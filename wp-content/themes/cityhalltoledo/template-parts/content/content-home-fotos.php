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
$table_name = $wpdb->prefix . 'fotos';
$sql = "SELECT * FROM $table_name WHERE($table_name.local='TOLEDO EM FOTOS') ORDER BY id desc limit 0,6";
$result = $wpdb->get_results($wpdb->prepare($sql));
$countBanner = 0;
if(count($result)>0){
?>
<div class="mt-4 mb-4">
	<div class="risquinhoTitulos">
		<h2>Toledo em Fotos</h2>
	</div>
	<div class="container" style="">
	<div class="container-block-by" style="">
		
		<?php
		foreach ($result as $valor) 
		if(file_exists(get_attached_file($valor->img)))
		{
		?>
				
			<div class="block-by-3 p-2" >
			<a class="d-flex mt-3 galleryItem w-100" href="<?php echo wp_get_attachment_image_url($valor->img, 'Large', false); ?>" title="<?php echo $valor->legend; ?>" style="padding-top:100%;background-position:center center;background-size:cover;background-repeat: no-repeat;cursor: pointer;border-radius: 8px;background-image:url('<?php echo wp_get_attachment_image_url($valor->img, 'Large', false); ?>')"  alt="..."></a>
			</div>

		<?php
		}
		?>

		</div>
	</div>
</div>
<?php } ?>