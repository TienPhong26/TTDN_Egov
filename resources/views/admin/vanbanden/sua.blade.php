@extends('admin.layout.index')

@section('title', 'Sửa văn bản đến')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sửa văn bản đến</h1>
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

            <form action="{{ url('admin/vanbanden/sua/'.$vanbanden->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="sohieu">Số hiệu:</label>
                    <input type="text" class="form-control" id="sohieu" name="sohieu" value="{{ old('sohieu', $vanbanden->so_hieu) }}" required>
                </div>

                <div class="form-group">
                    <label for="ngay_den">Ngày đến:</label>
                    <input type="date" class="form-control" id="ngayden" name="ngayden" value="{{ old('ngayden', $vanbanden->ngay_den) }}" required>
                </div>

                <div class="form-group">
                    <label for="trichyeu">Trích yếu nội dung:</label>
                    <textarea class="form-control" id="trichyeu" name="trichyeu" required>{{ old('trichyeu', $vanbanden->trich_yeu) }}</textarea>
                </div>

                {{-- <div class="form-group">
                    <label for="nguoiky">Người ký:</label>
                    <input type="text" class="form-control" id="nguoiky" name="nguoiky" value="{{ old('nguoiky', $vanbanden->nguoi_ky) }}" required>
                </div> --}}
                
              

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ url('admin/vanbanden/chuyen') }}" class="btn btn-default">Hủy</a>
                <a href="{{ url('admin/vanbanden/chuyen') }}" class="btn btn-default" class="btn btn-primary">Quay lại</a>
            </form>
        </div>
    </div>

@endsection
