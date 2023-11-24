<?php
/**
 * The template for displaying search results pages
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */
 get_header();
 $category = get_queried_object();
 $cat_ID=$category->term_id;
 $count=0;
 $search_term="";
if(isset($_GET["s"])) $search_term=$_GET["s"];
$func = function($value) {
	return explode("#",$value)[1];
};
$tags=implode(",",array_map($func,explode(" ",$search_term)));
if ($tags[0]==",") $tags=substr($tags,1);
if ($tags[strlen($tags)-1]==",") $tags=substr($tags,0,-1);
$func = function($value) {
	return "#".$value;
};
$search_title=str_replace(array_map($func,explode(",",$tags)), "", $search_term);;
?>
 <div class="container pt-4">
	<h1 class="search text-center">RESULTADO DA BUSCA POR "<?php echo $search_term;?>"</h1>
  	<hr style="margin-bottom: 30px; margin-top: 30px;">
</div>  
<?php	
$param   = ( is_front_page() ) ? 'page' : 'paged';
$paged   = ( get_query_var( $param ) ) ? get_query_var( $param ) : 1;
/*$args    = array(
	'paged'       => $paged,
	'post_type' => 'post',
	'cat'=>'-1, 0$cat_ID',
	 //'post_title' => $search_term,
	array('relation' => 'OR',
		 
		 'post_title' => $search_term,
		 'post_title' => $search_term
	 ),
    'post_status'      => 'publish',
	'numberposts' => 9,
	'order'       => 'DESC'
);*/
$args    = array(
	'paged'       => $paged,
	'post_type' => array('post-event','post'),
	'category__not_in'=>-1,
	
	'tag' =>  $tags,
	's' => $search_title,
	'numberposts' => 9,
	'post_status'      => 'publish',
	'order'       => 'DESC'
);
if(isset($cat_ID) && !empty($cat_ID)) $args['category__in'] =  [$cat_ID];
if(isset($tags)&& !empty($tags)) $args['tag']=$tags;
require_once (get_template_directory() .  "/template-parts/content/content-list.php");
get_footer();
