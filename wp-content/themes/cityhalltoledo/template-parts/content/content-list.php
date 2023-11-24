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


global $post;
$count = 0;
$param   = ( is_front_page() ) ? 'page' : 'paged';
$paged   = ( get_query_var( $param ) ) ? get_query_var( $param ) : 1;

$the_query = new WP_Query( $args );
$count_posts=$the_query->found_posts;
?>
<div class=" container  container-block-by ">
<?php    
while (  $the_query->have_posts()  ) 
{

	$the_query->the_post();
	if ($count_posts === 1)  get_template_part('template-parts/content/content', 'single');
	else {
				
	
			get_template_part('template-parts/content/content', 'mini');
	
	}
	$count++;
}
if($count%3>0)
for($i=0;$i<3-($count%3);$i++){
	get_template_part('template-parts/content/content', 'none');	
}
?>
</div>
<?php

$posts = null;
$count_posts = null;
get_template_part('template-parts/footer/footer', 'paginate');

?>
