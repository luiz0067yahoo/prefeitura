<?php

if ( ! class_exists( 'CT_TAX_META' ) ) {

class CT_TAX_META {

  public function __construct() {
    //
  }
 
 /*
  * Initialize the class and start calling our hooks and filters
  * @since 1.0.0
 */
 public function init() {
    /*ALTER TABLE `."$wpdb->prefix".terms` ADD `image_icon_id` INT NULL AFTER `term_id`;*/
   add_action( 'category_add_form_fields', array ( $this, 'add_category_image' ), 10, 2 );
   add_action( 'created_category', array ( $this, 'save_category_image' ), 10, 2 );
   add_action( 'category_edit_form_fields', array ( $this, 'update_category_image' ), 10, 2 );
   add_action( 'edited_category', array ( $this, 'updated_category_image' ), 10, 2 );
   add_action( 'edited_custom_taxonomy', 'updated_category_image', 10, 2 );
 
   add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
   add_action( 'admin_footer', array ( $this, 'add_script' ) );
 }

/*
  * Save the form field
  * @since 1.0.0
 */
public function save_category_image ( $term_id, $tt_id ) {
  $image_icon_id =null;
  if( isset( $_POST['image_icon_id'] ) && '' !== $_POST['image_icon_id'] )
    $image_icon_id = $_POST['image_icon_id'];

  $image_background_id =null;
  if( isset( $_POST['image_background_id'] ) && '' !== $_POST['image_background_id'] )
      $image_background_id = $_POST['image_background_id'];

  $background_color =null;
  if( isset( $_POST['background_color'] ) && '' !== $_POST['background_color'] )
    $background_color = $_POST['background_color'];
  
  $title_color =null;
  if( isset( $_POST['title_color'] ) && '' !== $_POST['title_color'] )
    $title_color = $_POST['title_color'];
      
  $show_news =null;
  if( isset( $_POST['show_news'] ) && '' !== $_POST['show_news'] )
      $show_news = $_POST['show_news'];
      
  $show_title =null;
  if( isset( $_POST['show_title'] ) && '' !== $_POST['show_title'] )
      $show_title = $_POST['show_title'];
  
  $external_url =null;
  if( isset( $_POST['external_url'] ) && '' !== $_POST['external_url'] )
      $external_url = $_POST['external_url'];
       
      global  $wpdb;
     

    $tabela_nome = $wpdb->prefix . 'terms';
    $wpdb->update(
      $tabela_nome,
      array(
          'image_icon_id' => $image_icon_id ,
          'background_color' => $background_color,
          'title_color' => $title_color,
          'image_background_id' => $image_background_id,
          'show_title' => $show_title,
          'show_news' => $show_news,
          'external_url' => $external_url
      ),
      array('term_id' => $term_id)
    );
     

    delete_term_meta($term_id,'image_icon_id');
    add_term_meta($term_id,'image_icon_id', $image_icon_id, true );
    update_term_meta($term_id,'image_icon_id', $image_icon_id);
    $image_icon_id=get_term_meta($term_id,'image_icon_id',true);

    delete_term_meta($term_id,'background_color');
    add_term_meta($term_id,'background_color', $background_color, true );
    update_term_meta($term_id,'background_color', $background_color);
    $background_color=get_term_meta($term_id,'background_color',true);

    delete_term_meta($term_id,'title_color');
    add_term_meta($term_id,'title_color', $title_color, true );
    update_term_meta($term_id,'title_color', $title_color);
    $title_color=get_term_meta($term_id,'title_color',true);
  
    delete_term_meta($term_id,'image_background_id');
    add_term_meta($term_id,'image_background_id', $image_background_id, true );
    update_term_meta($term_id,'image_background_id', $image_background_id);
    $image_background_id=get_term_meta($term_id,'image_background_id',true);
  
    delete_term_meta($term_id,'show_news');
    add_term_meta($term_id,'show_news', $show_news, true );
    update_term_meta($term_id,'show_news', $show_news);
    $show_news=get_term_meta($term_id,'show_news',true);
  
    delete_term_meta($term_id,'show_title');
    add_term_meta($term_id,'show_title', $show_title, true );
    update_term_meta($term_id,'show_title', $show_title);
    $show_title=get_term_meta($term_id,'show_title',true);
  
    delete_term_meta($term_id,'external_url');
    add_term_meta($term_id,'external_url', $external_url, true );
    update_term_meta($term_id,'external_url', $external_url);
    $external_url=get_term_meta($term_id,'external_url',true);
  
  
 
 }
 


/*
 * Update the form field value
 * @since 1.0.0
 */
public function updated_category_image ( $term_id, $tt_id ) {
  $image_icon_id =null;
  if( isset( $_POST['image_icon_id'] ) && '' !== $_POST['image_icon_id'] )
    $image_icon_id = $_POST['image_icon_id'];

  $image_background_id =null;
  if( isset( $_POST['image_background_id'] ) && '' !== $_POST['image_background_id'] )
      $image_background_id = $_POST['image_background_id'];

  $background_color =null;
  if( isset( $_POST['background_color'] ) && '' !== $_POST['background_color'] )
    $background_color = $_POST['background_color'];
  
  $title_color =null;
  if( isset( $_POST['title_color'] ) && '' !== $_POST['title_color'] )
    $title_color = $_POST['title_color'];
         
  $show_news =null;
  if( isset( $_POST['show_news'] ) && '' !== $_POST['show_news'] )
      $show_news = $_POST['show_news'];
      
  $show_title =null;
  if( isset( $_POST['show_title'] ) && '' !== $_POST['show_title'] )
      $show_title = $_POST['show_title'];

  $external_url =null;
  if( isset( $_POST['external_url'] ) && '' !== $_POST['external_url'] )
      $external_url = $_POST['external_url'];   
    

  global  $wpdb;
   
    $tabela_nome = $wpdb->prefix . 'terms';
    $wpdb->update(
      $tabela_nome,
      array(
          'image_icon_id' => $image_icon_id ,
          'background_color' => $background_color,
          'title_color' => $title_color,
          'image_background_id' => $image_background_id,
          'show_news' => $show_news,
          'show_title' => $show_title,
          'external_url' => $external_url
      ),
      array('term_id' => $term_id)
    );
    delete_term_meta($term_id,'image_icon_id');
    add_term_meta($term_id,'image_icon_id', $image_icon_id, true );
    update_term_meta($term_id,'image_icon_id', $image_icon_id);
    $image_icon_id=get_term_meta($term_id,'image_icon_id',true);

    delete_term_meta($term_id,'background_color');
    add_term_meta($term_id,'background_color', $background_color, true );
    update_term_meta($term_id,'background_color', $background_color);
    $background_color=get_term_meta($term_id,'background_color',true);

    delete_term_meta($term_id,'title_color');
    add_term_meta($term_id,'title_color', $title_color, true );
    update_term_meta($term_id,'title_color', $title_color);
    $title_color=get_term_meta($term_id,'title_color',true);
  
    delete_term_meta($term_id,'image_background_id');
    add_term_meta($term_id,'image_background_id', $image_background_id, true );
    update_term_meta($term_id,'image_background_id', $image_background_id);
    $image_background_id=get_term_meta($term_id,'image_background_id',true);
  
    delete_term_meta($term_id,'show_news');
    add_term_meta($term_id,'show_news', $show_news, true );
    update_term_meta($term_id,'show_news', $show_news);
    $show_news=get_term_meta($term_id,'show_news',true);
  
    delete_term_meta($term_id,'show_title');
    add_term_meta($term_id,'show_title', $show_title, true );
    update_term_meta($term_id,'show_title', $show_title);
    $show_title=get_term_meta($term_id,'show_title',true);
  
    delete_term_meta($term_id,'external_url');
    add_term_meta($term_id,'external_url', $external_url, true );
    update_term_meta($term_id,'external_url', $external_url);
    $external_url=get_term_meta($term_id,'external_url',true);
  
  
} 


public function load_media() {
 wp_enqueue_media();
}
 
 /*
  * Add a form field in the new category page
  * @since 1.0.0
 */
 public function add_category_image ( $taxonomy ) { ?>
   <?php 
   $image_icon_id = 0;//get_term_meta ( $term -> term_id, 'image_icon_id', true ); 
   $image_background_id = 0;//get_term_meta ( $term -> term_id, 'image_icon_id', true ); 
   ?>
      <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="">URL Externa</label>
     </th>
     <td><input type="text" name="external_url" value=""></td>
   </tr>
   <label >Cor de fundo do Título</label>
   <div id="background_color_div" style="background-color:#01913a; border: 1px solid black"><input id="background_color" name="background_color" style=" text-transform: uppercase" value='#01913a' /></div>
   <label >Cor do Título</label>
   <div id="title_color_div" style="background-color:#FFFFFF; border: 1px solid black;"><input id="title_color" name="title_color" style=" text-transform: uppercase" value='#FFFFFF' /></div>
   
   <div class="form-field term-group">
     <label for="image_icon_id">Ícone</label>
     <input type="hidden" id="image_icon_id" name="image_icon_id" class="image_icon_id" value="<?php echo $image_icon_id; ?>">
     <div id="category-image-icon-wrapper">
         <?php if ( $image_icon_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_icon_id, 'thumbnail' ); ?>
         <?php } ?>
	  </div>
     <p>
       <input type="button" class="button button-secondary image_icon_id_add" id="image_icon_id_add" name="image_icon_id_add" value="Adicionar Image" />
       <input type="button" class="button button-secondary image_icon_id_remove" id="image_icon_id_remove" name="image_icon_id_remove" value="Remover Imagem" />
    </p>
   </div>
   <div class="form-field term-group">
     <label for="image_background_id">Imagem de fundo</label>
     <input type="hidden" id="image_background_id" name="image_background_id" class="image_background_id" value="<?php echo $image_background_id; ?>">
     <div id="category-image-background-wrapper">
         <?php if ( $image_background_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_background_id, 'thumbnail' ); ?>
         <?php } ?>
	  </div>
     <p>
       <input type="button" class="button button-secondary image_background_id_add" id="image_background_id_add" name="image_background_id_add" value="Adicionar Image" />
       <input type="button" class="button button-secondary image_background_id_remove" id="image_background_id_remove" name="image_background_id_remove" value="Remover Imagem" />
    </p>
   </div>
   <div class="form-field term-group">
      <label for="">Exibir Retirar notícias relacionadas </label>
      <input type="checkbox" name="show_news" checked  value="1">
   </div>
   <div class="form-field term-group">
      <label for="">Exibir Título na categoria </label>
      <input type="checkbox" name="show_title" checked  value="1">
   </div>
 <?php
 }
 
 
 /*
  * Edit the form field
  * @since 1.0.0
 */
 public function update_category_image ( $term, $taxonomy ) { 
   global  $wpdb;
    $tabela_nome = $wpdb->prefix . 'terms';
    $term_id= $term->term_id;
    $sql="SELECT id_post,show_news,show_title,image_icon_id,background_color,title_color,image_background_id,external_url FROM $tabela_nome WHERE($tabela_nome.term_id=%d)";
    $resultado = $wpdb->get_results($wpdb->prepare($sql,$term_id));
   
    $image_icon_id=null;
    if((count($resultado)>0) && (isset($resultado[0]->image_icon_id)))
      $image_icon_id=$resultado[0]->image_icon_id;
      

    $background_color=null;
    if((count($resultado)>0) && (isset($resultado[0]->background_color)))
        $background_color=$resultado[0]->background_color;
 
    $title_color=null;
    if((count($resultado)>0) && (isset($resultado[0]->title_color)))
        $title_color=$resultado[0]->title_color;
            
    $image_background_id=null;
    if((count($resultado)>0) && (isset($resultado[0]->image_background_id)))
        $image_background_id=$resultado[0]->image_background_id;
    
    $id_post=null;
    if((count($resultado)>0) && (isset($resultado[0]->id_post)))
      $id_post=$resultado[0]->id_post;

    $show_news=null;
    if((count($resultado)>0) && (isset($resultado[0]->show_news)))
      $show_news=$resultado[0]->show_news;
   
    $show_title=null;
    if((count($resultado)>0) && (isset($resultado[0]->show_title)))
      $show_title=$resultado[0]->show_title;

    $external_url=null;
    if((count($resultado)>0) && (isset($resultado[0]->external_url)))
      $external_url=$resultado[0]->external_url;
?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="">URL Externa</label>
     </th>
     <td><input type="text" name="external_url" value="<?php if(isset($external_url)) echo $external_url;?>"></td>
   </tr>
   <tr class="form-field term-group-wrap">
   <th scope="row">
      <label >Cor de fundo do Título</label>
   </th>
     <td><div id="background_color_div" style="background-color:<?php echo (empty($background_color))?"#01913a" :$background_color; ?>;border: 1px solid black"><input id="background_color" name="background_color" style=" text-transform: uppercase" value='<?php echo (empty($background_color))?"#01913a" :$background_color; ?>' /></div></td>
   </tr>
   <tr class="form-field term-group-wrap">
   <th scope="row">
     <label >Cor do Título</label>
   </th>
     <td><div id="title_color_div" style="background-color:<?php echo (empty($title_color))?"#FFFFFF" :$title_color; ?>;border: 1px solid black"><input id="title_color" name="title_color" style=" text-transform: uppercase" value='<?php echo (empty($title_color))?"#FFFFFF" :$title_color; ?>' /></div></td>
   </tr>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="image_icon_id">Ícone   </label>
     </th>
     <td>
      
       <input type="hidden" id="image_icon_id" name="image_icon_id" value="<?php echo $image_icon_id; ?>">
       <div id="category-image-icon-wrapper">
         <?php if ( $image_icon_id ) { ?>
           <?php echo"<img style='whidth:120px;height:120px' src='".wp_get_attachment_image_url ( $image_icon_id, 'thumbnail' )."'>"; ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary image_icon_id_add" id="image_icon_id_add" name="image_icon_id_add" value="Adicionar Imagem" />
         <input type="button" class="button button-secondary image_icon_id_remove" id="image_icon_id_remove" name="image_icon_id_remove" value="Remover Imagem" />
       </p>
     </td>
   </tr>

   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="image_background_id">Imagem de fundo </label>
     </th>
     <td>
      
       <input type="hidden" id="image_background_id" name="image_background_id" value="<?php echo $image_background_id; ?>">
       <div id="category-image-background-wrapper">
         <?php if ( $image_background_id ) { ?>
           <?php echo"<img style='width:auto;height:120px' src='".wp_get_attachment_image_url ( $image_background_id, 'full' )."'>"; ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary image_background_id_add" id="image_background_id_add" name="image_background_id_add" value="Adicionar Imagem" />
         <input type="button" class="button button-secondary image_background_id_remove" id="image_background_id_remove" name="image_background_id_remove" value="Remover Imagem" />
       </p>
     </td>
   </tr>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="">Exibir Retirar notícias relacionadas </label>
     </th>
     <td><input type="checkbox" name="show_news" <?php if($show_news==1) echo "checked";?>  value="1"></td>
   </tr>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="">Exibir Título na Categoria </label>
       
     </th>
     <td>
          <input type="checkbox" name="show_title" <?php if($show_title==1) echo "checked";?>  value="1">
     </td>
   </tr>
   <?php if(isset($id_post)) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="">Post Principal </label>
     </th>
     <td>
      <h1>
        <?php echo get_the_title($id_post) ; ?>
        <a class="text-decoration-none" href="<?php echo get_the_permalink($id_post);?>"><input type="button" class="button button-secondary" value="VER POST"></a>
        <a class="text-decoration-none" href="<?php echo get_home_url();?>/wp-admin/post.php?post=<?php echo $id_post;?>&action=edit"><input type="button" class="button button-secondary" value="editar"></a>
      </h1>
       <input type="hidden" id="id_post" name="id_post" value="<?php echo $id_post; ?>">
       <div id="category-image-background-wrapper">
         <?php if ( $id_post ) { ?>
           <?php echo"<img style='width:auto;height:120px' src='".get_the_post_thumbnail_url ( $id_post, 'full' )."'>"; ?>
         <?php } ?>
       </div>
      
     </td>
   </tr>
   
   <?php } ?>

   
   
 <?php
 }



/*
 * Add script
 * @since 1.0.0
 */
 public function add_script() { ?>
   <script src="<?php echo	plugins_url( '/../js/colorpicker.js', __FILE__ )?>"></script>
   <script>
    jQuery(document).ready( function($) {
     
     
      jQuery('#title_color').change(function(){
        jQuery('#title_color_div').css('backgroundColor', jQuery("#title_color").val());
        console.log(jQuery("#title_color").val());
      });
      $('#background_color').change(function(){
        $('#background_color_div').css('backgroundColor', $("#background_color").val());
      });
      $('#background_color').ColorPicker({
        color: $('#background_color').val(),
        onShow: function (colpkr) {
          $(colpkr).fadeIn(500);
          return false;
        },
        onHide: function (colpkr) {
          $(colpkr).fadeOut(500);
          return false;
        },
        onChange: function (hsb, hex, rgb) {
          $('#background_color_div').css('backgroundColor', '#' + hex);
          $('#background_color').val('#' +hex);
        }
      });

      
      jQuery('#title_color').ColorPicker({
        color: jQuery('#title_color').val(),
        onShow: function (colpkr) {
          jQuery(colpkr).fadeIn(500);
          return false;
        },
        onHide: function (colpkr) {
          jQuery(colpkr).fadeOut(500);
          return false;
        },
        onChange: function (hsb, hex, rgb) {
          jQuery('#title_color_div').css('backgroundColor', '#' + hex);
          jQuery('#title_color').val('#' +hex);
        }
      });


       function ct_media_upload_image_icon_id(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#image_icon_id').val(attachment.id);
               $('#category-image-icon-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#category-image-icon-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }

     function ct_media_upload_image_background_id(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#image_background_id').val(attachment.id);
               $('#category-image-background-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#category-image-background-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }


     ct_media_upload_image_icon_id('.image_icon_id_add.button'); 
     $('body').on('click','.image_icon_id_remove',function(){
       $('#image_icon_id').val('');
       $('#category-image-icon-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });

     ct_media_upload_image_background_id('.image_background_id_add.button'); 
     $('body').on('click','.image_background_id_remove',function(){
       $('#image_background_id').val('');
       $('#category-image-background-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
    
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#category-image-icon-wrapper').html('');
           $('#category-image-background-wrapper').html('');
           document.location.reload(true);
         }
       }
     });

    

  

   });
 </script>
 <?php }

  }
 
$CT_TAX_META = new CT_TAX_META();
$CT_TAX_META -> init();
 
}

?>