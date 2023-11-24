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

function download() {
      if(isset($_GET["file"])){
            $file_url=str_replace("../", "",str_replace("../", "",$_GET["file"]));
            try{
                  $base_url=realpath(".");
                  $extenssions_exec = array("php", "ini", "htacess", "cgi","sh","bin","asp","bat","dll","so","exe","msi","jar","class","asp","sql","css","js","html"); 
                  $extension_file=strtolower(pathinfo($base_url.DIRECTORY_SEPARATOR.$file_url)['extension']);
                  $file_name_=pathinfo($base_url.DIRECTORY_SEPARATOR.$file_url)['filename'];
                  $extension_found=in_array($extension_file, $extenssions_exec);
                  $full_path=$base_url.DIRECTORY_SEPARATOR.$file_url;
                  echo $base_url.DIRECTORY_SEPARATOR.$file_url;
                  if(!$extension_found){
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="'.$file_name_.".".$extension_file.'"');
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($full_path));
                        ob_clean();
                        flush();
                        readfile($full_path);
                        exit();
                  }
            }
            catch (Exception $e) {}
      }
}
function theme_prefix_rewrite_flush() {
      flush_rewrite_rules();
  }
  add_action( 'after_switch_theme', 'theme_prefix_rewrite_flush' ); 
   
function wordpress_pagination() {
      global $wp_query;

      $big = 999999999;

      echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages
      ) );
}

function wordpress_home_main_news(){
      
      global $wpdb;

      $last_news = [];
      $last_news_count = 1;
      $sql=" select ";
      $sql.=" p.ID as post_id, ";
      $sql.=" p.post_title as title, ";
      $sql.=" (SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='_thumbnail_id')and(p.ID=pm.post_id) limit 0,1) as image, ";
      $sql.=" t.name as category, ";
      $sql.=" p.post_date, ";
      $sql.=" CONCAT( ";
      $sql.=" (select top.option_value from {$wpdb->prefix}options top where(top.option_name='siteurl') limit 0,1), ";
      $sql.=" '/',t.slug,'/', ";
      $sql.=" IF((SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='_wp_desired_post_slug')and(p.ID=pm.post_id) limit 0,1) IS NULL, ";
      $sql.="   p.ID, ";
      $sql.=" (SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='_wp_desired_post_slug')and(p.ID=pm.post_id) limit 0,1)) ";
      $sql.=" ) ";
      $sql.=" as url, ";
      $sql.=" (SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='home_show_start')and(p.ID=pm.post_id) limit 0,1) as home_show_start, ";
      $sql.=" (SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='home_show_end')and(p.ID=pm.post_id) limit 0,1) as home_show_end, ";
      $sql.=" (SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='order')and(p.ID=pm.post_id) limit 0,1) as ordernation ";
      $sql.=" from {$wpdb->prefix}posts p ";
      $sql.=" LEFT JOIN {$wpdb->prefix}term_relationships tr ON (tr.object_id = p.ID)"; 
      $sql.=" LEFT JOIN {$wpdb->prefix}terms t ON t.term_id  = tr.term_taxonomy_id ";
      $sql.=" LEFT JOIN {$wpdb->prefix}term_taxonomy tt on (tt.term_id=t.term_id) ";
      $sql.=" where ";
      $sql.=" (p.post_status = 'publish') ";
      $sql.=" and ";
      $sql.=" (p.post_type = 'post') ";
      $sql.=" and ";
      $sql.=" (tt.taxonomy='category') ";
      $sql.=" and ";
      $sql.=" ( ";
      $sql.=" CURRENT_DATE  BETWEEN ";
      $sql.=" (SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='home_show_start')and(p.ID=pm.post_id) limit 0,1) ";
      $sql.=" and ";
      $sql.=" (SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='home_show_end')and(p.ID=pm.post_id) limit 0,1) ";
      $sql.=" )";
      $sql.=" order by ";
      $sql.=" (SELECT pm.meta_value FROM {$wpdb->prefix}postmeta pm where(pm.meta_key='order')and(p.ID=pm.post_id) limit 0,1) asc,";
      $sql.=" p.post_date desc";
      $sql.=" limit 0,10 ";





      $sql2=" SELECT GROUP_CONCAT(concat('#',tag_t.name)) ";
      $sql2.=" FROM {$wpdb->prefix}terms tag_t ";
      $sql2.=" left JOIN {$wpdb->prefix}term_taxonomy  tag_tt ";
      $sql2.="         ON (tag_tt.term_id = tag_t.term_id) ";
      $sql2.=" left JOIN {$wpdb->prefix}term_relationships  tag_tr ";
      $sql2.="         ON (tag_tr.term_taxonomy_id = tag_tt.term_taxonomy_id)    ";
      $sql2.="     left JOIN {$wpdb->prefix}posts tag_p ";
      $sql2.="         ON (tag_p.ID = tag_tr.object_id)  ";
      $sql2.=" WHERE  ";
      $sql2.="      (tag_tt.taxonomy = 'post_tag') ";
      $sql2.="     AND (tag_p.post_type = 'post') ";
      $sql2.="     AND (tag_p.post_status = 'publish') ";
      $sql2.=" GROUP BY tag_p.id ";
      $sql2.=" ORDER BY tag_p.post_date DESC ";
      $sql2.=" limit 0,1; ";

      $resultado = $wpdb->get_results($wpdb->prepare($sql));
      $postsIDs=[];
      foreach ($resultado as $valor){
            $posttags = get_the_tags($valor->post_id);
            $posttagsstr = "";
            if ($posttags) {
                  foreach ($posttags as $tag) {
                        $posttagsstr = "#" . $tag->name . ' ';
                  }
            }
            array_push($postsIDs,$valor->post_id) ;
            $last_news[$last_news_count] = [
                  "title" => $valor->title,
                  "image" => wp_get_attachment_image_url ($valor->image,"Large "),
                  "category" => $valor->category,
                  "date" => $valor->date,
                  "url" => get_permalink($valor->post_id),
                  "tags" => $posttagsstr
            ];
            $last_news_count++;
      }
     
      $args    = array(
            'paged'       => 1,
            'post_type' => 'post',
            'posts_per_page' => 13-$last_news_count,
            'post__not_in'=>$postsIDs,
            'cat' => 88, //Notícias Notícias Notícias Notícias Notícias Notícias Notícias Notícias Notícias Notícias Notícias 
            'order'       => 'DESC'
      );
      $the_query = new WP_Query($args);
      while ($the_query->have_posts()) {
            $the_query->the_post();
            $posttags = get_the_tags();
            $posttags_array=[];
            $posttagsstr = "";
            if ($posttags) {
                  foreach ($posttags as $tag) {
                        array_push($posttags_array, ("#" . $tag->name . ' '));
                  }
                  natcasesort($posttags_array);
                  //$posttagsstr=implode(",", $posttags_array);
                  $posttagsstr=$posttags_array[0];
            }
            $last_news[$last_news_count] = [
                  "title" => get_the_title(),
                  "image" => get_the_post_thumbnail_url(get_the_ID(), 'Large'),
                  "category" => get_the_category()[0]->name,
                  "date" => get_the_date('d/m/Y'),
                  "url" => get_permalink(),
                  "tags" => $posttagsstr
            ];

            $last_news_count++;
      }
      return $last_news;
}

//require_once plugin_dir_path( __FILE__ ) . 'plugin.php';