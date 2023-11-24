<?php
/*
CREATE TABLE `toledofotos` (
  `id` int(11) NOT NULL,
  `img` varchar(50) DEFAULT NULL,
  `img_mobile` varchar(50) DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL,
  `local` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/
//ALTER TABLE `$wpdb->prefixfotos` ADD `img_mobile` VARCHAR(50) NULL AFTER `img`;
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
global $wpdb;
$tabela_nome = $wpdb->prefix . 'fotos';
$campos = null;


if (!empty($_POST['acao']) && ($_POST['acao'] == "Salvar")) {



    $img = sanitize_text_field($_POST['img']);
    $img_mobile = sanitize_text_field($_POST['img_mobile']);
    $link = sanitize_text_field($_POST['link']);
    $local = sanitize_text_field($_POST['local']);
    global $wpdb;



    $id = null;
    if (!empty($_POST['id']))
        $id = sanitize_text_field($_POST['id']);

    if (!empty($id)) {

        $apagar_foto = $wpdb->update(
            $tabela_nome,
            array(
                'img' => $img,
                'img_mobile' => $img_mobile,
                'link' => $link,
                'local' => $local
            ),
            array('id' => $id)
        );
    } else {
        
         $wpdb->insert($tabela_nome, array(
            'img' => $img,
			'img_mobile' => $img_mobile,
            'link' => $link,
            'local' => $local
        ));
    }
    if ($wpdb) {
        echo "Foto salva com Sucesso";
    } else {
        echo "Erro ao salvar foto";
    }
}
if (!empty($_POST['acao']) && ($_POST['acao'] == "Excluir")) {
    global $wpdb;
    $id = null;
    if (!empty($_POST['id'])) {
        $id = sanitize_text_field($_POST['id']);

        $apagar_foto = $wpdb->delete($tabela_nome, array('id' => $id));

        if ($apagar_foto) {
            echo "Deletado com sucesso";
        } else {
            echo "Erro ao deletar";
        }
    }
}
if (!empty($_POST['acao']) && ($_POST['acao'] == "Editar")) {
    global $wpdb;

    $id = null;
    if (!empty($_POST['id'])) {
        $id = sanitize_text_field($_POST['id']);
        $campos = $wpdb->get_results("SELECT * FROM $tabela_nome WHERE ID=$id ORDER BY ID DESC");
    }
}
?>
    <div class="container">
        <h1>Inserir Fotos</h1>
        <form method="post">
            <input type="hidden" name="id" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->id; ?>">
            <div class="input-group">
                <label>Local </label>
                <select name="local" class="form-control" >
                    <option value="" disabled <?php if (!((is_array($campos) && count($campos) > 0) && isset($campos[0]->local))) echo "selected";?>></option>
                    <option value="BANNER ROTATIVO" <?php  if (is_array($campos) && count($campos) > 0) if ($campos[0]->local=="BANNER ROTATIVO") echo "selected";?>>BANNER ROTATIVO</option>
                    <option value="TOLEDO EM FOTOS" <?php  if (is_array($campos) && count($campos) > 0) if ($campos[0]->local=="TOLEDO EM FOTOS") echo "selected";?>>TOLEDO EM FOTOS</option>
                </select>
            </div>
			
            <div class="row">
                <img id="viewImg" class="mx-auto mt-1 p-0 my-2"  style="width:auto;height:240px;border:black solid;" 
                src="<?php 
                if (is_array($campos) && count($campos) > 0)
                    echo  wp_get_attachment_image_url($campos[0]->img,'full',false );
                else{ 
                ?>data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNDg5LjQgNDg5LjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4OS40IDQ4OS40OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTAsNDM3LjhjMCwyOC41LDIzLjIsNTEuNiw1MS42LDUxLjZoMzg2LjJjMjguNSwwLDUxLjYtMjMuMiw1MS42LTUxLjZWNTEuNmMwLTI4LjUtMjMuMi01MS42LTUxLjYtNTEuNkg1MS42DQoJCQlDMjMuMSwwLDAsMjMuMiwwLDUxLjZDMCw1MS42LDAsNDM3LjgsMCw0MzcuOHogTTQzNy44LDQ2NC45SDUxLjZjLTE0LjksMC0yNy4xLTEyLjItMjcuMS0yNy4xdi02NC41bDkyLjgtOTIuOGw3OS4zLDc5LjMNCgkJCWM0LjgsNC44LDEyLjUsNC44LDE3LjMsMGwxNDMuMi0xNDMuMmwxMDcuOCwxMDcuOHYxMTMuNEM0NjQuOSw0NTIuNyw0NTIuNyw0NjQuOSw0MzcuOCw0NjQuOXogTTUxLjYsMjQuNWgzODYuMg0KCQkJYzE0LjksMCwyNy4xLDEyLjIsMjcuMSwyNy4xdjIzOC4xbC05OS4yLTk5LjFjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwTDIwNS4yLDMzMy44bC03OS4zLTc5LjNjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwDQoJCQlsLTg0LjEsODQuMXYtMjg3QzI0LjUsMzYuNywzNi43LDI0LjUsNTEuNiwyNC41eiIvPg0KCQk8cGF0aCBkPSJNMTUxLjcsMTk2LjFjMzQuNCwwLDYyLjMtMjgsNjIuMy02Mi4zcy0yOC02Mi4zLTYyLjMtNjIuM3MtNjIuMywyOC02Mi4zLDYyLjNTMTE3LjMsMTk2LjEsMTUxLjcsMTk2LjF6IE0xNTEuNyw5Ng0KCQkJYzIwLjksMCwzNy44LDE3LDM3LjgsMzcuOHMtMTcsMzcuOC0zNy44LDM3LjhzLTM3LjgtMTctMzcuOC0zNy44UzEzMC44LDk2LDE1MS43LDk2eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K<?php }?>">
			</div>
			
			<div class="input-group ">
                <input type="hidden" id="codeImg" name="img" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->img; ?>">
                <input id="add_image" type="button"class="mx-auto  btn-dark w-25 " value="Adicionar Foto Desktop">
            </div> 			
			<div class="row">
                <img id="viewImg_mobile" class="mx-auto mt-1 p-0 my-2"  style="width:auto;height:240px;border:black solid;" 
                src="<?php 
                if (is_array($campos) && count($campos) > 0)
                    echo  wp_get_attachment_image_url($campos[0]->img_mobile,'full',false );
                else{ 
                ?>data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNDg5LjQgNDg5LjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4OS40IDQ4OS40OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTAsNDM3LjhjMCwyOC41LDIzLjIsNTEuNiw1MS42LDUxLjZoMzg2LjJjMjguNSwwLDUxLjYtMjMuMiw1MS42LTUxLjZWNTEuNmMwLTI4LjUtMjMuMi01MS42LTUxLjYtNTEuNkg1MS42DQoJCQlDMjMuMSwwLDAsMjMuMiwwLDUxLjZDMCw1MS42LDAsNDM3LjgsMCw0MzcuOHogTTQzNy44LDQ2NC45SDUxLjZjLTE0LjksMC0yNy4xLTEyLjItMjcuMS0yNy4xdi02NC41bDkyLjgtOTIuOGw3OS4zLDc5LjMNCgkJCWM0LjgsNC44LDEyLjUsNC44LDE3LjMsMGwxNDMuMi0xNDMuMmwxMDcuOCwxMDcuOHYxMTMuNEM0NjQuOSw0NTIuNyw0NTIuNyw0NjQuOSw0MzcuOCw0NjQuOXogTTUxLjYsMjQuNWgzODYuMg0KCQkJYzE0LjksMCwyNy4xLDEyLjIsMjcuMSwyNy4xdjIzOC4xbC05OS4yLTk5LjFjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwTDIwNS4yLDMzMy44bC03OS4zLTc5LjNjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwDQoJCQlsLTg0LjEsODQuMXYtMjg3QzI0LjUsMzYuNywzNi43LDI0LjUsNTEuNiwyNC41eiIvPg0KCQk8cGF0aCBkPSJNMTUxLjcsMTk2LjFjMzQuNCwwLDYyLjMtMjgsNjIuMy02Mi4zcy0yOC02Mi4zLTYyLjMtNjIuM3MtNjIuMywyOC02Mi4zLDYyLjNTMTE3LjMsMTk2LjEsMTUxLjcsMTk2LjF6IE0xNTEuNyw5Ng0KCQkJYzIwLjksMCwzNy44LDE3LDM3LjgsMzcuOHMtMTcsMzcuOC0zNy44LDM3LjhzLTM3LjgtMTctMzcuOC0zNy44UzEzMC44LDk2LDE1MS43LDk2eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K<?php }?>">
			</div>
            <div class="input-group ">
              
				<input type="hidden" id="codeImg_mobile" name="img_mobile" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->img_mobile; ?>">
                <input id="add_image_mobile" type="button"class="mx-auto  btn-dark w-25 " value="Adicionar Foto Mobile">

            </div>            
            <br>
            <div class="input-group">
                <label>link </label>
                <input type="text"  name="link" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->link; ?>">
            </div>
            <br>
            <div class="input-group">
                <input type="submit" name="acao" value="Salvar" class="form-control btn btn-dark">
            </div>
            <br>
        </form>
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Local</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">link</th>
                    <th scope="col" clospan="2">Ação</th>
                </tr>
            </thead>

            <?php
            global $wpdb;

            $tabela_nome = $wpdb->prefix . 'fotos';

            $resultado = $wpdb->get_results("SELECT * FROM $tabela_nome ORDER BY id DESC");


            ?>
            <tbody>
                <?php foreach ($resultado as $valor) : ?>
                    <form method="POST">
                        <tr>
                            <th scope="row"><input name="id" type="hidden" value="<?php echo $valor->id; ?>"><?php echo $valor->id; ?></th>
                            <td><img src="<?php echo wp_get_attachment_image_url($valor->img,'thumbnail',false ); ?>"></td>
                            <td><?php echo $valor->local; ?></td>
                            <td><?php echo $valor->link; ?></td>
                            <td><input name="acao" type="submit" value="Excluir"></td>
                            <td><input name="acao" type="submit" value="Editar"></td>
                        </tr>
                    </form>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>


  


     <script >
        
        
        
    jQuery(document).ready( function($) { 


        jQuery("#add_image").click(function(e) {
            var send_attachment_bkp = wp.media.editor.send.attachment;

            wp.media.editor.send.attachment = function(props, attachment) {

                $('#viewImg').attr('src', attachment.url);
                $('#codeImg').val(attachment.id);

                wp.media.editor.send.attachment = send_attachment_bkp;
            }



            wp.media.editor.open();

            
           
        });
		
		jQuery("#add_image_mobile").click(function(e) {
            var send_attachment_bkp = wp.media.editor.send.attachment;

            wp.media.editor.send.attachment = function(props, attachment) {

                $('#viewImg_mobile').attr('src', attachment.url);
                $('#codeImg_mobile').val(attachment.id);

                wp.media.editor.send.attachment = send_attachment_bkp;
            }



            wp.media.editor.open();

            
           
        });
     });
     
     
 
        
       
    </script>
