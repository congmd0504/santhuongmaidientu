@extends('frontend.layouts.main')



@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')



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
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset
        
            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 block-content-right">
                            <h3 class="title-template-news">{{ $category->name??"" }}</h3>
                            @isset($data)
                                <div class="list-news">
                                    <div class="row">
                                        @foreach ($data as $post)

                                        <div class="fo-03-news col-lg-3 col-md-4 col-sm-6">
                                            <div class="box">
                                                <div class="image">
                                                    <a href="{{ makeLink("post",$post->id,$post->slug) }}"><img src="{{ asset($post->avatar_path) }}" alt="{{ $post->name }}"></a>
                                                </div>
                                                <h3><a href="{{ makeLink("post",$post->id,$post->slug) }}">{{ $post->name }}</a></h3>
                                                <div class="date">{{ date_format($post->updated_at,"d/m/Y")}} - Admin</div>
                                                <div class="desc">
                                                    {!! $post->description  !!}
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                    </div>
                                </div>
                                @if (count($data))
                                {{$data->links()}}
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
<script>
    $(function(){
        $(document).on('click','.pt_icon_right',function(){
            event.preventDefault();
            $(this).parentsUntil('ul','li').children("ul").slideToggle();
            $(this).parentsUntil('ul','li').toggleClass('active');
        })
    })
</script>
@endsection
