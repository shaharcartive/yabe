<?php 

class C5AB_video extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'video-widget';
		$this->_shortcode_name = 'c5ab_video';
		$name = 'Video';
		$desc = 'Embed a Video "Youtube, Dailymotion, Vimeo, HTML5 Video".';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	function get_id($url) {
		$split_1 = explode("/", $url);
		if (strpos($url, 'www.youtube.com') !== false) {
		    $split_2 = explode("?v=", $split_1[3]);
		    return array('youtube' , $split_2[1]);
		    
		} elseif (strpos($url, 'vimeo.com') !== false) {
		    return array('vimeo' , $split_1[3]);
		    
		} elseif (strpos($url, 'www.dailymotion.com') !== false) {
		    $split_2 = explode("_", $split_1[4]);
		    return array('dailymotion' , $split_2[0]);
		    
		}
		
		return array('html5' , $url);
	}
	
	function youtube($id, $width ,$height) {
		return '<iframe width="' . $width . '" height="' . $height . '" src="'.esc_url('http://www.youtube.com/embed/' . $id  ) .'"  allowfullscreen></iframe>';
	}
	
	function vimeo( $id, $width ,$height ) {
	    
	    $colors = $this->get_main_colors();
	    $style_obj = new C5AB_STYLE();
	    $primary_color = $colors['primary'];
	
	
	    $clip_id = $id;
	    $title = '1';
	    $byline = '1';
	    $portrait = '1';
	    $color = substr($primary_color, 1);
	    $html5 = '1';
	
	    if (empty($clip_id) || !is_numeric($clip_id))
	        return '<!-- Code125 Vimeo: Invalid clip_id -->';
	    if ($height && !$width)
	        $width = intval($height * 16 / 9);
	    if (!$height && $width)
	        $height = intval($width * 9 / 16);
	
	    return $html5 ?
	            "<iframe  class='iframe_video' src='".esc_url('http://player.vimeo.com/video/'.$clip_id.'?title='.$title.'&byline='.$byline.'&portrait='.$portrait.'&color='.$color). "' width='$width' height='$height'   frameborder='0'></iframe>" :
	            "<object  class='iframe_video' width='$width' height='$height'><param name='allowfullscreen' value='true' />" .
	            "<param name='allowscriptaccess' value='always' />" .
	            "<param name='movie' value='http://vimeo.com/moogaloop.swf?clip_id=$clip_id&amp;server=vimeo.com&amp;show_title=$title&amp;show_byline=$byline&amp;show_portrait=$portrait&amp;color=$color&amp;fullscreen=1' />" .
	            "<embed src='http://vimeo.com/moogaloop.swf?clip_id=$clip_id&amp;server=vimeo.com&amp;show_title=$title&amp;show_byline=$byline&amp;show_portrait=$portrait&amp;color=$color&amp;fullscreen=1' type='application/x-shockwave-flash' allowfullscreen='true' allowscriptaccess='always' width='$width' height='$height'></embed></object>";
	}
	
	
	function dailymotion( $id, $width ,$height ) {
	   
	return '<iframe width="' . $width . '" height="' . $height . '"   src="'.esc_url('http://www.dailymotion.com/embed/video/' . $id ). '" ></iframe>';
	}
	
	
	function html5( $id, $width ,$height ) {
	
		return do_shortcode('[video src="'.esc_url($id).'" height="'.$height.'" width="'.$width.'"]');
	
	}
	
	
	function shortcode($atts,$content) {
		$return_data = $this->get_id( $atts['url'] );
		    $id = $return_data[1];
		    $type = $return_data[0];
		    
		    
		    $width = 	$GLOBALS['c5_content_width'];	
		    
		    
		    $height = round( $width*9/16);
		
			if($type == 'youtube'){
				return $this->youtube($id, $width ,$height);
			}elseif ($type == 'vimeo') {
				return $this->vimeo($id, $width ,$height);
			}elseif ($type == 'dailymotion') {
				return $this->dailymotion($id, $width ,$height);
			}elseif ($type == 'html5') {
				return $this->html5($id, $width ,$height);
			}
			return '';        
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			array(
			    'label' => 'Video URL',
			    'id' => 'url',
			    'type' => 'text',
			    'desc' => 'Add Video URL ... you can add a Youtube, Vimeo, Dailymotion URL and it will be automaticlly detected, or you can add external video url and it will be added to a player.',
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