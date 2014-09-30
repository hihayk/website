<?php

/************************************************************************
* Recent Comments Widget
*************************************************************************/

 class NZS_Comments_Widget extends WP_Widget {
 
     /**
      * Constructor
      *
      * @return void
      **/
     function NZS_Comments_Widget() {
         $widget_ops = array( 'classname' => 'widgity', 'description' => __('Show list of recent comments with avatars.','framework') );
         $this->WP_Widget( 'widget', '907 Comments', $widget_ops );
     }



     /**
      * Displays the form for this widget on the Widgets page of the WP Admin area.
      *
      * @param array  An array of the current settings for this widget
      * @return void Echoes it's output
      **/
     function form( $instance ) {
        $defauts = array(
            'title' => __('Recent Comments','framework'),
            'show_comment_count' => '3'
          );

         $instance = wp_parse_args( (array) $instance, $defauts );
         // display field names here using:
         // $this->get_field_id( 'option_name' ) - the CSS ID
         // $this->get_field_name( 'option_name' ) - the HTML name
         // $instance['option_name'] - the option value
         // 
         // 
         ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
          </p>

           <p>
          <label for="<?php echo $this->get_field_id( 'show_comment_count' ); ?>"><?php _e( 'Show Number of Comments:','framework' ); ?></label> 
          <input size="2" id="<?php echo $this->get_field_id( 'show_comment_count' ); ?>" name="<?php echo $this->get_field_name( 'show_comment_count' ); ?>" type="text" value="<?php echo esc_attr( $instance['show_comment_count'] ); ?>" />
          </p>

        <?php
     }
 
     /**
      * Outputs the HTML for this widget.
      *
      * @param array  An array of standard parameters for widgets in this theme
      * @param array  An array of settings for this widget instance
      * @return void Echoes it's output
      **/
     function widget( $args, $instance ) {
         extract( $args, EXTR_SKIP );

         if(isset($instance['title'])){
            $title = $instance['title'];
         }

         $number_of = 3;

         if(isset($instance['show_comment_count'])){

          $number_of = $instance['show_comment_count'];

         }
          
        $comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $number_of, 'status' => 'approve', 'post_status' => 'publish' ) ) );


         echo $before_widget;
         echo $before_title;
         echo $title; // Can set this with a widget option, or omit altogether
         echo $after_title;
     //
     // Widget display logic goes here
     //
     echo "<ul class=\"comments\">";

     foreach ($comments as $comment ){
      // print_r($comment);
?>
     <li>
        <a href="<?php echo get_permalink($comment->ID);?>">
        <img src="<?php echo get_avatar_url(get_avatar( $comment->comment_author_email, $size = '80', $default = '', $alt = false ));?>" alt="" class="img-frame" />
        <p><?php echo comment_excerpt( $comment->comment_ID );?></p>
      </a>
      </li>

<?php
      }
    echo "</ul>";
 
     echo $after_widget;

     }




     /**
      * Deals with the settings when they are saved by the admin. Here is
      * where any validation should be dealt with.
      *
      * @param array  An array of new settings as submitted by the admin
      * @param array  An array of the previous settings
      * @return array The validated and (if necessary) amended settings
      **/
     function update( $new_instance, $old_instance ) {
          
         // update logic goes here
         $updated_instance = $new_instance;
         return $updated_instance;
     }

 }
 
 add_action( 'widgets_init', create_function( '', "register_widget( 'NZS_Comments_Widget' );" ) ); 


 /************************************************************************
 * Responsive Video Widget
 *************************************************************************/


 class NZS_Responsive_Video extends WP_Widget {
 
     /**
      * Constructor
      *
      * @return void
      **/
     function NZS_Responsive_Video() {
         $widget_ops = array( 'classname' => 'widgity', 'description' => __('Displays responsive youtube and/or vimeo video','framework') );
         $this->WP_Widget( 'widget-video', '907 Video', $widget_ops );
     }



     /**
      * Displays the form for this widget on the Widgets page of the WP Admin area.
      *
      * @param array  An array of the current settings for this widget
      * @return void Echoes it's output
      **/
     function form( $instance ) {
        $defauts = array(
            'title' => __('Responsive Video','framework'),
            'video_url' => ''
          );

         $instance = wp_parse_args( (array) $instance, $defauts );
         // display field names here using:
         // $this->get_field_id( 'option_name' ) - the CSS ID
         // $this->get_field_name( 'option_name' ) - the HTML name
         // $instance['option_name'] - the option value
         // 
         // 
         ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
          </p>

           <p>
          <label for="<?php echo $this->get_field_id( 'video_url' ); ?>"><?php _e( 'Video URL','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'video_url' ); ?>" name="<?php echo $this->get_field_name( 'video_url' ); ?>" type="text" value="<?php echo esc_url( $instance['video_url'] ); ?>" />
          </p>

        <?php
     }
 
     /**
      * Outputs the HTML for this widget.
      *
      * @param array  An array of standard parameters for widgets in this theme
      * @param array  An array of settings for this widget instance
      * @return void Echoes it's output
      **/
     function widget( $args, $instance ) {
         extract( $args, EXTR_SKIP );

         if(isset($instance['title'])){
            $title = $instance['title'];
         }

         if(isset($instance['video_url'])){

          $video_url = esc_url($instance['video_url']);


          if( 1 === preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$video_url , $matches)){

                $video_url = 'http://www.youtube.com/embed/'.$matches[1];

            }elseif( 1 === preg_match('/vimeo.com\/(?:video\/)?([0-9]+)/', $video_url , $matches)){
              
              $video_url = 'http://player.vimeo.com/video/'.$matches[1].'?title=0&amp;byline=0&amp;portrait=0';
            }

         }
          

         echo $before_widget;
         echo $before_title;
         echo $title; // Can set this with a widget option, or omit altogether
         echo $after_title;
     //
     // Widget display logic goes here
     //


      // print_r($comment);
?>
<div class="video-frame">
  <div class="nzs-responsive-video">

    <?php if(!empty($video_url)): ?>

    <iframe src="<?php echo $video_url;?>" width="400" height="300" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
   
    <?php else: ?>

    Video Link Not Added

    <?php endif; ?>

  </div>
</div>

<?php
 
     echo $after_widget;

     }




     /**
      * Deals with the settings when they are saved by the admin. Here is
      * where any validation should be dealt with.
      *
      * @param array  An array of new settings as submitted by the admin
      * @param array  An array of the previous settings
      * @return array The validated and (if necessary) amended settings
      **/
     function update( $new_instance, $old_instance ) {

      if(isset($new_instance['video_url'])){

          $video_url = esc_url($new_instance['video_url']);


          if( 1 === preg_match('/youtube.com\/embed\/([^\/]+)/', $video_url , $matches)){

          $video_url = 'http://www.youtube.com/embed/'.$matches[1];

          }elseif( 1 === preg_match('/player.vimeo.com\/video\/([0-9]+)/', $video_url , $matches)){
          
          $video_url = 'http://player.vimeo.com/video/'.$matches[1];
        
          }

         }

        $new_instance['video_url'] = $video_url;
          
         // update logic goes here
         $updated_instance = $new_instance;
         return $updated_instance;
     }

 }
 
 add_action( 'widgets_init', create_function( '', "register_widget( 'NZS_Responsive_Video' );" ) ); 



/************************************************************************
* Flickr Widget
*************************************************************************/



 class NZS_Flickr_Widget extends WP_Widget {
 
     /**
      * Constructor
      *
      * @return void
      **/
     function NZS_Flickr_Widget() {
         $widget_ops = array( 'classname' => 'widgity', 'description' => __('Displays Flickr feed.','framework') );
         $this->WP_Widget( 'widget-flickr', '907 Flickr', $widget_ops );
     }



     /**
      * Displays the form for this widget on the Widgets page of the WP Admin area.
      *
      * @param array  An array of the current settings for this widget
      * @return void Echoes it's output
      **/
     function form( $instance ) {
        $defauts = array(
            'title' => __('Flickr','framework'),
            'flickr_username' => '',
            'show_count' => '6'
          );

         $instance = wp_parse_args( (array) $instance, $defauts );
         // display field names here using:
         // $this->get_field_id( 'option_name' ) - the CSS ID
         // $this->get_field_name( 'option_name' ) - the HTML name
         // $instance['option_name'] - the option value
         // 
         // 
         ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
          </p>

           <p>
          <label for="<?php echo $this->get_field_id( 'flickr_username' ); ?>"><?php _e( 'Flickr Id','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'flickr_username' ); ?>" name="<?php echo $this->get_field_name( 'flickr_username' ); ?>" type="text" value="<?php echo esc_attr( $instance['flickr_username'] ); ?>" />
          </p>

           <p>
          <label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Show','framework' ); ?></label> 
          <input size="2" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" type="text" value="<?php echo esc_attr( $instance['show_count'] ); ?>" />
          </p>

        <?php
     }
 
     /**
      * Outputs the HTML for this widget.
      *
      * @param array  An array of standard parameters for widgets in this theme
      * @param array  An array of settings for this widget instance
      * @return void Echoes it's output
      **/
     function widget( $args, $instance ) {
         extract( $args, EXTR_SKIP );

         if(isset($instance['title'])){
            $title = $instance['title'];
         }

         if(isset($instance['flickr_username'])){

          $flickr_username = $instance['flickr_username'];

         }
          

         echo PHP_EOL.PHP_EOL.$before_widget;
         echo $before_title;
         echo $title; // Can set this with a widget option, or omit altogether
         echo $after_title;
     //
     // Widget display logic goes here
     //


      // print_r($comment);
?>

<div class="<?php echo $this->id; ?>" id="flickrImages"></div>

<script type="text/javascript">
  jQuery(document).ready(function($){
    $("div.<?php echo $this->id; ?>").flickrush({
        limit: <?php echo $instance['show_count']; ?>,
        id: "<?php echo $flickr_username;?>",
        random: true,
        style: "img-frame"
    });
  });
</script>
<?php
 
     echo $after_widget;

     }




     /**
      * Deals with the settings when they are saved by the admin. Here is
      * where any validation should be dealt with.
      *
      * @param array  An array of new settings as submitted by the admin
      * @param array  An array of the previous settings
      * @return array The validated and (if necessary) amended settings
      **/
     function update( $new_instance, $old_instance ) {

      if(isset($new_instance['flickr_username'])){

          $flickr_username = $new_instance['flickr_username'];

         }



        $new_instance['flickr_username'] = $flickr_username;
          
         // update logic goes here
         $updated_instance = $new_instance;
         return $updated_instance;
     }

 }
 
 add_action( 'widgets_init', create_function( '', "register_widget( 'NZS_Flickr_Widget' );" ) ); 



/************************************************************************
* Big 250x250 Ad
*************************************************************************/



 class NZS_Big_Ad extends WP_Widget {
 
     /**
      * Constructor
      *
      * @return void
      **/
     function NZS_Big_Ad() {
         $widget_ops = array( 'classname' => 'widgity', 'description' => __('Shows 250x250 ad.','framework') );
         $this->WP_Widget( 'widget-big-ad', '907 Big Ad', $widget_ops );
     }



     /**
      * Displays the form for this widget on the Widgets page of the WP Admin area.
      *
      * @param array  An array of the current settings for this widget
      * @return void Echoes it's output
      **/
     function form( $instance ) {
        $defauts = array(
            'title' => '',
            'ad_img' => get_template_directory_uri().'/assets/img/ad-holder-large.jpg',
            'ad_url' => 'http://themeforest.net/?ref=webcreations907',
            'ad_alt' => 'Sponsors Ad'
          );

         $instance = wp_parse_args( (array) $instance, $defauts );
         // display field names here using:
         // $this->get_field_id( 'option_name' ) - the CSS ID
         // $this->get_field_name( 'option_name' ) - the HTML name
         // $instance['option_name'] - the option value
         // 
         // 
         ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
          </p>

           <p>
          <label for="<?php echo $this->get_field_id( 'ad_alt' ); ?>"><?php _e( 'Alt Text','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_alt' ); ?>" name="<?php echo $this->get_field_name( 'ad_alt' ); ?>" type="text" value="<?php echo esc_attr( $instance['ad_alt'] ); ?>" />
          </p>

           <p>
          <label for="<?php echo $this->get_field_id( 'ad_url' ); ?>"><?php _e( 'URL','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_url' ); ?>" name="<?php echo $this->get_field_name( 'ad_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['ad_url'] ); ?>" />
          </p>
          <p>
          <label for="<?php echo $this->get_field_id( 'ad_img' ); ?>"><?php _e( 'Image URL','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_img' ); ?>" type="text" value="<?php echo esc_url( $instance['ad_img'] ); ?>" />
          </p>

        <?php
     }
 
     /**
      * Outputs the HTML for this widget.
      *
      * @param array  An array of standard parameters for widgets in this theme
      * @param array  An array of settings for this widget instance
      * @return void Echoes it's output
      **/
     function widget( $args, $instance ) {
         extract( $args, EXTR_SKIP );

         

        
          

         echo PHP_EOL.PHP_EOL.$before_widget;

         if(isset($instance['title']) && !empty($instance['title'])){
            $title = $instance['title'];
             echo $before_title;
             echo $title; // Can set this with a widget option, or omit altogether
             echo $after_title;
           }
     //
     // Widget display logic goes here
     //


      // print_r($comment);
?>

<div class="ads large">
  <a href="<?php echo esc_url($instance['ad_url']); ?>"><img src="<?php echo esc_url($instance['ad_img']); ?>" alt="<?php echo esc_attr($instance['ad_alt']); ?>"></a>
</div>

<?php
     echo $after_widget;

     }




     /**
      * Deals with the settings when they are saved by the admin. Here is
      * where any validation should be dealt with.
      *
      * @param array  An array of new settings as submitted by the admin
      * @param array  An array of the previous settings
      * @return array The validated and (if necessary) amended settings
      **/
     function update( $new_instance, $old_instance ) {

      if(isset($new_instance['ad_img'])){

         $new_instance['ad_img'] = esc_url($new_instance['ad_img']);

         }

         if(isset($new_instance['ad_url'])){

         $new_instance['ad_url'] = esc_url($new_instance['ad_url']);

         }
          
         // update logic goes here
         $updated_instance = $new_instance;
         return $updated_instance;
     }

 }
 
 add_action( 'widgets_init', create_function( '', "register_widget( 'NZS_Big_Ad' );" ) ); 



/************************************************************************
* 125x125 Ads
*************************************************************************/



 class NZS_Ad_Small extends WP_Widget {
 
     /**
      * Constructor
      *
      * @return void
      **/
     function NZS_Ad_Small() {
         $widget_ops = array( 'classname' => 'widgity', 'description' => __('Shows 125x125 ads.','framework') );
         $this->WP_Widget( 'widget-small-ad', '907 Ads', $widget_ops );
     }



     /**
      * Displays the form for this widget on the Widgets page of the WP Admin area.
      *
      * @param array  An array of the current settings for this widget
      * @return void Echoes it's output
      **/
     function form( $instance ) {
        $defauts = array(

            'title' => 'Sponosor',
            'ad_img' => array(get_template_directory_uri().'/assets/img/ad-holder.jpg'),
            'ad_url' => array('http://themeforest.net/?ref=webcreations907'),
            'ad_alt' => array('Sponsors Ads')
          );

         $instance = wp_parse_args( (array) $instance, $defauts );
         // display field names here using:
         // $this->get_field_id( 'option_name' ) - the CSS ID
         // $this->get_field_name( 'option_name' ) - the HTML name
         // $instance['option_name'] - the option value
         // 
         // print_r($instance);
         // 
         // 
         ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title']); ?>" />
          </p>

         <?php

         $current_ads = count($instance['ad_img']);

         

         
         for($i=0; $i < count($instance['ad_img']);$i++) { 


          if(!empty($instance['ad_alt'][$i]) && !empty($instance['ad_url'][$i]) && !empty($instance['ad_img'][$i])){
         ?>

         <p><strong><?php echo __("Ad Spot ",'framework').($i+1); ?></strong></p>

          <p>
          <label for="<?php echo $this->get_field_id( 'ad_alt' ); ?>[]"><?php _e( 'Alt Text','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_alt' ); ?>[]" name="<?php echo $this->get_field_name( 'ad_alt' ); ?>[]" type="text" value="<?php echo esc_attr( $instance['ad_alt'][$i]); ?>" />
          </p>

          <p>
          <label for="<?php echo $this->get_field_id( 'ad_url' ); ?>[]"><?php _e( 'URL','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_url' ); ?>[]" name="<?php echo $this->get_field_name( 'ad_url' ); ?>[]" type="text" value="<?php echo esc_attr( $instance['ad_url'][$i] ); ?>" />
          </p>

           <p>
          <label for="<?php echo $this->get_field_id( 'ad_img' ); ?>[]"><?php _e( 'Image URL','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_img' ); ?>[]" name="<?php echo $this->get_field_name( 'ad_img' ); ?>[]" type="text" value="<?php echo esc_url( $instance['ad_img'][$i] ); ?>" />
          </p>


        <?php
      }
    }



        if(!empty($instance['ad_alt'][$i-1]) && !empty($instance['ad_url'][$i-1]) && !empty($instance['ad_img'][$i-1])){

          $instance['ad_url'][] = '';
          $instance['ad_img'][] = 'http://';
          $instance['ad_alt'][] = ' ';

          
         ?>

         <p><strong><?php echo __("Ad Spot ",'framework').($i+1); ?></strong></p>

          <p>
          <label for="<?php echo $this->get_field_id( 'ad_alt' ); ?>[]"><?php _e( 'Alt Text','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_alt' ); ?>[]" name="<?php echo $this->get_field_name( 'ad_alt' ); ?>[]" type="text" value="<?php echo esc_attr( $instance['ad_alt'][$i]); ?>" />
          </p>

          <p>
          <label for="<?php echo $this->get_field_id( 'ad_url' ); ?>[]"><?php _e( 'URL','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_url' ); ?>[]" name="<?php echo $this->get_field_name( 'ad_url' ); ?>[]" type="text" value="<?php echo esc_attr( $instance['ad_url'][$i] ); ?>" />
          </p>

           <p>
          <label for="<?php echo $this->get_field_id( 'ad_img' ); ?>[]"><?php _e( 'Image URL','framework' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'ad_img' ); ?>[]" name="<?php echo $this->get_field_name( 'ad_img' ); ?>[]" type="text" value="<?php echo esc_attr( $instance['ad_img'][$i] ); ?>" />
          </p>


        <?php
      }
               ?>


        <?php
     }
 
     /**
      * Outputs the HTML for this widget.
      *
      * @param array  An array of standard parameters for widgets in this theme
      * @param array  An array of settings for this widget instance
      * @return void Echoes it's output
      **/
     function widget( $args, $instance ) {
         extract( $args, EXTR_SKIP );

         

        
          

       echo PHP_EOL.PHP_EOL.$before_widget;

       if(isset($instance['title']) && !empty($instance['title'])){
          $title = $instance['title'];
           echo $before_title;
           echo $title; // Can set this with a widget option, or omit altogether
           echo $after_title;
         }
  


        echo '<div class="ads small">';

        for($i=0; $i < count($instance['ad_img']);$i++) { 


          if(!empty($instance['ad_alt'][$i]) && !empty($instance['ad_url'][$i]) && !empty($instance['ad_img'][$i])){

      ?>


   <a href="<?php echo esc_attr($instance['ad_url'][$i]);?>"><img src="<?php echo esc_attr($instance['ad_img'][$i]);?>" alt="<?php echo esc_attr($instance['ad_alt'][$i]);?>"></a>



        <?php

          }
        }

        echo '</div>';

       echo $after_widget;

     }




     /**
      * Deals with the settings when they are saved by the admin. Here is
      * where any validation should be dealt with.
      *
      * @param array  An array of new settings as submitted by the admin
      * @param array  An array of the previous settings
      * @return array The validated and (if necessary) amended settings
      **/
     function update( $new_instance, $old_instance ) {

      for($i=0; $i < count($instance['ad_img']);$i++) { 


          if(isset($new_instance['ad_img'][$i])){

         $new_instance['ad_img'][$i] = esc_url($new_instance['ad_img'][$i]);

         }

         if(isset($new_instance['ad_url'][$i])){

         $new_instance['ad_url'][$i] = esc_url($new_instance['ad_url'][$i]);

         }

         if(isset($new_instance['ad_alt'][$i])){

         $new_instance['ad_alt'][$i] = esc_attr($new_instance['ad_alt'][$i]);

         }
       }




         // update logic goes here
         $updated_instance = $new_instance;
         return $updated_instance;
     }

 }
 
 add_action( 'widgets_init', create_function( '', "register_widget( 'NZS_Ad_Small' );" ) ); 


?>