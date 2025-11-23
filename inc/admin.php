<?php

function simple_tour_guide_call_to_action_markup() {

	global $current_user;
	$user_id         = $current_user->ID;

	if ( ! get_user_meta( $user_id, 'stg_bfcm_banner_hide_admin_notice' ) ) :
		?>
	<div id="message" class="notice notice-success nasiothemes-notice stg-notice">
		<a class="nasiothemes-message-close notice-dismiss" href="?stg_bfcm_banner_hide_admin_notice=0"></a>

		<div class="nasiothemes-message-content">
			<div class="nasiothemes-message-image">
				<a href="<?php echo esc_url( SIMPLE_TOUR_GUIDE_HOMEPAGE_URL ); ?>">
					<img class="nasiothemes-screenshot"
						src="<?php echo esc_url( plugin_dir_url( dirname(__FILE__) ) . 'assets/img/stg-logo.png' ); ?>"
						alt="<?php echo esc_attr__( 'Simple Tour Guide', 'simple-tour-guide' ); ?>"
					/>
				</a>
			</div>

			<div class="nasiothemes-message-text">
				<h2 class="nasiothemes-message-heading"><?php echo esc_html__( 'Get more with Simple Tour Guide Pro!', 'simple-tour-guide' ); ?> 🚀</h2> 
				<?php 
				echo '<p>';
					/* translators: %1$s is a line break, %2$s is a link */
					printf( __( 'Unlimited tours, start tour on link click, different tours based on user authentication,%1$smore options and premium support - %2$s.', 'simple-tour-guide' ), '<br>', '<a target="_blank" href="' . esc_url( SIMPLE_TOUR_GUIDE_HOMEPAGE_URL ) . '">' . esc_html__( 'Get started with Simple Tour Guide Pro', 'simple-tour-guide' ) . '</a>' );
				echo '</p>';

				// Bonus message
				echo '<div class="stg-bonus-message">';
				echo '<p class="nasiothemes-bonus-text"><span>🎁</span> <strong>' . esc_html__( 'BFCM crazy discount!', 'simple-tour-guide' ) . ' </strong> ';
				echo esc_html__( 'Very limited time offer! Upgrade to the Pro plan and', 'simple-tour-guide' ) . ' ';
				echo '<strong> ' . esc_html__( 'save 50% off!', 'simple-tour-guide' ) . ' </strong> ';
				printf('(' . esc_html__( 'use coupon code %s on checkout', 'simple-tour-guide' ) . '). Only between 28 November - 2 December!','<code>nasio50</code>' );
				echo '</p></div>';

				echo '<p class="notice-buttons"><a href="' . esc_url( SIMPLE_TOUR_GUIDE_HOMEPAGE_URL ) . '" target="_blank" rel="noopener" class="button button-primary nasiothemes-button"><span class="dashicons dashicons-cart"></span>';
				echo esc_html__( 'Upgrade to Pro', 'simple-tour-guide' );
				echo '</a>';
				echo ' <a href="' . esc_url( SIMPLE_TOUR_GUIDE_VIDEO_URL ) . '" target="_blank" rel="noopener" class="button button-youtube nasiothemes-button"><span class="dashicons dashicons-youtube"></span> ';
				echo esc_html__( 'Watch Video', 'simple-tour-guide' );
				echo '</a></p>';
				?>
			</div><!-- .nasiothemes-message-text -->
		</div><!-- .nasiothemes-message-content -->
	</div><!-- #message -->

	<?php endif;
}

add_action( 'admin_notices', 'simple_tour_guide_call_to_action_markup' );

function simple_tour_guide_dismiss_admin_notice() {
	global $current_user;
	$user_id = $current_user->ID;
	
	if ( isset( $_GET['stg_bfcm_banner_hide_admin_notice'] ) && '0' === $_GET['stg_bfcm_banner_hide_admin_notice'] ) {
		add_user_meta( $user_id, 'stg_bfcm_banner_hide_admin_notice', 'true', true );
	}
}
add_action( 'admin_init', 'simple_tour_guide_dismiss_admin_notice' );
