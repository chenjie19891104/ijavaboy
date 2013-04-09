<?php
	
	//Dropcap
	function dropcap( $atts, $content = null ) {
   		return '<span class="dropcap">' . do_shortcode($content) . '</span>';
	}
	add_shortcode('dropcap', 'dropcap');
	
	//Dropcap 2
	function dropcap2( $atts, $content = null ) {
   		return '<span class="dropcap2">' . do_shortcode($content) . '</span>';
	}
	add_shortcode('dropcap2', 'dropcap2');
	
	//Highlight
	function highlight( $atts, $content = null ) {
   		return '<span class="highlight">' . do_shortcode($content) . '</span>';
	}
	add_shortcode('highlight', 'highlight');
	
	//Button
	function button( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'link'      => '#',
		), $atts));
	
		$out = "<p><a class=\"btn\" href=\"" .$link. "\">" .do_shortcode($content). "</a></p>";
		return $out;
	}
	add_shortcode('button', 'button');
	
	//Info Notification
	function info( $atts, $content = null ) {
   		return '<p class="info">' . do_shortcode($content) . '</p>';
	}
	add_shortcode('info', 'info');
	
	//Warning Notification
	function warning( $atts, $content = null ) {
   		return '<p class="warning">' . do_shortcode($content) . '</p>';
	}
	add_shortcode('warning', 'warning');
	
	//Error Notification
	function error( $atts, $content = null ) {
   		return '<p class="error">' . do_shortcode($content) . '</p>';
	}
	add_shortcode('error', 'error');
	
	//Success Notification
	function success( $atts, $content = null ) {
   		return '<p class="success">' . do_shortcode($content) . '</p>';
	}
	add_shortcode('success', 'success');
	
	//Note Notification
	function note( $atts, $content = null ) {
   		return '<p class="note">' . do_shortcode($content) . '</p>';
	}
	add_shortcode('note', 'note');
	
	//Download Notification
	function download( $atts, $content = null ) {
   		return '<p class="download">' . do_shortcode($content) . '</p>';
	}
	add_shortcode('download', 'download');
	
	//Divider
	function divider() {
	   return '<div class="divider"></div>';
	}
	add_shortcode('divider', 'divider');
	
	//Single Column
	function singlecol( $atts, $content = null ) {
	   return '<div class="singlecol left">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('singlecol', 'singlecol');
	
	function singlecol_last( $atts, $content = null ) {
	   return '<div class="singlecol left last">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('singlecol_last', 'singlecol_last');
	
	//One Third Column
	function onethirdcol( $atts, $content = null ) {
	   return '<div class="onethirdcol left">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('onethirdcol', 'onethirdcol');
	
	function onethirdcol_last( $atts, $content = null ) {
	   return '<div class="onethirdcol left last">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('onethirdcol_last', 'onethirdcol_last');
	
	//Two Column
	function twocol( $atts, $content = null ) {
	   return '<div class="twocol left">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('twocol', 'twocol');
	
	function twocol_last( $atts, $content = null ) {
	   return '<div class="twocol left last">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('twocol_last', 'twocol_last');
	
	//Two Third Column
	function twothirdcol( $atts, $content = null ) {
	   return '<div class="twothirdcol left">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('twothirdcol', 'twothirdcol');
	
	function twothirdcol_last( $atts, $content = null ) {
	   return '<div class="twothirdcol left last">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('twothirdcol_last', 'twothirdcol_last');
	
	//Three Column
	function threecol( $atts, $content = null ) {
	   return '<div class="threecol left">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('threecol', 'threecol');
	
	function threecol_last( $atts, $content = null ) {
	   return '<div class="threecol left last">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('threecol_last', 'threecol_last');
	
	//Four Column
	function fourcol( $atts, $content = null ) {
	   return '<div class="fourcol left">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('fourcol', 'fourcol');

?>