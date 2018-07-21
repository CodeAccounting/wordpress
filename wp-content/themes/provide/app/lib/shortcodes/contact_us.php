<?php

class provide_contact_us_VC_ShortCode extends provide_VC_ShortCode {
	static $counter = 0;

	public static function provide_contact_us( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"     => esc_html__( "Contact Us", 'provide' ),
				"base"     => "provide_contact_us_output",
				"icon"     => 'provide_contact_us_output.png',
				"category" => esc_html__( 'Provide', 'provide' ),
				"params"   => array(
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Title", 'provide' ),
						"param_name"  => "title",
						"description" => esc_html__( "Enter the title for this section.", 'provide' )
					),
					array(
						"type"        => "textarea",
						"heading"     => esc_html__( "Description", 'provide' ),
						"param_name"  => "desc",
						"description" => esc_html__( "Enter the description for this section.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Button Text", 'provide' ),
						"param_name"  => "btn_text",
						"value"       => esc_attr__( 'Send Message', 'provide' ),
						"description" => esc_html__( "Enter the contact form button text.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Email", 'provide' ),
						"param_name"  => "receiving_email",
						"description" => esc_html__( "Get Request on this email that you enter.", 'provide' )
					),
				)
			);

			return apply_filters( 'provide_contact_us_output', $return );
		}
	}

	public static function provide_contact_us_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		ob_start();

		$h = new provide_Helper;
		$opt = $h->provide_opt();
		
		$optcontact_one_icon = $h->provide_set( $opt, 'optcontact_one_icon' );
		$optcontact_one_text = $h->provide_set( $opt, 'optcontact_one_text' );
		$optcontact_one_content = $h->provide_set( $opt, 'optcontact_one_content' );
		$optcontact_two_icon = $h->provide_set( $opt, 'optcontact_two_icon' );
		$optcontact_two_text = $h->provide_set( $opt, 'optcontact_two_text' );
		$optcontact_two_content = $h->provide_set( $opt, 'optcontact_two_content' );
		$optcontact_three_icon = $h->provide_set( $opt, 'optcontact_three_icon' );
		$optcontact_three_text = $h->provide_set( $opt, 'optcontact_three_text' );
		$optcontact_three_content = $h->provide_set( $opt, 'optcontact_three_content' );
		$optcontact_four_icon = $h->provide_set( $opt, 'optcontact_four_icon' );
		$optcontact_four_text = $h->provide_set( $opt, 'optcontact_four_text' );
		$optcontact_four_content = $h->provide_set( $opt, 'optcontact_four_content' );
             
	?>

	<div class="row">
            <div class="col-md-7 pro-col">
                <div class="contact-page-text">
                    <h2><?php echo esc_html( $title ) ?></h2>
					<?php echo wp_kses( $desc, true ) ?>
                </div><!-- Contact Page Text -->
            </div>
    	<div class="col-md-5 pro-col">
            <div class="header-contact style2">
                <div class="row">
					<div class="col-md-6">
                            <div class="info">
								<i class="<?php echo $optcontact_one_icon; ?>"></i>
                                <strong><?php echo esc_html( $optcontact_one_text ) ?> 
									<?php $i = 0;
									if($optcontact_one_content != ''){
									foreach ($optcontact_one_content as $content) { ?>
										<span><?php echo $optcontact_one_content[$i]; ?></span>
										<?php $i++;
									} } ?>
								</strong>
                            </div><!-- Info --></div>
					<div class="col-md-6">
                            <div class="info">
								<i class="<?php echo $optcontact_two_icon; ?>"></i>
                                <strong><?php echo esc_html( $optcontact_two_text ) ?> 
									<?php $i = 0;
									if($optcontact_two_content != ''){
									foreach ($optcontact_two_content as $content) { ?>
										<span><a href="mailto:<?php echo $optcontact_two_content[$i]; ?>"><?php echo $optcontact_two_content[$i]; ?></a></span>
										<?php $i++;
									} } ?>
								</strong>
                            </div><!-- Info --></div>
                </div>
                <div class="row">            
					<div class="col-md-6">
                            <div class="info">
								<i class="<?php echo $optcontact_three_icon; ?>"></i>
                                <strong><?php echo esc_html( $optcontact_three_text ) ?> 
									<?php $i = 0;
									if($optcontact_three_content != ''){
									foreach ($optcontact_three_content as $content) { ?>
										<span><a href="tel:<?php echo $optcontact_three_content[$i]; ?>"><?php echo $optcontact_three_content[$i]; ?></a></span>
										<?php $i++;
									} } ?>
								</strong>
                            </div><!-- Info --></div>
					<div class="col-md-6">
                            <div class="info">
								<i class="<?php echo $optcontact_four_icon; ?>"></i>
                                <strong><?php echo esc_html( $optcontact_four_text ) ?> 
									<?php $i = 0;
									if($optcontact_four_content != ''){
									foreach ($optcontact_four_content as $content) { ?>
										<span><?php echo $optcontact_four_content[$i]; ?></span>
										<?php $i++;
									} } ?>
								</strong>
                            </div><!-- Info --></div>
				</div>
            </div>
        </div>
	
            <div class="col-md-12 pro-col">
                <div class="contact-page-form">
                    <div class="log"></div>
                    <form id="c_form" class="simple-form">
                        <div class="row">
                            <input type="hidden" id="c_receiver" value="<?php echo esc_attr( $receiving_email ) ?>"/>
                            <div class="col-md-4">
                                <input type="text" id="c_name" placeholder="<?php esc_html_e( 'Name', 'provide' ) ?>"/>
                            </div>
                            <div class="col-md-4">
                                <input type="email" id="c_email" placeholder="<?php esc_html_e( 'Email', 'provide' ) ?>"/>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="c_subject" placeholder="<?php esc_html_e( 'Subject', 'provide' ) ?>"/>
                            </div>
                            <div class="col-md-12">
                                <textarea id="c_message" placeholder="<?php esc_html_e( 'Message', 'provide' ) ?>"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button id="c_submit" class="yellow-btn"><?php echo esc_html( $btn_text ) ?></button>
                            </div>
                        </div>
                    </form>
                </div><!-- Contact Page Form -->
            </div>
        </div>
		<?php
		$output = ob_get_contents();
		ob_clean();

		return do_shortcode( $output );
	}

}
