<div id="event-<?php echo $valor->id;?>" class="bigContainerScheduleEvent-full bigContainerScheduleEvent-close big-event w-100 h-100 d-flex flex-wrap position-absolute d-none" style="top:0px;left:0px;z-index:4000;">
	<div class="w-100 h-100 d-flex flex-wrap position-fixed p-0 m-0" style="top:0px;left:0px;background-color:rgba(0, 0, 0, 0.9);">
		<?php if($count!=0){?>
		<div class="position-absolute h-100 d-flex justify-content-center align-items-center" style="width:60px;top:0px;left:0px;">
			<button class="bigContainerScheduleEvent-back d-flex bg-3 color-1 justify-content-center align-items-center rounded-pill" style="width:50px;height:50px;margin-left:10px;">
				<i class="fas fa-caret-left"></i>
			</button>
		</div>
		<?php }?>
		<?php if($count!=(count($result)-1)){?>
		<div class="position-absolute h-100 d-flex justify-content-center align-items-center" style="width:60px;top:0px;right:0px;">
			<button class=" d-flex bg-3 color-1 justify-content-center align-items-center rounded-pill" style="width:50px;height:50px;margin-right:10px;">
				<i class="fas fa-caret-right"></i>
			</button>
		</div>
		<?php }?>
		<div class="bigContainerScheduleEvent-close position-absolute d-flex bg-1 color-0 justify-content-center align-items-center rounded-pill" style="width:60px;height:60px;top:40px;right:10px;">
			<i class="fas fa-times" ></i>
		</div>
		<div class="container-block-by w-100 d-flex" >
			<?php
				$classNameEventBanner=" block-by-4 big-event ";
				//require(get_template_directory() .  '/template-parts/content/event/event-banner.php');
				require(plugin_dir_path( __FILE__ ) . 'event-banner.php');
			?>
			<div class="containerScheduleEvent-container block-by-4 max-height-parent-first-child min-height-first-child my-1" style="flex-grow:2;height:auto;">
				<div class="fundoScheduleEvent position-absolute dimenssion-parent">
					<div class="fundoScheduleEventText w-100">
					<p>
						<?php if (isset($valor->categoria_evento) && !empty($valor->categoria_evento)){?>
						<p>
							<b><?php echo "#".$valor->categoria_evento;?></b>
						</p>
						<?php } ?>
						<p>
							<h1><b><?php 
								echo $valor->nome_do_evento; 
							?></b></h1>
						</p>
						<p>
							<br><?php echo  str_replace("\\\"", "\"",$valor->descricao);; ?>
						</p>
						<p>
							<br><?php echo $valor->informacao; ?>
						</p>
						<hr>
						<p><?php echo date('d/m/Y', strtotime($valor->data_inicial)); ?><?php if(isset($valor->data_final)&& !empty($valor->data_final)) echo " - ".date('d/m/Y', strtotime($valor->data_final)); ?></p>
						<p><?php echo date('H:i', strtotime($valor->horario_inicial)); ?><?php if(isset($valor->horario_final)&& !empty($valor->horario_final))echo "- ".date('H:i', strtotime($valor->horario_final)); ?></p>
						<p><?php echo $valor->nome_local; ?></p>		
						<p><?php echo $valor->endereco; ?></p>
						
					</p>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
