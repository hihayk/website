<?php

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'parallax-section.php' == basename($_SERVER['SCRIPT_FILENAME'])){
	die ('This file can not be accessed directly!');
}
$parallax_ID = get_the_ID();

$extra_class = '';

$mobile_bg_image = '';

$has_video_bg = false;

$video_html = '';

$bg_style = '';

$background_color = get_post_meta( $parallax_ID, 'nzs_parallax_overlay_color', true);

if($background_color){

	$bg_style .= 'style="background-color:rgba('.nzs_hex_rgb( $background_color , get_post_meta( $parallax_ID, 'nzs_parallax_overlay_alpha', true ) ).');"';
}

$video_html .= '<div class="parallax-bg-overlay" '.$bg_style.'></div>';

if(get_post_meta( $parallax_ID, 'nzs_video_bg_enable', true ) == 'enabled'){

	$has_video_bg = true;

	$extra_class = 'video-bg-section';


    $video_webm = get_post_meta( $parallax_ID, 'nzs_video_bg_path_webm', true );
    $video_mp4 = get_post_meta( $parallax_ID, 'nzs_video_bg_path_mp4', true );
    $video_ogv = get_post_meta( $parallax_ID, 'nzs_video_bg_path_ogv', true );

    $video_bg_image = get_post_meta( $parallax_ID, 'nzs_video_poster_image', true );


    $poster_video_bg_image = '';
    
    if($video_bg_image) {

    	$poster_video_bg_image = 'poster="'.$video_bg_image .'"';

    	$video_html .= '<div class="mobile-video-image" style="background:url(\''.$video_bg_image.'\');"></div>';
    }
    
    wp_enqueue_script('wp-mediaelement');
	wp_enqueue_style('wp-mediaelement');

	$video_html .= '<div class="nzs-video-bg">';

	$video_html .= '<video class="video-background" muted controls="controls" width="1700" height="970" '.$poster_video_bg_image.' preload="auto" loop autoplay>';
	if($video_webm) $video_html .= '<source src="'.$video_webm.'" type="video/webm">';
	if($video_mp4) $video_html .= '<source src="'.$video_mp4.'" type="video/mp4">';
	if($video_ogv) $video_html .= '<source src="'.$video_ogv.'" type="video/ogv">';

	if($video_mp4){
		$video_html .= '<object width="1700" height="970" type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/assets/js/flashmediaelement.swf">';
		$video_html .= '<param name="movie" value="'.get_template_directory_uri().'/assets/js/flashmediaelement.swf" />';
		$video_html .= '<param name="flashvars" value="controls=true&file='.$video_mp4.'&autoPlay=true" />';
		$video_html .= '<param name="autoplay" value="true">';
		        
		if($video_bg_image) $video_html .= '<img src="'.$video_bg_image.'" width="1700" height="970" title="Not supported" />';
    	
    	$video_html .= '</object>';
	}



	$video_html .='</video>';
	$video_html .='</div>';
}
?>

<section class="parallax <?php echo get_post_type();?>-<?php echo $parallax_ID;?> <?php echo $extra_class;?>" id="<?php echo get_post_type();?>-<?php echo get_the_ID();?>">

	<?php echo $video_html; ?>

	<div class="container message">
		<?php

		the_content();
		
		?>
	</div>
</section>