<?php

namespace App\Http\Controllers;
use App\CongVan;
use App\Donvi;
use App\LinhVuc;
use Illuminate\Http\Request;

class LinhVucController extends Controller {
	//
	public function getDanhSach() {
		// Lấy lĩnh vực kèm theo tên đơn vị lĩnh vực
		$linhvuc = LinhVuc::with('donvilinhvuc')->get();
		$donvilinhvuc = Donvi::all(); // Lấy danh sách phòng ban
	
		return view('admin.danhmuc.linhvuc', [
			'linhvuc' => $linhvuc,
			'donvilinhvuc' => $donvilinhvuc
		]);
	}

	public function getThem() {
		$linhvuc = LinhVuc::all();
		$donvilinhvuc = Donvi::all(); // Lấy danh sách phòng ban
	
		return view('admin.danhmuc.linhvuc', [
			'linhvuc' => $linhvuc,
			'donvilinhvuc' => $donvilinhvuc
		]);
	}
	
	

	public function postThem(Request $request) {
		$this->validate($request, [
			'Ten' => 'required|unique:linhvuc,name|min:3|max:30',
			'iddonvilinhvuc' => 'required|exists:donvilinhvuc,id', // Kiểm tra tồn tại
		], [
			'Ten.required' => 'Bạn phải nhập tên lĩnh vực',
			'Ten.unique' => 'Tên lĩnh vực đã tồn tại',
			'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
			'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
			'iddonvilinhvuc.required' => 'Vui lòng chọn phòng ban',
			'iddonvilinhvuc.exists' => 'Phòng ban không tồn tại',
		]);
	
		$linhvuc = new LinhVuc;
		$linhvuc->name = $request->Ten;
		$linhvuc->iddonvilinhvuc = $request->iddonvilinhvuc; // Lưu ID phòng ban
		$linhvuc->save();
	
		return redirect('admin/danhmuc/linhvuc/them')->with('thongbao', 'Thêm thành công');
	}
	


//sửa
	
public function getSua($id) {
    $linhvuc_list = LinhVuc::all(); // Lấy danh sách lĩnh vực
    $linhvuc_edit = LinhVuc::findOrFail($id); // Lấy bản ghi cần sửa
    $donvilinhvuc = Donvi::all(); // Danh sách phòng ban

    return view('admin.danhmuc.linhvuc', [
        'linhvuc' => $linhvuc_list,
        'linhvuc_edit' => $linhvuc_edit,
        'donvilinhvuc' => $donvilinhvuc
    ]);
}

    // Xử lý sửa
    public function postSua(Request $request, $id) {
		$linhvuc = LinhVuc::findOrFail($id);
	
		$this->validate($request, [
			'Ten' => 'required|unique:linhvuc,name,' . $id . '|min:3|max:30',
			'iddonvilinhvuc' => 'required|exists:donvilinhvuc,id',
		], [
			'Ten.required' => 'Bạn phải nhập tên lĩnh vực',
			'Ten.unique' => 'Tên lĩnh vực đã tồn tại',
			'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
			'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
			'iddonvilinhvuc.required' => 'Vui lòng chọn phòng ban',
			'iddonvilinhvuc.exists' => 'Phòng ban không tồn tại',
		]);
	
		$linhvuc->name = $request->Ten;
		$linhvuc->iddonvilinhvuc = $request->iddonvilinhvuc; // Cập nhật phòng ban
		$linhvuc->save();
	
		return redirect('admin/danhmuc/linhvuc/sua/' . $id)->with('thongbao', 'Sửa thành công');
	}
	
	public function getXoa($id) {
		$linhvuc = LinhVuc::find($id);
		//kiểm tra khoá ngoại trước khi xoá
		$kiemtrakhoangoai = CongVan::where('idlinhvuc', $id)->get();
		$soluong = count($kiemtrakhoangoai);
		if ($soluong) {
			return redirect('admin/danhmuc/linhvuc')->with('loi', 'Không được phép xoá danh mục này vì đang có ' . $soluong . ' công văn đang sử dụng danh mục. Vui lòng tìm và xoá toàn bộ những công văn đó trước!');
		} else {
			$linhvuc->delete();
		}

		return redirect('admin/danhmuc/linhvuc')->with('thongbao', 'Xoá thành công');
	}
}
