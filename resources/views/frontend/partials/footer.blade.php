<style>
    @media (max-width: 786px) {
        div#button-contact-vr {
            display: none !important;
        }

        footer.footer {
            margin-bottom: 60px;
        }

    }
</style>
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
<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-12 content-box">
                    <div class="footer-layer">
                        <div class="logo-footer">
                            <img src="{{ $footer['logo']->image_path }}" alt="{{ $footer['logo']->name }}">
                        </div>
                        <div class="title-footer">
                            {{ $footer['dataAddress']->value }}
                        </div>
                        <ul class="address_footer">
                            @foreach ($footer['dataAddress']->childs()->where('active', 1)->orderBy('order')->get() as $item)
                                <li><strong>{{ $item->name }}</strong> {{ $item->value }}</li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="row">
                        @foreach ($footer['linkFooter'] as $item)
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 content-box">
                                <div class="footer__other">
                                    <div class="title-footer">
                                        <span>{{ $item->name }} </span>
                                    </div>
                                    <div class="footer__policy">
                                        @foreach ($item->childs as $item2)
                                            <a href="{{ $item2->slug }}"> {{ $item2->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{--
                <div class="col-lg-3 col-md-6 col-sm-12 content-box">
                    <div class="footer__other">
                         <div class="title-footer">
                            <span>  {{ $footer['registerSale']->name }}</span>
                        </div>
                        <div class="desc-footer">
                            {{ $footer['registerSale']->value }}
                        </div>

                        <div class="box-form-2">
                            <form action="index.php?act=newsletter" method="post" name="frmnewsletter" id="frmnewsletter" onsubmit="return validate('Vui lòng nhập email của bạn.');">
                                <div class="form-group">
                                    <input type="text" name="txtemail" class="form-control" placeholder="Nhập địa chỉ email">
                                </div>
                                <button type="submit" class="btn btn-primary">Đăng ký ngay</button>
                            </form>
                        </div> 
                        @if (isset($footer['map']) && $footer['map']->count() > 0)
                        <div class="title-footer">
                            <span>  {{ $footer['map']->name }}</span>
                        </div>
                        <div class="map">
                          {!! $footer['map']->description  !!}
                        </div>
                        @endif
                    </div>
                </div>
                --}}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-xs-12">
                            <div class="list-pay-footer">
                                <div class="title-footer">
                                    {{ $footer['pay']->value }}
                                </div>
                                <div class="image">
                                    <a href="{{ $footer['pay']->slug }}">
                                        <img src="{{ $footer['pay']->image_path }}" alt="{{ $footer['pay']->name }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="box-social-footer">
                                <div class="title-footer">
                                    Kết nối với chúng tôi

                                </div>
                                <div class="social-footer">

                                    <ul>
                                        @foreach ($footer['socialParent']->childs as $social)
                                            <li class=""><a href="{{ $social->slug }}">{!! $social->value !!}
                                                </a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="cpy">
                        <p class="text-xs-center">
                            {{ $footer['coppy_right']->value }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="button-contact-vr">
    <div id="gom-all-in-one">
{{--
        @if (isset($footer['messenger']) && $footer['messenger']->count() > 0)
            <div id="viber-vr" class="button-contact">
                <div class="phone-vr">
                    <div class="phone-vr-circle-fill"></div>
                    <div class="phone-vr-img-circle">
                        <a target="_blank" href="{{ $footer['messenger']->slug }}">
                            <img src="{{ asset($footer['messenger']->image_path) }}" alt="icon_mes">
                        </a>
                    </div>
                </div>
            </div>
        @endif
--}}
        @if (isset($footer['hotline']) && $footer['hotline']->count() > 0)
            <div id="phone-vr" class="button-contact">
                <div class="phone-vr">
                    <div class="phone-vr-circle-fill"></div>
                    <div class="phone-vr-img-circle">
                        <a href="tel:{{ optional($footer['hotline'])->value }}">
                            <img src="{{ asset($footer['hotline']->image_path) }}" alt="phone">
                        </a>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($footer['zalo']) && $footer['zalo']->count() > 0)
            <div id="zalo-vr" class="button-contact">
                <div class="phone-vr">
                    <div class="phone-vr-circle-fill"></div>
                    <div class="phone-vr-img-circle">
                        <a target="_blank" href="https://zalo.me/{{ $footer['zalo']->value }}">
                            <img src="{{ asset($footer['zalo']->image_path) }}" alt="zalo">
                        </a>
                    </div>
                </div>
            </div>
        @endif


    </div>
</div>



























































@if ($footer['menuFixBottom'])
    <style>
        .fix-footer {
            display: none !important;
        }

        .fix-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            padding: 2px 0px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .1);
            z-index: 1;
        }

        .d-block {
            display: block;
        }
        @media (max-width: 1190px) {
            .fix-footer {
                display: block !important;
            }
        }
        @media (max-width: 550px) {
            .fix-footer-box span {
                font-size: 9px !important;
            }

            .fix-footer-box svg {
                width: 20px !important;
                display: block;
            }

            .fix-footer-body .clm {
                padding: 0 !important;
            }
        }

        @media (max-width: 786px) {
         

            .fix-footer-body .clm {
                padding-right: 5px;
                padding-left: 5px;
            }

            .fix-footer-box .svg-active,
            .fix-footer-box .active2 .svg-noactive {
                display: none;
            }

            .fix-footer-box .active2 span {
                color: #055c00;
            }

            .fix-footer-box span {
                font-size: 13px;
                font-weight: 500;
                color: gray;
            }
        }

        [style*="--w-xs"] {
            width: calc(100%/12 * var(--w-xs));
            max-width: calc(100%/12 * var(--w-xs));
        }

        .fix-footer-box svg {
            height: 20px;
            width: 33px;
            fill: gray;
            margin: 6px auto;
        }

        svg {
            overflow: hidden;
            vertical-align: middle;
        }

        .clm {
            flex: 1 0 auto;
            padding-inline: var(--gutter);
        }

        .ta-center {
            text-align: center;
        }

        .ctnr {
            padding: 0 7px;
            margin: 0 auto;
            max-width: 100%;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-inline: calc(-1 * var(--gutter));
        }
    </style>
    <div class="fix-footer d-block">
        <div class="ctnr">
            <div class="fix-footer-body">
                <div class="row">
                    @foreach ($footer['menuFixBottom']->childs()->where('active', 1)->orderBy('order')->orderByDesc('created_at')->get() as $key => $i)
                        <div class="clm" style="--w-xs:2.4;">
                            <div class="fix-footer-box">
                                @if ($i->id == 114)
                                    <a href="@guest # @else{{ $i->slug }} @endguest"
                                        class="d-block ta-center @guest btn-signin @endguest">
                                        {!! $i->value !!}
                                        <span class="d-block">
                                            {{ $i->name }}
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ $i->slug }}" class="d-block ta-center">
                                        {!! $i->value !!}
                                        <span class="d-block">
                                            {{ $i->name }}
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.btn-signin').on("click", function() {
            $('#myModalSignIn').addClass('show');
            return false;
        })
        $('#myModalSignIn .modal-bg, #myModalSignIn .close').on("click", function() {
            $('#myModalSignIn').removeClass('show');
        })
    </script>
@endif
