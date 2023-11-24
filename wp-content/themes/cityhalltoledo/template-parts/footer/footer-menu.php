<?php
global $wpdb;
$menu = get_terms( 'nav_menu', array(
	'hide_empty' => false,
	'name'=>"rodape",
	'hide_empty' => 0
)); 
$menu_term_id= (int) $menu[0]->term_id;
$items = wp_get_nav_menu_items($menu_term_id,array("object"=>"category",'hide_empty' => 0));



			foreach ($items as $item)
			if($item->menu_item_parent==0) 
			{
				
				$cat_ID        = (int) $item->object_id;
				$category_name = $item->title;
				$category_base=get_option("category_base");
				$category_base=($category_base== ".") ? "" : (($category_base) ? "category/" : $category_base."/");
				$category_slug=get_category($cat_ID)->slug;
				$url= $wpdb->get_results($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d ",$cat_ID)); 
				if(empty($url))
					$url= get_category($cat_ID)->slug;
				if(substr($category_slug, 0, 4) != 'http')
					$url=get_home_url()."/".$category_base."/".$category_slug;
				if (strtolower($category_name) != 'sem categoria') { ?>
			<div teste="<?php echo $item->menu_item_parent;?>" class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
				<div class="menu" style="height:50px"> 
					<h5 class="text-uppercase mb-2 w-100" style="font-family: Panton-ExtraBold;"><?php echo $category_name;?></h5>
					<hr style="width: 150px; margin: auto; height:2px">
				</div>
				<div class="menu" style="margin-top: -10px;"> 
				
				<?php


					foreach ($items as $sub_category)
					if($sub_category->menu_item_parent==$item->ID) {
						$target="";
						$sub_cat_ID        = (int) $sub_category->object_id;
						$sub_category_name = $sub_category->title;
						$url= $wpdb->get_var($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d limit 1",$item->object_id)); 
						if(!isset($url) || empty($url)){$url= get_category($cat_ID)->slug;}
						$category_url=(get_option("category_base") == "/")? "category" : get_option("category_base")."/";
						if(substr($sub_category->slug, 0, 4) != 'http')
							$url=get_category_link($sub_cat_ID);
						
						if(strpos($url,"novosite.toledo.pr.gov.br")==-1){
							$target='target="_blank"';
						}
						?>
							<p class="w-100"><a href="<?php echo $url ;?>"><?php echo  $sub_category_name;?></a></p>
						<?php 
						
					}
					$count = 0;
					$categories = get_categories(array(
						'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
						'orderby'    => 'id',
						'parent'     => $cat_ID,
						'hide_empty' => 0, // change to 1 to hide categores not having a single post
					));

					foreach ($categories as $sub_category) {
						$url= $wpdb->get_var($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d limit 1",$item->object_id)); 
						if(!isset($url) || empty($url)){$url= $sub_category->slug;}
						$category_url=(get_option("category_base") == "/")? "category" : get_option("category_base")."/";
						if(substr($url, 0, 4) != 'http')
							$url=get_home_url()."/".$category_url.$category_slug."/".$sub_category->slug;
						
					?>
					<p class="w-100"><a <?php echo $target;?>href="<?php echo $url ;?>"><?php echo  $sub_category->name;?></a></p>
					<?php

					}
					
	
					?>
					
				</div>
			</div>
			<?php		}
		}
		
		?>

		
		