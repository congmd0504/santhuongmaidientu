@extends('frontend.layouts.main')



@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')


@section('css')
<style>
    .main {
        background-color: #fff;
        width: 100%;
    }

    .list-comment::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    .list-comment::-webkit-scrollbar {
        width: 5px;
        background-color: #F5F5F5;
    }

    .list-comment::-webkit-scrollbar-thumb {
        background-color: #a29c9c;
        border: 2px solid #cdc2c2;
    }

    .form-post-cmt {
        padding-top: 15px;
    }

    .form-post-cmt p {
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        padding-bottom: 5px;
    }

    .subscribe-form {
        --main-focus: #2d8cf0;
        --font-color: #FEFEFE;
        --font-color-sub: #666;
        --bg-color: #111;
        --main-color: #FEFEFE;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        display: flex;
        flex-direction: row;
        width: 100%;
        height: 35px;
        border-radius: 5px;
        box-shadow: #2d8cf0;
    }

    .modal-header p {
        padding-bottom: 20px;
    }

    .subscribe-input {
        width: 100%;
        height: 100%;
        padding: 5px 10px;
        border: 1px solid #cdcdcd7a;
        border-right: 0;
        border-radius: 25px 0px 0px 25px;
        font-size: 13px;
        font-weight: 500;
        color: var(--font-color);
    }

    .slide-box {
        min-width: 25%;
    }

    .subscribe-btn {
        width: 100px;
        height: 40px;
        border: 1px solid #dbd7d78a;
        border-radius: 0 25px 25px 0;
        background-color: #dbd7d78a;
        font-size: 12px;
        letter-spacing: 1px;
        font-weight: 500;
        color: #111;
        cursor: pointer;
    }

    .subscribe-input:focus {
        outline: none;
        border: 2px solid var(--main-focus);
        border-right: 0;
    }

    /* .wrapper.home {
            overflow: hidden;
            width: 428px;
            margin: 0 auto;
            max-width: 428px;
        } */

    .box-comment-new {
        padding-bottom: 15px;
        display: flex;

    }

    .avater-comment {
        width: 48px;
        height: 48px;
        border-radius: 100%;
        overflow: hidden;
    }

    .content-comment span {
        display: flex;
        color: #111;
        font-weight: 600;
        font-size: 15px;
        align-items: center;
    }

    .content-comment {
        margin-left: 5px;
        background: #dbd7d75c;
        border-radius: 16px;
        padding: 3px 10px;
        width: calc(100% - 60px);
    }

    .content-comment span p {
        font-size: 11px;
        padding-left: 5px;
    }

    p.commnt-news-bottom {
        font-size: 14px;
    }
/* 
    .content-wrapper {
        margin-bottom: 105px;
    } */

    .box {
        background-color: white !important;
    }

    ul#myTab {
        background: #eee;
    }

    .box-item {
        margin: 0px 0 15px 0;
        border-bottom: 1px solid #eee;
        padding: 0 10px;
    }

    .box-name .name p {
        text-transform: uppercase;
    min-height: 45px;
    }

    .box-title {
        display: inline-flex;
        align-items: center;
        margin: 5px;
        padding-bottom: 10px;
        padding-top: 10px;
    }

    .box-title .img-avatar {
        width: 40px;
        height: 40px;
    }

    .box-title .box-name {
        margin-left: 10px;
    }

    .box-title .box-name .time {
        font-size: 12px;
    }

    .box-title .box-name .name {
        font-weight: 700;
    }

    .box-item .box-name-new {
        margin: 10px 5px;
    }

    .box-img-post img {
        width: 100%;
        
        object-fit: cover;
        border-radius: 10px;
        overflow: hidden;
    }
    .form_search{
        width: 1180px;
    margin: 0 auto;
    }
.box-img-post {
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    overflow: hidden;
    border-radius: 10px;
}
    .box-title .img-avatar img {
        border-radius: 50%;
        height: 40px;
        width: 40px;
        object-fit: cover;
    }

    .box-item .box-name-new h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }
    .box-img-post:hover img {
    transform: scale(1.1);
    transition: 0.5s ease;
}
.box-social-footer .title-footer{
    font-size: 16px;
}



    #myTab::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    #myTab::-webkit-scrollbar {
        width: 2px;
        background-color: #F5F5F5;
        display: none;
    }

    #myTab::-webkit-scrollbar-thumb {
        background-color: #cdcdcd;
        border: 2px solid #cdcdcd;
    }

    ul#myTab {
        overflow-x: auto;
        min-width: max-content;
        max-width: fit-content;
    }

    .box-ovl-page-facevert {
        background: #edededff;
        overflow: auto;
    }

    .box-item .box-des p {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        overflow: hidden;
        -webkit-box-orient: vertical;
        margin: 0 5px;
    }

    .box-item .box-like svg {
        height: 1.5rem;
        width: 1.5rem;
        display: inline-block;
        margin-left: 5px;
        cursor: pointer;
    }

    .box-like {
        padding: 5px 0;
    }

    button.close {
        position: absolute;
        top: 0;
        right: 5px;
    }

    .modal-header {
        display: -ms-flexbox;
        display: unset;
        -ms-flex-align: start;
        align-items: flex-start;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: calc(.3rem - 1px);
        border-top-right-radius: calc(.3rem - 1px);
        position: relative;
    }

    .input-group {
        position: relative;
        display: flex;
        border-collapse: separate;
    }

    .subscribe-input {
        color: #000;
    }

    .list-comment {
        height: 200px;
        overflow-y: scroll;
    }

    .box-list-comment {
        border: 1px solid #eee;
        padding: 10px;
        border-radius: 5px;
    }

    .box-des p {
        font-size: 14px;
    }

    .box-like {
        padding: 10px 0;
    }

    .content-comment {
        position: relative;
    }

    .content-comment .delete {
        position: absolute;
        top: 0px;
        right: 10px;
        cursor: pointer;
    }

    span.btn-xoa {
        display: none !important;
    }

    .btn-xoa.active {
        display: block !important;
    }

    span.btn-xoa.active {
        position: absolute;
        top: 0px;
        right: 35px;
        color: #fff;
        font-size: 10px;
        border: 1px solid #000;
        padding: 5px;
        background: #000;
        border-radius: 5px;
    }

    span.btn-xoa.active:before {
        content: "";
        position: absolute;
        border-top: 5px solid transparent;
        border-left: 7px solid #000;
        top: 8px;
        right: -19px;
        border-bottom: 5px solid transparent;
        width: 20px;
        background: none;
    }





    .up-post {
        background-color: #fff;
        margin-bottom: 10px;
        display: block;
        padding: 10px 10px;
    }

    .up-post-box.up-post-box-click {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .up-post-box.up-post-box-click img {
        height: 40px;
        width: 40px;
    }

    .up-post-box.up-post-box-click button {
        flex: 1;
        margin: 0px 16px;
        border: 1px solid #c2c2c2;
        border-radius: 30px;
        height: 32px;
        text-align: left;
        font-size: 12px;
        display: flex;
        justify-content: left;
        line-height: 32px;
        font-weight: 500;
    }

    .up-post-box.up-post-box-click .circle {
        height: 40px;
        width: 40px;
    }

    .up-post-box.up-post-box-click figure {
        padding: 0px;
        margin: 0px;
    }

    figure .box-imgse-right {}

    img.box-imgse-right {}

    .slideshow.scroll-x.d-flex {
        background-color: white;
        padding: 15px;
        margin-bottom: 10px;
        /* scroll-behavior: smooth;
                                                                  -webkit-overflow-scrolling: touch;
                                                                  scroll-snap-type: x mandatory;
                                                                  scroll-padding-left: 15px;
                                                                  overflow-x: auto;
                                                                  display: flex;
                                                                  scroll-snap-align: start;
                                                                  scroll-snap-stop: always; */
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scroll-snap-stop: always;
        scroll-snap-type: x mandatory;
        scroll-padding-left: 15px;
        overflow-x: auto;
        display: flex;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .slide__img img {
        border-radius: 10px;
        object-fit: cover;
    }

    .slide__img .overlay::after {
        border-radius: 10px;
    }
.content-wrapper .container, .container-fluid {
    padding-left: 15%;
    padding-right: 15%;
}
    .overlay::after {
        position: absolute;
        content: "";
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: black;
        opacity: .3;
    }

    .slide-box.scroll-snap-align-start {
        position: relative;
    }

    .slide-box {
        height: 200px !important;
        width: 100%;
        margin-right: 7px;
    }


    .box-item {
        width: calc(100% / 1);
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    
    border-radius: 10px;
    overflow: hidden;
}

.box--itemp-perer {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

/* .wrapper.home {
    width: 1200px;
    max-width: 1200px;
    margin: 0 auto;
} */
.container{
    width: unset;
}
.header .container{
    width: 100%;
}
.fix-footer-box:last-child {
    padding-right: 0px;
}
@media (max-width:990px){
.container, .container-fluid{
	    padding-left: 10%;
    padding-right: 10%;
}
 {
        width: calc(100% / 1);
}
@media (max-width:768px){
.container, .container-fluid{
	    padding-left: 10%;
    padding-right: 10%;
}
.box-item {
        width: calc(100% / 1);
}
}
    .form_search {
    width: 100%;
    margin: 0 auto;
}   
    .card-body.table-responsive.p-3 {
    padding: 31px !important;
}
    
.box-social-footer {
    display: flex;
    justify-content: space-between;
}

 
}
    @media (max-width:550px) {
.content-wrapper .container, .container-fluid{
    padding-left: 0px;
    padding-right: 0px;
}
.container, .container-fluid{
	    padding-left: 15px;
    padding-right: 15px;
}
         {
             width: calc(96% / 1);
        }
        .slide-box {
            min-width: 33.333%;
        }
    }

    .scroll-snap-align-start {
        scroll-snap-align: start;
    }

    .slide__content {
        position: absolute;
        top: 65px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
    }

    .slide__content h2 {
        color: #fff;
        font-size: 15px;
    }

    .slide__content img {
        width: 50px;
        height: 50px;
    }

    .circle {
        border-radius: 100%;
    }


    @media (max-width: 540px) {
        .header .header-tool {
            margin-right: 0px;
        }

        .wrapper.home {
            width: 100%;
            max-width: 100%;
        }

        .box-img-post img {
            object-fit: cover;
        }
         .box-name-new h3 {
                margin: 0;
                font-size: 16px;
        }
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container">
        <div class="main">
    
            <div class="up-post">
                <div class="up-post-box up-post-box-click">
                    <figure>
                        <a href="{{ route('profile.index') }}">
                            <img src="{{ Auth::user()->avatar_path ?? asset('admin_asset/images/username.png') }}" alt="{{ Auth::user()->name }}" style="border-radius:50%">
                        </a>
                    </figure>
    
                    <button onclick="window.location.href='{{ route('post.create') }}'">
                        Bạn đang nghĩ gì?
                    </button>
                    <figure>
                        <a href="{{ route('listPostByUser') }}">
                            <img src="{{ asset('frontend/images/list-bai-dang.webp') }}" alt="">
                        </a>
                    </figure>
                </div>
            </div>
    
            <div class="slideshow scroll-x d-flex">
                @foreach ($dataLimit5 as $item)
                @php
                $user1 = App\Models\User::where('id', $item->user_id)->first();
                $admin = App\Models\Admin::where('id', $item->admin_id)->first();
                if ($admin) {
                $user = $admin;
                } else {
                $user = $user1;
                }
                @endphp
                <div class="slide-box scroll-snap-align-start p-relative h-100">
                    <div class="slide__img p-absolute h-100  w-100">
                        <img class="h-100 w-100 d-block circle" src="{{ $item->avatar_path }}" alt="{{ $item->name }}">
                        <div class="overlay"></div>
                    </div>
                    <div class="slide__content p-relative ta-center">
                        <a href="{{ $item->slug_full }}">
                            <img src="{{ $user->avatar_path ?? asset('admin_asset/images/username.png') }}" alt="{{ $user->name }}" class="circle">
                        </a>
                        <h2>{{ $user->name }}</h2>
                    </div>
                </div>
                @endforeach
    
            </div>
    
            <div class="box--itemp-perer">
                @foreach ($data as $item)
                @php
                $user1 = App\Models\User::where('id', $item->user_id)->first();
                $admin = App\Models\Admin::where('id', $item->admin_id)->first();
                if ($admin) {
                $user = $admin;
                } else {
                $user = $user1;
                }
                @endphp
                
                
                
                <div class="box-item">
                    <div class="box-title">
                        <div class="img-avatar">
                            <img src="{{ $user->avatar_path ?? asset('admin_asset/images/username.png') }}" alt="{{ $user->name }}">
                        </div>
                        <div class="box-name">
                            <div class="time">
                                <p>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                            </div>
                            <div class="name">
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-img-post">
                        <a href="{{ $item->slug_full }}"><img src="{{ $item->avatar_path }}" alt="{{ $item->name }}"></a>
                    </div>
                    <div class="box-name-new">
                        <h3><a href="{{ $item->slug_full }}">{{ $item->name }}</a></h3>
                    </div>
                    <div class="box-des">
                        <p>{{ $item->description }}</p>
                    </div>
                
                    <div class="box-like">
                        <span class="like">
                            @php
                            $like = App\Models\Like::where('post_id', $item->id)->count();
                            $userLike = App\Models\Like::where('user_id', Auth::id())
                            ->where('post_id', $item->id)
                            ->first();
                            @endphp
                            <a id="like_{{ $item->id }}">
                                @if ($userLike)
                                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" style="fill: red;">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                                @else
                                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                                @endif
                            </a>
                
                            <span id="count_like_{{ $item->id }}">
                                {{ $like }}
                            </span>
                        </span>
                        <script>
                            $(document).on('click', '#like_{{ $item->id }}', function() {
                                $.ajax({
                                    url: "{{ route('post.like', ['id_post' => $item->id]) }}", // Đặt URL của API hoặc đường dẫn mà bạn gửi yêu cầu Ajax
                                    type: 'GET', // Hoặc 'POST' tùy thuộc vào phương thức mà bạn đang sử dụng
                                    success: function(response) {
                                        $('#like_{{ $item->id }}').html(response.html);
                                        $('#count_like_{{ $item->id }}').html(response.countLike);
                                    },
                                    error: function(error) {
                                        console.error('Lỗi:', error);
                                    }
                                });
                            })
                        </script>
                        {{-- <span class="comment" data-toggle="modal" data-target="#staticBackdrop_{{ $item->id }}"> --}}
                        <span class="comment" id="clickShowComment_{{ $item->id }}">
                            <svg width="64px" height="64px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                </g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>comment-3</title>
                                    <desc>Created with Sketch Beta.</desc>
                                    <defs> </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-204.000000, -255.000000)" fill="#000000">
                                            <path d="M228,267 C226.896,267 226,267.896 226,269 C226,270.104 226.896,271 228,271 C229.104,271 230,270.104 230,269 C230,267.896 229.104,267 228,267 L228,267 Z M220,281 C218.832,281 217.704,280.864 216.62,280.633 L211.912,283.463 L211.975,278.824 C208.366,276.654 206,273.066 206,269 C206,262.373 212.268,257 220,257 C227.732,257 234,262.373 234,269 C234,275.628 227.732,281 220,281 L220,281 Z M220,255 C211.164,255 204,261.269 204,269 C204,273.419 206.345,277.354 210,279.919 L210,287 L217.009,282.747 C217.979,282.907 218.977,283 220,283 C228.836,283 236,276.732 236,269 C236,261.269 228.836,255 220,255 L220,255 Z M212,267 C210.896,267 210,267.896 210,269 C210,270.104 210.896,271 212,271 C213.104,271 214,270.104 214,269 C214,267.896 213.104,267 212,267 L212,267 Z M220,267 C218.896,267 218,267.896 218,269 C218,270.104 218.896,271 220,271 C221.104,271 222,270.104 222,269 C222,267.896 221.104,267 220,267 L220,267 Z" id="comment-3" sketch:type="MSShapeGroup"> </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span id="count_comment_{{ $item->id }}">
                                {{ $item->comments()->count() }}
                            </span>
                        </span>
                    </div>
                    <div class="box-list-comment" id="loadShowComment_{{ $item->id }}" style="display:none">
                        <div class="list-comment" id="list-comment-{{ $item->id }}">
                            @foreach ($item->comments()->get() as $i_child)
                            @php
                            $userDang = App\Models\User::where('id', $i_child->user_id)->first();
                            @endphp
                            <div class="box-comment-new">
                                <div class="avater-comment">
                                    <img src="{{ $userDang->avatar_path ?? asset('admin_asset/images/username.png') }}" alt="{{ $userDang->name }}">
                                </div>
                                <div class="content-comment">
                                    <span>{{ $userDang->name }}
                                        <p>
                                            ({{ \Carbon\Carbon::parse($i_child->created_at)->diffForHumans() }})
                                        </p>
                                    </span>
                                    <p class="commnt-news-bottom">{{ $i_child->content }}</p>
                                    @if (Auth::id() == $i_child->user_id)
                                    <span class="delete" id="delete_{{ $i_child->id }}">...</span>
                                    @endif
                                    <a href="{{ route('destroyComment', ['id' => $i_child->id, 'post_id' => $item->id]) }}">
                                        <span class="btn-xoa" id="btn-xoa_{{ $i_child->id }}">Xóa</span>
                                    </a>
                                    <script>
                                            $(document).on('click', '#delete_{{ $i_child->id }}', function(e) {
                                                var btnXoa_{{$i_child->id }}= document.querySelector('#btn-xoa_{{ $i_child->id }}');
                                                btnXoa_{{ $i_child->id }}.classList.toggle('active');
                                            });
                                        </script>
                                    <script>
                                        $(document).on('click', '#btn-xoa_{{ $i_child->id }}', function(e) {
                                            e.preventDefault();
                                            var listComment = document.getElementById('list-comment-{{ $item->id }}');
                                            $.ajax({
                                                type: 'GET',
                                                url: "{{ route('destroyComment', ['id' => $i_child->id, 'post_id' => $item->id]) }}",
                                                success: function(response) {
                                                    $('#list-comment-{{ $item->id }}').html(response.html);
                                                    $('#count_comment_{{ $item->id }}').html(response.countComment);
                                                    if (response.countComment <= 3) {
                                                        listComment.style.height = 'auto';
                                                        listComment.style.overflowY = 'unset';
                                                    } else {
                                                        listComment.style.height = '200px';
                                                        listComment.style.overflowY = 'scroll';
                                                    }
                                                },
                                                error: function(response) {}
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-post-cmt">
                            {{-- <p>Viết bình luận</p> --}}
                            <form class="subscribe-form" action="{{ route('commentPost', ['id' => $item->id]) }}" method="GET" data-ajax="commentPost_{{ $item->id }}">
                                <input class="subscribe-input" placeholder="Viết bình luận công khai..." type="text" name="content" required>
                                <button class="subscribe-btn">Gửi</button>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).on('click', '#clickShowComment_{{ $item->id }}', function() {
                            var item_{{ $item->id }} = document.getElementById('loadShowComment_{{ $item->id }}');
                            var listComment = document.getElementById('list-comment-{{ $item->id }}');

                            // Kiểm tra số lượng phần tử con có id là 'box-comment-new'
                            var boxCommentNewElements = listComment.querySelectorAll('.box-comment-new');

                            // Lấy độ dài của mảng chứa các phần tử con có id là 'box-comment-new'
                            var numberOfComments = boxCommentNewElements.length;
                            if (item_{{ $item -> id }}.style.display == 'none') {
                                if (numberOfComments <= 3) {
                                    listComment.style.height = 'auto';
                                    listComment.style.overflowY = 'unset';
                                } else {
                                    listComment.style.height = '200px';
                                    listComment.style.overflowY = 'scroll';
                                }
                                item_{{$item -> id}}.style.display = 'block';
                            } else {
                                item_{{$item -> id}}.style.display = 'none';
                            }
                        });
                        // Lấy ra phần tử div#list-comment
                    </script>
                    
                </div>
                <!-- Button trigger modal -->
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#staticBackdrop_{{ $item->id }}">
                Click {{ $item->id }}
                </button> --}}
                
                <!-- Modal -->
                {{-- <div class="modal fade" id="staticBackdrop_{{ $item->id }}"
                data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p>Viết bình luận</p>
                            <form class="subscribe-form" action="{{ route('commentPost', ['id' => $item->id]) }}" method="GET" data-ajax="commentPost_{{ $item->id }}">
                                <input class="subscribe-input" placeholder="Nhập bình luận..." type="text" name="content" required>
                                <button class="subscribe-btn">Đăng</button>
                            </form>
                
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="update_comment_{{ $item->id }}">
                            @foreach ($item->comments()->get() as $i_child)
                            @php
                            $userDang = App\Models\User::where(
                            'id',
                            $i_child->user_id,
                            )->first();
                            @endphp
                            <div class="box-comment-new">
                                <div class="avater-comment">
                                    <img src="{{ $userDang->avatar_path ?? asset('admin_asset/images/username.png') }}" alt="{{ $userDang->name }}">
                                </div>
                                <div class="content-comment">
                                    <span>{{ $userDang->name }}
                                        <p>
                                            ({{ \Carbon\Carbon::parse($i_child->created_at)->diffForHumans() }})
                                        </p>
                                    </span>
                                    <p class="commnt-news-bottom">{{ $i_child->content }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                </div> --}}
                <script>
                $(document).on('submit', "[data-ajax='commentPost_{{ $item->id }}']", function(e) {
                    e.preventDefault();
                    let myThis = $(this);
                    let formValues = $(this).serialize();
                    var listComment = document.getElementById('list-comment-{{ $item->id }}');
                
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('commentPost', ['id' => $item->id]) }}",
                        data: formValues,
                        success: function(response) {
                            $('#list-comment-{{ $item->id }}').html(response.html);
                            $('#count_comment_{{ $item->id }}').html(response.countComment);
                            if (response.countComment <= 3) {
                                listComment.style.height = 'auto';
                                listComment.style.overflowY = 'unset';
                            } else {
                                listComment.style.height = '200px';
                                listComment.style.overflowY = 'scroll';
                            }
                            myThis[0].reset();
                        },
                        error: function(response) {}
                    });
                });
                </script>
                @endforeach
            </div>
    
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
</script>
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