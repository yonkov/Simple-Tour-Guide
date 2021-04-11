<?php
/*
 * Plugin Name: Simple Tour Guide
 * Plugin URI: https://github.com/yonkov/Post-Order-By-Category
 * Description: Simple Tour Guide is a lightweight step-by-step user guide based on Shepherd.js that provides an easy way to indroduce users to your product or service - by guiding them visually to different elements on your app. Create, edit or delete steps directly from the WordPress admin and show them to your visitors to boost user experience.
 * Version: 1.0.0
 * Author: Atanas Yonkov
 * Author URI: https://yonkov.github.io/
 * Tags: walktrough, product tour, guided tour
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

/**
 * Enqueue scripts and styles.
 */
function simple_tour_guide_scripts_and_styles() {
	// Shepherd scripts and styles
	wp_enqueue_style( 'shepherd', plugin_dir_url( __FILE__ ) . 'assets/lib/shepherd.min.css', '8.2.3' );
	wp_enqueue_script( 'shepherd', plugin_dir_url( __FILE__ ) . 'assets/lib/shepherd.js', array(), '8.2.3', true );
	// Plugin options script
	if ( version_compare( $GLOBALS['wp_version'], '5.0-alpha', '>=' ) ) {
		wp_enqueue_script( 'simple-tour-guide', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array( 'wp-i18n' ), '1.0.0', true );
	} else { // Fallback for wp < 5.0
		wp_enqueue_script( 'simple-tour-guide', plugin_dir_url( __FILE__ ) . 'assets/js/fallback-main.js', array(), '1.0.0', true );
	}
	// pass plugin options
	global $post;
	$script_params = array(
		'counter'       => simple_tour_guide_get_steps_count(),
		'tour_object'   => simple_tour_guide_get_escaped_tour_object_input(),
		'tour_settings' => simple_tour_guide_get_escaped_tour_settings_input(),
		'is_admin'      => is_admin(),
		'has_tour'      => has_shortcode( $post->post_content, 'stg_kef' ),
	);
	wp_localize_script( 'simple-tour-guide', 'scriptParams', $script_params );
}
add_action( 'wp_enqueue_scripts', 'simple_tour_guide_scripts_and_styles' );

/**
 * Enqueue admin scripts and styles.
 */
function simple_tour_guide_admin_scripts_and_styles() {
	// Plugin settings page script
	wp_enqueue_script( 'simple-tour-guide-admin-handle', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', array( 'jquery' ), '1.0.0', true );
	$script_params = array(
		'counter' => simple_tour_guide_get_steps_count(),
	);
	wp_localize_script( 'simple-tour-guide-admin-handle', 'scriptParams', $script_params );
	// Plugin settings page style
	wp_enqueue_style( 'simple-tour-guide-admin-style', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', '1.0.0' );
	// Iris Color picker
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
		<h2><?php _e( 'Simple Tour Guide Options', 'simple-tour-guide' ); ?></h2>

		<?php
		// Get the active tab from the $_GET param
		$default_tab = 'create_tour';
		$active_tab  = isset( $_GET['tab'] ) ? $_GET['tab'] : $default_tab;

		if ( isset( $_GET['tab'] ) ) {
			$active_tab = $_GET['tab'];
		}
		?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=simple_tour_guide&tab=create_tour"
				class="nav-tab <?php echo $active_tab == 'create_tour' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Create a Tour', 'simple-tour-guide' ); ?></a>
			<a href="?page=simple_tour_guide&tab=tour_options"
				class="nav-tab <?php echo $active_tab == 'tour_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Tour Options', 'simple-tour-guide' ); ?></a>
			<a href="?page=simple_tour_guide&tab=style"
				class="nav-tab <?php echo $active_tab == 'style' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Style', 'simple-tour-guide' ); ?></a>
			<a href="?page=simple_tour_guide&tab=faq"
				class="nav-tab <?php echo $active_tab == 'style' ? 'nav-tab-active' : ''; ?>"><?php _e( 'FAQ', 'simple-tour-guide' ); ?></a>
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

/*
 * Save Tour Steps in an array of steps
 *
 */
function simple_tour_guide_setup_sections() {
	$steps         = simple_tour_guide_get_steps_count();
	$options       = array();
	$btn_bgr_color = esc_attr( get_option( 'stg_btn_color', '#3288e6' ) );
	for ( $step = 1; $step <= $steps; $step++ ) {

		$title       = 'title_' . $step;
		$description = 'description_' . $step;
		$location    = 'location_' . $step;
		$classname   = 'classname_' . $step;

		$tour_step = array(
			$title       => __( 'Welcome Aboard!', 'simple-tour-guide' ),
			$description => __( "Thank you for using Simple Tour Guide plugin. To customize this tour and add more steps, go to the plugin's settings page.", 'simple-tour-guide' ),
			$location    => '',
			$classname   => '.my-awesome-class',
		);

		$tour_options = array_merge( $options, $tour_step );

	}

	add_option( 'stg_tour', $tour_options ); // default tour
	register_setting( 'simple_tour_guide_fields', 'stg_tour' );

	$general_options = array(
		'show_intro'        => true,
		'show_confirmation' => '',
		'show_on_all_pages' => true,
	);
	add_option( 'stg_settings', $general_options ); // default settings
	register_setting( 'simple_tour_guide_additional_fields', 'stg_settings' );

	add_option( 'stg_btn_color', $btn_bgr_color );
	register_setting(
		'simple_tour_guide_color_fields',
		'stg_btn_color',
		'sanitize_hex_color'
	);
}

add_action( 'admin_init', 'simple_tour_guide_setup_sections' );

/**
 * Increment Steps and store step counter in the database
 */
function simple_tour_guide_increment_counter() {
	// Name of the option
	$option_name = 'stg_steps';
	// Check if the option is set already
	if ( get_option( $option_name ) !== false ) {
		$new_value = intval( get_option( $option_name ) ) + 1;
		// The option already exists, so update it.
		update_option( $option_name, absint( $new_value ) );
	} else {
		// The option hasn't been created yet, so add it with $autoload set to 'no'.
		$deprecated = null;
		$autoload   = 'no';
		add_option( $option_name, 2, $deprecated, $autoload );
	}
}

add_action( 'wp_ajax_increment_counter', 'simple_tour_guide_increment_counter' );
add_action( 'wp_ajax_nopriv_increment_counter', 'simple_tour_guide_increment_counter' );

function simple_tour_guide_decrement_counter() {
	delete_option( 'stg_title_' . esc_attr( get_option( 'stg_steps' ) ) );
	delete_option( 'stg_description_' . esc_attr( get_option( 'stg_steps' ) ) );
	delete_option( 'stg_location_' . esc_attr( get_option( 'stg_steps' ) ) );
	delete_option( 'stg_classname_' . esc_attr( get_option( 'stg_steps' ) ) );
	// Name of the option
	$option_name = 'stg_steps';
	// Decrement the option if is set and bigger that one
	if ( get_option( $option_name ) !== false && get_option( $option_name ) > 1 ) {
		$new_value = intval( get_option( $option_name ) ) - 1;
		// The option already exists, so update it.
		update_option( $option_name, absint( $new_value ) );
	}

}

add_action( 'wp_ajax_decrement_counter', 'simple_tour_guide_decrement_counter' );
add_action( 'wp_ajax_nopriv_decrement_counter', 'simple_tour_guide_decrement_counter' );

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
	if ( ! empty( $tour_object ) ) {
		return array_map( 'esc_attr', $tour_object );
	}
}

/**
 * Get the tour general settings. Escape db output
 *
 * @link https://wordpress.stackexchange.com/questions/284023/how-to-escape-multiple-attribute-at-once-in-wordpress
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
 * Add color styling from the plugin
 */
function simple_tour_guide_custom_styles() {
	$btn_bgr_color = get_option( 'stg_btn_color', '#3288e6' );
	if ( ! empty( $btn_bgr_color ) ) :
		?>
		 <style>
		.shepherd-button{
			background-color: <?php echo esc_attr( $btn_bgr_color ); ?> !important;
		}
		 </style>
		<?php
	endif;
}
add_action( 'wp_head', 'simple_tour_guide_custom_styles' );

/**
 *
 * shim for wordpress < 4.6
 * hex color sanitization function
 *
 * @link https://developer.wordpress.org/reference/functions/sanitize_hex_color
 */

if ( ! function_exists( 'sanitize_hex_color' ) ) {
	function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}
		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}
	}
}
