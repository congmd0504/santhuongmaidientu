@extends('admin.layouts.main')
@section('title',"Sửa danh mục sản phẩm")
@section('css')

@endsection

@section('content')

<div class="content-wrapper lb_template_categoryproduct_edit">
    @include('admin.partials.content-header',['name'=>"Danh mục sản phẩm","key"=>"Sửa danh mục sản phẩm"])

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
                    <form action="{{route('admin.categoryproduct.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
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
                                            <input type="text" class="form-control" id="name" value="{{ $data->name }}" name="name" placeholder="Nhập tên danh mục sản phẩm" required="required">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">slug</label>
                                            <input type="text" class="form-control" id="slug" value="{{ $data->slug }}" name="slug" placeholder="Nhập slug" required="required">
                                        </div>
                                        @error('slug')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Nhập mô tả</label>
                                            <textarea class="form-control" name="description" id="" rows="4" placeholder="Nhập mô tả">{{ $data->description }}</textarea>
                                        </div>
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập content</label>
                                            <textarea class="form-control tinymce_editor_init" name="content" id="content" rows="7" placeholder="Nhập content">{{ $data->content }}</textarea>
                                        </div>
                                        @error('content')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Chọn danh mục cha</label>
                                            <select class="form-control custom-select" id="" name="parentId">
                                                <option value="0">Chọn danh mục cha</option>
                                                {!!$option!!}
                                            </select>
                                        </div>
                                        @error('parentId')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="">Số thứ
                                                    tự</label>
                                                <div class="col-sm-12">
                                                    <input type="number" min="0"
                                                        class="form-control  @error('order') is-invalid  @enderror"
                                                        value="{{ old('order') ?? $data->order }}"
                                                        name="order" placeholder="Nhập số thứ tự">
                                                </div>
                                                @error('order')
                                                    <div class="invalid-feedback d-block">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="active" @if( $data->active=="1"||old('active')==="1") {{'checked'}} @endif
                                                    >
                                                    Active
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if( $data->active==="0"||old('active')==="0"){{'checked'}} @endif
                                                    name="active"
                                                    >
                                                    Disable
                                                </label>
                                            </div>
                                        </div>
                                        @error('active')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        {{--<div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="">
                                            <label class="form-check-label" for="" required="required">Check me out</label>
                                        </div>--}}
                                        @error('checkrobot')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="submit" class="btn btn-primary">Chấp nhận</button>
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
                                                <label for="">icon</label>
                                                <input type="file" class="form-control-file img-load-input border" id="" value="" name="icon_path">
                                            </div>
                                            @error('icon_path')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <img src="{{asset($data->icon_path)}}" alt="{{$data->name}}" class="img-load border p-1 w-30" style="height: 80px;object-fit:contain;">
                                        </div>
                                        <div class="wrap-load-image">
                                            <div class="form-group">
                                                <label for="">avatar</label>
                                                <input type="file" class="form-control-file img-load-input" id="" value="" name="avatar_path">
                                            </div>
                                            @error('avatar_path')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <img src="{{asset($data->avatar_path)}}" alt="{{$data->name}}" class="img-load border p-1 w-100" style="height: 200px;object-fit:cover;">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Nhập description_seo</label>
                                            <input type="text" class="form-control" id="" value="{{ $data->description_seo }}" name="description_seo" placeholder="Nhập description_seo">
                                        </div>
                                        @error('description_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Nhập title_seo</label>
                                            <input type="text" class="form-control" id="" value="{{ $data->title_seo }}" name="title_seo" placeholder="Nhập title_seo">
                                        </div>
                                        @error('title_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

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
