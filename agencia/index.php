<?php 
$base_server_path_files=$_SERVER['DOCUMENT_ROOT'].'/agencia';
require($GLOBALS["base_server_path_files"].'/route.php');
require($GLOBALS["base_server_path_files"].'/library/functions.php');
Route::add('/agencia/',function(){
    include($GLOBALS["base_server_path_files"].'/index.html');
},'get');

require_once($GLOBALS["base_server_path_files"].'/mvc/controller/estadosController.php');

Route::add('/agencia/server/estados',function(){
  // if(controlAcess())
   ((new estadosController())->find());
},'get');

Route::add('/agencia/server/estados/([0-9]*)',function($id){
   //if(controlAcess())
   ((new estadosController())->findById($id));
},'get');

Route::add('/agencia/server/estados',function(){
    //if(controlAcess())
    ((new estadosController())->save());
},'put');

Route::add('/agencia/server/estados',function(){
    //if(controlAcess())
    ((new estadosController())->del());
},'delete');
/*
Route::add('/admin',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/index.php');
});

Route::add('/admin/',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/index.php');
});

Route::add('/admin/panel',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/panel.php');
});

Route::add('/admin/login',function(){
	include($GLOBALS["base_server_path_files"].'/mvc/view/admin/login.php');
},'get');

Route::add('/admin/login',function(){
	include($GLOBALS["base_server_path_files"].'/mvc/view/admin/login.php');
},'post');

Route::add('/admin/logout',function(){
	logout();
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/login.php');
},"post");

Route::add('/admin/logout',function(){
	logout();
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/login.php');
},"get");

Route::add('/admin/esqueceu_a_senha',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/esqueceu_a_senha.php');
},"get");

Route::add('/admin/esqueceu_a_senha',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/esqueceu_a_senha.php');
},"post");

Route::add('/admin/recuperar_senha',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/recuperar_senha.php');
},"get");

Route::add('/admin/recuperar_senha',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/recuperar_senha.php');
},"post");

Route::add('/admin/email_recuperar_senha',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/email_recuperar_senha.php');
});


Route::add('/admin/time_session',function(){
    echo sessionCount();
},'get');

Route::add('/admin/apps/explorer',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/apps/explorer.html');
},'get');

Route::add('/admin/explorer',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/controller/explorer.php');
},'get');

Route::add('/admin/explorer',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/controller/explorer.php');
},'post');
//###############################################################################




//###############################################################################
Route::add('/admin/usuarios',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_usuarios.php');
},'get');

Route::add('/admin/menus',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_menus.php');
},'get');

Route::add('/admin/noticias',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_noticias.php');
},'get');

Route::add('/admin/noticiasAnexo',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_noticiasAnexo.php');
},'get');

Route::add('/admin/tiposAnuncios',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_tiposAnuncios.php');
},'get');

Route::add('/admin/anuncios',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_anuncios.php');
},'get');

Route::add('/admin/albumFotos',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_albumFotos.php');
},'get');

Route::add('/admin/fotos',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_fotos.php');
},'get');

Route::add('/admin/albumVideos',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_albumVideos.php');
},'get');

Route::add('/admin/videos',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/system/cadastro_videos.php');
},'get');
//###############################################################################



//###############################################################################
require_once($GLOBALS["base_server_path_files"].'/mvc/controller/controllerMenus.php');
Route::add('/server/site/mainMenus',function(){
   ((new controllerMenus())->findMainMenus());
},'get');

Route::add('/server/site/subMenus/([0-9]*)',function($idMenu){
   ((new controllerMenus())->findSubMenus($idMenu));
},'get');

Route::add('/server/menus',function(){
   if(controlAcess())((new controllerMenus())->find());
},'get');

Route::add('/server/menus/([0-9]*)',function($id){
   if(controlAcess())((new controllerMenus())->findById($id));
},'get');

Route::add('/server/menus',function(){
    if(controlAcess())((new controllerMenus())->save());
},'put');

Route::add('/server/menus',function(){
    if(controlAcess())((new controllerMenus())->del());
},'delete');
//###############################################################################


//###############################################################################
require_once($GLOBALS["base_server_path_files"].'/mvc/controller/controllerAlbumFotos.php');
Route::add('/server/site/slideShowPhotos/',function(){
   ((new controllerAlbumFotos())->findSlideShow($menuSubMenu=''));
},'get');

Route::add('/server/site/slideShowPhotos/(.*)/',function($menuSubMenu){
   ((new controllerAlbumFotos())->findSlideShow($menuSubMenu));
},'get');

Route::add('/server/site/slideShowPhotos/(.*)/(.*)/',function($menuSubMenu){
   ((new controllerAlbumFotos())->findSlideShow($menuSubMenu));
},'get');

Route::add('/server/site/slideShowPhotos/(.*)/(.*)/(.*)/',function($menuSubMenu){
   ((new controllerAlbumFotos())->findSlideShow($menuSubMenu));
},'get');

Route::add('/server/site/photos/(.*)/',function($menuSubMenu){
   ((new controllerAlbumFotos())->findMenuAlbum($menuSubMenu));
},'get');

Route::add('/server/albumFotos',function(){
   if(controlAcess())((new controllerAlbumFotos())->find());
},'get');

Route::add('/server/albumFotos/([0-9]*)',function($id){
   if(controlAcess())((new controllerAlbumFotos())->findById($id));
},'get');


Route::add('/server/albumFotos',function(){
    if(controlAcess())((new controllerAlbumFotos())->save());
},'put');

Route::add('/server/albumFotos',function(){
    if(controlAcess())((new controllerAlbumFotos())->del());
},'delete');
//###############################################################################


//###############################################################################
require_once($GLOBALS["base_server_path_files"].'/mvc/controller/controllerFotos.php');

Route::add('/server/fotos',function(){
    if(controlAcess())((new controllerFotos())->find());
},'get');

Route::add('/server/fotos/([0-9]*)',function($id){
   if(controlAcess())((new controllerFotos())->findById($id));
},'get');

Route::add('/server/fotos',function(){
    if(controlAcess())((new controllerFotos())->save());
},'post');

Route::add('/server/fotos',function(){
    if(controlAcess())((new controllerFotos())->del());
},'delete');
//###############################################################################


//###############################################################################
require($GLOBALS["base_server_path_files"].'/mvc/controller/controllerAlbumVideos.php');
Route::add('/server/site/slideShowVideos/',function(){
   ((new controllerAlbumVideos())->findSlideShow($menuSubMenu=''));
},'get');

Route::add('/server/site/slideShowVideos/(.*)/',function($menuSubMenu){
   ((new controllerAlbumVideos())->findSlideShow($menuSubMenu));
},'get');

Route::add('/server/site/slideShowVideos/(.*)/(.*)/',function($menuSubMenu){
   ((new controllerAlbumVideos())->findSlideShow($menuSubMenu));
},'get');

Route::add('/server/site/slideShowVideos/(.*)/(.*)/(.*)/',function($menuSubMenu){
   ((new controllerAlbumVideos())->findSlideShow($menuSubMenu));
},'get');

Route::add('/server/site/videos/(.*)/',function($menuSubMenu){
   ((new controllerAlbumVideos())->findMenuAlbum($menuSubMenu));
},'get');

Route::add('/server/albumVideos',function(){
   if(controlAcess())((new controllerAlbumVideos())->find());
},'get');

Route::add('/server/albumVideos/([0-9]*)',function($id){
   if(controlAcess())((new controllerAlbumVideos())->findById($id));
},'get');

Route::add('/server/albumVideos',function(){
    if(controlAcess())((new controllerAlbumVideos())->save());
},'put');

Route::add('/server/albumVideos',function(){
    if(controlAcess())((new controllerAlbumVideos())->del());
},'delete');
//###############################################################################

//###############################################################################
require($GLOBALS["base_server_path_files"].'/mvc/controller/controllerVideos.php');
Route::add('/server/videos',function(){
    if(controlAcess())((new controllerVideos())->find());
},'get');

Route::add('/server/videos/([0-9]*)',function($id){
   if(controlAcess())((new controllerVideos())->findById($id));
},'get');

Route::add('/server/videos',function(){
    if(controlAcess())((new controllerVideos())->save());
},'post');

Route::add('/server/videos',function(){
    if(controlAcess())((new controllerVideos())->del());
},'delete');
//###############################################################################


//###############################################################################
require_once($GLOBALS["base_server_path_files"].'/mvc/controller/controllerNoticias.php');
Route::add('/server/site/slideShowNews/',function(){
   ((new controllerNoticias())->findSlideShow($menuSubMenu=""));
},'get');

Route::add('/server/site/slideShowNews/(.*)/',function($menuSubMenu){
   ((new controllerNoticias())->findSlideShow($menuSubMenu));
},'get');

Route::add('/server/site/slideShowNews/(.*)/(.*)/',function($menuSubMenu){
   ((new controllerNoticias())->findSlideShow($menuSubMenu));
},'get');


Route::add('/server/site/homeNews/',function(){
   ((new controllerNoticias())->findHome());
},'get');


Route::add('/server/site/News/(.*)/',function($menuSubMenu){
   ((new controllerNoticias())->findMenu($menuSubMenu));
},'get');

Route::add('/server/site/News/(.*)/(.*)/',function($menuSubMenu){
   ((new controllerNoticias())->findMenu($menuSubMenu));
},'get');



Route::add('/server/noticias',function(){
   if(controlAcess())((new controllerNoticias())->find());
},'get');

Route::add('/server/noticias/([0-9]*)',function($id){
   if(controlAcess())((new controllerNoticias())->findById($id));
},'get');

Route::add('/server/noticias',function(){
    if(controlAcess())((new controllerNoticias())->save());
},'put');

Route::add('/server/noticias',function(){
    if(controlAcess())((new controllerNoticias())->del());
},'delete');
//###############################################################################


//###############################################################################
Route::add('/server/noticiasAnexo',function(){
   if(controlAcess())((new controllerNoticiasAnexo())->find());
},'get');

Route::add('/server/noticiasAnexo/([0-9]*)',function($id){
   if(controlAcess())((new controllerNoticiasAnexo())->findById($id));
},'get');

Route::add('/server/noticiasAnexo',function(){
    if(controlAcess())((new controllerNoticiasAnexo())->save());
},'put');

Route::add('/server/noticiasAnexo',function(){
    if(controlAcess())((new controllerNoticiasAnexo())->del());
},'delete');
//###############################################################################


//###############################################################################
Route::add('/server/noticiasFotos',function(){
   if(controlAcess())((new controllerNoticiasFotos())->find());
},'get');

Route::add('/server/noticiasFotos/([0-9]*)',function($id){
   if(controlAcess())((new controllerNoticiasFotos())->findById($id));
},'get');

Route::add('/server/noticiasFotos',function(){
    if(controlAcess())((new controllerNoticiasFotos())->save());
},'put');

Route::add('/server/noticiasFotos',function(){
    if(controlAcess())((new controllerNoticiasFotos())->del());
},'delete');
//###############################################################################


//###############################################################################
Route::add('/server/tiposAnuncios',function(){
   if(controlAcess())((new controllerTiposAnuncios())->find());
},'get');

Route::add('/server/tiposAnuncios/([0-9]*)',function($id){
   if(controlAcess())((new controllerTiposAnuncios())->findById($id));
},'get');

Route::add('/server/tiposAnuncios',function(){
    if(controlAcess())((new controllerTiposAnuncios())->save());
},'put');

Route::add('/server/tiposAnuncios',function(){
    if(controlAcess())((new controllerTiposAnuncios())->del());
},'delete');
//###############################################################################


//###############################################################################
require_once($GLOBALS["base_server_path_files"].'/mvc/controller/controllerAnuncios.php');
Route::add('/server/site/banners/(.*)',function($nameType){
   ((new controllerAnuncios())->findbyType(urldecode($nameType)));
},'get');

Route::add('/server/anuncios',function(){
   if(controlAcess())((new controllerAnuncios())->find());
},'get');

Route::add('/server/anuncios/([0-9]*)',function($id){
   if(controlAcess())((new controllerAnuncios())->findById($id));
},'get');

Route::add('/server/anuncios',function(){
    if(controlAcess())((new controllerAnuncios())->save());
},'put');

Route::add('/server/anuncios',function(){
    if(controlAcess())((new controllerAnuncios())->del());
},'delete');
//###############################################################################


//###############################################################################
Route::add('/server/usuarios',function(){
   if(controlAcess())((new controllerUsuarios())->find());
},'get');

Route::add('/server/usuarios/([0-9]*)',function($id){
   if(controlAcess())((new controllerUsuarios())->findById($id));
},'get');

Route::add('/server/usuarios',function(){
    if(controlAcess())((new controllerUsuarios())->save());
},'put');

Route::add('/server/usuarios',function(){
    if(controlAcess())((new controllerUsuarios())->del());
},'delete');
//###############################################################################

Route::add('/admin/(.*)',function(){
    include($GLOBALS["base_server_path_files"].'/mvc/view/admin/404.php');
},'get');


*/

Route::run('/');


?>