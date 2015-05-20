<?php 

class C5_header extends C5_skin_base {
	
	function _hook() {
		$this->slug = 'header';
		$this->name = 'Header';
		$this->image = 'header';
		
		$this->supports = array( 'title' );
		
		$this->hook();
	}
	
	
	
	function meta_box() {
	    
	    
	    
	    $meta_header_logo = array(
	        'id' => 'meta_header_logo',
	        'title' => 'Logo Options',
	        'desc' => '',
	        'pages' => array('header'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $this->get_logo_options(),
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	    
	    
	    $meta_header_background = array(
	        'id' => 'meta_header_background',
	        'title' => 'General Settings',
	        'desc' => '',
	        'pages' => array('header'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $this->get_header_options(),
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	    
	    
	    
	    
	    
	    
	    	    
	
		$header_defaults = array();
		
		foreach ($meta_header_background['fields'] as $option) {
			$header_defaults[$option['id']] = array($option['type'], $option['std']);
		}
		foreach ($meta_header_logo['fields'] as $option) {
			$header_defaults[$option['id']] = array($option['type'], $option['std']);
		}
		
		
		
		
		update_option('c5_header_defaults', $header_defaults);
	    
	    ot_register_meta_box($meta_header_logo);
	    ot_register_meta_box($meta_header_background);
	    
	    
	    
	   }
	   
	   
	   
	
}

 ?>