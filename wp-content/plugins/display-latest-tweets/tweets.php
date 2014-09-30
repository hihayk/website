<?php
/*
 * Plugin Name: Display Latest Tweets
 * Plugin URI: http://wordpress.org/plugins/display-latest-tweets/
 * Description: A widget that displays your latest tweets
 * Version: 1.0
 * Author: Sayful Islam
 * Author URI: http://www.sayful.net
 * License: GPL2
*/

/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget("SIS_Tweet_Widget");' ) );

/**
 * Create the widget class and extend from the WP_Widget
 */
 class SIS_Tweet_Widget extends WP_Widget {

	private $twitter_title = "My Tweets";
	private $twitter_username = "username";
	private $twitter_postcount = "2";
	private $twitter_follow_text = "Follow Me On Twitter";

	private $twitter_api_key = "xxxxxxxxxx";
	private $twitter_api_secret = "xxxxxxxxxx";
	private $twitter_access_token = "xxx-xxxxxxx";
	private $twitter_access_token_secret = "xxxxxxxxxx";

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
			'sis_tweet_widget',		// Base ID
			'Twitter Widget',		// Name
			array(
				'classname'		=>	'sis_tweet_widget',
				'description'	=>	__('A widget that displays your latest tweets.', 'sistweets')
			)
		);

		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

	} // end constructor

	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	public function register_scripts_and_styles() {
		wp_enqueue_style('sis_tweets_genericons_style',plugins_url( '/css/genericons.css' , __FILE__ ));
		wp_enqueue_style('sis_tweets_main_style',plugins_url( '/css/tweets.css' , __FILE__ ));
	} // end register_scripts_and_styles

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$this->twitter_title = apply_filters('widget_title', $instance['title'] );

		$this->twitter_username = $instance['username'];
		$this->twitter_postcount = $instance['postcount'];
		$this->twitter_follow_text = $instance['tweettext'];

		$this->twitter_api_key = $instance['apikey'];
		$this->twitter_api_secret = $instance['apisecret'];
		$this->twitter_access_token = $instance['accesstoken'];
		$this->twitter_access_token_secret = $instance['accesstokensecret'];

		$transName = 'list_tweets';
	    $cacheTime = 20;

	    if(false === ($twitterData = get_transient($transName) ) ){
	    	require_once 'twitteroauth/twitteroauth.php';
			$twitterConnection = new TwitterOAuth(
								''.$this->twitter_api_key.'',	// Consumer Key
								''.$this->twitter_api_secret.'',   	// Consumer secret
								''.$this->twitter_access_token.'',       // Access token
								''.$this->twitter_access_token_secret.''    	// Access token secret
							);

			$twitterData = $twitterConnection->get(
					'statuses/user_timeline',
					array(
					    'screen_name'     => $this->twitter_username,
					    'count'           => $this->twitter_postcount,
					    'exclude_replies' => false
					)
				);

			if($twitterConnection->http_code != 200)
			{
				$twitterData = get_transient($transName);
			}

	        // Save our new transient.
	        set_transient($transName, $twitterData, 60 * $cacheTime);
	    }

		/* Before widget (defined by themes). */
		echo $before_widget;
		?><div class="twitter_box"><?php

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $this->twitter_title )
			echo $before_title . $this->twitter_title . $after_title;

		/* Display Latest Tweets */
		?>
			<a href="https://twitter.com/<?php echo $this->twitter_username; ?>"
				class="twitter-follow-button"
				data-show-count="true"
				data-lang="en">Follow @<?php echo $this->twitter_username; ?>
			</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

        <?php

        if(!empty($twitterData) || !isset($twitterData['error'])){
            $i=0;
			$hyperlinks = true;
			$encode_utf8 = true;
			$twitter_users = true;
			$update = true;

			echo '<ul class="twitter_update_list">';

		    foreach($twitterData as $item){

		        $msg = $item->text;
		        $permalink = 'http://twitter.com/#!/'. $this->twitter_username .'/status/'. $item->id_str;
		        if($encode_utf8) $msg = utf8_encode($msg);
                    $msg = $this->encode_tweet($msg);
		            $link = $permalink;

		            echo '<li class="twitter-item">';

		        if ($hyperlinks) {    $msg = $this->hyperlinks($msg); }
		        if ($twitter_users)  { $msg = $this->twitter_users($msg); }

		        echo $msg;

		        if($update) {
		            $time = strtotime($item->created_at);

		            if ( ( abs( time() - $time) ) < 86400 )
		                $h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
		            else
		                $h_time = date(__('Y/m/d'), $time);

		            	echo sprintf( __('%s', 'twitter-for-wordpress'),' <span class="twitter-timestamp"><abbr title="' . date(__('Y/m/d H:i:s'), $time) . '">' . $h_time . '</abbr></span>' );
		        }

		        echo '</li>';

		        $i++;
		        if ( $i >= $this->twitter_postcount ) break;
		    }

			echo '</ul>';
        }

        ?></div><?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags to remove HTML (important for text inputs)
		foreach($new_instance as $k => $v){
			$instance[$k] = strip_tags($v);
		}

		return $instance;
	}

	/**
	 * Create the form for the Widget admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => $this->twitter_title,
			'username' => $this->twitter_username,
			'postcount' => $this->twitter_postcount,
			'tweettext' => $this->twitter_follow_text,
			'apikey' => $this->twitter_api_key,
			'apisecret' => $this->twitter_api_secret,
			'accesstoken' => $this->twitter_access_token,
			'accesstokensecret' => $this->twitter_access_token_secret,
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sistweets') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Username e.g. username', 'sistweets') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>

		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of tweets (max 20)', 'sistweets') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" value="<?php echo $instance['postcount']; ?>" />
		</p>

		<!-- Tweettext: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tweettext' ); ?>"><?php _e('Follow Text e.g. Follow me on Twitter', 'sistweets') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tweettext' ); ?>" name="<?php echo $this->get_field_name( 'tweettext' ); ?>" value="<?php echo $instance['tweettext']; ?>" />
		</p>

		<!-- apikey: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'apikey' ); ?>"><?php _e('Api Key', 'sistweets') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'apikey' ); ?>" name="<?php echo $this->get_field_name( 'apikey' ); ?>" value="<?php echo $instance['apikey']; ?>" />
			<small>Don't know your API Key, Api Secret, Access Token and Access Token Secret? <a target="_blank" href="http://sayful1.wordpress.com/2014/06/14/how-to-generate-twitter-api-key-api-secret-access-token-access-token-secret/">Click here to get help.</a></small>
		</p>

		<!-- apisecret: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'apisecret' ); ?>"><?php _e('Api Secret', 'sistweets') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'apisecret' ); ?>" name="<?php echo $this->get_field_name( 'apisecret' ); ?>" value="<?php echo $instance['apisecret']; ?>" />
		</p>

		<!-- accesstoken: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'accesstoken' ); ?>"><?php _e('Access Token', 'sistweets') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'accesstoken' ); ?>" name="<?php echo $this->get_field_name( 'accesstoken' ); ?>" value="<?php echo $instance['accesstoken']; ?>" />
		</p>

		<!-- accesstokensecret: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'accesstokensecret' ); ?>"><?php _e('Access Token Secret', 'sistweets') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'accesstokensecret' ); ?>" name="<?php echo $this->get_field_name( 'accesstokensecret' ); ?>" value="<?php echo $instance['accesstokensecret']; ?>" />
		</p>

	<?php
	}

	/**
	 * Find links and create the hyperlinks
	 */
	private function hyperlinks($text) {
	    $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
	    $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);

	    // match name@address
	    $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
	        //mach #trendingtopics. Props to Michael Voigt
	    $text = preg_replace('/([\.|\,|\:|\Â¡|\Â¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
	    return $text;
	}

	/**
	 * Find twitter usernames and link to them
	 */
	private function twitter_users($text) {
	    $text = preg_replace('/([\.|\,|\:|\Â¡|\Â¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
	    return $text;
	}

    /**
    * Encode single quotes in your tweets
    */
    private function encode_tweet($text) {
        $text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8");
        return $text;
    }

 }
?>