<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
$h          = new provide_Helper();
$opt        = $h->provide_opt();
$bg         = $h->provide_set( $opt, 'optComingSoonBG' );
$title      = $h->provide_set( $opt, 'optComingSoonTitle' );
$date       = $h->provide_set( $opt, 'optComingSoonDate' );
$timezone   = ( $h->provide_set( $opt, 'optComingSoonTimeZone' ) ) ? $h->provide_set( $opt, 'optComingSoonTimeZone' ) : '|||0';
$newsLetter = $h->provide_set( $opt, 'optComingSoonNewsletter' );
?>
<div class="commingsoon" style="background-image: url(<?php echo esc_url( $h->provide_set( $bg, 'url' ) ) ?>)">
	<div class="soon-all">
		<div class="container">
			<?php if ( ! empty( $title ) ): ?>
				<div class="logo">
					<a href="javascript:void(0)" title=""><i class="fa fa-bullseye"></i> <?php echo esc_html( $title ) ?></a>
				</div>
			<?php endif; ?>
			<div class="countdown-sec">
				<ul class="countdown">
					<li><span class="days">00</span>
						<p class="days_ref">days</p></li>
					<li><span class="hours">00</span>
						<p class="hours_ref">hours</p></li>
					<li><span class="minutes">00</span>
						<p class="minutes_ref">minutes</p></li>
					<li><span class="seconds">00</span>
						<p class="seconds_ref">seconds</p></li>
				</ul>
			</div><!-- Timer -->
			<div class="fancy-social">
				<span>Contact with us</span>
				<a href="javascript:void(0)" title=""><i class="fa fa-facebook"></i></a>
				<a href="javascript:void(0)" title=""><i class="fa fa-google-plus"></i></a>
				<a href="javascript:void(0)" title=""><i class="fa fa-twitter"></i></a>
				<a href="javascript:void(0)" title=""><i class="fa fa-reddit"></i></a>
				<a href="javascript:void(0)" title=""><i class="fa fa-pinterest"></i></a>
			</div><!-- Fancy Social -->
			<?php if ( $newsLetter == '1' ): ?>
				<div class="log"></div>
				<form id="comingSoonNewsletter" class="subscribtion">
					<input id="newsletter_email" autocomplete="off" name="email" type="text" placeholder="<?php esc_html_e( 'Subscribe Your Email', 'provide' ) ?>">
					<button type="submit"><?php esc_html_e( 'Done', 'provide' ) ?></button>
				</form><!-- Form -->
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
if ( $h->provide_set( $date, 'timestamp' ) != '' ) {
	$timestemp = $h->provide_set( $date, 'timestamp' );
	$jsDate    = date( "m/d/Y h:i:s", strtotime( $h->provide_set( $date, 'date' ) ) );
	$getOffset = explode( '|||', $timezone, 2 );
	wp_enqueue_script( array( 'jquery', 'provide-downCount' ) );
	$count_down_script = 'jQuery(document).ready(function ($) {
                    var date = "' . esc_js( $jsDate ) . '";
                    jQuery(".countdown").downCount({
                        date: date,
                        offset: ' . esc_js( str_replace( ':00', '', $h->provide_set( $getOffset, '1' ) ) ) . '
                    });
                });';

	wp_add_inline_script( 'provide-downCount', $count_down_script );
}
?>
<?php wp_footer(); ?>
</body>
</html>
