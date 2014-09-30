<div class="wrap">
	<div id="" class="icon-jotform"><br></div>
	<h2><?php _e( "Settings | Form Generator for WordPress", 'dxbase' ); ?></h2>
	
	<p>To get started click "Connect with JotForm" below to authenticate your account. You can also authenticate manually by creating an API key <a class="" href="http://www.jotform.com/myaccount/api"><strong>here</strong></a> and entering it below.</p>
	<div id="dx_page_messages"></div>
	<form id="dx-plugin-base-form" action="options.php" method="POST">
			<?php settings_fields( 'jc_setting' ) ?>
			<?php do_settings_sections( 'dx-plugin-base' ) ?>
			<input type="submit" value="<?php _e( "Save", 'dxbase' ); ?>" />
	</form> <!-- end of #dxtemplate-form -->
	
    

 
 
	<?php 
	

	try{
		$jc_settings=get_option( 'jc_setting', '' );
  		$jt = new JotForm($jc_settings['jc_api_key']);
		$key=$jc_settings['jc_api_key'];
		if (! $key==""){
				echo "<script> JF.initialize({ apiKey: '$key' }) </script>";
		}
		
		
		$users=$jt->getUser();
 		//var_dump($users);
		echo '<hr/>';
		echo '<h3> Account Information </h3>';
		echo '<table width="600px" class="sc">';
		foreach ($users as $key=>$user) {
		printf('
		<tr>
			<th scope="row">%s</th>
			<td>%s</td>
		</tr>',$key,$user);
			
		}
		echo '</table>';
	}
		catch(Exception $e){
			//echo ($e->getMessage());
			echo '<p> <button   id="jotFormLogin" class=" jotFormLogin button button-primary">Connect with JotForm</button></p>';
			echo '<div class="error">
       <p><strong>Form Generator is not Active.</strong> <br/> <a class="jotFormLogin" href="?page=jc-settings-page">Login or sign-up with Jotform</a> to get started </p>
    </div>';
	
			wp_die('');
		}

	 ?>
	<div id="resource-window"> 	</div>
			
</div>