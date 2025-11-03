<style>
    .dang-nhap{
        background-image: linear-gradient(to right, rgb(72, 185, 65) 0px, rgb(72, 185, 65) 50%, rgb(72, 185, 65) 100%);
        border-radius: 5px;
    }
    .dang-nhap .dropdown{
        padding: 6px 0px;
    }
    @media (max-width: 767px){
        .dang-nhap #navbarDropdown .name_account {
            display: block !important;
        }   
        
    }   
    .dang-nhap #navbarDropdown .icon_account{
        display: none !important;
    }
    .dang-nhap #navbarDropdown .name_account{
        color: white;
        font-weight: 600;
        text-align: center;
    }
    .dang-nhap #navbarDropdown{
        text-align: center;
    }
    .dang-nhap .dropdown::marker{
        font-size:0px;
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
        @include('frontend.components.menu',[
            'limit'=>4,
            'icon_d'=>'<i class="fas fa-chevron-down mn-icon"></i>',
            'icon_r'=>'<i class="fas fa-chevron-down mn-icon"></i>',
            'data'=>$header['menu'],
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
                {{--<form id="logout-form" action="/logout" method="POST" class="d-none">
                    <input type="hidden" name="_token" value="jVmEXIRtev5aupnEyHY6ieeriAQNmNzgsJQaCD3Z">
                </form>--}}
            </div>
        </li>
    </div>
</div>
<div id="header" class="header">
    {{--<div class="topbar">
        <div class="topbar-mb d-block d-lg-none">
            @if(isset($header['banner_top_mb']) && $header['banner_top_mb']->count()>0)
            <a href="#" style="background:url({{ asset($header['banner_top_mb']->image_path)}}) center center no-repeat"></a>
            @endif
        </div>
        <div class="topbar d-none d-lg-block">
            @if(isset($header['banner_top_desk']) && $header['banner_top_desk']->count()>0)
            <a href="#" style="background:url({{ asset($header['banner_top_desk']->image_path)}}) center center no-repeat"></a>
            @endif
        </div>
    </div>---}}
    <div class="header_top">
        <div class="container">
            <div class=" item-header_top">
                <div class="topbar-text d-none d-lg-block">
                    @if(isset($header['hotline']) && $header['hotline']->count()>0)
                    <a href="tel:{{ $header['hotline']->slug }}" class="phone">
                        <i class="fas fa-phone"></i>
                        <b>{{ $header['hotline']->value }}</b>
                    </a>
                    @endif
                    @if(isset($header['email']) && $header['email']->count()>0)
                    <a href="javascript:;" class="email">
                        <i class="fas fa-envelope"></i>
                        <b>{{ $header['email']->value }}</b>
                    </a>
                    @endif
                </div>
                <div class="header-tool">
                    <div class="cart-drop" style="display: flex;">
                        @guest
                        <li class="account-item has-icon">
                            <a href="javascript:;" class="nav-top-link nav-top-not-logged-in is-small btn-signin">
                                <i class="fas fa-user"></i>
                            </a>
                        </li>
                        @else
                        <li class="nav-item dropdown taikhoan-dangnhap">
                                @if(Auth::guard('web')->check())
                                <span class="icon_account"><a href="{{ route('profile.editInfo') }}"><i class="fas fa-user"></i></a></span>
                                {{--<span class="name_account">{{ Auth::guard()->user()->name }}</span>--}}
                                @endif
                            {{--<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            </a>--}}
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(Auth::guard('web')->check())
                                    <a class="dropdown-item" href="{{ route('profile.editInfo') }}">Tài khoản</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        {{ __('Thoát') }}
                                    </a>
                                @endif
                            </div>
                        </li>
                        @endguest
                        <a href="{{ route('cart.list') }}" style="position: relative;">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="count_item count_item_pr">{{ $header['totalQuantity'] }}</span>
                        </a>
                        <div class="top-cart-content">
                            <div class="CartHeaderContainer">
                            </div>
                        </div>
                        {{--<ul class="navbar-nav ml-2">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif 
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownG" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-user"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('login') }}">
                                            <i class="fas fa-user"></i> Đăng nhập
                                        </a>
                                        <a class="dropdown-item" href="{{ route('register') }}">
                                        <i class="fas fa-sign-in-alt"></i> Đăng Ký
                                        </a>
                                    </div>
                                </li>
                            @else
                                
                            @endguest
                        </ul>--}}
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
               {{-- <div class="theme-search-smart">
                    <div class="header_search theme-searchs">
                        <form action="{{ makeLink('search') }}" method="GET" class="input-group search-bar theme-header-search-form ultimate-search" role="search">
                            <div class="row relative">
                                <div class="flex-col search-form-categories">
                                    <select class="search_categories resize-select mb-0" id="categoryProduct" name="category">
                                        <option value="">All</option>
                                        @if(isset($header['category_all']))
                                            @foreach($header['category_all'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="flex-col flex-grow">
                                    <input type="text" aria-label="Tìm sản phẩm" name="keyword" autocomplete="off" placeholder="Tìm sản phẩm" class="search-auto auto-search" required="">
                                </div>
                                <div class="flex-col">
                                    <button type="submit" class="btn icon-fallback-text input-group-btn" aria-label="Justify"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
    {{--
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="box-header-top">
                        <div class="box-social-header-top">
                            <div class="box-info ">
                                <ul>
                                    <li><a href="tel:{{ $header['hotline']->slug }}" class="phone"><i class="fa fa-phone" aria-hidden="true"></i> {{ $header["hotline"]->value }}</a></li>
                                    <li class="d-none  d-md-block"><a href="mailto:{{ $header['email']->slug }}" class="email"><i class="fa fa-envelope" aria-hidden="true"></i> {{ $header["email"]->value }}</a></li>
                                    <li class="d-none  d-lg-block"><a href="{{ $header['address']->slug }}" class="address"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $header["address"]->value }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-social-header-top">
                            <div class="group-social">
                                <ul>
                                    @foreach($header["socialParent"]->childs as $social )
                                    <li class="social-item"><a href="{{ $social->slug }}">{!! $social->value  !!} </a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <nav class="navbar navbar-expand-md  shadow-sm p-0">
                                    <button class="navbar-toggler d-none" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse show" id="navbarSupportedContent">

                                        <ul class="navbar-nav mr-auto">

                                        </ul>
                                        <ul class="navbar-nav ml-auto">
                                            @guest
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                                </li>
                                                @if (Route::has('register'))
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                                    </li>
                                                @endif
                                            @else
                                                <li class="nav-item dropdown">
                                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                                        @if (Auth::guard('admin')->check())
                                                        {{ Auth::guard('admin')->user()->name }}
                                                        @else
                                                        @if(Auth::guard('web')->check())
                                                        {{ Auth::guard()->user()->name }}
                                                        @endif
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                                        @if (Auth::guard('admin')->check())
                                                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                                        onclick="event.preventDefault();
                                                                      document.getElementById('logout-form').submit();">
                                                         {{ __('Logout') }}
                                                         </a>
                                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                                        <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-user mr-2"></i> Tài khoản của tôi</a>
                                                        @if(Auth::guard('web')->check())
                                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                      document.getElementById('logout-form').submit();">
                                                        <i class="fas fa-sign-out-alt"></i>  {{ 'Thoát' }}
                                                         </a>
                                                        
                                                        @endif
                                                    </div>
                                                </li>
                                            @endguest
                                        </ul>
                                    </div>

                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    --}}


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
                    @include('frontend.components.menu',[
                        'limit'=>5,
                        'icon_d'=>'<i class="fas fa-chevron-down"></i>',
                        'icon_r'=>"<i class='fas fa-angle-right'></i>",
                        'data'=>$header['menu'],
                    ])
                    <ul class = "tim-kiem">
                        <li class="icon-search show_search"><a><i class="fa fa-search" aria-hidden="true"></i></a></li>
                        {{--<li class="cart">
                            <a href="{{ route('cart.list') }}"><img src="{{ asset('frontend/images/bag.png') }}" alt="bag"><span class="number-cart">{{ $header['totalQuantity'] }}</span></a>
                        </li>--}}
                    </ul>
                    
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{check_link1}"><span>{name11} </span> </a>
                            <ul class="nav-sub">
                                <li class="nav-sub-item"><a href=""> Về chúng tôi</a>
                                    <ul class="nav-sub-child">
                                        <li class="nav-sub-item-child"><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i> Thông tin công ty</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> --}}

                </div>
                    
                <div class="search" id="search">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form_search" id="form1" name="form1" method="get" action="{{ makeLink('search') }}" style = "display:flex;">
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

<script type="text/javascript">
    $('.btn-signin').on( "click", function() {
        $('#myModalSignIn').addClass('show');
        return false;
    })
    $('#myModalSignIn .modal-bg, #myModalSignIn .close').on( "click", function() {
        $('#myModalSignIn').removeClass('show');
    })
</script>
@else

@endguest
