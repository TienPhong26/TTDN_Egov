<?php

namespace App\Http\Controllers;
use App\VanBanDi;
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


class VanBanDiController extends Controller
{
    public function getThem() {
        $loaivanban = LoaiVanBan::all();
        $linhvuc = LinhVuc::all();
        $domat = DoMat::all();
        $dokhan = DoKhan::all();
        $donvi =Donvi::all();
        $user =User::where('role', ['officer','sofficer','pofficer'])->get();
        return view('admin.vanbandi.vaosodi', compact('loaivanban', 'linhvuc', 'domat', 'dokhan','donvi','user'));
    }

    public function postThem(Request $request) {
        $this->validate($request, [
            'sohieu' => 'required|min:3|max:15',
            'trichyeu' => 'required|min:1|max:255',
            'FileVanBan' => 'nullable|mimes:pdf|max:2048',
        ], [
            'sohieu.required' => 'Bạn phải nhập số hiệu',
            'trichyeu.required' => 'Bạn phải nhập trích yếu nội dung',
            'FileVanBan.mimes' => 'Chỉ được tải lên file PDF',
            'FileVanBan.max' => 'Dung lượng file tối đa là 2MB',
        ]);
    
        $vanban = new VanBanDi();
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
        $vanban->noinhan = $request->noinhan;
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
    
        return redirect('admin/vanbandi/vaosodi')->with('thongbao', 'Thêm văn bản đi thành công!');
    }

    public function getDanhSach() {
        // Lấy tất cả các bản ghi có cột action là 'pending'
        //$vanbandi= VanBanDi::where('action', 'done')->get();
        $vanbandi= VanBanDi::all();
        $user = User::all();
        return view('admin.vanbandi.danhsach', ['vanbandi' => $vanbandi, 'user' => $user]);
    }
    public function getHoanThanh() {
        // Lấy tất cả các bản ghi có cột action là 'pending'
        $vanbandi= VanBanDi::where('action', 'done')->get();
        $user = User::all();
        return view('admin.vanbandi.hoanthanh', ['vanbandi' => $vanbandi, 'user' => $user]);
    }
    public function getPheDuyet() {
        // Lấy tất cả các bản ghi có cột action là 'pending'
        $vanbandi= VanBanDi::where('action', 'next')->get();
        $user = User::all();
        return view('admin.vanbandi.pheduyetdi', ['vanbandi' => $vanbandi, 'user' => $user]);
    }
    public function getChuyen() {
        // Lấy tất cả các bản ghi có cột action là 'pending'
        $vanbandi= VanBanDi::where('action', 'pending')->get();
        $user = User::all();
        return view('admin.vanbandi.chuyen', ['vanbandi' => $vanbandi, 'user' => $user]);
    }

    public function getPheDuyetDi($id) {
		$vanbandi = VanBanDi::find($id);
		$loaivanban = LoaiVanBan::all();
        $donvi = Donvi::all();
        //$user = User::all();
        $user = User::whereIn('role', ['pofficer','sofficer'])->get();

		return view('admin.vanbandi.pheduyetvbdi', ['vanbandi' => $vanbandi, 'user' => $user,'donvi'=>$donvi]);
    }
    public function getChuyenvbdi($id) {
		$vanbandi = VanBanDi::find($id);
		$loaivanban = LoaiVanBan::all();
        $donvi = Donvi::all();
        //$user = User::all();
        $user = User::whereIn('role', ['pofficer','sofficer'])->get();

		return view('admin.vanbandi.chuyenvbdi', ['vanbandi' => $vanbandi, 'user' => $user,'donvi'=>$donvi]);
    }
    public function postPheDuyetDi(Request $request, $id) {
        $vanbandi = VanBanDi::find($id);
      //  $ykien = NhanYKien::all();
        if (!$vanbandi) {
            return redirect()->back()->with('error', 'Văn bản không tồn tại');
        }
    
        if ($request->has('guilai') && $request->guilai == 'true') {
            // Xử lý khi người dùng nhấn "gửi lạih"
            
            $vanbandi->action = 'resend';
            $vanbandi->save();
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
            return redirect('admin/vanbandi/pheduyetvbdi/'.$id)->with('thongbao', 'Hoàn thành gửi lại');
        }
        
        // Logic phê duyệt thông thường
        $vanbandi->action = 'done';
        //$vanbandi->id_nguoinhan = $request->nguoinhan;
        $vanbandi->save();
    
     
        // $ykien = new NhanYKien();
        // $ykien->id_nguoinhan = $request->nguoinhan;
        // $ykien->y_kien = $request->ykien;
        // $ykien->save();
    //    dd($request->all());
        return redirect('admin/vanbandi/pheduyetdi')->with('thongbao', 'Phê duyệt thành công');
    }
    public function postChyenvbdi(Request $request, $id) {
        $vanbandi = VanBanDi::find($id);
      //  $ykien = NhanYKien::all();
        if (!$vanbandi) {
            return redirect()->back()->with('error', 'Văn bản không tồn tại');
        }
    
        if ($request->has('guilai') && $request->guilai == 'true') {
            // Xử lý khi người dùng nhấn "gửi lạih"
            
            $vanbandi->action = 'resend1';
            $vanbandi->save();
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
            return redirect('admin/vanbandi/chuyenvbdi/'.$id)->with('thongbao', 'Hoàn thành gửi lại');
        }
        
        // Logic phê duyệt thông thường
        $vanbandi->action = 'next';
        //$vanbandi->id_nguoinhan = $request->nguoinhan;
        $vanbandi->save();
        return redirect('admin/vanbandi/chuyen')->with('thongbao', 'Phê duyệt thành công');
    }

    public function downloadFile($id)
{
    // Lấy dữ liệu văn bản theo ID
    $vanban = VanBanDi::find($id);

    if (!$vanban) {
        return redirect()->back()->with('loi', 'Văn bản không tồn tại');
    }
    $nguoiKy = $vanban->nguoiKy ? $vanban->nguoiKy->name : 'Không xác định';
    // Tạo nội dung file (ví dụ: file .txt)
    $fileContent = "Ngày Ký: " . $vanban->ngayky . "\n";
    $fileContent .= "Số hiệu: " . $vanban->so_hieudi . "\n";
    $fileContent .= "Ngày văn bản: " . $vanban->ngayvanban . "\n";
    $fileContent .= "Trích yếu nội dung: " . $vanban->trichyeu . "\n";
    $fileContent .= "Nơi nhận: " . $vanban->noinhan . "\n";
    $fileContent .= "Người ký: " . $nguoiKy . "\n";
    $fileContent .= "Ghi chú: " . $vanban->ghichu . "\n";

    // Tạo file .txt
    $fileName = "vanban_ho_so_{$id}.txt";

    // Trả về file tải về
    return response()->stream(
        function () use ($fileContent) {
            echo $fileContent;
        },
        200,
        [
            'Content-Type' => 'text/plain', // Loại file là text/plain cho file .txt
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"', // Tên file khi tải về
        ]
    );
}
}
