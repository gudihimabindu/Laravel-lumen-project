<?php

namespace Gzc\Employee\Http;

use Exception;
use Gzc\Employee\Helper;
use Gzc\Employee\Models\Employee;
use Gzc\Employee\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use Storage;

class EmployeeController extends BaseController {

	/**
	 * The auth object for getting the current user
	 *
	 * @var \Gzc\Employee\Services;
	 */
	protected $employee_service;

	/**
	 * Construct the controller container
	 *
	 * @return void
	 */
	public function __construct() {
		$this->employeeService = new EmployeeService;
	}

	/**
	 * Get All employees
	 **/
	public function index(Request $request) {

		$this->validate($request, [
			'offset' => 'sometimes|numeric',
			'limit' => 'sometimes|numeric',
		]);

		$limit = 10;
		if ($request->has('limit')) {
			$limit = $request->limit;
		}
		$offset = 0;
		if ($request->has('offset')) {
			$offset = $request->offset;
		}

		$employees = Employee::where('created_by_user_id', Auth::id());

		$total = $employees->count();
		$employees = $employees->limit($limit)->offset($offset)->orderBy('created_at', 'desc')->get();

		return response()->json(['success' => true, 'employees' => $employees, 'total' => $total], 200);
	}

	/**
	 * Add new employee
	 **/
	public function store(Request $request) {
		$this->validate($request, [
			'first_name' => 'required|max:50',
			'last_name' => 'required|max:50',
			'email' => 'required|max:150|email|unique:employees,email',
		]);

		try {
			$custom_id = Helper::getUniqueString('employees');
			$request['custom_id'] = $custom_id;

			$create_employee = $this->employeeService->createEmployee($request->all());

			if ($create_employee) {
				return response()->json(['success' => true, 'employee' => $create_employee], 200);
			}
			return response()->json(['success' => false], 500);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['message' => $e->getMessage()], 405);
		}
	}

	/**
	 * Get employee data by custom id
	 **/
	public function show($custom_id) {
		$employee = $this->employeeService->find($custom_id);
		if ($employee) {
			return response()->json(['success' => true, 'employee' => $employee], 200);
		} else {
			return response()->json(['message' => __("Employee not found.")], 404);
		}
	}

	/**
	 * update employee data
	 **/
	public function update($custom_id, Request $request) {
		$employee = $this->employeeService->find($custom_id);

		if ($employee) {

			$this->validate($request, [
				'first_name' => 'required|max:50',
				'last_name' => 'required|max:50',
				'email' => 'required|max:150|email|unique:employees,email,' . $employee->id,
			]);

			$update_employee = $this->employeeService->editEmployee($employee->id, $request); // using service example

			if (!$update_employee) {
				return response()->json(['success' => false], 500);
			}
			return response()->json(['employee' => $update_employee, 'success' => true], 200);

		} else {
			return response()->json(['message' => __("Employee not found.")], 404);
		}

	}

	/**
	 *
	 * @param  int  $custom_id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $custom_id) {
		$employee = $this->employeeService->find($custom_id);
		try {
			$employee = $this->employeeService->deleteEmployee($custom_id);

			if ($employee) {
				return response()->json(['success' => true], 200);
			}
			return response()->json(['success' => false], 500);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['message' => $e->getMessage()], 405);
		}
	}

	/**
	 * update employee data
	 **/
	public function upload(Request $request) {

		$this->validate($request, [
			'csv_import' => 'required|mimes:csv,txt',
		]);
		if ($request->file('csv_import')) {

			$extension = $request->file('csv_import')->getClientOriginalExtension();
			$filename = uniqid() . '.' . $extension;
			$path = Storage::disk('local')->putFileAs('/public/employee', $request->file('csv_import'), $filename);
			$file_path = $path;

			ini_set("allow_url_fopen", 1);
			$data_array = [];
			$fileData = fopen(Storage::path($file_path), 'r');
			$cnt = 0;
			$already_employee_added = [];
			while (($line = fgetcsv($fileData)) !== FALSE) {
				$cnt++;
				if ($cnt > 1 && $line[2] != '') {
					// first check already employee created or not
					$employee = $this->employeeService->findByEmail($line[2]);

					if (!$employee) {
						$data_array = [];
						$custom_id = Helper::getUniqueString('employees');
						$data_array['custom_id'] = $custom_id;
						$data_array['first_name'] = $line[0];
						$data_array['last_name'] = $line[1];
						$data_array['email'] = $line[2];
						$data_array['contact_no'] = $line[3];

						// Add new employee
						$create_employee = $this->employeeService->createEmployee($data_array);
					} else {
						$already_employee_added[] = $line[2];
					}
				}
			}
			$message = '';
			if (!empty($already_employee_added)) {
				$message = implode(', ', $already_employee_added) . ' already available';
			}
			return response()->json(['success' => true, 'message' => $message], 200);
		}
		return response()->json(['success' => false], 404);
	}

	/**
	 *	Test method
	 **/
	public function test() {
		return Helper::hello() . ' from controller.';
	}
}