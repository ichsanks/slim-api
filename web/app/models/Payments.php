<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model {

	protected $table = 'payments';

	public function jobs() {
        return $this->hasMany('App\Models\Jobs');
    }

}