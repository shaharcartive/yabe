<?php 

class C5AB_toggle extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'toggle-widget';
		$this->_shortcode_name = 'c5ab_toggle';
		$name = 'Toggle';
		$desc = 'Toggle Box.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		
		$data = '<div class="toggle"><h3 class="clearfix"><span class="'.$atts['icon'].'"></span><a href="#">'.$atts['title'].'</a></h3><div class="content" style="display: none;">'.do_shortcode($content).'</div></div>';
		return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$icons = new C5AB_ICONS();
		$icons_array = $icons->get_icons_as_images();
		$this->_options =array(
			
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Call an action title.',
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
			   'std'         => 'fa fa-facebook',
			   'rows'        => '',
			   'post_type'   => '',
			   'taxonomy'    => '',
			   'class'       => 'c5ab_icons'
			 ),
			array(
			    'label' => 'Content',
			    'id' => 'content',
			    'type' => 'textarea-simple',
			    'desc' => 'Tab Content.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
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