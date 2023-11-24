<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 * Template Post Type: post, page, evento
 */
$search_term="";
if(isset($_GET["s"]))
	$search_term=$_GET["s"];
$category = get_queried_object();
$cat_ID=isset($category->term_id)?$category->term_id:0;
$url_search=get_home_url();
if(isset($cat_ID)&& !empty($cat_ID)){
	$url_search=get_category_link($cat_ID);
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>  style="margin-top:0px!important;">

<head>
	<meta charset="<?php bloginfo('charset'); ?>"  />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<link href="<?php bloginfo('template_url'); ?>/css/all.css" rel="stylesheet">
	<link href="<?php bloginfo('template_url'); ?>/css/simpleLightbox.css" rel="stylesheet">
	<link href="<?php bloginfo('template_url'); ?>/style.css.php" rel="stylesheet">
	<link rel="stylesheet" href="https://use.typekit.net/xub8lda.css">
	
	
	<?php wp_head(); ?>   
</head>

<body >
	<div id="barraTopo" class="position-fixed w-100" style="background-color: #EEEEEE;z-index:39; ">
		<div class="accessibility-container mb-1 mt-1" style="width:440px">
			<button class="btn-social btn-social-text border dark-mode" id="contrast"><i class="fas fa-adjust"></i></button>
			<button class="btn-social btn-social-text border" name="decrease-font" id="decrease-font" title="Diminuir fonte">A-</button>
			<button class="btn-social btn-social-text border" name="increase-font" id="increase-font" title="Aumentar fonte">A+</button>
			<button id="mandar" class="btn-social btn-social-text border"><i class="fab fa-accessible-icon"></i> Acessibilidade</button>
			<!-- <a id="mapa-site" href="https://novosite.toledo.pr.gov.br/mapa-do-site/"><button class="btn-social btn-social-text border">Mapa do Site</button></a> -->
			<a target="_blank" href="http://toledo.eouve.com.br"><button class="btn-social btn-social-text border">Ouvidoria</button></a>
			<a target="_blank" href="http://equiplano.toledo.pr.gov.br:7474/transparencia/"><button class="btn-social btn-social-text border">Portal da Transparência</button></a>
		</div>
	</div>
	

	<div class="w-100 bg-0">
		<div class="container-fluid row justify-content-center menu-center py-2 " style="">
			<div class="row" style="height:45px">
			</div>
			<div class="text-center col-2 align-vertical mx-3" href="#" style="line-height:125%;min-width:200px;">
				<div style="width:160px;padding: 0 0 0 0;margin-left:auto;margin-right:auto">
					<a  id="logo-header" href="<?php echo get_home_url(); ?>"></a>

				</div>
			</div>





			<div class="header-search-container col mx-0 mt-4" style="box-shadow: none;">
				<form action="<?php echo $url_search;?>" role="search" method="get" id="searchform" class="searchform row row-cols-lg-auto justify-content-center">
					<div class="input-group mb-4" style="width: 80%;min-width:260px;">
						<input type="search" name="s" class="form-control color-1" placeholder="O que você procura?" style="border:5px solid var(--cor-3); background-color: var(--cor-3); text-align:center;"  onfocus="this.placeholder=''" onfocusout="this.placeholder='O que você procura?'" value="<?php if (isset($search_term)) echo $search_term;?>"/>
						<button class="btn-social" id="search-addon" style="height: 100%; min-width: 40px;margin: auto; box-shadow: none;border:1px solid var(--cor-3) ">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</form>
			</div>

			<div class="social-links-header-container col-1 mx-0 px-0 mt-1">
				<div class="social-links-header ">
					<a id="fcb" class="btn-social" target="_blank" href="https://pt-br.facebook.com/PrefeituraMunicipalToledo/"><i class="fab fa-facebook-f"></i></a>
					<a id="twi" class="btn-social" target="_blank" href="https://twitter.com/PrefsdeToledo"><i class="fab fa-twitter"></i></a>
					<a id="ins" class="btn-social" target="_blank" href="https://www.instagram.com/prefeituradetoledo/"><i class="fab fa-instagram"></i></a>
					<a id="you" class="btn-social" target="_blank" href="https://www.youtube.com/c/PrefeituradeToledoPR/"><i class="fab fa-youtube"></i></a>
				</div>
			</div>

		</div>
		<!-- Top Menu -->
	</div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center navbar-full" style="height:44px;">
		<div class="justify-content-center h-100 px-0;">
			<div class="social-links-mobile" style="margin: 6px">
				<a style="margin: 2px;  margin-left: 40px" id="fcb" target="_blank" href="https://pt-br.facebook.com/PrefeituraMunicipalToledo/"><i class="fab fa-facebook-f"></i></a>
				<a style="margin: 2px;" id="twi" target="_blank" href="https://twitter.com/PrefsdeToledo"><i class="fab fa-twitter"></i></a>
				<a style="margin: 2px;" id="ins" target="_blank" href="https://www.instagram.com/prefeituradetoledo/"><i class="fab fa-instagram"></i></a>
				<a style="margin: 2px;" id="you" target="_blank" href="https://www.youtube.com/c/PrefeituradeToledoPR/"><i class="fab fa-youtube"></i></a>
			</div>
			<div class=" w-100">
				<div class="container-fluid d-flex align-items-start">
					<button id="menuList" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="position: absolute; left: 15px; top: 2px; background: #01913A">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse">

						<?php get_template_part('template-parts/header/menu', 'desktop');?>


					</div>
				</div>
			</div>
		</div>

	</nav>
	<?php get_template_part('template-parts/header/menu', 'mobile');?>
	