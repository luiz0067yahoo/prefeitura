<?php $search=(isset($_GET["search"]))?$_GET["search"]:"";?>
<?php require_once (get_template_directory() .  "/template-parts/categories/turismo/head-turismo.php");?>
		<div class="container ">
            <h1 class="text-center w-100 mt-4   " style="text-transform: uppercase;"><a class="color-1" href="<?php echo get_category_link($cat_id_level_1);?>" style="font-family:inherit;text-decoration:none;"><?php echo get_cat_name($cat_id_level_1); ?></a></h1>
            <hr style="margin-top:20px; margin-bottom: 20px;margin-left:auto;margin-right:auto; max-width: 50%;">            
            <?php if((isset($id_post))&&(isset($content_post->post_title))&&(! empty($content_post->post_title))){?>
                <div class="row mt-5">
                    <p style="text-align:center; font-size: 40px; margin-bottom: 0;" class="w-100"><?php if(isset($id_post))echo $content_post->post_title ;?></p>
                    <hr style="width: 35%; margin: auto; height: 4px; margin-bottom: 20px; opacity:unset; background-color: var(--cor-4);">
                </div>
            <?php } ?>
		</div>
        <?php
            $id_post=null;
            $resultado = $wpdb->get_results($wpdb->prepare("SELECT id_post FROM {$wpdb->prefix}terms WHERE({$wpdb->prefix}terms.term_id=%d)",$category->term_id));
            if (isset($resultado) && !empty($resultado) && is_array($resultado) && count($resultado)>=1) 
                $id_post=$resultado[0]->id_post;
            $content_post = get_post($id_post);
            $show_title=get_post_meta($id_post, "show_title",true);
            if(($show_title=="on")&&(isset($id_post))&&(isset($content_post->post_title))&&(! empty($content_post->post_title))){?>
                <div class="container ">
                    <div class="row mt-5">
                        <p style="text-align:center; font-size: 40px; margin-bottom: 0;" class="w-100"><?php if(isset($id_post))echo $content_post->post_title ;?></p>
                        <hr style="width: 35%; margin: auto; height: 4px; margin-bottom: 20px; opacity:unset; background-color: var(--cor-4);">
                    </div>
                </div>
        <?php } ?>
        <?php require_once (get_template_directory() .  "/template-parts/header/menu-inner.php");?>	
    <div id="empresas" class="container mt-4 ">
        <?php if(isset($id_post)) echo $content_post->post_content;?>
        <?php if($cat_id_level_2!=0){ ?>
        <h1 class="text-center w-100" style="text-transform: uppercase;"><?php echo get_cat_name($cat_id_level_2); ?></h1>
        <?php } ?>
        <form><div class="input-group mb-4 mx-auto" style="width: 400px;min-width:260px;">
            <input value="<?php if (isset($search) && !empty($search)) echo $search; ?>" type="search" name="search" class="form-control color-1" placeholder="buscar" style="border:5px solid var(--cor-3); background-color: var(--cor-3); text-align:center;" onfocus="this.placeholder=''" onfocusout="this.placeholder='O que você procura?'">
            <button class="btn-social" id="search-addon" style="height: 46px; min-width: 40px;margin: auto; box-shadow: none;border:1px solid var(--cor-3) ">
                <i class="fa fa-search"></i>
            </button>
        </div></form>


			
		<?php 
		$resultado = $wpdb->get_results($wpdb->prepare("SELECT id_post,title_color,show_news,show_title,background_color,image_background_id FROM $tabela_nome WHERE($tabela_nome.term_id=%d)",$cat_id_level_2));
		if(isset($resultado) && !empty($resultado) && is_array($resultado) && count($resultado)>0) 
			$show_news=$resultado[0]->show_news;
		


 
		global $post;
		$count = 0;
		$param   = ( !is_front_page() ) ? 'page' : 'paged';
		$paged   = ( get_query_var( $param ) ) ? get_query_var( $param ) : 1;
		$page =$paged;
		$args    = array(
			'paged'       => $paged,
			'post_type' => 'empresa',
			's' => $search,
			'cat' =>  $cat_id_level_2,
			'numberposts' => 20,
			'post_status' => 'publish',
			'orderby' => 'title',
			'order' => 'ASC',
		);
		$the_query = new WP_Query( $args );
		$total=$the_query->found_posts;
		if(($show_news==1)&&($total>0)){ 
		?>
        <div class="row  w-100 d-flex">
            <div class="w-50  ps-0 pe-2">
                <div class="accordion w-100 accordion-col" id="accordionSection_empresa_0_left_0">
                <?php 
                    for ($i=0;$i<min(10,$total);$i++){ 
                        $the_query->the_post();
                ?> 
                    <div class="accordion-item accordion-flush  bg-3">
                        <h2 class="accordion-header accordion">
                        <button type="button" class="accordion-button collapsed bg-3 color-1" data-bs-toggle="collapse" data-bs-target="#collapse_empresas_0_<?php echo $i; ?>">
                            <i class="far fa-question-circle color-4"></i> &nbsp; <?php the_title();?>
                        </button>
                        </h2>
                        <div class="accordion-collapse collapse border" id="collapse_empresas_0_<?php echo $i; ?>" data-bs-parent="#accordionSection_empresa_0_left_0">
                        <div class="accordion-body bg-0 color-1">
                            <?php  the_content();?>
                        </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
			<?php if($total>10){ ?>
            <div class="w-50 ps-2 pe-0">
                <div class="accordion w-100 accordion-col" id="accordionSection_empresa_0_right_1">
                    <?php for ($i=10;$i<min(20,$total);$i++){ 
                        if(!$the_query->have_posts());
                            break;
                        $the_query->the_post();
                    ?> 
                    <div class="accordion-item accordion-flush  bg-3">
                        <h2 class="accordion-header accordion">
                            <button type="button" class="accordion-button collapsed bg-3 color-1" data-bs-toggle="collapse" data-bs-target="#collapse_empresa_1_<?php echo $i; ?>">
                            <i class="far fa-question-circle color-4"></i> &nbsp; <?php the_title();?>
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse border" id="collapse_empresa_1_<?php echo $i; ?>" data-bs-parent="#accordionSection_empresa_0_right_1">
                        <div class="accordion-body bg-0 color-1">
                            <?php  the_content();?>
                        </div>
                        </div>
                    </div>
                    <?php } ?> 
                </div>
            </div>
			<?php 	} ?>
        </div>
		<?php } ?>
</div>
<?php 
 get_template_part('template-parts/footer/footer', 'paginate'); 


?> 