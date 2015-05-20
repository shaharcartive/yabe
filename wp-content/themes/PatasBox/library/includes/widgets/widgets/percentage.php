<?php 

class C5AB_percentage extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'percentage-widget';
		$this->_shortcode_name = 'c5ab_percentage';
		$name = 'Percentage';
		$desc = 'Percentage bar.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		
		$data = '<div class="progress progress-striped active">
		  <div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: '.$atts['percentage'].'%">
		    <span class="">'.$atts['title'].'</span>
		  </div>
		</div>';
		return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
	
		$this->_options =array(
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Title .',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Percentage',
			    'id' => 'percentage',
			    'type' => 'text',
			    'desc' => 'Percentage',
			    'std' => '50', 
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