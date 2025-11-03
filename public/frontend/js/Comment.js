(function($) {
    $.fn.createFormComment = function(option) {
        var setting = $.extend({
            //   a: 3,
        }, option);
        return this.each(function() {
            console.log(setting.a);
        });
    }
}(jQuery));