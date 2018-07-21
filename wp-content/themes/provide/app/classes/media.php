<?php

class provide_Media {

	static private $styles = array();
	static private $adminStyles = array();
	static private $scripts = array();
	private static $instance;
	public $runTimeStyles = array();
	public $loadStyles = array();

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;

		return false;
	}

	public function provide_RenderMedia( $medias = array() ) {
		( new provide_Helper() )->provide_check( $medias );
		$this->loadStyles = $medias;
		add_action( 'wp_enqueue_scripts', array( $this, 'provide_runtimeRenderStyle' ) );
	}

	public function provide_RenderStyle() {
		$h                 = new provide_Helper();
		$google_typo_fonts = $this->provide_typographyFonts();
		if ( ! empty( $google_typo_fonts ) ):
			wp_enqueue_style( 'provide-theme-typo', $google_typo_fonts, array(), '', 'all' );
		endif;
		$google_theme_fonts = $this->provide_theme_google_fonts();
		if ( ! empty( $google_theme_fonts ) ):
			wp_enqueue_style( 'provide-theme-fonts', $google_theme_fonts, array(), '', 'all' );
		endif;
		self::$styles = provide_ThemeInit::provide_singleton()->provide_getSetting( 'themeStyles' );
		foreach ( self::$styles as $name => $file ) {
			$handle = $name;
			wp_enqueue_style( $handle, $h->provide_url( $file ), array(), provide_V, 'all' );
		}
		$opt   = $h->provide_opt();
		$color = $h->provide_colorScheme( $h->provide_set( $opt, 'optThemeColor' ), $h->provide_set( $opt, 'optThemeColor2' ) );
		wp_add_inline_style( 'provide-style', $color );
		$this->provide_typography();

		$bodyBg = $h->provide_set( $opt, 'optBodyBG' );
		if ( $h->provide_set( $bodyBg, 'url' ) != '' ) {
			$cssOutput = "
                .provide-body-bg{
                    background: #fff url(" . $h->provide_set( $bodyBg, 'url' ) . ") no-repeat fixed 0 0 / cover ;
                }
            ";
			wp_add_inline_style( 'provide-style', $cssOutput );
		}
		$this->provide_boxedLayout();

		if ( $h->provide_set( $opt, 'optThemeCssEditor' ) != '' ) {
			$customCss = $h->provide_set( $opt, 'optThemeCssEditor' );
			wp_add_inline_style( 'provide-style', $customCss );
		}
	}

	public function provide_runtimeRenderStyle() {
		foreach ( $this->loadStyles as $style ) {
			$handle = 'provide-' . $style;
			if ( ! wp_style_is( $handle, $list = 'enqueued ' ) ) {
				wp_enqueue_style( $handle );
			}
		}
	}

	static public function provide_RenderScript() {
		self::$scripts = provide_ThemeInit::provide_singleton()->provide_getSetting( 'themeScript' );
		foreach ( self::$scripts as $name => $file ) {
			$handle = $name;
			wp_register_script( $handle, ( new provide_Helper() )->provide_url( $file ), array(), provide_V, true );
		}
		$translation_array = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'url'     => provide_Uri,
		);
		wp_localize_script( 'provide-script', 'provide', $translation_array );
		wp_enqueue_script( array( 'jquery', 'bootstrap', 'wow', 'provide-script' ) );
	}

	public function provide_RenderAdminStyles() {
		self::$adminStyles = provide_ThemeInit::provide_singleton()->provide_getSetting( 'adminStyles' );
		foreach ( self::$adminStyles as $name => $file ) {
			$handle = 'provide-' . $name;
			wp_enqueue_style( $handle, provide_Uri . 'partial/' . $file, array(), provide_V, 'all' );
		}
	}

	public function provide_eq( $scripts = array() ) {
		foreach ( $scripts as $script ) {
			$handle = $script;
			wp_enqueue_script( $handle );
		}
	}

	public function provide_head() {
		if ( is_singular() ) {
			wp_enqueue_script( "comment-reply" );
		}
	}

	public function provide_theme_google_fonts() {
		$fonts_url = '';

		$fonts = array(
			'Lato'         => 'Lato:100,100i,300,300i,400,400i,700,700i,900,900i',
			'Montserrat'   => 'Montserrat:400,700',
			'Crimson_Text' => 'Crimson Text:400,400i,600,600i,700,700i',
			'Roboto_Slab'  => 'Roboto Slab:100,300,400,700',
		);

		if ( $fonts ) {
			$font_families = array();
			foreach ( $fonts as $name => $font ) {
				$string = sprintf( _x( 'on', '%s font: on or off', 'provide' ), $name );
				if ( 'off' !== $string ) {
					$font_families[] = $font;
				}
			}
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$protocol   = ( is_ssl() ) ? 'https' : 'http';
			$fonts_url  = add_query_arg( $query_args, $protocol . '://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}

	public function provide_typographyFonts() {
		$h      = new provide_Helper;
		$opt    = $h->provide_opt();
		$render = '';
		$fonts  = array();
		$subset = array();
		$style  = array( 'body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
		foreach ( $style as $s ) {
			$isTypo = $h->provide_set( $opt, 'opt' . ucfirst( $s ) . 'Typo' );
			if ( $isTypo == '1' ) {
				$styleArray    = $h->provide_set( $opt, 'opt' . ucfirst( $s ) . 'Typography' );
				$key           = str_replace( ' ', '_', $h->provide_set( $styleArray, 'font-family' ) );
				$fountName     = str_replace( ' ', '+', $h->provide_set( $styleArray, 'font-family' ) );
				$fonts[ $key ] = $fountName . ':' . $h->provide_set( $styleArray, 'font-weight' );
				if ( $h->provide_set( $styleArray, 'subsets' ) != '' ) {
					$subset[ $h->provide_set( $styleArray, 'subsets' ) ] = '';
				}
			}
		}

		if ( ! empty( $subset ) && count( $subset ) > 0 ) {
			$getSubset = array_keys( $subset );
			$subsets   = implode( ',', $getSubset );
		} else {
			$subsets = 'latin';
		}

		if ( $fonts ) {
			$font_families = array();
			foreach ( $fonts as $name => $font ) {
				$string = sprintf( _x( 'on', '%s font: on or off', 'provide' ), $name );
				if ( 'off' !== $string ) {
					$font_families[] = $font;
				}
			}
			$query_args = array(
				'family' => implode( '|', $font_families ),
				'subset' => urlencode( $subsets ),
			);
			$protocol   = ( is_ssl() ) ? 'https' : 'http';
			$fonts_url  = add_query_arg( $query_args, $protocol . '://fonts.googleapis.com/css' );
		}
		if ( ! empty( $fonts_url ) ) {
			return esc_url_raw( $fonts_url );
		} else {
			return;
		}
	}

	public function provide_typography() {
		$h      = new provide_Helper;
		$opt    = $h->provide_opt();
		$render = '';
		$style  = array( 'body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
		foreach ( $style as $s ) {
			$isTypo = $h->provide_set( $opt, 'opt' . ucfirst( $s ) . 'Typo' );
			if ( $isTypo == '1' ) {
				$styleArray = $h->provide_set( $opt, 'opt' . ucfirst( $s ) . 'Typography' );
				unset( $styleArray['font-options'] );
				unset( $styleArray['google'] );
				unset( $styleArray['font-style'] );
				unset( $styleArray['subsets'] );
				if ( ! empty( $styleArray ) && count( $styleArray ) > 0 ) {
					if ( $s == 'body' ) {
						$render .= $s . ' p{' . PHP_EOL;
					} else {
						$render .= $s . '{' . PHP_EOL;
					}
					foreach ( $styleArray as $k => $v ) {
						if ( ! empty( $v ) ) {
							$render .= $k . ':' . $v . ' !important;' . PHP_EOL;
						}
					}
					$render .= '}' . PHP_EOL;
				}
			}
		}
		wp_add_inline_style( 'provide-style', $render );
	}

	public function provide_boxedLayout() {
		$h                = new provide_Helper;
		$opt              = $h->provide_opt();
		$background_style = '';
		if ( $h->provide_set( $opt, 'themeBoxedLayout' ) == '1' && $h->provide_set( $opt, 'optBoxedBackgroundType' ) == '1' ) {
			$backgroundImage = $h->provide_set( $opt, 'optBoxedBackgroundImage' );
			if ( $h->provide_set( $backgroundImage, 'url' ) != '' ) {
				$background_style .= 'body{';
				$background_style .= 'background-image:url(' . $h->provide_set( $backgroundImage, 'url' ) . ') !important;';
				$background_style .= 'background-repeat:' . $h->provide_set( $opt, 'optBoxedBackgroundRepeat' ) . ' !important;';
				$background_style .= 'background-attachment:' . $h->provide_set( $opt, 'optBoxedBackgroundAttachment' ) . '  !important;';
				$background_style .= 'background-size: cover !important;';
				$background_style .= '}';
			}
		}
		if ( $h->provide_set( $opt, 'themeBoxedLayout' ) && $h->provide_set( $opt, 'optBoxedBackgroundType' ) == '2' ) {
			$backgroundPattern = $h->provide_set( $opt, 'optBoxedBackgroundPattern' );

			if ( $backgroundPattern != '0' ) {
				$patternUrl = provide_Uri . 'partial/images/patterns/pattern-' . $backgroundPattern . '.png';
				$background_style .= 'body{';
				$background_style .= 'background-image:url(' . $patternUrl . ')';
				$background_style .= '}';
			}
		}
		wp_add_inline_style( 'provide-style', $background_style );
	}

	public function provide_footer() {
		$h   = new provide_Helper();
		$opt = $h->provide_opt();
		if ( $h->provide_set( $opt, 'optThemeJsEditor' ) != '' ) {
			$customJS = $h->provide_set( $opt, 'optThemeJsEditor' );
			wp_add_inline_script( 'provide-script', $customJS );
		}
	}

	public static function provide_singleton() {
		if ( ! isset( self::$instance ) ) {
			$obj            = __CLASS__;
			self::$instance = new $obj;
		}

		return self::$instance;
	}

}
