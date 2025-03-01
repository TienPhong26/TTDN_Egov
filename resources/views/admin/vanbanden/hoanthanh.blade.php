@extends('admin.layout.index')
@section('title')
Danh sách văn bản hoàn thành
@endsection
@section('content')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Danh sách văn bản hoàn thành
                          
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
                                <th>Ngày Đến</th>
                                <th>Số đến</th>
                                <th>Số hiệu</th>
                                <th>Trích yếu nội dung</th>
                                <th>Ngày chuyển</th>
                                <th>Hạn xử lý</th>
                                <th>Đính kèm</th>
                                {{-- <th>Nội dung lãnh đạo</th> --}}
                                <th>Trạng thái</th>
                                @if (auth()->user()->level == 3 || auth()->user()->level == 2)
                                    <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
{{-- Kiểm tra dữ liệu của bảng nếu k có thì in ra Bảng hiện có dữ liệu --}}
@if(count($vanbanden) == 0)
<tr>Bảng hiện tại chưa có dữ liệu</tr>
@endif

<?php
//Cách xuất STT
$i = 1;
if (isset($_GET['page']) && $_GET['page'] != 1) {
	$i = (($_GET['page'] - 1) * 10) + 1;
}
?>


                            @foreach($vanbanden as $key => $value)
                                <tr class="odd gradeX" align="center">
                                    <td>{{ $i }}</td><?php $i++;?>
                                    <td>{{ $value->ngay_den }}</td>
                                    <td>{{ $value->so_cong_van_den }}</td>
                                    <td>{{ $value->so_hieu }}</td>
                                    <td>{{ $value->ngay_van_ban }}</td>
                                    <td>{{ $value->trich_yeu }}</td>
                                    <td>{{ $value->thoi_han_hoan_thanh }}</td>
                                    <td><a href="{{ asset($value->ten_tep) }}" target="_blank">File</a></td>
                                    <td>Hoàn thành</td>
                                    @if (auth()->user()->level == 3 || auth()->user()->level == 2)
                                    <td><a href="{{ route('download.file', ['id' => $value->id]) }}"><i class="fa-solid fa-sd-card"></i> Lưu hồ sơ</a></td>
                                    @endif
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
                {{-- <button type="button" class="btn btn-primary">Xuất dữ liệu</button> --}}
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->


@endsection