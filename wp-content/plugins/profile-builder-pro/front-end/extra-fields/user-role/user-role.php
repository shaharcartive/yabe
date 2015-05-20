<?php
/* handle field output */
function wppb_user_role_handler( $output, $form_location, $field, $user_id, $field_check_errors, $request_data ){
    if ( $field['field'] == 'Select (User Role)' ){
        $input_value =  isset( $request_data['custom_field_user_role'] ) ? $request_data['custom_field_user_role'] : '';

        $item_title = apply_filters( 'wppb_'.$form_location.'_user_role_custom_field_'.$field['id'].'_item_title', wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_title_translation', $field['field-title'] ) );
        $item_description = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_description_translation', $field['description'] );

        //get user roles
        if( !empty( $field['user-roles'] ) ) {
            global $wp_roles;

            $available_user_roles = explode( ', ', $field['user-roles'] );

            foreach( $available_user_roles as $key => $role_slug ) {
                if( isset( $wp_roles->roles[$role_slug]['name'] ) ) {
                    $available_user_roles[$key] = array(
                        'slug' => $role_slug,
                        'name' => $wp_roles->roles[$role_slug]['name']
                    );
                } else {
                    unset( $available_user_roles[$key] );
                }
            }
        }

        if( $form_location == 'register' ) {
            $error_mark = ( ( $field['required'] == 'Yes' ) ? '<span class="wppb-required" title="'.wppb_required_field_error($field["field-title"]).'">*</span>' : '' );

            if ( array_key_exists( $field['id'], $field_check_errors ) )
                $error_mark = '<img src="'.WPPB_PLUGIN_URL.'assets/images/pencil_delete.png" title="'.wppb_required_field_error($field["field-title"]).'"/>';

            $output = '
				<label for="custom_field_user_role">'.$item_title.$error_mark.'</label>
				<select name="custom_field_user_role" id="'.$field['meta-name'].'" class="custom_field_user_role">';

                if( !empty( $available_user_roles ) ) {
                    foreach( $available_user_roles as $user_role ){
                        $output .= '<option value="'. $user_role['slug'] .'"';

						$output .= selected( $input_value, $user_role['slug'], false );

                        $output .= '>'. $user_role['name'] .'</option>';
                    }
                }

				$output .= '</select>';

            if( !empty( $item_description ) )
                $output .= '<span class="wppb-description-delimiter">'.$item_description.'</span>';
        }

        return apply_filters( 'wppb_'.$form_location.'_user_role_custom_field_'.$field['id'], $output, $form_location, $field, $user_id, $field_check_errors, $request_data, $input_value );
    }
}
add_filter( 'wppb_output_form_field_select-user-role', 'wppb_user_role_handler', 10, 6 );


/* handle field validation */
function wppb_check_user_role_value( $message, $field, $request_data, $form_location ) {
    if( $form_location != 'register' )
        return;

    if( $field['field'] == 'Select (User Role)' ){

        if ( ( isset( $request_data[$field['meta-name']] ) && ( trim( $request_data[$field['meta-name']] ) == '' ) ) && ( $field['required'] == 'Yes' ) ){
            return wppb_required_field_error($field["field-title"]);
        }

        if( isset( $field['user-roles'] ) ) {
            $available_user_roles = explode(', ', $field['user-roles'] );

            if( !in_array( $request_data['custom_field_user_role'], $available_user_roles ) ) {
                return __( 'You cannot register this user role', 'profilebuilder');
            }
        }

    }

    return $message;
}
add_filter( 'wppb_check_form_field_select-user-role', 'wppb_check_user_role_value', 10, 4 );


/* handle field save */
function wppb_userdata_add_user_role( $userdata, $global_request ){

    if ( isset( $global_request['custom_field_user_role'] ) )
        $userdata['role'] = sanitize_text_field( trim( $global_request['custom_field_user_role'] ) );

    return $userdata;
}
add_filter( 'wppb_build_userdata', 'wppb_userdata_add_user_role', 10, 2 );