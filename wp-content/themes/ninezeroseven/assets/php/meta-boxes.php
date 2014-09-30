<?php
/************************************************************************
* Meta Boxes
*************************************************************************/

$prefix = 'nzs_';

$args = array();
$args['none'] = __('Attach Parallax','framework');


$test_select = new WP_Query( array( 'post_type' => 'parallax-sections', 'posts_per_page' => -1, 'order' => 'ASC' ));

    if($test_select->have_posts()):  while($test_select->have_posts()) : $test_select->the_post();

            $args[get_the_ID()] =  get_the_title();

        endwhile;
    endif;

$args2 = array();
$args2['default'] = __('Use Default','framework');
$args2['none'] = __('None','framework');


$test_select = new WP_Query( array( 'post_type' => 'page-sections', 'posts_per_page' => -1, 'order' => 'ASC' ));

    if($test_select->have_posts()):  while($test_select->have_posts()) : $test_select->the_post();

            $args2[get_the_ID()] =  get_the_title();

        endwhile;
    endif;


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

$nzs_page_layouts = array();
$nzs_page_layouts['1c'] = __('Full Width','framework');
$nzs_page_layouts['2cr'] = __('Right Sidebar','framework');
$nzs_page_layouts['2cl'] = __('Left Sidebar','framework');

$parallax_args = array();
$parallax_args['default'] = __('Use Default','framework');
$parallax_args['none'] = __('None','framework');

$parallax_ops = $parallax_args + $args;


$section_option_meta = array(
    'id' => 'page-section-meta',
    'title' => __('Section Customize Options','framework'),
    'page' => 'page-sections',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Show on Front Page?', 'framework'),
            'desc' => __('Uncheck this box if do not want this section shown on front page', 'framework'),
            'id' => $prefix.'show_front',
            "type" => "check",
            'std' => 'include'
        ),
        array(
            'name' => __('Background Image', 'framework'),
            'desc' => __('Choose a background image for this section.', 'framework'),
            'id' => $prefix.'section_bg_image',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => $prefix.'section_bg_image_button',
            'type' => 'button',
            'std' => 'Browse'
        ),
        array(
            'name' => __('Background color', 'framework'),
            'desc' => __('You can set a custom background color using the color picker, or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'section_bg_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Attach Parallax Section', 'framework'),
            'desc' => __('You can attach a previously created parallax section to show below this on the main page.', 'framework'),
            'id' => $prefix.'parallax_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $args,
        ),
        array(
            'name' => __('Title Bar Heading Color', 'framework'),
            'desc' => __('This is for the font color for the heading tag used in the title bar short code. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'section_tb_h_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Title Bar Sub Heading Color', 'framework'),
            'desc' => __('This is for the font color for the sub-heading tag used in the title bar short code. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'section_tb_sh_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Heading Tag Color', 'framework'),
            'desc' => __('Sets custom color to all h1-h6 tags in this section. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'section_h_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Font Color', 'framework'),
            'desc' => __('Sets custom color to all body font in this section. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'section_font_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Link Color', 'framework'),
            'desc' => __('Sets custom color to all links for this section. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'section_link_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Link Hover Color', 'framework'),
            'desc' => __('Sets custom color to all links hover state for this section. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'section_link_hover_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => $prefix.'section_clear_fields',
            'type' => 'button-clear',
            'std' => 'Clear Fields'
        )

    )
);

/*
 * create boxes
 * */

add_action('admin_menu', 'add_section_meta_boxes');
function add_section_meta_boxes()
{
    global  $section_option_meta;

    add_meta_box($section_option_meta['id'], $section_option_meta['title'], 'show_section_options', $section_option_meta['page'], $section_option_meta['context'], $section_option_meta['priority']);

}


function show_section_options()
{
    global $section_option_meta, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($section_option_meta['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        switch ($field['type']) {





            case 'text':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                break;


            case 'button':
                echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '" value="Browse" />';
                echo     '</td>',
                '</tr>';

                break;


            case 'button-clear':
                echo '<tr><td colspan="2"><input style="float: right;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '" value="Clear Fields" />';
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        $('#nzs_section_clear_fields').click(function(){
                            if(confirm("Are you sure you want to clear fields?")){
                                 $('#<?php echo $section_option_meta['id'];?> input[type="text"]').val('');
                             }
                        });
                    });

                </script>
                <?php
                echo     '</td>',
                '</tr>';

                break;


            case 'select':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select name="' . $field['id'] . '">';

                foreach ($field['options'] as $option) {

                    echo'<option';
                    if ($meta == $option) {
                        echo ' selected="selected"';
                    }
                    echo'>' . $option . '</option>';

                }

                echo'</select>';

                break;

 
            case 'select-custom':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select name="' . $field['id'] . '">';

                foreach ($field['options'] as $key => $option) {

                    echo'<option';
                    if ($meta == $key) {
                        echo ' selected="selected"';
                    }
                    echo' value="'.$key.'">' . $option . '</option>';

                }

                echo'</select>';

                break;

            case 'color':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo '<div id="' . $field['id'] . '_picker" class="colorSelector"><div></div></div>';
                echo '<input style="width:75px; margin-left: 5px;" class="tz-color" name="' . $field['id'] . '" id="' . $field['id'] . '" type="text" value="' . $meta . '" />';
                ?>
            <script type="text/javascript" language="javascript">
                jQuery(document).ready(function () {
                    //Color Picker
                    jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '<?php echo $meta; ?>');
                    jQuery('#<?php echo $field['id']; ?>_picker').ColorPicker({
                        color:'<?php echo $meta; ?>',
                        onShow:function (colpkr) {
                            jQuery(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide:function (colpkr) {
                            jQuery(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange:function (hsb, hex, rgb) {
                            jQuery(this).css('border','1px solid red');
                            jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '#' + hex);
                            jQuery('#<?php echo $field['id']; ?>_picker').next('input').attr('value', '#' + hex);
                        }
                    });
                });
            </script>
            <?php       break;

        }

    }

    echo '</table>';
}

add_action('save_post', 'section_save_options');


/*
 * save metadata
 * */
function section_save_options($post_id)
{
    global $section_option_meta,$post;
    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($section_option_meta['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];

           // echo $new;
        }

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);

        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }



}




// PARALLAX META





$parallax_option_meta = array(
    'id' => 'parallax-meta',
    'title' => __('Parallax Customize Options','framework'),
    'page' => 'parallax-sections',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Enable Video BG?', 'framework'),
            'desc' => __('Check this box to enable video bg option', 'framework'),
            'id' => $prefix.'video_bg_enable',
            "type" => "checkbox",
            'std' => 'disabled'
        ),
        array(
            'name' => __('WebM Video', 'framework'),
            'desc' => __('Enter URL to WebM video, you should enter MP4 as well below.', 'framework'),
            'id' => $prefix.'video_bg_path_webm',
            "type" => "regtext",
            'std' => ''
        ),
        array(
            'name' => __('MP4 Video', 'framework'),
            'desc' => __('Enter URL to MP4 video', 'framework'),
            'id' => $prefix.'video_bg_path_mp4',
            "type" => "regtext",
            'std' => ''
        ),
        array(
            'name' => __('OGV Video', 'framework'),
            'desc' => __('Enter URL to OGV video', 'framework'),
            'id' => $prefix.'video_bg_path_ogv',
            "type" => "regtext",
            'std' => ''
        ),
        array(
            'name' => __('Poster Image', 'framework'),
            'desc' => __('Add poster image which is displayed before load and non supported browsers. Demo theme uses 1799 x 970', 'framework'),
            'id' => $prefix.'video_poster_image',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => $prefix.'parallax_bg_video_button',
            'type' => 'button',
            'std' => 'Browse'
        ),
        array(
            'name' => __('Background Image', 'framework'),
            'desc' => __('Choose a background image for this section. Demo theme uses 1799 x 970', 'framework'),
            'id' => $prefix.'parallax_bg_image',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => $prefix.'parallax_bg_image_button',
            'type' => 'button',
            'std' => 'Browse'
        ),
        array(
            'name' => __('Background Repeat Options', 'framework'),
            'desc' => __('Choose your background options. Default is repeating background', 'framework'),
            'id' => $prefix.'parallax_repeat',
            'type' => 'select-custom',
            'std' => 'none',
            'options' => array(
                'none' => 'Default',
                'no-repeat' =>'No Repeat',
                'cover' => 'Cover'
            ),
        ),
        array(
            'name' => __('Parallax Speed', 'framework'),
            'desc' => __('Use the drop down to delect a speed for how much image moves in parallax section. Default 0.3', 'framework'),
            'id' => $prefix.'parallax_speed',
            'type' => 'select-custom',
            'std' => 'default',
            'options' => array(
                'default' => 'Default',
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
                ),
        ),
        array(
            'name' => __('Parallax Section Size', 'framework'),
            'desc' => __('Change the height(pixel or percent) of the parallax section. Default 500px', 'framework'),
            'id' => $prefix.'parallax_size',
            "type" => "text",
            'std' => '500px'
        ),
        array(
            'name' => __('Background color', 'framework'),
            'desc' => __('You can set a custom background color using the color picker, or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'parallax_bg_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Color Overlay', 'framework'),
            'desc' => __('You can set a custom color overlay using the color picker, or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'parallax_overlay_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Color Overlay Opacity', 'framework'),
            'desc' => __('Set color overlay opacity, this allows to see through to background. Enter 1-100', 'framework'),
            'id' => $prefix.'parallax_overlay_alpha',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Title Bar Heading Color', 'framework'),
            'desc' => __('This is for the font color for the heading tag used in the title bar short code. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'parallax_tb_h_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Title Bar Sub Heading Color', 'framework'),
            'desc' => __('This is for the font color for the sub-heading tag used in the title bar short code. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'parallax_tb_sh_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Heading Tag Color', 'framework'),
            'desc' => __('Sets custom color to all h1-h6 tags in this section. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'parallax_h_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Font Color', 'framework'),
            'desc' => __('Sets custom color to all body font in this section. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'parallax_font_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Link Color', 'framework'),
            'desc' => __('Sets custom color to all links for this section. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'parallax_link_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Link Hover Color', 'framework'),
            'desc' => __('Sets custom color to all links hover state for this section. Use color picker or enter a hex value (i.e #ff0000).', 'framework'),
            'id' => $prefix.'parallax_link_hover_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => $prefix.'parallax_clear_fields',
            'type' => 'button-clear',
            'std' => 'Clear Fields'
        )

    )
);

/*
 * create boxes
 * */

add_action('admin_menu', 'add_parallax_meta_boxes');
function add_parallax_meta_boxes()
{
    global  $parallax_option_meta;

    add_meta_box($parallax_option_meta['id'], $parallax_option_meta['title'], 'show_parallax_options', $parallax_option_meta['page'], $parallax_option_meta['context'], $parallax_option_meta['priority']);

}


function show_parallax_options()
{
    global $parallax_option_meta, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($parallax_option_meta['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        switch ($field['type']) {

            case 'checkbox':
                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta
                    : $field['std'], '"';

                    if(isset($meta) && $meta == 'enabled' ) echo 'checked';



                    echo ' />';

                echo '</td></tr>';

                break;

            case 'regtext':
                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? esc_url($meta)
                    : esc_url($field['std']), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

               
                echo '</td></tr>';

                break;

            case 'text':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                break;


            case 'button':
                echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '" value="Browse" />';
                echo     '</td>',
                '</tr>';

                break;


            case 'button-clear':
                echo '<tr><td colspan="2"><input style="float: right;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '" value="Clear Fields" />';
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        $('#nzs_parallax_clear_fields').click(function(){
                            if(confirm("Are you sure you want to clear fields?")){
                                 $('#<?php echo $parallax_option_meta['id'];?> input[type="text"]').val('');
                             }
                        });
                    });

                </script>
                <?php
                echo     '</td>',
                '</tr>';

                break;


            case 'select':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select name="' . $field['id'] . '">';

                foreach ($field['options'] as $option) {

                    echo'<option';
                    if ($meta == $option) {
                        echo ' selected="selected"';
                    }
                    echo'>' . $option . '</option>';

                }

                echo'</select>';

                break;


            case 'select-custom':

                echo '<tr>',
                '<th style="width:25%" class="',$field['id'],'"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select name="' . $field['id'] . '">';

                foreach ($field['options'] as $key => $option) {

                    echo'<option';
                    if ($meta == $key) {
                        echo ' selected="selected"';
                    }
                    echo' value="'.$key.'">' . $option . '</option>';

                }

                echo'</select>';

                break;

            case 'color':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo '<div id="' . $field['id'] . '_picker" class="colorSelector"><div></div></div>';
                echo '<input style="width:75px; margin-left: 5px;" class="tz-color" name="' . $field['id'] . '" id="' . $field['id'] . '" type="text" value="' . $meta . '" />';
                ?>
            <script type="text/javascript" language="javascript">
                jQuery(document).ready(function () {
                    //Color Picker
                    jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '<?php echo $meta; ?>');
                    jQuery('#<?php echo $field['id']; ?>_picker').ColorPicker({
                        color:'<?php echo $meta; ?>',
                        onShow:function (colpkr) {
                            jQuery(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide:function (colpkr) {
                            jQuery(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange:function (hsb, hex, rgb) {
                            jQuery(this).css('border','1px solid red');
                            jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '#' + hex);
                            jQuery('#<?php echo $field['id']; ?>_picker').next('input').attr('value', '#' + hex);
                        }
                    });
                });
            </script>
            <?php       break;

        }

    }

    echo '</table>';
}

add_action('save_post', 'parallax_save_options');


/*
 * save metadata
 * */
function parallax_save_options($post_id)
{
    global $parallax_option_meta;
    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($parallax_option_meta['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {

            $new = $_POST[$field['id']];

            if(isset($_POST['nzs_video_bg_enable']) && $field['id'] == 'nzs_video_bg_enable'){
                $new = 'enabled';
            }elseif($field['id'] == 'nzs_video_bg_enable'){
                $new = 'disabled';
            }
        }

        

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }



}



$team_option_meta = array(
    'id' => 'team-meta',
    'title' => __('Member Social Info/Extras','framework'),
    'page' => 'team_members',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Optional Link', 'framework'),
            'desc' => __('This links the member\'s image', 'framework'),
            'id' => $prefix.'team_link_option',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Link Window Option', 'framework'),
            'desc' => __('Choose new window or default', 'framework'),
            'id' => $prefix.'team_link_window',
            'type' => 'select-custom',
            'std' => '_self',
            'options' => array(
                '_self' => 'Default',
                '_blank' => 'New Window'
                ),
        ),
        array(
            'name' => __('Twitter Link', 'framework'),
            'desc' => __('Add Twitter Link', 'framework'),
            'id' => $prefix.'member_social_twitter',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Facebook Link', 'framework'),
            'desc' => __('Add Facebook Link.', 'framework'),
            'id' => $prefix.'member_social_facebook',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Google Link', 'framework'),
            'desc' => __('Add Google Link.', 'framework'),
            'id' => $prefix.'member_social_google',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Flickr Link', 'framework'),
            'desc' => __('Add Flickr Link.', 'framework'),
            'id' => $prefix.'member_social_flickr',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('LinkedIn Link', 'framework'),
            'desc' => __('Add LinkedIn Link.', 'framework'),
            'id' => $prefix.'member_social_linkedin',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Pinterest Link', 'framework'),
            'desc' => __('Add Pinterest Link.', 'framework'),
            'id' => $prefix.'member_social_pinterest',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Dribbble Link', 'framework'),
            'desc' => __('Add Dribbble Link.', 'framework'),
            'id' => $prefix.'member_social_dribbble',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('DeviantArt Link', 'framework'),
            'desc' => __('Add DeviantArt Link.', 'framework'),
            'id' => $prefix.'member_social_deviantart',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Youtube Link', 'framework'),
            'desc' => __('Add Youtube Link.', 'framework'),
            'id' => $prefix.'member_social_youtube',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Vimeo Link', 'framework'),
            'desc' => __('Add Vimeo Link.', 'framework'),
            'id' => $prefix.'member_social_vimeo',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Instagram Link', 'framework'),
            'desc' => __('Add Instagram Link.', 'framework'),
            'id' => $prefix.'member_social_instagram',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Email Link', 'framework'),
            'desc' => __('Add Email Link.', 'framework'),
            'id' => $prefix.'member_social_email',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Soundcloud Link', 'framework'),
            'desc' => __('Add Soundcloud Link.', 'framework'),
            'id' => $prefix.'member_social_soundcloud',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Behance Link', 'framework'),
            'desc' => __('Add Behance Link.', 'framework'),
            'id' => $prefix.'member_social_behance',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Ustream Link', 'framework'),
            'desc' => __('Add Ustream Link.', 'framework'),
            'id' => $prefix.'member_social_ustream',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('RSS Link', 'framework'),
            'desc' => __('Add RSS Link.', 'framework'),
            'id' => $prefix.'member_social_rss',
            "type" => "text",
            'std' => ''
        )

    )
);

/*
 * create boxes
 * */

add_action('admin_menu', 'add_team_meta_boxes');
function add_team_meta_boxes()
{
    global  $team_option_meta;

    add_meta_box($team_option_meta['id'], $team_option_meta['title'], 'show_team_options', $team_option_meta['page'], $team_option_meta['context'], $team_option_meta['priority']);

}


function show_team_options()
{
    global $team_option_meta, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($team_option_meta['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        switch ($field['type']) {


            case 'select-custom':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select name="' . $field['id'] . '">';

                foreach ($field['options'] as $key => $option) {

                    echo'<option';
                    if ($meta == $key) {
                        echo ' selected="selected"';
                    }
                    echo' value="'.$key.'">' . $option . '</option>';

                }

                echo'</select></td></tr>';

                break;



            case 'text':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                echo '</td></tr>';

                break;


            

        }

    }

    echo '</table>';
}

add_action('save_post', 'team_save_options');


/*
 * save metadata
 * */
function team_save_options($post_id)
{
    global $team_option_meta;
    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($team_option_meta['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }



}



/************************************************************************
* Post MetaBox
*************************************************************************/


$custom_post_box = array(
    'id' => 'post-meta-box',
    'title' => __('Post Options','framework'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Featured post type', 'framework'),
            'desc' => __('You can select to have a slider or video post.', 'framework'),
            'id' => $prefix.'portfolio_type',
            'type' => 'select-custom',
            'std' => 'image',
            'options' => array('image' => __('Image','framework'),'video' => __('Video','framework'))
        ),
        array(
            'name' => __('Slider Images','framework'),
            'desc' => __('If you would like to add more images for a slider, you can add them here.','framework'),
            'id' => $prefix.'image_fields',
            'type' => 'image-blocks',
            'std' => '',
            'options' => array()
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => $prefix.'portfolio_gallery',
            'type' => 'button',
            'std' => 'Browse'
        ),
        array(
            'name' => __('Add a Video Link','framework'),
            'desc' => __('You can add a Youtube or Vimeo URL here.','framework'),
            'id' => $prefix.'video_link',
            'type' => 'text-input',
            'std' => ''
        ),

        array(
            'name' => __('Attach Parallax Section', 'framework'),
            'desc' => __('You can attach a previously created parallax section to show below this on the main page.', 'framework'),
            'id' => $prefix.'parallax_custom_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $parallax_ops,
        ),
        array(
            'name' => __('Attach Page Section', 'framework'),
            'desc' => __('You can attach a previously created page section to show below this on the main page.', 'framework'),
            'id' => $prefix.'page_section_custom_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $args2,
        ),

        array(
            'name' => __('Available Sidebars', 'framework'),
            'desc' => __('You can set a different sidebar here.', 'framework'),
            'id' => $prefix.'unlimited_sidebar',
            'type' => 'select-custom',
            'std' => '',
            'options' => $nzs_side_bars,
        ),
        array(
            'name' => __('Page Template', 'framework'),
            'desc' => __('Page layout choices', 'framework'),
            'id' => $prefix.'page_layout',
            'type' => 'select-custom',
            'std' => (isset($smof_data['nzs_single_page_layout'])) ? $smof_data['nzs_single_page_layout'] : '2cr',
            'options' => $nzs_page_layouts,
        )

    )
);

/*
 * create boxes
 * */

add_action('admin_menu', 'add_post_boxes');
function add_post_boxes()
{
    global  $custom_post_box;

    add_meta_box($custom_post_box['id'], $custom_post_box['title'], 'show_post_custom', $custom_post_box['page'], $custom_post_box['context'], $custom_post_box['priority']);

}


function show_post_custom()
{
    global $custom_post_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<span class="current-post" id='.$post->ID.'></span>';

    echo '<table class="form-table">';

    foreach ($custom_post_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        switch ($field['type']) {

            case 'image-blocks':

                echo '<tr id='.$field['id'].'>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                

                   

                    echo'<ul id="image-holder" style="overflow:hidden;">';
                    
                     if(is_array($meta)){
                   
                    foreach ($meta as $key => $option) {

                        $image_attributes = wp_get_attachment_image_src( $option ,'editor-thumbs');

                        if($image_attributes[0]){

                            echo '<li>';
                            echo '<input type="hidden" name="nzs_image_fields[]" value="'.$option.'" />';
                            echo '<img style="padding:3px;background-color:#fff;box-shadow:1px 1px 2px #d8d8d8;" width="150" height="150" class="thumbnail" src="'.$image_attributes[0].'" /><br/>';
                            echo '<a href="#" class="remove-image">remove</a></li>';

                        }

                    }
                }

                    echo'</ul>';



                break;


            case 'text-input':

                echo '<tr id='.$field['id'].'>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? strip_tags($meta)
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                echo '</td></tr>';

                break;


            case 'text':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? esc_attr(strip_tags($meta))
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                break;


            case 'button':
                echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '" value="Upload Slider Images" />';
                echo     '</td>',
                '</tr>';

                break;

            case 'select-custom':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select id="' . $field['id'] . '" name="' . $field['id'] . '">';

                foreach ($field['options'] as $key => $option) {

                    echo'<option';
                    if ($meta == $key) {
                        echo ' selected="selected"';
                    }elseif(empty($meta) && isset($field['std']) && !empty($field['std'])){
                        if ($field['std'] == $key) {
                        echo ' selected="selected"';
                        }
                    }
                    echo' value="'.$key.'">' . $option . '</option>';

                }

                echo'</select>';
                echo'</td>';
                echo'</tr>';

                break;


        }

    }

    echo '</table>';
}

add_action('save_post', 'save_post_meta_custom');


/*
 * save metadata
 * */
function save_post_meta_custom($post_id)
{
    global $custom_post_box;
    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($custom_post_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];

            if('nzs_video_link' == $field['id']){

                $video_url = esc_url($new);


                if( 1 === preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$video_url , $matches)){

                    $video_url = 'http://www.youtube.com/embed/'.$matches[1];

                    $new = $video_url;

                }elseif( 1 === preg_match('/vimeo.com\/(?:video\/)?([0-9]+)/', $video_url , $matches)){
                  
                    $video_url = 'http://vimeo.com/'.$matches[1];

                    $new = $video_url;

                
                }

            }
            
        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }



}


/************************************************************************
* Page MetaBox
*************************************************************************/


$custon_page_box = array(
    'id' => 'page-meta-box',
    'title' => __('Extra Page Options','framework'),
    'page' => 'page',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Attach Parallax Section', 'framework'),
            'desc' => __('Attach a parallax section to the this page. Default uses what you set in themeoptions.', 'framework'),
            'id' => $prefix.'parallax_custom_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $parallax_ops,
        ),
        array(
            'name' => __('Attach Page Section', 'framework'),
            'desc' => __('Attach a page section to the this page. Default uses what you set in themeoptions.', 'framework'),
            'id' => $prefix.'page_section_custom_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $args2,
        ),

        array(
            'name' => __('Available Sidebars', 'framework'),
            'desc' => __('You can set a different sidebar here.', 'framework'),
            'id' => $prefix.'unlimited_sidebar',
            'type' => 'select-custom',
            'std' => '',
            'options' => $nzs_side_bars,
        )

    )
);

/*
 * create boxes
 * */

add_action('admin_menu', 'add_page_box');
function add_page_box()
{
    global  $custon_page_box;

    add_meta_box($custon_page_box['id'], $custon_page_box['title'], 'show_page_box', $custon_page_box['page'], $custon_page_box['context'], $custon_page_box['priority']);

}


function show_page_box()
{
    global $custon_page_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($custon_page_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        switch ($field['type']) {


                //If Select
            case 'select-custom':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select name="' . $field['id'] . '" style="min-width:200px;">';

                foreach ($field['options'] as $key => $option) {

                    echo'<option';
                    if ($meta == $key) {
                        echo ' selected="selected"';
                    }
                    echo' value="'.$key.'">' . $option . '</option>';

                }

                echo'</select></tr></td>';

                break;

        }

    }

    echo '</table>';
}

add_action('save_post', 'save_page_meta_custom');


/*
 * save metadata
 * */
function save_page_meta_custom($post_id)
{
    global $custon_page_box;
    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($custon_page_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }



}

/************************************************************************
* Portfolio Meta
*************************************************************************/


$portfolio_meta_box = array(
    'id' => 'portfolio-meta',
    'title' => __('Portfolio Options','framework'),
    'page' => 'one_page_portfolio',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Portfolio Type', 'framework'),
            'desc' => __('Here you can select if this is a video or image.', 'framework'),
            'id' => $prefix.'portfolio_type',
            'type' => 'select-custom',
            'std' => 'image',
            'options' => array('image' => __('Image','framework'),'video' => __('Video','framework'))
        ),
        array(
            'name' => __('PrettyPhoto Gallery','framework'),
            'desc' => __('If you would like to add more images to PrettyPhoto popup, you can add them here.','framework'),
            'id' => $prefix.'image_fields',
            'type' => 'image-blocks',
            'std' => '',
            'options' => array()
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => $prefix.'portfolio_gallery',
            'type' => 'button',
            'std' => 'Browse'
        ),
        array(
            'name' => __('Add a Video Link','framework'),
            'desc' => __('You can add a Youtube or Vimeo URL here.','framework'),
            'id' => $prefix.'video_link',
            'type' => 'text-input',
            'std' => ''
        ),
        array(
            'name' => __('Attach Parallax Section', 'framework'),
            'desc' => __('You can attach a previously created parallax section to show below this on the main page.', 'framework'),
            'id' => $prefix.'parallax_custom_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $parallax_ops,
        ),
        array(
            'name' => __('Attach Page Section', 'framework'),
            'desc' => __('You can attach a previously created page section to show below this on the main page.', 'framework'),
            'id' => $prefix.'page_section_custom_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $args2,
        ),
        array(
            'name' => __('Available Sidebars', 'framework'),
            'desc' => __('You can set a different sidebar here.', 'framework'),
            'id' => $prefix.'unlimited_sidebar',
            'type' => 'select-custom',
            'std' => '',
            'options' => $nzs_side_bars,
        ),
        array(
            'name' => __('Page Template', 'framework'),
            'desc' => __('Page layout choices', 'framework'),
            'id' => $prefix.'page_layout',
            'type' => 'select-custom',
            'std' => (isset($smof_data['nzs_portfolio_page_layout'])) ? $smof_data['nzs_portfolio_page_layout'] : '2cr',
            'options' => $nzs_page_layouts,
        ),
        array(
            'name' => __('External Link','framework'),
            'desc' => __('You can add a external link here.','framework'),
            'id' => $prefix.'external_link',
            'type' => 'text-input',
            'std' => ''
        )     

    )
);

// echo $smof_data['nzs_portfolio_page_layout'];

/*
 * create boxes
 * */

add_action('admin_menu', 'add_portfolio_meta_boxes');
function add_portfolio_meta_boxes()
{
    global  $portfolio_meta_box;

    add_meta_box($portfolio_meta_box['id'], $portfolio_meta_box['title'], 'show_portfolio_options', $portfolio_meta_box['page'], $portfolio_meta_box['context'], $portfolio_meta_box['priority']);

}


function show_portfolio_options()
{
    global $portfolio_meta_box, $post;




    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($portfolio_meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);


        switch ($field['type']) {



            case 'select-custom':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select id="' . $field['id'] . '" name="' . $field['id'] . '">';

                foreach ($field['options'] as $key => $option) {

                    echo'<option';
                    if ($meta == $key) {
                        echo ' selected="selected"';
                    }elseif(empty($meta) && isset($field['std']) && !empty($field['std'])){
                        if ($field['std'] == $key) {
                        echo ' selected="selected"';
                        }
                    }
                    echo' value="'.$key.'">' . $option . '</option>';

                }


                echo'</select>';

                // if(empty($meta)){echo $field['std'] ; }
                echo'</td>';
                echo'</tr>';

                break;


            case 'image-blocks':

                echo '<tr id='.$field['id'].'>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                    echo'<ul id="image-holder" style="overflow:hidden;">';
                    
                     if(is_array($meta)){
                   
                    foreach ($meta as $key => $option) {

                        $image_attributes = wp_get_attachment_image_src( $option ,'editor-thumbs');

                        if($image_attributes[0]){

                            echo '<li>';
                            echo '<input type="hidden" name="nzs_image_fields[]" value="'.$option.'" />';
                            echo '<img style="padding:3px;background-color:#fff;box-shadow:1px 1px 2px #d8d8d8;" width="150" height="150" class="thumbnail" src="'.$image_attributes[0].'" /><br/>';
                            echo '<a href="#" class="remove-image">remove</a></li>';

                        }

                    }
                }

                    echo'</ul>';



                break;


            case 'text-input':

                echo '<tr id='.$field['id'].'>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? strip_tags($meta)
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                echo '</td></tr>';

                break;


            case 'button':
                echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '" value="Upload Slider Images" />';
                echo     '</td>',
                '</tr>';

                break;




        }

    }

    echo '</table>';
}

add_action('save_post', 'portfolio_save_options');


/*
 * save metadata
 * */
function portfolio_save_options($post_id)
{
    global $portfolio_meta_box;

    // print_r($_POST);

    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($portfolio_meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);

     if (isset($_POST[$field['id']])) {


         $new = $_POST[$field['id']];

            if('nzs_video_link' == $field['id']){

                $video_url = esc_url($new);


                if( 1 === preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$video_url , $matches)){

                    $video_url = 'http://www.youtube.com/embed/'.$matches[1];

                    $new = $video_url;

                }elseif( 1 === preg_match('/vimeo.com\/(?:video\/)?([0-9]+)/', $video_url , $matches)){
                  
                    $video_url = 'http://vimeo.com/'.$matches[1];

                    $new = $video_url;

                
                }

            }

        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }



}


/************************************************************************
* RECENT WORKS
*************************************************************************/

$recent_works_meta_box = array(
    'id' => 'recent-works-meta',
    'title' => __('Works Options','framework'),
    'page' => 'recent_works',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Project Type', 'framework'),
            'desc' => __('Here you can select if this is a video or image.', 'framework'),
            'id' => $prefix.'portfolio_type',
            'type' => 'select-custom',
            'std' => 'image',
            'options' => array('image' => __('Image','framework'),'video' => __('Video','framework'))
        ),
        array(
            'name' => __('PrettyPhoto Gallery','framework'),
            'desc' => __('If you would like to add more images to PrettyPhoto popup, you can add them here.','framework'),
            'id' => $prefix.'image_fields',
            'type' => 'image-blocks',
            'std' => '',
            'options' => array()
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => $prefix.'portfolio_gallery',
            'type' => 'button',
            'std' => 'Browse'
        ),
        array(
            'name' => __('Add a Video Link','framework'),
            'desc' => __('You can add a Youtube or Vimeo URL here.','framework'),
            'id' => $prefix.'video_link',
            'type' => 'text-input',
            'std' => ''
        ),
        array(
            'name' => __('Attach Parallax Section', 'framework'),
            'desc' => __('You can attach a previously created parallax section to show below this on the main page.', 'framework'),
            'id' => $prefix.'parallax_custom_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $parallax_ops,
        ),
        array(
            'name' => __('Attach Page Section', 'framework'),
            'desc' => __('You can attach a previously created page section to show below this on the main page.', 'framework'),
            'id' => $prefix.'page_section_custom_attach',
            'type' => 'select-custom',
            'std' => '',
            'options' => $args2,
        ),
        array(
            'name' => __('Available Sidebars', 'framework'),
            'desc' => __('You can set a different sidebar here.', 'framework'),
            'id' => $prefix.'unlimited_sidebar',
            'type' => 'select-custom',
            'std' => '',
            'options' => $nzs_side_bars,
        ),
        array(
            'name' => __('Page Template', 'framework'),
            'desc' => __('Page layout choices', 'framework'),
            'id' => $prefix.'page_layout',
            'type' => 'select-custom',
            'std' => (isset($smof_data['nzs_works_page_layout'])) ? $smof_data['nzs_works_page_layout'] : '2cr',
            'options' => $nzs_page_layouts,
        ),
        array(
            'name' => __('External Link','framework'),
            'desc' => __('You can add a external link here.','framework'),
            'id' => $prefix.'external_link',
            'type' => 'text-input',
            'std' => ''
        )      

    )
);

/*
 * create boxes
 * */

add_action('admin_menu', 'add_works_meta_boxes');
function add_works_meta_boxes()
{
    global  $recent_works_meta_box;

    add_meta_box($recent_works_meta_box['id'], $recent_works_meta_box['title'], 'show_works_options', $recent_works_meta_box['page'], $recent_works_meta_box['context'], $recent_works_meta_box['priority']);

}


function show_works_options()
{
    global $recent_works_meta_box, $post;




    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($recent_works_meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);


        switch ($field['type']) {



            case 'select-custom':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select id="' . $field['id'] . '" name="' . $field['id'] . '">';

                foreach ($field['options'] as $key => $option) {

                    echo'<option';
                    if ($meta == $key) {
                        echo ' selected="selected"';
                    }elseif(empty($meta) && isset($field['std']) && !empty($field['std'])){
                        if ($field['std'] == $key) {
                        echo ' selected="selected"';
                        }
                    }
                    echo' value="'.$key.'">' . $option . '</option>';

                }

                echo'</select>';
                echo'</td>';
                echo'</tr>';

                break;


            case 'image-blocks':

                echo '<tr id='.$field['id'].'>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                    echo'<ul id="image-holder" style="overflow:hidden;">';
                    
                     if(is_array($meta)){
                   
                    foreach ($meta as $key => $option) {

                        $image_attributes = wp_get_attachment_image_src( $option ,'editor-thumbs');

                        if($image_attributes[0]){

                            echo '<li>';
                            echo '<input type="hidden" name="nzs_image_fields[]" value="'.$option.'" />';
                            echo '<img style="padding:3px;background-color:#fff;box-shadow:1px 1px 2px #d8d8d8;" width="150" height="150" class="thumbnail" src="'.$image_attributes[0].'" /><br/>';
                            echo '<a href="#" class="remove-image">remove</a></li>';

                        }

                    }
                }

                    echo'</ul>';



                break;


            case 'text-input':

                echo '<tr id='.$field['id'].'>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? strip_tags($meta)
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                echo '</td></tr>';

                break;


            case 'button':
                echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '" value="Upload Slider Images" />';
                echo     '</td>',
                '</tr>';

                break;




        }

    }

    echo '</table>';
}

add_action('save_post', 'works_save_options');


/*
 * save metadata
 * */
function works_save_options($post_id)
{
    global $recent_works_meta_box;

    // print_r($_POST);

    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($recent_works_meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);

     if (isset($_POST[$field['id']])) {


         $new = $_POST[$field['id']];

            if('nzs_video_link' == $field['id']){

                $video_url = esc_url($new);


                if( 1 === preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$video_url , $matches)){

                    $video_url = 'http://www.youtube.com/embed/'.$matches[1];

                    $new = $video_url;

                }elseif( 1 === preg_match('/vimeo.com\/(?:video\/)?([0-9]+)/', $video_url , $matches)){
                  
                    $video_url = 'http://vimeo.com/'.$matches[1];

                    $new = $video_url;

                
                }

            }

        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }



}

?>