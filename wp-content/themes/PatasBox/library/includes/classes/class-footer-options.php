<?php 

class C5_footer extends C5_skin_base {
	
	function _hook() {
		$this->slug = 'footer';
		$this->name = 'Footer';
		$this->image = 'footer';
		
		$this->supports = array( 'title', 'editor' );
		
		$this->hook();
	}
	
	function meta_box() {
			
	
	    $footer_settings = array(
	        'id' => 'meta_footer_skins',
	        'title' => 'Bottom Footer Options',
	        'desc' => '',
	        'pages' => array('footer'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $this->get_footer_options(),
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	
	
	    
	    
	    $skin_defaults = array();
	    
	    foreach ($footer_settings['fields'] as $option) {
	    	$skin_defaults[$option['id']] = array($option['type'], $option['std']);
	    }
	    
	    
	    update_option('c5_footer_defaults', $skin_defaults);
	
	    ot_register_meta_box($footer_settings);
	}
	
	
}

 ?>