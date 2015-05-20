<?php 

class C5AB_tweet extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'tweet-widget';
		$this->_shortcode_name = 'c5ab_tweet';
		$name = 'Twitter Status';
		$desc = 'Add Twitter Status.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
	}
	
	
	function shortcode($atts,$content) {
		
		
		    $data = '<div class="c5-tweet-wrap" ><blockquote class="twitter-tweet" lang="en"><a href="'.$atts['link'].'"></a></blockquote>
		    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script></div>';
		    
		    return $data;
	}
	
	
	
	function options() {
		
		
		
		$this->_options =array(
			array(
			    'label' => 'Tweet link',
			    'id' => 'link',
			    'type' => 'text',
			    'desc' => 'Add your Tweet link.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			
		);
	}
	

}


 ?>