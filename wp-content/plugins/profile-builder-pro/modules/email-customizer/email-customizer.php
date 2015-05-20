<?php

function wppb_email_customizer_generate_merge_tags( $special_merge_tags = null ){

	$mustache_vars = array(
						array(
							'group-title' => __( 'Available Tags', 'profilebuilder' ),
							'variables' => wppb_email_customizer_generate_default_meta_merge_tags( $special_merge_tags )
						),
						array(
							'group-title' => __( 'User Meta', 'profilebuilder' ),
							'variables' => wppb_email_customizer_generate_meta_merge_tags()
						)
					);

	return $mustache_vars;
}


function wppb_email_customizer_generate_default_meta_merge_tags( $special_merge_tags ){
	$merge_tags[] = array( 'name' => 'site_url', 'type' => 'ec_site_url', 'label' => __( 'Site Url', 'profilebuilder' ) );
	$merge_tags[] = array( 'name' => 'site_name', 'type' => 'ec_site_name', 'label' => __( 'Site Name', 'profilebuilder' ) );
	
	if ( $special_merge_tags != 'email_confirmation' ){
		$merge_tags[] = array( 'name' => 'user_id', 'type' => 'ec_user_id', 'label' => __( 'User Id', 'profilebuilder' )  );
	}
	
	$merge_tags[] = array( 'name' => 'username', 'type' => 'ec_username', 'label' => __( 'Username', 'profilebuilder' )  );
	$merge_tags[] = array( 'name' => 'user_email', 'type' => 'ec_user_email', 'label' => __( 'Email', 'profilebuilder' )  );
	$merge_tags[] = array( 'name' => 'password', 'type' => 'ec_password', 'label' => __( 'Password', 'profilebuilder' )  );
	$merge_tags[] = array( 'name' => 'role', 'type' => 'ec_role', 'label' => __( 'User Role', 'profilebuilder' )  );
	$merge_tags[] = array( 'name' => 'website', 'type' => 'ec_website', 'label' => __( 'Website', 'profilebuilder' )  );
	$merge_tags[] = array( 'name' => 'reply_to', 'type' => 'ec_reply_to', 'label' => __( 'Reply To', 'profilebuilder' )  );

	if ( $special_merge_tags == 'email_confirmation' ){
		$merge_tags[] = array( 'name' => 'activation_key', 'type' => 'ec_activation_key', 'label' => __( 'Activation Key', 'profilebuilder' )  );
		$merge_tags[] = array( 'name' => 'activation_url', 'type' => 'ec_activation_url', 'label' => __( 'Activation Url', 'profilebuilder' )  );
		$merge_tags[] = array( 'name' => 'activation_link', 'type' => 'ec_activation_link', 'unescaped' => true, 'label' => __( 'Activation Link', 'profilebuilder' )  );
	}

	if ( $special_merge_tags == 'password_reset' ){
		$merge_tags[] = array( 'name' => 'reset_key', 'type' => 'ec_reset_key', 'label' => __( 'Reset Key', 'profilebuilder' )  );
		$merge_tags[] = array( 'name' => 'reset_url', 'type' => 'ec_reset_url', 'label' => __( 'Reset Url', 'profilebuilder' )  );
		$merge_tags[] = array( 'name' => 'reset_link', 'type' => 'ec_reset_link', 'unescaped' => true, 'label' => __( 'Reset Link', 'profilebuilder' )  );
	}
	
	return $merge_tags;
}


function wppb_email_customizer_generate_meta_merge_tags(){
	$wppb_manage_fields = get_option( 'wppb_manage_fields', 'not_found' );
	$merge_tags = array();

	if ( $wppb_manage_fields != 'not_found' ){
		foreach( $wppb_manage_fields as $key => $value ){
			if( !empty( $value['meta-name'] ) ){
				$merge_tags[] = array( 'name' => $value['meta-name'], 'type' => 'ec_user_meta', 'label' => $value['field-title'] );
                if( $value['field'] == 'Select' || $value['field'] == 'Select (Multiple)' || $value['field'] == 'Checkbox' || $value['field'] == 'Radio' )
                    $merge_tags[] = array( 'name' => $value['meta-name'] . '_labels', 'type' => 'ec_user_meta_labels', 'label' => $value['field-title'] . ' Labels' );
            }
		}
	}
	
	return $merge_tags;
}


function wppb_email_customizer_admin_approval_new_user_signup_filter_handler( $default_string, $user_email, $user_password, $email_sent_from, $option_name ){
	$email_customizer_option = get_option( $option_name, 'not_found' );
	if ( $email_customizer_option != 'not_found' ){
		$user_data = get_user_by( 'email', $user_email );
		wppb_change_email_from_headers();
		return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags(), $email_customizer_option, array( 'user_id' => $user_data->ID, 'user_login' => $user_data->user_login, 'user_email' => $user_email, 'user_password' => $user_password, 'user_data' => $user_data, 'email_sent_from' => $email_sent_from ) );
	}

	return $default_string;
}

function wppb_email_customizer_admin_approval_new_user_status_filter_handler( $default_string, $user_data, $new_status, $email_sent_from, $option_name ){
	$email_customizer_option = get_option( $option_name, 'not_found' );
		
	if ( $email_customizer_option != 'not_found' ){
        if( !empty( $user_data ) ){
			wppb_change_email_from_headers();
		    return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags(), $email_customizer_option, array( 'user_id' => $user_data->ID, 'user_login' => $user_data->user_login, 'user_email' => $user_data->user_email, 'user_password' => $user_data->user_pass, 'user_data' => $user_data, 'email_sent_from' => $email_sent_from ) );
		}
	}

	return $default_string;
}

function wppb_email_customizer_email_confirmation_filter_handler( $default_string, $user_email, $username, $key, $activation_url, $serialized_data, $email_sent_from, $option_name ){
    $email_customizer_option = get_option( $option_name, 'not_found' );
	if ( $email_customizer_option != 'not_found' ){
        $unserialized_data = unserialize( $serialized_data );
        if( !empty( $unserialized_data ) ){
			wppb_change_email_from_headers();
		    return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags( 'email_confirmation' ), $email_customizer_option, array( 'user_login' => $unserialized_data['user_login'], 'user_email' => $user_email, 'user_password' => $unserialized_data['user_pass'], 'email_confirmation_unserialized_data' => $unserialized_data, 'email_confirmation_key' => $key, 'email_confirmation_url' => $activation_url, 'email_sent_from' => $email_sent_from ) );
		}
	}

	return $default_string;
}

function wppb_email_customizer_password_reset_content_filter_handler( $default_string, $user_id, $user_login, $user_email ) {
	$email_customizer_option = get_option( 'wppb_user_emailc_reset_email_content', 'not_found' );
	$key = wppb_retrieve_activation_key( $user_login );
	$url = add_query_arg( array( 'loginName' => $user_login, 'key' => $key ), wppb_curpageurl() );

	if( $email_customizer_option != 'not_found' ) {
		return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags( 'password_reset' ), $email_customizer_option, array( 'user_login' => $user_login, 'reset_key' => $key, 'reset_url' => $url, 'user_email' => $user_email, 'user_id' => $user_id ) );
	}

	return $default_string;
}

function wppb_email_customizer_password_reset_title_filter_handler( $default_string, $username ) {
	$email_customizer_option = get_option( 'wppb_user_emailc_reset_email_subject', 'not_found' );

	if( $email_customizer_option != 'not_found' ) {
		return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags( 'password_reset' ), $email_customizer_option, array( 'user_login' => $username ) );
	}

	return $default_string;
}

function wppb_email_customizer_password_reset_success_content_filter_handler( $default_string, $username, $new_password, $userID ) {
	$email_customizer_option = get_option( 'wppb_user_emailc_reset_success_email_content', 'not_found' );

	if( $email_customizer_option != 'not_found' ) {
		return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags(), $email_customizer_option, array( 'user_login' => $username, 'user_password' => base64_encode( $new_password ), 'user_id' => $userID ) );
	}

	return $default_string;
}

function wppb_email_customizer_password_reset_success_title_filter_handler( $default_string, $username ) {
	$email_customizer_option = get_option( 'wppb_user_emailc_reset_success_email_subject', 'not_found' );

	if( $email_customizer_option != 'not_found' ) {
		return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags(), $email_customizer_option, array( 'user_login' => $username ) );
	}

	return $default_string;
}

function wppb_admin_email_customizer_password_reset_content_filter_handler( $default_string, $username, $new_password, $userID ) {
	$email_customizer_option = get_option( 'wppb_admin_emailc_user_password_reset_email_content', 'not_found' );

	if( $email_customizer_option != 'not_found' ) {
		return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags(), $email_customizer_option, array( 'user_login' => $username, 'user_password' => base64_encode( $new_password ), 'user_id' => $userID ) );
	}

	return $default_string;
}

function wppb_admin_email_customizer_password_reset_title_filter_handler( $default_string, $username ) {
	$email_customizer_option = get_option( 'wppb_admin_emailc_user_password_reset_email_subject', 'not_found' );

	if( $email_customizer_option != 'not_found' ) {
		return (string) new PB_Mustache_Generate_Template( wppb_email_customizer_generate_merge_tags(), $email_customizer_option, array( 'user_login' => $username ) );
	}

	return $default_string;
}

$wppb_addonOptions = get_option( 'wppb_module_settings' );
// using filters, we overwrite the old content with the new one from the email customizer (for the user)
if ( $wppb_addonOptions['wppb_emailCustomizer'] == 'show' ){
	add_filter ( 'wppb_register_user_email_subject_without_admin_approval', 'wppb_email_customizer_admin_approval_new_user_signup_filter_handler', 10, 5 );
	add_filter ( 'wppb_register_user_email_message_without_admin_approval', 'wppb_email_customizer_admin_approval_new_user_signup_filter_handler', 10, 5 );

	add_filter ( 'wppb_register_user_email_subject_with_admin_approval', 'wppb_email_customizer_admin_approval_new_user_signup_filter_handler', 10, 5 );
	add_filter ( 'wppb_register_user_email_message_with_admin_approval', 'wppb_email_customizer_admin_approval_new_user_signup_filter_handler', 10, 5 );

	add_filter ( 'wppb_new_user_status_subject_approved', 'wppb_email_customizer_admin_approval_new_user_status_filter_handler', 10, 5 );
	add_filter ( 'wppb_new_user_status_message_approved', 'wppb_email_customizer_admin_approval_new_user_status_filter_handler', 10, 5 );

	add_filter ( 'wppb_new_user_status_subject_unapproved', 'wppb_email_customizer_admin_approval_new_user_status_filter_handler', 10, 5 );
	add_filter ( 'wppb_new_user_status_message_unapproved', 'wppb_email_customizer_admin_approval_new_user_status_filter_handler', 10, 5 );

	add_filter ( 'wppb_signup_user_notification_email_subject', 'wppb_email_customizer_email_confirmation_filter_handler', 10, 8 );
	add_filter ( 'wppb_signup_user_notification_email_content', 'wppb_email_customizer_email_confirmation_filter_handler', 10, 8 );

	add_filter ( 'wppb_recover_password_message_content_sent_to_user1', 'wppb_email_customizer_password_reset_content_filter_handler', 10, 4 );
	add_filter ( 'wppb_recover_password_message_title_sent_to_user1', 'wppb_email_customizer_password_reset_title_filter_handler', 10, 2 );

	add_filter ( 'wppb_recover_password_message_content_sent_to_user2', 'wppb_email_customizer_password_reset_success_content_filter_handler', 10, 4 );
	add_filter ( 'wppb_recover_password_message_title_sent_to_user2', 'wppb_email_customizer_password_reset_success_title_filter_handler', 10, 2 );
}

// using filters, we overwrite the old content with the new one from the email customizer (for the admin)
if ( $wppb_addonOptions['wppb_emailCustomizerAdmin'] == 'show' ){
	add_filter ( 'wppb_register_admin_email_subject_without_admin_approval', 'wppb_email_customizer_admin_approval_new_user_signup_filter_handler', 10, 5 );
	add_filter ( 'wppb_register_admin_email_message_without_admin_approval', 'wppb_email_customizer_admin_approval_new_user_signup_filter_handler', 10, 5 );

	add_filter ( 'wppb_register_admin_email_subject_with_admin_approval', 'wppb_email_customizer_admin_approval_new_user_signup_filter_handler', 10, 5 );
	add_filter ( 'wppb_register_admin_email_message_with_admin_approval', 'wppb_email_customizer_admin_approval_new_user_signup_filter_handler', 10, 5 );

	add_filter ( 'wppb_recover_password_message_content_sent_to_admin', 'wppb_admin_email_customizer_password_reset_content_filter_handler', 10, 4 );
	add_filter ( 'wppb_recover_password_message_title_sent_to_admin', 'wppb_admin_email_customizer_password_reset_title_filter_handler', 10, 2 );
}


/**
 * Function that overwrites the default reply-to with the one set in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $sender_email
 *
 * @return string
 */
function wppb_ec_website_email( $value, $merge_tag_name, $merge_tag, $extra_data ){
    $admin_email_address = get_bloginfo( 'admin_email' );

	$emailc_common_settings_from_reply_to_email = get_option( 'wppb_emailc_common_settings_from_reply_to_email', 'not_found' );
	if ( $emailc_common_settings_from_reply_to_email != 'not_found' ) {
        if( strpos( $emailc_common_settings_from_reply_to_email, '{{reply_to}}' ) === false ) {
            if( is_email( trim( $emailc_common_settings_from_reply_to_email ) ) )
                $admin_email_address = trim( $emailc_common_settings_from_reply_to_email );
        }
    }

    return apply_filters( 'wppb_ec_sender_email_filter', trim( $admin_email_address ) );
}
add_filter( 'mustache_variable_ec_reply_to', 'wppb_ec_website_email', 10, 4 );


/**
 * Function that filters and returns the site_url in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_site_url( $value, $merge_tag_name, $merge_tag, $extra_data ){
	return apply_filters( 'wppb_ec_site_url_filter', get_bloginfo( 'url' ) );
}
add_filter( 'mustache_variable_ec_site_url', 'wppb_ec_replace_site_url', 10, 4 );


/**
 * Function that filters and returns the site_name in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_site_name( $value, $merge_tag_name, $merge_tag, $extra_data ){
	return apply_filters( 'wppb_ec_site_name_filter', get_bloginfo( 'name' ) );
}
add_filter( 'mustache_variable_ec_site_name', 'wppb_ec_replace_site_name', 10, 4 );


/**
 * Function that filters and returns the user_id in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_user_id( $value, $merge_tag_name, $merge_tag, $extra_data ){
    if( !empty( $extra_data['user_id'] ) )
	    return $extra_data['user_id'];
    else
        return '';
}
add_filter( 'mustache_variable_ec_user_id', 'wppb_ec_replace_user_id', 10, 4 );


/**
 * Function that filters and returns the username in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_username( $value, $merge_tag_name, $merge_tag, $extra_data ){
    $wppb_general_settings = get_option( 'wppb_general_settings' );

	if ( isset( $extra_data['email_confirmation_unserialized_data']['user_login'] ) ){
        if( isset( $wppb_general_settings['loginWith'] ) && ( $wppb_general_settings['loginWith'] == 'email' ) )
            return $extra_data['email_confirmation_unserialized_data']['user_email'];
        else
		    return $extra_data['email_confirmation_unserialized_data']['user_login'];
    }

    if( isset( $wppb_general_settings['loginWith'] ) && ( $wppb_general_settings['loginWith'] == 'email' ) )
        return $extra_data['user_email'];
    else
        return $extra_data['user_login'];
}
add_filter( 'mustache_variable_ec_username', 'wppb_ec_replace_username', 10, 4 );


/**
 * Function that filters and returns the user_email in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_user_email( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['email_confirmation_unserialized_data']['user_email'] ) )
		return $extra_data['email_confirmation_unserialized_data']['user_email'];

    if( !empty( $extra_data['user_email'] ) )
	    return $extra_data['user_email'];
    else
        return '';
}
add_filter( 'mustache_variable_ec_user_email', 'wppb_ec_replace_user_email', 10, 4 );


/**
 * Function that filters and returns the users password in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_password( $value, $merge_tag_name, $merge_tag, $extra_data ){
    if( empty( $extra_data['email_confirmation_unserialized_data']['user_pass'] ) && empty( $extra_data['user_password'] ) ){
        return __( 'Your selected password at signup', 'profilebuilder' );
    }

	if ( isset( $extra_data['email_confirmation_unserialized_data']['user_pass'] ) ) {
        if( base64_encode( base64_decode($extra_data['email_confirmation_unserialized_data']['user_pass'] ) ) === $extra_data['email_confirmation_unserialized_data']['user_pass'] )
            return base64_decode($extra_data['email_confirmation_unserialized_data']['user_pass']);
        else
            return __( 'Your selected password at signup', 'profilebuilder' );
    }

    if ( isset( $extra_data['user_password'] ) ) {
        if( base64_encode( base64_decode($extra_data['user_password'] ) ) === $extra_data['user_password'] )
            return base64_decode($extra_data['user_password']);
        else
            return __( 'Your selected password at signup', 'profilebuilder' );
    }

	return $extra_data['user_password'];
}
add_filter( 'mustache_variable_ec_password', 'wppb_ec_replace_password', 10, 4 );


/**
 * Function that filters and returns the users website in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_website( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['email_confirmation_unserialized_data']['user_url'] ) )
		return $extra_data['email_confirmation_unserialized_data']['user_url'];
    if( !empty( $extra_data['user_data'] ) )
	    return $extra_data['user_data']->user_url;
}
add_filter( 'mustache_variable_ec_website', 'wppb_ec_replace_website', 10, 4 );


/**
 * Function that filters and returns the users role in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_role( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if( isset( $extra_data['email_confirmation_unserialized_data']['role'] ) ) {
		return $extra_data['email_confirmation_unserialized_data']['role'];
	}

	if( ! empty( $extra_data['user_data'] ) ) {
		$user_role = implode( ', ', $extra_data['user_data']->roles );
		return $user_role;
	}

	if( ! empty ( $extra_data['user_id'] ) ) {
		$user_data = get_user_by( 'id', $extra_data['user_id'] );
		$user_role = implode( ', ', $user_data->roles );
		return $user_role;
	}
}
add_filter( 'mustache_variable_ec_role', 'wppb_ec_replace_role', 10, 4 );


/**
 * Function that filters and returns the users activation_key in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_activation_key( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['email_confirmation_key'] ) )
		return $extra_data['email_confirmation_key'];
}
add_filter( 'mustache_variable_ec_activation_key', 'wppb_ec_replace_activation_key', 10, 4 );


/**
 * Function that filters and returns the users activation_url in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_activation_url( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['email_confirmation_url'] ) )
		return $extra_data['email_confirmation_url'];
}
add_filter( 'mustache_variable_ec_activation_url', 'wppb_ec_replace_activation_url', 10, 4 );


/**
 * Function that filters and returns the users activation_link in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_activation_link( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['email_confirmation_url'] ) )
		return '<a href="'.$extra_data['email_confirmation_url'].'" target="_blank">'.$extra_data['email_confirmation_url'].'</a>';
}
add_filter( 'mustache_variable_ec_activation_link', 'wppb_ec_replace_activation_link', 10, 4 );


/**
 * Function that filters and returns the users reset_key in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_reset_key( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['reset_key'] ) )
		return $extra_data['reset_key'];
}
add_filter( 'mustache_variable_ec_reset_key', 'wppb_ec_replace_reset_key', 10, 4 );


/**
 * Function that filters and returns the users reset_url in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_reset_url( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['reset_url'] ) )
		return $extra_data['reset_url'];
}
add_filter( 'mustache_variable_ec_reset_url', 'wppb_ec_replace_reset_url', 10, 4 );


/**
 * Function that filters and returns the users reset_link in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_reset_link( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['reset_url'] ) )
		return '<a href="'.$extra_data['reset_url'].'" target="_blank">'.$extra_data['reset_url'].'</a>';
}
add_filter( 'mustache_variable_ec_reset_link', 'wppb_ec_replace_reset_link', 10, 4 );


/**
 * Function that filters and returns the users user_meta values in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_user_meta( $value, $merge_tag_name, $merge_tag, $extra_data ){
	if ( isset( $extra_data['email_confirmation_unserialized_data'][$merge_tag_name] ) )
		return $extra_data['email_confirmation_unserialized_data'][$merge_tag_name];

    if( !empty( $extra_data['user_id'] ) )
	    return get_user_meta( $extra_data['user_id'], $merge_tag_name, true );
}
add_filter( 'mustache_variable_ec_user_meta', 'wppb_ec_replace_user_meta', 10, 4 );


/**
 * Function that filters and returns the users user_meta labels in the Email Customizer
 *
 * @since v.2.0
 *
 * @param string $value
 * @param string $merge_tag_name
 * @param string $merge_tag
 * @param array $extra_data
 *
 * @return string
 */
function wppb_ec_replace_user_meta_labels( $value, $merge_tag_name, $merge_tag, $extra_data ){
    /* we remove _labels from end so we get the meta name */
    $merge_tag_name = preg_replace( '/_labels$/', '', $merge_tag_name, 1 );

    if ( isset( $extra_data['email_confirmation_unserialized_data'][$merge_tag_name] ) )
        $value = $extra_data['email_confirmation_unserialized_data'][$merge_tag_name];
    if( !empty( $extra_data['user_id'] ) )
        $value = get_user_meta( $extra_data['user_id'], $merge_tag_name, true );

    /* get label from value */
    /* get manage fields */
    $fields = get_option( 'wppb_manage_fields', 'not_found' );
    if( !empty( $fields ) ) {
        foreach ($fields as $field) {
            if( $field['meta-name'] == $merge_tag_name ){
                /* get label corresponding to value. the values and labels in the backend settings are comma separated so we assume that as well here ? */
                $saved_values = array_map( 'trim', explode( ',', $value ) );
                $field['options'] = array_map( 'trim', explode( ',', $field['options'] ) );
                $field['labels'] = array_map( 'trim', explode( ',', $field['labels'] ) );
                /* get the position for each value */
                $key_array = array();
                if( !empty( $field['options'] ) ){
                    foreach( $field['options'] as $key => $option ){
                        if( in_array( $option, $saved_values ) )
                            $key_array[] = $key;
                    }
                }

                $show_values = array();
                if( !empty( $key_array ) ){
                    foreach( $key_array as $key ){
                        if( !empty( $field['labels'][$key] ) )
                            $show_values[] = $field['labels'][$key];
                        else
                            $show_values[] = $field['options'][$key];
                    }
                }

                return implode( ',', $show_values );
            }
        }
    }
}
add_filter( 'mustache_variable_ec_user_meta_labels', 'wppb_ec_replace_user_meta_labels', 10, 4 );

// function that filters the From email address
function wppb_website_email($sender_email){
    $wppb_addonOptions = get_option( 'wppb_module_settings' );

    if ( ( $wppb_addonOptions['wppb_emailCustomizer'] == 'show' ) || ( $wppb_addonOptions['wppb_emailCustomizerAdmin'] == 'show' ) ){
        $reply_to_email = get_option( 'wppb_emailc_common_settings_from_reply_to_email', 'not_found' );
        if ( $reply_to_email != 'not_found' ) {
            $reply_to_email = str_replace('{{reply_to}}', get_bloginfo('admin_email'), $reply_to_email );
            if( is_email( $reply_to_email ) )
                $sender_email = $reply_to_email;
        }
    }

    return $sender_email;
}

// function that filters the From name
function wppb_website_name($site_name){
    $wppb_addonOptions = get_option( 'wppb_module_settings' );

    if ( ( $wppb_addonOptions['wppb_emailCustomizer'] == 'show' ) || ( $wppb_addonOptions['wppb_emailCustomizerAdmin'] == 'show' ) ){
        $email_from_name = get_option( 'wppb_emailc_common_settings_from_name', 'not_found' );
        if ( $email_from_name != 'not_found' ) {
            $email_from_name = str_replace('{{site_name}}', get_bloginfo('name'), $email_from_name );
            $site_name = $email_from_name;
        }
    }

    return $site_name;
}

// Function that changes email headers only when they are needed.
function wppb_change_email_from_headers(){
	add_filter('wp_mail_from_name','wppb_website_name', 20, 1);
	add_filter('wp_mail_from','wppb_website_email', 20, 1);
}