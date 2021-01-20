<?php
/*
Plugin Name: Social profile plugin
Description: Welcome to WordPress plugin development.
Plugin URI:  https://github.com/SagunNakarmiJCU/Assignment3CMS
Author:      Sagun Nakarmi
Version:     1.3
License:     GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/

*/

/* exist if directly accessed */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HD_ESPW_LOCATION', dirname( __FILE__ ) );
define( 'HD_ESPW_LOCATION_URL', plugins_url( '', __FILE__ ) );

/**
 * Get the registered social profiles.
 *
 * @return array An array of registered social profiles.
 */
function hd_espw_get_social_profiles() {

	return apply_filters(
		'hd_espw_social_profiles',
		array()
	);

}

/**
 * Registers the default social profiles.
 *
 * @param  array $profiles An array of the current registered social profiles.
 * @return array           The modified array of social profiles.
 */
function register_default_social_profiles( $profiles ) {

	$profiles['facebook'] = array(
		'id'                => 'hd_espw_facebook_url',
		'label'             => __( 'Facebook ', 'social-media-profiles' ),
		'class'             => 'facebook',
		'description'       => __( 'Enter your Facebook profile URL', 'social-media-profiles' ),
		'priority'          => 10,
		'type'              => 'text',
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	);


	$profiles['linkedin'] = array(
		'id'                => 'hd_espw_linkedin_url',
		'label'             => __( 'LinkedIn ', 'social-media-profiles' ),
		'class'             => 'linkedin',
		'description'       => __( 'Enter your LinkedIn profile URL', 'social-media-profiles' ),
		'priority'          => 20,
		'type'              => 'text',
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	);


	$profiles['twitter'] = array(
		'id'                => 'hd_espw_twitter_url',
		'label'             => __( 'Twitter', 'social-media-profiles' ),
		'class'             => 'twitter',
		'description'       => __( 'Enter your Twitter profile URL', 'social-media-profiles' ),
		'priority'          => 40,
		'type'              => 'text',
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	);


	$profiles['youtube'] = array(
		'id'                => 'hd_espw_youtube_url',
		'label'             => __( 'Youtube', 'social-media-profiles' ),
		'class'             => 'youtube',
		'description'       => __( 'Enter your youtube profile URL', 'social-media-profiles' ),
		'priority'          => 40,
		'type'              => 'text',
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	);

	$profiles['instagram'] = array(
 		'id'                => 'hd_espw_instagram_url',
		'label'             => __( 'Instagram 	', 'social-media-profiles' ),
		'class'             => 'instagram',
		'description'       => __( 'Enter your Instagram profile URL', 'social-media-profiles' ),
		'priority'          => 40,
		'type'              => 'text',
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	);

	return $profiles;

}

add_filter( 'hd_espw_social_profiles', 'register_default_social_profiles', 10, 1 );

/**
 * Registers the social profiles with the customizer in WordPress.
 *
 * @param  WP_Customizer $wp_customize The customizer object.
 */
function register_social_customizer_settings( $wp_customize ) {


	$social_profiles = hd_espw_get_social_profiles();


	if ( ! empty( $social_profiles ) ) {

	
		$wp_customize->add_section(
			'hd_espw_social',
			array(
				'title'          => __( 'Social Profiles' ),
				'description'    => __( 'Add social media profiles here.' ),
				'priority'       => 160,
				'capability'     => 'edit_theme_options',
			)
		);

		
		foreach ( $social_profiles as $social_profile ) {

			
			$wp_customize->add_setting(
				$social_profile['id'],
				array(
					'default'           => '',
					'sanitize_callback' => $social_profile['sanitize_callback'],
				)
			);

			$wp_customize->add_control(
				$social_profile['id'],
				array(
					'type'        => $social_profile['type'],
					'priority'    => $social_profile['priority'],
					'section'     => 'hd_espw_social',
					'label'       => $social_profile['label'],
					'description' => $social_profile['description'],
				)
			);

		}

	}

}

add_action( 'customize_register', 'register_social_customizer_settings' );

/**
 * Register the social icons widget with WordPress.
 */
function hd_espw_register_social_icons_widget() {
	register_widget( 'HD_ESPW_Social_Icons_Widget' );
}

add_action( 'widgets_init', 'hd_espw_register_social_icons_widget' );

/**
 * Extend the widgets class for our new social icons widget.
 */
class HD_ESPW_Social_Icons_Widget extends WP_Widget {

	/**
	 * Setup the widget.
	 */
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname'   => 'hd-espw-social-icons',
			'description' => __( 'Output your sites social icons, based on the social profiles added to the cutomizer.', 'social-media-profiles' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'hd_espw_social_icons',
		);

		/* Create the widget. */
		parent::__construct( 'hd_espw_social_icons', 'Social Icons', $widget_ops, $control_ops );
	
	}

	/**
	 * Output the widget front-end.
	 */
	public function widget( $args, $instance ) {

		// output the before widget content.
		echo wp_kses_post( $args['before_widget'] );

		/**
		 * Call an action which outputs the widget.
		 *
		 * @param $args is an array of the widget arguments e.g. before_widget.
		 * @param $instance is an array of the widget instances.
		 *
		 * @hooked hd_espw_social_icons_output_widget_title.- 10
		 * @hooked hd_espw_output_social_icons_widget_content - 20
		 */
		do_action( 'hd_espw_social_icons_widget_output', $args, $instance );

		// output the after widget content.
		echo wp_kses_post( $args['after_widget'] );

	}

	/**
	 * Output the backend widget form.
	 */
	public function form( $instance ) {

		// get the saved title.
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'social-media-profiles' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<?php
			printf(
				__( 'To add social profiles, please use the social profile section in the %1$scustomizer%2$s.', 'social-media-profiles' ),
				'<a href="' . admin_url( 'customize.php' ) . '">',
				'</a>'
			);
			?>

		</p>

		<?php

	}

	/**
	 * Controls the save function when the widget updates.
	 *
	 * @param  array $new_instance The newly saved widget instance.
	 * @param  array $old_instance The old widget instance.
	 * @return array               The new instance to update.
	 */
	public function update( $new_instance, $old_instance ) {

		// create an empty array to store new values in.
		$instance = array();

		// add the title to the array, stripping empty tags along the way.
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		// return the instance array to be saved.
		return $instance;

	}

}

/**
 * Outputs the widget title for the social icons widget.
 *
 * @param  array $args     An array of widget args.
 * @param  array $instance The current instance of widget data.
 */
function hd_espw_social_icons_output_widget_title( $args, $instance ) {

	// if we have before widget content.
	if ( ! empty( $instance['title'] ) ) {

	
		if ( ! empty( $args['before_title'] ) ) {

	
			echo wp_kses_post( $args['before_title'] );

		}

	
		echo esc_html( $instance['title'] );


		if ( ! empty( $args['after_title'] ) ) {

			echo wp_kses_post( $args['after_title'] );

		}
	}

}

add_action( 'hd_espw_social_icons_widget_output', 'hd_espw_social_icons_output_widget_title', 10, 2 );

/**
 * Outputs the widget content for the social icons widget - the actual icons and links.
 *
 * @param  array $args     An array of widget args.
 * @param  array $instance The current instance of widget data.
 */
function hd_espw_output_social_icons_widget_content( $args, $instance ) {

	// get the array of social profiles.
	$social_profiles = hd_espw_get_social_profiles();


	if ( ! empty( $social_profiles ) ) {

		?>
		<ul class="hd-espw-social-icons">
		<?php


		foreach ( $social_profiles as $social_profile ) {

	
			$profile_url = get_theme_mod( $social_profile['id'] );

		
			if ( empty( $profile_url ) ) {
				continue; // continue to the next social profile.
			}

	
			if ( empty ( $social_profile['class'] ) ) {

	
				$social_profile['class'] = strtolower( sanitize_title_with_dashes( $social_profile['label'] ) );

			}

		
			?>

			<li class="hd-espw-social-icons__item hd-espw-social-icons__item--<?php echo esc_attr( $social_profile['class'] ); ?>">
				<a target="_blank" class="hd-espw-social-icons__item-link" href="<?php echo esc_url( $profile_url ); ?>">
					<i class="icon-<?php echo esc_attr( $social_profile['class'] ); ?>"></i> <span><?php echo esc_html( $social_profile['label'] ); ?></span>
				</a>
			</li>

			<?php

		}

		// end the output markup.
		?>
		</ul>
		<?php

	}

}

add_action( 'hd_espw_social_icons_widget_output', 'hd_espw_output_social_icons_widget_content', 20, 2 );