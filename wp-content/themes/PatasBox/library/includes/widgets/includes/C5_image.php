<?php
/** بسم الله الرحمن الرحيم **
 *
 * Plugin Name: Code125 Image resizer 
 * Plugin URI: http://code125.com/
 * Description: Easily resize the image on the fly.
 * Version: 1.0
 * Author: Code125
 * Author URI: http://themeforest.net/user/Code125
 * License: GPLV3
 *
 */



/**
* function: c5ab_register_retina
*
* @param none
* @return none
*/



function c5ab_register_retina() {
	
		if( !isset($_COOKIE["device_pixel_ratio"]) ){
	    
		?>
		<script>
		window.onload = function(){
		  if( document.cookie.indexOf('device_pixel_ratio') == -1
		      && 'devicePixelRatio' in window
	   		   && window.devicePixelRatio == 2 ){
	
	    	var date = new Date();
	    	date.setTime( date.getTime() + 3600000 );
	
	    	document.cookie = 'device_pixel_ratio=' + window.devicePixelRatio + ';' +  ' expires=' + date.toGMTString() +'; path=/';
	  		}	
		};
	</script>
	<?php } 
}

add_action('wp_head', 'c5ab_register_retina');

function c5ab_generate_image_size($width = 960 , $height = 960 , $crop = true ) {
	if($crop){
		$array = array(
		   'slug' => 'custom_image_size_crop_' . $width . 'x' . $height ,
		   'width' => $width,
		   'height' => $height,
		   'crop' => true,
		);
	}else {
		$array = array(
		   'slug' => 'custom_image_size_' . $width . 'x' . $height ,
		   'width' => $width,
		   'height' => $height,
		   'crop' => false,
		);
		
	}
	
	
	code125_add_image_size($array['slug'] , $array['width'] , $array['height'], $array['crop']);
	
	return $array['slug'];
	
}

function c5ab_get_attachment_id_from_src ($attachment_src) {
	global $wpdb;
	
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$attachment_src'";
	$id = $wpdb->get_var($query);
		
	return $id;
}
if(!function_exists('code125_image_downsize')){


function code125_check_image_size($size = 'thumbnail') {
	

	global $_wp_additional_image_sizes;
	$sizes = get_intermediate_image_sizes();
	if(is_array($_wp_additional_image_sizes)){
		foreach ($_wp_additional_image_sizes as $key => $single_size) {
			if( $key == $size){
				$new_size = $_wp_additional_image_sizes[$key];
				$img_array = array($new_size['width'], $new_size['height'],$new_size['crop']);
				return $img_array;
			}
		}
	}
	
	global $_code125_image_sizes;
	if(is_array($_code125_image_sizes)){
		foreach ($_code125_image_sizes as $key => $size_2 ) {
			if($key == $size ){
				$img_array = array($size_2['width'], $size_2['height'],$size_2['crop']);
				return $img_array;
			
			}
		}
	}
	
	return false;
	
}

function code125_image_downsize($ignore = false , $id = 0 , $size = 'medium') {
	
	
	
	if ( !wp_attachment_is_image($id) )
	                return false;
	
	        $img_url = wp_get_attachment_url($id);
	        $meta = wp_get_attachment_metadata($id);
	        if (!$meta) {
	        	return array($img_url , '' ,'',false,$id );
	        }
	        if($size == 'full'){
	        	return array($img_url, $meta['width'], $meta['height'],false,$id);
	        }
	        $width = $height = 0;
	        $is_intermediate = false;
	        $img_url_basename = wp_basename($img_url);
	        
	        $new_img_meta  =  code125_check_image_size($size) ;
	       if(!$new_img_meta){
	       		return array($img_url, $meta['width'], $meta['height'],false,$id);
	       }
	       

	       $new_image_dimen = image_resize_dimensions( $meta['width'], $meta['height'], $new_img_meta[0], $new_img_meta[1], $new_img_meta[2] );
	       
	       
	       $height = $new_image_dimen[5];
	       $width = $new_image_dimen[4];
	       
	       
	       $retina = false;
	       $device = new C5AB_Mobile_Detect();
	       
	       if(!isset($_COOKIE["device_pixel_ratio"])) {
	      		$test= 1;
	       }else {
	       		$test= $_COOKIE["device_pixel_ratio"];
	       }
	       
	       if( $device->isMobile() || $test >= 2  ){
	       		$test_height =  2*$height;
	       		$test_width =  2*$width;
	       		if( $test_height < $meta['height'] && $test_width < $meta['width'] ){
	       			$height = 2*$height;
	       			$width = 2*$width;
	       			$retina = true;
	       		}
	       }
	       
	       
	       
	       
	       
	       $base_url = wp_upload_dir();
	       $url = str_replace($base_url['baseurl'],$base_url['basedir'],$img_url);
	      	
	      	$img_info = pathinfo($url);
	      	$dir  = $img_info['dirname'];
	      	$ext  = $img_info['extension'];
	      	
	      	$name = wp_basename( $img_url, ".$ext" );
	      	
	      	
	      	
	      	
	      	$suffix = $width .'x' . $height;
	      	
	      	$new_file =  trailingslashit( $dir ) . "{$name}-{$suffix}.{$ext}";
	      	if(file_exists($new_file)){
	      		
	      		$new_image_url = str_replace($base_url['basedir'],$base_url['baseurl'],$new_file );
	      		if($retina){
	      				return array($new_image_url, $width/2, $height/2,false,$id);
	      		
	      			}else{
	      				return array($new_image_url, $width, $height,false,$id);
	      				
	      				
	      			}
	      		
	      	}else{
	      		$image = wp_get_image_editor($url );
	      		if ( ! is_wp_error( $image ) ) {
	      			
	      		 
	      		    if( !file_exists($image->generate_filename($width .'x' . $height))){
	      		    $image->resize($width, $height, $new_img_meta[2]);
	      		    $image->set_quality(80);
	      		    $saved_file = $image->save();
	      			
	      			if ( is_wp_error( $saved_file ) ) {
	      				return array($img_url, $meta['width'], $meta['height'],false,$id);
	      			}
	      			$new_image_url = str_replace($base_url['basedir'],$base_url['baseurl'],$saved_file['path'] );
	      			
	      				}else {
	      					$new_image_url = str_replace($base_url['basedir'],$base_url['baseurl'], $image->generate_filename($width .'x' . $height) );
	      				}
	      				if($retina){
	      					return array($new_image_url, $width/2, $height/2,false,$id);
	      			
	      				}else{
	      					
	      					return array($new_image_url, $width, $height,false,$id);
	      				}
	      		
	      		}else {
	      			return false;
	      		}
	      	}
	      	
	      	
	       
	  
	  
	       
	      
	  
}

	function code125_add_image_size( $name, $width = 0, $height = 0, $crop = false ) {
	        global $_code125_image_sizes;
	        $_code125_image_sizes[$name] = array( 'width' => absint( $width ), 'height' => absint( $height ), 'crop' => (bool) $crop );
	}


add_filter('image_downsize','code125_image_downsize', 99, 3);


function c5_add_image_class($atts) {
	$atts['class'] .= $atts['class']. ' c5-resize-image';
	return $atts;
}
add_filter('wp_get_attachment_image_attributes','c5_add_image_class',1,1);

}


function c5_generate_image($width,$height,$link,$crop) {
	$image_size = c5ab_generate_image_size($width, $height, $crop);
	$img_id = c5ab_get_attachment_id_from_src($link);
	if($img_id!=''){
		$image_url = wp_get_attachment_image_src($img_id, $image_size);
	}else {
		$image_url = array(
			$link,'',''
		);
	}
	return $image_url;
}


?>