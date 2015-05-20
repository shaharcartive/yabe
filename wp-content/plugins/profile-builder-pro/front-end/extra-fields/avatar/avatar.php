<?php
/* handle field output */
function wppb_avatar_handler( $output, $form_location, $field, $user_id, $field_check_errors, $request_data ){
	if ( $field['field'] == 'Avatar' ){
		$item_title = apply_filters( 'wppb_'.$form_location.'_avatar_custom_field_'.$field['id'].'_item_title', wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_title_translation', $field['field-title'] ) );
		$item_description = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_description_translation', $field['description'] );

        if( $form_location != 'register' )
		    $input_value = ( ( wppb_user_meta_exists ( $user_id, $field['meta-name'] ) != null ) ? get_user_meta( $user_id, $field['meta-name'], true ) : '' );
        else
            $input_value = '';

		$resized_avatar = ( ( wppb_user_meta_exists ( $user_id, 'resized_avatar_'.$field['meta-name'] ) != null ) ? get_user_meta( $user_id, 'resized_avatar_'.$field['meta-name'], true ) : '' );

		if ( $input_value != '' ){
			if ( $resized_avatar == '' ){
				wppb_resize_avatar( $user_id );
				$resized_avatar = get_user_meta( $user_id, 'resized_avatar_'.$field['id'], true );
				
			}

            $resized_avatar_path = get_user_meta( $user_id, 'resized_avatar_'.$field['id'].'_relative_path', true );

            if( file_exists( $resized_avatar_path ) ) {

                if( !empty( $resized_avatar_path ) ) {
                    $avatar_image_info = getimagesize($resized_avatar_path);

                    if (is_array($avatar_image_info)) {
                        if (($avatar_image_info[0] != trim($field['avatar-size'])) || ($avatar_image_info[1] != trim($field['avatar-size']))) {
                            wppb_resize_avatar($user_id);

                            $resized_avatar = get_user_meta($user_id, 'resized_avatar_' . $field['id'], true);
                        }
                    }
                }

            } else {
                // if the file doesn't exist on the server for some reason display to the user the default wp avatar
                $resized_avatar_path = 'https://secure.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536';
                $resized_avatar = $resized_avatar_path;
                $avatar_image_info = getimagesize( $resized_avatar_path );

                $avatar_exists = false;
            }
		}

		$wppb_nonce = wp_create_nonce( 'user'.$user_id.'_nonce_avatar' );
		
		$wp_upload_array = wp_upload_dir(); // Array of key => value pairs

		if ( $form_location != 'back_end' ){
			$error_mark = ( ( $field['required'] == 'Yes' ) ? '<span class="wppb-required" title="'.wppb_required_field_error($field["field-title"]).'">*</span>' : '' );
						
			if ( array_key_exists( $field['id'], $field_check_errors ) )
				$error_mark = '<img src="'.WPPB_PLUGIN_URL.'assets/images/pencil_delete.png" title="'.wppb_required_field_error($field["field-title"]).'"/>';
				
				$output = '
					<label for="'.$field['meta-name'].'">'.$item_title.$error_mark.'</label>
					<input name="'.$field['meta-name'].'" class="custom_field_upload" id="'.$field['meta-name'].'" size="30" type="file" /><span class="wppb-max-upload">('.__( 'max upload size', 'profilebuilder' ).' '.WPPB_SERVER_MAX_UPLOAD_SIZE_MEGA.'b)</span>';
            if( !empty( $item_description ) )
                $output .= '<span class="wppb-description-delimiter">'.$item_description.'</span>';
					
					if ( $form_location == 'edit_profile' ){
						if ( ( $input_value == '' ) || ( $input_value == $wp_upload_array['baseurl'].'/profile_builder/avatars/' ) ){
							$output .= '<span class="wppb-avatar-nofile">'. __( 'Current avatar: No uploaded avatar', 'profilebuilder' ) . '</span>';
						
						}else{
							//display the resized image
							$output .= '<span class="wppb-avatar-file">';
							$output .= '<img class="avatar-imagen" src="'.$resized_avatar.'" title="'.__( 'Avatar', 'profilebuilder' ).'" alt="'.__( 'Avatar', 'profilebuilder' ).'" height='.$avatar_image_info[1].' width='.$avatar_image_info[0].'>';
							$output .= '</span>';
														
							if ( $field['required'] == 'Yes' ) {
								$output .= '<a href="'.$input_value.'" target="_blank" class="wppb-cattachment">';
								$output .= '<img class="wppb-file-icons" src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'attachment.png" title="'. __( 'Click to see the current avatar', 'profilebuilder' ) .'">';
								$output .= '</a>';
								$output .= '<img class="wppb-file-icons" src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'icon_delete_disabled.png" title="'. __( "The avatar can't be deleted (It was marked as required by the administrator)", "profilebuilder" ) .'">';
							} else {

								$output .= '<a href="javascript:confirmDelete(\''.$wppb_nonce.'\',\''.base64_encode( $user_id ).'\',\''.base64_encode( $field['id'] ).'\',\''.base64_encode( $field['meta-name'] ).'\',\''.get_permalink().'\',\''. admin_url('admin-ajax.php') .'\',\'avatar\',\'\',\''.__( 'Are you sure you want to delete this avatar?', 'profilebuilder' ).'\')" class="wppb-dattachment">';
								$output .= '<img class="wppb-file-icons" src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'icon_delete.png" title="'.__( 'Click to delete the current avatar', 'profilebuilder' ).'">';
								$output .= '</a>';
							}

						}
					}

		}else{
            $item_title = ( ( $field['required'] == 'Yes' ) ? $item_title .' <span class="description">('. __( 'required', 'profilebuilder' ) .')</span>' : $item_title );

			$output = '
				<table class="form-table">
					<tr>
						<th><label for="'.$field['meta-name'].'">'.$item_title.'</label></th>
						<td>
						<input name="'.$field['meta-name'].'" class="custom_field_upload" id="'.$field['meta-name'].'" size="40" type="file" /><font color="grey" size="1">('. __('max upload size', 'profilebuilder') .' '.WPPB_SERVER_MAX_UPLOAD_SIZE_MEGA.'b)</font>
						<br/><span class="wppb-description-delimiter">'.$item_description;
						if ( ( $input_value == '' ) || ( $input_value == $wp_upload_array['baseurl'].'/profile_builder/avatars/' ) ){
							$output .= '</span><span class="wppb-description-delimiter"><u>'.__( 'Current avatar', 'profilebuilder' ).'</u>: </span><span style="padding-left:5px"></span><span class="wppb-description-delimiter"><i>'. __( 'No uploaded avatar', 'profilebuilder' ) .'</i></span>';

						}else{
							//display the resized image
							$output .= '</span><br/><img src="'.$resized_avatar.'" title="'.__( 'Avatar', 'profilebuilder' ).'" alt="'.__( 'Avatar', 'profilebuilder' ).'" height='.$avatar_image_info[1].' width='.$avatar_image_info[0].'>';

							if ( $field['required'] == 'Yes' )
								$output .= '<span style="padding-left:10px"><a href="'.$input_value.'" target="_blank" class="wppb-cattachment"><img src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'attachment.png" title="'. __( 'Click to see the current avatar', 'profilebuilder' ) .'"></a><span style="padding-left:10px"><img src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'icon_delete_disabled.png" title="'. __( "The avatar can't be deleted (It was marked as required by the administrator)", "profilebuilder" ) .'"></span>';
							else
								$output .= '<span style="padding-left:10px"><a href="'.$input_value.'" target="_blank" class="wppb-cattachment"><img src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'attachment.png" title="'. __( 'Click to see the current avatar', 'profilebuilder' ) .'"></a><span style="padding-left:10px"><a href="javascript:confirmDelete(\''.$wppb_nonce.'\',\''.base64_encode( $user_id ).'\',\''.base64_encode( $field['id'] ).'\',\''.base64_encode( $field['meta-name'] ).'\',\''.get_permalink().'\',\''. admin_url('admin-ajax.php') .'\',\'avatar\',\'\',\''.__( 'Are you sure you want to delete this avatar?', 'profilebuilder' ).'\')" class="wppb-dattachment"><img src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'icon_delete.png" title="'.__( 'Click to delete the current avatar', 'profilebuilder' ).'"></a></span>';
						}

						$output .= '
						</td>
					</tr>
				</table>';

            if( isset( $avatar_exists ) && $avatar_exists === false ) {
                $output .= '<div class="error"><p>' . sprintf( __( "The image file set in the %s field for this user could not be found on the server. The default WordPress avatar is being used at the moment.", "profilebuilder"), $field["field"] ) . '</p></div>';
            }
		}

		return apply_filters( 'wppb_'.$form_location.'_avatar_custom_field_'.$field['id'], $output, $form_location, $field, $user_id, $field_check_errors, $request_data, $input_value );
	}
}
add_filter( 'wppb_output_form_field_avatar', 'wppb_avatar_handler', 10, 6 );
add_filter( 'wppb_admin_output_form_field_avatar', 'wppb_avatar_handler', 10, 6 );


/* handle field save */
function wppb_save_avatar_value( $field, $user_id, $request_data, $form_location ){
	if( $field['field'] == 'Avatar' ){
		if ( isset( $_FILES[$field['meta-name']] ) && ( basename( $_FILES[$field['meta-name']]['name'] ) != '' ) ){
			if ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 0 ) ){
				if ( ( $_FILES[$field['meta-name']]['size'] < WPPB_SERVER_MAX_UPLOAD_SIZE_BYTE ) && ( $_FILES[$field['meta-name']]['size'] !== 0 ) ){
					//create the target path for uploading	
					$wp_upload_array = wp_upload_dir(); // Array of key => value pairs
					
					$safe_filename = preg_replace( array( "/\s+/", "/[^-\.\w]+/" ), array( "_", "" ), trim( $_FILES[$field['meta-name']]['name'] ) );
					$target_path = $wp_upload_array['basedir'].'/profile_builder/avatars/userID_'.$user_id.'_originalAvatar_'.$safe_filename;

					if ( PHP_OS == "WIN32" || PHP_OS == "WINNT" )
						$target_path = str_replace( '\\', '/', $target_path );
					
					if ( move_uploaded_file( $_FILES[$field['meta-name']]['tmp_name'], $target_path ) ){
						$wp_filetype = wp_check_filetype(basename( $_FILES[$field['meta-name']]['name']), null );
						
						$attachment = array(
							 'post_mime_type' => $wp_filetype['type'],
							 'post_title' => $safe_filename,
							 'post_content' => '',
							 'post_status' => 'inherit'
							);

						$attach_id = wp_insert_attachment( $attachment, $target_path );
				
						$uploaded_file = image_downsize( $attach_id, 'thumbnail' );
					
						update_user_meta( $user_id, $field['meta-name'], $uploaded_file[0] );
						update_user_meta( $user_id, 'avatar_directory_path_'.$field['id'], $target_path );
                        wppb_resize_avatar( $user_id );
					}
				}
			}
		}
	}
}
add_action( 'wppb_save_form_field', 'wppb_save_avatar_value', 10, 4 );
add_action( 'wppb_backend_save_form_field', 'wppb_save_avatar_value', 10, 4 );


function wppb_add_avatar_for_user_signup( $field_value, $field, $request_data ){
	if( $field['field'] == 'Avatar' ){
		if ( isset( $_FILES[$field['meta-name']] ) && ( basename( $_FILES[$field['meta-name']]['name'] ) != '' ) ){
			if ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 0 ) ){
				if ( ( $_FILES[$field['meta-name']]['size'] < WPPB_SERVER_MAX_UPLOAD_SIZE_BYTE ) && ( $_FILES[$field['meta-name']]['size'] !== 0 ) ){
					$wp_upload_array = wp_upload_dir(); // Array of key => value pairs
					
					$random_user_number = apply_filters( 'wppb_register_wpmu_avatar_random_user_number', substr( md5( $request_data['email'] ), 0, 12 ), $request_data );
					
					$safe_filename = preg_replace( array( "/\s+/", "/[^-\.\w]+/" ), array( "_", "" ), trim( $_FILES[$field['meta-name']]['name'] ) );
					$target_path = $wp_upload_array['basedir'].'/profile_builder/avatars/wpmuRandomID_'.$random_user_number.'_originalAvatar_'.$safe_filename; //create the target path for uploading

					if ( move_uploaded_file( $_FILES[$field['meta-name']]['tmp_name'], $target_path ) )
						return $wp_upload_array['baseurl'].'/profile_builder/avatars/wpmuRandomID_'.$random_user_number.'_originalAvatar_'.$safe_filename;
				}
			}
		}
	}	
}
add_filter( 'wppb_add_to_user_signup_form_field_avatar', 'wppb_add_avatar_for_user_signup', 10, 3 );

/* handle field validation */
function wppb_check_avatar_value( $message, $field, $request_data, $form_location ){
	if( $field['field'] == 'Avatar' ){
		if ( isset( $_FILES[$field['meta-name']] ) && ( basename( $_FILES[$field['meta-name']]['name'] ) != '' ) ){
			if ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 0 ) ){
				if ( ( $_FILES[$field['meta-name']]['size'] < WPPB_SERVER_MAX_UPLOAD_SIZE_BYTE ) && ( $_FILES[$field['meta-name']]['size'] !== 0 ) ){
					$allowed_extensions = ( ( trim( $field['allowed-image-extensions'] ) == '.*' ) ? '.jpg,.jpeg,.gif,.png' : $field['allowed-image-extensions'] );

					$allowed_extensions_array = str_replace( '.', '', array_map ( 'trim', explode( ',', $allowed_extensions ) ) );
					
					if ( in_array( strtolower( pathinfo( $_FILES[$field['meta-name']]['name'], PATHINFO_EXTENSION ) ), array_map( 'strtolower', $allowed_extensions_array ) ) ){
						//valid file, ready to upload
						
					}else
						return __( "The extension of the file did not match", "profilebuilder" ).' ('.$allowed_extensions.')';
					
				}else
					return __( "The file uploaded exceeds the upload_max_filesize directive in php.ini", "profilebuilder" );
			
			}elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 1 ) )
				return __( "The file uploaded exceeds the upload_max_filesize directive in php.ini", "profilebuilder" );
				
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 2 ) )
				return __( "The file uploaded exceeds the MAX_FILE_SIZE directive in php.ini", "profilebuilder" );
			
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 3 ) )
				return __( "The file could only partially be uploaded ", "profilebuilder" );
				
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 4 ) )
				return __( "No file was selected", "profilebuilder" );
			
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 6 ) )
				return __( "The temporary upload folder is missing from the system", "profilebuilder" );
			
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 7 ) )
				return __( "The file failed to write to the disk", "profilebuilder" );
			
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 8 ) )
				return __( "A PHP extension stopped the file upload", "profilebuilder" );
				
			else
				return __( "Unknown error occurred", "profilebuilder" );
		
		}elseif ( $field['required'] == 'Yes' ){
			if ( $form_location == 'edit_profile' ){
                if( isset( $_GET['edit_user'] ) && ! empty( $_GET['edit_user'] ) )
                    $current_user_id = $_GET['edit_user'];
                else
				    $current_user_id = get_current_user_id();
				
				$saved_avatar = get_user_meta( $current_user_id, $field['meta-name'], true );
				
				if ( !isset( $saved_avatar ) || ( trim( $saved_avatar ) == '' ) )
					return __( "No file was selected", "profilebuilder" );
				
			}elseif ( $form_location == 'register' )
				return __( "No file was selected", "profilebuilder" );
		}
	
	}
    return $message;
}
add_filter( 'wppb_check_form_field_avatar', 'wppb_check_avatar_value', 10, 4 );