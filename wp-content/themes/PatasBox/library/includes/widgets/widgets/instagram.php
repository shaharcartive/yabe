<?php 

class C5AB_instagram extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $wpiwdomain  = '';
	
	function __construct() {
		
		$id_base = 'instagram-widget';
		$this->_shortcode_name = 'c5ab_instagram';
		$name = 'Instagram Photo Stream';
		$desc = 'Embed Instagram Photo Stream.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	function scrape_instagram($username, $slice = 9) {
	
			if (false === ($instagram = get_transient('instagram-photos-'.sanitize_title_with_dashes($username)))) {
				
				$remote = wp_remote_get('http://instagram.com/'.trim($username));
	
				if (is_wp_error($remote)) 
		  			return new WP_Error('site_down', __('Unable to communicate with Instagram.', $this->wpiwdomain));
	
	  			if ( 200 != wp_remote_retrieve_response_code( $remote ) ) 
	  				return new WP_Error('invalid_response', __('Instagram did not return a 200.', $this->wpiwdomain));
	
				$shards = explode('window._sharedData = ', $remote['body']);
				$insta_json = explode(';</script>', $shards[1]);
				$insta_array = json_decode($insta_json[0], TRUE);
	
				if (!$insta_array)
		  			return new WP_Error('bad_json', __('Instagram has returned invalid data.', $this->wpiwdomain));
	
				$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
	
				$instagram = array();
				foreach ($images as $image) {
	
					if ($image['type'] == 'image' && $image['user']['username'] == $username) {
	
						$instagram[] = array(
							'description' 	=> $image['caption']['text'],
							'link' 			=> $image['link'],
							'time'			=> $image['created_time'],
							'comments' 		=> $image['comments']['count'],
							'likes' 		=> $image['likes']['count'],
							'thumbnail' 	=> $image['images']['thumbnail'],
							'large' 		=> $image['images']['standard_resolution']
						);
					}
				}
	
				$instagram = base64_encode( serialize( $instagram ) );
				set_transient('instagram-photos-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
			}
	
			$instagram = unserialize( base64_decode( $instagram ) );
	
			return array_slice($instagram, 0, $slice);
		}
	
	
	function shortcode($atts,$content) {
		
		    
	    $username = $atts['username'];
		$count = $atts['count'];
		$data = '';
		$size = 'large';
		if ($username != '') {
			
			
			$images_array = $this->scrape_instagram($username, $count);
			$counter = 0;
			if ( is_wp_error($images_array) ) {
			   echo $images_array->get_error_message();
			} else {
				$data .='<div class="c5ab-instagram-flexslider"><ul class="c5ab-instagram-slides clearfix">';
				foreach ($images_array as $image) {
					$data .='<li><a href="'.esc_url($image['link']).'" target="_blank"><img src="'.$image[$size]['url'].'"  alt="'.esc_attr($image['description']).'" title="'.esc_attr($image['description']).'"/></a></li>';
					$counter++;
					if($counter == $atts['count']){
						break;
					}
				}
				$data .='</ul></div>';
			
				
			}
//			$data .=  do_shortcode('[c5ab_button text="'.__('Follow on','code125') .' @'.$atts['username'].'" link="http://www.instagram.com/'.$atts['username'].'" icon="fa fa-instagram" font_size="14" font_weight="300" button_class="" float="right" button_color="#517fa4" button_hover_color="#222" ]');
		}
		
	    
	    return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			array(
			    'label' => 'Instagram Username',
			    'id' => 'username',
			    'type' => 'text',
			    'desc' => 'instagram Username, ex:facebook ',
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
			    'desc' => 'Instagram images count to pull.',
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