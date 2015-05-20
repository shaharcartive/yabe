<?php

class C5AB_contact_form extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'contact_form-widget';
        $this->_shortcode_name = 'c5ab_contact_form';
        $name = 'Contact us Form';
        $desc = 'Add Contact us Form Box';
        $classes = '';
		
        $this->self_construct($name, $id_base, $desc, $classes);
    }
	
	
	
    function shortcode($atts, $content) {
    	
    	
    	$data = '<form id="c5-contact-form" class="clearfix" method="post" action="">';
    	
    	$data = $data . '<div class="row">';
    	
    	$data = $data . '<div class="col-md-6">
    		<div class="input-wrap"><input type="text" name="name" class="element-block" id="name" placeholder="'.$atts['name'].'" size="20" /><span class="fa fa-user"></span></div>
    		</div>';
    	$data = $data . '<div class="col-md-6">
    		<div class="input-wrap"><input type="text" name="email" class="element-block" id="email" placeholder="'.$atts['your_email'].'" size="20" /><span class="fa fa-envelope"></span></div>
    		</div></div>';
    	$data = $data . '<textarea id="message" placeholder="'.$atts['message'].'" name="message" class="element-block  " tabindex="4" aria-required="true"></textarea>';
    	
    	$data = $data . '<input name="submit" type="submit" id="c5-submit-contact" value="'.$atts['send'].'">';
    	  
    	 
    	$data = $data . '<input type="hidden" name="recieve_email" id="recieve_email" value="'.$atts['email'].'" /><div class="clearfix"></div><div class="message_contact_true alert alert-success"><p>'.$atts['success'].'</p></div><div class="message_contact_false alert alert-warning"><p>'.$atts['fail'].'</p></div></form>';
    	
    		
		return $data;
	}
	
	function custom_css() {
	
		
        
    }

    function options() {
		
		
		
        $this->_options = array(
            array(
                'label' => 'Email to recieve',
                'id' => 'email',
                'type' => 'text',
                'desc' => 'Add Email to recieve.',
                'std' => '',
            ),
            array(
                'label' => 'Name Placeholder',
                'id' => 'name',
                'type' => 'text',
                'desc' => 'Add name placeholder.',
                'std' => 'Name',
            ),
            array(
                'label' => 'Email Placeholder Text',
                'id' => 'your_email',
                'type' => 'text',
                'desc' => 'Add Email  Placeholder text.',
                'std' => 'Email',
            ),
            array(
                'label' => 'Message Placeholder Text',
                'id' => 'message',
                'type' => 'text',
                'desc' => 'Add Message Placeholder Text.',
                'std' => 'Your message ...',
            ),
            array(
                'label' => 'Send Text',
                'id' => 'send',
                'type' => 'text',
                'desc' => 'Add your Send Button Text.',
                'std' => 'Send',
            ),
            array(
                'label' => 'Succesful Message Text',
                'id' => 'success',
                'type' => 'text',
                'desc' => 'Add your Succesful Message Text.',
                'std' => 'Your Message was sent, Thank you.',
            ),
            array(
                'label' => 'Failure Message Text',
                'id' => 'fail',
                'type' => 'text',
                'desc' => 'Add your Failure Message Text.',
                'std' => 'Your Message was not sent, Please try again.',
            ),
            
         );
    }

   


}

function c5ab_contact_send() {

		add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));

        ob_start();
        bloginfo('name');
        $name = ob_get_contents();
        ob_end_clean();

		$email = sanitize_email($_POST['recieve_email']);
		
		$message = '<p>' . __('Name: ','code125') . sanitize_text_field($_POST['name']) . '</p>';
        $message .= '<p>' . __('Email: ','code125') . sanitize_email($_POST['email']) . '</p>';
        $message .= '<p>' . __('Message: ','code125') . wp_kses($_POST['message'] , array('a'=>array(),'span'=>array())) . '</p>';
        $headers = 'From: ' . $name . ' ' . "\r\n";
        
        wp_mail( $email , $name . ' Contact Page', $message, $headers, '');

        echo 'done';
        die();
}


add_action( 'wp_ajax_c5ab_contact_send', 'c5ab_contact_send' );
add_action( 'wp_ajax_nopriv_c5ab_contact_send', 'c5ab_contact_send' );
?>