<?php
namespace App\Http\Controllers;

use App\Jobs\ExampleJob;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
	/**
	 * Instantiate a new UserController instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//$this->middleware('auth');
	}

	/**
	 * Get the authenticated User.
	 *
	 * @return Response
	 */
	public function profile() {
		return response()->json(['user' => Auth::user()], 200);
	}

	/**
	 * Get all User.
	 *
	 * @return Response
	 */
	public function allUsers() {
		return response()->json(['users' => User::all()], 200);
	}

	/**
	 * Get one user.
	 *
	 * @return Response
	 */
	public function singleUser($id) {
		try {
			$user = User::findOrFail($id);

			return response()->json(['user' => $user], 200);

		} catch (\Exception $e) {

			return response()->json(['message' => 'user not found!'], 404);
		}

	}

	/**
	 * Send Notifications
	 **/
	public function sendNotification() {
		$users = User::all();
		foreach ($users as $user) {
			$data = ['message' => 'Test Notification'];
			dispatch(new ExampleJob($user, $data));
		}
		return response()->json(['success' => true], 200);
	}

}
