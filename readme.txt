=== Simple Tour Guide ===
Contributors: nravota12
Plugin Name: Simple Tour Guide
Plugin URI: https://github.com/yonkov/Simple-Tour-Guide
Tags: walktrough, product tour, guided tour, shepherd
Author URI: https://yonkov.github.io/
Author: Atanas Yonkov
Requires at least: 4.4
Requires PHP: 5.2.4
Tested up to: 5.7
Stable tag: 1.0
License: GPLv2

Integration of Shepherd.js (https://shepherdjs.dev/) for WordPress.

== Description ==
Simple Tour Guide is a step-by-step user guide based on Shepherd.js that lets you create an interactive guided tour for your visitors. 
The plugin provides a great, neat and fast way to indroduce users to your product or service - by guiding them visually to different elements on your app. 
An interactive walktrough is a powerful way to increase user experience and customer satisfaction. This plugin is based on Shepperd.js - an open-source lightweight vanilla js library for guided tours. 
Customize the text, the number of popups and link to any DOM element through a friendly user admin interface.

== Installation ==
1. Take the easy route and install through the WordPress plugin installer or download the .zip file and upload the unzipped folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
= Where are the plugin settings? =
From your WordPress dashboard, click on Settings tab => Simple Tour Guide.

= What are the options? =
You can create a tour and add as many steps to it as you want from "Create a Tour" tab. 
You can add step title, step description, link the step to a specific dom element and add a custom class to it. 
You can also choose to display the tour only once or show it everytime you reload a page (test mode) and ask for confirmation when the user clicks the close button. 
Another cool feature is the ability to choose on which pages to display the tour. You can also change the background color of the step buttons via the "Style" tab.

= How to add steps? =
Go to "Create a Tour" tab and add as many steps as you want.

= Can I link a step to a page element? =
Sure, you can! Inspect a page element with the browser dev tool (right click with the mouse => inspect element) and then add its selector in the "Step Position" field from "Create a Tour" tab. You can add class, id or tag selector like so: .class, #id, tag. If you do not assign a selector, the step will appear exactly in the middle of the screen.

= How to show the tour guide only on one page? =
Go to Tour Options tab, uncheck "Show the tour on all pages" box and copy the plugin shortcode. Then, navigate to a page or post you want, click "edit" and paste the shortcode on the top of the post content.

= How to customize the style of the steps? =
You can use the .stg classname or add a custom class to each step from the "Create a Tour tab". Go to appearance => customize => additional css and add your own custom styles there.

= Can I create more than one tour? =
The plugin currently supports only one tour, however you can add an additional tour. Check shepherd.js documentation on how to do it.

= Can I request a new feature? =
Deffinitely! I will add new features on the go, just let me know what you need and I will consider it in a next plugin release.

== Changelog ==
= 1.0 =
* First publicly available version of the plugin.

== Upgrade Notice ==
= 1.0 =
Initial release.

== Screenshots ==

1. Plugin settings page
2. Plugin frontend