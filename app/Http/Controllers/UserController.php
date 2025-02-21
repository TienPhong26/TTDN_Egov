<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CongVan;

class UserController extends Controller {
	//

	
	public function getDanhSach()
{
    $user = User::whereIn('role', ['officer', 'sofficer'])->get();  // Lọc theo role 'officer' hoặc 'sofficer'
    return view('admin.danhmuc.nguoiky', ['user' => $user]);
}

	public function getThem()
    {
        $user = User::all();
        return view('admin.danhmuc.nguoiky', ['user' => $user]);
    }

    // Xử lý thêm mới
	public function postThem(Request $request)
	{
		$this->validate($request, [
			'Ten' => 'required|unique:users,name|min:3|max:30',
		], [
			'Ten.required' => 'Bạn phải nhập tên người ký',
			'Ten.unique' => 'Tên người ký đã tồn tại',
			'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
			'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
		]);
	
		// Tạo mới người dùng và gán giá trị 'role' là 'officer'
		$user = new User;
		$user->name = $request->Ten;
		  // Gán role mặc định là 'officer'
		$user->email = '';    
		    // Email rỗng hoặc bạn có thể bỏ qua nếu không cần
		$user->level = '1';        // Level rỗng hoặc bạn có thể bỏ qua nếu không cần
		$user->password = bcrypt('123456'); // Mã hóa mật khẩu mặc định là '123456'
		$user->remember_token = ''; 
		$user->role = 'officer';// Nếu không cần nhớ token, có thể để rỗng hoặc bỏ qua
		$user->save();

			
		return redirect('admin/danhmuc/nguoiky/them')->with('thongbao', 'Thêm thành công');
	}
	

	public function getSua($id)
    {
    $user_list = User::all(); // Lấy toàn bộ danh sách để hiển thị bảng
    $user_edit = User::find($id); // Bản ghi cần sửa

    return view('admin.danhmuc.nguoiky', [
        'user' => $user_list, // Cho bảng danh sách
        'user_edit' => $user_edit // Dữ liệu form sửa
    ]);
    }

    // Xử lý sửa
    public function postSua(Request $request, $id)
    {
        $user = User::find($id);

        $this->validate($request, [
            'Ten' => 'required|unique:users,name,' . $id . '|min:3|max:30',
        ], [
            'Ten.required' => 'Bạn phải nhập tên đơn vị',
            'Ten.unique' => 'Tên độ khẩn đã tồn tại',
            'Ten.min' => 'Tên phải từ 3 đến 30 ký tự',
            'Ten.max' => 'Tên phải từ 3 đến 30 ký tự',
        ]);

        $user->name = $request->Ten;
        $user->save();

        return redirect('admin/danhmuc/nguoiky/sua/' . $id)->with('thongbao', 'Sửa thành công');
    }


	public function getXoa($id)
    {
        $user = User::find($id);

        // Kiểm tra khóa ngoại
        $kiemtrakhoangoai = CongVan::where('idloaivanban', $id)->count();

        if ($kiemtrakhoangoai > 0) {
            return redirect('admin/danhmuc/nguoiky')->with('loi', 'Không được phép xoá vì có ' . $kiemtrakhoangoai . ' công văn đang sử dụng.');
        }

        $user->delete();

        return redirect('admin/danhmuc/nguoiky')->with('thongbao', 'Xoá thành công');
    }
	public function getDangnhapAdmin() {
		return view('admin.login');
	}

	public function postDangnhapAdmin(Request $request) {
		$this->validate($request,
			[
				'email' => 'required',
				'password' => 'required|min:6|max:20',
			],
			[
				'email.required' => 'Bạn phải nhập email',
				'password.required' => 'Bạn phải nhập mật khẩu',
				'password.min' => 'Bạn phải nhập mật khẩu lớn hơn, từ 6 đến 20 ký tự',
				'password.max' => 'Bạn phải nhập mật khẩu nhỏ hơn, từ 6 đến 20 ký tự',
			]

		);

		if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
			return redirect('admin/congvan/danhsach');
		} else {
			return redirect('admin/dangnhap')->with('loi', 'Đăng nhập không thành công, mời nhập lại!');
		}
	}

	public function getDangxuat() {
		Auth::logout();
		return redirect('admin/dangnhap')->with('thongbao', 'Đăng xuất thành công');
	}
}
