<?php

/*

	Plugin Name: JAM for Wordpress
	Plugin URI: http://www.avant5.com/jam/
	Description: Easy managing and loading of jQuery plugins, libraries and the WP enqueued scripts for jQuery.  Complete with a full library of ready-to-use scripts.
	Author: Avant 5 Multimedia
	Version: 2.1
	Author URI: http://www.avant5.com
	
	Copyright 2017  Avant 5 Multimedia  ( email : info@avant5.com )
	
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
*/

if ( ! defined( 'ABSPATH' ) ):
	exit;
endif;

if (!is_admin()):
	include("classes/class.header.php");
	include("classes/class.footer.php");
	include("inc/jamwp.script.inc.php");
endif;

$blogURL = get_bloginfo('url');
$jamwp_plugin_file = plugin_basename(__FILE__);
$jamwp_plugin_url = plugin_dir_url(__FILE__);
$jamwp_plugin_directory = dirname(__FILE__);

$jamwp_wp = array();
$jamwp_wp[0] = array("jQuery","jQuery Schedule","jQuery Suggest","jQuery Hotkeys","jQuery Form","jQuery Color","jQuery Masonry","Iris","Jcrop","MediaElement","ThickBox");
$jamwp_wp['ui'] = array("jQuery UI Core","jQuery UI Widget","jQuery UI Mouse","jQuery UI Accordion","jQuery UI Autocomplete","jQuery UI Slider","jQuery UI Tabs","jQuery UI Sortable","jQuery UI Draggable","jQuery UI Droppable","jQuery UI Selectable","jQuery UI Position","jQuery UI Datepicker","jQuery UI Resizable","jQuery UI Dialog","jQuery UI Button");
$jamwp_wp['effects'] = array("jQuery UI Effects","jQuery UI Effects - Blind","jQuery UI Effects - Bounce","jQuery UI Effects - Clip","jQuery UI Effects - Drop","jQuery UI Effects - Explode","jQuery UI Effects - Fade","jQuery UI Effects - Fold","jQuery UI Effects - Highlight","jQuery UI Effects - Pulsate","jQuery UI Effects - Scale","jQuery UI Effects - Shake","jQuery UI Effects - Slide","jQuery UI Effects - Transfer");
$jamwp_wp['other'] = array("Backbone JS","Underscore JS","Simple AJAX Code-kit");
$jamwp_collection = array("Arctext","aSlyder","Avgrund Modal","Countdown","FitText","Gridster","iCheck","jQuery Countdown","jQuery Knob","Lettering","Tubular","Typeahead");

function jamwp_header() {
	GLOBAL $jamwp_wp,$jamwp_collection;
	$jamwp_plugin_file = plugin_basename(__FILE__);
	$jamwp_plugin_url = plugin_dir_url(__FILE__);
	$jamwp_plugin_directory = dirname(__FILE__);
	$options = get_option('jamwp');	
	$plugins = $options['active'];
		if ( $plugins['Arctext'] ) 
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/arctext/jquery.arctext.js\"></script>\n";
	if ( $plugins['aSlyder'] )
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/aslyder/aslyder.js\"></script>\n";
	if ( $plugins['Avgrund Modal'] ) 
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/avgrund-modal/jquery.avgrund.js\"></script>\n";
	if ( $plugins['FitText'] )
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/fittext/jquery.fittext.js\"></script>\n";
	if ( $plugins['Countdown'] )
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/fittext/countdown.js\"></script>\n";
	if ( $plugins['Gridster'] ) 
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/gridster/jquery.gridster.min.js\"></script>\n";
	if ( $plugins['iCheck'] ) 
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/icheck/jquery.icheck.min.js\"></script>\n";
	if ( $plugins['jQuery Knob'] )
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/jquery-knob/jquery.knob.js\"></script>\n";
	if ( $plugins['jQuery Countdown'] )
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/jquery-countdown/jquery.countdown.js\"></script>\n";
	if ( $plugins['Lettering'] )
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/lettering/jquery.lettering.js\"></script>\n";
	if ( $plugins['Tubular'] )
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/tubular/jquery.tubular.1.0.js\"></script>\n";
	if ( $plugins['Typeahead'] )
		print "<script type=\"text/javascript\" src=\"{$jamwp_plugin_url}jquery-scripts/typeahead/typeahead.min.js\"></script>\n";
	if ( $options['external'] ):
		foreach ( $options['external'] as $x=>$y ) {
			if ( $y['active'] && $y['header'] ) print "\n<script type=\"text/javascript\" src=\"{$y['url']}\"></script>";
		}
		print "\n";
	endif;
	
	// jsDeliver CSS files (always in header)
	if ( $files = get_option('jamwp_jsdelivr_files') ):
		foreach ( $files as $x ) {
			if ( $x['css'] ):
				foreach ( $x['css'] as $y ){
					echo "$y\n";
				}
			endif;
		}
	endif;
	
	if ( $options['headerscript'] )
		print "<script type=\"text/javascript\">".stripslashes($options['headerscript'])."</script>";
} // _header()

function jamwp_footer() {
	$options = get_option('jamwp');
	if ( $options['external'] ):
		foreach ( $options['external'] as $x=>$y ) {
			if ( $y['active'] && !$y['header'] ) print "\n<script type=\"text/javascript\" src=\"{$y['url']}\"></script>";
		}
		print "\n";
	endif;
	if ( $options['footerscript'] ) print "\n<script type=\"text/javascript\">\n".stripslashes($options['footerscript'])."\n</script>\n";
	if ( $options['jsdelivr_tracker'] ):
print <<<ThisHTML
<script type="text/javascript">
(function(w, d) { var a = function() { var a = d.createElement('script'); a.type = 'text/javascript';
a.async = 'async'; a.src = '//' + ((w.location.protocol === 'https:') ? 's3.amazonaws.com/cdx-radar/' :
'radar.cedexis.com/') + '01-11475-radar10.min.js'; d.body.appendChild(a); };
if (w.addEventListener) { w.addEventListener('load', a, false); }
else if (w.attachEvent) { w.attachEvent('onload', a); }
}(window, document));
</script>
ThisHTML;
	endif; 

	// jsDelivr script files designated for in-footer
	if ( $files = get_option('jamwp_jsdelivr_files') ):
		foreach ( $files as $x ) {
			if ( $x['js_footer'] ):
			foreach ( $x['js_footer'] as $y ){
				echo "$y\n";
			}
			endif;
		}
	endif;


} // _footer()

add_action( 'wp_enqueue_scripts', 'jamwp_scripts' );
add_action('wp_head','jamwp_header');
add_action('wp_footer','jamwp_footer',20);


if ( is_admin() ):
	require_once("jam-admin.php");
endif;
?>