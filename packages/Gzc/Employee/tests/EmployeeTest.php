<?php

class EmployeeTest extends TestCase {

	public function testSomethingIsTrue() {
		$this->assertTrue(true);
		$this->visit('/')->see('Laravel Lumen');
	}
}