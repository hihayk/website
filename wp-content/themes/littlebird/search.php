<?php get_header(); ?>

<div id="sub-title">
	<h2>Search<small>Find what your looking for</small></h2>
	<?php get_search_form(); ?>
</div>

<div id="container">
	<div class="color-bar"></div>
	<div class="content-wide">
	<?php if (have_posts()) : ?>

		<h2><span class="color-dark-gray">Results For:</span> "<?= $_GET['s'] ?>"</h2>

		<?php while (have_posts()) : the_post(); ?>
			<article class="search-result" id="post-<?php the_ID(); ?>">
				<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
			</article>
		<?php endwhile; ?>
		<?php include (TEMPLATEPATH . '/includes/nav.php' ); ?>

	<?php else : ?>

		<h2>No posts found.</h2>

	<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
