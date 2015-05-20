<?php 

class C5AB_button extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'button-widget';
		$this->_shortcode_name = 'c5ab_button';
		$name = 'Button';
		$desc = 'Add a Button.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		$id = $this->get_unique_id();
		$style_obj = new C5AB_STYLE();
		
		$icon = '';
		$has_icon ='';
		if($atts['icon']!='fa fa-none'){
			$icon = '<span class="icon '.$atts['icon'].'"></span>';
			$has_icon ='has_icon';
		}
		
		$data = '<a href="' . $atts['link'] . '" target="'.$atts['target'].'" class="'.$has_icon.' ' . $atts['button_class'] . ' c5btn c5btn-'.$id.' ' . $atts['float'] . '"><span class="text">' . $atts['text'] .'</span>' . $icon .'</a>';
		
		global $c5_skindata;
		if($atts['button_color']==''){
			
			$atts['button_color'] = $c5_skindata['primary_color'];
		}
		
		if($atts['button_hover_color']==''){
			
			$atts['button_hover_color'] = $style_obj->hexDarker($atts['button_color'],20);
		}
		$color_text_lum = c5_get_lum($atts['button_color']);
		if ($color_text_lum > 170) {
			$color_text= '#333';
		}else {
			$color_text= '#f8f8f8';
		}
		
		$border_color = $style_obj->hexDarker($atts['button_color'],20);
		$border_color_hover = $style_obj->hexDarker($atts['button_hover_color'],20);
		
		$color_text_hover_lum = c5_get_lum($atts['button_hover_color']);
		if ($color_text_hover_lum > 170) {
			$color_text_hover = '#333';
		}else {
			$color_text_hover= '#f8f8f8';
		}
		
		$data .= '<style>
		.c5btn.c5btn-'.$id.'{
			padding: '.round( 1.2*$atts['font_size']).'px '.round( 1.8*$atts['font_size']).'px;
			font-size:'.$atts['font_size'].'px; 
		}
		.c5btn.c5btn-'.$id.'{
			background-color: '. $atts['button_color'] .';
			color: '.$color_text.';
			border-bottom: 3px solid '.$border_color.';
			text-shadow: 0px -2px '.$border_color.';
			
		}
		.c5btn.c5btn-'.$id.':hover{ 
			background-color: '. $atts['button_hover_color'] .';
			color: '.$color_text_hover.';
			border-bottom: 3px solid '.$border_color_hover.';
			text-shadow: 0px -2px '.$border_color_hover.';
		}
		</style>';
		
		return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$colors = $this->get_main_colors();
		$obj = new C5AB_ICONS();
		$icons = $obj->get_icons_as_images();
		$this->_options =array(
			
			array(
			    'label' => 'Text',
			    'id' => 'text',
			    'type' => 'text',
			    'desc' => 'Button Text.',
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
			    'desc' => 'Button Link.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button target',
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
			    'label' => 'Font Size',
			    'id' => 'font_size',
			    'type' => 'numeric-slider',
			    'desc' => 'Font Size for the title.',
			    'std' => '12',
			    'min_max_step' => '12,100,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button Class',
			    'id' => 'button_class',
			    'type' => 'text',
			    'desc' => 'Service Column Button Text.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Float',
			    'id' => 'float',
			    'type' => 'select',
			    'desc' => 'Choose button float.',
			    'choices' => array(
			        array(
			            'label' => 'Left',
			            'value' => 'left'
			        ),
			        array(
			            'label' => 'Center',
			            'value' => 'center'
			        ),
			        array(
			            'label' => 'Right',
			            'value' => 'right'
			        )
			    ),
			    'std' => 'center',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Button Color',
			    'id' => 'button_color',
			    'type' => 'colorpicker',
			    'desc' => 'Button Text Color.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button Hover Color',
			    'id' => 'button_hover_color',
			    'type' => 'colorpicker',
			    'desc' => 'Button Text Hover Color.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
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