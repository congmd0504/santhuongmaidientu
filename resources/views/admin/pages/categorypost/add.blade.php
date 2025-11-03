@extends('admin.layouts.main')
@section('title',"Thêm danh mục bài viết")
@section('content')


<div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>"Category post","key"=>"Thêm danh mục bài viết"])
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
                    <form action="{{route('admin.categorypost.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                    <h3 class="card-title">Thông tin danh mục bài viết</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <label for="">Tên danh mục</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên danh mục">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">slug</label>
                                            <input type="text" class="form-control" id="slug" value="{{ old('slug') }}" name="slug" placeholder="Nhập slug">
                                        </div>
                                        @error('slug')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
										<div class="form-group">
                                            <label for="">Nhập title Seo</label>
                                            <input type="text" class="form-control @error('title_seo') is-invalid @enderror" id="" value="{{ old('title_seo') }}" name="title_seo" placeholder="Nhập title Seo">
                                         </div>
                                         @error('title_seo')
                                         <div class="alert alert-danger">{{ $message }}</div>
                                         @enderror
                                         <div class="form-group">
                                            <label for="">Nhập mô tả Seo</label>
                                            <input type="text" class="form-control @error('description_seo') is-invalid @enderror" id="" value="{{ old('description_seo') }}" name="description_seo" placeholder="Nhập description_seo">
                                         </div>
                                         @error('description_seo')
                                         <div class="alert alert-danger">{{ $message }}</div>
                                         @enderror

                                        <div class="form-group">
                                            <label for="">Nhập giới thiệu</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="" rows="3" value="" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                                         </div>
                                         @error('description')
                                         <div class="alert alert-danger">{{ $message }}</div>
                                         @enderror
                                         <div class="form-group">
                                            <label for="">Nhập Nội dung</label>
                                            <textarea class="form-control tinymce_editor_init @error('content') is-invalid  @enderror" name="content" id="content" rows="6" value="" placeholder="Nhập nội dung">
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
                                        <div class="wrap-load-image mb-3">
                                            <div class="form-group">
                                                <label for="">icon</label>
                                                <input  type="file" class="form-control-file img-load-input  border" id="" value="" name="icon_path" >
                                            </div>
                                            @error('icon_path')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <img class="img-load border p-1 w-40" src="{{asset('admin_asset/images/upload-image.png')}}" alt="no image" style="height: 80px;object-fit:cover;">
                                        </div>
                                        <div class="wrap-load-image mb-3">
                                            <div class="form-group">
                                                <label for="">avatar</label>
                                                <input type="file" class="form-control-file img-load-input" id="" value="" name="avatar_path">
                                            </div>
                                            @error('avatar_path')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" alt="no image" style="height: 170px;object-fit:cover;">
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
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==="1" ||old('active')===null){{'checked'}} @endif>
                                                    Hiển thị
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" ) {{'checked'}} @endif name="active">
                                                    Ẩn đi
                                                </label>
                                            </div>
                                        </div>
                                        @error('active')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        {{--<div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="" required="required">
                                            <label class="form-check-label" for="">Tôi đồng ý</label>
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@endsection
@section('js')
@endsection
