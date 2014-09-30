<?php get_header(); ?>

<div id="sub-title">
	<h2>Oops<small>You discovered a quirk</small></h2>
	<?php get_search_form(); ?>
</div>

<div id="container">
	<div class="color-bar"></div>

	<div id="content">
		<h2><?php _e('Error 404 - Page Not Found','html5reset'); ?></h2>
	</div>

	<?php get_sidebar(); ?>

	<div class="clearfix"></div>
</div>

<?php get_footer(); ?>
