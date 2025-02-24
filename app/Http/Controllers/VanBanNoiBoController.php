<?php

namespace App\Http\Controllers;
use App\VanBanNoiBo;
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


class VanBanNoiBoController extends Controller
{
    public function getThem() {
        $loaivanban = LoaiVanBan::all();
        $linhvuc = LinhVuc::all();
        $domat = DoMat::all();
        $dokhan = DoKhan::all();
        $donvi =Donvi::all();
        $user =User::where('role', ['officer','sofficer','pofficer'])->get();
        return view('admin.vanbannoibo.vaosonoibo', compact('loaivanban', 'linhvuc', 'domat', 'dokhan','donvi','user'));
    }

    public function postThem(Request $request) {
        $this->validate($request, [
            'sohieu' => 'required|min:3|max:15',
            'donvi' => 'required',
            'trichyeu' => 'required|min:1|max:255',
            'FileVanBan' => 'nullable|mimes:pdf|max:2048',
            'ngayvanban' => 'required|date',
            'ngayky' => 'required|date',
            'nguoiky' => 'required|string|max:255',
        ], [
            'sohieu.required' => 'Bạn phải nhập số hiệu',
            'donvi.required' => 'Bạn phải nhập đơn vị',
            'trichyeu.required' => 'Bạn phải nhập trích yếu nội dung',
            'FileVanBan.mimes' => 'Chỉ được tải lên file PDF',
            'FileVanBan.max' => 'Dung lượng file tối đa là 2MB',
            'ngayvanban.required' => 'Bạn phải nhập ngày văn bản',
            'ngayvanban.date' => 'Ngày văn bản không hợp lệ',
            'ngayky.required' => 'Bạn phải nhập ngày ký',
            'ngayky.date' => 'Ngày ký không hợp lệ',
            'nguoiky.required' => 'Bạn phải nhập người ký',
            'nguoiky.string' => 'Người ký phải là chuỗi văn bản',
            'nguoiky.max' => 'Người ký không được quá 255 ký tự',
        ]);
        

        
        $vanban = new VanBanNoiBo();
        $vanban->so_hieudi = $request->sohieu;
        //$vanban->so_cong_van_den = $request->socongvan;
       // $vanban->ngay_den = $request->ngayden;
        $vanban->id_donvi = $request->donvi;
        $vanban->trichyeu = $request->trichyeu;
        $vanban->id_loaivanban = $request->loaivanban ? intval($request->loaivanban) : null;
        $vanban->id_linhvuc = $request->linhvuc ? intval($request->linhvuc) : null;
        $vanban->id_domat = $request->domat ? intval($request->domat) : null;
        $vanban->id_dokhan = $request->dokhan ? intval($request->dokhan) : null;
        $vanban->ngayvanban = $request->ngayvanban;
        $vanban->ngayky = $request->ngayky;
        $vanban->ghichu = $request->ghichu;
        $vanban->nguoiky = $request->nguoiky;
     //   $vanban->noinhan = $request->noinhan;
      //  $vanban->thoi_han_hoan_thanh = $request->ThoiHanHoanThanh ?? null;
        //$vanban->ghi_chu = $request->GhiChu ?? null;
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
            $vanban->ten_file = 'upload/' . $filename;
        }
        
        
        $vanban->save();
    
        return redirect('admin/vanbannoibo/vaosonoibo')->with('thongbao', 'Thêm văn bản đi thành công!');
    }

    public function getDanhSach() {
        // Lấy tất cả các bản ghi có cột action là 'pending'
        $vanbannoibo= VanBanNoiBo::where('action', 'done')->get();
        $user = User::all();
        return view('admin.vanbannoibo.danhsach', ['vanbannoibo' => $vanbannoibo, 'user' => $user]);
    }
    public function getPheDuyet() {
        // Lấy tất cả các bản ghi có cột action là 'pending'
        $vanbannoibo= VanBanNoiBo::where('action', 'pending')->get();
        $user = User::all();
        return view('admin.vanbannoibo.pheduyet', ['vanbannoibo' => $vanbannoibo, 'user' => $user]);
    }

    public function getPheDuyetNoiBo($id) {
		$vanbannoibo = VanBanNoiBo::find($id);
	//	$coquanbanhanh = CoQuanBanHanh::all();
	//	$hinhthucvanban = HinhThucVanBan::all();
	//	$linhvuc = LinhVuc::all();
	//	$loaihinhvanbanden = LoaiHinhVanBanDen::all();
		$loaivanban = LoaiVanBan::all();
        $donvi = Donvi::all();
        //$user = User::all();
        $user = User::whereIn('role', ['pofficer','sofficer'])->get();

		return view('admin.vanbannoibo.pheduyetnoibo', ['vanbannoibo' => $vanbannoibo, 'user' => $user,'donvi'=>$donvi]);
    }

    public function postPheDuyetNoiBo(Request $request, $id) {
        $vanbannoibo = VanBanNoiBo::find($id);
      //  $ykien = NhanYKien::all();
        if (!$vanbannoibo) {
            return redirect()->back()->with('error', 'Văn bản không tồn tại');
        }
    
        if ($request->has('guilai') && $request->guilai == 'true') {
            // Xử lý khi người dùng nhấn "gửi lạih"
            
            $vanbannoibo->action = 'resend';
            $vanbannoibo->save();
            $request->validate([
              //  'donvi' => 'required|exists:donvi_table,id',  // Điều chỉnh bảng cho phù hợp
                'y_kien' => 'required|string|max:500'  // Kiểm tra y_kien có giá trị và không trống
            ]);
            
            $ykien = new NhanYKien();
            $ykien->id_nguoinhan = '1';
            $ykien->id_donvi = $request->donvi;
            $ykien->y_kien = $request->y_kien;
            $ykien->save();
            // Bạn có thể thêm logic ở đây nếu cần
            return redirect('admin/vanbannoibo/pheduyetnoibo/'.$id)->with('thongbao', 'Hoàn thành gửi lại phê duyệt');
        }
    
        // Logic phê duyệt thông thường
        $vanbannoibo->action = 'done';
        //$vanbannoibo->id_nguoinhan = $request->nguoinhan;
        $vanbannoibo->save();
    
     
        // $ykien = new NhanYKien();
        // $ykien->id_nguoinhan = $request->nguoinhan;
        // $ykien->y_kien = $request->ykien;
        // $ykien->save();
    
        return redirect('admin/vanbannoibo/pheduyet')->with('thongbao', 'Phê duyệt thành công');
    }
}
