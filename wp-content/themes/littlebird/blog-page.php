<?php /* Template Name: Blog Page */ ?>
<?php get_header(); ?>

<div id="sub-title">
	<h2><a href="<?= site_url() ?>/blog">Blog</a><small>Keep up to date with Little Bird</small></h2>
	<?php get_search_form(); ?>
</div>

<div id="container">
	<div class="color-bar"></div>

	<div id="content">

		<?php $recent_news = wp_get_recent_posts('numberofposts=5&post_status=publish'); ?>	
    	<?php if ($recent_news): foreach($recent_news as $post): ?>
		<article class="post" id="post-<?php the_ID(); ?>">
		
			<h3><a href="<?= get_permalink($post["ID"]) ?>"><?= $post['post_title'] ?></a></h3>

			<div class="entry">
				<?php echo apply_filters('the_content', $post['post_content']); ?>
				
				<div class="clearfix"></div>
				
				<a href="<?= get_permalink($post["ID"]) ?>" class="button-large">Read Article</a>
				
				<h4 class="comments-count"><a href="<?= get_permalink($post["ID"]) ?>#disqus_thread"> Comments</a></h4>
			</div>	

		</article>
    	<?php endforeach; endif; ?>

	</div>

	<?php get_sidebar(); ?>

	<div class="clearfix"></div>
</div>

<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'getlittlebird'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
</script>

<?php get_footer(); ?>
