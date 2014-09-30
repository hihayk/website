<?php
/************************************************************************
 * FlexSlider Header File
 *************************************************************************/ 
?>

<section class="headerContent">
<div class="container">
	
		<div class="mainSlider">
			<ul class="slides">


				<?php

				global $smof_data;
				
				$slides = $smof_data['nzs_flex_slider'];


				if($slides){

					foreach ($slides as $slide) {

						echo '<li>';


						if(!empty($slide['url'])){

							if(!empty($slide['link'])){

								echo '<a href="'.esc_attr( $slide['link'] ).'"><img src="'.esc_attr($slide['url']).'" alt="" width="970" class="scale-with-grid"></a>';

							}else{

								echo '<img src="'.esc_attr($slide['url']).'" alt="" width="970" class="scale-with-grid">';

							}
						}

						if(!empty($slide['title']) && !empty($slide['description'])){
							?>

							<div class="flex-content">
								<h4><?php echo $slide['title']; ?></h4>
								<p><?php echo $slide['description']; ?></p>
							</div>

							<?php

						}

						echo '</li>';
					}

				} 

				?>


			</ul>

		</div> <!-- END MAIN SLIDER -->	

	</div> <!-- ./container -->

</section> <!-- ./headerContent -->