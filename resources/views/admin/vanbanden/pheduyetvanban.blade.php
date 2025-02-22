@extends('admin.layout.index')

@section('title', 'Phê duyệt văn bản')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Phê duyệt văn bản</h1>
                </div>
            </div>

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                        {{ $err }}<br>
                    @endforeach
                </div>
            @endif

            @if(session('loi'))
                <div class="alert alert-danger">
                    {{ session('loi') }}
                </div>
            @endif

            @if(session('thongbao'))
                <div id="alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                    {{ session('thongbao') }}
                </div>

                <script>
                    setTimeout(function() {
                        var alert = document.getElementById('alert-success');
                        if (alert) {
                            alert.style.display = 'none';
                        }
                    }, 2000); // 2000ms = 2 giây
                </script>
            @endif

            <form action="{{ route('admin.vanbanden.pheduyetvanban', ['id' => $vanbanden->id]) }}" method="POST">
                {{ csrf_field() }}
            
                <input type="hidden" name="vanban_id" value="{{ $vanbanden->id }}">
                <table style="border-collapse: collapse; width: 80%;">
                    <tr>
                        <td>  <div class="form-group">
                            <label>Số Đến:</label>
                            <input type="text" class="form-control" style="width: 400px;" value="{{ $vanbanden->so_cong_van_den }}" readonly>
                        </div></td>
                        <td>
                            <div class="form-group">
                                <label>Nơi gửi:</label>
                                <input type="text" class="form-control" value="{{ $vanbanden->don_vi_gui}}" readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label>Người ký:</label>
                                <input type="text" class="form-control" style="width: 400px;"  value="{{ $vanbanden->nguoi_ky}}" readonly>
                            </div>
                        </td>
                        <td>
                              
                            <div class="form-group">
                                <label>Số hiệu:</label>
                                <input type="text" class="form-control" value="{{ $vanbanden->so_hieu}}" readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label>Trích Yếu:</label>
                                <textarea class="form-control " style="width: 600px;" rows="3" readonly >{{ $vanbanden->trich_yeu }}</textarea>
                                {{-- <input type="text" class="form-control" value="{{ $vanbanden->trich_yeu }}" readonly> --}}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>Ngày Đến:</label>
                                <input type="text" class="form-control" style="width: 100px;"value="{{ $vanbanden->ngay_den }}" readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group" style="width: 400px;">
                                <label>Giao chỉ đạo</label>
                                <select class="form-control" name="nguoinhan">
                                    <option value="">--Chọn--</option>
                                    @foreach($nguoinhan as $us)
                                        <option value="{{ $us->id }}">{{ $us->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>File Đính Kèm:</label><br>
                                <a href="{{ asset($vanbanden->ten_tep) }}" >{{ $vanbanden->ten_tep }}</a>
                            </div>            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-group">
                                <label>Ý kiến chỉ đạo:</label><br>
                                <textarea class="form-control " style="width: 600px;" rows="3" id='ykien' name="ykien"></textarea>
                                {{-- <a href="{{ asset($vanbanden->ten_tep) }}" >{{ $vanbanden->ten_tep }}</a> --}}
                            </div>
                        </td>
                    </tr>
                </table>
    
                
                
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen-nib"></i> Phê duyệt</button>
                <button type="submit" name="hoanthanh" value="true" class="btn btn-success">
                    <i class="fa-solid fa-check"></i> Hoàn thành
                </button>
                <a href="{{ url('admin/vanbanden/butphe') }}" class="btn btn-default" class="btn btn-primary"><i class="fa-solid fa-backward"></i> Quay lại</a>
            </form>
        </div>
        <div class="form-group">
            <label></label><br>
            <a href="{{ asset($vanbanden->ten_tep) }}" >{{ $vanbanden->ten_tep }}</a><br>
            
            {{-- Kiểm tra xem file có phải là hình ảnh không --}}
            @if(in_array(strtolower(pathinfo($vanbanden->ten_tep, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                <img src="{{ asset($vanbanden->ten_tep) }}" alt="File Image" style="max-width: 100%; height: auto; margin-top: 10px;">
            @endif
        </div>
        
    </div>

@endsection
