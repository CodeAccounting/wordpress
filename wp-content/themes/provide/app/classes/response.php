<?php

class provide_response {

	private static $instance;

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;

		return false;
	}

	public function provide_funFactNewsletter( $data ) {
		$before = '<div class="alert alert-warning">';
		$after  = '</div>';
		$h      = new provide_Helper();
		$opt    = $h->provide_opt();
		$email  = trim( $h->provide_set( $data, 'email' ) );
		if ( get_magic_quotes_gpc() ) {
			$email = stripslashes( $email );
		}
		$errors = '';
		$notify = '';
		if ( $email == '' ) {
			$errors .= $before . esc_html__( 'Please Enter Valid Email Address', 'provide' ) . $after;
		}
		if ( $email != '' && ! preg_match( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email ) ) {
			$errors .= $before . esc_html__( 'Please Enter Valid Email Address', 'provide' ) . $after;
		}
		if ( empty( $errors ) ) {
			$list_id = $h->provide_set( $opt, 'optMailchimpListId' );
			$dc      = "us1";
			if ( strstr( $h->provide_set( $opt, 'optMailchimpApiKey' ), "-" ) ) {
				list( $key, $dc ) = explode( "-", $h->provide_set( $opt, 'optMailchimpApiKey' ), 2 );
				if ( ! $dc ) {
					$dc = "us1";
				}
			}
			$apikey    = $h->provide_set( $opt, 'optMailchimpApiKey' );
			$get_name  = explode( '@', $email );
			$auth      = provide_encrypt( 'user:' . $apikey );
			$data      = array(
				'apikey'        => $apikey,
				'email_address' => $email,
				'status'        => 'subscribed',
				'merge_fields'  => array(
					'FNAME' => $h->provide_set( $get_name, '0' )
				)
			);
			$json_data = json_encode( $data );
			$request   = array(
				'headers'     => array(
					'Authorization'  => 'Basic ' . $auth,
					'Accept'         => 'application/json',
					'Content-Type'   => 'application/json',
					'Content-Length' => strlen( $json_data ),
				),
				'httpversion' => '1.0',
				'timeout'     => 10,
				'method'      => 'POST',
				'user-agent'  => 'PHP-MCAPI/2.0',
				'sslverify'   => false,
				'body'        => $json_data,
			);
			$req       = wp_remote_post( 'https://' . $dc . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/', $request );
			$r         = json_decode( $h->provide_set( $req, 'body' ) );
			if ( preg_match( "/The requested resource could not be found./", $h->provide_set( $r, 'detail' ) ) ) {
				$notify .= '<div class="alert alert-warning"><strong>' . esc_html__( 'Invalid List ID', 'provide' ) . '</div>';
			} elseif ( $h->provide_set( $r, 'title' ) == "Member Exists" ) {
				$notify .= "<div class='alert alert-warning'><strong>{$email} " . esc_html__( 'is Already Exists', 'provide' ) . ".</div>";
			} else {
				$notify .= '<div class="alert alert-success"><strong>' . esc_html__( 'Thank you for subscribing with us', 'provide' ) . '.</div>';
			}
			wp_send_json( array( 'status' => true, 'msg' => $notify ) );
		} else {
			wp_send_json( array( 'status' => false, 'msg' => $errors ) );
		}
	}

	public function provide_requestAQuote( $data ) {
		$h        = new provide_Helper();
		$error    = '';
		$name     = ( $h->provide_set( $data, 'name' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'name' ) ) : '';
		$email    = ( $h->provide_set( $data, 'email' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'email' ) ) : '';
		$number   = ( $h->provide_set( $data, 'number' ) != 'undefined' ) ? esc_attr( $h->provide_set( $data, 'number' ) ) : '';
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
		if ( empty( $number ) ) {
			$error .= '<div class="alert alert-warning">' . esc_html__( 'Please Enter your Contact Number', 'provide' ) . '</div>';
		}
		if ( empty( $error ) ) {
			$message   = "Dear Admin, you have a contact request from $name, $email, $number";
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
					wp_send_json( array( 'status' => false, 'msg' => $mailer->ErrorInfo ) );
				}
			} else {
				wp_mail( $rec_email, esc_html__( 'Contact Us Message', 'provide' ), $message, $headers );
			}
			$message = ( $h->provide_set( $opt, 'optContactMessage' ) ) ? $h->provide_set( $opt, 'optContactMessage' ) : sprintf( esc_html__( 'Thank you %s for using our contact form! Your email was successfully sent and we will be in touch with you soon.', 'provide' ), $name );
			$error   .= '<div class="alert alert-success">' . $message . '</div>';
			wp_send_json( array( 'status' => true, 'msg' => $error ) );
		} else {
			wp_send_json( array( 'status' => false, 'msg' => $error ) );
		}
	}

	public function provide_videoNewsletter( $data ) {
		$before = '<div class="alert alert-warning">';
		$after  = '</div>';
		$h      = new provide_Helper();
		$opt    = $h->provide_opt();
		$email  = trim( $h->provide_set( $data, 'email' ) );
		if ( get_magic_quotes_gpc() ) {
			$email = stripslashes( $email );
		}
		$errors = '';
		$notify = '';
		if ( $email == '' ) {
			$errors .= $before . esc_html__( 'Please Enter Valid Email Address', 'provide' ) . $after;
		}
		if ( $email != '' && ! preg_match( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email ) ) {
			$errors .= $before . esc_html__( 'Please Enter Valid Email Address', 'provide' ) . $after;
		}
		if ( empty( $errors ) ) {
			$list_id = $h->provide_set( $opt, 'optMailchimpListId' );
			$dc      = "us1";
			if ( strstr( $h->provide_set( $opt, 'optMailchimpApiKey' ), "-" ) ) {
				list( $key, $dc ) = explode( "-", $h->provide_set( $opt, 'optMailchimpApiKey' ), 2 );
				if ( ! $dc ) {
					$dc = "us1";
				}
			}
			$apikey    = $h->provide_set( $opt, 'optMailchimpApiKey' );
			$get_name  = explode( '@', $email );
			$auth      = provide_encrypt( 'user:' . $apikey );
			$data      = array(
				'apikey'        => $apikey,
				'email_address' => $email,
				'status'        => 'subscribed',
				'merge_fields'  => array(
					'FNAME' => $h->provide_set( $get_name, '0' )
				)
			);
			$json_data = json_encode( $data );
			$request   = array(
				'headers'     => array(
					'Authorization'  => 'Basic ' . $auth,
					'Accept'         => 'application/json',
					'Content-Type'   => 'application/json',
					'Content-Length' => strlen( $json_data ),
				),
				'httpversion' => '1.0',
				'timeout'     => 10,
				'method'      => 'POST',
				'user-agent'  => 'PHP-MCAPI/2.0',
				'sslverify'   => false,
				'body'        => $json_data,
			);
			$req       = wp_remote_post( 'https://' . $dc . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/', $request );
			$r         = json_decode( $h->provide_set( $req, 'body' ) );
			if ( preg_match( "/The requested resource could not be found./", $h->provide_set( $r, 'detail' ) ) ) {
				$notify .= '<div class="alert alert-warning"><strong>' . esc_html__( 'Invalid List ID', 'provide' ) . '</div>';
			} elseif ( $h->provide_set( $r, 'title' ) == "Member Exists" ) {
				$notify .= "<div class='alert alert-warning'><strong>{$email} " . esc_html__( 'is Already Exists', 'provide' ) . ".</div>";
			} else {
				$notify .= '<div class="alert alert-success"><strong>' . esc_html__( 'Thank you for subscribing with us', 'provide' ) . '.</div>';
			}
			wp_send_json( array( 'status' => true, 'msg' => $notify ) );
		} else {
			wp_send_json( array( 'status' => false, 'msg' => $errors ) );
		}
	}
        
        public function provide_quickview($data) {
            $h = new provide_Helper();
            $args = array(
                'post_type' => 'product',
                'post_status'   => 'publish',
                'p' =>  $h->provide_set($data, 'productID'),
            );
            
            $query = new WP_Query($args);
            $imagify = new provide_Imagify();
            $size = array('m' => '350x510', 'i' => '350x510', 'w' => '350x510');
            
            
            while($query->have_posts()) : $query->the_post();
            global $product;
            echo '<div class="quick-view-popup show">
		<div class="quick-view-product">
                    <span class="fa fa-close close-view-popup"></span>
                    <div class="quick-thumb">
                        '. $imagify->provide_thumb($size, true, array(TRUE, TRUE, TRUE)) .'
                    </div>
                    <div class="quick-view-info">
                        <div class="stars">
                            '. wc_get_rating_html($product->get_average_rating()) .'
                            
                        </div>
                        <h3><a href="'. get_the_permalink(get_the_ID()) .'" title="'. get_the_title(get_the_ID()) .'">'. get_the_title(get_the_ID()) .'</a></h3>
                        <div class="prices">
                                '. $product->get_price_html() .'
                        </div>
                        <p>'. esc_html(wp_trim_words(get_the_content(get_the_ID()), 50)) .'</p>
                        <a href="#" title="" class="color-btn">ADD YOUR CART</a>
                    </div>
		</div>
            </div>';
            
            $script = '
            jQuery(document).ready(function() {    
                jQuery(".view-btn-hover").on("click", function(){
                    jQuery(".quick-view-popup").addClass("show");
                    jQuery("html").addClass("stop-scroll");
                });
                return false;
            });';
            wp_add_inline_script("provide-script", $script);
            
            endwhile; wp_reset_postdata();
        }

	public static function provide_singleton() {
		if ( ! isset( self::$instance ) ) {
			$obj            = __CLASS__;
			self::$instance = new $obj;
		}

		return self::$instance;
	}

	public function __clone() {
		trigger_error( esc_html__( 'Cloning the registry is not permitted', 'provide' ), E_USER_ERROR );
	}

}
