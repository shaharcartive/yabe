<?php
/* handle field output */
function wppb_timezone_select_handler( $output, $form_location, $field, $user_id, $field_check_errors, $request_data ){
	if ( $field['field'] == 'Select (Timezone)' ){
		$item_title = apply_filters( 'wppb_'.$form_location.'_timezone_select_custom_field_'.$field['id'].'_item_title', wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_title_translation', $field['field-title'] ) );
		$item_description = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_description_translation', $field['description'] );

		$timezone_array = apply_filters( 'wppb_'.$form_location.'_timezone_select_array', array ( '(GMT -12:00) Eniwetok, Kwajalein', '(GMT -11:00) Midway Island, Samoa', '(GMT -10:00) Hawaii', '(GMT -9:00) Alaska', '(GMT -8:00) Pacific Time (US &amp; Canada)', '(GMT -7:00) Mountain Time (US &amp; Canada)', '(GMT -6:00) Central Time (US &amp; Canada), Mexico City', '(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima', '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz', '(GMT -3:30) Newfoundland', '(GMT -3:00) Brazil, Buenos Aires, Georgetown', '(GMT -2:00) Mid-Atlantic', '(GMT -1:00) Azores, Cape Verde Islands', '(GMT) Western Europe Time, London, Lisbon, Casablanca', '(GMT +1:00) Brussels, Copenhagen, Madrid, Paris', '(GMT +2:00) Kaliningrad, South Africa', '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg', '(GMT +3:30) Tehran', '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi', '(GMT +4:30) Kabul', '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent', '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi', '(GMT +5:45) Kathmandu', '(GMT +6:00) Almaty, Dhaka, Colombo', '(GMT +7:00) Bangkok, Hanoi, Jakarta', '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong', '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk', '(GMT +9:30) Adelaide, Darwin', '(GMT +10:00) Eastern Australia, Guam, Vladivostok', '(GMT +11:00) Magadan, Solomon Islands, New Caledonia', '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka' ) );

        if( $form_location != 'register' )
		    $input_value = ( ( wppb_user_meta_exists ( $user_id, $field['meta-name'] ) != null ) ? get_user_meta( $user_id, $field['meta-name'], true ) : '' );
		else
            $input_value = '';

        $input_value = ( isset( $request_data[$field['meta-name']] ) ? trim( $request_data[$field['meta-name']] ) : $input_value );
		
		if ( $form_location != 'back_end' ){
			$error_mark = ( ( $field['required'] == 'Yes' ) ? '<span class="wppb-required" title="'.wppb_required_field_error($field["field-title"]).'">*</span>' : '' );
						
			if ( array_key_exists( $field['id'], $field_check_errors ) )
				$error_mark = '<img src="'.WPPB_PLUGIN_URL.'assets/images/pencil_delete.png" title="'.wppb_required_field_error($field["field-title"]).'"/>';

			$output = '
				<label for="'.$field['meta-name'].'">'.$item_title.$error_mark.'</label>
				<select name="'.$field['meta-name'].'" id="'.$field['meta-name'].'" class="custom_field_timezone_select">';
				
				foreach( $timezone_array as $timezone ){
					$output .= '<option value="'.$timezone.'"';
					
					if ( $input_value === $timezone )
						$output .= ' selected';
						
					$output .= '>'.$timezone.'</option>';
				}
				
				$output .= '
				</select>';
            if( !empty( $item_description ) )
                $output .= '<span class="wppb-description-delimiter">'.$item_description.'</span>';

		}else{
            $item_title = ( ( $field['required'] == 'Yes' ) ? $item_title .' <span class="description">('. __( 'required', 'profilebuilder' ) .')</span>' : $item_title );
			$output = '
				<table class="form-table">
					<tr>
						<th><label for="'.$field['meta-name'].'">'.$item_title.'</label></th>
						<td>
							<select name="'.$field['meta-name'].'" class="custom_field_timezone_select" id="'.$field['meta-name'].'">';
							
							foreach( $timezone_array as $timezone ){
								$output .= '<option value="'.$timezone.'"';
								
								if ( $input_value === $timezone )
									$output .= ' selected';
									
								$output .= '>'.$timezone.'</option>';
							}
							
							$output .= '</select>
							<span class="description">'.$item_description.'</span>
						</td>
					</tr>
				</table>';
		}
			
		return apply_filters( 'wppb_'.$form_location.'_timezone_select_custom_field_'.$field['id'], $output, $form_location, $field, $user_id, $field_check_errors, $request_data, $input_value );
	}
}
add_filter( 'wppb_output_form_field_select-timezone', 'wppb_timezone_select_handler', 10, 6 );
add_filter( 'wppb_admin_output_form_field_select-timezone', 'wppb_timezone_select_handler', 10, 6 );


/* handle field save */
function wppb_save_timezone_select_value( $field, $user_id, $request_data, $form_location ){
	if( $field['field'] == 'Select (Timezone)' ){
		if ( isset( $request_data[$field['meta-name']] ) )
			update_user_meta( $user_id, $field['meta-name'], $request_data[$field['meta-name']] );
	}
}
add_action( 'wppb_save_form_field', 'wppb_save_timezone_select_value', 10, 4 );
add_action( 'wppb_backend_save_form_field', 'wppb_save_timezone_select_value', 10, 4 );


/* handle field validation */
function wppb_check_timezone_select_value( $message, $field, $request_data, $form_location ){
	if( $field['field'] == 'Select (Timezone)' ){
		if ( ( isset( $request_data[$field['meta-name']] ) && ( trim( $request_data[$field['meta-name']] ) == '' ) ) && ( $field['required'] == 'Yes' ) ){
			return wppb_required_field_error($field["field-title"]);
		}
	}

    return $message;
}
add_filter( 'wppb_check_form_field_select-timezone', 'wppb_check_timezone_select_value', 10, 4 );