"use strict";
jQuery(document).ready(function($) {
    /* Menu type */
    $('.onoff').hide();
    $('#headerstyle > label > input').change(function() {
        if($(this).is(':checked')) {    
            var get_id_to_show = '.' + $(this).closest("label").attr("id");
            //alert (get_id_to_show);
            $('.onoff').hide(100);
            //alert (get_id_to_show);
            $(get_id_to_show).show(200);
            }
    }).change();


    $('#auto_adjust_logo').change(function() {
        if($(this).is(':checked')) {    
            $('.onoff').hide(100);
            }
            else {
                $('.onoff').show(100);
            }
    }).change();



    $(".style-images").each(function( index ) {
        if( $("input[type=radio]").eq(index).is(':checked')) {
            $(".style-images").eq( index ).css({
                "border":"2px solid #2187c0",
                "cursor":"default"
            });
        }
    });
        
    $(".style-images").click(function(){
            
        $("input[type=radio]").eq( $(this).index(".style-images") ).click();
            
        $(".style-images").each(function( index ) {
            $(".style-images").eq( index ).css({
                "border":"2px solid #efefef",
                "cursor":"pointer"
            });
        });
            
        $(this).css({
            "border":"2px solid #2187c0",
            "cursor":"default"
        });
    });

    $("input.dummy").click(function() {
        
        $(".absolute.fullscreen.importspin").addClass('visible');
        /*alert ('visible');*/
    })

$(window).on('scroll', function(){
   var ScrollTop = $(window).scrollTop();
   $('.submit-right button.fixsave').css('transform', 'translateY(' + ( ScrollTop + 100 )+ 'px)');
})

});