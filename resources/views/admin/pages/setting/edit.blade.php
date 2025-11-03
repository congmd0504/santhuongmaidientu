@extends('admin.layouts.main')
@section('title', 'Thêm setting')
@section('content')
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Setting","key"=>"Sửa nội dung"])

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
                                {{session("error")}}
                            </div>
                        @endif
                        <form action="{{ route('admin.setting.update', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">

                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Thêm nội dung mới</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group">
                                                <label for="">Tên nội dung mới</label>
                                                <input type="text" class="form-control" id="name" value="{{ $data->name }}"
                                                    name="name" placeholder="Nhập nội dung mới">
                                            </div>
                                            @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="form-group">
                                                <label for="">Nội dung</label>
                                                <textarea
                                                    class="form-control @error('value') is-invalid @enderror"
                                                    name="value" id="" rows="3" value="" placeholder="Nhập nội dung">{{ $data->value }}</textarea>
                                            </div>
                                            @error('value')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="form-group">
                                                <label for="">Slug</label>
                                                <input type="text" class="form-control"  value="{{ $data->slug }}" name="slug"
                                                    placeholder="Nhập slug">
                                            </div>
                                            @error('slug')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="form-group">
                                                <label for="">Chọn danh mục cha</label>
                                                <select class="form-control custom-select" id=""  name="parentId">
                                                  <option value="0">Chọn danh mục cha</option>
                                                  {!!$option!!}
                                                </select>
                                              </div>
                                              @error('parentId')
                                              <div class="alert alert-danger">{{ $message }}</div>
                                              @enderror

                                            <div class="form-group">
                                                <label for="">Nhập mô tả</label>
                                                <textarea
                                                    class="form-control tinymce_editor_init @error('description') is-invalid @enderror"
                                                    name="description" id="description" rows="3" value="" placeholder="Nhập description">{{ $data->description }}
                                                </textarea>
                                            </div>
                                            @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="1" name="active" @if ($data->active == '1' || old('active') == '1')
                                                        {{ 'checked' }} @endif>Hiện
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="0" @if ($data->active == '0' || old('active') == '0'){{ 'checked' }}
                                                        @endif name="active">Ẩn
                                                    </label>
                                                </div>
                                            </div>
                                            @error('active')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            {{--<div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input" name="checkrobot" id="checkrobot">
                                                <label class="form-check-label" for="checkrobot" required>Tôi đồng ý</label>
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
                                <div class="col-md-4">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                           <h3 class="card-title">Thông tin khác</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="wrap-load-image mb-3">
                                                <div class="form-group">
                                                    <label for="">Image</label>
                                                    <input type="file" class="form-control-file img-load-input border" id="" value="" name="image_path">
                                                </div>
                                                @error('image_path')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <img class="img-load border p-1 w-100" src="{{asset($data->image_path)}}" alt="{{$data->name}}" style="object-fit:contain;">
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
