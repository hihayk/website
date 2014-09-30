<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2013 Ultimate Wordpress
 */

class UltimateSocialDeuxAdmin {

	private $settings_api;

	/**
	 * Instance of this class.
	 *
	 * @since	1.0.0
	 *
	 * @var		object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since	1.0.0
	 *
	 * @var		string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since	 1.0.0
	 */
	private function __construct() {

		$plugin = UltimateSocialDeux::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		$this->settings_api = new WeDevs_Settings_API;

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'admin_init', array( $this, 'admin_init' ) );

		if ( defined('WPB_VC_VERSION') ) {

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		}

	}

	/**
	 * Enqueue admin CSS.
	 *
	 * @since	 1.0.0
	 *
	 */
	public function admin_enqueue_scripts() {
		wp_register_style( 'ultimate-social-deux-visual-composer-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', false, '1.0.0' );
        wp_enqueue_style( 'ultimate-social-deux-visual-composer-style' );
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
	 * Loading settings page and menu.
	 *
	 * @since	 1.0.0
	 */
	public function admin_init() {

		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		$this->settings_api->admin_init();
	}

	/**
	 * Loading admin menu.
	 *
	 * @since	 1.0.0
	 */
	public function admin_menu() {
		add_options_page( 'Ultimate Social Deux', 'Ultimate Social Deux', 'delete_posts', 'ultimate_social_deux', array($this, 'settings_page') );
	}

	/**
	 * Creating admin menu wrapper.
	 *
	 * @since	 1.0.0
	 */
	public function settings_page() {

		echo '<div class="wrap ultimate-social-settings">';

		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();

		echo '</div>';
	}

	/**
	 * Creating settings tabs.
	 *
	 * @since	 1.0.0
	 */
	public function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'us_basic',
				'title' => __( 'Basic Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_styling',
				'title' => __( 'Style Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_mail',
				'title' => __( 'Mail Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_placement',
				'title' => __( 'Placement Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_fan_count',
				'title' => __( 'Fan Count Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_advanced',
				'title' => __( 'Advanced Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_license',
				'title' => __( 'License Settings', 'ultimate-social-deux' )
			),
		);

		return $sections;
	}

	/**
	 * Creating individual settings.
	 *
	 * @since	 1.0.0
	 */
	public function get_settings_fields() {

		$facebook = __('Facebook','ultimate-social-deux');
		$twitter = __('Twitter','ultimate-social-deux');
		$google = __('Google Plus','ultimate-social-deux');
		$pinterest = __('Pinterest','ultimate-social-deux');
		$linkedin = __('LinkedIn','ultimate-social-deux');
		$stumble = __('StumbleUpon','ultimate-social-deux');
		$delicious = __('Delicious','ultimate-social-deux');
		$buffer = __('Buffer','ultimate-social-deux');
		$reddit = __('Reddit','ultimate-social-deux');
		$vkontakte = __('VKontakte','ultimate-social-deux');
		$mail = __('Mail','ultimate-social-deux');

		$fields = array(
			/**
			 * Basic settings.
			 */
			'us_basic' => array(
				array(
					'name' => 'us_tweet_via',
					'label' => __( 'Tweet via: @', 'ultimate-social-deux' ),
					'desc' => __( 'Write your Twitter username here to be mentioned in visitors tweets', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_vkontakte_appid',
					'label' => __( 'VKontakte', 'ultimate-social-deux' ) . ' ' . __( 'App ID', 'ultimate-social-deux' ),
					'desc' => __( 'You need to register your site at vk.com to use the native vk.com button. Register your app abd obtain your ID', 'ultimate-social-deux' ) . ' ' . '<a href="http://vk.com/dev/Like" target="_blank">' . __( 'here', 'ultimate-social-deux' ) . '</a>.',
					'type' => 'text',
				),
				array(
					'name' => 'us_facebook_appid',
					'label' => __( 'Facebook', 'ultimate-social-deux' ) . ' ' . __( 'App ID', 'ultimate-social-deux' ),
					'desc' => __( 'This is used for insights of how people are sharing your content.', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_total_shares_text',
					'label' => __( 'Total Shares Button Text', 'ultimate-social-deux' ),
					'desc' => __( 'The text you want for the total shares button', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __( 'Shares', 'ultimate-social-deux' ),
				),
				array(
					'name' => 'us_open_graph',
					'label' => __( 'Add Open Graph tags', 'ultimate-social-deux' ),
					'desc' => __( 'This is used for some social networks to fetch data from your site', 'ultimate-social-deux' ),
					'type' => 'checkbox',
				),
				array(
					'name' => 'us_bitly_access_token',
					'label' => __( 'Bit.ly access token', 'ultimate-social-deux' ),
					'desc' => __( 'Bit.ly link shortener is available for Twitter and Buffer URLs. Get your access token by going to:', 'ultimate-social-deux' ) . ' ' . 'https://bitly.com/a/oauth_apps',
					'type' => 'text',
				),
				array(
					'name' => 'us_counts_transient',
					'label' => __( 'Caching for share buttons', 'ultimate-social-deux' ),
					'desc' => __( "in seconds. We are caching some of the results from the API's that are not returning a valid JSONP output.", 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '600',
				),
				array(
					'name' => 'us_enqueue',
					'label' => __( 'Style and script enqueuing', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'no',
					'desc' => __( "Some themes need to have the styles and scripts loaded on 'All Pages', some can load the styles and scripts on 'Individual Pages' where the buttons are visual.", 'ultimate-social-deux' ),
					'options' => array(
						'all_pages' => __( 'All Pages', 'ultimate-social-deux' ),
						'individual' => __( 'Individual Pages', 'ultimate-social-deux' ),
						'manually' => __( 'Manually - no styles or scripts will load', 'ultimate-social-deux' )
					)
				),
			),
			/**
			 * Styling settings.
			 */
			'us_styling' => array(
				array(
					'name' => 'us_custom_css_header',
					'label' => '<h2>'.__( 'Custom CSS', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_custom_css',
					'label' => __( 'Custom CSS field', 'ultimate-social-deux' ),
					'type' => 'textarea',
				),
				array(
					'name' => 'us_border_radius_sharing_header',
					'label' => '<h2>'.__( 'Border radius - sharing buttons', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_border_radius_sharing_top_left',
					'label' => __( 'top', 'ultimate-social-deux' ) . ' ' . __( 'left', 'ultimate-social-deux' ),
					'type' => 'select',
					'options' => self::fifteenpx_array(),
					'default' => '0',
				),
				array(
					'name' => 'us_border_radius_sharing_top_right',
					'label' => __( 'top', 'ultimate-social-deux' ) . ' ' . __( 'right', 'ultimate-social-deux' ),
					'type' => 'select',
					'options' => self::fifteenpx_array(),
					'default' => '0',
				),
				array(
					'name' => 'us_border_radius_sharing_bottom_left',
					'label' => __( 'bottom', 'ultimate-social-deux' ) . ' ' . __( 'left', 'ultimate-social-deux' ),
					'type' => 'select',
					'options' => self::fifteenpx_array(),
					'default' => '0',
				),
				array(
					'name' => 'us_border_radius_sharing_bottom_right',
					'label' => __( 'bottom', 'ultimate-social-deux' ) . ' ' . __( 'right', 'ultimate-social-deux' ),
					'type' => 'select',
					'options' => self::fifteenpx_array(),
					'default' => '0',
				),
				array(
					'name' => 'us_border_radius_fan_count_header',
					'label' => '<h2>'.__( 'Border radius - Fan Count', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_border_radius_fan_count_top_left',
					'label' => __( 'top', 'ultimate-social-deux' ) . ' ' . __( 'left', 'ultimate-social-deux' ),
					'type' => 'select',
					'options' => self::sixtypx_array(),
					'default' => '0',
				),
				array(
					'name' => 'us_border_radius_fan_count_top_right',
					'label' => __( 'top', 'ultimate-social-deux' ) . ' ' . __( 'right', 'ultimate-social-deux' ),
					'type' => 'select',
					'options' => self::sixtypx_array(),
					'default' => '0',
				),
				array(
					'name' => 'us_border_radius_fan_count_bottom_left',
					'label' => __( 'bottom', 'ultimate-social-deux' ) . ' ' . __( 'left', 'ultimate-social-deux' ),
					'type' => 'select',
					'options' => self::sixtypx_array(),
					'default' => '0',
				),
				array(
					'name' => 'us_border_radius_fan_count_bottom_right',
					'label' => __( 'bottom', 'ultimate-social-deux' ) . ' ' . __( 'right', 'ultimate-social-deux' ),
					'type' => 'select',
					'options' => self::sixtypx_array(),
					'default' => '0',
				),
				array(
					'name' => 'us_color_control_header',
					'label' => '<h2>'.__( 'Color control', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_hover_color',
					'label' => __( 'Hover', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'When hovering over a button the button changes to this color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#008000',
				),
				array(
					'name' => 'us_facebook_color',
					'label' => __( 'Facebook', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Facebook', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#3b5998',
				),
				array(
					'name' => 'us_twitter_color',
					'label' => __( 'Twitter', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Twitter', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#00ABF0',
				),
				array(
					'name' => 'us_googleplus_color',
					'label' => __( 'Google Plus', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Google Plus', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#D95232',
				),
				array(
					'name' => 'us_pinterest_color',
					'label' => __( 'Pinterest', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Pinterest', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#AE181F',
				),
				array(
					'name' => 'us_linkedin_color',
					'label' => __( 'LinkedIn', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'LinkedIn', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#1C86BC',
				),
				array(
					'name' => 'us_delicious_color',
					'label' => __( 'Delicious', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Delicious', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#66B2FD',
				),
				array(
					'name' => 'us_stumble_color',
					'label' => __( 'StumbleUpon', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'StumbleUpon', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#E94B24',
				),
				array(
					'name' => 'us_buffer_color',
					'label' => __( 'Buffer', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Buffer', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#000000',
				),
				array(
					'name' => 'us_reddit_color',
					'label' => __( 'Reddit', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Reddit', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#CEE3F8',
				),
				array(
					'name' => 'us_vkontakte_color',
					'label' => __( 'VKontakte', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'VKontakte', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#537599',
				),
				array(
					'name' => 'us_mail_color',
					'label' => __( 'Mail', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Mail', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#666666',
				),
				array(
					'name' => 'us_love_color',
					'label' => __( 'Love', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Love', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#FF0000',
				),
				array(
					'name' => 'us_pocket_color',
					'label' => __( 'Pocket', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Pocket', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#ee4056',
				),
				array(
					'name' => 'us_print_color',
					'label' => __( 'Printfriendlyfriendly', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Printfriendlyfriendly', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#60d0d4',
				),
				array(
					'name' => 'us_flipboard_color',
					'label' => __( 'Flipboard', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Flipboard', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#c10000',
				),
				array(
					'name' => 'us_comments_color',
					'label' => __( 'Comments', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Comments', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#b69823',
				),
				array(
					'name' => 'us_tumblr_color',
					'label' => __( 'Tumblr', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Tumblr', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#529ecc',
				),
				array(
					'name' => 'us_feedly_color',
					'label' => __( 'Feedly', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Feedly', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#414141',
				),
				array(
					'name' => 'us_youtube_color',
					'label' => __( 'Youtube', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Youtube', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#cc181e',
				),
				array(
					'name' => 'us_vimeo_color',
					'label' => __( 'Vimeo', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Vimeo', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#1bb6ec',
				),
				array(
					'name' => 'us_dribbble_color',
					'label' => __( 'Dribbble', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Dribbble', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#f72b7f',
				),
				array(
					'name' => 'us_envato_color',
					'label' => __( 'Envato', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Envato', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#82b540',
				),
				array(
					'name' => 'us_github_color',
					'label' => __( 'Github', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Github', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#201e1f',
				),
				array(
					'name' => 'us_soundcloud_color',
					'label' => __( 'SoundCloud', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'SoundCloud', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#ff6f00',
				),
				array(
					'name' => 'us_instagram_color',
					'label' => __( 'Instagram', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Instagram', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#48769c',
				),
				array(
					'name' => 'us_feedpress_color',
					'label' => __( 'Feedpress', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Feedpress', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#ffafaf',
				),
				array(
					'name' => 'us_mailchimp_color',
					'label' => __( 'Mailchimp', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Mailchimp', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#6dc5dc',
				),
				array(
					'name' => 'us_flickr_color',
					'label' => __( 'Flickr', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Flickr', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#0062dd',
				),
				array(
					'name' => 'us_members_color',
					'label' => __( 'Members', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Members', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#0ab071',
				),
				array(
					'name' => 'us_posts_color',
					'label' => __( 'Posts', 'ultimate-social-deux' ) . ' ' . __( 'Color', 'ultimate-social-deux' ),
					'desc' => __( 'Posts', 'ultimate-social-deux' ) . ' ' . __( 'button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#924e2a',
				),
			),
			/**
			 * Mail settings.
			 */
			'us_mail' => array(
				array(
					'name' => 'us_mail_header',
					'label' => __( 'Popup header:', 'ultimate-social-deux' ),
					'desc' => __( 'The heading of the mail popup', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __('Share with your friends','ultimate-social-deux'),
				),
				array(
					'name' => 'us_mail_from_email',
					'label' => __( 'Mail From:', 'ultimate-social-deux' ),
					'desc' => __( 'Email address that mail form will email from', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => get_bloginfo('admin_email'),
				),
				array(
					'name' => 'us_mail_from_name',
					'label' => __( 'Mail From Name:', 'ultimate-social-deux' ),
					'desc' => __( 'Name that mail form will email with', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => get_bloginfo('name'),
				),
				array(
					'name' => 'us_mail_subject',
					'label' => __( 'Mail Subject:', 'ultimate-social-deux' ),
					'desc' => __( 'Subject of email.', 'ultimate-social-deux' ) . '<br>' . __('Available tags is:', 'ultimate-social-deux' ) . '<br>{post_title} -> ' . __('Outputs title of the post or page', 'ultimate-social-deux' ) . '<br>{post_url} -> ' . __('Outputs url of the post or page', 'ultimate-social-deux' ) . '<br>{post_author} -> ' . __('Outputs the author of the post or page', 'ultimate-social-deux' ) . '<br>{site_title} -> ' . __('Outputs the title of the Wordpress Install', 'ultimate-social-deux' ) . '<br>{site_url} -> ' . __('Outputs the url of the Wordpress Install', 'ultimate-social-deux' ) . '<br>{sender_name} -> ' . __('Outputs the senders name', 'ultimate-social-deux' ) . '<br>{sender_email} -> ' . __('Outputs the senders email', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __('A visitor of', 'ultimate-social-deux' ) . ' ' . '{site_title}' . __('shared', 'ultimate-social-deux' ) . ' ' . '{post_title}' . __('with you.','ultimate-social-deux'),
				),
				array(
					'name' => 'us_mail_body',
					'label' => __( 'Mail Message:', 'ultimate-social-deux' ),
					'desc' => __( 'Body of email.', 'ultimate-social-deux' ). ' ' . __('Available tags is:', 'ultimate-social-deux' ) . '<br>{post_title} -> ' . __('Outputs title of the post or page', 'ultimate-social-deux' ) . '<br>{post_url} -> ' . __('Outputs url of the post or page', 'ultimate-social-deux' ) . '<br>{post_author} -> ' . __('Outputs the author of the post or page', 'ultimate-social-deux' ) . '<br>{site_title} -> ' . __('Outputs the title of the Wordpress Install', 'ultimate-social-deux' ) . '<br>{site_url} -> ' . __('Outputs the url of the Wordpress Install', 'ultimate-social-deux' ),
					'type' => 'textarea',
					'default' => __('I read this article and found it very interesting, thought it might be something for you. The article is called', 'ultimate-social-deux' ) . ' ' . '{post_title}' . __('and is located at', 'ultimate-social-deux' ) . '{post_url}.',
				),
				array(
					'name' => 'us_mail_bcc_enable',
					'label' => __( 'Send copy to admin?', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'no',
					'options' => array(
						'yes' => __( 'Yes', 'ultimate-social-deux' ),
						'no' => __( 'No', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_mail_captcha_enable',
					'label' => __( 'Enable Captcha?', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'yes',
					'options' => array(
						'yes' => __( 'Yes', 'ultimate-social-deux' ),
						'no' => __( 'No', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_mail_captcha_question',
					'label' => __( 'Captcha Question', 'ultimate-social-deux' ),
					'desc' => __( 'Your captcha question', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __( 'What is the sum of 7 and 2?', 'ultimate-social-deux' ),
				),
				array(
					'name' => 'us_mail_captcha_answer',
					'label' => __( 'Captcha Answer', 'ultimate-social-deux' ),
					'desc' => __( 'Your captcha answer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '9',
				),
				array(
					'name' => 'us_mail_try',
					'label' => __( 'Try message', 'ultimate-social-deux' ),
					'desc' => __( 'Before the message has been sent', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __( 'Trying to send email...', 'ultimate-social-deux' ),
				),
				array(
					'name' => 'us_mail_success',
					'label' => __( 'Success message', 'ultimate-social-deux' ),
					'desc' => __( 'For successful sent email', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __( 'Great work! Your message was sent.', 'ultimate-social-deux' ),
				),
			),
			/**
			 * Placement settings.
			 */
			'us_placement' => array(
				/**
				 * Floating placement.
				 */
				array(
					'name' => 'us_floating_header',
					'label' => '<h2>'.__( 'Floating', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_floating',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_frontpage' => __( 'Hide on frontpage?', 'ultimate-social-deux' ),
						'hide_blogpage' => __( 'Hide on blog page?', 'ultimate-social-deux' ),
						'hide_posts' => __( 'Hide on posts?', 'ultimate-social-deux' ),
						'hide_pages' => __( 'Hide on pages?', 'ultimate-social-deux' ),
						'hide_archive' => __( 'Hide on archive pages?', 'ultimate-social-deux' ),
						'hide_search' => __( 'Hide on search pages?', 'ultimate-social-deux' ),
						'hide_mobile' => __( 'Hide on mobile?', 'ultimate-social-deux' ),
						'hide_desktop' => __( 'Hide on desktop?', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_floating_url',
					'label' => __( 'Custom URL', 'ultimate-social-deux' ),
					'desc' => __( 'You might want a static URL for your floating buttons across your site.', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_floating_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Floating buttons on posts/pages with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_floating_speed',
					'label' => __( 'Floating animation speed', 'ultimate-social-deux' ),
					'desc' => __( 'in ms', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '1000',
				),

				/**
				 * Pages top placement.
				 */
				array(
					'name' => 'us_pages_top_header',
					'label' => '<h2>'.__( 'Top of Pages', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_pages_top',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_pages_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_pages_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of pages with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_top_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_top_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Pages bottom placement.
				 */
				array(
					'name' => 'us_pages_bottom_header',
					'label' => '<h2>'.__( 'Bottom of Pages', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_pages_bottom',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_pages_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_pages_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of pages with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_bottom_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_bottom_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Post excerpts top placement.
				 */
				array(
					'name' => 'us_excerpts_top_header',
					'label' => '<h2>'.__( 'Top of Post excerpts', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'Your theme may not support this.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_excerpts_top',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_excerpts_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_excerpts_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of post excerpts with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_excerpts_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_excerpts_top_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_excerpts_top_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Post excerpts bottom placement.
				 */
				array(
					'name' => 'us_excerpts_bottom_header',
					'label' => '<h2>'.__( 'Bottom of Post excerpts', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'Your theme may not support this.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_excerpts_bottom',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_excerpts_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_excerpts_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of post excerpts with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_excerpts_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_excerpts_bottom_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_excerpts_bottom_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Posts top placement.
				 */
				array(
					'name' => 'us_posts_top_header',
					'label' => '<h2>'.__( 'Top of Posts', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_posts_top',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_blogpage' => __( 'Hide on blog page?', 'ultimate-social-deux' ),
						'hide_archive' => __( 'Hide on archive pages?', 'ultimate-social-deux' ),
						'hide_search' => __( 'Hide on search pages?', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_posts_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_posts_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of posts with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_top_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_top_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Posts bottom placement.
				 */
				array(
					'name' => 'us_posts_bottom_header',
					'label' => '<h2>'.__( 'Bottom of Posts', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_posts_bottom',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_blogpage' => __( 'Hide on blog page?', 'ultimate-social-deux' ),
						'hide_archive' => __( 'Hide on archive pages?', 'ultimate-social-deux' ),
						'hide_search' => __( 'Hide on search pages?', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_posts_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_posts_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of posts with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_bottom_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_bottom_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * WooCommerce top placement.
				 */
				array(
					'name' => 'us_woocommerce_top_header',
					'label' => '<h2>'.__( 'WooCommerce Top', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'You will need', 'ultimate-social-deux' ) . ' <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> ' . __('for these options to work.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_woocommerce_top',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_woocommerce_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_woocommerce_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of WooCommerce products with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_woocommerce_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_woocommerce_top_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_woocommerce_top_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * WooCommerce bottom placement.
				 */
				array(
					'name' => 'us_woocommerce_bottom_header',
					'label' => '<h2>'.__( 'WooCommerce Bottom', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'You will need', 'ultimate-social-deux' ) . ' <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> ' . __('for these options to work.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_woocommerce_bottom',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_woocommerce_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_woocommerce_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of WooCommerce products with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_woocommerce_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_woocommerce_bottom_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_woocommerce_bottom_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Jigoshop top placement.
				 */
				array(
					'name' => 'us_jigoshop_top_header',
					'label' => '<h2>'.__( 'Jigoshop Top', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'You will need', 'ultimate-social-deux' ) . ' <a href="http://jigoshop.com/" target="_blank">Jigoshop</a> ' . __('for these options to work.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_jigoshop_top',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_jigoshop_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_jigoshop_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of Jigoshop products with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_jigoshop_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_jigoshop_top_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_jigoshop_top_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Jigoshop bottom placement.
				 */
				array(
					'name' => 'us_jigoshop_bottom_header',
					'label' => '<h2>'.__( 'Jigoshop Bottom', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'You will need', 'ultimate-social-deux' ) . ' <a href="http://jigoshop.com/ target="_blank">Jigoshop</a> ' . __('for these options to work.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_jigoshop_bottom',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_jigoshop_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_jigoshop_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of Jigoshop products with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_jigoshop_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_jigoshop_bottom_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_jigoshop_bottom_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Easy Digital Downloads top placement.
				 */
				array(
					'name' => 'us_edd_top_header',
					'label' => '<h2>'.__( 'Easy Digital Downloads Top', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'You will need', 'ultimate-social-deux' ) . ' <a href="http://easydigitaldownloads.com" target="_blank">Easy Digital Downloads</a> ' . __('for these options to work.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_edd_top',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_edd_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_edd_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of Easy Digital Downloads products with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_edd_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_edd_top_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_edd_top_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Easy Digital Downloads bottom placement.
				 */
				array(
					'name' => 'us_edd_bottom_header',
					'label' => '<h2>'.__( 'Easy Digital Downloads Bottom', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'You will need', 'ultimate-social-deux' ) . ' <a href="http://easydigitaldownloads.com" target="_blank">Easy Digital Downloads</a> ' . __('for these options to work.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_edd_bottom',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_edd_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_edd_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of Easy Digital Downloads products with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_edd_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_edd_bottom_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_edd_bottom_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Custom Post Types top placement.
				 */
				array(
					'name' => 'us_cpt_top_header',
					'label' => '<h2>'.__( 'Top of Custom Post Types', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'You might have a plugin or theme which is creating custom post types. You can easily integrate these custom post types with Ultimate Social Deux.', 'ultimate-social-deux' ),
					'type' => 'html',
				),
				array(
					'name' => 'us_cpt_top_cpt',
					'label' => __( 'CPT Slugs', 'ultimate-social-deux' ),
					'desc' => __( 'Add the slugs of the CPT\'s that you want the buttons to display on. Comma seperated: "books, movies, links"', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_cpt_top',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_cpt_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_cpt_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of custom post types with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_cpt_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_cpt_top_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_cpt_top_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

				/**
				 * Custom Post Types bottom placement.
				 */
				array(
					'name' => 'us_cpt_bottom_header',
					'label' => '<h2>'.__( 'Bottom of Custom Post Types', 'ultimate-social-deux' ).'</h2>',
					'desc' => __( 'You might have a plugin or theme which is creating custom post types. You can easily integrate these custom post types with Ultimate Social Deux.', 'ultimate-social-deux' ),
					'type' => 'html',
				),

				array(
					'name' => 'us_cpt_bottom_cpt',
					'label' => __( 'CPT Slugs', 'ultimate-social-deux' ),
					'desc' => __( 'Add the slugs of the CPT\'s that you want the buttons to display on. Comma seperated: "books, movies, links"', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_cpt_bottom',
					'label' => __( 'Buttons', 'ultimate-social-deux' ),
					'type' => 'multicheck',
					'options' => array(
						'total' => __( 'Total', 'ultimate-social-deux' ),
						'facebook' => $facebook,
						'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
						'twitter' => $twitter,
						'googleplus' => $google,
						'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'reddit' => $reddit,
						'vkontakte' => $vkontakte,
						'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
						'love' => __( 'Love', 'ultimate-social-deux' ),
						'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
						'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
						'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
						'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
						'mail' => $mail,
						'comments' => __( 'Comments', 'ultimate-social-deux' ),
						'hide_count' => __( 'Hide count numbers?', 'ultimate-social-deux' ),
						'native' => __( 'Native buttons on hover for Facebook, Google+ and VKontakte?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_cpt_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_cpt_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of custom post types with these IDs? Comma seperated:', 'ultimate-social-deux' ) . ' "42, 12, 4"',
					'type' => 'text',
				),
				array(
					'name' => 'us_cpt_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_cpt_bottom_margin_top',
					'label' => __( 'Margin above buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_cpt_bottom_margin_bottom',
					'label' => __( 'Margin below buttons', 'ultimate-social-deux' ),
					'desc' => __( 'In pixels', 'ultimate-social-deux' ),
					'type' => 'text',
				),

			),

			/**
			 * Fan Count settings.
			 */
			'us_fan_count' => array(
				array(
					'name' => 'us_cache_header',
					'label' => '<h2>'.__( 'Cache', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_cache',
					'label' => __( 'How long should we cache the counts?', 'ultimate-social-deux' ),
					'desc' => __( 'in hours', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '2',
				),
				array(
					'name' => 'us_facebook_header',
					'label' => '<h2>'.__( 'Facebook', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_facebook_id',
					'label' => __( 'Facebook', 'ultimate-social-deux' ) . ' ' . __( 'Page ID', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Your ID is what comes after', 'ultimate-social-deux' ) . ' ' . 'http://facebook.com/',

				),
				array(
					'name' => 'us_twitter_header',
					'label' => '<h2>'.__( 'Twitter', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_twitter_id',
					'label' => __( 'Twitter', 'ultimate-social-deux' ). ' ' .__( 'handle', 'ultimate-social-deux' ),
					'type' => 'text',

				),
				array(
					'name' => 'us_twitter_key',
					'label' => __( 'Twitter', 'ultimate-social-deux' ). ' ' .__( 'App key', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Register your App at', 'ultimate-social-deux' ) . ' ' . 'https://apps.twitter.com/',
				),
				array(
					'name' => 'us_twitter_secret',
					'label' => __( 'Twitter', 'ultimate-social-deux' ). ' ' .__( 'App secret', 'ultimate-social-deux' ),
					'type' => 'password',

				),
				array(
					'name' => 'us_google_header',
					'label' => '<h2>'.__( 'Google Plus', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_google_id',
					'label' => __( 'Google Plus', 'ultimate-social-deux' ) . ' ' . __( 'Page ID', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Your ID is what comes after', 'ultimate-social-deux' ) . ' ' . 'https://plus.google.com/',
				),
				array(
					'name' => 'us_google_key',
					'label' => __( 'Google Plus', 'ultimate-social-deux' ). ' ' .__( 'API key', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Register your App at', 'ultimate-social-deux' ) . ' ' . 'https://developers.google.com/console/help/new/#generatingdevkeys',
				),
				array(
					'name' => 'us_youtube_header',
					'label' => '<h2>'.__( 'YouTube', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_youtube_id',
					'label' => __( 'Youtube', 'ultimate-social-deux' ) . ' ' . __( 'Page ID', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Your ID is what comes after', 'ultimate-social-deux' ) . ' ' . 'https://www.youtube.com/user/',
				),
				array(
					'name' => 'us_vimeo_header',
					'label' => '<h2>'.__( 'Vimeo', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_vimeo_id',
					'label' => __( 'Vimeo', 'ultimate-social-deux' ) . ' ' . __( 'Channel ID', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Your ID is what comes after', 'ultimate-social-deux' ) . ' ' . 'http://vimeo.com/channels/',
				),
				array(
					'name' => 'us_soundcloud_header',
					'label' => '<h2>'.__( 'SoundCloud', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_soundcloud_id',
					'label' => __( 'SoundCloud', 'ultimate-social-deux' ) . ' ' . __( 'Client ID', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Register your App at', 'ultimate-social-deux' ) . ' ' . 'http://soundcloud.com/you/apps',
				),
				array(
					'name' => 'us_soundcloud_username',
					'label' => __( 'SoundCloud username', 'ultimate-social-deux' ),
					'type' => 'text',

				),
				array(
					'name' => 'us_dribbble_header',
					'label' => '<h2>'.__( 'Dribbble', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_dribbble_id',
					'label' => __( 'Dribbble', 'ultimate-social-deux' ) . ' ' . __( 'Page ID', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Your ID is what comes after', 'ultimate-social-deux' ) . ' ' . 'https://dribbble.com/',
				),
				array(
					'name' => 'us_github_header',
					'label' => '<h2>'.__( 'Github', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_github_id',
					'label' => __( 'Github', 'ultimate-social-deux' ) . ' ' . __( 'username', 'ultimate-social-deux' ),
					'type' => 'text',

				),
				array(
					'name' => 'us_envato_header',
					'label' => '<h2>'.__( 'Envato', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_envato_id',
					'label' => __( 'Envato', 'ultimate-social-deux' ) . ' ' . __( 'username', 'ultimate-social-deux' ),
					'type' => 'text',

				),
				array(
					'name' => 'us_instagram_header',
					'label' => '<h2>'.__( 'Instagram', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_instagram_api',
					'label' => __( 'Instagram', 'ultimate-social-deux' ) . ' ' . __( 'Access Token', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' =>  __( 'Find your access token by following', 'ultimate-social-deux' ). ' ' . '<a href="http://www.pinceladasdaweb.com.br/instagram/access-token/" target="_blank">'. __( 'this link.', 'ultimate-social-deux' ).'</a>',

				),
				array(
					'name' => 'us_instagram_username',
					'label' => __( 'Instagram', 'ultimate-social-deux' ) . ' ' . __( 'username', 'ultimate-social-deux' ),
					'type' => 'text',

				),
				array(
					'name' => 'us_vkontakte_header',
					'label' => '<h2>'.__( 'VKontakte', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),

				array(
					'name' => 'us_vkontakte_id',
					'label' => __( 'VKontakte', 'ultimate-social-deux' ) . ' ' . __( 'Group ID', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Your ID is what comes after', 'ultimate-social-deux' ) . ' ' . 'http://vk.com/.' . ' ' . __( 'Make sure that you are getting a group ID and not a page ID.', 'ultimate-social-deux' ),
				),
				array(
					'name' => 'us_pinterest_header',
					'label' => '<h2>'.__( 'Pinterest', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_pinterest_username',
					'label' => __( 'Pinterest', 'ultimate-social-deux' ) . ' ' . __( 'username', 'ultimate-social-deux' ),
					'type' => 'text',

				),
				array(
					'name' => 'us_flickr_header',
					'label' => '<h2>'.__( 'Flickr', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_flickr_id',
					'label' => __( 'Flickr', 'ultimate-social-deux' ) . ' ' . __( 'Group ID', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Your ID is what comes after', 'ultimate-social-deux' ) . ' ' . 'https://www.flickr.com/groups/',
				),
				array(
					'name' => 'us_flickr_api',
					'label' => __( 'Flickr', 'ultimate-social-deux' ) . ' ' . __( 'API key', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Register your App at', 'ultimate-social-deux' ) . ' ' . 'https://www.flickr.com/services/apps/create/apply',
				),
				array(
					'name' => 'us_mailchimp_header',
					'label' => '<h2>'.__( 'Mailchimp', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_mailchimp_name',
					'label' => __( 'Mailchimp', 'ultimate-social-deux' ) . ' ' . __( 'list name', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Get your list name from', 'ultimate-social-deux' ) . ' ' . 'https://admin.mailchimp.com/lists/',
				),
				array(
					'name' => 'us_mailchimp_api',
					'label' => __( 'Mailchimp', 'ultimate-social-deux' ) . ' ' . __( 'API key', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Register your App at', 'ultimate-social-deux' ) . ' ' . 'https://admin.mailchimp.com/account/api/',
				),
				array(
					'name' => 'us_mailchimp_link',
					'label' => __( 'Mailchimp', 'ultimate-social-deux' ) . ' ' . __( 'subscription link', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Use your own or build one with Mailchimp', 'ultimate-social-deux' ),
				),
				array(
					'name' => 'us_feedpress_header',
					'label' => '<h2>'.__( 'Feedpress', 'ultimate-social-deux' ).'</h2>',
					'type' => 'html',
				),
				array(
					'name' => 'us_feedpress_url',
					'label' => __( 'Feedpress', 'ultimate-social-deux' ) . ' ' . __( 'JSON url', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Link yo your feeds .json file. First go to', 'ultimate-social-deux' ) . ' ' . 'http://feedpress.it/feeds/YOUR-FEED-ID.' . ' ' . __( 'Then choose JSON File from the Miscellaneous dropdown menu. You must have a Premium Feedpress account to do use this.', 'ultimate-social-deux' ),
				),
				array(
					'name' => 'us_feedpress_manual',
					'label' => __( 'Manual RSS count', 'ultimate-social-deux' ),
					'type' => 'text',
					'desc' => __( 'Add a manual count if you do not have a Premium Feedpress account.', 'ultimate-social-deux' ),
				),
			),

			/**
			 * Advanced settings.
			 */
			'us_advanced' => array(
				array(
					'name' => 'us_facebook_height',
					'label' => __( 'Facebook', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_facebook_width',
					'label' => __( 'Facebook', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_twitter_height',
					'label' => __( 'Twitter', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_twitter_width',
					'label' => __( 'Twitter', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_googleplus_height',
					'label' => __( 'Google Plus', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_googleplus_width',
					'label' => __( 'Google Plus', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_delicious_height',
					'label' => __( 'Delicious', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_delicious_width',
					'label' => __( 'Delicious', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_stumble_height',
					'label' => __( 'StumbleUpon', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_stumble_width',
					'label' => __( 'StumbleUpon', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_linkedin_height',
					'label' => __( 'LinkedIn', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_linkedin_width',
					'label' => __( 'LinkedIn', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_pinterest_height',
					'label' => __( 'Pinterest', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '320',
				),
				array(
					'name' => 'us_pinterest_width',
					'label' => __( 'Pinterest', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '720',
				),
				array(
					'name' => 'us_buffer_height',
					'label' => __( 'Buffer', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_buffer_width',
					'label' => __( 'Buffer', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_reddit_height',
					'label' => __( 'Reddit', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_reddit_width',
					'label' => __( 'Reddit', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_vkontakte_height',
					'label' => __( 'VKontakte', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_vkontakte_width',
					'label' => __( 'VKontakte', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_printfriendly_height',
					'label' => __( 'Printfriendlyfriendly', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_printfriendly_width',
					'label' => __( 'Printfriendlyfriendly', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '1045',
				),
				array(
					'name' => 'us_pocket_height',
					'label' => __( 'Pocket', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_pocket_width',
					'label' => __( 'Pocket', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_tumblr_height',
					'label' => __( 'Tumblr', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_tumblr_width',
					'label' => __( 'Tumblr', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_vkontakte_height',
					'label' => __( 'Flipboard', 'ultimate-social-deux' ) . ' ' . __('Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_vkontakte_width',
					'label' => __( 'Flipboard', 'ultimate-social-deux' ) . ' ' . __('Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'in pixels', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
			),
			/**
			 * License settings.
			 */
			'us_license' => array(
				array(
					'name' => 'us_license',
					'label' => __( 'Enter your CodeCanyon Purchase Code', 'ultimate-social-deux' ),
					'desc' => __( 'This enables automatic updates.', 'ultimate-social-deux' ) . ' <a href="'.admin_url( 'update-core.php?force-check=1' ).'">'.__( 'Check for updates.', 'ultimate-social-deux' ).'</a>',
					'type' => 'password',
				),
				array(
					'name' => 'us_license_help',
					'label' => __( 'To access your Purchase Code for an item:', 'ultimate-social-deux' ),
					'desc' => '<ol><li>' . __( 'Log into your CodeCanyon account.', 'ultimate-social-deux' ) . '</li><li>' . __('From your account dropdown links, select "Downloads".', 'ultimate-social-deux' ) . '</li><li>' . __('Click the "Download" button that corresponds with your purchase.', 'ultimate-social-deux' ) . '</li><li>' . __('Select the "License certificate & purchase code" download link. Your Purchase Code will be displayed within the License Certificate.', 'ultimate-social-deux' ) . '</li></ol>',
					'type' => 'html',
				),
			),
		);

		return $fields;
	}

	public function fifteenpx_array() {
		$array = array(
			'0' => 'none',
			'1' => '1px',
			'2' => '2px',
			'3' => '3px',
			'4' => '4px',
			'5' => '5px',
			'6' => '6px',
			'7' => '7px',
			'8' => '8px',
			'9' => '9px',
			'10' => '10px',
			'11' => '11px',
			'12' => '12px',
			'13' => '13px',
			'14' => '14px',
			'15' => '15px',
		);

		return $array;
	}

	public function sixtypx_array() {
		$array = array(
			'0' => 'none',
			'1' => '1px',
			'2' => '2px',
			'3' => '3px',
			'4' => '4px',
			'5' => '5px',
			'6' => '6px',
			'7' => '7px',
			'8' => '8px',
			'9' => '9px',
			'10' => '10px',
			'11' => '11px',
			'12' => '12px',
			'13' => '13px',
			'14' => '14px',
			'15' => '15px',
			'16' => '16px',
			'17' => '17px',
			'18' => '18px',
			'19' => '19px',
			'20' => '20px',
			'21' => '21px',
			'22' => '22px',
			'23' => '23px',
			'24' => '24px',
			'25' => '25px',
			'26' => '26px',
			'27' => '27px',
			'28' => '28px',
			'29' => '29px',
			'30' => '30px',
			'31' => '31px',
			'32' => '32px',
			'33' => '33px',
			'34' => '34px',
			'35' => '35px',
			'36' => '36px',
			'37' => '37px',
			'38' => '38px',
			'39' => '39px',
			'40' => '40px',
			'41' => '41px',
			'42' => '42px',
			'43' => '43px',
			'44' => '44px',
			'45' => '45px',
			'46' => '46px',
			'47' => '47px',
			'48' => '48px',
			'49' => '49px',
			'50' => '50px',
			'51' => '51px',
			'52' => '52px',
			'53' => '53px',
			'54' => '54px',
			'55' => '55px',
			'56' => '56px',
			'57' => '57px',
			'58' => '58px',
			'59' => '59px',
			'60' => '60px',

		);

		return $array;
	}
}