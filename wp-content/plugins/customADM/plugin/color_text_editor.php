<?php 

function mychild_setup_theme_supported_features() {
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => esc_attr__( 'Verde', 'mychild' ),
			'slug' => 'green',
			'color' => '#01913a',
		),
		array(
			'name' => esc_attr__( 'Cinza escuro', 'mychild' ),
			'slug' => 'dark-gray',
			'color' => '#333333',
		),
		array(
			'name' => esc_attr__( 'Cinza', 'mychild' ),
			'slug' => 'gray',
			'color' => '#d0d0D0',
		),
		array(
			'name' => esc_attr__( 'Cinza claro', 'ea-starter' ),
			'slug' => 'light-gray',
			'color' => '#eeeeee',
		),		
		array(
			'name' => esc_attr__( 'Vermelho', 'ea-starter' ),
			'slug' => 'red',
			'color' => '#e00b1c',
		),		
		array(
			'name' => esc_attr__( 'Amarelo', 'ea-starter' ),
			'slug' => 'yellow',
			'color' => '#fdea14',
		),		
		array(
			'name' => esc_attr__( 'Azul 1', 'ea-starter' ),
			'slug' => 'blue',
			'color' => '#3399cc',
		),		
		array(
			'name' => esc_attr__( 'Azul 2', 'ea-starter' ),
			'slug' => 'dark-blue',
			'color' => '#005C90',
		),		
		array(
			'name' => esc_attr__( 'Preto', 'ea-starter' ),
			'slug' => 'black',
			'color' => '#000000',
		)
		
	) );
}
add_action( 'after_setup_theme', 'mychild_setup_theme_supported_features' );
?>