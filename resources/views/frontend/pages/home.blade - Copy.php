@extends('frontend.layouts.main')
@section('title', $header['seo_home']->name)
@section('image', asset($header['seo_home']->image_path))
@section('keywords', $header['seo_home']->slug)
@section('description', $header['seo_home']->value)
@section('abstract', $header['seo_home']->slug)

@section('content')
<link href="{{ asset('assets/index.scss.css') }}" rel="stylesheet" type="text/css" />
    <div class="content-wrapper">
        <div class="main">
            <div class="container">
                    <div class="row">
                        <h1 class="d-none">
                            {h1trangchu}
                        </h1>
                        <h2 class="d-none">
                            {h2trangchu}
                        </h2>
                        <div class="col-lg-12">
                                <div class="slide">
                                    @isset($slider)
                                        <div class="box-slide faded">
                                            @foreach ($slider as $item)
                                                <div class="item-slide">
                                                    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endisset
                                </div>
                        </div>
                        {{--<div class="col-lg-3" style = "background-color: white;">
                            <div class="row">
                                <div class="tin-noibat">
                                    <div class="h2">Tin tức nổi bật</div>
                                    <ul>
                                        <li>
                                            <div class="img-new-noibat">
                                                <a href="">
                                                    <img src="https://demo.dailylifehtc.com/storage/product/48/2wkGmVQWeKSGPEmKaD0s.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="content-new-noibat">
                                                <a href="">
                                                    <p>Thành phần và công dụng của thực phẩm chức năng </p>
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="img-new-noibat">
                                                <a href="">
                                                    <img src="https://demo.dailylifehtc.com/storage/product/48/2wkGmVQWeKSGPEmKaD0s.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="content-new-noibat">
                                                <a href="">
                                                    <p>Thành phần và công dụng của thực phẩm chức năng. Thành phần và công dụng của thực phẩm chức năng </p>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                
            </div>

            {{--<div class="tin-noi-bat">

            </div>--}}

            <section class="section_product_new section_giovang">
                <div class="container ">
                    <div class="  item-section_giovang" >
                        <div class="col-sm-12 col-12">
                            <div class="title-flash-sale">
                                <h2 class="title-block">
                                    GIỜ VÀNG DEAL SỐC
                                </h2>
                                <div class="example">
                                    <p>Kết thúc sau:</p>
                                    <div id="flipdown" class="flipdown"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="">
                                @if(isset($productsGioVang)&& $productsGioVang->count()>0)                   
                                <div class="swiper-container">
                                    <div class="slider slide6_row2b cate_rows">
                                        @php
                        
                                            $chunks = $productsGioVang->chunk(1);
                                        @endphp
                                        @foreach($chunks as $items)
                                        <div class="swiper-slide">
                                            @foreach($items as $item)
                                                <div class="item_product_main" data-url="{{ $item->slug_full }}" data-id="{{ $item->id }}">
                                                    
                                                    <div class="product-thumbnail">
                                                        @if($item->price && $item->sale)
                                                            <span class="product-percent">-{{ $item->sale}}%</span>
                                                        @endif
                                                        <a class="image_thumb" href="{{ $item->slug_full }}" title="{{ $item->name }}">
                                                            <img class="lazyload" src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}" />
                                                        </a>
                                                        <div class="image-tools">
                                                            <a class="quickView styleBtnBuy" href="{{ $item->slug_full }}"><i class="fa fa-cart-plus"></i> Đặt hàng </a>
                                                            <a class="styleBtnBuy" href="{{ $item->slug_full }}"><i class="fa fa-eye"></i> Xem chi tiết</a>
                                                        </div>
                                                    </div>
                                                    <div class="product-info">
                                                        <h3 class="product-name">
                                                            <a href="{{ $item->slug_full }}" title="{{ $item->name }}">{{ $item->name }}</a>
                                                        </h3>

                                                        <div class="bottom-action">
                                                            <div class="price-box">
                                                                
                                                                @if ($item->sale>0)
                                                                <span class="compare-price">{{ number_format($item->price) }}{{ $unit }}</span>
                                                                @endif
                                                                <div>
                                                                    <span class="price">{{ $item->price?number_format($item->price_after_sale)."đ":"Liên hệ" }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="fs-goods__dt-btm">
                                                            <div class="ld-price__flash-process new">
                                                                <div class="ld-price__flash-process_left" style="width: 30%;"></div>
                                                                <div class="ld-price__flash-process_right"></div>
                                                            </div>
                                                            <div style="width: 100%; font-size: 12px;">
                                                                <span>30% Đã bán</span>
                                                            </div>
                                                        </div>
                                                 
                                                    </div>  
                                                </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                        
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <section class="section_product_new section_sp_km">
                <div class="container">
                    <div class=" item-section_sp_km">
                        <div class="col-sm-12 col-12">
                            @if(isset($sp_km)&& $sp_km)
                            <div class="title-flash-sale">
                                <h2 class="title-block">
                                    {{ $sp_km->name }}
                                </h2>
                                <p>{{ $sp_km->value }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="">
                                @if(isset($sp_km)&&$sp_km)
                                <div class="slider_banner autoplay3 cate_rows">
                                    @foreach($sp_km->childs()->where('active', 1)->get() as $item)
                                    <div class="item">
                                        <div class="banner_item">
                                            <div class="image">
                                                <a href="{{ $item->slug }}">
                                                    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            
                            @if(isset($productsGioVang)&& $productsGioVang->count()>0)
                            <div class="">              
                                <div class="swiper-container slieproduct-new autoplay5 cate_rows">
                                    @foreach($productsGioVang as $item)
                        
                                    <div class="item">
                                        <div class="item_product_main" data-url="{{ $item->slug_full }}" data-id="{{ $item->id }}">

                                            <div class="product-thumbnail">
                                                @if($item->price && $item->sale)
                                                    <span class="product-percent">-{{ $item->sale}}%</span>
                                                @endif
                                                <a class="image_thumb" href="{{ $item->slug_full }}" title="{{ $item->name }}">
                                                    <img class="lazyload" src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}" />
                                                </a>
                                                <div class="image-tools">
                                                    <a class="quickView styleBtnBuy" href="{{ $item->slug_full }}"><i class="fa fa-cart-plus"></i> Đặt hàng </a>
                                                    <a class="styleBtnBuy" href="{{ $item->slug_full }}"><i class="fa fa-eye"></i> Xem chi tiết</a>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h3 class="product-name">
                                                    <a href="{{ $item->slug_full }}" title="{{ $item->name }}">{{ $item->name }}</a>
                                                </h3>

                                                <div class="bottom-action">
                                                    <div class="price-box">

                                                        @if ($item->sale>0)
                                                        <span class="compare-price">{{ number_format($item->price) }}{{ $unit }}</span>
                                                        @endif
                                                        <div>
                                                            <span class="price">{{ $item->price?number_format($item->price_after_sale)."đ":"Liên hệ" }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="fs-goods__dt-btm">
                                                    <div class="ld-price__flash-process new">
                                                        <div class="ld-price__flash-process_left" style="width: 30%;"></div>
                                                        <div class="ld-price__flash-process_right"></div>
                                                    </div>
                                                    <div style="width: 100%; font-size: 12px;">
                                                        <span>30% Đã bán</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            {{--<a href="{{ route('product.sale') }}" target="_self" class="button primary is-underline lowercase mlhxtc mlhxtcm">
                                <span>Xem tất cả</span><i class="fa fa-chevron-right"></i>
                            </a>--}}
                            @endif
                            </div>
                        </div>
                    </div>
            </section>


            {{--<section class="section_product_new section_sp_bc" style="background-color: #fff">
                <div class="container">
                    <div class="row">
                        <div class="img_light_l">
                            <img src="{{ asset('frontend/images/light_left.png')}}" alt="Light left">
                        </div>
                        <div class="img_light_r">
                            <img src="{{ asset('frontend/images/light_right.png')}}" alt="Light right">
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="title-block">
                                <p>SGFE</p>
                                <h2>SẢN PHẨM BÁN CHẠY NHẤT</h2>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            @if(isset($productsGioVang)&& $productsGioVang->count()>0)                   
                                <div class="swiper-container">
                                    <div class="slider slide5_row2">
                                        @php
                                            $chunks2 = $productsGioVang->chunk(2);
                                        @endphp
                                        @foreach($chunks2 as $items)
                                        <div class="swiper-slide">
                                            @foreach($items as $item)
                                                <div class="item_product_main" data-url="{{ $item->slug_full }}" data-id="{{ $item->id }}">
                                                    
                                                    <div class="product-thumbnail">
                                                        @if($item->price && $item->sale)
                                                            <span class="product-percent">-{{ $item->sale}}%</span>
                                                        @endif
                                                        <a class="image_thumb" href="{{ $item->slug_full }}" title="{{ $item->name }}">
                                                            <img class="lazyload" src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}" />
                                                        </a>
                                                        <div class="image-tools">
                                                            <a class="quickView styleBtnBuy" href="{{ $item->slug_full }}"><i class="fa fa-cart-plus"></i> Đặt hàng </a>
                                                            <a class="styleBtnBuy" href="{{ $item->slug_full }}"><i class="fa fa-eye"></i> Xem chi tiết</a>
                                                        </div>
                                                    </div>
                                                    <div class="product-info">
                                                        <h3 class="product-name">
                                                            <a href="{{ $item->slug_full }}" title="{{ $item->name }}">{{ $item->name }}</a>
                                                        </h3>

                                                        <div class="bottom-action">
                                                            <div class="price-box">
                                                                
                                                                @if ($item->sale>0)
                                                                <span class="compare-price">{{ number_format($item->price) }}{{ $unit }}</span>
                                                                @endif
                                                                <div>
                                                                    <span class="price">{{ $item->price?number_format($item->price_after_sale)."đ":"Liên hệ" }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mua_ngay2">
                                                            <a href="{{ $item->slug_full }}">
                                                                <span>Mua ngay</span>
                                                            </a>
                                                        </div>                                                 
                                                    </div>  
                                                </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="col-sm-12 col-12">
                            <div class="dac_quyen">
                                <div class="img_light_l2">
                                    <img src="{{ asset('frontend/images/light_left.png')}}" alt="Light left">
                                </div>
                                <div class="img_light_r2">
                                    <img src="{{ asset('frontend/images/light_right.png')}}" alt="Light right">
                                </div>
                                @if(isset($dac_quyen) && $dac_quyen)
                                <div class="row">
                                    <div class="col-sm-12 col-12">
                                        <div class="title-block title-block2">
                                            <h2>{{ $dac_quyen->name }}</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-lg-12 col-12">
                                                <div class="row">
                                                    <div class="list_sp">
                                                        @foreach($dac_quyen->childs()->where('active', 1)->get() as $item)
                                                        <div class="item">
                                                            <div class="box">
                                                                <div class="image">
                                                                    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
                                                                </div>
                                                                <p>{{ $item->name }}</p>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="hoa_co">
                            <img src="{{ asset('frontend/images/hoa_co.png')}}" alt="Hoa cỏ">
                        </div>
                    </div>
                </div>
            </section>--}}


            {{--
            <div class="section-1">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Danh mục sản phẩm</h3>
                                <div class="desc">
                                    Chúng tôi cung cấp đa dạng các dòng nội thất khác nhau trong các lĩnh vực từ văn phòng, trường học, gia đình cho đến các công trình công cộng.
                                </div>
                            </div>
                            @isset($listCategory)
                                <div class="list-card">
                                    <div class="row">
                                        @foreach ($listCategory as $category)
                                            <div class="col-md-3 col-sm-6 col-6">
                                                <div class="card">
                                                    <a href="{{ $category->slug_full }}" class="box">
                                                        <div class="image">
                                                            <img src="{{  $category->avatar_path }}" alt="{{  $category->name }}">
                                                        </div>
                                                        <h3>{{  $category->name }}</h3>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
            --}}
            {{-- <div class="section-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm nổi bật</h3>
                            </div>
                            <div class="row">
                                @isset($productHot)
                                    @foreach($productHot as $product)
                                    <div class="col-2dot4 col-md-3 col-sm-6 col-xs-6 col-6">
                                        <div class="product-card">
                                            <div class="box">
                                                <div class="card-top">
                                                    <div class="image">
                                                        <a href="{{ $product->slug_full }}">
                                                            <img src="{{ asset($product->avatar_path) }}" alt="Sofa phòng khách SF08" class="image-card image-default">
                                                        </a>
                                                        @if ($product->sale)
                                                        <span class="sale-1">-{{ $product->sale }}%</span>
                                                        @endif
                                                    </div>
                                                    <ul class="list-quick">
                                                        <li class="quick-view">
                                                            <a href="{{ $product->slug_full }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        </li>
                                                        <li class="cart quick-cart">
                                                            <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id,]) }}"><i class="fas fa-cart-plus"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-name"><a href="{{ $product->slug_full }}">{{ $product->name }}</a></h4>
                                                    <div class="card-price">
                                                        <span class="new-price">{{ $product->price_after_sale }} {{ $unit  }}</span>
                                                        @if ($product->sale>0)
                                                        <span class="old-price">{{ $product->price }} {{ $unit  }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endisset
                            </div>
                          <div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{linkhost}/san-pham.html" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="section-4">
                <div class="container">
                    <div class="row pd-left-right">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm mới</h3>
                            </div>
                            <div class="row">
                                @isset($productNew)
                                    @foreach($productNew as $product)
                                    <div class="col-2dot4 col-md-3 col-sm-6 col-xs-6 col-6 ">
                                        <div class="product-card">
                                            <div class="box">
                                                <div class="card-top">
                                                    <div class="image">
                                                        <a href="{{ $product->slug_full }}">
                                                            <img src="{{ asset($product->avatar_path) }}" alt="Sofa phòng khách SF08" class="image-card image-default">
                                                        </a>
                                                        @if ($product->sale)
                                                        <span class="sale-1">-{{ $product->sale }}%</span>
                                                        @endif

                                                    </div>
                                                    <ul class="list-quick">
                                                        <li class="quick-view">
                                                            <a href="{{ $product->slug_full }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        </li>
                                                        {{-- <li class="cart quick-cart">
                                                            <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id,]) }}"><i class="fas fa-cart-plus"></i></a>
                                                        </li> --}}
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-name"><a href="{{ $product->slug_full }}">{{ $product->name }}</a></h4>
                                                    <div class="card-price">
                                                        <span class="new-price">{{ number_format($product->price_after_sale) }} {{ $unit  }}</span>
                                                        @if ($product->sale>0)
                                                        <span class="old-price">{{ number_format($product->price)  }} {{ $unit  }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endisset
                            </div>
                            {{--<div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{{ route('product.new') }}" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>--}}

                        </div>
                    </div>
                </div>
            </div>

            {{--<div class="section_5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm xem nhiều</h3>
                            </div>
                            <div class="row">
                                @isset($productView)
                                    @foreach($productView as $product)
                                    <div class="col-2dot4 col-md-3 col-sm-6 col-xs-6 col-6 sp_moi_home">
                                        <div class="product-card">
                                            <div class="box">
                                                <div class="card-top">
                                                    <div class="image">
                                                        <a href="{{ $product->slug_full }}">
                                                            <img src="{{ asset($product->avatar_path) }}" alt="Sofa phòng khách SF08" class="image-card image-default">
                                                        </a>
                                                        @if ($product->sale)
                                                        <span class="sale-1">-{{ $product->sale }}%</span>
                                                        @endif

                                                    </div>
                                                    <ul class="list-quick">
                                                        <li class="quick-view">
                                                            <a href="{{ $product->slug_full }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-name"><a href="{{ $product->slug_full }}">{{ $product->name }}</a></h4>
                                                    <div class="card-price">
                                                        <span class="new-price">{{ number_format($product->price_after_sale)  }} {{ $unit  }}</span>
                                                        @if ($product->sale>0)
                                                        <span class="old-price">{{ number_format($product->price) }} {{ $unit  }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endisset
                            </div>
                            <div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{linkhost}/san-pham.html" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>--}}

            {{-- <div class="section-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm mua nhiều</h3>
                            </div>
                            <div class="row">
                                @isset($productPay)
                                    @foreach($productPay as $product)
                                    <div class="col-2dot4 col-md-3 col-sm-6 col-xs-6 col-6">
                                        <div class="product-card">
                                            <div class="box">
                                                <div class="card-top">
                                                    <div class="image">
                                                        <a href="{{ $product->slug_full }}">
                                                            <img src="{{ asset($product->avatar_path) }}" alt="Sofa phòng khách SF08" class="image-card image-default">
                                                        </a>
                                                        @if ($product->sale)
                                                        <span class="sale-1">-{{ $product->sale }}%</span>
                                                        @endif

                                                    </div>
                                                    <ul class="list-quick">
                                                        <li class="quick-view">
                                                            <a href="{{ $product->slug_full }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        </li>
                                                        <li class="cart quick-cart">
                                                            <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id,]) }}"><i class="fas fa-cart-plus"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-name"><a href="{{ $product->slug_full }}">{{ $product->name }}</a></h4>
                                                    <div class="card-price">
                                                        <span class="new-price">{{ $product->price_after_sale }} {{ $unit  }}</span>
                                                        @if ($product->sale>0)
                                                        <span class="old-price">{{ $product->price }} {{ $unit  }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endisset
                            </div>
                            <div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{linkhost}/san-pham.html" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}
            {{--<div class="section-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            @isset($bannerHome)
                                <!-- START BLOCK : quang_cao_home -->
                                <div class="banner">
                                    <a href="{{ $bannerHome->slug }}"><img src="{{ $bannerHome->image_path }}" alt="{{ $bannerHome->name }}"> </a>
                                </div>
                                <!-- END BLOCK : quang_cao_home -->
                            @endisset
                        </div>
                    </div>
                </div>
            </div>--}}
            {{--
            <div class="section-6">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="box-text">
                                <h4>OUR STORIES</h4>
                                <h3>We design <br> everything we make.
                                </h3>
                                <div class="desc">
                                    Sed cursus turpis vitae tortor. Curabitur ligula sapien, tincidunt non, euismod posuere imperdiet, leo. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam cursus lacinia erat. Nulla sit amet est.
                                </div>
                                <div class="box-about">
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" height="512" viewBox="0 0 512 512" width="512"><g><path d="m373.489 364.092c-33.329-8.401-58.793-14.952-68.238-45.384 28.932-15.432 49.831-44.01 54.673-77.708h1.076c33.423 0 60-28.112 60-61 0-10.925-2.949-21.167-8.072-30h23.072c8.284 0 15-6.716 15-15s-6.716-15-15-15h-75v-45c0-41.355-33.645-75-75-75h-60c-41.355 0-75 33.645-75 75v45c-33.084 0-60 26.916-60 60 0 32.894 26.584 61 60 61h1.076c4.842 33.698 25.74 62.276 54.673 77.708-9.473 30.52-35.346 37.093-68.238 45.384-51.068 12.874-107.511 29.199-107.511 132.908 0 8.284 6.716 15 15 15h420c8.284 0 15-6.716 15-15 0-95.348-45.592-117.298-107.511-132.908zm-222.489 27.784c10.202-2.599 20.486-5.39 30.305-9.194 3.332 38.256 35.336 69.318 74.695 69.318 39.338 0 71.361-31.038 74.695-69.317 9.818 3.804 20.103 6.594 30.305 9.194v90.123h-210zm240-211.876c0 16.804-13.738 31-30 31v-61c16.542 0 30 13.458 30 30zm-210-105c0-24.813 20.187-45 45-45h60c24.813 0 45 20.187 45 45v45h-30v-45c0-8.284-6.716-15-15-15h-60c-8.284 0-15 6.716-15 15v45h-30zm90 45h-30v-30h30zm-150 60c0-16.542 13.458-30 30-30v61c-16.262 0-30-14.196-30-31zm60 46v-76h150v76c0 41.355-33.645 75-75 75s-75-33.645-75-75zm75 105c7.206 0 14.244-.731 21.045-2.12 4.899 14.946 12.828 27.07 23.955 36.647v10.473c0 24.935-20.607 46-45 46s-45-21.065-45-46v-10.473c11.127-9.578 19.055-21.701 23.955-36.647 6.801 1.389 13.839 2.12 21.045 2.12zm-135 68.987v82.013h-59.516c3.416-50.491 22.941-70.304 59.516-82.013zm270 82.013v-82.013c36.415 11.658 56.081 31.242 59.516 82.013z"></path></g></svg>
                                        <span>About us</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            --}}

            <div class="box_news">
                <div class="container">
                    <div class="row pd-left-right">
                        @if(isset($hd_ct) && $hd_ct)
                        @php
                            $img_hd = $hd_ct->posts()->where('active', 1)->first();
                        @endphp
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <div class="box_video">
                                <div class="title_top">
                                    {{ $hd_ct->name }}
                                </div>
                                <div class="box_news_in">
                                    <li class="first_post">
                                        <a href="{{ $img_hd->slug_full }}" style="background-image: url('{{ $img_hd->avatar_path }}')"></a>
                                    </li>
                                    @foreach($hd_ct->posts()->where('active', 1)->orderByDesc('created_at')->get() as $item)   
                                    <li><a href="{{ $item->slug_full }}">{{ $item->name }}</a></li>
                                    @endforeach
                                </div>
                                <a class="button primary is-underline lowercase mlhxtc" href="{{ $hd_ct->slug_full }}">
                                    <span>Xem tất cả</span><i class="icon-angle-right"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(isset($hethong) && $hethong)
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <div class="box_video">
                                <div class="title_top">
                                    {{ $hethong->name }}
                                </div>
                                <div class="box_news_in">
                                    <li class="first_post">
                                        <a href="{{ $hethong->slug_full }}" style="background-image: url('{{ $hethong->image_path }}')"></a>
                                    </li>
                                    <div class="list-shop0">
                                        <ul class="list-shop menu">
                                            @foreach($hethong->childs()->where('active', 1)->get() as $item)
                                            <li class=""><strong>{{ $item->name }}: </strong>
                                                <p>{!! $item->description !!}</p>
                                                
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <a class="button primary is-underline lowercase mlhxtc" href="{{ $hethong->slug_full }}">
                                    <span>Xem tất cả</span><i class="icon-angle-right"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(isset($km_news) &&$km_news)
                        @php
                            $img_news = $km_news->posts()->where('active', 1)->first();
                        @endphp
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <div class="box_video">
                                <div class="title_top">
                                    {{ $km_news->name }}
                                </div>
                                <div class="box_news_in">
                                    <li class="first_post">
                                        <a href="{{ $img_news->slug_full }}" style="background-image: url('{{ $img_news->avatar_path }}')"></a>
                                    </li>
                                    @foreach($km_news->posts()->where('active', 1)->orderByDesc('created_at')->get() as $item)
                                    <li><a href="{{ $item->slug_full }}">{{ $item->name }}</a></li>
                                    @endforeach
                                </div>
                                <a class="button primary is-underline lowercase mlhxtc" href="{{ $km_news->slug_full }}">
                                    <span>Xem tất cả</span><i class="icon-angle-right"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            {{--<section class="pt_section_62">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Tin tức nổi bật</h3>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 wrap-news-card">

                                <div class="row">
                                    @isset($postsHot)
                                        <!-- START BLOCK : tin_tuc -->
                                        @foreach ($postsHot as $item)
                                        <div class="fo-03-news col-lg-4 col-md-6 col-sm-6">
                                            <div class="box">
                                                <div class="image">
                                                    <a href="{{ $item->slug_full }}"><img src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}"></a>
                                                </div>
                                                <h3><a href="{{ $item->slug_full }}">{{ $item->name }}</a></h3>
                                                <div class="date">{{ date_format($item->updated_at,"d/m/Y")}} - Admin </div>
                                                <div class="desc">
                                                    {!! $item->description  !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <!-- END BLOCK : tin_tuc -->
                                    @endisset

                                </div>

                        </div>
                    </div>
                </div>
            </section>--}}

            <script>
            $(document).ready(function () {

                var swiperBannerNew = new Swiper('.slider-banner-new', {
                    slidesPerView: 6,
                    //centeredSlides: true,
                    loop: false,
                    grabCursor: true,
                    roundLengths: true,
                    slideToClickedSlide: false,
                    autoplay: false,
                    touchStartPreventDefault: false,
                    autoplay: {
                        delay: 5000,
                    },
                    pagination: {
                        el: '.slider-banner-new .swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        300: {
                            slidesPerView: 1
                        },
                        500: {
                            slidesPerView: 1
                        },
                        640: {
                            slidesPerView: 1
                        },
                        768: {
                            slidesPerView: 1
                        },
                        992: {
                            slidesPerView: 1
                        },
                        1400: {
                            slidesPerView: 1
                        }
                    }
                });

                var swiperNewh = new Swiper('.slieproduct-new', {
                    slidesPerView: 5,
                    //centeredSlides: true,
                    loop: false,
                    grabCursor: true,
                    spaceBetween: 20,
                    roundLengths: true,
                    slideToClickedSlide: false,
                    autoplay: false,
                    touchStartPreventDefault: false,
                    pagination: {
                        el: '.slieproduct-new .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.slieproduct-new .swiper-button-next',
                        prevEl: '.slieproduct-new .swiper-button-prev',
                    },
                    breakpoints: {
                        300: {
                            slidesPerView: 2,
                            spaceBetween: 10
                        },
                        500: {
                            slidesPerView: 2,
                            spaceBetween: 10
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 7
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 7
                        },
                        992: {
                            slidesPerView:5,
                            spaceBetween:20
                        },
                        1400: {
                            slidesPerView:5,
                            spaceBetween:20
                        }
                    }
                });

                var swiperNewh = new Swiper('.slieproduct-new2', {
                    slidesPerView: 6,
                    //centeredSlides: true,
                    loop: false,
                    grabCursor: true,
                    spaceBetween: 20,
                    roundLengths: true,
                    slideToClickedSlide: false,
                    autoplay: false,
                    touchStartPreventDefault: false,
                    pagination: {
                        el: '.slieproduct-new2 .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.slieproduct-new2 .swiper-button-next',
                        prevEl: '.slieproduct-new2 .swiper-button-prev',
                    },
                    breakpoints: {
                        300: {
                            slidesPerView: 2,
                            spaceBetween: 10
                        },
                        500: {
                            slidesPerView: 2,
                            spaceBetween: 10
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 7
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 7
                        },
                        992: {
                            slidesPerView:6,
                            spaceBetween:20
                        },
                        1400: {
                            slidesPerView:6,
                            spaceBetween:20
                        }
                    }
                });

                var bannerSwiper = new Swiper('.banner-swiper', {
                    slidesPerView: 3,
                    //centeredSlides: true,
                    loop: true,
                    grabCursor: true,
                    spaceBetween: 20,
                    roundLengths: true,
                    slideToClickedSlide: false,
                    autoplay: true,
                    touchStartPreventDefault: false,
                    pagination: {
                        el: '.banner-swiper .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.banner-swiper .swiper-button-next',
                        prevEl: '.banner-swiper .swiper-button-prev',
                    },
                    breakpoints: {
                        300: {
                            slidesPerView: 2,
                            spaceBetween: 10
                        },
                        500: {
                            slidesPerView: 2,
                            spaceBetween: 10
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 7
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 7
                        },
                        992: {
                            slidesPerView:3,
                            spaceBetween:20
                        },
                        1400: {
                            slidesPerView:3,
                            spaceBetween:20
                        }
                    }
                });

                
            })
            window.addEventListener('DOMContentLoaded', (event) => {
            })
        </script>

            <script type="text/javascript">
                function scrollToAboutUs() {
                    $('html, body').animate({
                        scrollTop: $(".du_an3").offset().top - 90
                    }, 1000);
                }


                document.addEventListener('DOMContentLoaded', () => {
                let now = new Date();
                let hours = now.getHours();
                let minutes = now.getMinutes();
                let seconds = now.getSeconds();

                let fulltime = (hours * 360) + (minutes*60) + seconds;

                // Unix timestamp (in seconds) to count down to
                var twoDaysFromNow = (new Date().getTime() / 1000) + (86400 ) + 1 - fulltime;

                // Set up FlipDown
                var flipdown = new FlipDown(twoDaysFromNow)

                // Start the countdown
                .start()

                // Do something when the countdown ends
                // .ifEnded(() => {
                //   console.log('The countdown has ended!');
                // });

                });
            </script>

            <!--
            <div class="section-6">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="wrap-left">
                                <div class="wrap-1">
                                    <div class="wrap-email">
                                        <div class="box">
                                            <div class="icon">
                                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            </div>
                                            <h3>Join now and get 10% off your next purchase!</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="wrap-2">
                                    <div class="text">
                                        Subscribe to the weekly newsletter for all the latest updates
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-7 col-xs-12">
                            <div class="box-form">
                                <form action="/action_page.php">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        -->
        </div>
    </div>
@endsection
@section('js')
<script>
     $('.slide6_row2b').slick({
        dots: false,
        arrows: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        speed: 600,
        autoplaySpeed: 3000,
        responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,

            }
        },
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 4,

            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 3,

            }
        },
        {
            breakpoint: 550,
            settings: {
                slidesToShow: 2,

            }
        }
        ]
    });
</script>
@endsection
