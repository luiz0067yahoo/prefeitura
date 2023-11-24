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
$table_name = $wpdb->prefix . 'fotos';
$sql = "SELECT * FROM $table_name WHERE($table_name.local='BANNER ROTATIVO') ORDER BY id desc limit 0,5";
$result = $wpdb->get_results($wpdb->prepare($sql));
$total = count($result);
$countBanner = 0;
if(count($result)>0){
?>

<div class="container mt-4">
	<div class="w-100 slide-show-block ">
		<div style="width:100%;overflow-x:hidden;margin-left:auto;margin-right:auto">
			<div id="slideHomeDesktop" class="carousel slide mx-auto rounded" data-bs-ride="carousel" style="width: 100%; padding-top: 22%; min-width: 280px; margin-bottom: 10px"><?php //margin-bottom: calc(170px - 6vw); " 
																																													?>
				<div class="carousel-indicators">
					<?php
					foreach ($result as $valor) 
					if(file_exists(get_attached_file($valor->img)))
					{
					?>
						<button type="button" data-bs-target="#slideHomeDesktop" data-bs-slide-to="<?php echo $countBanner; ?>" <?php if ($countBanner == 0) { ?>class="active" aria-current="true" <?php } ?> aria-label="<?php echo $valor->legend; ?>"></button>
					<?php
						$countBanner++;
					} ?>
				</div>
				<div class="carousel-inner" style="height: 100%; width: 100%; position: absolute; top: 0px; overflow: visible;">
					<?php
					$countBanner = 0;
					foreach ($result as $valor) 
					if(file_exists(get_attached_file($valor->img)))
					{
					?>
						<a <?php if(isset($valor->link)&& !empty($valor->link)){?>href="<?php echo $valor->link;?>"<?php }?> class="carousel-item rounded <?php if ($countBanner == 0) echo "active"; ?>" style="width: 100%; height: 100%; background-image: url('<?php echo wp_get_attachment_image_url($valor->img, 'Large', false); ?>'); background-size: cover; background-position: center center;">
							<div class="carousel-caption color-1 w-100" style="top: calc(100% - 30px); right: 10px; left: auto;">
							
							</div>
						</a>
					<?php

						$countBanner++;
					}
					?>
				</div>
				<button class="carousel-control-prev" data-bs-target="#slideHomeDesktop" data-bs-slide="prev">
					<spam class="carousel-control-prev-icon" aria-hidden="true"></spam>
				</button>
				<button class="carousel-control-next" data-bs-target="#slideHomeDesktop" data-bs-slide="next">
					<spam class="carousel-control-next-icon" aria-hidden="true"></spam>
				</button>
			</div>
		</div>
	</div>
</div>
<?php } ?>