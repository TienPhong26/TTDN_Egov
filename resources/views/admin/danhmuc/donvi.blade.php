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
                        <h1 class="page-header">Đơn vị lĩnh vực
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

@if(isset($donvilinhvuc) && $donvilinhvuc instanceof \Illuminate\Support\Collection && $donvilinhvuc->isEmpty())
    <tr><td colspan="4" align="center">Bảng hiện tại chưa có dữ liệu</td></tr>
@endif


<?php
//Cách xuất STT
$i = 0;
if (isset($_GET['page']) && $_GET['page'] != 1) {
	$i = (($_GET['page'] - 1) * 10) + 1;
}
?>

                            
                    @foreach($donvilinhvuc as $dv)
                    <tr class="odd gradeX" align="center">
                        <td><?php echo $i +=1; ?></td>
                        <td>{{ $dv->name }}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/danhmuc/donvi/xoa/{{ $dv->id }}">Xoá</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/danhmuc/donvi/sua/{{ $dv->id }}">Sửa</a></td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            @if(Auth::user()->level == 2)
            <form action="{{ isset($donvilinhvuc_edit) ? 'admin/danhmuc/donvi/sua/' . $donvilinhvuc_edit->id : 'admin/danhmuc/donvi/them' }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>{{ isset($donvilinhvuc_edit) ? 'Sửa đơn vị' : 'Thêm đơn vị' }}</label>
                    <input class="form-control" name="Ten" placeholder="Nhập tên đơn vị" style="width: 40%;"
                    value="{{ isset($donvilinhvuc_edit) ? $donvilinhvuc_edit->name : '' }}" />
                </div>
                
                <button type="submit" class="btn btn-default">{{ isset($donvilinhvuc_edit) ? 'Cập nhật' : 'Thêm' }}</button>
                <a href="{{ url('admin/danhmuc/donvi') }}" class="btn btn-default">Làm mới</a>
            </form>
            @endif
            
        </div>
        <!-- /#page-wrapper -->

     
@endsection