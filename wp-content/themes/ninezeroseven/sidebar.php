<?php
/************************************************************************
 * Sidebar File
 *************************************************************************/ 
?>

<!-- BEGIN SIDE BAR -->

<div class="one-third column">
	<div class="rightpadding sidebar">

		<?php if ( ! dynamic_sidebar( get_custom_sidebar() ) ) : ?>

			<!-- SEARCH WIDGET -->

			<?php get_search_form(); ?>

			<!-- CATEGORIES WIDGET -->

			<div class="widget">
				<div class="heading">
					<h5><?php _e('Categories','framework'); ?></h5>
				</div>
				<ul class="categories">
					<?php wp_list_categories('title_li='); ?>
				</ul>
			</div>


			<!-- META WIDGET -->

			<div class="widget">
				<div class="heading">
					<h5><?php _e('Meta','framework'); ?></h5>
				</div>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</div>


			<!-- Archives WIDGET -->

			<div class="widget">
				<div class="heading">
					<h5><?php _e('Archives','framework'); ?></h5>
				</div>
				<ul>
					<?php wp_get_archives(); ?>
				</ul>
			</div>

			<!-- Pages WIDGET -->

			<div class="widget">
				<div class="heading">
					<h5><?php _e('Pages','framework'); ?></h5>
				</div>
				<ul>
					<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
				</ul>
			</div>


		<?php endif; wp_head_title(); // end sidebar widget area ?>

	</div>
<!-- END SIDBAR -->
</div>
