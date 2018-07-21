<?php

class provide_import_export {

	private $path = '';
	private $file_system = '';
	private $backup_path = '';
	private $demo = '';

	function __construct( $demo = '' ) {
		$this->demo  = $demo;
		$this->path  = Plugin_ROOT . '/panel/redux-extensions/extensions/wbc_importer/demo-data/' . $this->demo . '/';
		$this->path2 = ABSPATH . '/wp-content/provide/';
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
		$this->file_system = $wp_filesystem;
		if ( ! is_dir( $this->path2 ) ) {
			$this->file_system->mkdir( $this->path2 );
		}
	}

	function provide_export() {
		$this->provide_sidebar_export();
		$this->provide_theme_options_export();
		if ( function_exists( 'rev_slider_shortcode' ) ) {
			$this->revslider_export();
		}
	}

	function provide_import() {
		$this->provide_sidebar_import();
		$this->provide_theme_options_import();
		if ( function_exists( 'rev_slider_shortcode' ) ) {
			$this->revslider_import();
		}
	}

	function provide_create_bakup( $folders ) {
		if ( ! empty( $folders ) ) {
			$counter = 0;
			foreach ( $folders as $folder ) {
				if ( $counter == 0 ) {
					$check = $this->backup_path . $folder;
				} else {
					$check = $this->backup_path . $folder . '/' . $folder;
				}
				if ( ! $this->file_system->is_dir( $check ) ) {
					$this->file_system->mkdir( $check );
				}
				$counter ++;
			}
		}
	}

	function provide_vc_template_provide_export( $file = '' ) {
		global $wpdb;
		$file     = ( $file ) ? $file : 'default_settings';
		$data     = array();
		$settings = get_option( 'wpb_js_templates' );
		$dir      = $this->path . 'vc_options';
		$this->newdir( $dir );
		$w_file = $dir . '/' . $file;
		$this->file_system->put_contents( $w_file, $this->encrypt( $settings ), 0777 );
	}

	function provide_vc_template_import( $file = '' ) {
		global $wpdb;
		$file     = ( $file ) ? $file : 'default_settings';
		$settings = $this->read_file( $this->newdir( $this->path . 'vc_options' ) . DIRECTORY_SEPARATOR . $file );
		update_option( 'wpb_js_templates', $settings );
	}

	function revslider_export( $file = '' ) {

		global $wpdb;
		$file = ( $file ) ? $file : 'default_settings';
		$data = array();

		$sliders = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "revslider_sliders", ARRAY_A );

		$slides = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "revslider_slides", ARRAY_A );

		foreach ( $sliders as $k => $s ) {

			$slider_id = provide_set( $s, 'id' );

			if ( isset( $s['id'] ) ) {
				unset( $s['id'] );
			}

			$data['slider'][ $k ] = $s;

			foreach ( $slides as $ss ) {

				if ( isset( $ss['id'] ) ) {
					unset( $ss['id'] );
				}


				if ( $slider_id == provide_set( $ss, 'slider_id' ) ) {
					$data['slider'][ $k ]['slides'][] = $ss;
				}
			}
		}

		$dir = $this->path2 . 'revslider_options';
		$this->newdir( $dir );
		$w_file = $dir . '/' . $file;

		$this->file_system->put_contents( $w_file, $this->encrypt( $data ), 0777 );

	}

	function revslider_import( $file = '' ) {

		global $wpdb;
		$file     = ( $file ) ? $file : 'default_settings';
		$settings = $this->read_file( $this->path . 'revslider_options' . DIRECTORY_SEPARATOR . $file );
		if ( $settings ) {
			foreach ( (array) $settings['slider'] as $v ) {
				$slider_id = '';
				$res       = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "revslider_sliders` WHERE `title` LIKE '%" . $v['title'] . "%'" );
				if ( $res ) {
					continue;
				}
				$slides = provide_set( $v, 'slides' );
				if ( $slides ) {
					unset( $v['slides'] );
				}
				$wpdb->insert( $wpdb->prefix . "revslider_sliders", $v );
				$slider_id = $wpdb->insert_id;

				if ( $slider_id ) {

					foreach ( $slides as $key => $val ) {

						if ( $val ) {

							$val['slider_id'] = $slider_id;

							$wpdb->insert( $wpdb->prefix . "revslider_slides", $val );
						}
					}
				}
			}
		}
	}

	function provide_layerslider_export( $file = '' ) {
		global $wpdb;
		$file           = ( $file ) ? $file : 'default_settings';
		$data           = array();
		$sliders        = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "layerslider", ARRAY_A );
		$data           = array();
		$data['slider'] = $sliders;
		$dir            = $this->path . 'layerslider_options';
		$this->newdir( $dir );
		$w_file = $dir . '/' . $file;

		$this->file_system->put_contents( $w_file, $this->encrypt( $data ), 0777 );
	}

	function provide_layerslider_import( $file = '' ) {
		global $wpdb;
		$file = ( $file ) ? $file : 'default_settings';

		$settings = $this->read_file( $this->path . 'layerslider_options' . DIRECTORY_SEPARATOR . $file );

		foreach ( (array) $settings['slider'] as $v ) {
			$res = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "layerslider` WHERE `name` LIKE '%" . $v['name'] . "%'" );
			if ( $res ) {
				continue;
			}

			$data = $v;
			$wpdb->insert( $wpdb->prefix . "layerslider", array(
				'id'     => $data['id'],
				'author' => $data['author'],
				'name'   => $data['name'],
				'slug'   => $data['slug'],
				'data'   => $data['data'],
				'date_c' => $data['date_c'],
				'date_m' => $data['date_m']
			), array(
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d'
			) );
		}
	}

	function provide_theme_options_import( $file = '' ) {
		global $wpdb;
		$file = ( $file ) ? $file : 'default_settings';
		$data = $this->read_file( $this->path . 'theme_options' . DIRECTORY_SEPARATOR . $file );
		$v    = $this->replace_pseudo( $data );
		update_option( 'provideOpt', $v );
		$front_page = get_page_by_title( 'Home' );
		$blog_page  = get_page_by_title( 'Blog Ver 1' );
		if ( $front_page ) {
			if ( get_option( 'show_on_front' ) != 'page' && ! get_option( 'page_on_front' ) ) {
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $front_page->ID );
				update_option( 'page_for_posts', $blog_page->ID );
			}
		}
		update_option( 'posts_per_page', 6 );
		$res = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "terms WHERE " . $wpdb->prefix . "terms.slug = 'main-menu' OR " . $wpdb->prefix . "terms.slug = 'responsive'" );
		if ( $res ) {
			$nav_menu                                     = array( '' );
			$nav_menu['nav_menu_locations']['primary']    = $res[0]->term_id;
			$nav_menu['nav_menu_locations']['responsive'] = $res[0]->term_id;
			$info                                         = pathinfo( get_template_directory() );
			update_option( 'theme_mods_' . provide_set( $info, 'basename' ), $nav_menu );
		}
	}

	function provide_theme_options_export( $file = '' ) {
		$file    = ( $file ) ? $file : 'default_settings';
		$options = get_option( 'provideOpt' );
		$data    = $this->pseudo( $options );
		$dir     = $this->path2 . 'theme_options';
		$this->newdir( $dir );
		$w_file = $dir . '/' . $file;
		$this->file_system->put_contents( $w_file, $this->encrypt( $data ), 0777 );
	}

	function provide_sidebar_import( $file = '' ) {
		$file = ( $file ) ? $file : 'default_settings';
		$data = $this->read_file( $this->path . 'widgets' . DIRECTORY_SEPARATOR . $file );

		if ( ! isset( $data['settings'] ) || ! isset( $data['sidebars'] ) ) {
			return;
		}

		foreach ( $data['settings'] as $k => $v ) {
			update_option( 'widget_' . $k, $this->replace_pseudo( $v ) );
		}
		update_option( 'sidebars_widgets', $data['sidebars'] );
	}

	function provide_sidebar_export( $file = '' ) {
		$file     = ( $file ) ? $file : 'default_settings';
		$settings = array();
		$sidebars = wp_get_sidebars_widgets();
		if ( isset( $sidebars['wp_inactive_widgets'] ) ) {
			unset( $sidebars['wp_inactive_widgets'] );
		}

		foreach ( $sidebars as $name => $widgets ) {
			if ( ! count( $widgets ) || $name == 'orphaned_widgets' ) {
				continue;
			}

			foreach ( $widgets as $widget ) {
				if ( preg_match( '#(.*?)-(\d+)$#', $widget, $matches ) ) {
					$type = $matches[1];
					$id   = $matches[2];
					if ( $widget_settings = get_option( 'widget_' . $type ) ) {
						$settings[ $type ][ $id ] = $this->pseudo( $widget_settings[ $id ] );
					}
				}
			}
		}
		$dir = $this->path2 . 'widgets';
		$this->newdir( $dir );
		$w_file = $dir . '/' . $file;
		$this->file_system->put_contents( $w_file, $this->encrypt( array( 'settings' => $settings, 'sidebars' => $sidebars ) ), 0777 );
	}

	function encrypt( $data ) {
		if ( is_array( $data ) ) {
			return provide_encrypt( serialize( $data ) );
		} else {
			return $data;
		}
	}

	function decrypt( $data ) {
		$data = base64_decode( $data );
		if ( is_serialized( $data ) ) {
			return unserialize( $data );
		} else {
			return $data;
		}
	}

	function newdir( $path ) {
		if ( ! $this->file_system->is_dir( $path ) ) {
			$this->file_system->mkdir( $path );
		}
	}

	function read_file( $file ) {

		if ( ! file_exists( $file ) ) {
			return false;
		}

		$data = '';

		$data .= $this->file_system->get_contents( $file );

		return $this->decrypt( $data );
	}

	function pseudo( $options = array() ) {
		if ( ! empty( $options ) ) {
			foreach ( $options as $k => $v ) {
				if ( is_array( $v ) ) {
					$options[ $k ] = $this->pseudo( $v );
				} elseif ( preg_match( "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $v ) ) {
					$options[ $k ] = '{ADMIN_EMAIL}';
				} else {
					$options[ $k ] = str_replace( array( get_template_directory_uri(), home_url( '/' ), get_option( 'admin_email' ) ), array( '{THEME_URL}', '{HOME_URL}', '{ADMIN_EMAIL}' ), $v );
				}
			}

			return $options;
		}
	}

	function replace_pseudo( $options = array() ) {
		foreach ( (array) $options as $k => $v ) {
			if ( is_array( $v ) ) {
				$options[ $k ] = $this->replace_pseudo( $v );
			} else {
				$options[ $k ] = str_replace( array( '{THEME_URL}', '{HOME_URL}', '{ADMIN_EMAIL}' ), array( get_template_directory_uri(), home_url( '/' ), get_option( 'admin_email' ) ), $v );
			}
		}

		return $options;
	}

}
