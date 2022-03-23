<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form class="stg-form" method="post" action="options.php">
	<?php
	settings_fields( 'simple_tour_guide_fields' );
	$tour_options = get_option( 'stg_tour' );
	?>
	<h3><?php esc_html_e( 'Add a Tour', 'simple-tour-guide' ); ?></h3>
	<p><?php esc_html_e( 'Create a guided intro tour by adding steps to it here. Customize each step (you can add title, description, attach it to any dom element and additional css class) to guide your visitors throughout your project. They will appreciate it.', 'simple-tour-guide' ); ?></p>
	<table class="form-table stg-table">
		<?php
		for ( $step = 1; $step <= $steps; $step++ ) :
			?>
			<tbody class="step">
				<tr valign="top">
					<th scope="row"><label for="<?php echo esc_attr( 'stg_tour[title_' . $step . ']' ); ?>"><?php esc_html_e( 'Step Title', 'simple-tour-guide' ); ?><span class="required">*</span></label></th>
					<td><input type="text" required class="form-field" name="<?php echo esc_attr( 'stg_tour[title_' . $step . ']' ); ?>" value="<?php echo esc_attr( isset( $tour_options[ 'title_' . $step ] ) ? $tour_options[ 'title_' . $step ] : '' ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="<?php echo esc_attr( 'stg_tour[description_' . $step . ']' ); ?>"><?php esc_html_e( 'Step Description', 'simple-tour-guide' ); ?></label></th>
					<?php
					$content  = isset( $tour_options[ 'description_' . $step ] ) ? $tour_options[ 'description_' . $step ] : '';
					$settings = array(
						'textarea_name' => esc_attr( 'stg_tour[description_' . $step . ']' ),
						'editor_class'  => 'form-field',
						'wpautop'       => false,
						'textarea_rows' => 5,
					);
					if ( version_compare( $GLOBALS['wp_version'], '4.9', '>=' ) ) :
						?>
					<td><?php wp_editor( wp_kses_post( $content ), $step -1, $settings ); ?></td>
					<?php else : ?>
					<td><textarea class="form-field" name="<?php echo esc_attr( 'stg_tour[description_' . $step . ']' ); ?>" rows="5" cols="50"><?php echo esc_html( $content ); ?></textarea></td>
					<?php endif; ?>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="<?php echo esc_attr( 'stg_tour[location_' . $step . ']' ); ?>"><?php esc_html_e( 'Step Position', 'simple-tour-guide' ); ?></label></th>
					<td><input type="text" class="form-field" name="<?php echo esc_attr( 'stg_tour[location_' . $step . ']' ); ?>" placeholder="<?php esc_html_e( 'Link the step to a dom element, e.g. .entry-content', 'simple-tour-guide' ); ?>" value="<?php echo esc_attr( isset( $tour_options[ 'location_' . $step ] ) ? $tour_options[ 'location_' . $step ] : '' ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="<?php echo esc_attr( 'stg_tour[classname_' . $step . ']' ); ?>"><?php esc_html_e( 'Custom Css Class', 'simple-tour-guide' ); ?></label></th>
					<td><input type="text" class="form-field" name="<?php echo esc_attr( 'stg_tour[classname_' . $step . ']' ); ?>" placeholder="<?php esc_html_e( 'Add an optional css class to style the step, .e.g. my-awesome-class', 'simple-tour-guide' ); ?>" value="<?php echo esc_attr( isset( $tour_options[ 'classname_' . $step ] ) ? $tour_options[ 'classname_' . $step ] : '' ); ?>" /></td>
				</tr>
			</tbody>
		<?php endfor; ?>
		<tbody>
			<tr class="stg-buttons" valign="top">
				<th scope="row"><label for="stg_steps"><?php esc_html_e( 'Add or Remove Steps', 'simple-tour-guide' ); ?></label></th>
				<td><span class="dashicons dashicons-no"></span>
				<input type="button" id="stg_remove_steps" class="button-secondary" name="stg_remove_steps" value="<?php esc_html_e( 'Remove', 'simple-tour-guide' ); ?>">
				<span class="dashicons dashicons-yes-alt"></span>
				<input type="button" id="stg_steps" class="button-secondary" name="stg_steps" value="<?php esc_html_e( 'Add new', 'simple-tour-guide' ); ?>"></td>
			</tr>
		</tbody>
	</table>
	<?php submit_button(); ?>
</form>
