<?php 

class C5AB_google_plus_box extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'google-plus-box-widget';
		$this->_shortcode_name = 'c5ab_google_plus_box';
		$name = 'Google Plus Box';
		$desc = 'Embed Google Plus for page.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		add_action('wp_footer', array($this, 'footer'));
		
	}
	
	function footer() {
		echo '<!-- Place this amazing tag after the last widget tag. -->
		<script type="text/javascript">
		  (function() {
		    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
		    po.src = \'https://apis.google.com/js/platform.js\';
		    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>';
	}
	
	function shortcode($atts,$content) {
		$width = $GLOBALS['c5_content_width'];	
		
		$data = '<div class="g-page" data-width="' . $width . '" data-href="'.$atts['url'].'" data-rel="publisher"></div>';
		    return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			array(
			    'label' => 'Page URL',
			    'id' => 'url',
			    'type' => 'text',
			    'desc' => 'Google Plus Page url.',
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