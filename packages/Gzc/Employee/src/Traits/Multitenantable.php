<?php
namespace Gzc\Employee\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Multitenantable {

	protected static function bootMultitenantable() {
		if (auth()->check()) {
			static::creating(function ($model) {
				$model->created_by_user_id = auth()->id();
			});

			static::addGlobalScope('created_by_user_id', function (Builder $builder) {
				$builder->where('created_by_user_id', auth()->id());
			});
		}
	}

}