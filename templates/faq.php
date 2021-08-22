<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<h3><?php _e( 'Frequently Asked Questions', 'simple-tour-guide' ); ?></h3>
<h4><?php _e( '1. What are the options?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'You can create a tour and add as many steps to it as you want from "Create a Tour" tab. You can add step title, step description, link the step to a specific dom element and add a custom class to it. You can also choose to display the tour only once or show it everytime you reload a page (test mode) and ask for confirmation when the close button is clicked. Another cool feature is the ability to choose on which pages to display the tour. If you want, you can also choose to display the tour to logged in users only. You can also add a progress bar to show the users how many steps remain until the end of the tour and customize the colors of the step buttons and the progress bar via the "Style" tab.', 'simple-tour-guide' ); ?><p>
<h4><?php _e( '2. How to add steps?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'Go to "Create a Tour" tab and add as many steps as you want.', 'simple-tour-guide' ); ?><p>
<h4><?php _e( '3. Can I link a step to a page element?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'Sure you can! Inspect a page element with the browser dev tool (right click with the mouse => inspect element) and then add its selector in the "Step Position" field from "Create a Tour" tab. You can add class, id or tag selector like so: .class, #id, tag. If you do not assign a selector to the step, it will appear exactly in the middle of the screen.', 'simple-tour-guide' ); ?><p>
<h4><?php _e( '4. How to show the tour guide only on one page?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'Go to Tour Options tab, uncheck "Show the tour on all pages" box and copy the plugin shortcode. Then, navigate to a page or post you want, click "edit" and paste the shortcode on the top of the post content.', 'simple-tour-guide' ); ?></p>
<h4><?php _e( '5. How to customize the style of the steps?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'You can use the .stg classname or add a custom class to each step from the "Create a Tour tab". Go to appearance => customize => additional css and add your own custom styles there.', 'simple-tour-guide' ); ?><p>
<h4><?php _e( '6. Can I create more than one tour?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'The plugin currently supports only one tour, however you can add an additional tour. Check Shepherd.js documentation on how to do it, as well as the last question in this section (you would need to add some custom code).', 'simple-tour-guide' ); ?><p>
<h4><?php _e( '7. Can I add a background overlay to cover the site while the tour goes on?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'Yes, this feature is available since version 1.03. All you need to do is check the option "Show modal background overlay when the tour is active" in the Tour Options tab. This will disable any site interaction until the user has finished or dismissed the tour.', 'simple-tour-guide' ); ?><p>
<h4><?php _e( '8. Can I show the tour to logged in users only?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'Since version 1.02 you can! You can check the option "Show the tour to logged in users only" in the Tour Options tab.', 'simple-tour-guide' ); ?><p>
<h4><?php _e( '9. Can I run the tour inside the WP Admin?', 'simple-tour-guide' ); ?></h4>
<p><?php _e( 'No, the scope of this plugin is the site frontend.', 'simple-tour-guide' ); ?><p>
<h4><?php _e( "10. Can I customize the tour beyond the plugin's options?", "simple-tour-guide" ); ?></h4>
<p><?php printf( __("You can override the plugin's js file and enqueue your own. In this way, you will be able to use all the options provided by shepherd.js. Please check <a href=%s>plugin's documentation</a> on how to do it.", 'simple-tour-guide' ), 'https://wordpress.org/plugins/simple-tour-guide/#can%20i%20customize%20the%20tour%20beyond%20the%20existing%20options%3F' ); ?><p>