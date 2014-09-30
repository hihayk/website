(function ()
{
	// create zillaShortcodes plugin
	tinymce.create("tinymce.plugins.zillaShortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("zillaPopup", function ( a, params )
			{
				var popup = params.identifier;
				
				// load thickbox
				tb_show("Insert Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "zilla_button" )
			{	
				var a = this;
				
				var btn = e.createSplitButton('zilla_button', {
                    title: "Insert Shortcode",
					image: ZillaShortcodes.plugin_folder +"/tinymce/images/icon.png",
					icons: false
                });

                btn.onRenderMenu.add(function (c, b)
				{	
					a.addWithPopup( b, "Columns", "columns" );
					a.addWithPopup( b, "Title bar", "title_bar" );
					a.addWithPopup( b, "Heading", "heading" );

					a.addWithPopup( b, "Sidebars", "nzs_sidebars" );
					a.addImmediate( b, "Blog", "[blog]" );
					a.addWithPopup( b, "Portfolio", "nzs_portfolio" );
					a.addWithPopup( b, "Recent Works", "nzs_works" );
					a.addWithPopup( b, "Team", "nzs_team" );
					a.addWithPopup( b, "Member Name", "member_bar" );
					a.addWithPopup( b, "Contact Form", "nzs_contact" );
					a.addImmediate( b, "Social Links", "[social_links]" );
					a.addWithPopup( b, "Contact Info", "contact_info" );
					a.addWithPopup( b, "Padding Box", "padding_box" );
					a.addWithPopup( b, "Video", "video_box" );
					a.addWithPopup( b, "Light Box", "light_box" );
					a.addWithPopup( b, "Standard UL", "standard_list_icon");
					c=b.addMenu({title: "Font Awesome"});
					a.addWithPopup( c, "Font Icon", "font_icons" );
					a.addWithPopup( c, "Font Icon List", "icon_list_icon" );
					

					c=b.addMenu({title: "Pricing Table"});
					a.addImmediate( c, "Pricing Table Holder", "[price_table] Put Plans In Here [/price_table]");
					a.addWithPopup( c, "Price Plan", "nzs_price" );
					a.addWithPopup( b, "Slider", "nzs_slider" );
					a.addWithPopup( b, "Service", "service" );				
					a.addWithPopup( b, "Buttons", "button" );
					a.addImmediate( b, "Clear Floats", "[clear]" );
					a.addWithPopup( b, "Excerpt Link", "excerpt_link" );

				});
                
                return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("zillaPopup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},
		getInfo: function () {
			return {
				longname: 'Zilla Shortcodes',
				author: 'Orman Clark',
				authorurl: 'http://themeforest.net/user/ormanclark/',
				infourl: 'http://wiki.moxiecode.com/',
				version: "1.0"
			}
		}
	});
	
	// add zillaShortcodes plugin
	tinymce.PluginManager.add("zillaShortcodes", tinymce.plugins.zillaShortcodes);
})();