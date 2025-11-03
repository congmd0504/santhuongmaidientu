@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? 'Đăng tin')
@section('keywords', $seo['keywords'] ?? 'Đăng tin')
@section('description', $seo['description'] ?? 'Đăng tin')
@section('abstract', $seo['abstract'] ?? 'Đăng tin')
@section('image', $seo['image'] ?? '')
@section('css')
    <style>
        .wrap-load-image .form-group {
            margin: 0;
        }

        .none {
            display: none;
        }

        @media(max-width:550px) {
            div#sidebar-profile {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="wrap-content-main">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Thông tin bài đăng</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3" style="padding:0 !important">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Tên bài đăng</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" placeholder="Nhập tên bài đăng...">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 none">
                                                    <div class="form-group">
                                                        <label for="">Slug</label>
                                                        <input type="text" class="form-control" id="slug"
                                                            name="slug" placeholder="Nhập slug...">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="wrap-load-image mb-3">
                                                        <div class="form-group">
                                                            <label for="">Ảnh đại diện</label>
                                                            <input type="file"
                                                                class="form-control-file img-load-input border"
                                                                id="clickImage" name="avatar_path" style="display:none;">
                                                        </div>
                                                        <img onclick="$('#clickImage').click();"
                                                            class="img-load border p-1 w-100"
                                                            src="{{ asset('admin_asset/images/username.png') }}"
                                                            alt=""
                                                            style="height: auto;width:auto;max-width:150px;object-fit:cover;">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label for="">Nhập nội dung</label>
                                                        <textarea name="description" class="form-control" cols="30" rows="10" style="height:120px;"
                                                            placeholder="Nhập nội dung..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 none" style="padding:0 15px !important">
                                                    <div class="form-group">
                                                        <label for="">Nhập nội dung</label>
                                                        <textarea name="content" class="form-control" cols="30" rows="10"
                                                            placeholder="Nhập nội dung..."></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="active" value="1">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="hidden" name="category_id" value="29">
                                                <input type="hidden" name="slug" id="slugNew" value="">
                                                <input type="hidden" name="title_seo" id="title_seo" value="">
                                                <input type="hidden" name="description_seo" id="description_seo"
                                                    value="">
                                                <div class="col-md-12" style="padding:0 15px !important">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                                        <button type="reset" onclick="window.location.reload()"
                                                            class="btn btn-danger">Làm lại</button>
                                                    </div>
                                                </div>
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
        document.getElementById('name').addEventListener('keyup', function() {
            var name = this.value;
            var slug = slugify(name);
            // document.getElementById('slug').value = slug;
            document.getElementById('slugNew').value = slug;
            document.getElementById('title_seo').value = name;
            document.getElementById('description_seo').value = name;
        });

        function slugify(str) {
            // Loại bỏ dấu tiếng Việt
            var from = "àáảãạăằắẳẵặâầấẩẫậèéẻẽẹêềếểễệìíỉĩịòóỏõọôồốổỗộơờớởỡợùúủũụưừứửữựỳýỷỹỵđ";
            var to = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            // Loại bỏ các ký tự không phải chữ cái, số hoặc dấu gạch ngang
            str = str.toLowerCase().trim().replace(/[^a-z0-9 -]/g, '');

            // Thay thế các khoảng trắng bằng dấu gạch ngang
            str = str.replace(/\s+/g, '-');

            // Loại bỏ các dấu gạch ngang liên tiếp
            str = str.replace(/-+/g, '-');

            return str;
        }
    </script>
    <script src="https://cdn.tiny.cloud/1/b2vtb365nn7gj3ia522w5v4dm1wcz2miw5agwj55cejtlox1/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        let editor_config = {
            path_absolute: "/",
            selector: 'textarea.tinymce_editor_init',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            rel_list: [{
                    title: 'None',
                    value: ''
                },
                {
                    title: 'Nofollow',
                    value: 'nofollow'
                },
                {
                    title: 'Noopener',
                    value: 'noopener noreferrer'
                }
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback: function(callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                let y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                let cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };
        if ($("textarea.tinymce_editor_init").length) {
            tinymce.init(editor_config);
        }
    </script>
    <script>
        $(function() {
            // js load image khi upload
            $(document).on('change', '.img-load-input', function() {
                let input = $(this);
                displayImage(input, '.wrap-load-image', '.img-load');
            });

            function displayImage(input, selectorWrap, selectorImg) {
                let img = input.parents(selectorWrap).find(selectorImg);
                let file = input.prop('files')[0];
                let reader = new FileReader();

                reader.addEventListener("load", function() {
                    // convert image file to base64 string
                    img.attr('src', reader.result);
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
@endsection
