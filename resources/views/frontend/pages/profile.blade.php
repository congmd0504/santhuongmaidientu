@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')
@section('css')
    <style>
        .info-box {
            box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
            border-radius: .25rem;
            background-color: #fff;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
            width: 100%;
        }

        .info-box .info-box-icon {
            border-radius: .25rem;
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            font-size: 1.875rem;
            -ms-flex-pack: center;
            justify-content: center;
            text-align: center;
            width: 60px;
            flex: 0 0 auto;
        }

        .info-box .info-box-content {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            line-height: 1.8;
            -ms-flex: 1;
            flex: 1;
            padding: 0 10px;
        }

        .info-box .info-box-text,
        .info-box .progress-description {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .info-box .info-box-number {
            display: block;
            margin-top: .25rem;
            font-weight: 700;
        }

        .card-title {
            font-size: 25px;
            font-weight: bold;
            margin-top: 0;
        }
    </style>
@endsection
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
                    @if ($user->active == 0)
                        <div class="col-md-12">
                            <div class="alert alert-danger" style=" font-size: 150%;">
                                <strong>warning!</strong> Tài khoản của bạn chưa được kích hoạt <br>
                                <span style="font-size: 14px;">(Các thông số tài khoản sẽ là thông số của tài khoản sau khi
                                    được kích hoạt)</span>
                            </div>
                        </div>
                    @elseif($user->active == 2)
                        <div class="col-md-12">
                            <div class="alert alert-danger" style=" font-size: 150%;">
                                <strong>warning!</strong> Tài khoản của bạn đã bị khóa <br>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="col-md-{{ $openPay ? '6' : '12' }} col-sm-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"> Tổng số điểm có thể rút</span>
                                <span class="info-box-number"> <strong>{{ number_format($sumPointCurrent) }}</strong>
                                    đ</span>
                            </div>
                        </div>
                    </div> --}}


                    @isset($sumEachType)
                        @foreach ($sumEachType as $item)
                            <div class="col-md-{{ $openPay ? '6' : '12' }} col-sm-12">
                                <div class="info-box">
                                    <span class="info-box-icon {{ $item['class'] }}"><i class="fas fa-cart-plus"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text"> {{ $item['name'] }}</span>
                                        <span class="info-box-number">
                                            <strong>
                                                @if($item['name'] == 'Ví BB')
                                                    {{ number_format($item['total']/getConfigBB()) }}
                                                @else
                                                    {{ number_format($item['total']) }}
                                                @endif
                                                    {{ $item['donvi'] }}
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                    <div class="col-md-{{ $openPay ? '6' : '12' }} col-sm-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"> Doanh số cá nhân</span>
                                <span class="info-box-number">
                                <strong>{{ number_format($user->total_money) }}</strong>
                                đ</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-{{ $openPay ? '6' : '12' }} col-sm-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"> Doanh số nhóm</span>
                                <span class="info-box-number">
                                    <strong>{{ number_format($user->total_money_group + $user->total_money) }}</strong>
                                    đ</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-{{ $openPay ? '6' : '12' }} col-sm-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"> Doanh số cá nhân</span>
                                <span class="info-box-number"> <strong>{{ number_format($user->total_money) }}</strong>
                                    đ</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            @if ($openPay && $user->active == 1)
                <div class="wrap-pay">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            @if (session('alert'))
                                <div class="alert alert-success">
                                    {{ session('alert') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-warning">
                                    {{ session('error') }}
                                </div>
                            @endif

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
                            @if (request()->type == 2)
                                <form action="{{ route('profile.pointToXu') }}" method="POST" onsubmit="submitPay(this)">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="card card-outline card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Đổi VNĐ sang BB</h3>
                                                    {{-- <div class="desc">Rút điểm chỉ được mở từ ngày 1- 2 hàng tháng</div> --}}
                                                </div>
                                                <div class="card-body table-responsive p-3">
                                                    <div class="form-group">
                                                        <label for="">Số VNĐ</label>
                                                        {{-- <input type="text" class="form-control" id=""
                                                            value="{{ old('pay') }}" name="pay"
                                                            placeholder="Nhập số điểm"> --}}
                                                        <input type="text" class="form-control jsFormatNumber"
                                                            name="pay" placeholder="Nhập số tiền"
                                                            oninput="format_curency(this);" type="text"
                                                            onchange="format_curency(this);">
                                                        @error('pay')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" name="checkrobot"
                                                            id="checkrobot" required>
                                                        <label class="form-check-label" for="checkrobot">Tôi đồng ý</label>
                                                    </div>
                                                    @error('checkrobot')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-info">Chấp nhận</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('profile.drawPoint') }}" method="POST" onsubmit="submitPay(this)">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="card card-outline card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Rút ví (VNĐ)</h3>
                                                    {{-- <div class="desc">Rút điểm chỉ được mở từ ngày 1- 2 hàng tháng</div> --}}
                                                </div>
                                                <div class="card-body table-responsive p-3">
                                                    <div class="form-group">
                                                        <label for="">Số tiền rút <small>(số tiền cần rút là số rút tiền sẽ trừ 5% thuế
                                                            thu nhập cá nhân)</small></label>
                                                        {{-- <input type="text" class="form-control" id=""
                                                            value="{{ old('pay') }}" name="pay"
                                                            placeholder="Nhập số điểm"> --}}
                                                        <input type="text" class="form-control jsFormatNumber"
                                                            name="pay" placeholder="Nhập số điểm"
                                                            oninput="format_curency(this);" type="text"
                                                            onchange="format_curency(this);">
                                                        @error('pay')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    @isset($sumEachType)
                                                        @foreach ($sumEachType as $item)
                                                            @if($item['name'] !== 'Ví BB')
                                                                <input name="check_vivnd" value="{{ $item['total'] }}" type="number" hidden>
                                                            @endif
                                                        @endforeach
                                                    @endisset
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" name="checkrobot"
                                                            id="checkrobot" required>
                                                        <label class="form-check-label" for="checkrobot">Tôi đồng ý</label>
                                                    </div>
                                                    @error('checkrobot')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-info">Chấp nhận</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <br>
            <!--Bắn BB-->
            <div class="wrap-pay">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        @if (session('alert1'))
                            <div class="alert alert-success">
                                {{ session('alert1') }}
                            </div>
                        @elseif(session('error1'))
                            <div class="alert alert-warning">
                                {{ session('error1') }}
                            </div>
                        @endif

                        <script>
                            function format_curency(a) {
                                let val = a.value.replaceAll('.', '');
                                // console.log(a.value);

                                a.value = val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                            }

                            function submitBB(form) {
                                console.log($(form).find('.jsFormatNumber').val());
                                $(form).find('.jsFormatNumber').val($(form).find('.jsFormatNumber').val().replaceAll('.', ''));


                            }
                        </script>
                            <form action="{{ route('profile.shootBB') }}" method="POST" onsubmit="submitBB(this)">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="card card-outline card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Chuyển BB</h3>
                                                {{-- <div class="desc">Rút điểm chỉ được mở từ ngày 1- 2 hàng tháng</div> --}}
                                            </div>
                                            <div class="card-body table-responsive p-3">
                                                <div class="form-group">
                                                    <label for="">Nhập số BB cần chuyển</label>
                                                    <input type="text" class="form-control jsFormatNumber"
                                                           name="BB" placeholder="Nhập số điểm"
                                                           oninput="format_curency(this);" type="text"
                                                           onchange="format_curency(this);" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="userSelect">Chọn user</label>
                                                    @php
                                                        $userPrent = App\Models\User::find($user->parent_id);
                                                    @endphp
                                                    <select class="form-control" id="userSelect" name="userSelect" required>
                                                        <option value="">--- Chọn ---</option>
                                                        @if($userPrent)
                                                            <option value="{{ $userPrent->id }}">{{ $userPrent->name }} (Cha)</option>
                                                        @endif

                                                        @if($user->childs()->count() > 0)
                                                            @foreach($user->childs()->get() as $us)
                                                            <option value="{{ $us->id }}">{{ $us->name }} (Con)</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <input type="number" name="id_user" value="{{ $user->id }}" hidden>
                                                </div>

                                                <div class="form-group form-check">
                                                    <input type="checkbox" class="form-check-input" name="checkrobot2"
                                                           id="checkrobot2" required>
                                                    <label class="form-check-label" for="checkrobot">Tôi đồng ý</label>
                                                </div>
                                                @error('checkrobot')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info">Chấp nhận</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
