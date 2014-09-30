<?php
/************************************************************************
 * Full Width Video(Vimeo) Header File
 *************************************************************************/ 

global $smof_data;

function fullscreen_init(){
	global $smof_data;


	$video_link = (isset($smof_data['nzs_vimeo_video_embed'])) ? $smof_data['nzs_vimeo_video_embed'] : "";

	if( 1 === preg_match('/player.vimeo.com\/video\/([^\/]+)/', $video_link , $matches)){
	
		$video_url = $matches[1];

     }else{

     	$video_url = "";

     }

     if(isset($smof_data['nzs_vimeo_video_repeat'])){

     	$video_repeat = ($smof_data['nzs_vimeo_video_repeat'] == 0 ? '1' : '0');

     }else{

     	$video_repeat = '1';
     }

     if(isset($smof_data['nzs_vimeo_volume'])){

     	$video_volume_setting = $smof_data['nzs_vimeo_volume'] / 100;

     }else{

     	$video_volume_setting = 0.3;
     }

?>

<script type="text/javascript">
	(function(){
	   jQuery('#full-youtube-video-container').tubular({videoId: '<?php echo $video_url;?>',repeat:<?php echo $video_repeat; ?>,volumeDefault:<?php echo $video_volume_setting; ?>});

	   jQuery('.video-header-controls').mouseover(function(){

	   	jQuery('.video-header-controls').stop().animate({'right':'0'});

	   }).mouseout(function(){

	   	jQuery('.video-header-controls').stop().animate({'right':'-190px'});

	   });

	})(jQuery,window);
</script>
				
<?php	
}

add_action( 'wp_footer', 'fullscreen_init', 30);
 
?>

<section id="full-youtube-video-container" class="video-header vimeo-header"<?php if(is_admin_bar_showing()){echo ' style="margin-top:-28px"';} ?>>


	<div class="video-header-content">

		<div class="container">

			<?php if(isset($smof_data['nzs_vimeo_logo_image']) && !empty($smof_data['nzs_vimeo_logo_image'])): ?>


					<div class="sixteen columns header-logo-area">

						<img src="<?php echo $smof_data['nzs_vimeo_logo_image']; ?>" class="header-logo scale-with-grid"/>

					</div>


				<?php endif; ?>


			<?php
				if(!empty($smof_data['nzs_vimeo_heading_text']) || !empty($smof_data['nzs_vimeo_description_text'])){
			?>

			<div class="message">

			<?php if(!empty($smof_data['nzs_vimeo_heading_text'])): ?>

				<h2><?php echo $smof_data['nzs_vimeo_heading_text'];?></h2><br/>

			<?php endif; ?>

			<?php if(!empty($smof_data['nzs_vimeo_description_text'])): ?>

				<p><?php echo $smof_data['nzs_vimeo_description_text'];?></p>

			<?php endif; ?>

			</div> <!-- ./message -->

			<?php } ?>

			

		</div> <!-- ./ Container -->
			
		<?php if( function_exists('nzs_social_links') ){ ?>

			<div class="social">
				<?php echo nzs_social_links();?>
			</div>

		<?php }?>

	</div> <!-- ./video-header-content -->


	<div class="video-header-controls clearfix">
		<ul>
			<li class="tubular-play active"></li>
			<li class="tubular-pause"></li>
			<li class="tubular-mute"></li>
			<li class="tubular-volume-down"></li>
			<li class="tubular-volume-up"></li>
		</ul>
		<div class="control-handle"></div>
	</div>

	<div id="tubular-cover-image"></div>

</section> <!-- ./headerContent -->