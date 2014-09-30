<div id="sidebar">
	
	<?php if (uri_segments(1) == 'tour'): // Shown on 'Tour' section ?>
	<!-- How Do I -->
	<div class="sidebar-widget">	
		<h3>How Do I?</h3>
		<ul>
			<?= wp_list_pages('child_of=45&title_li='.__('')); ?>
		</ul>
	</div>
	<div class="clearfix"></div>

	<!-- FAQ Section -->
	<div class="sidebar-widget">
		<h3>FAQ</h3>
		<?php 
		$parent_pages = get_pages('include=62,77,67&post_type=page'); 
		foreach ($parent_pages as $page): 
		?>	
		<h4><?= $page->post_title ?></h4>
		<nav class="sidebar-links">
			<?php 
			$sub_pages = get_pages('child_of='.$page->ID.'&post_type=page');
			$count_sub_pages = count($sub_pages);
			$i=0;
			foreach ($sub_pages as $sub): $i++; if ($i < $count_sub_pages): $comma = ','; else: $comma = ''; endif; ?>
			<a href="<?= site_url().'/tour/faq/'.$page->post_name.'/'.$sub->post_name ?>"><?= $sub->post_title.$comma ?></a>
			<?php endforeach; ?>
		</nav>
		<div class="clearfix"></div>
		<?php endforeach; ?>
	</div>
	<div class="clearfix"></div>

	<!-- Webinars -->
	<div class="sidebar-widget">	
		<h3>Webinars</h3>
		<ul>
			<?= wp_list_pages('child_of=237&title_li='.__('')); ?>
		</ul>
	</div>
	<div class="clearfix"></div>


    <?php else: // Shown on 'Blog' section ?>
    <div class="sidebar-widget">
	    <h3>Recent Posts</h3>
		<?php $recent_news = wp_get_recent_posts('numberofposts=5&post_status=publish'); ?>
	    <ul>
	    	<?php foreach($recent_news as $post): ?>
	    	<li><a href="<?= get_permalink($post["ID"]) ?>"><?= $post['post_title'] ?></a></li>
	    	<?php endforeach; ?>
	    </ul>
	    <?php the_widget( 'WP_Widget_Archives', 'dropdown=1&count=1' ); ?>
    </div>
	<div class="clearfix"></div>

	<div class="sidebar-widget">
	    <h3>Tour</h3>
	    <ul>
	    	<li><a href="/tour">How Do I?</a></li>
	    	<li><a href="/tour">FAQ</a></li>
	    	<li><a href="/tour">Webinars</a></li>
	    </ul>
	</div>
	<div class="clearfix"></div>
    <?php endif; ?>

	<div class="sidebar-widget">
		<h3>Follow Us</h3>
		<ul class="social-links">
			<li><a href="http://twitter.com/getlittlebird" target="_blank"><span class="social-twitter"></span></a></li>
			<li><a href="http://facebook.com/getlittlebird" target="_blank"><span class="social-facebook"></span></a></li>
			<li><a href="http://pinterest.com/getlittlebird/" target="_blank"><span class="social-pinterest"></span></a></li>
			<li><a href="http://vimeo.com/getlittlebird" target="_blank"><span class="social-vimeo"></span></a></li>
			<li><a href="<?php bloginfo('rss2_url'); ?>" target="_blank"><span class="social-rss"></span></a></li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
	
	
	<?php // dynamic_sidebar('Sidebar Widgets'); ?>

	
</div>
