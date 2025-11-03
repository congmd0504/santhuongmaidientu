@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')


@section('content')

<div class="content-wrapper">
    <div class="main">
        <div class="breadcrumbs clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <ol class="breadcrumb mb-0" style="font-size: 12px;">
                            <li class="breadcrumb-item">
                                <a href="{{ makeLink("home") }}" >Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active "><a href="javascript:;">Sản phẩm khuyến mãi</a></li>
                            
                        </ol>
                    </div>
                </div>
            </div>
        </div> 
        <div class="wrap-content-main wrap-template-product template-detail">
            <div class="container ">
                <div class="bg_collection section">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12  block-content-right">
                            <h3 class="title-template-news">{{ $category->name??"" }}</h3>
                            @isset($data)
                                <div class="wrap-list-product">
                                    <div class="list-product-card">
                                        <div class="row">
                                            @foreach($data as $product)
                                            <div class="col-md-3 col-sm-3 col-xs-6">
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
                                                            @if($product->phantramdiem > 0)<li class="quick-view phantramdiem" style="color:#060505">{{ intval($product->phantramdiem) }}%</li>@endif

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
                                                                <span class="old-price">{{   number_format($product->price )}} {{ $unit  }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @if (count($data))
                                        {{$data->links()}}
                                        @endif

                                    </div>
                                </div>
                            @endisset

                        </div>
                    </div>
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
