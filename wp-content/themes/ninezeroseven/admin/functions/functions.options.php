<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");

		/************************************************************************
		* Google Subsets
		*************************************************************************/

		$google_lang_options = array("latin" => "Latin", "latin-ext" => "Latin Extended","cyrillic" => "Cyrillic" , "cyrillic-ext" => "Cyrillic Extended", "greek" => "Greek", "greek-ext" => "Greek Extended","vietnamese" => "Vietnamese");

		/************************************************************************
		* Parallax Selects
		*************************************************************************/

		$nzs_parallax = array();
		$nzs_parallax['none'] = __('Attach Parallax','framework');

		$test_select = new WP_Query( array( 'post_type' => 'parallax-sections', 'posts_per_page' => -1, 'order' => 'ASC' ));

		    if($test_select->have_posts()):  while($test_select->have_posts()) : $test_select->the_post();

		            $nzs_parallax[get_the_ID()] =  get_the_title();

		        endwhile;
		    endif;


		$nzs_page_section = array();
		$nzs_page_section['none'] = __('Attach Section','framework');


		$test_select = new WP_Query( array( 'post_type' => 'page-sections', 'posts_per_page' => -1, 'order' => 'ASC' ));

		    if($test_select->have_posts()):  while($test_select->have_posts()) : $test_select->the_post();

		            $nzs_page_section[get_the_ID()] =  get_the_title();

		        endwhile;
		    endif;
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}

		global $smof_data;
		// SideBars
		// print_r($smof_data);
		$nzs_side_bars = array();
		$nzs_side_bars['sidebar-1'] = __('Default Sidebar','framework');

		if(isset($smof_data['nzs_side_bars']) && is_array($smof_data['nzs_side_bars'])){

			foreach ($smof_data['nzs_side_bars'] as $key => $value) {
				$nzs_side_bars["$key"] = "$value";
			}
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

$prefix = "nzs_";

// Set the Options Array
global $of_options;
$of_options = array();

/************************************************************************
* HOME SETTINGS
*************************************************************************/

$of_options[] = array( "name" => "Home Settings",
					"type" => "heading"
					);

$of_options[] = array( "name" => "Use Plain Text Logo",
					"desc" => "If you want to use plain text instead of image logo, then check this option.",
					"id" => $prefix."plain_text_logo",
					"std" => 0,
					"type" => "checkbox");
								
$of_options[] = array( "name" => "Site Logo Upload",
					"desc" => "Upload a logo using the upload button or enter a url (ie: http://www.yoursite.com/logo.png).",
					"id" => $prefix."logo",
					"std" => "",
					"type" => "media");

$of_options[] = array( "name" => "",
					"desc" => "px Custom Logo Width",
					"id" => $prefix."logo_width",
					"std" => "",
					"type" => "text",
					"class" => "mini"); 

$of_options[] = array( "name" => "",
					"desc" => "px Custom Logo Height",
					"id" => $prefix."logo_height",
					"std" => "",
					"type" => "text",
					"class" => "mini"); 

$of_options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $prefix."custom_favicon",
					"std" => "",
					"type" => "upload"); 

$of_options[] = array( "name" => "Alternating Background 1",
					"desc" => "Upload a background image to alternate. You can override this when creating page sections.",
					"id" => $prefix."alternate_bg1",
					"std" => "",
					"type" => "media");

$of_options[] = array( "name" => "",
					"desc" => "Or Choose a color.",
					"id" => $prefix."alternate_bg1_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" => "Alternating Background 2",
					"desc" => "Upload a background image to alternate. You can override this when creating page sections.",
					"id" => $prefix."alternate_bg2",
					"std" => "",
					"type" => "media");

$of_options[] = array( "name" => "",
					"desc" => "Or Choose a color.",
					"id" => $prefix."alternate_bg2_color",
					"std" => "",
					"type" => "color");



/************************************************************************
* HEADER OPTIONS
*************************************************************************/

$of_options[] = array( "name" => "Header Options",
					"type" => "heading"
					);

$url =  ADMIN_DIR . 'assets/images/';


$of_options[] = array( "name" => "Header Options",
					"desc" => "Use the drop down to select the header you'd like to use.",
					"id" => $prefix."header_options",
					"std" => "fullscreen",
					"type" => "select-custom",
					"options" => 
						array(
							'fullscreen' => 'Full Screen Slider',
							'parallax' => 'Parallax',
							'flexslider' => 'FlexSlider',
							'video-header' => 'Video Header',
							'customheader' => 'Custom Header',

							)

					);


$of_options[] = array( "name" => "Menu Bar Position",
					"desc" => "Select if you'd like nav on top or bottom",
					"id" => $prefix."nav_position",
					"std" => "bottom",
					"type" => "select-custom",
					"options" => 
						array(
							'top' => 'Top',
							'bottom' => 'Bottom',

							)

					);

/************************************************************************
* Video header	
*************************************************************************/
$of_options[] = array( "name" => "videoheader",
					"type" => "heading"
					);

$of_options[] = array( 	"name" 		=> "Video Type",
						"desc" 		=> "Select Youtube or Vimeo option",
						"id" 		=> $prefix."full_video_type",
						"std" 		=> 0,
						"on" 		=> "Youtube",
						"off" 		=> "Vimeo",
						"type" 		=> "switch"
				);

$of_options[] = array( "name" => "youtubeheader",
					"type" => "heading"
					);

$of_options[] = array( "name" => "Youtube Embed Video Link",
					"desc" => "This should look like http://www.youtube.com/embed/pTTkTN_IIck",
					"id" => $prefix."youtube_video_embed",
					"std" => '',
					"type" => "text");

$of_options[] = array( 	"name" 		=> "Repeat Video(loop)",
						"desc" 		=> "Option to have video loop",
						"id" 		=> $prefix."youtube_video_repeat",
						"std" 		=> 0,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Volume Setting",
						"desc" 		=> "Change the volume on starting. Set to 0 to mute on start.",
						"id" 		=> $prefix."youtube_volume",
						"std" 		=> "30",
						"min" 		=> "0",
						"step"		=> "10",
						"max" 		=> "100",
						"type" 		=> "sliderui" 
				); 

$of_options[] = array( "name" => "Cover Image",
					"desc" => "This image is shown before video load and unsupported devices.",
					"id" => $prefix."youtube_image",
					"std" => "",
					"type" => "upload"); 

$of_options[] = array( "name" => "Heading Text",
					"desc" => "",
					"id" => $prefix."youtube_heading_text",
					"std" => 'Parallax',
					"type" => "text");

$of_options[] = array( "name" => "Description Text",
					"desc" => "",
					"id" => $prefix."youtube_description_text",
					"std" => 'Great one page theme with tons of possibilities and options!',
					"type" => "text"); 

$of_options[] = array( "name" => "Header Logo (optional)",
					"desc" => "You can use this image upload to insert a logo in the header.",
					"id" => $prefix."youtube_logo_image",
					"std" => "",
					"type" => "media"); 

$of_options[] = array( "name" =>  "Font Colors",
					"desc" => "Heading Font",
					"id" => $prefix."heading_font_youtube",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Description font color.",
					"id" => $prefix."desc_font_youtube",
					"std" => "",
					"type" => "color"); 


/************************************************************************
* Vimeo Header
*************************************************************************/

$of_options[] = array( "name" => "vimeoheader",
					"type" => "heading"
					);
$of_options[] = array( "name" => "Vimeo Embed Video Link",
					"desc" => "This should look like http://player.vimeo.com/video/7449107",
					"id" => $prefix."vimeo_video_embed",
					"std" => '',
					"type" => "text");

$of_options[] = array( 	"name" 		=> "Repeat Video(loop)",
						"desc" 		=> "Option to have video loop",
						"id" 		=> $prefix."vimeo_video_repeat",
						"std" 		=> 0,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Volume Setting",
						"desc" 		=> "Change the volume on starting. Set to 0 to mute on start.",
						"id" 		=> $prefix."vimeo_volume",
						"std" 		=> "30",
						"min" 		=> "0",
						"step"		=> "10",
						"max" 		=> "100",
						"type" 		=> "sliderui" 
				);

$of_options[] = array( "name" => "Cover Image",
					"desc" => "This image is shown before video load and unsupported devices.",
					"id" => $prefix."vimeo_image",
					"std" => "",
					"type" => "upload"); 
$of_options[] = array( "name" => "Heading Text",
					"desc" => "",
					"id" => $prefix."vimeo_heading_text",
					"std" => 'Vimeo',
					"type" => "text");

$of_options[] = array( "name" => "Description Text",
					"desc" => "",
					"id" => $prefix."vimeo_description_text",
					"std" => 'Great one page theme with tons of possibilities and options!',
					"type" => "text");  

$of_options[] = array( "name" => "Header Logo (optional)",
					"desc" => "You can use this image upload to insert a logo in the header.",
					"id" => $prefix."vimeo_logo_image",
					"std" => "",
					"type" => "media"); 

$of_options[] = array( "name" =>  "Font Colors",
					"desc" => "Heading Font",
					"id" => $prefix."heading_font_vimeo",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Description font color.",
					"id" => $prefix."desc_font_vimeo",
					"std" => "",
					"type" => "color"); 

/************************************************************************
* Custom Header Option
*************************************************************************/
$of_options[] = array( "name" => "customheader",
					"type" => "heading"
					);

$of_options[] = array( "name" => "Custom Header Code",
					"desc" => "Insert custom header code/shortcodes in here.",
					"id" => $prefix."custom_header_code",
					"std" => "",
					"type" => "textarea");  

$of_options[] = array( "name" => "Background Image",
					"desc" => "Upload a repeatable background image.",
					"id" => $prefix."custom_slider_bg_image",
					"std" => "",
					"type" => "upload"); 
$of_options[] = array( "name" => "",
					"desc" => "Repeat Options",
					"id" => $prefix."custom_bg_repeat",
					"std" => "repeat",
					"type" => "select-custom",
					"options" => 
						array(
							'repeat' => 'Repeat',
							'repeat-x' => 'Repeat X',
							'repeat-y' => 'Repeat y',
							'no-repeat' => 'No Repeat',

							)

					);


/************************************************************************
* Flex Header
*************************************************************************/
$of_options[] = array( "name" => "flexslider",
					"type" => "heading"
					);


$of_options[] = array( "name" => "FlexSlider Slides",
					"desc" => "Unlimited slider with drag and drop sortings.",
					"id" => $prefix."flex_slider",
					"std" => "",
					"type" => "slider");

$of_options[] = array( "name" => "Background Image",
					"desc" => "Upload a repeatable background image.",
					"id" => $prefix."flex_slider_bg_image",
					"std" => "",
					"type" => "upload"); 

$of_options[] = array( "name" =>  "Color Options",
					"desc" => "Heading Font",
					"id" => $prefix."heading_font_flexslider",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Description font color.",
					"id" => $prefix."desc_font_flexslider",
					"std" => "",
					"type" => "color"); 

$of_options[] = array( "name" =>  "",
					"desc" => "Slider frame color.",
					"id" => $prefix."frame_flexslider",
					"std" => "",
					"type" => "color"); 


/************************************************************************
* PArallax Header
*************************************************************************/
$of_options[] = array( "name" => "parallax",
					"type" => "heading"
					);

$of_options[] = array( "name" => "Heading Text",
					"desc" => "",
					"id" => $prefix."parallax_heading_text",
					"std" => 'Parallax',
					"type" => "text");

$of_options[] = array( "name" => "Description Text",
					"desc" => "",
					"id" => $prefix."parallax_description_text",
					"std" => 'Great one page theme with tons of possibilities and options!',
					"type" => "text"); 

$of_options[] = array( "name" => "Upload Image for Parallax header",
					"desc" => "This image is used in header.",
					"id" => $prefix."parallax_image",
					"std" => "",
					"type" => "upload"); 

$of_options[] = array( "name" => "Header Logo (optional)",
					"desc" => "You can use this image upload to insert a logo in the header.",
					"id" => $prefix."parallax_logo_image",
					"std" => "",
					"type" => "media"); 

$of_options[] = array( "name" => "Parallax Speed",
					"desc" => "Speed of parallax effect. Default 0.3",
					"id" => $prefix."parallax_header_speed",
					"std" => "0.3",
					"type" => "select-custom",
					"options" => array(
			                '0.0' => '0.0',
			                '0.1' => '0.1',
			                '0.2' =>'0.2',
			                '0.3' => '0.3',
			                '0.4' => '0.4',
			                '0.5' => '0.5',
			                '0.6' => '0.6',
			                '0.7' => '0.7',
			                '0.8' => '0.8',
			                '0.9' => '0.9',
			                '1' => '1',
			                '1.1' => '1.1',
			                '1.2' =>'1.2',
			                '1.3' => '1.3',
			                '1.4' => '1.4',
			                '1.5' => '1.5',
			                '1.6' => '1.6',
			                '1.7' => '1.7',
			                '1.8' => '1.8',
			                '1.9' => '1.9'
			                )

					);  

$of_options[] = array( "name" =>  "Font Colors",
					"desc" => "Heading Font",
					"id" => $prefix."heading_font_parallax",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Description font color.",
					"id" => $prefix."desc_font_parallax",
					"std" => "",
					"type" => "color"); 

/************************************************************************
* Full Screen SLider
*************************************************************************/

$of_options[] = array( "name" => "FullScreen",
					"type" => "heading"
					);

$of_options[] = array( "name" => "Full Screen Slides",
					"desc" => "Unlimited slider with drag and drop sortings.",
					"id" => $prefix."full_screen_slider",
					"std" => "",
					"type" => "slider");

$of_options[] = array( "name" => "Header Logo (optional)",
					"desc" => "You can use this image upload to insert a logo in the header.",
					"id" => $prefix."fullscreen_logo_image",
					"std" => "",
					"type" => "media"); 


$of_options[] = array( 	"name" 		=> "Slide Speed",
						"desc" 		=> "Change slide speed. default 4000",
						"id" 		=> $prefix."fullscreen_speed",
						"std" 		=> "4000",
						"min" 		=> "4000",
						"step"		=> "3",
						"max" 		=> "20000",
						"type" 		=> "sliderui" 
				);

$of_options[] = array( "name" => "Slide Transition",
					"desc" => "Choose transition effect for between slides.",
					"id" => $prefix."fullscreen_trans",
					"std" => "1",
					"type" => "select-custom",
					"options" => 
						array(
							'0' => 'None',
							'1' => 'Fade',
							'2' => 'Slide Top',
							'3' => 'Slide Right',
							'4' => 'Slide Bottom',
							'5' => 'Slide Left',
							'6' => 'Carousel Right',
							'7' => 'Carousel Left',
						)

					); 
$of_options[] = array( "name" => "Open Links In",
					"desc" => "Optional open links in new or same window",
					"id" => $prefix."full_slider_target",
					"std" => 1,
					"type" => "select-custom",
					"class" => "tiny", //mini, tiny, small
					"options" => array(
						"0" => "_self",
						"1" => "_blank",
					)); 

$of_options[] = array( "name" =>  "Font Colors",
					"desc" => "Heading Font",
					"id" => $prefix."heading_font_fullscreen",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Description font color.",
					"id" => $prefix."desc_font_fullscreen",
					"std" => "",
					"type" => "color"); 


/************************************************************************
* GENERAL SETTINGS
*************************************************************************/

$of_options[] = array( "name" => "General Settings",
                    "type" => "heading");


$of_options[] = array( 	"name" 		=> "Responsive Layout",
						"desc" 		=> "Disable Responsive Layout?",
						"id" 		=> $prefix."responsive_layout",
						"std" 		=> 0,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);


$of_options[] = array( "name" => "Default Parallax",
					"desc" => "Optional Choose a default parallax for pages, post, etc. This is shown at bottom of pages.",
					"id" => $prefix."default_parallax",
					"std" => "none",
					"type" => "select-custom",
					"options" =>$nzs_parallax,

					); 

$of_options[] = array( "name" => "Default Page Section",
					"desc" => "Optional Choose a default page section for pages, post, etc. This is shown at bottom of pages.",
					"id" => $prefix."default_page_section",
					"std" => "none",
					"type" => "select-custom",
					"options" =>$nzs_page_section,

					);  
                                               
$of_options[] = array( "name" => "Tracking Code/Custom JS",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $prefix."google_analytics",
					"std" => "",
					"type" => "textarea");        


$of_options[] = array( "name" => "Footer Text",
                    "desc" => "You can use the following shortcodes in your footer text: [theme-link] [the-year]",
                    "id" => $prefix."footer_text",
                    "std" => "",
                    "type" => "textarea");     


/************************************************************************
* Typography OPTIONS
*************************************************************************/

   
$of_options[] = array( "name" => "Typography",
					"type" => "heading");

$of_options[] = array( "name" => "Body Font",
					"desc" => "Specify the body font properties",
					"id" => $prefix."body_font",
					"std" => array('size' => '13px','face' => 'Open Sans','color' => '#303030'),
					"type" => "typography");  

$of_options[] = array( "name" => "Heading Font",
					"desc" => "Specify the heading font properties",
					"id" => $prefix."heading_face_font",
					"std" => array('face' => 'Oswald','color' => '#cc6633'),
					"type" => "typography");

$of_options[] = array( "name" => "Menu Font",
					"desc" => "Specify the menu font face",
					"id" => $prefix."menu_face_font",
					"std" => array('size' => '15px','face' => 'Oswald'),
					"type" => "typography");

$of_options[] = array( "name" => "Heading 1",
					"desc" => "Font size for H1 tags. Default size: 46px",
					"id" => $prefix."heading_one",
					"std" => array('size' => '46px'),
					"type" => "typography"); 

$of_options[] = array( "name" => "Heading 2",
					"desc" => "Font size for H2 tags. Default size: 35px",
					"id" => $prefix."heading_two",
					"std" => array('size' => '35px'),
					"type" => "typography"); 

$of_options[] = array( "name" => "Heading 3",
					"desc" => "Font size for H3 tags. Default size: 28px",
					"id" => $prefix."heading_three",
					"std" => array('size' => '28px'),
					"type" => "typography"); 

$of_options[] = array( "name" => "Heading 4",
					"desc" => "Font size for H4 tags. Default size: 21px",
					"id" => $prefix."heading_four",
					"std" => array('size' => '21px'),
					"type" => "typography"); 

$of_options[] = array( "name" => "Heading 5",
					"desc" => "Font size for H5 tags. Default size: 17px",
					"id" => $prefix."heading_five",
					"std" => array('size' => '17px'),
					"type" => "typography"); 

$of_options[] = array( "name" => "Heading 6",
					"desc" => "Font size for H6 tags. Default size: 14px",
					"id" => $prefix."heading_six",
					"std" => array('size' => '14px'),
					"type" => "typography"); 

$of_options[] = array( "name" => "Google Character Sets (optional)",
					"desc" => "Please note this doesn't check the font on Google Webfonts to see if the subset is available.",
					"id" => $prefix."body_font_options",
					"std" => '',
				  	"type" => "multicheck",
					"options" => $google_lang_options);  
/************************************************************************
* Styling Options
*************************************************************************/ 			
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading");

$of_options[] = array( "name" => "Navigation Styling",
					"desc" => "Upload a image for navigation background image.",
					"id" => $prefix."nav_bg_image",
					"std" => "",
					"type" => "media");

$of_options[] = array( "name" =>  "",
					"desc" => "Background Color",
					"id" => $prefix."nav_bg_color",
					"std" => "",
					"type" => "color");
$of_options[] = array( "name" =>  "",
					"desc" => "Border Color",
					"id" => $prefix."nav_border_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Link Color",
					"id" => $prefix."nav_link_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Link Hover Color",
					"id" => $prefix."nav_link_hover",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Sub Menu Background Color",
					"id" => $prefix."nav_subbg",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Sub Menu Hover Background Color",
					"id" => $prefix."nav_subbg_hover",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Sub Menu Border Color",
					"id" => $prefix."nav_subborder",
					"std" => "",
					"type" => "color");


$of_options[] = array( 	"name" 		=> "Mobile Menu Option",
						"desc" 		=> "Select Dropdown or Mobile Menu",
						"id" 		=> $prefix."mobile_menu_type",
						"std" 		=> 0,
						"on" 		=> "DropDown",
						"off" 		=> "Mobile Menu",
						"type" 		=> "switch"
				);


$of_options[] = array( "name" =>  "",
					"desc" => "Mobile Menu BG Color",
					"id" => $prefix."mobile_bg_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Mobile Icon Color",
					"id" => $prefix."mobile_icon",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Mobile Icon Active",
					"id" => $prefix."mobile_icon_open",
					"std" => "",
					"type" => "color");

$of_options[] = array( 	"name" 		=> "Load Font Awesome Icons",
						"desc" 		=> "Set to Enable to load font awesome.",
						"id" 		=> $prefix."load_font_awesome",
						"std" 		=> 1,
						"on" 		=> "Enable",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);


$of_options[] = array( "name" =>  "Image Hover Styling",
					"desc" => "Image Overlay Color",
					"id" => $prefix."overlay_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Icon BG Color",
					"id" => $prefix."bg_icon_color",
					"std" => "",
					"type" => "color"); 

$of_options[] = array( "name" =>  "Link Styling",
					"desc" => "Link Color",
					"id" => $prefix."link_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Hover Color",
					"id" => $prefix."link_hover",
					"std" => "",
					"type" => "color"); 

$of_options[] = array( "name" =>  "Button Styling",
					"desc" => "Background Color",
					"id" => $prefix."button_background",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Border Color",
					"id" => $prefix."button_border",
					"std" => "",
					"type" => "color");
					
$of_options[] = array( "name" =>  "",
					"desc" => "Font Color",
					"id" => $prefix."button_font_color",
					"std" => "",
					"type" => "color"); 
					
$of_options[] = array( "name" =>  "Footer Styling",
					"desc" => "Background Color",
					"id" => $prefix."footer_background",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Border Color",
					"id" => $prefix."footer_border",
					"std" => "",
					"type" => "color");
					
$of_options[] = array( "name" =>  "",
					"desc" => "Font Color",
					"id" => $prefix."footer_font_color",
					"std" => "",
					"type" => "color"); 

$of_options[] = array( "name" =>  "",
					"desc" => "Link Color",
					"id" => $prefix."footer_link_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Link Hover Color",
					"id" => $prefix."footer_link_hover_color",
					"std" => "",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $prefix."custom_css",
                    "std" => "",
                    "type" => "textarea");


/************************************************************************
* HOME SETTINGS
*************************************************************************/

$of_options[] = array( "name" => "Image Settings",
					"type" => "heading"
					);

$of_options[] = array( 	"name" 		=> "FlexSlider Speed",
						"desc" 		=> "Change transition speed",
						"id" 		=> $prefix."flex_speed",
						"std" 		=> "3500",
						"min" 		=> "0",
						"step"		=> "100",
						"max" 		=> "20000",
						"type" 		=> "sliderui" 
				); 

$of_options[] = array( 	"name" 		=> "FlexSlider AutoPlay",
						"desc" 		=> "Set to Enable to autoplay/start slider",
						"id" 		=> $prefix."flex_auto_start",
						"std" 		=> 0,
						"on" 		=> "Enable",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);

$of_options[] = array( "name" => "Portfolio Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."portfolio_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."portfolio_thumb_width",
					"std" => '410',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."portfolio_thumb_height",
					"std" => '230',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."portfolio_crop_mode",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Portfolio Single Page Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."portfolio_single_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."portfolio_single_thumb_width",
					"std" => '610',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."portfolio_single_thumb_height",
					"std" => '230',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."portfolio_single_crop_mode",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Portfolio Single Full Width Page Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."portfolio_single_full_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."portfolio_single_full_thumb_width",
					"std" => '925',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."portfolio_single_full_thumb_height",
					"std" => '350',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."portfolio_single_full_crop_mode",
					"std" => 1,
					"type" => "checkbox");


/*WORKS IMAGEs*/

$of_options[] = array( "name" => "Works Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."works_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."works_thumb_width",
					"std" => '410',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."works_thumb_height",
					"std" => '160',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."works_crop_mode",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Works Single Page Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."works_single_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."works_single_thumb_width",
					"std" => '610',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."works_single_thumb_height",
					"std" => '230',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."works_single_crop_mode",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Works Single Full Width Page Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."works_single_full_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."works_single_full_thumb_width",
					"std" => '925',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."works_single_full_thumb_height",
					"std" => '350',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."works_single_full_crop_mode",
					"std" => 1,
					"type" => "checkbox");

/*BLOG POST*/

// $of_options[] = array( "name" => "Posts Thumbnail",
// 					"desc" => "Check box to override theme's default sizes",
// 					"id" => $prefix."post_thumb_enable",
// 					"std" => 0,
// 					"type" => "checkbox");

// $of_options[] = array( "name" => "",
// 					"desc" => "px Width",
// 					"id" => $prefix."post_thumb_width",
// 					"std" => '410',
// 					"class" => 'mini',
// 					"type" => "text");

// $of_options[] = array( "name" => "",
// 					"desc" => "px Height",
// 					"id" => $prefix."post_thumb_height",
// 					"std" => '160',
// 					"class" => 'mini',
// 					"type" => "text");

// $of_options[] = array( "name" => "",
// 					"desc" => "Uncheck box for soft crop mode.",
// 					"id" => $prefix."post_crop_mode",
// 					"std" => 1,
// 					"type" => "checkbox");

$of_options[] = array( "name" => "Posts Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."post_single_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."post_single_thumb_width",
					"std" => '610',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."post_single_thumb_height",
					"std" => '230',
					"class" => 'mini',
					"type" => "text");
$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."post_single_crop_mode",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Posts Single Full Width Page Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."post_single_full_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."post_single_full_thumb_width",
					"std" => '925',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."post_single_full_thumb_height",
					"std" => '350',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."post_single_full_crop_mode",
					"std" => 1,
					"type" => "checkbox");

/*Team*/

$of_options[] = array( "name" => "Team Thumbnail",
					"desc" => "Check box to override theme's default sizes",
					"id" => $prefix."team_thumb_enable",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "px Width",
					"id" => $prefix."team_thumb_width",
					"std" => '250',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "px Height",
					"id" => $prefix."team_thumb_height",
					"std" => '250',
					"class" => 'mini',
					"type" => "text");

$of_options[] = array( "name" => "",
					"desc" => "Uncheck box for soft crop mode.",
					"id" => $prefix."team_crop_mode",
					"std" => 1,
					"type" => "checkbox");

/************************************************************************
* Recent Works
*************************************************************************/			
$of_options[] = array( "name" => "Works Options",
					"type" => "heading"
					);

$of_options[] = array( "name" => "Excerpt Length",
					"desc" => "Custom Excerpt Length",
					"id" => $prefix."works_excerpt_length",
					"std" => "85",
					"type" => "text",
					"class" => "mini"); 
				
$of_options[] = array( 	"name" 		=> "Mouseover Icons",
						"desc" 		=> "Show page link icon?",
						"id" 		=> $prefix."hide_works_link",
						"std" 		=> 0,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Show photo popup icon?",
						"id" 		=> $prefix."hide_works_photo_link",
						"std" 		=> 0,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Masonry Layout",
						"desc" 		=> "Isotype masonry layout option",
						"id" 		=> $prefix."iso_works_option",
						"std" 		=> 1,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);

$of_options[] = array( "name" => "Works Display Order Options",
					"desc" => "Use the drop down to select orderby value",
					"id" => $prefix."works_orderby",
					"std" => "ID",
					"type" => "select-custom",
					"options" => 
						array(
							'title' => 'Title',
							'ID' => 'Default',
							'date' => 'Date',
							'rand' => 'Random',

							)

					);

$of_options[] = array( "name" => "",
					"desc" => "Use the drop down to select to ascend order or descend.",
					"id" => $prefix."works_order",
					"std" => "DESC",
					"type" => "select-custom",
					"options" => 
						array(
							'ASC' => 'Ascending',
							'DESC' => 'Decending',

							)

					);

$url =  ADMIN_DIR . 'assets/images/';
$of_options[] = array( "name" => "Recent Works Columns",
					"desc" => "Select if you'd like 3 or 4 per row by clicking one of the images.",
					"id" => $prefix."works_cols",
					"std" => '3',
					"type" => "images",
					"options" => array(
						'3' => $url . '3-col-portfolio.png',
						'4' => $url . '4-col-portfolio.png')); 


$of_options[] = array( 	"name" 		=> "Works Single Page Layout",
						"desc" 		=> "Select layout for recent works single page view",
						"id" 		=> $prefix."works_page_layout",
						"std" 		=> "2cr",
						"type" 		=> "images",
						"options" 	=> array(
							'1c' 	=> $url . '1col.png',
							'2cr' 	=> $url . '2cr.png',
							'2cl' 	=> $url . '2cl.png'
						)
				);

$of_options[] = array( "name" => "Image Frame Background",
					"desc" => "Can choose a background color for image frame/box.",
					"id" => $prefix."working_frame_bg",
					"std" => "",
					"type" => "color");


$of_options[] = array( "name" => "Heading Font",
					"desc" => "Options for heading font.",
					"id" => $prefix."works_heading",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");

$of_options[] = array( "name" => "Description Font",
					"desc" => "Options for description font.",
					"id" => $prefix."works_desc",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography"); 

/************************************************************************
* Portfolio
*************************************************************************/
$of_options[] = array( "name" => "Portfolio Options",
					"type" => "heading"
					);

$of_options[] = array( "name" => "Excerpt Length",
					"desc" => "Custom Excerpt Length",
					"id" => $prefix."portfolio_excerpt_length",
					"std" => "55",
					"type" => "text",
					"class" => "mini"); 
				
$of_options[] = array( 	"name" 		=> "Mouseover Icons",
						"desc" 		=> "Show page link icon?",
						"id" 		=> $prefix."hide_portfolio_link",
						"std" 		=> 0,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Show photo popup icon?",
						"id" 		=> $prefix."hide_portfolio_photo_link",
						"std" 		=> 0,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Masonry Layout",
						"desc" 		=> "Isotype masonry layout option",
						"id" 		=> $prefix."iso_portfolio_option",
						"std" 		=> 1,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);


$of_options[] = array( "name" => "Portfolio Display Order Options",
					"desc" => "Use the drop down to select orderby value",
					"id" => $prefix."portfolio_orderby",
					"std" => "ID",
					"type" => "select-custom",
					"options" => 
						array(
							'title' => 'Title',
							'ID' => 'Default',
							'date' => 'Date',
							'rand' => 'Random',

							)

					);

$of_options[] = array( "name" => "",
					"desc" => "Use the drop down to select to ascend order or descend.",
					"id" => $prefix."portfolio_order",
					"std" => "DESC",
					"type" => "select-custom",
					"options" => 
						array(
							'ASC' => 'Ascending',
							'DESC' => 'Decending',

							)

					);


$url =  ADMIN_DIR . 'assets/images/';
$of_options[] = array( "name" => "Portfolio Columns",
					"desc" => "Select if you'd like 3 or 4 per row by clicking one of the images.",
					"id" => $prefix."portfolio_cols",
					"std" => '4',
					"type" => "images",
					"options" => array(
						'3' => $url . '3-col-portfolio.png',
						'4' => $url . '4-col-portfolio.png')); 

$of_options[] = array( 	"name" 		=> "Portfolio Single Page Layout",
						"desc" 		=> "Select layout for portfolio single page view",
						"id" 		=> $prefix."portfolio_page_layout",
						"std" 		=> "2cr",
						"type" 		=> "images",
						"options" 	=> array(
							'1c' 	=> $url . '1col.png',
							'2cr' 	=> $url . '2cr.png',
							'2cl' 	=> $url . '2cl.png'
						)
				);

$of_options[] = array( "name" => "Image Frame Background",
					"desc" => "Can choose a background color for image frame/box.",
					"id" => $prefix."portfolio_frame_bg",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" => "Heading Font",
					"desc" => "Options for heading font.",
					"id" => $prefix."portfolio_heading",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");

$of_options[] = array( "name" => "Description Font",
					"desc" => "Options for description font.",
					"id" => $prefix."portfolio_desc",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");

/************************************************************************
* Team
*************************************************************************/
$of_options[] = array( "name" => "Team Options",
					"type" => "heading"
					);
// $url =  ADMIN_DIR . 'assets/images/';

$of_options[] = array( "name" => "Team Member Columns",
					"desc" => "Select if you'd like 2,3 or 4 per row by clicking one of the images.",
					"id" => $prefix."team_cols",
					"std" => '4',
					"type" => "images",
					"options" => array(
						'2' => $url . '2-col-portfolio.png',
						'3' => $url . '3-col-portfolio.png',
						'4' => $url . '4-col-portfolio.png')); 

$of_options[] = array( "name" => "Image Frame Background",
					"desc" => "Can choose a background color for image frame/box.",
					"id" => $prefix."team_frame_bg",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" => "Image Frame Background Hover",
					"desc" => "Can choose a background hover color for image frame/box.",
					"id" => $prefix."team_hover_bg",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" => "Team Name Font",
					"desc" => "Font size and color for members name.",
					"id" => $prefix."team_name",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");

$of_options[] = array( "name" => "Last Name Font Color",
					"desc" => "Font Color for members last name (optional).",
					"id" => $prefix."team_name_last",
					"std" =>"",
					"type" => "color");

$of_options[] = array( "name" => "Position Font",
					"desc" => "Font size and color for members position.",
					"id" => $prefix."team_position",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");

$of_options[] = array( "name" => "Description Font",
					"desc" => "Font size for members info text",
					"id" => $prefix."team_desc",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");
/************************************************************************
* Blog
*************************************************************************/

$of_options[] = array( "name" => "Blog Options",
					"type" => "heading"
					);
$of_options[] = array( 	"name" 		=> "Single Post Page Layout",
						"desc" 		=> "Select layout for single post page view",
						"id" 		=> $prefix."single_page_layout",
						"std" 		=> "2cr",
						"type" 		=> "images",
						"options" 	=> array(
							'1c' 	=> $url . '1col.png',
							'2cr' 	=> $url . '2cr.png',
							'2cl' 	=> $url . '2cl.png'
						)
				);

$of_options[] = array( 	"name" 		=> "Front Blog Layout",
						"desc" 		=> "Select layout for front page blog shortcode",
						"id" 		=> $prefix."blog_page_layout",
						"std" 		=> "2cr",
						"type" 		=> "images",
						"options" 	=> array(
							'1c' 	=> $url . '1col.png',
							'2cr' 	=> $url . '2cr.png',
							'2cl' 	=> $url . '2cl.png'
						)
				);

$of_options[] = array( "name" => "Image Frame Background",
					"desc" => "Can choose a background color for image frame/box.",
					"id" => $prefix."blog_frame_bg",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" => "Blog Title Font",
					"desc" => "Size and color option for post titles.",
					"id" => $prefix."blog_heading",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");

$of_options[] = array( "name" => "Description Font",
					"desc" => "Size and color option for general post text.",
					"id" => $prefix."blog_desc",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");

$of_options[] = array( "name" => "Link Color",
					"desc" => "Link color within posts/blog section.",
					"id" => $prefix."blog_link",
					"std" => "",
					"type" => "color");
$of_options[] = array( "name" => "Link Hover Color",
					"desc" => "Link hover color within posts/blog section.",
					"id" => $prefix."blog_hover_link",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" => "Widget Heading Font",
					"desc" => "Widget headings font size and color.",
					"id" => $prefix."widget_heading",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography"); 

$of_options[] = array( "name" => "Widget Font",
					"desc" => "Font size and color for text within widgets.",
					"id" => $prefix."widget_desc",
					"std" => array('size' => '12px','color' => ''),
					"type" => "typography");

$of_options[] = array( "name" => "Meta Font",
					"desc" => "Font size and color for post meta.",
					"id" => $prefix."meta_desc",
					"std" => array('size' => '10px','color' => ''),
					"type" => "typography");     

/************************************************************************
* SOCIAL OPTIONS
*************************************************************************/

$of_options[] = array( "name" => "Social",
					"type" => "heading"
					);
$of_options[] = array( "name" => "Open Social In",
					"desc" => "You can select to open social links in a new window.",
					"id" => $prefix."social_target",
					"std" => "_blank",
					"type" => "select",
					"class" => "tiny", //mini, tiny, small
					"options" => array(
						"_self" => "_self",
						"_blank" => "_blank",
					));  
					
$of_options[] = array( "name" => "Twitter Link",
					"desc" => "",
					"id" => $prefix."social_twitter",
					"std" => '',
					"type" => "text"); 
$of_options[] = array( "name" => "Facebook Link",
					"desc" => "",
					"id" => $prefix."social_facebook",
					"std" => '',
					"type" => "text"); 
$of_options[] = array( "name" => "Google+ Link",
					"desc" => "",
					"id" => $prefix."social_google",
					"std" => '',
					"type" => "text"); 
$of_options[] = array( "name" => "Flickr Link",
					"desc" => "",
					"id" => $prefix."social_flickr",
					"std" => '',
					"type" => "text");
$of_options[] = array( "name" => "LinkedIn Link",
					"desc" => "",
					"id" => $prefix."social_linkedin",
					"std" => '',
					"type" => "text");
$of_options[] = array( "name" => "Pinterest Link",
					"desc" => "",
					"id" => $prefix."social_pinterest",
					"std" => '',
					"type" => "text");  
$of_options[] = array( "name" => "Dribbble Link",
					"desc" => "",
					"id" => $prefix."social_dribbble",
					"std" => '',
					"type" => "text"); 
$of_options[] = array( "name" => "DeviantArt Link",
					"desc" => "",
					"id" => $prefix."social_deviantart",
					"std" => '',
					"type" => "text");

$of_options[] = array( "name" => "Youtube Link",
					"desc" => "",
					"id" => $prefix."social_youtube",
					"std" => '',
					"type" => "text");
$of_options[] = array( "name" => "Vimeo Link",
				"desc" => "",
				"id" => $prefix."social_vimeo",
				"std" => '',
				"type" => "text");
$of_options[] = array( "name" => "Instagram Link",
				"desc" => "",
				"id" => $prefix."social_instagram",
				"std" => '',
				"type" => "text");
$of_options[] = array( "name" => "Email Address",
				"desc" => "",
				"id" => $prefix."social_email",
				"std" => '',
				"type" => "text");
$of_options[] = array( "name" => "SoundCloud Link",
				"desc" => "",
				"id" => $prefix."social_soundcloud",
				"std" => '',
				"type" => "text"); 
$of_options[] = array( "name" => "Behance Link",
				"desc" => "",
				"id" => $prefix."social_behance",
				"std" => '',
				"type" => "text"); 
$of_options[] = array( "name" => "Ustream Link",
				"desc" => "",
				"id" => $prefix."social_ustream",
				"std" => '',
				"type" => "text");        
$of_options[] = array( "name" => "RSS Link",
				"desc" => "",
				"id" => $prefix."social_rss",
				"std" => '',
				"type" => "text"); 

/************************************************************************
* SideBars
*************************************************************************/


$of_options[] = array( "name" => "Sidebars",
					"type" => "heading");
					
$of_options[] = array( "name" => "Create Unlimted Sidebars",
                    "id" => $prefix."side_bars",
                    "desc" => "",
                    "std" => "",
                    "type" => "side-bars",
					"options" => $nzs_side_bars);         

/************************************************************************
* BACKUP OPTIONS
*************************************************************************/


$of_options[] = array( "name" => "Backup Options",
					"type" => "heading");
					
$of_options[] = array( "name" => "Backup and Restore Options",
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
					
$of_options[] = array( "name" => "Transfer Theme Options Data",
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						',
					);
				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
