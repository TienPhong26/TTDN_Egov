<?php

namespace App\Http\Controllers;

use App\CongVan;
use App\Dokhan;
use App\Domat;
use App\Donvi;
use Illuminate\Http\Request;

class DanhmucController extends Controller
{
    // Hiển thị danh sách độ khẩn
    public function getDanhSach()
    {
        $dokhan = Dokhan::all();
        return view('admin.danhmuc.dokhan', ['dokhan' => $dokhan]);
    }

    // Hiển thị form thêm mới
    public function getThem()
    {
        $dokhan = Dokhan::all();
        return view('admin.danhmuc.dokhan', ['dokhan' => $dokhan]);
    }

    // Xử lý thêm mới
    public function postThem(Request $request)
    {
        $this->validate($request, [
            'Ten' => 'required|unique:dokhan,name|min:3|max:30',
        ], [
            'Ten.required' => 'Bạn phải nhập tên độ khẩn',
            'Ten.unique' => 'Tên độ khẩn đã tồn tại',
            'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
            'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        ]);

        $dokhan = new Dokhan;
        $dokhan->name = $request->Ten;
        $dokhan->save();

        return redirect('admin/danhmuc/dokhan/them')->with('thongbao', 'Thêm thành công');
    }

    // Hiển thị form sửa
    public function getSua($id)
    {
    $dokhan_list = Dokhan::all(); // Lấy toàn bộ danh sách để hiển thị bảng
    $dokhan_edit = Dokhan::find($id); // Bản ghi cần sửa

    return view('admin.danhmuc.dokhan', [
        'dokhan' => $dokhan_list, // Cho bảng danh sách
        'dokhan_edit' => $dokhan_edit // Dữ liệu form sửa
    ]);
    }


    // Xử lý sửa
    public function postSua(Request $request, $id)
    {
        $dokhan = Dokhan::find($id);

        $this->validate($request, [
            'Ten' => 'required|unique:dokhan,name,' . $id . '|min:3|max:30',
        ], [
            'Ten.required' => 'Bạn phải nhập tên độ khẩn',
            'Ten.unique' => 'Tên độ khẩn đã tồn tại',
            'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
            'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        ]);

        $dokhan->name = $request->Ten;
        $dokhan->save();

        return redirect('admin/danhmuc/dokhan/sua/' . $id)->with('thongbao', 'Sửa thành công');
    }

    // Xử lý xóa
    public function getXoa($id)
    {
        $dokhan = Dokhan::find($id);

        // Kiểm tra khóa ngoại
        $kiemtrakhoangoai = CongVan::where('iddokhan', $id)->count();

        if ($kiemtrakhoangoai > 0) {
            return redirect('admin/danhmuc/dokhan')->with('loi', 'Không được phép xoá vì có ' . $kiemtrakhoangoai . ' công văn đang sử dụng.');
        }

        $dokhan->delete();

        return redirect('admin/danhmuc/dokhan')->with('thongbao', 'Xoá thành công');
    }


    // Hiển thị danh sách độ mật
    public function getDomat()
    {
        $domat = Domat::all();
        return view('admin.danhmuc.domat', ['domat' => $domat]);
    }

    // Hiển thị form thêm mới
    public function getThemDm()
    {
        $domat = Domat::all();
        return view('admin.danhmuc.domat', ['domat' => $domat]);
    }

    // Xử lý thêm mới
    public function postThemDm(Request $request)
    {
        $this->validate($request, [
            'Ten' => 'required|unique:domat,name|min:3|max:30',
        ], [
            'Ten.required' => 'Bạn phải nhập tên độ khẩn',
            'Ten.unique' => 'Tên độ khẩn đã tồn tại',
            'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
            'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        ]);

        $domat = new Domat;
        $domat->name = $request->Ten;
        $domat->save();

        return redirect('admin/danhmuc/domat/them')->with('thongbao', 'Thêm thành công');
    }

    // Hiển thị form sửa
    public function getSuaDm($id)
    {
    $domat_list = Domat::all(); // Lấy toàn bộ danh sách để hiển thị bảng
    $domat_edit = Domat::find($id); // Bản ghi cần sửa

    return view('admin.danhmuc.domat', [
        'domat' => $domat_list, // Cho bảng danh sách
        'domat_edit' => $domat_edit // Dữ liệu form sửa
    ]);
    }


    // Xử lý sửa
    public function postSuaDm(Request $request, $id)
    {
        $domat = Domat::find($id);

        $this->validate($request, [
            'Ten' => 'required|unique:domat,name,' . $id . '|min:3|max:30',
        ], [
            'Ten.required' => 'Bạn phải nhập tên độ mật',
            'Ten.unique' => 'Tên độ khẩn đã tồn tại',
            'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
            'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        ]);

        $domat->name = $request->Ten;
        $domat->save();

        return redirect('admin/danhmuc/domat/sua/' . $id)->with('thongbao', 'Sửa thành công');
    }

    // Xử lý xóa
    public function getXoaDm($id)
    {
        $domat = Domat::find($id);

        // Kiểm tra khóa ngoại
        $kiemtrakhoangoai = CongVan::where('iddomat', $id)->count();

        if ($kiemtrakhoangoai > 0) {
            return redirect('admin/danhmuc/domat')->with('loi', 'Không được phép xoá vì có ' . $kiemtrakhoangoai . ' công văn đang sử dụng.');
        }

        $domat->delete();

        return redirect('admin/danhmuc/domat')->with('thongbao', 'Xoá thành công');
    }

    // Hiển thị danh sách người ký
    public function getDonvi()
    {
        $donvilinhvuc = Donvi::all();
        return view('admin.danhmuc.donvi', ['donvilinhvuc' => $donvilinhvuc]);
    }

    // Hiển thị form thêm mới
    public function getThemDonvi()
    {
        $donvilinhvuc = Donvi::all();
        return view('admin.danhmuc.donvi', ['donvilinhvuc' => $donvilinhvuc]);
    }

    // Xử lý thêm mới
    public function postThemDonvi(Request $request)
    {
        $this->validate($request, [
            'Ten' => 'required|unique:donvilinhvuc,name|min:3|max:30',
        ], [
            'Ten.required' => 'Bạn phải nhập tên độ khẩn',
            'Ten.unique' => 'Tên độ khẩn đã tồn tại',
            'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
            'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        ]);

        $donvilinhvuc = new Donvi;
        $donvilinhvuc->name = $request->Ten;
        $donvilinhvuc->save();

        return redirect('admin/danhmuc/donvi/them')->with('thongbao', 'Thêm thành công');
    }

    // Hiển thị form sửa
    public function getSuaDonvi($id)
    {
    $donvilinhvuc_list = Donvi::all(); // Lấy toàn bộ danh sách để hiển thị bảng
    $donvilinhvuc_edit = Donvi::find($id); // Bản ghi cần sửa

    return view('admin.danhmuc.donvi', [
        'donvilinhvuc' => $donvilinhvuc_list, // Cho bảng danh sách
        'donvilinhvuc_edit' => $donvilinhvuc_edit // Dữ liệu form sửa
    ]);
    }

    // Xử lý sửa
    public function postSuaDonvi(Request $request, $id)
    {
        $donvilinhvuc = Donvi::find($id);

        $this->validate($request, [
            'Ten' => 'required|unique:donvilinhvuc,name,' . $id . '|min:3|max:30',
        ], [
            'Ten.required' => 'Bạn phải nhập tên đơn vị',
            'Ten.unique' => 'Tên độ khẩn đã tồn tại',
            'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
            'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        ]);

        $donvilinhvuc->name = $request->Ten;
        $donvilinhvuc->save();

        return redirect('admin/danhmuc/donvi/sua/' . $id)->with('thongbao', 'Sửa thành công');
    }

    // Xử lý xóa
    public function getXoaDonvi($id)
    {
        $donvilinhvuc = Donvi::find($id);

        // Kiểm tra khóa ngoại
        $kiemtrakhoangoai = CongVan::where('iddonvilinhvuc', $id)->count();

        if ($kiemtrakhoangoai > 0) {
            return redirect('admin/danhmuc/donvi')->with('loi', 'Không được phép xoá vì có ' . $kiemtrakhoangoai . ' công văn đang sử dụng.');
        }

        $donvilinhvuc->delete();

        return redirect('admin/danhmuc/donvi')->with('thongbao', 'Xoá thành công');
    }
        // // Hiển thị danh sách người ký
        // public function getNguoiky()
        // {
        //     $donvilinhvuc = Donvi::all();
        //     return view('admin.danhmuc.donvi', ['donvilinhvuc' => $donvilinhvuc]);
        // }
    
        // // Hiển thị form thêm mới
        // public function getThemDonvi()
        // {
        //     $donvilinhvuc = Donvi::all();
        //     return view('admin.danhmuc.donvi', ['donvilinhvuc' => $donvilinhvuc]);
        // }
    
        // // Xử lý thêm mới
        // public function postThemDonvi(Request $request)
        // {
        //     $this->validate($request, [
        //         'Ten' => 'required|unique:donvilinhvuc,name|min:3|max:30',
        //     ], [
        //         'Ten.required' => 'Bạn phải nhập tên độ khẩn',
        //         'Ten.unique' => 'Tên độ khẩn đã tồn tại',
        //         'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
        //         'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        //     ]);
    
        //     $donvilinhvuc = new Donvi;
        //     $donvilinhvuc->name = $request->Ten;
        //     $donvilinhvuc->save();
    
        //     return redirect('admin/danhmuc/donvi/them')->with('thongbao', 'Thêm thành công');
        // }
    
        // // Hiển thị form sửa
        // public function getSuaDonvi($id)
        // {
        // $donvilinhvuc_list = Donvi::all(); // Lấy toàn bộ danh sách để hiển thị bảng
        // $donvilinhvuc_edit = Donvi::find($id); // Bản ghi cần sửa
    
        // return view('admin.danhmuc.donvi', [
        //     'donvilinhvuc' => $donvilinhvuc_list, // Cho bảng danh sách
        //     'donvilinhvuc_edit' => $donvilinhvuc_edit // Dữ liệu form sửa
        // ]);
        // }
    
        // // Xử lý sửa
        // public function postSuaDonvi(Request $request, $id)
        // {
        //     $donvilinhvuc = Donvi::find($id);
    
        //     $this->validate($request, [
        //         'Ten' => 'required|unique:donvilinhvuc,name,' . $id . '|min:3|max:30',
        //     ], [
        //         'Ten.required' => 'Bạn phải nhập tên đơn vị',
        //         'Ten.unique' => 'Tên độ khẩn đã tồn tại',
        //         'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
        //         'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        //     ]);
    
        //     $donvilinhvuc->name = $request->Ten;
        //     $donvilinhvuc->save();
    
        //     return redirect('admin/danhmuc/donvi/sua/' . $id)->with('thongbao', 'Sửa thành công');
        // }
    
        // // Xử lý xóa
        // public function getXoaDonvi($id)
        // {
        //     $donvilinhvuc = Donvi::find($id);
    
        //     // Kiểm tra khóa ngoại
        //     $kiemtrakhoangoai = CongVan::where('iddonvilinhvuc', $id)->count();
    
        //     if ($kiemtrakhoangoai > 0) {
        //         return redirect('admin/danhmuc/donvi')->with('loi', 'Không được phép xoá vì có ' . $kiemtrakhoangoai . ' công văn đang sử dụng.');
        //     }
    
        //     $donvilinhvuc->delete();
    
        //     return redirect('admin/danhmuc/donvi')->with('thongbao', 'Xoá thành công');
        // }
}
