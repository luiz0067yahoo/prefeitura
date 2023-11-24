<div href="#<?php echo $valor->nome_do_evento;?>" class="<?php echo $classNameEventBanner;?> height-square p-2 mx-auto color-1 pe-auto"  onclick="{jQuery('#event-<?php echo $valor->id;?>').toggleClass('d-none');loadDimension;setTimeout(loadDimension,100);setTimeout(loadDimension,200);}" style="overflow-x:hidden"> 
	<?php 
		$classCSSName= " ";
		if(isset($valor->com_sem_informacoes) && $valor->com_sem_informacoes==0) $classCSSName .= " less-text ";
		if(isset($valor->preto_branco) && !empty($valor->preto_branco) && $valor->preto_branco==-1)  $classCSSName .= " color-1 ";
		else $classCSSName .= " color-0 ";
		if(isset($valor->com_sem_sombra) && !empty($valor->com_sem_sombra) && $valor->com_sem_sombra!=0) $classCSSName .= " event-text-shadow ";
	?>
	<div  class="viewImg<?php echo $valor->id;?> containerScheduleEvent w-100 height-square <?php  echo $classCSSName;?>" style="background-image:url('<?php echo  wp_get_attachment_image_url($valor->media_id,'large',false );?>');background-position-x:0<?php if(isset($valor->posicao))echo (100-$valor->posicao);?>%;"> 
		<div class="position-absolute dimenssion-parent">
			<div class="containerScheduleEventText  h-100 d-flex align-content-between flex-wrap">
				<div class="container-title-and-data-description ">
					<div class="category-title">
<?php 
$categoria_evento="";
if (isset($valor->categoria_evento) && !empty($valor->categoria_evento)){
	$categoria_evento="#".$valor->categoria_evento;
}
?>
						<p class="category">
							<?php echo $categoria_evento;?>
						</p>
						<p class="event-title" >
						<?php 
						if (strlen($valor->nome_do_evento)<33) 
							echo $valor->nome_do_evento;    
						else  
							echo substr($valor->nome_do_evento,0,33)."...";
						?>
						</p>
					</div>
					<div class="w-100"></div>
					<div class="data-description ">
						<p class="text-date">
							<?php if(isset($valor->data_inicial) && !empty($valor->data_inicial))echo date('d/m/Y', strtotime($valor->data_inicial)); ?>
							<?php if(isset($valor->data_final)&& !empty($valor->data_final)) echo " - ".date('d/m/Y', strtotime($valor->data_final)); ?>
						</p>
						<p class="text-hours">
							<?php if(isset($valor->horario_inicial)&& !empty($valor->horario_inicial)) echo date('H:i', strtotime($valor->horario_inicial)); ?>
							<?php if(isset($valor->horario_final)&& !empty($valor->horario_final))echo "- ".date('H:i', strtotime($valor->horario_final)); ?>
						</p>
						<p class="local"><?php echo $valor->nome_local; ?></p>
						<div class="plus-information h-80 overflow-hidden">  
							<p class="event-text-plus-information">
								<?php if(isset($valor->mais_infos) && !empty($valor->mais_infos)){ ?>
									<br>Mais Informações: <br>
									<?php 
										
										echo str_replace("\\\"", "\"",$valor->mais_infos);
									?>  
								<?php } ?>
							</p>
							<p class="event-text-info">
								<?php if(isset($valor->descricao) && !empty($valor->descricao)){ ?>
									
									<?php 
										echo str_replace("\\\"", "\"",$valor->descricao);  
									?>  
								<?php } ?>
							</p>
						</div>  
						<p class="andress"><?php echo $valor->endereco; ?></p>
					</div>
				</div>  
				<div class="w-100"></div>
				<div class="logoToo-ScheduleEvent ">
					<div id="logoEvent"></div>
				</div>
			</div>
		</div>
	</div>
</div>