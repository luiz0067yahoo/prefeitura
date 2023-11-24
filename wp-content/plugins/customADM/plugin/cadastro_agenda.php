<?php
/*
CREATE TABLE ."$wpdb->prefix".cadastro_eventos (
  id integer NOT NULL AUTO_INCREMENT primary key,
  data_inicial date NOT NULL,
  data_final date DEFAULT NULL,
  horario_inicial time DEFAULT NULL,
  horario_final time DEFAULT NULL,
  nome_local varchar(45)DEFAULT NULL,
  categoria_evento varchar(45)  DEFAULT NULL,
  nome_do_evento varchar(100)  DEFAULT NULL,
  post_id int(11) DEFAULT NULL,
  endereco varchar(200) DEFAULT NULL,
  descricao blob(60000) DEFAULT NULL
)
;
*/
$post_type="post";
$post_type="evento";
global $wpdb;
if ( ! defined( 'WP_ADMIN' ) ) {
	define( 'WP_ADMIN', true );
}
if ( defined( 'ABSPATH' ) ) {
	require_once ABSPATH . 'wp-load.php';
} else {
	require_once dirname( __DIR__ ) . '/wp-load.php';
}
/** Allow for cross-domain requests (from the front end). */
send_origin_headers();
require_once ABSPATH . 'wp-admin/includes/admin.php';
nocache_headers();
/** This action is documented in wp-admin/admin.php */
do_action( 'admin_init' );
if(function_exists( 'wp_enqueue_media' )){
    wp_enqueue_media();
}else{
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
}
$str_conditions="";
$args=[];
$tabela_nome = $wpdb->prefix . 'cadastro_eventos';
$result = null;
$campos = null;
$total = 0;
$page = max(
    1,
    (
        (isset($_GET["paged"]))
        ? $_GET["paged"]
        : 
		(
            (isset($_POST["paged"]))
            ? $_POST["paged"]
            : 0
        )
    )
);
$rows_per_page = 9;
if($_POST){
    $id = (isset($_POST['id']) && !empty($_POST['id']))?sanitize_text_field($_POST['id']):null;
    $media_id = (isset($_POST['media_id']) && !empty($_POST['media_id']))?sanitize_text_field($_POST['media_id']):null;
    $post_id = (isset($_POST['post_id']) && !empty($_POST['post_id']))?sanitize_text_field($_POST['post_id']):null;
    $data_inicial = (isset($_POST['data_inicial']) && !empty($_POST['data_inicial']))?sanitize_text_field($_POST['data_inicial']):null;
    $data_final = (isset($_POST['data_final']) && !empty($_POST['data_final']))?sanitize_text_field($_POST['data_final']):null;
    $horario_inicial = (isset($_POST['horario_inicial']) && !empty($_POST['horario_inicial']))?sanitize_text_field($_POST['horario_inicial']):null;
    $horario_final = (isset($_POST['horario_final']) && !empty($_POST['horario_final']))?sanitize_text_field($_POST['horario_final']):null;
    $nome_local = (isset($_POST['nome_local']) && !empty($_POST['nome_local']))?sanitize_text_field($_POST['nome_local']):"";
    $categoria_evento = (isset($_POST['categoria_evento']) && !empty($_POST['categoria_evento']))?sanitize_text_field($_POST['categoria_evento']):"";
    $categoria_evento = (isset($_POST['categoria_evento']) && !empty($_POST['categoria_evento']))?sanitize_text_field($_POST['categoria_evento']):"";
    $nome_do_evento = (isset($_POST['nome_do_evento']) && !empty($_POST['nome_do_evento']))?sanitize_text_field($_POST['nome_do_evento']):"";
    $endereco = (isset($_POST['endereco']) && !empty($_POST['endereco']))?sanitize_text_field($_POST['endereco']):"";
    $descricao = (isset($_POST['descricao']) && !empty($_POST['descricao']))?($_POST['descricao']):"";
    $mais_infos = (isset($_POST['mais_infos']) && !empty($_POST['mais_infos']))?($_POST['mais_infos']):"";
	
    $com_sem_sombra = (isset($_POST['com_sem_sombra']) && !empty($_POST['com_sem_sombra']) && ($_POST['com_sem_sombra']!=0))?-1:0;
    $com_sem_informacoes = (isset($_POST['com_sem_informacoes']) && !empty($_POST['com_sem_informacoes']) && ($_POST['com_sem_informacoes']==0))?0:-1;
    $preto_branco = (isset($_POST['preto_branco']) && !empty($_POST['preto_branco']) && ($_POST['preto_branco']!=0))?-1:0;
    $posicao = (isset($_POST['posicao']))?($_POST['posicao']):0;
    $post_content=
    "<hr>".
    "<img style='max-width:500px;min-width:280px' class='mx-auto' src='".wp_get_attachment_image_url($media_id,'thumbnail',false )."'><br>".
    "<div class='text-block'>".
        "<p>".$descricao."</p>".
        "<hr>".
        (   
            (isset($data_inicial) && !empty($data_inicial))
            ?"<p><b>Data: </b> ".date('d/m/Y', strtotime($data_inicial))
            :""
        ).
        (
            (isset($data_final) && !empty($data_final))
            ?(" até ".date('d/m/Y',strtotime($data_final))."</p>")
            :""
        ).
        (
            (isset($horario_inicial) && !empty($horario_inicial))
            ?"<p><b>Horário: </b> ".date('H:i:s',strtotime($horario_inicial))
            :""
        ).
        (   (isset($horario_final) && !empty($horario_final))
            ?(" até ".date('H:i:s',strtotime($horario_final))."</p>")
            :""
        ).
        (
            (isset($nome_local) && !empty($nome_local))
                ?"<p><b>Local: </b> ".$nome_local."</p>"
                :""
		).
        
		(
            (isset($mais_infos) && !empty($mais_infos))
            ?"<p><b>Endereço: </b> ".$mais_infos."</p>"
            :""
        ).
    "</div>";

    if (!empty($_POST['acao']) && ($_POST['acao'] == "Salvar")) {
        $params=[];
        $params['post_id']=$post_id;
        $params['media_id']=$media_id;
        $params['nome_do_evento']=$nome_do_evento;
        if(isset($data_inicial) && !empty($data_inicial)) $params['data_inicial']=date('Y/m/d', strtotime($data_inicial)); else $params['data_inicial']=null;
        if(isset($data_final) && !empty($data_final)) $params['data_final']=date('Y/m/d', strtotime($data_final)); else $params['data_final']=null;
        if(isset($horario_inicial) && !empty($horario_inicial)) $params['horario_inicial']=date('H:i:s', strtotime($horario_inicial)); else $params['horario_inicial']=null;
        if(isset($horario_final) && !empty($horario_final)) $params['horario_final']=date('H:i:s', strtotime($horario_final));else $params['horario_final']=null;
        $params['nome_local']=$nome_local;
        $params['categoria_evento']=$categoria_evento;
        $params['endereco']=$endereco;
        $params['descricao']=$descricao;
        $params['mais_infos']=$mais_infos;
        $params['com_sem_sombra']=$com_sem_sombra;
        $params['com_sem_informacoes']=$com_sem_informacoes;
        $params['preto_branco']=$preto_branco;
        $params['posicao']=$posicao;
		
        if (!empty($id)) {
            $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $tabela_nome WHERE (ID=%d) limit  1",$id));
            $post_id = wp_update_post(array ('ID' => $post_id,'post_category' => [160],'post_title' => $nome_do_evento,'post_content' => $post_content,'post_type' => $post_type,'post_status' => 'publish',));
            $params['post_id']=$post_id;
            $wpdb->update($tabela_nome,$params,['id' => $id]);
            set_post_thumbnail( $post_id, $media_id);
        } else {
            $post_id = wp_insert_post(array (
                'post_category' => [160],  // /noticias-e-agenda/agenda/
                'post_type' => $post_type,
                'post_title' => $nome_do_evento,
                'post_content' => $post_content,
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ));
            $params['post_id']=$post_id;
            $wpdb->insert($tabela_nome,$params);
            set_post_thumbnail( $post_id, $media_id);
        }
        if ($wpdb) {
            echo "<h1 class='bg-success w-100 text-white text-center'>Salvo com Sucesso</h1>";
        } else {
            echo "<h1 class='bg-danger w-100 text-white text-center'>Erro ao salvar evento</h1>";
        }
    }
    if (!empty($_POST['acao']) && ($_POST['acao'] == "Excluir")) {
        if (isset($id) && !empty($id)) {
            $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $tabela_nome WHERE (ID=%d) limit 1",$id));
            wp_delete_post($post_id,true);
            $apagar_evento = $wpdb->delete($tabela_nome, array('id' => $id));

            if ($apagar_evento) {
                echo "Deletado com sucesso";
            } else {
                echo "Erro ao deletar";
            }
        }
    }
    if (!empty($_POST['acao']) && ($_POST['acao'] == "Editar")) {
        $id = null;
        if (!empty($_POST['id'])) {
            $id = sanitize_text_field($_POST['id']);
            $str_conditions = " WHERE (id = %d)";
            array_push($args, $id);
            $campos = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabela_nome $str_conditions ORDER BY ID ASC", $args));
			$valor=$campos[0];
			$args=[];
			$str_conditions = "";
        }
    }
    if (!empty($_POST['acao']) && ($_POST['acao'] == "Buscar")) {
        $conditions = [];
        if (!empty($data_inicial) && (strlen($data_inicial) > 0)) {
            array_push($args, $data_inicial);
            array_push($conditions, "(data_inicial >= %s)");
        }
        if (!empty($data_final) && (strlen($data_final) > 0)) {
            array_push($args, $data_final);
            array_push($conditions, "(data_final <= %s)");
        }
        if (!empty($horario_inicial) && (strlen($horario_inicial) > 0)) {
            array_push($args, $horario_inicial);
            array_push($conditions, "(horario_inicial >= %s)");
        }
        if (!empty($horario_final) && (strlen($horario_final) > 0)) {
            array_push($args, $horario_final);
            array_push($conditions, "(horario_final >= %s)");
        }

        if (!empty($nome_local) && (strlen($nome_local) > 0)) {
            $nome_local_contem = strtoupper("%" . sanitize_text_field($_POST['nome_local']) . "%");
            array_push($args, $nome_local_contem);
            array_push($conditions, "(UPPER(nome_local) LIKE %s)");
        }
        if (!empty($categoria) && (strlen($categoria_evento) > 0)) {
            $categoria_evento_contem = strtoupper("%" . sanitize_text_field($_POST['categoria_evento']) . "%");
            array_push($args, $categoria_evento_contem);
            array_push($conditions, "(UPPER(categoria_evento) LIKE %s)");
        }
        if (!empty($nome_do_evento) && (strlen($nome_do_evento) > 0)) {
            $nome_do_evento_contem =     strtoupper("%" . sanitize_text_field($_POST['nome_do_evento']) . "%");
            array_push($args, $nome_do_evento_contem);
            array_push($conditions, "(UPPER(nome_do_evento) LIKE %s)");
        }
        if (!empty($endereco) && (strlen($endereco) > 0)) {
            $endereco_contem = strtoupper("%" . sanitize_text_field($_POST['endereco']) . "%");
            array_push($args, $endereco_contem);
            array_push($conditions, "(UPPER(endereco) LIKE %s)");
        }
        if (!empty($descricao) && (strlen($descricao) > 0)) {
            $descricao_contem = strtoupper("%" . strip_tags(sanitize_text_field($_POST['descricao'])) . "%");
            array_push($args, $descricao_contem);
            array_push($conditions, "(UPPER(descricao) LIKE %s)");
        }
		if (!empty($mais_infos) && (strlen($mais_infos) > 0)) {
            $descricao_contem = strtoupper("%" . strip_tags(sanitize_text_field($_POST['mais_infos'])) . "%");
            array_push($args, $mais_infos_contem);
            array_push($conditions, "(UPPER(mais_infos) LIKE %s)");
        }
        $str_conditions = (count($args) > 0)?" WHERE (" . implode("and", $conditions) . ")":"";
    } 
}
$total = $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM $tabela_nome $str_conditions ",$args));
$offset = ($page - 1) * $rows_per_page;
$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabela_nome $str_conditions ORDER BY ID DESC limit {$offset}, {$rows_per_page}", $args));

?>
<div class="container">
	<h1 class="w-100 text-center ">Agenda de Eventos</h1>
</div>
<div class="container">
    <div id="form-data" class="container w-100 border border-dark position-absolute bg-white" 
            style="<?php if(!empty($_POST['acao']) && ($_POST['acao'] == "Editar")){?>
            display:block;
            <?php } else{ ?>
            display:none;
            <?php }?>
            z-index:4000;margin-left:-20px;"
        >
            <h1 class="fas fa-window-close float-end text-danger " onclick="this.parentNode.style.display='none'"></h1>
            <br><br>
            <h1 class="text-center"><?php if(isset($id)){ ?>Alterar<?php } else{ ?>Inserir<?php } ?> Evento</h1>
            <form method="post" enctype="multipart/form-data"  >
			<input type="hidden" name="id" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->id; ?>">
			<input type="hidden" name="post_id" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->post_id; ?>">
			<div class="row container-block-by">
				<div class="mx-auto" style="width:33%">
					<?php require_once plugin_dir_path( __FILE__ ) . 'event/event-big.php';?>
					<?php require_once plugin_dir_path( __FILE__ ) . 'event/event-mini.php';?>
				</div>
			</div>
			<div class="row w-100 mt-4 d-flex justify-content-center align-items-center" >
						<div class="mx-auto" style="max-width:840px!important;">
							
							<button id="text-color-black-white" type="button" class="btn btn-primary" >Preto/Branco</button>
							<input id="preto_branco" name="preto_branco" type="hidden" value="<?php echo $valor->preto_branco;?>">

							<input id="move-background-image-x" type="range" class="btn btn-primary" value="0<?php if (isset($valor->posicao))echo ($valor->posicao);?>">
							<input id="posicao" name="posicao" type="hidden" value="<?php if (isset($valor->posicao) && !empty($valor->posicao))echo $valor->posicao;?>">

							<button id="hidde-text" type="button" class="btn btn-primary">Apagar Informações/Ver Informações</button>
							<input name="com_sem_informacoes" id="com_sem_informacoes" type="hidden" value="<?php echo $valor->com_sem_informacoes;?>">

							<button id="shadow-text-event" type="button" class="btn btn-primary">SOMBRA/SEM SOMBRA</button>
							<input name="com_sem_sombra" id="com_sem_sombra" type="hidden" value="<?php echo $valor->com_sem_sombra;?>">

							<input type="hidden" id="codeImg" name="media_id" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->media_id; ?>">
							<button  id="add_image" type="button" class="btn btn-primary">Adicionar Foto</button>
						</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="input-group">
						<label class="w-100"> Título do Evento </label>
						<input type="text" id="nome_do_evento" name="nome_do_evento" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->nome_do_evento; ?>">
					</div>
				</div>
				<div class="col">
					<div class="input-group">
						<label class="w-100"> Categoria do Evento </label>
						<input type="text" id="categoria_evento" name="categoria_evento" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->categoria_evento; ?>">
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col">
					<div class="input-group">
						<label class="w-100"> Data Inicial</label>
						<input type="date" id="data_inicial" name="data_inicial" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->data_inicial) && !empty($campos[0]->data_inicial)) echo date('Y-m-d', strtotime($campos[0]->data_inicial)); ?>">
					</div>
				</div>
				<div class="col">
					<div class="input-group">
						<label class="w-100"> Data Final </label>
						<input type="date" id="data_final" name="data_final" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && (isset($campos[0]->data_final) && !empty($campos[0]->data_final))) echo date('Y-m-d', strtotime($campos[0]->data_final)); ?>">
					</div>
				</div>
				<div class="col">
					<div class="input-group">
						<label class="w-100"> Horário Inicial </label>
						<input type="time" id="horario_inicial" name="horario_inicial" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && (isset($campos[0]->horario_inicial) && !empty($campos[0]->horario_inicial)))  echo date('H:i', strtotime($campos[0]->horario_inicial)); ?>">
					</div>
				</div>
				<div class="col">
					<div class="input-group">
						<label class="w-100"> Horário Final </label>
						<input type="time" id="horario_final" name="horario_final" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && (isset($campos[0]->horario_final) && !empty($campos[0]->horario_final)))  echo date('H:i', strtotime($campos[0]->horario_final)); ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="input-group">
						<label class="w-100"> Local </label>
						<input type="text" id="nome_local" name="nome_local" placeholder="Insira o local do evento" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->nome_local; ?>">
					</div>
				</div>
				<div class="col">
					<div class="input-group">
						<label class="w-100"> Endereço </label>
						<input type="text" id="endereco" name="endereco" class="form-control" placeholder="Insira o Endereço" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->endereco; ?>">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="input-group">
					<label class="w-100">Mais Informações </label>
					<div class="w-100"><textarea class="editor-mais-informacoes w-100 .editor " id="mais_infos"  name="mais_infos" placeholder="Insira mais informações..."><?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->mais_infos; ?></textarea></div>
					<label id="editor-mais-informacoes-word-count">  </label>
				</div>
			</div>
			<div class="row">
				<div class="input-group">
					<label class="w-100"> info </label>
					<div class="w-100"><textarea class="editor-descricao w-100 .editor" id="descricao"  name="descricao" placeholder="Insira a descrição do evento..."><?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->descricao; ?></textarea></div>
					<label id="editor-descricao-word-count">  </label>
				</div>
			</div>
			<br>
			<input type="submit" name="acao" value="Salvar" class=" btn btn-dark">
			<input type="submit" name="acao" value="Buscar" class=" btn btn-dark">
			<br>
		</form>
	</div>  
</div>  

<input id="clean" type="button" name="acao" value="Novo" class="m-4 btn btn-dark" >

<div class="container-block-by">
    <?php
	$count=0;
    foreach ($result as $valor) {
        
        $url = "#";
        $post_id = null;
        if (isset($valor->post_id)) {
            $post_id = $valor->post_id;
            $url = get_permalink($post_id);
        }
    ?>
                
         <div class="block-by-3 p-2">
			<?php require plugin_dir_path( __FILE__ ) . 'event/event-big.php';?>
			<?php require plugin_dir_path( __FILE__ ) . 'event/event-mini.php';?>
			<div class="bottons-edit d-flex justify-content-center  position-absolute">
				 <form method="post">
					<input name="id" type="hidden" value="<?php echo $valor->id; ?>">
					<input name="acao" type="hidden" value="Editar">
					<button type="submit" class="p-2 m-1 border rounded  fas fa-pen bg-primary text-white" style="font-size:32px"></button>
				</form>
				<form method="post">
					<input name="id" type="hidden" value="<?php echo $valor->id; ?>">
					<input name="acao" type="hidden" value="Excluir">
					<button type="submit" class="p-2 m-1 border rounded  fas fa-minus bg-danger text-white" style="font-size:32px"></button>
				</form>
			</div>
        </div>
    <?php 
		$count++;
	} 
	$rest=($count%3);
	if($rest>0)
	for($count=$rest;$count<3;$count++){
		require plugin_dir_path( __FILE__ ) . 'event/event-none.php';
	}
?>
</div>
<?php
	require_once plugin_dir_path( __FILE__ ) . 'parts/paginate.php';
?>
<script src="<?php echo    plugins_url('/../js/ckeditor.js', __FILE__) ?>"></script>
<script>
	var loadDimension;
    jQuery(document).ready( function($) {
		loadDimension=function(){
			jQuery(".height-square").each(function(){
					jQuery(this).height(jQuery(this).width());
			});
			jQuery(".dimenssion-parent").each(function(){
				height=(jQuery(this).parent().height());
				width=(jQuery(this).parent().width());
				jQuery(this).height(height);
				jQuery(this).width(width);
			});
			jQuery(".max-height-parent-first-child").each(function(){
				height=(jQuery(this).parent().children(":first").height());
				jQuery(this).css("max-height",height+"px");
			});
			jQuery(".min-height-first-child").each(function(){
				height=(jQuery(this).first().height());
				if(jQuery(this).css("max-height").replace('px', '')>height)
					jQuery(this).css("min-height",jQuery(this).css("max-height"));
				else
					jQuery(this).css("min-height",height+"px");
			});
			jQuery(".h-80").each(function(){
				jQuery(this).height(jQuery(this).parent().height()*0.8);
			});

		}
		setTimeout(loadDimension,250);		
        jQuery("#add_image").click(function(e) {
            var send_attachment_bkp = wp.media.editor.send.attachment;

            wp.media.editor.send.attachment = function(props, attachment) {
               jQuery('#codeImg').val(attachment.id);
                jQuery('.viewImg').css('background-image','url("'+attachment.url+'")');
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open();
        });
		
		
		
		
		
		jQuery("#text-color-black-white").click(function(){
			if(jQuery( ".containerScheduleEvent" ).hasClass( "color-0")){
				jQuery("#form-data").find( ".containerScheduleEvent" ).removeClass( "color-0").addClass("color-1");//white
				jQuery("#form-data").find( "#preto_branco" ).val(-1);//false
			}
			else{
				jQuery("#form-data").find( ".containerScheduleEvent" ).removeClass( "color-1").addClass("color-0");//black
				jQuery("#form-data").find( "#preto_branco" ).val(0);//true
			}
		});
		jQuery("#shadow-text-event").click(function(){
			jQuery("#form-data").find(".containerScheduleEvent").toggleClass('event-text-shadow');
			if(jQuery("#form-data").find(".containerScheduleEvent").hasClass('event-text-shadow'))
				jQuery("#form-data").find("#com_sem_sombra").val(-1);//true
			else
				jQuery("#form-data").find("#com_sem_sombra").val(0);//false
		});	
		jQuery("#move-background-image-x").click(function(event){
			element=jQuery(event.target);
			jQuery("#form-data").find('.containerScheduleEvent').css('background-position-x', (100 - element.val()) + "%");
			jQuery("#form-data").find('#posicao').val(element.val());
		});
		jQuery("#hidde-text").click(function(){
			jQuery("#form-data").find(".containerScheduleEvent").toggleClass('less-text');
			if(jQuery("#form-data").find(".containerScheduleEvent").hasClass('less-text'))
				jQuery("#form-data").find("#com_sem_informacoes").val(0);//true
			else
				jQuery("#form-data").find("#com_sem_informacoes").val(-1);//false
		});
		




    ClassicEditor
        .create(document.querySelector('.editor-descricao'), {
            licenseKey: '',
        })
        .then(editor => {
            window.editorDescricao = editor;
            editor.ui.view.editable.element.style.width=jQuery(".editor").parent().width()+"px"
			editor.model.document.on( 'change:data', () => {
				jQuery("#form-data").find("p.event-text-info").html(editor.getData());
			});
			const wordCountPlugin = editor.plugins.get( 'WordCount' );
			const wordCountWrapper = document.getElementById( 'editor-descricao-word-count' );
			wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );
       })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: o7sw7kwnfjm1-a3158np2os9l');
            console.error(error);
        });
		
	 ClassicEditor
        .create(document.querySelector('.editor-mais-informacoes'), {
            licenseKey: '',
        })
        .then(editor => {
            window.editorMaisInformacoes = editor;
            editor.ui.view.editable.element.style.width=jQuery(".editor").parent().width()+"px"
			editor.model.document.on( 'change:data', () => {
				if (editor.getData()!="")
					jQuery("#form-data").find("p.event-text-plus-information").html("Mais Informações:"+editor.getData());
			} );
			const wordCountPlugin = editor.plugins.get( 'WordCount' );
			const wordCountWrapper = document.getElementById( 'editor-mais-informacoes-word-count' );
			wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );
        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: o7sw7kwnfjm1-a3158np2os9l');
            console.error(error);
        });	
       jQuery("#clean").click(function(){
            window.editorDescricao.setData( '' );
            window.editorMaisInformacoes.setData( '' );
            jQuery("#form-data").find("input")
            .not(':button, :submit, :reset')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');
            jQuery("#form-data").find("textarea").val('');
            jQuery("#form-data").find("option:selected").removeAttr("selected");
            jQuery('#viewImg').attr('src', "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNDg5LjQgNDg5LjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4OS40IDQ4OS40OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTAsNDM3LjhjMCwyOC41LDIzLjIsNTEuNiw1MS42LDUxLjZoMzg2LjJjMjguNSwwLDUxLjYtMjMuMiw1MS42LTUxLjZWNTEuNmMwLTI4LjUtMjMuMi01MS42LTUxLjYtNTEuNkg1MS42DQoJCQlDMjMuMSwwLDAsMjMuMiwwLDUxLjZDMCw1MS42LDAsNDM3LjgsMCw0MzcuOHogTTQzNy44LDQ2NC45SDUxLjZjLTE0LjksMC0yNy4xLTEyLjItMjcuMS0yNy4xdi02NC41bDkyLjgtOTIuOGw3OS4zLDc5LjMNCgkJCWM0LjgsNC44LDEyLjUsNC44LDE3LjMsMGwxNDMuMi0xNDMuMmwxMDcuOCwxMDcuOHYxMTMuNEM0NjQuOSw0NTIuNyw0NTIuNyw0NjQuOSw0MzcuOCw0NjQuOXogTTUxLjYsMjQuNWgzODYuMg0KCQkJYzE0LjksMCwyNy4xLDEyLjIsMjcuMSwyNy4xdjIzOC4xbC05OS4yLTk5LjFjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwTDIwNS4yLDMzMy44bC03OS4zLTc5LjNjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwDQoJCQlsLTg0LjEsODQuMXYtMjg3QzI0LjUsMzYuNywzNi43LDI0LjUsNTEuNiwyNC41eiIvPg0KCQk8cGF0aCBkPSJNMTUxLjcsMTk2LjFjMzQuNCwwLDYyLjMtMjgsNjIuMy02Mi4zcy0yOC02Mi4zLTYyLjMtNjIuM3MtNjIuMywyOC02Mi4zLDYyLjNTMTE3LjMsMTk2LjEsMTUxLjcsMTk2LjF6IE0xNTEuNyw5Ng0KCQkJYzIwLjksMCwzNy44LDE3LDM3LjgsMzcuOHMtMTcsMzcuOC0zNy44LDM3LjhzLTM3LjgtMTctMzcuOC0zNy44UzEzMC44LDk2LDE1MS43LDk2eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K");
			
			jQuery("#form-data").css("display","block");
            jQuery(".system-menssage").remove();
			loadDimension();
        });
		jQuery(".bigContainerScheduleEvent-close").on("click", function(event){
			if(jQuery(event.target).closest(".containerScheduleEvent-container").length==0){
				jQuery(event.target).closest(".big-event").addClass("d-none");
				loadDimension();
				setTimeout(loadDimension,100);
				setTimeout(loadDimension,200);
			}
		});
		
		
		
		
		jQuery("#endereco").on("change", function(event){
			jQuery("#form-data").find("p.andress").html(jQuery(this).val());
		});
		jQuery("#nome_local").on("change", function(event){
			jQuery("#form-data").find("p.local").html(jQuery(this).val());
		});
		jQuery("#categoria_evento").on("change", function(event){
			jQuery("#form-data").find("p.category").html("#"+jQuery(this).val());
		});
		jQuery("#nome_do_evento").on("change", function(event){
			jQuery("#form-data").find("p.event-title").html(jQuery(this).val());
		});
		jQuery("#data_inicial").on("change", function(event){
			var dateStartEnd="";
			if(
				(jQuery("#data_inicial").val()!=null)
				&&
				(jQuery("#data_inicial").val()!=undefined)
				&&
				(jQuery("#data_inicial").val().length!=0)
			){
				dateStartEnd=jQuery("#data_inicial").val();
				
				if(
					(jQuery("#data_final").val()!=null)
					&&
					(jQuery("#data_final").val()!=undefined)
					&&
					(jQuery("#data_final").val().length!=0)
				){
					dateStartEnd +=" - "+jQuery("#data_final").val();
				}
			}
			jQuery("#form-data").find("p.text-date").html(dateStartEnd);
		});
		jQuery("#data_final").on("change", function(event){
			var dateStartEnd="";
			if(
				(jQuery("#data_inicial").val()!=null)
				&&
				(jQuery("#data_inicial").val()!=undefined)
				&&
				(jQuery("#data_inicial").val().length!=0)
			){
				dateStartEnd=jQuery("#data_inicial").val();
				
				if(
					(jQuery("#data_final").val()!=null)
					&&
					(jQuery("#data_final").val()!=undefined)
					&&
					(jQuery("#data_final").val().length!=0)
				){
					dateStartEnd +=" - "+jQuery("#data_final").val();
				}
			}
			jQuery("#form-data").find("p.text-date").html(dateStartEnd);
		});
		
		
		jQuery("#horario_inicial").on("change", function(event){
			var hourStartEnd="";
			if(
				(jQuery("#horario_inicial").val()!=null)
				&&
				(jQuery("#horario_inicial").val()!=undefined)
				&&
				(jQuery("#horario_inicial").val().length!=0)
			){
				hourStartEnd=jQuery("#horario_inicial").val();
				
				if(
					(jQuery("#horario_final").val()!=null)
					&&
					(jQuery("#horario_final").val()!=undefined)
					&&
					(jQuery("#horario_final").val().length!=0)
				){
					hourStartEnd +=" - "+jQuery("#horario_final").val();
				}
			}
			jQuery("#form-data").find("text-hours").html(hourStartEnd);
		});
		jQuery("#horario_final").on("change", function(event){
			var hourStartEnd="";
			if(
				(jQuery("#horario_inicial").val()!=null)
				&&
				(jQuery("#horario_inicial").val()!=undefined)
				&&
				(jQuery("#horario_inicial").val().length!=0)
			){
				hourStartEnd=jQuery("#horario_inicial").val();
				
				if(
					(jQuery("#horario_final").val()!=null)
					&&
					(jQuery("#horario_final").val()!=undefined)
					&&
					(jQuery("#horario_final").val().length!=0)
				){
					hourStartEnd +=" - "+jQuery("#horario_final").val();
				}
			}
			jQuery("#form-data").find("text-hours").html(hourStartEnd);
		});
		

	
    });
</script>