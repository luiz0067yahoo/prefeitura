<?php	// Get the current queried object
			global $wpdb;		
					
					
					$menu = get_terms( 'nav_menu', array(
							'hide_empty' => false,
							'name'=>"topo",
							'hide_empty' => 0
						)); 
						$menu_term_id= (int) $menu[0]->term_id;
						$items = wp_get_nav_menu_items($menu_term_id,array("object"=>"category",'hide_empty' => 0));
						?>
						<ul class="navbar-nav">
							<?php foreach ($items as $item) {
								$target="";
								$cat_ID        = (int) $item->object_id;
								$category_name = $item->title;
								$url= $wpdb->get_var($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d limit 1",$item->object_id)); 
								if(!isset($url) || empty($url)){$url= get_category_link($cat_ID);}
								if(strpos($url,"novosite.toledo.pr.gov.br") === false){
									$target='target="_blank"';
								}
								if (strtolower($category_name) != 'sem categoria') { ?>
									<li class="nav-item dropdown hj">
										<a class="navbar-brand" href="<?php echo $url?>" <?php echo $target;?> >
											<?php echo  $category_name; ?>
										</a>
										<?php
										$have_sub_category = false;
										$categories = get_categories(array(
											'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
											'orderby'    => 'id',
											'parent'     => $cat_ID,
											'hide_empty' => 0, // change to 1 to hide categores not having a single post
										));
										foreach ($categories as $sub_category) {
											
											$target="";

											$url= $wpdb->get_var($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d limit 1",$sub_category->term_id)); 
											if(!isset($url) || empty($url)){$url= get_category_link($sub_category->term_id);}
											if(strpos($url,"novosite.toledo.pr.gov.br")=== false){
												$target='target="_blank"';
											}
										
											if ($have_sub_category == false) { ?>
												<ul class="dropdown-menu">
													<ul class="navbar-nav subnvabar justify-content-center">
													<?php } ?>
													<li class="lista"><a class="navbar-item" aria-current="page" href="<?php echo $url;?>" <?php echo $target;?>>
															<?php echo $sub_category->name; ?>
														</a></li>
												<?php
												$have_sub_category = true;
											}
											if ($have_sub_category == true) { ?>
													</ul>
												</ul>
											<?php } ?>

									</li>
							<?php		}
							}	?>
						</ul>