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

global $wpdb;
$show_news=false;
$show_title=false;
$background_color="#01913a";
$title_color="#FFFFFF";
$image_background_id=null;
$tabela_nome = $wpdb->prefix . 'terms';
$sql = "SELECT id_post,title_color,show_news,show_title,background_color,image_background_id FROM $tabela_nome WHERE($tabela_nome.term_id=%d)";

	$resultado = $wpdb->get_results($wpdb->prepare($sql,get_the_category()[0]->term_id));
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
<?php 	if((!is_category())&&((isset($image_background_id))||($show_title==1))){ ?>
		<header class=" level-1 headCategory container-fluid" style="overflow-x:hidden;background-color:<?php echo $background_color;?>;background-image:url('<?php if(isset($image_background_id)) echo wp_get_attachment_image_url ( $image_background_id, 'full' );?>')">
			<h1 style="color:<?php echo $title_color;?>"> <?php if($show_title==1){ ?><?php echo (get_the_category())[0]->name;?><?php } ?> </h1>
		</header>
<?php  }  ?>


<div>&nbsp;</div> 
<div class="container text-center">
		
<?php 
$title=get_the_title();
$show_title=get_post_meta(get_the_ID(), "show_title",true);

if(
	
	(isset($title))
	&&
	(!empty($title))
	&&
	(strlen($title)>0)
	&&
	(isset($show_title)&&($show_title!="off"))
	){
?>
	<h1 class="title"><?php the_title();  ?></h1>
<?php } ?>
	<?php
		if (get_the_category(get_the_ID())[0]->slug == "noticias") {?>
			<h6  style="color:var(--cor-2);"><?php the_author();?> | <?php the_date();  ?></h6>
			<h2 class="mt-0 text-uppercase" style="color:var(--cor-2);font-family: Panton-Bold; font-size: 12.9px">
			<?php 
				$all_tags=get_the_tags(get_the_ID());
				$tags_str=implode(" #",array_column($all_tags, 'name')); 
				array_multisort(
					array_column(get_the_tags(get_the_ID()),"term_taxonomy_id"),
					SORT_ASC,
					$all_tags,
				);
				if(strlen($tags_str)>0)
					echo "#".$tags_str; 
			?>
			</h2> 
			<hr class="m-1">
	<?php		
		}
	?>
	<div>&nbsp;</div>
	<?php the_content();?>
	
</div> 
