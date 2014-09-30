/* jQuery tubular plugin
|* by Sean McCambridge
|* http://www.seanmccambridge.com/tubular
|* version: 1.0
|* updated: October 1, 2012
|* since 2010
|* licensed under the MIT License
|* Enjoy.
|* 
|* Thanks,
|* Sean */


;(function ($, window) {

    // test for feature support and return if failure
    
    // defaults
    var defaults = {
        ratio: 16/9, // usually either 4/3 or 16/9 -- tweak as needed
        width: $(window).width(),
        wrapperZIndex: 99,
        repeat:0,
        volumeDefault:20,
        playButtonClass: 'tubular-play',
        pauseButtonClass: 'tubular-pause',
        muteButtonClass: 'tubular-mute',
        volumeUpClass: 'tubular-volume-up',
        volumeDownClass: 'tubular-volume-down'
    };

    // methods

    var tubular = function(node, options) { // should be called on the wrapper div
        var options = $.extend({}, defaults, options),
            $body = $('#full-youtube-video-container') // cache body node
            $node = $(node); // cache wrapper node


        // build container
        var tubularContainer = '<div id="tubular-container" style="opacity:0;overflow: hidden; position: relative; z-index: 1; width: 100%; height: 100%"><iframe id="tubular-player" style="position:absolute;" src="http://player.vimeo.com/video/'+options.videoId+'?title=0&byline=0&portrait=0&api=1&player_id=tubular-player&loop='+options.repeat+'" width="400" height="225" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div><div id="tubular-shield" style="width: 100%; height: 100%; z-index: 2; position: absolute; left: 0; top: 0;"></div>';

        // set up css prereq's, inject tubular container and set up wrapper defaults
        $('html,body').css({'width': '100%', 'height': '100%'});
        $body.prepend(tubularContainer);
        $node.css({position: 'relative', 'z-index': options.wrapperZIndex});

        var iframe = $('#tubular-player')[0],
            player = $f(iframe),
            status = $('.status'),
            currentVolume = options.volumeDefault,
            isMuted = false,
            isPaused= false;

        // When the player is ready, add listeners for pause, finish, and playProgress
        player.addEvent('ready', function() {

            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent))return;
            
            resize();
            
            player.addEvent('pause', onPause);
            player.addEvent('finish', onFinish);
            player.addEvent('play', onPlay);
            player.addEvent('playProgress', onPlayProgress);

            player.api('play');
        });

        // Call the API when a button is pressed
        $('.video-header-controls li').bind('click', function() {


            clickedButton = $(this).attr('class').replace(" active","");



            switch(clickedButton){

                case "tubular-play":

                    player.api('play');

                     if(isPaused){

                        isPaused = false;

                        $('.tubular-pause').removeClass('active');

                    }

                break;

                case "tubular-pause":

                  

                    if(isPaused){

                        isPaused = false;

                        $('.tubular-pause').removeClass('active');

                        $('.tubular-play').addClass('active');

                        player.api('play');

                    }else{

                        isPaused = true;

                        $('.tubular-pause').addClass('active');
                        $('.tubular-play').removeClass('active');

                        player.api('pause');

                    }

                break;


                case "tubular-mute":


                    if(isMuted){

                        isMuted = false;

                        $('.tubular-mute').removeClass('active');

                        player.api('setVolume',currentVolume);

                    }else{

                        isMuted = true;

                        $('.tubular-mute').addClass('active');

                        player.api('setVolume',0);

                    }



                break;

                case "tubular-volume-up":
          
                    currentVolume = currentVolume + .1
                    player.api('setVolume', currentVolume);

                    if(isMuted){

                        isMuted = false;

                        $('.tubular-mute').removeClass('active');

                    }

                break;


                case "tubular-volume-down":

                    currentVolume = currentVolume - .1
                    player.api('setVolume', currentVolume);

                    if(isMuted){

                        isMuted = false;

                        $('.tubular-mute').removeClass('active');

                    }

                break;


            }

        });

        function onPause(id) {
        }

        function onPlay(id){

            player.api('setVolume',currentVolume);

            // $('#tubular-container,.control-handle').css({"opacity" : "1"});
            // $('#tubular-cover-image').hide();
        }

        function onFinish(id) {
            status.text('finished');
            if(options.repeat === 0){
                $('#tubular-cover-image').show();
            }
        }

        function onPlayProgress(data, id) {
            status.text(data.seconds + 's played');

            if(data.seconds > .3){
                $('#tubular-container,.control-handle').css({"opacity" : "1"});
                $('#tubular-cover-image').hide();
            }
        }


        // resize handler updates width, height and offset of player after resize/init
        var resize = function() {
            var width = $(window).width(),
                pWidth, // player width, to be defined
                height = $(window).height(),
                pHeight, // player height, tbd
                $tubularPlayer = $('#tubular-player');

            // when screen aspect ratio differs from video, video must center and underlay one dimension

            if (width / options.ratio < height) { // if new video height < window height (gap underneath)
                pWidth = Math.ceil(height * options.ratio); // get new player width
                $tubularPlayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
            } else { // new video width < window width (gap to right)
                pHeight = Math.ceil(width / options.ratio); // get new player height
                $tubularPlayer.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2}); // player height is greater, offset top; reset left
            }

        }


        // events
        $(window).on('resize.tubular', function() {
            resize();
        });

       
    }


    // create plugin

    $.fn.tubular = function (options) {
        return this.each(function () {
            if (!$.data(this, 'tubular_instantiated')) { // let's only run one
                $.data(this, 'tubular_instantiated', 
                tubular(this, options));
            }
        });
    }

})(jQuery, window);