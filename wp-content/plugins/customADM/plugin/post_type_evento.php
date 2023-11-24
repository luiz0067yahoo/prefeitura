<?php 


add_action( 'init', 'post_type_evento' );
function post_type_evento() {
  register_post_type( 'evento',
    array(
      'labels' => array(
        'name' => 'Eventos',
        'singular_name' => 'Evento'
      ),
		'show_in_menu'=>false,
		'show_in_nav_menus'=>false,
		'show_in_nav_menus' => false,
		'show_in_admin_bar'=>false,
		'show_in_menu' => false,
		
		'public' => true,
		'show_ui' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'has_archive' => false,
		

		'show_in_rest' => true,
		'supports' => array('title','editor','thumbnail'),
		'rewrite' => array(
			'slug'                => 'eventos',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		),
		//'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
		'taxonomies' => array( 'post_tag' ),
		'capability_type' => 'post',
    )
  );
}

?>