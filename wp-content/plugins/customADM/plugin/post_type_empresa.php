<?php 
add_action( 'init', 'post_type_empresa' );
function post_type_empresa() {
  register_post_type( 'empresa',
    array(
      'labels' => array(
        'name' => 'empresas',
        'singular_name' => 'empresa'
      ),
		'show_in_menu'=>false,
		'show_in_nav_menus'=>false,
		'show_in_admin_bar'=>false,
		'show_in_menu' => true,
		//'show_in_menu' => false,
		
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
			'slug'                => 'empresas',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		),
		//'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
		'taxonomies' => array( 'category','post_tag' ),
		'capability_type' => 'post',
    )
  );
}

?>