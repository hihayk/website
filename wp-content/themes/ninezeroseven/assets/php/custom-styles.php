<?php
/**
 * Load Custom Page Section Styles
 */
global $smof_data;


function generate_custom_css(){

		$gen = '';

		$gen .= custom_css();

		$gen .= body_font();
		$gen .= link_style();
		$gen .= heading_font();

		$gen .= parallax_css();

		$gen .= nzs_custom_nav_css();

		$gen .= alternate_backgrounds();

		$gen .= recent_works();
		$gen .= portfolio_style();
		$gen .= blog_style();
		$gen .= team_style();

		$gen .= footer_style();

		$gen .= user_custom_css();

		$gen .= parallax_h_style();

		$gen .= button_style();

		$gen .= overlay_css();

		$gen .= header_heading_font();

		$gen .= video_header_styles();



		if(!empty($gen)){

			$wrap_css ='';

			$wrap_css .="\n<!-- CUSTOM PAGE SECTIONS STYLE -->\n";
			$wrap_css .="<style type=\"text/css\">\n";

			$wrap_css .= $gen;

			$wrap_css .="\n\n</style>\n<!-- END CUSTOM PAGE SECTIONS STYLE -->\n\n";

			echo $wrap_css;

		}




}

add_action('wp_head','generate_custom_css'); 


function header_heading_font(){

	global $smof_data;

	if(isset($smof_data['nzs_header_options'])){

		$css_return = '';

		switch ($smof_data['nzs_header_options']) {

			case 'parallax':

				if(!empty($smof_data['nzs_heading_font_parallax'])){

					$css_return .= ".entry .message h2{";
					$css_return .= "color:".$smof_data['nzs_heading_font_parallax'].";";
					$css_return .= "border-color:".$smof_data['nzs_heading_font_parallax'].";";
					$css_return .= "}";


				}

				if(!empty($smof_data['nzs_desc_font_parallax'])){

					$css_return .= ".entry .message p{";
					$css_return .= "color:".$smof_data['nzs_desc_font_parallax'].";";
					$css_return .= "}";


				} 

				return $css_return;

				break;

			case 'fullscreen':
				
				if(!empty($smof_data['nzs_heading_font_fullscreen'])){

					$css_return .= ".entry .message h2{";
					$css_return .= "color:".$smof_data['nzs_heading_font_fullscreen'].";";
					$css_return .= "border-color:".$smof_data['nzs_heading_font_fullscreen'].";";
					$css_return .= "}";


				}

				if(!empty($smof_data['nzs_desc_font_fullscreen'])){

					$css_return .= ".entry .message p{";
					$css_return .= "color:".$smof_data['nzs_desc_font_fullscreen'].";";
					$css_return .= "}";


				} 

				return $css_return;
				
				break;

			case 'video-header':

				if(0 == $smof_data['nzs_full_video_type']){

					if(!empty($smof_data['nzs_heading_font_youtube'])){

					$css_return .= ".video-header-content .message h2{";
					$css_return .= "color:".$smof_data['nzs_heading_font_youtube'].";";
					$css_return .= "border-color:".$smof_data['nzs_heading_font_youtube'].";";
					$css_return .= "}";


					}

					if(!empty($smof_data['nzs_desc_font_youtube'])){

						$css_return .= ".video-header-content .message p{";
						$css_return .= "color:".$smof_data['nzs_desc_font_youtube'].";";
						$css_return .= "}";


					} 

				}else{

					if(!empty($smof_data['nzs_heading_font_vimeo'])){

					$css_return .= ".video-header-content .message h2{";
					$css_return .= "color:".$smof_data['nzs_heading_font_vimeo'].";";
					$css_return .= "border-color:".$smof_data['nzs_heading_font_vimeo'].";";
					$css_return .= "}";


					}

					if(!empty($smof_data['nzs_desc_font_vimeo'])){

						$css_return .= ".video-header-content .message p{";
						$css_return .= "color:".$smof_data['nzs_desc_font_vimeo'].";";
						$css_return .= "}";


					} 
				}
			
				

			return $css_return;
			
			break;

			case 'flexslider':
				
				if(!empty($smof_data['nzs_heading_font_flexslider'])){

					$css_return .= ".headerContent .flex-content h4{";
					$css_return .= "color:".$smof_data['nzs_heading_font_flexslider'].";";
					$css_return .= "}";


				}

				if(!empty($smof_data['nzs_desc_font_flexslider'])){



					$css_return .= ".headerContent .flex-content{";
					$css_return .= "color:".$smof_data['nzs_desc_font_flexslider'].";";
					$css_return .= "}";


				}

				if(!empty($smof_data['nzs_frame_flexslider'])){

					$css_return .= ".mainSlider{";
					$css_return .= "background-color:".$smof_data['nzs_frame_flexslider'].";";
					$css_return .= "}";

					$css_return .= ".mainSlider .flex-viewport{";
					$css_return .= "border-color:".$smof_data['nzs_frame_flexslider'].";";
					$css_return .= "}";




				} 


				if(!empty($smof_data['nzs_flex_slider_bg_image'])){

					$css_return .= ".headerContent{";
					$css_return .= "background:url('".$smof_data['nzs_flex_slider_bg_image']."') repeat;";
					$css_return .= "}";


				} 

 

				return $css_return;
				
				break;


				case 'customheader':


				if(!empty($smof_data['nzs_custom_slider_bg_image'])){


					if(!empty($smof_data['nzs_custom_bg_repeat'])){
						$bg_repeat = $smof_data['nzs_custom_bg_repeat'];
					}else{
						$bg_repeat = 'repeat';
					}

					$css_return .= ".custom-header-option{";
					$css_return .= "background:url('".$smof_data['nzs_custom_slider_bg_image']."') ".$bg_repeat.";";
					$css_return .= "}";


				} 
 
 

				return $css_return;
				
				break;
			
			default:
				return;
			break;
		}

	}

}

function parallax_css(){

	global $post;

	$temp_query = $post;

	$page_section_query = new WP_Query( array( 'post_type' => 'parallax-sections', 'posts_per_page' => -1, 'order' => 'ASC' ) ); 
		
		$css_out = '';
		$css_out .="\n/* PARALLAX CSS \n============================== */\n";

		if($page_section_query->have_posts()): while($page_section_query->have_posts()) : $page_section_query->the_post();

			$parallax_style_image = get_post_meta(get_the_ID(), 'nzs_parallax_bg_image', TRUE);

			$parallax_style_color = get_post_meta(get_the_ID(), 'nzs_parallax_bg_color', TRUE);

			$parallax_heading_color = get_post_meta(get_the_ID(), 'nzs_parallax_tb_h_color', TRUE);
			$parallax_sub_heading_color = get_post_meta(get_the_ID(), 'nzs_parallax_tb_sh_color', TRUE);

			$parallax_h_color = get_post_meta(get_the_ID(), 'nzs_parallax_h_color', TRUE);

			$parallax_font_color = get_post_meta(get_the_ID(), 'nzs_parallax_font_color', TRUE);

			$parallax_link_color = get_post_meta(get_the_ID(), 'nzs_parallax_link_color', TRUE);
			$parallax_hover_color = get_post_meta(get_the_ID(), 'nzs_parallax_link_hover_color', TRUE);


			$parallax_repeat = get_post_meta(get_the_ID(), 'nzs_parallax_repeat', TRUE);
			$parallax_size = get_post_meta(get_the_ID(), 'nzs_parallax_size', TRUE);
			
			

			$parallax_class = ".".get_post_type()."-".get_the_ID();
			$parallax_id = "#".get_post_type()."-".get_the_ID();

			if(!empty($parallax_font_color)){
				$css_out .= $parallax_class.",".$parallax_class." .message{\n\t";
			
				$css_out .= "color:".$parallax_font_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($parallax_heading_color)){
				$css_out .= $parallax_class." .titleBar h2{\n\t";
			
				$css_out .= "color:".$parallax_heading_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($parallax_sub_heading_color)){
				$css_out .= $parallax_class." .titleBar span{\n\t";
			
				$css_out .= "color:".$parallax_sub_heading_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($parallax_link_color)){
				$css_out .= $parallax_class." a,".$parallax_class." a:visited{\n\t";
			
				$css_out .= "color:".$parallax_link_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($parallax_hover_color)){
				$css_out .= $parallax_class." a:hover,".$parallax_class." a:focus{\n\t";
			
				$css_out .= "color:".$parallax_hover_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($parallax_h_color)){
				$css_out .= $parallax_class." h1,".$parallax_class." h2,".$parallax_class." h3,".$parallax_class." h4,".$parallax_class." h5,".$parallax_class." h6{\n\t";
			
				$css_out .= "color:".$parallax_h_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($parallax_size) && "500px" != $parallax_size){
				$css_out .= $parallax_class."{\n\t";
			
				$css_out .= "height:".$parallax_size.";\n";
				$css_out .= "}\n";
			}


			if(!empty($parallax_style_image) || !empty($parallax_style_color)){


				if(!empty($parallax_repeat) && 'none' != $parallax_repeat && 'cover' != $parallax_repeat){
					$repeat = $parallax_repeat;
				}else{
					$repeat = 'repeat';
				}

				$css_out .= $parallax_id."{\n";
			
			if(!empty($parallax_style_image)){
				$css_out .= "\tbackground:url(\"".$parallax_style_image."\") ".$repeat." 50% -3px fixed transparent;\n";
			}

			if(!empty($parallax_repeat) && 'cover' == $parallax_repeat){
				$css_out .= "\tbackground-size: cover !important; \n";
			}

			if(!empty($parallax_style_color) && empty($parallax_style_image)){
				$css_out .= "\tbackground-image: none !important; \n";
				$css_out .= "\tbackground-color:".$parallax_style_color.";\n";
			}
				$css_out .= "}\n";
			}
			
			endwhile;

			$post = $temp_query;

			return $css_out."\n\n";
	
	endif;

}

function nzs_custom_nav_css(){
	global $smof_data;

	$custom_logo = $smof_data['nzs_logo'];

	$custom_nav_bg_image = $smof_data['nzs_nav_bg_image'];

	$custom_logo_width = $smof_data['nzs_logo_width'];
	$custom_logo_height = $smof_data['nzs_logo_height'];


	$custom_nav_bg_color = $smof_data['nzs_nav_bg_color'];
	$custom_nav_border_color = $smof_data['nzs_nav_border_color'];
	$custom_nav_link_color = $smof_data['nzs_nav_link_color'];
	$custom_nav_link_hover = $smof_data['nzs_nav_link_hover'];

	$sub_bg_color = $smof_data['nzs_nav_subbg'];
	$sub_bg_hover_color = $smof_data['nzs_nav_subbg_hover'];
	$sub_border_color = $smof_data['nzs_nav_subborder'];
	$menu_font_face_css = $smof_data['nzs_menu_face_font'];


	$mobile_bg_color = $smof_data['nzs_mobile_bg_color'];
	$mobile_icon = $smof_data['nzs_mobile_icon'];
	$mobile_icon_active = $smof_data['nzs_mobile_icon_open'];


	$nav_css = "";


	if(isset($mobile_bg_color) && !empty($mobile_bg_color)){

		$nav_css .= "nav.mainMenu.mobile-show{\n";
		$nav_css .= "\tbackground-color:".$mobile_bg_color.";";
		$nav_css .= "\n}\n\n";

	}

	if(isset($mobile_icon) && !empty($mobile_icon)){

		$nav_css .= ".nzs-mobile-menu span.mobile-toggle-menu{\n";
		$nav_css .= "\tcolor:".$mobile_icon.";";
		$nav_css .= "\n}\n\n";

	}

	if(isset($mobile_icon_active) && !empty($mobile_icon_active)){

		$nav_css .= ".nzs-mobile-menu span.mobile-toggle-menu.mobile-open{\n";
		$nav_css .= "\tcolor:".$mobile_icon_active.";";
		$nav_css .= "\n}\n\n";

	}


	if($menu_font_face_css['face'] != 'Oswald' || $menu_font_face_css['size'] != '15px'){

		$menu_add = "";

		if($menu_font_face_css['face'] != 'Oswald'){
			$menu_add .= "\tfont-family:".$menu_font_face_css['face'].",helvetica,arial,sans-serif;\n";
		}

		if($menu_font_face_css['size'] != '15px'){
			$menu_add .= "\tfont-size:".$menu_font_face_css['size'].";\n";
		}


		$nav_css .= "nav.mainMenu ul li a{\n";
		$nav_css .= $menu_add;
		$nav_css .= "\n}\n\n";

	}


	if(empty($custom_nav_bg_image) && !empty($custom_nav_bg_color)){
		$nav_css .= ".topBar{\n";
		$nav_css .= "\tbackground-color:".$custom_nav_bg_color.";";
		$nav_css .= "\n\tbackground-image:none;\n";
		if(!empty($custom_nav_border_color)){
			$nav_css .= "\tborder-color:".$custom_nav_border_color.";\n";
		}
		$nav_css .= "}\n";
	}

	if(empty($custom_nav_bg_color) && !empty($custom_nav_bg_image)){
		$nav_css .= ".topBar{\n";
		$nav_css .= "\tbackground:url('".$custom_nav_bg_image."');";
		if(!empty($custom_nav_border_color)){
			$nav_css .= "\tborder-color:".$custom_nav_border_color.";\n";
		}
		$nav_css .= "}\n";
	}

	if(!empty($custom_nav_bg_color) && !empty($custom_nav_bg_image)){
		$nav_css .= ".topBar{\n";
		$nav_css .= "\tbackground:url('".$custom_nav_bg_image."') ".$custom_nav_bg_color.";\n";
		if(!empty($custom_nav_border_color)){
			$nav_css .= "\tborder-color:".$custom_nav_border_color.";\n";
		}
		$nav_css .= "}\n";
	}

	if(!empty($custom_nav_link_color)){
		$nav_css .= "nav.mainMenu ul li a{\n";
		$nav_css .= "\tcolor:".$custom_nav_link_color.";\n";
		$nav_css .= "}\n";
	}
	if(!empty($custom_nav_link_hover)){
		$nav_css .= "nav.mainMenu ul li > a:hover,nav.mainMenu ul li.active > a{\n";
		$nav_css .= "\tcolor:".$custom_nav_link_hover.";\n";
		$nav_css .= "}\n";
	}

	if(!empty($custom_logo)){

		$nav_css .= ".topBar h1.hide-text{\n";
		$nav_css .= "\tbackground:url('".$custom_logo."') no-repeat top left;\n";

		if(!empty($custom_logo_width)){
		$nav_css .= "\twidth:".$custom_logo_width."px;\n";
		}

		if(!empty($custom_logo_height)){
		$nav_css .= "\theight:".$custom_logo_height."px;\n";
		}



		$nav_css .= "}\n\n";
	}

	if(!empty($sub_bg_color)){
		$nav_css .= "nav.mainMenu ul li ul li{\n";
		$nav_css .= "\tbackground-color:".$sub_bg_color.";";
		if(!empty($sub_border_color)){
			$nav_css .= "\tborder-color:".$sub_border_color.";\n";
		}
		$nav_css .= "}\n";
	}

	if(!empty($sub_bg_hover_color)){
		$nav_css .= "nav.mainMenu ul li ul li:hover{\n";
		$nav_css .= "\tbackground-color:".$sub_bg_hover_color.";";
		$nav_css .= "}\n";
	}

	
	

	return $nav_css;
}


function overlay_css(){
	global $smof_data;

	$image_overlay = $smof_data['nzs_overlay_color'];
	$bg_icon_color = $smof_data['nzs_bg_icon_color'];

	$overlay = '';


	if(!empty($image_overlay)){

		$overlay .= '.image-wrapper .mouse-effect{'."\n";

		$overlay .= "\t".'background-color:'.$image_overlay.';'."\n";

		$overlay .= '}'."\n\n";

	}

	if(!empty($bg_icon_color)){

		$overlay .= '.image-wrapper a.photo-up, .image-wrapper a.go-link, .image-wrapper a.web-link{'."\n";

		$overlay .= "\t".'background-color:'.$bg_icon_color.';'."\n";

		$overlay .= '}'."\n\n";

	}


	return $overlay;



}


function recent_works(){
	global $smof_data;

	$frame_bg = $smof_data['nzs_working_frame_bg'];
	$heading_font = $smof_data['nzs_works_heading']; 
	$desc_font = $smof_data['nzs_works_desc'];

	$css = '';

	if(!empty($frame_bg)){

		$css .= '.project .img-frame{'.
				'background-color:'.$frame_bg.';'.
				'}';

	}

	if(!empty($heading_font['color']) || $heading_font['size'] !== '12px'){

		$font_size = "";

		if($heading_font['size'] !== '12px'){
			$font_size = 'font-size:'.$heading_font['size'].';';
		}

		$css .= '.project .img-frame h5{'.
				'color:'.$heading_font['color'].';'.
				$font_size.
				'}';

	}

	if(!empty($desc_font['color']) || $desc_font['size'] !== '12px'){

		$font_size = "";

		if($desc_font['size'] !== '12px'){
			$font_size = 'font-size:'.$desc_font['size'].';';
		}

		$css .= '.project .img-frame p{'.
				'color:'.$desc_font['color'].';'.
				$font_size.
				'}';

	}

	return $css;


}

function team_style(){
	global $smof_data;

	$frame_bg = $smof_data['nzs_team_frame_bg'];
	$frame_hover_bg = $smof_data['nzs_team_hover_bg'];


	$position_font = $smof_data['nzs_team_position']; 

	$team_name_font = $smof_data['nzs_team_name'];

	$team_last_name_font = $smof_data['nzs_team_name_last'];

	$desc_font = $smof_data['nzs_team_desc'];

	$css = '';

	if(!empty($frame_bg)){

		$css .= '.team .img-wrap{'.
				'background-color:'.$frame_bg.';'.
				'}';

	}

	if(!empty($frame_hover_bg)){

		$css .= 'ul.team li .img-wrap:hover{'.
				'background-color:'.$frame_hover_bg.';'.
				'}';

	}

	if(!empty($position_font['color']) || $position_font['size'] !== '12px'){

		$font_pos_size = "";

		if($position_font['size'] !== '12px'){
			$font_pos_size = 'font-size:'.$position_font['size'].';';
		}

		$css .= 'ul.team li .name em{'.
				'color:'.$position_font['color'].';'.
				$font_pos_size.
				'}';

	}

	if(!empty($team_name_font['color']) || $team_name_font['size'] !== '12px'){

		$font_name_size = "";

		if($team_name_font['size'] !== '12px'){
			$font_name_size = 'font-size:'.$team_name_font['size'].';';
		}

		$css .= 'ul.team li .name{'.
				'color:'.$team_name_font['color'].';'.
				$font_name_size.
				'}';

	}

	if(!empty($team_last_name_font)){

		$css .= 'ul.team li .name span{'.
				'color:'.$team_last_name_font.';'.
				'}';

	}

	if(!empty($desc_font['color']) || $desc_font['size'] !== '12px'){

		$font_size = "";

		if($desc_font['size'] !== '12px'){
			$font_size = 'font-size:'.$desc_font['size'].';';
		}

		$css .= '.team p{'.
				'color:'.$desc_font['color'].';'.
				$font_size.
				'line-height:1.2em;'.
				'}';

	}

	return $css;


}


function portfolio_style(){
	global $smof_data;

	$frame_bg = $smof_data['nzs_portfolio_frame_bg'];
	$heading_font = $smof_data['nzs_portfolio_heading']; 
	$desc_font = $smof_data['nzs_portfolio_desc'];

	$css = '';

	if(!empty($frame_bg)){

		$css .= '.portfolio-layout .img-frame{'.
				'background-color:'.$frame_bg.';'.
				'}';

	}

	if(!empty($heading_font['color']) || $heading_font['size'] !== '12px'){

		$font_size = "";

		if($heading_font['size'] !== '12px'){
			$font_size = 'font-size:'.$heading_font['size'].';';
		}

		$css .= '.portfolio-layout .img-frame h5{'.
				'color:'.$heading_font['color'].';'.
				$font_size.
				'}';

	}

	if(!empty($desc_font['color']) || $desc_font['size'] !== '12px'){

		$font_size = "";

		if($desc_font['size'] !== '12px'){
			$font_size = 'font-size:'.$desc_font['size'].';';
		}

		$css .= '.portfolio-layout .img-frame p{'.
				'color:'.$desc_font['color'].';'.
				$font_size.
				'}';

	}

	return $css;


}


function blog_style(){
	global $smof_data;

	$frame_bg = $smof_data['nzs_blog_frame_bg'];
	$heading_font = $smof_data['nzs_blog_heading']; 
	$desc_font = $smof_data['nzs_blog_desc'];

	$link_font = $smof_data['nzs_blog_link'];
	$link_hover_font = $smof_data['nzs_blog_hover_link'];

	$desc_widget_font = $smof_data['nzs_widget_desc'];


	$desc_meta_font = $smof_data['nzs_meta_desc'];

	$heading_widget_font = $smof_data['nzs_widget_heading']; 

	$css = '';

	if(!empty($frame_bg)){

		$css .= '.posts .img-frame, .sidebar .img-frame{'.
				'background-color:'.$frame_bg.';'.
				'}';

	}

	if(!empty($heading_font['color']) || $heading_font['size'] !== '12px'){

		$font_size = "";

		if($heading_font['size'] !== '12px'){
			$font_size = 'font-size:'.$heading_font['size'].';';
		}

		$css .= '.posts h4 a,.posts h4{'.
				'color:'.$heading_font['color'].';'.
				$font_size.
				'}';

	}

	if(!empty($desc_font['color']) || $desc_font['size'] !== '12px'){

		$font_body_size = "";

		if($desc_font['size'] !== '12px'){
			$font_body_size = 'font-size:'.$desc_font['size'].';';
		}

		$css .= '.posts p{'.
				'color:'.$desc_font['color'].';'.
				$font_body_size.
				'}';

	}

	if(!empty($link_font)){

		$css .= '.posts a, .sidebar a{'.
				'color:'.$link_font.';'.
				'}';

	}

	if(!empty($link_hover_font)){

		$css .= '.posts a:hover, .sidebar a:hover{'.
				'color:'.$link_hover_font.';'.
				'}';

	}

	if($desc_meta_font['size'] != '10px' || $desc_meta_font['color'] != '' ){

		$font_meta_size = "";

		if($desc_meta_font['size'] !== '10px'){
			$font_meta_size = 'font-size:'.$desc_meta_font['size'].';';
		}

		$css .= '.post .meta ul li{'.
				'color:'.$desc_meta_font['color'].';'.
				$font_meta_size.
				'}';

	}


	if(!empty($heading_widget_font['color']) || $heading_widget_font['size'] !== '12px'){

		$font_widget_size = "";

		if($heading_widget_font['size'] !== '12px'){
			$font_widget_size = 'font-size:'.$heading_widget_font['size'].';';
		}

		$css .= '.sidebar h5{'.
				'color:'.$heading_widget_font['color'].';'.
				$font_widget_size.
				'}';

	}


	if(!empty($desc_widget_font['color']) || $desc_widget_font['size'] !== '12px'){

		$font_widget_desc_size = "";

		if($desc_widget_font['size'] !== '12px'){
			$font_widget_desc_size = 'font-size:'.$desc_widget_font['size'].';';
		}

		$css .= '.sidebar li,.widget p{'.
				'color:'.$desc_widget_font['color'].';'.
				$font_widget_desc_size.
				'}';

	}

	return $css;


}


function alternate_backgrounds(){
	global $smof_data;

	$bg_custom1 = $smof_data['nzs_alternate_bg1_color'];
	$bg_custom1_image = $smof_data['nzs_alternate_bg1'];

	$bg_custom2 = $smof_data['nzs_alternate_bg2_color'];
	$bg_custom2_image = $smof_data['nzs_alternate_bg2'];

	$css = '';

	if(!empty($bg_custom1) && empty($bg_custom1_image)){
		$css .= '.alternate-bg1,'.
		'.alternate-bg1 .titleBar h2,'.
		'.alternate-bg1 .heading h1,'.
		'.alternate-bg1 .heading h2,'.
		'.alternate-bg1 .heading h3,'.
		'.alternate-bg1 .heading h4,'.
		'.alternate-bg1 .heading h5,'.
		'.alternate-bg1 .heading h6{'.
			'background-color:'.$bg_custom1.';'.
			'background-image:none;'.
		'}';

	}

	if(!empty($bg_custom1_image)){
		$css .= '.alternate-bg1,'.
		'.alternate-bg1 .titleBar h2,'.
		'.alternate-bg1 .heading h1,'.
		'.alternate-bg1 .heading h2,'.
		'.alternate-bg1 .heading h3,'.
		'.alternate-bg1 .heading h4,'.
		'.alternate-bg1 .heading h5,'.
		'.alternate-bg1 .heading h6{'.
			'background:url("'.$bg_custom1_image.'");'.
		'}';

	}

	if(!empty($bg_custom2) && empty($bg_custom2_image)){
		$css .= '.alternate-bg2,'.
		'.alternate-bg2 .titleBar h2,'.
		'.alternate-bg2 .heading h1,'.
		'.alternate-bg2 .heading h2,'.
		'.alternate-bg2 .heading h3,'.
		'.alternate-bg2 .heading h4,'.
		'.alternate-bg2 .heading h5,'.
		'.alternate-bg2 .heading h6{'.
			'background-color:'.$bg_custom2.';'.
			'background-image:none;'.
		'}';

	}

	if(!empty($bg_custom2_image)){
		$css .= '.alternate-bg2,'.
		'.alternate-bg2 .titleBar h2,'.
		'.alternate-bg2 .heading h1,'.
		'.alternate-bg2 .heading h2,'.
		'.alternate-bg2 .heading h3,'.
		'.alternate-bg2 .heading h4,'.
		'.alternate-bg2 .heading h5,'.
		'.alternate-bg2 .heading h6{'.
			'background:url("'.$bg_custom2_image.'");'.
		'}';

	}


	return $css;


}

function custom_css(){

	global $post;

	$temp_query = $post;

	$page_section_query = new WP_Query( array( 'post_type' => 'page-sections', 'posts_per_page' => -1, 'order' => 'ASC' ) ); 
		
		$css_out = '';

		if($page_section_query->have_posts()): while($page_section_query->have_posts()) : $page_section_query->the_post();

			$section_style_image = get_post_meta(get_the_ID(), 'nzs_section_bg_image', TRUE);

			$section_style_color = get_post_meta(get_the_ID(), 'nzs_section_bg_color', TRUE);

			$section_heading_color = get_post_meta(get_the_ID(), 'nzs_section_tb_h_color', TRUE);
			$section_sub_heading_color = get_post_meta(get_the_ID(), 'nzs_section_tb_sh_color', TRUE);

			$section_h_color = get_post_meta(get_the_ID(), 'nzs_section_h_color', TRUE);

			$section_font_color = get_post_meta(get_the_ID(), 'nzs_section_font_color', TRUE);

			$section_link_color = get_post_meta(get_the_ID(), 'nzs_section_link_color', TRUE);
			$section_hover_color = get_post_meta(get_the_ID(), 'nzs_section_link_hover_color', TRUE);
			
			

			$section_class = ".".get_post_type()."-".get_the_ID();

			if(!empty($section_font_color)){
				$css_out .= $section_class."{\n\t";
			
				$css_out .= "color:".$section_font_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($section_heading_color)){
				$css_out .= $section_class." .titleBar h2{\n\t";
			
				$css_out .= "color:".$section_heading_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($section_sub_heading_color)){
				$css_out .= $section_class." .titleBar span{\n\t";
			
				$css_out .= "color:".$section_sub_heading_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($section_link_color)){
				$css_out .= $section_class." a,".$section_class." a:visited{\n\t";
			
				$css_out .= "color:".$section_link_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($section_hover_color)){
				$css_out .= $section_class." a:hover,".$section_class." a:focus{\n\t";
			
				$css_out .= "color:".$section_hover_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($section_h_color)){
				$css_out .= $section_class." h1,".$section_class." h2,".$section_class." h3,".$section_class." h4,".$section_class." h5,".$section_class." h6{\n\t";
			
				$css_out .= "color:".$section_h_color.";\n";
				$css_out .= "}\n";
			}

			if(!empty($section_style_image) || !empty($section_style_color)){

				$css_out .= $section_class.",".$section_class." .titleBar h2, ".$section_class." .heading h1, ".$section_class." .heading h2, ".$section_class." .heading h3, ".$section_class." .heading h4, ".$section_class." .heading h5, ".$section_class." .heading h6{\n";
			
			if(!empty($section_style_image)){
				$css_out .= "\tbackground:url('".$section_style_image."') $section_style_color !important;\n";
			}
			if(!empty($section_style_color) && empty($section_style_image)){
				$css_out .= "\tbackground-image: none !important; \n";
				$css_out .= "\tbackground-color:".$section_style_color.";\n";
			}
				$css_out .= "}\n";
			}
			
			endwhile;


			$post = $temp_query;
			
			return $css_out;


		endif;

}


function link_style(){
	global $smof_data;

	$link_color = $smof_data['nzs_link_color'];
	$link_hover = $smof_data['nzs_link_hover'];

	if($link_color || $link_hover){
		
		$add_in = '';

		if(!empty($link_color)){
			$add_in .= 'a,a:visited{color:'.$link_color.';}'."\n";
		}

		if(!empty($link_hover)){
			$add_in .= 'a:hover{color:'.$link_hover.';}'."\n";
		}

		return $add_in;

	}

}

function button_style(){
	global $smof_data;

	$button_bg = $smof_data['nzs_button_background'];
	$button_border = $smof_data['nzs_button_border'];
	$button_font = $smof_data['nzs_button_font_color'];

	if($button_bg || $button_border || $button_font){

		$css = '';
		
		$add_in = '';

		if(!empty($button_bg)){
			$add_in .= "\t".'background-color:'.$button_bg.';'."\n";
		}

		if(!empty($button_border)){
			$add_in .= "\t".'border-color:'.$button_border.';'."\n";
		}


		if(!empty($button_font)){
			$add_in .= "\t".'color:'.$button_font.' !important;'."\n";

			$css .= 'a.color-btn{color:'.$button_font.' !important;}'."\n";
		}


		$css .= 'p.form-submit input[type="submit"], a.main-btn,button.main-btn{'."\n".
				$add_in.
				'}'."\n";

		return $css;

	}

}

function user_custom_css(){
	global $smof_data;

	$user_css = $smof_data['nzs_custom_css'];

	if(!empty($user_css)){


		$css_user = '';

		$css_user .="\n\n\n/* CUSTOM USER CSS \n============================== */\n";
		$css_user .= $user_css;


		return $css_user;
	}
}


function nzs_custom_fonts(){
	global $smof_data;

	$body_custom_front = $smof_data['nzs_body_font'];

	$heading_custom_font = $smof_data['nzs_heading_face_font'];


	$menu_font_face = $smof_data['nzs_menu_face_font'];

	$face_check = array('arial'=>'Arial',
			'verdana'=>'Verdana, Geneva',
			'trebuchet'=>'Trebuchet',
			'georgia' =>'Georgia',
			'times'=>'Times New Roman',
			'tahoma'=>'Tahoma, Geneva',
			'palatino'=>'Palatino',
			'helvetica'=>'Helvetica' );


	$font_sets = "";

		if(!empty($smof_data['nzs_body_font_options'])){

		$font_sets = array();

		foreach ($smof_data['nzs_body_font_options'] as $key => $value) {
			$font_sets[] = $key;
		}

		$font_sets = "&subset=".join(',',$font_sets);

		}

	if(!array_key_exists($body_custom_front['face'], $face_check) &&  'Open Sans' != $body_custom_front['face']){
		$custom_font = str_replace(" ", "+", $body_custom_front['face']);

		wp_enqueue_style( 'custom-body-fonts', 'http://fonts.googleapis.com/css?family='.$custom_font.$font_sets);

	}

	if(!array_key_exists($heading_custom_font['face'], $face_check) &&  'Oswald' != $heading_custom_font['face']){
		$custom_h_font = str_replace(" ", "+", $heading_custom_font['face']);

		wp_enqueue_style( 'custom-heading-fonts', 'http://fonts.googleapis.com/css?family='.$custom_h_font.$font_sets);

	}


	if(!array_key_exists($menu_font_face['face'], $face_check) &&  'Oswald' != $menu_font_face['face']){
		$custom_h_font = str_replace(" ", "+", $menu_font_face['face']);

		wp_enqueue_style( 'custom-menu-fonts', 'http://fonts.googleapis.com/css?family='.$custom_h_font.$font_sets);

	}



}

add_action('wp_enqueue_scripts', 'nzs_custom_fonts');

function body_font(){
	global $smof_data;

	$font_body = $smof_data['nzs_body_font'];

	 $css = '';

	if($font_body['color'] !== '#303030' || $font_body['size'] !== '13px' || $font_body['face'] !== 'Open Sans' ){

		$add_in = '';

		if($font_body['color'] != '#303030' && $font_body['color'] != ''){
			$add_in .= "\t".'color:'.$font_body['color'].';'."\n";
		}

		if($font_body['size'] != '13px'){
			$add_in .= "\t".'font-size:'.$font_body['size'].';'."\n";
			$add_in .= "\t".'line-height:1.2em;'."\n";
		}

		if($font_body['face'] !== 'Open Sans'){

			$add_in .= "\t".'font-family:"'.$font_body["face"].'",helvetica,arial,sans-serif;'."\n";
		}
		
		$css = 'body{'."\n".
				$add_in.
				'}'."\n";

	}

	return $css;


}

function heading_font(){
	global $smof_data;

	$heading_font_custom = $smof_data['nzs_heading_face_font'];

	$heading_one = $smof_data['nzs_heading_one'];
	$heading_two = $smof_data['nzs_heading_two'];
	$heading_three = $smof_data['nzs_heading_three'];
	$heading_four = $smof_data['nzs_heading_four'];
	$heading_five = $smof_data['nzs_heading_five'];
	$heading_six = $smof_data['nzs_heading_six'];

	 $css = '';

	if($heading_font_custom['color'] !== '#cc6633' ||  $heading_font_custom['face'] !== 'Oswald' ){

		$add_in = '';

		if($heading_font_custom['color'] != '#cc6633' && $heading_font_custom['color'] != ''){
			$add_in .= "\t".'color:'.$heading_font_custom['color'].';'."\n";
		}

		if($heading_font_custom['face'] != 'Oswald'){

			$add_in .= "\t".'font-family:"'.$heading_font_custom['face'].'",helvetica,arial,sans-serif;'."\n";
		}

		if(!empty($add_in)){
		
		$css .= 'h1,h2,h3,h4,h5,h6,.name,.titleBar h2{'."\n".
				$add_in.
				'}'."\n";
			}

	}


	if($heading_one['size'] != '46px'){
		$css .= 'h1{font-size:'.$heading_one['size'].';}'."\n";
	}
	if($heading_two['size'] != '35px'){
		$css .= 'h2{font-size:'.$heading_two['size'].';}'."\n";
	}
	if($heading_three['size'] != '28px'){
		$css .= 'h3{font-size:'.$heading_three['size'].';}'."\n";
	}
	if($heading_four['size'] != '21px'){
		$css .= 'h4{font-size:'.$heading_four['size'].';}'."\n";
	}
	if($heading_five['size'] != '17px'){
		$css .= 'h5{font-size:'.$heading_five['size'].';}'."\n";
	}
	if($heading_six['size'] != '14px'){
		$css .= 'h6{font-size:'.$heading_six['size'].';}'."\n";
	}

	return $css;


}

function footer_style(){
	global $smof_data;

	$footer_bg = $smof_data['nzs_footer_background'];
	$footer_border = $smof_data['nzs_footer_border'];
	$footer_font_color = $smof_data['nzs_footer_font_color'];
	$footer_link_color = $smof_data['nzs_footer_link_color'];
	$footer_hover_color = $smof_data['nzs_footer_link_hover_color'];

	 $css = '';

	if($footer_bg || $footer_font_color || $footer_link_color || $footer_hover_color || $footer_border){
		
		$add_in = '';

		if(!empty($footer_bg)){
			$add_in .= 'background-color:'.$footer_bg.';';
		}

		if(!empty($footer_border)){
			$add_in .= 'border-color:'.$footer_border.';';
		}


		if(!empty($footer_font_color)){
			$add_in .= 'color:'.$footer_font_color.';';
		}


		$css .= '.footer{'.
				$add_in.
				'}';


		if(!empty($footer_link_color)){
			$css  .= '.footer a{color:'.$footer_link_color.';}';
		}

		if(!empty($footer_hover_color)){
			$css  .= '.footer a:hover{color:'.$footer_hover_color.';}';
		}


	}

	return $css;
}





function parallax_h_style(){
	global $smof_data;

	$parallax_image = $smof_data['nzs_parallax_image'];

	if(!empty($parallax_image) && 'parallax' == $smof_data['nzs_header_options']){
		$css = '';

		$css .= "\n\n".'#header-option{'."\n";
		$css.= "\t".'background: url("'.$parallax_image.'") repeat 50% -3px fixed transparent;'."\n";
		$css.= "\t".'background-size:cover;'."\n";
		$css.= '}'."\n";

		return $css;

	}

}

function video_header_styles(){
	global $smof_data;

	$youtube_cover_image = $smof_data['nzs_youtube_image'];

	$vimeo_cover_image = $smof_data['nzs_vimeo_image'];

	if('video-header' == $smof_data['nzs_header_options'] && is_home()){

		if(0 == $smof_data['nzs_full_video_type']){
			
			if(!empty($youtube_cover_image)){
				
				$css = '';

				$css .= "\n\n".'#tubular-cover-image{'."\n";
				$css.= "\t".'background: url("'.$youtube_cover_image.'") repeat 50% -3px fixed transparent;'."\n";
				$css.= "\t".'background-size:cover;'."\n";
				$css.= '}'."\n";

				return $css;

			}

		}else{
			if(!empty($vimeo_cover_image)){
				
				$css = '';

				$css .= "\n\n".'#tubular-cover-image{'."\n";
				$css.= "\t".'background: url("'.$vimeo_cover_image.'") repeat 50% -3px fixed transparent;'."\n";
				$css.= "\t".'background-size:cover;'."\n";
				$css.= '}'."\n";

				return $css;

			}
		}
	}
}

?>