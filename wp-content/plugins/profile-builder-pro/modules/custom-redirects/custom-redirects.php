<?php
function wppb_customRedirect(){
	//first thing we will have to do is create a default settings on first-time run of the addon
	$customRedirectSettings = get_option( 'customRedirectSettings','not_found' );
		if ( $customRedirectSettings == 'not_found' ){
			$custom_redirect_arguments = array( 'afterRegister' => 'no', 
												'afterLogin'=> 'no',
												'afterRegisterTarget' => '', 
												'afterLoginTarget'=> '',
												'loginRedirect' => 'no',
												'loginRedirectLogout' => 'no',
												'registerRedirect' => 'no',
												'recoverRedirect' => 'no',
												'dashboardRedirect' => 'no',
												'loginRedirectTarget' => '', 
												'loginRedirectTargetLogout' => '', 
												'registerRedirectTarget'=> '',
												'recoverRedirectTarget' => '', 
												'dashboardRedirectTarget' => '' );
												
			add_option( 'customRedirectSettings', $custom_redirect_arguments );
			
			$customRedirectSettings = get_option( 'customRedirectSettings' );
		}
?>

	<div class="wrap wppb-wrap wppb-custom-redirects">
	
		<h2><?php _e( 'Custom Redirects', 'profilebuilder' );?></h2>
		
		<form method="post" action="options.php#add-ons">
		
			<?php settings_fields( 'customRedirectSettings' ); ?>
			
			<h4><?php _e( 'Redirects on custom page requests:', 'profilebuilder' );?></h4>
			<table class="widefat column-1">
				<thead>
					<tr>
						<th scope="col" class="wppb_col_1"><?php _e( 'Action', 'profilebuilder' );?></th>
						<th scope="col" class="wppb_col_2"><?php _e( 'Redirect', 'profilebuilder' );?></th>
						<th scope="col" class="wppb_col_3"><?php _e( 'URL', 'profilebuilder' );?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e( 'After Registration:', 'profilebuilder' );?></td> 
						<td>
							<input id="ar_a" type="radio" name="customRedirectSettings[afterRegister]" value="yes" <?php if ( $customRedirectSettings['afterRegister'] == 'yes' ) echo 'checked';?>  /><label for="ar_a"><?php _e( 'Active', 'profilebuilder' );?></label>
							<input id="ar_i" type="radio" name="customRedirectSettings[afterRegister]" value="no" <?php if ( $customRedirectSettings['afterRegister'] == 'no' ) echo 'checked';?>/><label for="ar_i"><?php _e( 'Inactive', 'profilebuilder' );?></label>
						</td>
						<td>
							<input name="customRedirectSettings[afterRegisterTarget]" class="afterRegisterTarget" type="text" value="<?php echo $customRedirectSettings['afterRegisterTarget'];?>" />
						</td>
					</tr>
					<tr>
						<td><?php _e( 'After Login:', 'profilebuilder' );?></td> 
						<td>
							<input id="al_a" type="radio" name="customRedirectSettings[afterLogin]" value="yes" <?php if ( $customRedirectSettings['afterLogin'] == 'yes' ) echo 'checked';?> /><label for="al_a"><?php _e( 'Active', 'profilebuilder' );?></label>
							<input id="al_i" type="radio" name="customRedirectSettings[afterLogin]" value="no" <?php if ( $customRedirectSettings['afterLogin'] == 'no' ) echo 'checked';?> /><label for="al_i"><?php _e( 'Inactive', 'profilebuilder' );?></label>
						</td>
						<td>
							<input name="customRedirectSettings[afterLoginTarget]" class="afterLoginTarget" type="text" value="<?php echo $customRedirectSettings['afterLoginTarget'];?>" />
						</td>
					</tr>
					<tr> 
						<td><?php _e( 'Recover Password (*)', 'profilebuilder' );?></td> 
						<td> 
							<input id="rpr_a" type="radio" name="customRedirectSettings[recoverRedirect]" value="yes" <?php if ( $customRedirectSettings['recoverRedirect'] == 'yes' ) echo 'checked';?> /><label for="rpr_a"><?php _e( 'Active', 'profilebuilder' );?></label>
							<input id="rpr_i" type="radio" name="customRedirectSettings[recoverRedirect]" value="no" <?php if ( $customRedirectSettings['recoverRedirect'] == 'no' ) echo 'checked';?> /><label for="rpr_i"><?php _e( 'Inactive', 'profilebuilder' );?></label>
						</td>
						<td>
							<input name="customRedirectSettings[recoverRedirectTarget]" class="recoverRedirectTarget" type="text" value="<?php echo $customRedirectSettings['recoverRedirectTarget'];?>" />
						</td>
					</tr>
				</tbody>
			</table>
			<?php echo '<p class="wppb-extra-info-notice">(*) '.__('When activated this feature will redirect the user on both the default Wordpress password recovery page and the "Lost password?" link used by Profile Builder on the front-end login page.', 'profilebuilder').' </p>'; ?>
		

		
			<h4><?php _e( 'Redirects on default WordPress page requests:', 'profilebuilder' );?></h4>
			<table class="widefat column-1">
				<thead>
					<tr>
						<th scope="col" class="wppb_col_1"><?php _e( 'Action', 'profilebuilder' );?></th>
						<th scope="col" class="wppb_col_2"><?php _e( 'Redirect', 'profilebuilder' );?></th>
						<th scope="col" class="wppb_col_3"><?php _e( 'URL', 'profilebuilder' );?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e( 'Default WordPress Login Page', 'profilebuilder' );?></td>
						<td>
							<input id="lr_a" type="radio" name="customRedirectSettings[loginRedirect]" value="yes" <?php if ( $customRedirectSettings['loginRedirect'] == 'yes' ) echo 'checked';?>  /><label for="lr_a"><?php _e( 'Active', 'profilebuilder' );?></label>
							<input id="lr_i" type="radio" name="customRedirectSettings[loginRedirect]" value="no" <?php if ( $customRedirectSettings['loginRedirect'] == 'no' ) echo 'checked';?>/><label for="lr_i"><?php _e( 'Inactive', 'profilebuilder' );?></label>
						</td>
						<td>
							<input name="customRedirectSettings[loginRedirectTarget]" class="loginRedirectTarget" type="text" value="<?php echo $customRedirectSettings['loginRedirectTarget'];?>" />
						</td>
					</tr>
					<tr>
						<td><?php _e( 'Default WordPress Logout Page', 'profilebuilder' );?></td>
						<td>
							<input id="lrl_a" type="radio" name="customRedirectSettings[loginRedirectLogout]" value="yes" <?php if ( $customRedirectSettings['loginRedirectLogout'] == 'yes' ) echo 'checked';?> /><label for="lrl_a"><?php _e( 'Active', 'profilebuilder' );?></label>
							<input id="lrl_i" type="radio" name="customRedirectSettings[loginRedirectLogout]" value="no" <?php if ( $customRedirectSettings['loginRedirectLogout'] == 'no' ) echo 'checked';?> /><label for="lrl_i"><?php _e( 'Inactive', 'profilebuilder' );?></label>
						</td>
						<td>
							<input name="customRedirectSettings[loginRedirectTargetLogout]" class="loginRedirectTargetLogout" type="text" value="<?php echo $customRedirectSettings['loginRedirectTargetLogout'];?>" />
						</td>
					</tr>
					<tr>
						<td><?php _e( 'Default WordPress Register Page', 'profilebuilder' );?></td>
						<td> 
							<input id="rr_a" type="radio" name="customRedirectSettings[registerRedirect]" value="yes" <?php if ( $customRedirectSettings['registerRedirect'] == 'yes' ) echo 'checked';?> /><label for="rr_a"><?php _e( 'Active', 'profilebuilder' );?></label>
							<input id="rr_i" type="radio" name="customRedirectSettings[registerRedirect]" value="no" <?php if ( $customRedirectSettings['registerRedirect'] == 'no' ) echo 'checked';?> /><label for="rr_i"><?php _e( 'Inactive', 'profilebuilder' );?></label>
						</td>
						<td>
							<input name="customRedirectSettings[registerRedirectTarget]" class="registerRedirectTarget" type="text" value="<?php echo $customRedirectSettings['registerRedirectTarget'];?>" />
						</td>
					</tr>
					<tr>
						<td><?php _e( 'Default WordPress Dashboard (*)', 'profilebuilder' );?></td>
						<td>
							<input id="dr_a" type="radio" name="customRedirectSettings[dashboardRedirect]" value="yes" <?php if ( $customRedirectSettings['dashboardRedirect'] == 'yes' ) echo 'checked';?> /><label for="dr_a"><?php _e( 'Active', 'profilebuilder' );?></label>
							<input id="dr_i" type="radio" name="customRedirectSettings[dashboardRedirect]" value="no" <?php if ( $customRedirectSettings['dashboardRedirect'] == 'no' ) echo 'checked';?> /><label for="dr_i"><?php _e( 'Inactive', 'profilebuilder' );?></label>
						</td>
						<td>
							<input name="customRedirectSettings[dashboardRedirectTarget]" class="dashboardRedirectTarget" type="text" value="<?php echo $customRedirectSettings['dashboardRedirectTarget'];?>" />
						</td>
					</tr>
				</tbody>
			</table>
            <?php echo '<p class="wppb-extra-info-notice">(*) '.__('Redirects every user-role EXCEPT the ones with administrator privileges (can manage options).', 'profilebuilder').' </p>'; ?>
			<div id="wppb_submit_button_div">
				<input type="hidden" name="action" value="update" />
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" /></p>
			</div>
			
		</form>
		
	</div>
	
<?php	
}

//the function needed to block access to the admin-panel (if requested)
function wppb_restrict_dashboard_access(){
	if ( is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ){

		$wppb_module_settings = get_option( 'wppb_module_settings' );
		if ( isset( $wppb_module_settings['wppb_customRedirect'] ) && ( $wppb_module_settings['wppb_customRedirect'] == 'show' ) ){
			
			$custom_redirect = get_option( 'customRedirectSettings' );
			if ( isset( $custom_redirect['dashboardRedirect'] ) && isset( $custom_redirect['dashboardRedirectTarget'] ) && ( $custom_redirect['dashboardRedirect'] == 'yes' ) && ( trim( $custom_redirect['dashboardRedirectTarget'] ) != '' ) ){
				
				if ( defined('DOING_AJAX') || ( ( isset( $_GET['action'] ) && $_GET['action'] == 'logout' ) && isset( $_GET['redirect_to'] ) ) ){
					//let wp log out the user or pass ajax calls

				} elseif ( is_user_logged_in() && !current_user_can( apply_filters( 'wppb_redirect_capability', 'manage_options' ) ) ){
					$redirect_link = trim( $custom_redirect['dashboardRedirectTarget'] );
							
					if ( wppb_check_missing_http( $redirect_link ) )
						$redirect_link = 'http://'. $redirect_link;
					
					wp_redirect( $redirect_link );
					
					exit;
				}
			}
		}
	}
}
add_action( 'admin_init', 'wppb_restrict_dashboard_access' );


if ( !is_admin() ){
	//check to see if the redirecting addon is present and activated
    $wppb_module_settings = get_option( 'wppb_module_settings' );
	if ( isset( $wppb_module_settings['wppb_customRedirect'] ) && ( $wppb_module_settings['wppb_customRedirect'] == 'show' ) ){
		global $pagenow; //get the currently loaded page

		//the part for the WP register page
		if ( ( $pagenow == 'wp-login.php' ) && ( isset($_GET['action'] ) ) && ( $_GET['action'] == 'register' ) ){
			$custom_redirect = get_option( 'customRedirectSettings', 'not_found' );
			
			if ( $custom_redirect != 'not_found' ){
				if ( ( $custom_redirect['registerRedirect'] == 'yes' ) && ( trim( $custom_redirect['registerRedirectTarget'] ) != '' ) ){
					include ('wp-includes/pluggable.php');

					$redirect_link = trim( $custom_redirect['registerRedirectTarget'] );
					
					if ( wppb_check_missing_http( $redirect_link ) )
						$redirect_link = 'http://'.$redirect_link;
				
					wp_redirect( $redirect_link );
					
					exit;
				}
			}
		//the part for the WP password recovery
		}elseif ( ( $pagenow == 'wp-login.php' ) && ( isset( $_GET['action'] ) ) && ( $_GET['action'] == 'lostpassword' ) ){
			$custom_redirect = get_option( 'customRedirectSettings','not_found' );
			
			if ( $custom_redirect != 'not_found' ){
				if ( ( $custom_redirect['recoverRedirect'] == 'yes' ) && ( trim( $custom_redirect['recoverRedirectTarget'] ) != '' ) ){
					include ('wp-includes/pluggable.php');
					$redirect_link = trim( $custom_redirect['recoverRedirectTarget'] );
					
					if ( wppb_check_missing_http( $redirect_link ) )
						$redirect_link = 'http://'.$redirect_link;
				
					wp_redirect( $redirect_link );
					
					exit;
				}
			}
		//the part for WP login; BEFORE login; this part only covers when the user isn't logged in and NOT when he just logged out
		}elseif ( ( ( $pagenow == 'wp-login.php' ) && ( !isset($_GET['action'] ) ) && ( !isset($_GET['loggedout'] ) ) && !isset( $_POST['wppb_login'] ) ) || ( isset( $_GET['redirect_to'] ) && ( $_GET['action'] != 'logout' ) ) ){
			$custom_redirect = get_option( 'customRedirectSettings','not_found' );

			if ($custom_redirect != 'not_found'){
				if (($custom_redirect['loginRedirect'] == 'yes') && (trim($custom_redirect['loginRedirectTarget']) != '')){
					include ('wp-includes/pluggable.php');
					
					$redirect_link = trim($custom_redirect['loginRedirectTarget']);
					
					if ( wppb_check_missing_http( $redirect_link ) )
						$redirect_link = 'http://'. $redirect_link;
				
					wp_redirect( $redirect_link );
					
					exit;
				}
			}
		//the part for WP login; AFTER logout; this part only covers when the user was logged in and has logged out
		}elseif ( ( $pagenow == 'wp-login.php' ) && ( isset($_GET['loggedout'] ) ) && ( $_GET['loggedout'] == 'true' ) ){
			$custom_redirect = get_option( 'customRedirectSettings','not_found' );
			
			if ( $custom_redirect != 'not_found' ){
				if ( ( $custom_redirect['loginRedirectLogout'] == 'yes' ) && ( trim( $custom_redirect['loginRedirectTargetLogout'] ) != '' ) ){
					include ( 'wp-includes/pluggable.php' );
					
					$redirect_link = trim( $custom_redirect['loginRedirectTargetLogout'] );					
					
					if ( wppb_check_missing_http( $redirect_link ) )
						$redirect_link = 'http://'.$redirect_link;
				
					wp_redirect( $redirect_link );
					
					exit;
				}
			}
			
		}
	}
}