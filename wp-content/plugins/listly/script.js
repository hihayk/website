jQuery(document).ready(function($)
{
	$('#ListlyAdminAuthStatus').click(function(e)
	{
		e.preventDefault();

		var Key = $(this).prev('input').val();
		var ElmMsg = $(this).next('span');

		ElmMsg.html('Loading...');

		$.post(ajaxurl, {'action': 'ListlyAJAXPublisherAuth', 'nounce': Listly.Nounce, 'Key': Key}, function(data)
		{
			ElmMsg.html(data);
		});
	});


	$('input[name="ListlyAdminListSearch"]').bind('keyup', function(event)
	{
		var ElmValue = $(this).val();
		var Container = $('#ListlyAdminYourList');
		var SearchType = $('input[name="ListlyAdminListSearchType"]:checked').val();

		if (ElmValue.length)
		{
			$('.ListlyAdminListSearchClear').show();
		}
		else
		{
			$('.ListlyAdminListSearchClear').hide();
		}

		if (ElmValue == '' && SearchType == 'publisher')
		{
			ListlyAdminYourList();
		}

		if (ElmValue.length > 2)
		{
			Container.html('<p>Loading...</p>');

			$.ajax
			({
				type: 'POST',
				url: Listly.SiteURL + 'autocomplete/list.json',
				data: {'term': ElmValue, 'key': Listly.Key, 'type': SearchType},
				jsonp: 'callback',
				//jsonpCallback: 'jsonCallback',
				contentType: 'application/json',
				dataType: 'jsonp',
				success: function(data)
				{
					if (data.status == 'ok')
					{
						Container.empty();

						if (jQuery.isEmptyObject(data.results))
						{
							Container.append('<p>No results found!</p>');
						}
						else
						{
							$(data.results).each(function(i)
							{
								Container.append('<p> <img class="avatar" src="'+data.results[i].user_image+'" alt="" /> <a class="ListlyAdminListEmbed" target="_new" href="http://list.ly/preview/'+data.results[i].list_id+'?key='+Listly.Key+'&source=wp_plugin" title="Get Short Code"><img src="'+Listly.PluginURL+'images/shortcode.png" alt="" /></a> <a class="strong" target="_blank" href="http://list.ly/'+data.results[i].list_id+'?source=wp_plugin" title="Go to List on List.ly">'+data.results[i].title+'</a> </p>');
							});
						}
					}
					else
					{
						Container.html(data.message);
					}
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					Container.html('<p>Error: '+errorThrown+'</p>');
				}
			});
		}
	});


	$('.ListlyAdminListSearchClear').click(function(e)
	{
		e.preventDefault();

		$('.ListlyAdminListSearchClear').hide();
		$('input[name="ListlyAdminListSearch"]').val('').focus();

		var SearchType = $('input[name="ListlyAdminListSearchType"]:checked').val();

		if (SearchType == 'publisher')
		{
			ListlyAdminYourList();
		}
	});


	$('input[name="ListlyAdminListSearchType"]').click(function(e)
	{
		$('input[name="ListlyAdminListSearch"]').trigger('keyup');
	});


	function ListlyAdminYourList()
	{
		window.clearTimeout(ListlyAdminYourListTimer)

		var Container = $('#ListlyAdminYourList');

		Container.html('<p>Loading...</p>');

		$.ajax
		({
			type: 'POST',
			url: Listly.SiteURL + 'publisher/lists',
			data: {'key': Listly.Key},
			jsonp: 'callback',
			//jsonpCallback: 'jsonCallback',
			contentType: 'application/json',
			dataType: 'jsonp',
			success: function(data)
			{
				if (data == '')
				{
					Container.html('<p>Connection error. Retrying in 1 minute...<a id="ListlyAdminYourListReload" href="#">try now</a></p>');

					var ListlyAdminYourListTimer = window.setTimeout(ListlyAdminYourList, 60000);
				}
				else if (data.status == 'ok')
				{
					Container.empty();

					if (jQuery.isEmptyObject(data.lists))
					{
						Container.append('<p>No lists found!</p>');
					}
					else
					{
						$(data.lists).each(function(i)
						{
							Container.append('<p> <img class="avatar" src="'+data.lists[i].user_image+'" alt="" /> <a class="ListlyAdminListEmbed" target="_new" href="http://list.ly/preview/'+data.lists[i].list_id+'?key='+Listly.Key+'&source=wp_plugin" title="Get Short Code"><img src="'+Listly.PluginURL+'images/shortcode.png" alt="" /></a> <a class="strong" target="_blank" href="http://list.ly/'+data.lists[i].list_id+'?source=wp_plugin" title="Go to List on List.ly">'+data.lists[i].title+'</a> </p>');
						});
					}
				}
				else if (data.message != '')
				{
					Container.html(data.message);
				}
				else
				{
					Container.html('<p>Connection error. Retrying in 1 minute...<a id="ListlyAdminYourListReload" href="#">try now</a></p>');

					var ListlyAdminYourListTimer = window.setTimeout(ListlyAdminYourList, 60000);
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				Container.html('<p>Connection error. Retrying in 1 minute...<a id="ListlyAdminYourListReload" href="#">try now</a></p>');

				var ListlyAdminYourListTimer = window.setTimeout(ListlyAdminYourList, 60000);
			}
		});
	}

	if ($('#ListlyAdminYourList').length)
	{
		var ListlyAdminYourListTimer;

		ListlyAdminYourList();

		$('#ListlyAdminYourList').on('click', '#ListlyAdminYourListReload', function(e)
		{
			e.preventDefault();

			ListlyAdminYourList();
		});
	}

});