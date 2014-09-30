<?php

if ( defined('WPB_VC_VERSION') ) {
	vc_map(
		array(
			"name" => __("Ultimate Social", 'ultimate-social-deux') . ' - ' . __("Fan Count", 'ultimate-social-deux'),
			"base" => "ultimatesocial_fan_count",
			"icon" => 'ultimate-social-deux',
			"category" => __('Social', 'ultimate-social-deux'),
			"params" => array(
				array(
					"type" => 'textfield',
					"heading" => __("Networks", "ultimate-social-deux"),
					"description" => __("Comma seperate a list of networks you would like to display. Setup is done from the Ultimate Social Deux settings menu. Available networks is:", "ultimate-social-deux") . ' ' . 'facebook, twitter, google, youtube, vimeo, dribbble, envato, github, soundcloud, instagram, feedpress, pinterest, mailchimp, flickr, members, posts, comments',
					"param_name" => "networks",
				),
				array(
					"type" => "dropdown",
					"heading" => __("Rows", "ultimate-social-deux"),
					"param_name" => "rows",
					"value" => array(
						'1' => "1",
						'2' => "2",
						'3' => "3",
						'4' => "4",
						'5' => "5"
					)
				),
			)
		)
	);
	vc_map(
		array(
			"name" => __("Ultimate Social", 'ultimate-social-deux'),
			"base" => "ultimatesocial_false",
			"icon" => 'ultimate-social-deux',
			"category" => __('Social', 'ultimate-social-deux'),
			"params" => array(
				array(
					"type" => 'textfield',
					"heading" => __("URL to share", "ultimate-social-deux"),
					"param_name" => "url",
				),
				array(
					"type" => "textfield",
					"heading" => __("Share Text:", 'ultimate-social-deux'),
					"param_name" => "share_text",
				),
				array(
					"type" => 'textfield',
					"heading" => __("Networks", "ultimate-social-deux"),
					"description" => __("Comma seperate a list of networks you would like to display. Available networks is:", "ultimate-social-deux") . ' ' . 'total, facebook, facebook_native, twitter, google, google_native, pinterest, linkedin, stumble, delicious, reddit, buffer, vkontakte, vkontakte_native, mail, comments, love, pocket, tumblr, print, flipboard',
					"param_name" => "networks",
				),
				array(
					"type" => 'checkbox',
					"heading" => __("Counts?", "ultimate-social-deux"),
					"param_name" => "count",
					"value" => array(
						__("No", "ultimate-social-deux") => "false"
					)
				),
				array(
					"type" => 'textfield',
					"heading" => __("Custom Class", "ultimate-social-deux"),
					"param_name" => "custom_class",
				),
				array(
					"type" => "dropdown",
					"heading" => __("Align", "ultimate-social-deux"),
					"param_name" => "align",
					"value" => array(
						__("Center", "ultimate-social-deux") => "center",
						__("Left", "ultimate-social-deux") => "left",
						__("Right", "ultimate-social-deux") => "right"
					)
				),
			)
		)
	);
}