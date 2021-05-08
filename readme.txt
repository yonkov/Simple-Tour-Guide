=== Simple Tour Guide ===
Contributors: nravota12
Plugin Name: Simple Tour Guide
Plugin URI: https://github.com/yonkov/Simple-Tour-Guide
Tags: user-onboarding, tour, introduction, walkthrough, shepherd
Author URI: https://yonkov.github.io/
Author: Atanas Yonkov
Requires at least: 4.4
Requires PHP: 5.2.4
Tested up to: 5.7
Stable tag: 1.0.3
License: GPLv2

Easily add an interactive step-by-step user guide (intro tour) for your visitors. Based on Shepherd.js (https://shepherdjs.dev/).

== Description ==
Simple Tour Guide is an easy to use step-by-step onboarding user guide that lets you create an interactive guided tour for your visitors. 
The plugin provides a great, neat and fast way to indroduce users to your product or service - by guiding them visually to different elements on your website. 
An interactive user walkthrough is a powerful way to increase user experience and customer satisfaction. This plugin is based on Shepperd.js - an open-source lightweight vanilla js library for guided tours. 
Customize the text, the number of popups and link to any DOM element through a friendly user admin interface.

= Plugin Options =
You can create a tour and add as many steps to it as you want from "Create a Tour" tab. You can add step title, step description, link the step to a specific dom element and add a custom class to it. You can also choose to display the tour only once or show it everytime you reload a page (test mode) and ask for confirmation when the close button is clicked. Another cool feature is the ability to choose on which pages to display the tour. If you want, you can also choose to display the tour to logged in users only. You can also add a progress bar to show the users how many steps remain until the end of the tour and customize the colors of the step buttons and the progress bar via the "Style" tab.

== Installation ==
1. Take the easy route and install through the WordPress plugin installer or download the .zip file and upload the unzipped folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
= How to add, edit or delete steps? =
From the WordPress admin, go to Settings => Simple Tour Guide and add as many steps as you want.

= Can I link a step to a page element? =
Sure, you can! Inspect a page element with the browser dev tool (right click with the mouse => inspect element) and then add its selector in the "Step Position" field from "Create a Tour" tab. You can add class, id or tag selector like so: `.class`, `#id`, `tag`. If you do not assign a selector, that is also fine, the step will appear exactly in the middle of the screen.

= Can I show the tour only once? =
Absolutely! In fact, by default the plugin hides the tour when the user finishes or dismisses it. However, you can also choose to display the steps on every page reload (test mode) from the "Tour Options" tab.

= How to show the tour guide only on one page? =
Go to "Tour Options" tab, uncheck "Show the tour on all pages" box and copy the plugin shortcode `[stg_kef]`. Then, navigate to a page or post you want, click `"edit"` and paste the shortcode on the top of the post content.

= How to customize the style of the steps? =
Go to "Style" tab and customize accordingly. For additional customizations, you can use the `.stg` classname or add a custom class to each step from the "Create a Tour" tab. Go to `Аppearance => Customize => Additional css` and add your own custom styles there.

= Can I create more than one tour? =
The plugin currently supports only one tour, however you can add an additional tour. Check [Shepherd.js](https://shepherdjs.dev/docs/tutorial-02-usage.html) documentation on how to do it (you would need to add some custom code to make it work).

= Can I add a background overlay to disable the rest of the site while the tour is active?
Yes, this feature is available since version 1.03. All you need to do is check the option "Show modal background overlay when the tour is active" in the Tour options tab. This will disable any site interaction until the user has finished or dismissed the tour.
Please note that in some rare cases this might interfere with the site usability on mobile. If you need to remove the dark overlay on mobile, add the following css to Appearance => Customize => Additional css:

    @media(max-width:62em) {
        .shepherd-modal-overlay-container.shepherd-modal-is-visible {
            display: none;
        }
    }

In addition, in some extreme cases, you might also want to remove the whole tour on mobile and tablet like so:
    
    @media(max-width:62em) {
        .stg {
		    display: none;
	    }
    }

= Can I show the tour to logged in users only? =
Since version 1.02 you can! You can check the option "Show the tour to logged in users only" in the Tour Options tab.

= Can I run the tour inside the WP Admin? =
No, the scope of this plugin is the site frontend only.

== Changelog ==
= 1.0.3 =
* Adds option to show dark modal overlay to cover the site until the user has finished the tour.

= 1.0.2 =
* Adds option to show tour to logged in users only.

= 1.0.1 =
* Refactor and optimize decrement count steps function.  Hide the tour afrer the user finishes or dismisses it. Update css.

= 1.0.0 =
* First publicly available version of the plugin. Update css.

== Upgrade Notice ==
= 1.0.1 =
* Refactor and optimize decrement count steps function. 

= 1.0.0 =
Initial release.

== Screenshots ==

1. Plugin settings page: add steps
2. Plugin settings page: tour options
3. Plugin settings page: style options
4. Plugin frontend