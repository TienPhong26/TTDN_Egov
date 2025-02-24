@extends('admin.layout.index')

@section('title', 'Phê duyệt văn bản đi')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Phê duyệt văn bản đi</h1>
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

            <form action="{{ route('admin.vanbandi.pheduyetvbdi', ['id' => $vanbandi->id]) }}" method="POST">
                {{ csrf_field() }}
            
                <input type="hidden" name="vanban_id" value="{{ $vanbandi->id }}">
                <table style="border-collapse: collapse; width: 80%;">
                    <tr>
                        <td>  <div class="form-group">
                            <label>Số Hiệu Đi:</label>
                            <input type="text" class="form-control" style="width: 400px;" value="{{ $vanbandi->so_hieudi }}" readonly>
                        </div></td>
                        <td>
                            <div class="form-group">
                                <label>Nơi nhận:</label>
                                <input type="text" class="form-control" value="{{ $vanbandi->noinhan}}" readonly>
                            </div>
                        </td>
                            @if(is_iterable($user))
                                            @foreach($user as $us)
                                                @if($us->id == $vanbandi->nguoiky)
                                                    <td>{{ $us->name }}</td>
                                                @endif
                                            @endforeach
                                        @else
                                            <td>Không tìm thấy người ký</td>
                                        @endif                        
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="form-group">
                                <label>Ngày ký:</label>
                                <input style="width: 100px;" type="text" class="form-control" value="{{ $vanbandi->ngayky}}" readonly>
                            </div>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label>Trích Yếu:</label>
                                <textarea class="form-control " style="width: 400px;" rows="3" readonly >{{ $vanbandi->trichyeu }}</textarea>
                                {{-- <input type="text" class="form-control" value="{{ $vanbandi->trich_yeu }}" readonly> --}}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>Ghi chú:</label>
                                <textarea class="form-control " style="width: 400px;" rows="3" readonly >{{ $vanbandi->ghichu }}</textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label>File Đính Kèm:</label><br>
                                <a href="{{ asset($vanbandi->ten_file) }}" >{{ $vanbandi->ten_file}}</a>
                            </div>            
                        </td>
                    </tr>
                </table>
                <!-- Modal -->
                <!-- Modal -->
                <div id="editModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg"> <!-- Đổi modal-lg nếu cần form lớn hơn -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Chỉnh sửa</h4>
                            </div>
                            <div class="modal-body">
                                <form id="editForm">
                                    <div class="form-group">
                                        <label >Đơn vị chỉnh sửa:</label>
                                        <select style="height: 30px" id="donvi" name="donvi">
                                            <option value=""  disabled selected>Chọn đơn vị</option>
                                        @foreach ($donvi as $dv )
                                            <option value="{{ $dv->id }}">{{ $dv->name}}</option>
                                        @endforeach
                                        </select>
                                        <br>
                                        <label >Yêu cầu chỉnh sửa:</label>
                                        <textarea id="y_kien" name="y_kien" class="form-control" rows="4"></textarea>
                                    </div>
                                    <button type="submit" name="guilai" value="true" class="btn btn-primary">Gửi lại</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen-nib"></i> Phê duyệt</button>
                {{-- <button type="submit" name="hoanthanh" value="true" class="btn btn-success">
                    <i class="fa-solid fa-check"></i> Hoàn thành
                </button> --}}
                <button type="button"  class="btn btn-success" data-toggle="modal" data-target="#editModal">
                    <i class="fa fa-check"></i> Gửi chỉnh sửa lại
                </button>
                              
                <a href="{{ url('admin/vanbandi/pheduyetdi') }}" class="btn btn-default" class="btn btn-primary"><i class="fa-solid fa-backward"></i> Quay lại</a>
            </form>
        </div>
        <div class="form-group">
            <br>
            <iframe src="{{ asset($vanbandi->ten_file) }}" width="60%" height="800px" style="margin-left: 15%;"></iframe>
        </div>
        
    </div>

@endsection
