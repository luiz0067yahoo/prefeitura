<?php

/*
Plugin name: Custom ADM 
Plugin uri: https://github.com/luiz0067/toledoadm.git
Description: This plugin user control the layout of wp-admin 
Version: 1.0
Author: Luiz Fernando Brogliatto Ferreira
Author uri: https://www.linkedin.com/in/luiz-fernando-brogliatto-ferreira-2375047b/
License: GPLv2 or later
*/	

function custtomADM_CSS() { 
	wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css');
	wp_enqueue_style( 'bootstrapAll', plugin_dir_url( __FILE__ ) . 'css/all.css' );
	wp_enqueue_style( 'colorpicker', plugin_dir_url( __FILE__ ) . 'css/colorpicker.css' );
	wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'style.css.php' );
}
add_action( 'login_enqueue_scripts', 'custtomADM_CSS' ,10);
add_action('wp_before_admin_bar_render', 'custtomADM_CSS');

require_once plugin_dir_path( __FILE__ ) . 'plugin/permitSVG.php';
require_once plugin_dir_path( __FILE__ ) . 'plugin/blocks.php';
require_once plugin_dir_path( __FILE__ ) . 'plugin/customLogin.php';
require_once plugin_dir_path( __FILE__ ) . 'plugin/categoryImage.php';
require_once plugin_dir_path( __FILE__ ) . 'plugin/systems.php';


?>