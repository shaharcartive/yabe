<?php 

class C5AB_service_column extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $_skip_title = true;
	
	function __construct() {
		
		$id_base = 'service-column-widget';
		$this->_shortcode_name = 'c5ab_service_column';
		$name = 'Service Column';
		$desc = 'Show your services in a decent way.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		$id = $this->get_unique_id();
		
		$data = '<div class="services_wrapper c5ab-service-column-'.$id.'" >
						<div class="c5-service-item">';
								
		if($atts['image']==''){						
			$data .= '<span class="'.$atts['icon'].'"></span>';
		}else {
			$data .= '<img src="'.$atts['image'].'" alt="" />';
		}
		
								
		$data .= '<h3>'.$atts['title'].'</h3>';
		$data .= '<p>'.$content.'</p>';
								
		if($atts['button_text']!=''){						
			$data .= '[c5ab_button link="'.$atts['link'].'" text="'. $atts['button_text'] .'" ]';
		}
		$data .= '</div></div>';
					
					
		
		
		return $data;
	}
	
	
	
	function options() {
		$colors = $this->get_main_colors();
		
		$icons = new C5AB_ICONS();
		$icons_array = $icons->get_icons_as_images(); 
		
		$this->_options =array(
			
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Service Column title.',
			    'std' => 'Service Column',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Image',
			    'id' => 'image',
			    'type' => 'upload',
			    'desc' => 'upload image instead of icons.',
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
			  'choices' => $icons_array,
			  'std'         => 'fa fa-cloud',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => 'c5ab_icons'
			),
			array(
			    'label' => 'Circle Width',
			    'id' => 'width',
			    'type' => 'numeric-slider',
			    'desc' => 'Font Weight for the title.',
			    'std' => '80',
			    'min_max_step' => '50,200,10',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Content',
			    'id' => 'content',
			    'type' => 'textarea-simple',
			    'desc' => 'Service Column Content.',
			    'std' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button Link',
			    'id' => 'link',
			    'type' => 'text',
			    'desc' => 'Service Column Button Link.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button Text',
			    'id' => 'button_text',
			    'type' => 'text',
			    'desc' => 'Service Column Button Text.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
		 
		);
	}
	
	

}


 ?>