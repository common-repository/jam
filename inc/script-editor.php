<?php
	$jplug_options = get_option('jamwp');
	if ( $_POST['jamscriptedits'] ):
		check_admin_referer( 'jamwp_script_update', 'jamwp_script_edit' );
		// preg_replace to remove script tags - just in case
		$_POST['headerscript'] = preg_replace('/<script>|<\/script>/','',$_POST['headerscript']);
		$_POST['footerscript'] = preg_replace('/<script>|<\/script>/','',$_POST['footerscript']);
		$jplug_options['headerscript'] = $_POST['headerscript'];
		$jplug_options['footerscript'] = $_POST['footerscript'];
		update_option('jamwp',$jplug_options);
		print "<div class=\"updated\"><p><strong>Scripts Updated</strong></p></div>";
	endif;
	$headerscript = stripslashes($jplug_options['headerscript']);
	$footerscript = stripslashes($jplug_options['footerscript']);
print <<<ThisHTML
	<form method="post">
ThisHTML;
	wp_nonce_field( 'jamwp_script_update','jamwp_script_edit' );
print <<<ThisHTML
		<table class="form-table">
			<tr>
				<th scope="row">Header Script<br />
					<p class="description">Add javascript here to add javascript to header. Script will appear after other script requests.</p>
					<p class="description">Do not use &lt;script&gt; tags.</p>
				</th>
				<td>
					<textarea cols="50" rows="10" name="headerscript" id="headerscript" class="large-text">$headerscript</textarea>
				</td>
			</tr>
			<tr>
				<th scope="row">Footer Script
					<p class="description">Add javascript here to add javascript to footer. Script will appear after other script requests.</p>
					<p class="description">Do not use &lt;script&gt; tags</p>
				</th>
				<td>
					<textarea cols="50" rows="10" name="footerscript" id="footerscript" class="large-text">$footerscript</textarea>
				</td>
			</tr>
			<tr>
				<th>
					<input type="submit" class="button-primary" value="Update Scripts" name="jamscriptedits" id="jamscriptedits" />
				</th>
				<td> </td>
			</tr>
		</table>
	</form>
ThisHTML;
?>