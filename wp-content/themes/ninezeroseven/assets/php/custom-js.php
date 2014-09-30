<?php
/************************************************************************
 * Custom JS File
 *************************************************************************/ 



function load_custom_js(){

	$script_out = '';

	$script_out .= '<script type="text/javascript">'."\n";
	$script_out .= 'jQuery(document).ready(function($){'."\n";

	$script_out .= ajaxed_blog();

	$script_out .= nav_script_block();

	$script_out .= '});'."\n";
	$script_out .= "\n".'</script>'."\n\n\n";

	$script_out .= custom_analytics_code();

	$script_out .= parallax_move();

	

	echo $script_out;


}

add_action('wp_footer','load_custom_js',20);

function custom_analytics_code(){
	global $smof_data;

	if(isset($smof_data['nzs_google_analytics']) && !empty($smof_data['nzs_google_analytics'])){

		return $smof_data['nzs_google_analytics']."\n\n\n";

	}
}

function nav_script_block(){

	$script = '';

	$script .='$(\'#subMenu\').change(function(){'."\n";
    $script .= "\t".'var content = $(this).val();'."\n";

    $script .= "\t".'var checkURL = content.match(/^#([^\/]+)$/i);'."\n";

    $script .= "\t".'if(checkURL){'."\n\n";

	$script .= "\t". "\t".'var goPosition = $(content).offset().top - 80;'."\n";
	$script .= "\t". "\t".'$(\'html,body\').animate({ scrollTop: goPosition}, \'slow\');'."\n\n";

    $script .= "\t".'}else{'."\n";

     $script .= "\t". "\t".'window.location = content;'."\n";
        		
    $script .= "\t".'}'."\n";
    $script .='});'."\n\n";


	return $script;
}


function ajaxed_blog(){

	if(!is_home()){
		return;
	}

	$script_return = '';

	$script_return .= "\t".'$("#page-links a").live("click",function(event){'."\n";
	$script_return .= "\t\t".'event.preventDefault();'."\n";
	$script_return .= "\t\t".'var post_id = $(this).attr("href");'."\n";
	$script_return .= "\t\t".'var parentSection = $(this).parents("section").attr("id");'."\n";
	$script_return .= "\t\t".'$(".ajaxed").animate({opacity : "0.1"});'."\n";
	$script_return .= "\t\t\t".'$("html, body").animate({ scrollTop: $("#"+parentSection).offset().top -80 }, 1000);'."\n";
	$script_return .= "\t\t".'$(".ajaxed").load(post_id+" .ajaxed", function(){'."\n";
	$script_return .= "\t\t".'$(".ajaxed").animate({opacity : "1"});'."\n";
	$script_return .= "\t\t\t".'$("a[rel^=\'prettyPhoto\']").prettyPhoto();'."\n";
	$script_return .= flexslider_sliders();
	$script_return .= image_effect();
	$script_return .= "\t\t".'});'."\n";

	$script_return .= "\t".'});'."\n\n\n";

	return $script_return;




}

function parallax_move(){
	global $smof_data;

	$page_section_query = new WP_Query( array( 'post_type' => 'parallax-sections', 'posts_per_page' => -1, 'order' => 'ASC' )); 
	if($page_section_query->have_posts()): 

		$script_return = '';


		if(isset($smof_data['nzs_parallax_header_speed'])){

			$header_speed = $smof_data['nzs_parallax_header_speed'];

		}else{
			$header_speed = '0.3';
		}

		if('parallax' == $smof_data['nzs_header_options']){
			$script_return .= "\t".'jQuery("#header-option").parallax("50%", "'.$header_speed.'");'."\n";
		}

		while($page_section_query->have_posts()) : $page_section_query->the_post();


			$meta = get_post_meta(get_the_ID(), 'nzs_parallax_speed', true);

			if($meta == false || 'default' == $meta){
				$p_speed = '0.3';
			}else{
				$p_speed = $meta;
			}


			$script_return .= "\t".'jQuery("#parallax-sections-'.get_the_ID().'").parallax("50%", "'.$p_speed.'");'."\n";


		endwhile;

		$script_out ='';

		$script_out .= '<script type="text/javascript">'."\n";
		$script_out .= 'jQuery(window).load(function () {'."\n";
			
		$script_out .= $script_return;

		$script_out .= '});'."\n";
		$script_out .= "\n\n\n";

		$script_out .= 'jQuery(window).resize(function () {'."\n";
			
		$script_out .= $script_return;

		$script_out .= '});'."\n";
		$script_out .= "\n".'</script>'."\n\n\n";

		return $script_out;

	endif;


}


function image_effect(){

	$effect = "";

	$effect .= "\t\t\t$('.image-wrapper').hover(function(){\n";

	$effect .= "\t\t\t\t$(this).find('.mouse-effect').stop().animate({'opacity':'0.6'});\n";
    $effect .= "\t\t\t\t$(this).find('.extra-links').stop().animate({'top':'50%'});\n";
	$effect .= "\t\t\t\t },function(){\n";
	$effect .= "\t\t\t\t $(this).find('.mouse-effect').stop().animate({'opacity':'0'});\n";
	$effect .= "\t\t\t\t$(this).find('.extra-links').stop().animate({'top':'-50%'});\n";

	$effect .= "\t\t\t});\n\n\n";


	


	return $effect;


	
}

function flexslider_sliders(){
	global $smof_data;

	$post_slider_query = new WP_Query( array( 'post_type' => 'post','meta_key'=>'nzs_portfolio_type','meta_value'=>'image', 'posts_per_page' => -1, 'order' => 'ASC' )); 
	if($post_slider_query->have_posts()): 


		$flexslider_speed = (isset($smof_data['nzs_flex_speed'])) ? $smof_data['nzs_flex_speed'] : '3500';
		if(isset($smof_data['nzs_flex_auto_start'])){

			$flexslider_auto = ($smof_data['nzs_flex_auto_start'] == 1) ? 'false' : 'true';

		}else{

			$flexslider_auto = 'true';
		}

		$script_return = '';

		

		while($post_slider_query->have_posts()) : $post_slider_query->the_post();

			$meta = get_post_meta(get_the_ID(), 'nzs_image_fields', true);

			if(is_array($meta)){

			$script_return .= "\t\t\t".'$(".slider-'.get_the_ID().'").flexslider({'."\n";
			$script_return .= "\t\t\t\t".'animation: "fade",'."\n";
			$script_return .= "\t\t\t\t".'animationLoop: true,'."\n";
			$script_return .= "\t\t\t\t".'directionNav: true,'."\n";
			$script_return .= "\t\t\t\t".'controlNav: false,'."\n";
			$script_return .= "\t\t\t\t".'useCSS: false,'."\n";
			$script_return .= "\t\t\t\t".'slideshow:'.$flexslider_auto.",\n";
			$script_return .= "\t\t\t\t".'slideshowSpeed:'.$flexslider_speed."\n";
			$script_return .= "\t\t\t".'});'."\n\n";


			}

			


		endwhile;

		return $script_return;

	endif;


}


?>