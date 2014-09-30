<?php
/************************************************************************
 * Supersized Full Width Header File
 *************************************************************************/ 

global $smof_data;


function fullscreen_init(){
	global $smof_data;
				
	$slides = $smof_data['nzs_full_screen_slider'];


	$full_images = "";

	if($slides){

		foreach($slides as $slide){

			if(!empty($slide['url'])){

				$add_in = '';

				if(!empty($slide['title'])){

					$add_in .= '<h2>'.addslashes($slide['title']).'</h2><br/>';

				}

				if(!empty($slide['description'])){

					$add_in .= '<p>'.addslashes($slide['description']).'</p>';

				}

				if(!empty($add_in) || !empty($slide['link'])){

					$content = "";


					if(!empty($add_in)){
						$content .= ",title:\"".$add_in."\"";
					}

					if(!empty($slide['link'])){

						$content .= ",url:\"".$slide['link']."\"";

					}

					$full_images .= "{image: \"".$slide['url']."\"".$content."}";

				}else{

					$full_images .= "{image: \"".$slide['url']."\"}";

				}

			}else{
				$full_images .= "{image: \"".get_template_directory_uri()."/assets/img/theme/slider-holder.jpg\",title: '<h2>".get_bloginfo('name')."</h2><br/><p>".get_bloginfo('description')."</p>'}";
			}

		}
		
	}else{
		
		$full_images .= "{image: \"".get_template_directory_uri()."/assets/img/theme/slider-holder.jpg\",title: '<h2>".get_bloginfo('name')."</h2><br/><p>".get_bloginfo('description')."</p>'}";

	}

	$full_images = str_replace("}{", "},".PHP_EOL."\t\t\t{", $full_images);

	?>
<script type="text/javascript">
	jQuery(window).load(function(){
	    jQuery(".super").supersized({
	        slide_interval: <?php echo (isset($smof_data['nzs_fullscreen_speed'])) ? (int) $smof_data['nzs_fullscreen_speed'] : '4000'; ?>,
	        transition: <?php echo (isset($smof_data['nzs_fullscreen_trans'])) ? (int) $smof_data['nzs_fullscreen_trans'] : '1'; ?>,
	        transition_speed: 700,
	        new_window: <?php echo (isset($smof_data['nzs_full_slider_target'])) ? $smof_data['nzs_full_slider_target'] : '1'; ?>,
	        slides: [<?php echo $full_images;?>]
	    });
	});
</script>
	<?php
}

add_action( 'wp_footer', 'fullscreen_init', 30);
 
?>


<section class="headerContent entry"<?php if(is_admin_bar_showing()){echo ' style="margin-top:-28px"';} ?>>
	<div class="super">

		<a id="prevslide" class="load-item"></a>
		<a id="nextslide" class="load-item"></a>

		<div id="progress-back" class="load-item">
			<div id="progress-bar"></div>
		</div>

		<div class="container">


			<?php if(isset($smof_data['nzs_fullscreen_logo_image']) && !empty($smof_data['nzs_fullscreen_logo_image'])): ?>


				<div class="sixteen columns header-logo-area">

					<img src="<?php echo $smof_data['nzs_fullscreen_logo_image']; ?>" class="header-logo scale-with-grid"/>

				</div>


			<?php endif; ?>

			<div id="slidecaption" class="message"></div>

		</div>
	
		<?php if( function_exists('nzs_social_links') ){ ?>
		
			<div class="social">
				<?php echo nzs_social_links();?>
			</div>

		<?php }?>
	
	</div>
</section> <!-- ./headerContent -->