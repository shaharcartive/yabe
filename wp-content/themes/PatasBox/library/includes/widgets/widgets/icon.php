<?php 

class C5AB_icon extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'icon-widget';
		$this->_shortcode_name = 'c5ab_icon';
		$name = 'Icon';
		$desc = 'Icon for your website.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
			$id = $this->get_unique_id();		    
		    
		    $data = '';
		    
		    if( $atts['link']!='' ){
		    	$data .= '<a href="'.$atts['link'].'" target="'.$atts['target'].'"> ';
	    	}
	    	
	    	$data .= '<span class="c5ab-single-icon c5ab-single-icon-'.$id.' '.$atts['icon'].'"></span>';
		    
		    if( $atts['link']!='' ){
		    	$data .= '</a>';
		    }
		    
		    $data .='<style>.c5ab-single-icon-'.$id.'{font-size:'.$atts['font_size'].'px; color:'.$atts['color'].';}.c5ab-single-icon-'.$id.':hover{color:'.$atts['hover_color'].';}  </style>';
		    
		    return $data;
		
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$obj = new C5AB_ICONS();
		$icons = $obj->get_icons_as_images();
		$this->_options =array(
			
			array(
			    'label' => 'Font Size',
			    'id' => 'font_size',
			    'type' => 'numeric-slider',
			    'desc' => 'Font Size for the icon.',
			    'std' => '20',
			    'min_max_step' => '12,400,1',
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
			    'label' => 'Color',
			    'id' => 'color',
			    'type' => 'colorpicker',
			    'desc' => 'Choose the color of the Icon.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Hover Color',
			    'id' => 'hover_color',
			    'type' => 'colorpicker',
			    'desc' => 'Choose the Hover color of the Icon.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			
			array(
			    'label' => 'Link',
			    'id' => 'link',
			    'type' => 'text',
			    'desc' => 'Add a url if you want to the icon to be clickable.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'link target',
			    'id' => 'target',
			    'type' => 'select',
			    'desc' => 'Choose button target.',
			    'choices' => array(
			        array(
			            'label' => 'Opens the linked document in a new window or tab',
			            'value' => '_blank'
			        ),
			        array(
			            'label' => 'Opens the linked document in the same frame as it was clicked (this is default)',
			            'value' => '_self'
			        ),
			        array(
			            'label' => 'Opens the linked document in the parent frame',
			            'value' => '_parent'
			        ),
			        array(
			            'label' => 'Opens the linked document in the full body of the window',
			            'value' => '_top'
			        )
			    ),
			    'std' => '_self',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
					 
		);
	}
	
	function css() {
		?>
		<style>
		
		</style>
		<?php
	}

}


 ?>