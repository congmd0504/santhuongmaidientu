@extends('frontend.layouts.main')
@section('title', 'Trang chủ')
@section('css')
   <style>
        .container-cart{
            max-width: 600px;
        }
        .template-search{
            background: #eee;
        }
        .title-cart{
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            margin-bottom: 20px;
        }
        .bg-cart{
            background: #fff;
        }
        .sucess-order{
            display: block;
            overflow: hidden;
            background-color: #f5f5f5;
            text-align: center;
            padding: 10px 0;
            color: #34c772;
            font-size: 25px;
            font-weight: bold;
        }
        .order-content{
            padding: 10px 30px;
        }
        .order-content .infor-order{}
        .thank-you{}
        .order-content  .list-infor{
            display: block;
            overflow: hidden;
            background-color: #f3f3f3;
            padding:10px;
        }
        .order-content  .list-infor li{
            line-height: 25px;
            padding: 5px 0;
        }
        .order-content  .list-infor li span{
            font-weight: 600;
            color: #000;
        }
        .order-content  .total-price{
            color: red;
        }
        .order-content  .total-price span{

        }
        .buy-more{}
        .buy-more a{
            overflow: hidden;
            border: 1px solid #288ad6;
            color: #288ad6;
            background-color: #fff;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
        }
        .order-item h4{
            margin: 0;
            font-size: 12px;
            font-weight: bold;
        }
        .title-order{
            font-size: 14px;
            font-weight: bold;

        }
   </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="container container-cart">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="bg-cart mt-5 mb-5">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <div class="sucess-order text-center mb-3">
                                        @if (session("sucess"))
                                        <i class="fas fa-shopping-bag mr-3"></i> {{ session("sucess") }}
                                        @elseif(session("error"))
                                        <i class="fas fa-shopping-bag mr-3"></i> {{ session("error") }}
                                        @else
                                        <i class="fas fa-shopping-bag mr-3"></i> Bạn chưa đặt hàng
                                        @endif
                                    </div>

                                    <div class="order-content">
                                        @if (session("sucess"))
                                        <div class="infor-order mb-3">
                                            <div class="thank-you text-center mb-3">
                                             Cảm ơn quý khách  đã đặt hàng của chúng tôi
                                            </div>
                                            <ul class="list-infor">
                                                <li><span>Người nhận hàng </span> {{ $data->name }}</li>
                                                <li><span>Giao đến </span> {{ $data->address_detail }}, {{ optional($data->commune)->name }}, {{ optional($data->district)->name }}, {{ optional($data->city)->name }} (nhân viên sẽ gọi xác nhận trước khi giao).</li>
                                                <li class="total-price"><span>Tổng tiền </span> {{ number_format($data->total) }} {{ $unit }}</li>
                                                <li class="total-price"><span>Chi trả bằng tiền mặt</span> {{ number_format($data->money) }} {{ $unit }}</li>
                                                <li class="total-price"><span>Chi trả bằng BB </span> {{ number_format($data->point) }} {{ $pointUnit }}</li>
                                                <li class="total-price"><span>Chi trả Ví VNĐ </span> {{ number_format($data->vi_vnd) }} {{ $unit }}</li>
                                                <li class="total-price"><span>Sử dụng giảm giá </span> {{ number_format($data->money_code_sale) }}</li>
                                            </ul>
                                          <div class="list-order-product pt-4 pb-4">
                                            <div class="title-order  mb-3">
                                                Sản phẩm đã đặt
                                            </div>
                                            <div class="row">
                                                @foreach ($data->products as $productItem)

                                                <div class="col-md-6 col-sm-6 col-xs-6 mb-2">
                                                    <div class="order-item">
                                                        <div class="media p-0">
                                                            <div class="image position-relative">
                                                                <a href="{{ $productItem->slug_full }}">  <img src="{{ $productItem->avatar_path }}" alt="{{ $productItem->name }}" class="" style="width:50px;"></a>
                                                            </div>
                                                            <div class="media-body pl-3">
                                                                <div class="content">
                                                                    <h4><a href="{{ $productItem->slug_full }}">{{ $productItem->name }}</a> </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                      </div>
                                                </div>
                                                @endforeach
                                            </div>
                                          </div>
                                         </div>
                                         @endif
                                         <div class="buy-more text-center">
                                             <a href="{{ route('home.index') }}" class="btn">Mua thêm sản phẩm khác</a>
                                         </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
