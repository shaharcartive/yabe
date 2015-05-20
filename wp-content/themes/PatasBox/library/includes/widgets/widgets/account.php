<?php

class C5AB_account extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'account-widget';
        $this->_shortcode_name = 'c5ab_account';
        $name = 'Account';
        $desc = 'Add Account Box. (Login Box)';
        $classes = '';
		
        $this->self_construct($name, $id_base, $desc, $classes);
    }
	
	
	
    function shortcode($atts, $content) {
    	$data = '';	
    	
    	if (!is_user_logged_in()) {
    	$data = '<form name="loginform" class="c5_loginform clearfix" action="' . esc_url(home_url() . '/wp-login.php').'" method="post" ><div class="input-wrap"><input type="text" name="log" class="element-block" id="user_login"  placeholder="'.$atts['username_text'].'" size="20" /><span class="fa fa-user"></span></div><div class="clearfix"></div><div class="input-wrap"><input type="password" name="pwd" class="element-block" id="user_pass"  placeholder="'.$atts['password_text'].'" size="20" /><span class="fa fa-lock"></span></div>';
    	        
    	        
    	$data .= '<div class="row"><div class="col-xs-6">';
    	if($atts['checkbox']!='off'){
    		$data .='<p class="login-remember"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever">' . $atts['remember_text'] . '</label></p>';
    	}
    	$data .='</div><div class="col-xs-6"><input type="submit" name="wp-submit" id="c5-login-submit" class="button-primary " value="' . $atts['login_text'] . '"></div></div>';
    	        
    	$data .='<p class="login-submit">';
    	
    	if($atts['forget']!='off'){
    	$data .='<a class="c5_forget_password" href="' . wp_lostpassword_url(home_url()) . '">' . $atts['forget_text'] . '</a>';
    	}
    	if($atts['register']!='off'){
    	$data .='<a class="c5_register" href="' . home_url() . '/wp-login.php?action=register">' . $atts['register_text'] . '</a>';
    	}
    	$data .='<input type="hidden" name="redirect_to" value="' . home_url() . '"></p></form>';
    	}			
		return $data;
	}
	
	function custom_css() {
	
		
        
    }

    function options() {
		
		
		
        $this->_options = array(
            array(
                'label' => 'Username Placeholder Text',
                'id' => 'username_text',
                'type' => 'text',
                'desc' => 'Add your Username  Placeholder text.',
                'std' => 'Username',
            ),
            array(
                'label' => 'Password Placeholder Text',
                'id' => 'password_text',
                'type' => 'text',
                'desc' => 'Add your Password  Placeholder text.',
                'std' => '******',
            ),
            array(
                'label' => 'Login Button Text',
                'id' => 'login_text',
                'type' => 'text',
                'desc' => 'Add your Login Button Text.',
                'std' => 'Login',
            ),
            array(
                'label' => 'Register Button Text',
                'id' => 'register_text',
                'type' => 'text',
                'desc' => 'Add your Register Button Text.',
                'std' => 'Register',
            ),
            array(
                'label' => 'Forget Password Text',
                'id' => 'forget_text',
                'type' => 'text',
                'desc' => 'Add your Forget Password Text.',
                'std' => 'Forget Password ?',
            ),
            array(
                'label' => 'Remember Me Text',
                'id' => 'remember_text',
                'type' => 'text',
                'desc' => 'Add your Remember Me Text.',
                'std' => 'Remember me ?',
            ),
            array(
                'label' => 'Show Remember Checkbox',
                'id' => 'checkbox',
                'type' => 'on_off',
                'desc' => 'Show Remember Checkbox.',
                'std' => 'on',
            ),
            array(
                'label' => 'Show Forget Link',
                'id' => 'forget',
                'type' => 'on_off',
                'desc' => 'Show Forget Link.',
                'std' => 'on',
            ),
            array(
                'label' => 'Show Register Link',
                'id' => 'register',
                'type' => 'on_off',
                'desc' => 'Show Register Link.',
                'std' => 'on',
            ),
            
         );
    }


}
?>