$(document).ready(function() {
    /*
    $(".menu-desktop .nav-sub .nav-sub-child").each(function() {
        let length = $(this).find(".nav-sub-item-child").length;
        if (length) {
            $(this).prev("a").append("<i class='fa fa-angle-right pt_icon_right'></i>");
        }
    });
    $(".menu-desktop .nav-item .nav-sub").each(function() {
        if ($(this).find(".nav-sub-item").length) {
            $(this).prev("a").append("<i class='fa fa-angle-down' aria-hidden='true'></i>");
        }
    })
    $(".menu_fix_mobile .nav-sub").each(function() {
        if ($(this).find(".nav-sub-item").length) {
            $(this).parent(".nav-item").prepend("<i class='fa fa-chevron-down mm1'></i>");
        }
    })
    $(".menu_fix_mobile .nav-sub-child").each(function() {
        if ($(this).find(".nav-sub-item-child").length) {
            $(this).parent(".nav-sub-item").prepend("<i class='fa fa-chevron-down mm2'></i>");
        }
    })
    $(".menu_fix_mobile .megamenu-container .list-megamenu").each(function() {
        if ($(this).find(".megamenu-item").length) {
            $(this).parents(".nav-megamenu").prepend("<i class='fa fa-chevron-down mega-mn1'></i>");
        }
    });
    */

    $(".megamenu-item-sub .submenu-right3").each(function() {
        let length = $(this).find("li").length;
        if (length) {
            $(this).prev("a").append("<div class='openc'></div>");

        }
    })
    $(".megamenu-item-sub .openc").click(function() {
        event.preventDefault();
        $(this).parents(".megamenu-item-sub").find(".submenu-right3").slideToggle();
        $(this).parents(".megamenu-item-sub").toggleClass('active');
    })

    $(".mega-mn1").click(function() {
        $(this).parents(".nav-megamenu").find(".megamenu-container").slideToggle();
    });

    $('.category-action').click(function() {
        $('.menu_fix_mobile').addClass('main-menu-show');
        $(this).addClass('change');
    });

    $('.close-menu #close-menu-button').click(function() {
        $(this).parent().parent().removeClass('main-menu-show');
        $('.list-bar').removeClass('change');
    });

    $('.menu_fix_mobile .mn-icon').click(function() {
        event.preventDefault();
        $(this).parent('a').next('ul').slideToggle();
        $(this).parent().toggleClass('active');
    });
    // $('.menu_fix_mobile .mm2').click(function() {
    //     $(this).parent().find('.nav-sub-child').slideToggle();
    //     $(this).parent().toggleClass('active');
    // });

    $('.show_search a').click(function() {
        $('#search').slideToggle();
    });
    $('.close-search').click(function() {
        $('#search').slideToggle();
    })
    $('.search_mobile').click(function() {
        $('#search').slideToggle();
    });

    setTimeout(function () {
        $(function () {
            var lastScrollTop = 0,
            delta = 5;
            $(window).scroll(function () {
                var nowScrollTop = $(this).scrollTop();
                if (Math.abs(lastScrollTop - nowScrollTop) >= delta) {
                    if (nowScrollTop > lastScrollTop) {
                        if ($(window).width() > 1200) {
                            $('.header').addClass('scroll-down');
                            $('.header').removeClass('scroll-up');
                        }
                    } else {
                        if ($(window).width() > 1200) {
                            $('.header').removeClass('scroll-down');
                            $('.header').addClass('scroll-up');
                        }
                    }
                    lastScrollTop = nowScrollTop;
                }
                if ($(this).scrollTop() > 10 && !$('.header').hasClass('scroll')) {
                    $('.header').addClass('scroll');
                    $('body').addClass('scroll');
                } else if ($(this).scrollTop() <= 10) {
                    $('.header').removeClass('scroll');
                    $('body').removeClass('scroll');
                }
            });
        });
    },
    1500);

    /*$(window).scroll(function(event) {
        var pos_body = $('html,body').scrollTop();
        if (pos_body > 160) {
            $('.header').addClass('fixed');
        } else {
            $('.header').removeClass('fixed');
        }
    });*/

    $('.column').click(function() {
        var src = $(this).find('img').attr('src');
        $(".hrefImg").attr("href", src);
        $("#expandedImg").attr("src", src);
    });
    $('.slide_small').slick({
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 3,
            }
        }]
    });

    $('.faded').slick({
        dots: true,
        infinite: true,
        speed: 1000,
        autoplay: true,
        autoplaySpeed: 3000,
        fade: true,
        cssEase: 'linear'
    });

    $('.autoplay4').slick({
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        responsive: [{
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
    $('.slide6_row2').slick({
        dots: false,
        arrows: true,
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        speed: 600,
        autoplaySpeed: 3000,
        responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 5,

            }
        },
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 4,

            }
        },
        {
            breakpoint: 767,
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

    $('.autoplay3').slick({
        dots: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        responsive: [{
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

    $('.slide5_row2').slick({
        dots: false,
        arrows: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        speed: 600,
        autoplaySpeed: 3000,
        responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,

            }
        },
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 4,

            }
        },
        {
            breakpoint: 767,
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

    $('.autoplay5').slick({
        dots: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        responsive: [{
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


    $('.autoplay5-doitac').slick({
        dots: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        responsive: [{
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

    $(window).scroll(function(event) {
        var pos_body = $('html').scrollTop();
        if (pos_body > 300) {
            $('#back-to-top').fadeIn();;
        } else {
            $('#back-to-top').fadeOut();;
        }
    });
});






function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

function myFunction2(x) {
    x.classList.toggle("change2");
}