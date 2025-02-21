<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokhan extends Model {
	//
	protected $table = 'dokhan';
	public $timestamps = false;
	public function congvan() {
		return $this->hasMany('App\CongVan', 'iddokhan', 'id');
	}
}
