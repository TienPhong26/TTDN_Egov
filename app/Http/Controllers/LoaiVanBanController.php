<?php

namespace App\Http\Controllers;
use App\CongVan;
use App\LoaiVanBan;
use Illuminate\Http\Request;

class LoaiVanBanController extends Controller {
	//
	public function getDanhSach() {
		$loaivanban = LoaiVanBan::all();
		return view('admin.danhmuc.loaivanban', ['loaivanban' => $loaivanban]);
	}

	public function getThem()
    {
        $loaivanban = Loaivanban::all();
        return view('admin.danhmuc.loaivanban', ['loaivanban' => $loaivanban]);
    }

    // Xử lý thêm mới
    public function postThem(Request $request)
    {
		$this->validate($request, [
			'Ten' => 'required|unique:loaivanban,name|min:3|max:30',
			'hinhthuc' => 'required|in:vanbandi,vanbanden,vanbannoibo,vanbankhac',  // Kiểm tra giá trị hợp lệ
		], [
			'Ten.required' => 'Bạn phải nhập tên độ khẩn',
			'Ten.unique' => 'Tên độ khẩn đã tồn tại',
			'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
			'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
			'hinhthuc.required' => 'Bạn phải chọn hình thức',
			'hinhthuc.in' => 'Hình thức không hợp lệ',  // Thông báo khi giá trị không hợp lệ
		]);
		

        $loaivanban = new Loaivanban;
		$loaivanban->name = $request->Ten;
		$loaivanban->hinhthuc = $request->hinhthuc;  // Lưu giá trị "hình thức"
		$loaivanban->save();


        return redirect('admin/danhmuc/loaivanban/them')->with('thongbao', 'Thêm thành công');
    }
	

	public function getSua($id)
    {
    $loaivanban_list = Loaivanban::all(); // Lấy toàn bộ danh sách để hiển thị bảng
    $loaivanban_edit = Loaivanban::find($id); // Bản ghi cần sửa

    return view('admin.danhmuc.loaivanban', [
        'loaivanban' => $loaivanban_list, // Cho bảng danh sách
        'loaivanban_edit' => $loaivanban_edit // Dữ liệu form sửa
    ]);
    }

    // Xử lý sửa
    public function postSua(Request $request, $id)
    {
        $loaivanban = Loaivanban::find($id);

        $this->validate($request, [
            'Ten' => 'required|unique:loaivanban,name,' . $id . '|min:3|max:30',
        ], [
            'Ten.required' => 'Bạn phải nhập tên đơn vị',
            'Ten.unique' => 'Tên độ khẩn đã tồn tại',
            'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
            'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        ]);

        $loaivanban->name = $request->Ten;
        $loaivanban->save();

        return redirect('admin/danhmuc/loaivanban/sua/' . $id)->with('thongbao', 'Sửa thành công');
    }


	
	public function getXoa($id)
    {
        $loaivanban = Loaivanban::find($id);

        // Kiểm tra khóa ngoại
        $kiemtrakhoangoai = CongVan::where('idloaivanban', $id)->count();

        if ($kiemtrakhoangoai > 0) {
            return redirect('admin/danhmuc/loaivanban')->with('loi', 'Không được phép xoá vì có ' . $kiemtrakhoangoai . ' công văn đang sử dụng.');
        }

        $loaivanban->delete();

        return redirect('admin/danhmuc/loaivanban')->with('thongbao', 'Xoá thành công');
    }
}

