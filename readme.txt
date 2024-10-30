=== Jam Plugin for Wordpress ===
Contributors: Avant 5
Tags: jQuery, scripts, enqueue, javascript, libraries, jam, jsDelivr
Author URI: http://www.avant5.com
Plugin URI: http://www.avant5.com/jam
Requires at least: 3.0.1
Tested up to: 4.9
Stable tag: 2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A quick interface to popular jQuery plugins and the jQuery and Javascript packaged with Wordpress.

== JAM is Discontinued ==

Thanks to everyone that tried and used my plugin, but because jsDelivr did such a great job, there is no need to continue with this.  JAM will continue to be maintained for Wordpress compatibility, but development has been halted
indefinitely.  We highly recomment using the jsDelivr plugin as an alternative for serving all of your Javascript applications.

== Description ==

The Javascript Application Manager (JAM) for Wordpress is a unique new tool for quickly including a wide variety of plugins and libraries for Javascript and jQuery allowing users to load one or many with a simple interface, eliminating the need to alter themes to bring the wonderful user experience. Enjoy your already-favorite Javascript and jQuery plugins and discover new ones with this great tool for themers.

Includes 12 plugins :: Arctext, aSlyder, Avgrund Modal, Countdown, Fittext, Gridster, iCheck, jQuery Knob, Lettering, Tubular and Typeahead.  All included plugins are set up to work with the noConflict style for complete Wordpress compatibility.  More plugins coming soon!

Allows quick and easy adding/removing of 44 of the Javascript, jQuery, jQuery UI and jQuery UI Effect plugins and libraries included with Wordpress.  Allows easy theme switching without needing to recode theme files to bring jQuery functionality to the new theme.

This is not a plug-n-play device, but rather a tool for experienced themers to improve workflow in including functionality to themes.  Some setup required for most plugins and libraries.  All plugins included are GPL, MIT or WTFPL licensed so can be redistributed, sold and submitted to Wordpress.org without licensing conflicts.

= Planned Features =
* Improved functionality for the jsDelivr CDN
* More responsive UI and performance
* Auto-updating of scripts
* jsDelivr CSS libraries
* Access to additional plugins embedded in Wordpress - especially non-jQuery apps
* Help files and set up instructions for individual plugins


= Stay connected =
Follow us on Twitter @avant5 for release and update information on this and all of our products and services.

== Installation ==

1 Upload entire aslyder folder and contents to /wp-content/plugins/

2 From the WP admin panel activate the plugin.

3 From the admin panel for JAM, use the checkboxes to turn on any plugins desired.

4 Follow plugin author instructions for setup of CSS and HTML within themes. Clicking plugin names in the admin panel will take you to the plugin's site.

== Security ==

= A note on security =

This plugin was developed as an extension and workflow improvement tool for experts, not as a quick drop-in tool for the more casual user.  But regardless of who is using this plugin, great care should be taken in its use.

This plugin handles the delivery of Javascript, as well as the storage of scripts, and because of this extra diligence should be taken in monitoring activity surrounding the plugin, as well as its interaction with other plugins. Always be aware of manipulation and the potential for cross-contamination of data by plugins, as Wordpress [at the time of thie writing] does not have a mechanism for protecting against this.

Because of its nature, its power and flexibility makes JAM is an excellent tool for injecting malicious code into your site.  While every effort is put into the security and and isolating the plugin from others, all plugins have access to the Wordpress database and options.  It is every webmaster's job to monitor changes to the system, and with a plugin such as this, all the more so.

This is not to say that JAM is dangerous to your site.  Caution should be used with *any* Wordpress plugin.  Just like scissors, knives and hammers, used incorrectly these tools can be dangerous.  Used properly, they make our lives better and more productive in our work.  



== Changelog ==
2.1
* Added info to README about discontinued development
* Fixed PHP 7 related errors in collection.external.php
* Fixed icheck typo in script calling code

1.32
* Added: Six additional plugins from the WP package.

1.31
* Added: jQuery.Countdown [by request]

1.3
* Fixed: Admin panel javascript set to load only on JAM options pages.
* Added: Control panel for external and remote scripts management.

1.22
* Added Countdown.js to library [by request]

1.2
* Removed XML descriptions file loading for site visitors to improve performance.
* Added script editors for header and footer custom scripts
* Added descriptions for all Wordpress-packaged scripts, and linked titles to corresponding sites/pages.
* Added AJAX activation/deactivation of scripts