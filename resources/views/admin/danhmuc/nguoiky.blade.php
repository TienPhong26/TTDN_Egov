@extends('admin.layout.index')
@section('title')
Danh sách Người ký
@endsection
@section('content')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Người ký
                        
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err )
                                {{ $err }}<br>
                            @endforeach
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
                    @if(session('loi'))
                        <div class="alert alert-success">{{ session('loi') }}</div>
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
@if(count($user) == 0)
<tr>Bảng hiện tại chưa có dữ liệu</tr>
@endif

<?php
//Cách xuất STT
$i = 1;
if (isset($_GET['page']) && $_GET['page'] != 1) {
	$i = (($_GET['page'] - 1) * 10) + 1;
}
?>

                            @foreach($user as $usr)
                                <tr class="odd gradeX" align="center">
                                    <td>{{ $i }}</td><?php $i++;?>
                                    <td>{{ $usr->name }}</td>
                                    <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/danhmuc/nguoiky/xoa/{{ $usr->id }}">Xoá</a></td>
                                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/danhmuc/nguoiky/sua/{{ $usr->id }}">Sửa</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            @if(Auth::user()->level == 2)
            <form action="{{ isset($user_edit) ? 'admin/danhmuc/nguoiky/sua/' . $user_edit->id : 'admin/danhmuc/nguoiky/them' }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>{{ isset($user_edit) ? 'Sửa người ký' : 'Thêm người ký' }}</label>
                    <input class="form-control" name="Ten" placeholder="Nhập tên người ký" style="width: 40%;"
                    value="{{ isset($user_edit) ? $user_edit->name : '' }}" />
                </div>
                
                <button type="submit" class="btn btn-default">{{ isset($user_edit) ? 'Cập nhật' : 'Thêm' }}</button>
                <a href="{{ url('admin/danhmuc/nguoiky') }}" class="btn btn-default">Làm mới</a>
            </form>
            @endif
        </div>
        <!-- /#page-wrapper -->

@endsection