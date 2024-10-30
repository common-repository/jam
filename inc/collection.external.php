<?php

	$jamwp_plugin_file = plugin_basename(__FILE__);
	$jamwp_plugin_url = plugin_dir_url(__FILE__);
	$jamwp_plugin_directory = dirname(__FILE__);

	$options = get_option('jamwp');

	
	if ( $_GET['activate'] ):
		check_admin_referer( 'jamwp-activate' );
		$plugs = $options['external'];
		$plugs[$_GET['plugin']]['active'] = ($plugs[$_GET['plugin']]['active'])?false:true;
		$options['external'] = $plugs;
		update_option('jamwp',$options);
	endif;

	
	if ( $_GET['jamheader'] ):
		check_admin_referer( 'jamwp-locheader' );
		$plugs = $options['external'];
		if ( $plugs[$_GET['plugin']] ):
			$plugs[$_GET['plugin']]['header'] = ($_GET['jamheader'] == "h")?true:false; // could use the 1/0 from the GET but this prevents eroneous data
			$options['external'] = $plugs;
			update_option('jamwp',$options);
		else:
			print "<div class=\"error\"><p><strong>Script {$_GET['plugin']} not found</strong></p></div>";
		endif;
	endif;

	if ( $_GET['purge'] ):	
		if ( $_POST['purgeconfirm'] ):
			// verified choice, check nonce and purge if so
			check_admin_referer( 'jamwp_purge_externals', 'jamwp_nonce' );
			unset ($options['external']);
			update_option('jamwp',$options);
			print "<h4>All external scripts removed</h4>";
			print '<a href="admin.php?page=jamwp&tab=jamexternal" class="button">Continue</a>';
			// Display success notice, with link to continue
		else:
			// Not verified, so ask for them being sure
			print '<h4>This action will remove all external scripts from JAM settings. Are you sure?</h4>';
			print '<form method="post" action="admin.php?page=jamwp&tab=jamexternal&purge=1">';
			wp_nonce_field( 'jamwp_purge_externals', 'jamwp_nonce' );
			print '<input type="submit" class="button" value="Yes" name="purgeconfirm" /> <a href="admin.php?page=jamwp&tab=jamexternal" class="button">No</a>';
			print '</form>';
		endif;	
	endif; // GET PURGE

	
	if ( $_GET['delete'] ):
		check_admin_referer( 'jamwp_delete_external' );
		$externals = $options['external'];
		unset( $externals[$_GET['delete']] );
		$options['external'] = $externals;
		update_option('jamwp',$options);
	endif; // GET delete


	if ( $_GET['editexternal'] ):
		$externals = $options['external'];
		if ( !$externals[$_GET['editexternal']] ):
			print "Script not found";
			return;
		endif;
		$x = $externals[$_GET['editexternal']];
		$jamwp_url_submit_nonce = wp_nonce_field( 'jamwp_add_external', 'jamwp_nonce', true, false );
		
print <<<ThisHTML
		<form method="post" action="admin.php?page=jamwp&tab=jamexternal">
			{$jamwp_url_submit_nonce}
			<input type="hidden" name="jam_old_name" value="{$_GET['editexternal']}" />
			<label for="jam_nam">Name:</label> <input type="text" class="regular-text" name="jam_name" id="jam_name" value="{$_GET['editexternal']}" />
			<label for="jam_url" style="margin-left:20px;">URL:</label> <input style="margin-right:10px;" type="text" class="regular-text" name="jam_url" id="jam_url" value="{$x['url']}" />
			<input type="submit" value="Update" name="jam_edit_submit" class="button" /> <a href="admin.php?page=jamwp&tab=jamexternal" class="button">Cancel</a>
		</form>
ThisHTML;
		return;
		// break; // Why did I put this here?  Break out of what? - obviously the script was supposed to stop, not display the 'add' form.
		// UPGRADE/DEBUG need to find a way to halt the script here.  Or recode the entire include.
	endif;


	if ( $_POST['jam_url'] ):
		// verify nonce
		check_admin_referer( 'jamwp_add_external', 'jamwp_nonce' );
		if ( !$_POST['jam_name'] ):
			print "<div class=\"error\"><p><strong>Must provide a script name</strong></p></div>";
		else:
			$externals = $options['external'];

			// validate that it looks like a URL? And add protocol if it doesn't have one?  Assume http://? UPDATE

			// if there's an old name, delete that one
			if ( $_POST['jam_old_name'] ) unset( $externals[$_POST['jam_old_name']] );
			$externals[$_POST['jam_name']]['url'] = $_POST['jam_url'];
			$options['external'] = $externals;
			update_option('jamwp',$options);
			if ( $_POST['jam_edit_submit'] ) print "<div class=\"updated\"><p><strong>Script updated</strong></p></div>";
		endif;
	endif;

	$jamwp_url_submit_nonce = wp_nonce_field( 'jamwp_add_external', 'jamwp_nonce', true, false );

	
print <<<ThisHTML
<p>
	<form method="post">
		{$jamwp_url_submit_nonce}
		<label for="jam_name">NAME: </label><input type="text" class="regular-text" name="jam_name" id="jam_name" />
		<label for="jam_url" style="margin-left:25px;">URL: </label><input type="text" class="regular-text" name="jam_url" id="jam_url" /> <input type="submit" name="jam_url_submit" id="jam_url_submit_top" class="button" value="Add" /><br />
	</form>
</p>
	<style>
		.widefat td { vertical-align:middle; }
	</style>
	
		<table class="widefat" id="exlibrary">
		<thead>
			<tr>
				<th width="22">&nbsp;</th>
				<th width="200">Script</th>
				<th>URL</th>
				<th width="15">Location</th>
				<th width="10"> </th>
				<th width="10"> </th>
			</tr>
		</thead>
		<tbody>
ThisHTML;
	if ( $options['external'] ):
		foreach ( $options['external'] as $x=>$y ) {	
			print "<tr>";
				$plugin_on = ($y['active'])?"on":"off";
					if ( $plugin_on == "on" ):
						$plugin_on_image = "<img src=\"{$jamwp_plugin_url}grfx/on-state.png\" alt=\"on\" />";
					else:
						$plugin_on_image = "<img src=\"{$jamwp_plugin_url}grfx/off-state.png\" alt=\"off\" />";
					endif;
					$on_style = ($plugin_on == "on")?' style="font-weight:bold; color:green"':"";
					$url = wp_nonce_url("admin.php?page=jamwp&tab=jamexternal&activate=$plugin_on&plugin=$x",'jamwp-activate');
				print "<td class=\"onoff\" valign=\"middle\"><a data-plugin=\"$x\" href=\"$url\"$on_style>$plugin_on_image</a></td>";
				print "<td valign=\"middle\">$x</td>";
				print "<td valign=\"middle\">{$y['url']}</td>";
				if ( $y['header']):
					$url = wp_nonce_url("admin.php?page=jamwp&tab=jamexternal&jamheader=f&plugin=$x",'jamwp-locheader');
					print "<td valign=\"middle\" align=\"center\"><a href=\"$url\">header</a></td>";
				else:
					$url = wp_nonce_url("admin.php?page=jamwp&tab=jamexternal&jamheader=h&plugin=$x",'jamwp-locheader');
					print "<td valign=\"middle\" align=\"center\"><a href=\"$url\">footer</a></td>";
				endif;
				print '<td valign=\"middle\"><a href="admin.php?page=jamwp&tab=jamexternal&editexternal='.$x.'">edit</a></td>';
				$url = wp_nonce_url("admin.php?page=jamwp&tab=jamexternal&delete=$x",'jamwp_delete_external');
				print '<td valign=\"bottom\"><a href="'.$url.'">delete</a></td>';
			print "</tr>";
		} // external loop
	else:
		print "<tr><td> </td><td>No External Scripts</td></tr>";
	endif;
print <<<ThisHTML
		</tbody>
	</table>
ThisHTML;
	// only display the remove all button if there is more than one item.
	if ( count($options['external']) > 1 ) print '<p><a href="admin.php?page=jamwp&tab=jamexternal&purge=1" class="button">Remove All</a></p>';
print <<<ThisHTML
<div style="margin-top:30px; padding-top:20px; border-top:1px solid #ccc;">
<h3>External Scripts Help</h3>
<h4>Adding a new script</h4>
<p>Simply insert information into the name and URL spaces in the form at the top of the page. The name can be anything the administrator likes, it is only for display in the list. Refrain from using symbols or non alpha-numeric characters for script names.</p>
<p>The URL must be explicit to the location, for example <strong>http://www.mydomain.com/myscript.js</strong>. The script can be hosted on the local site webhost, or a remote script location, such as CDN hosted scripts at Google.com.</p>
<p>By default, scripts are disabled and set to load in the footer - as is the Wordpress standard for script location. Click the checkbox left of the script name to enable the script, and click the link "footer" under heading "Location" to change the location to header. When the location is already 'header', clicking will set the location back to footer.
</div>
ThisHTML;

?>