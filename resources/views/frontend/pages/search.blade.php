@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')
@section('css')
    <style>
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

            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            @isset($dataProduct)
                                @if ($dataProduct)
                                    @if ($dataProduct->count())
                                        <h3 class="title-template-news">Kết quả tìm kiếm sản phẩm </h3>
                                        <div class="wrap-list-product">
                                            <div class="list-product-card">
                                                <div class="row">
                                                    @foreach ($dataProduct as $product)
                                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                                            <div class="product-card">
                                                                <div class="box">
                                                                    <div class="card-top">
                                                                        <div class="image">
                                                                            <a
                                                                                href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">
                                                                                <img src="{{ asset($product->avatar_path) }}"
                                                                                    alt="Sofa phòng khách SF08"
                                                                                    class="image-card image-default">
                                                                            </a>
                                                                            @if ($product->sale)
                                                                                <span
                                                                                    class="sale-1">-{{ $product->sale }}%</span>
                                                                            @endif

                                                                        </div>
                                                                        <ul class="list-quick">
                                                            @if($product->phantramdiem > 0)<li class="quick-view phantramdiem" style="color:#060505">{{ intval($product->phantramdiem) }}%</li>@endif

                                                                            <li class="quick-view">
                                                                                <a
                                                                                    href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}"><i
                                                                                        class="fa fa-eye"
                                                                                        aria-hidden="true"></i></a>
                                                                            </li>
                                                                            <li class="cart quick-cart">
                                                                                <a class="add-to-cart"
                                                                                    data-url="{{ route('cart.add', ['id' => $product->id]) }}"><i
                                                                                        class="fas fa-cart-plus"></i></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <h4 class="card-name"><a
                                                                                href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->name }}</a>
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
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                @if (count($dataProduct))
                                                    {{ $dataProduct->links() }}
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endisset

                        </div>
                        <div class="col-lg-12 col-sm-12">
                            @isset($dataPost)
                                @if ($dataPost)
                                    @if ($dataPost->count())
                                        <h3 class="title-template-news">Kết quả tìm kiếm tin tức</h3>
                                        <div class="list-news">
                                            <div class="row">
                                                @foreach ($dataPost as $post)
                                                    <div class="fo-03-news col-lg-4 col-md-6 col-sm-6">
                                                        <div class="box">
                                                            <div class="image">
                                                                <a href="{{ makeLink('post', $post->id, $post->slug) }}"><img
                                                                        src="{{ asset($post->avatar_path) }}"
                                                                        alt="{{ $post->name }}"></a>
                                                            </div>
                                                            <h3><a
                                                                    href="{{ makeLink('post', $post->id, $post->slug) }}">{{ $post->name }}</a>
                                                            </h3>
                                                            <div class="date">{{ date_format($post->updated_at, 'd/m/Y') }} -
                                                                Admin Bivaco</div>
                                                            <div class="desc">
                                                                {!! $post->description !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if (count($dataPost))
                                            {{ $dataPost->links() }}
                                        @endif
                                    @endif
                                @endif
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
