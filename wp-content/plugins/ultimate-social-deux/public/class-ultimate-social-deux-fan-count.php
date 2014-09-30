<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2013 Ultimate Wordpress
 */

class UltimateSocialDeuxFanCount {

	/**
	 * Instance of this class.
	 *
	 * @since	1.0.0
	 *
	 * @var		object
	 */
	protected static $instance = null;

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
	 * Return fan counters
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function fan_count_output($networks = '', $rows = '1') {

		UltimateSocialDeux::enqueue_stuff();

		global $us_fan_count_data;

		$output = '<div class="us_wrapper us_fan_count_wrapper">';

		$networks = str_replace(' ', '', $networks);

		$networks = explode(',', $networks);

		foreach ($networks as &$network) {

		  switch ($network) {
			  case "facebook":
					$network = 'facebook';
					$count = UltimateSocialDeux::number_format( self::facebook_count() );
					$desc = __('Fans', 'ultimate-social-deux');
					$link = sprintf('https://facebook.com/%s', UltimateSocialDeux::opt('us_facebook_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
			  case "twitter":
					$network = 'twitter';
					$count = UltimateSocialDeux::number_format( self::twitter_count() );
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://twitter.com/%s', UltimateSocialDeux::opt('us_twitter_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "google":
					$network = 'google';
					$count = UltimateSocialDeux::number_format( self::google_count() );
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://plus.google.com/%s/', UltimateSocialDeux::opt('us_google_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "youtube":
					$network = 'youtube';
					$count = UltimateSocialDeux::number_format( self::youtube_count() );
					$desc = __('Subscribers', 'ultimate-social-deux');
					$link = sprintf('https://www.youtube.com/user/%s/', UltimateSocialDeux::opt('us_youtube_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "vimeo":
					$network = 'vimeo';
					$count = UltimateSocialDeux::number_format( self::vimeo_count() );
					$desc = __('Subscribers', 'ultimate-social-deux');
					$link = sprintf('http://vimeo.com/channels/%s', UltimateSocialDeux::opt('us_vimeo_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "dribbble":
					$network = 'dribbble';
					$count = UltimateSocialDeux::number_format( self::dribbble_count() );
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://dribbble.com/%s', UltimateSocialDeux::opt('us_dribbble_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "envato":
					$network = 'envato';
					$count = UltimateSocialDeux::number_format( self::envato_count() );
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('http://codecanyon.net/user/%s/follow', UltimateSocialDeux::opt('us_envato_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "github":
					$network = 'github';
					$count = UltimateSocialDeux::number_format( self::github_count() );
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://github.com/%s', UltimateSocialDeux::opt('us_github_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "soundcloud":
					$network = 'soundcloud';
					$count = UltimateSocialDeux::number_format( self::soundcloud_count() );
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://soundcloud.com/%s', UltimateSocialDeux::opt('us_soundcloud_username', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "instagram":
					$network = 'instagram';
					$count = UltimateSocialDeux::number_format( self::instagram_count() );
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('http://instagram.com/%s', UltimateSocialDeux::opt('us_instagram_username', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "vkontakte":
					$network = 'vkontakte';
					$count = UltimateSocialDeux::number_format( self::vkontakte_count() );
					$desc = __('Members', 'ultimate-social-deux');
					$link = sprintf('http://vk.com/%s', UltimateSocialDeux::opt('us_vkontakte_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "feedpress":
					$network = 'feedpress';
					$count = UltimateSocialDeux::number_format( self::feedpress_count() );
					$desc = __('Subscribers', 'ultimate-social-deux');
					$link = sprintf('%s', UltimateSocialDeux::opt('us_feedpress_url', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "pinterest":
					$network = 'pinterest';
					$count = UltimateSocialDeux::number_format( self::pinterest_count() );
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('http://www.pinterest.com/%s', UltimateSocialDeux::opt('us_pinterest_username', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "mailchimp":
					$network = 'mailchimp';
					$count = UltimateSocialDeux::number_format( self::mailchimp_count() );
					$desc = __('Subscribers', 'ultimate-social-deux');
					$link = sprintf('%s', UltimateSocialDeux::opt('us_mailchimp_link', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "flickr":
					$network = 'flickr';
					$count = UltimateSocialDeux::number_format( self::flickr_count() );
					$desc = __('Members', 'ultimate-social-deux');
					$link = sprintf('https://www.flickr.com/groups/%s/', UltimateSocialDeux::opt('us_flickr_id', 'us_fan_count', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "members":
					$network = 'members';
					$count = UltimateSocialDeux::number_format( self::members_count() );
					$desc = __('Members', 'ultimate-social-deux');
					$link = '';
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "posts":
					$network = 'posts';
					$count = UltimateSocialDeux::number_format( self::posts_count() );
					$desc = __('Posts', 'ultimate-social-deux');
					$link = '';
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
				case "comments":
					$network = 'comments';
					$count = UltimateSocialDeux::number_format( self::comments_count() );
					$desc = __('Comments', 'ultimate-social-deux');
					$link = '';
					$output .= self::counter($network, $count, $desc, $rows, $link);
					break;
			}
		}

		$output .= '</div>';

		if ($us_fan_count_data) {
			self::update_count($us_fan_count_data);
		}

		return $output;
	}

	/**
	 * Return counter markup
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 markup
	 */
	public static function counter($network, $count, $desc, $rows, $link = '') {
		$output = sprintf('<div class="us_fan_count rows-%s">', $rows);
			$output .= ($link) ? sprintf('<a href="%s" target="_blank" class="us_%s_fan_count_link">', $link, $network): '';
				$output .= sprintf('<div class="us_%s_fan_count us_fan_count_button">', $network);
					$output .= '<div class="us_fan_count_icon_holder">';
						$output .= sprintf('<i class="us-icon-%s"></i>', $network);
					$output .= '</div>';
					$output .= '<div class="us_fan_count_holder">';
						$output .= $count;
					$output .= '</div>';
					$output .= '<div class="us_fan_count_desc">';
						$output .= $desc;
					$output .= '</div>';
				$output .= '</div>';
			$output .= ($link) ? sprintf('</a>', $link): '';
		$output .= '</div>';

		return $output;

	}

	/**
	 * Updates options and transients
	 *
	 * @since 	 1.0.0
	 *
	 */
	public static function update_count($data, $network){

		$transient = get_transient( 'us_fan_count_counters' );

		$options = get_option( 'us_fan_count_counters' );

		$cache = intval(UltimateSocialDeux::opt('us_cache', 'us_fan_count', 2));

		$transient[$network] = $data;
		$options['data'][$network] = $data;

		set_transient( 'us_fan_count_counters', $transient , $cache*60*60 );
		update_option( 'us_fan_count_counters', $options );
	}

	/**
	 * Return Twitter count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function twitter_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['twitter']) ){
			$count = $transient['twitter'];
		} else {
			$id = UltimateSocialDeux::opt('us_twitter_id', 'us_fan_count');
			$key = UltimateSocialDeux::opt('us_twitter_key', 'us_fan_count');
			$secret = UltimateSocialDeux::opt('us_twitter_secret', 'us_fan_count');

			if ($id && $key && $secret) {
				$token = get_option( 'us_fan_count_twitter_token' );

				if(!$token) {
					$credentials = $key . ':' . $secret;
					$encode = base64_encode($credentials);

					$args = array(
						'method' => 'POST',
						'httpversion' => '1.1',
						'blocking' => true,
						'headers' => array(
							'Authorization' => 'Basic ' . $encode,
							'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
						),
						'body' => array( 'grant_type' => 'client_credentials' )
					);

					add_filter('https_ssl_verify', '__return_false');
					$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

					$keys = json_decode(wp_remote_retrieve_body($response));

					if($keys) {
						update_option('us_fan_count_twitter_token', $keys->access_token);
						$token = $keys->access_token;
					}
				}

				$args = array(
					'httpversion' => '1.1',
					'blocking' => true,
					'headers' => array(
						'Authorization' => "Bearer $token"
					)
				);

				add_filter('https_ssl_verify', '__return_false');
				$api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=$id";
				$response = wp_remote_get($api_url, $args);

				if (!is_wp_error($response)) {
					$followers = json_decode(wp_remote_retrieve_body($response));
					$count = $followers->followers_count;
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'twitter');
			}

			if( empty( $count ) && !empty( $options['twitter'] ) ) {
				$count = $options['twitter'];
			}
		}
		return $count;
	}

	/**
	 * Return Facebook count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function facebook_count(){

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['facebook']) ){
			$count = $transient['facebook'];
		} else {
			$id = UltimateSocialDeux::opt('us_facebook_id', 'us_fan_count', '');
			if ($id) {
				try {
					$data = @UltimateSocialDeux::remote_get( "http://graph.facebook.com/$id");
					$count = (int) $data['likes'];
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ){
				$data = $count;
				self::update_count($data, 'facebook');
			}

			if( empty( $count ) && !empty( $options['facebook'] ) ){
				$count = $options['facebook'];
			}
		}
		return $count;
	}

	/**
	 * Return Google count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function google_count(){

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['google']) ){
			$count = $transient['google'];
		} else {
			$id = UltimateSocialDeux::opt('us_google_id', 'us_fan_count', '');
			$key = UltimateSocialDeux::opt('us_google_key', 'us_fan_count', '');
			if($key && $id) {
				try {
					$data = @UltimateSocialDeux::remote_get("https://www.googleapis.com/plus/v1/people/".$id."?key=".$key);

					$count = intval( $data['circledByCount'] );
				} catch (Exception $e) {
					$count = 0;
				}

			} elseif($id) {
				$id = 'https://plus.google.com/' . $id;
				try {
					$data_params = array(
						'method'  => 'POST',
						'sslverify' => false,
						'timeout'  => 30,
						'headers'  => array( 'Content-Type' => 'application/json' ),
						'body'   => '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $id . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]'
			  		);
					$data = wp_remote_get( 'https://clients6.google.com/rpc', $data_params );

					if ( is_wp_error( $data ) || '400' <= $data['response']['code'] ) {
						$count = ( isset( $options['google'] ) ) ? $options['google'] : 0;
					} else {
						$response = json_decode( $data['body'], true );
						if ( isset( $response[0]['result']['metadata']['globalCounts']['count'] ) ) {
							$count = $response[0]['result']['metadata']['globalCounts']['count'];
							$count = $count;
						}
					}
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'google');
			}

			if( empty( $count ) && !empty( $options['google'] ) ) {
				$count = $options['google'];
			}
		}
		return $count;
	}

	/**
	 * Return Youtube count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function youtube_count(){

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['youtube']) ){
			$count = $transient['youtube'];
		} else {
			$id = UltimateSocialDeux::opt('us_youtube_id', 'us_fan_count', '');
			if ($id) {
				try {
					$data = @UltimateSocialDeux::remote_get("http://gdata.youtube.com/feeds/api/users/$id?alt=json");
					$count = (int) $data['entry']['yt$statistics']['subscriberCount'];
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ){
				$data = $count;
				self::update_count($data, 'youtube');
			}

			if( empty( $count ) && !empty( $options['youtube'] ) ){
				$count = $options['youtube'];
			}
		}
		return $count;
	}

	/**
	 * Return SoundCloud count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function soundcloud_count(){

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['soundcloud']) ){
			$count = $transient['soundcloud'];
		} else {
			$id = UltimateSocialDeux::opt('us_soundcloud_id', 'us_fan_count', '');
			$user = UltimateSocialDeux::opt('us_soundcloud_username', 'us_fan_count', '');
			if ($id && $user) {
				try {
					$data = @wp_remote_get( 'http://api.soundcloud.com/users/' . $user . '.json?client_id=' . $id );
					$response = json_decode( $data['body'], true );

					$count = intval( $response['followers_count'] );
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ){
				$data = $count;
				self::update_count($data, 'soundcloud');
			}

			if( empty( $count ) && !empty( $options['soundcloud'] ) ){
				$count = $options['soundcloud'];
			}
		}
		return $count;
	}

	/**
	 * Return Vimeo count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function vimeo_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['vimeo']) ){
			$count = $transient['vimeo'];
		} else {
			$id = UltimateSocialDeux::opt('us_vimeo_id', 'us_fan_count', '');
			if ($id) {
				try {
					@$data = UltimateSocialDeux::remote_get( "http://vimeo.com/api/v2/channel/$id/info.json" );
					$count = (int) $data['total_subscribers'];
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'vimeo');
			}

			if( empty( $count ) && !empty( $options['vimeo'] ) ) {
				$count = $options['vimeo'];
			}
		}
		return $count;
	}

	/**
	 * Return Dribbble count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function dribbble_count() {
		global $us_fan_count_data;

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['dribbble']) ){
			$count = $transient['dribbble'];
		} else {
			$id = UltimateSocialDeux::opt('us_dribbble_id', 'us_fan_count', '');
			if ($id) {
				try {
					$data = @UltimateSocialDeux::remote_get("http://api.dribbble.com/$id");
					$count = (int) $data['followers_count'];
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'dribbble');
			}

			if( empty( $count ) && !empty( $options['dribbble'] ) ) {
				$count = $options['dribbble'];
			}
		}
		return $count;
	}

	/**
	 * Return Github count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function github_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['github']) ){
			$count = $transient['github'];
		} else {
			$id = UltimateSocialDeux::opt('us_github_id', 'us_fan_count', '');
			if ($id) {
				try {
					$data = @UltimateSocialDeux::remote_get("https://api.github.com/users/$id");
					$count = (int) $data['followers'];
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) )
				$data = $count;
				self::update_count($data, 'github');

			if( empty( $count ) && !empty( $options['github'] ) ) {
				$count = $options['github'];
			}
		}
		return $count;
	}

	/**
	 * Return Envato count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function envato_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['envato']) ){
			$count = $transient['envato'];
		} else {
			$id = UltimateSocialDeux::opt('us_envato_id', 'us_fan_count', 'ultimate-wp');
			if ($id) {
				try {
					$data = @UltimateSocialDeux::remote_get("http://marketplace.envato.com/api/edge/user:$id.json");
					$count = (int) $data['user']['followers'];
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'envato');
			}

			if( empty( $count ) && !empty( $options['envato'] ) ) {
				$count = $options['envato'];
			}
		}
		return $count;
	}

	/**
	 * Return Instagram count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function instagram_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['instagram']) ){
			$count = $transient['instagram'];
		} else {
			$api = UltimateSocialDeux::opt('us_instagram_api', 'us_fan_count', '');
			$id = explode(".", $api);
			if ($api && $id) {
				try {
					$data = @UltimateSocialDeux::remote_get("https://api.instagram.com/v1/users/$id[0]/?access_token=$api");
					$count = (int) $data['data']['counts']['followed_by'];
				} catch (Exception $e) {
					$count = 0;
				}
			}


			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'instagram');
			}

			if( empty( $count ) && !empty( $options['instagram'] ) ) {
				$count = $options['instagram'];
			}
		}
		return $count;
	}

	/**
	 * Return Mailchimp count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function mailchimp_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['mailchimp']) ){
			$count = $transient['mailchimp'];
		} else {

			$name = UltimateSocialDeux::opt('us_mailchimp_name', 'us_fan_count', '');
			$api = UltimateSocialDeux::opt('us_mailchimp_api', 'us_fan_count', '');

			if ($name && $api) {
				if (!class_exists('MCAPI')) {
					require_once( plugin_dir_path( __FILE__ ) . 'includes/MCAPI.class.php' );
				}

				$api = new MCAPI($api);
				$retval = $api->lists();
				$count = 0;

				foreach ($retval['data'] as $list){
					if($list['name'] == $name){
						$count = $list['stats']['member_count'];
						break;
					}
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'mailchimp');
			}

			if( empty( $count ) && !empty( $options['mailchimp'] ) ) {
				$count = $options['mailchimp'];
			}
		}
		return $count;
	}

	/**
	 * Return VKontakte count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function vkontakte_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['vkontakte']) ){
			$count = $transient['vkontakte'];
		} else {
			$id = UltimateSocialDeux::opt('us_vkontakte_id', 'us_fan_count', '');
			if ($id) {
				try {
					$data = @UltimateSocialDeux::remote_get( "http://api.vk.com/method/groups.getById?gid=$id&fields=members_count");
					$count = (int) $data['response'][0]['members_count'];
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'vkontakte');
			}

			if( empty( $count ) && !empty( $options['vkontakte'] ) ) {
				$count = $options['vkontakte'];
			}
		}
		return $count;
	}

	/**
	 * Return Pinterest count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function pinterest_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['pinterest']) ){
			$count = $transient['pinterest'];
		} else {
			$username = UltimateSocialDeux::opt('us_pinterest_username', 'us_fan_count', '');
			if ($username) {
				try {
					$html = UltimateSocialDeux::remote_get( "http://www.pinterest.com/$username/" , false);
					$doc = new DOMDocument();
					@$doc->loadHTML($html);
					$metas = $doc->getElementsByTagName('meta');
					for ($i = 0; $i < $metas->length; $i++){
						$meta = $metas->item($i);
						if($meta->getAttribute('name') == 'pinterestapp:followers'){
							$count = $meta->getAttribute('content');
							break;
						}
					}

				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'pinterest');
			}

			if( empty( $count ) && !empty( $options['pinterest'] ) ) {
				$count = $options['pinterest'];
			}
		}
		return $count;
	}

	/**
	 * Return Flickr count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function flickr_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		if( !empty($transient['flickr']) ){
			$count = $transient['flickr'];
		} else {
			$id = UltimateSocialDeux::opt('us_flickr_id', 'us_fan_count', '');
			$api = UltimateSocialDeux::opt('us_flickr_api', 'us_fan_count', '');
			if ($id && $api) {
				try {
					$data = @UltimateSocialDeux::remote_get( "https://api.flickr.com/services/rest/?method=flickr.groups.getInfo&api_key=$api&group_id=$id&format=json&nojsoncallback=1");
					$count = (int) $data['group']['members']['_content'];
				} catch (Exception $e) {
					$count = 0;
				}
			}

			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'flickr');
			}

			if( empty( $count ) && !empty( $options['flickr'] ) ) {
				$count = $options['flickr'];
			}
		}
		return $count;
	}

	/**
	 * Return feedpress count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function feedpress_count() {

		$transient = get_transient( 'us_fan_count_counters' );

		$options = UltimateSocialDeux::opt('data', 'us_fan_count_counters', '');

		$manual = intval( UltimateSocialDeux::opt('us_feedpress_manual', 'us_fan_count', 0) );

		if( !empty($transient['feedpress']) ){
			$count = $transient['feedpress'];
		} elseif( empty($transient['feedpress']) && !empty($us_fan_count_data) && !empty( $options['feedpress'] ) ){
			$count = $options['feedpress'];
		} else {
			$url = UltimateSocialDeux::opt('us_feedpress_url', 'us_fan_count', '');
			if ($url) {
				try {
					$data = @UltimateSocialDeux::remote_get( $url );
					$count = (int) $data[ 'subscribers' ];
				} catch (Exception $e) {
					$count = 0;
				}
			}
			if( !empty( $count ) ) {
				$data = $count;
				self::update_count($data, 'feedpress');
			}

			if( empty( $count ) && !empty( $options['feedpress'] ) ) {
				$count = $options['feedpress'];
			}
		}

		return $count + $manual;
	}

	/**
	 * Return post count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function posts_count() {
		$count_posts = wp_count_posts();
		$count = $count_posts->publish ;
		return $count;
	}

	/**
	 * Return comments count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function comments_count() {
		$comments_count = wp_count_comments() ;
		$count = $comments_count->approved ;
		return $count;
	}

	/**
	 * Return members count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function members_count() {
		$members_count = count_users() ;
		$count = $members_count['total_users'] ;
		return $count;
	}

}
