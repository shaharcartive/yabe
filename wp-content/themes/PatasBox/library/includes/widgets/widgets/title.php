<?php 

class C5AB_title extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'title-widget';
		$this->_shortcode_name = 'c5ab_title';
		$name = 'Title';
		$desc = 'Title for your website.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		
		    $title_id = '';
		    if ($atts['id'] != '') {
		        $title_id = 'id="' . $atts['id'] . '"';
		    } 
		
		
			$class= '';
			if ($atts['class'] != '') {
			    $class =  $atts['class'];
			}
			
			$link= '';
			$tag= 'span';
			if ($atts['link'] != '') {
			    $link = 'href="' . $atts['link'] . '"';
			    $tag= 'a';
			}
			
		    $icon = '';
		    if($atts['icon'] != '' && $atts['icon'] !='fa fa-none' ){
		    	$icon=  '<span class="icon '. $atts['icon'] .'"></span>'  ;
		    }
		    
		    $id = $this->get_unique_id();		    
		    
		    
		    
		
		    $data = '<h3  '.$title_id.' class=" c5ab-title-'.$id.'  '.$class.' '.$atts['transform'].' title  clearfix"><'.$tag.' '.$link.' class="text-wrap">'.$icon.'<span class="text ">' . $atts['title'] . '</span></'.$tag.'></h3>';
		    
		    return $data;
		
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$obj = new C5AB_ICONS();
		$icons = $obj->get_icons_as_images();
		
		
		
		
		$this->_options =array(
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Title.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Text transform',
			    'id' => 'transform',
			    'type' => 'select',
			    'desc' => 'Text transform.',
			    'choices' => array(
			    	array(
			    		'label' => 'Uppercase',
			    		'value' => 'uppercase'
			    	),
			    	array(
			    		'label' => 'Normal',
			    		'value' => 'normal'
			    	)
			    ),
			    'std' => 'normal',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Class',
			    'id' => 'class',
			    'type' => 'text',
			    'desc' => 'Class.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			  'label'       => 'Icon',
			  'id'          => 'icon',
			  'type'        => 'radio-text',
			  'desc'        => '',
			  'choices' => $icons,
			  'std'         => 'fa fa-none',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => 'c5ab_icons'
			),
			array(
			    'label' => 'Link',
			    'id' => 'link',
			    'type' => 'text',
			    'desc' => 'Add a url if you want to the title to be clickable.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'ID',
			    'id' => 'id',
			    'type' => 'text',
			    'desc' => 'Add ID to the title.',
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