<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domat extends Model {
	//
	protected $table = 'domat';
	public $timestamps = false;
	public function congvan() {
		return $this->hasMany('App\CongVan', 'iddomat', 'id');
	}
}
