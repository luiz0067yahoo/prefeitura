<?php 
add_action('admin_menu', 'my_menu_pages');
function my_menu_pages()
{
    add_menu_page('Cadastro Agenda', 'Cadastro Agenda', 'manage_options', 'manage_agenda', 'wp_load_cadastro_agenda');
    add_submenu_page('manage_agenda', 'Ver Agenda', 'Ver Agenda', 'manage_options', get_home_url() . '/ver/noticias-e-agenda/agenda/');
    add_menu_page('Cadastro Fotos', 'Cadastro Fotos', 'manage_options', 'manage_fotos', 'wp_load_cadastro_fotos');
    add_submenu_page('manage_fotos', 'Ver Fotos', 'Ver Fotos', 'manage_options', get_home_url() . '/fotos');
    
	
	add_menu_page('Cadastro Empresas', 'Cadastro Empresas', 'manage_options', 'manage_empresas', 'wp_load_cadastro_empresas');
    add_submenu_page('manage_empresas', 'Ver Empresas', 'Ver Empresas', 'manage_options', get_home_url() . '?systempage=empresas');
	
	add_menu_page('Cadastro Diário Oficial', 'Cadastro Diário Oficial', 'manage_options', 'manage_diario_oficial', 'wp_load_cadastro_pdf');
    add_submenu_page('manage_diario_oficial', 'Ver Diário Oficial', 'Ver Diário Oficial', 'manage_options', get_home_url() . '/diario_oficial');

}

function wp_load_cadastro_agenda()
{
    require_once plugin_dir_path(__FILE__) . 'cadastro_agenda.php';
}
function wp_load_cadastro_fotos()
{
    require_once plugin_dir_path(__FILE__) . 'cadastro_fotos.php';
}

function wp_load_cadastro_empresas()
{
    require_once plugin_dir_path(__FILE__) . 'cadastro_empresas.php';
}

function wp_load_cadastro_pdf()
{
    require_once plugin_dir_path(__FILE__) . 'cadastro_diario_official.php';
}
?>