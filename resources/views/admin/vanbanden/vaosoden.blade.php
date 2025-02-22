@extends('admin.layout.index')
@section('title')
Vào sổ văn bản đến
@endsection
@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Vào sổ văn bản đến</h1>
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

            <div class="col-lg-12" style="padding-bottom:120px">
                <form action="admin/vanbanden/vaosoden" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-bordered">
                        <tr>
                            <th>Số công văn đến</th>
                            <td><input class="form-control" name="socongvan" placeholder="Nhập số công văn" /></td>
                            <th>Ngày đến</th>
                            <td><input type="date" class="form-control" name="ngayden" value="<?= date('Y-m-d') ?>"/></td>
                        </tr>
                        <tr>
                            <th>Đơn vị gửi</th>
                            <td><input class="form-control" name="donvigui" placeholder="Nhập đơn vị gửi" /></td>
                            <th>Số hiệu</th>
                            <td><input class="form-control" name="sohieu" placeholder="Nhập số hiệu" /></td>
                        </tr>
                        <tr>
                            <th>Trích yếu</th>
                            <td colspan="3"><textarea class="form-control" name="trichyeu" rows="3" placeholder="Nhập trích yếu"></textarea></td>
                        </tr>
                        <tr>
                            <th>Loại văn bản</th>
                            <td>
                                <select class="form-control" name="LoaiVanBan">
                                    <option value="">--Chọn--</option>
                                    @foreach($loaivanban as $lvb)
                                        <option value="{{ $lvb->id }}">{{ $lvb->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <th>Lĩnh vực</th>
                            <td>
                                <select class="form-control" name="LinhVuc">
                                    <option value="">--Chọn--</option>
                                    @foreach($linhvuc as $lv)
                                        <option value="{{ $lv->id }}">{{ $lv->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Độ mật</th>
                            <td>
                                <select class="form-control" name="DoMat">
                                    @foreach($domat as $dm)
                                        <option value="{{ $dm->id }}">{{ $dm->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <th>Độ khẩn</th>
                            <td>
                                <select class="form-control" name="DoKhan">
                                    @foreach($dokhan as $dk)
                                        <option value="{{ $dk->id }}">{{ $dk->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày văn bản</th>
                            <td><input type="date" class="form-control" name="NgayVanBan" value="<?= date('Y-m-d') ?>" /> </td>
                            <th>Người ký</th>
                            <td><input class="form-control" name="NguoiKy" placeholder="Nhập họ và tên người ký" /></td>
                        </tr>
                        <tr>
                            <th>Thời hạn hoàn thành</th>
                            <td><input type="date" class="form-control" name="ThoiHanHoanThanh" /></td>
                        </tr>
                        <tr>
                            <th>Ghi chú</th>
                            <td colspan="3"><textarea class="form-control" name="GhiChu" rows="2" placeholder="Thêm ghi chú"></textarea></td>
                        </tr>
                        <tr>
                            <th>File văn bản (PDF)</th>
                            <td colspan="3"><input type="file" name="FileVanBan" accept="application/pdf"></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input type="checkbox" name="ChoPhepTai" checked> Cho phép tải văn bản
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                    <button type="reset" class="btn btn-secondary">Làm mới</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
