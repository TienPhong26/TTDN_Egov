@extends('admin.layout.index')
@section('title')
Danh sách văn bản đi
@endsection
@section('content')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Danh sách văn bản đi
                          
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    @if(count($errors)>0)
                            <div class="alert-danger">
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
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                        <thead>
                            <tr align="center">
                                <th>#</th>
                                <th>Số hiệu</th>
                                <th>Ngày Ký</th>
                                <th>Ngày Văn Bản</th>
                                <th>Trích yếu nội dung</th>
                                <th>Nơi nhận</th>
                                <th>Người ký</th>
                                <th>Đính kèm</th>
                                {{-- <th>Nội dung lãnh đạo</th> --}}
                                <th>Ghi chú</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
{{-- Kiểm tra dữ liệu của bảng nếu k có thì in ra Bảng hiện có dữ liệu --}}
@if(count($vanbandi) == 0)
<tr>Bảng hiện tại chưa có dữ liệu</tr>
@endif

<?php
//Cách xuất STT
$i = 1;
if (isset($_GET['page']) && $_GET['page'] != 1) {
	$i = (($_GET['page'] - 1) * 10) + 1;
}
?>


                                @if(is_iterable($vanbandi) && count($vanbandi) > 0)
                                @foreach($vanbandi as $key => $value)
                                    <tr class="odd gradeX" align="center">
                                        <td>{{ $i }}</td><?php $i++; ?>
                                        <td>{{ $value->so_hieudi }}</td>
                                        <td>{{ $value->ngayky }}</td>
                                        <td>{{ $value->ngayvanban }}</td>
                                        <td>{{ $value->trichyeu }}</td>
                                        <td>{{ $value->noinhan }}</td>

                                        @if(is_iterable($user))
                                            @foreach($user as $us)
                                                @if($us->id == $value->nguoiky)
                                                    <td>{{ $us->name }}</td>
                                                @endif
                                            @endforeach
                                        @else
                                            <td>Không tìm thấy người ký</td>
                                        @endif
                                        <td><a href="{{ asset($value->ten_file) }}" target="_blank">File</a></td>
                                        <td>{{$value->ghichu}}</td>
                                        
                                        @switch($value->action)
                                            @case('pending')
                                                <td>Chờ kiểm tra</td>
                                                @break

                                            @case('next')
                                                <td>Chờ phê duyệt</td>
                                                @break

                                            @case('resend')
                                            @case('resend1')
                                                <td>Gửi đơn vị sửa lại</td>
                                                @break

                                            @case('done')
                                                <td>Hoàn thành</td>
                                                @break
                                        @endswitch

                                        
                                    </tr>
                                @endforeach
                                @else
                                <tr><td colspan="7">Không có dữ liệu</td></tr>
                                @endif

                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->


@endsection