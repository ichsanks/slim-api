<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model {

	protected $table = 'jobs';

	protected $fillable = [

	];

	public function invoice() {
        return $this->belongsTo('App\Models\Invoice');
	}
	
	public function payments() {
        return $this->belongsTo('App\Models\Payments');
    }

}