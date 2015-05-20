<?php 

class C5AB_youtube_box extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'youtube-box-widget';
		$this->_shortcode_name = 'c5ab_youtube_box';
		$name = 'Youtube Subscribe Box';
		$desc = 'Embed Youtube Subscribe Bpx.';
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
		
		$data = '';
		if($atts['title']!=''){
			$data .= do_shortcode('[c5ab_title title="'.$atts['title'].'" class="" icon="fa fa-none" link="" id="" ]');
		}
		
		$data .= '<div class="g-ytsubscribe" data-channel="'.$atts['username'].'" data-layout="full" data-theme="light" data-count="default"></div>';
		    return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Title.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Channel Username',
			    'id' => 'username',
			    'type' => 'text',
			    'desc' => 'Youtube Channel Username.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
		);
	}
	
	function css() {
	}

}


 ?>