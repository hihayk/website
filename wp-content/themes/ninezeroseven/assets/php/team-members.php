<ul class="team clearfix">

<?php
/************************************************************************
* Team members
*************************************************************************/

	global $post,$smof_data,$nzs_category;
	$old = $post;

	if(isset($smof_data['nzs_team_cols'])){

		switch ($smof_data['nzs_team_cols']) {
			case 2:
				$team_column_num = "eight columns";

			break;

			case 3:
				$team_column_num = "one-third column";

			break;

			case 4:
				$team_column_num = "four columns";

			break;
			
			default:
				$team_column_num = "four columns";
			break;
		}

	}else{

		$team_column_num = "four columns";

	}

	$target_window = $smof_data['nzs_social_target'];

	$portfolio_query = new WP_Query( array( 'post_type' => 'team_members', 'posts_per_page' => -1, 'order' => 'ASC','filter_team'=>$nzs_category  ) ); 
		
		if($portfolio_query->have_posts()): while($portfolio_query->have_posts()) : $portfolio_query->the_post();



		$team_link = get_post_meta(get_the_ID(), 'nzs_team_link_option', true);
		$team_link_window = get_post_meta(get_the_ID(), 'nzs_team_link_window', true);

?>
			<li class="<?php echo $team_column_num; ?>">

				<?php
				if(has_post_thumbnail()){
			 		// $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'team-thumbnail');  
			 		$thumb = nzs_get_post_image(get_post_thumbnail_id());
				?>

				<span class="img-wrap">

					<?php if($team_link){?>

					<a href="<?php echo esc_url($team_link);?>" target="<?php esc_attr_e($team_link_window); ?>"><img src="<?php echo $thumb;?>" alt="" class="rounded scale-with-grid"></a>

					<?php }else{ ?>
					
					<img src="<?php echo $thumb;?>" alt="" class="rounded scale-with-grid">

					<?php } ?>

				</span>

				<?php
				}else{
				?>

				<span class="img-wrap">

					<?php if($team_link){?>

					<a href="<?php echo esc_url($team_link);?>" target="<?php esc_attr_e($team_link_window); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/team-holder.jpg" alt="" class="rounded scale-with-grid"></a>

					<?php }else{ ?>
					
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/team-holder.jpg" alt="" class="rounded scale-with-grid">

					<?php } ?>


				</span>

				<?php
				}

				the_content();

				$team_twitter = get_post_meta( get_the_ID(), 'nzs_member_social_twitter', true);
				$team_facebook = get_post_meta( get_the_ID(), 'nzs_member_social_facebook', true);
				$team_google = get_post_meta( get_the_ID(), 'nzs_member_social_google', true);
				$team_flickr = get_post_meta( get_the_ID(), 'nzs_member_social_flickr', true);
				$team_linkedin = get_post_meta( get_the_ID(), 'nzs_member_social_linkedin', true);
				$team_dribbble = get_post_meta( get_the_ID(), 'nzs_member_social_dribbble', true);
				$team_deviantart = get_post_meta( get_the_ID(), 'nzs_member_social_deviantart', true);
				$team_pinterest = get_post_meta( get_the_ID(), 'nzs_member_social_pinterest', true);

				$team_youtube = get_post_meta( get_the_ID(), 'nzs_member_social_youtube', true);
				$team_vimeo = get_post_meta( get_the_ID(), 'nzs_member_social_vimeo', true);
				$team_instagram = get_post_meta( get_the_ID(), 'nzs_member_social_instagram', true);
				$team_email = get_post_meta( get_the_ID(), 'nzs_member_social_email', true);
				$team_soundcloud = get_post_meta( get_the_ID(), 'nzs_member_social_soundcloud', true);
				$team_behance = get_post_meta( get_the_ID(), 'nzs_member_social_behance', true);
				$team_ustream = get_post_meta( get_the_ID(), 'nzs_member_social_ustream', true);
				$team_rss = get_post_meta( get_the_ID(), 'nzs_member_social_rss', true);

				?>

				<div class="social">

					<?php
					if($team_twitter){
					?>
					<a class="hide-text twitter" target="<?php echo $target_window;?>" href="<?php echo $team_twitter;?>">Twitter</a>
					<?php
					} 
					?>
					<?php
					if($team_facebook){
					?>
					<a class="hide-text facebook" target="<?php echo $target_window;?>" href="<?php echo $team_facebook;?>">Facebook</a>
					<?php
					} 
					?>
					<?php
					if($team_google){
					?>
					<a class="hide-text google" target="<?php echo $target_window;?>" href="<?php echo $team_google;?>">Google+</a>
					<?php
					} 
					?>
					<?php
					if($team_dribbble){
					?>
					<a class="hide-text dribbble" target="<?php echo $target_window;?>" href="<?php echo $team_dribbble;?>">Dribbble</a>
					<?php
					} 
					?>
					<?php
					if($team_pinterest){
					?>
					<a class="hide-text pinterest" target="<?php echo $target_window;?>" href="<?php echo $team_pinterest;?>">Pinterest</a>
					<?php
					} 
					?>
					<?php
					if($team_flickr){
					?>
					<a class="hide-text flickr" target="<?php echo $target_window;?>" href="<?php echo $team_flickr;?>">Flickr</a>
					<?php
					} 
					?>
					<?php
					if($team_deviantart){
					?>
					<a class="hide-text deviantart" target="<?php echo $target_window;?>" href="<?php echo $team_deviantart;?>">Deviantart</a>
					<?php
					} 
					?>
					<?php
					if($team_linkedin){
					?>
					<a class="hide-text linkedin" target="<?php echo $target_window;?>" href="<?php echo $team_linkedin;?>">Linkedin</a>
					<?php
					} 
					?>

					<?php
					if($team_vimeo){
					?>
					<a class="hide-text vimeo" target="<?php echo $target_window;?>" href="<?php echo $team_vimeo;?>">Vimeo</a>
					<?php
					} 
					?>

					<?php
					if($team_instagram){
					?>
					<a class="hide-text instagram" target="<?php echo $target_window;?>" href="<?php echo $team_instagram;?>">Instagram</a>
					<?php
					} 
					?>

					<?php
					if($team_email){
					?>
					<a class="hide-text email" target="<?php echo $target_window;?>" href="mailto:<?php echo $team_email;?>">Email</a>
					<?php
					} 
					?>

					<?php
					if($team_youtube){
					?>
					<a class="hide-text youtube" target="<?php echo $target_window;?>" href="<?php echo $team_youtube;?>">Youtube</a>
					<?php
					} 
					?>

					<?php
					if($team_soundcloud){
					?>
					<a class="hide-text soundcloud" target="<?php echo $target_window;?>" href="<?php echo $team_soundcloud;?>">Soundcloud</a>
					<?php
					} 
					?>

					<?php
					if($team_behance){
					?>
					<a class="hide-text behance" target="<?php echo $target_window;?>" href="<?php echo $team_behance;?>">Behance</a>
					<?php
					} 
					?>

					<?php
					if($team_ustream){
					?>
					<a class="hide-text ustream" target="<?php echo $target_window;?>" href="<?php echo $team_ustream;?>">Ustream</a>
					<?php
					} 
					?>

					<?php
					if($team_rss){
					?>
					<a class="hide-text rss" target="<?php echo $target_window;?>" href="<?php echo $team_rss;?>">RSS</a>
					<?php
					} 
					?>


				</div>

			</li>
			<?php
			 		
		endwhile;
		endif;

$post = $old;
 
?>
		
</ul>
