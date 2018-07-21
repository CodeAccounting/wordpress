<?php
if ( ! class_exists( 'Grabber' ) ) {
	class Grabber {
		private static $instance;

		public function _set( $var, $key, $def = '' ) {
			if ( ! $var ) {
				return FALSE;
			}
			if ( is_object( $var ) && isset( $var->$key ) ) {
				return $var->$key;
			} elseif ( is_array( $var ) && isset( $var[ $key ] ) ) {
				return $var[ $key ];
			} elseif ( $def ) {
				return $def;
			} else {
				return FALSE;
			}
		}

		public function run() {
			$data     = $_POST;
			$metaData = array();
			$type     = $this->_set( $data, 'type' );
			$urls     = $this->_set( $data, 'urls' );
			$siplit   = explode( '|', $urls );
			if ( ! empty( $siplit ) && count( $siplit ) > 0 ) {
				foreach ( $siplit as $uri ) {
					$urlParts   = parse_url( $uri );
					$replace    = array( 'www.', '.com' );
					$host       = str_replace( $replace, '', $this->_set( $urlParts, 'host' ) );
					$metaData[] = $this->$host( $uri );
				}
			} else {
				echo json_encode( array( 'status' => 'false', 'msg' => esc_html__( 'Video Url missing', 'provide' ) ) );
			}


		}

		public function youtube( $url ) {
			if ( empty( $url ) ) {
				return;
			}
			$urlParts   = parse_url( $url );
			$videoId    = str_replace( 'v=', '', $this->_set( $urlParts, 'query' ) );
			$args       = array(
				'timeout'     => 5,
				'redirection' => 5,
				'httpversion' => '1.1',
				'user-agent'  => 'WordPress/' . $wp_version . '; ' . home_url(),
				'blocking'    => TRUE,
				'headers'     => array(),
				'cookies'     => array(),
				'body'        => NULL,
				'compress'    => FALSE,
				'decompress'  => TRUE,
				'sslverify'   => TRUE,
				'stream'      => FALSE,
				'filename'    => NULL
			);
			$fetchData  = wp_remote_get( "https://www.googleapis.com/youtube/v3/videos?part=snippet,player&snippet&id=$videoId&key=AIzaSyB34BrDzyiylP3-TLF1aFkVGd51_sehUl0", $args );
			$dataObject = json_decode( wp_remote_retrieve_body( $fetchData ) );
			print_r( $dataObject );
			exit;
			if ( ! empty( $dataObject ) ) {
				return array(
					'title'      => '',
					'desc'       => '',
					'thumbnails' => '',
					'title'      => '',
					'title'      => '',
					'title'      => '',
					'title'      => '',
					'title'      => '',
				);
			} else {
				return array();
			}

		}

		public function vimeo( $url ) {
			if ( empty( $url ) ) {
				return;
			}
		}

		public function dailymotion( $url ) {
			if ( empty( $url ) ) {
				return;
			}
		}

		public function soundcloud( $url ) {
			if ( empty( $url ) ) {
				return;
			}
		}

		public static function Instance() {
			if ( ! isset( self::$instance ) ) {
				$obj            = __CLASS__;
				self::$instance = new $obj;
			}

			return self::$instance;
		}
	}
}