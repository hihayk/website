<?php
    /*
    Plugin Name: Gravity Forms HubSpot Add-On
    Plugin URI: http://wordpress.org/extend/plugins/hubspot-for-gravity-forms/
    Description: <a href="http://www.23systems.net/gravity-forms/" rel="nofollow">Gravity Forms</a> HubSpot Add-On uses the <a href="http://www.hubspot.com" rel="nofollow">HubSpot</a> Lead API to allow you to send your Gravity Forms based landing pages to send lead information to HubSpot.
    Version: 1.0-beta
    Author: Dan Zappone
    Author URI: http://www.23systems.net
    */

    /**
    * Ensure class doesn't already exist
    */
    if (!class_exists('GFHubspot')) {
        class GFHubspot {

            private static $path = "gravity-forms-hubspot/gf-hubspot.php";
            private static $url = "http://www.gravityforms.com";
            private static $slug = "gravity-forms-hubspot";
            private static $version = "1.0";
            private static $min_gravityforms_version = "1.3.9";

            // Plugin starting point. Will load appropriate files
            public static function init(){

                add_action("admin_notices", array('GFHubspot', 'is_gravity_forms_installed'), 10);

                if(!self::is_gravityforms_supported()){
                    return;
                }

                if(is_admin()){
                    //creates a new Settings page on Gravity Forms' settings screen
                    if(self::has_access("gravityforms_hubspot")){
                        RGForms::add_settings_page("HubSpot", array("GFHubspot", "settings_page"), self::get_base_url() . "/hubspot-50x50.png");
                    }
                }

                //creates the subnav left menu
                add_filter("gform_addon_navigation", array('GFHubspot', 'create_menu'));

                if(self::is_hubspot_page()) {
                    //enqueueing sack for AJAX requests
                    wp_enqueue_script(array("sack"));
                    wp_enqueue_style('gravityforms-admin', GFCommon::get_base_url().'/css/admin.css');
                } elseif(in_array(RG_CURRENT_PAGE, array("admin-ajax.php"))){
                    add_action('wp_ajax_rg_update_feed_active', array('GFHubspot', 'update_feed_active'));
                    add_action('wp_ajax_gf_select_hubspot_form', array('GFHubspot', 'select_hubspot_form'));
                } elseif(in_array(RG_CURRENT_PAGE, array('admin.php'))) {
                    add_action('admin_head', array('GFHubspot', 'show_hubspot_status'));
                } else {
                    add_action("gform_pre_submission", array('GFHubspot', 'push'), 10, 2); //handling post submission.
                }

                #add_action("gform_field_advanced_settings", array('GFHubspot',"add_hubspot_editor_field"), 10, 2); // For future use

                add_action("gform_editor_js", array('GFHubspot', 'add_form_option_js'), 10);

                add_filter('gform_tooltips', array('GFHubspot', 'add_form_option_tooltip'));

                add_filter("gform_confirmation", array('GFHubspot', 'confirmation_error'));
            }

            public function add_hubspot_editor_field($position, $form_id) {
                /* For future use */
            }

            public static function confirmation_error($confirmation, $form = '', $lead = '', $ajax ='' ) {

                if(current_user_can('administrator') && !empty($_REQUEST['hubspotErrorMessage'])) {
                    $confirmation .= sprintf(__('%sThe entry was not added to HubSpot because %sboth first and last names are required%s, and were not detected. %sYou are only being shown this because you are an administrator. Other users will not see this message.%s%s', 'gravity-forms-hubspot'), '<div class="error" style="text-align:center; color:#790000; font-size:14px; line-height:1.5em; margin-bottom:16px;background-color:#FFDFDF; margin-bottom:6px!important; padding:6px 6px 4px 6px!important; border:1px dotted #C89797">', '<strong>', '</strong>', '<em>', '</em>', '</div>');
                }
                return $confirmation;
            }

            public static function add_form_option_tooltip($tooltips) {
                $tooltips["form_hubspot"] = "<h6>" . __("Enable HubSpot Integration", "gravity-forms-hubspot") . "</h6>" . __("Check this box to integrate this form with HubSpot. When an user submits the form, the data will be added to HubSpot.", "gravity-forms-hubspot");
                return $tooltips;
            }

            public static function show_hubspot_status() {
                global $pagenow;

                if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'gf_edit_forms' && !isset($_REQUEST['id'])) {
                    $activeforms = array();
                    $forms = RGFormsModel::get_forms();
                    if(!is_array($forms)) { return; }
                    foreach($forms as $form) {
                        $form = RGFormsModel::get_form_meta($form->id);
                        if(is_array($form) && !empty($form['enableHubSpot'])) {
                            $activeforms[] = $form['id'];
                        }
                    }

                    if(!empty($activeforms)) {
                    ?>
                    <style type="text/css">
                        td a.row-title span.hubspot_enabled {
                            position: absolute;
                            background: url('<?php echo WP_PLUGIN_URL ?>/gravity-forms-hubspot/hubspot-16x16.png') right top no-repeat;
                            height: 16px;
                            width: 16px;
                            margin-left: 10px;
                        }
                    </style>

                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $('table tbody.user-list tr').each(function() {
                                <?php
                                    foreach ($activeforms as &$value) {
                                    ?>
                                    if($('td.column-id', $(this)).text() ==  <?php echo $value; ?>) {
                                        $('td a.row-title', $(this)).append('<span class="hubspot_enabled" title="<?php _e('HubSpot integration is enabled for this Form', "gravity-forms-hubspot"); ?>"></span>');
                                    }
                                    <?php
                                    }
                                ?>
                            });
                        });
                    </script>
                    <?php
                    }
                }
            }

            public static function add_form_option_js() {
                ob_start();
                gform_tooltip("form_hubspot");
                $tooltip = ob_get_contents();
                ob_end_clean();
                $tooltip = trim(rtrim($tooltip)).' ';
                $tooltip = str_replace("'", '"', $tooltip);
                echo '<!-- TOOLTIP CHECK: '.$tooltip.' -->';
            ?>
            <style type="text/css">
                #gform_title .hubspot,
                #gform_enable_hubspot_label {
                    float:right;
                    background: url('<?php echo WP_PLUGIN_URL ?>/gravity-forms-hubspot/hubspot-16x16.png') right top no-repeat;
                    height: 16px;
                    width: 16px;
                    cursor: help;
                }
                #gform_enable_hubspot_label {
                    float: none;
                    width: auto;
                    background-position: left top;
                    padding-left: 18px;
                    cursor:default;
                }
            </style>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#gform_settings_tab_2 .gforms_form_settings').append('<li><input type="checkbox" id="gform_enable_hubspot" /> <label for="gform_enable_hubspot" id="gform_enable_hubspot_label"><?php _e('Enable HubSpot integration', 'gravity-forms-hubspot'); ?> <?php echo $tooltip; ?></label></li>');

                    if($().prop) {
                        $("#gform_enable_hubspot").prop("checked", form.enableHubSpot ? true : false);
                    } else {
                        $("#gform_enable_hubspot").attr("checked", form.enableHubSpot ? true : false);
                    }

                    $("#gform_enable_hubspot").live('click change load', function(e) {

                        var checked = $(this).is(":checked")

                        form.enableHubSpot = checked;

                        if(checked) {
                            $("#gform_title").append('<span class="hubspot" title="<?php _e("HubSpot integration is enabled.", "gravity-forms-hubspot") ?>"></span>');
                        } else {
                            $("#gform_title .hubspot").remove();
                        }

                        SortFields(); // Update the form object to include the new enableHubSpot setting

                    }).trigger('load');

                    $('.tooltip_form_hubspot').qtip({
                        content: $('.tooltip_form_hubspot').attr('tooltip'), // Use the tooltip attribute of the element for the content
                        show: { delay: 200, solo: true },
                        hide: { when: 'mouseout', fixed: true, delay: 200, effect: 'fade' },
                        style: 'gformsstyle', // custom tooltip style
                        position: {
                            corner: {
                                target: 'topRight'
                                ,tooltip: 'bottomLeft'
                            }
                        }
                    });
                });
            </script><?php
            }

            //Returns true if the current page is an Feed pages. Returns false if not
            private static function is_hubspot_page(){
                if(empty($_GET["page"])) { return false; }
                $current_page = trim(strtolower($_GET["page"]));
                $hubspot_pages = array("gf_hubspot");

                return in_array($current_page, $hubspot_pages);
            }

            //Creates HubSpot left nav menu under Forms
            public static function create_menu($menus){

                // Adding submenu if user has access
                $permission = self::has_access("gravityforms_hubspot");
                if(!empty($permission))
                    $menus[] = array("name" => "gf_hubspot", "label" => __("HubSpot", "gravityformshubspot"), "callback" =>  array("GFHubspot", "hubspot_page"), "permission" => $permission);

                return $menus;
            }

            public static function settings_page(){
                $message = $validimage = false; global $plugin_page;
                if(!empty($_POST["uninstall"])){
                    check_admin_referer("uninstall", "gf_hubspot_uninstall");
                    self::uninstall();

                ?>
                <div class="updated fade" style="padding:20px;"><?php _e(sprintf("Gravity Forms HubSpot Add-On have been successfully uninstalled. It can be re-activated from the %splugins page%s.", "<a href='plugins.php'>","</a>"), "gravityformshubspot")?></div>
                <?php
                    return;
                }
                elseif(!empty($_POST["gf_hubspot_submit"])) {
                    check_admin_referer("update", "gf_hubspot_update");
                    $pid_settings = stripslashes($_POST["gf_hubspot_portal_id"]);
                    $app_settings = stripslashes($_POST["gf_hubspot_app_domain"]);
                    update_option("gf_hubspot_pid", $pid_settings);
                    update_option("gf_hubspot_app_domain", $app_settings);
                } else {
                    $pid_settings = get_option("gf_hubspot_pid");
                    $app_settings = get_option("gf_hubspot_app_domain");
                }

                $api = self::test_api(true);

                if(is_array($api) && empty($api)){
                    $message = "<p>".__('HubSpot.com is temporarily unavailable. Please try again in a few minutes.',"gravityformshubspot")."</p>";
                    $class = "error";
                    $validimage = '';
                    $valid = true;
                } elseif($api) {
                    $class = "updated";
                    $validimage = '<img src="'.GFCommon::get_base_url().'/images/tick.png"/>';
                    $valid = true;
                } elseif(!empty($settings)) {
                    $message = "<p>".__('Invalid HubSpot Organization ID.', "gravityformshubspot")."</p>";
                    $class = "error";
                    $valid = false;
                    $validimage = '<img src="'.GFCommon::get_base_url().'/images/cross.png"/>';
                }

            ?>
            <style type="text/css">
                .ul-square li { list-style: square!important; }
                .ol-decimal li { list-style: decimal!important; }
            </style>
            <div class="wrap">
                <?php
                    if($plugin_page !== 'gf_settings') {

                        echo '<h2>'.__('Gravity Forms HubSpot Add-on',"gravityformshubspot").'</h2>';
                    }
                    if($message) {
                        echo "<div class='fade below-h2 {$class}'>".wpautop($message)."</div>";
                } ?>

                <form method="post" action="">
                    <?php wp_nonce_field("update", "gf_hubspot_update") ?>
                    <h3><?php _e("HubSpot Account Information", "gravityformshubspot") ?></h3>
                    <p style="text-align: left;">
                        <?php _e(sprintf("If you don't have a HubSpot account, you can %ssign up for one here%s", "<a href='http://www.hubspot.com/' target='_blank'>" , "</a>"), "gravityformshubspot") ?>
                    </p>

                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="gf_hubspot_portal_id"><?php _e("HubSpot Portal ID #", "gravityformshubspot"); ?></label> </th>
                            <td><input type="text" size="75" id="gf_hubspot_portal_id" class="code pre" style="font-size:1.1em; margin-right:.5em;" name="gf_hubspot_portal_id" value="<?php echo esc_attr($pid_settings) ?>"/> <?php echo $validimage; ?>
                                <?php echo '<small style="display:block;">'.__('Find your HubSpot Portal Number by looking for a number with between 2 and 6 digits in your tracking code, as shown below:','gravityformshubspot').'</small>';?>

                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="gf_hubspot_app_domain"><?php _e("HubSpot Application Domain", "gravityformshubspot"); ?></label> </th>
                            <td><input type="text" size="75" id="gf_hubspot_app_domain" class="code pre" style="font-size:1.1em; margin-right:.5em;" name="gf_hubspot_app_domain" value="<?php echo esc_attr($app_settings) ?>"/> <?php echo $validimage; ?>
                            <?php echo '<small style="display:block;">'.__('Find your HubSpot Application domain by looking for a string of text that ends in hubspot.com in your trakcing code, as shown below:','gravityformshubspot').'</small>';?>
                        </tr>
                        <tr>
                            <td colspan="2" ><input type="submit" name="gf_hubspot_submit" class="submit button-primary" value="<?php _e("Save Settings", "gravityformshubspot") ?>" /></td>
                        </tr>

                    </table>
                </form>
                <h3><?php _e("Locating your HubSpot Portal ID and Application Domain", "gravityformshubspot"); ?></h3>
                <p><?php _e("Log in to HubSpot go to <big><em>Settings -> <strong>Analytics</strong>: External Site Traffic Logging</em></big> look in the logging code for the required information.", "gravityformshubspot"); ?></p>
                <img src="<?php echo WP_PLUGIN_URL ?>/gravity-forms-hubspot/ExternalSiteTrafficLogging.png" alt="External Site Traffic Logging Image">

                <?php if(isset($valid) && $valid) { ?>
                    <div class="hr-divider"></div>

                    <h3>Usage Instructions</h3>

                    <div class="delete-alert alert_gray">
                        <h4>To integrate a form with HubSpot:</h4>
                        <ol class="ol-decimal">
                            <li>Edit the form you would like to integrate (choose from the <a href="<?php _e(admin_url('admin.php?page=gf_edit_forms')); ?>">Edit Forms page</a>).</li>
                            <li>Click "Form Settings"</li>
                            <li>Click the "Advanced" tab</li>
                            <li><strong>Check the box "Enable HubSpot integration"</strong></li>
                            <li>Save the form</li>
                        </ol>
                    </div>

                    <h4><?php _e('Custom Fields', "gravityformshubspot"); ?></h4>
                    <?php echo wpautop(sprintf(__('When you are trying to map a custom field, you need to set either the "Admin Label" for the input (in the Advanced tab of each field in the  Gravity Forms form editor) or the Parameter Name (in Advanced tab, visible after checking "Allow field to be populated dynamically") to be the field name of the custom field as shown in HubSpot. For example, a Custom Field with a Field Label "Web Source" could have an API Name of "WebSource" or "SfCampaignId" or "HS_WS_Forms" or something else entirely.

                        You can find your custom fields in the HubSpot Form Manager.

                        For more information on custom fields, %sread this HubSpot.com Help Article%s', "gravityformshubspot"), '<a href="http://developers.hubspot.com/docs/methods/leads/create_lead" target="_blank">', '</a>')); ?>

                    <h4><?php _e('Form Fields', "gravityformshubspot"); ?></h4>
                    <p><?php _e('Fields will be automatically mapped by HubSpot using the default Gravity Forms labels.', "gravityformshubspot"); ?></p>
                    <p><?php _e('If you have issues with data being mapped, make sure to use the following keywords in the label to match and send data to HubSpot.', "gravityformshubspot"); ?></p>

                    <ul class="ul-square">
                        <li><?php _e(sprintf('%sname%s (use to auto-split names into First Name and Last Name fields)', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%sfirst name%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%slast name%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%scompany%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%semail%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%sphone%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%scity%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%scountry%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%szip%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%ssubject%s', '<code>', '</code>'), "gravityformshubspot"); ?></li>
                        <li><?php _e(sprintf('%sdescription%s, %squestion%s, %smessage%s, or %scomments%s for Description', '<code>', '</code>','<code>', '</code>','<code>', '</code>','<code>', '</code>'), "gravityformshubspot"); ?></li>
                    </ul>

                    <form action="" method="post">
                        <?php wp_nonce_field("uninstall", "gf_hubspot_uninstall") ?>
                        <?php if(GFCommon::current_user_can_any("gravityforms_hubspot_uninstall")){ ?>
                            <div class="hr-divider"></div>

                            <h3><?php _e("Uninstall HubSpot Add-On", "gravityformshubspot") ?></h3>
                            <div class="delete-alert alert_red">
                                <h3><?php _e('Warning', 'gravityformshubspot'); ?></h3>
                                <p><?php _e("This operation deletes ALL HubSpot Feeds. ", "gravityformshubspot") ?></p>
                                <?php
                                    $uninstall_button = '<input type="submit" name="uninstall" value="' . __("Uninstall HubSpot Add-On", "gravityformshubspot") . '" class="button" onclick="return confirm(\'' . __("Warning! ALL HubSpot Feeds will be deleted. This cannot be undone. \'OK\' to delete, \'Cancel\' to stop", "gravityformshubspot") . '\');"/>';
                                    echo apply_filters("gform_hubspot_uninstall_button", $uninstall_button);
                                ?>
                            </div>
                            <?php } ?>
                    </form>
                    <?php
                    } // end if($api)
                ?>
            </div>
            <?php
            }

            public static function hubspot_page(){
                if(isset($_GET["view"]) && $_GET["view"] == "edit") {
                    self::edit_page($_GET["id"]);
                } else {
                    self::settings_page();
                }
            }

            private static function test_api($debug = false){
                $api = false;

                return self::send_request(array(), $debug);
            }

            public static function send_request($post, $debug = false) {
                global $wp_version;
                $option['app_domain']   = get_option("gf_hubspot_app_domain");

                if(empty($option['app_domain'])) { return false; }

                // Set SSL verify to false because of server issues.
                $args = array(
                'body'         => $post,
                'headers'     => array(
                'Content-Type'    => 'application/x-www-form-urlencoded; ' .
                'charset=' . get_option( 'blog_charset' ),
                'User-Agent' => 'Gravity Forms HubSpot Add-on plugin - WordPress/'.$wp_version.'; '.get_bloginfo('url'),
                ),
                'sslverify'    => false,
                );

                $result = wp_remote_post('http://'.$option['app_domain'].'/?app=leaddirector&FormName='.urlencode($post['FormName']).'&UserToken='.urlencode($post['UserToken']).'&IPAddress='.urlencode($post['IPAddress']), $args);

                /**
                * HubSpot Exmaple Code for Reference
                * http://docs.hubapi.com/wiki/Inserting_Leads#PHP_Example_Using_cURL_.28Recommended_PHP_Code.29
                */

                if(wp_remote_retrieve_response_code($result) !== 200) { // Server is down.
                    return array();
                }
                elseif (preg_match('/Lead has been successfully added to HubSpot/i', $result['headers']['body'])) {
                    // For a valid request - Lead has been successfully added to HubSpot
                    return $result;
                }
                elseif(strpos($result['headers']['body'], 'Invalid attempt to add a lead')) {
                    // For an invalid request
                    return false;
                }
                return $result;
            }

            public static function push($form_meta, $entry = array()){
                global $wp_version;

                if(!isset($form_meta['enableHubSpot']) || empty($form_meta['enableHubSpot'])) { return; }

                $defaults = array(
                'FirstName'         => array('label' => 'First name'),
                'LastName'          => array('label' => 'Last name'),
                'Company'           => array('label' => 'Company'),
                'Website'           => array('label' => 'Website'),
                'Email'             => array('label' => 'Email'),
                'Phone'             => array('label' => 'Phone'),
                'Fax'               => array('label' => 'Fax'),
                'Message'           => array('label' => 'Message'),
                'title'             => array('label' => 'Title'),
                'Address'           => array('label' => 'Street'),
                'City'              => array('label' => 'City'),
                'State'             => array('label' => 'State'),
                'Country'           => array('label' => 'Country'),
                'ZipCode'           => array('label' => 'ZIP'),
                'FormName'          => array('label' => 'Lead Source'),
                'industry'          => array('label' => 'Industry'),
                'rating'            => array('label' => 'Rating'),
                'AnnualRevenue'     => array('label' => 'Annual Revenue'),
                'NumberEmployees'   => array('label' => 'Employees')
                );

                $data = array();

                //displaying all submitted fields
                foreach($form_meta["fields"] as $fieldKey => $field){

                    if($field['type'] == 'section') {
                        continue;
                    }

                    if( is_array($field["inputs"]) ){
                        $valuearray = array();
                        //handling multi-input fields such as name and address
                        foreach($field["inputs"] as $inputKey => $input){
                            $value = trim(rtrim(stripslashes(@$_POST["input_" . str_replace('.', '_', $input["id"])])));
                            $label = self::getLabel($input["label"], $field, $input);
                            if(!$label) { $label = self::getLabel($field['label'], $field, $input); }
                            if ($label == 'FullName' && !empty($value)) {
                                $names = explode(" ", $value);
                                $names[0] = trim(rtrim($names[0]));
                                $names[1] = trim(rtrim($names[1]));
                                if(!empty($names[0])) {
                                    $data['FirstName'] = $names[0];
                                }
                                if(!empty($names[1])) {
                                    $data['LastName'] = $names[1];
                                }
                            } elseif ($label == 'Message') {
                                $message = 'true';
                                $data['Message'] .= "\n".$value."\n";
                            } elseif($label == 'Address') {
                                $data['Address'] = isset($data['Address']) ? $data['Address'].$value."\n" : $value."\n";
                            } elseif (trim(strtolower($label)) == 'hubspot' ) {
                                $hubspot = $value;
                            } else {
                                if(!empty($field['inputName']) && (apply_filters('gf_hubspot_use_inputname', true) === true)) {
                                    $valuearray["{$field['inputName']}"][] = $value;
                                } elseif(!empty($field['adminLabel']) && (apply_filters('gf_hubspot_use_adminlabel', true) === true)) {
                                    $valuearray["{$field['adminLabel']}"][] = $value;
                                } elseif((!empty($data["{$label}"]) && !empty($value) && $value !== '0') || empty($data["{$label}"]) && array_key_exists("{$label}", $defaults)) {
                                    $data[$label] = $value ;
                                }
                            }
                        }
                        if(isset($valuearray["{$field['adminLabel']}"])) {
                            $data[$label] = implode(apply_filters('gf_hubspot_implode_glue', ', '), $valuearray["{$field['adminLabel']}"]);
                        } elseif(isset($valuearray["{$field['inputName']}"])) {
                            $data[$label] = implode(apply_filters('gf_hubspot_implode_glue', ', '), $valuearray["{$field['inputName']}"]);
                        }
                    } else {
                        //handling single-input fields such as text and paragraph (textarea)
                        $value = trim(rtrim(stripslashes(@$_POST["input_" . $field["id"]])));
                        $label = self::getLabel($field["label"], $field);

                        if ($label == 'FullName' && !empty($value)) {
                            $names = explode(" ", $value);
                            $names[0] = trim(rtrim($names[0]));
                            $names[1] = trim(rtrim($names[1]));
                            if(!empty($names[0])) {
                                $data['FirstName'] = $names[0];
                            }
                            if(!empty($names[1])) {
                                $data['LastName'] = $names[1];
                            }
                        } elseif ($label == 'Message') {
                            $message = 'true';
                            $data['Message'] = empty($data['Message']) ? $value."\n" : $data['Message']."\n".$value."\n";
                        } elseif($label == 'Address') {
                            $data['Address'] .= $value."\n";
                        } elseif (trim(strtolower($label)) == 'hubspot' ) {
                            $hubspot = $value;
                        } else {
                            if(!empty($field['inputName']) && (apply_filters('gf_hubspot_use_inputname', true) === true)) {
                                $data["{$field['inputName']}"] = $value ;
                            } elseif(!empty($field['adminLabel']) && (apply_filters('gf_hubspot_use_adminlabel', true) === true)) {
                                $data["{$field['adminLabel']}"] = $value ;
                            } elseif((!empty($data["{$label}"]) && !empty($value) && $value !== '0') || empty($data["{$label}"]) && (array_key_exists("{$label}", $defaults) || apply_filters('gf_hubspot_use_custom_fields', true) === true)) {
                                $data["{$label}"] = $value ;
                            }
                        }
                    }
                }

                $data['Message'] = isset($data['Message']) ? trim(rtrim($data['Message'])) : '';
                $data['Address'] = isset($data['Address']) ? trim(rtrim($data['Address'])) : '';

                $data['IPAddress'] = $_SERVER['REMOTE_ADDR'];
                $data['UserToken'] = $_COOKIE['hubspotutk'];

                $post = $data;

                $formName = isset($form_meta['title']) ? $form_meta['title'] : 'Gravity Forms Form';
                $data['FormName'] = apply_filters('gf_hubspot_lead_source', $formName, $form_meta, $data);
                //$data['debug']            = 0;

                $result = self::send_request($data);

                if($result && !empty($result)) {
                    return true;
                } else {
                    return false;
                }
            }

            public static function getLabel($temp, $field = '', $input = false){
                $label = false;

                if($input && isset($input['id'])) {
                    $id = $input['id'];
                } else {
                    $id = $field['id'];
                }

                $type = $field['type'];

                switch($type) {

                    case 'name':
                        if($field['nameFormat'] == 'simple') {
                            $label = 'FullName';
                        } else {
                            if(strpos($id, '.2')) {
                                $label = 'salutation'; // 'Prefix'
                            } elseif(strpos($id, '.3')) {
                                $label = 'FirstName';
                            } elseif(strpos($id, '.6')) {
                                $label = 'LastName';
                            } elseif(strpos($id, '.8')) {
                                $label = 'suffix'; // Suffix
                            }
                        }
                        break;
                    case 'address':
                        if(strpos($id, '.1') || strpos($id, '.2')) {
                            $label = 'Address'; // 'Prefix'
                        } elseif(strpos($id, '.3')) {
                            $label = 'City';
                        } elseif(strpos($id, '.4')) {
                            $label = 'State'; // Suffix
                        } elseif(strpos($id, '.5')) {
                            $label = 'ZipCode'; // Suffix
                        } elseif(strpos($id, '.6')) {
                            $label = 'Country'; // Suffix
                        }
                        break;
                    case 'email':
                        $label = 'Email';
                        break;
                }

                if($label) {
                    return $label;
                }

                $the_label = strtolower($temp);

                if(!empty($field['inputName']) && (apply_filters('gf_hubspot_use_inputname', true) === true)) {
                    $label = $field['inputName'];
                } elseif(!empty($field['adminLabel']) && (apply_filters('gf_hubspot_use_adminlabel', true) === true)) {
                    $label = $field['adminLabel'];
                }

                if(!apply_filters('gf_hubspot_autolabel', true) || !empty($label)) { return $label; }

                if ($type == 'name' && ($the_label === "first name" || $the_label === "first")) {
                    $label = 'FirstName';
                } elseif ($type == 'name' && ($the_label === "last name" || $the_label === "last")) {
                    $label = 'LastName';
                } elseif($the_label == 'prefix' || $the_label == 'salutation' || $the_label === 'prefix' || $the_label === 'salutation') {
                    $label = 'salutation';
                } elseif ( $the_label === 'both names') {
                    $label = 'FullNames';
                } elseif ($the_label === "company") {
                    $label = 'Company';
                } elseif ( $the_label === "email" || $the_label === "e-mail" || $type == 'email') {
                    $label = 'Email';
                } elseif ( strpos( $the_label,"fax") !== false) {
                    $label = 'Fax';
                } elseif ( strpos( $the_label,"phone") !== false ) {
                    $label = 'Phone';
                } elseif ( strpos( $the_label,"city") !== false ) {
                    $label = 'City';
                } elseif ( strpos( $the_label,"country") !== false ) {
                    $label = 'Country';
                } elseif ( strpos( $the_label,"state") !== false ) {
                    $label = 'State';
                } elseif ( strpos( $the_label,"zip") !== false ) {
                    $label = 'ZipCode';
                } elseif ( strpos( $the_label,"street") !== false || strpos( $the_label,"address") !== false ) {
                    $label = 'Address';
                } elseif ( strpos( $the_label,"website") !== false || strpos( $the_label,"web site") !== false || strpos( $the_label,"web") !== false ||  strpos( $the_label,"url") !== false) {
                    $label = 'Website';
                } elseif ( strpos( $the_label,"source") !== false ) {
                    $label = 'FormName';
                } elseif ( strpos( $the_label,"revenue") !== false ) {
                    $label = 'AnnualRevenue';
                } elseif ( strpos( $the_label,"employees") !== false ) {
                    $label = 'NumberEmployees';
                } elseif ( strpos( $the_label,"question") !== false || strpos( $the_label,"message") !== false || strpos( $the_label,"comments") !== false || strpos( $the_label,"description") !== false ) {
                    $label = 'Message';
                } elseif(!empty($field['label']) && (apply_filters('gf_hubspot_use_label', true) === true)) {
                    $label = $field['label'];
                } else {
                    $label = false;
                }
                return $label;
            }

            public static function disable_hubspot(){
                delete_option("gf_hubspot_pid");
                delete_option("gf_hubspot_app_domain");
            }

            public static function uninstall(){

                if(!GFHubspot::has_access("gravityforms_hubspot_uninstall"))
                    (__("You don't have adequate permission to uninstall HubSpot Add-On.", "gravityformshubspot"));

                //removing options
                delete_option("gf_hubspot_pid");
                delete_option("gf_hubspot_app_domain");

                //Deactivating plugin
                $plugin = "gravity-forms-hubspot/gf-hubspot.php";
                deactivate_plugins($plugin);
                update_option('recently_activated', array($plugin => time()) + (array)get_option('recently_activated'));
            }

            private static function is_gravityforms_installed(){
                return class_exists("RGForms");
            }

            private static function is_gravityforms_supported(){
                if(class_exists("GFCommon")){
                    $is_correct_version = version_compare(GFCommon::$version, self::$min_gravityforms_version, ">=");
                    return $is_correct_version;
                } else {
                    return false;
                }
            }

            public static function is_gravity_forms_installed() {
                global $pagenow, $page; $message = '';

                if($pagenow != 'plugins.php') { return;}

                if(!class_exists('RGForms')) {
                    if(file_exists(WP_PLUGIN_DIR.'/gravityforms/gravityforms.php')) {
                        $message .= '<p>Gravity Forms is installed but not active. <strong>Activate Gravity Forms</strong> to use the Gravity Forms HubSpot plugin.</p>';
                    } else {
                        $message .= '<h2><a href="http://www.23systems.net/gravityforms">Gravity Forms</a> is required.</h2><p>You do not have the Gravity Forms plugin enabled. <a href="http://www.23systems.net/gravityforms">Get Gravity Forms</a>.</p>';
                    }
                }
                if(!empty($message)) {
                    echo '<div id="message" class="error">'.$message.'</div>';
                }
            }

            protected static function has_access($required_permission){
                $has_members_plugin = function_exists('members_get_capabilities');
                $has_access = $has_members_plugin ? current_user_can($required_permission) : current_user_can("level_7");
                if($has_access)
                    return $has_members_plugin ? $required_permission : "level_7";
                else
                    return false;
            }

            //Returns the url of the plugin's root folder
            protected function get_base_url(){
                return plugins_url(null, __FILE__);
            }

            //Returns the physical path of the plugin's root folder
            protected function get_base_path(){
                $folder = basename(dirname(__FILE__));
                return WP_PLUGIN_DIR . "/" . $folder;
            }
        }
        /**
        * END CLASS CHECK
        */
    }
    /**
    * Instantiate the class
    */
    if (class_exists('GFHubspot')) {
        add_action('init',  array('GFHubspot', 'init'));
    }
?>