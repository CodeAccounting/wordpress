"use strict";
jQuery(document).ready(function( $ ) {  
    var currentlyClickedElement = '';
  	
    $('.color-pick-color').bind("click", function(){ 
        currentlyClickedElement = this;
    });
  	
    $('.color-pick-color').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).css("background","#"+hex);
            $(el).attr("data-value", "#"+hex);
            $(el).parent().children(".color-pick").val("#"+hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor($(this).attr("data-value"));
        },
        onChange: function (hsb, hex, rgb) {
            $(currentlyClickedElement).css("background","#"+hex);
            $(currentlyClickedElement).attr("data-value", "#"+hex);
            $(currentlyClickedElement).parent().children(".color-pick").val("#"+hex);
        }
    })
    .bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
    });
	 
 
    $('.color-pick').bind('keyup', function(){
        $(this).parent().children(".color-pick-color").css("background", $(this).val());
    });
    
    // 17 - var default = new Array("" , "", "", "", "", "");
    var default_val = new Array("#727272" , "#26507a", "#3178bf", "#000000", "#000000",  "#c1c1c1", "#f9f9f9", "#0f0f0f", "#242424", "#c4c4c4", "#ffffff", "#fff", "#000000", "", "", "","#3178bf", "#26507a", "#fff", "#3178bf" , "#ffffff", "#26507a", "#fff", "#3178bf", "#fff", "#000", "#fff", "#fff", "#fff", "#26507a", "#26507A", "#fff", "#26507a", "#26507a", "#3178bf", "#26507a", "#fff", "#3178bf", "#fff", "#c3c3c3", "#fff", "#737373", "#fff");
    var yellow = new Array("#727272" , "#292929", "#f9e60d", "#000000", "#000000",  "#c1c1c1", "#f9f9f9", "#242424", "#0f0f0f", "#d9d9d9", "#ffffff", "#fff", "#000000", "", "", "", "#f9e60d","#030303", "#ffffff", "#f9e60d", "#ffffff", "#292929", "#fff", "#f9e60d", "#fff", "#f9e60d", "#fff", "#000000", "#fff", "#ffffff", "#ffffff", "#242424", "#ffffff", "#f9e60d", "#242424", "#f9e60d", "#fff", "#242424", "#fff", "#c3c3c3", "#fff", "#737373", "#fff", "#bfbfbf");
    var orange = new Array("#727272" , "#292929", "#d54900", "#000000", "#000000",  "#c1c1c1", "#f9f9f9", "#242424", "#0f0f0f", "#d9d9d9", "#ffffff", "#fff", "#000000", "", "", "", "#d54900", "#030303", "#ffffff", "#d54900", "#ffffff", "#292929", "#fff", "#d54900", "#fff", "#d54900", "#fff", "#000000", "#fff", "#ffffff", "#ffffff", "#242424", "#ffffff", "#d54900", "#242424", "#d54900", "#fff", "#242424", "#fff", "#c3c3c3", "#fff", "#737373", "#fff");
    var green   = new Array("#727272" , "#292929", "#43b425", "#000000", "#000000",  "#c1c1c1", "#f9f9f9", "#242424", "#0f0f0f", "#d9d9d9", "#ffffff", "#fff", "#000000", "", "", "", "#43b425","#030303", "#ffffff", "#43b425", "#ffffff", "#292929", "#fff", "#43b425", "#fff", "#43b425", "#fff", "#000000", "#fff", "#ffffff", "#ffffff", "#242424", "#ffffff", "#43b425", "#242424", "#43b425", "#fff", "#242424", "#fff", "#c3c3c3", "#fff", "#737373", "#fff", "#bfbfbf");  

    $("#predefined_colors label").bind("click", function(){ 
        var table; 	
        switch($('input', this).val()) {
            case "default" :
                table = default_val;
                break;
            case "yellow" :
                table = yellow;
                break;
            case "orange" :
                table = orange;
                break;
            case "green" :
                table = green;
                break;
        }
    	console.log($(this).val());
        $(".color-pick").each(function(index){
            $(".color-pick").eq(index).val(table[index]);
            $(".color-pick").eq(index).parent().children(".color-pick-color").css("background", table[index]);
            $(".color-pick").eq(index).parent().children(".color-pick-color").attr("data-value", table[index]);
        });
    });
    $(".input-type").change(function(){
        if($(this).val() == "dropdown") {
            $(this).parent().parent().children(".validation").hide();
            $(this).parent().parent().children(".label-place-val").children("label").html("Values");
        }
        else {
            $(this).parent().parent().children(".validation").show();
            $(this).parent().parent().children(".label-place-val").children("label").html("Placeholder");
        }
    });
});