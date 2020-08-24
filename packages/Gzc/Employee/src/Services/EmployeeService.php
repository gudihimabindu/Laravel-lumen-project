<?php
namespace Gzc\Employee\Services;

use Gzc\Employee\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeService {

	public function find($custom_id) {
		$employee = Employee::has('user')->with('user')->where('custom_id', $custom_id)->first();
		if ($employee) {
			return $employee;
		}
		return false;
	}

	public function findByEmail($email) {

		$employee = Employee::has('user')->with('user')->where('email', $email)->first();
		if ($employee) {
			return $employee;
		}
		return false;
	}

	public function createEmployee($request) {
		DB::beginTransaction();

		if ($employee = Employee::create($request)) {
			DB::commit();
			return $employee;
		}
		return false;
	}

	public function editEmployee($id, $request) {
		DB::beginTransaction();
		$employee = Employee::find($id);
		$employee->first_name = $request->input('first_name');
		$employee->last_name = $request->input('last_name');
		$employee->email = $request->input('email');
		$employee->contact_no = $request->input('contact_no');
		if ($employee->save()) {
			DB::commit();
			return $employee;
		}
		return false;
	}

	public function deleteEmployee($custom_id) {
		$employee = $this->find($custom_id);
		DB::beginTransaction();
		if ($employee) {
			if ($employee->forceDelete()) {
				DB::commit();
				return true;
			}
		}
		return false;
	}
}