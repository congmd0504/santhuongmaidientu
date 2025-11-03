

$(document).ready(function () {
	showmorefilter();

	$('.filter-group .filter-group-title').click(function (e) {
		$(this).parent().toggleClass('active');
	});
	$('.filter-mobile').click(function (e) {
		$('.aside.aside-mini-products-list.filter').toggleClass('active');
	});
	$('#show-admin-bar').click(function (e) {
		$('.aside.aside-mini-products-list.filter').toggleClass('active');
	});
	$('.filter-container__selected-filter-header-title').click(function (e) {
		$('.aside.aside-mini-products-list.filter').toggleClass('active');
	});
});

function showmorefilter() {
	var stringmore = 'Xem thêm <img src="https://ngoctrai.me/assets/icon/more_filter.svg" alt="more"/>',
	stringless = 'Thu gọn <img src="https://ngoctrai.me/assets/icon/more_filter.svg" alt="more"/>';
	$(document).on('click', '.showmore.more', function () {
		$(this).removeClass('more').addClass('less').html(stringless);
		$(this).closest('.aside-content').find('ul').removeClass('maxheight');
	});
	$(document).on('click', '.showmore.less', function () {
		$(this).removeClass('less').addClass('more').html(stringmore);
		$(this).closest('.aside-content').find('ul').addClass('maxheight');
	});
}
window.showmorefilter = showmorefilter;
$(document).on('change', '#start', function (e) {
	var val = parseInt($('#start input').val()) - 1;
	var val2 = parseInt($('#stop input').val()) + 1;
	$("#slider").slider("values", 0, parseInt(val));
	$('#filter-value').attr('data-value', '(>' + val + ' AND <' + val2 + ')');
});
$(document).on('change', '#stop', function (e) {
	var val = parseInt($('#start input').val()) - 1;
	var val2 = parseInt($('#stop input').val()) + 1;
	$("#slider").slider("values", 1, parseInt(val2));
	$('#filter-value').attr('data-value', '(>' + val + ' AND <' + val2 + ')');
});
if ($(window).width() > 1200) {
	$('.aside-filter .aside-title').click(function () {
		$(this).toggleClass('active');
		$(this).next().slideToggle()
	})
}
else {
	$('.move-fillter .aside-item .aside-title').click(function () {
		$(this).toggleClass('active');
		$('.move-fillter .aside-item .aside-title').not(this).removeClass('active');
		$('.section_sort .sort-cate-left .title').removeClass('active');
		$('.section_sort .sort-cate-left>ul').hide();
	})
	$('.section_sort .sort-cate-left .title').click(function () {
		$(this).toggleClass('active');
		$(this).next().toggle();
		$('.move-fillter .aside-item .aside-title').not(this).removeClass('active');
	})
	$('.dqdt-sidebar .aside-filter .filter-mb .aside-title').click(function () {
		$(this).toggleClass('active');
		$(this).next().slideToggle()
	})
}
$.fn.extend({
	toggleText: function (a, b) {
		return this.html(this.html() == b ? a: b);
	}
});
var height = $('.coll-desc').height();
if (height > 110) {
	$('.coll-desc').css({
		'height': '110px',
		'padding-bottom': '0'
	}).append('<a href="javascript:;" class="view-more"><span>Xem thêm <img src="https://ngoctrai.me/assets/icon/more_filter.svg" alt="more"/></span></a>')
}
$(".coll-desc").on("click", ".view-more", function () {
	$(".coll-desc").toggleClass("open");
	$(this).toggleText('<span>Xem thêm <img src="https://ngoctrai.me/assets/icon/more_filter.svg" alt="more"/>', '<span>Thu gọn <img src="https://ngoctrai.me/assets/icon/more_filter.svg" alt="more"/>');
});