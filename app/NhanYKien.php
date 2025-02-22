<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhanYKien extends Model {
	//
	protected $table = 'nhan_ykien';
	public $timestamps = false;
	public function ykien() {
		return $this->hasMany('App\NhanYKien', 'id_nguoinhan', 'id');
	}
}
