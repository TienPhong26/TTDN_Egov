@extends('admin.layout.index')
@section('title')
Danh sách Lĩnh vực
@endsection
@section('content')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Lĩnh vực
            
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    @if(session('thongbao'))
                            <div class="alert alert-success">{{ session('thongbao') }}</div>
                    @endif
                    @if(session('loi'))
                            <div class="alert alert-danger">{{ session('loi') }}</div>
                    @endif
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Thuộc đơn vị</th>
                                <th>Xoá</th>
                                <th>Sửa</th>
                            </tr>
                        </thead>
                        <tbody>

{{-- Kiểm tra dữ liệu của bảng nếu k có thì in ra Bảng hiện có dữ liệu --}}
@if(count($linhvuc) == 0)
<tr>Bảng hiện tại chưa có dữ liệu</tr>
@endif

<?php
//Cách xuất STT
$i = 1;
if (isset($_GET['page']) && $_GET['page'] != 1) {
	$i = (($_GET['page'] - 1) * 10) + 1;
}
?>

                            @foreach($linhvuc as $lv )
                                <tr class="odd gradeX" align="center">
                                    <td>{{ $i }}</td><?php $i++;?>
                                    <td>{{ $lv->name }}</td>
                                    <td>{{ $lv->donvilinhvuc->name ?? 'Chưa có đơn vị' }}</td>
                                    <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/danhmuc/linhvuc/xoa/{{ $lv->id }}">Xoá</a></td>
                                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/danhmuc/linhvuc/sua/{{ $lv->id }}">Sửa</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
                <form action="{{ isset($linhvuc_edit) ? 'admin/danhmuc/linhvuc/sua/' . $linhvuc_edit->id : 'admin/danhmuc/linhvuc/them' }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                        <div class="form-group">
                                <label>{{ isset($linhvuc_edit) ? 'Sửa lĩnh vực' : 'Thêm lĩnh vực' }}</label>
                                <input class="form-control" name="Ten" placeholder="Nhập tên lĩnh vực" style="width: 40%;"
                                    value="{{ isset($linhvuc_edit) ? $linhvuc_edit->name : '' }}" />
                            </div>
                        
                            </td>
                            <td>
                                <div class="form-group">
                                    <label>Chọn Phòng Ban</label>
                                    <select class="form-control" name="iddonvilinhvuc" style="width: 40%;">
                                        <option value="">-- Chọn Phòng Ban --</option>
                                        @foreach($donvilinhvuc as $dv)
                                            <option value="{{ $dv->id }}" 
                                                {{ isset($linhvuc_edit) && $linhvuc_edit->iddonvilinhvuc == $dv->id ? 'selected' : '' }}>
                                                {{ $dv->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <button type="submit" class="btn btn-default">{{ isset($linhvuc_edit) ? 'Cập nhật' : 'Thêm' }}</button>
                                <a href="{{ url('admin/danhmuc/linhvuc') }}" class="btn btn-default">Làm mới</a>
                            </td>
                        </tr>
                    </table>
                    
                    
                
                   
                </form>
                
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

@endsection