@extends('admin.layout.index')
@section('title')
Danh sách Độ khẩn
@endsection
@section('content')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Độ khẩn
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    {{-- @if(session('thongbao'))
                            <div class="alert alert-success">{{ session('thongbao') }}</div>
                    @endif --}}
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
                    @if(session('loi'))
                            <div class="alert alert-danger">{{ session('loi') }}</div>
                    @endif
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Xoá</th>
                                <th>Sửa</th>
                            </tr>
                        </thead>
                        <tbody>

{{-- Kiểm tra dữ liệu của bảng nếu k có thì in ra Bảng hiện có dữ liệu --}}

@if(isset($dokhan) && $dokhan instanceof \Illuminate\Support\Collection && $dokhan->isEmpty())
    <tr><td colspan="4" align="center">Bảng hiện tại chưa có dữ liệu</td></tr>
@endif


<?php
//Cách xuất STT
$i = 0;
if (isset($_GET['page']) && $_GET['page'] != 1) {
	$i = (($_GET['page'] - 1) * 10) + 1;
}
?>

                            
                    @foreach($dokhan as $dk)
                    <tr class="odd gradeX" align="center">
                        <td><?php echo $i +=1; ?></td>
                        <td>{{ $dk->name }}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/danhmuc/dokhan/xoa/{{ $dk->id }}">Xoá</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/danhmuc/dokhan/sua/{{ $dk->id }}">Sửa</a></td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            @if ( Auth::user()->level == 2)
            
            
            <form action="{{ isset($dokhan_edit) ? 'admin/danhmuc/dokhan/sua/' . $dokhan_edit->id : 'admin/danhmuc/dokhan/them' }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>{{ isset($dokhan_edit) ? 'Sửa độ khẩn' : 'Thêm độ khẩn' }}</label>
                    <input class="form-control" name="Ten" placeholder="Nhập tên độ khẩn" style="width: 40%;"
                           value="{{ isset($dokhan_edit) ? $dokhan_edit->name : '' }}" />
                </div>
            
                <button type="submit" class="btn btn-default">{{ isset($dokhan_edit) ? 'Cập nhật' : 'Thêm' }}</button>
                <a href="{{ url('admin/danhmuc/dokhan') }}" class="btn btn-default">Làm mới</a>
            </form>
            @endif
        </div>
        <!-- /#page-wrapper -->

     
@endsection