<style>
    .main {
        background-color: white;
    }

    .cart-item {

        width: 100%;
        box-sizing: border-box;
        border-bottom: 1px solid #ccc;
        background: #fff;
    }

    .cart-item .image {}

    .cart-item .remove-cart {
        display: block;
        overflow: hidden;
        margin: 15px auto 0;
        border: 0;
        background: #fff;
        color: #999;
        font-size: 12px;
        width: auto;
        width: 50px;
        padding: 0;
    }

    .cart-item .media-body {
        justify-content: space-between;
        align-items: flex-start;
    }

    .cart-item .media-body .content {
        width: auto;
        padding-left: 15px;
    }

    .cart-item .media-body .content h4 {
        width: 70%;
        font-size: 14px;
        color: #333;
        font-weight: 700;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .cart-item .media-body .content p {
        overflow: hidden;
        font-size: 12px;
        color: #666;
        padding: 6px 0 0 0px;
    }

    .cart-item .media-body .box-price {
        width: auto;
    }

    .cart-item .media-body .box-price>span {
        display: block;
        font-size: 14px;
        text-align: right;
        margin-bottom: 2px;
    }

    .cart-item .media-body .box-price .new-price-cart {
        color: #f30c28;

    }

    .cart-item .media-body .box-price .old-price-cart {
        color: #666;
        text-decoration: line-through;
    }

    .cart-item .quantity-cart {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .cart-item .quantity-cart .box-quantity {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cart-item .quantity-cart .box-quantity span {
        font-size: 23px;
        border-radius: 0;
        color: #333;
        background-color: #fff;
        border: 1px #ebebeb solid;
        height: 30px;
        line-height: 29px;
        width: 30px;
        padding: 0;
        -webkit-transition: background-color ease 0.3s;
        -moz-transition: background-color ease 0.3s;
        -ms-transition: background-color ease 0.3s;
        -o-transition: background-color ease 0.3s;
        transition: background-color ease 0.3s;
        cursor: pointer;
    }

    .cart-item .quantity-cart .box-quantity .prev-cart {}

    .cart-item .quantity-cart .box-quantity input {
        width: 40px;
        line-height: 28px;
        font-size: 14px;
        margin: 0 5px;
        text-align: center;
        -moz-appearance: textfield;
        margin: 0 5px;
        float: left;
        border-radius: 0;
        border: 1px #ebebeb solid;
        height: 30px;
        padding: 0 !important;
    }

    .cart-item .quantity-cart .box-quantity .next-cart {}

    .cart-item .quantity-cart .box-quantity input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .sale-cart {
        top: 0;
        right: 0;
    }

    .cart-item .remove-cart span {
        float: left;
        background: #ccc;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        position: relative;
        margin: 2px 3px 0 0;
    }

    .cart-item .remove-cart span:after,
    .cart-item .remove-cart span:before {
        content: "";
        width: 2px;
        height: 8px;
        background: #fff;
        position: absolute;
        transform: rotate(45deg);
        top: 2px;
        left: 5px;
    }

    .cart-item .remove-cart span:after {
        transform: rotate(-45deg);
    }

    label,
    input.form-control,
    select.form-control {
        font-size: 12px;
    }

    .area-total {}

    .area-total .total {

        font-weight: 600;
    }

    .area-total .total span {}

    .area-total .total-price {
        font-size: 16px;
        color: red;
    }

    .area-total .total-provisional {
        font-size: 12px;
    }

    .area-total .total-provisional-price {
        padding-bottom: 10px;

    }

    .wrap-footer-cart {}

    .wrap-footer-cart .wrap-user-point {}

    .wrap-footer-cart .area-total {}

    @media(max-width: 550px) {
        .wrap-footer-cart .wrap-user-point {
            width: 100%;
        }

        .wrap-footer-cart .area-total {
            width: 100%;
        }
    }

    .thead-light,
    .cart-item {
        display: flex;
        width: 100%;
        text-align: center;
    }

    .a-center-img,
    .a-center-tensanpham,
    .a-center-soluong,
    .a-center-giaban,
    .a-center-xoa {
        border-top: solid 1px #ebebeb;
        border-left: solid 1px #ebebeb;
        padding: 10px 20px;
    }

    .a-center-xoa {
        border-right: solid 1px #ebebeb;
    }

    .a-center-img {
        width: 25%;

    }

    .item-cart {
        display: flex;
        width: 65%;
    }

    .a-center-tensanpham {
        width: 40%;
    }

    .a-center-soluong {
        width: 30%;
    }

    .a-center-giaban {
        width: 30%;
    }

    .a-center-xoa {
        width: 10%;
    }

    @media(max-width: 650px) {
        .cart-item {
            padding: 20px 0px;
        }

        .table-bordered {
            border: solid 1px #ebebeb;
        }

        .thead-light {
            display: none;
        }

        .a-center-img,
        .a-center-tensanpham,
        .a-center-soluong,
        .a-center-giaban,
        .a-center-xoa {
            border-top: solid 0px #ebebeb;
            border-left: solid 0px #ebebeb;
            padding: 0px 0px;
            text-align: left;
            display: flex;
        }

        .item-cart {
            flex-direction: column;
            margin-left: 30px;
        }

        .a-center-tensanpham {
            width: 100%;
            order: 1;
            display: flex;
        }

        .a-center-soluong {
            width: 100%;
            order: 3;
            display: flex;
        }

        .a-center-giaban {
            width: 100%;
            order: 2;
            display: flex;
        }

        .item-cart {
            order: 3;
        }

        .cart-image {
            order: 2;
        }

        .a-center-xoa {
            order: 1;
            width: 5%;
            margin-right: 20px;
            display: flex;
            align-items: center;
        }

        .a-center-img {
            width: 25%;

        }

        .item-cart {
            display: flex;
            width: 70%;

        }

        .cart-item .remove-cart {

            margin: 0px auto 0;
        }

        .a-center-xoa {
            border-right: solid 0px #ebebeb;
        }

        .d-flex {
            display: block !important;
        }

        .name {
            display: block !important;
        }

        .total-point-number {
            color: red;
        }
    }

    .bgr-le {
        background-color: #fbfafa;
        padding: 20px;

    }

    .bgr-le,
    .bgr-chan,
    .bgr-le label,
    .bgr-chan label {
        font-size: 16px !important;
    }

    .bgr-chan {
        background-color: #d1d1d1;
        padding: 15px;
    }

    .border-bottom {
        border: 1px solid #dee2e6 !important;
    }

    .bgr-khac {
        background-color: rgb(72, 185, 65);
        padding: 15px;
        color: white;
        font-size: 20px;
    }
</style>
@if (count($data) > 0)
    <div class="cart-wrapper">
        <div class="table-responsive">
            <div class="table table-bordered ">
                <div class="thead-light">

                    <div class = "a-center-img">Ảnh</div>
                    <div class="item-cart">
                        <div class = "a-center-tensanpham">Tên sản phẩm</div>
                        <div class = "a-center-soluong">Số lượng</div>
                        <div class = "a-center-giaban">Giá bán</div>
                    </div>
                    <div class = "a-center-xoa">Xóa</div>
                </div>
                <div>
                    @foreach ($data as $cartItem)
                        <div class="cart-item">
                            <div class="cart-image a-center-img" data-title="Hình ảnh:">
                                <div class="image position-relative">
                                    <img src="{{ $cartItem['avatar_path'] }}" alt="{{ $cartItem['name'] }}"
                                        class="mr-3 mt-3" style="width:80px;">
                                    <span
                                        class="badge badge-pill badge-danger position-absolute sale-cart">{{ $cartItem['sale'] }}%</span>
                                </div>
                            </div>
                            <div class="item-cart">
                                <div class="cart-name a-center-tensanpham" data-title="Tên sản phẩm:">
                                    <span> {{ $cartItem['name'] }} </span>
                                </div>
                                <div class="cart-quantity a-center-soluong" data-title="Số lượng:">
                                    <div class="quantity-cart">
                                        <div class="box-quantity text-center">
                                            <span class="prev-cart">-</span>
                                            <input class="number-cart"
                                                data-url="{{ route('cart.update', [
                                                    'id' => $cartItem['id'],
                                                ]) }}"
                                                value="{{ $cartItem['quantity'] }}" type="number" id=""
                                                name="quantity" disabled="disabled">
                                            <span class="next-cart">+</span>
                                        </div>
                                        @isset($cartItem['error'])
                                            @if ($cartItem['error'])
                                                <div class="invalid-feedback" style="display:block;">
                                                    {{ $cartItem['error'] }}</div>
                                            @endif
                                        @endisset

                                    </div>
                                </div>
                                <div class="cart-price a-center-giaban " data-title="Giá bán:">
                                    <div class="box-price">
                                        <span class="new-price-cart"
                                            style="color: red; display: block;">{{ number_format($cartItem['totalPriceOneItem']) }}
                                            {{ $unit ?? '' }}</span>
                                        <span class="old-price-cart"
                                            style="display: block; font-size: 80%; text-decoration: line-through;">{{ number_format($cartItem['totalOldPriceOneItem']) }}
                                            {{ $unit ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-action a-center-xoa" data-title="Xóa:">
                                <a data-url="{{ route('cart.remove', [
                                    'id' => $cartItem['id'],
                                ]) }}"
                                    class="btn btn-danger remove-cart ">
                                    {{-- <span></span> --}}
                                    <i class="fas fa-times-circle delete-option" data-tab="80"></i>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
                </table>
            </div>
            <div class="area-total border-bottom">
                <div class="form-inline justify-content-end bgr-chan">
                    <label for="" class="mr-sm-2" style = "font-weight: 600;">Sử dụng mã giảm giá:</label>
                    <div class="d-inline-block">
                        <input type="text" class="form-control mr-sm-2" placeholder=""
                            data-url="/cart/apply-code-sale" name="code-sale" id="jsApplyCodeSale" form="buynow"
                            value="{{ $cartSale['codeSale'] }}">
                        @if ($cartSale['codeSale'])
                            <div>{{ $cartSale['mes'] }}</div>
                        @endif
                    </div>
                    <span></span>
                    <button type="button" class="btn btn-danger jsBtnApplyCodeSale">Áp dụng mã giảm giá</button>
                </div>

                <div class="total d-flex align-items-center justify-content-between bgr-le">
                    {{ getPhanTramMotaGiamGiaLevel(optional(auth()->user())->level) }}
                </div>
                {{--<div class="total d-flex align-items-center justify-content-between bgr-le">
                    <span class="name" style = "font-weight: 600;">Tổng tiền sau khi trả bằng ví BB
                        <small>({{ $totalQuantity }} sản phẩm)</small></span>
                    <span class="total-price "> {{ number_format($totalPrice) }} {{ $unit ?? '' }}</span>
                </div>--}}
                {{--@if (Auth::user()->level == 0)
                    <style>
                        .checkLevel {
                            opacity: 0.5;
                            pointer-events: none;
                            border: 1px solid red;
                        }
                    </style>
                @endif--}}
                <div class="checkLevel">
                    <div class="total-point d-flex align-items-center justify-content-between  bgr-chan">
                        <span class="name" style = "font-weight: 600;">Số dư trong ví KTG:</span>
                        <span class="total-point-number"> {{ number_format($sumPointCurrent) }}
                            <strong>{{ $pointUnit ?? '' }}</strong></span>
                    </div>
                    <div class="total-point d-flex align-items-center justify-content-between  bgr-le">
                        <span class="name" style = "font-weight: 600;">
                            Số KTG cần để mua đơn hàng:
                        </span>
                        <span class="total-point-number"> {{ number_format($totalPointAccessUse) }}
                            <strong>{{ $pointUnit ?? '' }}</strong></span>
                    </div>
                    <div class="form-inline justify-content-end bgr-chan">
                        <label for="" class="mr-sm-2" style = "font-weight: 600; none">Sử dụng KTG:</label>
                        <div class="d-inline-block">
                            @if($sumPointCurrent > $totalPointAccessUse || $sumPointCurrent == $totalPointAccessUse)
                                <input type="number"
                                       class="form-control mr-sm-2  @isset($errorNumberPoint)  @if ($errorNumberPoint){{ 'is-invalid' }} @endif   @endisset    @error('usePoint') {{ 'is-invalid' }}  @enderror"
                                       placeholder="Nhập số KTG"
                                       data-url="{{ route('cart.update', [
                                        'id' => 0,
                                    ]) }}"
                                       value="{{ $usePoint ?? '' }}" name="usePoint" id="usePoint" form="buynow">
                            @elseif($sumPointCurrent < $totalPointAccessUse)
                                <input type="number"
                                       class="form-control mr-sm-2  @isset($errorNumberPoint)  @if ($errorNumberPoint){{ 'is-invalid' }} @endif   @endisset    @error('usePoint') {{ 'is-invalid' }}  @enderror"
                                       placeholder="Nhập số KTG"
                                       data-url="{{ route('cart.update', [
                                        'id' => 0,
                                    ]) }}"
                                       value="{{ $sumPointCurrent ?? '' }}" name="usePoint" id="usePoint" form="buynow">
                            @endif
                            @error('usePoint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if (session('alert1'))
                                <div class="alert alert-success">
                                    {{ session('alert1') }}
                                </div>
                            @elseif(session('error1'))
                                <div class="alert alert-warning">
                                    {{ session('error1') }}
                                </div>
                            @endif

                            @isset($errorNumberPoint)
                                @if ($errorNumberPoint)
                                    <div class="invalid-feedback">{{ $errorNumberPoint }}</div>
                                @endif
                            @endisset
                        </div>
                        <span></span>
                        <label class="">{{ $pointUnit ?? '' }}</label>

                    </div>
                    <div class="total  d-flex align-items-center justify-content-between bgr-le">
                        <span class="name" style = "font-weight: 600;">Số dư (VNĐ) có thể chi trả: {{ number_format($totalViVNĐ ?? 0) }}đ</span>
                        <span class="name" style = "font-weight: 600;">Số (VNĐ) cần chi trả: {{ number_format($totalViVndTra ?? 0) }}đ</span>
                        {{--<span class="total-price">
                            @if($totalViVNĐ > 0)
                                <span
                                    id="total-price-point-cart">{{ ($totalViVNĐ - $totalPrice) > 0 ? number_format($totalViVNĐ - $totalPrice) : 0 }}
                                </span>đ
                            @else
                                <span
                                    id="total-price-point-cart">{{ number_format(0) }}
                                </span>đ
                            @endif

                        </span>--}}

                    </div>
                </div>


                <div class="total  d-flex align-items-center justify-content-between bgr-chan">
                    <span class="name" style = "font-weight: 600;">Chi trả bằng tiền mặt:</span>

                    <span class="total-price">
                        @if($totalOldPrice >  $totalPriceMoney )
                        <span class="total-provisional-price text-line-through" style="text-decoration: line-through;color: gray;
                    font-size: 12px;">
                            {{ number_format($totalOldPrice ?? 0) }}{{ $unit ?? '' }}
                        </span>
                        @endif
                        <span id="total-price-money-cart">
                            {{ number_format($totalPriceMoney ?? 0) }}
                        </span>
                            {{ $unit ?? '' }}
                    </span>
                    <input name="useMoney" id="useMoney" value="{{ $totalPriceMoney }}" hidden form="buynow">
                </div>
                <div class="total  d-flex align-items-center justify-content-between bgr-khac">
                    <span class="name"style="font-weight: 600;">Tổng giá trị đơn hàng:</span>
                    <span class=""> <span id="total-price-cart"
                            style="font-size: 130%;">{{ number_format($totalPrice) }}</span>
                        {{ $unit ?? '' }}</span>
                </div>
            </div>
        </div>
    @else
        <style>
            .wrap-hide-if {
                display: none;
            }
        </style>
        <div class="wrap-no-product p-5">
            <div class="text-center">
                <i class="fas fa-cart-plus" style="font-size: 50px; color:red"></i>
                <p>Không có sản phẩm nào được chọn</p>
                <a href="{{ makeLink('home') }}" class="btn btn btn-outline-primary w-100 mt-2 mb-2">Về trang chủ</a>
                <p>Vui long đi đi đến <a href="{{ makeLink('contact') }}" style="color:red;">liên hệ</a> để được hỗ
                    trợ</p>
            </div>
        </div>

@endif
