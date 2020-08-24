<?php

namespace Gzc\Employee;

use Illuminate\Support\Facades\Facade;

class EmployeeFacade extends Facade {
	protected static function getFacadeAccessor() {
		return 'gzc-employee';
	}
}
