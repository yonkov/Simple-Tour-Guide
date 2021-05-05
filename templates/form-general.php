<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form class="stg-form" method="post" action="options.php">
	<?php settings_fields( 'simple_tour_guide_additional_fields' ); ?>
	<?php $options = get_option( 'stg_settings' ); ?>
	<h3><?php _e( 'Tour Options', 'simple-tour-guide' ); ?></h3>
	<p><?php _e( 'The below settings apply for the whole tour. You can choose to display the tour until the user has completed or dismissed it or to display it on every page reload (ideal for testing purposes). You can also confirm tour cancellation when the user clicks the close button and display the tour only on specific pages.', 'simple-tour-guide' ); ?></p>
	<input name="stg_settings[show_intro]" type="checkbox" value="true" <?php checked( 'true', isset( $options['show_intro'] ) ? 'true' : '', true ); ?> />
	<label for="stg_settings[show_intro]"><?php _e('Show the tour only once. Hide it after the user finishes or dismisses it.', 'simple-tour-guide' ); ?></label>
	<br>
	<input name="stg_settings[show_confirmation]" type="hidden" value=""<?php checked( 'true', $options['show_confirmation'],  true ); ?> />
	<input name="stg_settings[show_confirmation]" type="checkbox" value="true" <?php checked( 'true', $options['show_confirmation'],  true ); ?> />
	<label for="stg_settings[show_confirmation]"><?php _e('Ask for confirmation when the user clicks the close button.', 'simple-tour-guide')?></label>
	<br>
	<input name="stg_settings[show_user_logged_in]" type="hidden" value=""<?php checked( 'true', isset ($options['show_user_logged_in']) ? $options['show_user_logged_in'] : '' ,  true ); ?> />
	<input name="stg_settings[show_user_logged_in]" type="checkbox" value="true" <?php checked( 'true', isset ($options['show_user_logged_in']) ? $options['show_user_logged_in'] : '',  true ); ?> />
	<label for="stg_settings[show_user_logged_in]"><?php _e('Show the tour to logged in users only', 'simple-tour-guide')?></label>
	<br>
	<input name="stg_settings[show_modal]" type="checkbox" value="true" <?php checked( 'true', isset ($options['show_modal']) ? $options['show_modal'] : '',  true ); ?> />
	<label for="stg_settings[show_modal]"><?php _e('Show modal background overlay when the tour is active.', 'simple-tour-guide')?></label>
	<br>
	<input name="stg_settings[show_progress]" type="checkbox" value="true" <?php checked( 'true', isset( $options['show_progress'] ) ? 'true' : '', true ); ?> />
	<label for="stg_settings[show_progress]"><?php _e('Show tour progress bar', 'simple-tour-guide')?></label>
	<br>
	<input name="stg_settings[show_on_all_pages]" type="checkbox" value="true" <?php checked( 'true', isset( $options['show_on_all_pages'] ) ? 'true' : '', true ); ?> />
	<label for="stg_settings[show_on_all_pages]"><?php _e('Show the tour on all pages.', 'simple-tour-guide')?></label>
	<p><?php _e('You can also use the shortcode ', 'simple-tour-guide')?><code>[stg_kef]</code><?php _e(' to display the tour only on a specific post or page. Uncheck the above option and copy paste the shortcode on top of the post or page you want it to appear.', 'simple-tour-guide')?></p>
	<?php submit_button(); ?>
</form>