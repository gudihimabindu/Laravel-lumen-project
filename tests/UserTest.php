<?php
class UserTest extends TestCase {

	public function testAddUser() {

		$this->post('/api/v1/register', [
			"name" => "test3",
			"email" => "test4qa1947@gmail.com",
			"password" => "user@123",
			"password_confirmation" => "user@123"])
			->seeJsonEquals([
				'created' => true,
			]);
	}

	public function testGetUserProfile() {
		$user = \App\User::find(1);

		$this->actingAs($user)
			->get('/api/v1/profile')
			->seeJsonEquals([
				"success" => true,
			]);
	}

	public function testSendNotifications() {
		$this->get('/api/v1/sendnotifications')->seeJsonEquals(['success' => true]);
	}
}