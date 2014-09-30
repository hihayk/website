<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2014 Ultimate Wordpress
 */

class UltimateSocialDeuxFanCount_Widget extends WP_Widget {

	// constructor
	function UltimateSocialDeuxFanCount_Widget() {
		parent::WP_Widget(false, $name = __('Ultimate Social Deux - Fan Count', 'ultimate-social-deux') );
	}

	// widget form creation
	function form($instance) {
		$facebook = ( isset($instance['us_w_facebook']) ) ? esc_attr($instance['us_w_facebook']): '';
		$twitter = ( isset($instance['us_w_twitter']) ) ? esc_attr($instance['us_w_twitter']): '';
		$google = ( isset($instance['us_w_google']) ) ? esc_attr($instance['us_w_google']): '';
		$pinterest = ( isset($instance['us_w_pinterest']) ) ? esc_attr($instance['us_w_pinterest']): '';
		$youtube = ( isset($instance['us_w_youtube']) ) ? esc_attr($instance['us_w_youtube']): '';
		$vimeo = ( isset($instance['us_w_vimeo']) ) ? esc_attr($instance['us_w_vimeo']): '';
		$dribbble = ( isset($instance['us_w_dribbble']) ) ? esc_attr($instance['us_w_dribbble']): '';
		$envato = ( isset($instance['us_w_envato']) ) ? esc_attr($instance['us_w_envato']): '';
		$github = ( isset($instance['us_w_github']) ) ? esc_attr($instance['us_w_github']): '';
		$soundcloud = ( isset($instance['us_w_soundcloud']) ) ? esc_attr($instance['us_w_soundcloud']): '';
		$instagram = ( isset($instance['us_w_instagram']) ) ? esc_attr($instance['us_w_instagram']): '';
		$vkontakte = ( isset($instance['us_w_vkontakte']) ) ? esc_attr($instance['us_w_vkontakte']): '';
		$feedpress = ( isset($instance['us_w_feedpress']) ) ? esc_attr($instance['us_w_feedpress']): '';
		$mailchimp = ( isset($instance['us_w_mailchimp']) ) ? esc_attr($instance['us_w_mailchimp']): '';
		$flickr = ( isset($instance['us_w_flickr']) ) ? esc_attr($instance['us_w_flickr']): '';
		$members = ( isset($instance['us_w_members']) ) ? esc_attr($instance['us_w_members']): '';
		$posts = ( isset($instance['us_w_posts']) ) ? esc_attr($instance['us_w_posts']): '';
		$comments = ( isset($instance['us_w_comments']) ) ? esc_attr($instance['us_w_comments']): '';
		$rows = ( isset($instance['us_w_rows']) ) ? esc_attr($instance['us_w_rows']): '';

		?>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_facebook'); ?>" name="<?php echo $this->get_field_name('us_w_facebook'); ?>" type="checkbox" value="1" <?php checked( '1', $facebook ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_facebook'); ?>"><?php _e('Facebook', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_twitter'); ?>" name="<?php echo $this->get_field_name('us_w_twitter'); ?>" type="checkbox" value="1" <?php checked( '1', $twitter ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_twitter'); ?>"><?php _e('Twitter', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_google'); ?>" name="<?php echo $this->get_field_name('us_w_google'); ?>" type="checkbox" value="1" <?php checked( '1', $google ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_google'); ?>"><?php _e('Google Plus', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_pinterest'); ?>" name="<?php echo $this->get_field_name('us_w_pinterest'); ?>" type="checkbox" value="1" <?php checked( '1', $pinterest ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_pinterest'); ?>"><?php _e('Pinterest', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_youtube'); ?>" name="<?php echo $this->get_field_name('us_w_youtube'); ?>" type="checkbox" value="1" <?php checked( '1', $youtube ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_youtube'); ?>"><?php _e('Youtube', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_vimeo'); ?>" name="<?php echo $this->get_field_name('us_w_vimeo'); ?>" type="checkbox" value="1" <?php checked( '1', $vimeo ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_vimeo'); ?>"><?php _e('Vimeo', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_dribbble'); ?>" name="<?php echo $this->get_field_name('us_w_dribbble'); ?>" type="checkbox" value="1" <?php checked( '1', $dribbble ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_dribbble'); ?>"><?php _e('Dribbble', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_envato'); ?>" name="<?php echo $this->get_field_name('us_w_envato'); ?>" type="checkbox" value="1" <?php checked( '1', $envato ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_envato'); ?>"><?php _e('Envato', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_github'); ?>" name="<?php echo $this->get_field_name('us_w_github'); ?>" type="checkbox" value="1" <?php checked( '1', $github ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_github'); ?>"><?php _e('Github', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_soundcloud'); ?>" name="<?php echo $this->get_field_name('us_w_soundcloud'); ?>" type="checkbox" value="1" <?php checked( '1', $soundcloud ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_soundcloud'); ?>"><?php _e('SoundCloud', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_instagram'); ?>" name="<?php echo $this->get_field_name('us_w_instagram'); ?>" type="checkbox" value="1" <?php checked( '1', $instagram ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_instagram'); ?>"><?php _e('Instagram', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_vkontakte'); ?>" name="<?php echo $this->get_field_name('us_w_vkontakte'); ?>" type="checkbox" value="1" <?php checked( '1', $vkontakte ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_vkontakte'); ?>"><?php _e('VKontakte', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_feedpress'); ?>" name="<?php echo $this->get_field_name('us_w_feedpress'); ?>" type="checkbox" value="1" <?php checked( '1', $feedpress ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_feedpress'); ?>"><?php _e('Feedpress', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_mailchimp'); ?>" name="<?php echo $this->get_field_name('us_w_mailchimp'); ?>" type="checkbox" value="1" <?php checked( '1', $mailchimp ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_mailchimp'); ?>"><?php _e('Mailchimp', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_flickr'); ?>" name="<?php echo $this->get_field_name('us_w_flickr'); ?>" type="checkbox" value="1" <?php checked( '1', $flickr ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_flickr'); ?>"><?php _e('Flickr', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_members'); ?>" name="<?php echo $this->get_field_name('us_w_members'); ?>" type="checkbox" value="1" <?php checked( '1', $members ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_members'); ?>"><?php _e('Members', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_posts'); ?>" name="<?php echo $this->get_field_name('us_w_posts'); ?>" type="checkbox" value="1" <?php checked( '1', $posts ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_posts'); ?>"><?php _e('Posts', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_comments'); ?>" name="<?php echo $this->get_field_name('us_w_comments'); ?>" type="checkbox" value="1" <?php checked( '1', $comments ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_comments'); ?>"><?php _e('Comments', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<label for="<?php echo $this->get_field_id('us_w_rows'); ?>"><?php _e('Rows', 'ultimate-social-deux'); ?></label>
			<select name="<?php echo $this->get_field_name('us_w_rows'); ?>" id="<?php echo $this->get_field_id('us_w_rows'); ?>" class="widefat">
			<?php
			$options = array( '1', '2', '3', '4', '5');
			foreach ($options as $option) {
			echo '<option value="' . $option . '" id="' . $option . '"', $rows == $option ? ' selected="selected"' : '', '>', $option, '</option>';
			}
			?>
			</select>
			</p>
		<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
	    // Fields
	    $instance['us_w_share_text'] = strip_tags($new_instance['us_w_share_text']);
	    $instance['us_w_facebook'] = strip_tags($new_instance['us_w_facebook']);
	    $instance['us_w_twitter'] = strip_tags($new_instance['us_w_twitter']);
	    $instance['us_w_google'] = strip_tags($new_instance['us_w_google']);
	    $instance['us_w_pinterest'] = strip_tags($new_instance['us_w_pinterest']);
	    $instance['us_w_youtube'] = strip_tags($new_instance['us_w_youtube']);
	    $instance['us_w_vimeo'] = strip_tags($new_instance['us_w_vimeo']);
	    $instance['us_w_dribbble'] = strip_tags($new_instance['us_w_dribbble']);
	    $instance['us_w_envato'] = strip_tags($new_instance['us_w_envato']);
	    $instance['us_w_github'] = strip_tags($new_instance['us_w_github']);
	    $instance['us_w_soundcloud'] = strip_tags($new_instance['us_w_soundcloud']);
	    $instance['us_w_instagram'] = strip_tags($new_instance['us_w_instagram']);
	    $instance['us_w_vkontakte'] = strip_tags($new_instance['us_w_vkontakte']);
	    $instance['us_w_feedpress'] = strip_tags($new_instance['us_w_feedpress']);
	    $instance['us_w_mailchimp'] = strip_tags($new_instance['us_w_mailchimp']);
	    $instance['us_w_flickr'] = strip_tags($new_instance['us_w_flickr']);
	    $instance['us_w_members'] = strip_tags($new_instance['us_w_members']);
	    $instance['us_w_posts'] = strip_tags($new_instance['us_w_posts']);
	    $instance['us_w_comments'] = strip_tags($new_instance['us_w_comments']);
	    $instance['us_w_rows'] = strip_tags($new_instance['us_w_rows']);

	    return $instance;
	}

	// display widget
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$atts['facebook'] = ( !empty($instance['us_w_facebook']) ) ? 'facebook' : '';
		$atts['twitter'] = ( !empty($instance['us_w_twitter']) ) ? 'twitter' : '';
		$atts['google'] = ( !empty($instance['us_w_google']) ) ? 'google' : '';
		$atts['pinterest'] = ( !empty($instance['us_w_pinterest']) ) ? 'pinterest' : '';
		$atts['youtube'] = ( !empty($instance['us_w_youtube']) ) ? 'youtube' : '';
		$atts['vimeo'] = ( !empty($instance['us_w_vimeo']) ) ? 'vimeo' : '';
		$atts['dribbble'] = ( !empty($instance['us_w_dribbble']) ) ? 'dribbble' : '';
		$atts['envato'] = ( !empty($instance['us_w_envato']) ) ? 'envato' : '';
		$atts['github'] = ( !empty($instance['us_w_github']) ) ? 'github' : '';
		$atts['soundcloud'] = ( !empty($instance['us_w_soundcloud']) ) ? 'soundcloud' : '';
		$atts['instagram'] = ( !empty($instance['us_w_instagram']) ) ? 'instagram' : '';
		$atts['vkontakte'] = ( !empty($instance['us_w_vkontakte']) ) ? 'vkontakte' : '';
		$atts['feedpress'] = ( !empty($instance['us_w_feedpress']) ) ? 'feedpress' : '';
		$atts['mailchimp'] = ( !empty($instance['us_w_mailchimp']) ) ? 'mailchimp' : '';
		$atts['flickr'] = ( !empty($instance['us_w_flickr']) ) ? 'flickr' : '';
		$atts['members'] = ( !empty($instance['us_w_members']) ) ? 'members' : '';
		$atts['posts'] = ( !empty($instance['us_w_posts']) ) ? 'posts' : '';
		$atts['comments'] = ( !empty($instance['us_w_comments']) ) ? 'comments' : '';
		$rows = ( !empty($instance['us_w_rows']) ) ? $instance['us_w_rows'] : '1';

		$networks = '';

		foreach ($atts as &$network) {
			$networks .= $network.',';
		}

		echo $before_widget;

		if (class_exists('UltimateSocialDeux')) {
			echo UltimateSocialDeuxFanCount::fan_count_output($networks, $rows);
		}

		echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("UltimateSocialDeuxFanCount_Widget");'));

class UltimateSocialDeux_Widget extends WP_Widget {

	// constructor
	function UltimateSocialDeux_Widget() {
		parent::WP_Widget(false, $name = __('Ultimate Social Deux', 'ultimate-social-deux') );
	}

	// widget form creation
	function form($instance) {
		$share_text = ( isset($instance['us_w_share_text']) ) ? esc_attr($instance['us_w_share_text']): '';
		$total = ( isset($instance['us_w_total']) ) ? esc_attr($instance['us_w_total']): '';
		$facebook = ( isset($instance['us_w_facebook']) ) ? esc_attr($instance['us_w_facebook']): '';
		$facebook_native = ( isset($instance['us_w_facebook_native']) ) ? esc_attr($instance['us_w_facebook_native']): '';
		$twitter = ( isset($instance['us_w_twitter']) ) ? esc_attr($instance['us_w_twitter']): '';
		$google = ( isset($instance['us_w_google']) ) ? esc_attr($instance['us_w_google']): '';
		$google_native = ( isset($instance['us_w_google_native']) ) ? esc_attr($instance['us_w_google_native']): '';
		$pinterest = ( isset($instance['us_w_pinterest']) ) ? esc_attr($instance['us_w_pinterest']): '';
		$linkedin = ( isset($instance['us_w_linkedin']) ) ? esc_attr($instance['us_w_linkedin']): '';
		$stumble = ( isset($instance['us_w_stumble']) ) ? esc_attr($instance['us_w_stumble']): '';
		$delicious = ( isset($instance['us_w_delicious']) ) ? esc_attr($instance['us_w_delicious']): '';
		$buffer = ( isset($instance['us_w_buffer']) ) ? esc_attr($instance['us_w_buffer']): '';
		$reddit = ( isset($instance['us_w_reddit']) ) ? esc_attr($instance['us_w_reddit']): '';
		$vkontakte = ( isset($instance['us_w_vkontakte']) ) ? esc_attr($instance['us_w_vkontakte']): '';
		$vkontakte_native = ( isset($instance['us_w_vkontakte_native']) ) ? esc_attr($instance['us_w_vkontakte_native']): '';
		$love = ( isset($instance['us_w_love']) ) ? esc_attr($instance['us_w_love']): '';
		$pocket = ( isset($instance['us_w_pocket']) ) ? esc_attr($instance['us_w_pocket']): '';
		$flipboard = ( isset($instance['us_w_flipboard']) ) ? esc_attr($instance['us_w_flipboard']): '';
		$tumblr = ( isset($instance['us_w_tumblr']) ) ? esc_attr($instance['us_w_tumblr']): '';
		$print = ( isset($instance['us_w_print']) ) ? esc_attr($instance['us_w_print']): '';
		$mail = ( isset($instance['us_w_mail']) ) ? esc_attr($instance['us_w_mail']): '';
		$url = ( isset($instance['us_w_url']) ) ? esc_attr($instance['us_w_url']): '';
		$count = ( isset($instance['us_w_count']) ) ? esc_attr($instance['us_w_count']): '';
		$align = ( isset($instance['us_w_align']) ) ? esc_attr($instance['us_w_align']): '';

		?>
			<p>
			<label for="<?php echo $this->get_field_id('us_w_share_text'); ?>"><?php _e('Share text:', 'ultimate-social-deux'); ?></label>
			<input id="<?php echo $this->get_field_id('us_w_share_text'); ?>" name="<?php echo $this->get_field_name('us_w_share_text'); ?>" type="text" value="<?php echo $share_text; ?>" />
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_total'); ?>" name="<?php echo $this->get_field_name('us_w_total'); ?>" type="checkbox" value="1" <?php checked( '1', $total ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_total'); ?>"><?php _e('Total', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_facebook'); ?>" name="<?php echo $this->get_field_name('us_w_facebook'); ?>" type="checkbox" value="1" <?php checked( '1', $facebook ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_facebook'); ?>"><?php _e('Facebook', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_facebook_native'); ?>" name="<?php echo $this->get_field_name('us_w_facebook_native'); ?>" type="checkbox" value="1" <?php checked( '1', $facebook_native ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_facebook_native'); ?>"><?php echo __('Facebook', 'ultimate-social-deux') . ' ' . __('native', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_twitter'); ?>" name="<?php echo $this->get_field_name('us_w_twitter'); ?>" type="checkbox" value="1" <?php checked( '1', $twitter ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_twitter'); ?>"><?php _e('Twitter', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_google'); ?>" name="<?php echo $this->get_field_name('us_w_google'); ?>" type="checkbox" value="1" <?php checked( '1', $google ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_google'); ?>"><?php _e('Google Plus', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_google_native'); ?>" name="<?php echo $this->get_field_name('us_w_google_native'); ?>" type="checkbox" value="1" <?php checked( '1', $google_native ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_google_native'); ?>"><?php echo  __('Google Plus', 'ultimate-social-deux') . ' ' . __('native', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_pinterest'); ?>" name="<?php echo $this->get_field_name('us_w_pinterest'); ?>" type="checkbox" value="1" <?php checked( '1', $pinterest ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_pinterest'); ?>"><?php _e('Pinterest', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_linkedin'); ?>" name="<?php echo $this->get_field_name('us_w_linkedin'); ?>" type="checkbox" value="1" <?php checked( '1', $linkedin ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_linkedin'); ?>"><?php _e('LinkedIn', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_stumble'); ?>" name="<?php echo $this->get_field_name('us_w_stumble'); ?>" type="checkbox" value="1" <?php checked( '1', $stumble ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_stumble'); ?>"><?php _e('StumbleUpon', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_delicious'); ?>" name="<?php echo $this->get_field_name('us_w_delicious'); ?>" type="checkbox" value="1" <?php checked( '1', $delicious ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_delicious'); ?>"><?php _e('Delicious', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_buffer'); ?>" name="<?php echo $this->get_field_name('us_w_buffer'); ?>" type="checkbox" value="1" <?php checked( '1', $buffer ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_facebook'); ?>"><?php _e('Buffer', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_reddit'); ?>" name="<?php echo $this->get_field_name('us_w_reddit'); ?>" type="checkbox" value="1" <?php checked( '1', $reddit ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_reddit'); ?>"><?php _e('Reddit', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_vkontakte'); ?>" name="<?php echo $this->get_field_name('us_w_vkontakte'); ?>" type="checkbox" value="1" <?php checked( '1', $vkontakte ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_vkontakte'); ?>"><?php _e('VKontakte', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_vkontakte_native'); ?>" name="<?php echo $this->get_field_name('us_w_vkontakte_native'); ?>" type="checkbox" value="1" <?php checked( '1', $vkontakte_native ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_vkontakte_native'); ?>"><?php echo __('VKontakte', 'ultimate-social-deux') . ' ' . __('native', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_love'); ?>" name="<?php echo $this->get_field_name('us_w_love'); ?>" type="checkbox" value="1" <?php checked( '1', $love ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_love'); ?>"><?php _e('Love', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_pocket'); ?>" name="<?php echo $this->get_field_name('us_w_pocket'); ?>" type="checkbox" value="1" <?php checked( '1', $pocket ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_pocket'); ?>"><?php _e('Pocket', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_flipboard'); ?>" name="<?php echo $this->get_field_name('us_w_flipboard'); ?>" type="checkbox" value="1" <?php checked( '1', $flipboard ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_flipboard'); ?>"><?php _e('Flipboard', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_tumblr'); ?>" name="<?php echo $this->get_field_name('us_w_tumblr'); ?>" type="checkbox" value="1" <?php checked( '1', $tumblr ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_tumblr'); ?>"><?php _e('Tumblr', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_print'); ?>" name="<?php echo $this->get_field_name('us_w_print'); ?>" type="checkbox" value="1" <?php checked( '1', $print ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_print'); ?>"><?php _e('Print', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_mail'); ?>" name="<?php echo $this->get_field_name('us_w_mail'); ?>" type="checkbox" value="1" <?php checked( '1', $mail ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_mail'); ?>"><?php _e('Mail', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<label for="<?php echo $this->get_field_id('us_w_url'); ?>"><?php _e('Custom URL to share:', 'ultimate-social-deux'); ?></label>
			<input id="<?php echo $this->get_field_id('us_w_url'); ?>" name="<?php echo $this->get_field_name('us_w_url'); ?>" type="text" value="<?php echo $url; ?>" />
			</p>
			<p>
			<input id="<?php echo $this->get_field_id('us_w_count'); ?>" name="<?php echo $this->get_field_name('us_w_count'); ?>" type="checkbox" value="1" <?php checked( '1', $count ); ?> />
			<label for="<?php echo $this->get_field_id('us_w_count'); ?>"><?php _e('Hide counts?', 'ultimate-social-deux'); ?></label>
			</p>
			<p>
			<label for="<?php echo $this->get_field_id('us_w_align'); ?>"><?php _e('Align', 'ultimate-social-deux'); ?></label>
			<select name="<?php echo $this->get_field_name('us_w_align'); ?>" id="<?php echo $this->get_field_id('us_w_align'); ?>" class="widefat">
			<?php
			$options = array( 'left', 'center', 'right');
			foreach ($options as $option) {
			echo '<option value="' . $option . '" id="' . $option . '"', $align == $option ? ' selected="selected"' : '', '>', $option, '</option>';
			}
			?>
			</select>
			</p>
		<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
	    // Fields
	    $instance['us_w_share_text'] = strip_tags($new_instance['us_w_share_text']);
	    $instance['us_w_total'] = strip_tags($new_instance['us_w_total']);
	    $instance['us_w_facebook'] = strip_tags($new_instance['us_w_facebook']);
	    $instance['us_w_facebook_native'] = strip_tags($new_instance['us_w_facebook_native']);
	    $instance['us_w_twitter'] = strip_tags($new_instance['us_w_twitter']);
	    $instance['us_w_google'] = strip_tags($new_instance['us_w_google']);
	    $instance['us_w_google_native'] = strip_tags($new_instance['us_w_google_native']);
	    $instance['us_w_pinterest'] = strip_tags($new_instance['us_w_pinterest']);
	    $instance['us_w_linkedin'] = strip_tags($new_instance['us_w_linkedin']);
	    $instance['us_w_stumble'] = strip_tags($new_instance['us_w_stumble']);
	    $instance['us_w_delicious'] = strip_tags($new_instance['us_w_delicious']);
	    $instance['us_w_buffer'] = strip_tags($new_instance['us_w_buffer']);
	    $instance['us_w_reddit'] = strip_tags($new_instance['us_w_reddit']);
	    $instance['us_w_vkontakte'] = strip_tags($new_instance['us_w_vkontakte']);
	    $instance['us_w_vkontakte_native'] = strip_tags($new_instance['us_w_vkontakte_native']);
	    $instance['us_w_love'] = strip_tags($new_instance['us_w_love']);
	    $instance['us_w_pocket'] = strip_tags($new_instance['us_w_pocket']);
	    $instance['us_w_flipboard'] = strip_tags($new_instance['us_w_flipboard']);
	    $instance['us_w_tumblr'] = strip_tags($new_instance['us_w_tumblr']);
	    $instance['us_w_print'] = strip_tags($new_instance['us_w_print']);
	    $instance['us_w_mail'] = strip_tags($new_instance['us_w_mail']);
	    $instance['us_w_url'] = strip_tags($new_instance['us_w_url']);
	    $instance['us_w_count'] = strip_tags($new_instance['us_w_count']);
	    $instance['us_w_align'] = strip_tags($new_instance['us_w_align']);
	    return $instance;
	}

	// display widget
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$share_text = ( isset($instance['us_w_share_text']) ) ? $instance['us_w_share_text'] : '';
		$atts['total'] = ( !empty($instance['us_w_total']) ) ? 'total' : '';
		$atts['facebook'] = ( !empty($instance['us_w_facebook']) ) ? 'facebook' : '';
		$atts['facebook_native'] = ( !empty($instance['us_w_facebook_native']) ) ? 'facebook_native' : '';
		$atts['twitter'] = ( !empty($instance['us_w_twitter']) ) ? 'twitter' : '';
		$atts['google'] = ( !empty($instance['us_w_google']) ) ? 'google' : '';
		$atts['google_native'] = ( !empty($instance['us_w_google_native']) ) ? 'google_native' : '';
		$atts['pinterest'] = ( !empty($instance['us_w_pinterest']) ) ? 'pinterest' : '';
		$atts['linkedin'] = ( !empty($instance['us_w_linkedin']) ) ? 'linkedin' : '';
		$atts['stumble'] = ( !empty($instance['us_w_stumble']) ) ? 'stumble' : '';
		$atts['delicious'] = ( !empty($instance['us_w_delicious']) ) ? 'delicious' : '';
		$atts['buffer'] = ( !empty($instance['us_w_buffer']) ) ? 'buffer' : '';
		$atts['reddit'] = ( !empty($instance['us_w_reddit']) ) ? 'reddit' : '';
		$atts['vkontakte'] = ( !empty($instance['us_w_vkontakte']) ) ? 'vkontakte' : '';
		$atts['vkontakte_native'] = ( !empty($instance['us_w_vkontakte_native']) ) ? 'vkontakte_native' : '';
		$atts['love'] = ( !empty($instance['us_w_love']) ) ? 'love' : '';
		$atts['pocket'] = ( !empty($instance['us_w_pocket']) ) ? 'pocket' : '';
		$atts['flipboard'] = ( !empty($instance['us_w_flipboard']) ) ? 'flipboard' : '';
		$atts['tumblr'] = ( !empty($instance['us_w_tumblr']) ) ? 'tumblr' : '';
		$atts['print'] = ( !empty($instance['us_w_print']) ) ? 'print' : '';
		$atts['mail'] = ( !empty($instance['us_w_mail']) ) ? 'mail' : '';
		$count = ( !empty($instance['us_w_count']) ) ? false : true;
		$url = ( isset($instance['us_w_url']) ) ? $instance['us_w_url'] : '';
		$align = ( !empty($instance['us_w_align']) ) ? $instance['us_w_align'] : '';

		$networks = '';

		foreach ($atts as &$network) {
			$networks .= $network.',';
		}
		echo $before_widget;

		if (class_exists('UltimateSocialDeux')) {
			echo UltimateSocialDeux::buttons($share_text, $networks, $url, $align, $count, false );
		}

		echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("UltimateSocialDeux_Widget");'));