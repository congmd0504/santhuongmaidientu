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
            @include('frontend.components.breadcrumbs', [
                'breadcrumbs' => $breadcrumbs,
                'breadcrumbs' => $breadcrumbs,
                'type' => $typeBreadcrumb,
            ])
            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 block-content-right">
                            <div class="content-about">
                                {!! $data->content !!}
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
