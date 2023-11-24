<?php
    $category = get_queried_object();
    $cat_ID=$category->term_id;
    $id_post=0;
    $show_news=false;
    $show_title=false;
    $background_color="#01913a";
    $title_color="#FFFFFF";
    $image_background_id=null;
    $tabela_nome = $wpdb->prefix . 'terms';
    $sql = "SELECT id_post,title_color,show_news,show_title,background_color,image_background_id FROM $tabela_nome WHERE($tabela_nome.term_id=%d)";
    $resultado = $wpdb->get_results($wpdb->prepare($sql,$category->term_id));
    foreach ($resultado as $valor) {
        $id_post=$valor->id_post;
        $show_news=$valor->show_news;
        $show_title=$valor->show_title;
        $background_color=$valor->background_color;
        $image_background_id=$valor->image_background_id;
        $title_color=$valor->title_color;
        break;
    }
    if((isset($image_background_id))||($show_title==1)){?>
		<header class="<?php echo "level-1";?> headCategory container-fluid" style="overflow-x:hidden;background-color:<?php echo $background_color;?>;background-image:url('<?php if(isset($image_background_id)) echo wp_get_attachment_image_url ( $image_background_id, 'full' );?>')">
			
				<h1 style="color:<?php echo $title_color;?>"><a href="<?php echo get_category_link($cat_ID);?>" style="color:<?php echo $title_color;?>;font-family:inherit;text-decoration:none;"> <?php if($show_title==1){  echo get_cat_name($cat_ID);} ?> </a></h1>
			
		</header>
		<?php  } ?>
		<div class="container ">
            <h1 class="text-center w-100 mt-4   " style="text-transform: uppercase;"><a class="color-1" href="<?php echo get_category_link($cat_id_level_1);?>" style="font-family:inherit;text-decoration:none;"><?php echo get_cat_name($cat_id_level_1); ?></a></h1>
            <hr style="margin-top:20px; margin-bottom: 20px;margin-left:auto;margin-right:auto; max-width: 50%;">            
            <?php if((isset($id_post))&&(isset($content_post->post_title))&&(! empty($content_post->post_title))){?>
                <div class="row mt-5">
                    <p style="text-align:center; font-size: 40px; margin-bottom: 0;" class="w-100"><?php if(isset($id_post))echo $content_post->post_title ;?></p>
                    <hr style="width: 35%; margin: auto; height: 4px; margin-bottom: 20px; opacity:unset; background-color: var(--cor-4);">
                </div>
            <?php } ?>
		</div>
        <?php
            $id_post=null;
            $tabela_nome = $wpdb->prefix . 'terms';
            $sql = "SELECT id_post FROM $tabela_nome WHERE($tabela_nome.term_id=%d)";
            $resultado = $wpdb->get_results($wpdb->prepare($sql,$category->term_id));
            foreach ($resultado as $valor) {
                $id_post=$valor->id_post;
                break;
            }
            $content_post = get_post($id_post);
            $show_title=get_post_meta($id_post, "show_title",true);
            if(($show_title=="on")&&(isset($id_post))&&(isset($content_post->post_title))&&(! empty($content_post->post_title))){?>
                <div class="container ">
                    <div class="row mt-5">
                        <p style="text-align:center; font-size: 40px; margin-bottom: 0;" class="w-100"><?php if(isset($id_post))echo $content_post->post_title ;?></p>
                        <hr style="width: 35%; margin: auto; height: 4px; margin-bottom: 20px; opacity:unset; background-color: var(--cor-4);">
                    </div>
                </div>
        <?php } ?>
    <div id="empresas" class="container mt-4 ">
        <?php if(isset($id_post)) echo $content_post->post_content;?>
        <?php
            if($cat_id_level_2!=0){
        ?>
        <h1 class="text-center w-100" style="text-transform: uppercase;"><?php echo get_cat_name($cat_id_level_2); ?></h1>
        <?php } ?>
        
    </div>
<?php
global $wpdb;
$tabela_nome = $wpdb->prefix . 'cadastro_pdf';
$url_canvas="";
$str_conditions="";
$args=[];
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
$rows_per_page = 18;
$id = null;

$search = sanitize_text_field($_POST['search']);
if($_POST){
    if (!empty($_POST['search']) && isset($_POST['search']) ) {
        $conditions = [];
        
        if (!empty($search) && (strlen($search) > 0)) {
            $search_contem = strtoupper("%" . sanitize_text_field($_POST['search']) . "%");
            array_push($args, $search_contem);
            array_push($conditions, "(UPPER(title) LIKE %s)");

            array_push($args, $search_contem);
            array_push($conditions, "(description LIKE %s)");
        }
        $str_conditions = "";
        if (count($args) > 0) {
            $str_conditions = " WHERE (" . implode("OR", $conditions) . ")";
        }
    } 
}
$total = $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM $tabela_nome $str_conditions ",$args));
$offset = ($page - 1) * $rows_per_page;
$resultado = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabela_nome $str_conditions ORDER BY ID DESC limit {$offset}, {$rows_per_page}", $args));
?>
	<form method="POST">
		<div class="input-group mb-4 mx-auto" style="width: 400px;min-width:260px;">
            
            <input type="search" name="search" class="form-control color-1" placeholder="buscar" style="border:5px solid var(--cor-3); background-color: var(--cor-3); text-align:center;" onfocus="this.placeholder=''" onfocusout="this.placeholder='O que você procura?'">
            <button type="submit" class="btn-social" id="search-addon" style="height: 46px; min-width: 40px;margin: auto; box-shadow: none;border:1px solid var(--cor-3) ">
                <i class="fa fa-search"></i>
            </button>
        </div>
	</form>
    <div class="container-block-by">
	
        <?php 
        for($count=0;$count<(min(3,count($resultado)));$count++) { 
            $valor=$resultado[$count];?>
            <div class="block-by-3  flex-wrap p-2 " style="max-width:500px;min-width:280px">
                <a  class="w-100 h-100 d-flex align-items-center" target="_blank" href="<?php echo wp_get_attachment_url($valor->media_id); ?>">
					<canvas class="overflow-hidden  canvas-pdf-image p-0 d-flex m-auto" url="<?php echo wp_get_attachment_url($valor->media_id); ?>"  
					style="align-self: center;width:auto;height:240px;min-width:240px;max-width:100%;border:black solid;">
					</canvas>
                </a>
                <label class="w-100 text-center"><?php echo $valor->title; ?></label>
            </div>
        <?php } ?>
    </div>
	
    <div class="container">
		<hr style="margin-top:40px; margin-bottom: 20px;margin-left:auto;margin-right:auto; max-width: 50%;">
		<br>
		<div class="container-block-by">
               
                <?php 
                    if(count($resultado)>3 )
                    for($count=3;$count<(min(15,count($resultado)));$count++) { 
                        $valor=$resultado[$count];    
                    ?>
                        <div class="block-by-3  flex-wrap p-2 " style="max-width:500px;min-width:280px">
							<a  class="text-decoration-none w-100" style="border-bottom: 1px solid #ccc;" target="_blank" href="<?php echo wp_get_attachment_url($valor->media_id); ?>">
								<label style="font-size:12px;color:#999;" >01/01/2022 | <?php echo $valor->title; ?></label>
								<label class="w-100  color-1"><?php echo $valor->title; ?></label>
							</a>
						</div>
                    <?php 
                    } 
                ?>
		</div>
    </div>
<?php if($total>18){?>	
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
                            'total'     => ceil($total / $rows_per_page),
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
                    </div>
                </div>
        </div>
    </nav>  
<?php } ?>
    <script src="<?php echo	plugins_url( 'js/pdf.worker.js', __FILE__ )?>"></script>
    <script src="<?php echo	plugins_url( 'js/pdf.js', __FILE__ )?>"></script