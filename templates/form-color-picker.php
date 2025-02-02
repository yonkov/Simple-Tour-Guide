<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<h3><?php esc_html_e( 'Styles', 'simple-tour-guide' ); ?></h3>
<form class="stg-form" method="post" action="options.php">
	<?php settings_fields( 'simple_tour_guide_color_fields' );
	$colors = get_option( 'stg_colors', array() ); ?>
	<?php printf( '<p><strong>' . esc_html__( 'More stylization options - %s', 'simple-tour-guide' ) . '</strong></p>','<a href="' . esc_url( SIMPLE_TOUR_GUIDE_HOMEPAGE_URL ) . '" target="_blank" rel="noopener">' . esc_html__( 'Upgrade to pro.', 'simple-tour-guide' ) . '</a>' ); ?>
	<h3><?php esc_html_e( 'Button background color', 'simple-tour-guide-pro' ); ?></h3>
	<p><?php esc_html_e( 'Change the background color of the back, next and finish step buttons to match the look and feel of your theme.', 'simple-tour-guide-pro' ); ?></p>
	<input type="text" name="stg_colors[btn_color]" value="<?php echo esc_attr( isset( $colors['btn_color'] ) ? $colors['btn_color'] : '#3288e6' ); ?>" class="my-color-field" data-default-color="#3288e6" />
	
	<h3><?php esc_html_e( 'Progress bar color', 'simple-tour-guide-pro' ); ?></h3>
	<p><?php esc_html_e( 'Change the progress bar color.', 'simple-tour-guide-pro' ); ?></p>
	<input type="text" name="stg_colors[progress_color]" value="<?php echo esc_attr( isset( $colors['progress_color'] ) ? $colors['progress_color'] : '#3288e6' ); ?>" class="my-color-field" data-default-color="#3288e6" />
	<p> <?php esc_html_e( 'For further customizations, you can assign additional css class for a specific step in Create a Tour => Custom Css Class. Then, add your custom css in the theme customizer (Appearance => Customize =>Additional Css).', 'simple-tour-guide-pro' ); ?></p>
	
	<?php submit_button(); ?>
</form>