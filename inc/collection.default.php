<?php

if ( !is_admin() ) exit;

print <<<ThisHTML
	<style>
		.widefat td { vertical-align:middle; }
		.jamwp-meta { font-size:10px; color:#666; }
		.onoff a, .onoff a:focus { box-shadow:none; }
	</style>
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

foreach ( $jamwp_collection as $x ) {
	print "<tr>";
		$plugin_on = ($jplug_active[$x])?"on":"off";
		if ( $plugin_on == "on" ):
			$plugin_on_image = "<img src=\"{$jamwp_plugin_url}grfx/on-state.png\" alt=\"on\" />";
		else:
			$plugin_on_image = "<img src=\"{$jamwp_plugin_url}grfx/off-state.png\" alt=\"off\" />";
		endif;

		$on_style = ($plugin_on == "on")?' style="font-weight:bold; color:green"':"";
	print "<td valign=\"middle\" class=\"onoff\"><a data-plugin=\"$x\" href=\"".wp_nonce_url("admin.php?page=jamwp&activate=$plugin_on&plugin=$x",'jamwp-activate')."\"$on_style>$plugin_on_image</a></td>";
	$jamwp_list_name = ($jplug[$x]['url'])?"<a href=\"{$jplug[$x]['url']}\" target=\"_blank\">$x</a>":$x;
	print "<td valign=\"middle\">$jamwp_list_name</td>";
		unset($metaset);
		$metaset = array();
		if ($jplug[$x]['url']) $metaset[] = "<a href=\"$jplug[$x]['url']\">Site</a>";

		switch ($jplug[$x]['license']){
			case "MIT":
				$metaset[] = 'Licence: <a href="http://opensource.org/licenses/MIT">MIT</a>';
			break;

			case "GPL":
				$metaset[] = 'Licence: <a href="http://www.gnu.org/licenses/gpl.html">GPL</a>';
			break;

			case "WTFPL":
				$metaset[] = 'Licence: <a href="http://www.wtfpl.net/">GPL</a>';
			break;
			default:
				// no license if default - no action
		} // license switch
		$metadisplay = implode(" | ",$metaset); // not used yet
	print "<td valign=\"middle\">{$jplug[$x]['description']}";
	print "</tr>";
}

print "</tbody></table>";

?>