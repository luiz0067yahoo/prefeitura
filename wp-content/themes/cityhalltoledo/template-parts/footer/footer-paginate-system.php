
<hr style="margin-top:40px; margin-bottom: 20px;margin-left:auto;margin-right:auto; max-width: 50%;">
<nav>
  <div class="pagination justify-content-center pagination pagination-lg" style="margin:20px;">
	<section class="pager m-50 ">
	  <div class="row">
		<div>
		  <?php
		  $big = 999999999; // need an unlikely integer
		  $links = paginate_links(array(
			'base'      => str_replace($big, '%#%', get_pagenum_link($big)),
			'format'    => '?paged=%#%',
			'current'   => $page,
			'total'     => ceil($total/$rows_per_page),
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