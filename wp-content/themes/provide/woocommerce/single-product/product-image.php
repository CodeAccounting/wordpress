<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
$h = new provide_Helper();
$attachments = $product->get_gallery_image_ids();
$imagify = new provide_Imagify();
$big_image = array('m' => '570x585', 'i' => '570x585', 'w' => '570x585');
$small_image = array('m' => '100x110', 'i' => '100x110', 'w' => '100x110');

?>


<div class="single-product-slide">
        <?php if(count($attachments) > 1 && !empty($attachments) ) :  ?>
            <div class="single-product-slide">
                <ul class="single-item-gallery">
                    <?php
                        foreach($attachments as $att) :
                            $url = $h->provide_set(wp_get_attachment_image_src($att, 'full'), '0');
                    ?>
                    <li>
                        <img src="<?php echo $imagify->provide_thumb($big_image, false, array(true, true, true), $url, 'c', true); ?>" alt="" /></li>
                    <?php endforeach; ?>
                </ul>
                <ul class="single-product-thumb wow fadeIn">
                    <?php
                        foreach($attachments as $att) :
                            $url = $h->provide_set(wp_get_attachment_image_src($att, 'full'), '0');
                    ?>
                    <li>
                        <img src="<?php echo $imagify->provide_thumb($small_image, false, array(true, true, true), $url, 'c', true); ?>" alt="" /></li>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else:
            echo $imagify->provide_thumb($big_image, true, array(true, true, true));
        ?>
        
        <?php endif; ?>
</div>


<?php

(new provide_Media())->provide_eq(array('slick'));
$script = '
    jQuery(".single-item-gallery").slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  slide: "li",
	  fade: false,
	  asNavFor: ".single-product-thumb"
	});
	jQuery(".single-product-thumb").slick({
	  slidesToShow: 5,
	  slidesToScroll: 1,
	  asNavFor: ".single-item-gallery",
	  dots: false,
	  arrows: false,
	  slide: "li",
	  vertical: false,
	  centerMode: true,
	  centerPadding: "0px",
	  focusOnSelect: true,
	  responsive: [
	    {
	      breakpoint: 1000,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 1,
	        infinite: true,
	        vertical: false,
	        centerMode: true,
	        centerPadding:"115px",
	        dots: false
	      }
	    },
	    {
	      breakpoint: 980,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 1,
	        infinite: true,
	        vertical: false,
	        centerMode: true,
	        centerPadding: "115px",
	        dots: false
	      }
	    },
	    {
	      breakpoint: 767,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 1,
	        infinite: true,
	        vertical: false,
	        centerMode: true,
	        centerPadding: "70px",
	        dots: false
	      }
	    },
	    {
	      breakpoint: 480,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 1,
	        infinite: true,
	        vertical: false,
	        centerMode: true,
	        centerPadding:"60px",
	        dots: false
	      }
	    }
	  ]
	});
';

wp_add_inline_script('slick', $script);

?>
