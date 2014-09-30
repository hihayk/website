<?php
/**
 * Ultimate Social Deux.
 *
 * @package 	Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2013 Ultimate Wordpress
 */

class UltimateSocialDeuxPinterestSharer {

	/**
	 * Instance of this class.
	 *
	 * @since	1.0.0
	 *
	 * @var		object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since	 1.0.0
	 */
	private function __construct() {

		add_filter( 'query_vars', array( $this, 'add_trigger' ) );
		add_action( 'template_redirect', array( $this, 'pinterest_sharer' ) );
		add_action( 'wp_head', array( $this, 'ajax' ), 100 );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since	 1.0.0
	 *
	 * @return	object	A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function add_trigger( $vars ) {
		$vars[] = 'pinterestshare';
		return $vars;
	}

	public function ajax() {

		if ( intval( get_query_var( 'pinterestshare' ) ) == 1 ) {

			global $pinterestshare_url;
			global $pinterestshare_desc;

			?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var share_url = "<?php echo $pinterestshare_url; ?>";
						if (share_url) {
							jQuery.ajax({
					            url: share_url,
					            success: function(data) {
					            	var data = jQuery(data).children().not('header');
					            	var data = jQuery(data).children().not('footer');
							    	jQuery("img", data).each(function() {
							    		var src = jQuery(this).attr("src");
										var nopin = jQuery(this).attr("nopin"); //Thanks to Jesse Heap
										if ( src.indexOf("gravatar") < 0 && nopin!="true" && src.indexOf("blank.gif") < 0 && src.indexOf("icons") < 0 && src.indexOf("icon") < 0 ) {
							    			jQuery('.images').append('<div class="holder"><a href="http://pinterest.com/pin/create/button/?url='+encodeURIComponent(share_url)+'&description='+encodeURIComponent("<?php echo $pinterestshare_desc; ?>")+'&media='+src+'"><img src="' + src + '" /></div></a>');
								        }
					            	});
					        	},
					        	error: function(e) {
					        		if (e.state() == 'rejected') {
					        			jQuery('body').append(share_url + ' ' + '<?php _e("is not allowing us to pull images from them.", "ultimate-social-deux") ?>');
					        		} else {
					        			jQuery('body').append('<?php _e("Unknown error!", "ultimate-social-deux") ?>');
					        			alert( e.state() );
					        		}
					        	}
					        });
					    } else {
					    	jQuery('body').append( '<?php _e("No url to pull images from is specified!", "ultimate-social-deux") ?>');
					    }
			        });
		        </script>
	        <?php

    	}
	}

	/**
	 * If trigger (query var) is tripped, load our pseudo-stylesheet
	 *
	 * I'd prefer to esc $content at the very last moment, but we need to allow the > character.
	 *
	 * @since 3.0
	 */
	public function pinterest_sharer() {

		if ( intval( get_query_var( 'pinterestshare' ) ) == 1 ) {

				global $pinterestshare_url;
				global $pinterestshare_desc;

				$pinterestshare_url = ( $_GET['url'] ) ? $_GET['url']: '';
				$pinterestshare_desc = ( $_GET['desc'] ) ? $_GET['desc']: '';

				wp_enqueue_style( 'pinterest-sharer-style', plugins_url( 'includes/pinterest-sharer/style.css', __FILE__ ), array(), ULTIMATE_SOCIAL_DEUX_VERSION );
				wp_enqueue_script( 'jquery' );
				?>
				<!DOCTYPE html>
					<html>
					<head>
					<title><?php _e("Pinterest Image Sharer", "ultimate-social-deux") ?></title>

					<?php
						wp_head();
					?>

					</head>

					<body>
						<nav class="navbar">
							<h1>Share to Pinterest</h1>
							<div><img src="<?php echo plugins_url( 'includes/pinterest-sharer/pinterest-logo.png', __FILE__ ); ?>"></div>
						</nav>
						<section class="images">
						</section>
						<?php wp_footer(); ?>
					</body>

					</html>
				<?php
			exit;
			ob_clean();
		}
	}

}