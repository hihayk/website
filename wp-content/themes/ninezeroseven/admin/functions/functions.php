<?php


global $smof_data;

// Styling for the custom post type icon
add_action( 'admin_head', 'nzs_custom_type_icons' );
function nzs_custom_type_icons() {
    global $pagenow;
    ?>
    <style type="text/css" media="screen">

	#icon-edit.icon32-posts-page-sections {background: url(<?php echo get_template_directory_uri(); ?>/admin/assets/images/icon-headers32.png) no-repeat;}
   	#icon-edit.icon32-posts-recent_works {background: url(<?php echo get_template_directory_uri(); ?>/admin/assets/images/icon-works32.png) no-repeat;}
   	#icon-edit.icon32-posts-one_page_portfolio {background: url(<?php echo get_template_directory_uri(); ?>/admin/assets/images/icon-portfolio32.png) no-repeat;}
   	#icon-edit.icon32-posts-team_members {background: url(<?php echo get_template_directory_uri(); ?>/admin/assets/images/icon-team32.png) no-repeat;}
   	#icon-edit.icon32-posts-parallax-sections {background: url(<?php echo get_template_directory_uri(); ?>/admin/assets/images/icon-parallax32.png) no-repeat;}

   	td input#nzs_parallax_size,td input#nzs_parallax_overlay_alpha{width:60px !important;}

li.parallax,li.fullscreen,li.flexslider,li.customheader,li.videoheader,li.youtubeheader,li.vimeoheader{display: none;}
    #image-holder { list-style-type: none; margin:4px; padding: 0; width: 100%;overflow: hidden; }
    #image-holder li { margin:2px 0 20px 0; padding: 1px; float: left; width: 110px; text-align: center;cursor: move; }

    #image-holder li img.thumbnail{width:100px !important; height: 100px !important;}
    #image-holder .highlight-place{background-color: #fff;border:3px dashed #00CC33; height: 120px;border-radius: 4px;}
    </style>
    <?php if($pagenow == "nav-menus.php" && !isset($_GET['action'])): ?>

    <script type="text/javascript">

        jQuery(document).ready(function(){

            if(jQuery('#add-page-sections-hide').is(':checked')){
                return
            }else{
                jQuery('.wrap').prepend("<div class='page-section-alert error' style='padding:5px;margin:40px 5px 10px 5px;'><b>Page Sections Menu Not Visible</b><br/>Click on 'Screen Options' in top right corner and check 'Page Sections' for the menu to show up</div>");
            }

            jQuery('#add-page-sections-hide').click(function(){
                if(jQuery('#add-page-sections-hide').is(':checked')){
                    jQuery('.page-section-alert').hide();
                }
            });


        });

    </script>
<?php 
endif;
}


include( get_template_directory() . '/assets/php/install-plugins.php' );

function wmpl_save_config_file(){
    global $smof_data;


    if(!function_exists('icl_register_string')){
        return;
    }


    $wmpl_nzs_strings = '<wpml-config>'."\n";
    $wmpl_nzs_strings .= '<admin-texts>'."\n";
    $wmpl_nzs_strings .= '<key name="theme_mods_ninezeroseven">'."\n";
    $wmpl_nzs_strings .= '<key name="nzs_youtube_heading_text" />'."\n";
    $wmpl_nzs_strings .= '<key name="nzs_youtube_description_text" />'."\n";

    $wmpl_nzs_strings .= '<key name="nzs_vimeo_heading_text" />'."\n";
    $wmpl_nzs_strings .= '<key name="nzs_vimeo_description_text" />'."\n";

    $wmpl_nzs_strings .= '<key name="nzs_parallax_heading_text" />'."\n";
    $wmpl_nzs_strings .= '<key name="nzs_parallax_description_text" />'."\n";

    $wmpl_nzs_strings .= '<key name="nzs_full_screen_slider">'."\n";

    $slides = $smof_data['nzs_full_screen_slider'];

    for($j=1;$j<=count($slides);$j++){
        $wmpl_nzs_strings .= '<key name="'.$j.'">'."\n";
        $wmpl_nzs_strings .= '<key name="title" />'."\n";
        $wmpl_nzs_strings .= '<key name="description" />'."\n";
        $wmpl_nzs_strings .= '</key>'."\n";
    }
    $wmpl_nzs_strings .= '</key>'."\n";

    $wmpl_nzs_strings .= '<key name="nzs_flex_slider">'."\n";
    $slides = $smof_data['nzs_flex_slider'];

    for($j=1;$j<=count($slides);$j++){
        $wmpl_nzs_strings .= '<key name="'.$j.'">'."\n";
        $wmpl_nzs_strings .= '<key name="title" />'."\n";
        $wmpl_nzs_strings .= '<key name="description" />'."\n";
        $wmpl_nzs_strings .= '</key>'."\n";
    }
    $wmpl_nzs_strings .= '</key>'."\n";

    $wmpl_nzs_strings .= '<key name="nzs_custom_header_code" />'."\n";
    $wmpl_nzs_strings .= '<key name="nzs_footer_text" />'."\n";
    $wmpl_nzs_strings .= '</key>'."\n";
    $wmpl_nzs_strings .= '</admin-texts>'."\n";
    $wmpl_nzs_strings .= '</wpml-config>'."\n";


    file_put_contents(get_template_directory().'/wpml-config.xml', $wmpl_nzs_strings, LOCK_EX);


}


function ninezeroseven_unlimited_sidebars() {

    global $smof_data;

    if(isset($smof_data['nzs_side_bars']) && is_array($smof_data['nzs_side_bars'])){

            foreach ($smof_data['nzs_side_bars'] as $key => $value) {

                if($key != 'sidebar-1'){
                    if(!empty($key) && !empty($value)){
                        register_sidebar( array(
                                'name' =>$value,
                                'id' => $key,
                                'before_widget' => '<div class="widget %2$s">',
                                'after_widget' => '</div>',
                                'before_title' => '<div class="heading"><h5>',
                                'after_title' => '</h5></div>',
                            ) );
                    }
                }
            }
        }
}
add_action( 'widgets_init', 'ninezeroseven_unlimited_sidebars' );

?>