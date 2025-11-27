@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')
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

        span.gia-goc {
            text-decoration: line-through;
            font-size: 18px;
            color: #333;
            line-height: 17px;
            display: inline;
        }

        @media(max-width:550px) {
            footer {
                display: none;
            }

            .main {
                margin-bottom: 40px
            }
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs', [
                    'breadcrumbs' => $breadcrumbs,
                    'type' => $typeBreadcrumb,
                ])
            @endisset

            <div class="wrap-content-main wrap-template-product-detail template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="wrap-top">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-9 col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-12 col-sm-12">
                                                        <div class="product-detail-left-content">
                                                            <div class="image">
                                                                <a class="hrefImg" href="{{ asset($data->avatar_path) }}"
                                                                    data-lightbox="image"><img id="expandedImg"
                                                                        src="{{ asset($data->avatar_path) }}"></a>
                                                                <span class="sale-acstion">
                                                                    @if ($data->sale)
                                                                        {{ 'Sale ' . $data->sale . '%' }}
                                                                    @endif
                                                                    @if($data->sale && $data->phantramdiem)
                                                                    -
                                                                    @endif
                                                                    @if ($data->phantramdiem > 0 && $data->is_tinh_diem == 1)
                                                                        {{ number_format($data->phantramdiem) . '%' }}(KTG)
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="list-image-small">
                                                                <div class="slider slide_small">
                                                                <div class="column">
                                                                            <img src="{{ asset($data->avatar_path) }}"
                                                                                alt="{name}">
                                                                        </div>
                                                                    @foreach ($data->images as $image)
                                                                        <div class="column">
                                                                            <img src="{{ asset($image->image_path) }}"
                                                                                alt="{name}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-5 col-md-12 col-sm-12">
                                                        <div class="product-information">
                                                            <h1 class="name-product">{{ $data->name }}</h1>
                                                            {{-- <div class="product-top clearfix">
                                                                <div class="sku-product ">
                                                                    <span class="variant-sku" itemprop="sku"
                                                                        content="LBSWP45">Mã: LBSWP45</span>
                                                                </div>
                                                            </div> --}}
                                                            <div class="group-power">
                                                                <div class="price-box clearfix">
                                                                    <span class="special-price">
                                                                        @if ($data->sale > 0)
                                                                            <span id="new-price"
                                                                                class="price product-price">
                                                                                {{ number_format(($data->price * (100 - $data->sale)) / 100) . ' ' . $unit }}
                                                                            </span>
                                                                            <span class="gia-goc">
                                                                                {{ number_format($data->price) . ' ' . $unit }}
                                                                            </span>
                                                                        @else
                                                                            <span id="new-price"
                                                                                class="price product-price">
                                                                                {{ number_format($data->price) . ' ' . $unit }}
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                    {{-- <span class="munber_buyed">Đã bán 277</span> --}}
                                                                    <span class="save-price d-none">Đang sale:
                                                                        <span class="price product-price-save"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="box-price-detail">
                                                                <span class="new-price">{{ number_format($data->price)." ".$unit }}</span>
                                                                <div class="desc-price">{{( number_format($data->sale? $data->price*(100- $data->sale)/100:$data->price)) ." ".$unit }}</div>
                                                            </div> --}}
                                                            <div class="gioi_thieu">
                                                                {!! $data->description !!}
                                                            </div>
                                                            <div class="product-action">
                                                                @if ($data->het_hang == 1)
                                                                    <div class="list-btn-action clearfix">
                                                                        <a class="btn-buynow addnow" href="javascript:">
                                                                            <p>Hết Hàng </p>
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    <div class="list-btn-action clearfix">
                                                                        <a class="btn-add-cart add-to-cart"
                                                                            data-url="{{ route('cart.add', ['id' => $data->id]) }}">Thêm
                                                                            Vào Giỏ Hàng</a>
                                                                        <a class="btn-buynow addnow"
                                                                            href="{{ route('cart.buy', ['id' => $data->id]) }}">
                                                                            <p>ĐẶT HÀNG NGAY </p><span>Giao Hàng
                                                                                Nhanh</span>
                                                                        </a>
                                                                        {{-- <a class="btn-buynow addnow" href="/contact"><p>ĐẶT HÀNG NGAY </p><span>Giao Hàng Nhanh Toàn Quốc Miễn Phí</span></a> --}}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="product_featured">
                                                                <ul class="featuredelly">
                                                                    <li class="spcl"><i class="fa fa-thumbs-up"></i><b
                                                                            class="txt-uppercase">Cam kết chất lượng</b>Cam
                                                                        kết sản phẩm đúng chất lượng miêu tả trên website.
                                                                    </li>
                                                                    <li class="pvcct"><i class="fa fa-shield-alt"></i><b
                                                                            class="txt-uppercase">Bảo hành 3 tới 6
                                                                            tháng</b>Hỗ trợ bảo dưỡng sản phẩm trọn đời</li>
                                                                    <li class="dhmp"><i class="fa fa-user-check"></i><b
                                                                            class="txt-uppercase">Kiểm tra hàng trước khi
                                                                            thanh toán</b>Được kiểm tra hàng trước khi nhận
                                                                        &amp; thanh toán, không ưng ý không mua không phải
                                                                        trả bất cứ khoản phí nào.</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="box_content_detail">
                                                            <h2>Thông tin chi tiết sản phẩm</h2>
                                                            <div class="tab-text">
                                                                {!! $data->content !!}
                                                            </div>
                                                            <div id="fb-root"></div>
                                                            @if ($data->content2)
                                                                <div class="hoidap">
                                                                    <div class="commet">
                                                                        <div class="text_header"><strong>Bình luận</strong>
                                                                        </div>
                                                                        <input type="hidden" name="_token"
                                                                            value="LO8JsBpF3mZTw6fdIJyZOYEtJeKfLMH9O68kTslN">
                                                                        <div class="commet_add">
                                                                            <textarea class="textarea show_hoidap" name="content" rows="4" placeholder="Đang cập nhật!!!">{!! $data->content2 !!}</textarea>
                                                                            <div
                                                                                class="sumit_commet sumit_commethoidap hidden">

                                                                                <div class="input">
                                                                                    <input type="text" name="name"
                                                                                        class="inputText"
                                                                                        placeholder="Họ tên*" value=""
                                                                                        required="">
                                                                                    <input type="email"
                                                                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                                                        name="email" class="inputText"
                                                                                        placeholder="Email*" required=""
                                                                                        value="">
                                                                                    <div class="cloe_cometss">
                                                                                        <i class="fas fa-times"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <button class="btn_commet"
                                                                                    type="submit">Gửi bình luận</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            {{-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0" nonce="CN14vFSO"></script>
															<div class="fb-comments" data-href="https://www.facebook.com/htcgroups.vn" data-width="" data-numposts="5"></div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12">
                                                <div class="box_sp_giagoc">
                                                    <div class="title_sp_giagoc">
                                                        <h2>Sản phẩm mới nhất</h2>
                                                    </div>
                                                    @foreach ($dataNew as $item)
                                                        <div class="product_giagoc">
                                                            <div class="item_product_main" data-url="#">
                                                                <div class="product-thumbnail">
                                                                    {{-- <span class="product-percent">-12%</span> --}}
                                                                    <a class="image_thumb" href="" tabindex="-1">
                                                                        <img class="lazyload loaded"
                                                                            src="{{ $item->avatar_path }}"
                                                                            data-src="{{ $item->avatar_path }}"
                                                                            alt="{{ $item->avatar_path }}"
                                                                            data-was-processed="true">
                                                                    </a>
                                                                    <div class="image-tools">
                                                                        <a class="quickView styleBtnBuy add-to-cart"
                                                                            data-url="{{ route('cart.add', ['id' => $item->id]) }}"
                                                                            tabindex="-1"><i class="fa fa-cart-plus"></i>
                                                                            Đặt hàng</a>
                                                                        <a class="styleBtnBuy"
                                                                            href="{{ $item->slug_full }}"
                                                                            tabindex="-1"><i class="fa fa-eye"></i> Xem
                                                                            chi tiết</a>
                                                                    </div>
                                                                </div>
                                                                <div class="product-info">
                                                                    <h3 class="product-name">
                                                                        <a
                                                                            href="{{ $item->slug_full }}">{{ $item->name }}</a>
                                                                    </h3>
                                                                    <div class="price-box">
                                                                        @if ($item->sale > 0)
                                                                            <span
                                                                                class="compare-price">{{ number_format($item->price) }}
                                                                                {{ $unit }}</span>
                                                                        @endif
                                                                        <div>
                                                                            <span
                                                                                class="price">{{ number_format($item->price_after_sale) }}
                                                                                {{ $unit }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mua_ngay2">
                                                                        <a href="{{ route('cart.buy', ['id' => $item->id]) }}"
                                                                            tabindex="-1">
                                                                            <span>Mua ngay</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- <div class="wrap-tab-product-detail tab-category-1">
                                <div role="tabpanel">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Chi tiết sản phẩm</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active show" id="tab-1">
                                            <div class="tab-text">
                                               {!! $data->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="product-relate">
                                <div class="title-1">Sản phẩm liên quan</div>
                                @isset($dataRelate)
                                    @if ($dataRelate->count())
                                        <div class="list-product-card autoplay4">
                                            <!-- START BLOCK : cungloai -->
                                            @foreach ($dataRelate as $product)
                                                <div class="col-md-12">
                                                    <div class="product-card">
                                                        <div class="box">
                                                            <div class="card-top">
                                                                <div class="image">
                                                                    <a href="{{ $product->slug_full }}">
                                                                        <img src="{{ asset($product->avatar_path) }}"
                                                                            alt="Sofa phòng khách SF08"
                                                                            class="image-card image-default">
                                                                    </a>
                                                                    @if ($product->sale)
                                                                        <span class="sale-1">-{{ $product->sale }}%</span>
                                                                    @endif

                                                                </div>
                                                                {{-- <ul class="list-quick">
                                                                        <li class="quick-view">
                                                                            <a href="{{ $product->slug_full }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                        </li>
                                                                         <li class="cart quick-cart">
                                                                            <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id,]) }}"><i class="fas fa-cart-plus"></i></a>
                                                                        </li>
                                                                    </ul> --}}
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
                                                                        <span
                                                                            class="old-price">{{ number_format($product->price) }}
                                                                            {{ $unit }}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="fs-goods__dt-btm">
                                                                    <div class="ld-price__flash-process new">
                                                                        <div class="ld-price__flash-process_left"
                                                                            style="width: 100%;"></div>
                                                                        <div class="ld-price__flash-process_right"></div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <!-- END BLOCK : cungloai -->
                                        </div>
                                    @endif
                                @endisset

                            </div>

                            <!-- <div class="wrap-banner-product">
                                                            <a href="" class="image-banner">
                                                                <img src="../images/banner2.png" alt="">
                                                            </a>
                                                        </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
