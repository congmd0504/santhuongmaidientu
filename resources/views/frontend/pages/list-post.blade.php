@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? 'Danh sách bài đăng')
@section('keywords', $seo['keywords'] ?? 'Danh sách bài đăng')
@section('description', $seo['description'] ?? 'Danh sách bài đăng')
@section('abstract', $seo['abstract'] ?? 'Danh sách bài đăng')
@section('image', $seo['image'] ?? '')
@section('css')
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet" />

    <style>
        .wrap-load-image .form-group {
            margin: 0;
        }

        td.white-space-nowrap a {
            width: 30px;
        }

        .btn-info {
            border: solid 1px #009846;
            background: #009846;
            padding: 4px 8px;
        }

        .hien4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            overflow: hidden;
            -webkit-box-orient: vertical;
        }

        .page-item.active .page-link {
            z-index: 0;
            color: #fff;
            background-color: #c4151c;
            border-color: #c4151c;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c4151c;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .notification {
            animation: hide 5s forwards;
            /* Áp dụng animation với tên hide và thời gian 5s */
        }

        @keyframes hide {
            to {
                opacity: 0;
                /* Kết thúc animation với opacity = 0 */
                visibility: hidden;
                /* Ẩn phần tử */
            }
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Danh sách bài đăng
                                            @if (session('alert'))
                                                <span class="notification">({{ session('alert') }})</span>
                                            @endif
                                            @if (session('error'))
                                                <span class="notification">({{ session('error') }})</span>
                                            @endif
                                        </h3>
                                    </div>
                                    <div class="card-body table-responsive p-3" style="padding:0 !important">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card-body table-responsive p-0 lb-list-category">
                                                    <table class="table table-head-fixed" style="font-size:13px;">
                                                        <thead>
                                                            <tr>
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Tên bài viết</th>
                                                                <th class="white-space-nowrap">Giới thiệu</th>
                                                                <th class="white-space-nowrap">Ảnh</th>
                                                                <th class="white-space-nowrap">Hành động</th>
                                                            </tr>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data as $postItem)
                                                                <tr>
                                                                    <td>{{ $loop->index + 1 }}</td>
                                                                    <td>{{ $postItem->name }}</td>
                                                                    <td class="hien4" style="width:330px">
                                                                        {{ $postItem->description }}
                                                                    </td>
                                                                    <td><img src="{{ asset($postItem->avatar_path) }}"
                                                                            alt="{{ $postItem->name }}"
                                                                            style="width:80px; height:80px; border-radius:50%">
                                                                    </td>

                                                                    <td class="white-space-nowrap">
                                                                        <a href="{{ route('post.edit', ['id' => $postItem->id]) }}"
                                                                            class="btn btn-sm btn-info"><i
                                                                                class="fas fa-edit"></i></a>
                                                                        <a data-url="{{ route('post.destroy', ['id' => $postItem->id]) }}"
                                                                            class="btn btn-sm btn-danger lb_delete"><i
                                                                                class="far fa-trash-alt"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                {{ $data->appends(request()->all())->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin_asset/js/main.js') }}"></script>
    <script src="{{ asset('admin_asset/js/function.js') }}"></script>
    <script src="{{ asset('admin_asset/ajax/deleteAdminAjax.js') }}"></script>


@endsection
