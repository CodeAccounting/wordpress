(function ($) {
    "use strict";
    redux.field_objects = redux.field_objects || {};
    redux.field_objects.social_media = redux.field_objects.social_media || {};
    redux.field_objects.social_media.fieldID = '';
    redux.field_objects.social_media.optName = '';
    redux.field_objects.social_media.init = function (selector) {
        if (!selector) {
            selector = $(document).find(".redux-group-tab:visible").find('.redux-container-social_media:visible');
        }

        $(selector).each(
                function () {
                    var el = $(this);
                    var parent = el;
                    if (!el.hasClass('redux-field-container')) {
                        parent = el.parents('.redux-field-container:first');
                    }
                    if (parent.is(":hidden")) { // Skip hidden fields
                        return;
                    }
                    if (parent.hasClass('redux-field-init')) {
                        parent.removeClass('redux-field-init');
                    } else {
                        return;
                    }
                    redux.field_objects.social_media.modInit(el);
                    redux.field_objects.social_media.initReset(el);
                    redux.field_objects.social_media.initDefault(el);
                }
        );
    };
    redux.field_objects.social_media.modInit = function (el) {
        redux.field_objects.social_media.fieldID = el.find('.icons-pack').data('id');
        redux.field_objects.social_media.optName = el.find('.icons-pack').data('opt-name');
        el.find('.icons-sec').enscroll();
        el.find('div.icons-pack .icons-sec ul > li').on('click', function () {
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
                var key = $(this).data('key');
                el.find('li#redux-social_meida-' + key).slideDown();
                redux.field_objects.social_media.updateDataString(el, key, 'enable', 'true');
                el.find('.redux-social_media-url-text-' + key).live('blur', function () {
                    var key = $(this).data('key');
                    var val = $(this).val();
                    redux.field_objects.social_media.updateDataString(el, key, 'url', val);
                });
            }
        });

        el.find('input').live('click', function () {
            var getKey = $(this).data('key');
            el.find('.redux-social_media-url-text-' + getKey).live('blur', function () {
                var key = $(this).data('key');
                var val = $(this).val();
                redux.field_objects.social_media.updateDataString(el, key, 'url', val);
            });
        });
    };
    redux.field_objects.social_media.updateDataString = function (el, key, name, value) {
        var dataEl = el.find('.redux-social_media-hidden-data-' + key);
        var rawData = dataEl.val();
        rawData = decodeURIComponent(rawData);
        rawData = JSON.parse(rawData);
        rawData[name] = value;
        rawData = JSON.stringify(rawData);
        rawData = encodeURIComponent(rawData);
        dataEl.val(rawData);
    };
    redux.field_objects.social_media.initDefault = function (el) {
        el.find('span.del-btn').live('click', function () {
            var key = $(this).data('key');
            redux.field_objects.social_media.updateDataString(el, key, 'enable', '');
            el.find('div.icons-pack div.icons-sec > ul li').each(function () {
                var getKey = $(this).data('key');
                if (getKey === key) {
                    $(this).removeClass('active');
                    el.find('li#redux-social_meida-' + key).slideUp();
                }
            });
        });
        el.find('div.socialmedia-settingsec ul li').each(function () {
            if ($(this).is(':visible')) {
                var rawData = '';
                var key = $(this).data('key');
                var inputData = $(this).find('.redux-social_media-hidden-data-' + key).val();
                rawData = decodeURIComponent(inputData);
                rawData = JSON.parse(rawData);
            }
        });
    };
    redux.field_objects.social_media.initReset = function (el) {
        el.find('button.clear-btn').on('click', function () {
            var buttonClicked = $(this);
            if (buttonClicked.length > 0) {
                var itemToReset = buttonClicked.data('value');
                redux.field_objects.social_media.resetItem(el, itemToReset);
            }
            return false;
        });
    };
    redux.field_objects.social_media.resetItem = function (el, itemID) {
        el.find('input.redux-social_media-color-picker-' + itemID).spectrum("set", '');
        el.find('input.redux-social_media-background-picker-' + itemID).spectrum("set", '');
        redux.field_objects.social_media.updateDataString(el, itemID, 'color', '');
        redux.field_objects.social_media.updateDataString(el, itemID, 'background', '');
        redux.field_objects.social_media.updateDataString(el, itemID, 'url', '');
        el.find('.redux-social_media-url-text-' + itemID).val('');
        el.find('li#redux-social_meida-' + itemID + ' span.icon-title > i').css({
            'background': 'inherit',
            'color': 'inherit'
        });
        return false;
    };
})(jQuery);