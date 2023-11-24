<?php
$post_type="pdf";
global $wpdb;
$tabela_nome = $wpdb->prefix . 'cadastro_pdf';
$url_canvas="";
$str_conditions="";
$args=[];
$result = null;
$campos = null;
$total = 0;
$page = max(
    1,
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
$rows_per_page = 18;
$id = null;
/*
CREATE TABLE $wpdb->prefixcadastro_pdf(
    id int(11) NOT NULL auto_increment primary key,
    media_id int  DEFAULT NULL,---pdf media id
    title varchar(8000)  DEFAULT NULL,
    sub_title varchar(250)  DEFAULT NULL,
    description blob(65535)  DEFAULT NULL
);	
*/
$id = null;
if($_POST){
    if (!empty($_POST['id']))$id = sanitize_text_field($_POST['id']);
    $media_id = sanitize_text_field($_POST['media_id']);
    $post_id = sanitize_text_field($_POST['post_id']);
    $title = sanitize_text_field($_POST['title']);
    $sub_title = sanitize_text_field($_POST['sub_title']);
    $date_file =(isset($_POST['date_file']) && !empty($_POST['date_file']))?sanitize_text_field($_POST['date_file']):null;
    $command="pdftohtml -stdout -q -s -i -dataurls ".get_attached_file($_POST['media_id']);
    $description = (shell_exec($command));
    $description = strip_tags($description);
    $description = strip_tags($description);
    $description = strtoupper($description);
    //echo($description);
    if (!empty($_POST['acao']) && ($_POST['acao'] == "Salvar")) {
		$params=[];
        $params['post_id']=$post_id;
        $params['media_id']=$media_id;//media_id of pdf
        $params['title']=$title;
        $params['sub_title']=$sub_title;
        $params['description']=$description;
        if (!empty($id)) {
            $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $tabela_nome WHERE (ID=%d) limit  1",$id));
            $post_id = wp_update_post(array ('ID' => $post_id,'post_category' => [160],'post_title' => $title,'post_content' => $description,'post_type' => $post_type,'post_status' => 'publish',));
            $params['post_id']=$post_id;
            $wpdb->update($tabela_nome,$params,['id' => $id]);
			if($_FILES["image_tumbnail"]["error"]==0){
				$media_id_pdf_to_image_tumbnail =media_handle_upload('image_tumbnail', $post_id);
				set_post_thumbnail( $post_id, $media_id_pdf_to_image_tumbnail);
			}
			if(isset($date_file) && !empty($date_file)){
				$date_file=date('Y/m/d', strtotime($date_file));
				//update date from pdf media
				wp_update_post(
					[
						'ID' => $media_id
						,'post_date'     => $date_file
						,'post_date_gmt' => get_gmt_from_date( $date_file )
						,'edit_date'     => true,
					]
				);
			}
        } 
		else {
			$post_id = wp_insert_post(array (
                'post_category' => [160],  //     /municipio/orgao-oficial/
                'post_type' => $post_type,
                'post_title' => $title,
                'post_content' => $description,
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ));
            $params['post_id']=$post_id;
            $wpdb->insert($tabela_nome,$params);
            $media_id_pdf_to_image_tumbnail =media_handle_upload('image_tumbnail', $post_id);
			set_post_thumbnail( $post_id, $media_id_pdf_to_image_tumbnail);
			if(isset($date_file) && !empty($date_file)){
				$date_file=date('Y/m/d', strtotime($date_file));
				//update date from pdf media
				wp_update_post(
					[
						'ID' => $media_id
						,'post_date'     => $date_file
						,'post_date_gmt' => get_gmt_from_date( $date_file )
						,'edit_date'     => true,
					]
				);
			}
        }
        if ($wpdb) {
            echo "<h1 class='text-white bg-success p-2 text-center system-menssage'>Salvo com Sucesso</h1>";
        } else {
            echo "<h1 class='text-white bg-success p-2 text-center system-menssage'>Erro ao salvar</h1>";
        }
    }
    else if (!empty($_POST['acao']) && ($_POST['acao'] == "Excluir")) {
        if (!empty($_POST['id'])) {
			$post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $tabela_nome WHERE (ID=%d) limit 1",$id));
            wp_delete_post($post_id,true);
            $apagar_pdf = $wpdb->delete($tabela_nome, array('id' => $id));
            if ($apagar_pdf) {
                echo "<h1 class='text-white bg-success p-2 text-center system-menssage'>Deletado com sucesso</h1>";
            } else {
                echo "<h1 class='text-white bg-danger p-2 text-center system-menssage'>Erro ao deletar</h1>";
            }
        }
    }
    else if (!empty($_POST['acao']) && ($_POST['acao'] == "Editar")) {
        if (!empty($_POST['id'])) {
            $campos = $wpdb->get_results("SELECT * FROM $tabela_nome WHERE ID=$id ORDER BY id DESC limit 1");
        }
    }
    if (!empty($_POST['acao']) && ($_POST['acao'] == "Buscar")) {
        $conditions = [];
        
        if (!empty($title) && (strlen($title) > 0)) {
            $title_contem = strtoupper("%" . sanitize_text_field($_POST['title']) . "%");
            array_push($args, $title_contem);
            array_push($conditions, "(UPPER(title) LIKE %s)");
            $title_contem = strtoupper("%" . sanitize_text_field($_POST['title']) . "%");
            array_push($args, $title_contem);
            array_push($conditions, "((description) LIKE %s)");
        } 
		if (!empty($sub_title) && (strlen($sub_title) > 0)) {
            $sub_title_contem = strtoupper("%" . sanitize_text_field($_POST['sub_title']) . "%");
            array_push($args, $sub_title_contem);
            array_push($conditions, "(UPPER(sub_title) LIKE %s)");
            $sub_title_contem = strtoupper("%" . sanitize_text_field($_POST['sub_title']) . "%");
            array_push($args, $sub_title_contem);
            array_push($conditions, "((description) LIKE %s)");
        }
        $str_conditions = "";
        if (count($args) > 0) {
            $str_conditions = " WHERE (" . implode("OR", $conditions) . ")";
        }
    } 
}
$total = $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM $tabela_nome $str_conditions ",$args));
$offset = ($page - 1) * $rows_per_page;
$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabela_nome $str_conditions ORDER BY ID DESC limit {$offset}, {$rows_per_page}", $args));
?>
    <div class="container">
        <h1 class="w-100 text-center ">Órgão Oficial</h1>
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
            <h1 class="text-center"><?php if(isset($id)){ ?>Alterar<?php } else{ ?>Inserir<?php } ?> PDF</h1>
            <form method="post" enctype="multipart/form-data"  >
                <input type="hidden" name="id" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->id; ?>">
                <input id="fileImg" type="file" class="d-none" name="image_tumbnail" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->id; ?>">
                <div class=" container-block-by w-100 ">
					<div class=" block-by-3" style="min-height:1px;"></div>
					<div class=" block-by-3 p-2 ">
						<div class=" w-100 height-square d-flex align-items-center justify-content-center " style="border:1px black solid;">
							<img id="viewImg" class="mx-auto"   
							style="width:auto;max-height:100%;max-width:100%;"
							<?php
							$thumbnail_url_image=(is_array($campos) && count($campos) > 0)?get_the_post_thumbnail_url($campos[0]->post_id):"";					
							if(
								isset($thumbnail_url_image) 
								&& 
								!empty($thumbnail_url_image)
							)
							{
							?>
							src="<?php echo $thumbnail_url_image; ?>"
							<?php } else{ ?>
							src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNDg5LjQgNDg5LjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4OS40IDQ4OS40OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTAsNDM3LjhjMCwyOC41LDIzLjIsNTEuNiw1MS42LDUxLjZoMzg2LjJjMjguNSwwLDUxLjYtMjMuMiw1MS42LTUxLjZWNTEuNmMwLTI4LjUtMjMuMi01MS42LTUxLjYtNTEuNkg1MS42DQoJCQlDMjMuMSwwLDAsMjMuMiwwLDUxLjZDMCw1MS42LDAsNDM3LjgsMCw0MzcuOHogTTQzNy44LDQ2NC45SDUxLjZjLTE0LjksMC0yNy4xLTEyLjItMjcuMS0yNy4xdi02NC41bDkyLjgtOTIuOGw3OS4zLDc5LjMNCgkJCWM0LjgsNC44LDEyLjUsNC44LDE3LjMsMGwxNDMuMi0xNDMuMmwxMDcuOCwxMDcuOHYxMTMuNEM0NjQuOSw0NTIuNyw0NTIuNyw0NjQuOSw0MzcuOCw0NjQuOXogTTUxLjYsMjQuNWgzODYuMg0KCQkJYzE0LjksMCwyNy4xLDEyLjIsMjcuMSwyNy4xdjIzOC4xbC05OS4yLTk5LjFjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwTDIwNS4yLDMzMy44bC03OS4zLTc5LjNjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwDQoJCQlsLTg0LjEsODQuMXYtMjg3QzI0LjUsMzYuNywzNi43LDI0LjUsNTEuNiwyNC41eiIvPg0KCQk8cGF0aCBkPSJNMTUxLjcsMTk2LjFjMzQuNCwwLDYyLjMtMjgsNjIuMy02Mi4zcy0yOC02Mi4zLTYyLjMtNjIuM3MtNjIuMywyOC02Mi4zLDYyLjNTMTE3LjMsMTk2LjEsMTUxLjcsMTk2LjF6IE0xNTEuNyw5Ng0KCQkJYzIwLjksMCwzNy44LDE3LDM3LjgsMzcuOHMtMTcsMzcuOC0zNy44LDM3LjhzLTM3LjgtMTctMzcuOC0zNy44UzEzMC44LDk2LDE1MS43LDk2eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K"
							<?php } ?>
							>
						</div>
					</div>
					<div class=" block-by-3" style="min-height:1px;"></div>
                </div>
                <div class="input-group ">
                <input type="hidden" id="codeImg" name="media_id" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->media_id; ?>">
                    <input id="add_image" type="button" class="mx-auto  btn-dark w-25 " value="Adicionar PDF">
                </div>
                <br>
                <br>
                <div class="input-group">
                    <label class="w-100"> Título </label>
                    <input id="title" type="text" name="title" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->title; ?>">
                </div>
				<div class="input-group">
                    <label class="w-100"> Sub Título </label>
                    <input id="sub_title" type="text" name="sub_title" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo $campos[0]->sub_title; ?>">
                </div>
				<div class="input-group">
                    <label class="w-100"> Data Arquivo </label>
					<?php ;?>
                    <input id="date_file" type="date" name="date_file" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0) echo get_the_date("Y-m-d",(int)$campos[0]->media_id); ?>">
                </div>
                <br>
                <input type="submit" name="acao" value="Salvar" class="btn btn-dark">
                <br>
            </form>
        </div>
		<form method="post" class=" col-6 mx-auto my-4" >
			<input type="hidden" name="acao" value="Buscar" >
			<div class="input-group">  
				<input type="text" name="title" class="form-control w-100" placeholder="Buscar" value="">
				<button type="submit" class="bg-transparent p-2 position-absolute fa fa-search " style="z-index:2000;left:100%;margin-left:-32px;"></button>
			</div>
		</form>
    </div>

    <input type="button" name="acao" value="Novo" class="m-4 btn btn-dark" onclick="limpar(this);">
    <div class="container-block-by">
        <?php 
        for($count=0;$count<(min(3,count($result)));$count++) { 
            $valor=$result[$count];?>
            <div class="block-by-3   align-content-start flex-wrap p-2" style="max-width:500px;min-width:280px">
				<div class=" w-100 height-square d-flex align-items-center justify-content-center " style="border:1px black solid;">
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
					<img id="viewImg" class="mx-auto"  
					style="max-height:100%;max-width:100%;"
					<?php
					$thumbnail_url_image=get_the_post_thumbnail_url($valor->post_id);					
					if(
						isset($thumbnail_url_image) 
						&& 
						!empty($thumbnail_url_image)
					)
					{
					?>
					src="<?php echo $thumbnail_url_image; ?>"
					<?php } else{ ?>
					src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNDg5LjQgNDg5LjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4OS40IDQ4OS40OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTAsNDM3LjhjMCwyOC41LDIzLjIsNTEuNiw1MS42LDUxLjZoMzg2LjJjMjguNSwwLDUxLjYtMjMuMiw1MS42LTUxLjZWNTEuNmMwLTI4LjUtMjMuMi01MS42LTUxLjYtNTEuNkg1MS42DQoJCQlDMjMuMSwwLDAsMjMuMiwwLDUxLjZDMCw1MS42LDAsNDM3LjgsMCw0MzcuOHogTTQzNy44LDQ2NC45SDUxLjZjLTE0LjksMC0yNy4xLTEyLjItMjcuMS0yNy4xdi02NC41bDkyLjgtOTIuOGw3OS4zLDc5LjMNCgkJCWM0LjgsNC44LDEyLjUsNC44LDE3LjMsMGwxNDMuMi0xNDMuMmwxMDcuOCwxMDcuOHYxMTMuNEM0NjQuOSw0NTIuNyw0NTIuNyw0NjQuOSw0MzcuOCw0NjQuOXogTTUxLjYsMjQuNWgzODYuMg0KCQkJYzE0LjksMCwyNy4xLDEyLjIsMjcuMSwyNy4xdjIzOC4xbC05OS4yLTk5LjFjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwTDIwNS4yLDMzMy44bC03OS4zLTc5LjNjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwDQoJCQlsLTg0LjEsODQuMXYtMjg3QzI0LjUsMzYuNywzNi43LDI0LjUsNTEuNiwyNC41eiIvPg0KCQk8cGF0aCBkPSJNMTUxLjcsMTk2LjFjMzQuNCwwLDYyLjMtMjgsNjIuMy02Mi4zcy0yOC02Mi4zLTYyLjMtNjIuM3MtNjIuMywyOC02Mi4zLDYyLjNTMTE3LjMsMTk2LjEsMTUxLjcsMTk2LjF6IE0xNTEuNyw5Ng0KCQkJYzIwLjksMCwzNy44LDE3LDM3LjgsMzcuOHMtMTcsMzcuOC0zNy44LDM3LjhzLTM3LjgtMTctMzcuOC0zNy44UzEzMC44LDk2LDE1MS43LDk2eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K"
					<?php } ?>
					>
                </div>
				<label style="font-size:12px;color:#999;" ><?php echo get_the_date("d/m/Y",(int)$valor->media_id);?> | <?php echo $valor->title; ?></label>
				<label class="w-100  color-1"><?php echo $valor->sub_title; ?></label>

            </div>
        <?php } ?>
<?php 
	if(
		((count($result)%3)>0)
		&&
		(count($result)<=3)
	)
		for($count=0;$count<3-(count($result)%3);$count++) { 
?>	
            <div class="block-by-3  flex-wrap p-2 " style="max-width:500px;min-width:280px;min-height:1px"></div>
<?php
		}
?>
    </div>
  <div class="container">
		<hr style="margin-top:40px; margin-bottom: 20px;margin-left:auto;margin-right:auto; max-width: 50%;">
		<br>
		<div class="container-block-by">
               
                <?php 
                    if(count($result)>3 )
                    for($count=3;$count<(min(15,count($result)));$count++) { 
                        $valor=$result[$count];    
                    ?>
                        <div class="block-by-3  flex-wrap p-2 " style="max-width:500px;min-width:280px">
							<div class="w-100 " style="border-bottom: 1px solid #ccc;">
								<div class="w-100 container-block-by justify-content-start">
									<form method="post"  class="d-flex" style="height:30px;width:30px;">
										<input name="id" type="hidden" value="<?php echo $valor->id; ?>">
										<input name="acao" type="hidden" value="Editar">
										<button type="submit" class="p-1 border rounded  fas fa-pen bg-dark text-white" style="font-size:15px;height:30px;width:30px;"></button>
									</form>
									<form method="post"  class="d-flex" style="height:30px;width:30px;">
										<input name="id" type="hidden" value="<?php echo $valor->id; ?>">
										<input name="acao" type="hidden" value="Excluir">
										<button type="submit" class="p-1 border rounded  fas fa-minus bg-dark text-white" style="font-size:15px;height:30px;width:30px;"></button>
									</form>
								</div>
								<a  class="text-decoration-none"  target="_blank" href="<?php echo wp_get_attachment_url($valor->media_id); ?>">
									<label style="font-size:12px;color:#999;" ><?php echo get_the_date("d/m/Y",(int)$valor->media_id);?> | <?php echo $valor->title; ?></label>
									<label class="w-100  color-1"><?php echo $valor->sub_title; ?></label>
								</a>
							</div>
						</div>
                    <?php 
                    } 
                ?>
<?php 
	if(
		((count($result)%3)>0)

	)
		for($count=0;$count<3-(count($result)%3);$count++) { 
?>	
            <div class="block-by-3  flex-wrap p-2 " style="max-width:500px;min-width:280px;min-height:1px"></div>
<?php
		}
?>				
		</div>
    </div>
<?php
	require_once plugin_dir_path( __FILE__ ) . 'parts/paginate.php';
?>
    <script src="<?php echo	plugins_url( '../js/pdf.worker.js', __FILE__ )?>"></script>
    <script src="<?php echo	plugins_url( '../js/pdf.js', __FILE__ )?>"></script>

    <script>
        function limpar(element_){
            //window.editor.setData( '' );
            jQuery(element_.form).find("input")
            .not(':button, :submit, :reset')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');
            jQuery(element_.form).find("textarea").val('');
            jQuery(element_.form).find("option:selected").removeAttr("selected");
            jQuery("#codeImg").attr("src","data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNDg5LjQgNDg5LjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4OS40IDQ4OS40OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTAsNDM3LjhjMCwyOC41LDIzLjIsNTEuNiw1MS42LDUxLjZoMzg2LjJjMjguNSwwLDUxLjYtMjMuMiw1MS42LTUxLjZWNTEuNmMwLTI4LjUtMjMuMi01MS42LTUxLjYtNTEuNkg1MS42DQoJCQlDMjMuMSwwLDAsMjMuMiwwLDUxLjZDMCw1MS42LDAsNDM3LjgsMCw0MzcuOHogTTQzNy44LDQ2NC45SDUxLjZjLTE0LjksMC0yNy4xLTEyLjItMjcuMS0yNy4xdi02NC41bDkyLjgtOTIuOGw3OS4zLDc5LjMNCgkJCWM0LjgsNC44LDEyLjUsNC44LDE3LjMsMGwxNDMuMi0xNDMuMmwxMDcuOCwxMDcuOHYxMTMuNEM0NjQuOSw0NTIuNyw0NTIuNyw0NjQuOSw0MzcuOCw0NjQuOXogTTUxLjYsMjQuNWgzODYuMg0KCQkJYzE0LjksMCwyNy4xLDEyLjIsMjcuMSwyNy4xdjIzOC4xbC05OS4yLTk5LjFjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwTDIwNS4yLDMzMy44bC03OS4zLTc5LjNjLTQuOC00LjgtMTIuNS00LjgtMTcuMywwDQoJCQlsLTg0LjEsODQuMXYtMjg3QzI0LjUsMzYuNywzNi43LDI0LjUsNTEuNiwyNC41eiIvPg0KCQk8cGF0aCBkPSJNMTUxLjcsMTk2LjFjMzQuNCwwLDYyLjMtMjgsNjIuMy02Mi4zcy0yOC02Mi4zLTYyLjMtNjIuM3MtNjIuMywyOC02Mi4zLDYyLjNTMTE3LjMsMTk2LjEsMTUxLjcsMTk2LjF6IE0xNTEuNyw5Ng0KCQkJYzIwLjksMCwzNy44LDE3LDM3LjgsMzcuOHMtMTcsMzcuOC0zNy44LDM3LjhzLTM3LjgtMTctMzcuOC0zNy44UzEzMC44LDk2LDE1MS43LDk2eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K");
            jQuery("#form-data").css("display","block");
            jQuery(".system-menssage").remove();
			loadDimension();
        }
			
			
		var setImageAndInputFileFirstPagePDFbyURL= function(img,inputfile,url){
				if((url!=null)&&(url!=undefined)&&(url.length>0)){    
					var	canvas=document.createElement("CANVAS");
					if(canvas!=null){
						pdfjsLib.getDocument(url).promise.then(function (doc) {
							
						  var pages = []; 
						  var canvas_width=500;
						  var canvas_height=500;
						  
						 
						  if (pages.length < doc.numPages) pages.push(pages.length + 1);
						  return Promise.all(pages.map(function (num) {
							return doc.getPage(num).then(
								function (page) {
									var scale = 1;
									var viewport = page.getViewport({ scale: scale});
									scale = Math.min(canvas_width / viewport.width, canvas_height / viewport.height);
									viewport = page.getViewport({ scale: scale});
									var outputScale = window.devicePixelRatio || 1;
									var context = canvas.getContext('2d');
									canvas.width = Math.floor(viewport.width * outputScale);
									canvas.height = Math.floor(viewport.height * outputScale);
									canvas.style.width = Math.floor(viewport.width) + "px";
									canvas.style.height =  Math.floor(viewport.height) + "px";
									var transform = outputScale !== 1
									  ? [outputScale, 0, 0, outputScale, 0, 0]
									  : null;
									var renderContext = {
									  canvasContext: context,
									  transform: transform,
									  viewport: viewport
									};
									var task=page.render(renderContext);
									task.promise.then(function(){
										var imageData64=canvas.toDataURL('image/jpeg',0.75);

										let fileName = url.substring(url.lastIndexOf('/')+1);
										let fileExtension = fileName.substring(fileName.lastIndexOf('.')+1);
										fileName=fileName.replace(fileExtension,"jpg");
										(fetch(imageData64,inputfile)
											.then(function(res){return res.arrayBuffer();})
											.then(function(buf){
												let file=new File([buf], fileName,{type:"image/jpeg"});
												let container = new DataTransfer(); 
												container.items.add(file);
												jQuery(inputfile).get(0).files = container.files;
												jQuery(img).attr("src",imageData64);
												return 0
											})
										);
									});
								}
							)  
						  }));
						}).catch(console.error);
					}
				}
				return "";
			}	   
			
        jQuery(document).ready( function($) { 
           
            jQuery("#add_image").click(function(e) {
                var send_attachment_bkp = wp.media.editor.send.attachment;

                wp.media.editor.send.attachment = function(props, attachment) {
                    $('#codeImg').val(attachment.id);
                    $('#title').val(attachment.title);
                    $('#date_file').val(attachment.date.toLocaleDateString('en-CA'));
					setImageAndInputFileFirstPagePDFbyURL( $('#viewImg'),$('#fileImg'),attachment.url);
                    wp.media.editor.send.attachment = send_attachment_bkp;
                }

                wp.media.editor.open();
            
            });
        });
		var loadDimension =function(){
			jQuery(".height-square").each(function(){
					jQuery(this).height(jQuery(this).width());
			});
			jQuery(".dimenssion-parent").each(function(){
				height=($(this).parent().height());
				width=($(this).parent().width());
				jQuery(this).height(height);
				jQuery(this).width(width);
			});
			jQuery(".max-height-parent-first-child").each(function(){
				height=($(this).parent().children(":first").height());
				jQuery(this).css("max-height",height+"px");
			});
			jQuery(".min-height-first-child").each(function(){
				height=($(this).first().height());
				if(jQuery(this).css("max-height").replace('px', '')>height)
					jQuery(this).css("min-height",jQuery(this).css("max-height"));
				else
					jQuery(this).css("min-height",height+"px");
			});
		}
		setTimeout(loadDimension,250);
    </script>