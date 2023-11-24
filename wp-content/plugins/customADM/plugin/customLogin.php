<?php 

$login_title = 'Administrativo | Login' ;
function custom_login_title( $login_title ) {
return str_replace(array( ' &lsaquo;', ' &#8212; WordPress'), array( ' &lsaquo;', ''),$login_title );
}
add_filter( 'login_title', 'custom_login_title' );

function custom_login_header() {?>
<DIV class="principal">ADMINISTRATIVO</DIV>

<center><div class="menssagerestrict" style="margin-top: 50px; margin-bottom: 25px;padding:10px;">Área de Edição do Site da Prefeitura de Toledo.<br>Apenas equipe autorizada </div></center>

<?php }
add_action( 'login_header', 'custom_login_header' );
function custom_login_footer() {
	?>
	  

	<div class="loginbluebar"></div>
    <footer style="text-align: center;">
        <img src="<?php echo plugins_url('/../images/footerLogoPref.png', __FILE__);?>" style="width: 180px;">
        <img src="<?php echo plugins_url('/../images/footerLogoTI.png', __FILE__);?>" style="width: 180px;">
        <div class="">
			<div class="helpme">
				<div class="form-row ">
					<p>Abrir um chamado de Suporte:</p> 
					<button type="submit" class="btn btn-primary btn-block"><a class="" style="color:white!important;text-decoration:none;" href="http://suporte.toledo.pr.gov.br/" target="_blank">CHAMADO</a></button>
				</div>
			</div>
        </div>
        <hr style="width: 40%; margin: auto; margin-top: 50px; padding: 1px; background-color: #3399CC !important;">
        <p style="text-align: center; ">©2021 - Departamento de Tecnologia da Informação - Prefeitura de Toledo.</p>
        &nbsp;
    </footer>
  <script src="<?php echo plugins_url('/../js/bootstrap.bundle.js', __FILE__);?>" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<?php 
}
add_action( 'login_footer', 'custom_login_footer' );
?>