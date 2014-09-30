<?php
/************************************************************************
* Portfolio Template
*************************************************************************/

global $post,
		$smof_data,
		$nzs_category,
		$gallery_count;

		$old = $post;

	$unique_gallery = $gallery_count;


	if(0 == $smof_data['nzs_iso_portfolio_option']){

		$gallery_mode = " nzs-isotype";

		$gallery_view = "nzs-iso-enabled";

		$gallery_image = "one_page_iso_portfolio-thumbnail";
		
	}else{

		$gallery_mode = " nzs-standard";

		$gallery_view = "nzs-gallery";

		$gallery_image = "one_page_portfolio-thumbnail";
	}


	if(isset($smof_data['nzs_portfolio_orderby']) && isset($smof_data['nzs_portfolio_order'])){
		$portfolio_orderby = $smof_data['nzs_portfolio_orderby'];
		$portfolio_order = $smof_data['nzs_portfolio_order'];
	}else{
		$portfolio_orderby = 'date';
		$portfolio_order = 'DESC';
	}


	$portfolio_query = new WP_Query( array( 'post_type' => 'one_page_portfolio', 'posts_per_page' => -1,'orderby'=>$portfolio_orderby, 'order' => $portfolio_order,'filter'=>$nzs_category) ); 
		
		if($portfolio_query->have_posts()): 
?>

<ul class="portfolio-layout<?php echo $gallery_mode;?>">


<?php

		if(isset($smof_data['nzs_portfolio_cols']) && !empty($smof_data['nzs_portfolio_cols'])){

			$portfolio_cols = ("4" == $smof_data['nzs_portfolio_cols']) ? 'four columns' : 'one-third column';

		}else{

			$portfolio_cols = 'four columns';
		}


		  while($portfolio_query->have_posts()) : $portfolio_query->the_post();

		?>

		<!-- GALLERY ITEM -->
		<li class="<?php echo $portfolio_cols;?> <?php echo $gallery_view; ?>">
			<div class="gallery-padding">
				<div class="img-frame">
					<div class="image-wrapper">

				<?php 

				if(has_post_thumbnail()){


					$icon_link = '';


					$portfolio_type = get_post_meta( get_the_ID(), 'nzs_portfolio_type', true);

					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');

					$thumb = nzs_get_post_image(get_post_thumbnail_id());

					$image_caption = (nzs_get_caption(get_post_thumbnail_id())) ? nzs_get_caption(get_post_thumbnail_id()) : the_title_attribute('echo=0');
			
					// image gallery
					if('image' == $portfolio_type){

						printf('<a href="%1s" title="%2$s" rel="prettyPhoto[main-%2$s]" class="img-preview"><img src="%3$s" alt="%2$s" class="scale-with-grid" /></a>',
						$large_image_url[0],
						esc_attr(the_title_attribute('echo=0')),
						$thumb);


						$icon_link = ' href="'.$large_image_url[0].'" title="'.esc_attr($image_caption).'" rel="prettyPhoto['.$unique_gallery.'-'.esc_attr(the_title_attribute('echo=0')).']" ';

						$meta = get_post_meta(get_the_ID(), 'nzs_image_fields', true);


						echo '<a'.$icon_link.' class="photo-box"></a>';

						if(is_array($meta)){
	                   
		                    foreach ($meta as $key => $option) {
								
								$image_attributes = wp_get_attachment_image_src( $option ,'large');

								$image_caption = (nzs_get_caption($option)) ? nzs_get_caption($option) : get_the_title($option);

		                        if($image_attributes[0]){

		                        	printf('<a href="%1s" title="%2s" rel="prettyPhoto[%3s]" class="img-preview"></a>',
		                        		esc_attr($image_attributes[0]),
		                        		esc_attr($image_caption),
		                        		$unique_gallery."-".the_title_attribute('echo=0'));
		                        }

		                    } //end foreach
	               		}


	               	//  video		
	               	}elseif('video' == $portfolio_type){

	               		$video_link = get_post_meta(get_the_ID(), 'nzs_video_link', true);

	               		$video_link = $video_link ? $video_link.'?iframe=true&width=75%&height=75%' : '';

	               		$icon_link = ' href="'.$video_link.'" title="'.esc_attr($image_caption).'" rel="prettyPhoto['.$unique_gallery.'-'.esc_attr(the_title_attribute('echo=0')).']" ';

	               		echo '<a'.$icon_link.' class="photo-box"></a>';

	               		if($video_link){
		               		printf('<a href="%1s" title="%2$s" rel="prettyPhoto[iframes]" class="video-preview"><img src="%3$s" alt="%2$s" class="scale-with-grid" /></a>',
		               			esc_attr($video_link),
		               			esc_attr($image_caption),
		               			esc_attr($thumb));
	               		}
						
	               	// single image
	               	}else{

	               		printf('<a href="%1s" title="%2$s" rel="prettyPhoto[%2$s]" class="img-preview"><img src="%3$s" alt="%2$s" class="scale-with-grid" /></a>',
							esc_attr($large_image_url[0]),
							$unique_gallery."-".esc_attr(the_title_attribute('echo=0')),
							esc_attr($thumb));

	               	}

				} //ENDS has_post_thumbnail

				?>

				<div class="mouse-effect"></div>

					<span class="extra-links">

						<?php if(isset($smof_data['nzs_hide_portfolio_photo_link']) && 0 == $smof_data['nzs_hide_portfolio_photo_link']): ?>
								<a class="photo-up hide-text">View Images</a>
						<?php endif; ?>

						<?php
							$external_url = get_post_meta( get_the_ID(), 'nzs_external_link', true);

							if(isset($external_url) && !empty($external_url)){

								echo '<a href="'.esc_attr($external_url).'" target="_blank" class="web-link hide-text">Visit Site</a>';

							}
						?>



					<?php if(isset($smof_data['nzs_hide_portfolio_link']) && 0 == $smof_data['nzs_hide_portfolio_link']): ?>

						<a href="<?php the_permalink(); ?>" class="go-link hide-text">View Details</a>

					<?php endif; ?>

					</span>

				</div>


				<h5><?php the_title();?></h5>
				<?php the_excerpt();?>

				</div>
			</div>
		</li>

	<!-- GALLERY ITEM -->



<?php
		endwhile;
	endif;
	$post = $old;
 
?>

</ul>
