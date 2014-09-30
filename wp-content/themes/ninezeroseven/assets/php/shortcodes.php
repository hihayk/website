<?php
/************************************************************************
 * Custom Shortcodes
 *
 * Content filter used ONLY on custom theme shortcodes to remove
 * p and br tags.
 *************************************************************************/ 

add_filter("the_content", "the_content_filter");

function the_content_filter($content) {
 
// array of custom shortcodes requiring the fix
$block = join("|",array("portfolio",
						"one_fourth",
						"one_fourth_first",
						"one_fourth_last",
						"one_third",
						"one_third_first",
						"one_third_last",
						"two_thirds",
						"two_thirds_first",
						"two_thirds_last",
						"one_half",
						"one_half_first",
						"one_half_last",
						"three_fourth",
						"three_fourth_first",
						"three_fourth_last",
						"full",
						"full_nested",
						"title_bar",
						"video_box",
						"border_box",
						"clear",
						"button",
						"blog",
						"team",
						"member_info",
						"recent_works",
						"heading",
						"lightbox",
						"nzs_slider",
						"nzs_slides",
						"nzs_service",
						"nzs_heading",
						"social_links",
						"price_table",
						"price_plan",
						"price_option",
						"nzs_contact_form",
						"contact_info",
						"padding_box",
						"social_links",
						"icon_list",
						"icon_list_li",
						"sidebar_shortcode",
						"font_icon",
						"standard_list",
						"standard_list_li"
						));
 
// opening tag
$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
// closing tag
$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
return $rep;
 
}

/**************************************
* Sidebar Shortcode
***************************************/

function get_sidebar_shortcode( $atts, $content = null ) {

	$atts = extract(shortcode_atts(array(
	'sidebar' => ''
	),$atts));

	if(empty($sidebar)){
		$sidebar = 'sidebar-1';
	}

	ob_start();	
	dynamic_sidebar( $sidebar );
	$sidebar_code = ob_get_clean();
    return '<div class="sidebar">'.$sidebar_code.'</div>';

}
add_shortcode('sidebar_shortcode','get_sidebar_shortcode');


/************************************************************************
* Columns
*************************************************************************/

function wrap_container( $atts, $content = null ) {

	return "<div class=\"container\">".do_shortcode($content)."</div>";

}
add_shortcode('container','wrap_container');


//1/3
function one_thrid_column( $atts, $content = null ) {

	return "<div class=\"one-third column\">".do_shortcode($content)."</div>";

}
add_shortcode('one_third','one_thrid_column');

function one_thrid_first( $atts, $content = null ) {

	return "<div class=\"one-third column alpha\">".do_shortcode($content)."</div>";

}
add_shortcode('one_third_first','one_thrid_first');

function one_thrid_last( $atts, $content = null ) {

	return "<div class=\"one-third column omega\">".do_shortcode($content)."</div>";

}
add_shortcode('one_third_last','one_thrid_last');


//2/3

function two_third_column( $atts, $content = null ) {

	return "<div class=\"two-thirds column\">".do_shortcode($content)."</div>";

}
add_shortcode('two_thirds','two_third_column');

function two_third_first( $atts, $content = null ) {

	return "<div class=\"two-thirds column alpha\">".do_shortcode($content)."</div>";

}
add_shortcode('two_thirds_first','two_third_first');

function two_third_last( $atts, $content = null ) {

	return "<div class=\"two-thirds column omega\">".do_shortcode($content)."</div>";

}
add_shortcode('two_thirds_last','two_third_last');

//1/2

function one_half_column( $atts, $content = null ) {

	return "<div class=\"eight columns\">".do_shortcode($content)."</div>";

}
add_shortcode('one_half','one_half_column');

function one_half_first( $atts, $content = null ) {

	return "<div class=\"eight columns alpha\">".do_shortcode($content)."</div>";

}
add_shortcode('one_half_first','one_half_first');

function one_half_last( $atts, $content = null ) {

	return "<div class=\"eight columns omega\">".do_shortcode($content)."</div>";

}
add_shortcode('one_half_last','one_half_last');

//1/4

function one_fourth_column( $atts, $content = null ) {

	return "<div class=\"four columns\">".do_shortcode($content)."</div>";

}
add_shortcode('one_fourth','one_fourth_column');

function one_fourth_first( $atts, $content = null ) {

	return "<div class=\"four columns alpha\">".do_shortcode($content)."</div>";

}
add_shortcode('one_fourth_first','one_fourth_first');

function one_fourth_last( $atts, $content = null ) {

	return "<div class=\"four columns omega\">".do_shortcode($content)."</div>";

}
add_shortcode('one_fourth_last','one_fourth_last');

function three_fourth_column( $atts, $content = null ) {

	return "<div class=\"twelve columns\">".do_shortcode($content)."</div>";

}
add_shortcode('three_fourth','three_fourth_column');

function three_fourth_first( $atts, $content = null ) {

	return "<div class=\"twelve columns alpha\">".do_shortcode($content)."</div>";

}
add_shortcode('three_fourth_first','three_fourth_first');

function three_fourth_last( $atts, $content = null ) {

	return "<div class=\"twelve columns omega\">".do_shortcode($content)."</div>";

}
add_shortcode('three_fourth_last','three_fourth_last');

function full_column( $atts, $content = null ) {

	return "<div class=\"sixteen columns\">".do_shortcode($content)."</div>";

}
add_shortcode('full','full_column');

function full_nested( $atts, $content = null ) {

	return "<div class=\"sixteen columns\" style=\"margin:0;\">".do_shortcode($content)."</div>";

}
add_shortcode('full_nested','full_nested');




/************************************************************************
* Responsive video
*************************************************************************/

function nzs_responsive_video($atts) {
$atts = extract(shortcode_atts(array(
	'video_url' => ''
	),$atts));

	if(isset($video_url)){

          $video_url = esc_url($video_url);


          if( 1 === preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$video_url , $matches)){

            	$video_url = 'http://www.youtube.com/embed/'.$matches[1];

            }elseif( 1 === preg_match('/vimeo.com\/(?:video\/)?([0-9]+)/', $video_url , $matches)){
              
            	$video_url = 'http://player.vimeo.com/video/'.$matches[1].'?title=0&amp;byline=0&amp;portrait=0';
            }

        

        if(!empty($video_url)):
        	$video = '';

       		$video .= '<div class="video-frame">';
 			$video .= '<div class="nzs-responsive-video">';
			$video .= '<iframe src="'.$video_url.'" width="400" height="300" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			$video .= '</div>';
			$video .= '</div>';

		endif;

		return $video;

	}

	
}

add_shortcode('video_box','nzs_responsive_video');


/************************************************************************
* Border Box
*************************************************************************/

function border_frame( $atts, $content = null ){
	return '<div class="img-frame">'.do_shortcode($content).'</div>';
}

add_shortcode('border_box','border_frame');

/************************************************************************
* Standard LI list
*************************************************************************/
function nzs_standard_list($atts,$content = null){
	$atts = extract(shortcode_atts(array(
	'list_type'=>''
	),$atts));
	
	$list = '';

	$list .= '<ul class="'.$list_type.'">';

	$list .= do_shortcode( $content );

	$list .= '</ul>';

	return $list;
}

function nzs_standard_list_li($atts,$content = null){
	
	return '<li>'.$content.'</li>';
}
add_shortcode( 'standard_list', 'nzs_standard_list' );
add_shortcode( 'standard_list_li', 'nzs_standard_list_li' );

/************************************************************************
* Font Icon list
*************************************************************************/

function nzs_icon_list($atts,$content = null){

	wp_enqueue_style( 'font-awesome' );
	
	$list = '';

	$list .= '<ul class="shortcode-list-icons">';

	$list .= do_shortcode( $content );

	$list .= '</ul>';

	return $list;
}

add_shortcode( 'icon_list', 'nzs_icon_list' );

/************************************************************************
* Font Icon list LI's
*************************************************************************/

function nzs_icon_list_li($atts,$content = null){
	$atts = extract(shortcode_atts(array(
	'icon'=>''
	),$atts));

	$icon = (isset($icon)) ? $icon : '';

	$list = '';

	$list .= '<li>';

	$list .= '<i class="'.$icon.'"></i>';

	$list .= do_shortcode( $content );

	$list .= '</li>';

	return $list;
}

add_shortcode( 'icon_list_li', 'nzs_icon_list_li' );

/************************************************************************
* Font Icon's
*************************************************************************/

function nzs_icon_font($atts,$content = null){
	$atts = extract(shortcode_atts(array(
	'icon'=>''
	),$atts));

	wp_enqueue_style( 'font-awesome' );

	return '<i class="shortcode-font-icon '.$icon.'"></i>';
}

add_shortcode( 'font_icon', 'nzs_icon_font' );


/************************************************************************
* LightBox
*************************************************************************/

function light_box($atts,$content = null){
	$atts = extract(shortcode_atts(array(
	'thumb_img'=>'',
	'full_img' => '',
	'align'=> 'left',
	'alt_text' => ''

	),$atts));

	$full_img = (!empty($full_img)) ? $full_img : $thumb_img;



	$string = sprintf('<a href="%1$s" rel="prettyPhoto"><img class="align%2$s img-frame" alt="%3$s" src="%4$s" /></a>',
		esc_attr($full_img),
		$align,
		esc_attr($alt_text),
		esc_attr($thumb_img));

	return $string;
}

add_shortcode( 'lightbox', 'light_box' );

/************************************************************************
* Slider
*************************************************************************/

function custom_slider($atts,$content = null) {

$atts = extract(shortcode_atts(array(
	'sub_heading'=>'',
	'heading' => ''

	),$atts));

	global $post;


	$link_up = '';

	preg_match('/full_img="([^"]+)"/', $content , $matched);



	if(isset($matched[1])){
	
		$link_up = $matched[1];

	}else{
		preg_match('/slide_img="([^"]+)"/', $content , $matched);

		$link_up = $matched[1];
	}


	$gallery = $post->post_name."-".$post->ID;

	$unq_id = rand(0,999);
	
	$slide = '';

	$slide .='<script type="text/javascript">';

	$slide .='jQuery(document).ready(function($) {';

	$slide .='$(".custom-slider-'.$unq_id.'").flexslider({';
	$slide .='	animation: "fade",';
	$slide .='	animationLoop: true,';
	$slide .='	directionNav: true,';
	$slide .='	controlNav: false,';
	$slide .='	slideshowSpeed: 3500';
	$slide .='});';
   
	$slide .='});';
				
	$slide .='</script>';

	$slide .='<div class="post-slider custom-slider-'.$unq_id.'">';
	$slide .='<div style="padding:3px;">';
	$slide .='<div class="image-wrapper">';
	$slide .='<ul class="slides">';
	$slide .= do_shortcode( $content );
	$slide .='</ul>';

	$slide .='<div class="mouse-effect"></div>';
	$slide .='<span class="extra-links">';
	$slide .='<a href="'.$link_up.'" rel="prettyPhoto['.$gallery.']" class="photo-up hide-text">View Images</a>';
	$slide .='</span>';
	$slide .='</div>';
	$slide .='</div>';

	$slide .='</div>';
	return $slide;

}

function custom_slides($atts,$content = null) {

	global $post;

	$gallery = $post->post_name."-".$post->ID;

$atts = extract(shortcode_atts(array(
	'title'=>'',
	'full_img'=>'',
	'slide_img'=>''

	),$atts));

	
	$full_img = (!empty($full_img)) ? $full_img : $slide_img;

	$slides = sprintf('<li><a href="%1s" title="%2$s" rel="prettyPhoto['.$gallery.']" class="img-preview"><img src="%3$s" alt="%2$s" class="scale-with-grid" /></a></li>',
				esc_attr($full_img),
				esc_attr($title),
				esc_attr($slide_img));


	return $slides;

	

}

add_shortcode('nzs_slider','custom_slider');
add_shortcode('nzs_slides','custom_slides');

/************************************************************************
* Title Bar / Headings
*************************************************************************/

function title_bar($atts) {
$atts = extract(shortcode_atts(array(
	'sub_heading'=>'',
	'heading' => ''

	),$atts));

	$str = "<div class=\"titleBar\"><span>".$sub_heading."</span><h2>".$heading."</h2></div>";
	return $str;

}
add_shortcode('title_bar','title_bar');

function heading_bar($atts, $content) {
$atts = extract(shortcode_atts(array(
	'heading' => '1'

	),$atts));

	$str = "<div class=\"heading\"><h".$heading.">".$content."</h".$heading."></div>";

	return $str;
}
add_shortcode('nzs_heading','heading_bar');

/************************************************************************
* Service
*************************************************************************/

function service_info( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'icon_url' => '',
	'title' => '',
	'link' =>''
	),$atts));


	if(!empty($link)){

		$servie_icon = '<a href="'.esc_url( $link ).'"><img src="'.$icon_url.'" alt="" class="scale-with-grid"></a>';

	}else{

		$servie_icon = '<img src="'.$icon_url.'" alt="" class="scale-with-grid">';
	}

	$service = '';

	$service .= '<div class="info">';
	$service .= $servie_icon;
	$service .= '<h5>'.$title.'</h5>';
	$service .= do_shortcode($content);
	$service .= '</div>';

	return $service;

}
add_shortcode('nzs_service','service_info');

/************************************************************************
* Social
*************************************************************************/

function social_code ($atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'pos' => '#',
	),$atts));

	global $smof_data;

	$twitter = $smof_data['nzs_social_twitter'];
	$facebook = $smof_data['nzs_social_facebook'];
	$google = $smof_data['nzs_social_google'];
	$flickr = $smof_data['nzs_social_flickr'];
	$linkedin = $smof_data['nzs_social_linkedin'];
	$pinterest = $smof_data['nzs_social_pinterest'];
	$dribbble = $smof_data['nzs_social_dribbble'];
	$deviantart = $smof_data['nzs_social_deviantart'];

	$youtube = $smof_data['nzs_social_youtube'];
	$vimeo = $smof_data['nzs_social_vimeo'];
	$instagram = $smof_data['nzs_social_instagram'];
	$email = $smof_data['nzs_social_email'];
	$soundcloud = $smof_data['nzs_social_soundcloud'];
	$behance = $smof_data['nzs_social_behance'];
	$ustream = $smof_data['nzs_social_ustream'];
	$rss = $smof_data['nzs_social_rss'];

	$target_window = $smof_data['nzs_social_target'];


	$links = '';

	$links .= '<ul class="social-links">';

	
	if(!empty($twitter)){
		$links .= '<li><a class="hide-text twitter" target="'.esc_attr($target_window).'" href="'.esc_html($twitter).'">'. __('Twitter','framework') .'</a></li>';
	}

	if(!empty($facebook)){
		$links .= '<li><a class="hide-text facebook" target="'.esc_attr($target_window).'" href="'.esc_html($facebook).'">'. __('Facebook','framework') .'</a></li>';
	}
	if(!empty($google)){
		$links .= '<li><a class="hide-text google" target="'.esc_attr($target_window).'" href="'.esc_html($google).'">'. __('Google','framework') .'</a></li>';
	}
	if(!empty($flickr)){
		$links .= '<li><a class="hide-text flickr" target="'.esc_attr($target_window).'" href="'.esc_html($flickr).'">'. __('Flickr','framework') .'</a></li>';
	}
	if(!empty($linkedin)){
		$links .= '<li><a class="hide-text linkedin" target="'.esc_attr($target_window).'" href="'.esc_html($linkedin).'">'. __('LinkedIn','framework') .'</a></li>';
	}
	if(!empty($pinterest)){
		$links .= '<li><a class="hide-text pinterest" target="'.esc_attr($target_window).'" href="'.esc_html($pinterest).'">'. __('Pinterest','framework') .'</a></li>';
	}
	if(!empty($dribbble)){
		$links .= '<li><a class="hide-text dribbble" target="'.esc_attr($target_window).'" href="'.esc_html($dribbble).'">'. __('Dribbble','framework') .'</a></li>';
	}
	if(!empty($deviantart)){
		$links .= '<li><a class="hide-text deviantart" target="'.esc_attr($target_window).'" href="'.esc_html($deviantart).'">'. __('DeviantArt','framework') .'</a></li>';
	}

	if(!empty($youtube)){
		$links .= '<li><a class="hide-text youtube" target="'.esc_attr($target_window).'" href="'.esc_html($youtube).'">'. __('Youtube','framework') .'</a></li>';
	}

	if(!empty($vimeo)){
		$links .= '<li><a class="hide-text vimeo" target="'.esc_attr($target_window).'" href="'.esc_html($vimeo).'">'. __('Vimeo','framework') .'</a></li>';
	}

	if(!empty($instagram)){
		$links .= '<li><a class="hide-text instagram" target="'.esc_attr($target_window).'" href="'.esc_html($instagram).'">'. __('Instagram','framework') .'</a></li>';
	}

	if(!empty($email)){
		$links .= '<li><a class="hide-text email" target="'.esc_attr($target_window).'" href="mailto:'.esc_html($email).'">'. __('Email','framework') .'</a></li>';
	}

	if(!empty($soundcloud)){
		$links .= '<li><a class="hide-text soundcloud" target="'.esc_attr($target_window).'" href="'.esc_html($soundcloud).'">'. __('Soundcloud','framework') .'</a></li>';
	}

	if(!empty($behance)){
		$links .= '<li><a class="hide-text behance" target="'.esc_attr($target_window).'" href="'.esc_html($behance).'">'. __('Behance','framework') .'</a></li>';
	}

	if(!empty($ustream)){
		$links .= '<li><a class="hide-text ustream" target="'.esc_attr($target_window).'" href="'.esc_html($ustream).'">'. __('Ustream','framework') .'</a></li>';
	}

	if(!empty($rss)){
		$links .= '<li><a class="hide-text rss" target="'.esc_attr($target_window).'" href="'.esc_html($rss).'">'. __('rss','framework') .'</a></li>';
	}

	$links .= '</ul>';
	

	return $links;

}

add_shortcode( 'social_links', 'social_code' );

/************************************************************************
* Button
*************************************************************************/

function color_button( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'url' => '#',
	'color' => 'main-btn',
	'target' => '_self'

	),$atts));

	return "<a href=\"".$url."\" target=\"".$target."\" class=\"color-btn ".$color."\">".$content."</a>";

}
add_shortcode('button','color_button');


/************************************************************************
* Member Info
*************************************************************************/


function member_info( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'position' => '',
	'firstname' => '',
	'lastname' => '',
	),$atts));
	
	$member_out = "";

	$member_out .= "<div class=\"name\">\n";
	$member_out .= "$firstname <span>$lastname</span>\n";
	$member_out .= "<em>$position</em>\n";
	$member_out .= "</div>\n";

	return $member_out;

}
add_shortcode('member_info','member_info');

/************************************************************************
* Clear
*************************************************************************/


function clear_float( $atts, $content = null ) {

	return "<div class=\"clear\"></div>";

}
add_shortcode('clear','clear_float');

/************************************************************************
* Portfolio
*************************************************************************/

function portfolio_show( $atts, $content = null ) {

	global $nzs_category,$smof_data,$gallery_count;

	$atts = extract(shortcode_atts(array(
	'nzs_category' => ''
	),$atts));

	
	if(!isset($gallery_count)){
		$gallery_count = 3425;
	}

	if(!empty($nzs_category) && 'all' != $nzs_category){
		$nzs_category = $nzs_category;

		$portfolio_file = "portfolio.php";

	}else{
		$nzs_category = '';

		if(0 == $smof_data['nzs_iso_portfolio_option']){

			$portfolio_file = "iso-filtered-portfolio.php";

		}else{

			$portfolio_file = "filtered-portfolio.php";
		}
	}
	
	ob_start();	
	locate_template('/assets/php/'.$portfolio_file, true, false);
	$content = ob_get_clean();
	$gallery_count++;
    return $content;

}
add_shortcode('portfolio','portfolio_show');

/************************************************************************
* Recent Works
*************************************************************************/

function recent_works_show( $atts, $content = null ) {

	global $nzs_category,$smof_data,$works_count;

	$atts = extract(shortcode_atts(array(
	'nzs_category' => ''
	),$atts));

	
	if(!isset($works_count)){
		$works_count = 3525;
	}

	if(!empty($nzs_category) && 'all' != $nzs_category){
		$nzs_category = $nzs_category;

	}else{

		$nzs_category = '';

	}
	
	ob_start();	
	locate_template('/assets/php/recent-works.php', true, false);
	$content = ob_get_clean();
	$works_count++;
    return $content;

}
add_shortcode('recent_works','recent_works_show');

/************************************************************************
* Blog
*************************************************************************/


function blog_show( $atts, $content = null ) {
	global $smof_data;

	if(isset($smof_data['nzs_blog_page_layout'])){
		switch ($smof_data['nzs_blog_page_layout']) {
			case '2cr':
				$blog_file = 'blog-front.php';
				break;

				case '1c':
				$blog_file = 'blog-front-full.php';
				break;

				case '2cl':
				$blog_file = 'blog-front-left.php';
				break;
			
			default:
				$blog_file = 'blog-front.php';
				break;
		}
	}else{
		$blog_file = 'blog-front.php';
	}
	
	ob_start();	
	locate_template('/assets/php/'.$blog_file, true , false);
	$content = ob_get_clean();

    return $content;

}
add_shortcode('blog','blog_show');

/************************************************************************
* Team
*************************************************************************/

function team_show( $atts, $content = null ) {

	global $nzs_category;

	$atts = extract(shortcode_atts(array(
	'nzs_category' => ''
	),$atts));


	if(!empty($nzs_category) && 'all' != $nzs_category){
		
		$nzs_category = $nzs_category;

	}else{

		$nzs_category = '';

	}


	ob_start();	
	locate_template('/assets/php/team-members.php', true, false);
	$content = ob_get_clean();
    return $content;

}
add_shortcode('team','team_show');

/************************************************************************
* Pricing Table
*************************************************************************/

function pricing_table( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'position' => '',
	'firstname' => '',
	'lastname' => '',
	),$atts));

		$table = '';

		$table .='<ul class="pricing-table">';
		
		$table .= do_shortcode($content);

		$table .='</ul>';

		return $table;

	}

function pricing_plan( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'featured' => '',
	'first_word' => '',
	'last_word' => 'Plan',
	'link' => '#',
	'btn_text' => 'Sign Up!'
	),$atts));

		$table = '';

		$table .='<li>';
		$table .='<ul class="plan '.$featured.'">';

		$table .='<li class="plan-head">'.$first_word.' <span>'.$last_word.'</span>';
		$table .= '</li>';
		
		$table .= do_shortcode($content);

		$table .= '<li class="order-btn">';
		$table .= '<a href="'.$link.'" class="color-btn main-btn">'.$btn_text.'</a>';

		if('best' == $featured){
			$table .= '<img alt="" src="'.get_template_directory_uri().'/assets/img/theme/best.png">';
		}

		$table .= '</li>';

		$table .='</ul>';
		$table .='</li>';

		return $table;

	}

function pricing_option( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'position' => '',
	'firstname' => '',
	'lastname' => '',
	),$atts));


	return '<li>'.$content.'</li>';



	}

add_shortcode('price_table','pricing_table');
add_shortcode('price_plan','pricing_plan');
add_shortcode('price_option','pricing_option');

/************************************************************************
* Contact Form
*************************************************************************/


function show_contact_form( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'email_label' => 'Email',
	'name_label' => 'Name',
	'message_label' => 'Message',
	'btn_label' => 'Submit',
	),$atts));


	$contact_form_message = array(
			'nzs_required_name' => __('This field is required.','framework'),
			'nzs_required_email' => __('This field is required.','framework'),
			'nzs_valid_email' => __('Please enter a valid email address.','framework'),
			'nzs_required_message' => __('Please enter a message','framework'),
		);


	$contact_form_message = apply_filters('nzs_contact_form_messages', $contact_form_message);

	wp_enqueue_script('form-custom');
	wp_enqueue_script('form-validate');
	wp_enqueue_script('nzs-contact-form');
	wp_localize_script('nzs-contact-form', 'nzs_contact_vars', $contact_form_message);


	if(empty($email_label)){
		$email_label = 'Email';
	}
	if(empty($name_label)){
		$name_label = 'Name';
	}
	if(empty($message_label)){
		$message_label = 'Message';
	}
	if(empty($btn_label)){
		$btn_label = 'Send';
	}

	$form = '';

 	$form .= '<div class="contact-area">';
	$form .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="contactForm">';
	$form .= '<label class="first" for="name">'.$name_label.'</label>';
	$form .= '<input type="text" id="name" name="name" class="required" />';
	$form .= wp_nonce_field('contact_form','nzs_contact_nonce',true,false);
	$form .= '<label for="cemail">'.$email_label.'</label>';
	$form .= '<input type="text" id="cemail" name="email" class="required email" />';
	$form .= '<label for="message">'.$message_label.'</label>';
	$form .= '<textarea id="message" name="message" class="required" cols="90" rows="5"></textarea>';
	$form .= '<button class="color-btn main-btn" type="submit">'.$btn_label.'</button>';
	$form .= '</form>';
	$form .= '<div class="successMessage" style="text-align:center; padding:30px 0;"></div>';
	$form .= '</div>';

	return $form;


}

add_shortcode('nzs_contact_form','show_contact_form');


/************************************************************************
* Contact Info
*************************************************************************/

function show_contact_info( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'name' => '',
	'phone' => '',
	'address' => '',
	'email' => '',
	),$atts));



	$info = '';

	$info .='<ul class="contact-info">';

	if(!empty($name)){
		$info .='<li class="name">'.$name.'</li>';
	}

	if(!empty($phone)){
		$info .='<li class="phone">'.$phone.'</li>';
	}
	
	if(!empty($address)){
		$info .='<li class="address">'.$address.'</li>';
	}
	
	if(!empty($email)){
		$info .='<li class="email"><a href="mailto:'.esc_attr($email).'">'.$email.'</a></li>';
	}
	
	
	$info .='</ul>';

	return $info;



}

add_shortcode('contact_info','show_contact_info');

/************************************************************************
* Padding Box
*************************************************************************/

function add_padding( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'left' => '',
	'right' => '',
	'top' => '',
	'bottom' => '',
	),$atts));


	$left = (preg_match('/^([0-9]+)$/', $left)) ? $left : '0';
	$right = (preg_match('/^([0-9]+)$/', $right)) ? $right : '0';
	$top = (preg_match('/^([0-9]+)$/', $top)) ? $top : '0';
	$bottom = (preg_match('/^([0-9]+)$/', $bottom)) ? $bottom : '0';


	return '<div class="custom-padding-box clearfix" style="padding:'.$top.'px '.$right.'px '.$bottom.'px '.$left.'px;">'.do_shortcode( $content ).'</div>';



}

add_shortcode('padding_box','add_padding');


function year_code( $atts, $content = null ){

	return date("Y");

}
add_shortcode('the-year', 'year_code');


function theme_link( $atts, $content = null ){

	$link = '<a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo('name').'</a>';

	return $link;
	
}
add_shortcode('theme-link', 'theme_link');

function linked_code( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title' => ''
	),$atts));

	return '<a href="'.esc_attr($content).'">'.$title.'</a>';
}

add_shortcode( 'link', 'linked_code');

?>