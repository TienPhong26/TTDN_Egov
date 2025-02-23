@extends('admin.layout.index')

@section('title', 'Giao xử lý')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Giao xử lý</h1>
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

            <form action="{{ route('admin.vanbanden.giaoxuly', ['id' => $vanbanden->id]) }}" method="POST">
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
                                <textarea class="form-control " style="width: 400px;" rows="3" readonly >{{ $vanbanden->trich_yeu }}</textarea>
                                {{-- <input type="text" class="form-control" value="{{ $vanbanden->trich_yeu }}" readonly> --}}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>Bút phê:</label>
                                <textarea class="form-control " style="width: 400px;" rows="3" id="butphe" name="butphe"></textarea>
                                {{-- <input type="text" class="form-control" value="{{ $vanbanden->trich_yeu }}" readonly> --}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-group">
                                <label>Thời hạn hoàn thành:</label>
                                <input type="date" class="form-control" style="width: 150px;" id="han_xu_ly" name="han_xu_ly">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group" style="width:250px; ">
                                <label>Đơn vị chủ trì</label>
                                <select class="form-control"  id="donvi" name="donvi">
                                    <option value="">--Chọn--</option>
                                    @foreach($donvi as $dv)
                                        <option value="{{ $dv->id }}">{{ $dv->name }}</option>
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
                </table>
              
                
    
               
    
                
                {{-- <div class="form-group">
                    <label>Người nhận</label>
                    <select class="form-control" name="nguoinhan">
                        <option value="">--Chọn--</option>
                        @foreach($nguoinhan as $us)
                            <option value="{{ $us->id }}">{{ $us->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Giao xử lý</button>
                <a href="{{ url('admin/vanbanden/butphe') }}" class="btn btn-default" class="btn btn-primary">Quay lại</a>
            </form>
        </div>
    </div>

@endsection
