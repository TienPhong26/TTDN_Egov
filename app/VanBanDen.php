<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VanBanDen extends Model {
	//
	protected $table = 'vanbanden';
	public $timestamps = false;
	//Tạo liên kết cho bảng văn bản đến
	// public function coquanbanhanh() {
	// 	return $this->belongsTo('App\CoQuanBanHanh', 'idcoquanbanhanh', 'id');
	// }

	// public function hinhthucvanban() {
	// 	return $this->belongsTo('App\HinhThucVanBan', 'idhinhthucvanban', 'id');
	// }

	public function linhvuc() {
		return $this->belongsTo('App\LinhVuc', 'idlinhvuc', 'id');
	}

	public function loaivanban() {
		return $this->belongsTo('App\LoaiVanBan', 'idloaivanban', 'id');
	}

	// public function loaihinhcongvan() {
	// 	return $this->belongsTo('App\LoaiHinhCongVan', 'idloaihinhcongvan', 'id');
	// }
	public function dokhan() {
		return $this->belongsTo('App\Dokhan', 'iddokhan', 'id');
	}
	public function domat() {
		return $this->belongsTo('App\Domat', 'iddomat', 'id');
	}
	public function donvilinhvuc() {
		return $this->belongsTo('App\Donvi', 'iddonvilinhvuc', 'id');
	}

}
