@extends('admin.layout.index')
@section('title')
Danh sách Loại văn bản
@endsection
@section('content')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Loại văn bản
                           
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
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
                            <tr style="text-align: center,margin: auto;">
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Hình thức</th>
                                <th>Xoá</th>
                                <th>Sửa</th>
                            </tr>
                        </thead>
                        <tbody>

{{-- Kiểm tra dữ liệu của bảng nếu k có thì in ra Bảng hiện có dữ liệu --}}
@if(count($loaivanban) == 0)
<tr>Bảng hiện tại chưa có dữ liệu</tr>
@endif

<?php
//Cách xuất STT
$i = 0;
if (isset($_GET['page']) && $_GET['page'] != 1) {
	$i = (($_GET['page'] - 1) * 10) + 1;
}
?>

                            
                    @foreach($loaivanban as $lvb)
                    <tr class="odd gradeX" align="center">
                        <td><?php echo $i +=1; ?></td>
                        <td>{{ $lvb->name }}</td>
                        <td>{{ $lvb->hinhthuc }}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/danhmuc/loaivanban/xoa/{{ $lvb->id }}">Xoá</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/danhmuc/loaivanban/sua/{{ $lvb->id }}">Sửa</a></td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <form action="{{ isset($loaivanban_edit) ? 'admin/danhmuc/loaivanban/sua/' . $loaivanban_edit->id : 'admin/danhmuc/loaivanban/them' }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table style="width: 80%;border-collapse: collapse"  >
                    <tr>
                        <td>
                                    <div class="form-group">
                            <label>{{ isset($loaivanban_edit) ? 'Sửa loại văn bản' : 'Thêm loại văn bản' }}</label>
                            <input class="form-control" name="Ten" placeholder="Nhập tên loại văn bản" style="width: 40%;"
                                value="{{ isset($loaivanban_edit) ? $loaivanban_edit->name : '' }}" />
                        </div>
                    
                        </td>
                        <td>
                            <div class="form-group">
                                <label>Hình thức văn bản</label>
                                <select name="hinhthuc" class="form-control" style="width: 300px">
                                    <option value="">-- Chọn Hình thức --</option>
                                    <option value="vanbandi" {{ old('hinhthuc') == 'vanbandi' ? 'selected' : '' }}>Văn bản đi</option>
                                    <option value="vanbanden" {{ old('hinhthuc') == 'vanbanden' ? 'selected' : '' }}>Văn bản đến</option>
                                    <option value="vanbannoibo" {{ old('hinhthuc') == 'vanbannoibo' ? 'selected' : '' }}>Văn bản nội bộ</option>
                                    <option value="vanbankhac" {{ old('hinhthuc') == 'vanbankhac' ? 'selected' : '' }}>Văn bản khác</option>
                                </select>
                                
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <button type="submit" class="btn btn-default">{{ isset($loaivanban_edit) ? 'Cập nhật' : 'Thêm' }}</button>
                            <a href="{{ url('admin/danhmuc/loaivanban') }}" class="btn btn-default">Làm mới</a>
                        </td>
                    </tr>
                </table>
            </form>
            
        </div>
        <!-- /#page-wrapper -->

@endsection