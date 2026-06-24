<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="stg-upsell-banner">
	<h3 class="header-text"><?php esc_html_e( 'Adding more tours is a PRO Feature', 'simple-tour-guide-pro' ); ?></h3>
	
	<p class="description"><?php esc_html_e( 'Unlock the power of Simple Tour Guide Pro:', 'simple-tour-guide-pro' ); ?></p>
	
	<ul class="stg-feature-list">
		<li>
			<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM10 14.17L16.59 7.58L18 9L10 17L6 13L7.41 11.59L10 14.17Z" fill="currentColor"></path>
			</svg> <?php esc_html_e( 'Unlimited Tours', 'simple-tour-guide-pro' ); ?>
		</li>
		<li>
			<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM10 14.17L16.59 7.58L18 9L10 17L6 13L7.41 11.59L10 14.17Z" fill="currentColor"></path>
			</svg> <?php esc_html_e( 'Unlimited Steps', 'simple-tour-guide-pro' ); ?>
		</li>
		<li>
			<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM10 14.17L16.59 7.58L18 9L10 17L6 13L7.41 11.59L10 14.17Z" fill="currentColor"></path>
			</svg> <?php esc_html_e( 'Assign tour to a specific page', 'simple-tour-guide-pro' ); ?>
		</li>
		<li>
			<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM10 14.17L16.59 7.58L18 9L10 17L6 13L7.41 11.59L10 14.17Z" fill="currentColor"></path>
			</svg> <?php esc_html_e( 'Start a tour based on user interaction', 'simple-tour-guide-pro' ); ?>
		</li>
		<li>
			<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM10 14.17L16.59 7.58L18 9L10 17L6 13L7.41 11.59L10 14.17Z" fill="currentColor"></path>
			</svg> <?php esc_html_e( 'Additional Tour Options', 'simple-tour-guide-pro' ); ?>
		</li>
		<li>
			<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM10 14.17L16.59 7.58L18 9L10 17L6 13L7.41 11.59L10 14.17Z" fill="currentColor"></path>
			</svg> <?php esc_html_e( 'Additional Styling Options', 'simple-tour-guide-pro' ); ?>
		</li>
	</ul>
	<div class="actions">
		<a href="<?php echo esc_url(SIMPLE_TOUR_GUIDE_HOMEPAGE_URL)?>" target="_blank"><?php esc_html_e( 'Unlock Unlimited Tours', 'simple-tour-guide-pro' ); ?></a>
		<a href="<?php echo esc_url(SIMPLE_TOUR_GUIDE_PREMIUM_OPTIONS_URL)?>" target="_blank" class="learn-more"><?php esc_html_e( 'Compare Free vs Pro', 'simple-tour-guide-pro' ); ?></a>
	</div>
</div>
