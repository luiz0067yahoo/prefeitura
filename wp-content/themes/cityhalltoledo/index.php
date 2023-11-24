<?php

/**
 * The header for our theme
 * The main template file
 *
 * 
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */
if((isset($_GET["systempage"]))&&($_GET["systempage"]=="eventos")){
	require_once (get_template_directory() .  "/template-parts/content/event/event-list.php");
}
else if((isset($_GET["systempage"]))&&($_GET["systempage"]=="download")){
	download();
}
else
{
	get_header();
	if ( is_home() ) {		
		get_template_part( 'template-parts/content/content','home' );
	}

	get_footer();
}