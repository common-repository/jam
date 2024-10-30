<?php

class jamMenu {

	function menu($tab="",$subtab=NULL) {
		switch ( $tab ) {
			case "wp": $wpTab = " nav-tab-active"; break;
			case "jampops": $optsTab = " nav-tab-active"; break;
			case "jamedit": $editTab = " nav-tab-active"; break;
			case "jamexternal": $externalTab = " nav-tab-active"; break;
			case "jamimport": $importTab = " nav-tab-active"; break;
			case "jamcdn": $cdnTab  = " nav-tab-active"; break;
			default: $mainTab = " nav-tab-active";
		}// switch
	
		print "<h3 class=\"nav-tab-wrapper\" style=\"margin-bottom:3px;\">";
		print " &nbsp;<a href=\"admin.php?page=jamwp&tab=main\" class=\"nav-tab$mainTab\">Library</a>";
		print "<a href=\"admin.php?page=jamwp&tab=jamcdn\" class=\"nav-tab$cdnTab\">JSDelivr CDN</a>";
		print "<a href=\"admin.php?page=jamwp&tab=wp\" class=\"nav-tab$wpTab\">WP Built-in</a>";
		print "<a href=\"admin.php?page=jamwp&tab=jamedit\" class=\"nav-tab$editTab\">Script Editors</a>";
		print "<a href=\"admin.php?page=jamwp&tab=jamexternal\" class=\"nav-tab$externalTab\">External Scripts</a>";
		//print "<a href=\"admin.php?page=jamwp&tab=jampops\" class=\"nav-tab$optsTab\">Options</a>";
		print "</h3>";
		
		if ( $subtab ):
		
		endif;
	} // ::menu()
	
	function tab($tab="") {
	
	} // ::tab()

} // jamMenu class

?>