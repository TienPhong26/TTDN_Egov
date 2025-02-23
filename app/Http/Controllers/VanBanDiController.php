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
            'trichyeu' => 'required|min:10|max:255',
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
        $vanbandi= VanBanDi::all();
        $user = User::all();
        return view('admin.vanbandi.danhsach', ['vanbandi' => $vanbandi, 'user' => $user]);
    }
}
