<?php 

class C5AB_center extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'center-widget';
		$this->_shortcode_name = 'c5ab_center';
		$name = 'Center';
		$desc = 'Center bar.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		
		$data = '<div class="c5ab_center_everything">'.do_shortcode($content).'</div>';
		return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
	
		$this->_options =array(
			array(
			    'label' => 'Content',
			    'id' => 'conte',
			    'type' => 'textarea-simple',
			    'desc' => 'Content .',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		 
		);
	}
	
	function css() {
		?>
		<style>
		.c5ab_center_everything{
			text-align: center;
		}
		</style>
		<?php
	}

}


 ?>