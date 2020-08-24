<?php

namespace App\Jobs;
use Illuminate\Support\Facades\Log;

class ExampleJob extends Job {
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public $user;
	public $payload;

	public function __construct($user, $payload) {
		$this->user = $user;
		$this->payload = $payload;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		Log::info('Showing user profile for user: ' . $this->user->id);
	}
}
