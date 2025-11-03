@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? 'Thông báo')
@section('keywords', $seo['keywords'] ?? 'Thông báo')
@section('description', $seo['description'] ?? 'Thông báo')
@section('abstract', $seo['abstract'] ?? 'Thông báo')
@section('image', $seo['image'] ?? '')
@section('css')
    <style>
        nav.mt-2.background-color-white.sodu-mobile.border-radius-5 {
            display: none !important;
        }

        nav.mt-2.background-color-white.khampha-mobile.border-radius-5 {
            display: none !important;
        }

        .pd-profile-2.display-flex {
            display: none;
        }

        .wrap-load-image .form-group {
            margin: 0;
        }

        .pd-profile {
            padding: 0px 15px;
        }

        .background-color-white {
            background-color: white;
        }

        .box-tt-profile {
            margin-bottom: 10px;
        }

        .box-tt-profile {
            display: flex;
        }

        .box-icon-profile {
            width: 40px;
            border: 1px solid #dfdfdf;
            padding: 8px;
            border-radius: 100%;
            -webkit-border-radius: 100%;
            -moz-border-radius: 100%;
            display: flex;
            justify-content: center;
            height: 40px;
            align-items: center;
        }

        .text-pro {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }

        .text-pro a {
            line-height: 18px;
            font-weight: 500;
            font-size: 16px;
        }

        .box-icon-profile i {
            color: rgb(72, 185, 65);
        }

        @media(max-width:550px) {
            #sidebar-profile {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="wrap-content-main">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thông báo</h3>
                            </div>
                            @if (isset($postsHotNew) && $postsHotNew->count() > 0)
                                <div class="pd-profile">

                                    <div class = "mt-2 background-color-white border-radius-5">
                                        @foreach ($postsHotNew as $item)
                                            <div class="box-tt-profile">
                                                <div class="icon-pro">
                                                    <div class="box-icon-profile">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="text-pro">
                                                    <a href="{{ $item->slug_full }}">{{ $item->name }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
@endsection
