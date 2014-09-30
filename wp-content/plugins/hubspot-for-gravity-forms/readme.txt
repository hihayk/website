=== Gravity Forms HubSpot Add-on ===
Contributors: dzappone
Donate link: http://www.23systems.net/plugins/donate/
Tags: lead, lead generation, gravity forms, forms, gravity, form, crm, gravity form, hubspot, hubspot plugin, form, forms, gravity, gravity form, gravity forms, secure form, simplemodal contact form, wp contact form, widget, hub spot, customer, contact, contacts
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 1.0-beta

<a href="http://www.gravityforms.com/" rel="nofollow">Gravity Forms</a> HubSpot Add-On uses the <a href="http://www.hubspot.com" rel="nofollow">HubSpot</a> Lead API to allow you to send your Gravity Forms based landing pages to send lead information to HubSpot.

== Description ==

This plugin requires the <a href="http://www.gravityforms.com/" rel="nofollow">Gravity Forms plugin</a>. <strong>Don't use Gravity Forms? <a href="http://www.gravityforms.com/" rel="nofollow">Get the plugin</a></strong>, then start using this great plugin!

= Requirements =

Server

* WordPress 2.8+
* PHP 5+ (Recommended)
* HubSpot Account

= Integrate Gravity Forms with HubSpot =

Add one setting, check a box when configuring your forms, and all your form entries will be added to HubSpot from now on. <strong>Integrating with HubSpot has never been so simple.</strong>

In order for the lead data to go from Gravity Forms to HubSpot you must also configure the Lead API for the form on the HubSpot side.

<ol>
<li>Log in to HubSpot</li>
<li>Go to Setting --> Lead API</li>
<li>Add New Form</li>
<li>Give the form the exact same name as the Gravity Form</li>
<li>Add an email address for notification</li>
<li>Click submit</li>
<li>You're done</li>
</ol>

= Gravity Forms & HubSpot: A Powerful Combination =

This free HubSpot add-on for Gravity Forms feeds leads into HubSpot automatically, making lead generation with Gravity Forms simple. The setup process takes less than three minutes, and your forms will be linked with HubSpot.

= Custom Field support =

<a href="http://wordpress.org/extend/plugins/gravity-forms-hubspot/faq/">Read the FAQ</a> for information on how to integrate with Custom Fields.

== Screenshots ==

1. HubSpot for Gravity Forms settings page
2. HubSpot integration indicator in form listing
3. It's easy to integrate Gravity Forms with HubSpot: check a box in the "Advanced" tab of a form's Form Settings

== Installation ==

<ol>
<li>Upload plugin files to your plugins folder, or install using WordPress' built-in Add New Plugin installer</li>
<li>Activate the plugin</li>
<li>Go to the plugin settings page (under Forms > HubSpot)</li>
<li>Enter the information requested by the plugin.</li>
<li>Click Save Settings.</li>
<li>If the settings are correct, it will say so.</li>
<li>Follow on-screen instructions for integrating with HubSpot.</li>
</ol>

== Frequently Asked Questions ==

= How do I set a custom Lead Source? =

This feature uses `gf_hubspot_lead_source` is the filter.

Add the following to your theme's `functions.php` file. Modify as you see fit:

`
add_filter('gf_hubspot_lead_source', 'create_lead_source', 1, 3);

function create_lead_source($lead_source, $form_meta, $data) {
	// $lead_source - What was about to be used (normally Gravity Forms Form Title)
	// $form_meta - Gravity Forms form details
	// $data - The data to be passed to HubSpot via Lead API

	return $lead_source; // Return something else if you want to.
}
`

= Can I use HubSpot Custom Fields? =

When you are trying to map a custom field, you need to set either the "Admin Label" for the input (in the Advanced tab of each field in the  Gravity Forms form editor) or the Parameter Name (in Advanced tab, visible after checking "Allow field to be populated dynamically") to be the field name of the custom field as shown in HubSpot. For example, a Custom Field with a Field Label "Web Source" could have an Lead API Name of "WebSource" or "SfCampaignId" or "HS_WS_Forms" or something else entirely.

You can find your custom fields in the HubSpot Form Manager.

For more information on custom fields, <a href="http://developers.hubspot.com/docs/methods/leads/create_lead" rel="nofollow">sread this HubSpot.com Help Article</a>

= Does this plugin require Gravity Forms? =

Yes, this plugin extends the amazing <a href="http://www.gravityforms.com/" rel="nofollow">Gravity Forms plugin</a>. Don't use Gravity Forms? <a href="http://www.gravityforms.com/" rel="nofollow">Buy the plugin</a> and start using this add-on plugin!

= What's the license for this plugin? =

This plugin is released under the GPL compatible <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>.

= What are my support options =

At present there is no specified support.  Once a non-beta version is released support options will be provided.

== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==

None at this time - initial release
