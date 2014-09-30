;(function ( $, window, document, undefined ) {

	/* Defaults
	================================================== */
	var pluginName = 'ultimate_social_deux',
	defaults = {
		className: 'sharrre',
		share: {
			facebook: false,
			twitter: false,
			googlePlus: false,
			pinterest: false,
			linkedin: false,
			stumbleupon: false,
			delicious: false,
			buffer: false,
			reddit: false,
			vkontakte: false,
			comments: false
		},
		shareTotal: 0,
		template: '',
		title: '',
		url: document.location.href,
		defaults: 0,
		text: document.title,
		urlCurl: us_script.sharrre_url,
		count: {},
		total: 0,
		shorterTotal: true,
		enableHover: true,
		enableCounter: true,
		hover: function(){},
		hide: function(){},
		click: function(){},
		render: function(){},
		buttons: {
			googlePlus : {
				url: '',
				urlCount: false,
				size: 'medium',
				lang: 'en-US',
				annotation: ''
			},
			facebook: {
				url: '',
				urlCount: false,
				action: 'like',
				layout: 'button_count',
				width: '',
				send: 'false',
				faces: 'false',
				colorscheme: '',
				font: '',
				lang: 'en_US'
			},
			twitter: {
				url: '',
				urlCount: false,
				count: 'horizontal',
				hashtags: '',
				via: '',
				related: '',
				lang: 'en'
			},
			delicious: {
				url: '',
				urlCount: false,
				size: 'medium'
			},
			stumbleupon: {
				url: '',
				urlCount: false,
				layout: '1'
			},
			reddit: {
				url: '',
				urlCount: false
			},
			vkontakte: {
				url: '',
				urlCount: false,
				media: '',
				description: ''
			},
			linkedin: {
				url: '',
				urlCount: false,
				counter: ''
			},
			pinterest: {
				url: '',
				media: '',
				description: '',
				urlCount: false,
				layout: 'horizontal'
			},
			buffer: {
				url		 : '',
				media	   : '',
				description : '',
				layout	  : 'horizontal',
				urlCount: false
			},
			comments: {
				urlCount: false
			},
			love: {
				urlCount: false
			},
			pocket: {
				url: '',
				description: ''
			},
			tumblr: {
				url: '',
				description: ''
			},
			printfriendly: {
				url: '',
				description: ''
			},
			flipboard: {
				url: '',
				description: ''
			},
		}
	},
	/* Json URL to get count number
	================================================== */
	urlJson = {
		googlePlus: "",
		reddit: "",
		stumbleupon: "",
		pinterest: "",
		facebook: "//graph.facebook.com/fql?q=SELECT%20url,%20normalized_url,%20share_count,%20like_count,%20comment_count,%20total_count,commentsbox_count,%20comments_fbid,%20click_count%20FROM%20link_stat%20WHERE%20url=%27{url}%27&callback=?",
		twitter: "//cdn.api.twitter.com/1/urls/count.json?url={url}&callback=?",
		delicious: "http://feeds.delicious.com/v2/json/urlinfo/data?url={url}&callback=?",
		linkedin: "//www.linkedin.com/countserv/count/share?format=jsonp&url={url}&callback=?",
		vkontakte: "",
		buffer: "https://api.bufferapp.com/1/links/shares.json?url={url}&callback=?",
		comments: "",
		love: ""
	},

	/* Popup for each social network
	================================================== */
	popup = {
		googlePlus: function(opt){
			PopupCenter("https://plus.google.com/share?hl="+opt.buttons.googlePlus.lang+"&url="+encodeURIComponent((opt.buttons.googlePlus.url !== '' ? opt.buttons.googlePlus.url : opt.url)), 'googlePlus', us_script.googleplus_width, us_script.googleplus_height );
		},
		facebook: function(opt){
			PopupCenter("http://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent((opt.buttons.facebook.url !== '' ? opt.buttons.facebook.url : opt.url))+"&t="+opt.text+"", 'facebook', us_script.facebook_width, us_script.facebook_height );
		},
		twitter: function(opt){
			get_short_url(opt.url, function( short_url ) {
				PopupCenter("https://twitter.com/intent/tweet?text="+encodeURIComponent(opt.text)+"&url="+encodeURIComponent(short_url)+(opt.buttons.twitter.via !== '' ? '&via='+opt.buttons.twitter.via : ''), 'twitter', us_script.twitter_width, us_script.twitter_height );
			});
		},
		delicious: function(opt){
			PopupCenter('http://www.delicious.com/save?v=5&noui&jump=close&url='+encodeURIComponent((opt.buttons.delicious.url !== '' ? opt.buttons.delicious.url : opt.url))+'&title='+opt.text, 'delicious', us_script.delicious_width, us_script.delicious_height );
		},
		stumbleupon: function(opt){
			PopupCenter('http://www.stumbleupon.com/badge/?url='+encodeURIComponent((opt.buttons.stumbleupon.url !== '' ? opt.buttons.stumbleupon.url : opt.url)), 'stumble', us_script.stumble_width, us_script.stumble_height );
		},
		linkedin: function(opt){
			PopupCenter('https://www.linkedin.com/cws/share?url='+encodeURIComponent((opt.buttons.linkedin.url !== '' ? opt.buttons.linkedin.url : opt.url))+'&token=&isFramed=true', 'linkedin', us_script.linkedin_width, us_script.linkedin_height );
		},
		pinterest: function(opt){
			PopupCenter(us_script.home_url + '?pinterestshare=1&url='+encodeURIComponent((opt.buttons.pinterest.url !== '' ? opt.buttons.pinterest.url : opt.url))+'&desc='+encodeURIComponent(opt.text), 'pinterest', us_script.pinterest_width, us_script.pinterest_height );
		},
		buffer: function(opt){
			get_short_url(opt.url, function( short_url ) {
				PopupCenter('http://bufferapp.com/add?url='+encodeURIComponent(short_url)+'&text='+encodeURIComponent(opt.text)+'&via='+us_script.tweet_via+'&picture='+encodeURIComponent(opt.buttons.buffer.media)+'&count='+opt.buttons.buffer.layout+'&source=button', 'buffer', us_script.buffer_width, us_script.buffer_height );
			});
		},
		reddit: function(opt){
			PopupCenter('http://reddit.com/submit?url='+encodeURIComponent((opt.buttons.reddit.url !== '' ? opt.buttons.reddit.url : opt.url))+'&title='+encodeURIComponent(opt.text), 'reddit', us_script.reddit_width, us_script.reddit_height );
		},
		vkontakte: function(opt){
			PopupCenter('http://vkontakte.ru/share.php?url='+encodeURIComponent((opt.buttons.vkontakte.url !== '' ? opt.buttons.vkontakte.url : opt.url))+'&title='+encodeURIComponent(opt.buttons.vkontakte.description)+'&image='+encodeURIComponent(opt.buttons.vkontakte.media), 'vkontakte', us_script.vkontakte_width, us_script.vkontakte_height );
		},
		printfriendly: function(opt){
			PopupCenter('http://www.printfriendly.com/print/?url='+encodeURIComponent((opt.buttons.printfriendly.url !== '' ? opt.buttons.printfriendly.url : opt.url)), 'printfriendly', us_script.printfriendly_width, us_script.printfriendly_height );
		},
		pocket: function(opt){
			PopupCenter('https://getpocket.com/edit.php?url='+encodeURIComponent((opt.buttons.pocket.url !== '' ? opt.buttons.pocket.url : opt.url)), 'pocket', us_script.pocket_width, us_script.pocket_height );
		},
		tumblr: function(opt){
			PopupCenter('http://tumblr.com/share?s=&v=3&u='+encodeURIComponent((opt.buttons.tumblr.url !== '' ? opt.buttons.tumblr.url : opt.url))+'&t='+encodeURIComponent(opt.text), 'tumblr', us_script.tumblr_width, us_script.tumblr_height );
		},
		flipboard: function(opt){
			PopupCenter('https://share.flipboard.com/bookmarklet/popout?url='+encodeURIComponent((opt.buttons.flipboard.url !== '' ? opt.buttons.flipboard.url : opt.url))+'&title='+encodeURIComponent(opt.text), 'flipboard', us_script.flipboard_width, us_script.flipboard_height );
		}
	};

	/* Plugin constructor
	================================================== */
	function Plugin( element, options ) {
		this.element = element;

		this.options = $.extend( true, {}, defaults, options);
		this.options.share = options.share; //simple solution to allow order of buttons

		this._defaults = defaults;
		this._name = pluginName;

		this.init();
	};

	/* Potition popups center
	================================================== */
	function PopupCenter(url, title, w, h) {
	// Fixes dual-screen position						 Most browsers	  Firefox
		var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

		width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
		height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

		var left = ((width / 2) - (w / 2)) + dualScreenLeft;
		var top = ((height / 2) - (h / 2)) + dualScreenTop;
		var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

		// Puts focus on the newWindow
		if (window.focus) {
		newWindow.focus();
		}
	}

	function get_short_url(longUrl, callback) {
		if (us_script.bitly === 'true') {
			$.ajax({
				url : us_script.ajaxurl,
					dataType : "json",
					type : "POST",
					data : {
					url : longUrl,
					action : 'us_bitly'
				},
				async: false,
				success : function(response) {
					if(response.status_txt === "OK"){
						callback( response.data.url );
					} else {
						callback( longUrl );
					}
				},
				error : function(xhr, error, message) {
					callback( longUrl );
				}
			});
		} else {
			callback( longUrl );
		}
	}

	/* Initialization method
	================================================== */
	Plugin.prototype.init = function () {
		var self = this;
		if(this.options.urlCurl !== ''){
			urlJson.googlePlus = this.options.urlCurl + '?url={url}&type=googlePlus&action=us_counts';
			urlJson.stumbleupon = this.options.urlCurl + '?url={url}&type=stumbleupon&action=us_counts';
			urlJson.reddit = this.options.urlCurl + '?url={url}&type=reddit&action=us_counts';
			urlJson.pinterest = this.options.urlCurl + '?url={url}&type=pinterest&action=us_counts';
			urlJson.vkontakte = this.options.urlCurl + '?url={url}&type=vkontakte&action=us_counts';
			urlJson.comments = this.options.urlCurl + '?url={url}&type=comments&action=us_counts';
			urlJson.love = this.options.urlCurl + '?url={url}&type=love&action=us_counts';

			//console.log(urlJson.reddit);
		}
		$(this.element).addClass(this.options.className); //add class

		//HTML5 Custom data
		if(typeof $(this.element).data('title') !== 'undefined'){
			this.options.title = $(this.element).attr('data-title');
		}
		if(typeof $(this.element).data('url') !== 'undefined'){
			this.options.url = $(this.element).data('url');
		}
		if(typeof $(this.element).data('text') !== 'undefined'){
			this.options.text = $(this.element).data('text');
		}
		if(typeof $(this.element).data('media') !== 'undefined'){
			this.options.media = $(this.element).attr('data-media');
		}
		if(typeof $(this.element).data('description') !== 'undefined'){
			this.options.description = $(this.element).attr('data-description');
		}

		//how many social website have been selected
		$.each(this.options.share, function(name, val) {
			if(val === true){
				self.options.shareTotal ++;
			}
		});

		if(self.options.enableCounter === true){  //if for some reason you don't need counter
			//get count of social share that have been selected
			$.each(this.options.share, function(name, val) {
				if(val === true){
				//self.getSocialJson(name);
				try {
					self.getSocialJson(name);
					} catch(e){}
				}
			});
		} else if(self.options.template !== ''){  //for personalized button (with template)
			this.options.render(this, this.options);
		}

		//click event
		$(this.element).click(function(){
			self.options.click(self, self.options);
			return false;
		});
	};

	/* getSocialJson methode
	================================================== */
	Plugin.prototype.getSocialJson = function (name) {
		var self = this,
		count = 0,
		url = urlJson[name].replace('{url}', encodeURIComponent(this.options.url));
		if(this.options.buttons[name].urlCount === true && this.options.buttons[name].url !== ''){
			url = urlJson[name].replace('{url}', this.options.buttons[name].url);
		}
		//console.log(urlJson[name]);
		//console.log('name : ' + name + ' - url : '+url); //debug
		if(url != '' && self.options.urlCurl !== ''){  //urlCurl = '' if you don't want to used PHP script but used social button
			$.getJSON(url, function(json){
				if(typeof json.count !== "undefined" || typeof json.shares !== "undefined"){  //GooglePlus, Stumbleupon, Twitter, Pinterest and Reddit
					if (json.count) {
						var temp = json.count + '';
					} else if( json.shares ) {
						var temp = json.shares + '';
					} else {
						var temp = 0 + '';
					}
					temp = temp.replace('\u00c2\u00a0', '');  //remove google plus special chars
					count += parseInt(temp, 10);
				} else if(typeof json[0] !== "undefined"){  //Delicious
					count += parseInt(json[0].total_posts, 10);
				} else if(json.data && json.data.length > 0 && typeof json.data[0].total_count !== "undefined"){ //Facebook total count
					count += parseInt(json.data[0].total_count, 10);
				} else if(typeof json[0] !== "undefined"){
				}
				self.options.count[name] = count;
				self.options.total += count;
				self.renderer();
				self.rendererPerso();
				//console.log(json); //debug
			})
			.error(function() {
				self.options.count[name] = 0;
				self.rendererPerso();
			});
		} else{
			self.renderer();
			self.options.count[name] = 0;
			self.rendererPerso();
		}
	};

	/* Methode for open popup
	================================================== */
	Plugin.prototype.openPopup = function (site) {
		popup[site](this.options);

		if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
			var tracking = {
				googlePlus: {site: 'GooglePlus', action: 'share'},
				facebook: {site: 'Facebook', action: 'share'},
				twitter: {site: 'Twitter', action: 'tweet'},
				delicious: {site: 'Delicious', action: 'add'},
				stumbleupon: {site: 'Stumbleupon', action: 'add'},
				linkedin: {site: 'Linkedin', action: 'share'},
				pinterest: {site: 'Pinterest', action: 'pin'},
				buffer: {site: 'Buffer', action: 'share'},
				reddit: {site: 'Reddit', action: 'share'},
				vkontakte: {site: 'Vkontakte', action: 'share'},
				printfriendly: {site: 'Printfriendly', action: 'print'},
				pocket: {site: 'Pocket', action: 'share'},
				tumblr: {site: 'Tumblr', action: 'share'},
				flipboard: {site: 'Flipboard', action: 'share'}

	    	}
	    	ga('send', 'social', tracking[site].site, tracking[site].action);
    	}
	};

	/* launch render methode
	================================================== */
	Plugin.prototype.rendererPerso = function () {
		//check if this is the last social website to launch render
		var shareCount = 0;
		for (e in this.options.count) { shareCount++; }
		if(shareCount === this.options.shareTotal){
			this.options.render(this, this.options);
		}
	};

	/* render methode
	================================================== */
	Plugin.prototype.renderer = function () {
		var total = this.options.total,
		template = this.options.template;
		if(this.options.shorterTotal === true){  //format number like 1.2k or 5M
			total = this.shorterTotal(total);
		}

		if(template !== ''){  //if there is a template
			template = template.replace('{total}', total);
			$(this.element).html(template);
		}
	};

	/* format total numbers like 1.2k or 5M
	================================================== */
	Plugin.prototype.shorterTotal = function (num) {
		if (num >= 1e6){
			num = (num / 1e6).toFixed(2) + "M"
		} else if (num >= 1e3){
			num = (num / 1e3).toFixed(1) + "k"
		}
		return num;
	};

	/* Methode for add +1 to a counter
	================================================== */
	Plugin.prototype.simulateClick = function () {
		var html = $(this.element).html();
		$(this.element).html(html.replace(this.options.total, this.options.total+1));
	};

	/* A really lightweight plugin wrapper around the constructor, preventing against multiple instantiations
	================================================== */
	$.fn[pluginName] = function ( options ) {
		var args = arguments;
		if (options === undefined || typeof options === 'object') {
			return this.each(function () {
				if (!$.data(this, 'plugin_' + pluginName)) {
					$.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
				}
			});
		} else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
			return this.each(function () {
				var instance = $.data(this, 'plugin_' + pluginName);
				if (instance instanceof Plugin && typeof instance[options] === 'function') {
					instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
				}
			});
		}
	};
})(jQuery, window, document);

(function () {

	function us_mail_send() {

		var your_name = jQuery('.us_mail_your_name').val(),
			url = jQuery('.us_mail_url').val(),
			your_email = jQuery('.us_mail_your_email').val(),
			recipient_email = jQuery('.us_mail_recipient_email').val(),
			message = jQuery('.us_mail_message').val(),
			captcha = jQuery('.us_mail_captcha').val();

		jQuery.ajax({
			type: 'POST',
			url: us_script.ajaxurl,
			data: {
				action: 'us_send_mail',
				url: url,
				your_name: your_name,
				your_email: your_email,
				recipient_email: recipient_email,
				message: message,
				captcha: captcha
			},

			success: function(response){

				var responseElement = jQuery('.us_mail_response');
				var us_mail_form = jQuery('.us_mail_form_holder');

				responseElement
					.hide()
					.removeClass('alert alert-danger alert-info alert-success');

				if (response === "ok") {
					responseElement
						.fadeIn().addClass('alert alert-success').html(us_script.success);

					us_mail_form
						.html('');

					setTimeout(function() {
						jQuery('.us_modal');
							jQuery.magnificPopup.instance.close();
					}, 2000);
				} else {
					responseElement
						.fadeIn()
						.html(response)
						.addClass('alert alert-danger');
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
			}

		});

	}

	jQuery(document).ready(function() {

		jQuery('.us_mail_send').on('click', function(){
			jQuery('.us_mail_response').addClass('alert alert-info').html(us_script.trying);
			us_mail_send();
		});

		jQuery('.us_mail a').magnificPopup({
			type:'inline',
			midClick: true,
			removalDelay: 300,
			mainClass: 'us_mail_fade us_wrapper'
		});

		jQuery('.us_share_text').each(function() {
			var share_text = jQuery(this).data("text");
			jQuery(this).find('.us_share_text_span').text(share_text);
		});

		jQuery('.us_total').each(function() {
			var template = '<div class="us_box"><div class="us_count">{total}</div><div class="us_share">' + us_script.total_shares_text + '</div></div>';

			jQuery(this).ultimate_social_deux({
				total: jQuery(this).data("defaults"),
				share: {
					facebook: jQuery(this).data("facebook"),
					twitter: jQuery(this).data("twitter"),
					googlePlus: jQuery(this).data("googleplus"),
					pinterest: jQuery(this).data("pinterest"),
					linkedin: jQuery(this).data("linkedin"),
					stumbleupon: jQuery(this).data("stumble"),
					delicious: jQuery(this).data("delicious"),
					buffer: jQuery(this).data("buffer"),
					reddit: jQuery(this).data("reddit"),
					vkontakte: jQuery(this).data("vkontakte")
				},
				template: template,
				urlCurl: us_script.sharrre_url
			});
		});
		jQuery('.us_twitter').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-twitter"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
			}
			selector.ultimate_social_deux({
				share: {
					twitter: share
				},
				buttons: {
					twitter: {
						via: us_script.tweet_via
					}
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('twitter');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_facebook').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-facebook"></i></div><div class="us_count">{total}</div></a>';
			if ( jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
			}
			if (jQuery(this).hasClass('us_native') ) {
				var selector = jQuery( ".us_box", this);
				var template = '<div class="us_share"><i class="us-icon-facebook"></i></div><div class="us_count">{total}</div>';
				jQuery(this).mouseover(function() {
				  	us_native.load(this);
				});
			}

			selector.ultimate_social_deux({
				share: {
					facebook: share
				},
				template: template,
				click: function(api, options){
					api.openPopup('facebook');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_googleplus').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-gplus"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
				var count = jQuery(this).data('count');
				jQuery(this).find('.us_count').text(count);
			}
			if (jQuery(this).hasClass('us_native') ) {
				var selector = jQuery( ".us_box", this);
				var template = '<div class="us_share"><i class="us-icon-google"></i></div><div class="us_count">{total}</div>';
				jQuery(this).mouseover(function() {
				  	us_native.load(this);
				});
			}
			selector.ultimate_social_deux({
				share: {
					googlePlus: share
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('googlePlus');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_pinterest').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-pinterest"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
				var count = jQuery(this).data('count');
				jQuery(this).find('.us_count').text(count);
			}
			selector.ultimate_social_deux({
				share: {
					pinterest: share
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('pinterest');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_linkedin').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-linkedin"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
			}
			selector.ultimate_social_deux({
				share: {
					linkedin: share
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('linkedin');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_stumble').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-stumbleupon"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
				var count = jQuery(this).data('count');
				jQuery(this).find('.us_count').text(count);
			}
			selector.ultimate_social_deux({
				share: {
					stumbleupon: share
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('stumbleupon');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_delicious').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-delicious"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
			}
			selector.ultimate_social_deux({
				share: {
					delicious: share
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('delicious');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_buffer').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-buffer"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
			}
			selector.ultimate_social_deux({
				share: {
					buffer: share
				},
				buttons: {
					buffer: {
						url: jQuery(this).attr("data-url"),
						media: jQuery(this).attr("data-media"),
						description: jQuery(this).attr("data-text")
					}
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('buffer');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_reddit').each(function() {
			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-reddit"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
				var count = jQuery(this).data('count');
				jQuery(this).find('.us_count').text(count);
			}
			selector.ultimate_social_deux({
				share: {
					reddit: share
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('reddit');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_vkontakte').each(function() {

			var selector = jQuery(this);
			var share = true;
			var template = '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-vkontakte"></i></div><div class="us_count">{total}</div></a>';
			if (jQuery(this).hasClass('us_transient') || jQuery(this).hasClass('us_no_count')) {
				var share = false;
				var template = '';
				var count = jQuery(this).data('count');
				jQuery(this).find('.us_count').text(count);
			}
			if (jQuery(this).hasClass('us_native') ) {
				var selector = jQuery( ".us_box", this);
				var template = '<div class="us_share"><i class="us-icon-vkontakte"></i></div><div class="us_count">{total}</div>';
				jQuery(this).mouseover(function() {
					us_native.load(this);
				});
			}
			selector.ultimate_social_deux({
				share: {
					vkontakte: share
				},
				enableHover: false,
				template: template,
				urlCurl: us_script.sharrre_url,
				click: function(api, options){
					api.openPopup('vkontakte');
					api.simulateClick();
					return false;
				}
			});
		});
		jQuery('.us_pocket').each(function() {
			jQuery(this).ultimate_social_deux({
				share: {
					pocket: true
				},
				click: function(api, options){
					api.openPopup('pocket');
					return false;
				}
			});
		});
		jQuery('.us_tumblr').each(function() {
			jQuery(this).ultimate_social_deux({
				share: {
					tumblr: true
				},
				click: function(api, options){
					api.openPopup('tumblr');
					return false;
				}
			});
		});
		jQuery('.us_print').each(function() {
			jQuery(this).ultimate_social_deux({
				share: {
					printfriendly: true
				},
				click: function(api, options){
					api.openPopup('printfriendly');
					return false;
				}
			});
		});
		jQuery('.us_flipboard').each(function() {
			jQuery(this).ultimate_social_deux({
				share: {
					flipboard: true
				},
				click: function(api, options){
					api.openPopup('flipboard');
					return false;
				}
			});
		});

		jQuery('.us_comments').each(function() {
			var count = jQuery(this).data('count');
			jQuery(this).find('.us_count').text(count);
		});


		jQuery('.us_love').each(function() {

			var count = jQuery(this).data('count');
			jQuery(this).find('.us_count').text(count);

			jQuery(this).find('a').on('click', function() {
				var url = jQuery(this).data('url');
				var user_id = jQuery(this).data('user_id');

				var data = {
					action: 'us_love',
					url: url,
					user_id: user_id,
					nonce: us_script.nonce
				};

				// don't allow the user to love the item more than once
				if(jQuery(this).hasClass('loved')) {
					alert(us_script.already_loved_message);
					return false;
				}

				if( jQuery.cookie('us_love_count_' + url)) {
					alert(us_script.already_loved_message);
					return false;
				}

				var clicked = 'false';
				if( clicked === 'false' ) {
					clicked = 'true';
					jQuery.ajax({
						type: "POST",
						data: data,
						url: us_script.ajaxurl,
						context: this,
						success: function( response ) {
							if( response ) {
								jQuery(this).addClass('loved');
								jQuery(this).find('.us_count').text(count + 1);
								if(us_script.logged_in == 'false') {
									jQuery.cookie('us_love_count_' + url, 'yes', { expires: 365 });
								}
							} else {
								alert(us_script.already_loved_message);
							}
							clicked = 'false';
						}
					}).fail(function (data) {
						alert(us_script.error_message);
					});
				}
				return false;
			});
		});

	});

}(jQuery));

window.us_native = (function(window, document, undefined)
{
	'use strict';

	var uid	   = 0,
		instances = [ ],
		networks  = { },
		widgets   = { },
		rstate	= /^($|loaded|complete)/,
		euc	   = window.encodeURIComponent;

	var usnative = {

		settings: { },

		trim: function(str)
		{
			return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g,'');
		},

		hasClass: function(el, cn)
		{
			return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
		},

		addClass: function(el, cn)
		{
			if (!usnative.hasClass(el, cn)) {
				el.className = (el.className === '') ? cn : el.className + ' ' + cn;
			}
		},

		removeClass: function(el, cn)
		{
			el.className = usnative.trim(' ' + el.className + ' '.replace(' ' + cn + ' ', ' '));
		},

		extendObject: function(to, from, overwrite)
		{
			for (var prop in from) {
				var hasProp = to[prop] !== undefined;
				if (hasProp && typeof from[prop] === 'object') {
					usnative.extendObject(to[prop], from[prop], overwrite);
				} else if (overwrite || !hasProp) {
					to[prop] = from[prop];
				}
			}
		},

		getElements: function(context, cn)
		{
			var i   = 0,
				el  = [ ],
				gcn = !!context.getElementsByClassName,
				all = gcn ? context.getElementsByClassName(cn) : context.getElementsByTagName('*');
			for (; i < all.length; i++) {
				if (gcn || usnative.hasClass(all[i], cn)) {
					el.push(all[i]);
				}
			}
			return el;
		},

		getDataAttributes: function(el, noprefix, nostr)
		{
			var i	= 0,
				str  = '',
				obj  = { },
				attr = el.attributes;
			for (; i < attr.length; i++) {
				var key = attr[i].name,
					val = attr[i].value;
				if (val.length && key.indexOf('data-') === 0) {
					if (noprefix) {
						key = key.substring(5);
					}
					if (nostr) {
						obj[key] = val;
					} else {
						str += euc(key) + '=' + euc(val) + '&';
					}
				}
			}
			return nostr ? obj : str;
		},

		copyDataAttributes: function(from, to, noprefix, nohyphen)
		{
			var attr = usnative.getDataAttributes(from, noprefix, true);
			for (var i in attr) {
				to.setAttribute(nohyphen ? i.replace(/-/g, '_') : i, attr[i]);
			}
		},

		createIframe: function(src, instance)
		{
			var iframe = document.createElement('iframe');
			iframe.style.cssText = 'overflow: hidden; border: none;';
			usnative.extendObject(iframe, { src: src, allowtransparency: 'true', frameborder: '0', scrolling: 'no' }, true);
			if (instance) {
				iframe.onload = iframe.onreadystatechange = function ()
				{
					if (rstate.test(iframe.readyState || '')) {
						iframe.onload = iframe.onreadystatechange = null;
						usnative.activateInstance(instance);
					}
				};
			}
			return iframe;
		},

		networkReady: function(name)
		{
			return networks[name] ? networks[name].loaded : undefined;
		},

		appendNetwork: function(network)
		{

			if (!network || network.appended) {
				return;
			}
			if (typeof network.append === 'function' && network.append(network) === false) {
				network.appended = network.loaded = true;
				usnative.activateAll(network);
				return;
			}

			if (network.script) {
				network.el = document.createElement('script');
				usnative.extendObject(network.el, network.script, true);
				network.el.async = true;
				network.el.onload = network.el.onreadystatechange = function()
				{
					if (rstate.test(network.el.readyState || '')) {
						network.el.onload = network.el.onreadystatechange = null;
						network.loaded = true;
						if (typeof network.onload === 'function' && network.onload(network) === false) {
							return;
						}
						usnative.activateAll(network);
					}
				};
				document.body.appendChild(network.el);
			}
			network.appended = true;
		},

		removeNetwork: function(network)
		{
			if (!usnative.networkReady(network.name)) {
				return false;
			}
			if (network.el.parentNode) {
				network.el.parentNode.removeChild(network.el);
			}
			return !(network.appended = network.loaded = false);
		},

		reloadNetwork: function(name)
		{
			var network = networks[name];
			if (network && usnative.removeNetwork(network)) {
				usnative.appendNetwork(network);
			}
		},

		createInstance: function(el, widget)
		{
			var proceed  = true,
				instance = {
					el	  : el,
					uid	 : uid++,
					widget  : widget
				};
			instances.push(instance);
			if (widget.process !== undefined) {
				proceed = (typeof widget.process === 'function') ? widget.process(instance) : false;
			}
			if (proceed) {
				usnative.processInstance(instance);
			}
			instance.el.setAttribute('data-usnative', instance.uid);
			instance.el.className = 'usnative ' + widget.name + ' usnative-instance';
			return instance;
		},

		processInstance: function(instance)
		{
			var el = instance.el;
			instance.el = document.createElement('div');
			instance.el.className = el.className;
			usnative.copyDataAttributes(el, instance.el);
			// stop over-zealous scripts from activating all instances
			if (el.nodeName.toLowerCase() === 'a' && !el.getAttribute('data-default-href')) {
				instance.el.setAttribute('data-default-href', el.getAttribute('href'));
			}
			var parent = el.parentNode;
			parent.insertBefore(instance.el, el);
			parent.removeChild(el);
		},

		activateInstance: function(instance)
		{
			if (instance && !instance.loaded) {
				instance.loaded = true;
				if (typeof instance.widget.activate === 'function') {
					instance.widget.activate(instance);
				}
				usnative.addClass(instance.el, 'usnative-loaded');
				return instance.onload ? instance.onload(instance.el) : null;
			}
		},

		activateAll: function(network)
		{
			if (typeof network === 'string') {
				network = networks[network];
			}
			for (var i = 0; i < instances.length; i++) {
				var instance = instances[i];
				if (instance.init && instance.widget.network === network) {
					usnative.activateInstance(instance);
				}
			}
		},

		load: function(context, el, w, onload, process)
		{
			context = (context && typeof context === 'object' && context.nodeType === 1) ? context : document;

			if (!el || typeof el !== 'object') {
				usnative.load(context, usnative.getElements(context, 'usnative'), w, onload, process);
				return;
			}

			var i;

			if (/Array/.test(Object.prototype.toString.call(el))) {
				for (i = 0; i < el.length; i++) {
					usnative.load(context, el[i], w, onload, process);
				}
				return;
			}

			if (el.nodeType !== 1) {
				return;
			}

			if (!w || !widgets[w]) {
				w = null;
				var classes = el.className.split(' ');
				for (i = 0; i < classes.length; i++) {
					if (widgets[classes[i]]) {
						w = classes[i];
						break;
					}
				}
				if (!w) {
					return;
				}
			}

			var instance,
				widget = widgets[w],
				sid	= parseInt(el.getAttribute('data-usnative'), 10);
			if (!isNaN(sid)) {
				for (i = 0; i < instances.length; i++) {
					if (instances[i].uid === sid) {
						instance = instances[i];
						break;
					}
				}
			} else {
				instance = usnative.createInstance(el, widget);
			}

			if (process || !instance) {
				return;
			}

			if (!instance.init) {
				instance.init = true;
				instance.onload = (typeof onload === 'function') ? onload : null;
				widget.init(instance);
			}

			if (!widget.network.appended) {
				usnative.appendNetwork(widget.network);
			} else {
				if (usnative.networkReady(widget.network.name)) {
					usnative.activateInstance(instance);
				}
			}
		},

		activate: function(el, w, onload)
		{
			window.us_native.load(null, el, w, onload);
		},

		process: function(context, el, w)
		{
			window.us_native.load(context, el, w, null, true);
		},

		network: function(n, params)
		{
			networks[n] = {
				name	 : n,
				el	   : null,
				appended : false,
				loaded   : false,
				widgets  : { }
			};
			if (params) {
				usnative.extendObject(networks[n], params);
			}
		},

		widget: function(n, w, params)
		{
			params.name = n + '-' + w;
			if (!networks[n] || widgets[params.name]) {
				return;
			}
			params.network = networks[n];
			networks[n].widgets[w] = widgets[params.name] = params;
		},

		setup: function(params)
		{
			usnative.extendObject(usnative.settings, params, true);
		}

	};

	return usnative;

})(window, window.document);

(function() {
	var s = window._usnative;
	if (/Array/.test(Object.prototype.toString.call(s))) {
		for (var i = 0, len = s.length; i < len; i++) {
			if (typeof s[i] === 'function') {
				s[i]();
			}
		}
	}
})();

(function(window, document, us_native, undefined)
{

	us_native.setup({
		googleplus: {
			lang: 'en-GB',
			onstartinteraction : function(el, e) {
				if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
					ga('send', 'social', 'GooglePlus', '+1', url);
				}
			}
		}
	});

	us_native.network('googleplus', {
		script: {
			src: '//apis.google.com/js/plusone.js'
		},
		append: function(network)
		{
			if (window.gapi) {
				return false;
			}
			window.___gcfg = {
				lang: us_native.settings.googleplus.lang,
				parsetags: 'explicit'
			};
		}
	});

	var googleplusInit = function(instance)
	{
		var el = document.createElement('div');
		el.className = 'g-' + instance.widget.gtype;
		us_native.copyDataAttributes(instance.el, el);
		instance.el.appendChild(el);
		instance.gplusEl = el;
	};

	var googleplusEvent = function(instance, callback) {
		return (typeof callback !== 'function') ? null : function(data) {
			callback(instance.el, data);
		};
	};

	var googleplusActivate = function(instance)
	{
		var type = instance.widget.gtype;
		if (window.gapi && window.gapi[type]) {
			var settings = us_native.settings.googleplus,
				params   = us_native.getDataAttributes(instance.el, true, true),
				events   = ['onstartinteraction', 'onendinteraction', 'callback'];
			for (var i = 0; i < events.length; i++) {
				params[events[i]] = googleplusEvent(instance, settings[events[i]]);
			}
			window.gapi[type].render(instance.gplusEl, params);
		}
	};

	us_native.widget('googleplus', 'one',   { init: googleplusInit, activate: googleplusActivate, gtype: 'plusone' });
	us_native.widget('googleplus', 'share', { init: googleplusInit, activate: googleplusActivate, gtype: 'plus' });
	us_native.widget('googleplus', 'badge', { init: googleplusInit, activate: googleplusActivate, gtype: 'plus' });

})(window, window.document, window.us_native);

(function(window, document, us_native, undefined)
{

	us_native.setup({
		facebook: {
			lang: 'en_US',
			appId: us_script.facebook_appid,
			onlike   : function(url) {
				if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
					ga('send', 'social', 'facebook', 'like', url);
				}
			},
			onunlike : function(url) {
				if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
					ga('send', 'social', 'facebook', 'unlike', url);
				}
			}
		}
	});

	us_native.network('facebook', {
		script: {
			src : '//connect.facebook.net/{{language}}/all.js',
			id  : 'facebook-jssdk'
		},
		append: function(network)
		{
			var fb	   = document.createElement('div'),
				settings = us_native.settings.facebook,
				events   = {
					onlike: 'edge.create',
					onunlike: 'edge.remove',
					onsend: 'message.send' ,
					oncomment: 'comment.create',
					onuncomment: 'comment.remove'
				};
			fb.id = 'fb-root';
			document.body.appendChild(fb);
			network.script.src = network.script.src.replace('{{language}}', settings.lang);
			window.fbAsyncInit = function() {
				window.FB.init({
					  appId: settings.appId,
					  xfbml: true
				});
				for (var e in events) {
					if (typeof settings[e] === 'function') {
						window.FB.Event.subscribe(events[e], settings[e]);
					}
				}
			};
		}
	});

	us_native.widget('facebook', 'like', {
		init: function(instance)
		{
			var el = document.createElement('div');
			el.className = 'fb-like';
			us_native.copyDataAttributes(instance.el, el);
			instance.el.appendChild(el);
			if (window.FB && window.FB.XFBML) {
				window.FB.XFBML.parse(instance.el);
			}
		}
	});

})(window, window.document, window.us_native);

(function(window, document, us_native, undefined)
{

	var VKCallbacks = [];

	us_native.setup({
		vkontakte: {
			apiId: us_script.vkontakte_appid,
			group: {
			  id: 0,
			  mode: 0,
			  width: 48,
			  height: 20
			},
			like: {
			  type: 'mini',
			  pageUrl: null
			}
		}
	});

	us_native.network('vkontakte', {
		script: {
			src : '//vk.com/js/api/openapi.js?105',
			id  : 'vk-jsapi'
		},
		onload: function(network) {
		   var settings = us_native.settings.vkontakte;
		   VK.init({apiId: settings.apiId, onlyWidgets: true});
		   for (var i = 0, i$l = VKCallbacks.length; i < i$l; VKCallbacks[i].call(this), i++);
		}
	});

	var extendConfWithAttributes = function(el, attributes, original) {
		var result = {}, key;
		for (var k = 0, k$l = attributes.length; k < k$l; key = attributes[k], result[key] = el.getAttribute('data-' + key) || original[key], k++);
		return result;
	}

	us_native.widget('vkontakte', 'like', {
		init: function(instance)
		{
			if (typeof window.VK !== 'object') VKCallbacks.push(function(){
				var el	   = document.createElement('div'),
					settings = us_native.settings.vkontakte;
				el.className = 'vk-like';
				el.id = 'vkontakte-like-' + (new Date()).getTime() + Math.random().toString().replace('.', '-');
				us_native.copyDataAttributes(instance.el, el);
				like = extendConfWithAttributes(instance.el, ['pageUrl', 'type'], settings.like);
				instance.el.appendChild(el);
				VK.Widgets.Like(el.id, like);
			});
		}
	});

})(window, window.document, window.us_native);

!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e("object"==typeof exports?require("jquery"):jQuery)}(function(e){function n(e){return u.raw?e:encodeURIComponent(e)}function o(e){return u.raw?e:decodeURIComponent(e)}function i(e){return n(u.json?JSON.stringify(e):String(e))}function r(e){0===e.indexOf('"')&&(e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return e=decodeURIComponent(e.replace(c," ")),u.json?JSON.parse(e):e}catch(n){}}function t(n,o){var i=u.raw?n:r(n);return e.isFunction(o)?o(i):i}var c=/\+/g,u=e.cookie=function(r,c,f){if(void 0!==c&&!e.isFunction(c)){if(f=e.extend({},u.defaults,f),"number"==typeof f.expires){var a=f.expires,d=f.expires=new Date;d.setTime(+d+864e5*a)}return document.cookie=[n(r),"=",i(c),f.expires?"; expires="+f.expires.toUTCString():"",f.path?"; path="+f.path:"",f.domain?"; domain="+f.domain:"",f.secure?"; secure":""].join("")}for(var p=r?void 0:{},s=document.cookie?document.cookie.split("; "):[],m=0,x=s.length;x>m;m++){var v=s[m].split("="),k=o(v.shift()),l=v.join("=");if(r&&r===k){p=t(l,c);break}r||void 0===(l=t(l))||(p[k]=l)}return p};u.defaults={},e.removeCookie=function(n,o){return void 0===e.cookie(n)?!1:(e.cookie(n,"",e.extend({},o,{expires:-1})),!e.cookie(n))}});

/*! Magnific Popup - v0.9.9 - 2013-12-27
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2013 Dmitry Semenov; */
;(function($) {

/*>>core*/
/**
 *
 * Magnific Popup Core JS file
 *
 */


/**
 * Private static constants
 */
var CLOSE_EVENT = 'Close',
	BEFORE_CLOSE_EVENT = 'BeforeClose',
	AFTER_CLOSE_EVENT = 'AfterClose',
	BEFORE_APPEND_EVENT = 'BeforeAppend',
	MARKUP_PARSE_EVENT = 'MarkupParse',
	OPEN_EVENT = 'Open',
	CHANGE_EVENT = 'Change',
	NS = 'mfp',
	EVENT_NS = '.' + NS,
	READY_CLASS = 'mfp-ready',
	REMOVING_CLASS = 'mfp-removing',
	PREVENT_CLOSE_CLASS = 'mfp-prevent-close';


/**
 * Private vars
 */
var mfp, // As we have only one instance of MagnificPopup object, we define it locally to not to use 'this'
	MagnificPopup = function(){},
	_isJQ = !!(window.jQuery),
	_prevStatus,
	_window = $(window),
	_body,
	_document,
	_prevContentType,
	_wrapClasses,
	_currPopupType;


/**
 * Private functions
 */
var _mfpOn = function(name, f) {
		mfp.ev.on(NS + name + EVENT_NS, f);
	},
	_getEl = function(className, appendTo, html, raw) {
		var el = document.createElement('div');
		el.className = 'mfp-'+className;
		if(html) {
			el.innerHTML = html;
		}
		if(!raw) {
			el = $(el);
			if(appendTo) {
				el.appendTo(appendTo);
			}
		} else if(appendTo) {
			appendTo.appendChild(el);
		}
		return el;
	},
	_mfpTrigger = function(e, data) {
		mfp.ev.triggerHandler(NS + e, data);

		if(mfp.st.callbacks) {
			// converts "mfpEventName" to "eventName" callback and triggers it if it's present
			e = e.charAt(0).toLowerCase() + e.slice(1);
			if(mfp.st.callbacks[e]) {
				mfp.st.callbacks[e].apply(mfp, $.isArray(data) ? data : [data]);
			}
		}
	},
	_getCloseBtn = function(type) {
		if(type !== _currPopupType || !mfp.currTemplate.closeBtn) {
			mfp.currTemplate.closeBtn = $( mfp.st.closeMarkup.replace('%title%', mfp.st.tClose ) );
			_currPopupType = type;
		}
		return mfp.currTemplate.closeBtn;
	},
	// Initialize Magnific Popup only when called at least once
	_checkInstance = function() {
		if(!$.magnificPopup.instance) {
			mfp = new MagnificPopup();
			mfp.init();
			$.magnificPopup.instance = mfp;
		}
	},
	// CSS transition detection, http://stackoverflow.com/questions/7264899/detect-css-transitions-using-javascript-and-without-modernizr
	supportsTransitions = function() {
		var s = document.createElement('p').style, // 's' for style. better to create an element if body yet to exist
			v = ['ms','O','Moz','Webkit']; // 'v' for vendor

		if( s['transition'] !== undefined ) {
			return true;
		}

		while( v.length ) {
			if( v.pop() + 'Transition' in s ) {
				return true;
			}
		}

		return false;
	};



/**
 * Public functions
 */
MagnificPopup.prototype = {

	constructor: MagnificPopup,

	/**
	 * Initializes Magnific Popup plugin.
	 * This function is triggered only once when $.fn.magnificPopup or $.magnificPopup is executed
	 */
	init: function() {
		var appVersion = navigator.appVersion;
		mfp.isIE7 = appVersion.indexOf("MSIE 7.") !== -1;
		mfp.isIE8 = appVersion.indexOf("MSIE 8.") !== -1;
		mfp.isLowIE = mfp.isIE7 || mfp.isIE8;
		mfp.isAndroid = (/android/gi).test(appVersion);
		mfp.isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
		mfp.supportsTransition = supportsTransitions();

		// We disable fixed positioned lightbox on devices that don't handle it nicely.
		// If you know a better way of detecting this - let me know.
		mfp.probablyMobile = (mfp.isAndroid || mfp.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent) );
		_document = $(document);

		mfp.popupsCache = {};
	},

	/**
	 * Opens popup
	 * @param  data [description]
	 */
	open: function(data) {

		if(!_body) {
			_body = $(document.body);
		}

		var i;

		if(data.isObj === false) {
			// convert jQuery collection to array to avoid conflicts later
			mfp.items = data.items.toArray();

			mfp.index = 0;
			var items = data.items,
				item;
			for(i = 0; i < items.length; i++) {
				item = items[i];
				if(item.parsed) {
					item = item.el[0];
				}
				if(item === data.el[0]) {
					mfp.index = i;
					break;
				}
			}
		} else {
			mfp.items = $.isArray(data.items) ? data.items : [data.items];
			mfp.index = data.index || 0;
		}

		// if popup is already opened - we just update the content
		if(mfp.isOpen) {
			mfp.updateItemHTML();
			return;
		}

		mfp.types = [];
		_wrapClasses = '';
		if(data.mainEl && data.mainEl.length) {
			mfp.ev = data.mainEl.eq(0);
		} else {
			mfp.ev = _document;
		}

		if(data.key) {
			if(!mfp.popupsCache[data.key]) {
				mfp.popupsCache[data.key] = {};
			}
			mfp.currTemplate = mfp.popupsCache[data.key];
		} else {
			mfp.currTemplate = {};
		}



		mfp.st = $.extend(true, {}, $.magnificPopup.defaults, data );
		mfp.fixedContentPos = mfp.st.fixedContentPos === 'auto' ? !mfp.probablyMobile : mfp.st.fixedContentPos;

		if(mfp.st.modal) {
			mfp.st.closeOnContentClick = false;
			mfp.st.closeOnBgClick = false;
			mfp.st.showCloseBtn = false;
			mfp.st.enableEscapeKey = false;
		}


		// Building markup
		// main containers are created only once
		if(!mfp.bgOverlay) {

			// Dark overlay
			mfp.bgOverlay = _getEl('bg').on('click'+EVENT_NS, function() {
				mfp.close();
			});

			mfp.wrap = _getEl('wrap').attr('tabindex', -1).on('click'+EVENT_NS, function(e) {
				if(mfp._checkIfClose(e.target)) {
					mfp.close();
				}
			});

			mfp.container = _getEl('container', mfp.wrap);
		}

		mfp.contentContainer = _getEl('content');
		if(mfp.st.preloader) {
			mfp.preloader = _getEl('preloader', mfp.container, mfp.st.tLoading);
		}


		// Initializing modules
		var modules = $.magnificPopup.modules;
		for(i = 0; i < modules.length; i++) {
			var n = modules[i];
			n = n.charAt(0).toUpperCase() + n.slice(1);
			mfp['init'+n].call(mfp);
		}
		_mfpTrigger('BeforeOpen');


		if(mfp.st.showCloseBtn) {
			// Close button
			if(!mfp.st.closeBtnInside) {
				mfp.wrap.append( _getCloseBtn() );
			} else {
				_mfpOn(MARKUP_PARSE_EVENT, function(e, template, values, item) {
					values.close_replaceWith = _getCloseBtn(item.type);
				});
				_wrapClasses += ' mfp-close-btn-in';
			}
		}

		if(mfp.st.alignTop) {
			_wrapClasses += ' mfp-align-top';
		}



		if(mfp.fixedContentPos) {
			mfp.wrap.css({
				overflow: mfp.st.overflowY,
				overflowX: 'hidden',
				overflowY: mfp.st.overflowY
			});
		} else {
			mfp.wrap.css({
				top: _window.scrollTop(),
				position: 'absolute'
			});
		}
		if( mfp.st.fixedBgPos === false || (mfp.st.fixedBgPos === 'auto' && !mfp.fixedContentPos) ) {
			mfp.bgOverlay.css({
				height: _document.height(),
				position: 'absolute'
			});
		}



		if(mfp.st.enableEscapeKey) {
			// Close on ESC key
			_document.on('keyup' + EVENT_NS, function(e) {
				if(e.keyCode === 27) {
					mfp.close();
				}
			});
		}

		_window.on('resize' + EVENT_NS, function() {
			mfp.updateSize();
		});


		if(!mfp.st.closeOnContentClick) {
			_wrapClasses += ' mfp-auto-cursor';
		}

		if(_wrapClasses)
			mfp.wrap.addClass(_wrapClasses);


		// this triggers recalculation of layout, so we get it once to not to trigger twice
		var windowHeight = mfp.wH = _window.height();


		var windowStyles = {};

		if( mfp.fixedContentPos ) {
            if(mfp._hasScrollBar(windowHeight)){
                var s = mfp._getScrollbarSize();
                if(s) {
                    windowStyles.marginRight = s;
                }
            }
        }

		if(mfp.fixedContentPos) {
			if(!mfp.isIE7) {
				windowStyles.overflow = 'hidden';
			} else {
				// ie7 double-scroll bug
				$('body, html').css('overflow', 'hidden');
			}
		}



		var classesToadd = mfp.st.mainClass;
		if(mfp.isIE7) {
			classesToadd += ' mfp-ie7';
		}
		if(classesToadd) {
			mfp._addClassToMFP( classesToadd );
		}

		// add content
		mfp.updateItemHTML();

		_mfpTrigger('BuildControls');

		// remove scrollbar, add margin e.t.c
		$('html').css(windowStyles);

		// add everything to DOM
		mfp.bgOverlay.add(mfp.wrap).prependTo( mfp.st.prependTo || _body );

		// Save last focused element
		mfp._lastFocusedEl = document.activeElement;

		// Wait for next cycle to allow CSS transition
		setTimeout(function() {

			if(mfp.content) {
				mfp._addClassToMFP(READY_CLASS);
				mfp._setFocus();
			} else {
				// if content is not defined (not loaded e.t.c) we add class only for BG
				mfp.bgOverlay.addClass(READY_CLASS);
			}

			// Trap the focus in popup
			_document.on('focusin' + EVENT_NS, mfp._onFocusIn);

		}, 16);

		mfp.isOpen = true;
		mfp.updateSize(windowHeight);
		_mfpTrigger(OPEN_EVENT);

		return data;
	},

	/**
	 * Closes the popup
	 */
	close: function() {
		if(!mfp.isOpen) return;
		_mfpTrigger(BEFORE_CLOSE_EVENT);

		mfp.isOpen = false;
		// for CSS3 animation
		if(mfp.st.removalDelay && !mfp.isLowIE && mfp.supportsTransition )  {
			mfp._addClassToMFP(REMOVING_CLASS);
			setTimeout(function() {
				mfp._close();
			}, mfp.st.removalDelay);
		} else {
			mfp._close();
		}
	},

	/**
	 * Helper for close() function
	 */
	_close: function() {
		_mfpTrigger(CLOSE_EVENT);

		var classesToRemove = REMOVING_CLASS + ' ' + READY_CLASS + ' ';

		mfp.bgOverlay.detach();
		mfp.wrap.detach();
		mfp.container.empty();

		if(mfp.st.mainClass) {
			classesToRemove += mfp.st.mainClass + ' ';
		}

		mfp._removeClassFromMFP(classesToRemove);

		if(mfp.fixedContentPos) {
			var windowStyles = {marginRight: ''};
			if(mfp.isIE7) {
				$('body, html').css('overflow', '');
			} else {
				windowStyles.overflow = '';
			}
			$('html').css(windowStyles);
		}

		_document.off('keyup' + EVENT_NS + ' focusin' + EVENT_NS);
		mfp.ev.off(EVENT_NS);

		// clean up DOM elements that aren't removed
		mfp.wrap.attr('class', 'mfp-wrap').removeAttr('style');
		mfp.bgOverlay.attr('class', 'mfp-bg');
		mfp.container.attr('class', 'mfp-container');

		// remove close button from target element
		if(mfp.st.showCloseBtn &&
		(!mfp.st.closeBtnInside || mfp.currTemplate[mfp.currItem.type] === true)) {
			if(mfp.currTemplate.closeBtn)
				mfp.currTemplate.closeBtn.detach();
		}


		if(mfp._lastFocusedEl) {
			$(mfp._lastFocusedEl).focus(); // put tab focus back
		}
		mfp.currItem = null;
		mfp.content = null;
		mfp.currTemplate = null;
		mfp.prevHeight = 0;

		_mfpTrigger(AFTER_CLOSE_EVENT);
	},

	updateSize: function(winHeight) {

		if(mfp.isIOS) {
			// fixes iOS nav bars https://github.com/dimsemenov/Magnific-Popup/issues/2
			var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
			var height = window.innerHeight * zoomLevel;
			mfp.wrap.css('height', height);
			mfp.wH = height;
		} else {
			mfp.wH = winHeight || _window.height();
		}
		// Fixes #84: popup incorrectly positioned with position:relative on body
		if(!mfp.fixedContentPos) {
			mfp.wrap.css('height', mfp.wH);
		}

		_mfpTrigger('Resize');

	},

	/**
	 * Set content of popup based on current index
	 */
	updateItemHTML: function() {
		var item = mfp.items[mfp.index];

		// Detach and perform modifications
		mfp.contentContainer.detach();

		if(mfp.content)
			mfp.content.detach();

		if(!item.parsed) {
			item = mfp.parseEl( mfp.index );
		}

		var type = item.type;

		_mfpTrigger('BeforeChange', [mfp.currItem ? mfp.currItem.type : '', type]);
		// BeforeChange event works like so:
		// _mfpOn('BeforeChange', function(e, prevType, newType) { });

		mfp.currItem = item;





		if(!mfp.currTemplate[type]) {
			var markup = mfp.st[type] ? mfp.st[type].markup : false;

			// allows to modify markup
			_mfpTrigger('FirstMarkupParse', markup);

			if(markup) {
				mfp.currTemplate[type] = $(markup);
			} else {
				// if there is no markup found we just define that template is parsed
				mfp.currTemplate[type] = true;
			}
		}

		if(_prevContentType && _prevContentType !== item.type) {
			mfp.container.removeClass('mfp-'+_prevContentType+'-holder');
		}

		var newContent = mfp['get' + type.charAt(0).toUpperCase() + type.slice(1)](item, mfp.currTemplate[type]);
		mfp.appendContent(newContent, type);

		item.preloaded = true;

		_mfpTrigger(CHANGE_EVENT, item);
		_prevContentType = item.type;

		// Append container back after its content changed
		mfp.container.prepend(mfp.contentContainer);

		_mfpTrigger('AfterChange');
	},


	/**
	 * Set HTML content of popup
	 */
	appendContent: function(newContent, type) {
		mfp.content = newContent;

		if(newContent) {
			if(mfp.st.showCloseBtn && mfp.st.closeBtnInside &&
				mfp.currTemplate[type] === true) {
				// if there is no markup, we just append close button element inside
				if(!mfp.content.find('.mfp-close').length) {
					mfp.content.append(_getCloseBtn());
				}
			} else {
				mfp.content = newContent;
			}
		} else {
			mfp.content = '';
		}

		_mfpTrigger(BEFORE_APPEND_EVENT);
		mfp.container.addClass('mfp-'+type+'-holder');

		mfp.contentContainer.append(mfp.content);
	},




	/**
	 * Creates Magnific Popup data object based on given data
	 * @param  {int} index Index of item to parse
	 */
	parseEl: function(index) {
		var item = mfp.items[index],
			type;

		if(item.tagName) {
			item = { el: $(item) };
		} else {
			type = item.type;
			item = { data: item, src: item.src };
		}

		if(item.el) {
			var types = mfp.types;

			// check for 'mfp-TYPE' class
			for(var i = 0; i < types.length; i++) {
				if( item.el.hasClass('mfp-'+types[i]) ) {
					type = types[i];
					break;
				}
			}

			item.src = item.el.attr('data-mfp-src');
			if(!item.src) {
				item.src = item.el.attr('href');
			}
		}

		item.type = type || mfp.st.type || 'inline';
		item.index = index;
		item.parsed = true;
		mfp.items[index] = item;
		_mfpTrigger('ElementParse', item);

		return mfp.items[index];
	},


	/**
	 * Initializes single popup or a group of popups
	 */
	addGroup: function(el, options) {
		var eHandler = function(e) {
			e.mfpEl = this;
			mfp._openClick(e, el, options);
		};

		if(!options) {
			options = {};
		}

		var eName = 'click.magnificPopup';
		options.mainEl = el;

		if(options.items) {
			options.isObj = true;
			el.off(eName).on(eName, eHandler);
		} else {
			options.isObj = false;
			if(options.delegate) {
				el.off(eName).on(eName, options.delegate , eHandler);
			} else {
				options.items = el;
				el.off(eName).on(eName, eHandler);
			}
		}
	},
	_openClick: function(e, el, options) {
		var midClick = options.midClick !== undefined ? options.midClick : $.magnificPopup.defaults.midClick;


		if(!midClick && ( e.which === 2 || e.ctrlKey || e.metaKey ) ) {
			return;
		}

		var disableOn = options.disableOn !== undefined ? options.disableOn : $.magnificPopup.defaults.disableOn;

		if(disableOn) {
			if($.isFunction(disableOn)) {
				if( !disableOn.call(mfp) ) {
					return true;
				}
			} else { // else it's number
				if( _window.width() < disableOn ) {
					return true;
				}
			}
		}

		if(e.type) {
			e.preventDefault();

			// This will prevent popup from closing if element is inside and popup is already opened
			if(mfp.isOpen) {
				e.stopPropagation();
			}
		}


		options.el = $(e.mfpEl);
		if(options.delegate) {
			options.items = el.find(options.delegate);
		}
		mfp.open(options);
	},


	/**
	 * Updates text on preloader
	 */
	updateStatus: function(status, text) {

		if(mfp.preloader) {
			if(_prevStatus !== status) {
				mfp.container.removeClass('mfp-s-'+_prevStatus);
			}

			if(!text && status === 'loading') {
				text = mfp.st.tLoading;
			}

			var data = {
				status: status,
				text: text
			};
			// allows to modify status
			_mfpTrigger('UpdateStatus', data);

			status = data.status;
			text = data.text;

			mfp.preloader.html(text);

			mfp.preloader.find('a').on('click', function(e) {
				e.stopImmediatePropagation();
			});

			mfp.container.addClass('mfp-s-'+status);
			_prevStatus = status;
		}
	},


	/*
		"Private" helpers that aren't private at all
	 */
	// Check to close popup or not
	// "target" is an element that was clicked
	_checkIfClose: function(target) {

		if($(target).hasClass(PREVENT_CLOSE_CLASS)) {
			return;
		}

		var closeOnContent = mfp.st.closeOnContentClick;
		var closeOnBg = mfp.st.closeOnBgClick;

		if(closeOnContent && closeOnBg) {
			return true;
		} else {

			// We close the popup if click is on close button or on preloader. Or if there is no content.
			if(!mfp.content || $(target).hasClass('mfp-close') || (mfp.preloader && target === mfp.preloader[0]) ) {
				return true;
			}

			// if click is outside the content
			if(  (target !== mfp.content[0] && !$.contains(mfp.content[0], target))  ) {
				if(closeOnBg) {
					// last check, if the clicked element is in DOM, (in case it's removed onclick)
					if( $.contains(document, target) ) {
						return true;
					}
				}
			} else if(closeOnContent) {
				return true;
			}

		}
		return false;
	},
	_addClassToMFP: function(cName) {
		mfp.bgOverlay.addClass(cName);
		mfp.wrap.addClass(cName);
	},
	_removeClassFromMFP: function(cName) {
		this.bgOverlay.removeClass(cName);
		mfp.wrap.removeClass(cName);
	},
	_hasScrollBar: function(winHeight) {
		return (  (mfp.isIE7 ? _document.height() : document.body.scrollHeight) > (winHeight || _window.height()) );
	},
	_setFocus: function() {
		(mfp.st.focus ? mfp.content.find(mfp.st.focus).eq(0) : mfp.wrap).focus();
	},
	_onFocusIn: function(e) {
		if( e.target !== mfp.wrap[0] && !$.contains(mfp.wrap[0], e.target) ) {
			mfp._setFocus();
			return false;
		}
	},
	_parseMarkup: function(template, values, item) {
		var arr;
		if(item.data) {
			values = $.extend(item.data, values);
		}
		_mfpTrigger(MARKUP_PARSE_EVENT, [template, values, item] );

		$.each(values, function(key, value) {
			if(value === undefined || value === false) {
				return true;
			}
			arr = key.split('_');
			if(arr.length > 1) {
				var el = template.find(EVENT_NS + '-'+arr[0]);

				if(el.length > 0) {
					var attr = arr[1];
					if(attr === 'replaceWith') {
						if(el[0] !== value[0]) {
							el.replaceWith(value);
						}
					} else if(attr === 'img') {
						if(el.is('img')) {
							el.attr('src', value);
						} else {
							el.replaceWith( '<img src="'+value+'" class="' + el.attr('class') + '" />' );
						}
					} else {
						el.attr(arr[1], value);
					}
				}

			} else {
				template.find(EVENT_NS + '-'+key).html(value);
			}
		});
	},

	_getScrollbarSize: function() {
		// thx David
		if(mfp.scrollbarSize === undefined) {
			var scrollDiv = document.createElement("div");
			scrollDiv.id = "mfp-sbm";
			scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
			document.body.appendChild(scrollDiv);
			mfp.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
			document.body.removeChild(scrollDiv);
		}
		return mfp.scrollbarSize;
	}

}; /* MagnificPopup core prototype end */




/**
 * Public static functions
 */
$.magnificPopup = {
	instance: null,
	proto: MagnificPopup.prototype,
	modules: [],

	open: function(options, index) {
		_checkInstance();

		if(!options) {
			options = {};
		} else {
			options = $.extend(true, {}, options);
		}


		options.isObj = true;
		options.index = index || 0;
		return this.instance.open(options);
	},

	close: function() {
		return $.magnificPopup.instance && $.magnificPopup.instance.close();
	},

	registerModule: function(name, module) {
		if(module.options) {
			$.magnificPopup.defaults[name] = module.options;
		}
		$.extend(this.proto, module.proto);
		this.modules.push(name);
	},

	defaults: {

		// Info about options is in docs:
		// http://dimsemenov.com/plugins/magnific-popup/documentation.html#options

		disableOn: 0,

		key: null,

		midClick: false,

		mainClass: '',

		preloader: true,

		focus: '', // CSS selector of input to focus after popup is opened

		closeOnContentClick: false,

		closeOnBgClick: true,

		closeBtnInside: true,

		showCloseBtn: true,

		enableEscapeKey: true,

		modal: false,

		alignTop: false,

		removalDelay: 0,

		prependTo: null,

		fixedContentPos: 'auto',

		fixedBgPos: 'auto',

		overflowY: 'auto',

		closeMarkup: '<button title="%title%" type="button" class="mfp-close">&times;</button>',

		tClose: 'Close (Esc)',

		tLoading: 'Loading...'

	}
};



$.fn.magnificPopup = function(options) {
	_checkInstance();

	var jqEl = $(this);

	// We call some API method of first param is a string
	if (typeof options === "string" ) {

		if(options === 'open') {
			var items,
				itemOpts = _isJQ ? jqEl.data('magnificPopup') : jqEl[0].magnificPopup,
				index = parseInt(arguments[1], 10) || 0;

			if(itemOpts.items) {
				items = itemOpts.items[index];
			} else {
				items = jqEl;
				if(itemOpts.delegate) {
					items = items.find(itemOpts.delegate);
				}
				items = items.eq( index );
			}
			mfp._openClick({mfpEl:items}, jqEl, itemOpts);
		} else {
			if(mfp.isOpen)
				mfp[options].apply(mfp, Array.prototype.slice.call(arguments, 1));
		}

	} else {
		// clone options obj
		options = $.extend(true, {}, options);

		/*
		 * As Zepto doesn't support .data() method for objects
		 * and it works only in normal browsers
		 * we assign "options" object directly to the DOM element. FTW!
		 */
		if(_isJQ) {
			jqEl.data('magnificPopup', options);
		} else {
			jqEl[0].magnificPopup = options;
		}

		mfp.addGroup(jqEl, options);

	}
	return jqEl;
};


//Quick benchmark
/*
var start = performance.now(),
	i,
	rounds = 1000;

for(i = 0; i < rounds; i++) {

}
console.log('Test #1:', performance.now() - start);

start = performance.now();
for(i = 0; i < rounds; i++) {

}
console.log('Test #2:', performance.now() - start);
*/


/*>>core*/

/*>>inline*/

var INLINE_NS = 'inline',
	_hiddenClass,
	_inlinePlaceholder,
	_lastInlineElement,
	_putInlineElementsBack = function() {
		if(_lastInlineElement) {
			_inlinePlaceholder.after( _lastInlineElement.addClass(_hiddenClass) ).detach();
			_lastInlineElement = null;
		}
	};

$.magnificPopup.registerModule(INLINE_NS, {
	options: {
		hiddenClass: 'hide', // will be appended with `mfp-` prefix
		markup: '',
		tNotFound: 'Content not found'
	},
	proto: {

		initInline: function() {
			mfp.types.push(INLINE_NS);

			_mfpOn(CLOSE_EVENT+'.'+INLINE_NS, function() {
				_putInlineElementsBack();
			});
		},

		getInline: function(item, template) {

			_putInlineElementsBack();

			if(item.src) {
				var inlineSt = mfp.st.inline,
					el = $(item.src);

				if(el.length) {

					// If target element has parent - we replace it with placeholder and put it back after popup is closed
					var parent = el[0].parentNode;
					if(parent && parent.tagName) {
						if(!_inlinePlaceholder) {
							_hiddenClass = inlineSt.hiddenClass;
							_inlinePlaceholder = _getEl(_hiddenClass);
							_hiddenClass = 'mfp-'+_hiddenClass;
						}
						// replace target inline element with placeholder
						_lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
					}

					mfp.updateStatus('ready');
				} else {
					mfp.updateStatus('error', inlineSt.tNotFound);
					el = $('<div>');
				}

				item.inlineElement = el;
				return el;
			}

			mfp.updateStatus('ready');
			mfp._parseMarkup(template, {}, item);
			return template;
		}
	}
});

/*>>inline*/

/*>>ajax*/
var AJAX_NS = 'ajax',
	_ajaxCur,
	_removeAjaxCursor = function() {
		if(_ajaxCur) {
			_body.removeClass(_ajaxCur);
		}
	},
	_destroyAjaxRequest = function() {
		_removeAjaxCursor();
		if(mfp.req) {
			mfp.req.abort();
		}
	};

$.magnificPopup.registerModule(AJAX_NS, {

	options: {
		settings: null,
		cursor: 'mfp-ajax-cur',
		tError: '<a href="%url%">The content</a> could not be loaded.'
	},

	proto: {
		initAjax: function() {
			mfp.types.push(AJAX_NS);
			_ajaxCur = mfp.st.ajax.cursor;

			_mfpOn(CLOSE_EVENT+'.'+AJAX_NS, _destroyAjaxRequest);
			_mfpOn('BeforeChange.' + AJAX_NS, _destroyAjaxRequest);
		},
		getAjax: function(item) {

			if(_ajaxCur)
				_body.addClass(_ajaxCur);

			mfp.updateStatus('loading');

			var opts = $.extend({
				url: item.src,
				success: function(data, textStatus, jqXHR) {
					var temp = {
						data:data,
						xhr:jqXHR
					};

					_mfpTrigger('ParseAjax', temp);

					mfp.appendContent( $(temp.data), AJAX_NS );

					item.finished = true;

					_removeAjaxCursor();

					mfp._setFocus();

					setTimeout(function() {
						mfp.wrap.addClass(READY_CLASS);
					}, 16);

					mfp.updateStatus('ready');

					_mfpTrigger('AjaxContentAdded');
				},
				error: function() {
					_removeAjaxCursor();
					item.finished = item.loadError = true;
					mfp.updateStatus('error', mfp.st.ajax.tError.replace('%url%', item.src));
				}
			}, mfp.st.ajax.settings);

			mfp.req = $.ajax(opts);

			return '';
		}
	}
});







/*>>ajax*/

/*>>image*/
var _imgInterval,
	_getTitle = function(item) {
		if(item.data && item.data.title !== undefined)
			return item.data.title;

		var src = mfp.st.image.titleSrc;

		if(src) {
			if($.isFunction(src)) {
				return src.call(mfp, item);
			} else if(item.el) {
				return item.el.attr(src) || '';
			}
		}
		return '';
	};

$.magnificPopup.registerModule('image', {

	options: {
		markup: '<div class="mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<figure>'+
						'<div class="mfp-img"></div>'+
						'<figcaption>'+
							'<div class="mfp-bottom-bar">'+
								'<div class="mfp-title"></div>'+
								'<div class="mfp-counter"></div>'+
							'</div>'+
						'</figcaption>'+
					'</figure>'+
				'</div>',
		cursor: 'mfp-zoom-out-cur',
		titleSrc: 'title',
		verticalFit: true,
		tError: '<a href="%url%">The image</a> could not be loaded.'
	},

	proto: {
		initImage: function() {
			var imgSt = mfp.st.image,
				ns = '.image';

			mfp.types.push('image');

			_mfpOn(OPEN_EVENT+ns, function() {
				if(mfp.currItem.type === 'image' && imgSt.cursor) {
					_body.addClass(imgSt.cursor);
				}
			});

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(imgSt.cursor) {
					_body.removeClass(imgSt.cursor);
				}
				_window.off('resize' + EVENT_NS);
			});

			_mfpOn('Resize'+ns, mfp.resizeImage);
			if(mfp.isLowIE) {
				_mfpOn('AfterChange', mfp.resizeImage);
			}
		},
		resizeImage: function() {
			var item = mfp.currItem;
			if(!item || !item.img) return;

			if(mfp.st.image.verticalFit) {
				var decr = 0;
				// fix box-sizing in ie7/8
				if(mfp.isLowIE) {
					decr = parseInt(item.img.css('padding-top'), 10) + parseInt(item.img.css('padding-bottom'),10);
				}
				item.img.css('max-height', mfp.wH-decr);
			}
		},
		_onImageHasSize: function(item) {
			if(item.img) {

				item.hasSize = true;

				if(_imgInterval) {
					clearInterval(_imgInterval);
				}

				item.isCheckingImgSize = false;

				_mfpTrigger('ImageHasSize', item);

				if(item.imgHidden) {
					if(mfp.content)
						mfp.content.removeClass('mfp-loading');

					item.imgHidden = false;
				}

			}
		},

		/**
		 * Function that loops until the image has size to display elements that rely on it asap
		 */
		findImageSize: function(item) {

			var counter = 0,
				img = item.img[0],
				mfpSetInterval = function(delay) {

					if(_imgInterval) {
						clearInterval(_imgInterval);
					}
					// decelerating interval that checks for size of an image
					_imgInterval = setInterval(function() {
						if(img.naturalWidth > 0) {
							mfp._onImageHasSize(item);
							return;
						}

						if(counter > 200) {
							clearInterval(_imgInterval);
						}

						counter++;
						if(counter === 3) {
							mfpSetInterval(10);
						} else if(counter === 40) {
							mfpSetInterval(50);
						} else if(counter === 100) {
							mfpSetInterval(500);
						}
					}, delay);
				};

			mfpSetInterval(1);
		},

		getImage: function(item, template) {

			var guard = 0,

				// image load complete handler
				onLoadComplete = function() {
					if(item) {
						if (item.img[0].complete) {
							item.img.off('.mfploader');

							if(item === mfp.currItem){
								mfp._onImageHasSize(item);

								mfp.updateStatus('ready');
							}

							item.hasSize = true;
							item.loaded = true;

							_mfpTrigger('ImageLoadComplete');

						}
						else {
							// if image complete check fails 200 times (20 sec), we assume that there was an error.
							guard++;
							if(guard < 200) {
								setTimeout(onLoadComplete,100);
							} else {
								onLoadError();
							}
						}
					}
				},

				// image error handler
				onLoadError = function() {
					if(item) {
						item.img.off('.mfploader');
						if(item === mfp.currItem){
							mfp._onImageHasSize(item);
							mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
						}

						item.hasSize = true;
						item.loaded = true;
						item.loadError = true;
					}
				},
				imgSt = mfp.st.image;


			var el = template.find('.mfp-img');
			if(el.length) {
				var img = document.createElement('img');
				img.className = 'mfp-img';
				item.img = $(img).on('load.mfploader', onLoadComplete).on('error.mfploader', onLoadError);
				img.src = item.src;

				// without clone() "error" event is not firing when IMG is replaced by new IMG
				// TODO: find a way to avoid such cloning
				if(el.is('img')) {
					item.img = item.img.clone();
				}

				img = item.img[0];
				if(img.naturalWidth > 0) {
					item.hasSize = true;
				} else if(!img.width) {
					item.hasSize = false;
				}
			}

			mfp._parseMarkup(template, {
				title: _getTitle(item),
				img_replaceWith: item.img
			}, item);

			mfp.resizeImage();

			if(item.hasSize) {
				if(_imgInterval) clearInterval(_imgInterval);

				if(item.loadError) {
					template.addClass('mfp-loading');
					mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
				} else {
					template.removeClass('mfp-loading');
					mfp.updateStatus('ready');
				}
				return template;
			}

			mfp.updateStatus('loading');
			item.loading = true;

			if(!item.hasSize) {
				item.imgHidden = true;
				template.addClass('mfp-loading');
				mfp.findImageSize(item);
			}

			return template;
		}
	}
});



/*>>image*/

/*>>zoom*/
var hasMozTransform,
	getHasMozTransform = function() {
		if(hasMozTransform === undefined) {
			hasMozTransform = document.createElement('p').style.MozTransform !== undefined;
		}
		return hasMozTransform;
	};

$.magnificPopup.registerModule('zoom', {

	options: {
		enabled: false,
		easing: 'ease-in-out',
		duration: 300,
		opener: function(element) {
			return element.is('img') ? element : element.find('img');
		}
	},

	proto: {

		initZoom: function() {
			var zoomSt = mfp.st.zoom,
				ns = '.zoom',
				image;

			if(!zoomSt.enabled || !mfp.supportsTransition) {
				return;
			}

			var duration = zoomSt.duration,
				getElToAnimate = function(image) {
					var newImg = image.clone().removeAttr('style').removeAttr('class').addClass('mfp-animated-image'),
						transition = 'all '+(zoomSt.duration/1000)+'s ' + zoomSt.easing,
						cssObj = {
							position: 'fixed',
							zIndex: 9999,
							left: 0,
							top: 0,
							'-webkit-backface-visibility': 'hidden'
						},
						t = 'transition';

					cssObj['-webkit-'+t] = cssObj['-moz-'+t] = cssObj['-o-'+t] = cssObj[t] = transition;

					newImg.css(cssObj);
					return newImg;
				},
				showMainContent = function() {
					mfp.content.css('visibility', 'visible');
				},
				openTimeout,
				animatedImg;

			_mfpOn('BuildControls'+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);
					mfp.content.css('visibility', 'hidden');

					// Basically, all code below does is clones existing image, puts in on top of the current one and animated it

					image = mfp._getItemToZoom();

					if(!image) {
						showMainContent();
						return;
					}

					animatedImg = getElToAnimate(image);

					animatedImg.css( mfp._getOffset() );

					mfp.wrap.append(animatedImg);

					openTimeout = setTimeout(function() {
						animatedImg.css( mfp._getOffset( true ) );
						openTimeout = setTimeout(function() {

							showMainContent();

							setTimeout(function() {
								animatedImg.remove();
								image = animatedImg = null;
								_mfpTrigger('ZoomAnimationEnded');
							}, 16); // avoid blink when switching images

						}, duration); // this timeout equals animation duration

					}, 16); // by adding this timeout we avoid short glitch at the beginning of animation


					// Lots of timeouts...
				}
			});
			_mfpOn(BEFORE_CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);

					mfp.st.removalDelay = duration;

					if(!image) {
						image = mfp._getItemToZoom();
						if(!image) {
							return;
						}
						animatedImg = getElToAnimate(image);
					}


					animatedImg.css( mfp._getOffset(true) );
					mfp.wrap.append(animatedImg);
					mfp.content.css('visibility', 'hidden');

					setTimeout(function() {
						animatedImg.css( mfp._getOffset() );
					}, 16);
				}

			});

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {
					showMainContent();
					if(animatedImg) {
						animatedImg.remove();
					}
					image = null;
				}
			});
		},

		_allowZoom: function() {
			return mfp.currItem.type === 'image';
		},

		_getItemToZoom: function() {
			if(mfp.currItem.hasSize) {
				return mfp.currItem.img;
			} else {
				return false;
			}
		},

		// Get element postion relative to viewport
		_getOffset: function(isLarge) {
			var el;
			if(isLarge) {
				el = mfp.currItem.img;
			} else {
				el = mfp.st.zoom.opener(mfp.currItem.el || mfp.currItem);
			}

			var offset = el.offset();
			var paddingTop = parseInt(el.css('padding-top'),10);
			var paddingBottom = parseInt(el.css('padding-bottom'),10);
			offset.top -= ( $(window).scrollTop() - paddingTop );


			/*

			Animating left + top + width/height looks glitchy in Firefox, but perfect in Chrome. And vice-versa.

			 */
			var obj = {
				width: el.width(),
				// fix Zepto height+padding issue
				height: (_isJQ ? el.innerHeight() : el[0].offsetHeight) - paddingBottom - paddingTop
			};

			// I hate to do this, but there is no another option
			if( getHasMozTransform() ) {
				obj['-moz-transform'] = obj['transform'] = 'translate(' + offset.left + 'px,' + offset.top + 'px)';
			} else {
				obj.left = offset.left;
				obj.top = offset.top;
			}
			return obj;
		}

	}
});



/*>>zoom*/

/*>>iframe*/

var IFRAME_NS = 'iframe',
	_emptyPage = '//about:blank',

	_fixIframeBugs = function(isShowing) {
		if(mfp.currTemplate[IFRAME_NS]) {
			var el = mfp.currTemplate[IFRAME_NS].find('iframe');
			if(el.length) {
				// reset src after the popup is closed to avoid "video keeps playing after popup is closed" bug
				if(!isShowing) {
					el[0].src = _emptyPage;
				}

				// IE8 black screen bug fix
				if(mfp.isIE8) {
					el.css('display', isShowing ? 'block' : 'none');
				}
			}
		}
	};

$.magnificPopup.registerModule(IFRAME_NS, {

	options: {
		markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>'+
				'</div>',

		srcAction: 'iframe_src',

		// we don't care and support only one default type of URL by default
		patterns: {
			youtube: {
				index: 'youtube.com',
				id: 'v=',
				src: '//www.youtube.com/embed/%id%?autoplay=1'
			},
			vimeo: {
				index: 'vimeo.com/',
				id: '/',
				src: '//player.vimeo.com/video/%id%?autoplay=1'
			},
			gmaps: {
				index: '//maps.google.',
				src: '%id%&output=embed'
			}
		}
	},

	proto: {
		initIframe: function() {
			mfp.types.push(IFRAME_NS);

			_mfpOn('BeforeChange', function(e, prevType, newType) {
				if(prevType !== newType) {
					if(prevType === IFRAME_NS) {
						_fixIframeBugs(); // iframe if removed
					} else if(newType === IFRAME_NS) {
						_fixIframeBugs(true); // iframe is showing
					}
				}// else {
					// iframe source is switched, don't do anything
				//}
			});

			_mfpOn(CLOSE_EVENT + '.' + IFRAME_NS, function() {
				_fixIframeBugs();
			});
		},

		getIframe: function(item, template) {
			var embedSrc = item.src;
			var iframeSt = mfp.st.iframe;

			$.each(iframeSt.patterns, function() {
				if(embedSrc.indexOf( this.index ) > -1) {
					if(this.id) {
						if(typeof this.id === 'string') {
							embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
						} else {
							embedSrc = this.id.call( this, embedSrc );
						}
					}
					embedSrc = this.src.replace('%id%', embedSrc );
					return false; // break;
				}
			});

			var dataObj = {};
			if(iframeSt.srcAction) {
				dataObj[iframeSt.srcAction] = embedSrc;
			}
			mfp._parseMarkup(template, dataObj, item);

			mfp.updateStatus('ready');

			return template;
		}
	}
});



/*>>iframe*/

/*>>gallery*/
/**
 * Get looped index depending on number of slides
 */
var _getLoopedId = function(index) {
		var numSlides = mfp.items.length;
		if(index > numSlides - 1) {
			return index - numSlides;
		} else  if(index < 0) {
			return numSlides + index;
		}
		return index;
	},
	_replaceCurrTotal = function(text, curr, total) {
		return text.replace(/%curr%/gi, curr + 1).replace(/%total%/gi, total);
	};

$.magnificPopup.registerModule('gallery', {

	options: {
		enabled: false,
		arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
		preload: [0,2],
		navigateByImgClick: true,
		arrows: true,

		tPrev: 'Previous (Left arrow key)',
		tNext: 'Next (Right arrow key)',
		tCounter: '%curr% of %total%'
	},

	proto: {
		initGallery: function() {

			var gSt = mfp.st.gallery,
				ns = '.mfp-gallery',
				supportsFastClick = Boolean($.fn.mfpFastClick);

			mfp.direction = true; // true - next, false - prev

			if(!gSt || !gSt.enabled ) return false;

			_wrapClasses += ' mfp-gallery';

			_mfpOn(OPEN_EVENT+ns, function() {

				if(gSt.navigateByImgClick) {
					mfp.wrap.on('click'+ns, '.mfp-img', function() {
						if(mfp.items.length > 1) {
							mfp.next();
							return false;
						}
					});
				}

				_document.on('keydown'+ns, function(e) {
					if (e.keyCode === 37) {
						mfp.prev();
					} else if (e.keyCode === 39) {
						mfp.next();
					}
				});
			});

			_mfpOn('UpdateStatus'+ns, function(e, data) {
				if(data.text) {
					data.text = _replaceCurrTotal(data.text, mfp.currItem.index, mfp.items.length);
				}
			});

			_mfpOn(MARKUP_PARSE_EVENT+ns, function(e, element, values, item) {
				var l = mfp.items.length;
				values.counter = l > 1 ? _replaceCurrTotal(gSt.tCounter, item.index, l) : '';
			});

			_mfpOn('BuildControls' + ns, function() {
				if(mfp.items.length > 1 && gSt.arrows && !mfp.arrowLeft) {
					var markup = gSt.arrowMarkup,
						arrowLeft = mfp.arrowLeft = $( markup.replace(/%title%/gi, gSt.tPrev).replace(/%dir%/gi, 'left') ).addClass(PREVENT_CLOSE_CLASS),
						arrowRight = mfp.arrowRight = $( markup.replace(/%title%/gi, gSt.tNext).replace(/%dir%/gi, 'right') ).addClass(PREVENT_CLOSE_CLASS);

					var eName = supportsFastClick ? 'mfpFastClick' : 'click';
					arrowLeft[eName](function() {
						mfp.prev();
					});
					arrowRight[eName](function() {
						mfp.next();
					});

					// Polyfill for :before and :after (adds elements with classes mfp-a and mfp-b)
					if(mfp.isIE7) {
						_getEl('b', arrowLeft[0], false, true);
						_getEl('a', arrowLeft[0], false, true);
						_getEl('b', arrowRight[0], false, true);
						_getEl('a', arrowRight[0], false, true);
					}

					mfp.container.append(arrowLeft.add(arrowRight));
				}
			});

			_mfpOn(CHANGE_EVENT+ns, function() {
				if(mfp._preloadTimeout) clearTimeout(mfp._preloadTimeout);

				mfp._preloadTimeout = setTimeout(function() {
					mfp.preloadNearbyImages();
					mfp._preloadTimeout = null;
				}, 16);
			});


			_mfpOn(CLOSE_EVENT+ns, function() {
				_document.off(ns);
				mfp.wrap.off('click'+ns);

				if(mfp.arrowLeft && supportsFastClick) {
					mfp.arrowLeft.add(mfp.arrowRight).destroyMfpFastClick();
				}
				mfp.arrowRight = mfp.arrowLeft = null;
			});

		},
		next: function() {
			mfp.direction = true;
			mfp.index = _getLoopedId(mfp.index + 1);
			mfp.updateItemHTML();
		},
		prev: function() {
			mfp.direction = false;
			mfp.index = _getLoopedId(mfp.index - 1);
			mfp.updateItemHTML();
		},
		goTo: function(newIndex) {
			mfp.direction = (newIndex >= mfp.index);
			mfp.index = newIndex;
			mfp.updateItemHTML();
		},
		preloadNearbyImages: function() {
			var p = mfp.st.gallery.preload,
				preloadBefore = Math.min(p[0], mfp.items.length),
				preloadAfter = Math.min(p[1], mfp.items.length),
				i;

			for(i = 1; i <= (mfp.direction ? preloadAfter : preloadBefore); i++) {
				mfp._preloadItem(mfp.index+i);
			}
			for(i = 1; i <= (mfp.direction ? preloadBefore : preloadAfter); i++) {
				mfp._preloadItem(mfp.index-i);
			}
		},
		_preloadItem: function(index) {
			index = _getLoopedId(index);

			if(mfp.items[index].preloaded) {
				return;
			}

			var item = mfp.items[index];
			if(!item.parsed) {
				item = mfp.parseEl( index );
			}

			_mfpTrigger('LazyLoad', item);

			if(item.type === 'image') {
				item.img = $('<img class="mfp-img" />').on('load.mfploader', function() {
					item.hasSize = true;
				}).on('error.mfploader', function() {
					item.hasSize = true;
					item.loadError = true;
					_mfpTrigger('LazyLoadError', item);
				}).attr('src', item.src);
			}


			item.preloaded = true;
		}
	}
});

/*
Touch Support that might be implemented some day

addSwipeGesture: function() {
	var startX,
		moved,
		multipleTouches;

		return;

	var namespace = '.mfp',
		addEventNames = function(pref, down, move, up, cancel) {
			mfp._tStart = pref + down + namespace;
			mfp._tMove = pref + move + namespace;
			mfp._tEnd = pref + up + namespace;
			mfp._tCancel = pref + cancel + namespace;
		};

	if(window.navigator.msPointerEnabled) {
		addEventNames('MSPointer', 'Down', 'Move', 'Up', 'Cancel');
	} else if('ontouchstart' in window) {
		addEventNames('touch', 'start', 'move', 'end', 'cancel');
	} else {
		return;
	}
	_window.on(mfp._tStart, function(e) {
		var oE = e.originalEvent;
		multipleTouches = moved = false;
		startX = oE.pageX || oE.changedTouches[0].pageX;
	}).on(mfp._tMove, function(e) {
		if(e.originalEvent.touches.length > 1) {
			multipleTouches = e.originalEvent.touches.length;
		} else {
			//e.preventDefault();
			moved = true;
		}
	}).on(mfp._tEnd + ' ' + mfp._tCancel, function(e) {
		if(moved && !multipleTouches) {
			var oE = e.originalEvent,
				diff = startX - (oE.pageX || oE.changedTouches[0].pageX);

			if(diff > 20) {
				mfp.next();
			} else if(diff < -20) {
				mfp.prev();
			}
		}
	});
},
*/


/*>>gallery*/

/*>>retina*/

var RETINA_NS = 'retina';

$.magnificPopup.registerModule(RETINA_NS, {
	options: {
		replaceSrc: function(item) {
			return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
		},
		ratio: 1 // Function or number.  Set to 1 to disable.
	},
	proto: {
		initRetina: function() {
			if(window.devicePixelRatio > 1) {

				var st = mfp.st.retina,
					ratio = st.ratio;

				ratio = !isNaN(ratio) ? ratio : ratio();

				if(ratio > 1) {
					_mfpOn('ImageHasSize' + '.' + RETINA_NS, function(e, item) {
						item.img.css({
							'max-width': item.img[0].naturalWidth / ratio,
							'width': '100%'
						});
					});
					_mfpOn('ElementParse' + '.' + RETINA_NS, function(e, item) {
						item.src = st.replaceSrc(item, ratio);
					});
				}
			}

		}
	}
});

/*>>retina*/

/*>>fastclick*/
/**
 * FastClick event implementation. (removes 300ms delay on touch devices)
 * Based on https://developers.google.com/mobile/articles/fast_buttons
 *
 * You may use it outside the Magnific Popup by calling just:
 *
 * $('.your-el').mfpFastClick(function() {
 *     console.log('Clicked!');
 * });
 *
 * To unbind:
 * $('.your-el').destroyMfpFastClick();
 *
 *
 * Note that it's a very basic and simple implementation, it blocks ghost click on the same element where it was bound.
 * If you need something more advanced, use plugin by FT Labs https://github.com/ftlabs/fastclick
 *
 */

(function() {
	var ghostClickDelay = 1000,
		supportsTouch = 'ontouchstart' in window,
		unbindTouchMove = function() {
			_window.off('touchmove'+ns+' touchend'+ns);
		},
		eName = 'mfpFastClick',
		ns = '.'+eName;


	// As Zepto.js doesn't have an easy way to add custom events (like jQuery), so we implement it in this way
	$.fn.mfpFastClick = function(callback) {

		return $(this).each(function() {

			var elem = $(this),
				lock;

			if( supportsTouch ) {

				var timeout,
					startX,
					startY,
					pointerMoved,
					point,
					numPointers;

				elem.on('touchstart' + ns, function(e) {
					pointerMoved = false;
					numPointers = 1;

					point = e.originalEvent ? e.originalEvent.touches[0] : e.touches[0];
					startX = point.clientX;
					startY = point.clientY;

					_window.on('touchmove'+ns, function(e) {
						point = e.originalEvent ? e.originalEvent.touches : e.touches;
						numPointers = point.length;
						point = point[0];
						if (Math.abs(point.clientX - startX) > 10 ||
							Math.abs(point.clientY - startY) > 10) {
							pointerMoved = true;
							unbindTouchMove();
						}
					}).on('touchend'+ns, function(e) {
						unbindTouchMove();
						if(pointerMoved || numPointers > 1) {
							return;
						}
						lock = true;
						e.preventDefault();
						clearTimeout(timeout);
						timeout = setTimeout(function() {
							lock = false;
						}, ghostClickDelay);
						callback();
					});
				});

			}

			elem.on('click' + ns, function() {
				if(!lock) {
					callback();
				}
			});
		});
	};

	$.fn.destroyMfpFastClick = function() {
		$(this).off('touchstart' + ns + ' click' + ns);
		if(supportsTouch) _window.off('touchmove'+ns+' touchend'+ns);
	};
})();

/*>>fastclick*/
 _checkInstance(); })(window.jQuery || window.Zepto);