<?php

Route::get('employee/test', function () {
	return 'Test';
});

Route::get('employee/hello', 'Gzc\Employee\Http\EmployeeController@test');

// Matches "/api/v1/*"
Route::group(['namespace' => 'Gzc\Employee\Http', 'prefix' => 'api/v1', 'middleware' => 'auth'], function () {
	// Get All employees for specific user
	Route::post('employees', 'EmployeeController@index');

	// Add new employee
	Route::post('add/employee', 'EmployeeController@store');

	// Get employee data
	Route::get('employee/{custom_id}', 'EmployeeController@show');

	// Update employee
	Route::put('employee/{custom_id}', 'EmployeeController@update');

	// delete employee
	Route::delete('employee/{custom_id}', 'EmployeeController@destroy');

	// Upload employees
	Route::post('employees/upload', 'EmployeeController@upload');
});
