<?php 

class C5_skin extends C5_skin_base {
	
	
	
	function _hook() {
		$this->slug = 'skin';
		$this->name = 'Skin';
		$this->image = 'skin';
		
		$this->supports = array( 'title' );
		
		$this->hook();
	}
	
	
	function meta_box() {
		
		
	
	
	    $meta_skins = array(
	        'id' => 'meta_skins',
	        'title' => 'Skin Options',
	        'desc' => '',
	        'pages' => array('skin'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => array(
	            array(
	                'label' => 'Choose The default Header',
	                'id' => 'header_default',
	                'type' => 'custom-post-type-select',
	                'desc' => 'Choose The  Header.',
	                'std' => '',
	                'rows' => '',
	                'post_type' => 'header',
	                'taxonomy' => '',
	                'class' => ''
	            ),
	            array(
	                'label' => 'Choose The default Footer',
	                'id' => 'footer_default',
	                'type' => 'custom-post-type-select',
	                'desc' => 'Choose The Footer.',
	                'std' => '',
	                'rows' => '',
	                'post_type' => 'footer',
	                'taxonomy' => '',
	                'class' => ''
	            ),
	           array(
	               'label' => 'Custom CSS for this skin',
	               'id' => 'custom_css',
	               'type' => 'textarea',
	               'desc' => 'Add Custom CSS for this skin.',
	               'std' => '',
	               'rows' => '',
	               'post_type' => '',
	               'taxonomy' => '',
	               'class' => '',
	           ),
	           array(
	               'label' => 'Custom js for this skin',
	               'id' => 'custom_js',
	               'type' => 'textarea',
	               'desc' => 'Add Custom js for this skin.',
	               'std' => '',
	               'rows' => '',
	               'post_type' => '',
	               'taxonomy' => '',
	               'class' => '',
	           )
	        )
	        ,
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	    
	    
	    $meta_skins_layout = array(
	        'id' => 'meta_skins_layout',
	        'title' => 'Page Layout Options',
	        'desc' => '',
	        'pages' => array('skin'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $this->get_layout_options(),
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	
	
	    $meta_skins_style = array(
	        'id' => 'meta_skins_style',
	        'title' => 'Page Style Options',
	        'desc' => '',
	        'pages' => array('skin'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $this->get_colors_options(),
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	
	    $meta_skins_typography = array(
	        'id' => 'meta_skins_typography',
	        'title' => 'Page Typography Options',
	        'desc' => '',
	        'pages' => array('skin'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $this->get_fonts_options(),
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	    
	    
	    $skin_defaults = array();
	    
	    foreach ($meta_skins['fields'] as $option) {
	    	$skin_defaults[$option['id']] = array($option['type'], $option['std']);
	    }
	    foreach ($meta_skins_layout['fields'] as $option) {
	    	$skin_defaults[$option['id']] = array($option['type'], $option['std']);
	    }
	    
	    foreach ($meta_skins_style['fields'] as $option) {
	    	$skin_defaults[$option['id']] = array($option['type'], $option['std']);
	    }
	    
	    foreach ($meta_skins_style['fields'] as $option) {
	    	$skin_defaults[$option['id']] = array($option['type'], $option['std']);
	    }
	    
	    foreach ($meta_skins_typography['fields'] as $option) {
	    	$skin_defaults[$option['id']] = array($option['type'], $option['std']);
	    }
	    
	    update_option('c5_skin_defaults', $skin_defaults);
	
	    ot_register_meta_box($meta_skins);
	    ot_register_meta_box($meta_skins_layout);
	    ot_register_meta_box($meta_skins_style);
	    ot_register_meta_box($meta_skins_typography);
	}
	
	
}

 ?>