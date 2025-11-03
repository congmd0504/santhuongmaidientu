@extends('frontend.layouts.main')
@section('title', $header['seo_home']->name)
@section('image', asset($header['seo_home']->image_path))
@section('keywords', $header['seo_home']->slug)
@section('description', $header['seo_home']->value)
@section('abstract', $header['seo_home']->slug)
@section('css')

    <style>
         span.sale-acstion {
            position: absolute;
            top: 10px;
            z-index: 999;
            left: 15px;
            padding: 0px 8px;
            background: #ff0000d1;
            border-radius: 5px;
            color: #fff;
        }
         span.sale-acstion2 {
            position: absolute;
            top: 10px;
            z-index: 999;
            right: 15px;
            padding: 0px 8px;
            background: #ff0000d1;
            border-radius: 5px;
            color: #fff;
        }

       
        .price-box {
    text-align: center;
}
        .item-link h2 {
            font-size: 17px;
    text-align: center;
    margin: 0;
    padding: 10px;
    font-weight: 600;
        }

        .item-link {
            background: #fff;
            border-radius: 10px;
            border: 2px solid #d4cccc;
            box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 1px, rgba(0, 0, 0, 0.07) 0px 2px 2px, rgba(0, 0, 0, 0.07) 0px 4px 4px, rgba(0, 0, 0, 0.07) 0px 8px 8px, rgba(0, 0, 0, 0.07) 0px 16px 16px;
        }

        .item-link .box-img img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .item-link .box-img {
            text-align: center;
        }

        .item-link:hover {
            /* background: #000B5D; */
        }

        .item-link:hover h2 {
            /* color: #fff; */
        }

        .box-link {
            /*display: none;*/
        }

        .row.mobile-sp-new {
            display: none;
        }
        @media(max-width:900px){
            body{
                padding-top: 0px !important;
            }
            .item-link .box-img img {
                width: 100%;
                height: 100px;
            }
            .item-link h2 {
                font-size: 15px;
            }

        }

        @media(max-width:550px) {

            .col-lg-3:first-child,
            .col-md-3:first-child,
            .col-sm-3:first-child,
            .col-3:first-child {
                padding-left: 10px;
                padding-right: 5px;
            }


            .col-lg-3:nth-child(3),
            .col-md-3:nth-child(3),
            .col-sm-3:nth-child(3),
            .col-3:nth-child(3),
            .col-lg-3:nth-child(2),
            .col-md-3:nth-child(2),
            .col-sm-3:nth-child(2),
            .col-3:nth-child(2) {
                padding-left: 5px;
                padding-right: 5px;
            }

            .col-lg-3:nth-child(4),
            .col-md-3:nth-child(4),
            .col-sm-3:nth-child(4),
            .col-3:nth-child(4) {
                padding-left: 5px;
                padding-right: 10px;
            }

            .row.desktop-sp-new {
                display: none;
            }

            .row.mobile-sp-new .item_product_main .product-info {
                min-height: auto;
            }

            .row.mobile-sp-new {
                display: block;
            }

            .item-link h2 {
                font-size: 8px;
                padding: 4px 0;
            }

            /* .col-lg-3.col-md-3.col-sm-3.col-3 {
                                                    padding: 0 2px;
                                                } */

            .box-link {
                display: block;
            }

            .price-box div {
                display: contents;
            }

            .section-4 {
                background: unset
            }

            footer {
                display: none;
            }

            .main {
                margin-bottom: 40px
            }

            .box_news {
                display: none;
            }
        }

        .box_news {
            display: none;
        }

   

    </style>
@endsection
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
                                            <a href="{{ $item->slug }}" target="_blank"><img src="{{ $item->image_path }}"
                                                    alt="{{ $item->name }}"></a>
                                        </div>
                                    @endforeach
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
            @if ($listCateHome) 
                <div class="container">
                    <div class="box-link">
                        <div class="row">
                            @foreach ($listCateHome as $i)
                                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                                    <div class="item-link">
                                        <div class="box-img">
                                            <a
                                                href="{{ route('product.productByCategory', ['id' => $i->id, 'slug' => $i->slug]) }}"><img
                                                    src="{{ $i->icon_path }}" alt="{{ $i->name }}"></a>
                                        </div>
                                        <div class="box-name">
                                            <a
                                                href="{{ route('product.productByCategory', ['id' => $i->id, 'slug' => $i->slug]) }}">

                                                <h2>{{ $i->name }}</h2>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <section class="section_product_new section_giovang">
                <div class="container ">
                    <div class="  item-section_giovang">
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
                                @if (isset($productsGioVang) && $productsGioVang->count() > 0)
                                    <div class="swiper-container">
                                        <div class="slider slide6_row2b cate_rows">
                                            @php
                                                $chunks = $productsGioVang->chunk(1);
                                            @endphp
                                            @foreach ($chunks as $items)
                                                <div class="swiper-slide">
                                                    @foreach ($items as $item)
                                                        <div class="item_product_main" data-url="{{ $item->slug_full }}"
                                                            data-id="{{ $item->id }}">
                                                            <div class="product-thumbnail">
                                                                @if ($item->price && $item->sale)
                                                                    <span
                                                                        class="product-percent">-{{ $item->sale }}%</span>
                                                                @endif
                                                                <a class="image_thumb" href="{{ $item->slug_full }}"
                                                                    title="{{ $item->name }}">
                                                                    <img class="lazyload"
                                                                        src="{{ asset($item->avatar_path) }}"
                                                                        alt="{{ $item->name }}" />
                                                                </a>
                                                                <div class="image-tools">
                                                                    <a class="quickView styleBtnBuy add-to-cart" data-url="{{ route('cart.add', ['id' => $item->id]) }}">
                                                                        <i class="fa fa-cart-plus"></i> Đặt hàng </a>
                                                                    <a class="styleBtnBuy" href="{{ $item->slug_full }}"><i
                                                                            class="fa fa-eye"></i> Xem chi tiết</a>
                                                                </div>
                                                            </div>
                                                            <div class="product-info">
                                                                <h3 class="product-name">
                                                                    <a href="{{ $item->slug_full }}"
                                                                        title="{{ $item->name }}">{{ $item->name }}</a>
                                                                </h3>
                                                                <div class="bottom-action">
                                                                    <div class="price-box">
                                                                        @if ($item->sale > 0)
                                                                            <span
                                                                                class="compare-price">{{ number_format($item->price) }}{{ $unit }}</span>
                                                                        @endif
                                                                        <div>
                                                                            <span
                                                                                class="price">{{ $item->price ? number_format($item->price_after_sale) . 'đ' : 'Liên hệ' }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="fs-goods__dt-btm">
                                                                    <div class="ld-price__flash-process new">
                                                                        <div class="ld-price__flash-process_left"
                                                                            style="width: 75%;"></div>
                                                                        <div class="ld-price__flash-process_right"></div>
                                                                    </div>
                                                                    <div style="width: 100%; font-size: 12px;">
                                                                        <span>75% Đã bán</span>
                                                                    </div>
                                                                </div> --}}
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
                            @if (isset($sp_km) && $sp_km)
                                <div class="title-flash-sale">
                                    <h2 class="title-block">
                                        {{ $sp_km->name }}.
                                    </h2>
                                    <p>{{ $sp_km->value }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="">
                                @if (isset($sp_km) && $sp_km)
                                    <div class="slider_banner autoplay3 cate_rows">
                                        @foreach ($sp_km->childs()->where('active', 1)->get() as $item)
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

                            @if (isset($productHot) && $productsGioVang->count() > 0)
                                <div class="">
                                    <div class="swiper-container slieproduct-new autoplay5 cate_rows">
                                        @foreach ($productsGioVang as $item)
                                            <div class="item">
                                                <div class="item_product_main" data-url="{{ $item->slug_full }}"
                                                    data-id="{{ $item->id }}">
                                                    <div class="product-thumbnail">
                                                        @if ($item->price && $item->sale)
                                                            <span class="product-percent">-{{ $item->sale }}%</span>
                                                        @endif
                                                        <a class="image_thumb" href="{{ $item->slug_full }}"
                                                            title="{{ $item->name }}">
                                                            <img class="lazyload" src="{{ asset($item->avatar_path) }}"
                                                                alt="{{ $item->name }}" />
                                                        </a>
                                                        <div class="image-tools">
                                                            <a class="quickView styleBtnBuy add-to-cart" data-url="{{ route('cart.add', ['id' => $item->id]) }}"><i
                                                                    class="fa fa-cart-plus"></i> Đặt hàng </a>
                                                            <a class="styleBtnBuy" href="{{ $item->slug_full }}"><i
                                                                    class="fa fa-eye"></i> Xem chi tiết</a>
                                                        </div>
                                                    </div>
                                                    <div class="product-info">
                                                        <h3 class="product-name">
                                                            <a href="{{ $item->slug_full }}"
                                                                title="{{ $item->name }}">{{ $item->name }}</a>
                                                        </h3>
                                                        <div class="bottom-action">
                                                            <div class="price-box">
                                                                @if ($item->sale > 0)
                                                                    <span
                                                                        class="compare-price">{{ number_format($item->price) }}{{ $unit }}</span>
                                                                @endif
                                                                <div>
                                                                    <span
                                                                        class="price">{{ $item->price ? number_format($item->price_after_sale) . 'đ' : 'Liên hệ' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="fs-goods__dt-btm">
                                                            <div class="ld-price__flash-process new">
                                                                <div class="ld-price__flash-process_left"
                                                                    style="width: 55%;"></div>
                                                                <div class="ld-price__flash-process_right"></div>
                                                            </div>
                                                            <div style="width: 100%; font-size: 12px;">
                                                                <span>55% Đã bán</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <div class="section-4">
                <div class="container">
                    <div class="row pd-left-right">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm</h3>
                            </div>
                            <div class="row desktop-sp-new">
                                @isset($productHot)
                                    @foreach ($productHot as $product)
                                        <div class="col-2dot4 col-md-3 col-sm-6 col-xs-6 col-6 ">
                                            <div class="product-card">
                                                <div class="box">
                                                    <div class="card-top">
                                                        <div class="image">
                                                            <a href="{{ $product->slug_full }}">
                                                                <img src="{{ asset($product->avatar_path) }}"
                                                                    alt="Sofa phòng khách SF08"
                                                                    class="image-card image-default">
                                                            </a>
                                                            @if ($product->sale > 0 || $product->phantramdiem > 0)
                                                                <span class="sale-acstion">
                                                                    @if ($product->sale > 0)
                                                                        {{ 'Sale ' . $product->sale . '%' }}
                                                                    @endif
                                                                </span>
                                                                @if ($product->phantramdiem > 0)
                                                                <span class="sale-acstion2">
                                                                    - {{ intval($product->phantramdiem) }}%(BB)
                                                                </span>
                                                                    @endif
                                                            @endif

                                                        </div>
                                                        <ul class="list-quick">
                                                            <li class="quick-view">
                                                                <a href="{{ $product->slug_full }}"><i class="fa fa-eye"
                                                                        aria-hidden="true"></i></a>
                                                            </li>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <h4 class="card-name"><a
                                                                href="{{ $product->slug_full }}">{{ $product->name }}</a>
                                                        </h4>
                                                        <div class="card-price">
                                                            <span
                                                                class="new-price">{{ number_format($product->price_after_sale) }}
                                                                {{ $unit }}</span>
                                                            @if ($product->sale > 0)
                                                                <span class="old-price">{{ number_format($product->price) }}
                                                                    {{ $unit }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                            <div class="row mobile-sp-new">
                                <div class="swiper-container">
                                    <div class="row slider  cate_rows">
                                        @foreach ($productHot as $item)
                                            <div class="col-6">
                                                <div class="item_product_main" data-url="{{ $item->slug_full }}"
                                                    data-id="{{ $item->id }}">
                                                    <div class="product-thumbnail">
                                                    @if ($item->sale > 0 || $item->phantramdiem > 0)
                                                                <span class="sale-acstion">
                                                                    @if ($item->sale > 0)
                                                                        {{ 'Sale ' . $item->sale . '%' }}
                                                                    @endif
                                                                </span>
                                                                @if ($item->phantramdiem > 0)
                                                                <span class="sale-acstion2">
                                                                    - {{ intval($item->phantramdiem) }}%(BB)
                                                                </span>
                                                                    @endif
                                                            @endif
                                                        <a class="image_thumb" href="{{ $item->slug_full }}"
                                                            title="{{ $item->name }}">
                                                            <img class="lazyload" src="{{ asset($item->avatar_path) }}"
                                                                alt="{{ $item->name }}" />
                                                        </a>
                                                        <div class="image-tools">
                                                            <a class="quickView styleBtnBuy add-to-cart" data-url="{{ route('cart.add', ['id' => $item->id]) }}"><i
                                                                    class="fa fa-cart-plus"></i> Đặt hàng </a>
                                                            <a class="styleBtnBuy" href="{{ $item->slug_full }}"><i
                                                                    class="fa fa-eye"></i> Xem chi tiết</a>
                                                        </div>
                                                    </div>
                                                    <div class="product-info">
                                                        <h3 class="product-name">
                                                            <a href="{{ $item->slug_full }}"
                                                                title="{{ $item->name }}">{{ $item->name }}</a>
                                                        </h3>
                                                        <div class="bottom-action">
                                                            <div class="price-box">
                                                                @if ($item->sale > 0)
                                                                    <span
                                                                        class="compare-price">{{ number_format($item->price) }}{{ $unit }}</span>
                                                                @endif
                                                                <div>
                                                                    <span
                                                                        class="price">{{ $item->price ? number_format($item->price_after_sale) . 'đ' : 'Liên hệ' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{{ route('product.new') }}" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>

            {{--<div class="box_news">
                <div class="container">
                    <div class="row pd-left-right">
                        @if (isset($hd_ct) && $hd_ct)
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
                                            <a href="{{ $img_hd->slug_full ?? '' }}"
                                                style="background-image: url('{{ $img_hd->avatar_path ?? '' }}')"></a>
                                        </li>
                                        @foreach ($hd_ct->posts()->where('active', 1)->orderByDesc('created_at')->get() as $item)
                                            <li><a href="{{ $item->slug_full }}">{{ $item->name }}</a></li>
                                        @endforeach
                                    </div>
                                    <a class="button primary is-underline lowercase mlhxtc"
                                        href="{{ $hd_ct->slug_full }}">
                                        <span>Xem tất cả</span><i class="icon-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (isset($hethong) && $hethong)
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="box_video">
                                    <div class="title_top">
                                        {{ $hethong->name }}
                                    </div>
                                    <div class="box_news_in">
                                        <li class="first_post">
                                            <a href="{{ $hethong->slug_full }}"
                                                style="background-image: url('{{ $hethong->image_path }}')"></a>
                                        </li>
                                        <div class="list-shop0">
                                            <ul class="list-shop menu">
                                                @foreach ($hethong->childs()->where('active', 1)->get() as $item)
                                                    <li class=""><strong>{{ $item->name }}: </strong>
                                                        <p>{!! $item->description !!}</p>

                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <a class="button primary is-underline lowercase mlhxtc"
                                        href="{{ $hethong->slug_full }}">
                                        <span>Xem tất cả</span><i class="icon-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (isset($km_news) && $km_news)
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
                                            <a href="{{ $img_news->slug_full ?? '' }}"
                                                style="background-image: url('{{ $img_news->avatar_path ?? '' }}')"></a>
                                        </li>
                                        @foreach ($km_news->posts()->where('active', 1)->orderByDesc('created_at')->get() as $item)
                                            <li><a href="{{ $item->slug_full }}">{{ $item->name }}</a></li>
                                        @endforeach
                                    </div>
                                    <a class="button primary is-underline lowercase mlhxtc"
                                        href="{{ $km_news->slug_full }}">
                                        <span>Xem tất cả</span><i class="icon-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

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
                        slidesPerView: 5,
                        spaceBetween: 20
                    },
                    1400: {
                        slidesPerView: 5,
                        spaceBetween: 20
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
                        slidesPerView: 6,
                        spaceBetween: 20
                    },
                    1400: {
                        slidesPerView: 6,
                        spaceBetween: 20
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
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    1400: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    }
                }
            });


        })
        window.addEventListener('DOMContentLoaded', (event) => {})
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

            let fulltime = (hours * 360) + (minutes * 60) + seconds;

            // Unix timestamp (in seconds) to count down to
            var twoDaysFromNow = (new Date().getTime() / 1000) + (86400) + 1 - fulltime;

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
    <script>
        $('.slide6_row2b').slick({
            dots: false,
            arrows: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            speed: 600,
            autoplaySpeed: 3000,
            responsive: [{
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
