<?php
/* handle field output */
function wppb_checkbox_handler( $output, $form_location, $field, $user_id, $field_check_errors, $request_data ){
	if ( $field['field'] == 'Checkbox' ){
		$item_title = apply_filters( 'wppb_'.$form_location.'_checkbox_custom_field_'.$field['id'].'_item_title', wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_title_translation', $field['field-title'] ) );
		$item_description = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_description_translation', $field['description'] );
		$item_option_labels = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_option_labels_translation', $field['labels'] );

		$checkbox_labels = explode( ',', $item_option_labels );
		$checkbox_values = explode( ',', $field['options'] );

        if( $form_location != 'register' )
		    $input_value = ( ( wppb_user_meta_exists ( $user_id, $field['meta-name'] ) != null ) ? array_map( 'trim', explode( ',', get_user_meta( $user_id, $field['meta-name'], true ) ) ) : array_map( 'trim', explode( ',', $field['default-options'] ) ) );
        else
            $input_value = ( !empty( $field['default-options'] ) ? array_map( 'trim', explode( ',', $field['default-options'] ) ) : array() );

		$checked_values = '';
		foreach ( array_map( 'trim', explode( ',', $field['options'] ) ) as $key => $value ){
			if ( isset( $request_data[Wordpress_Creation_Kit_PB::wck_generate_slug( $value ).'_'.$field['id']] ) )
				$checked_values .= $request_data[Wordpress_Creation_Kit_PB::wck_generate_slug( $value ).'_'.$field['id']].',';
		}
		$input_value = ( ( trim( $checked_values, ',' ) != '' ) ? array_map( 'trim', explode( ',', $checked_values ) ) : $input_value );
		
		if ( $form_location != 'back_end' ){
			$error_mark = ( ( $field['required'] == 'Yes' ) ? '<span class="wppb-required" title="'.wppb_required_field_error($field["field-title"]).'">*</span>' : '' );
						
			if ( array_key_exists( $field['id'], $field_check_errors ) )
				$error_mark = '<img src="'.WPPB_PLUGIN_URL.'assets/images/pencil_delete.png" title="'.wppb_required_field_error($field["field-title"]).'"/>';

			$output = '
				<label for="'.$field['meta-name'].'">'.$item_title.$error_mark.'</label>';
					$output .= '<ul class="wppb-checkboxes">';
					foreach( $checkbox_values as $key => $value ){
						$output .= '<li><input value="'.trim( $value ).'" class="custom_field_checkbox" name="'.Wordpress_Creation_Kit_PB::wck_generate_slug( trim( $value ) ).'_'.$field['id'].'" id="'.Wordpress_Creation_Kit_PB::wck_generate_slug( trim( $value ) ).'_'.$field['id'].'" type="checkbox"';
						
						if ( in_array( trim( $value ), $input_value ) )
							$output .= ' checked';

						$output .= ' /><label for="'.trim( $value ).'_'.$field['id'].'" class="wppb-rc-value">'.( ( !isset( $checkbox_labels[$key] ) || !$checkbox_labels[$key] ) ? trim( $checkbox_values[$key] ) : trim( $checkbox_labels[$key] ) ).'</label></li>';
					}
				$output .= '</ul>';
            if( !empty( $item_description ) )
                $output .= '<span class="wppb-description-delimiter">'.$item_description.'</span>';

		}else{
            $item_title = ( ( $field['required'] == 'Yes' ) ? $item_title .' <span class="description">('. __( 'required', 'profilebuilder' ) .')</span>' : $item_title );
			$output = '
				<table class="form-table">
					<tr>
						<th><label for="'.$field['meta-name'].'">'.$item_title.'</label></th>
						<td>';
						
						foreach( $checkbox_values as $key => $value ){
							$output .= '<li><input value="'.trim( $value ).'" class="custom_field_checkbox" name="'.Wordpress_Creation_Kit_PB::wck_generate_slug( trim( $value ) ).'_'.$field['id'].'" id="'.Wordpress_Creation_Kit_PB::wck_generate_slug( trim( $value ) ).'_'.$field['id'].'" type="checkbox"';
							
							if ( in_array( trim( $value ), $input_value ) )
								$output .= ' checked';

							$output .= ' /><span for="'.trim( $value ).'_'.$field['id'].'" class="wppb-rc-value">'.( ( !isset( $checkbox_labels[$key] ) || !$checkbox_labels[$key] ) ? trim( $checkbox_values[$key] ) : trim( $checkbox_labels[$key] ) ).'</label></li>';
						}

						$output .= '
						<span class="wppb-description-delimiter">'.$item_description.'</span>
						</td>
					</tr>
				</table>';
		}
			
		return apply_filters( 'wppb_'.$form_location.'_checkbox_custom_field_'.$field['id'], $output, $form_location, $field, $user_id, $field_check_errors, $request_data, $input_value );
	}
}
add_filter( 'wppb_output_form_field_checkbox', 'wppb_checkbox_handler', 10, 6 );
add_filter( 'wppb_admin_output_form_field_checkbox', 'wppb_checkbox_handler', 10, 6 );


/* handle field save */
function wppb_save_checkbox_value( $field, $user_id, $request_data, $form_location ){
	if( $field['field'] == 'Checkbox' ){		
		$checkbox_values = wppb_process_checkbox_value( $field, $request_data );			
		update_user_meta( $user_id, $field['meta-name'], $checkbox_values );
	}
}
add_action( 'wppb_save_form_field', 'wppb_save_checkbox_value', 10, 4 );
add_action( 'wppb_backend_save_form_field', 'wppb_save_checkbox_value', 10, 4 );


function wppb_process_checkbox_value( $field, $request_data ){
	$checkbox_values = '';
	if( !empty( $field['options'] ) ){
		foreach ( array_map( 'trim', explode( ',', $field['options'] ) ) as $key => $value ){
			if ( isset( $request_data[ Wordpress_Creation_Kit_PB::wck_generate_slug( $value ).'_'.$field['id']] ) )
				$checkbox_values .= $request_data[Wordpress_Creation_Kit_PB::wck_generate_slug( $value ).'_'.$field['id']].',';
		}


	}
	
	return trim( $checkbox_values, ',' );
}


function wppb_add_checkbox_for_user_signup( $field_value, $field, $request_data ){
	return wppb_process_checkbox_value( $field, $request_data );
}
add_filter( 'wppb_add_to_user_signup_form_field_checkbox', 'wppb_add_checkbox_for_user_signup', 10, 3 );


/* handle field validation */
function wppb_check_checkbox_value( $message, $field, $request_data, $form_location ){
	if( $field['field'] == 'Checkbox' ){
		$checked_values = '';
		foreach ( array_map( 'trim', explode( ',', $field['options'] ) ) as $key => $value ){
			if ( isset( $request_data[ Wordpress_Creation_Kit_PB::wck_generate_slug( $value ).'_'.$field['id']] ) )
				$checked_values .= $request_data[ Wordpress_Creation_Kit_PB::wck_generate_slug( $value ).'_'.$field['id']].',';
		}

		if ( ( $field['required'] == 'Yes' ) && ( trim( $checked_values, ',' ) == '' ) ){
			return wppb_required_field_error($field["field-title"]);
		}
	}

    return $message;
}
add_filter( 'wppb_check_form_field_checkbox', 'wppb_check_checkbox_value', 10, 4 );