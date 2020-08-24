<?php

namespace Gzc\Employee;

use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider {

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
	}

	public function boot() {
		require __DIR__ . '/routes.php';
	}
}
