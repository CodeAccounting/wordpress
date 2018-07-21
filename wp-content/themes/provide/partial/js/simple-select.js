/*
 * jQuery SimpleSelect
 * http://pioul.fr/jquery-simpleselect
 *
 * Copyright 2014, Philippe Masset
 * Dual licensed under the MIT or GPL Version 2 licenses
 */
!function(a){"use strict";var b=null,c=null,d=[],e=!1,f=!1,g=function(b){b=a.extend({},{fadingDuration:b&&b.fadeSpeed||0,containerMargin:5,displayContainerInside:"window"},b),this.each(function(){var c=a(this).addClass("simpleselected"),d=a('<div class="simpleselect"></div>'),f=a('<div class="placeholder"></div>').appendTo(d),g=a('<div class="options"></div>').appendTo(d),h=c.attr("id");h&&d.attr("id","simpleselect_"+h),c.off("change"),c.attr("size",2);var i={select:c,selectOptions:null,simpleselect:d,ssPlaceholder:f,ssOptionsContainer:g,ssOptionsContainerHeight:null,ssOptions:null,canBeClosed:!0,isActive:!1,isScrollable:!1,isDisabled:!1,options:b};d.data("simpleselect",i).on({mousedown:function(){i.canBeClosed=!1},click:function(b){var c=a(b.target);c.hasClass("placeholder")?t.setActive.call(i):c.hasClass("option")&&(e=!0,o.call(i,c),t.setInactive.call(i))},mouseup:function(){i.canBeClosed=!0},mouseover:function(b){var c=a(b.target);c.hasClass("option")&&m.call(i,c)}}),c.data("simpleselect",i).on({keydown:function(a){13==a.keyCode&&t.setInactive.call(i)},focus:function(){e||t.setActive.call(i)},blur:function(){i.canBeClosed&&t.setInactive.call(i)},change:function(a,b){b||a.stopImmediatePropagation();var c=n.call(i);m.call(i,c,!0)},click:function(a){a.stopPropagation()}}),c.after(d);var j=a('<div class="hidden_select_container"></div>');c.after(j).appendTo(j),k.call(i),l.call(i),t.updatePresentationDependentVariables.call(i)})},h=function(){b=a(window).height()},i=function(a){d.push(a)},j=function(b){d=a.grep(d,function(a){return a!==b})},k=function(){this.selectOptions=this.select.find("option");var b="",c=function(a){b+='<div class="option">'+a.text()+"</div>"},d=function(d){b+='<div class="optgroup">';var f=d.attr("label");f&&(b+='<div class="optgroup-label">'+e(f)+"</div>"),d.children("option").each(function(){c(a(this))}),b+="</div>"},e=function(a){return a.replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#039;").replace(/</g,"&lt;").replace(/>/g,"&gt;")},f=this.select.children("optgroup, option"),g=!1;f.each(function(){var b=a(this);b.is("optgroup")?(d(b),g=!0):c(b)}),this.ssOptions=this.ssOptionsContainer.html(b).find(".option"),this.ssPlaceholder.text(n.call(this).text())},l=function(){this.isDisabled=this.select.prop("disabled"),this.simpleselect[this.isDisabled?"addClass":"removeClass"]("disabled")},m=function(a,b){if(this.ssOptions.removeClass("active"),a.addClass("active"),b&&this.isScrollable){var g,c=a.position(),d=this.ssOptionsContainer.scrollTop(),e=c.top,f=this.ssOptionsContainer.height()-(c.top+a.outerHeight());0>e?g=d+e:0>f&&(g=d-f),this.ssOptionsContainer.scrollTop(g)}},n=function(){var b=p.call(this),c=b.length?this.selectOptions.index(b):0;return a(this.ssOptions[c])},o=function(b){var c=a(this.selectOptions[this.ssOptions.index(b)]);this.select.val(c.val())},p=function(){return this.selectOptions.filter(":selected").first()},q=function(){this.ssOptionsContainer.css({height:"auto","overflow-y":"visible"})},r=function(){this.ssOptionsContainer.hide(),this.ssOptionsContainer[0].offsetHeight,this.ssOptionsContainer.show()},s=function(d){q.call(this);var e,f,g,h,i,j,k,l="window"==this.options.displayContainerInside,m=a.proxy(function(){e=d.position(),f=this.ssPlaceholderOffset.top-this.options.containerMargin-(l?a(window).scrollTop():0),g=(l?b:c)-f-this.ssPlaceholderHeight-2*this.options.containerMargin,h=f-e.top,i=g-(this.ssOptionsContainerOuterHeight-e.top-this.ssPlaceholderHeight),j=0>h?Math.abs(h):0,k=0>i?Math.abs(i):0},this);m();var n=this.isScrollable;if(this.isScrollable=0>h||0>i,this.isScrollable){this.ssOptionsContainer.css({height:"auto","overflow-y":"scroll"}),this.ssOptionsContainer.height()!=this.ssOptionsContainerHeight&&(r.call(this),t.updatePresentationDependentVariables.call(this,"ssOptionsContainer",!1),m());var o=this.ssOptionsContainer.height()-j-k;this.ssOptionsContainer.css({top:-(e.top-j)}).height(o).scrollTop(j)}else this.ssOptionsContainer.css({top:-e.top}),n&&r.call(this)},t={updatePresentationDependentVariables:function(a,b){a&&"ssPlaceholder"!=a||(this.ssPlaceholderOffset=this.ssPlaceholder.offset(),this.ssPlaceholderHeight=this.ssPlaceholder.outerHeight()),a&&"ssOptionsContainer"!=a||(b!==!1&&q.call(this),this.ssOptionsContainerOuterHeight=this.ssOptionsContainer.outerHeight(!0),this.ssOptionsContainerHeight=this.ssOptionsContainer.height())},refreshContents:function(){k.call(this),t.updatePresentationDependentVariables.call(this)},refreshState:function(){l.call(this)},disable:function(){this.select.prop("disabled",!0),t.refreshState.call(this)},enable:function(){this.select.prop("disabled",!1),t.refreshState.call(this)},setActive:function(){if(!this.isActive&&!this.isDisabled&&this.ssOptions.length){this.lastValue=this.select.val(),this.simpleselect.addClass("active"),this.isActive=!0,i.call(this,this.simpleselect);var b=n.call(this);m.call(this,b),c=a(document).height(),this.ssOptionsContainer.fadeTo(0,0).fadeTo(this.options.fadingDuration,1),this.select.is(":focus")||this.select.focus(),s.call(this,b),f=!0}},setInactive:function(){if(this.isActive){this.simpleselect.removeClass("active"),this.isActive=!1,j.call(this,this.simpleselect),this.ssOptionsContainer.fadeOut(this.options.fadingDuration),this.select.is(":focus")&&this.select.blur();var a=this.select.val();this.lastValue!=a&&(this.ssPlaceholder.text(p.call(this).text()),this.select.trigger("change",[!0]))}}};a.fn.simpleselect=function(b){if(t[b]){var c=Array.prototype.slice.call(arguments,1);this.each(function(){t[b].apply(a(this).data("simpleselect"),c)})}else g.apply(this,arguments);return this},a(document).ready(function(){h(),a(window).on("resize.simpleselect",function(){h()}),a(document).on("click.simpleselect keyup.simpleselect",function(a){if("click"==a.type&&(setTimeout(function(){e=!1},0),f))return f=!1,void 0;if("click"==a.type||"keyup"==a.type&&27==a.keyCode){var b=d.length;if(b)for(var c=d.slice(0),g=0;b>g;g++)c[g].simpleselect("setInactive")}})})}(jQuery);


jQuery("select").simpleselect();