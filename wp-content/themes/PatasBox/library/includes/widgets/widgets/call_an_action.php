<?php 

class C5AB_call_an_action extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'call-an-action-widget';
		$this->_shortcode_name = 'c5ab_call_an_action';
		$name = 'Call an action';
		$desc = 'Call an action Box.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		$left = 'fadeInLeft';
		$right = 'fadeInRight';
		
		$data = '<div class="welcome_wrapper">
										 <div class="row">
										 	<div class="col-sm-10" c5ab-animation-data="'.$left.'">
										 		<h2 class="c5-wel-title">'.$atts['title'].'</h2>
										 		<p class="c5-wel-para">'.$content.'</p>
										 	</div>
										 	<div class="col-sm-2" c5ab-animation-data="'.$right.'">
										 		'.do_shortcode('[c5ab_button link="'.$atts['link'].'" text="'. $atts['button_text'] .'" ]').'
										 	</div>
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
			    'desc' => 'Call an action title.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Content',
			    'id' => 'content',
			    'type' => 'textarea-simple',
			    'desc' => 'Call an action content "It will be wrapped in p html tag".',
			    'std' => '',
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
	
	function css() {
		?>
		<style>
		.welcome_wrapper {
		  padding: 36px 0;
		}
		.welcome_wrapper h2.c5-wel-title {
		  font-size: 24px;
		  margin: 0px;
		  font-weight: 200;
		}
		.welcome_wrapper .c5-wel-para {
		  font-size: 18px;
		  font-weight: 300;
		}
		
		</style>
		<?php
	}

}


 ?>