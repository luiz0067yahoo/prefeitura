<?php
$menu = get_terms('nav_menu', array(
	'hide_empty' => false,
	'name' => "destaque",
	'hide_empty' => 0
));
$menu_term_id = (int) $menu[0]->term_id;
$items = wp_get_nav_menu_items($menu_term_id, array("object" => "category", 'hide_empty' => 0));
$count_item = 0;
?>
<div class="menu_destaque">
	<div class="mt-4">
		<h2 id="destack-title" class="risquinhoTitulos" style="color:#333333!important;"><img src="<?php bloginfo('template_url'); ?>/images/toledoconexao.png" alt="" style="width: 250px"></h2>
	</div>
	<div class="container">
		<div class="menu_destaque-scroll">
			<div class=" menu_destaque-screen">
				<?php
				foreach ($items as $item) {
					$target = "";
					$cat_ID        = (int) $item->object_id;
					$category_name = $item->title;
					$url = $wpdb->get_var($wpdb->prepare("SELECT external_url FROM {$wpdb->prefix}terms WHERE term_id=%d ", $cat_ID));
					if (!isset($url) || empty($url)) {
						$url = get_category_link($cat_ID);
					}
					if (strpos($url, "novosite.toledo.pr.gov.br") === false) {
						$target = 'target="_blank"';
					}
					if (strtolower($category_name) != 'sem categoria') {
						if ($count_item == 0) {
				?>
							<div class="menu_destaque-inner">
							<?php
						}
						$count_item++;
							?>
							<a href="<?php echo $url; ?>" class="text-decoration-none menu_destaque_btn" <?php echo $target; ?>>
								<?php
								global  $wpdb;
								$tabela_nome = $wpdb->prefix . 'terms';
								$sql = "SELECT image_icon_id FROM $tabela_nome WHERE($tabela_nome.term_id=$cat_ID)";
								$resultado = $wpdb->get_results($sql);
								$image_icon_id = null;
								if ((count($resultado) > 0) && (isset($resultado[0]->image_icon_id)))
									$image_icon_id = $resultado[0]->image_icon_id;

								?>

								<?php if ($image_icon_id) { ?>
									<div class="w-100"><?php echo file_get_contents(get_attached_file($image_icon_id), true); ?></div>

								<?php } ?>
								<div class="txt"><?php echo $category_name; ?></div>
							</a>
						<?php

					}
				}
				if ($count_item > 0) {
						?>
							</div>
						<?php			} ?>


			</div>
		</div>
	</div>
</div>