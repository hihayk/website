jQuery(document).ready(function($){

    $(".successMessage").hide();

    $("#contactForm").validate({
        messages:{
            name:{
                required:"&nbsp;"+nzs_contact_vars.nzs_required_name+"&nbsp;",
             },

            email:{
                required:"&nbsp;"+nzs_contact_vars.nzs_required_email+"&nbsp;",
                email:"&nbsp;"+nzs_contact_vars.nzs_valid_email+"&nbsp;",
            },
            message:{
                required:"&nbsp;"+nzs_contact_vars.nzs_required_message+"&nbsp;",
            }

        },
        submitHandler: function (form) {
            var str = jQuery(form).serialize();
            jQuery.ajax({
                type:"POST",
                url: jQuery("#contactForm").attr('action'),
                data: 'action=contact_form&'+str,
                success: function(msg) {
                    jQuery(".successMessage").ajaxComplete(function(event, request, settings){
                            if(msg) {

                                jQuery(".contact-area .successMessage").html(msg);

                                $("#contactForm").hide(0, function () {

                                    $(".successMessage").css("text-indent", 0).fadeIn("slow").delay(2E3).fadeOut("slow", function () {
                                        $("#contactForm").find("input[type=text], textarea").val("");
                                        $("#contactForm").fadeIn("slow");
                                        $("#contactForm input[name='email']").val("")
                                    });

                                 });

                            }
                    });

                    }
            });
            

        }
    });
    

});