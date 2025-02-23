<?php

namespace App\Http\Controllers;
use App\VanBanDen;
use App\LinhVuc;
use App\LoaiVanBan;
use App\Dokhan;
use App\Donvi;
use App\Giaoxuly;
use App\User;
use App\Domat;
use App\NhanYKien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VanBanDenController extends Controller {
	//
	public function getDanhSach() {
		$vanbanden = VanBanDen::all();
		// foreach ($vanbanden as $key => $value) {
		// 	echo "<br>Key:" . $key;
		// 	echo "<hr>";
		// 	echo "id:" . $value->id;
		// 	echo "<hr>";
		// 	$ten = $value->coquanbanhanh->name;
		// 	echo "<b>Value: $ten</b>";
		// }
		return view('admin.vanbanden.danhsach', ['vanbanden' => $vanbanden]);
	}
    public function getDanhSachChuyen() {
        // Lấy tất cả các bản ghi có cột action là 'pending'
        $vanbanden = VanBanDen::where('action', 'pending')->get();
    
        return view('admin.vanbanden.chuyen', ['vanbanden' => $vanbanden]);
    }
    
	public function getThem() {
        $loaivanban = LoaiVanBan::all();
        $linhvuc = LinhVuc::all();
        $domat = DoMat::all();
        $dokhan = DoKhan::all();

        return view('admin.vanbanden.vaosoden', compact('loaivanban', 'linhvuc', 'domat', 'dokhan'));
    }

    public function postThem(Request $request) {
        $this->validate($request, [
            'sohieu' => 'required|min:3|max:15',
            'trichyeu' => 'required|min:10|max:255',
            'FileVanBan' => 'nullable|mimes:pdf|max:2048',
        ], [
            'sohieu.required' => 'Bạn phải nhập số hiệu',
            'trichyeu.required' => 'Bạn phải nhập trích yếu nội dung',
            'FileVanBan.mimes' => 'Chỉ được tải lên file PDF',
            'FileVanBan.max' => 'Dung lượng file tối đa là 2MB',
        ]);
    
        $vanban = new VanBanDen();
        $vanban->so_hieu = $request->sohieu;
        $vanban->so_cong_van_den = $request->socongvan;
        $vanban->ngay_den = $request->ngayden;
        $vanban->don_vi_gui = $request->donvigui;
        $vanban->trich_yeu = $request->trichyeu;
        $vanban->id_loai_van_ban = $request->LoaiVanBan ? intval($request->LoaiVanBan) : null;
        $vanban->id_linh_vuc = $request->LinhVuc ? intval($request->LinhVuc) : null;
        $vanban->id_do_mat = $request->DoMat ? intval($request->DoMat) : null;
        $vanban->id_do_khan = $request->DoKhan ? intval($request->DoKhan) : null;
        $vanban->ngay_van_ban = $request->NgayVanBan;
        $vanban->nguoi_ky = $request->NguoiKy;
        $vanban->thoi_han_hoan_thanh = $request->ThoiHanHoanThanh ?? null;
        $vanban->ghi_chu = $request->GhiChu ?? null;
        $vanban->action = 'pending';

    
        // if ($request->hasFile('FileVanBan')) {
        //     $file = $request->file('FileVanBan');
        //     $filename = time() . '_' . $file->getClientOriginalName();
            
        //     // Lưu vào thư mục public/upload
        //    // Storage::putFileAs('public/upload', $file, $filename);
        //    $file->move(public_path('upload'), $filename);

        //     // Lưu đường dẫn vào database (đảm bảo đúng format URL khi truy cập tệp)
        //     $vanban->ten_tep =  $filename;
        // }
        if ($request->hasFile('FileVanBan')) {
            $file = $request->file('FileVanBan');
            $filename = time() . '_' . $file->getClientOriginalName();
        
            // Lưu trực tiếp vào public/upload
            $file->move(public_path('upload'), $filename);
        
            // Lưu đường dẫn vào DB nếu cần
            $vanban->ten_tep = 'upload/' . $filename;
        }
        
        
        $vanban->save();
    
        return redirect('admin/vanbanden/vaosoden')->with('thongbao', 'Thêm văn bản đến thành công!');
    }
	public function getSua($id) {
		$vanbanden = VanBanDen::find($id);
	//	$coquanbanhanh = CoQuanBanHanh::all();
	//	$hinhthucvanban = HinhThucVanBan::all();
	//	$linhvuc = LinhVuc::all();
	//	$loaihinhvanbanden = LoaiHinhVanBanDen::all();
		$loaivanban = LoaiVanBan::all();
		return view('admin.vanbanden.sua', ['vanbanden' => $vanbanden]);
	}

	public function postSua(Request $request, $id) {
		$vanbanden = VanBanDen::find($id);
		$this->validate($request,
			[
				'sohieu' => 'required|min:3|max:15',

				'trichyeu' => 'required|min:10|max:100',

			],
			[
				'sohieu.required' => 'Bạn phải nhập số hiệu',
				'sohieu.min' => 'Bạn phải nhập số hiệu lớn từ 3 đến 15 ký tự',
				'sohieu.max' => 'Bạn phải nhập số hiệu lớn từ 3 đến 15 ký tự',

				'trichyeu.required' => 'Bạn phải nhập trích yếu nội dung',
				'trichyeu.min' => 'Bạn phải nhập trích yếu nội dung lớn từ 20 đến 100 ký tự',
				'trichyeu.max' => 'Bạn phải nhập trích yếu nội dung lớn từ 20 đến 100 ký tự',

			]);

		$vanbanden->so_hieu = $request->sohieu;
		$vanbanden->trich_yeu = $request->trichyeu;
		//$vanbanden->nguoi_ky = $request->nguoiky;

		//$vanbanden->idcoquanbanhanh = intval($request->CoQuanBanHanh);
		//$vanbanden->idhinhthucvanban = intval($request->HinhThucVanBan);
		//$vanbanden->idlinhvuc = intval($request->LinhVuc);
		//$vanbanden->idloaihinhvanbanden = intval($request->LoaiHinhVanBanDen);
		//$vanbanden->idloaivanban = intval($request->LoaiVanBan);

		$vanbanden->ngay_den = $request->ngayden;
	//	$vanbanden->ngayky = $request->ngayky;
	//	$vanbanden->ngayhieuluc = $request->ngayhieuluc;
	//	$vanbanden->ngaychuyen = $request->ngaychuyen;
	//	$vanbanden->conhieuluc = $request->conhieuluc;

		

	//	$vanbanden->TenKhongDau = changeTitle($request->trichyeunoidung);

		$vanbanden->save();

		return redirect('admin/vanbanden/sua/' . $id)->with('thongbao', 'Sửa thành công');

	}

	public function getXoa($id) {
		$vanbanden = VanBanDen::find($id);
		$vanbanden->delete();

		return redirect('admin/vanbanden/chuyen')->with('thongbao', 'Xoá thành công');
	}

    public function getPheDuyet($id) {
		$vanbanden = VanBanDen::find($id);
	//	$coquanbanhanh = CoQuanBanHanh::all();
	//	$hinhthucvanban = HinhThucVanBan::all();
	//	$linhvuc = LinhVuc::all();
	//	$loaihinhvanbanden = LoaiHinhVanBanDen::all();
		$loaivanban = LoaiVanBan::all();
        $nguoinhan = User::where('role', 'officer')->get();
		return view('admin.vanbanden.pheduyet', ['vanbanden' => $vanbanden, 'nguoinhan' => $nguoinhan]);
    }

    public function postPheDuyet(Request $request, $id) {
        $vanbanden = VanBanDen::find($id);

        if (!$vanbanden) {
            return redirect()->back()->with('error', 'Văn bản không tồn tại');
        }
        
        $vanbanden->action = 'approved';
        $vanbanden->id_nguoinhan = $request->nguoinhan;
        $vanbanden->save();
        
        $nguoinhan = User::find($request->nguoinhan); // Tìm người nhận đúng
        if (!$nguoinhan) {
            return redirect()->back()->with('error', 'Người nhận không tồn tại');
        }
        
        $nguoinhan->cong_viec = 'xử lý';
        $nguoinhan->save();
        
        return redirect('admin/vanbanden/chuyen')->with('thongbao', 'Phê duyệt thành công');
        
    }

    //bút phê văn bản
    public function getDanhSachButPhe() {
        // Lấy tất cả các bản ghi có cột action là 'pending'
        
        $vanbanden = VanBanDen::where('action', 'approved')->get();
        return view('admin.vanbanden.butphe', ['vanbanden' => $vanbanden]);
    }
    public function getPheDuyetVanBan($id) {
		$vanbanden = VanBanDen::find($id);
	//	$coquanbanhanh = CoQuanBanHanh::all();
	//	$hinhthucvanban = HinhThucVanBan::all();
	//	$linhvuc = LinhVuc::all();
	//	$loaihinhvanbanden = LoaiHinhVanBanDen::all();
		$loaivanban = LoaiVanBan::all();
        $nguoinhan = User::whereIn('role', ['pofficer'])->get();

		return view('admin.vanbanden.pheduyetvanban', ['vanbanden' => $vanbanden, 'nguoinhan' => $nguoinhan]);
    }

    public function postPheDuyetVanBan(Request $request, $id) {
        $vanbanden = VanBanDen::find($id);
    
        if (!$vanbanden) {
            return redirect()->back()->with('error', 'Văn bản không tồn tại');
        }
    
        if ($request->has('hoanthanh') && $request->hoanthanh == 'true') {
            // Xử lý khi người dùng nhấn "Hoàn thành"
            
            $vanbanden->action = 'done';
            $vanbanden->save();
            
            // Bạn có thể thêm logic ở đây nếu cần
            return redirect('admin/vanbanden/butphe')->with('thongbao', 'Hoàn thành');
        }
    
        // Logic phê duyệt thông thường
        $vanbanden->action = 'next';
        $vanbanden->id_nguoinhan = $request->nguoinhan;
        $vanbanden->save();
    
        $nguoinhan = User::find($request->nguoinhan); // Tìm người nhận đúng
        if (!$nguoinhan) {
            return redirect()->back()->with('error', 'Người nhận không tồn tại');
        }
    
        $nguoinhan->cong_viec = 'xử lý tiếp';
        $nguoinhan->save();
    
        $ykien = new NhanYKien();
        $ykien->id_nguoinhan = $request->nguoinhan;
        $ykien->y_kien = $request->ykien;
        $ykien->save();
    
        return redirect('admin/vanbanden/pheduyetvanban/'.$id)->with('thongbao', 'Phê duyệt thành công');
    }
    public function getXuLy($id) {
		$vanbanden = VanBanDen::find($id);
        $donvi = Donvi::all();
	//	$coquanbanhanh = CoQuanBanHanh::all();
	//	$hinhthucvanban = HinhThucVanBan::all();
	//	$linhvuc = LinhVuc::all();
	//	$loaihinhvanbanden = LoaiHinhVanBanDen::all();
		$loaivanban = LoaiVanBan::all();
        $nguoinhan = User::whereIn('role', ['pofficer'])->get();

		return view('admin.vanbanden.giaoxuly', ['vanbanden' => $vanbanden, 'nguoinhan' => $nguoinhan, 'donvi' => $donvi]);
    }
    public function postXuLy(Request $request, $id) {
        $vanbanden = VanBanDen::find($id);
        $xuly = Giaoxuly::find($id);
        // if (!$vanbanden) {
        //     return redirect()->back()->with('error', 'Văn bản không tồn tại');
        // }
    
        // if ($request->has('hoanthanh') && $request->hoanthanh == 'true') {
        //     // Xử lý khi người dùng nhấn "Hoàn thành"
            
        //     $vanbanden->action = 'done';
        //     $vanbanden->save();
            
        //     // Bạn có thể thêm logic ở đây nếu cần
        //     return redirect('admin/vanbanden/butphe')->with('thongbao', 'Hoàn thành');
        // }
    
        // Logic phê duyệt thông thường
        // $vanbanden->action = 'next';
        // $vanbanden->id_nguoinhan = $request->nguoinhan;
        $vanbanden->save();
        $this->validate($request,
			[

				'butphe' => 'required|min:10|max:100',

			],
			[
				//'sohieu.required' => 'Bạn phải nhập số hiệu',
				//'sohieu.min' => 'Bạn phải nhập số hiệu lớn từ 3 đến 15 ký tự',
				//'sohieu.max' => 'Bạn phải nhập số hiệu lớn từ 3 đến 15 ký tự',

				'butphe.required' => 'Bạn phải nhập trích yếu nội dung',
				'butphe.min' => 'Bạn phải nhập trích yếu nội dung lớn từ 20 đến 100 ký tự',
				'butphe.max' => 'Bạn phải nhập trích yếu nội dung lớn từ 20 đến 100 ký tự',

			]);
        $xuly = new Giaoxuly();
        $xuly->id_donvi = $request->donvi;
        $xuly->but_phe = $request->butphe;
        $xuly->id_sohieu = $request->id;
        $xuly->han_xu_ly = $request->han_xu_ly;
        $xuly->save();



        // $nguoinhan = User::find($request->nguoinhan); // Tìm người nhận đúng
        // if (!$nguoinhan) {
        //     return redirect()->back()->with('error', 'Người nhận không tồn tại');
        // }
    
        // $nguoinhan->cong_viec = 'xử lý tiếp';
        // $nguoinhan->save();
    
        // $ykien = new NhanYKien();
        // $ykien->id_nguoinhan = $request->nguoinhan;
        // $ykien->y_kien = $request->ykien;
        // $ykien->save();
    
        return redirect('admin/vanbanden/giaoxuly/'.$id)->with('thongbao', 'Giao xử lý thành công');
    }
    public function getHoanThanh() {
		$vanbanden = VanBanDen::where('action', 'done')->get();
		// foreach ($vanbanden as $key => $value) {
		// 	echo "<br>Key:" . $key;
		// 	echo "<hr>";
		// 	echo "id:" . $value->id;
		// 	echo "<hr>";
		// 	$ten = $value->coquanbanhanh->name;
		// 	echo "<b>Value: $ten</b>";
		// }
		return view('admin.vanbanden.hoanthanh', ['vanbanden' => $vanbanden]);
	}
}
