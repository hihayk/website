<?php
/************************************************************************
* Category Template
*************************************************************************/

get_header(); ?>

<section class="blog alternate-bg2 page-padding" id="blog">
	<div class="container">
		<div class="titleBar">
			<span><?php _e('You Are Viewing','framework');?></span>
			<h2><?php printf( __( 'Category Archives: %s', 'framework' ), single_cat_title( '', false )); ?></h2>
		</div>

		<div class="two-thirds column posts">
			<div class="leftpadding ajaxed">

				<?php
				if(have_posts()): while(have_posts()) : the_post(); 
				
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
			if(get_next_posts_link( $label = null, $wp_query->max_num_pages)){

						next_posts_link( __("&laquo; Older Posts ","framework"), $wp_query->max_num_pages);

					}

					if(get_previous_posts_link( $label = null, $wp_query->max_num_pages )){
						
						previous_posts_link( __("Newer Posts &raquo;","framework"), $wp_query->max_num_pages);
					
					}
				?>

			</div>
			<div id="contentinner"></div>
		</div>

		<?php
		get_sidebar(); 
		?>
	</div></section>
<?php get_footer(); ?>