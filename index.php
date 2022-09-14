<?php
/*
 * Plugin Name: Simple Tour Guide
 * Plugin URI: https://github.com/yonkov/Simple-Tour-Guide
 * Description: Simple Tour Guide is a lightweight step-by-step user guide based on Shepherd.js that provides an easy way to indroduce users to your product or service - by guiding them visually to different elements on your app. Create, edit or delete steps directly from the WordPress admin and show them to your visitors to boost user experience.
 * Version: 1.1.3
 * Author: Atanas Yonkov
 * Author URI: https://yonkov.github.io/
 * Tags: user-onboarding, tour, introduction, walkthrough, shepherd
 * License: GPL
 * Text Domain: simple-tour-guide
=====================================================================================
Copyright (C) 2021-present Atanas Yonkov
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with WordPress; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
=====================================================================================
*/

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Woof Woof Woof!' );
}

define( 'SIMPLE_TOUR_GUIDE_VERSION', '1.1.3' );

/**
 * Enqueue scripts and styles.
 */
function simple_tour_guide_scripts_and_styles() {
	// Shepherd scripts and styles
	wp_enqueue_style( 'shepherd', plugin_dir_url( __FILE__ ) . 'assets/lib/shepherd.min.css', '8.2.3' );
	wp_enqueue_script( 'shepherd', plugin_dir_url( __FILE__ ) . 'assets/lib/shepherd.min.js', array(), '8.2.3', true );
	// Plugin Options style
	wp_enqueue_style( 'simple-tour-guide', plugin_dir_url( __FILE__ ) . 'assets/css/main.css', array(), SIMPLE_TOUR_GUIDE_VERSION );
	// Plugin's main script for running the tour guide
		wp_enqueue_script( 'simple-tour-guide', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array(), SIMPLE_TOUR_GUIDE_VERSION, true );
	// pass plugin options
	global $post;
	$content       = isset( $post->post_content ) ? $post->post_content : '';
	$script_params = array(
		'counter'       => simple_tour_guide_get_steps_count(),
		'tour_object'   => simple_tour_guide_get_escaped_tour_object_input(),
		'tour_settings' => simple_tour_guide_get_escaped_tour_settings_input(),
		'is_admin'      => is_admin(),
		'is_logged_in'  => is_user_logged_in(),
		'has_tour'      => has_shortcode( $content, 'stg_kef' ),
		'strings'       => array(
			'close'  => __( 'Close', 'simple-tour-guide' ),
			'back'   => __( 'Back', 'simple-tour-guide' ),
			'next'   => __( 'Next', 'simple-tour-guide' ),
			'finish' => __( 'Finish', 'simple-tour-guide' ),
		),
	);
	wp_localize_script( 'simple-tour-guide', 'scriptParams', $script_params );
}
add_action( 'wp_enqueue_scripts', 'simple_tour_guide_scripts_and_styles' );

/**
 * Enqueue admin scripts and styles.
 */
function simple_tour_guide_admin_scripts_and_styles() {
	// Plugin settings page script
	wp_enqueue_script( 'simple-tour-guide-admin-handle', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', array( 'jquery' ), SIMPLE_TOUR_GUIDE_VERSION, true );
	$script_params = array(
		'counter'        => simple_tour_guide_get_steps_count(),
		'show_wp_editor' => simple_tour_guide_is_enqueue_editor(),
		'strings'        => array(
			'removeMessage' => __( 'Are you sure you want to delete this step?', 'simple-tour-guide' ),
		),
	);
	wp_localize_script( 'simple-tour-guide-admin-handle', 'scriptParams', $script_params );

	// Plugin settings page style
	wp_enqueue_style( 'simple-tour-guide-admin-style', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', array(), SIMPLE_TOUR_GUIDE_VERSION );
	// // WP editor
	if ( simple_tour_guide_is_enqueue_editor() ) {
		wp_enqueue_editor();
	}
	// Iris color picker
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'simple-tour-guide-color-picker', plugin_dir_url( __FILE__ ) . 'assets/js/color-picker.js', array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'simple_tour_guide_admin_scripts_and_styles' );

// Register plugin admin page under settings page
function simple_tour_guide_settings_page() {
	$page_title = __( 'Simple Tour Guide Options', 'simple-tour-guide' );
	$menu_title = __( 'Simple Tour Guide', 'simple-tour-guide' );
	$capability = 'manage_options';
	$slug       = 'simple_tour_guide';
	$callback   = 'simple_tour_guide_page_content_callback';
	$icon       = 'dashicons-admin-plugins';
	$position   = 100;

	add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback );
}
// Create admin tabs
function simple_tour_guide_page_content_callback() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// get the total number of "tour steps" from the database
	// the default value is 1
	$steps = simple_tour_guide_get_steps_count();
	?>
	<div class="wrap">
		<h2><?php esc_html_e( 'Simple Tour Guide Options', 'simple-tour-guide' ); ?></h2>

		<?php
		// Get the active tab from the $_GET param
		$default_tab = 'create_tour';
		$active_tab  = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : $default_tab; // // phpcs:ignore csrf ok, sanitization ok. 
		?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=simple_tour_guide&tab=create_tour"
				class="nav-tab <?php echo $active_tab == 'create_tour' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Create a Tour', 'simple-tour-guide' ); ?></a>
			<a href="?page=simple_tour_guide&tab=tour_options"
				class="nav-tab <?php echo $active_tab == 'tour_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Tour Options', 'simple-tour-guide' ); ?></a>
			<a href="?page=simple_tour_guide&tab=style"
				class="nav-tab <?php echo $active_tab == 'style' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Style', 'simple-tour-guide' ); ?></a>
			<a href="?page=simple_tour_guide&tab=faq"
				class="nav-tab <?php echo $active_tab == 'style' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'FAQ', 'simple-tour-guide' ); ?></a>
		</h2>

		<?php
		switch ( $active_tab ) :
			case 'create_tour':
				include_once plugin_dir_path( __FILE__ ) . 'templates/form-create.php';
				break;
			case 'tour_options':
				include_once plugin_dir_path( __FILE__ ) . 'templates/form-general.php';
				break;
			case 'style':
				include_once plugin_dir_path( __FILE__ ) . 'templates/form-color-picker.php';
				break;
			case 'faq':
				include_once plugin_dir_path( __FILE__ ) . 'templates/faq.php';
				break;
		endswitch;
		?>

	</div> 
	<?php
}

add_action( 'admin_menu', 'simple_tour_guide_settings_page' );

/**
 * Add Settings link in WordPress Plugins Page
 */

function simple_tour_guide_settings_link( array $links ) {
	$url           = get_admin_url() . 'options-general.php?page=simple_tour_guide';
	$settings_link = '<a href="' . esc_url( $url ) . '">' . __( 'Settings', 'simple-tour-guide' ) . '</a>';
	  $links[]     = $settings_link;
	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'simple_tour_guide_settings_link' );

/*
 * Save Tour Steps in an array of steps. Save tour settings and styles.
 *
 */
function simple_tour_guide_setup_sections() {
	$steps   = simple_tour_guide_get_steps_count();
	$options = array();
	$link    = get_admin_url() . 'options-general.php?page=simple_tour_guide';
	for ( $step = 1; $step <= $steps; $step++ ) {

		$title       = 'title_' . $step;
		$description = 'description_' . $step;
		$location    = 'location_' . $step;
		$classname   = 'classname_' . $step;

		$tour_step = array(
			$title       => __( 'Welcome Aboard!', 'simple-tour-guide' ),
			$description => __( 'Thank you for using Simple Tour Guide plugin. To customize this tour and add more steps, go to the', 'simple-tour-guide' ) . '<a href="' . esc_url( $link ) . '">' . __( ' plugin\'s settings page.', 'simple-tour-guide' ) . '</a>',
			$location    => '',
			$classname   => 'my-awesome-class',
		);

		$tour_options = array_merge( $options, $tour_step );

	}

	add_option( 'stg_tour', $tour_options ); // default tour
	register_setting( // save tour data
		'simple_tour_guide_fields',
		'stg_tour',
		'simple_tour_guide_sanitize' // sanitize input
	);

	$general_options = array(
		'show_intro'          => true,
		'show_confirmation'   => '',
		'show_modal'          => '',
		'show_wp_editor'      => '',
		'skip_step'           => '',
		'hide_mobile'         => '',
		'show_on_all_pages'   => true,
		'show_progress'       => true,
		'show_user_logged_in' => '',
	);
	add_option( 'stg_settings', $general_options ); // default settings



	register_setting( // save tour settings
		'simple_tour_guide_additional_fields',
		'stg_settings',
		'simple_tour_guide_sanitize' // sanitize input
	);

	$color_options = array(
		'btn_color'      => '#3288e6',
		'progress_color' => '#3288e6',
	);

	add_option( 'stg_colors', $color_options ); // default colors
	register_setting( // save colors
		'simple_tour_guide_color_fields',
		'stg_colors',
		'simple_tour_guide_sanitize' // sanitize colors
	);
}

add_action( 'init', 'simple_tour_guide_setup_sections' );

/**
 * Store step counter in the database
 */

function simple_tour_guide_save_counter() {
	// nonce check for an extra layer of security, the function will exit if it fails
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'stg_nonce' ) ) {
		exit( 'Woof Woof Woof' );
	}
	// get ajax data
	$counter = $_REQUEST['counter'];
	// Name of the option
	$option_name = 'stg_steps';
	// Check if the option is set already
	if ( get_option( $option_name ) !== false ) {
		// sanitize and update the option
		update_option( $option_name, absint( $counter ) );
	} else {
		// The option hasn't been created yet, so add it with $autoload set to 'no'.
		$deprecated = null;
		$autoload   = 'no';
		add_option( $option_name, 2, $deprecated, $autoload );
	}
	return $options;
}

add_action( 'wp_ajax_save_counter', 'simple_tour_guide_save_counter' );
add_action( 'wp_ajax_nopriv_save_counter', 'simple_tour_guide_save_counter' );

/**
 * Get the total number of "tour steps" from the database. Escape db output.
 * the default value is 1
 */
function simple_tour_guide_get_steps_count() {
	$steps = 1;
	if ( get_option( 'stg_steps' ) !== false ) {
		$steps = get_option( 'stg_steps' );
	}
	return esc_attr( intval( $steps ) );
}

/**
 * Get the tour object. Escape db output
 *
 * @link https://wordpress.stackexchange.com/questions/284023/how-to-escape-multiple-attribute-at-once-in-wordpress
 */
function simple_tour_guide_get_escaped_tour_object_input() {
	$tour_object = get_option( 'stg_tour' );
	// if ( ! empty( $tour_object ) ) {
	// return array_map( 'esc_attr', $tour_object );
	// }
	if ( ! empty( $tour_object ) ) {
		foreach ( $tour_object as $key => $value ) {
			if ( substr( $key, 0 ) !== 'description' ) {
				$tour_object[ $key ] == esc_attr( $tour_object[ $key ] );
			} else {
				$tour_object[ $key ] == wp_kses_post( $tour_object[ $key ] );
			}
		}
		return $tour_object;
	}
}

/**
 * Get the tour general settings. Escape db output
 */
function simple_tour_guide_get_escaped_tour_settings_input() {
	$tour_settings = get_option( 'stg_settings' );
	if ( ! empty( $tour_settings ) ) {
		return array_map( 'esc_attr', $tour_settings );
	}
}

/*
 * Register the `[stg_kef]` shortcode
 * Use it on a page where you want to show the tour
 */
function simple_tour_guide_demo_shortcode() {
	return;
}
add_shortcode( 'stg_kef', 'simple_tour_guide_demo_shortcode' );

/**
 * Sanitization callback
 */
function simple_tour_guide_sanitize( $options ) {
	$steps = simple_tour_guide_get_steps_count();

	// Checkboxes
	foreach ( $options as $option ) {
		if ( ! empty( $options[ $option ] ) ) {
			$options[ $option ] = true;
		} else {
			$options[ $option ] = false;
		}
	}

	// text input
	for ( $step = 1; $step <= $steps; $step++ ) {
		if ( ! empty( $options[ 'title_' . $step ] ) ) {
			$options[ 'title_' . $step ] = sanitize_text_field( $options[ 'title_' . $step ] );
		}
		if ( ! empty( $options[ 'description_' . $step ] ) ) {
			$options[ 'description_' . $step ] = wp_kses_post( $options[ 'description_' . $step ] );
		}
		if ( ! empty( $options[ 'location_' . $step ] ) ) {
			$options[ 'location_' . $step ] = sanitize_text_field( $options[ 'location_' . $step ] );
		}
		if ( ! empty( $options[ 'classname_' . $step ] ) ) {
			$options[ 'classname_' . $step ] = sanitize_text_field( $options[ 'classname_' . $step ] );
		}
	}
	// Colors
	if ( ! empty( $options['btn_color'] ) ) {
		$options['input_example'] = simple_tour_guide_sanitize_hex_color( $options['btn_color'] );
	}
	if ( ! empty( $options['progress_color'] ) ) {
		$options['progress_color'] = simple_tour_guide_sanitize_hex_color( $options['progress_color'] );
	}

	return $options;
}

/**
 * Add color styling from the plugin
 */
function simple_tour_guide_custom_styles() {
	$colors             = get_option( 'stg_colors' );
	$btn_bgr_color      = $colors['btn_color'];
	$progress_bar_color = $colors['progress_color'];
	if ( ! empty( $btn_bgr_color ) ) :
		?>
		 <style>
		.shepherd-button{
			background-color: <?php echo esc_attr( $btn_bgr_color ); ?> !important;
		}
		 </style>
		<?php
	endif;
	if ( ! empty( $progress_bar_color ) ) :
		?>
		 <style>
		.shepherd-progress-bar span{
			background-color: <?php echo esc_attr( $progress_bar_color ); ?>;
		}
		 </style>
		<?php
	endif;
}
add_action( 'wp_head', 'simple_tour_guide_custom_styles' );

/**
 *
 * shim for WordPress < 4.6
 * hex color sanitization function
 *
 * @link https://developer.wordpress.org/reference/functions/sanitize_hex_color
 */

if ( ! function_exists( 'simple_tour_guide_sanitize_hex_color' ) ) {
	function simple_tour_guide_sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}
		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}
	}
}

function simple_tour_guide_is_enqueue_editor() {
	return function_exists( 'wp_enqueue_editor' ) && ! empty( get_option( 'stg_settings' )['show_wp_editor'] ) ? 1 : 0;
}