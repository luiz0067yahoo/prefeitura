<?php	// Get the current queried object
	$menu = get_terms( 'nav_menu', array(
		'hide_empty' => false,
		'name'=>"topo",
		'hide_empty' => 0
	)); 
	$menu_term_id= (int) $menu[0]->term_id;
	$items = wp_get_nav_menu_items($menu_term_id,array("object"=>"category",'hide_empty' => 0));
	?>
	<div id="navbarSupportedContent" class="accordion collapse color-0 bg-1">
		<?php foreach ($items as $item) {
				$target="";
				$cat_ID        = (int) $item->object_id;
				$category_name = $item->title;
				$url= $wpdb->get_var($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d limit 1",$item->object_id)); 
				if(!isset($url) || empty($url)){$url= get_category_link($cat_ID);}
				if(strpos($url,"novosite.toledo.pr.gov.br")=== false){
					$target='target="_blank"';
				}
				if (strtolower($category_name) != 'sem categoria') { 
					$count = 0;
					$categories = get_categories(array(
						'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
						'orderby'    => 'id',
						'parent'     => $cat_ID,
						'hide_empty' => 0, // change to 1 to hide categores not having a single post
					));
				?>
				<div class="accordion-item">
						<a class="text-decoration-none" <?php echo $target; if(count($categories)==0){?>href="<?php echo $url?>"<?php }?>><h2 class="accordion-header " id="heading_<?php echo $cat_ID; ?>">
							<button class="bg-1 color-0 accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $cat_ID; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $cat_ID; ?>">
								<?php echo  $category_name; ?>
							</button>
						</h2><a>
					<div id="collapse_<?php echo $cat_ID; ?>" class="accordion-collapse collapse" aria-labelledby="heading_<?php echo $cat_ID; ?>" data-bs-parent="#navbarSupportedContent">
						<div class="accordion-body p-0">
							<?php
							

							foreach ($categories as $sub_category) {
								$target="";
								$url= $wpdb->get_var($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d limit 1",$sub_category->term_id)); 
								if(!isset($url) || empty($url)){$url= get_category_link($sub_category->term_id);}
								if(($sub_category->slug==$url)&&(strpos($url,"novosite.toledo.pr.gov.br")==-1)){
									$target='target="_blank"';
								}
								
							?>
								<a class="navbar-item-mobile-home border border-success" href="<?php echo $url;?>" <?php echo $target;?> >
									<?php echo $sub_category->name; ?>
								</a>
							<?php

							}
							?>
						</div>
					</div>
				</div>
		<?php		}
		}	?>
	</div>