<?php
/************************************************************************
* Single Portfolio Page
*************************************************************************/

get_header(); ?>

<section class="blog alternate-bg2 page-padding" id="blog">
	<div class="container">

		<?php while(have_posts()) : the_post(); ?>
			
		<div class="titleBar">
			<span><?php _e('Portfolio','framework');?></span>
			<h2><?php the_title( );?></h2>
		</div>

		<div class="sixteen columns posts">
			<div class="full-width-portfolio">
			

				<!-- POST -->
				<article class="post" style="padding-top:8px;">

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
			<div class="page-nav clearfix" style="margin-bottom:30px;">

			 <span class="fl"><?php previous_post_link('<strong>%link</strong>',__('&laquo; Previous','framework')); ?></span>
			 <span class="fr"><?php next_post_link('<strong>%link</strong>',__('Next &raquo;','framework')); ?></span>
			</div>

		</div> <!-- END PADDING -->
	</div><!-- END TWO-THIRDS -->

</div><!-- ./container -->
</section><!-- ./blog -->

<?php get_footer(); ?>