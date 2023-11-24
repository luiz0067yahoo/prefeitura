<?php
/**
 * The template for displaying all single posts
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>  style="margin-top:0px!important;">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<link href="<?php bloginfo('template_url'); ?>/css/all.css" rel="stylesheet">
	<link href="<?php bloginfo('template_url'); ?>/css/simpleLightbox.css" rel="stylesheet">
	<link href="<?php bloginfo('template_url'); ?>/style.css.php" rel="stylesheet">
	<?php wp_head(); ?>   
</head>
<body style="padding: 0 0 0 0;margin-top:0px!important;">
<?php

while ( have_posts() ) {
    the_post();
    get_template_part( 'template-parts/content/content', 'page' );
}
?>
		<script src="<?php bloginfo('template_url'); ?>/js/jquery-3.4.1.min.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/popper.min.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/bootstrap.bundle.min.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/sweetalert2@9.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/simpleLightbox.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/pdf.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/pdf.worker.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/chart.min.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/home.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/error404.js"></script>
	</body>
</html>
<?php