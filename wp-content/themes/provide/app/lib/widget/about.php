<?php

class provide_about_Widget extends WP_Widget {
	public $h;

	public function __construct() {
		$this->h     = new provide_Helper();
		$widget_ops  = array(
			'description' => esc_html__( 'This widget is used to show about us.', 'provide' )
		);
		$control_ops = array(
			'width'   => 250,
			'height'  => 350,
			'id_base' => 'provide-about'
		);
		parent::__construct( 'provide-about', esc_html__( 'Footer About - Provide', 'provide' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		$h   = new provide_Helper;
		$opt = $h->provide_opt();
		extract( $args );
		$defaults = array( 'logo' => '', 'desc' => '', 'address' => '', 'contact' => '', 'email' => '', 'social_icons' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		echo wp_kses( $before_widget, true );
		$address = $this->h->provide_set( $instance, 'address' );
		$contact = $this->h->provide_set( $instance, 'contact' );
		$email   = $this->h->provide_set( $instance, 'email' );
		?>
        <div class="about-widget">
			<?php if ( $this->h->provide_set( $instance, 'logo' ) != '' ): ?>
                <a class="widget-logo" href="<?php echo esc_url( home_url( '/' ) ) ?>" title="">
                    <img src="<?php echo esc_url( $this->h->provide_set( $instance, 'logo' ) ) ?>" alt=""/>
                </a>
			<?php endif; ?>
			<?php if ( $this->h->provide_set( $instance, 'desc' ) != '' ): ?>
                <p><?php echo esc_html( $this->h->provide_set( $instance, 'desc' ) ) ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $address ) || ! empty( $contact ) || ! empty( $email ) ): ?>
                <ul>
					<?php if ( ! empty( $address ) ): ?>
                        <li><i class="fa fa-map-marker"></i> <?php echo esc_html( $address ) ?></li>
					<?php endif; ?>
					<?php if ( ! empty( $contact ) ): ?>
                        <li><i class="fa fa-phone"></i> <?php echo esc_html( $contact ) ?></li>
					<?php endif; ?>
					<?php if ( ! empty( $email ) ): ?>
                        <li><i class="fa fa-envelope"></i> <?php echo esc_html( $email ) ?></li>
					<?php endif; ?>
                </ul>
			<?php endif; ?>
			<?php
			if ( $h->provide_set( $instance, 'social_icons' ) == 'true' ):
				$social = $h->provide_set( $opt, 'optFooterSocialicons' );
				?>
                <div class="dark-socials">
					<?php
					if ( ! empty( $social ) && count( $social ) > 0 ):
						foreach ( $social as $s ):
							$data = json_decode( urldecode( $h->provide_set( $s, 'data' ) ) );
							if ( $data->enable == 'true' ):
								?>
                                <a href="<?php echo esc_url( $data->url ) ?>">
                                    <i class="fa <?php echo esc_attr( $data->icon ) ?>"></i>
                                </a>
								<?php
							endif;
						endforeach;
					endif;
					?>
                </div>
			<?php endif; ?>
        </div>
		<?php
		echo wp_kses( $after_widget, true );
	}

	/* Store */
	public function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['logo']         = $new_instance['logo'];
		$instance['desc']         = $new_instance['desc'];
		$instance['address']      = $new_instance['address'];
		$instance['contact']      = $new_instance['contact'];
		$instance['email']        = $new_instance['email'];
		$instance['social_icons'] = $new_instance['social_icons'];

		return $instance;
	}

	/* Settings */

	public function form( $instance ) {
		$defaults = array( 'logo' => '', 'desc' => '', 'address' => '', 'contact' => '', 'email' => '', 'social_icons' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$options  = array( 'true' => esc_html__( 'True', 'provide' ), 'false' => esc_html__( 'False', 'provide' ) );
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'logo' ) ); ?>"><?php esc_html_e( 'Logo', 'provide' ); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'logo' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'logo' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $instance['logo'] ); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>"><?php esc_html_e( 'Short Description', 'provide' ); ?>:</label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'desc' ) ); ?>"><?php echo esc_attr( $instance['desc'] ); ?></textarea>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Address', 'provide' ); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $instance['address'] ); ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'provide' ); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'contact' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'contact' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $instance['contact'] ); ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email', 'provide' ); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $instance['email'] ); ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'social_icons' ) ); ?>"><?php esc_html_e( 'Social Icons', 'provide' ); ?>:</label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_icons' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'social_icons' ) ); ?>">
				<?php
				if ( ! empty( $options ) && count( $options ) > 0 ) {

					foreach ( $options as $key => $val ) {
						if ( ! empty( $instance['social_icons'] ) ) {
							$selected = ( $key == $instance['social_icons'] ) ? 'selected="selected"' : '';
						} else {
							$selected = '';
						}
						echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
					}
				}
				?>

            </select>
        </p>
		<?php
	}

}
