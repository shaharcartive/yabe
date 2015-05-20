<?php 

class C5AB_facebook_post extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'facebook-post-widget';
		$this->_shortcode_name = 'c5ab_facebook_post';
		$name = 'Facebook Embed Post';
		$desc = 'Embed a facebook post.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		$data = '';
		$width = 	$GLOBALS['c5_content_width'];	
		
		
		$data .= '<div class="c5-facebook-post-wrap" ><div class="fb-post" data-href="'.$atts['url'].'" data-width="' . $width . '"></div></div>';
		
		    return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			
			array(
			    'label' => 'Post Url',
			    'id' => 'url',
			    'type' => 'text',
			    'desc' => 'Facebook Post Url.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		 
		);
	}
	
	function css() {
	}

}


 ?>