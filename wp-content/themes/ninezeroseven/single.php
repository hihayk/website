<?php
/************************************************************************
* Single Post Page
*************************************************************************/

get_header(); ?>

<section class="blog alternate-bg2 page-padding" id="blog">
	<div class="container">

		<?php while(have_posts()) : the_post(); ?>
			
		<div class="titleBar">
			<span><?php _e('You Are Viewing','framework');?></span>
			<h2><?php _e('A Blog Post','framework');?></h2>
		</div>

		<div class="two-thirds column posts">
			<div class="leftpadding ajaxed">
			

				<!-- POST -->
				<article class="post">
					<h4><?php the_title();?></h4>
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

					<div class="content single clearfix">

						<?php
						the_content();
						?>

					</div>

				</article>	
				<!-- ./END POST -->

				<?php if(has_tag()): ?>

					<div class="tags">
						<?php the_tags(); ?>
					</div>

				<?php endif; ?>

				<!-- COMMENTS -->

				<div class="comment-section">
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ){
						comments_template( '', true );
					}
				?>
					
				</div>

				<!-- END COMMENTS -->


			<?php endwhile;?>


		</div> <!-- END PADDING -->
	</div><!-- END TWO-THIRDS -->

<?php get_sidebar();?>

</div><!-- ./container -->
</section><!-- ./blog -->

<?php get_footer(); ?>