<?php
/**
 * Ultimate Social Deux.
 *
 * @package 	Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2013 Ultimate Wordpress
 */

class UltimateSocialDeuxShortcodes {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since	 1.0.0
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

		add_shortcode( 'ultimatesocial_fan_counts', array($this, 'fan_counts' ) );
		add_shortcode( 'ultimatesocial_false', array($this, 'all_buttons_false' ) );
		add_shortcode( 'ultimatesocial', array($this, 'all_buttons' ) );
		add_shortcode( 'ultimatesocial_total_false', array($this, 'total_false' ) );
		add_shortcode( 'ultimatesocial_total', array($this, 'total' ) );
		add_shortcode( 'ultimatesocial_total_only', array($this, 'total_only' ) );
		add_shortcode( 'ultimatesocial_facebook', array($this, 'facebook' ) );
		add_shortcode( 'ultimatesocial_twitter', array($this, 'twitter' ) );
		add_shortcode( 'ultimatesocial_google', array($this, 'google' ) );
		add_shortcode( 'ultimatesocial_pinterest', array($this, 'pinterest' ) );
		add_shortcode( 'ultimatesocial_linkedin', array($this, 'linkedin' ) );
		add_shortcode( 'ultimatesocial_stumble', array($this, 'stumble' ) );
		add_shortcode( 'ultimatesocial_delicious', array($this, 'delicious' ) );
		add_shortcode( 'ultimatesocial_buffer', array($this, 'buffer' ) );
		add_shortcode( 'ultimatesocial_reddit', array($this, 'reddit' ) );
		add_shortcode( 'ultimatesocial_vkontakte', array($this, 'vkontakte' ) );
		add_shortcode( 'ultimatesocial_mail', array($this, 'mail' ) );

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
	 * Return shortcode markup for fan counts
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function fan_counts( $atts ) {

		$defaults = array(
			'networks' => '',
			'rows' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= UltimateSocialDeuxFanCount::fan_count_output($atts['networks'], $atts['rows']);

		return $shortcode;

	}

	/**
	 * Return shortcode markup for all buttons default false
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function all_buttons_false( $atts ) {

		$defaults = array(
			'facebook' => false,
			'twitter' => false,
			'google' => false,
			'pinterest' => false,
			'linkedin' => false,
			'stumble' => false,
			'delicious' => false,
			'buffer' => false,
			'reddit' => false,
			'vkontakte' => false,
			'mail' => false,
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
			'native' => false,
			'networks' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		if (!$atts['networks']) {
			$networks['facebook'] = ($atts['facebook']) ? 'facebook': '';
			$networks['twitter'] = ($atts['twitter']) ? 'twitter': '';
			$networks['google'] = ($atts['google']) ? 'google': '';
			$networks['pinterest'] = ($atts['pinterest']) ? 'pinterest': '';
			$networks['linkedin'] = ($atts['linkedin']) ? 'linkedin': '';
			$networks['stumble'] = ($atts['stumble']) ? 'stumble': '';
			$networks['delicious'] = ($atts['delicious']) ? 'delicious': '';
			$networks['buffer'] = ($atts['buffer']) ? 'buffer': '';
			$networks['reddit'] = ($atts['reddit']) ? 'reddit': '';
			$networks['vkontakte'] = ($atts['vkontakte']) ? 'vkontakte': '';
			$networks['mail'] = ($atts['mail']) ? 'mail': '';
		} else {
			$networks = $atts['networks'];
		}

		$shortcode = '';

		if ( $networks ) {

			$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

				$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], $networks, $atts['url'], $atts['align'], $atts['count'], $atts['native'] );

			$shortcode .= '</div>';

		}

		return $shortcode;

	}

	/**
	 * Return shortcode markup for all buttons
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function all_buttons( $atts ) {

		$defaults = array(
			'facebook' => true,
			'twitter' => true,
			'google' => true,
			'pinterest' => true,
			'linkedin' => true,
			'stumble' => true,
			'delicious' => true,
			'buffer' => true,
			'reddit' => true,
			'vkontakte' => true,
			'mail' => true,
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
			'native' => false,
			'networks' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		if (!$atts['networks']) {
			$networks['facebook'] = ($atts['facebook']) ? 'facebook': '';
			$networks['twitter'] = ($atts['twitter']) ? 'twitter': '';
			$networks['google'] = ($atts['google']) ? 'google': '';
			$networks['pinterest'] = ($atts['pinterest']) ? 'pinterest': '';
			$networks['linkedin'] = ($atts['linkedin']) ? 'linkedin': '';
			$networks['stumble'] = ($atts['stumble']) ? 'stumble': '';
			$networks['delicious'] = ($atts['delicious']) ? 'delicious': '';
			$networks['buffer'] = ($atts['buffer']) ? 'buffer': '';
			$networks['reddit'] = ($atts['reddit']) ? 'reddit': '';
			$networks['vkontakte'] = ($atts['vkontakte']) ? 'vkontakte': '';
			$networks['mail'] = ($atts['mail']) ? 'mail': '';
		} else {
			$networks = $atts['networks'];
		}

		$shortcode = '';

		if ( $networks ) {

			$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

				$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], $networks, $atts['url'], $atts['align'], $atts['count'], $atts['native'] );

			$shortcode .= '</div>';

		}

		return $shortcode;

	}

	/**
	 * Return shortcode markup for total button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function total_false( $atts ) {

		$defaults = array(
			'share_text' => '',
			'facebook' => false,
			'twitter' => false,
			'google' => false,
			'pinterest' => false,
			'linkedin' => false,
			'stumble' => false,
			'delicious' => false,
			'buffer' => false,
			'reddit' => false,
			'vkontakte' => false,
			'mail' => false,
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
			'native' => false,
			'networks' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		if (!$atts['networks']) {
			$networks['total'] = 'total';
			if ($atts['facebook']) {
				$networks['facebook'] = 'facebook';
			}
			if ($atts['twitter']) {
				$networks['twitter'] = 'twitter';
			}
			if ($atts['google']) {
				$networks['google'] = 'google';
			}
			if ($atts['pinterest']) {
				$networks['pinterest'] = 'pinterest';
			}
			if ($atts['linkedin']) {
				$networks['linkedin'] = 'linkedin';
			}
			if ($atts['stumble']) {
				$networks['stumble'] = 'stumble';
			}
			if ($atts['delicious']) {
				$networks['delicious'] = 'delicious';
			}
			if ($atts['buffer']) {
				$networks['buffer'] = 'buffer';
			}
			if ($atts['reddit']) {
				$networks['reddit'] = 'reddit';
			}
			if ($atts['vkontakte']) {
				$networks['vkontakte'] = 'vkontakte';
			}
			if ($atts['mail']) {
				$networks['mail'] = 'mail';
			}
		} else {
			$networks = 'total,' . $atts['networks'];
		}

		$shortcode = '';

		if ( $networks ) {

			$shortcode .= sprintf('<div class="us_shortcode us_total_shortcode %s">', $atts['custom_class'] );

				$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], $networks, $atts['url'], $atts['align'], $atts['count'], $atts['native'] );

			$shortcode .= '</div>';
		}

		return $shortcode;

	}

	/**
	 * Return shortcode markup for total button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function total( $atts ) {

		$defaults = array(
			'share_text' => '',
			'facebook' => true,
			'twitter' => true,
			'google' => true,
			'pinterest' => true,
			'linkedin' => true,
			'stumble' => true,
			'delicious' => true,
			'buffer' => true,
			'reddit' => true,
			'vkontakte' => true,
			'mail' => true,
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'media' => '',
			'count' => true,
			'native' => false,
			'networks' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		if (!$atts['networks']) {
			$networks['total'] = 'total';
			$networks['facebook'] = ($atts['facebook']) ? 'facebook': '';
			$networks['twitter'] = ($atts['twitter']) ? 'twitter': '';
			$networks['google'] = ($atts['google']) ? 'google': '';
			$networks['pinterest'] = ($atts['pinterest']) ? 'pinterest': '';
			$networks['linkedin'] = ($atts['linkedin']) ? 'linkedin': '';
			$networks['stumble'] = ($atts['stumble']) ? 'stumble': '';
			$networks['delicious'] = ($atts['delicious']) ? 'delicious': '';
			$networks['buffer'] = ($atts['buffer']) ? 'buffer': '';
			$networks['reddit'] = ($atts['reddit']) ? 'reddit': '';
			$networks['vkontakte'] = ($atts['vkontakte']) ? 'vkontakte': '';
			$networks['mail'] = ($atts['mail']) ? 'mail': '';
		} else {
			$networks = 'total' . $atts['networks'];
		}

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode us_total_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], $networks, $atts['url'], $atts['align'], $atts['count'], $atts['native'] );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for total button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function total_only( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode us_total_only_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons('', 'total', $atts['url'], $atts['align'], true, false );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for facebook button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function facebook( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
			'native' => false,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'facebook', $atts['url'], $atts['align'], $atts['count'], $atts['native'] );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for twitter button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function twitter( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
			'native' => false,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'twitter', $atts['url'], $atts['align'], $atts['count'], $atts['native'] );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for google button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function google( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
			'native' => false,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'google', $atts['url'], $atts['align'], $atts['count'], $atts['native'] );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for pinterest button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function pinterest( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'pinterest', $atts['url'], $atts['align'], $atts['count'], false );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for linkedin button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function linkedin( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
			'native' => false,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'linkedin', $atts['url'], $atts['align'], $atts['count'], false );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for stumble button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function stumble( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'stumble', $atts['url'], $atts['align'], $atts['count'], false );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for delicious button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function delicious( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'delicious', $atts['url'], $atts['align'], $atts['count'], false );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for buffer button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function buffer( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'buffer', $atts['url'], $atts['align'], $atts['count'], false );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for reddit button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function reddit( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'reddit', $atts['url'], $atts['align'], $atts['count'], false );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for reddit button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function vkontakte( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
			'count' => true,
			'native' => false,
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'vkontakte', $atts['url'], $atts['align'], $atts['count'], $atts['native'] );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for mail button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function mail( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], 'mail', $atts['url'], $atts['align'], '', false );

		$shortcode .= '</div>';

		return $shortcode;

	}

}