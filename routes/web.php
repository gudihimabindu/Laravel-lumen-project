<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->get('/', function () use ($router) {
	//return $router->app->version();
	return "Hello Lumen";
});

// use this route for generate application key
$router->get('/key', function () {
	return \Illuminate\Support\Str::random(32);
});

// API route group
$router->group(['prefix' => 'api/v1'], function () use ($router) {
	// Matches "/api/v1/register
	$router->post('register', 'AuthController@register');

	// Matches "/api/v1/login
	$router->post('login', 'AuthController@login');

	$router->get('sendnotifications', 'UserController@sendNotification');
});

$router->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () use ($router) {
	// Matches "/api/v1/profile
	$router->get('profile', 'UserController@profile');

	// Matches "/api/v1/users/1
	//get one user by id
	$router->get('users/{id}', 'UserController@singleUser');

	// Matches "/api/v1/users
	$router->get('users', 'UserController@allUsers');
});
