<?php
/*
Template Name: Right Sidebar
*/

get_header(); ?>

<section <?php post_class( 'blog alternate-bg2 page-padding');?> id="blog">
	<div class="container">
		<?php if( have_posts() ) : the_post(); ?>
		<div class="titleBar">
			<span><?php _e('You Are Viewing','framework');?></span>
			<h2><?php the_title();?></h2>
		</div>

		<div class="two-thirds column posts">
			<div class="leftpadding ajaxed">

				<!-- POST -->
				<article class="post page-template">

					<div class="content">
						
					<?php the_content(); ?>

					</div>
				</article>	
				<!-- ./END POST -->

			</div> <!-- END PADDING -->
		</div><!-- END TWO-THIRDS -->

		<?php endif; // end of the loop. ?>
	

<?php get_sidebar();?>
</div>
</section>
<?php get_footer(); ?>