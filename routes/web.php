<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'PagesController@trangchu');
Route::get('dangnhap', 'PagesController@getDangnhap');
Route::post('dangnhap', 'PagesController@postDangnhap');
Route::get('dangxuat', 'PagesController@getDangxuat');

//tìm kiếm
Route::get('timkiem', 'PagesController@getTimkiem');

//giới thiệu và liên hệ
Route::get('gioithieu', 'PagesController@getGioithieu');
Route::get('lienhe', 'PagesController@getLienHe');

//chi tiết công văn
Route::get('chitiet/{id}', 'PagesController@getChiTiet');

//route login and logout
Route::get('admin', 'UserController@getDangnhapAdmin');
Route::get('admin/dangnhap', 'UserController@getDangnhapAdmin');
Route::post('admin/dangnhap', 'UserController@postDangnhapAdmin');

Route::get('admin/dangxuat', 'UserController@getDangxuat');

//route admin
Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function () {
	Route::group(['prefix' => 'coquanbanhanh'], function () {
		Route::get('danhsach', 'CoQuanBanHanhController@getDanhSach');

		Route::get('sua/{id}', 'CoQuanBanHanhController@getSua');
		Route::post('sua/{id}', 'CoQuanBanHanhController@postSua');

		Route::get('them', 'CoQuanBanHanhController@getThem');
		Route::post('them', 'CoQuanBanHanhController@postThem');

		Route::get('xoa/{id}', 'CoQuanBanHanhController@getXoa');
	});

	Route::group(['prefix' => 'hinhthucvanban'], function () {
		Route::get('danhsach', 'HinhThucVanBanController@getDanhSach');

		Route::get('sua/{id}', 'HinhThucVanBanController@getSua');
		Route::post('sua/{id}', 'HinhThucVanBanController@postSua');

		Route::get('them', 'HinhThucVanBanController@getThem');
		Route::post('them', 'HinhThucVanBanController@postThem');

		Route::get('xoa/{id}', 'HinhThucVanBanController@getXoa');
	});

	Route::group(['prefix' => 'danhmuc'], function () {
		Route::get('dokhan', 'DanhmucController@getDanhSach');

		Route::get('dokhan/sua/{id}', 'DanhmucController@getSua');
		Route::post('dokhan/sua/{id}', 'DanhmucController@postSua');

		Route::get('dokhan/them', 'DanhmucController@getThem');
		Route::post('dokhan/them', 'DanhmucController@postThem');

		Route::get('dokhan/xoa/{id}', 'DanhmucController@getXoa');
		//độ mật
		Route::get('domat', 'DanhmucController@getDomat');

		Route::get('domat/sua/{id}', 'DanhmucController@getSuaDm');
		Route::post('domat/sua/{id}', 'DanhmucController@postSuaDm');

		Route::get('domat/them', 'DanhmucController@getThemDm');
		Route::post('domat/them', 'DanhmucController@postThemDm');

		Route::get('domat/xoa/{id}', 'DanhmucController@getXoaDm');
		//đơn vị lĩnh vực
		Route::get('donvi', 'DanhmucController@getDonvi');

		Route::get('donvi/sua/{id}', 'DanhmucController@getSuaDonvi');
		Route::post('donvi/sua/{id}', 'DanhmucController@postSuaDonvi');

		Route::get('donvi/them', 'DanhmucController@getThemDonvi');
		Route::post('donvi/them', 'DanhmucController@postThemDonvi');

		Route::get('donvi/xoa/{id}', 'DanhmucController@getXoaDonvi');


		
	});

	Route::group(['prefix' => 'danhmuc'], function () {
		Route::get('linhvuc', 'LinhVucController@getDanhSach');

		Route::get('linhvuc/sua/{id}', 'LinhVucController@getSua');
		Route::post('linhvuc/sua/{id}', 'LinhVucController@postSua');

		Route::get('linhvuc/them', 'LinhVucController@getThem');
		Route::post('linhvuc/them', 'LinhVucController@postThem');

		Route::get('linhvuc/xoa/{id}', 'LinhVucController@getXoa');
	});

	Route::group(['prefix' => 'danhmuc'], function () {
		Route::get('loaivanban', 'LoaiVanBanController@getDanhSach');

		Route::get('loaivanban/sua/{id}', 'LoaiVanBanController@getSua');
		Route::post('loaivanban/sua/{id}', 'LoaiVanBanController@postSua');

		Route::get('loaivanban/them', 'LoaiVanBanController@getThem');
		Route::post('loaivanban/them', 'LoaiVanBanController@postThem');

		Route::get('loaivanban/xoa/{id}', 'LoaiVanBanController@getXoa');
	});

	Route::group(['prefix' => 'loaihinhcongvan'], function () {
		Route::get('danhsach', 'LoaiHinhCongVanController@getDanhSach');

		Route::get('sua/{id}', 'LoaiHinhCongVanController@getSua');
		Route::post('sua/{id}', 'LoaiHinhCongVanController@postSua');

		Route::get('them', 'LoaiHinhCongVanController@getThem');
		Route::post('them', 'LoaiHinhCongVanController@postThem');

		Route::get('xoa/{id}', 'LoaiHinhCongVanController@getXoa');
	});

	Route::group(['prefix' => 'vanbanden'], function () {
		Route::get('chuyen', 'VanBanDenController@getDanhSachChuyen');

		Route::get('sua/{id}', 'VanBanDenController@getSua');
		Route::post('sua/{id}', 'VanBanDenController@postSua');

		Route::get('pheduyet/{id}', 'VanBanDenController@getPheDuyet')->name('admin.vanbanden.pheduyet');
		//Route::get('/vanbanden/pheduyet/{id}', 'VanBanDenController@showPheDuyetForm')->name('vanbanden.showPheDuyetForm');
		Route::post('pheduyet/{id}', 'VanBanDenController@postPheDuyet');

		Route::get('vaosoden', 'VanBanDenController@getThem');
		Route::post('vaosoden', 'VanBanDenController@postThem');

		Route::get('chuyen/xoa/{id}', 'VanBanDenController@getXoa');

		Route::get('butphe', 'VanBanDenController@getDanhSachButPhe');

		Route::get('pheduyetvanban/{id}', 'VanBanDenController@getPheDuyetVanBan')->name('admin.vanbanden.pheduyetvanban');

		Route::post('pheduyetvanban/{id}', 'VanBanDenController@postPheDuyetVanBan');

		Route::post('butphe', 'VanBanDenController@postHoanThanh');

		
		Route::get('giaoxuly/{id}', 'VanBanDenController@getXuly')->name('admin.vanbanden.giaoxuly');
		Route::post('giaoxuly/{id}', 'VanBanDenController@postXuly');

		Route::get('hoanthanh', 'VanBanDenController@getHoanThanh');
	});
	//Route::post('/vanbanden/pheduyet/{id}', [VanBanDenController::class, 'pheDuyet'])->name('vanbanden.pheduyet');
	//Route::post('/vanbanden/pheduyet/{id}', 'VanBanDenController@pheDuyet')->name('vanbanden.pheduyet');

	Route::group(['prefix' => 'vanbandi'], function () {
		Route::get('vaosodi', 'VanBanDiController@getThem');
		Route::post('vaosodi', 'VanBanDiController@postThem');

		Route::get('danhsach', 'VanBanDiController@getDanhSach');

		// Route::get('sua/{id}', 'CongVanController@getSua');
		// Route::post('sua/{id}', 'CongVanController@postSua');

		// Route::get('them', 'CongVanController@getThem');
		// Route::post('them', 'CongVanController@postThem');

		// Route::get('xoa/{id}', 'CongVanController@getXoa');
	});

	Route::group(['prefix' => 'congvan'], function () {
		Route::get('danhsach', 'CongVanController@getDanhSach');

		Route::get('sua/{id}', 'CongVanController@getSua');
		Route::post('sua/{id}', 'CongVanController@postSua');

		Route::get('them', 'CongVanController@getThem');
		Route::post('them', 'CongVanController@postThem');

		Route::get('xoa/{id}', 'CongVanController@getXoa');
	});

	Route::group(['prefix' => 'danhmuc'], function () {
		Route::get('nguoiky', 'UserController@getDanhSach');

		Route::get('nguoiky/sua/{id}', 'UserController@getSua');
		Route::post('nguoiky/sua/{id}', 'UserController@postSua');

		Route::get('nguoiky/them', 'UserController@getThem');
		Route::post('nguoiky/them', 'UserController@postThem');

		Route::get('nguoiky/xoa/{id}', 'UserController@getXoa');
	});

	Route::group(['prefix' => 'slide'], function () {
		Route::get('danhsach', 'SlideController@getDanhSach');

		Route::get('sua/{id}', 'SlideController@getSua');
		Route::post('sua/{id}', 'SlideController@postSua');

		Route::get('them', 'SlideController@getThem');
		Route::post('them', 'SlideController@postThem');

		Route::get('xoa/{id}', 'SlideController@getXoa');
	});
});

Route::get('trangchu', 'PagesController@trangchu');

Route::get('coquanbanhanh/{id}/{TenKhongDau}.html', 'PagesController@coquanbanhanh');

Route::get('hinhthucvanban/{id}/{TenKhongDau}.html', 'PagesController@hinhthucvanban');

Route::get('linhvuc/{id}/{TenKhongDau}.html', 'PagesController@linhvuc');

Route::get('loaivanban/{id}/{TenKhongDau}.html', 'PagesController@loaivanban');

Route::get('loaihinhcongvan/{id}/{TenKhongDau}.html', 'PagesController@loaihinhcongvan');