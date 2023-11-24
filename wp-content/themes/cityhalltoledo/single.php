<?php

/**
 * The sigle for our theme
 * The sigle or multiple post(s) template file
 *
 * 
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */
get_header();
while ( have_posts() ) {
    the_post();
	

    $category=get_the_category()[0];
    $all_categorys=array($category->name);
    while($category->category_parent!=0){
        
        $category=get_category($category->category_parent);
        array_push($all_categorys,$category->name);
    }
   
    $level_count= count($all_categorys);

   
   
    get_template_part( 'template-parts/content/content', 'single' );
    
}
get_footer();
