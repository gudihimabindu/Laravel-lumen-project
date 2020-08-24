<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employees', function (Blueprint $table) {
			$table->id();
			$table->string('custom_id')->nullable();
			$table->bigInteger('created_by_user_id')->unsigned();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique()->notNullable();
			$table->string('contact_no')->nullable();
			$table->timestamps();

			$table->foreign('created_by_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('employees');
	}
}
