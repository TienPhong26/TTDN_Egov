<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DonVi;

class LinhVuc extends Model {
	//
	protected $table = 'linhvuc';
	public $timestamps = false;
	public function congvan() {
		return $this->hasMany('App\CongVan', 'idlinhvuc', 'id');
	}

	public function donvilinhvuc()
    {
        return $this->belongsTo(Donvi::class, 'iddonvilinhvuc');
    }

}
