<?php

/**
 * The home for our theme
 * The start template file
 *
 * 
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */

?>
<?php
$last_news=wordpress_home_main_news();
if(count($last_news)>0){
?>
<div class="mt-4" style="background-color: var(--cor-3); padding: 15px 0px 15px 0px;">
	<h2 class="risquinhoTitulos" style="text-decoration: none !important;"><a style="text-decoration: none !important; 	color:var(--cor-1); font-family: Panton-Black;" href="https://novosite.toledo.pr.gov.br/ver/noticias-e-agenda/noticias/noticias/">Notícias</a></h2>


	<div class="global-container">
		<div class="container">
			<div class="row news" style="text-align:center">

				<div class="bloco-1 ">
					<a href="<?php if (isset($last_news[1])) echo  $last_news[1]["url"]; ?>" class="text-decoration-none color-1 w-100  h-100">
						<div class=" img " style="background-image:url('<?php if (isset($last_news[1])) echo  $last_news[1]["image"]; ?>');">
							<a href="<?php if (isset($last_news[1])) echo  $last_news[1]["url"]; ?>" class="text-decoration-none color-1 w-100  h-100">
								<div class="shadow">
									<div class=" cat-1"><?php if (isset($last_news[1])) echo $last_news[1]["tags"]; ?></div>
									<div class=" date-1"><?php if (isset($last_news[1])) echo  $last_news[1]["date"] ?></div>
									<div class="title-1">
										<?php if (isset($last_news[1])) echo  $last_news[1]["title"]; ?>
									</div>
								</div>
							</a>
						</div>
					</a>
				</div>

				<div class="bloco-2-3">
					<div class="bloco-2 ">
						<div class="img " style="background-image:url('<?php if (isset($last_news[2])) echo $last_news[2]["image"]; ?>');">
							<a href="<?php if (isset($last_news[2])) echo  $last_news[2]["url"]; ?>" class="text-decoration-none color-1 w-100  h-100">
								<div class="shadow">
									<div class=" cat-1"><?php if (isset($last_news[2])) echo  $last_news[2]["tags"]; ?></div>
									<div class=" date-1"><?php if (isset($last_news[2])) echo $last_news[2]["date"]; ?></div>
									<div class="title-1">
										<?php if (isset($last_news[2])) echo $last_news[2]["title"]; ?>
									</div>
								</div>
							</a>
						</div>
					</div>

					<div class="bloco-3 ">
						<div class="img " style="background-image:url('<?php if (isset($last_news[3])) echo $last_news[3]["image"]; ?>');">
							<a href="<?php if (isset($last_news[3])) echo  $last_news[3]["url"]; ?>" class="text-decoration-none color-1 w-100  h-100">
								<div class="shadow">
									<div class=" cat-1"><?php if (isset($last_news[3])) echo  $last_news[3]["tags"]; ?></div>
									<div class=" date-1"><?php if (isset($last_news[3])) echo $last_news[3]["date"]; ?></div>
									<div class="title-1">
										<?php if (isset($last_news[3])) echo $last_news[3]["title"]; ?>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="container">
		<div class="slider-wrap">
			<div class="slider news " style="min-height:200px;!important">
				<div class="slider-inner" style="height:205px;">
					<?php for ($last_news_count = 4; $last_news_count < 13; $last_news_count++) { ?>
						<div class="item d-flex overflow-hidden" style="height:195px;">
							<a href="<?php if (isset($last_news[$last_news_count])) echo  $last_news[$last_news_count]["url"]; ?>" class="text-decoration-none color-1 w-100  h-100">
								<div class="img  " style="background-image:url('<?php if (isset($last_news[$last_news_count])) echo $last_news[$last_news_count]["image"]; ?>');">
									<div class="shadow color-0">
										<div class=" cat-1" style="font-size:10px!important;"><?php if (isset($last_news[$last_news_count])) echo  $last_news[$last_news_count]["tags"]; ?></div>
										<div class=" date-1" style="font-size:10px!important;"><?php if (isset($last_news[$last_news_count])) echo $last_news[$last_news_count]["date"]; ?></div>
										<div class="title-1" style="font-size:15px!important; text-align: center;">
											<?php if (isset($last_news[$last_news_count])) echo $last_news[$last_news_count]["title"]; ?>
										</div>
									</div>
								</div>
							</a>
						</div>
					<?php } ?>

				</div>
			</div>
			<div class="progress-bar">
				<div class="prog-bar-inner"></div>
			</div>
		</div>
	</div>
</div>
<?php } ?>