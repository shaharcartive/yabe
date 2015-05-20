<?php 

class C5AB_divider extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $_skip_title = true;
	
	function __construct() {
		
		$id_base = 'divider-widget';
		$this->_shortcode_name = 'c5ab_divider';
		$name = 'Divider';
		$desc = 'Divider Box.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		
		$data = '<div class="c5ab_divider" style="margin-top:'.$atts['margin_top'].'px;margin-bottom:'.$atts['margin_bottom'].'px;"></div>';
		return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$icons = new C5AB_ICONS();
		$icons_array = $icons->get_icons();
		$this->_options =array(
			
			array(
			    'label' => 'Margin top',
			    'id' => 'margin_top',
			    'type' => 'text',
			    'desc' => 'Margin top in pixels, Default: 0.',
			    'std' => '0',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Margin bottom',
			    'id' => 'margin_bottom',
			    'type' => 'text',
			    'desc' => 'Margin bottom in pixels, Default: 0.',
			    'std' => '0',
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
		.c5ab_divider{
			display: block;
			height: 1px;
			background: #DDDDDD;
			width: 100%;
		}
		</style>
		<?php
	}

}


 ?>