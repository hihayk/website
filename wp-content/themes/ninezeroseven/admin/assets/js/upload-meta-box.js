jQuery(document).ready(function () {

    jQuery('#image-holder').sortable({
        placeholder: "highlight-place",
        containment: "#image-holder",
        tolerance: "pointer"
    });

    if(jQuery('#nzs_video_bg_enable').attr('checked')){


        jQuery('#nzs_parallax_bg_image,.nzs_parallax_repeat,.nzs_parallax_speed').parents('tr').hide();

        
    }else{

        jQuery('#nzs_video_bg_path_webm,#nzs_video_bg_path_mp4,#nzs_video_bg_path_ogv,#nzs_video_poster_image').parents('tr').hide();
    }

    jQuery('#nzs_video_bg_enable').click(function() {
       if(jQuery(this).is(":checked")) {

          jQuery('#nzs_parallax_bg_image,.nzs_parallax_repeat,.nzs_parallax_speed').parents('tr').hide();
          jQuery('#nzs_video_bg_path_webm,#nzs_video_bg_path_mp4,#nzs_video_bg_path_ogv,#nzs_video_poster_image').parents('tr').show();
          
          return;
       }



       jQuery('#nzs_video_bg_path_webm,#nzs_video_bg_path_mp4,#nzs_video_bg_path_ogv,#nzs_video_poster_image').parents('tr').hide();
       jQuery('#nzs_parallax_bg_image,.nzs_parallax_repeat,.nzs_parallax_speed').parents('tr').show();


    });

    var section = jQuery('#nzs_portfolio_type').val();

    if('image' === section){
        jQuery('tr#nzs_video_link').hide();
    }else if('video' === section){
        jQuery('tr#nzs_image_fields').hide();
    }

    jQuery('#nzs_portfolio_type').change(function(){
        var sectiond = jQuery('#nzs_portfolio_type').val();

        if('image' === sectiond){
            jQuery('tr#nzs_video_link').hide();
            jQuery('tr#nzs_image_fields').show();
        }else if('video' === sectiond){
            jQuery('tr#nzs_image_fields').hide();
            jQuery('tr#nzs_video_link').show();
        }

    });


    jQuery('#nzs_section_bg_image_button, #nzs_parallax_bg_image_button').click(function () {

        window.send_to_editor = function (html) {
            imgurl = jQuery('img', html).attr('src');
            jQuery('#nzs_section_bg_image , #nzs_parallax_bg_image,#nzs_video_poster_image').val(imgurl);


            tb_remove();
        }


        tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
        return false;

    });


    jQuery('#nzs_parallax_bg_video_button').click(function () {

        window.send_to_editor = function (html) {
            imgurl = jQuery('img', html).attr('src');
            jQuery('#nzs_video_poster_image').val(imgurl);


            tb_remove();
        }


        tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
        return false;

    });


    jQuery('#image-holder a').live('click',function(event){

        event.preventDefault();
        jQuery(this).parent().remove();

        return false;

    });



     jQuery('#nzs_portfolio_gallery, #nzs_post_slider').click(function (e) {

        var gallery_attach_images;
 
        e.preventDefault();
 
        if (gallery_attach_images) {
            gallery_attach_images.open();
            return;
        }
 
        gallery_attach_images = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image(s)',
            button: {
                text: 'Insert Image(s)'
            },
            multiple: true
        });

        gallery_attach_images.on( 'select', function() {
         
        var selection = gallery_attach_images.state().get('selection');
         
            selection.map( function( attachment ) {
             
            attachment = attachment.toJSON();


            var thumbType = attachment.url.match(/\.(jpg|jpeg|png|gif)$/i);


            if(thumbType){

            var thumbNail = attachment.url.replace(thumbType[0],'-150x150'+thumbType[0]);

            jQuery('#image-holder').append('<li><input type="hidden" name="nzs_image_fields[]" value="'+attachment.id+'" /><img style="padding:3px;background-color:#fff;box-shadow:1px 1px 3px #d8d8d8;" width="150" height="150" class="thumbnail" src="'+thumbNail+'" /><br/><a href="#" class="remove-image">remove</a></li>');

            }
             
            });
        });

        gallery_attach_images.open();

     });

    

});