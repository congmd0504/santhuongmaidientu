@extends('frontend.layouts.main')
@section('title', 'Đăng ký')
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
    <style type="text/css">
        .card {
            margin: 50px 0;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{-- <div class="card-header">{{ __('Register') }}</div> --}}
                    <div class="card-header"> {{ isset($url) ? ucwords($url) : '' }} {{ __('Đăng Ký') }}</div>
                    <div class="card-body">
                        {{-- <form method="POST" action="{{ route('register') }}"> --}}
                        @isset($url)
                            <form method="POST" action='{{ url("register/$url") }}' aria-label="{{ __('Register') }}">
                            @else
                                <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Đăng Ký') }}">
                                @endisset
                                @csrf
                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">Tên đăng nhập / Số
                                        điện thoại <span style="color: red;">(*)</span></label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            name="username" id="numberInput" value="{{ old('username') }}" required
                                            autocomplete="name" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <script>
                                        document.getElementById("numberInput").addEventListener("input", function(event) {
                                            let value = this.value;
                                            // Xóa bất kỳ ký tự không phải số nào khỏi giá trị nhập vào
                                            value = value.replace(/[^0-9]/g, "");
                                            // Cập nhật giá trị nhập vào
                                            this.value = value;
                                        });
                                    </script>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Họ tên') }}<span
                                            style="color: red;">(*)</span></label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right">Điện thoại mua
                                    </label>

                                    <div class="col-md-6">
                                        <input id="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="{{ old('phone') }}">

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}
                                        <span style="color: red;">(*)</span></label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Mã giới thiệu') }}</label>

                                    <div class="col-md-6">
                                        <input id="code" type="text"
                                            class="form-control @error('code') is-invalid @enderror" name="code"
                                            value="{{ old('code') }}" autocomplete="code">

                                        @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu') }} <span
                                            style="color: red;">(*)</span></label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Nhập lại mật khẩu') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Đăng Ký') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
