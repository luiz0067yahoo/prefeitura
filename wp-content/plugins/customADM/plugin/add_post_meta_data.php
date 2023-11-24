<?php 


add_action('load-post.php', 'utm_post_meta_boxes_setup');
add_action('load-post-new.php', 'utm_post_meta_boxes_setup');

function utm_post_meta_boxes_setup()
{
    add_action('add_meta_boxes', function(){
		  add_meta_box(
			'term_id',
			'Post Pricipal da Categoria',
			function ($post){
				wp_nonce_field(basename(__FILE__), 'utm_post_class_nonce'); 
			?>
				<div class="components-base-control editor-post-excerpt__textarea">
					<div class="components-base-control__field">
						<label class="components-base-control__label" for="event-id">Selecione A Categoria Para O Post Principal </label>
						<select name="term_id_" id="term_id_" class="w-75">
							<option value="" class="w-75">Nenhum</option>
							<?php
							global $wpdb;
							global $wp_query;
							global $wpdb;
							$id_category_ = "";
							$tabela_nome = $wpdb->prefix . 'terms';
							$resultado = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabela_nome WHERE(id_post= %d)",$post->ID));
							foreach ($resultado as $valor) {
								$id_category_ = $valor->term_id;
							}
							$resultado =  get_the_category($post->ID );
							foreach ($resultado as $category ) {
								$cat_ID        = (int) $category->term_id;
								$category_name = $category->name;
							
							?>
								<option value="<?php echo $cat_ID; ?>" class="w-75" <?php if ($cat_ID == $id_category_) echo "selected"; ?>>
									<?php echo $category_name ?>
								</option>
								
							<?php } ?>
						</select>
					</div>
				</div>
			<?php },
			'post',
			'side',
			'default'
		);
		
		add_meta_box(
			
			'show_title',
			'Mostrar Título',
			function ($post){
				wp_nonce_field(basename(__FILE__), 'utm_post_class_nonce'); 
			?>
				<div class="components-base-control editor-post-excerpt__textarea">
					<div class="components-base-control__field">
						<label class="components-base-control__label" for="term_id">Mostrar Título</label>
						<input type="checkbox" name="show_title" id="show_title" 
									<?php
										$show_title = get_post_meta( $post->ID, 'show_title', true );
										if($show_title!="on")	echo "checked";
										
									?>
						 >
					</div>
				</div>
			<?php },
			'post',
			'side',
			'default'
		);
		add_meta_box(
			
			'home_show',
			'Exibir na Página Inicial',
			function ($post){
				wp_nonce_field(basename(__FILE__), 'utm_post_class_nonce'); 
			?>
				Selecione o intervalo de datas para exibir na Página Inicial
				<div class="components-base-control editor-post-excerpt__textarea">
					<?php
						$home_show_start = get_post_meta( $post->ID, 'home_show_start', true );
						$home_show_end = get_post_meta( $post->ID, 'home_show_end', true );
					?>
					<div class="components-base-control__field">
						<label class="components-base-control__label" style="width:100px" >Hora início </label>
						<input type="date" name="home_show_start" id="home_show_start" value="<?php echo $home_show_start;?>">
					</div>
					<div class="components-base-control__field">
						<label class="components-base-control__label"  style="width:100px">Hora fim </label>
						<input type="date" name="home_show_end" id="home_show_end" value="<?php echo $home_show_end;?>">
					</div>
				</div>
				<hr>
				Informe a ordem que deseja que apareça na Página Inicial
				<div class="components-base-control editor-post-excerpt__textarea">
					<?php
						$order = get_post_meta( $post->ID, 'order', true );
					?>
					<div class="components-base-control__field">
						<label class="components-base-control__label" style="width:100px" >Ordem</label>
						<select class="w-75" name="order" id="order">
							<?php for($i=1;$i<=10;$i++){?>
							<option value="<?php echo $i ;?>" <?php if($order==$i) echo "selected";?>><?php echo $i ;?></option>
							<?php } ?>
						<select>
					</div>
					<hr>
					<div class="components-base-control__field">
						Se houver duas orderns iguais no mesmo intervalo o sistema mostra a última postagem por primeiro
					</div>
				</div>
			<?php },
			'post',
			'side',
			'default'
		);
	});
    add_action('save_post', 'save_category_main_post', 10, 2);
    add_action('save_post', 'save_event_post', 10, 2);
    add_action('save_post', 'save_show_title', 10, 2);
    add_action('save_post', 'save_home_show', 10, 2);
}





function save_category_main_post($post_id, $post)
{
/*ALTER TABLE `."$wpdb->prefix".terms` ADD `id_post` INT NULL AFTER `term_id`;*/
	

    $term_id_ = (isset($_POST['term_id_']) ? $_POST['term_id_'] : '');
	global $wpdb;
	$tabela_nome = $wpdb->prefix . 'terms';

	$wpdb->update(
		$tabela_nome,
		array(
			'id_post' => null
		),
		array('id_post' => $post_id)
	);
	$wpdb->update(
		$tabela_nome,
		array(
			'id_post' => $post_id
		),
		array('term_id' => $term_id_)
	);
    
}




function save_show_title($post_id, $post)
{
    $show_title = (isset($_POST['show_title']) ? $_POST['show_title'] : '');
	if(empty($show_title))
		$show_title="off";
	delete_post_meta($post_id, "show_title");
    add_post_meta($post_id, "show_title", $show_title,true);
    update_post_meta($post_id, "show_title", $show_title);
}

function save_home_show($post_id, $post)
{
    $home_show_start = (isset($_POST['home_show_start']) ? $_POST['home_show_start'] : '');
	//if(!empty($home_show_start))$home_show_start=date('Y-m-d', strtotime($home_show_start));
	delete_post_meta($post_id, "home_show_start");
    add_post_meta($post_id, "home_show_start", $home_show_start,true);
    update_post_meta($post_id, "home_show_start", $home_show_start);
    
	$home_show_end = (isset($_POST['home_show_end']) ? $_POST['home_show_end'] : '');
	//if(!empty($home_show_end))$home_show_end=date('Y-m-d', strtotime($home_show_end));
	delete_post_meta($post_id, "home_show_end");
    add_post_meta($post_id, "home_show_end", $home_show_end,true);
    update_post_meta($post_id, "home_show_end", $home_show_end);
	
	$order = (isset($_POST['order']) ? $_POST['order'] : '');
	delete_post_meta($post_id, "order");
    add_post_meta($post_id, "order", $order,true);
    update_post_meta($post_id, "order", $order);
}
?>