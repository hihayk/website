<?php
/**
 * Plugin Name: Form Generator for WordPress
 * Plugin URI: http://watchstreetconsulting.com/form-generator-wordpress/
 * Author: Trevor Montgomery
 * Author URI: http://watchstreetconsulting.com/
 * Version: 1.52
 * License: GPL2
 * Description: Form Generator lets you quickly and easily build stunning forms, take advantage of over 2500 JotForm templates, and manage your form submissions all within WordPress. Form Generator is the perfect tool for nonprofits, political campaigns, churches, or small business. Contact forms, RSVP forms, volunteer forms, donate forms with payment processing & more powered by JotForm are all available with an easy one-click set-up!

 Form Generator Plugin for WordPress
 Copyright (C) 2014, Trevor Montgomery - trevor@watchstreetconsulting.com
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Get some constants ready for paths when your plugin grows 
 * 
 */

define( 'JC_VERSION', '1.52' );
define( 'JC_PATH', dirname( __FILE__ ) );
define( 'JC_PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );
define( 'JC_FOLDER', basename( JC_PATH ) );
define( 'JC_URL', plugins_url() . '/' . JC_FOLDER );
define( 'JC_URL_INCLUDES', JC_URL . '/inc' );
if (!class_exists('JotForm')) include ( JC_PATH_INCLUDES .'/jotForm.class.php');
include ( JC_PATH_INCLUDES .'/jc-base.class.php');
if(!class_exists('JotFormWPEmbed')) include ( JC_PATH_INCLUDES .'/jotForm-embed.php');


 // Initialize everything
$dx_plugin_base = new JC_Plugin_Base();
add_filter('widget_text', 'do_shortcode');
add_filter('the_excerpt', 'do_shortcode');
add_filter('get_the_excerpt', 'do_shortcode');