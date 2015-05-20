<?php
/**
 * Encodes the given data into a query string format
 * @param $data - array of string elements to be encoded
 * @return string - encoded request
 */
function _wppb_encodeQS($data)
{
    $req = "";
    foreach ($data as $key => $value) {
        $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
    }
    // Cut the last '&'
    $req=substr($req, 0, strlen($req)-1);
    return $req;
}



/**
 * Submits an HTTP GET to a reCAPTCHA server
 * @param string $path
 * @param array $data
 */
function _wppb_submitHTTPGet($path, $data)
{
    $req = _wppb_encodeQS($data);
    $response = file_get_contents($path . $req);
    return $response;
}

/**
 * Gets the challenge HTML (javascript and non-javascript version).
 * This is called from the browser, and the resulting reCAPTCHA HTML widget
 * is embedded within the HTML form it was called from.
 * @param string $pubkey A public key for reCAPTCHA
 * @param string $error The error given by reCAPTCHA (optional, default is null)
 * @param boolean $use_ssl Should the request be made over ssl? (optional, default is false)

 * @return string - The HTML to be embedded in the user's form.
 */
function wppb_recaptcha_get_html ( $pubkey ){

    if ($pubkey == null || $pubkey == '')
        echo $errorMessage = '<span class="error">'. __("To use reCAPTCHA you must get an API key from", "profilebuilder"). " <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a></span><br/><br/>";

    return '
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<div id="recaptcha_widget_div" class="g-recaptcha" data-sitekey="'.$pubkey.'" data-theme="'.apply_filters('wppb_recaptcha_theme_select','light').'" ></div>
		';
}




/**
 * A wppb_ReCaptchaResponse is returned from wppb_recaptcha_check_answer()
 */
class wppb_ReCaptchaResponse {
    var $is_valid;
    var $error;
}


/**
 * Calls an HTTP POST function to verify if the user's answer was correct
 * @param string $privkey
 * @param string $remoteip
 * @param string $response
 * @return wppb_ReCaptchaResponse
 */
function wppb_recaptcha_check_answer ( $privkey, $remoteip, $response ){

    if ( $remoteip == null || $remoteip == '' )
        echo '<span class="error">'. __("For security reasons, you must pass the remote ip to reCAPTCHA!", "profilebuilder") .'</span><br/><br/>';

    // Discard empty solution submissions
    if ($response == null || strlen($response) == 0) {
        $recaptchaResponse = new wppb_ReCaptchaResponse();
        $recaptchaResponse->is_valid = false;
        $recaptchaResponse->error = 'missing-input';

        return $recaptchaResponse;
    }
    $getResponse = _wppb_submitHTTPGet(
        "https://www.google.com/recaptcha/api/siteverify?",
        array (
            'secret' => $privkey,
            'remoteip' => $remoteip,
            'response' => $response
        )
    );

    $answers = json_decode($getResponse, true);
    $recaptchaResponse = new wppb_ReCaptchaResponse();
    if (trim($answers ['success']) == true) {
        $recaptchaResponse->is_valid = true;
    } else {
        $recaptchaResponse->is_valid = false;
        $recaptchaResponse->error = $answers ['error-codes'];
    }
    return $recaptchaResponse;

}

/* the function to display error message on the registration page */
function wppb_validate_captcha_response( $publickey, $privatekey ){
    if (isset($_POST['g-recaptcha-response'])){
        $recaptcha_response_field = $_POST['g-recaptcha-response'];
    }
    else {
        $recaptcha_response_field = '';
    }

    $resp = wppb_recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $recaptcha_response_field );

    if ( !empty( $_POST ) )
        return ( ( !$resp->is_valid ) ? false : true );
}

/* the function to add reCAPTCHA to the registration form of PB */
function wppb_recaptcha_handler ( $output, $form_location, $field, $user_id, $field_check_errors, $request_data ){
    if ( $field['field'] == 'reCAPTCHA' ){
        $item_title = apply_filters( 'wppb_'.$form_location.'_recaptcha_custom_field_'.$field['id'].'_item_title', wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_title_translation', $field['field-title'] ) );
        $item_description = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_description_translation', $field['description'] );

        if ( $form_location == 'register' ){
            $error_mark = ( ( $field['required'] == 'Yes' ) ? '<span class="wppb-required" title="'.wppb_required_field_error($field["field-title"]).'">*</span>' : '' );

            if ( array_key_exists( $field['id'], $field_check_errors ) )
                $error_mark = '<img src="'.WPPB_PLUGIN_URL.'assets/images/pencil_delete.png" title="'.wppb_required_field_error($field["field-title"]).'"/>';

            $publickey = trim( $field['public-key'] );
            $privatekey = trim( $field['private-key'] );

            if ( ( $publickey == null ) || ( $publickey == '' ) )
                return '<span class="custom_field_recaptcha_error_message" id="'.$field['meta-name'].'_error_message">'.apply_filters( 'wppb_'.$form_location.'_recaptcha_custom_field_'.$field['id'].'_error_message', __("To use reCAPTCHA you must get an API public key from:", "profilebuilder"). '<a href="https://www.google.com/recaptcha/admin/create">https://www.google.com/recaptcha/admin/create</a>' ).'</span>';

            if ( ( $privatekey == null ) || ( $privatekey == '' ) )
                return '<span class="custom_field_recaptcha_error_message" id="'.$field['meta-name'].'_error_message">'.apply_filters( 'wppb_'.$form_location.'_recaptcha_custom_field_'.$field['id'].'_error_message', __("To use reCAPTCHA you must get an API private key from:", "profilebuilder"). '<a href="https://www.google.com/recaptcha/admin/create">https://www.google.com/recaptcha/admin/create</a>' ).'</span>';


            $output = '<style type="text/css">#recaptcha_area{line-height:0;}</style><label for="recaptcha_response_field">'.$item_title.$error_mark.'</label>'.wppb_recaptcha_get_html( $publickey );
            if( !empty( $item_description ) )
                $output .= '<span class="wppb-description-delimiter">' . $item_description . '</span>';

            return $output;

        }
    }
}
add_filter( 'wppb_output_form_field_recaptcha', 'wppb_recaptcha_handler', 10, 6 );


/* handle field validation */
function wppb_check_recaptcha_value( $message, $field, $request_data, $form_location ){
    if( $field['field'] == 'reCAPTCHA' ){
        if ( $form_location == 'register' ){
            if ( ( wppb_validate_captcha_response( trim( $field['public-key'] ), trim( $field['private-key'] ) ) == false ) && ( $field['required'] == 'Yes' ) ){
                return wppb_required_field_error($field["field-title"]);
            }
        }
    }

    return $message;
}
add_filter( 'wppb_check_form_field_recaptcha', 'wppb_check_recaptcha_value', 10, 4 );