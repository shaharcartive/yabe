<?php
/* handle field output */
function wppb_upload_handler( $output, $form_location, $field, $user_id, $field_check_errors, $request_data ){
	if ( $field['field'] == 'Upload' ){
		$item_title = apply_filters( 'wppb_'.$form_location.'_upload_custom_field_'.$field['id'].'_item_title', wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_title_translation', $field['field-title'] ) );
		$item_description = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_description_translation', $field['description'] );

        if( $form_location != 'register' )
		    $input_value = ( ( wppb_user_meta_exists ( $user_id, $field['meta-name'] ) != null ) ? get_user_meta( $user_id, $field['meta-name'], true ) : '' );
        else
            $input_value = '';

            $wppb_nonce = wp_create_nonce( 'user'.$user_id.'_nonce_upload' );
		
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
						if ( ( $input_value == '' ) || ( $input_value == $wp_upload_array['baseurl'].'/profile_builder/attachments/' ) ){
							$output .= '<span class="wppb-upload-nofile">'.__( 'Current file: No uploaded attachment', 'profilebuilder' ) . ' </span>';
						}else{
							if ( $field['required'] == 'Yes' ) {
								$output .= '<span class="wppb-upload-file">';
								$output .= __( 'Current file', 'profilebuilder').': ';
								$output .= str_replace( $wp_upload_array['baseurl'].'/profile_builder/attachments/userID_'.$user_id.'_attachment_', '', $input_value );
								$output .= '<a href="'.$input_value.'" target="_blank" class="wppb-attachment">';
								$output .= '<img class="wppb-file-icons" src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'attachment.png" title="'. __( 'Click to see the current attachment', 'profilebuilder' ) .'">';
								$output .= '</a>';
								$output .= '<img class="wppb-file-icons" src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'icon_delete_disabled.png" title="' . __( "The attachment can't be deleted (It was marked as required by the administrator)", "profilebuilder" ) .'">';
								$output .= '</span>';
							} else {
								$output .= '<span class="wppb-upload-file">';
								$output .= __( 'Current file', 'profilebuilder').': ';
								$output .= str_replace( $wp_upload_array['baseurl'].'/profile_builder/attachments/userID_'.$user_id.'_attachment_', '', $input_value );
								$output .= '<a href="'.$input_value.'" target="_blank" class="wppb-attachment">';
								$output .= '<img class="wppb-file-icons" src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'attachment.png" title="'. __( 'Click to see the current attachment', 'profilebuilder' ) .'">';
								$output .= '</a>';
								$output .= '<a href="javascript:confirmDelete(\''.$wppb_nonce.'\',\''.base64_encode( $user_id ).'\',\''.base64_encode( $field['id'] ).'\',\''.base64_encode( $field['meta-name'] ).'\',\''.get_permalink().'\',\''. admin_url('admin-ajax.php') .'\',\'attachment\',\''.str_replace( $wp_upload_array['baseurl'].'/profile_builder/attachments/userID_'.$user_id.'_attachment_', '', $input_value ).'\',\''.__( 'Are you sure you want to delete this attachment?', 'profilebuilder' ).'\')" class="wppb-dattachment">';
								$output .= '<img class="wppb-file-icons" src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'icon_delete.png" title="'. __( 'Click to delete the current attachment', 'profilebuilder' ) .'">';
								$output .= '</a>';
								$output .= '</span>';
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
						<input name="'.$field['meta-name'].'" class="custom_field_upload" id="'.$field['meta-name'].'" size="40" type="file" /><font color="grey" size="1">('.__( 'max upload size', 'profilebuilder' ) .' '.WPPB_SERVER_MAX_UPLOAD_SIZE_MEGA.'b)</font>
						<br/><span class="wppb-description-delimiter">'.$item_description;
						if ( ($input_value == '') || ($input_value == $wp_upload_array['baseurl'].'/profile_builder/attachments/') ){
							$output .= '</span><span class="wppb-description-delimiter"><u>'. __( 'Current file', 'profilebuilder' ) .'</u>: </span><span style="padding-left:5px"></span><span class="wppb-description-delimiter"><i>'. __( 'No uploaded attachment', 'profilebuilder' ) .'</i></span>';
						
						}else{
							if ( $field['required'] == 'Yes' ){
								$output .= '<u>'.__( 'Current file', 'profilebuilder' ).'</u>: <span style="padding-left:10px"></span>'.str_replace( $wp_upload_array['baseurl'].'/profile_builder/attachments/userID_'.$user_id.'_attachment_', '', $input_value ).'<span style="padding-left:10px"></span><a href="'.$input_value.'" target="_blank"><img src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'attachment.png" title="'.__('Click to see the current attachment', 'profilebuilder').'"></a><span style="padding-left:10px"></span><img src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'icon_delete_disabled.png" title="'.__( "The attachment can't be deleted (It was marked as required by the administrator)", "profilebuilder" ).'">';
							} else {
								$output .= '<u>'.__( 'Current file', 'profilebuilder' ).'</u>: <span style="padding-left:10px"></span>'.str_replace( $wp_upload_array['baseurl'].'/profile_builder/attachments/userID_'.$user_id.'_attachment_', '', $input_value ).'<span style="padding-left:10px"></span><a href="'.$input_value.'" target="_blank"><img src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'attachment.png" title="'.__('Click to see the current attachment', 'profilebuilder').'"></a><span style="padding-left:10px"></span><a href="javascript:confirmDelete(\''.$wppb_nonce.'\',\''.base64_encode( $user_id ).'\',\''.base64_encode( $field['id'] ).'\',\''.base64_encode( $field['meta-name'] ).'\',\''.get_permalink().'\',\''. admin_url('admin-ajax.php') .'\',\'attachment\',\''.str_replace( $wp_upload_array['baseurl'].'/profile_builder/attachments/userID_'.$user_id.'_attachment_', '', $input_value ).'\',\''.__( 'Are you sure you want to delete this attachment?', 'profilebuilder' ).'\')"><img src="'.( substr( WPPB_PLUGIN_URL, -1 ) == '/' ? WPPB_PLUGIN_URL . 'assets/images/' : WPPB_PLUGIN_URL . '/assets/images/' ).'icon_delete.png" title="'.__( 'Click to delete the current attachment', 'profilebuilder' ).'"></a>';
							}
						}
						
						$output .= '
						</td>
					</tr>
				</table>';
		}
			
		return apply_filters( 'wppb_'.$form_location.'_upload_custom_field_'.$field['id'], $output, $form_location, $field, $user_id, $field_check_errors, $request_data, $input_value );
	}
}
add_filter( 'wppb_output_form_field_upload', 'wppb_upload_handler', 10, 6 );
add_filter( 'wppb_admin_output_form_field_upload', 'wppb_upload_handler', 10, 6 );


/* handle field save */
function wppb_save_upload_value( $field, $user_id, $request_data, $form_location ){
	if( $field['field'] == 'Upload' ){
		if ( isset( $_FILES[$field['meta-name']] ) && ( basename( $_FILES[$field['meta-name']]['name'] ) != '' ) ){
			if ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 0 ) ){
				if ( ( $_FILES[$field['meta-name']]['size'] < WPPB_SERVER_MAX_UPLOAD_SIZE_BYTE ) && ( $_FILES[$field['meta-name']]['size'] !== 0 ) ){
					$wp_upload_array = wp_upload_dir(); // Array of key => value pairs
					
					$safe_filename = preg_replace( array( "/\s+/", "/[^-\.\w]+/" ), array( "_", "" ), trim( $_FILES[$field['meta-name']]['name'] ) );
					$target_path = $wp_upload_array['basedir'].'/profile_builder/attachments/userID_'.$user_id.'_attachment_'.$safe_filename; //create the target path for uploading

					if ( PHP_OS == "WIN32" || PHP_OS == "WINNT" )
						$target_path = str_replace( '\\', '/', $target_path );
					
					if ( move_uploaded_file( $_FILES[$field['meta-name']]['tmp_name'], $target_path ) ){
						$uploaded_file = $wp_upload_array['baseurl'].'/profile_builder/attachments/userID_'.$user_id.'_attachment_'.$safe_filename;
						update_user_meta( $user_id, $field['meta-name'], $uploaded_file );
					}
				}
			}
		}
	}
}
add_action( 'wppb_save_form_field', 'wppb_save_upload_value', 10, 4 );
add_action( 'wppb_backend_save_form_field', 'wppb_save_upload_value', 10, 4 );


function wppb_add_upload_for_user_signup( $field_value, $field, $request_data ){
	if( $field['field'] == 'Upload' ){
		if ( isset( $_FILES[$field['meta-name']] ) && ( basename( $_FILES[$field['meta-name']]['name'] ) != '' ) ){
			if ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 0 ) ){
				if ( ( $_FILES[$field['meta-name']]['size'] < WPPB_SERVER_MAX_UPLOAD_SIZE_BYTE ) && ( $_FILES[$field['meta-name']]['size'] !== 0 ) ){
					$wp_upload_array = wp_upload_dir(); // Array of key => value pairs
					
					$random_user_number = apply_filters( 'wppb_register_wpmu_upload_random_user_number', substr( md5( $request_data['email'] ), 0, 12 ), $request_data );
					
					$safe_filename = preg_replace( array( "/\s+/", "/[^-\.\w]+/" ), array( "_", "" ), trim( $_FILES[$field['meta-name']]['name'] ) );
					$target_path = $wp_upload_array['basedir'].'/profile_builder/attachments/wpmuRandomID_'.$random_user_number.'_attachment_'.$safe_filename; //create the target path for uploading

					if ( move_uploaded_file( $_FILES[$field['meta-name']]['tmp_name'], $target_path ) )
						return $wp_upload_array['baseurl'].'/profile_builder/attachments/wpmuRandomID_'.$random_user_number.'_attachment_'.$safe_filename;
				}
			}
		}
	}
}
add_filter( 'wppb_add_to_user_signup_form_field_upload', 'wppb_add_upload_for_user_signup', 10, 3 );


/* handle field validation */
function wppb_check_upload_value( $message, $field, $request_data, $form_location ){
	if( $field['field'] == 'Upload' ){
		if ( isset( $_FILES[$field['meta-name']] ) && ( basename( $_FILES[$field['meta-name']]['name'] ) != '' ) ){
			if ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 0 ) ){
				if ( ( $_FILES[$field['meta-name']]['size'] < WPPB_SERVER_MAX_UPLOAD_SIZE_BYTE ) && ( $_FILES[$field['meta-name']]['size'] !== 0 ) ){
					if ( trim( $field['allowed-upload-extensions'] ) == '.*' || trim( $field['allowed-upload-extensions'] ) == '' ){
						//valid file, ready to upload
                        $wp_allowed_mime_types = get_allowed_mime_types();
                        $wp_allowed_extensions = array();
                        if( !empty( $wp_allowed_mime_types ) ){
                            foreach( $wp_allowed_mime_types as $extension => $wp_allowed_mime_type ){
                                if( strpos( $extension, '|' ) !== false ){
                                    $extension_split = explode( '|', $extension );
                                    $wp_allowed_extensions = array_merge( $wp_allowed_extensions, $extension_split );
                                }
                                else
                                    $wp_allowed_extensions[] = $extension;
                            }
                        }
                        if ( !in_array( strtolower( pathinfo( $_FILES[$field['meta-name']]['name'], PATHINFO_EXTENSION ) ), array_map( 'strtolower', $wp_allowed_extensions ) ) )
                            return __( "The extension of the file is not allowed", "profilebuilder" ).' ('.pathinfo( $_FILES[$field['meta-name']]['name'], PATHINFO_EXTENSION ).')';
					
					}else{
						$allowed_extensions_array = str_replace( '.', '', array_map ( 'trim', explode( ',', $field['allowed-upload-extensions'] ) ) );
						
						if ( in_array( strtolower( pathinfo( $_FILES[$field['meta-name']]['name'], PATHINFO_EXTENSION ) ), array_map( 'strtolower', $allowed_extensions_array ) ) ){
							//valid file, ready to upload
							
						}else
							return __( "The extension of the file did not match", "profilebuilder" ).' ('.$field['allowed-upload-extensions'].')';
					}
					
				}else
					return __( "The file uploaded exceeds the upload_max_filesize directive in php.ini", "profilebuilder" );
			
			}elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 1 ) )
				return __( "The file uploaded exceeds the upload_max_filesize directive in php.ini", "profilebuilder" );
				
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 2 ) )
				return __( "The file uploaded exceeds the MAX_FILE_SIZE directive in php.ini", "profilebuilder" );
			
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 3 ) )
				return __( "The file could only partially be uploaded", "profilebuilder" );
				
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 4 ) )
				return __( "No file was selected", "profilebuilder" );
			
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 6 ) )
				return __( "The temporary upload folder is missing from the system", "profilebuilder" );
			
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 7 ) )
				return __( "The file failed to write to the disk", "profilebuilder" );
			
			elseif ( isset( $_FILES[$field['meta-name']]['error'] ) && ( $_FILES[$field['meta-name']]['error'] === 8 ) )
				return __( "A PHP extension stopped the file upload", "profilebuilder" );
				
			else
				return __( "This field wasn't updated because an unknown error occured", "profilebuilder" );
		
		}elseif ( $field['required'] == 'Yes' ){
			if ( $form_location == 'edit_profile' ){
                if( isset( $_GET['edit_user'] ) && ! empty( $_GET['edit_user'] ) )
                    $current_user_id = $_GET['edit_user'];
                else
				    $current_user_id = get_current_user_id();
				
				$uploaded_file = get_user_meta( $current_user_id, $field['meta-name'], true );
				
				if ( !isset( $uploaded_file ) || ( trim( $uploaded_file ) == '' ) )
					return __( "No file was selected", "profilebuilder" );
				
			}elseif ( $form_location == 'register' )
				return __( "No file was selected", "profilebuilder" );
		}
	}

    return $message;
}
add_filter( 'wppb_check_form_field_upload', 'wppb_check_upload_value', 10, 4 );