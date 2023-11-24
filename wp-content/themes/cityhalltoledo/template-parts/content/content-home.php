<?php

/**
 * The home for our theme
 * The start template file
 *
 * 
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */

?>
<!-- inicio dos Botões de Destaque -->
<?php get_template_part('template-parts/header/menu', 'destack'); ?>
<!-- Fim dos Botões de Destaque -->
<!-- Imagem da Home -->
<?php require_once(get_template_directory().'/template-parts/content/content-home-slide-show-desktop.php'); ?>
<!-- Fim da Imagem da Home -->
<!-- Imagem da Home -->
<?php require_once(get_template_directory().'/template-parts/content/content-home-slide-show-mobile.php'); ?>
<!-- Fim da Imagem da Home -->
<!-- Agenda -->
<?php require_once(get_template_directory().'/template-parts/content/content-home-agenda.php'); ?>
<!-- Fim da Agenda -->
<!-- Notícias -->
<?php require_once(get_template_directory().'/template-parts/content/content-home-noticias.php'); ?>
<!-- FIM Notícias -->
<!-- Toledo em Fotos -->
<?php require_once(get_template_directory().'/template-parts/content/content-home-fotos.php'); ?>
<!-- Fim do Toledo em Fotos -->