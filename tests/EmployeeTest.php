<?php
class EmployeeTest extends TestCase {

	/**
	 * Get All employees
	 **/
	public function testGetAllEmployees() {
		$user = \App\User::find(1);

		$this->actingAs($user)
			->post('/api/v1/employees', ['limit' => 10])
			->seeJsonEquals([
				'created' => true,
			]);
	}

	public function testGetEmployee() {
		$user = \App\User::find(1);

		$this->actingAs($user)
			->get('/api/v1/employee/aUaHZvxJ1')
			->seeJsonEquals([
				"employee" => [
					"contact_no" => "3434235",
					"created_by_user_id" => 1,
					"custom_id" => "aUaHZvxJ",
					"email" => "emp2@test.com",
					"first_name" => "em2",
					"last_name" => "sr2",
					"user" => [
						"created_at" => "2020-08-24T05:20:07.000000Z",
						"email" => "test1qa1947@gmail.com",
						"id" => 1,
						"name" => "test1qa",
						"updated_at" => "2020-08-24T05:20:07.000000Z"],
				],
				"success" => true,
			]);
	}

}