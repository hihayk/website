/* sample script here */


 function eraseCookieFromAllPaths(name) {
    // This function will attempt to remove a cookie from all paths.
    var pathBits = location.pathname.split('/');
    var pathCurrent = ' path=';

    // do a simple pathless delete first.
    document.cookie = name + '=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
	var x = document.cookie;
	console.log(x);

    for (var i = 0; i < pathBits.length; i++) {
        pathCurrent += ((pathCurrent.substr(-1) != '/') ? '/' : '') + pathBits[i];
		console.log(pathBits[i]);
        document.cookie = name + '=; expires=Thu, 01-Jan-70 00:00:01 GMT;' + pathCurrent + ';';
    }
}


jQuery("#jotFormLogout").live('click',function(){
 			 eraseCookieFromAllPaths('jotform.com');
});
 
// JF.initialize({ apiKey: 'd471b194e6de2b50facd59dd9b' })
  
jQuery(".jotFormLogin").live('click',function(){
 	event.preventDefault() ;
    JF.login(
        function success(){
           /* JF.getForms(function(response){
                for(var i=0; i<response.length; i++){
                    document.write( "<li> " + response[i].title);
                }
            });*/
			var apiKey = JF.getAPIKey();
			console.log(apiKey); 
			jQuery('#jc_api_key').val(apiKey);
			//jQuery('#jc_api_key').prop('disabled', true);
			jQuery('#dx-plugin-base-form').submit();
			 JF.getUser(function(response){
 				 console.log(response['email']);
					 for(var i=0; i<response.length; i++){
                   	console.log( "<li> " + response[i].title);
                	}
				});
			
			
        },

        function error(){
            window.alert("Could not authorize user");
        }
    ); 
});

jQuery(".cloneForm").live('click',function(){
	 $formID=	 jQuery(this).attr('id');
	 JF.cloneForm($formID, function(response){
     alert('Contact Form was created  Successfully' +  "\nTitle : " + response.title + "\n ID    : " + response.id); 
	 console.log(response);
	 location.reload();
	});
});

jQuery(document).ready(function($) {
	
	// Handle the AJAX field save action
	$('#dx-plugin-base-ajax-form').on('submit', function(e) {
		e.preventDefault();
		
		var ajax_field_value = $('#dx_option_from_ajax').val();
		
		 $.post(ajaxurl, {
			 	data: { 'dx_option_from_ajax': ajax_field_value },
		             action: 'store_ajax_value'
				 }, function(status) {
					 	 $('#dx_page_messages').html('Value updated successfully');
		           }
		);
	});
	
	// Handle the AJAX URL fetcher
	$('#dx-plugin-base-http-form').on('submit', function(e) {
		e.preventDefault();
		
		var ajax_field_value = $('#dx_url_for_ajax').val();
		
		 $.post(ajaxurl, {
			 	data: { 'dx_url_for_ajax': ajax_field_value },
		             action: 'fetch_ajax_url_http'
				 }, function(status) {
					 	 $('#dx_page_messages').html('The URL title is fetching in the frame below');
					 	 $('#resource-window').html( '<p>Site title: ' + status + '</p>');
		           }
		);
	});
	
	// Handle the Submission fetcher
	$('#submissions-filterx').on('submit', function(e) {
		e.preventDefault();
		
				$container =$('.ajax_response');
				var data = {
					action: 'fetch_submissions',
				};
				alert(ajaxurl);
				$loader='<div class="preloader"></div>';
				$.ajax(
				{
				//type: 'post',
				url: ajaxurl,
				data: data,
				beforeSend: function()
				{
					$container.append($loader);
				},
				success: function(data)
				{
					$container.append(data);
					$('.preloader').remove();
				},
				complete: function(xhr,status)
				{
					$('.preloader').remove();
				},
				error: function()
				{
					$container.append('Terjadi kesalahan, silahkan refresh browser anda');
				}
			});
		
	});
	
	/* $(".viewJotForm").click(function(){
		 alert('test');
		 var form_id=$(this).attr('id');
                    JotformAnywhere.launchBuilder({
                         insertTo: "#formViewer",
                         returnIframe: false,
                          openInModal: false                    
                    });
                });*/
				
	$("#embedJotform").click(function(){
  		 JotformAnywhere.launchBuilder({
                        insertTo: "#formViewer",
                        returnIframe: false,
                        openInModal: false
                    });
	 });
	
	$(".editJotForm").click(function(event){
        // var apiKey = JF.getAPIKey();
        // console.log(apiKey); //should log currently used API key
        // JF.initialize({ apiKey: JF.getAPIKey() });

		var form_id=$(this).attr('id');
		JotformAnywhere.editForm(form_id);
		event.preventDefault();
	});
	
/*	$(".cloneJotForm").click(function(){
		var form_id=$(this).attr('id');
		JotformAnywhere.editForm( form_id);
		event.preventDefault();
	});*/

	$(".deleteJotForm").click(function(){
		/*var form_id=$(this).attr('id');
		alert(form_id);
		JotformAnywhere.deleteForm( form_id);
		location.reload();*/
	});
	
	$(".viewJotForm").click(function(){
		
	});
 	
 
			
    // Subscribing to new form created event
    JotformAnywhere.subscribe("jotform.formCreated", function(response){
        // Close form builder
        removeElement("jotform_iframe_wrapper");
        removeElement("jotform_builder_mask");
    });

    // Subscribing to form updated event
    JotformAnywhere.subscribe("jotform.formUpdated", function(response){
        // Close form builder
        removeElement("jotform_iframe_wrapper");
        removeElement("jotform_builder_mask");
    });
	
					
	
});