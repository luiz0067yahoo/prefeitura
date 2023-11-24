<?php
/*
CREATE TABLE $wpdb->prefixcadastro_empresas(
  id int(11) NOT NULL auto_increment primary key,
  post_id int(11) DEFAULT NULL,
  term_id int(11) DEFAULT NULL,
  nome_empresa varchar(50) DEFAULT NULL,
  endereco varchar(50) DEFAULT NULL,
  telefone varchar(50) DEFAULT NULL,
  rs_email varchar(99) DEFAULT NULL,
  rs_facebook varchar(99) DEFAULT NULL,
  rs_instagram varchar(99) DEFAULT NULL,
  rs_whatsapp varchar(50) DEFAULT NULL,
  rs_youtube varchar(99) DEFAULT NULL,
  rs_twitter varchar(99) DEFAULT NULL,
  rs_website varchar(99) DEFAULT NULL
);   
*/
//asdd
$post_type="post";
$post_type="empresa";
global $wpdb;
$tabela_nome = $wpdb->prefix . 'cadastro_empresas';
$str_conditions="";
$args=[];
$campos = null;
$resultado = null;
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
$rows_per_page = 10;
if($_POST){
    $id = (isset($_POST['id']) && !empty($_POST['id']))?sanitize_text_field($_POST['id']):null;
    $post_id = (isset($_POST['post_id']) && !empty($_POST['post_id']))?sanitize_text_field($_POST['post_id']):null;
    $term_id = (isset($_POST['term_id']) && !empty($_POST['term_id']))?sanitize_text_field($_POST['term_id']):null;
    $nome_empresa = (isset($_POST['nome_empresa']) && !empty($_POST['nome_empresa']))?sanitize_text_field($_POST['nome_empresa']):"";
    $endereco = (isset($_POST['endereco']) && !empty($_POST['endereco']))?sanitize_text_field($_POST['endereco']):"";
    $telefone = (isset($_POST['telefone']) && !empty($_POST['telefone']))?sanitize_text_field($_POST['telefone']):"";
    $rs_email = (isset($_POST['rs_email']) && !empty($_POST['rs_email']))?sanitize_text_field($_POST['rs_email']):"";
    $rs_facebook = (isset($_POST['rs_facebook']) && !empty($_POST['rs_facebook']))?sanitize_text_field($_POST['rs_facebook']):"";
    $rs_instagram = (isset($_POST['rs_instagram']) && !empty($_POST['rs_instagram']))?sanitize_text_field($_POST['rs_instagram']):"";
    $rs_whatsapp = (isset($_POST['rs_whatsapp']) && !empty($_POST['rs_whatsapp']))?sanitize_text_field($_POST['rs_whatsapp']):"";
    $rs_youtube = (isset($_POST['rs_youtube']) && !empty($_POST['rs_youtube']))?sanitize_text_field($_POST['rs_youtube']):"";
    $rs_twitter = (isset($_POST['rs_twitter']) && !empty($_POST['rs_twitter']))?sanitize_text_field($_POST['rs_twitter']):"";
    $rs_website = (isset($_POST['rs_website']) && !empty($_POST['rs_website']))?sanitize_text_field($_POST['rs_website']):"";
    $post_content=
    "<div class='text-block'>".
        //"<p>".$nome_empresa."</p>".
        "<hr>".
        (   
            (isset($endereco) && !empty($endereco))
            ?"<p><b class=\"color-4\">Endereco: </b> ".$endereco
            :""
        ).
        (   
            (isset($telefone) && !empty($telefone))
            ?"<p><b class=\"color-4\">Telefone: </b> ".$telefone
            :""
        ).
        (   
            (isset($rs_email) && !empty($rs_email))
            ?"<p><b class=\"color-4\">E-mail: </b> ".$rs_email
            :""
        ).
        (   
            (isset($rs_facebook) && !empty($rs_facebook))
            ?"<p><b class=\"color-4\">Facebook: </b> ".$rs_facebook
            :""
        ).
        (   
            (isset($rs_instagram) && !empty($rs_instagram))
            ?"<p><b class=\"color-4\">Instagram: </b> ".$rs_instagram
            :""
        ).
        (   
            (isset($rs_whatsapp) && !empty($rs_whatsapp))
            ?"<p><b class=\"color-4\">Whatsapp: </b> ".$rs_whatsapp
            :""
        ).
        (   
            (isset($rs_youtube) && !empty($rs_youtube))
            ?"<p><b class=\"color-4\">Youtube: </b> ".$rs_youtube
            :""
        ).
        (   
            (isset($rs_twitter) && !empty($rs_twitter))
            ?"<p><b class=\"color-4\">Twitter: </b> ".$rs_twitter
            :""
        ).
		(   
            (isset($rs_website) && !empty($rs_website))
            ?"<p><b class=\"color-4\">Website: </b> ".$rs_website
            :""
        ).
    "</div>";

    if (isset($_POST['acao']) && !empty($_POST['acao']) && ($_POST['acao'] == "Salvar")) {
        $params=[
            'term_id' => $term_id,
            'post_id' => $post_id,
            'nome_empresa' => $nome_empresa,
            'endereco' => $endereco,
            'telefone' => $telefone,
            'rs_email' => $rs_email,
            'rs_facebook' => $rs_facebook,
            'rs_instagram' => $rs_instagram,
            'rs_whatsapp' => $rs_whatsapp,
            'rs_youtube' => $rs_youtube,
            'rs_twitter' => $rs_twitter,
            'rs_website' => $rs_website,
        ];
        $params['post_id']=$post_id;
        if (!empty($id)) {
            $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $tabela_nome WHERE (ID=%d) limit  1",$id));
            $post_id = wp_update_post(array ('ID' => $post_id,'post_category' => [$term_id],'post_title' => $nome_empresa,'post_content' => $post_content,'post_type' => $post_type,'post_status' => 'publish',));
            $params['post_id']=$post_id;
            $wpdb->update($tabela_nome,$params,['id' => $id]);
        } else {
            $post_id = wp_insert_post(array (
                'post_category' => [$term_id],  // /servicos/turismo/  ...
                'post_type' => $post_type,
                'post_title' => $nome_empresa,
                'post_content' => $post_content,
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ));
            $params['post_id']=$post_id;
            $wpdb->insert($tabela_nome,$params);
        }
        if ($wpdb) {
            echo "<h1 class='bg-success w-100 text-white text-center'>Salvo com Sucesso</h1>";
        } else {
            echo "<h1 class='bg-danger w-100 text-white text-center'>Erro ao salvar evento</h1>";
        }
    }    
    else if (!empty($_POST['acao']) && ($_POST['acao'] == "Excluir")) {
        if (isset($id) && !empty($id)) {
            $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $tabela_nome WHERE (ID=%d) limit 1",$id));
            wp_delete_post($post_id,true);
            $apagar = $wpdb->delete($tabela_nome, array('id' => $id));

            if ($apagar) {
                echo "<h1 class='bg-success w-100 text-white text-center system-menssage'>Deletada com Sucesso</h1>";
            } else {
				echo "<h1 class='bg-success w-100 text-white text-center system-menssage'>Erro ao deletar</h1>";
            }
        }
    }
    else if (!empty($_POST['acao']) && ($_POST['acao'] == "Editar")) {
        if (isset($id) && !empty($id)) {
            $str_conditions = " WHERE (id = %d)";
            array_push($args, $id);
            $campos = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabela_nome $str_conditions ORDER BY ID ASC", $args));
            $str_conditions = "";
			$args=[];
        }
    }
    
    else if (!empty($_POST['acao']) && ($_POST['acao'] == "Buscar")) {
        $conditions = [];
        if(!empty($term_id)&&(strlen($term_id)>0)){
            array_push($args,$term_id);
            array_push($conditions,"(term_id = %d)");
        }
        if(!empty($nome_empresa)&&(strlen($nome_empresa)>0)){
            $nome_empresa_contem=strtoupper("%".$nome_empresa."%");
            array_push($args,$nome_empresa);
            array_push($conditions,"(UPPER(nome_empresa) like %s)");
        }
        if(!empty($endereco)&&(strlen($endereco)>0)){
            $endereco_contem=strtoupper("%".$endereco."%");
            array_push($args,$endereco_contem);
            array_push($conditions,"(UPPER(endereco) like %s)");
        }
        if(!empty($telefone)&&(strlen($telefone)>0)){
            $telefone_contem=strtoupper("%".$telefone."%");
            array_push($args,$telefone_contem);
            array_push($conditions,"(UPPER(telefone) like %s)");
        }
        if(!empty($rs_email)&&(strlen($rs_email)>0)){
            $rs_email_contem=strtoupper("%".$rs_email."%");
            array_push($args,$telefone_contem);
            array_push($conditions,"(UPPER(rs_email) like %s)");
        }
        if(!empty($rs_facebook)&&(strlen($rs_facebook)>0)){
            $rs_facebook_contem=strtoupper("%".$rs_facebook."%");
            array_push($args,$rs_facebook_contem);
            array_push($conditions,"(UPPER(rs_facebook) like %s)");
        }
        if(!empty($rs_instagram)&&(strlen($rs_instagram)>0)){
            $rs_instagram_contem=strtoupper("%".$rs_instagram."%");
            array_push($args,$rs_instagram_contem);
            array_push($conditions,"(UPPER(rs_instagram) like %s)");
        }
        if(!empty($rs_whatsapp)&&(strlen($rs_whatsapp)>0)){
            $rs_whatsapp_contem=strtoupper("%".$rs_whatsapp."%");
            array_push($args,$rs_whatsapp_contem);
            array_push($conditions,"(UPPER(rs_whatsapp) like %s)");
        }
        if(!empty($rs_youtube)&&(strlen($rs_youtube)>0)){
            $rs_youtube_contem=strtoupper("%".$rs_youtube."%");
            array_push($args,$rs_youtube_contem);
            array_push($conditions,"(UPPER(rs_youtube) like %s)");
        }
        if(!empty($rs_twitter)&&(strlen($rs_twitter)>0)){
            $rs_twitter_contem=strtoupper("%".$rs_twitter."%");
            array_push($args,$rs_twitter_contem);
            array_push($conditions,"(UPPER(rs_twitter) like %s)");
        }
		if(!empty($rs_website)&&(strlen($rs_website)>0)){
            $rs_websitecontem=strtoupper("%".$rs_website."%");
            array_push($args,$rs_website_contem);
            array_push($conditions,"(UPPER(rs_website) like %s)");
        }
		$str_conditions = (count($args) > 0)?" WHERE (" . implode("and", $conditions) . ")":"";
    } 
}
$total = $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM $tabela_nome $str_conditions ",$args));
$offset = ($page - 1) * $rows_per_page;
$resultado = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabela_nome $str_conditions ORDER BY ID DESC limit {$offset}, {$rows_per_page}", $args));
?>
<div class="container">
	<h1 class="w-100 text-center ">Empresas</h1>
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
		<h1 class="text-center"><?php if(isset($id)){ ?>Alterar<?php } else{ ?>Inserir<?php } ?> Empresa</h1>
		
		<form method="post" enctype="multipart/form-data"  >
			<input type="hidden" name="id" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->id)) echo $campos[0]->id; ?>">
			   
			<div class="input-group w-100">
				<label class="w-100"> Categoria </label>
				<select class="w-100" name="term_id">
					<option value="" class="w-100">Nenhum</option>
					<?php
						global $wp_query;
						global $wpdb;
						//$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}terms "));
						//77//turismo
						$result_option_group = get_categories(array(
							'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
							'orderby'    => 'id',
							'parent'     => 77,//turismo
							'hide_empty' => 0, // change to 1 to hide categores not having a single post
						));
						//$wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}terms "));
						foreach ($result_option_group as $category_group ) {
							$cat_ID_group        = (int) $category_group->term_id;
							$category_name_group = $category_group->name;
						?>
							<option  class="w-100"  value="<?php echo $cat_ID_group; ?>" <?php if ($term_id==$cat_ID_group) echo "selected"; ?>>
								<?php echo $category_name_group;?>
							</option>
						<?php 
							$result_option = get_categories(array(
								'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
								'orderby'    => 'id',
								'parent'     => $cat_ID_group,//turismo
								'hide_empty' => 0, // change to 1 to hide categores not having a single post
							));
							foreach ($result_option as $category ) {
								$cat_ID        = (int) $category->term_id;
								$category_name = $category->name;
							?>
							<option  class="w-100"  value="<?php echo $cat_ID; ?>" <?php if ($term_id==$cat_ID) echo "selected"; ?>>
								<?php echo $category_name_group;?>
								/
								<?php echo $category_name;?>
							</option>
							<?php
							}
							?>
					<?php } ?>
				</select>
			</div>
				
			<br>

			<div class="input-group">
				<label class="w-100"> Nome Empresa </label>
				<input type="text" name="nome_empresa" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0  && isset($campos[0]->nome_empresa)) echo $campos[0]->nome_empresa; ?>">
			</div>

			<br>

			<div class="input-group">
				<label class="w-100"> Endereço </label>
				<input type="text" name="endereco" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->endereco)) echo $campos[0]->endereco; ?>">
			</div>        

			<br>

			<div class="input-group">
				<label class="w-100"> Telefone </label>
				<input type="text" name="telefone" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->telefone)) echo $campos[0]->telefone; ?>">
			</div>        

			<br>

			<div class="input-group">
				<label class="w-100"> Email </label>
				<input type="text" name="rs_email" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->rs_email)) echo $campos[0]->rs_email; ?>">
			</div>        

			<br>

			<div class="input-group">
				<label class="w-100"> Link Facebook </label>
				<input type="text" name="rs_facebook" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->rs_facebook)) echo $campos[0]->rs_facebook; ?>">
			</div>        

			<br>

			<div class="input-group">
				<label class="w-100"> Link Instagram </label>
				<input type="text" name="rs_instagram" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->rs_instagram)) echo $campos[0]->rs_instagram; ?>">
			</div>        

			<br>

			<div class="input-group">
				<label class="w-100"> WhatsApp </label>
				<input type="text" name="rs_whatsapp" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->rs_whatsapp)) echo $campos[0]->rs_whatsapp; ?>">
			</div>        

			<br>

			<div class="input-group">
				<label class="w-100"> Link Youtube </label>
				<input type="text" name="rs_youtube" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->rs_youtube)) echo $campos[0]->rs_youtube; ?>">
			</div>        

			<br>

			<div class="input-group">
				<label class="w-100"> Link Twitter </label>
				<input type="text" name="rs_twitter" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->rs_twitter)) echo $campos[0]->rs_twitter; ?>">
			</div>        

			<br>
			<div class="input-group">
				<label class="w-100"> Web Site </label>
				<input type="text" name="rs_website" class="form-control" value="<?php if (is_array($campos) && count($campos) > 0 && isset($campos[0]->rs_website)) echo $campos[0]->rs_website; ?>">
			</div>        

			<br>

			<br>
			<input type="submit" name="acao" value="Salvar" class=" btn btn-dark">
			<input type="submit" name="acao" value="Buscar" class=" btn btn-dark">

			<br>

		</form>
    </div>
</div>
<input id="clean" type="button" name="acao" value="Novo" class="m-4 btn btn-dark" >
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID categoria</th>
                    <th scope="col">Nome Empresa</th>
                    <th scope="col">Endereco</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Email</th>
                    <!-- <th scope="col">Facebook</th>
                    <th scope="col">Instagram</th> -->
                    <th scope="col">WhatsApp</th>
                    <!-- <th scope="col">Youtube</th>
                    <th scope="col">Twitter</th> -->
                    <th scope="col">Ações</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $valor) : ?>
                    <form method="POST">
                        <tr>
                            <input name="id" type="hidden" value="<?php echo $valor->id; ?>">
                            <td><?php if (isset($valor->term_id) && empty($valor->term_id)) echo $valor->term_id; ?></td>
                            <td><?php if (isset($valor->nome_empresa) && empty($valor->nome_empresa)) echo $valor->nome_empresa; ?></td>
                            <td><?php if (isset($valor->endereco) && empty($valor->endereco)) echo $valor->endereco; ?></td>
                            <td><?php if (isset($valor->telefone) && empty($valor->telefone)) echo $valor->telefone; ?></td>
                            <td><?php if (isset($valor->rs_email) && empty($valor->rs_email)) echo $valor->rs_email; ?></td>
                            <!-- <td><?php if (isset($valor->rs_facebook) && empty($valor->rs_facebook)) echo $valor->rs_facebook; ?></td>
                            <td><?php if (isset($valor->rs_instagram) && empty($valor->rs_instagram)) echo $valor->rs_instagram; ?></td> -->
                            <td><?php if (isset($valor->rs_whatsapp) && empty($valor->rs_whatsapp)) echo $valor->rs_whatsapp; ?></td>
                            <!-- <td><?php if (isset($valor->rs_youtube) && empty($valor->rs_youtube)) echo $valor->rs_youtube; ?></td>
                            <td><?php if (isset($valor->rs_twitter) && empty($valor->rs_twitter)) $valor->rs_twitter; ?></td> -->
                            <td><input name="acao" type="submit" value="Excluir"></td>
                            <td><input name="acao" type="submit" value="Editar"></td>
                        </tr>
                    </form>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<hr style="margin-top:40px; margin-bottom: 20px;margin-left:auto;margin-right:auto; max-width: 50%;">

<!-- Next page -->
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
		jQuery("#clean").click(function(){
			//window.editorDescricao.setData( '' );
			//window.editorMaisInformacoes.setData( '' );
			jQuery("#form-data").find("input")
			.not(':button, :submit, :reset')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected');
			jQuery("#form-data").find("textarea").val('');
			jQuery("#form-data").find("option:selected").removeAttr("selected");
			jQuery("#form-data").css("display","block");
			jQuery(".system-menssage").remove();
			loadDimension();
		});
		
		
	});
</script>