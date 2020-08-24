<?php
namespace Gzc\Employee\Models;

use Gzc\Employee\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

	use Multitenantable;

	protected $table = 'employees';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'custom_id', 'created_by_user_id', 'first_name', 'last_name', 'email', 'contact_no',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id', 'created_at', 'updated_at',
	];

	public function user() {
		return $this->belongsTo('App\User', 'created_by_user_id');
	}
}
