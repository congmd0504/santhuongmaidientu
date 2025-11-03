@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')
@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset --}}
            <div class="wrap-content-main">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('alert'))
                            <div class="alert alert-success">
                                {{ session('alert') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif


                        <div class="row">
                            <script type="text/javascript">
                                function check() {
                                    var price = document.Test.txt_gia.value;
                                    var txh_name = document.Test.txh_name.value;
                                    var txt_email = document.Test.txt_email.value;
                                    var txt_phone = document.Test.txt_phone.value;
                                    var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

                                    if (price < 2000) {
                                        alert('Minimum amount is 2000 VNĐ');
                                        return false;
                                    }

                                    if (txh_name.length > 50) {
                                        alert('Họ tên không hợp lệ');
                                        return false;
                                    }
                                    if (txt_email.length > 50) {
                                        alert('Email không hợp lệ');
                                        return false;
                                    }
                                    if (txt_phone.length > 20) {
                                        alert('Số điện thoại không hợp lệ');
                                        return false;
                                    }
                                    if (format.test(txh_name)) {
                                        alert('Họ tên không hợp lệ');
                                        return false;
                                    }
                                    return true;
                                }
                            </script>
                            <div class="col-md-12">
                                <form action="{{ route('profile.nganLuongPaymentPost') }}" method="POST"
                                    onsubmit="submitPay(this)">
                                    @csrf
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">1. Nạp tiền qua alepay ngân lượng
                                                ({{ number_format(config('point.pointToMoney')) }}đ đổi được 1 điểm)</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <p>
                                                <span style="color: #ff0000;"><em><span style="font-size: medium;"><strong>
                                                                <span style="color: #000000;">
                                                                    Thanh toán trực tuyến bằng thẻ ATM; Visa, Master
                                                                    Card;... qua
                                                                    NgânLượng.vn</span>
                                            </p>
                                            <p style="color: red">LƯU Ý: Nhập thông tin người thanh toán không được chứa
                                                thông tin
                                                Merchant</p>
                                            @isset($flag)
                                                @if (!$flag)
                                                    <p style="color: red">Lỗi : Thông tin không hợp lệ</p>
                                                @endif
                                            @endisset



                                            <div class="form-group col-sm-12">
                                                <label class="control-label">Tổng Tiền <span
                                                        class="require">(*)</span></label>


                                                    <input class="form-control jsFormatNumber" min="200000" step="1"
                                                    id="" value="{{ old('pay') }}" name="pay"
                                                    placeholder="Nhập số tiền nạp" oninput="format_curency(this);"
                                                    type="text" onchange="format_curency(this);" required>
                                            </div>

                                            <div class="form-group col-sm-12 d-none">
                                                <label class="control-label">Số Lượng <span
                                                        class="require">(*)</span></label>

                                                <input type="text" placeholder="Số Lượng" class="form-control"
                                                    name="totalItem" id="totalItem" required value="1">

                                            </div>


                                            <div class="form-group col-sm-12">
                                                <label class="control-label">Email <span class="require">(*)</span></label>

                                                <input type="text" placeholder="Email" class="form-control"
                                                    name="buyerEmail" id="buyerEmail" required>

                                            </div>
                                            <!-- Text input-->
                                            <div class="form-group col-sm-12">
                                                <label class="control-label">Họ Tên <span class="require">(*)</span></label>

                                                <input type="text" placeholder="Tên" class="form-control"
                                                    name="buyerName" id="buyerName" required>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label class="control-label">Số Điện Thoại <span
                                                        class="require">(*)</span></label>

                                                <input type="text" placeholder="Số Điện Thoại" class="form-control"
                                                    name="phoneNumber" id="phoneNumber" required>
                                            </div>
                                            <div class="form-group col-sm-5" style="display: none;">
                                                <label class="control-label">Tiền Tệ <span
                                                        class="require">(*)</span></label>
                                                <select name="currency" id="currency" class="form-control">
                                                    <option value="VND" selected>VND</option>
                                                </select>

                                            </div>
                                            <!-- Text input-->
                                            <div class="form-group col-sm-12">
                                                <label class="control-label">Địa Chỉ <span
                                                        class="require">(*)</span></label>

                                                <input type="text" placeholder="Địa Chỉ" class="form-control"
                                                    name="buyerAddress" id="buyerAddress" required>

                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label class="control-label">Quốc gia<span
                                                        class="require">(*)</span></label>

                                                <input type="text" placeholder="" class="form-control"
                                                    name="buyerCountry" id="buyerCountry" required value="Việt Nam">
                                            </div>
                                            <!-- Text input-->
                                            <div class="form-group col-sm-12" style="display: none;">
                                                <label class="control-label" for="orderDescription">Mô Tả Hóa
                                                    Đơn<span class="require">(*)</span></label>

                                                <textarea placeholder="Thông Tin Mô Tả Hóa Đơn" id="orderDescription" name="orderDescription" class="form-control"
                                                    required="">Nạp tiền</textarea>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label class="control-label">Thành Phố <span
                                                        class="require">(*)</span></label>

                                                <input type="text" placeholder="Thành Phố" class="form-control"
                                                    name="buyerCity" id="buyerCity" required value="Hà Nội">


                                            </div>
                                            <div class="row"></div>
                                            <div class="col-sm-12" id="alert"></div>
                                            <div class="form-group col-sm-12">
                                                <p>&nbsp;</p>
                                                <button id="sendInstallment" type="submit" class="btn btn-info btn-lg"
                                                    name="sendInstallment">
                                                    Thanh Toán
                                                </button>

                                            </div>

                                        </div>
                                    </div>
                                </form>

                            </div>
                            {{-- <div class="col-md-12">
                                <form action="{{ route('profile.nganLuongPaymentPost') }}" method="POST"
                                    onsubmit="submitPay(this)">
                                    @csrf
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">1. Nạp tiền qua ngân lượng
                                                ({{ number_format(config('point.pointToMoney')) }}đ đổi được 1 điểm)</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <p>
                                                <span style="color: #ff0000;"><em><span
                                                            style="font-size: medium;"><strong>
                                                                <span style="color: #000000;">
                                                                    Thanh toán trực tuyến bằng thẻ ATM; Visa, Master
                                                                    Card;... qua
                                                                    NgânLượng.vn</span>
                                            </p>
                                            <p style="color: red">LƯU Ý: Nhập thông tin người thanh toán không được chứa
                                                thông tin
                                                Merchant</p>
                                            @isset($flag)
                                                @if (!$flag)
                                                    <p style="color: red">Lỗi : Thông tin không hợp lệ</p>
                                                @endif
                                            @endisset

                                            <div class="form-group">
                                                <label for="">Họ Tên:</label>
                                                <input class="form-control" name="txh_name" size="50"
                                                    placeholder="không chứa thông tin merchant, ký tự đặc biệt, tối đa 50 ký tự"
                                                    maxlength="50" type="text">
                                                @error('txh_name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email:</label>
                                                <input class="form-control" type="email" name="txt_email"
                                                    size="50" placeholder="tối đa 50 ký tự" maxlength="50">
                                                @error('txt_email')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Số điện thoại:</label>
                                                <input class="form-control" type="text" name="txt_phone"
                                                    size="50" placeholder="tối đa 20 ký tự" maxlength="20">
                                                @error('txt_phone')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="">Số tiền</label>
                                                <input class="form-control jsFormatNumber" min="200000" step="1"
                                                    id="" value="{{ old('pay') }}" name="pay"
                                                    placeholder="Nhập số tiền nạp" oninput="format_curency(this);"
                                                    type="text" onchange="format_curency(this);">
                                                @error('pay')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" value="Thanh Toán">Chấp
                                                    nhận</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="col-md-12">
                                <form action="{{ route('profile.momoPaymentPost') }}" method="POST"
                                    onsubmit="submitPay(this)">
                                    @csrf
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">1. Nạp tiền qua momo
                                                ({{ number_format(config('point.pointToMoney')) }}đ đổi được 1 điểm)</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group">
                                                <label for="">Số tiền</label>
                                                <input class="form-control jsFormatNumber" min="200000" step="1"
                                                    id="" value="{{ old('pay') }}" name="pay"
                                                    placeholder="Nhập số tiền nạp" oninput="format_curency(this);"
                                                    type="text" onchange="format_curency(this);">


                                                @error('pay')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">2. Nạp tiền bằng chuyển khoản trực tiếp</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3" style="padding-bottom:0px !important;">
                                        <form action="{{ route('profile.momoPaymentPost') }}" method="POST"
                                            onsubmit="submitPay(this)">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Số tiền nạp</label>

                                                <input class="form-control jsFormatNumber" min="200000" step="1"
                                                    id="" value="{{ old('pay') }}" name="pay"
                                                    placeholder="Nhập số tiền nạp" oninput="format_curency(this);"
                                                    type="text" onchange="format_curency(this);">
                                                <script>
                                                    function format_curency(a) {
                                                        let val = a.value.replaceAll('.', '');
                                                        // console.log(a.value);

                                                        a.value = val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                                                    }

                                                    function submitPay(form) {
                                                        console.log($(form).find('.jsFormatNumber').val());
                                                        $(form).find('.jsFormatNumber').val($(form).find('.jsFormatNumber').val().replaceAll('.', ''));


                                                    }
                                                </script>


                                                {{-- <input type="text" class="form-control"
                                                    id="pay_off"
                                                    placeholder="Nhập số tiền nạp">
                                                <input type="hidden" class="form-control" min="200000" step="1"
                                                    id="pay_off_hidden" value="{{ old('pay') }}" name="pay"
                                                    placeholder="Nhập số tiền nạp"> --}}
                                                @error('pay')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group" style="margin-bottom:0px;">
                                                <button type="submit" value="yeuem" name="type"
                                                    class="btn btn-primary">Tôi đã chuyển khoản</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <div class="content-pay" style="padding:0px !important;">
                                            {!! $settingPay->description !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- <div class="col-md-12">
                                <form action="{{ route('profile.momoPaymentPost') }}" method="POST">
                                    @csrf
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">3. Số tiền nạp
                                                ({{ number_format(config('point.pointToMoney')) }}đ đổi được 1 điểm)</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group">
                                                <label for="">Số tiền nạp</label>
                                                <input type="number" class="form-control" min="200000" step="1"
                                                    id="" value="{{ old('pay') }}" name="pay"
                                                    placeholder="Nhập số tiền nạp">
                                                @error('pay')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" value="yeuem" name="type" class="btn btn-primary">Tôi đã chuyển khoản</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#pay_on').number(true, 0, '.', ',');
            let pay_on_show = $('#pay_on').val();
            let pay_on_hide = $('#pay_on_hidden').val(pay_on_show);

            $('#pay_off').number(true, 0, '.', ',');
            let pay_off_show = $('#pay_off').val();
            let pay_off_hide = $('#pay_off_hidden').val(pay_off_show);
            $('jsFormatNumber').trigger('change');
        });
        $('#pay_on').on('change', function() {
            let pay_on_show = $('#pay_on').val();
            let pay_on_hide = $('#pay_on_hidden').val(pay_on_show);
        });
        $('#pay_off').on('change', function() {
            let pay_off_show = $('#pay_off').val();
            let pay_off_hide = $('#pay_off_hidden').val(pay_off_show);
        });
    </script>
@endsection
