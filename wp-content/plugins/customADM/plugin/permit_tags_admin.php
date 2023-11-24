<?php 
if(!function_exists('wp_get_current_user')) {
    include(ABSPATH . "wp-includes/pluggable.php"); 
}
$current_user=wp_get_current_user();
if (isset($current_user->caps["administrator"]) && $current_user->caps["administrator"]==true){
	if (!defined('CUSTOM_TAGS')) define( 'CUSTOM_TAGS', true );
	function add_scriptfilter( $string ) {
		global $allowedtags;
		$allowedtags['link'] = array( 'href' => array () );
		$allowedtags['style'] = array( 'type' => array (),'media' => array ());
		$allowedtags['script'] = array( 'src' => array () );
		return $string;
	}
	add_filter( 'pre_kses', 'add_scriptfilter' );
 }
?>