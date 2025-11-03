@extends('admin.layouts.main')
@section('title',"Sửa  danh mục bài viết")
@section('css')

@endsection

@section('content')

<div class="content-wrapper lb_template_categorypost_edit">
    @include('admin.partials.content-header',['name'=>"Danh mục bài viết","key"=>"Sửa danh mục bài viết"])

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
                    <form action="{{route('admin.categorypost.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin danh mục sản phẩm</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <label for="">Tên danh mục tin tức</label>
                                            <input type="text" class="form-control name" id="name" value="{{ $data->name }}" name="name" placeholder="Nhập tên danh mục tin tức" required="required">
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
                                            <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="" rows="3" value="" placeholder="Nhập mô tả">{{ $data->description }}</textarea>
                                        </div>
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Nhập content</label>
                                            <textarea class="form-control tinymce_editor_init @error('content') is-invalid  @enderror" name="content" id="content" rows="6" value="" placeholder="Nhập content">
                                            {{ $data->content }}
                                            </textarea>
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
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="active" @if( $data->active=="1"||old('active')=="1") {{'checked'}} @endif
                                                    >
                                                    Active
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if( $data->active=="0"||old('active')=="0"){{'checked'}} @endif
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
                                            <img class="img-load border p-1 w-30" src="{{asset($data->icon_path)}}" alt="{{$data->name}}" style="height: 80px;object-fit:contain;">
                                        </div>

                                        <div class="wrap-load-image">
                                            <div class="form-group">
                                                <label for="">avatar</label>
                                                <input type="file" class="form-control-file img-load-input" id="" value="" name="avatar_path">
                                            </div>
                                            @error('avatar_path')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <img class="img-load border p-1 w-100" src="{{asset($data->avatar_path)}}" alt="{{$data->name}}" style="height: 200px;object-fit:cover;">
                                        </div>


                                        <div class="form-group">
                                            <label for="">Nhập title_seo</label>
                                            <input type="text" class="form-control @error('title_seo') is-invalid @enderror" id="" value="{{ $data->title_seo }}" name="title_seo" placeholder="Nhập title_seo">
                                        </div>
                                        @error('title_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập description_seo</label>
                                            <input type="text" class="form-control @error('description_seo') is-invalid @enderror" id="" value="{{ $data->description_seo }}" name="description_seo" placeholder="Nhập description_seo">
                                        </div>
                                        @error('description_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

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
<script>
    $(document).on('change', '.img-load-input',function(){
        let input=$(this);
        displayImage(input,'.wrap-load-image','.img-load');
    });
    $(document).on('change keyup', '#name',function(){
        let name=$(this).val();
        $('#slug').val(ChangeToSlug(name));
    });

    // function display image when upload file
    // paramter selectorWrap slector thẻ bọc của image và input
    // paramter selectorImg slector thẻ bọc của image
    function displayImage(input,selectorWrap,selectorImg) {
        let img= input.parents(selectorWrap).find(selectorImg);
        let  file = input.prop('files')[0];
        let reader = new FileReader();

        reader.addEventListener("load", function () {
            // convert image file to base64 string
            img.attr('src',reader.result);
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    // function convert slug
    function ChangeToSlug(title)
    {
       // title = document.getElementById("title").value;
        //Đổi chữ hoa thành chữ thường
        let slug = title.toLowerCase();
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        return slug;
    }
</script>
@endsection
