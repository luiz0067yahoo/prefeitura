<?php
    $category = get_queried_object();
    $cat_id_top_level=0;
    $cat_id_level_1=0;
    $cat_id_level_2=0;
    $cat_id_parent_list_categories=0;
    if (get_cat_name($category->parent)=="Turismo"){
        $cat_id_top_level=$category->parent;
        $cat_id_level_1=$category->term_id;
        $cat_id_parent_list_categories=$cat_id_level_1;
    }
    else if (get_cat_name(get_category($category->parent)->parent)=="Turismo"){
        $cat_id_level_2=$category->term_id;
        $cat_id_level_1=$category->parent;
        $cat_id_top_level=get_category($category->parent)->parent;
        $cat_id_parent_list_categories=$cat_id_level_1;
    }
    $id_post=0;
    $show_news=false;
    $show_title=false;
    $background_color="#01913a";
    $title_color="#FFFFFF";
    $image_background_id=null;
    $tabela_nome = $wpdb->prefix . 'terms';
    $sql = "SELECT id_post,title_color,show_news,show_title,background_color,image_background_id FROM $tabela_nome WHERE($tabela_nome.term_id=%d)";
    $resultado = $wpdb->get_results($wpdb->prepare($sql,$cat_id_top_level));
    foreach ($resultado as $valor) {
        $id_post=$valor->id_post;
        $show_news=$valor->show_news;
        $show_title=$valor->show_title;
        $background_color=$valor->background_color;
        $image_background_id=$valor->image_background_id;
        $title_color=$valor->title_color;
        break;
    }
    $category_slug=get_category(get_category($cat_id_top_level)->parent)->slug."/".get_category($cat_id_top_level)->slug."/".get_category($cat_id_level_1)->slug;
	if((isset($image_background_id))||($show_title==1)){?>
		<header class="<?php echo "level-".$level;?> headCategory container-fluid" style="overflow-x:hidden;background-color:<?php echo $background_color;?>;background-image:url('<?php if(isset($image_background_id)) echo wp_get_attachment_image_url ( $image_background_id, 'full' );?>')">
			
				<h1 style="color:<?php echo $title_color;?>"><a href="<?php echo get_category_link($cat_id_top_level);?>" style="color:<?php echo $title_color;?>;font-family:inherit;text-decoration:none;"> <?php if($show_title==1){  echo get_cat_name($cat_id_top_level);} ?> </a></h1>
			
		</header>
<?php  } ?>