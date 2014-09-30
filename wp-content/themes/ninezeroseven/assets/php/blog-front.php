<?php

/************************************************************************
* Front Blog Page
*************************************************************************/

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'blog-front.php' == basename($_SERVER['SCRIPT_FILENAME'])){
	die ('This file can not be accessed directly!');
}

global $post;
$old = $post;

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;



	$portfolio_query = new WP_Query( array( 'post_type' => 'post', 'order' => 'DESC','paged' => $paged) ); 
		
?>



		<div class="two-thirds column posts">
			<div class="leftpadding ajaxed">

				<?php
				if($portfolio_query->have_posts()): while($portfolio_query->have_posts()) : $portfolio_query->the_post(); 
				
				?>
				
				<!-- POST -->
				<article class="post">
					<h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
					<div class="meta">
						<ul>
							<li class="date"><?php echo get_the_date(get_option('date_format'))?></li>
							<li class="user"><?php _e('By','framework'); ?> <?php the_author_posts_link(); ?></li>
							<li class="postin"><?php _e('In','framework'); ?> <?php the_category(', ') ?></li>
							<li class="comments"><?php comments_number(__('No Comments','framework'), __('1 Comment','framework'), __('% Comments','framework') );?></li>
						</ul>
					</div>

					<?php

					get_template_part('assets/php/featured-image');
					
					?>

					<div class="content">
						
					<?php the_excerpt(); ?>

					</div>
					<div class="readmore">
						<?php

						printf('<a href="%1s" class="color-btn main-btn">%2s</a>',
							get_permalink(),
							__('Read More &raquo;','framework')
							);
						 
						?>
					</div>
				</article>	
				<!-- ./END POST -->

			<?php
			endwhile;
			endif; 
			?>
			<div id="page-links" class="page-nav clearfix" style="margin-bottom:30px;">

				<?php
					if(get_next_posts_link( $label = null, $portfolio_query->max_num_pages )){


						next_posts_link( __("&laquo; Older Posts","framework"), $portfolio_query->max_num_pages);
					}

					if(get_previous_posts_link( $label = null, $portfolio_query->max_num_pages )){
						
						previous_posts_link( __("Newer Posts &raquo;","framework"), $portfolio_query->max_num_pages);
					
					}
				?>
			</div>

			</div>
		</div>

		<?php
		
		$post = $old; 
		get_sidebar(); 
		?>

