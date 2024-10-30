<?php

if ( !is_admin() ) exit;



switch ( $_GET['cdntab'] ){
	case "options": $optionsClass = ' class="active-subtab"'; $jamwp_wp_collection = "other"; break;
	default:
	$mainClass = ' class="active-subtab"';
	$active_marker = "a";
	if ( $_GET['cdnsort'] ):
		$active_marker = $_GET['cdnsort'];
	endif;
	$collection_request = "http://api.jsdelivr.com/v1/jsdelivr/libraries?fields=mainfile,name,description,homepage";
	
} // wp tab switch

// setup on the active marker.  No active m
if ( strlen($active_marker) == 1 && preg_match('/[a-z]/',$active_marker) ):
	$catpull = "&name={$active_marker}*";
elseif ( $active_marker == "all"):
	$catpull = "";
	// this for UPGRADE space when sorting is more advanced
else:
	$catpull = ""; // default will be all in instances of blank, or unqualified GET request
	$active_marker = "all";
endif;
$collection_request .= $catpull;

	


print <<<ThisHTML
	<div class="subtabs">
		<a href="admin.php?page=jamwp&tab=jamcdn"$mainClass>jsDelivr</a>
		<a href="admin.php?page=jamwp&tab=jamcdn&cdntab=options"$optionsClass>Tracker</a>
	</div>

ThisHTML;

// CDNs use a prefix identifier.
switch ( $_GET['cdntab'] ){

case "options":
	$options = get_option('jamwp');
	if ( $_POST['update_cdn_track'] && check_admin_referer( 'jamwp_cdn_update_tracker', 'jamwp_cdn_tracker' ) ):
		echo "<div class=\"updated\"><p>Options Updated</p></div>";
		$options['jsdelivr_tracker'] = ( $_POST['allow_jsdelivr_track'] )?true:false;
		update_option('jamwp',$options);
	endif;
	
	$tracker_checked = ($options['jsdelivr_tracker'])?' checked="checked"':"";
	
GLOBAL $jamwp_plugin_file;
print <<<ThisHTML
<form method="post" action="admin.php?page=jamwp&tab=jamcdn&cdntab=options">
ThisHTML;
wp_nonce_field( 'jamwp_cdn_update_tracker','jamwp_cdn_tracker' );
print <<<ThisHTML
<table class="form-table">
	<tr>
		<th scope="row">Allow Tracking</th>
		<td><input type="checkbox" name="allow_jsdelivr_track"{$tracker_checked} /><span class="description">Checking this turns on performance tracking. See below for more information</span></td>
	</tr>
</table>
<p><input type="submit" value="Update" name="update_cdn_track" class="button-primary" /></p>
</form>
<h4 style="margin-top:50px; border-top:1px solid #444; padding-top:30px;">About the tracker</h4>
<p>jsDelivr uses real user performance data (also known as RUM) to make its routing decisions. This data is gathered from hundreds of websites and is used in our load balancing algorithm to make accurate decisions based on real time performance metrics.</p>
<p>This testing does not impact on your website performance or user browsing experience.</p>
<p class="description">The developer of this plugin is not associated in any way with jsDeliver, but includes this option in the plugin to give users the option to assist jsDeliver in improving this incredible free service, and improve the quality of content delivery of these scripts to this, your site, as well as others. &nbsp;It is an easy way to contribute to the open source community as a whole.</p>
<p class="description">Please see the section on <a href="https://github.com/jsdelivr/jsdelivr#contribute-performance-data" target="_blank">contributing performance data</a> at the <a href="https://github.com/jsdelivr/jsdelivr#contribute-performance-data" target="_blank">jsDeliver page</a> on Github for more detailed information on tracking and data collection.</p>
ThisHTML;
break;

default:

$jw_cdn_collection = json_decode( file_get_contents($collection_request,r) );

print <<<ThisHTML
	<style>
		.widefat td { vertical-align:middle; }
		.jamwp-meta { font-size:10px; color:#666; }
		.onoff a, .onoff a:focus { box-shadow:none; }
	</style>
ThisHTML;


if ( $active_marker == "all" ) $allMarker = "-primary";
print "<a href=\"admin.php?page=jamwp&tab=jamcdn&cdnsort=all\" class=\"button{$allMarker}\">All</a> &bull; ";
$marker = "a";
while ( $marker < "z" ):
	$markerClass = ( $active_marker == $marker )?"-primary":"";
	print "<a href=\"admin.php?page=jamwp&tab=jamcdn&cdnsort={$marker}\" class=\"button{$markerClass}\">$marker</a> ";
	$marker++;
endwhile;
print "<a href=\"#\" class=\"button{$markerClass}\">$marker</a> ";


print <<<ThisHTML
	<table class="widefat" id="library">
		<thead>
			<tr>
				<th width="22" align="center"></th>
				<th>Plugin</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
ThisHTML;
	foreach ( $jw_cdn_collection as $x ) {
			// filtering before display
			if ( substr($x->mainfile,-3) != ".js" ) continue;
			print "<tr>";
				$hosted_plugname = "cdnjsd_".$x->name;
				$plugin_on = ($jplug_active[$hosted_plugname])?"on":"off";
				if ( $plugin_on == "on" ):
					$plugin_on_image = "<img src=\"{$jamwp_plugin_url}grfx/on-state.png\" alt=\"on\" />";
				else:
					$plugin_on_image = "<img src=\"{$jamwp_plugin_url}grfx/off-state.png\" alt=\"off\" />";
				endif;
				$on_style = ($plugin_on == "on")?' style="font-weight:bold; color:green"':"";
				print "<td valign=\"middle\" class=\"onoff\"><a data-plugin=\"cdnjsd_{$x->name}</a>\" href=\"".wp_nonce_url("admin.php?page=jamwp&activate=$plugin_on&plugin={$x->name}",'jamwp-activate')."\"$on_style>$plugin_on_image</a></td>";
			$jamwp_list_name = ($x->homepage)?"<a href=\"{$x->homepage}\" target=\"_blank\">{$x->name}</a>":$x->name;
			print "<td valign=\"middle\">$jamwp_list_name</td>";
			print "<td valign=\"middle\">{$x->description}</td>";
			print "</tr>";
	} // foreach
	print "</tbody></table>";
} // tabs switch


?>