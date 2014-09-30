<?php
/************************************************************************
* Recent works template
*************************************************************************/

global $post,
		$smof_data,
		$nzs_category,
		$works_count;

		$old = $post;

	$unique_gallery = $works_count;



	if(0 == $smof_data['nzs_iso_works_option']){

		$works_mode = " nzs-isotype";

		$works_view = "nzs-iso-enabled";

		$works_image = "recent_iso_works-thumbnail";
		
	}else{

		$works_mode = "";

		$works_view = "";

		$works_image = "recent_works-thumbnail";
	}



if(isset($smof_data['nzs_works_orderby']) && isset($smof_data['nzs_works_order'])){
	$works_orderby = $smof_data['nzs_works_orderby'];
	$works_order = $smof_data['nzs_works_order'];
}else{
	$works_orderby = 'date';
	$works_order = 'DESC';
}

$portfolio_query = new WP_Query( array( 'post_type' => 'recent_works', 'posts_per_page' => -1,'orderby'=>$works_orderby, 'order' => $works_order,'filter_works'=>$nzs_category ) ); 

		if(isset($smof_data['nzs_works_cols']) && !empty($smof_data['nzs_works_cols'])){

			$works_cols = ("4" == $smof_data['nzs_works_cols']) ? 'four columns' : 'one-third column';

		}else{

			$works_cols = 'four columns';
		}
		
		if($portfolio_query->have_posts()):


		 echo '<div class="recent-works-view'.$works_mode.' clearfix">';

			while($portfolio_query->have_posts()) : $portfolio_query->the_post();


					 
?>

		<!-- PROJECT -->

		<div class="<?php echo $works_cols.' '.$works_view;?> project">
			<div class="gallery-padding">
				<div class="img-frame">
					<div class="image-wrapper">
					<?php 

						if(has_post_thumbnail()){

							$icon_link = '';

							$project_type = get_post_meta( get_the_ID(), 'nzs_portfolio_type', true);

							$thumb = nzs_get_post_image(get_post_thumbnail_id());

							$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');

							$gallery_title = $post->post_name.'-'.$post->ID;

							$image_caption = (nzs_get_caption(get_post_thumbnail_id())) ? nzs_get_caption(get_post_thumbnail_id()) : the_title_attribute('echo=0');


							// image gallery
							if('image' == $project_type){

								printf('<a href="%1s" title="%2$s" class="img-preview"><img src="%3$s" alt="%2$s" class="scale-with-grid" /></a>',
								get_permalink(),
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
			               	}elseif('video' == $project_type){

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


			               		printf('<a href="%1s" title="%2$s" class="img-preview"><img src="%3$s" alt="%2$s" class="scale-with-grid" /></a>',
									get_permalink(),
									$unique_gallery."-".esc_attr(the_title_attribute('echo=0')),
									esc_attr($thumb));

			               		$icon_link = ' href="'.$large_image_url[0].'" title="'.esc_attr(the_title_attribute('echo=0')).'" rel="prettyPhoto['.$gallery_title.']" ';


			               	}

						} //ENDS has_post_thumbnail

						// if(0 == $smof_data['nzs_hide_works_photo_link'] || 0 == $smof_data['nzs_hide_works_link']){
						// 	echo '<div class="mouse-effect"></div>';
						// }

					?>
					<div class="mouse-effect"></div>

						<span class="extra-links">

							<?php if(isset($smof_data['nzs_hide_works_photo_link']) && 0 == $smof_data['nzs_hide_works_photo_link']): ?>
								<a class="photo-up hide-text">View Images</a>
							<?php endif; ?>

							<?php
								$external_url = get_post_meta( get_the_ID(), 'nzs_external_link', true);

								if(isset($external_url) && !empty($external_url)){

									echo '<a href="'.esc_attr($external_url).'" target="_blank" class="web-link hide-text">Visit Site</a>';

								}
								
							?>

							<?php if(isset($smof_data['nzs_hide_works_link']) && 0 == $smof_data['nzs_hide_works_link']): ?>
								<a href="<?php the_permalink(); ?>" class="go-link hide-text">View Details</a>
							<?php endif; ?>
							
						</span>

					</div>

					<h5><?php the_title();?></h5>
					<?php the_excerpt();?>
				</div>
			</div>
		</div>

		<!-- END PROJECT -->

				
<?php
			 		
		endwhile;

		echo "</div>";

		endif;

$post = $old;
 
?>
