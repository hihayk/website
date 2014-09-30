<?php
/************************************************************************
* 404 page
*************************************************************************/

get_header(); ?>

<section class="blog alternate-bg2 page-padding" id="blog">
	<div class="container">

		<div class="titleBar">
			<span><?php _e('You Are Viewing','framework');?></span>
			<h2><?php _e( 'Oops! That page can&rsquo;t be found.', 'framework' ); ?></h2>
		</div>

		<div class="two-thirds column posts">
			<div class="leftpadding ajaxed">

				
				<!-- POST -->
				<article class="post page-template">
					<h4><?php _e( 'We Tried', 'framework' ); ?></h4>

					<div class="content">
						
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'framework' ); ?></p>
					
						
					<p>&nbsp;</p>	
					
					<div class="heading">
						<h5><?php _e('Search','framework'); ?></h5>
					</div>	

					<?php get_search_form(); ?>

					<br />
					<br />
					
					</div>
				</article>	
				<!-- ./END POST -->


			</div>
			<div id="contentinner"></div>
		</div>

		<?php get_sidebar();?>

	</div>
</section>
<?php get_footer(); ?>