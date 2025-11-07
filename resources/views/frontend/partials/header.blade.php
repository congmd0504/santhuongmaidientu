<style>
    .dang-nhap {
        background-image: linear-gradient(to right, rgb(72, 185, 65) 0px, rgb(72, 185, 65) 50%, rgb(72, 185, 65) 100%);
        border-radius: 5px;
    }

    .dang-nhap .dropdown {
        padding: 6px 0px;
    }

    .cart-drop a {
        padding-left: 10px;
    }

    @media (max-width: 767px) {
        .dang-nhap #navbarDropdown .name_account {
            display: block !important;
        }

    }

    .dang-nhap #navbarDropdown .icon_account {
        display: none !important;
    }

    .dang-nhap #navbarDropdown .name_account {
        color: white;
        font-weight: 600;
        text-align: center;
    }

    .dang-nhap #navbarDropdown {
        text-align: center;
    }

    .dang-nhap .dropdown::marker {
        font-size: 0px;
    }

    .show_search_mobile {
        display: none;
    }

    @media (max-width: 786px) {
        .category-action {
            margin-left: 10px !important;
        }

        .logo_mb {
            margin-left: 10px !important;
        }

        .cart-drop a i {
            font-size: 17px;
        }

        .cart-drop {
            padding: 0 !important;
            margin-top: 14px;
        }

        span.count_item.count_item_pr {
            width: 10px !important;
            height: 10px !important;
            font-size: 10px !important;
            line-height: 12px !important;
            right: -5px !important;
            top: -2px !important;
        }

        .item-link h2 {
            font-size: 8px;
        }

        .show_search_mobile {
            display: block;
        }

        .acount-desktop {
            display: none;
        }

        .search_mb .form_search .form-control {
            display: none;
        }

        .cart-drop a {
            margin: 0 5px;
        }

    }

    /*
    a.show_search_mobile2 {
        display: none;
    } */

    @media (max-width:550px) {
        .category-action {
            display: none !important;
        }

        .header_top {
            padding: 0;
        }

        form {
            margin-top: 0;
        }

        .header form input {
            padding-right: 15px;
        }

        .form_search input.form-control {
            font-size: 12px;
        }


    }

    @media (max-width: 786px) {
        a.show_search_mobile2 {
            display: block;
        }
    }

    .box-search-mobile {
        display: none;
        /* Ẩn box-search-mobile mặc định */
        transition: opacity 0.5s ease;
        /* Thêm hiệu ứng transition cho opacity */
        opacity: 0;
        /* Mặc định opacity là 0 */
    }

    .box-search-mobile.show {
        display: block;
        /* Hiển thị box-search-mobile khi có class show */
        opacity: 1;
        /* Đặt opacity thành 1 để hiển thị */
    }

    .box-search-mobile.show {
        position: absolute;
        left: 0;
        right: 0;
        top: 50px;
        width: 100%;
    }

    .box-search-mobile.show .close-form {
        position: absolute;
        z-index: 1;
        top: 0;
        right: 0;
    }
</style>
<div class="menu_fix_mobile">
    <div class="close-menu">
        <!-- <div class="logo_menu">
            <img class="logo-desk" src="{linkhost}/upload/images/{banner_top}">
        </div> -->
        <a href="javascript:;" id="close-menu-button">
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>
    </div>
    <ul class="nav-main">
        @include('frontend.components.menu', [
        'limit' => 4,
        'icon_d' => '<i class="fas fa-chevron-down mn-icon"></i>',
        'icon_r' => '<i class="fas fa-chevron-down mn-icon"></i>',
        'data' => $header['menu'],
        ])
    </ul>
    <div class="dang-nhap">
        <li class="nav-item dropdown"><a href="https://dailylifehtc.com/profile" style="height: 0px;display: block;">
            </a><a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                <span class="icon_account"><i class="fas fa-user"></i></span>
                <span class="name_account"> <i class="fas fa-user"></i> Tài khoản </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="">
                <a class="dropdown-item" href="/profile/edit-info">Tài khoản</a>
                <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Thoát
                </a>
                {{-- <form id="logout-form" action="/logout" method="POST" class="d-none">
                    <input type="hidden" name="_token" value="jVmEXIRtev5aupnEyHY6ieeriAQNmNzgsJQaCD3Z">
                </form> --}}
            </div>
        </li>
    </div>
</div>
<div id="header" class="header">
    <div class="header_top">
        <div class="container">
            <div class=" item-header_top">
                <div class="topbar-text d-none d-lg-block">
                    @if (isset($header['hotline']) && $header['hotline']->count() > 0)
                    <a href="tel:{{ $header['hotline']->slug }}" class="phone">
                        <i class="fas fa-phone"></i>
                        <b>{{ $header['hotline']->value }}</b>
                    </a>
                    @endif
                    @if (isset($header['email']) && $header['email']->count() > 0)
                    <a href="javascript:;" class="email">
                        <i class="fas fa-envelope"></i>
                        <b>{{ $header['email']->value }}</b>
                    </a>
                    @endif
                </div>
                <div class="header-tool">
                    <div class="cart-drop" style="display: flex;">
                        <a href="{{ route('notification') }}" style="position: relative;">
                            <i class="fas fa-bell"></i>
                            @php
                            $countPost = App\Models\Post::where('active', 1)->count();
                            @endphp
                            {{-- <span class="count_item count_item_pr">{{ $countPost }}</span> --}}
                        </a>
                        <a class="show_search_mobile2" style="position: relative;">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </a>
                        <div class="top-cart-content">
                            <div class="CartHeaderContainer">
                            </div>
                        </div>
                        {{--
                        <div class="acount-desktop">
                            @guest
                            <li class="account-item has-icon">
                                <a href="javascript:;" class="nav-top-link nav-top-not-logged-in is-small btn-signin">
                                    <i class="fas fa-user"></i>
                                </a>
                            </li>
                            @else
                            <li class="nav-item dropdown taikhoan-dangnhap">
                                @if (Auth::guard('web')->check())
                                <span class="icon_account"><a href="{{ route('profile.editInfo') }}"><i class="fas fa-user"></i></a></span>
                        @endif
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if (Auth::guard('web')->check())
                            <a class="dropdown-item" href="{{ route('profile.editInfo') }}">Tài khoản</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Thoát') }}
                            </a>
                            @endif
                        </div>
                        </li>
                        @endguest
                    </div>
                    --}}
                    <a href="{{ route('cart.list') }}" style="position: relative;">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="count_item count_item_pr">{{ $header['totalQuantity'] }}</span>
                    </a>
                    <div class="top-cart-content">
                        <div class="CartHeaderContainer">
                        </div>
                    </div>
                </div>
                <div class="logo_mb">
                    <a href="{{ makeLink('home') }}">
                        <img src="{{ asset($header['logo']->image_path) }}" alt="Logo">
                    </a>
                </div>
                <div class="category-action">
                    <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 2.01399V0.356445H22.0001V2.01399H0ZM0 19.6442V17.9866H22.0001V19.6442H0ZM22.0001 9.17154H0V10.8291H22.0001V9.17154Z" fill="black"></path>
                    </svg>
                </div>
            </div>
            <div class="search_mb">
                <form class="form_search" id="form1" name="form1" method="get" action="{{ makeLink('search') }}" style="display:flex;">
                    <input class="form-control" type="text" name="keyword" placeholder="Nhập từ khóa" required="">
                    <button class="form-control" type="submit" name="gone22" id="gone22"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="box-search-mobile">
    <div class="container">
        <form class="form_search" id="form1" name="form1" method="get" action="{{ makeLink('search') }}" style="display:flex;">
            <input class="form-control" type="text" name="keyword" placeholder="Nhập từ khóa" required="">
            <button class="form-control" type="submit" name="gone22" id="gone22"><i class="fa fa-search" aria-hidden="true"></i></button>
            <div class="colose-search-desk-mobile">
                <span><i class="fas fa-times"></i></span>
            </div>
        </form>
    </div>
</div>
<script>
    // Chọn phần tử có class show_search_mobile2
    var showSearchMobileButton = document.querySelector('.show_search_mobile2');

    // Chọn phần tử có class box-search-mobile
    var boxSearchMobile = document.querySelector('.box-search-mobile');

    // Chọn phần tử có class colose-search-desk-mobile
    var closeSearchMobileButton = document.querySelector('.colose-search-desk-mobile');

    // Thêm sự kiện click vào nút show_search_mobile2
    showSearchMobileButton.addEventListener('click', function() {
        // Toggle class 'show' cho phần tử box-search-mobile
        boxSearchMobile.classList.toggle('show');
    });

    // Thêm sự kiện click vào nút closeSearchMobileButton
    closeSearchMobileButton.addEventListener('click', function() {
        // Xoá class 'show' khỏi phần tử box-search-mobile
        boxSearchMobile.classList.remove('show');
    });
</script>


<div class="header-main">
    <div class="container ">
        <div class="box-header-main">
            <div class="list-bar">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <div class="logo-head">
                <div class="image">
                    <a href="{{ makeLink('home') }}"><img src="{{ asset($header['logo']->image_path) }}"></a>
                </div>
            </div>
            <div class="menu menu-desktop">
                <div class="box-menu-despkop">
                    <div class="fix-footer-box">
                        <a href="/" class="d-block ta-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 640 512">
                                <path d="M208 320h384c8.8 0 16-7.2 16-16V48c0-8.8-7.2-16-16-16H448v128l-48-32-48 32V32H208c-8.8 0-16 7.2-16 16v256c0 8.8 7.2 16 16 16zm416 64H128V16c0-8.8-7.2-16-16-16H16C7.2 0 0 7.2 0 16v32c0 8.8 7.2 16 16 16h48v368c0 8.8 7.2 16 16 16h82.9c-1.8 5-2.9 10.4-2.9 16 0 26.5 21.5 48 48 48s48-21.5 48-48c0-5.6-1.2-11-2.9-16H451c-1.8 5-2.9 10.4-2.9 16 0 26.5 21.5 48 48 48s48-21.5 48-48c0-5.6-1.2-11-2.9-16H624c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16z"></path>
                            </svg>
                        <span class="d-block">
                                SẢN PHẨM TIÊU DÙNG
                            </span>
                        </a>
                    </div>
                    @if(isset($header['nang_cap']))
                    <div class="fix-footer-box">
                        <a href="{{ makeLink('category_products', $header['nang_cap']->id, $header['nang_cap']->slug) }}" class="d-block ta-center">
                            <svg width="30px" height="30px" viewBox="0 0 1024 1024" fill="#000000" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M161.6 923.2c-15.2 0-30.4-6.4-40.8-17.6-22.4-22.4-22.4-60 0-82.4 11.2-11.2 25.6-17.6 40.8-17.6 15.2 0 30.4 6.4 40.8 17.6 22.4 22.4 22.4 60 0 82.4-10.4 12-24.8 17.6-40.8 17.6z m0-68c-2.4 0-4.8 0.8-6.4 2.4-4 4-4 10.4 0 14.4 1.6 1.6 4 2.4 6.4 2.4 2.4 0 4.8-0.8 6.4-2.4 4-4 4-10.4 0-14.4-1.6-1.6-4-2.4-6.4-2.4z" fill=""></path>
                                    <path d="M178.4 972c-24.8 0-47.2-9.6-64.8-27.2l-24-24c-35.2-36-35.2-94.4 0-130.4l1.6-1.6 423.2-362.4c-25.6-43.2-37.6-93.6-33.6-144 4-59.2 28.8-114.4 69.6-156 45.6-46.4 106.4-72 171.2-72 31.2 0 62.4 6.4 91.2 18.4 7.2 3.2 12.8 9.6 14.4 17.6 1.6 8-0.8 16-6.4 21.6L696.8 236.8l84 85.6L904 198.4c4.8-4.8 11.2-7.2 17.6-7.2 1.6 0 3.2 0 4.8 0.8 8 1.6 14.4 7.2 17.6 14.4 18.4 44 23.2 92.8 14.4 140-8.8 48.8-32 92.8-66.4 128-45.6 46.4-105.6 72-169.6 72-35.2 0-70.4-8-101.6-23.2l-377.6 421.6c-17.6 17.6-40.8 27.2-64.8 27.2z m-54.4-147.2c-16 17.6-16 44.8 0.8 61.6l24 24c8 8 18.4 12.8 29.6 12.8 11.2 0 21.6-4.8 29.6-12.8l388.8-434.4c4.8-4.8 11.2-8 18.4-8 4 0 8.8 0.8 12 3.2 28.8 16.8 61.6 25.6 95.2 25.6 51.2 0 98.4-20 134.4-56.8 45.6-47.2 65.6-113.6 52.8-178.4l-112 112.8c-4.8 4.8-11.2 7.2-17.6 7.2-6.4 0-12.8-2.4-17.6-7.2L645.6 253.6c-9.6-9.6-9.6-24.8 0-34.4l112-112.8c-12-2.4-24-3.2-36-3.2-51.2 0-100 20.8-136 57.6-68 68.8-75.2 176.8-18.4 256 7.2 10.4 5.6 24.8-4 32.8l-439.2 375.2z" fill=""></path>
                                    <path d="M405.6 522.4c-6.4 0-12.8-2.4-17.6-7.2L216 340h-58.4c-8.8 0-16.8-4.8-20.8-12L57.6 198.4c-5.6-9.6-4-22.4 4-30.4l64-64.8c4.8-4.8 11.2-7.2 17.6-7.2 4.8 0 8.8 1.6 12.8 4l130.4 81.6c7.2 4.8 11.2 12 11.2 20l0.8 58.4 176.8 181.6c4.8 4.8 7.2 11.2 7.2 17.6 0 6.4-2.4 12.8-7.2 16.8-4.8 4.8-10.4 7.2-16.8 7.2s-12.8-2.4-17.6-7.2L256 287.2c-4-4.8-7.2-10.4-7.2-16.8l-0.8-55.2-102.4-64-36.8 37.6 62.4 102.4h54.4c6.4 0 12.8 2.4 17.6 7.2l179.2 182.4c4.8 4.8 7.2 11.2 7.2 17.6 0 6.4-2.4 12.8-7.2 17.6-4 4-10.4 6.4-16.8 6.4zM768.8 979.2c-15.2 0-30.4-6.4-40.8-17.6L520.8 748c-22.4-22.4-22.4-59.2 0-82.4l6.4-6.4-7.2-7.2c-9.6-9.6-9.6-24.8 0.8-34.4 4.8-4.8 10.4-7.2 16.8-7.2s12.8 2.4 17.6 7.2l24 24c9.6 9.6 8.8 24.8 0 34.4l-23.2 24c-4 4-4 10.4 0 14.4L763.2 928c1.6 1.6 4 2.4 6.4 2.4 2.4 0 4.8-0.8 6.4-2.4l94.4-96.8c4-4 4-10.4 0-14.4l-208-213.6c-1.6-1.6-4-2.4-6.4-2.4-2.4 0-4.8 0.8-6.4 2.4L624 629.6c-4.8 4.8-11.2 7.2-17.6 7.2-6.4 0-12.8-2.4-17.6-7.2L568 606.4c-4.8-4.8-7.2-11.2-7.2-17.6 0-6.4 2.4-12.8 7.2-16.8 4.8-4.8 10.4-7.2 16.8-7.2s12.8 2.4 17.6 7.2l4.8 4.8 8-8c11.2-11.2 25.6-17.6 40.8-17.6 15.2 0 30.4 6.4 40.8 17.6L904 782.4c22.4 22.4 22.4 60 0 82.4l-94.4 96.8c-10.4 11.2-24.8 17.6-40.8 17.6z" fill=""></path>
                                </g>
                            </svg>
                            <span class="d-block">
                                NÂNG CẤP TK
                            </span>
                        </a>
                    </div>
                    @endif

                    <div class="fix-footer-box">
                        <a href="{{ route('contact.index') }}" class="d-block ta-center">
                            <svg fill="#000000" width="30px" height="30px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#000000" stroke-width="1.472">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="_x32_5_attachment"></g>
                                    <g id="_x32_4_office"></g>
                                    <g id="_x32_3_pin"></g>
                                    <g id="_x32_2_business_card"></g>
                                    <g id="_x32_1_form"></g>
                                    <g id="_x32_0_headset"></g>
                                    <g id="_x31_9_video_call"></g>
                                    <g id="_x31_8_letter_box"></g>
                                    <g id="_x31_7_papperplane"></g>
                                    <g id="_x31_6_laptop"></g>
                                    <g id="_x31_5_connection"></g>
                                    <g id="_x31_4_phonebook"></g>
                                    <g id="_x31_3_classic_telephone">
                                        <g>
                                            <g>
                                                <path d="M5.7783,24.7686c1.9902,1.085,5.0967,0.269,8.0811-0.6533c4.8364-1.3472,7.019-2.6401,7.168-6.7412 c0.0034-0.1011-0.0083-0.2021-0.0352-0.2998c-0.0029-0.0122,0.0063-0.1108,0.1294-0.2905 c0.7661-1.1177,3.6714-2.4893,7.2095-2.8501c0.9307-0.0977,1.9409-0.1489,2.9951-0.1523 c1.0571,0.0034,2.0674,0.0547,3.0049,0.1523c3.5352,0.3608,6.4395,1.7324,7.2061,2.8501 c0.123,0.1797,0.1328,0.2783,0.1289,0.2905c-0.0264,0.0972-0.0381,0.1982-0.0342,0.2988 c0.1445,4.1001,2.3271,5.3936,7.1377,6.7344c1.9893,0.6147,4.0195,1.1802,5.7432,1.1802c0.8848,0,1.6895-0.1494,2.3652-0.5176 c1.4609-0.7915,2.2539-3.3052,2.417-4.1216c1.3721-6.8125-3.7441-12.9063-9.0781-15.6851 C45.3633,2.4341,38.3145,0.9468,31.3296,1.001c-6.9517-0.0498-14.0381,1.4336-18.8872,3.9624 c-5.3335,2.7783-10.4502,8.8721-9.0811,15.686C3.5264,21.4678,4.3257,23.9814,5.7783,24.7686z M13.3667,6.7368 c4.5747-2.3862,11.2939-3.7954,17.9561-3.7358c0.0039,0,0.0098,0,0.0137,0c6.6821-0.0381,13.3774,1.3501,17.9565,3.7358 c4.6914,2.4443,9.209,7.7168,8.041,13.519c-0.2002,1.0054-0.8896,2.4741-1.4111,2.7568 c-1.4189,0.7725-4.8926-0.3003-6.5898-0.8242c-4.7744-1.3306-5.5859-2.2759-5.6982-4.7632 c0.0791-0.4399,0.0391-1.062-0.4482-1.7725c-1.2266-1.7891-4.7842-3.314-8.6504-3.7085c-1.002-0.1045-2.0796-0.1597-3.21-0.1631 c-1.1279,0.0039-2.2061,0.0586-3.2012,0.1631c-3.8682,0.3945-7.4263,1.9194-8.6528,3.708 c-0.4873,0.7104-0.5273,1.3325-0.4487,1.7725c-0.1143,2.4883-0.9272,3.4341-5.728,4.7715 c-1.6694,0.5161-5.1431,1.5889-6.562,0.8149c-0.5171-0.2798-1.2085-1.7505-1.4116-2.7568 C4.1563,14.4536,8.6748,9.1812,13.3667,6.7368z"></path>
                                                <path d="M61.5771,54.4614l-3.1309-19.0518c-0.8037-4.9136-4.1641-8.2148-8.3623-8.2148h-9.3481l-1.313-5.1528 c-0.5342-2.1182-1.8789-3.3823-3.5967-3.3823H27.498c-1.7393,0-3.0513,1.2319-3.5996,3.3799l-1.314,5.1553h-8.8257 c-4.1934,0-7.5542,3.3008-8.3628,8.2139L2.4893,53.0884c-0.6113,3.7251-0.2471,6.314,1.1128,7.915 c1.6968,1.9971,4.4331,1.9941,6.9116,1.9961h42.7012L53.5371,63c0.1074,0,0.2139,0,0.3213,0 c2.4238,0,5.0947-0.0757,6.6797-1.9399C61.7354,59.6523,62.0752,57.4941,61.5771,54.4614z M25.8364,22.5337 c0.1787-0.6997,0.6323-1.874,1.6616-1.874h8.3281c1.0313,0,1.4805,1.1729,1.6582,1.874l1.1875,4.6611H24.6484L25.8364,22.5337z M59.0146,59.7642C57.959,61.0059,55.7178,61.0039,53.54,61l-42.9087-0.0005h-0.1182c-2.0977,0-4.2891,0.001-5.3867-1.291 c-0.9434-1.1108-1.167-3.229-0.6636-6.2959l2.9067-17.6792c0.4961-3.0166,2.4673-6.5386,6.3892-6.5386H50.084 c3.9268,0,5.8955,3.5215,6.3887,6.5381l3.1318,19.0527C59.9951,57.1694,59.7969,58.8442,59.0146,59.7642z"></path>
                                            </g>
                                            <g>
                                                <path d="M32.002,58.4673c-7.3721,0-13.3701-5.998-13.3701-13.3701c0-7.3706,5.998-13.3667,13.3701-13.3667 c7.3701,0,13.3662,5.9961,13.3662,13.3667C45.3682,52.4692,39.3721,58.4673,32.002,58.4673z M32.002,33.7305 c-6.2695,0-11.3701,5.0991-11.3701,11.3667c0,6.2695,5.1006,11.3701,11.3701,11.3701c6.2676,0,11.3662-5.1006,11.3662-11.3701 C43.3682,38.8296,38.2695,33.7305,32.002,33.7305z"></path>
                                            </g>
                                            <g>
                                                <path d="M32.002,49.9707c-2.6875,0-4.8735-2.186-4.8735-4.8735c0-2.6855,2.186-4.8701,4.8735-4.8701 c2.6855,0,4.8701,2.1846,4.8701,4.8701C36.8721,47.7847,34.6875,49.9707,32.002,49.9707z M32.002,42.2271 c-1.5845,0-2.8735,1.2876-2.8735,2.8701c0,1.5845,1.2891,2.8735,2.8735,2.8735c1.583,0,2.8701-1.2891,2.8701-2.8735 C34.8721,43.5146,33.585,42.2271,32.002,42.2271z"></path>
                                            </g>
                                            <g>
                                                <path d="M32.002,37.7339c-0.5522,0-1.0298-0.4478-1.0298-1s0.418-1,0.9702-1h0.0596c0.5522,0,1,0.4478,1,1 S32.5542,37.7339,32.002,37.7339z"></path>
                                            </g>
                                            <g>
                                                <path d="M32.002,54.4644c-0.5522,0-1.0298-0.4478-1.0298-1s0.418-1,0.9702-1h0.0596c0.5522,0,1,0.4478,1,1 S32.5542,54.4644,32.002,54.4644z"></path>
                                            </g>
                                            <g>
                                                <path d="M23.6348,46.127c-0.5522,0-1-0.418-1-0.9702v-0.0596c0-0.5522,0.4478-1,1-1s1,0.4478,1,1S24.187,46.127,23.6348,46.127z"></path>
                                            </g>
                                            <g>
                                                <path d="M40.3652,46.127c-0.5527,0-1-0.418-1-0.9702v-0.0596c0-0.5522,0.4473-1,1-1c0.5527,0,1,0.4478,1,1 S40.918,46.127,40.3652,46.127z"></path>
                                            </g>
                                            <g>
                                                <path d="M26.0547,40.1924c-0.2539,0-0.5063-0.0928-0.6963-0.2827c-0.3906-0.3906-0.4116-1.0024-0.021-1.3931l0.042-0.042 c0.3906-0.3906,1.0234-0.3906,1.4141,0s0.3906,1.0234,0,1.4141C26.5933,40.0894,26.3232,40.1924,26.0547,40.1924z"></path>
                                            </g>
                                            <g>
                                                <path d="M37.8857,52.0234c-0.2549,0-0.5068-0.0928-0.6973-0.2827c-0.3896-0.3906-0.4111-1.0024-0.0205-1.3931l0.042-0.042 c0.3906-0.3906,1.0234-0.3906,1.4141,0s0.3906,1.0234,0,1.4141C38.4238,51.9204,38.1533,52.0234,37.8857,52.0234z"></path>
                                            </g>
                                            <g>
                                                <path d="M26.0977,52.0444c-0.2437,0-0.4863-0.0928-0.6763-0.2827l-0.042-0.042c-0.3906-0.3906-0.3906-1.0234,0-1.4141 s1.0234-0.3906,1.4141,0s0.4116,1.0444,0.021,1.4351C26.6143,51.9414,26.355,52.0444,26.0977,52.0444z"></path>
                                            </g>
                                            <g>
                                                <path d="M37.9287,40.2134c-0.2441,0-0.4863-0.0928-0.6768-0.2827l-0.042-0.042c-0.3906-0.3906-0.3906-1.0234,0-1.4141 s1.0234-0.3906,1.4141,0s0.4111,1.0444,0.0215,1.4351C38.4443,40.1104,38.1855,40.2134,37.9287,40.2134z"></path>
                                            </g>
                                        </g>
                                    </g>
                                    <g id="_x31_2_sending_mail"></g>
                                    <g id="_x31_1_man_talking"></g>
                                    <g id="_x31_0_date"></g>
                                    <g id="_x30_9_review"></g>
                                    <g id="_x30_8_email"></g>
                                    <g id="_x30_7_information"></g>
                                    <g id="_x30_6_phone_talking"></g>
                                    <g id="_x30_5_women_talking"></g>
                                    <g id="_x30_4_calling"></g>
                                    <g id="_x30_3_women"></g>
                                    <g id="_x30_2_writing"></g>
                                    <g id="_x30_1_chatting"></g>
                                </g>
                            </svg>
                            <span class="d-block">
                                LIÊN HỆ
                            </span>
                        </a>
                    </div>

                    <div class="fix-footer-box">
                        <a href="/mang-xa-hoi" class="d-block ta-center">
                            <svg width="30px" height="30px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>network_3 [#1082]</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs> </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Dribbble-Light-Preview" transform="translate(-300.000000, -3399.000000)" fill="#000000">
                                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                                <path d="M251.907,3250 L253.907,3250 L253.907,3248 L251.907,3248 L251.907,3250 Z M256,3250 L262,3250 L262,3248 L256,3248 L256,3250 Z M251.907,3257 L253.907,3257 L253.907,3255 L251.907,3255 L251.907,3257 Z M256,3257 L262,3257 L262,3255 L256,3255 L256,3257 Z M251.907,3243 L253.907,3243 L253.907,3241 L251.907,3241 L251.907,3243 Z M256,3243 L262,3243 L262,3241 L256,3241 L256,3243 Z M264,3245 L264,3239 L250,3239 L250,3241 L246,3241 L246,3239 L244,3239 L244,3257 L250,3257 L250,3259 L264,3259 L264,3253 L250,3253 L250,3255 L246,3255 L246,3250 L250,3250 L250,3252 L264,3252 L264,3246 L250,3246 L250,3248 L246,3248 L246,3243 L250,3243 L250,3245 L264,3245 Z" id="network_3-[#1082]"> </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span class="d-block">
                                MẠNG XÃ HỘI
                            </span>
                        </a>
                    </div>

                    <div class="fix-footer-box">
                        <a href="{{ route('profile.index') }}" class="d-block ta-center ">
                            <svg fill="#000000" width="30px" height="30px" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title></title>
                                    <path d="M69.3677,51.0059a30,30,0,1,0-42.7354,0A41.9971,41.9971,0,0,0,0,90a5.9966,5.9966,0,0,0,6,6H90a5.9966,5.9966,0,0,0,6-6A41.9971,41.9971,0,0,0,69.3677,51.0059ZM48,12A18,18,0,1,1,30,30,18.02,18.02,0,0,1,48,12ZM12.5977,84A30.0624,30.0624,0,0,1,42,60H54A30.0624,30.0624,0,0,1,83.4023,84Z"></path>
                                </g>
                            </svg>
                            <span class="d-block">
                                TÀI KHOẢN
                            </span>
                        </a>
                    </div>

                </div>
                {{-- @include('frontend.components.menu', [
                        'limit' => 5,
                        'icon_d' => '<i class="fas fa-chevron-down"></i>',
                        'icon_r' => "<i class='fas fa-angle-right'></i>",
                        'data' => $header['menu'],
                    ])
                    <ul class="tim-kiem">
                        <li class="icon-search show_search"><a><i class="fa fa-search" aria-hidden="true"></i></a>
                        </li>
                         <li class="cart">
                            <a href="{{ route('cart.list') }}"><img src="{{ asset('frontend/images/bag.png') }}" alt="bag"><span class="number-cart">{{ $header['totalQuantity'] }}</span></a>
                </li>
                </ul>--}}
            </div>
            <div class="search" id="search">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form_search" id="form1" name="form1" method="get" action="{{ makeLink('search') }}" style="display:flex;">
                                <input class="form-control" type="text" name="keyword" placeholder="Nhập từ khóa" required="">
                                <button class="form-control" type="submit" name="gone22" id="gone22"><i class="fa fa-search" aria-hidden="true"></i></button>
                                <button class="form-control close-search" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@guest
<div id="myModalSignIn" class="modal fade" role="dialog">
    <div class="modal-bg"></div>
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal"></button>
        <div class="content">
            <div class="title">
                Đăng nhập
            </div>
            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf
                <div class="form-group row">
                    <label for="username" class="col-12">Tên đăng nhập</label>

                    <div class="col-12">
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-12">Mật khẩu</label>

                    <div class="col-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            Đăng nhập
                        </button>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Quên mật khẩu?
                        </a>
                        @endif
                    </div>
                    <div class="col-12">
                        <div class="dang_ky">
                            Nếu bạn chưa có tài khoản vui lòng đăng ký <a href="{{ route('register') }}">tại đây</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@else
@endguest
