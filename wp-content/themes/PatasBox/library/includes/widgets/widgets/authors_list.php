<?php 

class C5AB_authors_list extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'authors_list-widget';
		$this->_shortcode_name = 'c5ab_authors_list';
		$name = 'Authors List';
		$desc = 'Authors list.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		$title = '';
		if($atts['title']!= '' ){	
			$title = do_shortcode('[c5ab_title apperance="title-style-1" title="' . $atts['title'] . '" font_size="20" font_weight="300" transform="normal" class="" icon="fa fa-authors_list" link="" id="" ]');
		}
		
		ob_start();
			wp_list_authors();
			$wp_list_authors = ob_get_contents();
			ob_end_clean();
		
		return $title . '<ul class="authors_list">' . $wp_list_authors . '</ul>';
		
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
		 
		);
	}
	
	function css() {
		?>
		<style>
		ul.authors_lists_list li{
			padding-left:0px;
			padding-right:0px;
		}
		ul.authors_lists_list li img{
			float: left;
			margin-right:15px;
			width: 50px;
			border-radius:2px;
		}
		ul.authors_lists_list li a{
			font-size:12px;
			line-height:1.3;
		}
		</style>
		<?php
	}

}


 ?>