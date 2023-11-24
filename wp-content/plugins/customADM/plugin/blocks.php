<?php


add_filter('allowed_block_types', function($block_types, $post) {
	$allowed = [
		'core/post-featured-image',
		//'core/button',
		'core/classic',
		//'core/gallery',
		//'core/image',
		'cms-adm/build-grafics',
		'cms-adm/multi-pdf',
		'cms-adm/mini-pdf',
		'cms-adm/image-only',
		'cms-adm/cols-image',
		'cms-adm/title-text',
		'cms-adm/panel-title-text',
		'cms-adm/topic-title-text',
		'cms-adm/topic-text-data',
		'cms-adm/date-title-link-file-upload',
		'cms-adm/date-title-link-external',
		'cms-adm/slide-show',
		'cms-adm/menu-accordion',
		'cms-adm/menu-accordion-double',
		'cms-adm/separator',
		'cms-adm/buttons-banner',
		'cms-adm/big-button',
		'cms-adm/destack-buttons'
		
	];
	
	
	if($post->post_type == 'post'){
		return $allowed;
	}
	return $allowed;
	return $block_types;
}, 10, 2);


function adm__block_admin() {
	
	
	 
	 wp_enqueue_script(
		'html-react-parser',
		plugins_url( '/../js/html-react-parser.min.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	 
 
	 wp_enqueue_script(
		'pdf-worker',
		plugins_url( '/../js/pdf.worker.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	


	wp_enqueue_script(
		'pdf',
		plugins_url( '/../js/pdf.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	

	 wp_enqueue_script(
		'mini-pdf',
		plugins_url( '/../js/blocks/mini-pdf-image.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	 
	 wp_enqueue_script(
		'multi-pdf',
		plugins_url( '/../js/blocks/multi-pdf-image.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	
	 wp_enqueue_script(
		'chart',
		plugins_url( '/../js/chart.min.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	 
	wp_enqueue_script(
		'grafics',
		plugins_url( '/../js/blocks/grafics.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );
	 
	 
	
	 wp_enqueue_script(
		'image-only',
		plugins_url( '/../js/blocks/image-only.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	 


	 wp_enqueue_script(
		'block-panel-title-text',
		plugins_url( '/../js/blocks/panel-title-text.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	 
	  wp_enqueue_script(
		'block-destack-buttons',
		plugins_url( '/../js/blocks/destack-buttons.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	 
	 wp_enqueue_script(
		'block-big-button',
		plugins_url( '/../js/blocks/big-button.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	 
	 wp_enqueue_script(
		'block-menu-accordion',
		plugins_url( '/../js/blocks/menu-accordion.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	   
	
	 wp_enqueue_script(
		'block-menu-accordion-double',
		plugins_url( '/../js/blocks/menu-accordion-double.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	   
		
	 wp_enqueue_script(
		'block-buttons-banner',
		plugins_url( '/../js/blocks/buttons-banner.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	   
		
	 wp_enqueue_script(
		'block-editor-separator',
		plugins_url( '/../js/blocks/separator.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	   
		 
	 wp_enqueue_script(
		'block-editor-slide-show',
		plugins_url( '/../js/blocks/slide-show.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );

	wp_enqueue_script(
		'cols-image',
		plugins_url( '/../js/blocks/cols-image.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
	
	wp_enqueue_script(
	   'block-title-text',
	   plugins_url( '/../js/blocks/title-text-block.js', __FILE__ ),
	   array( 'wp-blocks', 'wp-element' )
	);
	
	wp_enqueue_script(
	   'block-editor-topic-title-text',
	   plugins_url( '/../js/blocks/topic-title-text.js', __FILE__ ),
	   array( 'wp-blocks', 'wp-element' )
	);
	
	wp_enqueue_script(
	   'block-topic-text-data',
	   plugins_url( '/../js/blocks/topic-text-data.js', __FILE__ ),
	   array( 'wp-blocks', 'wp-element' )
	);
	
	wp_enqueue_script(
		'block-editor-date-title-link-file-upload',
		plugins_url( '/../js/blocks/date-title-link-file-upload.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );
	 
	 wp_enqueue_script(
		'block-editor-date-title-link',
		plugins_url( '/../js/blocks/date-title-link.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	   
	 
	wp_enqueue_script(
		'bootstrap.bundle.min',
		plugins_url( '/../js/bootstrap5.1.1/bootstrap.bundle.min.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );
	
	
	
	wp_enqueue_script(
		'popper.min',
		plugins_url( '/../js/bootstrap5.1.1/popper.min.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );
  
	
	wp_enqueue_script(
		'colorpicker___',
		plugins_url( '/../js/colorpicker.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	 );	
  
 }
 add_action( 'enqueue_block_editor_assets', 'adm__block_admin' );
 
?>