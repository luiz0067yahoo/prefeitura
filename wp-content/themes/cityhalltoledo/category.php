<?php

/**
 * The sigle for our theme
 * The sigle or multiple post(s) template file
 *
 * 
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */
$category = get_queried_object();
$category_base=get_option("category_base");
$category_base=($category_base== ".") ? "" : (($category_base=="") ? "category/" : $category_base."/");
$category_slug_pos=strpos($_SERVER['REQUEST_URI'],$category_base);
$category_slug= substr($_SERVER['REQUEST_URI'],$category_slug_pos+strlen($category_base),-1);
$categories_parent=explode("/",$category_slug);
$level=count($categories_parent)-1;
$param   = ( is_front_page() ) ? 'page' : 'paged';
$paged   = ( get_query_var( $param ) ) ? get_query_var( $param ) : 1;
if(get_query_var( $param ))
	$level=$level-2;

if ((isset($category_slug))&&($category_slug=="municipio/orgao-oficial")){
	get_header();
	require_once (get_template_directory() .  "/template-parts/categories/orgao_official.php");
	get_footer();
}
else if ((isset($category_slug))&&($category_slug=="noticias-e-agenda/agenda")){
	get_header();
	require_once (get_template_directory() .  "/template-parts/categories/agenda.php");
	get_footer();
	
}
else if(($level>=2)&&($categories_parent[0]=="servicos")&&($categories_parent[1]=="turismo")){
	get_header();
	require_once (get_template_directory() .  "/template-parts/categories/turismo.php");
	get_footer();
} 
else if(($level>=1)&&($categories_parent[0]=="portais")&&($categories_parent[1]=="guarda-municipal")){
	require_once (get_template_directory() .  "/custom_page/gm_toledo/index.php");
} 
else{
	get_header();
	$id_post=0;
	$show_news=false;
	$show_title=false;
	$background_color="#01913a";
	$title_color="#FFFFFF";
	$image_background_id=null;
	$tabela_nome = $wpdb->prefix . 'terms';
	$sql = "SELECT id_post,title_color,show_news,show_title,background_color,image_background_id FROM $tabela_nome WHERE($tabela_nome.term_id=%d)";
	$resultado = $wpdb->get_results($wpdb->prepare($sql,$category->term_id));
	foreach ($resultado as $valor) {
		$id_post=$valor->id_post;
		$show_news=$valor->show_news;
		$show_title=$valor->show_title;
		$background_color=$valor->background_color;
		$image_background_id=$valor->image_background_id;
		$title_color=$valor->title_color;
	}
	$content_post = get_post($id_post);
	?>
<?php 	if((isset($image_background_id))||($show_title==1)){ ?>
		<header class="level-1 headCategory container-fluid" style="overflow-x:hidden;background-color:<?php echo $background_color;?>;background-image:url('<?php if(isset($image_background_id)) echo wp_get_attachment_image_url ( $image_background_id, 'full' );?>')">
			<h1 style="color:<?php echo $title_color;?>"> <?php if($show_title==1){ ?><?php echo single_cat_title( '', false ) ;?><?php } ?> </h1>
		</header>
<?php  } ?>
<?php
		$show_title=get_post_meta($id_post, "show_title",true);
		if(($show_title=="on")&&(isset($id_post))&&(isset($content_post->post_title))&&(! empty($content_post->post_title))){?>
		<div class="container ">
			<div class="row mt-5">
				<p style="text-align:center; font-size: 40px; margin-bottom: 0;" class="w-100"><?php if(isset($id_post))echo $content_post->post_title ;?></p>
				<hr style="width: 35%; margin: auto; height: 4px; margin-bottom: 20px; opacity:unset; background-color: var(--cor-4);">
			</div>
		</div>
<?php 	} 
			$cat_id_parent_list_categories=$category->term_id ;
			require_once(get_template_directory() .  "/template-parts/header/menu-inner.php");
?>	
		<div class="container mt-4 ">
			<?php if(isset($id_post)) echo $content_post->post_content;?>
			<?php 
			if($show_news==1){?>
				<h3 class="d-none" style="font-size: 30px;">NOTÍCIAS RELACIONADAS</h3>
				<hr class=" d-none separator-green float-left d-block mx-0 " style="width:40px;">
				<?php
				
				$args    = array(
					'paged'       => $paged,
					'post_type' => array('post-event','post'),
					'category__not_in'=>-1,
					'category__in' =>  [$category->term_id],
					//'category__and' => 'category', //must use category id for this field
					//'tag__in' => 'post_tag', //must use tag id for this field
					'numberposts' => 9,
					'post_status'      => 'publish',
					'order'       => 'DESC'
				);
				require_once (get_template_directory() .  "/template-parts/content/content-list.php");
			}
?>
			</div> 
<?php			
	get_footer();
	}
?>