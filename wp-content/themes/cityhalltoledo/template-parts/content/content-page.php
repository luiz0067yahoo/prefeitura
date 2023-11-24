<?php
/**
 * Template part for displaying posts
 *
  * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */

?>
<?php 
$title=get_the_title();
$show_title=get_post_meta(get_the_ID(), "show_title");
if(
	
	(isset($title))
	&&
	(!empty($title))
	&&
	(strlen($title)>0)
	&&
	($show_title=="on")
	){
?>
	<h1 class="title">a<?php the_title(); the_ID();?></h1>
<?php } ?>
<?php the_content();?>
