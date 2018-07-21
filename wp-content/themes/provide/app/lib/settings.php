<?php
$h     = new provide_Helper();
$opt   = $h->provide_opt();
$boxed = ( ( new provide_Helper() )->provide_set( $opt, 'optShowBoxedLayout' ) === '1' ) ? 'boxed' : '';
if ( ! empty( $boxed ) ) {
	add_action( 'wp_enqueue_scripts', array( provide_Media::provide_singleton(), 'provide_boxedVersion' ) );
}
add_action( 'wp_enqueue_scripts', array( provide_Helper::provide_singleton(), 'provide_colorScheme' ) );
$style = array(
	'bootstrap'     => 'css/bootstrap.min.css',
	'icons'         => 'css/icons.css',
	'owl'           => 'css/style.css',
        'slick' =>  'css/slick.css',
	'animation'     => 'css/animate.css',
	'provide-style' => 'css/responsive.css',
);
$rtl   = array( 'provide-rtl' => 'css/rtl.css' );
if ( $h->provide_set( $opt, 'themeRtl' ) == '1' ) {
	$style = array_merge( $style, $rtl );
}
provide_ThemeInit::provide_singleton()->provide_storeSetting( $style, 'themeStyles' );
$mapKey  = $h->provide_set( $opt, 'optMapApiKey' );

$scripts = array(
	'bootstrap'         => 'js/bootstrap.min.js',
	'html5lightbox'     => 'js/html5lightbox.js',
	'owl'               => 'js/owl.carousel.min.js',
	'wow'               => 'js/wow.min.js',
	'flicker'           => 'js/jflickrfeed.min.js',
	'map'               => 'https://maps.googleapis.com/maps/api/js?key=' . $mapKey . '&v=3.exp',
	'morris'            => 'js/morris.js',
        'simple-select'     =>  'js/simple-select.js',
        'value'             =>  'js/value.js',
        'slick'             =>  'js/slick.min.js',
	'provide-isotope'   => 'js/isotope.js',
	'provide-counter'   => 'js/counter.js',
	'provide-select2'   => 'js/select2.min.js',
	'provide-downCount' => 'js/downcount.min.js',
	'provide-script'    => 'js/script.js'
);
provide_ThemeInit::provide_singleton()->provide_storeSetting( $scripts, 'themeScript' );

$adminStyles = array(
	'admin-style' => 'css/admin/style.css',
	'dashicons'   => 'css/admin/dashicons.css',
	'vc-toggle'   => 'css/admin/toggle.css',
);
provide_ThemeInit::provide_singleton()->provide_storeSetting( $adminStyles, 'adminStyles' );

$fileArray = array(
	'general_settings'    => array(
		'header_settings',
		'responsiveheader_settings',
		'footer_settings',
	),
	'comingsoon_settings' => array(),
	'contact_settings'    => array(),
	'newsletter_settings' => array(),
	'blog_settings'       => array(
		'imagecoverstyle_settings',
		'gridstyle_settings',
		'liststyle_settings',
		'blogsingle_settings',
	),
	'smtp_settings' => array(),
	'template_settings'   => array(
		'blogtemplate_settings',
		'archive_settings',
		'author_settings',
		'category_settings',
		'tag_settings',
		'search_settings',
		'404_settings',
	),
	'language_settings'    => array(),
	'sidebar_settings'    => array(),
	'typography_settings' => array(
		'bodytypography_settings',
		'h1typography_settings',
		'h2typography_settings',
		'h3typography_settings',
		'h4typography_settings',
		'h5typography_settings',
		'h6typography_settings'
	),
);
provide_ThemeInit::provide_singleton()->provide_storeSetting( $fileArray, 'optionsArray' );

$socialProfiler = array(
	'adn'                 => 'fa-adn',
	'android'             => 'fa-android',
	'apple'               => 'fa-apple',
	'behance'             => 'fa-behance',
	'behance_square'      => 'fa-behance-square',
	'bitbucket'           => 'fa-bitbucket',
	'bitcoin'             => 'fa-btc',
	'css3'                => 'fa-css3',
	'delicious'           => 'fa-delicious',
	'deviantart'          => 'fa-deviantart',
	'dribbble'            => 'fa-dribbble',
	'dropbox'             => 'fa-dropbox',
	'drupal'              => 'fa-drupal',
	'empire'              => 'fa-empire',
	'facebook'            => 'fa-facebook',
	'four_square'         => 'fa-foursquare',
	'git_square'          => 'fa-git-square',
	'github'              => 'fa-github',
	'github_alt'          => 'fa-github',
	'github_square'       => 'fa-github-square',
	'git_tip'             => 'fa-gittip',
	'google'              => 'fa-google',
	'google_plus'         => 'fa-google-plus',
	'google_plus_square'  => 'fa-google-plus-square',
	'hacker_news'         => 'fa-hacker-news',
	'html5'               => 'fa-html5',
	'instagram'           => 'fa-instagram',
	'joomla'              => 'fa-joomla',
	'js_fiddle'           => 'fa-jsfiddle',
	'linkedIn'            => 'fa-linkedin',
	'linkedIn_square'     => 'fa-linkedin-square',
	'linux'               => 'fa-linux',
	'MaxCDN'              => 'fa-maxcdn',
	'OpenID'              => 'fa-openid',
	'page_lines'          => 'fa-pagelines',
	'pied_piper'          => 'fa-pied-piper',
	'pinterest'           => 'fa-pinterest',
	'pinterest_square'    => 'fa-pinterest-square',
	'QQ'                  => 'fa-qq',
	'rebel'               => 'fa-rebel',
	'reddit'              => 'fa-reddit',
	'reddit_square'       => 'fa-reddit-square',
	'ren-ren'             => 'fa-renren',
	'share_alt'           => 'fa-share-alt',
	'share_square'        => 'fa-share-alt-square',
	'skype'               => 'fa-skype',
	'slack'               => 'fa-slack',
	'sound_cloud'         => 'fa-soundcloud',
	'spotify'             => 'fa-spotify',
	'stack_exchange'      => 'fa-stack-exchange',
	'stack_overflow'      => 'fa-stack-overflow',
	'steam'               => 'fa-steam',
	'steam_square'        => 'fa-steam-square',
	'stumble_upon'        => 'fa-stumbleupon',
	'stumble_upon_circle' => 'fa-stumbleupon-circle',
	'tencent_weibo'       => 'fa-tencent-weibo',
	'trello'              => 'fa-trello',
	'tumblr'              => 'fa-tumblr',
	'tumblr_square'       => 'fa-tumblr-square',
	'twitter'             => 'fa-twitter',
	'twitter_square'      => 'fa-twitter-square',
	'vimeo_square'        => 'fa-vimeo-square',
	'vine'                => 'fa-vine',
	'vK'                  => 'fa-vk',
	'weibo'               => 'fa-weibo',
	'weixin'              => 'fa-weixin',
	'windows'             => 'fa-windows',
	'wordPress'           => 'fa-wordpress',
	'xing'                => 'fa-xing',
	'xing_square'         => 'fa-xing-square',
	'yahoo'               => 'fa-yahoo',
	'yelp'                => 'fa-yelp',
	'youTube'             => 'fa-youtube',
	'youTube_play'        => 'fa-youtube-play',
	'youTube_square'      => 'fa-youtube-square',
);
provide_ThemeInit::provide_singleton()->provide_storeSetting( $socialProfiler, 'socialProfiler' );

function provide_CEM( $excerpt ) {
	return str_replace( '[&hellip;]', '...', $excerpt );
}

add_filter( 'the_excerpt', 'provide_CEM' );
add_filter( 'get_the_excerpt', 'provide_CEM' );
