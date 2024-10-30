<?php

if (!is_admin()) exit;


$xml = simplexml_load_file($jamwp_plugin_directory.'/library.xml');
$s = json_decode(json_encode($xml),TRUE);
foreach ( $s['item'] as $x ) {
	$name = $x['name'];
	$jplug[$name] = array(
		'description' => $x['description'],
		'url' => $x['url'],
		'license' => $x['license']
		);
} // foreach s item

include("classes/class.menu.php");

function jamwp_options(){

	GLOBAL $jplug,$jamwp_collection,$jamwp_wp;
	$jamwp_plugin_file = plugin_basename(__FILE__);
	$jamwp_plugin_url = plugin_dir_url(__FILE__);
	$jamwp_plugin_directory = dirname(__FILE__);
	$jplug_options = get_option('jamwp');
	$jplug_active = $jplug_options['active'];

	print '<div class="wrap">';
	print '<h2>JAM Options</h2>';
	print '<style>';
	print '.onoff a { outline:0; }';
	print '.subtabs { background-color:#222; margin:4px 0; padding-left:12px; }';
	print '.subtabs a { color:#eee; display:inline-block; padding:0 18px 5px; text-decoration:none; line-height:2.4; }';
	print '.subtabs a.active-subtab { color:#222; background-color:#eee; border-top:3px solid #222; }';
	print '</style>';
	jamMenu::menu($_GET['tab']);
	print '</div>'; // .wrap
	
	switch($_GET['tab']){
		case "wp": include("inc/collection.wp.php"); break;
		case "jamedit": include("inc/script-editor.php"); break;
		case "jamexternal": include("inc/collection.external.php"); break;
		case "jamcdn": include("inc/collection.cdn.php"); break;
		default: include("inc/collection.default.php");
	}

}

function jamwp_options_menu() {
	add_menu_page( "JAM Options","JAM","manage_options","jamwp","jamwp_options",$icon );
} // jamwp_options_menu
add_action('admin_menu', 'jamwp_options_menu');

add_action('admin_footer','jawmp_ajax_script');
function jawmp_ajax_script(){
// only do this if it's a JAM page
if ( $_GET['page'] == "jamwp" ):	
	$jamwp_plugin_file = plugin_basename(__FILE__);
	$jamwp_plugin_url = plugin_dir_url(__FILE__);
	$jamwp_plugin_directory = dirname(__FILE__);
	$jawmp_ajax_nonce = wp_create_nonce( 'jawmp-ajax-activate' );
print <<<ThisHTML
<script>
	(function($){
		$(document).ready(function(){
			$("#exlibrary .onoff a").on('click',function(_e) {
				// ignore right now. No-script method first
			});
			$("#library .onoff a").on('click',function(_e){
				_e.preventDefault();
				var targetCheck = $(this);
				var jamwp_plug_to_switch = $(this).attr('data-plugin');
				var data = {
					action: 'switch_onoff',
					plugin: jamwp_plug_to_switch,
					security: '{$jawmp_ajax_nonce}'
				};
				$.post(ajaxurl,data,function(_r){
					if ( _r == "on" ) {
						$(targetCheck).html('<img src="{$jamwp_plugin_url}grfx/on-state.png" alt="on" />');
					} else {
						$(targetCheck).html('<img src="{$jamwp_plugin_url}grfx/off-state.png" alt="off" />');
					}
				});
				alert(_r);
			});
		});
	})(jQuery);
</script>
ThisHTML;
endif; // GET jamwp
} // jawmp_ajax_script()


add_action('wp_ajax_switch_onoff','jawmp_ajax_onoff');
function jawmp_ajax_onoff() {
	check_ajax_referer( 'jawmp-ajax-activate', 'security' );
	global $wpdb;
	$jplug_options = get_option('jamwp');
	$jplug_active = $jplug_options['active'];
	$target_plugin = sanitize_text_field( $_POST['plugin'] );
	
	// DEBUG THIS
	
	
	if ( $jplug_active[$target_plugin] ):
		unset($jplug_active[$target_plugin]);
		if ( substr($target_plugin,0,7) == "cdnjsd_" ):
			$files = get_option('jamwp_jsdelivr_files');
			unset($files[$target_plugin]);
			update_option('jamwp_jsdelivr_files',$files);
		endif;
		echo "off";
	else:
		echo "on"; // first, for responsive checkbox reaction
		$jplug_active[$target_plugin] = 1;
		if ( substr($target_plugin,0,7) == "cdnjsd_" ):
			// get the files for this app
			$appname = substr($target_plugin,7);
			$x = json_decode( file_get_contents("http://api.jsdelivr.com/v1/jsdelivr/libraries?name={$appname}",r) );
			
			$app = $x[0];
			$versions = count($app->assets) - 1;
			$latest_version = $app->versions[0];
			
			foreach ( $app->assets[$versions]->files as $z ){
				// javascript files
				if ( substr($z,-3) == ".js" ):
					$minified = substr($z,0,-3).".min.js";
					if ( in_array($minified,$app->assets[$versions]->files) ) continue;
					$js_array[] = "<script src=\"//cdn.jsdelivr.net/{$appname}/{$latest_version}/$z\"></script>";
				endif;
				// css files
				if ( substr($z,-4) == ".css" ):
					$minified = substr($z,0,-4).".min.css";
					if ( in_array($minified,$app->assets[$versions]->files) ) continue;
					$css_array[] = "<link rel=\"stylesheet\" href=\"//cdn.jsdelivr.net/{$appname}/{$latest_version}/$z\" />";
				endif;
			}
			$all_files['css'] = $css_array;
			$all_files['js_footer'] = $js_array; // UPGRADE: also js_header to load scripts in the header instead
			
			$files = get_option('jamwp_jsdelivr_files');
			$files[$target_plugin] = $all_files;
			update_option('jamwp_jsdelivr_files',$files);
		endif; // cdnjsd check
		
	endif;
	$jplug_options['active'] = $jplug_active;
	update_option('jamwp',$jplug_options);
	die();
}
	
?>