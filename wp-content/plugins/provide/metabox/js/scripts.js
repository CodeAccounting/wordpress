(function ($) {
    "use strict";
    $('div.icons-pack div.icons-sec ul li').live('click', function () {
        var type = $(this).parents('div.icons-sec').attr('id');
        $('div#' + type + ' ul li').each(function () {
            $(this).removeClass('active');
        });
        var value = $(this).children('i').attr('class');
        $(this).toggleClass('active');
        var input = $(this).parents('div.icons-pack').prev('input');
        $(input).val(value);
    });
})(jQuery);