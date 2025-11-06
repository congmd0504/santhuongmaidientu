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

            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12  block-content-right">
                            <h3 class="title-template-news">{{ $category->name ?? '' }}</h3>
                            @isset($data)
                                <div class="wrap-list-product">
                                    <div class="list-product-card">
                                        <div class="row">
                                            @foreach ($data as $product)
                                                <div class="col-md-3 col-sm-4 col-6 col-xs-6">
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
                                                                @if ($product->phantramdiem > 0 && $product->is_tinh_diem == 1)
                                                                <span class="sale-acstion2">
                                                                    {{ intval($product->phantramdiem) }}%(KTG)
                                                                </span>
                                                                    @endif
                                                            @endif
                                                                </div>
                                                                <ul class="list-quick">
                                                            

                                                                    <li class="quick-view">
                                                                        <a href="{{ $product->slug_full }}"><i class="fa fa-eye"
                                                                                aria-hidden="true"></i></a>
                                                                    </li>
                                                                    {{-- <li class="cart quick-cart">
                                                                    <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id,]) }}"><i class="fas fa-cart-plus"></i></a>
                                                                </li> --}}
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
                                    {{-- <div class="col-md-12">
                                        @if (count($data))
                                            {{ $data->links() }}
                                        @endif

                                    </div> --}}
                                </div>
                            @endisset

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function() {
            $(document).on('click', '.pt_icon_right', function() {
                event.preventDefault();
                $(this).parentsUntil('ul', 'li').children("ul").slideToggle();
                $(this).parentsUntil('ul', 'li').toggleClass('active');
            })
        })
    </script>
@endsection
