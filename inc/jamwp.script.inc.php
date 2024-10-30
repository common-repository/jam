<?php

function jamwp_scripts() {
	GLOBAL $jamwp_wp,$jamwp_collection;
	$options = get_option('jamwp');
	$plugins = $options['active'];
	if ($plugins['jQuery']) wp_enqueue_script( 'jquery' );
	if ($plugins['jQuery Form']) { wp_enqueue_script( 'jquery-form ' ); }
	if ($plugins['jQuery Color']) wp_enqueue_script( 'jquery-color ' );
	if ($plugins['jQuery Masonry']) wp_enqueue_script( 'jquery-masonry' );
	if ($plugins['jQuery Schedule']) wp_enqueue_script( 'schedule' );
	if ($plugins['jQuery Suggest']) wp_enqueue_script( 'suggest' );
	if ($plugins['jQuery Hotkeys']) wp_enqueue_script( 'jquery-hotkeys' );
	if ($plugins['Iris']) wp_enqueue_script( 'iris' );
	
	if ($plugins['jQuery UI Effects']) wp_enqueue_script( 'jquery-effects-core' );
	if ($plugins['jQuery UI Effects - Blind']) wp_enqueue_script( 'jquery-effects-blind' );
	if ($plugins['jQuery UI Effects - Bounce']) wp_enqueue_script( 'jquery-effects-bounce' );
	if ($plugins['jQuery UI Effects - Clip']) wp_enqueue_script( 'jquery-effects-clip' );
	if ($plugins['jQuery UI Effects - Drop']) wp_enqueue_script( 'jquery-effects-drop' );
	if ($plugins['jQuery UI Effects - Explode']) wp_enqueue_script( 'jquery-effects-explode' );
	if ($plugins['jQuery UI Effects - Fade']) wp_enqueue_script( 'jquery-effects-fade' );
	if ($plugins['jQuery UI Effects - Fold']) wp_enqueue_script( 'jquery-effects-fold' );
	if ($plugins['jQuery UI Effects - Highlight']) wp_enqueue_script( 'jquery-effects-highlight' );
	if ($plugins['jQuery UI Effects - Pulsate']) wp_enqueue_script( 'jquery-effects-pulsate' );
	if ($plugins['jQuery UI Effects - Scale']) wp_enqueue_script( 'jquery-effects-scale' );
	if ($plugins['jQuery UI Effects - Shake']) wp_enqueue_script( 'jquery-effects-shake' );
	if ($plugins['jQuery UI Effects - Slide']) wp_enqueue_script( 'jquery-effects-slide' );
	if ($plugins['jQuery UI Effects - Transfer']) wp_enqueue_script( 'jquery-effects-transfer' );
	
	if ($plugins['jQuery UI Core']) wp_enqueue_script( 'jquery-ui-core ' );
	if ($plugins['jQuery UI Widget']) wp_enqueue_script( '	jquery-ui-widget' );
	if ($plugins['jQuery UI Mouse']) wp_enqueue_script( 'jquery-ui-mouse' );
	if ($plugins['jQuery UI Accordion']) wp_enqueue_script( 'jquery-ui-accordion' );
	if ($plugins['jQuery UI Autocomplete']) wp_enqueue_script( 'jquery-ui-autocomplete' );
	if ($plugins['jQuery UI Slider']) wp_enqueue_script( 'jquery-ui-slider' );
	if ($plugins['jQuery UI Tabs']) wp_enqueue_script( 'jquery-ui-tabs' );
	if ($plugins['jQuery UI Sortable']) wp_enqueue_script( 'jquery-ui-sortable' );
	if ($plugins['jQuery UI Draggable']) wp_enqueue_script( 'jquery-ui-draggable' );
	if ($plugins['jQuery UI Droppable']) wp_enqueue_script( 'jquery-ui-droppable' );
	if ($plugins['jQuery UI Selectable']) wp_enqueue_script( 'jquery-ui-selectable' );
	if ($plugins['jQuery UI Position']) wp_enqueue_script( 'jquery-ui-position' );
	if ($plugins['jQuery UI Datepicker']) wp_enqueue_script( 'jquery-ui-datepicker' );
	if ($plugins['jQuery UI Resizable']) wp_enqueue_script( 'jquery-ui-resizable' );
	if ($plugins['jQuery UI Dialog']) wp_enqueue_script( 'jquery-ui-dialog' );
	if ($plugins['jQuery UI Button']) wp_enqueue_script( 'jquery-ui-button' );
	
	if ($plugins['Backbone JS']) wp_enqueue_script( 'backbone' );
	if ($plugins['Underscore JS']) wp_enqueue_script( 'underscore' );
	if ($plugins['Jcrop']) wp_enqueue_script( 'jcrop' );
	if ($plugins['Simple AJAX Code-kit']) wp_enqueue_script( 'sack' );
	if ($plugins['ThickBox']) wp_enqueue_script( 'thickbox' );
	if ($plugins['MediaElement']) wp_enqueue_script( 'wp-mediaelement' );
	
} // jamwp_scripts()

function jamwp_jsdelivr_footer(){
	// footer version, upgrade will have header version, when locating scripts upgrade implemented
	$x = get_option('jamwp_jsdelivr_files');
	foreach ( $x as $files ){
		print "<p>";
		print_r($files);
		print "</p>";
	}
}
?>