<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */
 ?>

<div class="col block-by-3  d-flex justify-content-center p-2" style="min-width:280px;max-width:500px">
	<a href="<?php echo get_permalink(get_the_ID()); ?>" class="text-decoration-none newsCard pt-0 w-100">
		<div class="newsCardImg w-100 rounded" style="background-image:url('<?php  the_post_thumbnail_url('large'); ?>');background-size: cover;background-repeat: no-repeat;background-position: center center;">
			<div style="padding-top:55%"></div>
		</div>
		<div class="newsCardTxt">
			<h6>  
			<?php  
				$tags="#".strtoupper(get_the_tags(get_the_ID())[0]->name); 
				if(strlen($tags)>1) echo $tags;
			?>
			</h6>
			<h5><?php echo get_the_date('d/m/Y'); ?></h5>
			<h3><?php the_title(); ?></h3>
		</div>
	</a>
</div>



