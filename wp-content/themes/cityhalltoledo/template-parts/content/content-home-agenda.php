<?php

/**
 * The home for our theme
 * The start template file
 *
 * 
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */
$table_name = $wpdb->prefix . 'cadastro_eventos';
$sql = "SELECT * FROM $table_name WHERE (CURRENT_DATE <= data_inicial) ORDER BY data_inicial desc limit 0,3 ";
$result = $wpdb->get_results($wpdb->prepare($sql));
if(count($result)>0){
?>
<h2 class="risquinhoTitulos" style="text-decoration: none !important;"><a style="text-decoration: none !important; 	color:var(--cor-1); font-family: Panton-Black;" href="https://novosite.toledo.pr.gov.br/ver/noticias-e-agenda/agenda/">Agenda</a></h2>
<div class="container">
	<div class="row">
		<?php
		$count=0;
		for($countReverse=count($result)-1;$countReverse>=0;$countReverse--) {
			$valor=$result[$countReverse];
			require(get_template_directory() .  '/template-parts/content/event/event-big.php');
		?>
			<a class="cdEvento gradient-box col mx-2 my-2 text-decoration-none color-1" href="<?php echo "#".$valor->nome_do_evento;//if(isset($valor->post_id)&& !empty($valor->post_id))echo get_permalink($valor->post_id); ?>" onclick="{$('#event-<?php echo $valor->id;?>').toggleClass('d-none');loadDimension;setTimeout(loadDimension,100);setTimeout(loadDimension,200);}">
				<div class="row">
					<div class="col-4 mt-3">
						<h6 class="catEvento" style="margin:-10px !important;"><?php echo $valor->categoria_evento; ?></h6>
						<h4><?php echo date('d/m', strtotime($valor->data_inicial)); ?></h4>
						<h4 style="margin-top: -10px;"><?php echo date('Y', strtotime($valor->data_inicial)); ?></h4>
						<h6><?php echo date('H:i', strtotime($valor->horario_inicial)); ?></h6>

					</div>
					<div class="col-1 m-auto">
						<div style="border: 1px solid  #01913a; width: 3px; height: 90px; background-color: #01913a;"></div>
					</div>
					<div class="col w-100 mt-2">
						<h2><?php echo $valor->nome_do_evento; ?></h2>
					</div>
				</div>
			</a>
		<?php 
			$count++;
		}
		for($i=$count;$i<3;$i++) {
		?>
		<a class=" col mx-2 my-2 text-decoration-none color-1" ></a>
		<?php	
		}			
		?>
	</div>
</div>
<?php } ?>