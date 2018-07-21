<?php

class provide_ThemeInit {

	private static $settings = array();
	private static $instance;

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;

		return false;
	}

	static public function init() {
		add_action( 'init', array( __CLASS__, 'porivde_outputBuffer' ) );
		self::provide_singleton()->provide_constant();
		add_action( 'init', array( self::provide_singleton(), 'provide_updateOptions' ) );
		self::provide_singleton()->provide_autoLoader();
		self::provide_singleton()->provide_InitSettings();
		self::provide_singleton()->provide_front();
		new provide_ajax();
		require_once provide_Root . 'app/classes/vcsettings.php';
		require_once provide_Root . 'app/lib/shortcodes.php';
		require_once provide_Root . 'app/lib/widgets.php';
		add_action( 'load-profile.php', array( __CLASS__, 'provide_removeUserField' ) );
		add_action( 'widgets_init', array( 'provide_Widgets', 'register' ) );
		add_filter( 'post_row_actions', array( __CLASS__, 'provide_remove_link_faq' ), 10, 1 );
		add_filter( 'get_sample_permalink_html', array( __CLASS__, 'provide_permalink' ), 10, 5 );
		add_filter( 'body_class', array( __CLASS__, 'provide_bodyClass' ) );
		add_filter( 'excerpt_length', array( __CLASS__, 'provide_excerptLength' ), 999 );
		add_filter( 'comment_reply_link', array( __CLASS__, 'provide_modifyCommentReply' ) );
		add_filter( 'wp_list_categories', array( __CLASS__, 'provide_categoryCount' ) );
		add_filter( 'get_archives_link', array( __CLASS__, 'provide_categoryCount' ) );
		add_filter( 'pre_get_posts', array( __CLASS__, 'provide_searchFilter' ) );
		add_filter( 'get_header', array( __CLASS__, 'provideComingSoon' ) );
                
                

		add_filter( 'locale', array( __CLASS__, 'provide_themeLocalized' ), 10 );
		load_textdomain( 'provide', provide_Root . 'languages/' . get_locale() . '.mo' );

		if ( is_admin() ) {
			provide_admin::provide_singleton()->init();
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active( 'provide/provide.php' ) ) {
				$path = ABSPATH . 'wp-content/plugins/provide/vc-addon/';
				if ( file_exists( $path . 'toggle.php' ) ) {
					include_once $path . 'toggle.php';
					new provide_toggle();
				}
				if ( file_exists( $path . 'multiselect.php' ) ) {
					include_once $path . 'multiselect.php';
					new provide_multiselect();
				}
				if ( file_exists( $path . 'number.php' ) ) {
					include_once $path . 'number.php';
					new provide_number();
				}
				if ( file_exists( $path . 'heading.php' ) ) {
					include_once $path . 'heading.php';
					new provide_heading();
				}
			}
		}
		provide_Media::provide_singleton()->provide_RenderMedia( array( 'style' ) );
		add_action( 'widgets_init', array( provide_sidebar::provide_singleton(), 'init' ) );
	}

	public static function porivde_outputBuffer() {
		ob_start();
	}

	public function provide_setup() {
		add_editor_style();
		if ( ! isset( $content_width ) ) {
			$content_width = 900;
		}
                add_theme_support( 'woocommerce' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		register_nav_menus( array(
                    'primary'    => esc_html__( 'Primary', 'provide' ),
                    'left' => esc_html__( 'Left Menu', 'provide' ),
                    'right' => esc_html__( 'Right Menu', 'provide' ),
                    'responsive' => esc_html__( 'Responsive Menu', 'provide' )
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-background', apply_filters( 'provide_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
		add_theme_support( 'jetpack-responsive-videos' );
                
                add_image_size('provide_870x523', '870', '523', true);
                add_image_size('provide_1170x403', '1170', '403', true);
                add_image_size('provide_100x115', '100', '115', true);
	}

	public function provide_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'provide_content_width', 640 );
	}

	public function provide_custom_header_setup() {
		add_theme_support( 'custom-header', apply_filters( 'provide_custom_header_args', array(
			'default-image'      => '',
			'default-text-color' => '000000',
			'width'              => 1000,
			'height'             => 250,
			'flex-height'        => true,
			'wp-head-callback'   => array( $this, 'provide_header_style' ),
		) ) );
	}

	public function provide_header_style() {
            
		if ( get_header_image() ) :
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
			</a>
			<?php
		endif;
		add_action( 'wp_enqueue_scripts', array( provide_ThemeInit::provide_singleton(), 'provide_headerStyleAppend' ) );
	}

	public function provide_headerStyleAppend() {
		wp_enqueue_style( 'provide-custom-style', get_template_directory_uri() . '/partial/css/custom-style.css' );
		$customCss         = '';
		$header_text_color = get_header_textcolor();
		if ( HEADER_TEXTCOLOR === $header_text_color ) {
			return;
		}
		if ( ! display_header_text() ) {
			$customCss .= ".site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}";
		} else {
			$customCss .= ".site-title a,
				.site-description {
					color: #" . esc_attr( $header_text_color ) . ";
				}";
		}
		wp_add_inline_style( 'provide-custom-style', $customCss );
	}

	public function provide_constant() {
		define( 'provide_Root', get_template_directory() . '/' );
		define( 'provide_Uri', get_template_directory_uri() . '/' );
		define( 'provide_EXT', provide_Root . 'app/panel/redux-extensions/extensions/' );
		define( 'provide_EXTU', provide_Uri . 'app/panel/redux-extensions/extensions/' );
		define( 'provide_V', '1.0' );
		define( 'provide_OPT', 'provideOpt' );
		define( 'provide_GLOBEL', 'provide' );
	}

	public function provide_front() {
		add_action( 'after_setup_theme', array( self::provide_singleton(), 'provide_setup' ) );
		add_action( 'after_setup_theme', array( self::provide_singleton(), 'provide_content_width' ), 0 );
		add_action( 'after_setup_theme', array( self::provide_singleton(), 'provide_custom_header_setup' ) );
		add_action( 'wp_enqueue_scripts', array( provide_Media::provide_singleton(), 'provide_RenderStyle' ), 99 );
		add_action( 'wp_enqueue_scripts', array( provide_Media::provide_singleton(), 'provide_RenderScript' ) );
		add_action( 'wp_head', array( provide_Media::provide_singleton(), 'provide_head' ) );
		add_action( 'wp_footer', array( provide_Media::provide_singleton(), 'provide_footer' ) );
		add_action( 'init', array( 'provide_Shortcodes', 'init' ) );
		if ( class_exists( 'provide_Resizer' ) ) {
			add_action( 'delete_attachment', array( new provide_Resizer(), 'provide_delResizer' ) );
		}
		//add_action('after_setup_theme', array(self::provide_singleton(), 'provide_updateOptions'));
	}

	public function provide_storeSetting( $data, $key ) {
		self::$settings[ $key ] = $data;
	}

	public function provide_getSetting( $key ) {
		return self::$settings[ $key ];
	}

	public function provide_autoLoader() {
		require_once provide_Root . 'app/lib/autoloader.php';
		Autoload::register();
		Autoload::directories( array(
			provide_Root . 'app/classes/',
		) );
	}

	public function provide_InitSettings() {
		require_once provide_Root . 'app/lib/settings.php';
	}

	public static function provide_bodyClass( $classes ) {
		$h      = new provide_Helper();
		$opt    = $h->provide_opt();
		$bodyBg = $h->provide_set( $opt, 'optBodyBG' );
		if ( $h->provide_set( $bodyBg, 'url' ) != '' ) {
			$classes[] = 'provide-body-bg';
		}

		return $classes;
	}

	public static function provide_excerptLength( $length ) {
		return 20;
	}

	public static function provide_updateOptions() {
		if ( file_exists( provide_Root . 'app/lib/default.php' ) ) {
			delete_option( 'provideOpt' );
		}
		if ( get_option( 'provideOpt' ) == "" ) {
			if ( file_exists( provide_Root . 'app/lib/default.php' ) ) {
				include provide_Root . 'app/lib/default.php';
				if ( ! empty( $dummyArray ) ) {
					update_option( 'provideOpt', $dummyArray );
					unlink( provide_Root . 'app/lib/default.php' );
				}
			}
		}
	}

	public static function provide_LoadThemeOptions() {
		wp_enqueue_script( 'provide-script', get_template_directory_uri() . '/partial/js/script.js', array(), '1.0' );
		wp_add_inline_script( 'provide-script', 'location.reload();' );
	}

	public static function provide_removeUserField() {
		add_filter( 'option_show_avatars', '__return_false' );
	}

	public static function provide_modifyCommentReply( $class ) {
		$class = str_replace( "class='comment-reply-link", "class='reply", $class );

		return $class;
	}

	public static function provide_remove_link_faq( $action ) {
		global $post;
		$h = new provide_Helper;
		if ( $h->provide_set( $post, 'post_type' ) == 'pr_testimonial' || $h->provide_set( $post, 'post_type' ) == 'pr_price_table' ) {
			unset( $action['view'] );

			return $action;
		} else {
			return $action;
		}
	}

	public static function provide_permalink( $return, $id, $new_title, $new_slug ) {
		$h    = new provide_Helper;
		$post = get_post( $id );
		if ( $h->provide_set( $post, 'post_type' ) == 'pr_testimonial' || $h->provide_set( $post, 'post_type' ) == 'pr_price_table' ) {
			return '';
		} else {
			return $return;
		}
	}

	public static function provide_categoryCount( $links ) {
		$links = str_replace( '(', '<span class="post-count">', $links );
		$links = str_replace( ')', '</span>', $links );

		return $links;
	}

	static public function provide_searchFilter( $query ) {
		if ( ! $query->is_admin && $query->is_search ) {
			$query->set( 'post_type', array( 'post', 'pr_portfolio', 'pr_branches' ) );
		}

		return $query;
	}

	static public function provideComingSoon() {
		if ( ! is_admin() && ! is_user_logged_in() ) {
			$opt = ( new provide_Helper() )->provide_opt();
			if ( ( new provide_Helper() )->provide_set( $opt, 'optComingSoon' ) == '1' ) {
				include provide_Root . 'comming-soon.php';
				exit;
			}
		}
	}

	static public function provide_themeLocalized( $locale ) {
		$h    = new provide_Helper();
		$opt  = $h->provide_opt();
		$lang = $h->provide_set( $opt, 'optLanguage' );
		if ( isset( $_GET['l'] ) ) {
			return esc_attr( $_GET['l'] );
		}

		return ( ! empty( $lang ) ) ? $lang : $locale;
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
