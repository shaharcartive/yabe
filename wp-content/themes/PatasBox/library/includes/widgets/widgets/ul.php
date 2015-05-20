<?php 

class C5AB_ul extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $_child_shortcode_bool = true;
	public  $_child_shortcode = 'c5ab_li';
	
	function __construct() {
		
		$id_base = 'ul-widget';
		$this->_shortcode_name = 'c5ab_ul';
		$name = 'UL "Unordered List"';
		$desc = 'Add UL "Unordered List".';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
	}
	
	
	function child_shortcode($atts, $content) {
		    $x = $GLOBALS['c5ab_ul_count'];
		    $GLOBALS['c5ab_ul'][$x] = array('title' => sprintf($atts['title'], $GLOBALS['c5ab_ul_count']), 'icon' => $atts['icon'] , 'color' => $atts['color'],'content' => $content );
		
		    $GLOBALS['c5ab_ul_count']++;
	}
	
	function shortcode($atts,$content) {
		
		$GLOBALS['c5ab_ul_count'] = 0;
		unset($GLOBALS['c5ab_ul']);
		    do_shortcode($content);
		
		    $ul = '';
		    foreach ($GLOBALS['c5ab_ul'] as $tab) {
		        $id= $this->get_unique_id();
		    	$ul .=  '<li class="c5ab_custom_li_'.$id.'"><span class="'.$tab['icon'].'" title="' . $tab['title'] . '"></span>' . do_shortcode( $tab['content'] ) . '</li>';
		    	$ul .= '<style>.c5ab_custom_li_'.$id.' .fa{ color:'.$tab['color'].'}</style>';
		      
		    }
		    $return = '<ul class="c5ab_custom_ul clearfix">' . $ul . '</ul>';
		    
		    		    
		    
		    return $return;
	}
	
	function get_unique_id() {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 5; $i++) {
		    $randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	function custom_css() {
		
	}
	
	
	
	
	function options() {
		$icons = new C5AB_ICONS();
		$icons_array = $icons->get_icons_as_images(); 
		
		$colors = $this->get_main_colors();
		
		
		$this->_options =array(
			array(
			    'label' => 'Add li',
			    'id' => 'c5ab_li',
			    'type' => 'list-item',
			    'desc' => 'Add li to the ul box.',
			    'settings' => array(
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
			            'label' => 'Color',
			            'id' => 'color',
			            'type' => 'colorpicker',
			            'desc' => '',
			            'std' => $colors['primary'],
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        ),
			        array(
			            'label' => 'Content',
			            'id' => 'content',
			            'type' => 'textarea-simple',
			            'desc' => '',
			            'std' => '',
			            'rows' => '5',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        )
			    ),
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
		ul.c5ab_custom_ul{
			margin: 0px;
			padding: 0px;
			list-style: none;
		}
		ul.c5ab_custom_ul li {
			padding-left:30px;
			margin-bottom:15px;
		}
		ul.c5ab_custom_ul li .fa{
			margin-left:-30px;
			width: 30px;
			text-align: center;
		}
		
	</style>
	<?php
	}

}


 ?>