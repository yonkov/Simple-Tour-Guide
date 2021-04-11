<form class="stg-form" method="post" action="options.php">
	<?php settings_fields( 'simple_tour_guide_color_fields' ); ?>
	<?php $btn_bgr_color = get_option( 'stg_btn_color', '#3288e6' ); ?>
	<h3><?php _e( 'Button background color', 'simple-tour-guide' ); ?></h3>
	<p><?php _e( 'Change the background color of the back, next and finish step buttons to match the look and feel of your theme.', 'simple-tour-guide' ); ?></p>
	<input type="text" name="stg_btn_color" value="<?php echo esc_attr($btn_bgr_color)?>" class="my-color-field" data-default-color="#3288e6" />
	<p> <?php _e( 'For further customizations, you can assign additional css class for a specific step from "Create a Tour" tab. Then, add custom css in the theme customizer (Appearance=> Customize=>Additional Css).', 'simple-tour-guide' ); ?></p>
	<?php submit_button(); ?>
</form>