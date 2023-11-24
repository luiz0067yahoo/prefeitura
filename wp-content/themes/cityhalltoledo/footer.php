<?php

/**
 * The template for displaying the footer
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */
?>


<?php wp_footer(); ?>

<div class="risquinhoFooter" style="background-color: var(--cor-4); padding: 6px;"></div>
<footer class="cityhall bg-11 color-0 pt-5 pb-2">

	<div class="row text-center text-md-left">
		<div class="col-md-2 col-lg-2 col-xl-2 mx-auto">

		</div>

	</div>
	<div class="container">
		<div class="row text-center text-md-left">
			<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3" href="#" style="min-width: 171px;">
				<div class="social-links">
					<a style="margin: 2px;" id="fcb" target="_blank" href="https://pt-br.facebook.com/PrefeituraMunicipalToledo/"><i class="fab fa-facebook-f"></i></a>
					<a style="margin: 2px;" id="twi" target="_blank" href="https://twitter.com/PrefsdeToledo"><i class="fab fa-twitter"></i></a>
					<a style="margin: 2px;" id="ins" target="_blank" href="https://www.instagram.com/prefeituradetoledo/"><i class="fab fa-instagram"></i></a>
					<a style="margin: 2px;" id="you" target="_blank" href="https://www.youtube.com/c/PrefeituradeToledoPR/"><i class="fab fa-youtube"></i></a>
				</div>
				<div id="logo-footer"></div>
			</div>

			<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3" style="min-width:210px;"> 
				<div class="menu" style="height:50px"> 
					<h5 class="text-uppercase mb-2 w-100" style="font-family: Panton-ExtraBold;">Atendimento ao Público</h5>
					<hr style="width: 270px;; margin: auto; height:2px">
				</div>
				<div class="menu"> 
					<p class="w-100"><a href="#" class="btn-floating btn-sm">Segunda a Sexta-Feira</a></p>
					<p class="w-100"><a href="#">8h15 - 11h45 | 13h30 - 17h00</a></p>
					<hr style="width: 150px; margin: 6px;">
					<p class="w-100"><a href="#">Fone: (45) 3055 8800</a></p>
					<p class="w-100"><a href="#">Ouvidoria: 156 | (45) 3055 8929</a></p>
					<p class="w-100"><a href="mailto:toledo@toledo.pr.gov.br">toledo@toledo.pr.gov.br</a></p>
					<hr style="width: 150px; margin: 6px;">
					<p class="w-100"><a  target="_blank" href="https://goo.gl/maps/1X6hpG7WMYfWbhqp6">Rua: Raimundo Leonardi, 1586 <br> Centro - CEP: 85900-110</a></p>
				</div>
			</div>

			<?php require_once('template-parts/footer/footer-menu.php');?>
		
		</div>
		<hr class="mt-2" style="max-width:30%; margin: auto;">
		<div class="row text-center text-md-left">
			<div class="col mb-2">
				<a href="#" style="font-size: 15px;">© 2021 - Departamento de Tecnologia da Informação - Prefeitura de Toledo.</a>
			</div>
		</div>

	</div>
</footer>

<script src="<?php bloginfo('template_url'); ?>/js/jquery-3.4.1.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/bootstrap5.1.1/popper.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/bootstrap5.1.1/bootstrap.bundle.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/sweetalert2@9.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/simpleLightbox.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/pdf.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/pdf.worker.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/chart.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/home.js"></script>
</body>

</html>