<?php

/**
 * The template for displaying archive pages
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */

get_header();
$count = 0;

$posts = get_posts();
$count_posts = count($posts);
if (is_page()) {
} else while (have_posts()) :
  the_post();

  if ($count_posts === 1)  get_template_part('template-parts/content/content', 'single');
  else {
    if ($count == 0) {
?>
      <div class="container">
        <div class="row">
        <?php   } ?>
        <div class="col-4">
          <a href="<?php echo get_permalink(); ?>" class="text-decoration-none color-1">
            <div class="search-card">
              <div class="search-cardImg">
                <?php the_post_thumbnail('medium'); ?>
              </div>
              <div class="search-cardTxt">
               
                <h6 class="color-1">
                  <?php
                  foreach ((get_the_category()) as $category) {
                    echo $category->name . "<br>";
                    break;
                  }
                  ?>
                </h6>
                <h5 class="color-1"><?php echo get_the_date('d/m/Y'); ?></h5>
                <h2 class="color-1"><?php the_title(); ?></h2>
              </div>
            </div>
          </a>
        </div>
        <?php
        if ($count % 3 == 2) {
        ?>
        </div>
      </div>
      <div class="container">
        <div class="row">
      <?php
        }
      }
      $count++;
    endwhile;
    if ($count > 0) {
      ?>
        </div>
      </div>
    <?php
    }
    $posts = null;
    $count_posts = null;

    ?>

    <hr style="margin-top:40px; margin-bottom: 20px;margin-left:auto;margin-right:auto; max-width: 50%;">

    <!-- Next page -->
    <nav>
      <div class="pagination justify-content-center pagination pagination-lg" style="margin:20px;">
        <section class="pager m-50 ">
          <div class="row">
            <div>
              <?php
              global $wp_query;
              $big = 999999999; // need an unlikely integer
              $links = paginate_links(array(
                'base'      => str_replace($big, '%#%', get_pagenum_link($big)),
                'format'    => '?paged=%#%',
                'current'   => max(1, get_query_var('paged')),
                'total'     => $wp_query->max_num_pages,
                'prev_text' => __('<div class="page-link pull-left"><<</div>', 'multi'),
                'next_text' => __('<div class="page-link pull-right ">>></div>', 'multi'),
                'type'      => 'array'
              ));
              ?>
              <?php

              if (isset($links) && (count($links) > 0)) { ?>
                <div class=" archive-navigation">
                  <?php foreach ($links as $link) { ?>
                    <?php echo $link; ?>
                  <?php }; ?>
                </div>
              <?php }

              ?>
              <!-- End of blog-pagination -->
            </div>
          </div>
      </div>
    </nav>
    <?php

    get_footer();
