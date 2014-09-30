<?php
/************************************************************************
* No Results Page
*************************************************************************/
?>
<!-- POST -->


<?php if ( is_home()) : ?>

	<section class="blog alternate-bg2" id="blog">
		<div class="container">
			<div class="titleBar">
				<span><?php _e('Oh Whoops','framework');?></span>
				<h2><?php _e('Nothing to Show','framework');?></h2>
			</div>

			<div class="sixteen columns posts">

					<!-- POST -->
					<article class="post page-template">

						<div class="content">

							<?php if(current_user_can( 'publish_posts' ) ): ?>
							
								<p><?php printf( __( 'Ready to build? <a href="%1$s">Get started here</a>.', 'framework' ), admin_url( 'post-new.php?post_type=page-sections' ) ); ?></p>

							<?php else: ?>

								<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'framework' ); ?></p>
								
								<p>&nbsp;</p>	
					
								<div class="heading">
									<h5><?php _e('Search','framework'); ?></h5>
								</div>	

								<?php get_search_form(); ?>

							<?php endif; ?>
						</div>
					</article>	
					<!-- ./END POST -->
			</div>
		</div>
	</section>

<?php else: ?>

	<article class="post-0">
		<h4><?php _e( 'Nothing Found', 'framework' ); ?></h4>

		<div class="content">
			
			

				

			<?php if ( is_search() ) : ?>

				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'framework' ); ?></p>
				<p>&nbsp;</p>	
					
					<div class="heading">
						<h5><?php _e('Search','framework'); ?></h5>
					</div>	

					<?php get_search_form(); ?>

			<?php else : ?>

				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'framework' ); ?></p>
				<h5><?php _e('Search','framework'); ?></h5>
				<p>&nbsp;</p>	
					
					<div class="heading">
						<h5><?php _e('Search','framework'); ?></h5>
					</div>	

					<?php get_search_form(); ?>

			<?php endif; ?>

		</div>

	</article>	
<!-- ./END POST -->

<?php endif; ?>