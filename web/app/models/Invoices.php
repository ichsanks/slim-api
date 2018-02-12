<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model {

	protected $table = 'invoices';

	public function jobs() {
        return $this->hasMany('App\Models\Jobs');
    }

}