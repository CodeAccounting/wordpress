jQuery(document).ready(function ($) {
    "use strict";
    
    jQuery(".close-view-popup").live("click", function(){
        jQuery(".quick-view-popup").removeClass("show");
        jQuery(".quick-view-popup").remove();
        jQuery("html").removeClass("stop-scroll");
    });
    
    jQuery('li.menu-item-has-children').on("hover", function() {
       var $length = jQuery(this).children('ul').find('li').length;
       if($length > 8) {
           jQuery(this).children('ul.sub-menu').addClass('megamenu');
       }
    });

    if ($('.wpb_revslider_element').parent('div').prev('div').hasClass('col-md-12 pro-col')) {
        $('.wpb_revslider_element').parent('div').prev('div').remove();
    }

    var monstertWidget = ['widget_recent_entries', 'widget_recent_comments', 'widget_meta', 'widget_archive', 'widget_calendar', 'widget_categories', 'widget_pages', 'widget_rss', 'widget_text', 'widget_tag_cloud', 'widget_nav_menu']
    $(monstertWidget).each(function (i, v) {
        $('div.sidebar div.' + v + ' h4').next().wrap('<div class="widget-wrapper"></div>');
    });

    $(monstertWidget).each(function (i, v) {
        if (v == 'widget_archive') {
            $('div.widget_archive').each(function () {
                    $(this).find('label.screen-reader-text').remove();
                }
            );
        }
    })
    ;

    $(monstertWidget).each(function (i, v) {
        if (v == 'widget_categories') {
            $('div.widget_categories').each(function () {
                $(this).find('label.screen-reader-text').remove();
            });


        }
    });

    $(monstertWidget).each(function (i, v) {
        if (v == 'widget_archive') {
            $('div.sidebar div.widget_archive').each(function () {
                var $this = $(this);
                if ($($this).children('select').length) {
                    var $select = $($this).children('select');
                    $($this).children('select').remove();
                    $($this).find('div.widget-wrapper').append($select);
                }
            });


        }
    });

    $(monstertWidget).each(function (i, v) {
        if (v == 'widget_categories') {
            $('div.sidebar div.widget_categories').each(function () {
                var $this = $(this);
                if ($($this).children('select').length) {
                    var $select = $($this).children('select');
                    $($this).children('select').remove();
                    $($this).find('div.widget-wrapper').append($select);
                }
            });


        }
    });
    /*=================== Header Search ===================*/
    $(".header-search > a").on("click", function () {
        $(this).parent().toggleClass('active');
        return false;
    });

    
		

    /*=================== Dropdown Class ===================*/
    $("nav li ul").parent().addClass("has-children");

    /*=================== Accordion ===================*/
    $(".toggle").each(function(){
        $(this).find('.content').hide();
        $(this).find('h2:first, h3:first').addClass('active').next().slideDown(500).parent().addClass("activate");
        $('h2, h3', this).click(function() {
            if ($(this).next().is(':hidden')) {
                $(this).parent().parent().find("h2, h3").removeClass('active').next().slideUp(500).removeClass('animated fadeInUp').parent().removeClass("activate");
                $(this).toggleClass('active').next().slideDown(500).addClass('animated fadeInUp').parent().toggleClass("activate");
            }
        });
    });


    /*=================== Responsive Menu ===================*/
    $(".menu-button").on("click", function () {
        $(".responsive-menu").addClass("slidein");
        return false;
    });
    $(".close-menu").on("click", function () {
        $(".responsive-menu").removeClass("slidein");
        return false;
    });


    /*================== Responsive Menu Dropdown =====================*/
    $(".responsive-menu ul ul, .creative-header ul ul").parent().addClass("menu-item-has-children");
    $(".responsive-menu ul li.menu-item-has-children > a, .creative-header ul li.menu-item-has-children > a").on("click", function() {
        $(this).parent().toggleClass("active").siblings().removeClass("active");
        $(this).next("ul").slideToggle();
        $(this).parent().siblings().find("ul").slideUp();
        return false;
    });


    /*=================== Lightbox ===================*/
    if ($.isFunction($.fn.html5lightbox)) {
        jQuery(".html5lightbox").html5lightbox();
    }

    /* Script for WordPress */
    $('form#widget-contact-form button#submit-form').on('click', function (e) {
        var parent = $(this).parents('form'),
            $this = $(this),
            receiver = $(parent).find('input#receiver').val(),
            name = $(parent).find('input#name').val(),
            email = $(parent).find('input#email').val(),
            subject = $(parent).find('input#subject').val(),
            msg = $(parent).find('textarea#msg').val(),
            btnText = $(this).html(),
            log = $(parent).prev('div.log'),
            data = 'receiver=' + receiver +
                '&name=' + name +
                '&email=' + email +
                '&subject=' + subject +
                '&msg=' + msg +
                '&action=widgetContactForm';
        jQuery.ajax({
            type: "post",
            url: provide.ajaxurl,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $($this).prop('disabled', true);
                $($this).html("<i class='fa fa-cog spin'></i>");
            }
        }).done(function (res) {
            $(log).empty();
            $($this).prop('disabled', false);
            $($this).html(btnText);
            if (res.status === true) {
                $(log).html(res.msg);
                $(parent).slideUp('slow')
            } else if (res.status === false) {
                $(log).html(res.msg).show();
            }
            setTimeout(function () {
                $(log).empty().hide();
            }, 5000);
        }).fail(function (error) {
            $('.total-score').find('strong').html('0');
            console.log(error.text);
        });
        e.preventDefault();
    });

    // fun fact newsletter
    $('form#funfact_newletter button#funfact_newletter_button').on('click', function (e) {
        var parent = $(this).parents('form'),
            $this = $(this),
            email = $(parent).find('input#newsletter_email').val(),
            log = $(parent).prev('div.log'),
            data = '&email=' + email +
                '&action=funFactNewsletter';
        jQuery.ajax({
            type: "post",
            url: provide.ajaxurl,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $($this).prop('disabled', true);
                $($this).html("<i class='fa fa-cog spin'></i>");
            }
        }).done(function (res) {
            $(log).empty();
            $($this).prop('disabled', false);
            $($this).html("<i class='fa fa-paper-plane'></i>");
            if (res.status === true) {
                $(log).html(res.msg);
                $(parent).find('input#newsletter_email').val('');
            } else if (res.status === false) {
                $(log).html(res.msg);
            }
            setTimeout(function () {
                $(log).empty();
            }, 5000);
        }).fail(function (error) {
            $('.total-score').find('strong').html('0');
            console.log(error.text);
        });
        e.preventDefault();
    });
    // fun fact newsletter

    // request a quote
    $('form#req_submit button#req_submit_button').on('click', function (e) {
        var parent = $(this).parents('form'),
            $this = $(this),
            receiver = $(parent).find('input#req_rec_email').val(),
            name = $(parent).find('input#req_name').val(),
            email = $(parent).find('input#req_email').val(),
            number = $(parent).find('input#req_number').val(),
            btnText = $(this).html(),
            log = $(parent).prev('div.log'),
            data = 'receiver=' + receiver +
                '&name=' + name +
                '&email=' + email +
                '&number=' + number +
                '&action=requestAQuote';
        jQuery.ajax({
            type: "post",
            url: provide.ajaxurl,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $($this).prop('disabled', true);
                $($this).html("<i class='fa fa-cog spin'></i>");
            }
        }).done(function (res) {
            $(log).empty();
            $($this).prop('disabled', false);
            $($this).html(btnText);
            if (res.status === true) {
                $(log).html(res.msg);
                $(parent).slideUp('slow')
            } else if (res.status === false) {
                $(log).html(res.msg);
            }
            setTimeout(function () {
                $(log).empty();
            }, 5000);
        }).fail(function (error) {
            $('.total-score').find('strong').html('0');
            console.log(error.text);
        });
        e.preventDefault();
    });
    // request a quote

    // contact us with social box
    $('form#cuwsb_form button#cuwsb_submit').on('click', function (e) {
        var parent = $(this).parents('form'),
            $this = $(this),
            receiver = $(parent).find('input#cuwsb_receiver').val(),
            name = $(parent).find('input#cuwsb_name').val(),
            email = $(parent).find('input#cuwsb_email').val(),
            msg = $(parent).find('textarea#cuwsb_message').val(),
            btnText = $(this).html(),
            log = $(parent).prev('div.log'),
            data = 'receiver=' + receiver +
                '&name=' + name +
                '&email=' + email +
                '&msg=' + msg +
                '&action=cuwsbContactForm';
        jQuery.ajax({
            type: "post",
            url: provide.ajaxurl,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $($this).prop('disabled', true);
                $($this).html("<i class='fa fa-cog spin'></i>");
            }
        }).done(function (res) {
            $(log).empty();
            $($this).prop('disabled', false);
            $($this).html(btnText);
            if (res.status === true) {
                $(log).html(res.msg);
                $(parent).slideUp('slow')
            } else if (res.status === false) {
                $(log).html(res.msg);
            }
            setTimeout(function () {
                $(log).empty();
            }, 5000);
        }).fail(function (error) {
            $('.total-score').find('strong').html('0');
            console.log(error.text);
        });
        e.preventDefault();
    });
    // contact us with social box

    // video with newsletter
    $('form#v_newsletter button#v_newsletter_button').on('click', function (e) {
        var parent = $(this).parents('form'),
            $this = $(this),
            email = $(parent).find('input#v_newsletter_email').val(),
            log = $(parent).prev('div.log'),
            btnText = $(this).html(),
            data = '&email=' + email +
                '&action=videoNewsletter';
        jQuery.ajax({
            type: "post",
            url: provide.ajaxurl,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $($this).prop('disabled', true);
                $($this).html("<i class='fa fa-cog spin'></i>");
            }
        }).done(function (res) {
            $(log).empty();
            $($this).prop('disabled', false);
            $($this).html(btnText);
            if (res.status === true) {
                $(log).html(res.msg);
                $(parent).find('input#v_newsletter_email').val('');
            } else if (res.status === false) {
                $(log).html(res.msg);
            }
            setTimeout(function () {
                $(log).empty();
            }, 5000);
        }).fail(function (error) {
            $('.total-score').find('strong').html('0');
            console.log(error.text);
        });
        e.preventDefault();
    });
    // video with newsletter

    // contact us
    $('form#c_form button#c_submit').on('click', function (e) {
        var parent = $(this).parents('form'),
            $this = $(this),
            receiver = $(parent).find('input#c_receiver').val(),
            name = $(parent).find('input#c_name').val(),
            email = $(parent).find('input#c_email').val(),
            subject = $(parent).find('input#c_subject').val(),
            msg = $(parent).find('textarea#c_message').val(),
            btnText = $(this).html(),
            log = $(parent).prev('div.log'),
            data = 'receiver=' + receiver +
                '&name=' + name +
                '&email=' + email +
                '&subject=' + subject +
                '&msg=' + msg +
                '&action=mainContactForm';
        jQuery.ajax({
            type: "post",
            url: provide.ajaxurl,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $($this).prop('disabled', true);
                $($this).html("<i class='fa fa-cog spin'></i>");
            }
        }).done(function (res) {
            $(log).empty();
            $($this).prop('disabled', false);
            $($this).html(btnText);
            if (res.status === true) {
                $(log).html(res.msg);
                $(parent).slideUp('slow')
            } else if (res.status === false) {
                $(log).html(res.msg);
            }
            setTimeout(function () {
                $(log).empty();
            }, 5000);
        }).fail(function (error) {
            $('.total-score').find('strong').html('0');
            console.log(error.text);
        });
        e.preventDefault();
    });
    // contact us





    
    /*=================== Sticky Header ===================*/
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll > 200) {
            $(".menubar.stick, header.style3 .logobar.stick").addClass("sticky animated fadeInDown");
            var nav_height = $(".menubar.stick, header.style3 .logobar.stick").innerHeight();
            $(".menu-height, .logobar-height").css({
                "height": nav_height
            });
        } else if (scroll < 200) {
            $(".menubar.stick, header.style3 .logobar.stick").removeClass("sticky animated fadeInDown");
            $(".menu-height, .logobar-height").css({
                "height": 0
            });
        }
    });

    /*=================== Header Icons ===================*/
    $(".header-icon").on("click",function(){
        $(".creative-header").fadeToggle();
        $(this).toggleClass("active");       
        return false; 
    });
	
	/*=================== Video Play and Pause Button ===================*/
    
    $(".play-video").on("click", function () {
        $(this).parent().addClass("active");
        return false;
    });
    $(".pause-video").on("click", function () {
        $(this).parent().removeClass("active");
        return false;
    });
    	
		
});

