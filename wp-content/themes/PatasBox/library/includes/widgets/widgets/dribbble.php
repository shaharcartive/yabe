<?php 

class C5AB_dribbble extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'dribbble-widget';
		$this->_shortcode_name = 'c5ab_dribbble';
		$name = 'Dribbble Photo Stream';
		$desc = 'Embed Dribbble Photo Stream.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	function get_the_shots($player_id = false, $number = 15){
		$cache = get_transient('dribbble-shots-'.$player_id);
		if( $cache ) {
			return $cache;
		}
		$url = 'http://api.dribbble.com/players/'.rawurlencode($player_id).'/shots';
		if (function_exists('curl_init')) {
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, $url);
			curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_HEADER, false);
			$shots = curl_exec($c);
			curl_close($c);
		}  else {
			$shots = file_get_contents($url);
		}
		$json = json_decode($shots);
		$shots = $json->{"shots"};
		
		set_transient('dribbble-shots-'.$player_id, $shots, 300);
		return $shots;
	}	
	
	function shortcode($atts,$content) {
		
		    
	    $username = $atts['username'];
		$count = $atts['count'];
		$data = '';
		$counter = 0;
		$size = 'thumbnail';
		if ($username != '') {
			
			
			$images_array = $this->get_the_shots($username, $count);

			if ( is_wp_error($images_array) ) {
			   echo $images_array->get_error_message();
			} else {
				$data .='<div class="c5ab-dribbble-flexslider"><ul class="c5ab-dribbble-slides clearfix">';
				foreach ($images_array as $image) {
					$data .='<li><a href="'.esc_url($image->url).'" target="_blank"><img src="'.$image->image_url.'"  alt="'.esc_attr($image->title).'" title="'.esc_attr($image->title).'"/></a></li>';
					$counter++;
					if($counter == $atts['count']){
						break;
					}
				}
				$data .='</ul></div>';
			}
			
		}
		
	    
	    return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			array(
			    'label' => 'Dribbble Username',
			    'id' => 'username',
			    'type' => 'text',
			    'desc' => 'dribbble Username, ex:facebook ',
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
			    'desc' => 'Dribbble images count to pull.',
			    'std' => '9',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		);
	}
	
	

}


 ?>