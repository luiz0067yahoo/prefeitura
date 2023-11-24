	<div class="container">
			<div class="mx-auto d-flex flex-wrap justify-content-center mt-4" style="max-width:540px;">
				<?php
					
					$categories = get_categories(array(
						'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
						'orderby'    => 'id',
						'parent'     => $cat_id_parent_list_categories,
						'hide_empty' => 0, // change to 1 to hide categores not having a single post
					));
					$count_sub_category=0;
					foreach ($categories as $sub_category) {
						$target="";

						$url= $wpdb->get_var($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d limit 1",$sub_category->term_id)); 
						if(!isset($url) || empty($url)){$url= get_category_link($sub_category->term_id);}
						if(substr($url, 0, 4) != 'http')
							$url=get_home_url()."/".$category_base.$category_slug;
						if(strpos($url,"novosite.toledo.pr.gov.br")==-1){
							$target='target="_blank"';
						}
						$sub_category_name=$sub_category->name;
						$sub_cat_ID=$sub_category->term_id;
						global  $wpdb;
						$tabela_nome = $wpdb->prefix . 'terms';
						$sql="SELECT image_icon_id FROM $tabela_nome WHERE($tabela_nome.term_id=%d)";
						$resultado = $wpdb->get_results($wpdb->prepare($sql,$sub_cat_ID));
						$image_icon_id=null;
						if((count($resultado)>0) && (isset($resultado[0]->image_icon_id)))
						$image_icon_id=$resultado[0]->image_icon_id;
					
					?>
				<a href="<?php echo $url;?>" class="menu_destaque_categoria_btn" >
					<?php if ( $image_icon_id ) { ?>
						<div class="w-100"><?php echo file_get_contents(get_attached_file ( $image_icon_id ), true); ?></div>
					
					<?php } ?>
					<div class="txt"><?php echo $sub_category_name;?></div>
				</a>
				<?php
						
						$count_sub_category++;
					} 
					for($count=$count_sub_category;$count<12;$count++) 
					{
				?>
					<a class="menu_destaque_categoria_clean_btn" style="">
						
					</a>
				<?php } ?>
			</div>
		</div>