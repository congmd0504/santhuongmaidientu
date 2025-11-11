@extends('admin.layouts.main')
@section('title',"thêm sản phẩm")

@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #000 !important;
    }

    .select2-container .select2-selection--single {
        height: auto;
    }
</style>
@endsection
@section('content')


<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Product","key"=>"Thêm sản phẩm"])

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has("alert"))
                    <div class="alert alert-success">
                        {{session()->get("alert")}}
                    </div>
                    @elseif(session()->has('error'))
                    <div class="alert alert-warning">
                        {{session("error")}}
                    </div>
                    @endif
                    <form action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                       <h3 class="card-title">Thông tin sản phẩm</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3">

                                        <div class="form-group">
                                            <label for="">Tên sản phẩm</label>
                                            <input type="text" class="form-control
                                                @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" name="name" placeholder="Nhập tên sản phẩm">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Slug</label>
                                            <input type="text" class="form-control
                                            @error('slug') is-invalid  @enderror" id="slug" value="{{ old('slug') }}" name="slug" placeholder="Nhập slug">
                                        </div>
                                        @error('slug')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Mã sản phẩm</label>
                                            <input type="text" class="form-control
                                                @error('name') is-invalid @enderror" id="masp" value="{{ old('masp') }}" name="masp" placeholder="Nhập mã sản phẩm" required>
                                            @error('masp')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Thời gian bảo hành (tháng)</label>
                                            <input type="text" class="form-control @error('warranty')
                                            is-invalid
                                            @enderror" id="" value="{{ old('warranty') }}" name="warranty" placeholder="Nhập thời gian">
                                        </div>
                                        @error('warranty')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        {{-- <div class="form-group">
                                            <label for="">Số lượt xem</label>
                                            <input type="mumber" class="form-control @error('view')
                                            is-invalid
                                            @enderror" id="" value="{{ old('view') }}" name="view" placeholder="Nhập view">
                                        </div>
                                        @error('view')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror --}}

                                        <div class="form-group">
                                            <label for="">Nhập mô tả seo</label>
                                            <input type="text" class="form-control @error('description_seo') is-invalid @enderror" id="" value="{{ old('description_seo') }}" name="description_seo" placeholder="Nhập mô tả seo">
                                        </div>
                                        @error('description_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Nhập title seo</label>
                                            <input type="text" class="form-control @error('title_seo') is-invalid @enderror" id="" value="{{ old('title_seo') }}" name="title_seo" placeholder="Nhập title seo">
                                        </div>
                                        @error('title_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập giới thiệu</label>
                                            <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="" rows="3"  placeholder="Nhập giới thiệu">{{ old('description') }}</textarea>
                                        </div>
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập nội dung</label>
                                            <textarea class="form-control tinymce_editor_init @error('content') is-invalid  @enderror" name="content" id="content" rows="3" value="" placeholder="Nhập nội dung">
                                            {{ old('content') }}
                                            </textarea>
                                        </div>
                                        @error('content')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập tags</label>
                                            <select class="form-control tag-select-choose" multiple="multiple" name="tags[]">
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                       <h3 class="card-title">Thông tin khác</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <div class="wrap-load-image mb-3">
                                            <div class="form-group">
                                                <label for="">Ảnh đại diện</label>
                                                <input type="file" class="form-control-file img-load-input border @error('avatar_path')
                                                is-invalid
                                                @enderror" id="" name="avatar_path">
                                            </div>
                                            @error('avatar_path')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 200px;object-fit:cover;">
                                        </div>
                                        <div class="wrap-load-image mb-3">
                                            <div class="form-group">
                                                <label for="">Ảnh liên quan</label>
                                                <input type="file" class="form-control-file img-load-input border @error('image')
                                                    is-invalid
                                                    @enderror" id="" name="image[]" multiple>
                                            </div>
                                            @error('image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="load-multiple-img">
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                            </div>
                                         </div>

                                        <div class="row">
                                           <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Giá sỉ</label>
                                                    <input type="text"
                                                        class="form-control @error('price') is-invalid @enderror"
                                                        id="price_display"
                                                        value="{{ old('price') }}"
                                                        placeholder="Nhập giá hiển thị">

                                                    {{-- input ẩn để gửi lên server --}}
                                                    <input type="hidden" name="price" id="price" value="{{ old('price') }}">
                                                </div>

                                                @error('price')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Sale(%)</label>
                                                    <input type="number" class="form-control @error('sale')
                                                        is-invalid
                                                        @enderror" id="" value="{{ old('sale') }}" name="sale" placeholder="Nhập %">
                                                </div>
                                                @error('sale')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
    <div class="form-group">
        <label for="">Lợi nhuận</label>
        <input type="text" class="form-control format-number" id="loi_nhuan_display"
            value="" placeholder="Nhập lợi nhuận">

        <!-- Input ẩn để gửi lên database -->
        <input type="hidden" name="loi_nhuan" id="loi_nhuan" value="{{ old('loi_nhuan') }}">
    </div>

    @error('loi_nhuan')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>


                                        </div>
                                        <div class="row">
    <!-- Cột trái -->
    <div class="col-md-6">
        <div class="card shadow-sm p-3 mb-3">
            <h6 class="text-primary mb-3"><i class="fas fa-tags"></i> Loại sản phẩm</h6>

            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input single-check @error('sp_khoi_nghiep') is-invalid @enderror" 
                    value="1" name="sp_khoi_nghiep" id="sp_khoi_nghiep"
                    @if(old('sp_khoi_nghiep')==="1") checked @endif>
                <label class="form-check-label" for="sp_khoi_nghiep">SP Khởi nghiệp</label>
                @error('sp_khoi_nghiep')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input single-check @error('is_tinh_diem') is-invalid @enderror"
                    value="1" name="is_tinh_diem" checked id="is_tinh_diem"
                    @if(old('is_tinh_diem')==="1") checked @endif>
                <label class="form-check-label" for="is_tinh_diem">SP Tiêu dùng</label>
                @error('is_tinh_diem')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
             {{--<div class="form-check mb-2">
                <input type="checkbox" class="form-check-input @error('sp_tieu_dung') is-invalid @enderror"
                    value="1" name="sp_tieu_dung" id="sp_tieu_dung"
                    @if(old('sp_tieu_dung')==="1") checked @endif>
                <label class="form-check-label" for="sp_tieu_dung">SP Tiêu dùng</label>
                @error('sp_tieu_dung')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input @error('hot') is-invalid @enderror"
                    value="1" name="hot" id="hot"
                    @if(old('hot')==="1") checked @endif>
                <label class="form-check-label" for="hot">Sản phẩm giá sỉ</label>
                @error('hot')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input @error('gio_vang') is-invalid @enderror"
                    value="1" name="gio_vang" id="gio_vang"
                    @if(old('gio_vang')==="1") checked @endif>
                <label class="form-check-label" for="gio_vang">Hiện sản phẩm Giờ vàng</label>
                @error('gio_vang')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div> --}}
        </div>
    </div>

    <!-- Cột phải -->
    <div class="col-md-6">
        <div class="card shadow-sm p-3 mb-3">
            <h6 class="text-success mb-3"><i class="fas fa-cog"></i> Tùy chọn khác</h6>

            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input @error('het_hang') is-invalid @enderror"
                    value="1" name="het_hang" id="het_hang"
                    @if(old('het_hang')==="1") checked @endif>
                <label class="form-check-label" for="het_hang">Hết hàng</label>
                @error('het_hang')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

           

            {{-- <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input @error('khong_tich_luy_ds') is-invalid @enderror"
                    value="1" name="khong_tich_luy_ds" id="khong_tich_luy_ds"
                    @if(old('khong_tich_luy_ds')==="1") checked @endif>
                <label class="form-check-label" for="khong_tich_luy_ds">Không tích lũy doanh số</label>
                @error('khong_tich_luy_ds')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div> --}}
        </div>
    </div>
</div>

                                        <div class="form-group">
                                            <label class="control-label" for="">Số thứ tự</label>
                                            <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror" value="{{ old('order') }}" name="order" placeholder="Nhập số thứ tự">
                                            @error('order')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group">
                                        <label for="">Number</label>
                                        <input type="text" class="form-control" id="" value="{{ old('number') }}" name="number" placeholder="Nhập number">
                                        </div>
                                        @error('number')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror --}}
										<div class="form-group">
                                            <label for="">Chọn danh mục sản phẩm</label>
                                            <select class="form-control custom-select select-2-init @error('category_id')
                                                is-invalid
                                                @enderror" id="" value="{{ old('category_id') }}" name="category_id">
                                                {{-- <option value="0">Chọn danh mục cha</option> --}}
                                                <option value="">--- Chọn danh mục ---</option>
                                                {!!$option!!}
                                            </select>
                                        </div>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==="1" ||old('active')===null) {{'checked'}} @endif>Hiện
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" ){{'checked'}} @endif name="active">Ẩn
                                                </label>
                                            </div>
                                        </div>
                                        @error('active')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        {{--<div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="">
                                            <label class="form-check-label" for="" required>Tôi đồng ý</label>
                                        </div>--}}
                                        @error('checkrobot')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                            <button type="reset" class="btn btn-danger">Làm lại</button>
                                        </div>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
<script>
$(document).ready(function() {
    // Khi người dùng nhập vào ô hiển thị
    $('#price_display').on('input', function() {
        // Lấy chỉ số (loại bỏ dấu phẩy, ký tự khác)
        let rawValue = $(this).val().replace(/[^0-9]/g, '');

        // Format lại có dấu phẩy cho người xem
        if (rawValue) {
            let formatted = parseInt(rawValue, 10).toLocaleString('vi-VN');
            $(this).val(formatted);
        } else {
            $(this).val('');
        }

        // Gán giá trị thô (không dấu phẩy) vào input ẩn
        $('#price').val(rawValue);
    });

    // Nếu load lại form có old value thì format sẵn
    let oldVal = $('#price').val();
    if (oldVal) {
        $('#price_display').val(parseInt(oldVal, 10).toLocaleString('vi-VN'));
    }
});
</script>
<script>
$(document).ready(function() {
    // Hàm định dạng số có dấu chấm
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Khi người dùng nhập liệu
    $('#loi_nhuan_display').on('input', function() {
        // Lấy giá trị không có ký tự nào ngoài số
        let rawValue = $(this).val().replace(/\D/g, '');

        // Hiển thị lại input có dấu chấm
        $(this).val(formatNumber(rawValue));

        // Gán vào input ẩn (giá trị thật để lưu DB)
        $('#loi_nhuan').val(rawValue);
    });
});
</script>
<script>
$(document).ready(function() {
    $('.single-check').on('change', function() {
        if ($(this).is(':checked')) {
            // Bỏ chọn các checkbox khác cùng class
            $('.single-check').not(this).prop('checked', false);
        }
    });
});
</script>

@endsection
