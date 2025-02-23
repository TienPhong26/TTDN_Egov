<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giaoxuly extends Model {
	//
	protected $table = 'giaoxuly';
	public $timestamps = false;
	// public function congvan() {
	// 	return $this->hasMany('App\CongVan', 'iddomat', 'id');
	// }
    public function vanbanden() {
		return $this->belongsTo('App\VanBanDen', 'id_sohieu', 'id');
	}
}
