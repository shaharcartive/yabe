<?php 

class C5AB_box extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'box-widget';
		$this->_shortcode_name = 'c5ab_box';
		$name = 'Box';
		$desc = 'Box bar.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		
		$data = '<div class="alert '.$atts['type'].'">'.do_shortcode($content).'</div>';
		return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
	
		$this->_options =array(
			array(
			    'label' => 'Box Type',
			    'id' => 'type',
			    'type' => 'select',
			    'desc' => 'Box Type.',
			    'choices' => array(
			    	array(
			    		'label' => 'Success',
			    		'value' => 'alert-success'
			    	),
			    	array(
			    		'label' => 'Info',
			    		'value' => 'alert-info'
			    	),
			    	array(
			    		'label' => 'Warning',
			    		'value' => 'alert-warning'
			    	),
			    	array(
			    		'label' => 'Danger',
			    		'value' => 'alert-danger'
			    	)
			    ),
			    'std' => 'alert-info',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Content',
			    'id' => 'content',
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
		
		</style>
		<?php
	}

}


 ?>