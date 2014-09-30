(function($) {
"use strict";

	tinymce.PluginManager.add('zillaShortcodes', function(ed, url) {


    ed.addCommand("zillaPopup", function ( a, params )
    {
    	var popup = params.identifier;
				
		tb_show("Insert Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
    });


    ed.addButton('zilla_button', {
        text: '[ 9 ]',
        type:'menubutton',
        icon: false,
     
     menu:[

    
	{
		text: "Columns",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Columns',
							identifier: 'columns'
						})
    	}

    },
    {
    	text: "Padding Box",
    	onclick:function(){
    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
						title: 'Padding Box',
						identifier: 'padding_box'
					})
    	}


	},
	{
		text: "Title Bar",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Title Bar',
							identifier: 'title_bar'
						})
    	}

    }
    ,
	{
		text: "Heading",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Heading',
							identifier: 'heading'
						})
    	}

    }
    ,
	{
		text: "Side Bars",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Custom SideBars',
							identifier: 'nzs_sidebars'
						})
    	}

    }
    ,
	{
		text: "Portfolio",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Portfolio',
							identifier: 'nzs_portfolio'
						})
    	}

    },
	{
		text: "Recent Works",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Recent Works',
							identifier: 'nzs_works'
						})
    	}

    },

	{
		text: "Social Links",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[social_links]' )
    	}

    },

	{
		text: "Blog",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[blog]' )
    	}

    },


    {
		text: "Pricing Table",
		menu:[{
			text:"Pricing Table Holder",
			onclick:function(){
	    		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[price_table] Put Plans In Here [/price_table]' )
	    	}
		},
		{
			text: "Price Plan",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Price Plan',
							identifier: 'nzs_price'
						})
    		}
		}


		]
	    	
    	

    },
    {
		text: "Font Awesome",
		menu:[{
			text: "Font Icon",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Font Icon',
							identifier: 'font_icons'
						})
    		}
		},
		{
			text: "Font Icon List",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Font Icon List',
							identifier: 'icon_list_icon'
						})
    		}
		}


		]
	    	
    	

    },

	{
		text: "Clear Floats",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[clear]' )
    	}

    }
    ,
	{
		text: "Team",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Team Shortcode',
							identifier: 'nzs_team'
						})
    	}

    },
	{
		text: "Member Name",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Member Name',
							identifier: 'member_bar'
						})
    	}

    },
	{
		text: "Contact Form",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Contact Form',
							identifier: 'nzs_contact'
						})
    	}

    },
	{
		text: "Contact Info",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Contact Info',
							identifier: 'contact_info'
						})
    	}

    },
	{
		text: "Video",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Video',
							identifier: 'video_box'
						})
    	}

    },
	{
		text: "Light Box",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Title Bar',
							identifier: 'light_box'
						})
    	}

    },
	{
		text: "Standard UL",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Standard UL',
							identifier: 'standard_list_icon'
						})
    	}

    },
	{
		text: "Price Plan",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Price Plan',
							identifier: 'nzs_price'
						})
    	}

    },
	{
		text: "Slider",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Slider',
							identifier: 'nzs_slider'
						})
    	}

    },
	{
		text: "Service",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Service',
							identifier: 'service'
						})
    	}

    },
	{
		text: "Excerpt Link",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Excerpt Link',
							identifier: 'excerpt_link'
						})
    	}

    },
	{
		text: "Buttons",
	    	onclick:function(){
	    		tinyMCE.activeEditor.execCommand("zillaPopup", false, {
							title: 'Buttons',
							identifier: 'button'
						})
    	}

    }



     ]



    });

});

})(jQuery);