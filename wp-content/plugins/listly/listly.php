<?php
/*
	Plugin Name: List.ly
	Plugin URI:  http://wordpress.org/extend/plugins/listly/
	Description: Plugin to easily integrate List.ly lists to Posts and Pages. It allows publishers to add/edit lists, add items to list and embed lists using shortcode. <a href="mailto:support@list.ly">Contact Support</a>
	Version:     1.6.6
	Author:      Milan Kaneria
	Author URI:  http://brandintellect.in/?Listly
*/


if (!class_exists('Listly'))
{
	class Listly
	{
		function __construct()
		{
			$this->Version = '1.6.6';
			$this->PluginFile = __FILE__;
			$this->PluginName = 'Listly';
			$this->PluginPath = dirname($this->PluginFile) . '/';
			$this->PluginURL = get_bloginfo('wpurl') . '/wp-content/plugins/' . dirname(plugin_basename($this->PluginFile)) . '/';
			$this->SettingsURL = 'options-general.php?page=Listly';
			$this->SettingsName = 'Listly';
			$this->Settings = get_option($this->SettingsName);
			$this->SiteURL = is_ssl() ? 'https://list.ly/api/v2/' : 'http://list.ly/api/v2/';

			$this->SettingsDefaults = array
			(
				'PublisherKey' => '',
				'Layout' => 'full',
				'APIStylesheet' => '',
			);

			$this->PostDefaults = array
			(
				'method' => 'POST',
				'timeout' => 5,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'decompress' => true,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded', 'Accept-Encoding' => 'gzip, deflate'),
				'body' => array(),
				'cookies' => array(),
			);


			register_activation_hook($this->PluginFile, array($this, 'Activate'));

			add_filter('plugin_action_links_'.plugin_basename($this->PluginFile), array($this, 'ActionLinks'));
			add_action('init', array($this, 'Init'));
			add_action('admin_menu', array($this, 'AdminMenu'));
			add_action('admin_print_scripts', array($this, 'AdminPrintScripts'));
			add_action('admin_print_styles', array($this, 'AdminPrintStyles'));
			add_action('wp_enqueue_scripts', array($this, 'WPEnqueueScripts'));
			add_action('wp_ajax_ListlyAJAXPublisherAuth', array($this, 'ListlyAJAXPublisherAuth'));
			add_shortcode('listly', array($this, 'ShortCode'));

			if ($this->Settings['PublisherKey'] == '')
			{
				add_action('admin_notices', create_function('', "print '<div class=\'error\'><p><strong>$this->PluginName:</strong> Please enter Publisher Key on <a href=\'$this->SettingsURL\'>Settings</a> page.</p></div>';"));
			}
		}


		function Activate()
		{
			if (is_array($this->Settings))
			{
				$Settings = array_merge($this->SettingsDefaults, $this->Settings);
				$Settings = array_intersect_key($Settings, $this->SettingsDefaults);

				update_option($this->SettingsName, $Settings);
			}
			else
			{
				add_option($this->SettingsName, $this->SettingsDefaults);
			}
		}


		function ActionLinks($Links)
		{
			$Link = "<a href='$this->SettingsURL'>Settings</a>";

			array_push($Links, $Link);

			return $Links;
		}


		function Init()
		{
			if (isset($_GET['ListlyDeleteCache']))
			{
				global $wpdb;

				$TransientId = ($_GET['ListlyDeleteCache'] != '') ? $_GET['ListlyDeleteCache'] : 'Listly-';

				$Transients = $wpdb->get_col( $wpdb->prepare("SELECT DISTINCT option_name FROM $wpdb->options WHERE option_name LIKE %s", array("_transient_$TransientId%")) );

				if ($Transients)
				{
					foreach ($Transients as $Transient)
					{
						delete_transient(str_ireplace('_transient_', '', $Transient));
					}

					print 'Listly: Cached data deleted.';
				}
				else
				{
					print 'Listly: No cached data found.';
				}

				exit;
			}
		}


		function WPEnqueueScripts()
		{
			global $post;

			if ( !is_singular() || ( is_singular() && has_shortcode($post->post_content, 'listly') ) )
			{
				if ($this->Settings['APIStylesheet'])
				{
					wp_enqueue_style('listly-list', $this->Settings['APIStylesheet'], false, $this->Version, 'screen');
				}

				wp_enqueue_script('jquery');
			}
		}


		function AdminPrintScripts()
		{
			wp_enqueue_script('jquery');
			wp_enqueue_script('listly-script', $this->PluginURL.'script.js', false, $this->Version, false);
			wp_localize_script('listly-script', 'Listly', array('PluginURL' => $this->PluginURL, 'SiteURL' => $this->SiteURL, 'Key' => $this->Settings['PublisherKey'], 'Nounce' => wp_create_nonce('ListlyNounce')));
		}

		function AdminPrintStyles()
		{
			wp_enqueue_style('listly-style', $this->PluginURL.'style.css', false, $this->Version, 'screen');
		}


		function AdminMenu()
		{
			$ListlyHook = add_submenu_page('options-general.php', 'Listly Settings', 'Listly', 'manage_options', 'Listly', array($this, 'Admin'));

			add_action("load-$ListlyHook", array($this, 'AdminMenuLoad'));

			add_meta_box('ListlyMetaBox', 'Listly', array($this, 'MetaBox'), 'page', 'side', 'default');
			add_meta_box('ListlyMetaBox', 'Listly', array($this, 'MetaBox'), 'post', 'side', 'core');

			$PostTypes = get_post_types(array('_builtin' => false));

			if ($PostTypes)
			{
				foreach ($PostTypes as $PostType)
				{
					add_meta_box('ListlyMetaBox', 'Listly', array($this, 'MetaBox'), $PostType, 'side', 'default');
				}
			}
		}


		function AdminMenuLoad()
		{
			add_filter('contextual_help', array($this, 'AdminContextualHelp'), 10, 3);
		}


		function AdminContextualHelp($Help, $ScreenId, $Screen)
		{
			return '<p><a href="mailto:support@list.ly">Contact Support</a></p> <p><a target="_blank" href="http://list.ly/publishers/landing">Request Publisher Key</a></p>';
		}


		function Admin()
		{
			if (!current_user_can('manage_options'))
			{
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}

			if (isset($_POST['action']) && !wp_verify_nonce($_POST['nonce'], $this->SettingsName))
			{
				wp_die(__('Security check failed! Settings not saved.'));
			}

			global $wpdb;

			if (isset($_POST['action']) && $_POST['action'] == 'Save Settings')
			{
				foreach ($_POST as $Key => $Value)
				{
					if (array_key_exists($Key, $this->SettingsDefaults))
					{
						if (is_array($Value))
						{
							array_walk_recursive($Value, array($this, 'TrimByReference'));
						}
						else
						{
							$Value = trim($Value);
						}

						$this->Settings[$Key] = $Value;
					}
				}

				if (update_option($this->SettingsName, $this->Settings))
				{
					print '<div class="updated"><p><strong>Settings saved.</strong></p></div>';
				}
			}

			if (isset($_POST['action']) && $_POST['action'] == 'Delete Cache')
			{
				$Transients = $wpdb->get_col("SELECT DISTINCT option_name FROM $wpdb->options WHERE option_name LIKE '_transient_Listly-%'");

				if ($Transients)
				{
					foreach ($Transients as $Transient)
					{
						delete_transient(str_ireplace('_transient_', '', $Transient));
					}

					print '<div class="updated"><p><strong>All cached data deleted.</strong></p></div>';
				}
				else
				{
					print '<div class="error"><p><strong>No cached data found.</strong></p></div>';
				}
			}

		?>

			<style type="text/css">

				input.large-text
				{
					width: 98%;
				}

			</style>

			<div class="wrap">

				<h2>Listly Settings</h2>

				<form method="post" action="">

					<h3>Common Settings</h3>

					<table class="form-table listly-table">

						<tr valign="top">
							<th scope="row">
								Publisher Key
								<br /> <a target="_blank" href="http://list.ly/publishers/landing">Request Publisher Key</a>
							</th>
							<td>
								<input name="PublisherKey" type="text" value="<?php print $this->Settings['PublisherKey']; ?>" class="large-text" />
								<a id="ListlyAdminAuthStatus" href="#">Check Key Status</a> : <span></span>
							</td>
						</tr>

					</table>

					<h3>Default ShortCode Settings</h3>

					<table class="form-table listly-table">

						<tr valign="top">
							<th scope="row">Layout</th>
							<td>
								<select name="Layout">
									<option value="full" <?php $this->CheckSelected($this->Settings['Layout'], 'full'); ?>>Full</option>
									<option value="short" <?php $this->CheckSelected($this->Settings['Layout'], 'short'); ?>>Short</option>
									<option value="gallery" <?php $this->CheckSelected($this->Settings['Layout'], 'gallery'); ?>>Gallery</option>
								</select>
							</td>
						</tr>

					</table>

					<h3>Cache Settings</h3>

					<table class="form-table listly-table">

						<tr valign="top">
							<th scope="row">Delete Cache</th>
							<td>
								<input name="action" type="submit" value="Delete Cache" class="button-secondary" />
							</td>
						</tr>

						<?php if (isset($_GET['debug'])) : ?>
							<tr valign="top">
								<th scope="row">Cached Items</th>
								<td>
									<?php
										$Transients = $wpdb->get_col("SELECT DISTINCT option_name FROM $wpdb->options WHERE option_name LIKE '_transient_Listly-%'");

										if ($Transients)
										{
											foreach ($Transients as $Transient)
											{
												$TransientId = str_ireplace('_transient_', '', $Transient);
												$Timeout = date(get_option('date_format').' '.get_option('time_format'), get_option("_transient_timeout_$TransientId"));

												print "<p>$TransientId ($Timeout)</p>";
											}
										}
										else
										{
											print 'No cached data found.';
										}
									?>
								</td>
							</tr>
						<?php endif; ?>

					</table>

					<input name="nonce" type="hidden" value="<?php print wp_create_nonce($this->SettingsName); ?>" />

					<div class="submit"><input name="action" type="submit" value="Save Settings" class="button-primary" /></div>

				</form>

			</div>

		<?php

		}


		function ListlyAJAXPublisherAuth()
		{
			define('DONOTCACHEPAGE', true);

			if (!wp_verify_nonce($_POST['nounce'], 'ListlyNounce'))
			{
				print '<span class="error">Authorisation failed.</span>';
				exit;
			}

			if (isset($_POST['action'], $_POST['Key']))
			{
				if ($_POST['Key'] == '')
				{
					print '<span class="error">Please enter Publisher Key.</span>';
				}
				else
				{
					$PostParms = array_merge($this->PostDefaults, array('body' => http_build_query(array('key' => $_POST['Key']))));
					$Response = wp_remote_post($this->SiteURL.'publisher/auth.json', $PostParms);

					if (is_wp_error($Response) || !isset($Response['body']) || $Response['body'] == '')
					{
						print '<span class="error">No connectivity or Listly service not available. Try later.</span>';
					}
					else
					{
						$ResponseJson = json_decode($Response['body'], true);

						if ($ResponseJson['status'] == 'ok')
						{
							print '<span class="info">'.$ResponseJson['message'].'</span>';
						}
						else
						{
							print '<span class="error">'.$ResponseJson['message'].'</span>';
						}
					}
				}
			}

			exit;
		}


		function MetaBox()
		{
			if ($this->Settings['PublisherKey'] == '')
			{
				print "<p>Please enter Publisher Key on <a href='$this->SettingsURL'>Settings</a> page.</p>";
			}
			else
			{
				$UserURL = '#';

				$PostParms = array_merge($this->PostDefaults, array('body' => http_build_query(array('key' => $this->Settings['PublisherKey']))));

				if (false === ($Response = get_transient('Listly-Auth')))
				{
					$Response = wp_remote_post($this->SiteURL.'publisher/auth.json', $PostParms);

					if (!is_wp_error($Response) && isset($Response['body']) && $Response['body'] != '')
					{
						set_transient('Listly-Auth', $Response, 86400);
					}
				}

				if (!is_wp_error($Response) && isset($Response['body']) && $Response['body'] != '')
				{
					$ResponseJson = json_decode($Response['body'], true);

					if ($ResponseJson['status'] == 'ok')
					{
						$UserURL = $ResponseJson['user_url'].'?trigger=newlist';
					}
				}

			?>

				<div style="text-align: right;"><a class="button" target="_blank" href="<?php print $UserURL; ?>">Make New List</a></div>

				<p>
					<div class="ListlyAdminListSearchWrap">
						<input type="text" name="ListlyAdminListSearch" placeholder="Type at least 4 characters to search" autocomplete="off" style="width: 100%; margin: 0 0 5px;" />
						<a class="ListlyAdminListSearchClear" href="#">X</a>
					</div>
					<label><input type="radio" name="ListlyAdminListSearchType" value="publisher" checked="checked" /> <small>Just My Lists</small></label> &nbsp; <label><input type="radio" name="ListlyAdminListSearchType" value="all" /> <small>Search All Lists</small></label>
				</p>

				<div id="ListlyAdminYourList"></div>

			<?php

			}
		}


		function ShortCode($Attributes, $Content = null, $Code = '')
		{
			global $wp_version;

			$ListId = $Attributes['id'];
			$Layout = (isset($Attributes['layout']) && $Attributes['layout']) ? $Attributes['layout'] : $this->Settings['Layout'];
			$Title = (isset($Attributes['title']) && $Attributes['title']) ? sanitize_key('-'.$Attributes['title']) : '';
			$TransientId = 'Listly-'.md5(http_build_query($Attributes));

			if (empty($ListId))
			{
				return 'Listly: Required parameter List ID is missing.';
			}

			if (isset($_GET['ListlyDebug']))
			{
				require_once ABSPATH . 'wp-admin/includes/plugin.php';

				$Plugins = get_plugins();
				$PluginsActive = array();

				foreach ($Plugins as $PluginFile => $PluginData)
				{
					if ( is_plugin_active($PluginFile) || (is_multisite() && is_plugin_active_for_network($PluginFile)) )
					{
						$PluginsActive[$PluginFile] = array('Name' => $PluginData['Name'], 'PluginURI' => $PluginData['PluginURI'], 'Version' => $PluginData['Version'], 'Network' => $PluginData['Network']); 
					}
				}

				$PostParms = array_merge($this->PostDefaults, array('body' => http_build_query($PluginsActive)));

				wp_remote_post($this->SiteURL.'wpdebug.json', $PostParms);
			}

			$this->DebugConsole("Listly -> $this->Version", false, $ListId);
			$this->DebugConsole("WP -> $wp_version", false, $ListId);
			$this->DebugConsole('PHP -> '.phpversion(), false, $ListId);
			$this->DebugConsole("Transient -> $TransientId", false, $ListId);


			$PostParmsBody = http_build_query( array_merge( $Attributes , array( 'list' => $ListId, 'layout' => $Layout, 'key' => $this->Settings['PublisherKey'], 'user-agent' => $_SERVER['HTTP_USER_AGENT'], 'clear_wp_cache' => site_url("/?ListlyDeleteCache=$TransientId") ) ) );
			$PostParms = array_merge($this->PostDefaults, array('body' => $PostParmsBody));

			if (false === ($Response = get_transient($TransientId)))
			{
				$Response = wp_remote_post($this->SiteURL.'list/embed.json', $PostParms);

				//$this->DebugConsole(json_encode($PostParms), true); // Exposes Publisher Key
				$this->DebugConsole('Create Cache - API Response -> ', false, $ListId);
				$this->DebugConsole(json_encode($Response), true);

				if (!is_wp_error($Response) && isset($Response['body']) && $Response['body'] != '')
				{
					$ResponseJson = json_decode($Response['body'], true);

					if ($ResponseJson['status'] == 'ok')
					{
						set_transient($TransientId, $Response, 86400);
					}
				}
			}

			if (is_wp_error($Response) || !isset($Response['body']) || $Response['body'] == '')
			{
				return "<p><a href=\"http://list.ly/$ListId\">View List on List.ly</a></p>";
			}
			else
			{
				if (false !== ($Timeout = get_option("_transient_timeout_$TransientId")) && $Timeout < time() + 82800)
				{
					$ResponseFresh = wp_remote_post($this->SiteURL.'list/embed.json', $PostParms);

					//$this->DebugConsole(json_encode($PostParms), true); // Exposes Publisher Key
					$this->DebugConsole('Update Cache - API Response -> ', false, $ListId);
					$this->DebugConsole(json_encode($ResponseFresh), true);

					if (!is_wp_error($ResponseFresh) && isset($ResponseFresh['body']) && $ResponseFresh['body'] != '')
					{
						$ResponseFreshJson = json_decode($ResponseFresh['body'], true);

						if ($ResponseFreshJson['status'] == 'ok')
						{
							delete_transient($TransientId);
							set_transient($TransientId, $ResponseFresh, 86400);
							$Response = $ResponseFresh;
						}
					}
				}

				$this->DebugConsole('Cached Data -> ', false, $ListId);
				$this->DebugConsole(json_encode($Response), true);

				$ResponseJson = json_decode($Response['body'], true);

				if ($ResponseJson['status'] == 'ok')
				{
					if (!$this->Settings['APIStylesheet'] || $this->Settings['APIStylesheet'] != $ResponseJson['styles'][0])
					{
						$this->Settings['APIStylesheet'] = $ResponseJson['styles'][0];
						update_option($this->SettingsName, $this->Settings);
					}

					return $ResponseJson['list-dom'];
				}
				else
				{
					$this->DebugConsole('API Error -> '.$ResponseJson['message'], false, $ListId);
					return "<p><a href=\"http://list.ly/$ListId\">View List on List.ly</a></p>";
				}
			}
		}


		function DebugConsole($Message = '', $Array = false, $ListId = '')
		{
			if (isset($_GET['ListlyDebug']) && $Message)
			{
				if ($Array)
				{
					print "<script type='text/javascript'> console.log($Message); </script>";
				}
				else
				{
					print "<script type='text/javascript'> console.log('Listly $ListId: $Message'); </script>";
				}
			}
		}


		function CheckSelected($SavedValue, $CurrentValue, $Type = 'select')
		{
			if ( (is_array($SavedValue) && in_array($CurrentValue, $SavedValue)) || ($SavedValue == $CurrentValue) )
			{
				switch ($Type)
				{
					case 'select':
						print 'selected="selected"';
						break;
					case 'radio':
					case 'checkbox':
						print 'checked="checked"';
						break;
				}
			}
		}


		function TrimByReference(&$String)
		{
			$String = trim($String);
		}
	}

	$Listly = new Listly();
}


?>