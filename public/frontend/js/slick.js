$(function() {
    $('.autoplay1-slide').slick({
        dots: false,
        arrows: true,
        prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>',
        nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>',
        infinite: true,
        speed: 400,
        autoplay: true,
        autoplaySpeed: 1500,
        fade: false,
        cssEase: 'linear'
    });
})