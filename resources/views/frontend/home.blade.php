@extends('frontend.layouts.main')
@section('title', optional($header['seo_home'])->name)
@section('keywords', optional($header['seo_home'])->slug)
@section('description', optional($header['seo_home'])->value)
@section('image', asset(optional($header['seo_home'])->image_path))
{{-- @section('abstract', $seo['abstract'] ?? '') --}}
@section('image', $shareFrontend['logo'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.4/dist/fancybox.css" />
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="slide">
                @isset($slider)
                    <div class="box-slide faded">
                        @foreach ($slider as $item)
                            <div class="item-slide">
                                <a href="{{ $item->slug }}"><img src="{{ $item->image_path }}" alt="{{ $item->name }}"></a>
                            </div>
                        @endforeach
                    </div>
                @endisset
            </div>
            <div class="gioithieu">
                <div class="container">
                    <div class="row " style="align-items: center">
                        @if (isset($gioi_thieu) && $gioi_thieu->count() > 0)
                            <div class="col-lg-6">
                                <div class="box-gioithieu">
                                    <div class="title-gioithieu">
                                        {!! $gioi_thieu->name !!}
                                        <div class="img_header_home">
                                            <img src="./frontend/images/img_home_header.png" alt="">
                                        </div>
                                    </div>
                                    <div class="desc-gioithieu">
                                        {!! $gioi_thieu->value !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="box-gioithieu">
                                <div class="img">
                                    {!! $gioi_thieu->description !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-12" >
                            <a href="{{ $gioi_thieu->slug }}" class="more-gioithieu">Tìm hiểu thêm</a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- banner
        <div class="baner-img">
            <div class="img">
                <img src="{{$banner_tren->image_path}}" alt="{{$banner_tren->name}}">
            </div>
        </div>
end banner --}}
            {{-- VÌ SAO GỌI DƯỢC PHẨM FT LÀ 1 TUYỆT PHẨM?
        @if (isset($tuyet_pham) && $tuyet_pham->count() > 0)
        <div class="whychoose">
            <div class="container">
                <div class="title-ss">
                    <span class="line-title-left"></span>
                    <h3>{{$tuyet_pham->name}}</h3>
                    <span class="line-title-right"></span>
                </div>
                <div class="content-whychoose">
                    <div class="row row-whychoose">
                        @foreach ($tuyet_pham->childs()->where('active', 1)->get() as $item)
                        <div class="col-md-3 col-sm-4 col-6 col-whychoose">
                            <div class="item-whychoose">
                                <img src="{{$item->image_path}}" alt="{{$item->name}}">
                                <div class="info-whychoose">
                                    <h3>{{$item->name}} </h3>
                                    {{$item->value}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        --}}
            @if (isset($vi_sao) && $vi_sao->count() > 0)
                <div class="whychoose" id="whychoose-distribution">
                    <div class="container">
                        <div class="title-ss">
                            <h3>
                                {{ $vi_sao->name }}
                            <br>
                                {!! $vi_sao->value !!}
                            </h3>
                        </div>
                        <div class="img_header_home">
                            <img src="./frontend/images/img_home_header.png" alt="">
                        </div>
                        <div class="content-whychoose">
                            <div class="row row-distribution">
                                @foreach ($vi_sao->childs()->where('active', 1)->get() as $item)
                                    <div class="col-lg-6 col-md-6  col-12">
                                        <div class="item-distribution">
                                            <div class="img">
                                                <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
                                            </div>
                                            <div class="info-distribution">
                                                <h3 class="title-distribution">{{ $item->name }}</h3>
                                                <div class="desc-distribution">
                                                    {!! $item->value !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            @endif
            {{-- CHỨNG NHẬN
        @if (isset($chung_nhan) && $chung_nhan->count() > 0)
        <div class="certifications-awards">
            <div class="container">
                <div class="title-ss">
                    <span class="line-title-left"></span>
                    <h3>{{$chung_nhan->name}}</h3>
                    <span class="line-title-right"></span>
                </div>
                <div class="content-awards">
                    <div class="row row-awards">
                        @foreach ($chung_nhan->childs()->where('active', 1)->get() as $item)
                        <div class="col-6 col-lg-3 col-md-4 col-sm-6 col-awards">
                            <div class="img">
                                <img src="{{$item->image_path}}" alt="{{$item->name}}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
--}}
            {{--        sản phẩm nổi bật --}}
            <div class="sanphamnoibat">
                <div class="container">
                    <div class="title-ss">
                        <h3>{{ $sp_noibat->name }}</h3>
                    </div>
                    <div class="img_header_home">
                        <img src="./frontend/images/img_home_header.png" alt="">
                    </div>
                    <div class="title-ss-sub">
                        {!! $sp_noibat->value !!}
                    </div>
                    <div class="content-customers_say">
                        <div class="row-col-customers slick-4">
                            @foreach ($productsHot as $item)
                                <div class="col-customers">
                                    <div class="item-customers">
                                        <div class="box-customers">
                                            <div class="img-sanpham"> <a href="{{ $item->slug_full }}"><img
                                                        src="{{ $item->avatar_path }}" alt="{{ $item->name }}"></a></div>
                                            <div class="info-sanpham">
                                                <a href="{{ $item->slug_full }}">
                                                    <h3 class="name-sanpham">
                                                        {{ $item->name }}
                                                    </h3>
                                                </a>
                                                <div class="gia-sanpham">
                                                    Giá:
                                                    <span class="new-price">
                                                        {{ number_format($item->price) }}
                                                    </span>
                                                </div>
                                                <a href="{{ $item->slug_full }}">
                                                    <button class="muangay">
                                                        Mua ngay
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                   
                </div>
            </div>
            {{--        sản phẩm nổi bật --}}
            <div class="media">
                <div class="container">
                    <div class="title-ss">
                        <h3>{{ $media->name }}</h3>
                    </div>
                    <div class="img_header_home">
                        <img src="./frontend/images/img_home_header.png" alt="">
                    </div>
                    <div class="content-media">
                        <ul class="tab-media">
                            @foreach ($media->childs()->get() as $item)
                                @if ($loop->first)
                                    <li class="item-tab active">
                                        <div class="bg_boder"></div>
                                        <span>{{ $item->name }}</span>
                                    </li>
                                @else
                                    <li class="item-tab">
                                        <div class="bg_boder"></div>
                                        <span>{{ $item->name }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="wapper-content">
                            <div class="tab-content-media active" id="tab-media-1">
                                <div class="wapper-media slick-4">
                                    @foreach ($post1->childs()->get() as $item)
                                        <div class="item-media">
                                            <div class="box-media">
                                                <a href="{{ $item->image_path }}" data-fancybox="images" class="img">
                                                    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-content-media" id="tab-media-2">
                                <div class="wapper-media slick-4">
                                    @foreach ($post2->childs()->get() as $item)
                                        <div class="item-media">
                                            <div class="box-media">
                                                <a href="{{ $item->image_path }}" data-fancybox="images" class="img">
                                                    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-content-media" id="tab-media-3">
                                <div class="wapper-media slick-4">
                                    @foreach ($post3->childs()->get() as $item)
                                        <div class="item-media">
                                            <div class="box-media">
                                                <a href="{{ $item->image_path }}" data-fancybox="images" class="img">
                                                    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="customers-say">
                <div class="container">
                    <div class="title-ss">
                        <h3>{{ $khach_hang_noi->name }}</h3>
                    </div>
                    <div class="img_header_home">
                        <img src="./frontend/images/img_home_header.png" alt="">
                    </div>
                    <div class="title-ss-sub">
                        {{ $khach_hang_noi->value }}
                    </div>
                    <div class="content-customers_sayslider slick-5">
                        @php
                            $khach_hang = $khach_hang_noi->childs()->where('active', 1)->get();
                            $chunks = array_chunk($khach_hang->toArray(), 2);
                        @endphp

                        @foreach($khach_hang_noi->childs()->where('active', 1)->get() as $chunk)
                            <div class="item_number">
                                <div class="item_fixback">
                                  <div class="item">
                                        <a href="" data-fancybox="images">
                                            <img src="{{$chunk->image_path}}" alt="{{$chunk->name}}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="video_fixback">
                        <div class="title-ss">
                            <h3>{{$cam_nhan->name}}</h3>
                        </div>
                        <div class="img_header_home">
                            <img src="./frontend/images/img_home_header.png" alt="">
                        </div>
                        <div class="content_video slick-4-2">
                            @foreach($cam_nhan->childs()->where('active',1)->get() as $item)
                            <div class="item">
                              {!!$item->description!!}
                            </div>
                           @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="NEWS-KNOWLEDGE">
                <div class="container">
                    <div class="title-ss">
                        <h3> TIN TỨC NỔI BẬT</h3>
                    </div>
                    <div class="img_header_home">
                        <img src="./frontend/images/img_home_header.png" alt="img_home_header">
                    </div>
                    <div class="content-news">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          @foreach($cate_post->childs()->where('active', 1)->get() as $key=>$item)
                            @if($loop->first)
                              <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-{{ $key }}" data-bs-toggle="tab" data-bs-target="#content-{{ $key }}" type="button" role="tab" aria-controls="home" aria-selected="true">
                                  <div class="bg_boder"></div>
                                  <span>{{ $item->name }}</span>
                                </button>
                              </li>
                            @else
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-{{ $key }}" data-bs-toggle="tab" data-bs-target="#content-{{ $key }}" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                  <div class="bg_boder"></div>
                                  <span>{{ $item->name }}</span>
                                </button>
                              </li>
                            @endif
                          @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          @foreach($cate_post->childs()->where('active', 1)->get() as $key=>$item)
                            @if($loop->first)
                              <div class="tab-pane fade show active" id="content-{{ $key }}" role="tabpanel" aria-labelledby="tab-{{ $key }}">
                                <div class="content_tab_noibat">
                                    <div class="all_content slick-4">
                                      @php
                                      $post = \App\Models\Post::where([
                                      ['active', 1],
                                      ['category_id', $item->id],
                                      ['hot', 1]
                                      ])->orderByDesc("id")->limit(6)->get();
                                      @endphp
                                      @foreach($post as $postItem)
                                      <div class="item">
                                        <a href="{{ $postItem->slug_full }}">
                                          <div class="img one">
                                            <img src="{{ $postItem->avatar_path }}" alt="{{ $postItem->name }}">
                                          </div>
                                          <div class="text">
                                            <h2>{{ $postItem->name }}</h2>
                                          </div>
                                        </a>
                                      </div>
                                      @endforeach
                                    </div>
                                    <div class="timhieuthem">
                                      <a href="{{ $item->slug_full }}">Tìm hiểu thêm</a>
                                    </div>
                                  </div>
                                  
                              </div>
                            @else
                              <div class="tab-pane fade" id="content-{{ $key }}" role="tabpanel" aria-labelledby="tab-{{ $key }}">
                                <div class="content_tab_noibat">
                                    <div class="all_content slick-4">
                                      @php
                                      $post = $item->posts()->where('active',1)->where('hot', 1)->orderByDesc("id")->limit(6)->get();
                                 
                                      @endphp
                                      @foreach($post as $postItem)
                                      <div class="item">
                                        <a href="{{ $postItem->slug_full }}">
                                          <div class="img one">
                                            <img src="{{ $postItem->avatar_path }}" alt="{{ $postItem->name }}">
                                          </div>
                                          <div class="text">
                                            <h2>{{ $postItem->name }}</h2>
                                          </div>
                                        </a>
                                      </div>
                                      @endforeach
                                    </div>
                                    <div class="timhieuthem">
                                      <a href="{{ $item->slug_full }}">Tìm hiểu thêm</a>
                                    </div>
                                  </div>
                                  
                              </div>
                            @endif
                          @endforeach
                        </div>
                      </div>
                      
                </div>
            </div>

            <div class="contact-consultants">
                <div class="container">
                    <div class="form-contact-tr">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl-6 col-xxl-6">
                                <div class="img_form">
                                    <div class="title-ss">
                                        <h3>{{ $chung_nhan->name }}</h3>
                                    </div>
                                    <div class="img_header_home">
                                        <img src="./frontend/images/img_home_header.png" alt="">
                                    </div>
                                    <div class="img image_one">
                                        <img src="{{ $chung_nhan->image_path }}" alt="{{ $chung_nhan->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6 col-xxl-6">
                                <div class="content_form">
                                    <div class="title-ss">
                                        <h3>Liên hệ ngay hôm nay!</h3>
                                    </div>
                                    <div class="img_header_home">
                                        <img src="./frontend/images/img_home_header.png" alt="">
                                    </div>
                                    <form action="{{ route('contact.storeAjax') }}"
                                        data-url="{{ route('contact.storeAjax') }}" data-ajax="submit"
                                        data-target="alert" data-href="#modalAjax" data-content="#content"
                                        data-method="POST" method="POST">
                                        @csrf
                                        <div class="dv-form">
                                            <input type="text" name="name" placeholder="Họ tên*">
                                        </div>
                                        <div class="dv-form">
                                            <input type="tel" name="phone" required
                                                attern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                placeholder="Số điện thoại*">
                                        </div>
                                        <div class="dv-form">
                                            <input type="email" name="email" placeholder="Email">
                                        </div>
                                        <div class="dv-form">
                                            <textarea name="content" id="" cols="30" rows="3" placeholder="Lời nhắc"></textarea>
                                        </div>
                                        <div class="btn-form">
                                            <button>Gửi yêu cầu</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="dress_map">
                                    <div class="title-ss">
                                        <h3>{{ $he_thong->name }}</h3>
                                    </div>
                                    <div class="img_header_home">
                                        <img src="./frontend/images/img_home_header.png" alt="">
                                    </div>
                                    <div>
                                        {!! $he_thong->description !!}
                                    </div>
                                    <div class="map">
                                       {!! $bd->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.4/dist/fancybox.umd.js"></script>
    <script>
        $('.wapper-customers_say').slick({
            dots: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            // arrows: true,
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="ti-angle-left"></i></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"> <i class="ti-angle-right"></i></button>',
            // responsive: [{
            //         breakpoint: 1200,
            //         settings: {
            //             slidesToShow: 4,

            //         }
            //     },
            //     {
            //         breakpoint: 991,
            //         settings: {
            //             slidesToShow: 4,

            //         }
            //     },
            //     {
            //         breakpoint: 767,
            //         settings: {
            //             slidesToShow: 3,

            //         }
            //     },
            //     {
            //         breakpoint: 600,
            //         settings: {
            //             slidesToShow: 2,
            //         }
            //     }
            // ]
        });

        $('.slick-4').slick({
            dots: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            // arrows: true,
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="ti-angle-left"></i></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"> <i class="ti-angle-right"></i></button>',
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,

                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
        $('.slick-4-2').slick({
            dots: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            // arrows: true,
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="ti-angle-left"></i></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"> <i class="ti-angle-right"></i></button>',
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                
            ]
        });
        $('.slick-5').slick({
            dots: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="ti-angle-left"></i></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"> <i class="ti-angle-right"></i></button>',
            responsive: [{
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,

                }
            }]
        });
        $('.slick-3').slick({
            dots: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            // arrows: true,
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="ti-angle-left"></i></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"> <i class="ti-angle-right"></i></button>',
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                    }
                }
            ]
        });
        $('.wapper-health_product').slick({
            dots: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            // arrows: true,
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="ti-angle-left"></i></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"> <i class="ti-angle-right"></i></button>',
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                    }
                },
            ]
        })
    </script>

    <script>
        let tab_content_media = document.querySelectorAll('.tab-content-media')
        console.log()
        let item_tabs = document.querySelectorAll(".item-tab")
        item_tabs.forEach((item_tab, index) => {
            item_tab.addEventListener('click', () => {
                document.querySelector('.active.item-tab').classList.remove('active')
                item_tab.classList.add('active')
                document.querySelector(".tab-content-media.active").classList.remove('active')
                tab_content_media[index].classList.add("active")
            })
        })
    </script>
    <script type="text/javascript">
        function scrollToAboutUs() {
            $('html, body').animate({
                scrollTop: $(".du_an3").offset().top - 90
            }, 1000);
        }
    </script>
    <script>
        $('.doitac').slick({
            dots: false,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: true,
            prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
            nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
            responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 4,

                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 4,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 550,
                    settings: {
                        slidesToShow: 2,
                    }
                }
            ]
        });
        $('.slider-spyt').slick({
            dots: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: true,
            prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
            nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
            responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 550,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    </script>
@endsection
