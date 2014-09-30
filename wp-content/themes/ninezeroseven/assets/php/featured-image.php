<?php

/************************************************************************
* Featured image/slider/video file
*************************************************************************/


	$portfolio_type = get_post_meta( get_the_ID(), 'nzs_portfolio_type', true);


	$image_post_type = get_post_type(get_the_ID());


	if(has_post_thumbnail() || 'video' == $portfolio_type){


		echo '<div class="featured-image img-frame">';

		// $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-custom-thumbnail'); 
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');

		$thumb = nzs_get_post_image(get_post_thumbnail_id());


		$image_caption = (nzs_get_caption(get_post_thumbnail_id())) ? nzs_get_caption(get_post_thumbnail_id()) : the_title_attribute('echo=0');

		if('video' == $portfolio_type){
			
			$video_link = get_post_meta(get_the_ID(), 'nzs_video_link', true);


       		if($video_link && !empty($video_link)){

       			if( 1 === preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$video_link , $matches)){

	          		$video_url = 'http://www.youtube.com/embed/'.$matches[1];

	         	}elseif( 1 === preg_match('/vimeo.com\/(?:video\/)?([0-9]+)/', $video_link , $matches)){
	         		
	         		$video_url = 'http://player.vimeo.com/video/'.$matches[1].'?title=0&amp;byline=0&amp;portrait=0';
	         	}

	         	if($video_url){


           		printf('<div class="featured-video"><div class="nzs-responsive-video"><iframe src="%1s" width="400" height="300" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div></div>',
           			esc_attr($video_url));

           		}



       		}else{

       			printf('<a href="%1s" title="%2$s" rel="prettyPhoto" class="img-preview photo-box"><img src="%4$s" alt="%3$s" class="scale-with-grid" /></a>',
				esc_attr($large_image_url[0]),
				esc_attr($image_caption),
				esc_attr(the_title_attribute('echo=0')),
				esc_attr($thumb));
       		}




		}elseif('image' == $portfolio_type){
			//is IMAGE

			$meta = get_post_meta(get_the_ID(), 'nzs_image_fields', true);

			if(is_array($meta)){

				global $smof_data;

				$flexslider_speed = (isset($smof_data['nzs_flex_speed'])) ? $smof_data['nzs_flex_speed'] : '3500';
				if(isset($smof_data['nzs_flex_auto_start'])){

					$flexslider_auto = ($smof_data['nzs_flex_auto_start'] == 1) ? 'false' : 'true';

				}else{

					$flexslider_auto = 'true';
				}

				echo '<script type="text/javascript">';

				echo 'jQuery(document).ready(function($) {';

				echo '$(".slider-'.get_the_ID().'").flexslider({';
				echo '	animation: "fade",';
				echo '	animationLoop: true,';
				echo '	directionNav: true,';
				echo '	controlNav: false,';
				echo '	slideshow: '.$flexslider_auto.',';
				echo '	slideshowSpeed:'.$flexslider_speed;
				echo '});';
   
				echo '});';
				
				echo '</script>';

				echo '<div class="post-slider slider-'.get_the_ID().'">';
				echo '<div style="padding:3px;">';
				echo '<div class="image-wrapper">';
				echo '<ul class="slides">';

				printf('<li><a href="%1s" title="%2$s" rel="prettyPhoto[%3$s]" class="img-preview photo-box"><img src="%4$s" alt="%3$s" class="scale-with-grid" /></a></li>',
				esc_attr($large_image_url[0]),
				esc_attr($image_caption),
				esc_attr(the_title_attribute('echo=0')),
				esc_attr($thumb));
           
                foreach ($meta as $key => $option) {
					
					// $image_attributes = wp_get_attachment_image_src( $option ,'post-custom-thumbnail');

					$image_attributes  = nzs_get_post_image($option);

					$full_size_attributes = wp_get_attachment_image_src( $option ,'large');

					$image_caption = (nzs_get_caption($option)) ? nzs_get_caption($option) : get_the_title($option);

                    if($image_attributes){

                    	printf('<li><a href="%1$s" title="%3$s" rel="prettyPhoto[%4$s]" class="img-preview"><img src="%2$s" alt="%4$s" class="scale-with-grid" /></a></li>',
                    		$full_size_attributes[0],
                    		esc_attr($image_attributes),
                    		esc_attr($image_caption),
                    		the_title_attribute('echo=0')
                    		);
                    }

                } //end foreach

                echo '</ul>';
                echo '<div class="mouse-effect"></div>';

				echo '<span class="extra-links">';
				echo '<a class="photo-up hide-text">View Images</a>';

				if('one_page_portfolio' == $image_post_type || 'recent_works' == $image_post_type){
			
				$external_url = get_post_meta( get_the_ID(), 'nzs_external_link', true);

					if(isset($external_url) && !empty($external_url)){

						echo '<a href="'.esc_attr($external_url).'" target="_blank" class="web-link hide-text">Visit Site</a>';

					}
				}
				
				if(!is_single()){
					echo '<a href="'.get_permalink().'" class="go-link hide-text">View Details</a>';
				}

				echo '</span>';

				echo '</div>';
				echo '</div>';

                echo '</div>';


       		}else{

       			echo '<div style="padding:3px;">';

       			echo '<div class="image-wrapper">';

       			printf('<a href="%1s" title="%2$s" rel="prettyPhoto" class="img-preview photo-box"><img src="%4$s" alt="%3$s" class="scale-with-grid" /></a>',
				esc_attr($large_image_url[0]),
				esc_attr($image_caption),
				esc_attr(the_title_attribute('echo=0')),
				esc_attr($thumb));

				echo '<div class="mouse-effect"></div>';

				echo '<span class="extra-links">';
				echo '<a class="photo-up hide-text">View Images</a>';

				if('one_page_portfolio' == $image_post_type || 'recent_works' == $image_post_type){
			
				$external_url = get_post_meta( get_the_ID(), 'nzs_external_link', true);

					if(isset($external_url) && !empty($external_url)){

						echo '<a href="'.esc_attr($external_url).'" target="_blank" class="web-link hide-text">Visit Site</a>';

					}
				}
				
				if(!is_single()){
					echo '<a href="'.get_permalink().'" class="go-link hide-text">View Details</a>';
				}

				echo '</span>';

				echo '</div>';
				echo '</div>';
       		}

		}else{


			echo '<div class="image-wrapper">';

			echo '<a href="'.$large_image_url[0].'" title="'.esc_attr(the_title_attribute('echo=0')).'" rel="prettyPhoto[post-'.esc_attr(the_title_attribute('echo=0')).']" class="img-preview">';

				the_post_thumbnail( 'post-custom-thumbnail', array('class' => 'scale-with-grid'));
			
			echo '</a>';

			echo '<div class="mouse-effect"></div>';

			echo '<span class="extra-links">';
			echo '<a href="'.$large_image_url[0].'" title="'.esc_attr(the_title_attribute('echo=0')).'" rel="prettyPhoto['.esc_attr(the_title_attribute('echo=0')).']" class="photo-up hide-text">View Images</a>';
			

			if('one_page_portfolio' == $image_post_type || 'recent_works' == $image_post_type){
			
				$external_url = get_post_meta( get_the_ID(), 'nzs_external_link', true);

				if(isset($external_url) && !empty($external_url)){

					echo '<a href="'.esc_attr($external_url).'" target="_blank" class="web-link hide-text">Visit Site</a>';

				}
			}		


			if(!is_single()){
				echo '<a href="'.get_permalink().'" class="go-link hide-text">View Details</a>';
			}

			echo '</span>';

			echo '</div>';

		}


		echo '</div>';


	} //ENDS has_post_thumbnail 
?>