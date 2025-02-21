<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donvi extends Model {
	//
	protected $table = 'donvilinhvuc';
	public $timestamps = false;
	public function congvan() {
		return $this->hasMany('App\CongVan', 'iddonvilinhvuc', 'id');
	}
}
