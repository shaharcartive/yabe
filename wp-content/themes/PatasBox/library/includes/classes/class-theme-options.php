<?php

class C5_theme_option_build extends C5_theme_option_elements{

    
    function __construct() {
        
    }
    
    function hook_theme_options() {
    	add_action('admin_init', array($this, 'build_theme_options'), 1);
    }
	function build_sections () {
		$this->_sections[] = array(
		    'title' => 'General',
		    'id' => 'general_default'
		);
		if(!C5_simple_option){
			$this->_sections[] = array(
			   'title' => 'Default Skins',
			   'id' => 'default_skins'
			);
		}else{
			$this->_sections[] = array(
			   'title' => 'Layout Settings',
			   'id' => 'layout_settings'
			);
			$this->_sections[] = array(
			   'title' => 'Header Settings',
			   'id' => 'header_settings'
			);
			
			$this->_sections[] = array(
			   'title' => 'Color Settings',
			   'id' => 'color_settings'
			);
			$this->_sections[] = array(
			   'title' => 'Font Settings',
			   'id' => 'font_settings'
			);
		}
		
		$this->_sections[] = array(
		   'title' => 'Default Templates',
		   'id' => 'default_templates'
		);
		 
		 $this->_sections[] = array(
		    'title' => 'Social Settings',
		    'id' => 'social'
		 );
		 
		 $this->_sections[] = array(
		    'title' => 'Article Settings',
		    'id' => 'article'
		 );
		   
		 
		 $this->_sections[] = array(
		    'title' => 'Search Settings',
		    'id' => 'search'
		 ); 
		 
		 $this->_sections[] = array(
		    'title' => 'Sidebars',
		    'id' => 'sidebars'
		 ); 
		 
		 $this->_sections[] = array(
		    'title' => 'Menu Locations',
		    'id' => 'menus'
		 ); 
		 
		 $this->_sections[] = array(
		    'title' => 'Custom Fonts ',
		    'id' => 'fonts'
		 ); 
		 if(C5_simple_option){
		 	$this->_sections[] = array(
		 	   'title' => 'Footer Settings ',
		 	   'id' => 'footer'
		 	); 
		 }
		   
		  
	}
    function build_settings() {

	   $this->add_options( $this->get_logo_options('general_default') );
	   $this->add_options( $this->get_default_options('general_default') );
	   if(!C5_simple_option){
       		$this->add_options( $this->get_skins_options('default_skins') );
       }else{
       
       
       		$this->add_options( $this->get_default_blog('layout_settings') );
       		$this->add_options( $this->get_layout_options('layout_settings') );
       		$this->add_options( $this->get_header_options('header_settings') );
       		$this->add_options( $this->get_color_scheme_options('color_settings') );
       		$this->add_options( $this->get_colors_options('color_settings') );
       		$this->add_options( $this->get_fonts_options('font_settings') );
       }
       $this->add_options( $this->get_templates_options('default_templates') );
       $this->add_options( $this->get_social_options('social') );
       $this->add_options( $this->get_articles_options('article') );
       $this->add_options( $this->get_search_options('search') );
       $this->add_options( $this->get_sidebars_options('sidebars') );
       $this->add_options( $this->get_menu_locations_options('menus') );
       $this->add_options( $this->get_custom_fonts_options('fonts') );
       if(C5_simple_option){
       		$this->add_options( $this->get_footer_options('footer') );
       }
       if(C5_simple_option){
       		$this->update_std_options();
       }

    }
    function update_std_options() {
    	$obj = new C5_header();
    	$obj->meta_box();
    	
    	$obj = new C5_footer();
    	$obj->meta_box();
    	
    	$obj = new C5_skin();
    	$obj->meta_box();
    }
    function add_options($options) {
    	$this->_options = array_merge($this->_options, $options);
    }
    
    function build_theme_options() {
    		$this->build_sections();
    		$this->build_settings();
    	    /**
    	     * Get a copy of the saved settings array. 
    	     */
    	    $saved_settings = get_option('option_tree_settings', array());
    	
    	    /**
    	     * Create a custom settings array that we pass to 
    	     * the OptionTree Settings API Class.
    	     */
    	    $custom_settings = array(
    	        'contextual_help' => array(
    	        ),
    	        'sections' => $this->_sections,
    	        'settings' => $this->_options
    	    );
    	    
    	    
    	    
    	    /* allow settings to be filtered before saving */
    	    $custom_settings = apply_filters('option_tree_settings_args', $custom_settings);
    	
    	    /* settings are not the same update the DB */
    	    if ($saved_settings !== $custom_settings) {
    	        update_option('option_tree_settings', $custom_settings);
    	    }
    	}

    
	
    

}

?>