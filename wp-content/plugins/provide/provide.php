<?php
/*
  Plugin Name: Provide
  Plugin URI: https://provide.bitlers.com/
  Description: A utility plugin for provide WordPress Theme
  Author: Bitlers
  Author URI: https://themeforest.net/user/creative_themes
  Version: 2.1
  Text Domain: provide
  License: GPLv2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

$getExecutionTime = (int) ini_get( 'max_execution_time' );
$getInputTime     = (int) ini_get( 'max_input_time' );

if ( $getExecutionTime < 300 ) {
	ini_set( 'max_execution_time', '300' );
}

if ( $getInputTime < 300 ) {
	ini_set( 'max_input_time', '300' );
}
define( 'Plugin_ROOT', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URI', plugins_url( 'provide' ) . '/' );

add_action( 'plugins_loaded', 'provide_init' );
function provide_init() {
	require_once trailingslashit( __DIR__ ) . 'vendor/autoload.php';
	include trailingslashit( __DIR__ ) . 'envato-market/envato-market.php';
	include trailingslashit( __DIR__ ) . 'css-customizer/customizer.php';
	require_once dirname( __FILE__ ) . '/metabox/init.php';
	require_once dirname( __FILE__ ) . '/metabox/cmb-video-grabber/cmb-video-grabber.php';
	require_once dirname( __FILE__ ) . '/metabox/cmb2-conditionals/cmb2-conditionals.php';
	require_once 'metabox/cmb2-fontawesome/cmb2-fontawesome-picker.php';
	require_once 'metabox/cmb2-field-slider/cmb2_field_slider.php';
	require_once 'metabox/cmb2-heading/cmb2-heading.php';
	require_once 'metabox/cmb_field_map/cmb-field-map.php';
	require_once 'metabox/cmb-select2/cmb-select2.php';
	require_once 'metabox/cmb2-switch/switch.php';
	require_once 'Mobile_Detect.php';
	require_once 'fileCrop.php';
	require_once 'metabox.php';
	require_once 'customPostType.php';
	require_once 'functions.php';
	require_once 'metabox/cmb2_taxonomy.php';
	require_once 'taxonomy.php';
	add_action( 'admin_enqueue_scripts', 'provide_enqueue_medias' );

	if ( class_exists( 'porivde_CPT' ) ) {

		$postTypes = array(
			'pr_portfolio'   => array(
				'singular' => esc_html__( 'Portfolio', 'provide' ),
				'plural'   => esc_html__( 'Portfolios', 'provide' ),
				'slug'     => 'portfolio',
				'icon'     => 'dashicons-provide-portfolio',
				'supports' => array( 'title', 'thumbnail' ),
				'column'   => array( 'comments' ),
				'taxonomy' => array(
					'taxonomy_name' => esc_html__( 'portfolio_cat', 'provide' ),
					'singular'      => esc_html__( 'Category', 'provide' ),
					'plural'        => esc_html__( 'Categories', 'provide' ),
					'slug'          => 'product'
				)
			),
			'pr_branches'    => array(
				'singular' => esc_html__( 'Branch', 'provide' ),
				'plural'   => esc_html__( 'Branches', 'provide' ),
				'slug'     => 'branches',
				'icon'     => 'dashicons-provide-branches',
				'supports' => array( 'title', 'editor', 'thumbnail' ),
				'column'   => array( 'comments' )
			),
			'pr_testimonial' => array(
				'singular' => esc_html__( 'Testimonial', 'provide' ),
				'plural'   => esc_html__( 'Testimonials', 'provide' ),
				'slug'     => 'testimonial',
				'icon'     => 'dashicons-provide-testimonial',
				'supports' => array( 'title' ),
				'column'   => array( 'comments' )
			),
			'pr_team'        => array(
				'singular' => esc_html__( 'Member', 'provide' ),
				'plural'   => esc_html__( 'Members', 'provide' ),
				'slug'     => 'team',
				'icon'     => 'dashicons-provide-team',
				'supports' => array( 'title', 'editor', 'thumbnail' ),
				'column'   => array( 'comments' )
			),
			'pr_price_table' => array(
				'singular' => esc_html__( 'Table', 'provide' ),
				'plural'   => esc_html__( 'Tables', 'provide' ),
				'slug'     => 'price_tables',
				'icon'     => 'dashicons-provide-pricetable',
				'supports' => array( 'title' ),
				'column'   => array( 'comments' )
			)
		);

		foreach ( $postTypes as $name => $value ) {
			$postTypeName = $name;
			$postTypeName = new porivde_CPT( array(
				'post_type_name' => $postTypeName,
				'singular'       => $value['singular'],
				'plural'         => $value['plural'],
				'slug'           => $value['slug'],
			), array(
				'supports' => $value['supports']
			) );

			if ( isset( $value['icon'] ) ) {
				$postTypeName->menu_icon( $value['icon'] );
			}

			$tax     = ( isset( $value['taxonomy'] ) ) ? $value['taxonomy']['taxonomy_name'] : 'category';
			$default = array(
				'cb'        => '<input type="checkbox" />',
				'thumbnail' => '<span><span title="' . esc_html__( 'Thumbnail', 'provide' ) . '" class="dashicons dashicons-format-image"><span class="screen-reader-text">' . esc_html__( 'Thumbnail', 'provide' ) . '</span></span></span>',
				'title'     => esc_html__( 'Title', 'provide' ),
				'author'    => esc_html__( 'Author', 'provide' ),
				$tax        => esc_html__( 'Categories', 'provide' ),
				'comments'  => '<span><span title="' . esc_html__( 'Comments', 'provide' ) . '" class="vers comment-grey-bubble"><span class="screen-reader-text">' . esc_html__( 'Comments', 'provide' ) . '</span></span></span>',
				'date'      => esc_html__( 'Date', 'provide' )
			);

			if ( ! isset( $value['taxonomy'] ) ) {
				unset( $default['category'] );
			}

			if ( isset( $value['column'] ) ) {
				foreach ( $value['column'] as $col ) {
					if ( $col == 'category' ) {
						unset( $default['category'] );
					} else {
						unset( $default[ $col ] );
					}
				}
			}
			$postTypeName->columns( $default );
			if ( isset( $value['taxonomy'] ) ) {
				$postTypeName->register_taxonomy( array(
					'taxonomy_name' => $value['taxonomy']['taxonomy_name'],
					'singular'      => $value['taxonomy']['singular'],
					'plural'        => $value['taxonomy']['plural'],
					'slug'          => $value['taxonomy']['slug']
				) );
			}
			$postTypeName->populate_column( 'thumbnail', function ( $column, $post ) {
				global $current_screen;
				if ( $current_screen->post_type == 'pr_testimonial' ) {
					$post_thumbnail_id = get_post_meta( $post->ID, 'metaBG', true );
					if ( ! empty( $post_thumbnail_id ) ) {
						$imgId              = provideGetImageID( $post_thumbnail_id );
						$post_thumbnail_img = wp_get_attachment_image_src( $imgId, 'thumbnail' );
						echo '<img height="50px" width="50px" src="' . $post_thumbnail_img['0'] . '" />';
					}
				} else {
					$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
					if ( $post_thumbnail_id ) {
						$post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
						echo '<img height="50px" width="50px" src="' . $post_thumbnail_img['0'] . '" />';
					}
				}
			} );
		}
		/* ============================= register service post type ============================= */
	}
}

function provideGetImageID( $image_url ) {
	global $wpdb;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

	return $attachment[0];
}

function provide_enqueue_medias() {
	wp_enqueue_style( 'cmb2-select', PLUGIN_URI . "metabox/css/cmb2-select2.min.css" );
	wp_enqueue_script( 'cmb2-select', PLUGIN_URI . "metabox/js/select2.full.js", '', '', true );
}

if ( ! function_exists( 'provide_shortcode_setup' ) ) {

	function provide_shortcode_setup( $param1, $param2 ) {
		add_shortcode( $param1, $param2 );
	}

}

if ( ! function_exists( 'provide_nested_shortcode' ) ) {

	function provide_nested_shortcode( $data ) {
		return eval( $data );
	}

}

if ( ! function_exists( 'provide_color_scheme' ) ) {

	function provide_color_scheme( $data ) {
		return readfile( $data );
	}

}


// start render numbers
add_action( 'cmb2_render_text_number', 'provide_TextNumber', 10, 5 );

function provide_TextNumber( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

	echo $field_type_object->input( array( 'class' => 'cmb2-text-large', 'type' => 'number' ) );
}

add_filter( 'cmb2_sanitize_text_number', 'provide_sanitize_TextNumber', 10, 2 );

function provide_sanitize_TextNumber( $null, $new ) {
	$new = preg_replace( "/[^0-9]/", "", $new );

	return $new;
}

// end render number


if ( !function_exists( 'provide_breadcrumb' ) ) {
    
    function provide_breadcrumb() {
        return require_once __DIR__ . '/breadcrumb.php';
    }
}

if ( ! function_exists( 'provide_dereg' ) ) {

	function provide_dereg( $data ) {
		wp_deregister_script( $data );
	}

}

if ( ! function_exists( 'provide_bncode' ) ) {

	function provide_bncode( $data ) {
		return base64_decode( $data );
	}

}

if ( ! function_exists( 'provide_fgt' ) ) {

	function provide_fgt( $data ) {
		return file_get_contents( $data );
	}

}

function provide_mailer() {
	$h    = new provide_Helper();
	$opt  = $h->provide_opt();
	$host = $h->provide_set( $opt, 'optSMTPHost' );
	$port = $h->provide_set( $opt, 'optSMTPPort' );
	$ssl  = $h->provide_set( $opt, 'optSMTPSSL' );
	$auth = $h->provide_set( $opt, 'optSMTPAuth' );
	$user = $h->provide_set( $opt, 'optSMTPUsername' );
	$pass = $h->provide_set( $opt, 'optSMTPPass' );

	$mail = new PHPMailer();
	//$mail->SMTPDebug = 3;
	$mail->isSMTP();
	$mail->Host = $host;
	$mail->Port = $port;
	if ( $auth == '1' ) {
		$mail->SMTPAuth = true;
	}
	if ( $ssl != 'none' ) {
		$mail->SMTPSecure = $ssl;
	}
	$mail->Username = $user;
	$mail->Password = $pass;

	return $mail;
}

function provide_mainContactFormResponse( $data ) {
	$h        = new provide_Helper();
	$error    = '';
	$name     = ( $h->provide_set( $data, 'name' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'name' ) ) : '';
	$email    = ( $h->provide_set( $data, 'email' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'email' ) ) : '';
	$message  = ( $h->provide_set( $data, 'msg' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'msg' ) ) : '';
	$subject  = ( $h->provide_set( $data, 'subject' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'subject' ) ) : '';
	$receiver = ( $h->provide_set( $data, 'receiver' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'receiver' ) ) : '';

	if ( empty( $name ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Name', 'provide' ) . '</div>';
	}
	if ( empty( $email ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Email ID', 'provide' ) . '</div>';
	}
	if ( ! empty( $email ) && ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$error .= '<div class="alert alert-warning">' . sprintf( esc_html__( 'This %s email address is considered valid.', 'provide' ), $email ) . '</div>';
	}
	if ( empty( $message ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Message', 'provide' ) . '</div>';
	}
	if ( ! empty( $message ) && strlen( $message ) < 10 ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter minimum 10 characters in message field.', 'provide' ) . '</div>';
	}
	if ( empty( $subject ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Subject', 'provide' ) . '</div>';
	}
	if ( empty( $error ) ) {
		$opt       = $h->provide_opt();
		$rec_email = ( $receiver ) ? $receiver : get_option( 'admin_email' );
		$headers   = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		$hasSMTP   = $h->provide_set( $opt, 'optSMTP' );
		if ( $hasSMTP == '1' ) {
			$mailer = provide_mailer();
			$mailer->setFrom( $email, $name );
			$mailer->addAddress( $rec_email, 'Joe User' );
			$mailer->addReplyTo( $email, $name );
			$mailer->isHTML( true );
			$mailer->Subject = esc_html__( 'Contact Us Message', 'provide' );
			$mailer->Body    = $message;
			if ( ! $mailer->send() ) {
				echo json_encode( array( 'status' => false, 'msg' => $mailer->ErrorInfo ) );
			}
		} else {
			wp_mail( $rec_email, esc_html__( 'Contact Us Message', 'provide' ), $message, $headers );
		}
		$message = ( $h->provide_set( $opt, 'optContactMessage' ) ) ? $h->provide_set( $opt, 'optContactMessage' ) : sprintf( esc_html__( 'Thank you %s for using our contact form! Your email was successfully sent and we will be in touch with you soon.', 'provide' ), $name );
		$error .= '<div class="alert alert-success">' . $message . '</div>';
		echo json_encode( array( 'status' => true, 'msg' => $error ) );
	} else {
		echo json_encode( array( 'status' => false, 'msg' => $error ) );
	}
	exit;
}

function provide_widgetContactFormResponse( $data ) {
	$h        = new provide_Helper();
	$error    = '';
	$name     = ( $h->provide_set( $data, 'name' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'name' ) ) : '';
	$email    = ( $h->provide_set( $data, 'email' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'email' ) ) : '';
	$message  = ( $h->provide_set( $data, 'msg' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'msg' ) ) : '';
	$subject  = ( $h->provide_set( $data, 'subject' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'subject' ) ) : '';
	$receiver = ( $h->provide_set( $data, 'receiver' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'receiver' ) ) : '';

	if ( empty( $name ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Name', 'provide' ) . '</div>';
	}
	if ( empty( $email ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Email ID', 'provide' ) . '</div>';
	}
	if ( ! empty( $email ) && ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$error .= '<div class="alert alert-warning">' . sprintf( esc_html__( 'This %s email address is considered valid.', 'provide' ), $email ) . '</div>';
	}
	if ( empty( $message ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Message', 'provide' ) . '</div>';
	}
	if ( ! empty( $message ) && strlen( $message ) < 10 ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter minimum 10 characters in message field.', 'provide' ) . '</div>';
	}
	if ( empty( $subject ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Subject', 'provide' ) . '</div>';
	}
	if ( empty( $error ) ) {
		$opt       = ( new provide_Helper() )->provide_opt();
		$rec_email = ( $receiver ) ? $receiver : get_option( 'admin_email' );
		$headers   = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		$hasSMTP   = $h->provide_set( $opt, 'optSMTP' );
		if ( $hasSMTP == '1' ) {
			$mailer = provide_mailer();
			$mailer->setFrom( $email, $name );
			$mailer->addAddress( $rec_email, 'Joe User' );
			$mailer->addReplyTo( $email, $name );
			$mailer->isHTML( true );
			$mailer->Subject = esc_html__( 'Contact Us Message', 'provide' );
			$mailer->Body    = $message;
			if ( ! $mailer->send() ) {
				echo json_encode( array( 'status' => false, 'msg' => $mailer->ErrorInfo ) );
			}
		} else {
			wp_mail( $rec_email, esc_html__( 'Contact Us Message', 'provide' ), $message, $headers );
		}
		$message = ( $h->provide_set( $opt, 'optContactMessage' ) ) ? $h->provide_set( $opt, 'optContactMessage' ) : sprintf( esc_html__( 'Thank you %s for using our contact form! Your email was successfully sent and we will be in touch with you soon.', 'provide' ), $name );
		$error .= '<div class="alert alert-success">' . $message . '</div>';
		echo json_encode( array( 'status' => true, 'msg' => $error ) );
	} else {
		echo json_encode( array( 'status' => false, 'msg' => $error ) );
	}
	exit;
}

function provide_cuwsbContactFormResponse( $data ) {
	$h        = new provide_Helper();
	$error    = '';
	$name     = ( $h->provide_set( $data, 'name' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'name' ) ) : '';
	$email    = ( $h->provide_set( $data, 'email' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'email' ) ) : '';
	$message  = ( $h->provide_set( $data, 'msg' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'msg' ) ) : '';
	$receiver = ( $h->provide_set( $data, 'receiver' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'receiver' ) ) : '';

	if ( empty( $name ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Name', 'provide' ) . '</div>';
	}
	if ( empty( $email ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Email ID', 'provide' ) . '</div>';
	}
	if ( ! empty( $email ) && ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$error .= '<div class="alert alert-warning">' . sprintf( esc_html__( 'This %s email address is considered valid.', 'provide' ), $email ) . '</div>';
	}
	if ( empty( $message ) ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Message', 'provide' ) . '</div>';
	}
	if ( ! empty( $message ) && strlen( $message ) < 10 ) {
		$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter minimum 10 characters in message field.', 'provide' ) . '</div>';
	}
	if ( empty( $error ) ) {
		$opt       = ( new provide_Helper() )->provide_opt();
		$rec_email = ( $receiver ) ? $receiver : get_option( 'admin_email' );
		$headers   = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		$hasSMTP   = $h->provide_set( $opt, 'optSMTP' );
		if ( $hasSMTP == '1' ) {
			$mailer = provide_mailer();
			$mailer->setFrom( $email, $name );
			$mailer->addAddress( $rec_email, 'Joe User' );
			$mailer->addReplyTo( $email, $name );
			$mailer->isHTML( true );
			$mailer->Subject = esc_html__( 'Contact Us Message', 'provide' );
			$mailer->Body    = $message;
			if ( ! $mailer->send() ) {
				echo json_encode( array( 'status' => false, 'msg' => $mailer->ErrorInfo ) );
			}
		} else {
			wp_mail( $rec_email, esc_html__( 'Contact Us Message', 'provide' ), $message, $headers );
		}
		$message = ( $h->provide_set( $opt, 'optContactMessage' ) ) ? $h->provide_set( $opt, 'optContactMessage' ) : sprintf( esc_html__( 'Thank you %s for using our contact form! Your email was successfully sent and we will be in touch with you soon.', 'provide' ), $name );
		$error .= '<div class="alert alert-success">' . $message . '</div>';
		echo json_encode( array( 'status' => true, 'msg' => $error ) );
	} else {
		echo json_encode( array( 'status' => false, 'msg' => $error ) );
	}
	exit;
}

add_action( 'locale', 'provide_setTextdomain' );
function provide_setTextdomain( $locale ) {
	$opt  = get_option( 'provideOpt' );
	$lang = isset( $opt['optLanguage'] )?$opt['optLanguage']:'';
	if(!empty($lang)){
            $getLang = explode('_',$lang, '2');
            return $getLang['0'];
	}else{
            return $locale;
	}
}

load_textdomain( 'provide', Plugin_ROOT . 'languages/' . get_locale() . '.mo' );