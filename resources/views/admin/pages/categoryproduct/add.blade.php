@extends('admin.layouts.main')
@section('title',"Thêm danh mục sản phẩm")
@section('content')


  <div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Danh mục sản phẩm","key"=>"Thêm danh mục sản phẩm"])

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              @if(session("alert"))
              <div class="alert alert-success">
                  {{session("alert")}}
              </div>
              @elseif(session('error'))
              <div class="alert alert-warning">
                  {{session("error")}}
              </div>
              @endif
              <form action="{{route('admin.categoryproduct.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Thông tin danh mục sản phẩm</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <div class="form-group">
                                        <label for="">Tên danh mục</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            value="{{ old('name') }}"
                                            name="name"
                                            placeholder="Nhập tên danh mục"
                                            required="required"
                                        >
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">slug</label>
                                        <input
                                            type="text"
                                            class="form-control lb_load_slug"
                                            id="slug"
                                            value="{{ old('slug') }}"
                                            name="slug"
                                            placeholder="Nhập slug"
                                            required="required"
                                        >
                                    </div>
                                    @error('slug')
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
                                        <label for="">Nhập mô tả seo</label>
                                        <input type="text" class="form-control @error('description_seo') is-invalid @enderror" id="" value="{{ old('description_seo') }}" name="description_seo" placeholder="Nhập mô tả seo">
                                    </div>
                                    @error('description_seo')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">
                                        <label for="">Nhập giới thiệu</label>
                                        <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="" rows="3"  placeholder="Nhập mô tả">{{ old('description') }}</textarea>
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

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Thông tin khác</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <!--<div class="wrap-load-image mb-3">
                                        <div class="form-group">
                                            <label for="">icon</label>
                                            <input type="file" class="form-control-file img-load-input  border"  id="" value="" name="icon_path" >
                                        </div>
                                        @error('icon_path')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <img class="img-load border p-1 w-40 " src="{{asset('admin_asset/images/upload-image.png')}}" alt="" style="height: 80px;object-fit:contain;">
                                    </div>-->
                                    <div class="wrap-load-image mb-3">
                                        <div class="form-group">
                                            <label for="">Ảnh đại diện</label>
                                            <input type="file" class="form-control-file img-load-input border"  id="" value="" name="avatar_path" >
                                        </div>
                                        @error('avatar_path')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <img class="img-load p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" alt="" style="height: 170px;object-fit:cover;">
                                    </div>
									
                                    <div class="form-group">
                                        <label for="">Chọn danh mục cha</label>
                                        <select class="form-control custom-select" id="" value="{{ old('parentId') }}" name="parentId">
                                            <option value="0">Chọn danh mục cha</option>
                                            {!!$option!!}
                                        </select>
                                    </div>
                                    @error('parentId')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                            <label  for="">Số thứ
                                                tự</label>
                                            <div class="">
                                                <input type="number" min="0"
                                                    class="form-control  @error('order') is-invalid  @enderror"
                                                    value="{{ old('order') }}" name="order"
                                                    placeholder="Nhập số thứ tự">
                                            </div>
                                            @error('order')
                                                <div class="invalid-feedback d-block">{{ $message }}
                                                </div>
                                            @enderror
                                        
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==="1"||old('active')===null){{'checked'}}  @endif >
                                                Hiện
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="0" @if(old('active')==="0") {{'checked'}}  @endif name="active" >
                                                Ản
                                            </label>
                                        </div>
                                    </div>
                                    @error('active')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    {{--<div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="checkrobot" id=""  required="required">
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

@endsection
