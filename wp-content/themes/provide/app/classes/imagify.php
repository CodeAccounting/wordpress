<?php

class provide_Imagify {

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;

		return FALSE;
	}

	public function provide_thumb( $size = array(), $inPost = TRUE, $corp = array(), $url = '', $align = '', $isUrl = FALSE ) {
		$h = new provide_Helper;
		if ( class_exists( 'Mobile_Detect' ) ) {
			$resize = new provide_Resizer();
			$detect = new Mobile_Detect;
			if ( ! empty( $url ) ) {
				$url = $url;
			} else {
				$url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				if ( empty( $url ) ) {
					return;
				}
			}
			if ( $detect->isMobile() ) {
				$sizes = explode( 'x', $h->provide_set( $size, 'm' ) );
				$corp  = $h->provide_set( $corp, '0' );
			}
			if ( $detect->isiPad() || $detect->isTablet() ) {
				$sizes = explode( 'x', $h->provide_set( $size, 'i' ) );
				$corp  = $h->provide_set( $corp, '1' );
			}
			if ( ! $detect->isMobile() && ! $detect->isiPad() ) {
				$sizes = explode( 'x', $h->provide_set( $size, 'w' ) );
				$corp  = $h->provide_set( $corp, '2' );
			}
			return $resize->provide_resize( $url, $h->provide_set( $sizes, '0' ), $h->provide_set( $sizes, '1' ), $corp, $align, FALSE, $isUrl );
		} else {
			if ( $inPost === TRUE ) {
				return the_post_thumbnail( 'full' );
			} else {
				return $url;
			}
		}
	}

}
