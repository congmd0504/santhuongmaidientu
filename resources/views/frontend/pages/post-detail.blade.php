@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')

@section('css')
    <style>
        body {
            margin-top: 20px;
            background: #ebeef0;
        }

        .wrap-comment img {
            width: auto;
        }

        .img-sm {
            width: 46px;
            height: 46px;
        }

        .panel {
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.075);
            border-radius: 0;
            border: 0;
            margin-bottom: 15px;
        }

        .panel .panel-footer,
        .panel>:last-child {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .panel .panel-heading,
        .panel>:first-child {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .panel-body {
            padding: 25px 20px;
        }


        .media-block .media-left {
            display: block;
            float: left
        }

        .media-block .media-right {
            float: right
        }

        .media-block .media-body {
            display: block;
            overflow: hidden;
            width: auto
        }

        .middle .media-left,
        .middle .media-right,
        .middle .media-body {
            vertical-align: middle
        }

        .thumbnail {
            border-radius: 0;
            border-color: #e9e9e9
        }

        .tag.tag-sm,
        .btn-group-sm>.tag {
            padding: 5px 10px;
        }

        .tag:not(.label) {
            background-color: #fff;
            padding: 6px 12px;
            border-radius: 2px;
            border: 1px solid #cdd6e1;
            font-size: 12px;
            line-height: 1.42857;
            vertical-align: middle;
            -webkit-transition: all .15s;
            transition: all .15s;
        }

        .text-muted,
        a.text-muted:hover,
        a.text-muted:focus {
            color: #acacac;
        }

        .text-sm {
            font-size: 0.9em;
        }

        .text-5x,
        .text-4x,
        .text-5x,
        .text-2x,
        .text-lg,
        .text-sm,
        .text-xs {
            line-height: 1.25;
        }

        .btn-trans {
            background-color: transparent;
            border-color: transparent;
            color: #929292;
        }

        .btn-icon {
            padding-left: 9px;
            padding-right: 9px;
        }

        .btn-sm,
        .btn-group-sm>.btn,
        .btn-icon.btn-sm {
            padding: 5px 10px !important;
        }

        .mar-top {
            margin-top: 15px;
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
            @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs', [
                    'breadcrumbs' => $breadcrumbs,
                    'type' => $typeBreadcrumb,
                ])
            @endisset

            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 block-content-right">
                            <div class="news-detail">
                                <h1 class="news-title">
                                    {{ $data->name }}
                                </h1>
                                <div class="author">
                                    <div class="date">
                                        <div class="year">Ngày đăng: {{ date_format($data->created_at, 'd/m/Y') }}</div>
                                    </div>
                                    <div class="name-author">Đăng bởi: Admin</div>
                                </div>
                                <div class="image">
                                    <img src=" {{ $data->avatar_path }}" alt="{{ $data->name }}">
                                </div>

                                <div class="content-news">
                                    {!! $data->description !!}
                                </div>

                                <div class="content-news">
                                    {!! $data->content !!}
                                </div>
                                <ul class="list_tab">
                                    <li><i class="fa fa-tag" aria-hidden="true"></i> Tags</li>
                                    <li><a href=""></a></li>
                                </ul>
                                <div class="share-with">
                                    <div class="share-article">
                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-591d2f6c5cc3d5e5"></script>
                                        <div class="addthis_inline_share_toolbox"></div>
                                    </div>
                                </div>
                                @isset($dataRelate)
                                    @if ($dataRelate)
                                        @if ($dataRelate->count())
                                            <div class="list-news-relate">
                                                <div class="box-list-news-relate">
                                                    <h3 class="news-relate-title">Bài viết liên quan</h3>
                                                    <ul>
                                                        @foreach ($dataRelate as $item)
                                                            <li><span>›</span><a
                                                                    href="{{ makeLink('post', $item->id, $item->slug) }}">
                                                                    {{ $item->name }}<span
                                                                        class="">({{ date_format($item->created_at, 'd/m/Y') }})</span></a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endisset

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- <div class="wrap-comment">
                <div class="container bootdey">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 bootstrap snippets">
                                <div class="panel bg-light ">
                                    <div class="panel-body">
                                        <form action="{{ route('comment.store',[
                                            'type'=>'post',
                                            'id'=>$data->id
                                        ]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="image_path" >
                                        <textarea class="form-control" rows="2" placeholder="What are you thinking?" name="content"></textarea>
                                        <div class="mar-top clearfix">
                                            <button class="btn btn-sm btn-primary pull-right" type="submit"><i class="fa fa-pencil fa-fw"></i> Share</button>
                                            <a class="btn btn-trans btn-icon fa fa-video-camera add-tooltip" href="#"></a>
                                            <a class="btn btn-trans btn-icon fa fa-camera add-tooltip" href="#"></a>
                                            <a class="btn btn-trans btn-icon fa fa-file add-tooltip" href="#"></a>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                <div class="panel bg-light">

                                    <div class="panel-body">
                                        <!-- Newsfeed Content -->
                                        <!--===================================================-->
                                        <div class="media-block">
                                            <a class="media-left" href="#"><img class="rounded-circle img-sm" alt="Profile Picture" src="https://bootdey.com/img/Content/avatar/avatar1.png"></a>
                                            <div class="media-body pl-1">
                                                <div class="mar-btm">
                                                    <a href="#" class="btn-link text-semibold media-heading box-inline">Lisa D.</a>
                                                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> - From Mobile - 11 min ago</p>
                                                </div>
                                                <p>consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex
                                                    ea commodo consequat.</p>
                                                <div class="pad-ver">
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-default btn-hover-success" href="#"><i class="fa fa-thumbs-up"></i></a>
                                                        <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i class="fa fa-thumbs-down"></i></a>
                                                    </div>
                                                    <a class="btn btn-sm btn-default btn-hover-primary" href="#">Comment</a>
                                                </div>
                                                <hr>

                                                <!-- Comments -->
                                                <div>
                                                    <div class="media-block">
                                                        <a class="media-left" href="#"><img class="rounded-circle img-sm" alt="Profile Picture" src="https://bootdey.com/img/Content/avatar/avatar2.png"></a>
                                                        <div class="media-body pl-1">
                                                            <div class="mar-btm">
                                                                <a href="#" class="btn-link text-semibold media-heading box-inline">Bobby Marz</a>
                                                                <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> - From Mobile - 7 min ago</p>
                                                            </div>
                                                            <p>Sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                                            <div class="pad-ver">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-sm btn-default btn-hover-success active" href="#"><i class="fa fa-thumbs-up"></i> You Like it</a>
                                                                    <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i class="fa fa-thumbs-down"></i></a>
                                                                </div>
                                                                <a class="btn btn-sm btn-default btn-hover-primary" href="#">Comment</a>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>

                                                    <div class="media-block">
                                                        <a class="media-left" href="#"><img class="rounded-circle img-sm" alt="Profile Picture" src="https://bootdey.com/img/Content/avatar/avatar3.png">
                                                        </a>
                                                        <div class="media-body pl-1">
                                                            <div class="mar-btm">
                                                                <a href="#" class="btn-link text-semibold media-heading box-inline">Lucy Moon</a>
                                                                <p class="text-muted text-sm"><i class="fa fa-globe fa-lg"></i> - From Web - 2 min ago</p>
                                                            </div>
                                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate ?</p>
                                                            <div class="pad-ver">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-sm btn-default btn-hover-success" href="#"><i class="fa fa-thumbs-up"></i></a>
                                                                    <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i class="fa fa-thumbs-down"></i></a>
                                                                </div>
                                                                <a class="btn btn-sm btn-default btn-hover-primary" href="#">Comment</a>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <div class="bg-light p-2">
                                                        <div class="d-flex flex-row align-items-start"><img class="rounded-circle img-sm" alt="Profile Picture" src="https://bootdey.com/img/Content/avatar/avatar3.png"><textarea class="form-control ml-1 shadow-none textarea"></textarea></div>
                                                        <div class="mt-2 text-right"><button class="btn btn-primary btn-sm shadow-none" type="button">Post comment</button><button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button">Cancel</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--===================================================-->
                                        <!-- End Newsfeed Content -->


                                        <!-- Newsfeed Content -->
                                        <!--===================================================-->
                                        <div class="media-block pad-all">
                                            <a class="media-left" href="#"><img class="rounded-circle img-sm" alt="Profile Picture" src="https://bootdey.com/img/Content/avatar/avatar1.png"></a>
                                            <div class="media-body pl-1">
                                                <div class="mar-btm">
                                                    <a href="#" class="btn-link text-semibold media-heading box-inline">John Doe</a>
                                                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> - From Mobile - 11 min ago</p>
                                                </div>
                                                <p>Lorem ipsum dolor sit amet.</p>
                                                <img class="img-responsive thumbnail" src="https://via.placeholder.com/400x300" alt="Image">
                                                <div class="pad-ver">
                                                    <span class="tag tag-sm"><i class="fa fa-heart text-danger"></i> 250 Likes</span>
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-default btn-hover-success" href="#"><i class="fa fa-thumbs-up"></i></a>
                                                        <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i class="fa fa-thumbs-down"></i></a>
                                                    </div>
                                                    <a class="btn btn-sm btn-default btn-hover-primary" href="#">Comment</a>
                                                </div>
                                                <hr>

                                                <!-- Comments -->
                                                <div>
                                                    <div class="media-block pad-all">
                                                        <a class="media-left" href="#"><img class="rounded-circle img-sm" alt="Profile Picture" src="https://bootdey.com/img/Content/avatar/avatar2.png"></a>
                                                        <div class="media-body pl-1">
                                                            <div class="mar-btm">
                                                                <a href="#" class="btn-link text-semibold media-heading box-inline">Maria Leanz</a>
                                                                <p class="text-muted text-sm"><i class="fa fa-globe fa-lg"></i> - From Web - 2 min ago</p>
                                                            </div>
                                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate ?</p>
                                                            <div>
                                                                <div class="btn-group">
                                                                    <a class="btn btn-sm btn-default btn-hover-success" href="#"><i class="fa fa-thumbs-up"></i></a>
                                                                    <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i class="fa fa-thumbs-down"></i></a>
                                                                </div>
                                                                <a class="btn btn-sm btn-default btn-hover-primary" href="#">Comment</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--===================================================-->
                                        <!-- End Newsfeed Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
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
    <script src="{{ asset('frontend/js/Comment.js') }}"></script>
    <script>
        console.log($('div').createFormComment());
    </script>
@endsection
