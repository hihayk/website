<?php 
/**
 * SMOF Interface
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */
 
 
/**
 * Admin Init
 *
 * @uses wp_verify_nonce()
 * @uses header()
 *
 * @since 1.0.0
 */
function optionsframework_admin_init() 
{
	// Rev up the Options Machine
	global $of_options, $options_machine;
	$options_machine = new Options_Machine($of_options);

	$smof_data = of_get_options();
	$data = $smof_data;
	do_action('optionsframework_admin_init_before', array(
			'of_options'		=> $of_options,
			'options_machine'	=> $options_machine,
			'smof_data'			=> $smof_data
		));
	if (empty($smof_data['smof_init'])) { // Let's set the values if the theme's already been active
		of_save_options($options_machine->Defaults);
		of_save_options(date('r'), 'smof_init');
		$smof_data = of_get_options();
		$options_machine = new Options_Machine($of_options);
	}
	do_action('optionsframework_admin_init_after', array(
			'of_options'		=> $of_options,
			'options_machine'	=> $options_machine,
			'smof_data'			=> $smof_data
		));

}

/**
 * Create Options page
 *
 * @uses add_theme_page()
 * @uses add_action()
 *
 * @since 1.0.0
 */
function optionsframework_add_admin() {
	
    $of_page = add_theme_page( THEMENAME, 'Theme Options', 'edit_theme_options', 'optionsframework', 'optionsframework_options_page');

	// Add framework functionaily to the head individually
	add_action("admin_print_scripts-$of_page", 'of_load_only');
	add_action("admin_print_styles-$of_page",'of_style_only');
	
}


/**
 * Build Options page
 *
 * @since 1.0.0
 */
function optionsframework_options_page(){
	
	global $options_machine;
	
	/*
	//for debugging

	$smof_data = of_get_options();
	print_r($smof_data);

	*/	
	
	include_once( ADMIN_PATH . 'front-end/options.php' );

}

/**
 * Create Options page
 * wp_enqueue_style( $handle, $src, $deps, $ver, $media );
 * @uses wp_enqueue_style()
 *
 * @since 1.0.0
 */
function of_style_only(){
	add_action('admin_head', 'smof_admin_head');
	wp_enqueue_style('admin-style', ADMIN_DIR . 'assets/css/admin-style.css', array() , THEMEVERSION);
	//wp_enqueue_style('color-picker', ADMIN_DIR . 'assets/css/colorpicker.css');
	wp_enqueue_style('jquery-ui-custom-admin', ADMIN_DIR .'assets/css/jquery-ui-custom.css');

	if ( !wp_style_is( 'wp-color-picker','registered' ) ) {
		wp_register_style( 'wp-color-picker', ADMIN_DIR . 'assets/css/color-picker.min.css' );
	}
	wp_enqueue_style( 'wp-color-picker' );

}	

/**
 * Create Options page
 *
 * @uses add_action()
 * @uses wp_enqueue_script()
 *
 * @since 1.0.0
 */
function of_load_only() 
{
	add_action('admin_head', 'smof_admin_head');
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-input-mask', ADMIN_DIR .'assets/js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
	wp_enqueue_script('tipsy', ADMIN_DIR .'assets/js/jquery.tipsy.js', array( 'jquery' ));
	//wp_enqueue_script('color-picker', ADMIN_DIR .'assets/js/colorpicker.js', array('jquery'));
	wp_enqueue_script('cookie', ADMIN_DIR . 'assets/js/cookie.js', 'jquery');
	wp_enqueue_script('smof', ADMIN_DIR .'assets/js/smof.js', array( 'jquery' ));


	// Enqueue colorpicker scripts for versions below 3.5 for compatibility
	if ( !wp_script_is( 'wp-color-picker', 'registered' ) ) {
		wp_register_script( 'iris', ADMIN_DIR .'assets/js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
		wp_register_script( 'wp-color-picker', ADMIN_DIR .'assets/js/color-picker.min.js', array( 'jquery', 'iris' ) );
	}
	wp_enqueue_script( 'wp-color-picker' );
	

	/**
	 * Enqueue scripts for file uploader
	 */
	
	if ( function_exists( 'wp_enqueue_media' ) )
		wp_enqueue_media();

}

/**
 * Front end inline jquery scripts
 *
 * @since 1.0.0
 */
function smof_admin_head() { ?>
		
	<script type="text/javascript" language="javascript">

	jQuery.noConflict();
	jQuery(document).ready(function($){
	
		// COLOR Picker			
		// $('.colorSelector').each(function(){
		// 	var Othis = this; //cache a copy of the this variable for use inside nested function
				
		// 	$(this).ColorPiker({
		// 			color: '<?php if(isset($color)) echo $color; ?>',
		// 			onShow: function (colpkr) {
		// 				$(colpkr).fadeIn(500);
		// 				return false;
		// 			},
		// 			onHide: function (colpkr) {
		// 				$(colpkr).fadeOut(500);
		// 				return false;
		// 			},
		// 			onChange: function (hsb, hex, rgb) {
		// 				$(Othis).children('div').css('backgroundColor', '#' + hex);
		// 				$(Othis).next('input').attr('value','#' + hex);

						
		// 			}
		// 	});
				  
		// }); //end color picker

		$('li.parallax,li.fullscreen,li.flexslider,li.customheader,li.videoheader').hide();

		if($('li.headeroptions').hasClass('current')){

		if($('#nzs_header_options').val() == "flexslider"){
			 

			 	$('#of-option-flexslider').css("display","block");

			}

			if($('#nzs_header_options').val() == "parallax"){
			 

			 	$('#of-option-parallax').css("display","block");

			}

			if($('#nzs_header_options').val() == "fullscreen"){
			 

			 	$('#of-option-fullscreen').css("display","block");

			}

			if($('#nzs_header_options').val() == "customheader"){
			 

			 	$('#of-option-customheader').css("display","block");

			}

			if($('#nzs_header_options').val() == "video-header"){
			 

			 	$('#of-option-videoheader').css("display","block");


			 	if($('#section-nzs_full_video_type label').hasClass('cb-enable selected')){
					$('#of-option-vimeoheader').css("display","none");
					$('#of-option-youtubeheader').css("display","block");
				}else{
					$('#of-option-youtubeheader').css("display","none");
					$('#of-option-vimeoheader').css("display","block");
				}

			}

		}

			$('li.headeroptions a').click(function(){

			if($('#nzs_header_options').val() == "flexslider"){
			 

			 	$('#of-option-flexslider').css("display","block");

			}

			if($('#nzs_header_options').val() == "parallax"){
			 

			 	$('#of-option-parallax').css("display","block");

			}

			if($('#nzs_header_options').val() == "fullscreen"){
			 

			 	$('#of-option-fullscreen').css("display","block");

			}

			if($('#nzs_header_options').val() == "customheader"){
			 

			 	$('#of-option-customheader').css("display","block");

			}

			if($('#nzs_header_options').val() == "video-header"){
			 

			 	$('#of-option-videoheader').css("display","block");

			 	if($('#section-nzs_full_video_type label').hasClass('cb-enable selected')){
					$('#of-option-vimeoheader').css("display","none");
					$('#of-option-youtubeheader').css("display","block");
				}else{
					$('#of-option-youtubeheader').css("display","none");
					$('#of-option-vimeoheader').css("display","block");
				}

			}

		});

		$('#nzs_header_options').change(function(){


			$('#of-option-fullscreen,#of-option-flexslider,#of-option-parallax,#of-option-customheader,#of-option-youtubeheader,#of-option-videoheader,#of-option-vimeoheader').hide();

			var currentHeader = $('#nzs_header_options').val();

			if(currentHeader == "flexslider"){
			 

			 	$('#of-option-flexslider').css("display","block");

			}

			if(currentHeader == "parallax"){
			 

			 	$('#of-option-parallax').css("display","block");

			}

			if(currentHeader == "fullscreen"){
			 
				$('#of-option-fullscreen').css("display","block");

			}

			if(currentHeader == "customheader"){
			 
				$('#of-option-customheader').css("display","block");

			}

			if(currentHeader  == "video-header"){
			 

			 	$('#of-option-videoheader').css("display","block");

			 	if($('#section-nzs_full_video_type label').hasClass('cb-enable selected')){
					$('#of-option-vimeoheader').css("display","none");
					$('#of-option-youtubeheader').css("display","block");
				}else{
					$('#of-option-youtubeheader').css("display","none");
					$('#of-option-vimeoheader').css("display","block");
				}


			}


		});



		// if($('#section-nzs_full_video_type label').hasClass('cb-enable selected')){
		// 		$('#of-option-vimeoheader').css("display","none");
		// 		$('#of-option-youtubeheader').css("display","block");
		// 	}else{
		// 		$('#of-option-youtubeheader').css("display","none");
		// 		$('#of-option-vimeoheader').css("display","block");
		// 	}



		$('#section-nzs_full_video_type label').click(function(){
			
			if($(this).hasClass('cb-enable selected')){
				$('#of-option-vimeoheader').css("display","none");
				$('#of-option-youtubeheader').css("display","block");
			}else{
				$('#of-option-youtubeheader').css("display","none");
				$('#of-option-vimeoheader').css("display","block");
			}
		});

		// console.log($('#nzn_header_options').val());

	}); //end doc ready
	
	</script>
	
<?php }


/**
 * Ajax Save Options
 *
 * @uses get_option()
 *
 * @since 1.0.0
 */
function of_ajax_callback() 
{
	global $options_machine, $of_options;

	$nonce=$_POST['security'];
	
	if (! wp_verify_nonce($nonce, 'of_ajax_nonce') ) die('-1'); 
			
	//get options array from db
	$all = of_get_options();
	
	$save_type = $_POST['type'];
	
	//echo $_POST['data'];
	
	//Uploads
	if($save_type == 'upload')
	{
		
		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		 
			$upload_tracking[] = $clickedID;
				
			//update $options array w/ image URL			  
			$upload_image = $all; //preserve current data
			
			$upload_image[$clickedID] = $uploaded_file['url'];
			
			of_save_options($upload_image);
		
				
		 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
		 else { echo $uploaded_file['url']; } // Is the Response
		 
	}
	elseif($save_type == 'image_reset')
	{
			
			$id = $_POST['data']; // Acts as the name
			
			$delete_image = $all; //preserve rest of data
			$delete_image[$id] = ''; //update array key with empty value	 
			of_save_options($delete_image ) ;
	
	}
	elseif($save_type == 'backup_options')
	{
			
		$backup = $all;
		$backup['backup_log'] = date('r');
		
		of_save_options($backup, BACKUPS) ;
			
		die('1'); 
	}
	elseif($save_type == 'restore_options')
	{
			
		$smof_data = of_get_options(BACKUPS);

		of_save_options($smof_data);
		
		die('1'); 
	}
	elseif($save_type == 'import_options'){


		$smof_data = unserialize(base64_decode($_POST['data'])); //100% safe - ignore theme check nag
		of_save_options($smof_data);

		
		die('1'); 
	}
	elseif ($save_type == 'save')
	{

		wp_parse_str(stripslashes($_POST['data']), $smof_data);
		unset($smof_data['security']);
		unset($smof_data['of_save']);
		of_save_options($smof_data);
		wmpl_save_config_file();
		
		
		die('1');
	}
	elseif ($save_type == 'reset')
	{
		of_save_options($options_machine->Defaults);

		wmpl_save_config_file();
		
        die('1'); //options reset
	}

  	die();
}
