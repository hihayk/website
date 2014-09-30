<?php get_header(); ?>

<div id="sub-title">
	<h2><a href="<?= site_url() ?>/blog">Blog</a><small>Keep up to date with Little Bird</small></h2>
	<?php get_search_form(); ?>
</div>

<div id="container">
	<div class="color-bar"></div>

	<div id="content">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<h1 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
			<?php include(TEMPLATEPATH.'/includes/meta.php' ); ?>

			<div class="entry-content">

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

				<h3><?php the_tags('Tags: ', ', ', ''); ?></h3>

			</div>

		</article>

		<?php include(TEMPLATEPATH.'/includes/share.php' ); ?>

		<?php comments_template(); ?>

	<?php endwhile; endif; ?>
	</div>

	<?php get_sidebar(); ?>

<div class="clearfix"></div>
</div>

<?php get_footer(); ?>