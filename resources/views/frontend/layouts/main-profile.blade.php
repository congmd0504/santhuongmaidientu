<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="vi" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="abstract" content="@yield('abstract')" />
    <meta name="ROBOTS" content="Metaflow" />
    <meta name="ROBOTS" content="noindex, nofollow, all" />
    <meta name="AUTHOR" content="Phan văn tân" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:image" content="@yield('image')" />
    <meta property="og:url" content="{{ makeLink('home') }}" />
    <link rel="canonical" href="{{ makeLink('home') }}" />
    <link rel="shortcut icon" href="../favicon.ico" />
    <!--
    <link rel="stylesheet" href="{linkhost}/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{linkhost}/css/lightbox.min.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/animate.css" type="text/css" />
    <link href="{linkhost}/css/slick.css" rel="stylesheet" />
    <link href="{linkhost}/css/slick-theme.css" rel="stylesheet" />
    <link rel="stylesheet" href="{linkhost}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    -->

    <!--
    <link rel="stylesheet" href="{linkhost}/css/stylesheet-2.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/header.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/footer.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/cart.css" type="text/css" />
    -->


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap-4.5.3-dist/css/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/wow/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/lightbox-plus/css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet.css') }}">


    @yield('css')
    <style>
        input[type='file'] {
            z-index: 10000;
            position: relative;
        }

        .footer {
            margin-top: 10px;
        }

        .pd-profile-2{
            gap:10px 10px;
        }

        .avatar {}

        .avatar h4 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: white;
        }
button.btn.btn-info.btn-coppy-link {
    margin-bottom: 10px;
}
        .avatar .media img {
            margin-top: 0;
        }

        .avatar .media {
            align-items: center;
        }

        .wrap-profile-container {
            background-color: #f4f6f9;
            padding: 30px 0;
        }

        #sidebar-profile nav .nav-item {

            border-bottom: 1px solid #e5e5e5;
        }

        #sidebar-profile nav .nav-item:last-child {
            border: unset;
        }

        .bg-left {
            background-color: #fff;
        }

        #sidebar-profile nav .nav-item .nav-link {

            overflow: hidden;
        }

        #sidebar-profile nav .nav-item .nav-link p {
            display: inline-block;
            margin: 0;
        }

        #sidebar-profile nav .nav-item .nav-link i {
            margin-right: 5px;
        }

        h1 {
            font-size: 25px;
            font-weight: bold;
            margin-top: 0;
        }

        .card-title {
            margin: 0;
        }

        .card-title h3 {
            margin: 0;
            font-size: 25px;
            font-weight: bold;
        }



        /* width */
        .hidden-scroll ::-webkit-scrollbar {
            width: 2px;
        }

        /* Track */
        .hidden-scroll ::-webkit-scrollbar-track {
            background: #f1f1f1;

        }

        /* Handle */
        .hidden-scroll ::-webkit-scrollbar-thumb {
            background: #888;

        }

        /* Handle on hover */
        .hidden-scroll ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .avatar a h4 {
            margin-bottom: 15px;
        }

        .level-user {
            padding: 10px;
            border-radius: 5px;
        }

        .sodu-mobile,
        .khampha-mobile {
            display: none;
        }

        .baner-profile-mobile {
            display: none;
        }

        .avatar .bgr-img-avatar {
            display: none;
        }

        @media(max-width:786px) {
button.btn.btn-info.btn-coppy-link {
    margin-bottom: 0px;
}
            .avatar .bgr-img-avatar {
                display: block;
                background-repeat: round;
            }

            .wrap-profile-container {}

            .bg-left {
                background-color: #fff0;
            }

            #sidebar-profile {
                padding-top: 10px !important;
            }

            .avatar a img {
                width: 100px !important;
            }

            .avatar h4 {
                font-size: 18px;
                text-transform: capitalize;
            }

            .background-color-white {
                background-color: white;
            }

            .sodu-mobile ul li,
            .khampha-mobile ul li {
                flex: 1;
            }

            .icon-profile {
                background-color: gainsboro;
                height: 40px;
                width: 40px;
                border-radius: 50%;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 5px;
                display: flex;
                justify-content: center;
            }

            .icon-profile i {
                margin-right: 0px !important;
                display: flex;
                justify-content: center;
                position: relative;
                color: white !important;
                display: flex;
                align-items: center;

            }

            .sodu-mobile,
            .khampha-mobile {
                padding: 20px 5px;
                border-radius: 10px;
            }

            #sidebar-profile nav .nav-item {

                border-bottom: 0px solid #e5e5e5;
            }

            .nav-link span,
            .nav-link p {
                font-size: 13px;
                display: block;
                margin-right: auto;
                margin-left: auto
            }

            .nav-link div {
                text-align: center;
            }

            .nav-link {
                display: block;
                padding: 0px;
            }

            .sodu-desktop {
                display: none;
            }

            .sodu-mobile,
            .khampha-mobile {
                display: block !important;
            }

            .title-sodu {
                display: flex;
                padding: 0px 10px;
                justify-content: space-between;
                margin-bottom: 10px;
            }

            .title-sodu h6 {
                font-size: 14px;
                color: gray;
                margin: 0px;
            }

            .title-sodu span {
                font-size: 14px;
            }

            .title-sodu span i {
                color: gray;
                font-weight: 600;
                margin-left: 5px;
            }

            /* .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl {
        width: 100%;
        padding-right: 0px !important;
        padding-left: 0px !important;
    } */
            .wrap-profile-container {
                padding: 0px;
            }

            .avatar {
                position: relative;
            }

            .item-avatar {
                padding: 30px 15px;
            }

            .pd-profile {
                padding: 0px 15px;
            }

            .baner-profile-mobile {
                display: block;
                margin-top: 10px
            }

            .pd-mobile {
                padding: 0px !important;
            }

            .alert {
                margin: 0px;
                -ms-flex: 1;
                flex: 1;
                -ms-flex-negative: 1;
                background-color: #5c96bc4d !important;
                border-color: #5c96bc4d !important;
                font-size: 100% !important;
            }

            .alert {
                padding: 5px 10px !important;
                display: flex;
            }

            .pd-profile-2 {
                padding: 10px 15px;
            }

            .display-flex {
                display: flex;
            }

            .color-icon-profile-1 {
                background: #78b4fc;
            }

            .color-icon-profile-2 {
                background: #f04438;
            }

            .color-icon-profile-3 {
                background: #ffba5b;
            }

            .color-icon-profile-4 {
                background: #fb7dba;
            }

            .color-icon-profile-5 {
                background: #9a8ff8;
            }

            .color-icon-profile-6 {
                background: #623fa3;
            }

            .taikhoan-dangnhap {
                display: none !important;
            }

            .name_account {
                color: white;
                font-size: 17px !important;
                font-weight: 600 !important;
            }

            .dropdown {
                list-style: none;
                margin-bottom: 10px;
            }

            #navbarDropdown {
                display: flex;
            }

            .pd-profile-2 {
                justify-content: left;
            }

            #navbarDropdown .icon_account {
                display: none !important;
            }

            #navbarDropdown .name_account {
                display: block !important;
            }

            .baner-profile-dektop {
                display: none !important;
            }

            .box-icon-profile {
                width: 40px;
                border: 1px solid #dfdfdf;
                padding: 8px;
                border-radius: 100%;
                -webkit-border-radius: 100%;
                -moz-border-radius: 100%;
                display: flex;
                justify-content: center;
                height: 40px;
                align-items: center;
            }

            .box-icon-profile i {
                color: rgb(72, 185, 65);
            }

            .box-tt-profile {
                display: flex;

            }

            .text-pro {
                display: flex;
                align-items: center;
                margin-left: 15px;
            }

            .text-pro a {
                line-height: 18px;
                font-weight: 500;
                font-size: 16px;
            }

            .box-tt-profile {
                margin-bottom: 10px;
            }

            .box-tt-profile:last-child {
                margin-bottom: 0px;
            }

            .level-user {
                background: rgb(250, 167, 184);
                background: linear-gradient(119deg, rgba(250, 167, 184, 1) 0%, rgba(251, 238, 230, 1) 100%);
            }

        }

        .box-avatar img {
            height: 100px;
            width: 100px;

        }

        a:focus,
        a:hover {
            color: #48b941 !important;
        }

        .baner-profile-dektop {
            display: block;
        }

        .level-user-left {
            text-align: left;
        }

        .level-user-left h5 a {
            font-size: 14px;
            font-weight: 500;
        }

        .level-user-left h5 a i {
            color: gray;
        }

        .level-user-left h5 {
            margin: 0px !important;
        }

        .level-user-left p {
            font-size: 12px;
            color: gray;
            margin-top: 5px;
        }

        .baner-profile-mobile a img {
            border-radius: 10px;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .alert-danger {
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
            width: 100%;
        }


        .lisst-btn-santm {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.lisst-btn-santm a {
    display: inline-block;
    padding: 7px 10px;
    background: #0449af;
}

.lisst-btn-santm a {
    width: calc(97% /2);
    border-radius: 5px;
    text-align: center;
    color: #fff;
}

a.btn-troly {
    background: #9f0f06;
}
a.btn-dow {
    background:green;
}
.lisst-btn-santm{
    display: none;
}
@media(max-width:990px){
    .lisst-btn-santm{
    display: flex;
}
}
        @media (max-width:550px) {
            .col-md-6.col-sm-12 {
                padding: 0;
            }

            .wrap-pay .col-md-12.col-sm-12 {
                padding: 0;
            }

            .wrap-pay .col-md-12.col-sm-12 .col-md-8 {
                padding: 0;
            }

            .col-md-12 {
                padding: 0;
            }
        }
    </style>
</head>

<body class="template-search">
<div class="wrapper home main">

    <!-- Navbar -->
@include('frontend.partials.header')
<!-- /.navbar -->
    <div class="wrap-profile-container">
        <div class="container">
            <div class="row">
                <div class="col-md-3 bg-left pd-mobile">
                    <div id="sidebar-profile" class="pt-3 ">
                        <div class="avatar text-center ">
                        @php
                            $downloadApp = App\Models\Setting::where('active', 1)->find(130);
                            @endphp
                            @php
                            $banner = App\Models\Setting::where('active', 1)->find(122);
                            @endphp
                            <div class="bgr-img-avatar"
                                 style="background-image: url({{$banner ? asset($banner->image_path) :'/public/frontend/images/banner_profile_new1.jpg'}})">
                                <div class="item-avatar">
                                    <div class="box-avatar">
                                        <a href="{{ route('profile.index') }}">
                                            <img src="{{ $user->avatar_path ? $user->avatar_path : $shareFrontend['userNoImage'] }}"
                                                 alt="{{ $user->name }}" class="mb-3 rounded-circle"
                                                 style="width:100px;">
                                            <li class="nav-item dropdown ">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle"
                                                   href="#" role="button" data-toggle="dropdown"
                                                   aria-haspopup="true" aria-expanded="false" v-pre="">
                                                    <span class="icon_account"><i class="fas fa-user"></i></span>
                                                    <span class="name_account">{{ $user->name }} <i
                                                            class="fas fa-caret-down"></i></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="/profile/edit-info">Tài
                                                        khoản</a>
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                        Thoát
                                                    </a>
                                                </div>
                                            </li>
                                        </a>-
                                        <div class="level-user ">
                                            <div class="level-user-left">
                                                <h5>
                                                    <a href="">
                                                        {{ getNameLevel($user->level) }}
                                                        <i class="fas fa-angle-right"></i>
                                                    </a>
                                                </h5>
                                                <h5>
                                                    <a href="">
                                                        {{ getMotaLevel($user->level) }}
                                                    </a>
                                                </h5>

                                            </div>
                                            <div class="level-user-right">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $addLinkTL = App\Models\Setting::find(125);
                            $addLinkVQ = App\Models\Setting::find(124);
                        @endphp
                        
                        @if(isset($downloadApp))
                        <div class="lisst-btn-santm">
                        @foreach ($downloadApp->childs as $index => $item)
                            <a href="{{ $item->value }}" class="btn-dow ">
                                {{ $item->name }}
                            </a>
                        @endforeach
                        </div>
                        @endif
                        <div class="lisst-btn-santm">
                       
                            @if(isset($addLinkVQ))
                            <a href="{{ $addLinkVQ->value }}" class="btn-vongquay">
                                {{ $addLinkVQ->name }}
                            </a>
                            @endif
                           
                            @if(isset($addLinkTL))
                            <a href="{{ $addLinkTL->value }}" class="btn-troly">
                                {{ $addLinkTL->name }}
                            </a>
                            @endif
                        </div>

                        {{-- @php
                            $postsHotNew = \App\Models\Post::where([['category_id', 26], ['active', 1], ['hot', 1]])
                                ->orderByDesc('created_at')
                                ->limit(5)
                                ->get();
                        @endphp
                        @if (isset($postsHotNew) && $postsHotNew->count() > 0)
                            <div class="pd-profile">

                                <div class="baner-profile-mobile ">
                                    <div class = "mt-2 background-color-white sodu-mobile border-radius-5">
                                        @foreach ($postsHotNew as $item)
                                            <div class="box-tt-profile">
                                                <div class="icon-pro">
                                                    <div class="box-icon-profile">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="text-pro">
                                                    <a href="{{ $item->slug_full }}">{{ $item->name }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif --}}
                        <div class="pd-profile">
                            <div class="baner-profile-dektop ">
                                <div class="box-avatar"style="text-align: center;">
                                    <a href="/profile">
                                        <img src="{{ $user->avatar_path ? $user->avatar_path : $shareFrontend['userNoImage'] }}"
                                             alt="{{ $user->name }}" class="mb-3 rounded-circle"
                                             style="width:100px;">

                                    </a>
                                    <li class="nav-item dropdown " style="list-style: none;">
                                        <a href="/profile"></a>
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                           role="button" data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false" v-pre="">

                                                <span class="name_account"> {{ $user->name }} <i
                                                        class="fas fa-caret-down"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="/profile/edit-info">Tài khoản</a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                Thoát
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  enctype="multipart/form-data" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                        <div class="level">
                                            {{ getNameLevel($user->level) }}
                                        </div>
                                        <div class="level">
                                            {{ getMotaLevel($user->level) }}
                                        </div>
                                    </li>
                                </div>
                            </div>
                            <style>
                                .activeNew {
                                    display: block !important;
                                }


                                button#toggleButton {
                                    display: none;
                                    padding: 10px 20px;
                                //border-radius: 20px;
                                    width: 100%;
                                    border: 1px solid;
                                }

                                @media (max-width:550px) {
                                    button#toggleButton {
                                        display: block;
                                    }
                                }

                                .activeNew ul.nav.nav-pills.nav-sidebar.flex-column {
                                    border: 1px solid #eee;
                                }

                                .activeNew ul.nav.nav-pills.nav-sidebar.flex-column li {
                                    padding: 5px 10px;
                                }
                            </style>
                            {{-- <button id="toggleButton">Danh mục</button> --}}
                            
                            <nav class="mt-2 background-color-white sodu-desktop">

                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
                                    role="menu" data-accordion="false">
                                    @if (isset($downloadApp) && $downloadApp->childs()->count() > 0)
                                    <div class="row d-flex justify-content-between">
                                        @foreach ($downloadApp->childs as $index => $item)
                                            <div class="col-5 btn {{ $index === 0 ? 'btn-info' : 'btn-success' }}">
                                                <a href="{{ $item->value }}" class="text-white" style="display: block; width: 100%;">{{ $item->name }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('listPostByUser') }}">
                                            <i class="fas fa-user-friends"></i>
                                            <p> Danh sách bài đăng</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('post.create') }}">
                                            <i class="fas fa-edit"></i>
                                            <p> Đăng bài</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.index') }}">
                                            <i class="fas fa-list"></i>
                                            <p> Thông tin tài khoản</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.editInfo') }}">
                                            <i class="fas fa-edit"></i>
                                            <p> KYC Tài khoản</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listRose') }}">
                                            <i class="fas fa-list"></i>
                                            <p> Danh sách điểm</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listMember') }}">
                                            <i class="fas fa-user-friends"></i>
                                            <p> Danh sách thành viên</p>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('profile.createMember') }}">
                                        <i class="fas fa-user-plus"></i>
                                    <p> Thêm thành viên</p>
                                    </a>
                                </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.history') }}">
                                            <i class="fas fa-cart-plus"></i>
                                            <p>Lịch sử mua hàng</p>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('profile.history-draw-point') }}">
                                        <i class="fas fa-cart-plus"></i>
                                        <p>Lịch sử rút điểm</p>
                                    </a>
                                </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.momoPayment') }}">
                                            <i class="fas fa-cart-plus"></i>
                                            <p>Nạp tiền</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.index', ['type' => 2]) }}">
                                            <i class="fas fa-list"></i>
                                            <p>Nạp BB bằng Ví VNĐ</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.lichSuNapTien') }}">
                                            <i class="fas fa-cart-plus"></i>
                                            <p>Lịch sử nạp tiền</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.lichSuRutTien') }}">
                                            <i class="fas fa-cart-plus"></i>
                                            <p>Lịch s rút tiền</p>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Lắng nghe sự kiện click trên nt button
                                    document.getElementById('toggleButton').addEventListener('click', function() {
                                        // Chọn phần tử nav có lớp sodu-desktop
                                        var navElement = document.querySelector('.sodu-desktop');
                                        // Toggle lớp sodu-desktop
                                        navElement.classList.toggle('activeNew');
                                    });
                                });
                            </script>
                        </div>

                        <div class="pd-profile">
                            <nav class="mt-2 background-color-white sodu-mobile border-radius-5">
                                <div class="title-sodu">
                                    <h6>Số dư v BB</h6>
                                    <span class="">{{ number_format($user->points()->where('active', 1)->whereIn('type', config('point.listTypePointMH'))->get()->sum('point')/getConfigBB()) }} BB<i
                                            class="fas fa-angle-right"></i>
                                        </span>
                                </div>
                                <ul class="nav nav-pills nav-sidebar " data-widget="treeview" role="menu"
                                    data-accordion="false">
                                    <li class="nav-item ">
                                        <a class="nav-link " href="{{ route('profile.momoPayment') }}">
                                            <div class="icon-profile color-icon-profile-1"><i
                                                    class="fas fa-edit"></i></div>
                                            <div><span> Nạp tiền </span></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.index', ['type' => 2]) }}">
                                            <div class="icon-profile color-icon-profile-1"><i
                                                    class="fas fa-edit"></i></div>
                                            <p class="text-center">Nạp BB bng Ví VNĐ</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.lichSuRutTien') }}">

                                            <div class="icon-profile color-icon-profile-4"><i
                                                    class="fas fa-edit"></i></div>
                                            <p class="text-center">Lịch sử rút tiền</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('profile.lichSuNapTien') }}">
                                            <div class = "icon-profile color-icon-profile-3"><i
                                                    class="fas fa-cart-plus"></i></div>
                                            <div><span>Lịch sử nap</span></div>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="">
                                            <div class = "icon-profile"><i class="fas fa-list"></i></div>
                                            <div><span>  Hoa hồng</span></div>
                                        </a>
                                    </li> --}}


                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="">
                                            <div><i class="fas fa-user-plus"></i></div>
                                        <div><p> Thêm thành viên</p></div>
                                        </a>
                                    </li> --}}
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.history') }}">
                                            <div><i class="fas fa-cart-plus"></i></div>
                                            <div><p>Lịch sử mua hàng</p></div>
                                        </a>
                                    </li> --}}

                                    {{--<li class="nav-item">
                                        <a class="nav-link" href="{{ route('listPostByUser') }}">
                                            <div><i class="fas fa-cart-plus"></i></div>
                                            <div><p>Bài đăng</p></div>
                                        </a>
                                    </li>--}}
                                </ul>
                            </nav>
                        </div>
                        <div class="pd-profile">
                            <nav class="mt-2 background-color-white khampha-mobile border-radius-5">
                                <div class="title-sodu">
                                    <h6>Ví VNĐ</h6>
                                    <span
                                        class="">{{ number_format($user->points()->where('active', 1)->whereIn('type', config('point.listTypePointDiemThuong'))->get()->sum('point')) }}đ
                                            <i class="fas fa-angle-right"></i>
                                        </span>
                                </div>
                                <ul class="nav nav-pills nav-sidebar " data-widget="treeview" role="menu"
                                    data-accordion="false">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.index') }}">
                                            <div class="icon-profile color-icon-profile-4"><i
                                                    class="fas fa-edit"></i></div>
                                            <div><span> Thông tin tài khoản </span></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.editInfo') }}">
                                            <div class="icon-profile color-icon-profile-4"><i
                                                    class="fas fa-edit"></i></div>
                                            <div><span> KYC tài khoản </span></div>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('profile.listRose') }}">
                                        <div class = "icon-profile"><i class="fas fa-list"></i></div>
                                        <div><span> Mua hàng </span></div>
                                    </a>
                                </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listMember') }}">
                                            <div class="icon-profile color-icon-profile-5"><i
                                                    class="fas fa-user-friends"></i></div>
                                            <div><span> Danh sách thành viên </span></div>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('profile.history') }}">
                                            <div class="icon-profile color-icon-profile-2"><i
                                                    class="fas fa-user-friends"></i></div>
                                            <div><span> Đơn hàng </span></div>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('profile.createMember') }}">
                                        <div><i class="fas fa-user-plus"></i></div>
                                    <div><p> Đăng bán</p></div>
                                    </a>
                                </li> --}}
                                <!-- <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.history') }}">
                                            <div><i class="fas fa-cart-plus"></i></div>
                                            <div><p>Lịch sử mua hàng</p></div>
                                        </a>
                                    </li> -->
                                    {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('profile.history-draw-point') }}">
                                        <div class = "icon-profile color-icon-profile-6"><i class="fas fa-cart-plus"></i></div>
                                        <div><span>Lịch sử rút tiền</span></div>
                                    </a>
                                </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listRose') }}">
                                            <div class="icon-profile color-icon-profile-4"><i
                                                    class="fas fa-list"></i></div>
                                            <div><span> Danh sách điểm </span></div>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="pd-profile-2 display-flex ">
                           

                            <button class="btn btn-info btn-coppy-link" onclick="myFunction()">Copy link</button>
                             <button class="btn btn-info btn-back-link">Trờ về trang trước</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    @yield('content')
                </div>
            </div>
        </div>

    </div>

<script>
  document.querySelector('.btn-back-link').addEventListener('click', function () {
    window.history.back();
  });
</script>
    @include('frontend.partials.footer')


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script type="text/javascript" src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }} "></script>

<script type="text/javascript" src="{{ asset('lib/lightbox-plus/js/lightbox-plus-jquery.min.js') }}"></script>

<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script type="text/javascript" src="{{ asset('lib/bootstrap-4.5.3-dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/wow/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/slick-1.8.1/js/slick.min.js') }}"></script>
<script src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('lib/components/js/Cart.js') }}"></script>
<script src="{{ asset('admin_asset/js/jquery.number.js') }}"></script>
<script>
    function myFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        //   alert("Copied the text: " + copyText.value);
    }
</script>
@yield('js')
</body>

</html>
