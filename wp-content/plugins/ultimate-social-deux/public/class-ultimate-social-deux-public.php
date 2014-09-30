<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2013 Ultimate Wordpress
 */

class UltimateSocialDeux {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since	1.0.0
	 *
	 * @var	 string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since	1.0.0
	 *
	 * @var		string
	 */
	protected $plugin_slug = 'ultimate-social-deux';

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

		add_action( 'init', array( $this, 'load_textdomain' ) );

		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );

		add_action( 'wp_ajax_nopriv_us_send_mail', array( $this, 'us_send_mail' ) );

		add_action( 'wp_ajax_us_send_mail', array( $this, 'us_send_mail' ) );

		add_action( 'wp_ajax_nopriv_us_counts', array( $this, 'us_counts' ) );

		add_action( 'wp_ajax_us_counts', array( $this, 'us_counts' ) );

		add_action( 'wp_ajax_nopriv_us_love', array( $this, 'us_love_button_ajax' ) );

		add_action( 'wp_ajax_us_love', array( $this, 'us_love_button_ajax' ) );

		add_action( 'wp_ajax_nopriv_us_bitly', array( $this, 'us_bitly_shortener' ) );

		add_action( 'wp_ajax_us_bitly', array( $this, 'us_bitly_shortener' ) );

		add_action( 'template_redirect', array( $this, 'custom_css' ) );

		add_action( 'wp_head', array( $this, 'open_graph_tags' ), 1 );

		add_action( 'wp_footer', array( $this, 'us_mail_form' ) );

	}

	/**
	 * If trigger (query var) is tripped, load our pseudo-stylesheet
	 *
	 * I'd prefer to esc $content at the very last moment, but we need to allow the > character.
	 *
	 * @since 1.3
	 */
	public static function custom_css() {
		$custom_css = ( self::opt('us_custom_css', 'us_styling') ) ? self::opt('us_custom_css', 'us_styling'): '';
		$floating_speed = ( self::opt('us_floating_speed', 'us_placement') ) ? intval(self::opt('us_floating_speed', 'us_placement')): 1000;

		$facebook_color = ( self::opt('us_facebook_color', 'us_styling') ) ? self::opt('us_facebook_color', 'us_styling'): '#3b5998';
		$twitter_color = ( self::opt('us_twitter_color', 'us_styling') ) ? self::opt('us_twitter_color', 'us_styling'): '#00ABF0';
		$googleplus_color = ( self::opt('us_googleplus_color', 'us_styling') ) ? self::opt('us_googleplus_color', 'us_styling'): '#D95232';
		$delicious_color = ( self::opt('us_delicious_color', 'us_styling') ) ? self::opt('us_delicious_color', 'us_styling'): '#66B2FD';
		$stumble_color = ( self::opt('us_stumble_color', 'us_styling') ) ? self::opt('us_stumble_color', 'us_styling'): '#E94B24';
		$linkedin_color = ( self::opt('us_linkedin_color', 'us_styling') ) ? self::opt('us_linkedin_color', 'us_styling'): '#1C86BC';
		$pinterest_color = ( self::opt('us_pinterest_color', 'us_styling') ) ? self::opt('us_pinterest_color', 'us_styling'): '#AE181F';
		$buffer_color = ( self::opt('us_buffer_color', 'us_styling') ) ? self::opt('us_buffer_color', 'us_styling'): '#000000';
		$reddit_color = ( self::opt('us_reddit_color', 'us_styling') ) ? self::opt('us_reddit_color', 'us_styling'): '#CEE3F8';
		$vkontakte_color = ( self::opt('us_vkontakte_color', 'us_styling') ) ? self::opt('us_vkontakte_color', 'us_styling'): '#537599';
		$mail_color = ( self::opt('us_mail_color', 'us_styling') ) ? self::opt('us_mail_color', 'us_styling'): '#666666';
		$love_color = self::opt('us_love_color', 'us_styling', '#FF0000');
		$pocket_color = self::opt('us_pocket_color', 'us_styling', '#ee4056');
		$tumblr_color = self::opt('us_tumblr_color', 'us_styling', '#529ecc');
		$print_color = self::opt('us_print_color', 'us_styling', '#60d0d4');
		$flipboard_color = self::opt('us_flipboard_color', 'us_styling', '#c10000');
		$comments_color = self::opt('us_comments_color', 'us_styling', '#b69823');
		$feedly_color = self::opt('us_feedly_color', 'us_styling', '#414141');
		$youtube_color = self::opt('us_youtube_color', 'us_styling', '#cc181e');
		$vimeo_color = self::opt('us_vimeo_color', 'us_styling', '#1bb6ec');
		$dribbble_color = self::opt('us_dribbble_color', 'us_styling', '#f72b7f');
		$envato_color = self::opt('us_envato_color', 'us_styling', '#82b540');
		$github_color = self::opt('us_github_color', 'us_styling', '#201e1f');
		$soundcloud_color = self::opt('us_soundcloud_color', 'us_styling', '#ff6f00');
		$instagram_color = self::opt('us_instagram_color', 'us_styling', '#48769c');
		$feedpress_color = self::opt('us_feedpress_color', 'us_styling', '#ffafaf');
		$mailchimp_color = self::opt('us_mailchimp_color', 'us_styling', '#6dc5dc');
		$flickr_color = self::opt('us_flickr_color', 'us_styling', '#0062dd');
		$members_color = self::opt('us_members_color', 'us_styling', '#0ab071');
		$posts_color = self::opt('us_posts_color', 'us_styling', '#924e2a');
		$hover_color = ( self::opt('us_hover_color', 'us_styling') ) ? self::opt('us_hover_color', 'us_styling'): '#008000';

		$border_radius_sharing_top_left = self::opt('us_border_radius_sharing_top_left', 'us_styling', '0');
		$border_radius_sharing_top_right = self::opt('us_border_radius_sharing_top_right', 'us_styling', '0');
		$border_radius_sharing_bottom_left = self::opt('us_border_radius_sharing_bottom_left', 'us_styling', '0');
		$border_radius_sharing_bottom_right = self::opt('us_border_radius_sharing_bottom_right', 'us_styling', '0');

		$border_radius_fan_count_top_left = self::opt('us_border_radius_fan_count_top_left', 'us_styling', '0');
		$border_radius_fan_count_top_right = self::opt('us_border_radius_fan_count_top_right', 'us_styling', '0');
		$border_radius_fan_count_bottom_left = self::opt('us_border_radius_fan_count_bottom_left', 'us_styling', '0');
		$border_radius_fan_count_bottom_right = self::opt('us_border_radius_fan_count_bottom_right', 'us_styling', '0');

		$content = '';
			if ( $custom_css ) {
				$raw_content = isset( $custom_css ) ? $custom_css : '';
				$esc_content = esc_html( $raw_content );
				$content .= str_replace( '&gt;', '>', $esc_content );

			}
		$content .= sprintf(".us_floating .us_wrapper .us_button { width: 45px; -webkit-transition: width %dms ease-in-out, background-color 400ms ease-out; -moz-transition: width %dms ease-in-out, background-color 400ms ease-out; -o-transition: width %dms ease-in-out, background-color 400ms ease-out; transition: width %dms ease-in-out, background-color 400ms ease-out; }", $floating_speed, $floating_speed, $floating_speed, $floating_speed );
		$content .= sprintf(".us_floating .us_wrapper .us_button:hover { width: 90px;-webkit-transition: width %dms ease-in-out, background-color 400ms ease-out; -moz-transition: width %dms ease-in-out, background-color 400ms ease-out; -o-transition: width %dms ease-in-out, background-color 400ms ease-out; transition: width %dms ease-in-out, background-color 400ms ease-out; }", $floating_speed, $floating_speed, $floating_speed, $floating_speed);
		$content .= sprintf(".us_button:hover, .us_fan_count_button:hover { background-color:%s; }", $hover_color);
		$content .= sprintf(".us_button { -moz-border-radius-topleft: %spx; -moz-border-radius-topright: %spx; -moz-border-radius-bottomright: %spx; -moz-border-radius-bottomleft: %spx; border-top-left-radius: %spx; border-top-right-radius: %spx; border-bottom-right-radius: %spx; border-bottom-left-radius: %spx; -webkit-border-top-left-radius: %spx; -webkit-border-top-right-radius: %spx; -webkit-border-bottom-right-radius: %spx; -webkit-border-bottom-left-radius: %spx; }", $border_radius_sharing_top_left, $border_radius_sharing_top_right, $border_radius_sharing_bottom_right, $border_radius_sharing_bottom_left, $border_radius_sharing_top_left, $border_radius_sharing_top_right, $border_radius_sharing_bottom_right, $border_radius_sharing_bottom_left, $border_radius_sharing_top_left, $border_radius_sharing_top_right, $border_radius_sharing_bottom_right, $border_radius_sharing_bottom_left );
		$content .= sprintf(".us_fan_count_button { -moz-border-radius-topleft: %spx; -moz-border-radius-topright: %spx; -moz-border-radius-bottomright: %spx; -moz-border-radius-bottomleft: %spx; border-top-left-radius: %spx; border-top-right-radius: %spx; border-bottom-right-radius: %spx; border-bottom-left-radius: %spx; -webkit-border-top-left-radius: %spx; -webkit-border-top-right-radius: %spx; -webkit-border-bottom-right-radius: %spx; -webkit-border-bottom-left-radius: %spx; }", $border_radius_fan_count_top_left, $border_radius_fan_count_top_right, $border_radius_fan_count_bottom_right, $border_radius_fan_count_bottom_left, $border_radius_fan_count_top_left, $border_radius_fan_count_top_right, $border_radius_fan_count_bottom_right, $border_radius_fan_count_bottom_left, $border_radius_fan_count_top_left, $border_radius_fan_count_top_right, $border_radius_fan_count_bottom_right, $border_radius_fan_count_bottom_left );
		$content .= sprintf("div[class*='us_facebook'] { background-color:%s; }", $facebook_color);
		$content .= sprintf("div[class*='us_twitter'] { background-color:%s; }", $twitter_color);
		$content .= sprintf("div[class*='us_google'] { background-color:%s; }", $googleplus_color);
		$content .= sprintf("div[class*='us_delicious'] { background-color:%s; }", $delicious_color);
		$content .= sprintf("div[class*='us_stumble'] { background-color:%s; }", $stumble_color);
		$content .= sprintf("div[class*='us_linkedin'] { background-color:%s; }", $linkedin_color);
		$content .= sprintf("div[class*='us_pinterest'] { background-color:%s; }", $pinterest_color);
		$content .= sprintf("div[class*='us_buffer'] { background-color:%s; }", $buffer_color);
		$content .= sprintf("div[class*='us_reddit'] { background-color:%s; }", $reddit_color);
		$content .= sprintf("div[class*='us_vkontakte'] { background-color:%s; }", $vkontakte_color);
		$content .= sprintf(".us_mail { background-color:%s; }", $mail_color);
		$content .= sprintf("div[class*='us_love'] { background-color:%s; }", $love_color);
		$content .= sprintf("div[class*='us_pocket'] { background-color:%s; }", $pocket_color);
		$content .= sprintf("div[class*='us_tumblr'] { background-color:%s; }", $tumblr_color);
		$content .= sprintf("div[class*='us_print'] { background-color:%s; }", $print_color);
		$content .= sprintf("div[class*='us_flipboard'] { background-color:%s; }", $flipboard_color);
		$content .= sprintf("div[class*='us_comments']{ background-color:%s; }", $comments_color);
		$content .= sprintf("div[class*='us_feedly'] { background-color:%s; }", $feedly_color);
		$content .= sprintf("div[class*='us_youtube'] { background-color:%s; }", $youtube_color);
		$content .= sprintf("div[class*='us_vimeo'] { background-color:%s; }", $vimeo_color);
		$content .= sprintf("div[class*='us_dribbble'] { background-color:%s; }", $dribbble_color);
		$content .= sprintf("div[class*='us_envato'] { background-color:%s; }", $envato_color);
		$content .= sprintf("div[class*='us_github'] { background-color:%s; }", $github_color);
		$content .= sprintf("div[class*='us_soundcloud'] { background-color:%s; }", $soundcloud_color);
		$content .= sprintf("div[class*='us_instagram'] { background-color:%s; }", $instagram_color);
		$content .= sprintf("div[class*='us_feedpress'] { background-color:%s; }", $feedpress_color);
		$content .= sprintf("div[class*='us_mailchimp'] { background-color:%s; }", $mailchimp_color);
		$content .= sprintf("div[class*='us_flickr'] { background-color:%s; }", $flickr_color);
		$content .= sprintf("div[class*='us_members'] { background-color:%s; }", $members_color);
		$content .= sprintf(".us_posts_fan_count { background-color:%s; }", $posts_color);

		return $content;
}

	/**
	* Register and enqueue public-facing style sheet.
	*
	* @since	1.0.0
	*/
	public function register_styles() {
		wp_register_style( 'us-plugin-styles', plugins_url( 'assets/css/style.css', __FILE__ ), array(), ULTIMATE_SOCIAL_DEUX_VERSION );
		if (self::opt('us_enqueue', 'us_basic', 'all_pages') == 'all_pages') {
			self::enqueue_stuff();
		}
	}

	/**
	* Register and enqueues public-facing JavaScript files.
	*
	* @since	1.0.0
	*/
	public function register_scripts() {

		$tweet_via = ( self::opt('us_tweet_via', 'us_basic') ) ? self::opt('us_tweet_via', 'us_basic'): '';
		$success = ( self::opt('us_mail_success', 'us_mail') ) ? self::opt('us_mail_success', 'us_mail'): __('Great work! Your message was sent.', 'ultimate-social-deux' );
		$trying = ( self::opt('us_mail_try', 'us_mail') ) ? self::opt('us_mail_try', 'us_mail'): __('Trying to send email...', 'ultimate-social-deux' );

		$facebook_height = ( self::opt('us_facebook_height', 'us_advanced') ) ? intval(self::opt('us_facebook_height', 'us_advanced')): '500';
		$facebook_width = ( self::opt('us_facebook_width', 'us_advanced') ) ? intval(self::opt('us_facebook_width', 'us_advanced')): '900';

		$twitter_height = ( self::opt('us_twitter_height', 'us_advanced') ) ? intval(self::opt('us_twitter_height', 'us_advanced')): '500';
		$twitter_width = ( self::opt('us_twitter_width', 'us_advanced') ) ? intval(self::opt('us_twitter_width', 'us_advanced')): '900';

		$googleplus_height = ( self::opt('us_googleplus_height', 'us_advanced') ) ? intval(self::opt('us_googleplus_height', 'us_advanced')): '500';
		$googleplus_width = ( self::opt('us_googleplus_width', 'us_advanced') ) ? intval(self::opt('us_googleplus_width', 'us_advanced')): '900';

		$delicious_height = ( self::opt('us_delicious_height', 'us_advanced') ) ? intval(self::opt('us_delicious_height', 'us_advanced')): '550';
		$delicious_width = ( self::opt('us_delicious_width', 'us_advanced') ) ? intval(self::opt('us_delicious_width', 'us_advanced')): '550';

		$stumble_height = ( self::opt('us_stumble_height', 'us_advanced') ) ? intval(self::opt('us_stumble_height', 'us_advanced')): '550';
		$stumble_width = ( self::opt('us_stumble_width', 'us_advanced') ) ? intval(self::opt('us_stumble_width', 'us_advanced')): '550';

		$linkedin_height = ( self::opt('us_linkedin_height', 'us_advanced') ) ? intval(self::opt('us_linkedin_height', 'us_advanced')): '550';
		$linkedin_width = ( self::opt('us_linkedin_width', 'us_advanced') ) ? intval(self::opt('us_linkedin_width', 'us_advanced')): '550';

		$pinterest_height = ( self::opt('us_pinterest_height', 'us_advanced') ) ? intval(self::opt('us_pinterest_height', 'us_advanced')): '320';
		$pinterest_width = ( self::opt('us_pinterest_width', 'us_advanced') ) ? intval(self::opt('us_pinterest_width', 'us_advanced')): '720';

		$buffer_height = ( self::opt('us_buffer_height', 'us_advanced') ) ? intval(self::opt('us_buffer_height', 'us_advanced')): '500';
		$buffer_width = ( self::opt('us_buffer_width', 'us_advanced') ) ? intval(self::opt('us_buffer_width', 'us_advanced')): '900';

		$reddit_height = ( self::opt('us_reddit_height', 'us_advanced') ) ? intval(self::opt('us_reddit_height', 'us_advanced')): '500';
		$reddit_width = ( self::opt('us_reddit_width', 'us_advanced') ) ? intval(self::opt('us_reddit_width', 'us_advanced')): '900';

		$total_shares_text = ( self::opt('us_total_shares_text', 'us_basic') ) ? self::opt('us_total_shares_text', 'us_basic'): __( 'Shares', 'ultimate-social-deux' );

		wp_register_script( 'us-script', plugins_url( 'assets/js/script-ck.js',__FILE__ ), array('jquery', 'jquery-color'), ULTIMATE_SOCIAL_DEUX_VERSION );
		wp_localize_script( 'us-script', 'us_script',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'tweet_via' => $tweet_via,
				'sharrre_url' => admin_url( 'admin-ajax.php' ),
				'success' => $success,
				'trying' => $trying,
				'total_shares_text' => $total_shares_text,
				'facebook_height' => $facebook_height,
				'facebook_width' => $facebook_width,
				'twitter_height' => $twitter_height,
				'twitter_width' => $twitter_width,
				'googleplus_height' => $googleplus_height,
				'googleplus_width' => $googleplus_width,
				'delicious_height' => $delicious_height,
				'delicious_width' => $delicious_width,
				'stumble_height' => $stumble_height,
				'stumble_width' => $stumble_width,
				'linkedin_height' => $linkedin_height,
				'linkedin_width' => $linkedin_width,
				'pinterest_height' => $pinterest_height,
				'pinterest_width' => $pinterest_width,
				'buffer_height' => $buffer_height,
				'buffer_width' => $buffer_width,
				'reddit_height' => $reddit_height,
				'reddit_width' => $reddit_width,
				'vkontakte_height' => intval(self::opt('us_vkontakte_height', 'us_advanced', '500')),
				'vkontakte_width' => intval(self::opt('us_vkontakte_width', 'us_advanced', '900')),
				'printfriendly_height' => intval(self::opt('us_printfriendly_height', 'us_advanced', '500')),
				'printfriendly_width' => intval(self::opt('us_printfriendly_width', 'us_advanced', '1045')),
				'pocket_height' => intval(self::opt('us_pocket_height', 'us_advanced', '500')),
				'pocket_width' => intval(self::opt('us_pocket_width', 'us_advanced', '900')),
				'tumblr_height' => intval(self::opt('us_tumblr_height', 'us_advanced', '500')),
				'tumblr_width' => intval(self::opt('us_tumblr_width', 'us_advanced', '900')),
				'flipboard_height' => intval(self::opt('us_flipboard_height', 'us_advanced', '500')),
				'flipboard_width' => intval(self::opt('us_flipboard_width', 'us_advanced', '900')),
				'vkontakte_appid' => self::opt('us_vkontakte_appid', 'us_basic', ''),
				'facebook_appid' => self::opt('us_facebook_appid', 'us_basic', ''),
				'home_url' => home_url(),
				'enabletracking' => self::opt('tracking', 'us_basic', false),
				'nonce' => wp_create_nonce( 'us_nonce' ),
				'already_loved_message' => __( 'You have already loved this item.', 'ultimate-social-deux' ),
				'error_message' => __( 'Sorry, there was a problem processing your request.', 'ultimate-social-deux' ),
				'logged_in' => is_user_logged_in() ? 'true' : 'false',
				'bitly' => ( self::opt('us_bitly_access_token', 'us_basic', '') ) ? 'true' : 'false',
			)
		);

	}

	/**
	* Enqueues public-facing JavaScript and CSS files.
	*
	* @since	1.0.0
	*/
	public static function enqueue_stuff() {

		if (self::opt('us_enqueue', 'us_basic', 'all_pages') != 'manually') {
			wp_enqueue_style( 'us-plugin-styles' );
			wp_add_inline_style( 'us-plugin-styles', self::custom_css() );
			wp_enqueue_script( 'us-script' );
		}

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since	1.0.0
	 *
	 * @return	Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
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

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since	1.0.0
	 */
	public function load_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

		load_textdomain( $domain, realpath(dirname(__FILE__) . '/..') . '/languages' . '/' . $domain . '-' . $locale . '.mo' );

	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since	1.0.0
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses
	 *										"Network Activate" action, false if
	 *										WPMU is disabled or plugin is
	 *										activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide	) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since	1.0.0
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses
	 *										"Network Deactivate" action, false if
	 *										WPMU is disabled or plugin is
	 *										deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

					if ( $network_wide ) {

							// Get all blog ids
							$blog_ids = self::get_blog_ids();

							foreach ( $blog_ids as $blog_id ) {

									switch_to_blog( $blog_id );
									self::single_deactivate();

							}

							restore_current_blog();

					} else {
							self::single_deactivate();
					}

			} else {
					self::single_deactivate();
			}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since	1.0.0
	 *
	 * @param	int	$blog_id	ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

			if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
					return;
			}

			switch_to_blog( $blog_id );
			self::single_activate();
			restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since	1.0.0
	 *
	 * @return	array|false	The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

			global $wpdb;

			// get an array of blog ids
			$sql = "SELECT blog_id FROM $wpdb->blogs
					WHERE archived = '0' AND spam = '0'
					AND deleted = '0'";

			return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since	1.0.0
	 */
	private static function single_activate() {

	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since	1.0.0
	 */
	private static function single_deactivate() {

		delete_option( 'us_fan_count_counters' );
		delete_transient( 'us_fan_count_counters' );

	}

	public static function opt( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}

		return $default;
	}

	/**
	 * Replace strings for mail options
	 *
	 * @since	1.0.0
	 *
	 * @return	Replaced string
	 */
	public static function mail_replace_vars( $string, $url, $sender_name, $sender_email ) {

		if ( in_the_loop() || is_singular() ) {
			$post_title = get_the_title();
			$post_url = get_permalink();

			global $post;
			$post = get_post();
			$author_id=$post->post_author;
			$user_info = get_userdata($author_id);
			$post_author = $user_info->user_nicename;
		} elseif ( is_home() ) {
			$post_title = get_bloginfo('name');
			$post_url = get_bloginfo('url');
			$post_author = get_bloginfo('name');
		} else {
			$post_title = get_bloginfo('name');
			$post_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$post_author = get_bloginfo('name');
		}

		$post_url = ($url) ? $url: $post_url;

		$site_title = get_bloginfo('name');
		$site_url = get_bloginfo('url');

		$string = str_replace('{post_title}', $post_title, $string);
		$string = str_replace('{post_url}', $post_url, $string);
		$string = str_replace('{post_author}', $post_author, $string);
		$string = str_replace('{site_title}', $site_title, $string);
		$string = str_replace('{site_url}', $site_url, $string);
		$string = str_replace('{sender_name}', $sender_name, $string);
		$string = str_replace('{sender_email}', $sender_email, $string);

		return $string;
	}

	/**
	 * Returns first image of a post or page. If no images found it returns default image.
	 *
	 * @since	1.0.0
	 *
	 * @return	post image
	 */
	public static function catch_first_image($url = '') {

		$post_id = url_to_postid( $url );

		$post = ( get_post($post_id) ) ? get_post($post_id): get_page($post_id);

		$first_img = '';

		$post_content = $post->post_content;

		if ( $post_id ) {
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);

			if ( has_post_thumbnail( $post_id ) ) {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
				$url = $thumb['0'];

				$first_img = $url;
			} elseif (isset($matches[1][0])) {
				$first_img = $matches[1][0];
			}
		}

		return $first_img;
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public static function buttons($sharetext = '', $networks = array(), $url = '', $align = "center", $count = true, $native = false) {

		if ( $url ) {
			$url = $url;
			$text = '';
		} elseif ( is_singular() ) {
			$text = get_the_title();
			$url = get_permalink();
		} elseif ( in_the_loop() ) {
			$text = get_the_title();
			$url = get_permalink();
		} elseif ( is_home() ) {
			$text = get_bloginfo('name');
			$url = get_bloginfo('url');
		} elseif ( is_tax() || is_category() ) {
			global $wp_query;
			$term = $wp_query->get_queried_object();
			$text = $term->name;
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		} else {
			$text = get_bloginfo('name');
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		}

		if ($align == 'left') {
			$align = " tal";
		} elseif ($align == 'right') {
			$align = " tar";
		} else {
			$align = " tac";
		}

		$media = self::catch_first_image($url);

		$networks = str_replace(' ', '', $networks);

		$networks = ( is_array($networks) ) ? $networks: explode(',', $networks);

		$count = filter_var($count, FILTER_VALIDATE_BOOLEAN);

		$native = filter_var($native, FILTER_VALIDATE_BOOLEAN);

		$output = sprintf('<div class="us_wrapper%s">', $align);

		$facebook_both = (in_array('facebook', $networks) && in_array('facebook_native', $networks)) ? true: false;

		$google_both = ( (in_array('google', $networks) && in_array('google_native', $networks) ) || (in_array('googleplus', $networks) && in_array('googleplus_native', $networks) ) ) ? true: false;

		$vkontakte_both = (in_array('vkontakte', $networks) && in_array('vkontakte_native', $networks)) ? true: false;

		if ($sharetext) {
			$output .= sprintf('<div class="us_button us_share_text" data-text="%s"><span class="us_share_text_span"></span></div>', $sharetext);
		}

		foreach ($networks as $key => $button) {

			switch ($button) {
				case 'total':
					$output .= self::total_button($url, $text, $networks);
					break;
				case 'facebook':
					$output .= self::facebook_button($url, $text, $count, $native, false);
					break;
				case 'facebook_native':
					$output .= self::facebook_button($url, $text, $count, true, $facebook_both);
					break;
				case 'twitter':
					$output .= self::twitter_button($url, $text, $count);
					break;
				case 'google':
					$output .= self::google_button($url, $text, $count, $native, false);
					break;
				case 'google_native':
					$output .= self::google_button($url, $text, $count, true, $google_both);
					break;
				case 'googleplus':
					$output .= self::google_button($url, $text, $count, $native, false);
					break;
				case 'googleplus_native':
					$output .= self::google_button($url, $text, $count, true, $google_both);
					break;
				case 'pinterest':
					$output .= self::pinterest_button($url, $text, $count);
					break;
				case 'linkedin':
					$output .= self::linkedin_button($url, $text, $count);
					break;
				case 'stumble':
					$output .= self::stumble_button($url, $text, $count);
					break;
				case 'delicious':
					$output .= self::delicious_button($url, $text, $count);
					break;
				case 'reddit':
					$output .= self::reddit_button($url, $text, $count);
					break;
				case 'buffer':
					$output .= self::buffer_button($url, $text, $media, $count);
					break;
				case 'vkontakte':
					$output .= self::vkontakte_button($url, $text, $media, $count, $native, false);
					break;
				case 'vkontakte_native':
					$output .= self::vkontakte_button($url, $text, $media, $count, true, $vkontakte_both);
					break;
				case 'mail':
					$output .= self::mail_button($url);
					break;
				case 'comments':
					$output .= self::comments_button($url, $count);
					break;
				case 'love':
					$output .= self::love_button($url, $count);
					break;
				case 'pocket':
					$output .= self::pocket_button($url, $text);
					break;
				case 'tumblr':
					$output .= self::tumblr_button($url, $text);
					break;
				case 'print':
					$output .= self::print_button($url);
					break;
				case 'flipboard':
					$output .= self::flipboard_button($url, $text);
					break;
			}

		}

		$output .= '</div>';

		return $output;

	}

	/**
	 * Returns total button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function total_button($url, $text, $networks) {

		self::enqueue_stuff();

		$buttons = '';

		$love_number = 0;
		$comments_number = 0;
		$google_number = 0;
		$vkontakte_number = 0;
		$pinterest_number = 0;
		$stumble_number = 0;
		$reddit_number = 0;

		if( count($networks) === 1 ) {
			$networks = 'facebook,googleplus,vkontakte,stumble,twitter,buffer,delicious,pinteres,reddit,comments,love,linkedin';
			$networks = ( is_array($networks) ) ? $networks: explode(',', $networks);
		}

		if (is_array($networks)) {

			foreach ($networks as $key => $button) {

				if ($button == 'facebook_native') {
					$button = 'facebook';
				} elseif($button == 'google_native' || $button == 'googleplus_native' || $button == 'google' || $button == 'googleplus' ) {
					$transient = get_transient( 'us_counts_'.md5('googlePlus_'.urlencode($url) ) );
					$button = 'googleplus';
					if ( is_numeric($transient) || $transient == 'zoro' ) {
						$google_number = ( $transient == 'zoro' ) ? 0: $transient;
						$button = '';
					}
				} elseif($button == 'vkontakte_native' || $button == 'vkontakte' ) {
					$transient = get_transient( 'us_counts_'.md5('vkontakte_'.urlencode($url) ) );
					$button = 'vkontakte';
					if ( is_numeric($transient) || $transient == 'zoro' ) {
						$vkontakte_number = ( $transient == 'zoro' ) ? 0: $transient;
						$button = '';
					}
				} elseif($button == 'pinterest' ) {
					$transient = get_transient( 'us_counts_'.md5('pinterest_'.urlencode($url) ) );
					$button = 'pinterest';
					if ( is_numeric($transient) || $transient == 'zoro' ) {
						$pinterest_number = ( $transient == 'zoro' ) ? 0: $transient;
						$button = '';
					}
				} elseif($button == 'stumble' ) {
					$transient = get_transient( 'us_counts_'.md5('stumbleupon_'.urlencode($url) ) );
					$button = 'stumble';
					if ( is_numeric($transient) || $transient == 'zoro' ) {
						$stumble_number = ( $transient == 'zoro' ) ? 0: $transient;
						$button = '';
					}
				} elseif($button == 'reddit' ) {
					$transient = get_transient( 'us_counts_'.md5('reddit_'.urlencode($url) ) );
					$button = 'reddit';
					if ( is_numeric($transient) || $transient == 'zoro' ) {
						$reddit_number = ( $transient == 'zoro' ) ? 0: $transient;
						$button = '';
					}
				} elseif($button == 'total' ) {
					$button = '';
				} elseif($button == 'comments' ) {
					$post_id = url_to_postid( $url );
					$comments_number = ( get_comments_number( $post_id ) ) ? get_comments_number( $post_id ): 0;
					$button = '';
				} elseif($button == 'love') {
					$love_options = get_option( 'us_love_count' );
					$love_number = ( !empty( $love_options['data'][$url]['count'] ) ) ? $love_options['data'][$url]['count']: 0;
					$button = '';
				}

				if ($button) {
					$buttons .= ' data-'.$button.'="true" ';
				}

			}
		}

		$defaults = $love_number + $comments_number + $google_number + $vkontakte_number + $pinterest_number + $stumble_number + $reddit_number;

		$button = sprintf('<div class="us_total us_button" data-defaults="%s" data-url="%s"%s><div class="us_box" href="#"><div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div><div class="us_share"></div></div></div>', $defaults, $url, $buttons);

		return $button;
	}

	/**
	 * Returns Facebook button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function facebook_button($url, $text, $count = true, $native = false, $both = false ) {

		self::enqueue_stuff();

		$counter = ( $count && !$both ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count && !$both ) ? '': ' us_no_count';

		$native_class = ( $native ) ? ' us_native': '';

		$both_class = ( $both ) ? ' us_both': '';

		$native_markup = ( $native ) ? sprintf('<a class="usnative facebook-like" href="#" data-href="%s" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></a>',$url): '';

		$button = sprintf('<div class="us_facebook%s%s%s us_button" data-url="%s" data-text="%s"><a class="us_box" href="#" data-url="%s"><div class="us_share"><i class="us-icon-facebook"></i></div>%s</a>%s</div>', $counter_class, $native_class, $both_class, $url, strip_tags($text), $url, $counter, $native_markup );

		return $button;
	}

	/**
	 * Returns Twitter button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function twitter_button($url, $text, $count = true) {

		self::enqueue_stuff();

		$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$button = sprintf('<div class="us_twitter%s us_button" data-url="%s" data-text="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-twitter"></i></div>%s</a></div>', $counter_class, $url, strip_tags($text), $counter );

		return $button;

	}

	/**
	 * Returns Google button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function google_button($url, $text, $count = true, $native = false, $both = false) {

		self::enqueue_stuff();

		$transient = get_transient( 'us_counts_'.md5('googlePlus_'.urlencode($url) ) );

		$transient_class = ( is_numeric($transient) || $transient == 'zoro' ) ? ' us_transient': '';

		$number = ( is_numeric($transient) || $transient == 'zoro' ) ? sprintf(' data-count="%s"', self::number_format($transient) ): '';

		$counter = ( $count && !$both ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count && !$both ) ? '': ' us_no_count';

		$native_class = ( $native ) ? ' us_native': '';

		$both_class = ( $both ) ? ' us_both': '';

		$native_markup = ( $native ) ? sprintf('<a class="usnative googleplus-one" href="#" data-href="%s" data-size="medium" data-annotation="none"></a>',$url): '';

		$button = sprintf('<div class="us_googleplus%s%s%s%s us_button" data-url="%s" data-text="%s"%s><a class="us_box" href="#" data-url="%s"><div class="us_share"><i class="us-icon-google"></i></div>%s</a>%s</div>', $counter_class, $native_class, $transient_class, $both_class, $url, strip_tags($text), $number, $url, $counter, $native_markup );

		return $button;

	}

	/**
	 * Returns Pinterest button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function pinterest_button($url, $text, $count = true) {

		self::enqueue_stuff();

		$transient = get_transient( 'us_counts_'.md5('pinterest_'.urlencode($url) ) );

		$transient_class = ( is_numeric($transient) || $transient == 'zoro' ) ? ' us_transient': '';

		$number = ( is_numeric($transient) || $transient == 'zoro' ) ? sprintf(' data-count="%s"', self::number_format($transient) ): '';

		$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$button = sprintf('<div class="us_pinterest%s%s us_button" data-url="%s" data-text="%s"%s><a class="us_box" href="#"><div class="us_share"><i class="us-icon-pinterest"></i></div>%s</a></div>', $counter_class, $transient_class, $url, strip_tags($text), $number, $counter);

		return $button;

	}

	/**
	 * Returns Linkedin button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function linkedin_button($url, $text, $count = true) {

		self::enqueue_stuff();

		$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$button = sprintf('<div class="us_linkedin%s us_button" data-url="%s" data-text="%s"><a class="us_box" href="#"><div class="us_share"><i class="us-icon-linkedin"></i></div>%s</a></div>', $counter_class, $url, strip_tags($text), $counter );

		return $button;

	}

	/**
	 * Returns Stumble button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function stumble_button($url, $text, $count = true) {

		self::enqueue_stuff();

		$transient = get_transient( 'us_counts_'.md5('stumbleupon_'.urlencode($url) ) );

		$transient_class = ( is_numeric($transient) || $transient == 'zoro' ) ? ' us_transient': '';

		$number = ( is_numeric($transient) || $transient == 'zoro' ) ? sprintf(' data-count="%s"', self::number_format($transient) ): '';

		$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$button = sprintf('<div class="us_stumble%s%s us_button" data-url="%s" data-text="%s"%s><a class="us_box" href="#"><div class="us_share"><i class="us-icon-stumbleupon"></i></div>%s</a></div>', $counter_class, $transient_class, $url, strip_tags($text), $number, $counter );

		return $button;

	}

	/**
	 * Returns Delicious button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function delicious_button($url, $text, $count = true) {

		self::enqueue_stuff();

		$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$button = sprintf('<div class="us_delicious%s us_button" data-url="%s" data-text="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-delicious"></i></div>%s</a></div>', $counter_class, $url, strip_tags($text), $counter );

		return $button;

	}

	/**
	 * Returns Buffer button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function buffer_button($url, $text, $media, $count = true) {

		self::enqueue_stuff();

		$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$button = sprintf('<div class="us_buffer%s us_button" data-url="%s" data-text="%s" data-media="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-buffer"></i></div>%s</a></div>', $counter_class, $url, strip_tags($text), $media, $counter );

		return $button;

	}

	/**
	 * Returns Reddit button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function reddit_button($url, $text, $count = true) {

		self::enqueue_stuff();

		$transient = get_transient( 'us_counts_'.md5('reddit_'.urlencode($url) ) );

		$transient_class = ( is_numeric($transient) || $transient == 'zoro' ) ? ' us_transient': '';

		$number = ( is_numeric($transient) || $transient == 'zoro' ) ? sprintf(' data-count="%s"', self::number_format($transient) ): '';

		$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$button = sprintf('<div class="us_reddit%s%s us_button" data-url="%s" data-text="%s"%s><a class="us_box" href="#"><div class="us_share"><i class="us-icon-reddit"></i></div>%s</a></div>', $counter_class, $transient_class, $url, strip_tags($text), $number, $counter );

		return $button;

	}

	/**
	 * Returns comments button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function comments_button($url, $count = true) {

		$post_id = url_to_postid( $url );

		if ( $post_id != 0 && comments_open() ){

			self::enqueue_stuff();

			$number = ( self::number_format( get_comments_number( $post_id ) ) ) ? self::number_format( get_comments_number( $post_id ) ): 0;

			$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

			$counter_class = ( $count ) ? '': ' us_no_count';

			$button = sprintf('<div class="us_comments%s us_button" data-count="%s"><a class="us_box" href="%s#respond"><div class="us_share"><i class="us-icon-comments"></i></div>%s</a></div>', $counter_class, $number, $url, $counter);

			return $button;

		}

	}

	/**
	 * Returns love button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function love_button($url, $count = true) {

		self::enqueue_stuff();

		$options = get_option( 'us_love_count' );

		$user_id = ( get_current_user_id() != "0" ) ? sprintf( " data-user_id='%s'", get_current_user_id() ): "";

		$number = ( !empty( $options['data'][$url]['count'] ) ) ? $options['data'][$url]['count']: 0;

		$counter = ( $count ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$id_array = ( !empty($options['data'][$url]['ids']) ) ? $options['data'][$url]['ids']: array();

		$loved_class = ( in_array( $user_id, $id_array ) ) ? ' loved': '';

		$button = sprintf('<div class="us_love%s us_button" data-count="%s"><a class="us_box%s" href="#"%s data-url="%s"><div class="us_share"><i class="us-icon-love"></i></div>%s</a></div>', $counter_class, $number, $loved_class, $user_id, $url, $counter);

		return $button;

	}

	/**
	 * Returns vkontakte button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function vkontakte_button($url, $text, $media, $count = true, $native = false, $both = false) {

		self::enqueue_stuff();

		$transient = get_transient( 'us_counts_'.md5('vkontakte_'.urlencode($url) ) );

		$transient_class = ( is_numeric($transient) || $transient == 'zoro' ) ? ' us_transient': '';

		$number = ( is_numeric($transient) || $transient == 'zoro' ) ? sprintf(' data-count="%s"', self::number_format($transient) ): '';

		$counter = ( $count && !$both ) ? '<div class="us_count"><i class="us-icon-spin us-icon-spinner"></i></div>': '';

		$counter_class = ( $count && !$both ) ? '': ' us_no_count';

		$native_class = ( $native ) ? ' us_native': '';

		$both_class = ( $both ) ? ' us_both': '';

		$native_markup = ( $native ) ? sprintf('<a class="usnative vkontakte-like vk-like" href="#" data-pageUrl="%s"></a>',$url): '';

		$button = sprintf('<div class="us_vkontakte%s%s%s%s us_button" data-url="%s" data-text="%s"%s><a class="us_box" href="#" data-url="%s"><div class="us_share"><i class="us-icon-vkontakte"></i></div>%s</a>%s</div>', $counter_class, $native_class, $transient_class, $both_class, $url, strip_tags($text), $number, $url, $counter, $native_markup );

		return $button;

	}

	/**
	 * Returns Pocket button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function pocket_button($url, $text) {

		self::enqueue_stuff();

		$button = sprintf('<div class="us_pocket us_button" data-url="%s" data-text="%s"><a class="us_box" href="#"><div class="us_share"><i class="us-icon-pocket"></i></div></a></div>', $url, strip_tags($text) );

		return $button;

	}

	/**
	 * Returns Tumblr button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function tumblr_button($url, $text) {

		self::enqueue_stuff();

		$button = sprintf('<div class="us_tumblr us_button" data-url="%s" data-text="%s"><a class="us_box" href="#"><div class="us_share"><i class="us-icon-tumblr"></i></div></a></div>', $url, strip_tags($text) );

		return $button;

	}

	/**
	 * Returns Print button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function print_button($url) {

		self::enqueue_stuff();

		$button = sprintf('<div class="us_print us_button" data-url="%s"><a class="us_box" href="#"><div class="us_share"><i class="us-icon-print"></i></div></a></div>', $url);

		return $button;

	}

	/**
	 * Returns Flipboard button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function flipboard_button($url, $text) {

		self::enqueue_stuff();

		$button = sprintf('<div class="us_flipboard us_button" data-url="%s" data-text="%s"><a class="us_box" href="#"><div class="us_share"><i class="us-icon-flipboard"></i></div></a></div>', $url, strip_tags($text) );

		return $button;

	}

	/**
	 * Returns Mail button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function mail_button($url) {

		global $us_mail_form;

		self::enqueue_stuff();

		$random_string = self::random_string(5);

		$to = ( self::opt('us_mail_to', 'us_mail') ) ? self::opt('us_mail_to', 'us_mail') : 'Recipient Email';
		$body = ( self::opt('us_mail_body', 'us_mail') ) ? self::mail_replace_vars( self::opt('us_mail_body', 'us_mail'), $url, '', '' ) : self::mail_replace_vars( __('I read this article and found it very interesting, thought it might be something for you. The article is called', 'ultimate-social-deux' ) . ' ' . '{post_title} ' . __('and is located at', 'ultimate-social-deux' ) . ' {post_url}.', $url, '', '' );

		$captcha_enable	= ( self::opt('us_mail_captcha_enable', 'us_mail') ) ? self::opt('us_mail_captcha_enable', 'us_mail') : 'yes';
		$captcha = ( self::opt('us_mail_captcha_question', 'us_mail') ) ? stripslashes( self::opt('us_mail_captcha_question', 'us_mail') ) : __('What is the sum of 7 and 2?','ultimate-social-deux');

		$us_share = ( self::opt('us_mail_header', 'us_mail') ) ? self::opt('us_mail_header', 'us_mail') : __('Share with your friends','ultimate-social-deux');

		$your_name = __('Your Name','ultimate-social-deux');
		$your_email = __('Your Email','ultimate-social-deux');
		$recipient_email = __('Recipient Email','ultimate-social-deux');
		$your_message = __('Enter a Message','ultimate-social-deux');
		$captcha_label = __('Captcha','ultimate-social-deux');

		$form = sprintf('<div class="us_wrapper us_modal mfp-hide" id="us-modal-%s">', $random_string);
			$form .= '<div class="us_heading">';
				$form .= $us_share;
			$form .= '</div>';
			$form .= '<div class="us_mail_response"></div>';
			$form .= '<div class="us_mail_form_holder">';
				$form .= '<form role="form" id="ajaxcontactform" class="form-group contact" action="" method="post" enctype="multipart/form-data">';
					$form .= '<div class="form-group">';
						$form .= sprintf('<label class="label" for="ajaxcontactyour_name">%s</label><br>', $your_name );
						$form .= sprintf('<input type="text" id="ajaxcontactyour_name" class="border-box form-control us_mail_your_name" name="%s" placeholder="%s"><br>', $your_name, $your_name );
						$form .= sprintf('<label class="label" for="ajaxcontactyour_email">%s</label><br>', $your_email );
						$form .= sprintf('<input type="email" id="ajaxcontactyour_email" class="border-box form-control us_mail_your_email" name="%s" placeholder="%s"><br>', $your_email, $your_email );
						$form .= sprintf('<label class="label" for="ajaxcontactrecipient_email">%s</label><br>', $recipient_email );
						$form .= sprintf('<input type="email" id="ajaxcontactrecipient_email" class="border-box form-control us_mail_recipient_email" name="%s" placeholder="%s"><br>', $recipient_email, $recipient_email);
						$form .= sprintf('<label class="label" for="ajaxcontactmessage">%s</label><br>', $your_message);
						$form .= sprintf('<textarea class="border-box form-control border-us_box us_mail_message" id="ajaxcontactmessage" name="%s" placeholder="%s">%s</textarea>', $your_message, $your_message, $body);
						$form .= sprintf('<input type="email" id="ajaxcontactrecipient_url" class="border-box form-control us_mail_url" style="display:none;" name="%s" placeholder="%s"><br>', $url, $url);
					$form .= '</div>';

					if ( $captcha_enable == 'yes' ){
						$form .= '<div class="form-group">';
							$form .= sprintf('<label class="label" for="ajaxcontactcaptcha">%s</label><br>', $captcha_label);
							$form .= sprintf('<input type="text" id="ajaxcontactcaptcha" class="border-box form-control us_mail_captcha" name="%s" placeholder="%s"><br>', $captcha_label, $captcha);
						$form .= '</div>';
					}
				$form .= '</form>';
				$form .= sprintf('<a class="btn btn-success us_mail_send">%s</a>', __('Submit','ultimate-social-deux') );
			$form .= '</div>';
		$form .= '</div>';

		$us_mail_form[$random_string] = $form;

		$button = sprintf('<div class="us_mail us_button"><a class="us_box" href="#us-modal-%s"><i class="us-icon-mail"></i></a></div>', $random_string );

		return $button;

	}

	public function us_mail_form() {
		global $us_mail_form;

		if ($us_mail_form) {

			foreach($us_mail_form as $form){
				echo $form;
			}
		}
	}

	/**
	 * Ajax function to send mail.
	 *
	 * @since	1.0.0
	 */
	public function us_send_mail(){

		$url 			= ( $_POST['url'] ) ? $_POST['url']: '';
		$your_name		= ( $_POST['your_name'] ) ? $_POST['your_name']: '';
		$your_email		= ( $_POST['your_email'] ) ? $_POST['your_email']: '';
		$recipient_email = ( $_POST['recipient_email'] ) ? $_POST['recipient_email']: '';
		$subject		= ( self::opt('us_mail_subject', 'us_mail') ) ? self::mail_replace_vars( self::opt('us_mail_subject', 'us_mail'), $url, $your_name, $your_email ) : self::mail_replace_vars( __('A visitor of', 'ultimate-social-deux' ) . ' ' . '{site_title}' . __('shared', 'ultimate-social-deux' ) . ' ' . '{post_title}' . __('with you.','ultimate-social-deux'), $url, $your_name, $your_email );
		$message		= ( $_POST['message'] ) ? $_POST['message']: '';
		$captcha		= ( $_POST['captcha'] ) ? $_POST['captcha']: '';
		$captcha_answer	= ( self::opt('us_mail_captcha_answer', 'us_mail') ) ? self::opt('us_mail_captcha_answer', 'us_mail') : '9';
		$captcha_enable	= ( self::opt('us_mail_captcha_enable', 'us_mail') ) ? self::opt('us_mail_captcha_enable', 'us_mail') : 'yes';

		$admin_email	= get_bloginfo('admin_email');
		$from_email		= ( self::opt('us_mail_from_email', 'us_mail') ) ? self::opt('us_mail_from_email', 'us_mail') : $admin_email;
		$from_name		= ( self::opt('us_mail_from_name', 'us_mail') ) ? self::opt('us_mail_from_name', 'us_mail') : get_bloginfo('name');
		$admin_copy		= ( self::opt('us_mail_bcc_enable', 'us_mail') ) ? self::opt('us_mail_bcc_enable', 'us_mail') : 'yes';

		if ( $captcha_enable == 'yes' ){
			if( '' == $captcha )
				die( __( 'Captcha cannot be empty!', 'ultimate-social-deux' ) );
			if( $captcha !== $captcha_answer )
				die( __( 'Captcha does not match.', 'ultimate-social-deux' ) );
		}

		if ( ! filter_var( $recipient_email, FILTER_VALIDATE_EMAIL ) ) {
			die( __( 'Recipient email address is not valid.', 'ultimate-social-deux' ) );
		} elseif ( ! filter_var( $your_email, FILTER_VALIDATE_EMAIL ) ) {
			die( __( 'Your email address is not valid.', 'ultimate-social-deux' ) );
		} elseif( strlen( $your_name ) == 0 ) {
			die( __( 'Your name cannot be empty.', 'ultimate-social-deux' ) );
		} elseif( strlen( $message ) == 0 ) {
			die( __( 'Message cannot be empty.', 'ultimate-social-deux' ) );
		}
		$headers	= array();
		$headers[] = sprintf('From: %s <%s>', $from_name, $from_email );
		$headers[] = sprintf('Reply-To: %s <%s>', $your_name, $your_email );
		if ($admin_copy == 'yes') {
			$headers[] = sprintf('Bcc: %s', $admin_email);
		}

		if( true === ( $result = wp_mail( $recipient_email, stripslashes($subject), stripslashes($message), implode("\r\n", $headers) ) ) )
			die( 'ok' );

		if ( ! $result ) {

			global $phpmailer;

			if( isset( $phpmailer->ErrorInfo ) ) {
				die( sprintf( 'Error: %s', $phpmailer->ErrorInfo ) );
			} else {
				die( __( 'Unknown wp_mail() error.', 'ultimate-social-deux' ) );
			}
		}
	}

	/**
	 * Ajax function for love button
	 *
	 * @since	3.0.0
	 */
	public function us_love_button_ajax() {

		$url = ( $_POST['url'] ) ? $_POST['url']: '';
		$urlencode = urlencode($url);
		$user_id = ( $_POST['user_id'] ) ? $_POST['user_id']: '';
		$options = get_option( 'us_love_count' );

		$id_array = ( !empty($options['data'][$url]['ids']) ) ? $options['data'][$url]['ids']: array();

		if ( $url && wp_verify_nonce( $_POST['nonce'], 'us_nonce' ) ) {
			if (!in_array( $user_id, $id_array ) ) {

				if ( !empty( $options['data'][$url]['count'] ) ) {
					$options['data'][$url]['count'] = $options['data'][$url]['count'] + 1;
				} else {
					$options['data'][$url]['count'] = 1;
				}

				if( is_user_logged_in() ) {
					$options['data'][$url]['ids'][$user_id] = $user_id;
				}

				update_option( 'us_love_count', $options );

				die('ok');
			} else {
				die();
			}
		}
	}

	/**
	 * Ajax function for bit.ly shortener
	 *
	 * @since	3.0.0
	 */
	public function us_bitly_shortener() {

		header('content-type: application/json');

		$url = ( $_POST['url'] ) ? $_POST['url']: '';

		$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');

		$url = strtr(rawurlencode($url), $revert);

		$access_token = self::opt('us_bitly_access_token', 'us_basic', '');

		if ($access_token) {
			$content = @file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token='.$access_token.'&longUrl='.$url);

			if ($content === FALSE) {
				$content = @self::parse('https://api-ssl.bitly.com/v3/shorten?access_token='.$access_token.'&longUrl='.$url);
			}
		}

		die($content);

	}

	/**
	 * Ajax function for getting counts
	 *
	 * @since	1.0.0
	 */
	public function us_counts() {

		header('content-type: application/json');

		$json = array('url'=>'','count'=>0);
		$json['url'] = $_GET['url'];
		$url = urlencode($_GET['url']);
		$url_transient = urlencode($_GET['url']);
		$type = $_GET['type'];

		$expire = intval(self::opt('us_counts_transient', 'us_basic', '600'));

		if(filter_var($_GET['url'], FILTER_VALIDATE_URL)){
			switch($type) {
				case 'googlePlus':

					$transient = get_transient( 'us_counts_'.md5('googlePlus_'.$url_transient) );

					if ( is_numeric($transient) || $transient == 'zoro' ) {

						$transient_value = ( $transient == 'zoro' ) ? 0: $transient;

						$json['count'] = $transient_value;
					} else {
						$content = @file_get_contents("https://plusone.google.com/u/0/_/+1/fastbutton?url=".$url."&count=true");

						if ($content === FALSE) {
							$content = @self::parse("https://plusone.google.com/u/0/_/+1/fastbutton?url=".$url."&count=true");
						}

					  	if (preg_match("/window\.__SSR\s=\s\{c:\s([0-9]+)\.0/", $content, $matches)) {
							$json['count'] = $matches[1];
						}

						$transient_value = ( $json['count'] ) ? $json['count']: 'zoro';

						set_transient( 'us_counts_'.md5('googlePlus_'.$url_transient), $transient_value, $expire );
					}
					break;

				case 'stumbleupon':
					$transient = get_transient( 'us_counts_'.md5('stumbleupon_'.$url_transient) );

					if ( is_numeric($transient) || $transient == 'zoro' ) {

						$transient_value = ( $transient == 'zoro' ) ? 0: $transient;

						$json['count'] = $transient_value;
					}  else {
						$content = @file_get_contents("https://www.stumbleupon.com/services/1.01/badge.getinfo?url=".$url);

						if ($content === FALSE) {
							$content = @self::parse("https://www.stumbleupon.com/services/1.01/badge.getinfo?url=".$url);
						}

						$result = json_decode($content);
						if (isset($result->result->views)) {
							$json['count'] = $result->result->views;
						}

						$transient_value = ( $json['count'] ) ? $json['count']: 'zoro';

						set_transient( 'us_counts_'.md5('stumbleupon_'.$url_transient), $transient_value, $expire );
					}

					break;

				case 'pinterest':
					$transient = get_transient( 'us_counts_'.md5('pinterest_'.$url_transient) );

					if ( is_numeric($transient) || $transient == 'zoro' ) {

						$transient_value = ( $transient == 'zoro' ) ? 0: $transient;

						$json['count'] = $transient_value;
					} else {
						$content = @file_get_contents("https://api.pinterest.com/v1/urls/count.json?url=".$url);

						if ($content === FALSE) {
							$content = @self::parse("https://api.pinterest.com/v1/urls/count.json?url=".$url);
						}

						$content = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $content);

						$result = json_decode($content);

						$json['count'] = intval($result->count);

						$transient_value = ( $json['count'] ) ? $json['count']: 'zoro';

						set_transient( 'us_counts_'.md5('pinterest_'.$url_transient), $transient_value, $expire );
					}
					break;

				case 'reddit':
					$transient = get_transient( 'us_counts_'.md5('reddit_'.$url_transient) );

					if ( is_numeric($transient) || $transient == 'zoro' ) {

						$transient_value = ( $transient == 'zoro' ) ? 0: $transient;

						$json['count'] = $transient_value;
					}  else {
						$content = @file_get_contents("http://www.reddit.com/api/info.json?url=".$url);

						if ($content === FALSE) {
							$content = @self::parse("http://www.reddit.com/api/info.json?url=".$url);
						}

						$result = json_decode($content);

						$children = $result->data->children;

						if ( isset($children[0]->data->score) && is_int($children[0]->data->score)) {

							$sum = 0;
							foreach($children as $child) {

								$sum+= $child->data->score;
							}

							$json['count'] = $sum;

						}

						$transient_value = ( $json['count'] ) ? $json['count']: 'zoro';

						set_transient( 'us_counts_'.md5('reddit_'.$url_transient), $transient_value, $expire );
					}
					break;

				case 'vkontakte':
					$transient = get_transient( 'us_counts_'.md5('vkontakte_'.$url_transient) );

					if ( is_numeric($transient) || $transient == 'zoro' ) {

						$transient_value = ( $transient == 'zoro' ) ? 0: $transient;

						$json['count'] = $transient_value;
					}  else {

						$content = @file_get_contents("https://vk.com/share.php?act=count&index=0&url=".$url);

						if ($content === FALSE) {
							$content = @self::parse("https://vk.com/share.php?act=count&index=0&url=".$url);
						}

						$content = substr($content, 18, -2);

						$content = intval($content);

						if (is_int($content)) {
							$json['count'] = $content;
						}

						$transient_value = ( $json['count'] ) ? $json['count']: 'zoro';

						set_transient( 'us_counts_'.md5('vkontakte_'.$url_transient), $transient_value, $expire );
					}
					break;

					case 'comments':
						$post_id = url_to_postid( $_GET['url'] );

						$json['count'] = ( get_comments_number( $post_id ) ) ? get_comments_number( $post_id ): 0;

						break;

					case 'love':
						$options = get_option( 'us_love_count' );

						$json['count'] = ( !empty( $options['data'][$_GET['url']]['count'] ) ) ? $options['data'][$_GET['url']]['count']: 0;

						break;

				default:
					$json['count'] = 0;
					break;
			}

		}
		echo str_replace('\\/','/',json_encode($json));

		die();

	}

	public function parse($encUrl){

		$options = array(
			CURLOPT_RETURNTRANSFER => true, // return web page
			CURLOPT_HEADER => false, // don't return headers
			CURLOPT_FOLLOWLOCATION => true, // follow redirects
			CURLOPT_ENCODING => "", // handle all encodings
			CURLOPT_USERAGENT => 'sharrre', // who am i
			CURLOPT_AUTOREFERER => true, // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 5, // timeout on connect
			CURLOPT_TIMEOUT => 10, // timeout on response
			CURLOPT_MAXREDIRS => 3, // stop after 10 redirects
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => false,
		);
		$ch = curl_init();

		$options[CURLOPT_URL] = $encUrl;
		curl_setopt_array($ch, $options);

		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);

		curl_close($ch);

		return $content;

	}

	public static function remote_get( $url , $json = true) {
		$request = wp_remote_retrieve_body( wp_remote_get( $url , array( 'timeout' => 18 , 'sslverify' => false ) ) );
		if( $json ) $request = @json_decode( $request , true );
		return $request;
	}

	/**
	 * Returns random string.
	 *
	 * @since	1.0.0
	 *
	 * @return	random string
	 */
	public static function random_string($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function open_graph_tags() {
		global $post;

		$option = ( self::opt('us_open_graph', 'us_basic') ) ? self::opt('us_open_graph', 'us_basic'): 'off';
		$fb_app_id = ( self::opt('us_facebook_appid', 'us_basic') ) ? self::opt('us_facebook_appid', 'us_basic'): '';

		if ( $option === 'on' )  {

			if ( is_singular() ) {
				$title = get_the_title();
				$url = get_permalink();
			} elseif ( in_the_loop() ) {
				$title = get_the_title();
				$url = get_permalink();
			} elseif ( is_home() ) {
				$title = get_bloginfo('name');
				$url = get_bloginfo('url');
			} elseif ( is_archive() ) {
				global $wp_query;
				$term = $wp_query->get_queried_object();
				$title = $term->name;
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			} else {
				$title = get_bloginfo('name');
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			}

			$image = self::catch_first_image($url);
			?>
				<meta property="og:title" content="<?php echo $title; ?>" />
				<meta property="og:type" content="article" />
				<meta property="og:image" content="<?php echo $image; ?>" />
				<meta property="og:url" content="<?php echo $url; ?>" />
				<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
			<?php

			if ($fb_app_id) {
				printf('<meta property="fb:app_id" content="%s" />', $fb_app_id);
			}
		}
	}

	/**
	 * Return readable count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 readable number
	 */
	public static function number_format($n) {
	if($n>1000000000) return round(($n/1000000000),1).'B';
	elseif($n>1000000) return round(($n/1000000),1).'M';
	elseif($n>1000) return round(($n/1000),1).'k';

	return number_format(intval($n));

	}

}
