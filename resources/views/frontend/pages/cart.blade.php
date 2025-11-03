@extends('frontend.layouts.main')
@section('title', 'Giỏ hàng')
@section('css')
    <style>
        .container-cart {
            max-width: 1000px;
        }

        .template-search {
            background: #eee;
        }

        .title-cart {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            margin-bottom: 20px;
        }

        .bg-cart {
            background: #fff;
        }

        .bg-address {
            background: #eee;
            padding: 10px;
        }

        .form-buy {}

        .buy-more:before {
            content: "";
            width: 8px;
            height: 8px;
            border-top: 1px solid #288ad6;
            border-left: 1px solid #288ad6;
            display: inline-block;
            vertical-align: middle;
            margin: 0 3px 2px 0;
            transform: rotate(-45deg);
        }

        .buy-more {
            color: #288ad6;
        }

        .btn-colsap,
        .desc-collapse {
            display: block;
            line-height: 36px;
            padding: 0 10px 0 40px;
            border: 1px solid #d6d6d6;
            /* margin-bottom: 20px; */
            position: relative;
            box-shadow: unset;
            background: #fff;
            margin: 0;
        }

        .btn-colsap.active:before,
        .desc-collapse:before {
            content: "";
            display: block;
            width: 21px;
            height: 21px;
            border-radius: 50%;
            background-color: #ed1c24;
            position: absolute;
            left: 10px;
            top: 8px;
        }

        .btn-colsap.active:after,
        .desc-collapse:after {
            content: "";
            display: block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #fff;
            position: absolute;
            left: 17px;
            top: 15px;
        }

        .btn-colsap:before {
            content: "";
            display: block;
            width: 21px;
            height: 21px;
            border-radius: 50%;
            border: 1px solid #ed1c24;
            position: absolute;
            left: 10px;
            top: 8px;
            box-sizing: border-box;
        }

        .colsap {
            margin-bottom: 20px;
        }

        .active .content-colsap {
            display: block;
        }

        .content-colsap {
            margin-bottom: 12px;
            max-height: 250px;
            overflow-y: auto;
            font-size: 15px;
            line-height: 1.3;
            display: none;
        }

        .list-button-cart {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .list-button-cart a {
            background-color: #22aa06;
            color: #fff;
        }

        .list-button-cart button {
            background-color: #f6821f;
        }

        .list-button-cart a,
        .list-button-cart button {
            padding: 15px;
            font-weight: bold;
            text-transform: uppercase;
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
            <div class="container container-cart">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-between align-item-center pt-3 pb-3">
                            <a href="{{ route('home.index') }}" class="buy-more">Xem thêm sản phẩm</a>
                            <a data-url="{{ route('cart.clear') }}" class="clear-cart">Xóa tất cả</a>
                        </div>
                        <div class="bg-cart">
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-danger">
                                        @include('frontend.components.cart-component', [])
                                    </div>
                                </div>
                                <div class="">
                                    <form action="{{ route('cart.order.submit') }}" method="POST"
                                        enctype="multipart/form-data" id="buynow">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-buy">

                                                    <h2 class="title-cart">
                                                        Điền thông tin người mua
                                                    </h2>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="">Họ và tên</label>
                                                                <input type="text"
                                                                    class="form-control   @error('name')is-invalid   @enderror"
                                                                    id="" name="name"
                                                                    value="{{ auth()->user()->name }}"
                                                                    placeholder="Họ và tên">
                                                                @error('name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="">Email</label>
                                                                <input type="email"
                                                                    class="form-control @error('email')is-invalid   @enderror"
                                                                    value="{{ auth()->user()->email }}" id=""
                                                                    name="email" placeholder="Email">
                                                                @error('email')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="">Số điện thoại</label>
                                                                <input type="text"
                                                                    class="form-control @error('phone')is-invalid   @enderror"
                                                                    id="" name="phone"
                                                                    value="{{ auth()->user()->phone }}"
                                                                    placeholder="Số điện thoại">
                                                                @error('phone')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="bg-address">
                                                        <h2 class="title-cart">
                                                            Địa chỉ người nhận
                                                        </h2>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="">Địa chỉ cụ thể </label>
                                                                    <input type="text" name="address_detail"
                                                                        value="{{ auth()->user()->address }}"
                                                                        class="form-control  @error('address_detail')is-invalid   @enderror"
                                                                        id="" placeholder="Địa chỉ cụ thể">
                                                                    @error('address_detail')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="">Số điện thoại người nhận </label>
                                                                    <input type="text" name="phone_nguoinhan"
                                                                        class="form-control  @error('phone_nguoinhan')is-invalid   @enderror"
                                                                        id=""
                                                                        placeholder="Số điện thoại người nhận">
                                                                    @error('phone_nguoinhan')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="">Mua hộ </label>
                                                                    <input type="text" name="note"
                                                                        class="form-control  @error('note')is-invalid   @enderror"
                                                                        id=""
                                                                        placeholder="Yêu cầu khác (không bắt buộc)">
                                                                    @error('note')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div id="list-thanhtoan">
                                                    @isset($infoCart)
                                                        @if ($infoCart)
                                                            @foreach ($infoCart->childs()->where('active', 1)->get() as $itemInfo)
                                                                <div class="card colsap {{ $loop->first ? 'active' : '' }}">
                                                                    <div class="btn-colsap {{ $loop->first ? 'active' : '' }}">
                                                                        {{ $itemInfo->name }}
                                                                    </div>
                                                                    <div class="card-body content-colsap" style="">
                                                                        {!! $itemInfo->description !!}
                                                                        @if($itemInfo->image_path)
                                                                            <b>Hoặc quét mã QR:</b> 
                                                                            <img src="{{ asset($itemInfo->image_path) }}" alt="{{ $itemInfo->name }}">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endisset
                                                </div>
                                                <div class="list-button-cart">
                                                    <input type="number" name="vi_vnd" value="{{ $totalViVndTra ?? 0 }}" hidden>
                                                    <button type="submit" class="btn  d-inline-block w-50">Đặt mua sản phẩm</button>
                                                    <a class="btn  d-inline-block w-50" href="{{ makeLink('home') }}">Chọn thêm SP</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
    <script src="{{ asset('frontend/js/load-address.js') }}"></script>
    <script>
        $(document).on('click', '.btn-colsap', function() {
            $('#list-thanhtoan').find('.active').removeClass('active');
            $(this).addClass('active');
            $(this).parent('.colsap').addClass('active');
            let value = $(this).parent('.colsap.active').data('value');
            $('#hinhthuc').val(value);
            $('#list-thanhtoan').find('.colsap:not(".active") .content-colsap').slideUp();
            $(this).parent('.colsap.active').find('.content-colsap').slideDown();
        });
    </script>
@endsection
