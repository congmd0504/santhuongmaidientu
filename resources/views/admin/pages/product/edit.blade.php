@extends('admin.layouts.main')
@section('title', 'Sửa sản phẩm')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper lb_template_product_edit">
        @include('admin.partials.content-header', ['name' => 'Sản phẩm', 'key' => 'Sửa sản phẩm'])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('alert'))
                            <div class="alert alert-success">
                                {{ session('alert') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.product.update', ['id' => $data->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Thông tin sản phẩm</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group">
                                                <label for="">Mã sản phẩm</label>
                                                <input type="text" class="form-control" id="masp"
                                                    value="{{ $data->masp }}" name="masp"
                                                    placeholder="Nhập mã sản phẩm">
                                                @error('masp')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tên sản phẩm</label>
                                                <input type="text" class="form-control" id="name"
                                                    value="{{ $data->name }}" name="name"
                                                    placeholder="Nhập tên sản phẩm">
                                                @error('name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">slug</label>
                                                <input type="text" class="form-control" id="slug"
                                                    value="{{ $data->slug }}" name="slug" placeholder="Nhập slug">
                                            </div>
                                            @error('slug')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="form-group">
                                                <label for="">Thời gian bảo hành (tháng)</label>
                                                <input type="text" class="form-control" id=""
                                                    value="{{ $data->warranty }}" name="warranty"
                                                    placeholder="Nhập warranty">
                                            </div>
                                            @error('warranty')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="form-group">
                                                <label for="">Nhập mô tả seo</label>
                                                <input type="text" class="form-control" id=""
                                                    value="{{ $data->description_seo }}" name="description_seo"
                                                    placeholder="Nhập mô tả seo">
                                            </div>
                                            @error('description_seo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="form-group">
                                                <label for="">Nhập title seo</label>
                                                <input type="text" class="form-control" id=""
                                                    value="{{ $data->title_seo }}" name="title_seo"
                                                    placeholder="Nhập title seo">
                                            </div>
                                            @error('title_seo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="">Nhập giới thiệu</label>
                                                <textarea class="form-control" name="description" id="" rows="4" placeholder="Nhập giới thiệu">{{ $data->description }}</textarea>
                                            </div>
                                            @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="">Nhập nội dung</label>
                                                <textarea class="form-control tinymce_editor_init" name="content" id="content" rows="7"
                                                    placeholder="Nhập nội dung">{{ $data->content }}</textarea>
                                            </div>
                                            @error('content')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="form-group">
                                                <label for="">Nhập tags</label>
                                                <select class="form-control tag-select-choose" multiple="multiple"
                                                    name="tags[]">
                                                    @foreach ($data->tags as $tagItem)
                                                        <option value="{{ $tagItem->name }}" selected>{{ $tagItem->name }}
                                                        </option>
                                                    @endforeach
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
                                                    <input type="file" class="form-control-file img-load-input border"
                                                        id="" name="avatar_path">
                                                </div>
                                                @error('avatar_path')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                @if ($data->avatar_path)
                                                    <img class="img-load border p-1 w-100" src="{{ $data->avatar_path }}" alt="{{ $data->name }}" style="height: 200px;object-fit:cover;">
                                                    <a class="btn btn-sm btn-danger deleteAvatarProductDB"
                                                       data-url="{{ route('admin.product.delete_avatar_path', ['id' => $data->id]) }}"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="wrap-load-image mb-3">
                                                <div class="form-group">
                                                    <label for="">Hình ảnh khác</label>
                                                    <input type="file" class="form-control-file img-load-input border"
                                                        id="" name="image[]" multiple>
                                                </div>
                                                @error('image')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="load-multiple-img">
                                                    @foreach ($data->images()->get() as $productImageItem)
                                                        <img class="" src="{{ $productImageItem->image_path }}" alt="{{ $productImageItem->name }}">
                                                        <a class="btn btn-sm btn-danger lb_delete_image_new"
                                                           data-id="{{ $productImageItem->id }}"
                                                           data-url="{{ route('admin.product.destroy-image', ['id' => $productImageItem->id]) }}">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    @endforeach
                                                    @if (!$data->images()->get()->count())
                                                        <img class=""
                                                            src="{{ asset('admin_asset/images/upload-image.png') }}"
                                                            alt="'no image">
                                                        <img class=""
                                                            src="{{ asset('admin_asset/images/upload-image.png') }}"
                                                            alt="'no image">
                                                        <img class=""
                                                            src="{{ asset('admin_asset/images/upload-image.png') }}"
                                                            alt="'no image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                   <div class="form-group">
                                                            <label for="">Giá sỉ</label>
                                                            <input type="text"
                                                                class="form-control @error('price') is-invalid @enderror"
                                                                id="price_display"
                                                                value="{{ old('price') ?? $data->price }}"
                                                                placeholder="Nhập giá hiển thị">

                                                            {{-- input ẩn để gửi lên server --}}
                                                            <input type="hidden" name="price" id="price" value="{{ old('price') ?? $data->price }}">
                                                        </div>

                                                        @error('price')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Sale(%)</label>
                                                        <input type="number" class="form-control" id=""
                                                            value="{{ $data->sale }}" name="sale"
                                                            placeholder="Nhập %">
                                                    </div>
                                                    @error('sale')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Phần trăm điểm KTG(%)</label>
                                                        <input type="number" class="form-control" id=""
                                                            value="{{ $data->phantramdiem }}" name="phantramdiem"
                                                            min="0" max="100" placeholder="Nhập %">
                                                    </div>
                                                    @error('phantramdiem')
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
                                                        <input type="checkbox" class="form-check-input @error('sp_khoi_nghiep') is-invalid @enderror"
                                                            id="sp_khoi_nghiep" name="sp_khoi_nghiep" value="1"
                                                            @if ($data->sp_khoi_nghiep === 1) checked @endif>
                                                        <label class="form-check-label" for="sp_khoi_nghiep">SP Khởi nghiệp</label>
                                                        @error('sp_khoi_nghiep')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input @error('is_tinh_diem') is-invalid @enderror"
                                                            id="is_tinh_diem" name="is_tinh_diem" value="1"
                                                            @if ($data->is_tinh_diem === 1) checked @endif>
                                                        <label class="form-check-label" for="is_tinh_diem">SP Tiêu dùng</label>
                                                        @error('is_tinh_diem')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                      {{--<div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input @error('is_tinh_diem') is-invalid @enderror"
                                                            id="is_tinh_diem" name="is_tinh_diem" value="1"
                                                            @if ($data->is_tinh_diem === 1) checked @endif>
                                                        <label class="form-check-label" for="is_tinh_diem">Sản phẩm giá sỉ</label>
                                                        @error('is_tinh_diem')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                     <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input @error('hot') is-invalid @enderror"
                                                            id="hot" name="hot" value="1"
                                                            @if ($data->hot === 1) checked @endif>
                                                        <label class="form-check-label" for="hot">Sản phẩm giá sỉ</label>
                                                        @error('hot')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input @error('gio_vang') is-invalid @enderror"
                                                            id="gio_vang" name="gio_vang" value="1"
                                                            @if ($data->gio_vang === 1) checked @endif>
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
                                                            id="het_hang" name="het_hang" value="1"
                                                            @if ($data->het_hang === 1) checked @endif>
                                                        <label class="form-check-label" for="het_hang">Hết hàng</label>
                                                        @error('het_hang')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                  

                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input @error('khong_tich_luy_ds') is-invalid @enderror"
                                                            id="khong_tich_luy_ds" name="khong_tich_luy_ds" value="1"
                                                            @if ($data->khong_tich_luy_ds === 1) checked @endif>
                                                        <label class="form-check-label" for="khong_tich_luy_ds">Không tích lũy doanh số</label>
                                                        @error('khong_tich_luy_ds')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="form-group">
                                                <label for="">Chọn danh muc sản phẩm</label>
                                                <select class="form-control custom-select select-2-init" id=""
                                                    name="category_id">
                                                    {{-- <option value="0">Chọn danh mục cha</option> --}}
                                                    <option value="">Chọn danh mục</option>
                                                    {!! $option !!}
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label" for="">Số thứ tự</label>
                                                <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order')??$data->order }}" name="order" placeholder="Nhập số thứ tự">
                                                @error('order')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="1"
                                                            name="active"
                                                            @if ($data->active == '1' || old('active') == '1') {{ 'checked' }} @endif>Hiện
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="0"
                                                            @if ($data->active == '0' || old('active') == '0') {{ 'checked' }} @endif
                                                            name="active">Ẩn
                                                    </label>
                                                </div>
                                            </div>
                                            @error('active')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            {{-- <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="">
                                            <label class="form-check-label" for="" required>Tôi đồng ý</label>
                                        </div> --}}
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
        $(document).on('click', '.deleteAvatarProductDB', function(e) {
            e.preventDefault();

            var imageId = $(this).data('id');
            var url = $(this).data('url');
            var imageElement = $(this).closest('div');

            if(confirm('Bạn có chắc chắn muốn xóa ảnh này không?')) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.code == 200) {
                            imageElement.remove();
                            alert('Đã xóa ảnh thành công');
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra, vui lòng thử lại!');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Không thể xóa ảnh, vui lòng thử lại!');
                    }
                });
            }
        });

        $(document).on('click', '.lb_delete_image_new', function(e) {
            e.preventDefault();

            var imageId = $(this).data('id');
            var url = $(this).data('url');
            var imageElement = $(this).closest('div');

            if(confirm('Bạn có chắc chắn muốn xóa ảnh này không?')) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.code == 200) {
                            imageElement.remove();
                            alert('Đã xóa ảnh thành công');
                        } else {
                            alert('Có lỗi xảy ra, vui lòng thử lại!');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Không thể xóa ảnh, vui lòng thử lại!');
                    }
                });
            }
        });
    </script>
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
@endsection
