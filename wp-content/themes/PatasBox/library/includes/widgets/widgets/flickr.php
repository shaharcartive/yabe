<?php 

class C5AB_flickr extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'flickr-widget';
		$this->_shortcode_name = 'c5ab_flickr';
		$name = 'Flickr Photo Stream';
		$desc = 'Embed Flickr Photo Stream.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	function parseFlickrFeed($id, $n) {
	    
	    $c5_flickr_data = get_transient('c5_flickr_' . $id . '_' . $n);
	    if(!$c5_flickr_data){
	    	$url = "http://api.flickr.com/services/feeds/photos_public.gne?id={$id}&lang=it-it&format=rss_200";
	    	$s = file_get_contents($url);
	   	 	preg_match_all('#<item>(.*)</item>#Us', $s, $items);
	    	$c5_flickr_data = array();
	    	for ($i = 0; $i < count($items[1]); $i++) {
	        	if ($i >= $n){
	         	   break;
	         	 }
	        	$item = $items[1][$i];
	        	preg_match_all('#<link>(.*)</link>#Us', $item, $temp);
	        	$link = $temp[1][0];
	        	$title = '';
	        	preg_match_all('#<media:thumbnail([^>]*)>#Us', $item, $temp);
	        	$thumb = $this->attr_flickr($temp[0][0], "url");
	        	$class_i = $i + 1;
	        	if ($class_i % 3) {
	        	    $class = 'class=""';
	        	} else {
	        	    $class = 'class="last_col"';
	        	}
	
	        	$c5_flickr_data[] = array(
	        		'link'=> $link,
	        		'class'=> $class,
	        		'title'=> str_replace('"', '', $title),
	        		'thumb'=> $thumb,
	        	);
	    	}
	    	set_transient( 'c5_flickr_' . $id . '_' . $n , $c5_flickr_data , 3600);
	    }
	    
	    $data= '';
	    foreach ($c5_flickr_data as $key => $value) {
	    	$data .= "<a href=". $value['link'] . " ". $value['class'] . " target='_blank' title=\"" . $value['title'] .  "\"><img src='". $value['thumb'] . "' alt=''/></a>";
	    }
	    
	    
	    
	    
	    return $data;
	}
	
	function attr_flickr($s, $attrname) { // return html attribute
	    preg_match_all('#\s*(' . $attrname . ')\s*=\s*["|\']([^"\']*)["|\']\s*#i', $s, $x);
	    if (count($x) >= 3)
	        return $x[2][0];
	    else
	        return "";
	}
	
	function shortcode($atts,$content) {
		
		    
		    $username = $atts['id'];
		
		    $count = $atts['count'];
			$data = '';
		    $data = '<div class="c5ab_flickr clearfix">' . $this->parseFlickrFeed($username, $count) . '</div>';
		    
		    
		    return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			array(
			    'label' => 'Flickr Gallery ID',
			    'id' => 'id',
			    'type' => 'text',
			    'desc' => 'Flickr Gallery ID',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Count',
			    'id' => 'count',
			    'type' => 'text',
			    'desc' => 'Flickr Count Gallery.',
			    'std' => '9',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		);
	}
	
	function css() {
	?>
	
	<style>
		.c5ab_flickr{margin:-8px -8px 0}.c5ab_flickr a{display:block;float: left;
		}
		.c5ab_flickr img{display:block;margin:8px;-moz-transition:all .2s ease;-o-transition:all .2s ease;-webkit-transition:all .2s ease;-ms-transition:all .2s ease;transition:all .2s ease}
		
	
	</style>
	
	<?php
	
	}

}


 ?>