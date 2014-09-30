/** http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/ **/
function getWindowDimensions(){
    var viewportwidth;
    var viewportheight;
     // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
    if (typeof window.innerWidth != 'undefined')
    {
        viewportwidth = window.innerWidth,
        viewportheight = window.innerHeight;
    }
    // IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
    else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth !== 0)
    {
        viewportwidth = document.documentElement.clientWidth,
        viewportheight = document.documentElement.clientHeight;
    }
     // older versions of IE
    else
    {
        viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
        viewportheight = document.getElementsByTagName('body')[0].clientHeight;
    }
    return {
        width: viewportwidth,
        height: viewportheight
    };
}
/** http://www.onlineaspect.com/2010/01/15/backwards-compatible-postmessage/ **/
// everything is wrapped in the XD function to reduce namespace collisions
var XD = function(){
    var interval_id,
    last_hash,
    cache_bust = 1,
    attached_callback,
    window = this;
    return {
        postMessage : function(message, target_url, target) {
            if (!target_url) {
                return;
            }
            target = target || parent;  // default to parent
            if (window['postMessage']) {
                // the browser supports window.postMessage, so call it with a targetOrigin
                // set appropriately, based on the target_url parameter.
                target['postMessage'](message, target_url.replace( /([^:]+:\/\/[^\/]+).*/, '$1'));
            } else if (target_url) {
                // the browser does not support window.postMessage, so use the window.location.hash fragment hack
                target.location = target_url.replace(/#.*$/, '') + '#' + (+new Date) + (cache_bust++) + '&' + message;
            }
        },
        receiveMessage : function(callback, source_origin) {
            // browser supports window.postMessage
            if (window['postMessage']) {
                // bind the callback to the actual event associated with window.postMessage
                if (callback) {
                    attached_callback = function(e) {
                        if ((typeof source_origin === 'string' && e.origin !== source_origin)
                        || (Object.prototype.toString.call(source_origin) === "[object Function]" && source_origin(e.origin) === !1)) {
                             return !1;
                         }
                         callback(e);
                     };
                 }
                 if (window['addEventListener']) {
                     window[callback ? 'addEventListener' : 'removeEventListener']('message', attached_callback, !1);
                 } else {
                     window[callback ? 'attachEvent' : 'detachEvent']('onmessage', attached_callback);
                 }
             } else {
                 // a polling loop is started & callback is called whenever the location.hash changes
                 interval_id && clearInterval(interval_id);
                 interval_id = null;
                 if (callback) {
                     interval_id = setInterval(function() {
                         var hash = document.location.hash,
                         re = /^#?\d+&/;
                         if (hash !== last_hash && re.test(hash)) {
                             last_hash = hash;
                             callback({data: hash.replace(re, '')});
                         }
                     }, 100);
                 }
             }
         }
    };
}();

/**  IE7 document.querySelectorAll method **/
/** http://www.codecouch.com/2012/05/adding-document-queryselectorall-support-to-ie-7/ **/
/*@cc_on if (!document.querySelector)
    (function(d, s) {
        d=document, s=d.createStyleSheet();
        d.querySelectorAll = function(r, c, i, j, a) {
            a=d.all, c=[], r = r.replace(/\[for\b/gi, '[htmlFor').split(',');
            for (i=r.length; i--;) {
                s.addRule(r[i], 'k:v');
                for (j=a.length; j--;) a[j].currentStyle.k && c.push(a[j]);
                s.removeRule(0);
            }
            return c;
        }
    })()
    @*/

function removeElement(EId)
{
    return(EObj=document.getElementById(EId))?EObj.parentNode.removeChild(EObj):false;
}

function getIframeWindow(iframe_object) {
  var doc;

  if (iframe_object.contentWindow) {
    return iframe_object.contentWindow;
  }

  if (iframe_object.window) {
    return iframe_object.window;
  } 

  if (!doc && iframe_object.contentDocument) {
    doc = iframe_object.contentDocument;
  } 

  if (!doc && iframe_object.document) {
    doc = iframe_object.document;
  }

  if (doc && doc.defaultView) {
   return doc.defaultView;
  }

  if (doc && doc.parentWindow) {
    return doc.parentWindow;
  }

  return undefined;
}

/** DO NOT FORGET TO CHANGE FOR LIVE TESTS **/
var _jotformURL = "http://www.jotform.com";
// var _jotformURL = "http://mustafa.jotform.pro";


/**
 * 
 */
var JotformAnywhere = (function(){

    var subscribeToken = -1;
    var subscriberIndex = {};
    var builderFrameHeight = 600;
    var builderFrameWidth = 914;
    var root = {};

    root.formBuilderBarColor = "#FC7C03";
    root.primaryButtonColor = "#139045";
    root.primaryButtonHoverColor = "#16a24e";

    root.customize = function(options){
        if(options.formBuilderBarColor!==undefined || options.formBuilderBarColor!==null){
            root.formBuilderBarColor = options.formBuilderBarColor;
        }

        if(options.primaryButtonColor!==undefined || options.primaryButtonColor!==null){
            root.primaryButtonColor = options.primaryButtonColor;
        }

        if(options.primaryButtonHoverColor!==undefined || options.primaryButtonHoverColor!==null){
            root.primaryButtonHoverColor = options.primaryButtonHoverColor;
        }
    }

    root.createInstantForm = function(options){
        if(options.email===undefined){
            console.error("JotFormAnywhere cannot be initialized without email");
            return;
        }
        if(options.templateName===undefined){
            console.error("JotFormAnywhere cannot be initialized without template name");
            return;
        }
        var frameSrc = _jotformURL+"/api/anywhere/embed_builder.php";

        var frame = document.createElement('IFRAME');
        frame.setAttribute("src", frameSrc+"?ref="+encodeURIComponent(document.location.href)+"&email="+encodeURIComponent(options.email)+"&slug="+encodeURIComponent(options.templateName));
        frame.setAttribute("id", "jotform_builder_frame");
        frame.setAttribute("scrolling", "no");

        //insert template iframe in jotform_iframe_container
        var iframeContainer = document.createElement("div");
        iframeContainer.setAttribute("id", "jotform_iframe_wrapper");
        iframeContainer.style.display = "none";

        iframeContainer.appendChild(frame);
        document.body.appendChild(iframeContainer);
    };

    root.launchFormBuilder = root.launchBuilder = function(options){

        var formID = options.formID;   //if given, builder is opened with formID ?formID=
        var insertTo = options.insertTo;   //if given, iframe is appended into document.querySelector(insertTo) else iframe is appended to body
        var returnIframe = options.returnIframe || false;   //if true Jotform iframe is not rendered by SDK instead returns builded iframe DOM object
        var openInModal = options.openInModal || true;     //if true SDK opens buider frame in modalBox, notice that if true insertTo option has no effect
        var builderMaskColor = options.builderMaskColor || "#000000";

        this.builderOptions = options;

        var frameSrc = _jotformURL+"/api/anywhere/embed_builder.php";

        if(formID!==undefined) {
            frameSrc = frameSrc + "?formID=" + formID;
        }
        
        //builder iframe
        var frame = document.createElement('IFRAME');

        //remove '#' character at last because it cause problem on fullscreen parameter
        var ref = document.location.href;
        if(ref[ref.length-1]=='#'){
            ref = ref.substr(0,ref.length-1);
        }
        frame.setAttribute("src", frameSrc+"?ref="+encodeURIComponent(ref)+"&fbbc="+encodeURIComponent(root.formBuilderBarColor)+"&pbc="+encodeURIComponent(root.primaryButtonColor)+"&pbhc="+encodeURIComponent(root.primaryButtonHoverColor));
        frame.setAttribute("id", "jotform_builder_frame");
        frame.setAttribute("scrolling", "no");

        frame.style.width = builderFrameWidth+"px";
        frame.style.height = builderFrameHeight+"px";
        frame.style.backgroundColor = "white";
        frame.style.border = "0 none";

        if(!returnIframe){
            if(!openInModal){
                var container = insertTo ? document.querySelectorAll(insertTo)[0]:document.body;
                container.appendChild(frame);
                return;
            } else {

                var container = document.body;
                var innerHeight = getWindowDimensions().height;
                var innerWidth = getWindowDimensions().width;

                //create and append dimmer
                var dimmer = document.createElement("div");
                dimmer.setAttribute("id", "jotform_builder_mask");
                dimmer.style.position = "fixed";
                dimmer.style.width= "100%";
                dimmer.style.height = "100%";
                dimmer.style.top = "0";
                dimmer.style.left = "0";
                dimmer.style.zIndex = "2300";
                dimmer.style.opacity = "0.7";
                dimmer.style.filter = "alpha(opacity=70)";
                dimmer.style.background = builderMaskColor;
                container.appendChild(dimmer);

                //insert template iframe in jotform_iframe_container
                var iframeContainer = document.createElement("div");
                iframeContainer.setAttribute("id", "jotform_iframe_wrapper");
                iframeContainer.style.zIndex = "2301";
                iframeContainer.style.position = "fixed";
                iframeContainer.style.top =  (innerHeight-builderFrameHeight)/4+"px";
                iframeContainer.style.left = (innerWidth-builderFrameWidth)/2+"px";

                var closeButton = document.createElement("img");
                closeButton.src = _jotformURL+"/images/embed_builder_close.png";
                closeButton.style.position = "absolute";
                closeButton.style.right = "-15px";
                closeButton.style.top = "-15px";

                closeButton.onclick = function(){
                    removeElement("jotform_iframe_wrapper");
                    removeElement("jotform_builder_mask");
                };

                iframeContainer.appendChild(closeButton);

                iframeContainer.appendChild(frame);
                container.appendChild(iframeContainer);

                return;

            }
        } else {
            return frame;
        }
    };

    root.publish = function () {

        //type of event is the first argument
        var type = arguments[0];
        //rest of arguments will be used as arguments for handler execution
        var args = [].slice.call(arguments, 1);

        if (!subscriberIndex[type]) {
            return false;
        }

        var subscribers = subscriberIndex[type];

        var len = subscribers ? subscribers.length : 0;

        while (len--) {
            subscribers[len].func(args[0]);
        }

    };

    root.subscribe = function (type, handler) {
        if (!subscriberIndex[type]) {
            subscriberIndex[type] = [];
        }

        var token = (++subscribeToken).toString();

        subscriberIndex[type].push({
            func:handler,
            token:token
        });

        return token;
    };

    root.unsubscribe = function (token) {
        for (var type in subscriberIndex) {
            var subscribers = subscriberIndex[type];
            for (var i = 0; i<subscribers.length; i++) {
                var subscriber = subscribers[i];

                if (token === subscriber.token) {
                    subscribers.splice(i, 1);
                    return token;
                }
            }
        }
        return this;
    };

    root.insertForm = function(options){

        removeElement("jotform_iframe_wrapper");
        if(document.getElementById("jotform_builder_mask")!==null){
            removeElement("jotform_builder_mask");
        }

        var formID;
        if(options.formID===undefined){
            console.error("Form ID is undefined at insertForm method");
            return;
        } else {
            formID = options.formID;
        }

        var embedURL;
        if(options.formEmbedUrl===undefined){
            console.error("Form embed URL is undefined at insertForm method");
            return;
        } else {
            embedURL = options.formEmbedUrl;
        }

        //var editMode = options.editMode===undefined ? true : options.editMode;

        var putEditButton = options.putEditButton===undefined ? true : options.putEditButton;
        var putDeleteButton = options.putDeleteButton===undefined ? true : options.putDeleteButton;

        var formContainer = document.body;
        if(options.insertTo!==undefined){
            formContainer = document.querySelectorAll(options.insertTo)[0];
        }

        //this container is used as appendTo argument for jsform URL
        var jotformFormContainer = document.createElement("div");
        jotformFormContainer.setAttribute("id", "jotform_form_container_"+formID);
        if(options.width!==undefined) jotformFormContainer.style.width = options.width+"px";
        jotformFormContainer.setAttribute("class","jotform-form-container");

        editMode = (putEditButton || putDeleteButton);
        if(editMode){
            var css = '.jotform-form-container{position:relative;}'+
            '.jotform-form-container iframe {z-index: 0;} '+
            '.jotform-form-container-mask {display:none;} ' +
            '.jotform-form-container:hover .jotform-form-container-mask{display:block;} ' +
            '.form-edit-button{'+
                'padding:6px 39px 6px;'+
                'font-size: 18px;'+
                'line-height: 25px;'+
                'position: absolute;'+
                'top: 45%;'+
                'left: 23%;'+
                'font-weight: bold;'+
                'color:#fff;'+
                'border:1px solid #398db9;'+
                'text-shadow: 0 1px 0 #0a7ab4;'+
                '-moz-box-shadow: 0 1px 0 rgba(255,255,255,0.25) inset;'+
                '-webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.25) inset;'+
                'box-shadow: 0 1px 0 rgba(255,255,255,0.25) inset;'+
                '-moz-border-radius:3px;'+
                '-webkit-border-radius:3px;'+
                'border-radius:3px;'+
                'background: #57afdd;'+
                'background: -moz-linear-gradient(top,  #57afdd 0%, #4195c1 100%);'+
                'background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#57afdd), color-stop(100%,#4195c1)); /* Chrome,Safari4+ */'+
                'background: -webkit-linear-gradient(top,  #57afdd 0%,#4195c1 100%); /* Chrome10+,Safari5.1+ */'+
                'background: -o-linear-gradient(top,  #57afdd 0%,#4195c1 100%); /* Opera 11.10+ */'+
                'background: -ms-linear-gradient(top,  #57afdd 0%,#4195c1 100%); /* IE10+ */'+
                'background: linear-gradient(to bottom,  #57afdd 0%,#4195c1 100%); /* W3C */'+
                'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#57afdd", endColorstr="#4195c1",GradientType=0 ); /* IE6-9 */'+
            '} '+
            '.form-delete-button{'+
                'padding:6px 39px 6px;'+
                'font-size: 18px;'+
                'line-height: 25px;'+
                'position: absolute;'+
                'top: 45%;'+
                'left: 50%;'+
                'font-weight: bold;'+
                'color:#fff;'+
                'border:1px solid #398db9;'+
                'text-shadow: 0 1px 0 #0a7ab4;'+
                '-moz-box-shadow: 0 1px 0 rgba(255,255,255,0.25) inset;'+
                '-webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.25) inset;'+
                'box-shadow: 0 1px 0 rgba(255,255,255,0.25) inset;'+
                '-moz-border-radius:3px;'+
                '-webkit-border-radius:3px;'+
                'border-radius:3px;'+
                'background: #57afdd;'+
                'background: -moz-linear-gradient(top,  #57afdd 0%, #4195c1 100%);'+
                'background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#57afdd), color-stop(100%,#4195c1)); /* Chrome,Safari4+ */'+
                'background: -webkit-linear-gradient(top,  #57afdd 0%,#4195c1 100%); /* Chrome10+,Safari5.1+ */'+
                'background: -o-linear-gradient(top,  #57afdd 0%,#4195c1 100%); /* Opera 11.10+ */'+
                'background: -ms-linear-gradient(top,  #57afdd 0%,#4195c1 100%); /* IE10+ */'+
                'background: linear-gradient(to bottom,  #57afdd 0%,#4195c1 100%); /* W3C */'+
                'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#57afdd", endColorstr="#4195c1",GradientType=0 ); /* IE6-9 */'+
            '} ';

            var style=document.createElement("style");
            style.type="text/css";
            style.appendChild(document.createTextNode(css));
            jotformFormContainer.appendChild(style);

            jotformFormContainer.style.position = "relative";

            var jotformContainerMask = document.createElement("div");
            jotformContainerMask.setAttribute("class", "jotform-form-container-mask");

            jotformContainerMask.style.background = "black";
            jotformContainerMask.style.opacity = "0.7";
            jotformContainerMask.style.position = "absolute";
            jotformContainerMask.style.top = "0";
            jotformContainerMask.style.left = "0";
            jotformContainerMask.style.width = "100%";
            jotformContainerMask.style.height = "100%";

            jotformFormContainer.appendChild(jotformContainerMask);
            
            if(putEditButton){

                var editButton = document.createElement("button");
                editButton.setAttribute("class", "form-edit-button");
                editButton.setAttribute("id", "jotform_edit_form_"+formID);
                editButton.textContent = "Edit"+"\r\n"+"Form";

                jotformContainerMask.appendChild(editButton);

                editButton.onclick = function(){
                    root.launchBuilder({
                        formID: formID,
                        openInModal: true,
                        insertTo: "#content",
                        returnIframe: false
                    });
                };
            }

            if(putDeleteButton){
                var deleteButton = document.createElement("button");
                deleteButton.setAttribute("class", "form-delete-button");
                deleteButton.setAttribute("id", "jotform_delete_form_"+formID);
                deleteButton.textContent = "Delete"+"\r\n"+"Form";
                jotformContainerMask.appendChild(deleteButton);

                deleteButton.onclick = function(){
                    removeElement("jotform_form_container_"+formID);
                    removeElement("jotform_delete_form_"+formID);
                    removeElement("jotform_edit_form_"+formID);

                    root.publish("jotform.formDeleted", {formID: formID});

                    var scripts = document.querySelectorAll("script");
                    for(var i=0; i<scripts.length; i++){
                        if(scripts[i].src.match(/jsform/)!==null){
                            var sc=scripts[i];
                            sc.parentNode.removeChild(sc);
                        }
                    }
                };
            }
        }

        formContainer.appendChild(jotformFormContainer);

        var jsFormEmbedUrl = embedURL;
        var formScript = document.createElement("script");
        formScript.type = "text/javascript";
        formScript.src  = jsFormEmbedUrl+"?appendTo=jotform_form_container_"+formID;
        formScript.id = "jffb_"+formID;
        
        //insert jsform script
        formContainer.appendChild(formScript);

        //wait for a little time and check if jotform iframe loaded
        var frameLoadInterval = setInterval(function(){
            var formIf = document.getElementById(""+formID);
            if(formIf!==null && formIf!==undefined){

                clearInterval(frameLoadInterval);
                formIf.onload = function(){
                    root.publish("jotform.formLoaded", {
                        formID: formID
                    });
                }
            }
        }, 500);

    };

    root.editForm = function(formID){
        if(formID===undefined || formID===null){
            console.error("form id cannot be empty");
            return;
        }

        this.launchBuilder({
            formID: formID,
            openInModal: true,
            insertTo: "#content",
            returnIframe: false
        });
    }

    root.deleteForm = function(formID){
        if(formID===undefined || formID===null){
            console.error("form id cannot be empty");
            return;
        }

        removeElement("jotform_form_container_"+formID);
        removeElement("jotform_delete_form_"+formID);
        removeElement("jotform_edit_form_"+formID);

        root.publish("jotform.formDeleted", {formID: formID});

        var scripts = document.querySelectorAll("script");
        for(var i=0; i<scripts.length; i++){
            if(scripts[i].src.match(/jsform/)!==null){
                var sc=scripts[i];
                sc.parentNode.removeChild(sc);
            }
        }
    }

    //subscribe to formUpdated event by default
    root.subscribe("jotform.formUpdated", function(response){

        //remove already inserted iframe
        removeElement(response.formID);
        var scripts = document.querySelectorAll("script");
        for(var i=0; i<scripts.length; i++){
            if(scripts[i].src.match(/jsform/)!==null){
                var sc=scripts[i];
                sc.parentNode.removeChild(sc);
            }
        }

        var formContainer = document.getElementById("jotform_form_container_"+response.formID);
        //insert new script
        var formScript = document.createElement("script");
        formScript.type = "text/javascript";
        formScript.src  = response.formEmbedUrl+"?appendTo=jotform_form_container_"+response.formID;
        
        //insert new iframe
        formContainer.appendChild(formScript);

        //wait for a little time and check if jotform iframe loaded
        var frameLoadInterval = setInterval(function(){
            var formIf = document.getElementById(""+response.formID);
            if(formIf!==null && formIf!==undefined){

                clearInterval(frameLoadInterval);
                formIf.onload = function(){
                    root.publish("jotform.formLoaded", {
                        formID: response.formID
                    });
                }
            }
        }, 500);

        //remove builder frame opened for edit
        removeElement("jotform_iframe_wrapper");
        if(document.getElementById("jotform_builder_mask")!==null){
            removeElement("jotform_builder_mask");
        }


    });
    return root;
}());


XD.receiveMessage(function(message){

    //i dont know why but there happens a meesage including setHeight
    if(message.data.match(/setHeight/i)){
        return;
    }

    var op = JSON.parse(message.data);

    if(op.opType==="create"){
        JotformAnywhere.publish("jotform.formCreated", op);
    } else if(op.opType==="update"){
        JotformAnywhere.publish("jotform.formUpdated", op);
    }

}, _jotformURL);



