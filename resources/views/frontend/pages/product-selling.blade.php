@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
{{--@section('image', asset($header['seo_home']->image_path))--}}

@section('css')
<link rel="preload" as="style" type="text/css" href="{{ asset('assets/sidebar_style.scss.css') }}">
<link href="{{ asset('assets/sidebar_style.scss.css') }}" rel="stylesheet" type="text/css">

<link rel="preload" as="style" type="text/css" href="{{ asset('assets/collection_style.scss.css') }}">
<link href="{{ asset('assets/collection_style.scss.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="section wrap_background">
    <div class="flash-title d-block d-md-none">Đơn hàng trên <b>1.500.000vnđ</b> sẽ được miễn phí vận chuyển</div>
    <section class="bread-crumb d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-12 a-left">
                    <ul class="breadcrumb" >                    
                        <li class="home">
                            <a href="{{makeLink('home')}}" ><span>Trang chủ</span></a>
                        </li>
                        <li class="last">
                            <strong><span>Sản phẩm bán chạy nhất</span></strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>  
    
    
    <div class="container ">
        <div class="bg_collection section">
            <div class="row">
                <div class="main_container col-lg-12 col-md-12 col-sm-12">
                    
                    @if (isset($data) && $data->count()>0)
                    <div class="category-products products">
                        <section id="dataProductSearch" class="products-view products-view-grid collection_reponsive list_hover_pro">
                            <div class="row">
                                @foreach($data as $product)
                                    @php
                                        $tran=$product->translationsLanguage()->first();
                                        $link=$product->slug_full;
                                        $isColor = $product->options()->where('stock',1)->orderBy('order')->first();
                                    @endphp
                                    <div class="col-6 col-md-4 col-lg-4 col-xl-3 product-col">
                                        <div class="item_product_main" data-url="{{$link}}" data-id="{{ $product->id }}">
                                            <div class="product-thumbnail">
                                                @if($product->price && $product->old_price)
                                                    <span class="product-percent">-{{ ceil(100 - ($product->price/$product->old_price*100)).'%'}}</span>
                                                @endif
                                                <a class="image_thumb" href="{{ $link }}" title="{{ $product->name }}">
                                                    <img class="lazyload" src="{{ asset('assets/icon/lazyimg.jpg') }} " data-src="{{ asset($product->avatar_path) }}" alt="{{ $product->name }}" />
                                                    @if($isColor == null)
                                                    <div class="out-of-stock-label">Hết hàng</div>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-info">
                                                <h3 class="product-name">
                                                    <a href="{{ $link }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                                </h3>
                                                
                                                <div class="bottom-action">
                                                    <div class="price-box">
                                                        <span class="price">{{ $product->price?number_format($product->price)." ".$unit:"Liên hệ" }}</span>
                                                        @if ($product->old_price>0)
                                                        <span class="compare-price">{{ number_format($product->old_price) }}{{ $unit }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="sw-group">
                                                    <div class="option-swath">
                                                        <div class="swatch-color swatch clearfix" data-option-index="0" data-swatches="4">
                                                            @if(count($product->options))
                                                                
                                                                @foreach($product->options as $option)
                                                                    <div data-value="{{ $option->size }}" class="swatch-element color">

                                                                        <input id="swatch-{{$product->id}}-{{$option->id}}" type="radio" name="option-0" value="{{ $option->size }}" data-image="{{ asset($option->avatar_type) }}" />
                                                                        <label title="{{ $option->size }}" for="swatch-{{$product->id}}-{{$option->id}}" style="background-image:url({{ asset($option->avatar_type) }});background-size:37px;background-repeat:no-repeat;background-position: center!important;" data-scolor="{{ asset($option->avatar_type) }}"></label>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-ms-12 col-12">
                                    @if (count($data))
                                    {{$data->appends(request()->all())->onEachSide(1)->links()}}
                                    @endif
                                </div>
                            </div>

                        </section>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="collection-mask"></div>
<script>
    var colId = 2744593;
</script>
<style>
    .bread-crumb {
        padding-top: 40px;
    }
    @media (max-width:991px) {
        .main-slide-policy {display:none!important}
    }
    @media (max-width:767px) {
        .header .menu-mobile {display:none}
    }
</style>
<input id="collection_id" value="2744593" type="hidden"/>
@endsection
@section('js')
<script>
    $(function(){
        $(document).on('change','.field-form',function(){
          // $( "#formfill" ).submit();
            //filter-container__selected-filter
            let stt = 0;
            stt = parseInt(stt);
            $(".field-form").each(function() {
                let color_check = $(this).is(':checked');
                if(color_check){
                    stt++;
                }
            });
            if(stt>0){
                $(".filter-container__selected-filter").show();
            }
            else{
                $(".filter-container__selected-filter").hide();
            }

            let contentWrap = $('#dataProductSearch');
            let urlRequest = '{{ url()->current() }}';
            let data=$("#formfill").serialize();

            $.ajax({
                type: "GET",
                url: urlRequest,
                data:data,
                success: function(data) {
                    if (data.code == 200) {
                        let html = data.html;
                        let totalPro = data.countProduct;
                        contentWrap.html(html);
                        $('.count').html(totalPro +' sản phẩm');
                    }
                }
            });
        });

        $(document).on('click','.filter-container__clear-all',function(){
          // $( "#formfill" ).submit();
            //filter-container__selected-filter

            let contentWrap = $('#dataProductSearch');
            let urlRequest = '{{ url()->current() }}';
            let data=$("#formfill").serialize();

            $.ajax({
                type: "GET",
                url: urlRequest,
                data:data,
                success: function(data) {
                    if (data.code == 200) {
                        let html = data.html;
                        let totalPro = data.countProduct;
                        contentWrap.html(html);
                        $('.count').html(totalPro +' sản phẩm');
                    }
                }
            });
        });


        $(document).on('change','.field-change-link',function(){
          // $( "#formfill" ).submit();

           let link=$(this).val();
           if(link){
               window.location.href=link;
           }
        });
        
    });
</script>
@endsection
