jQuery(document).ready(function ($) {
    'use strict';

    $('input.single-grabber, input.multi-grabber').on('click', function () {
        var type = $(this).data('type');
        var urls = $(this).prev('input, textarea').val();
        var data = 'urls=' + urls + '&type=' + type + '&action=grabber';
        $.ajax({
            type: "post",
            url: grabber.ajax,
            data: data,
            cache: false,
            async: true,
            dataType: 'JSON',
            beforeSend: function () {
            }
        }).done(function (response) {
        });

        return false;
    });
});