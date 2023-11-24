<?php 
			
			global $wpdb;
			$resultado =null;
			$total=0;
			$page=max(1,
				(
					(isset($_GET["paged"]))
					? $_GET["paged"]
					: (
						(isset($_POST["paged"]))
						? $_POST["paged"]
						: 0
					)
				)
			);

			$rows_per_page=10;
			
			$search="%%";
			if(isset($_GET["search"]))
				$search=strtoupper("%".$_GET["search"]."%");

			$eventDate= date('Y-m-d');
			if(isset($_GET["eventDate"]))
				$eventDate=$_GET["eventDate"];

			if(isset($_GET["startDate"])&&($_GET["startDate"]=="true")){
				$total = $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM {$wpdb->prefix}cadastro_eventos  WHERE(UPPER(nome_do_evento) LIKE %s OR UPPER(categoria_evento) LIKE %s)and (%s <=  data_inicial )  ORDER BY data_inicial ASC",$search,$search,$eventDate));
				$offset = ($page - 1) * $rows_per_page;
				$resultado = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}cadastro_eventos  WHERE(UPPER(nome_do_evento) LIKE %s OR UPPER(categoria_evento) LIKE %s)and (%s <=  data_inicial )  ORDER BY data_inicial ASC limit {$offset}, $rows_per_page",$search,$search,$eventDate));
            }
			else{
				$total = $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM {$wpdb->prefix}cadastro_eventos  WHERE(UPPER(nome_do_evento) LIKE %s OR UPPER(categoria_evento) LIKE %s) and (((data_final is null) and (data_inicial=%s))OR(NOT(data_final is null) and (%s BETWEEN data_inicial AND data_final))) ORDER BY data_inicial ASC",$search,$search,$eventDate,$eventDate));
				$offset = ($page - 1) * $rows_per_page;
				$resultado = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}cadastro_eventos  WHERE(UPPER(nome_do_evento) LIKE %s OR UPPER(categoria_evento) LIKE %s) and (((data_final is null) and (data_inicial=%s))OR(NOT(data_final is null) and (%s BETWEEN data_inicial AND data_final))) ORDER BY data_inicial ASC limit {$offset}, $rows_per_page",$search,$search,$eventDate,$eventDate));
			}
			
			$url="";
			if($resultado!=null)
			foreach ($resultado as $valor){
				$url="#";
				$post_id=$valor->post_id;
				if (isset($post_id)&& !empty($post_id)){
					$url=get_permalink($post_id);
				}
				?>
				<div class="block-by- block-by-3">
					<a class="tooCard w-100" style="text-align: center;" href="<?php echo $url;?>">
						<div class="tooCardTxt">
							<h4><?php echo date('d/m/Y', strtotime($valor->data_inicial)); ?><?php if(isset($valor->data_final)&& !empty($valor->data_final)) echo " a ".date('d/m/Y', strtotime($valor->data_final)); ?></h4>
							
							<h6><?php echo date('H:i', strtotime($valor->horario_inicial)); ?><?php if(isset($valor->horario_final)&& !empty($valor->horario_final))echo date('H:i', strtotime($valor->horario_final)); ?></h6>
							<hr style="margin-top: 20px;margin-bottom: 20px;">
							<h5 style="text-align: center;"><?php echo $valor->categoria_evento; ?></h5>
							<h2><?php echo $valor->nome_do_evento; ?></h2>
						</div>
					</a>
				</div>
            <?php } ?>
			<div class="block-by-3" style="min-height:1px"></div>
			<div class="block-by-3" style="min-height:1px"></div>

<hr style="margin-top:40px; margin-bottom: 20px;margin-left:auto;margin-right:auto; max-width: 50%;">

		
		<nav>
		  <div class="pagination justify-content-center pagination pagination-lg" style="margin:20px;">
			<section class="pager m-50 ">
			  <div class="row">
				<div>
				  <?php
				  global $wp_query;
				  $big = 999999999; // need an unlikely integer
				  $links = paginate_links(array(
					'base'      => str_replace($big, '%#%', get_pagenum_link($big)),
					'format'    => '?paged=%#%',
					'current'   => $page,
					'total'     => ceil($total/$rows_per_page),
					'prev_text' => __('<div class="page-link pull-left"><<</div>', 'multi'),
					'next_text' => __('<div class="page-link pull-right ">>></div>', 'multi'),
					'type'      => 'array'
				  ));
				  ?>
				  <?php

				  if (isset($links) && (count($links) > 0)) { ?>
					<div class=" archive-navigation">
					  <?php foreach ($links as $link) { ?>
						<?php echo $link; ?>
					  <?php }; ?>
					</div>
				  <?php }

				  ?>
				  <!-- End of blog-pagination -->
				</div>
			  </div>
		  </div>
		</nav>	