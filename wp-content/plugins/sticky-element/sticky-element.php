<?php
/*
Plugin Name: Sticky Element
Description: Prevent element scrolling off page 
Author: Stew Heckenberg
Version: 1.3.4
Author URI: http://webcoder.com.au/
*/

function sticky_element_enqueue_script() {
  wp_enqueue_script('jquery');
}

function sticky_element_footer() {
  
  $sel = get_option('sticky_element');
  $end = get_option('sticky_element_end');
  $max = get_option('sticky_element_max');

  if ( !isset($sel) || !isset($end) || !isset($max) ) return;
  if ( $sel == '' || $end == '' || $max == '' ) return;

echo <<<EOT
<script>
jQuery(document).ready(function($) {

  var winwidth = $(window).width();

  $(window).resize(function() {
      clearTimeout(this.id);
      this.id = setTimeout(doneResizing, 500);
  });

  function doneResizing(){
    if ($(window).width() != winwidth) {
      window.location.reload();
    }
  };

  if ( !$('$sel').length && console) {
    console.log('"$sel" element not found, please check Sticky Element plugin settings');
    return;
  }
  if ( !$('$end').length && console) {
    console.log('"$end" element not found, please check Sticky Element plugin settings');
    return;
  }

  if (winwidth >= $max) {

    var el = $("$sel");
    var elwidthpx = el.css('width');
    var elleftmar = el.css('margin-left');
    var eltop;
    var elheight;
    var elleft = el.offset().left;

    $('<div/>').attr('id', 'clone').css('width',elwidthpx).insertAfter( $('$sel') );

    var style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = '.sticky-element-fixed { position: fixed; top: 0; width: ' + elwidthpx + ' !important; }';
    document.getElementsByTagName('head')[0].appendChild(style);

    $(window).scroll(function() {

      if (typeof eltop === "undefined" ) {
        eltop = el.offset().top;
      }
      elheight = el.outerHeight();

      var end = $("$end");
      endtop = end.offset().top;
      var winscroll = $(window).scrollTop();

      if (winscroll > eltop) {
        $("$sel").addClass('sticky-element-fixed');
        $("$sel").css("left", elleft);
        $("$sel").css("margin-left", 0);
        $('#clone').css('height',elheight);
      } else {
        $("$sel").removeClass('sticky-element-fixed');
        $("$sel").css("left", "auto");
        $("$sel").css("margin-left", elleftmar);
        $('#clone').css('height',0);
      }

      if (winscroll + elheight > endtop) {
        var amount = endtop - (winscroll + elheight);
        $("$sel").css("top", amount + "px");
      } else {
        var amount = endtop - (winscroll + elheight);
        $("$sel").css("top", "");
      }

    });
  }

});
</script>
EOT;
}

if (!is_admin()):
  add_action('wp_enqueue_scripts', 'sticky_element_enqueue_script');
	add_action('wp_footer', 'sticky_element_footer', 1);
else:

add_action('admin_menu', 'sticky_element_create_menu');

function sticky_element_create_menu() {
	add_menu_page('Sticky Element Settings', 'Sticky Element', 'administrator', __FILE__, 'sticky_element_settings_page',plugins_url('/icon.png', __FILE__));
	add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
	register_setting( 'sticky-element-settings-group', 'sticky_element', 'validate_selector' );
	register_setting( 'sticky-element-settings-group', 'sticky_element_end', 'validate_selector' );
	register_setting( 'sticky-element-settings-group', 'sticky_element_max', 'validate_number' );
}

function validate_selector($input) {
  if ($input == '') return $input;
  if (!preg_match("/^[#\w\s\.\-\[\]\=\^\~\:]+$/", $input)) return '#invalid-selector';
  return $input;
}

function validate_number($input) {
  if ($input == '') return $input;
  if (!is_numeric($input)) return '0';
  return $input;
}

function sticky_element_settings_page() {
?>
<div class="wrap">
<h2 style="float: left;">Sticky Element</h2>
<h3 style="float: right; color: gray;">Not a web developer? <a href="http://sticky-element.com/downloads/pro/" target="_blank">Check out the Pro version</a> featuring easy point-and-click setup!</h3>
<form method="post" action="options.php">
    <?php settings_fields( 'sticky-element-settings-group' ); ?>
    <?php //do_settings_fields( 'sticky-element-settings-group' ); ?>

    <table class="form-table">
        <tr valign="top">
        <th scope="row">Element you want to make sticky</th>
        <td><input type="text" name="sticky_element" value="<?php echo get_option('sticky_element'); ?>" placeholder="e.g. #sidebar" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Element that pushes sticky upward</th>
        <td><input type="text" name="sticky_element_end" value="<?php echo get_option('sticky_element_end'); ?>" placeholder="e.g. #footer" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Active when window is wider than</th>
        <td><input type="text" name="sticky_element_max" value="<?php echo get_option('sticky_element_max'); ?>" placeholder="e.g. 960" />px</td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php
}

endif;

?>
