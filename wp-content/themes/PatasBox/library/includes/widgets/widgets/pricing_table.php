<?php 

class C5AB_pricing_table extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $_child_shortcode_bool = true;
	public  $_child_shortcode = 'c5ab_pricing_element';
	
	function __construct() {
		
		$id_base = 'pricing-table-column-widget';
		$this->_shortcode_name = 'c5ab_pricing_table';
		$name = 'Pricing table Column';
		$desc = 'Add Pricing table Column.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function child_shortcode($atts, $content) {
		    $x = $GLOBALS['c5ab_pricing_table_count'];
		    $GLOBALS['c5ab_pricing_table'][$x] = array('title' => sprintf($atts['title'], $GLOBALS['c5ab_pricing_table_count']) );
		
		    $GLOBALS['c5ab_pricing_table_count']++;
	}
	
	function shortcode($atts,$content) {
		
		$GLOBALS['c5ab_pricing_table_count'] = 0;
		    unset($GLOBALS['c5ab_pricing_table']);
		    do_shortcode($content);
		    
		    
		    if (is_array($GLOBALS['c5ab_pricing_table'])) {
		        $tabs = '';
		        $counter = 0;
		        foreach ($GLOBALS['c5ab_pricing_table'] as $tab) {
		            if($counter%2==0){
		            	$class= "even";
		            }else {
		            	$class= "odd";
		            }
		            $tabs .= '<div class="c5ab_pricing_element '.$class.'">' . $tab['title'] . '</div>';
		            $counter++;
		        }
		        $return = '<div class="c5ab_pricing_table clearfix"><div class="c5ab_pricing_title">'.$atts['title'].'</div><div class="c5ab_circle"><span class="price">'.$atts['price'].'</span><span class="price_subtitle">'.$atts['price_subtitle'].'</span></div>' . $tabs;
		        if($atts['button_text'] != '' && $atts['button_link'] != '' ){
		        	$return .= '<div class="c5ab_pricing_button">' . do_shortcode('[c5ab_button link="'.$atts['button_link'].'" font_size="16" text="'. $atts['button_text'] .'" float="center"]') . '</div>';
		        }
		        
		        $return .=  '</div>';
		
		    }
		    return $return;
	}
	
	
	
	function options() {
		
		$this->_options =array(
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Column Title.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Price',
			    'id' => 'price',
			    'type' => 'text',
			    'desc' => 'Column Price.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Price Subtitle',
			    'id' => 'price_subtitle',
			    'type' => 'text',
			    'desc' => 'Column Price subtitle.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Add Pricing Element',
			    'id' => 'c5ab_pricing_element',
			    'type' => 'list-item',
			    'desc' => 'Add Pricing Element the Pricing Column.',
			    'settings' => array(
			        array(
			            'label' => 'Content',
			            'id' => 'content',
			            'type' => 'textarea-simple',
			            'desc' => 'Pricing Element Content.',
			            'std' => '',
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        ),
			    ),
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
		 	    'desc' => 'Button text.',
		 	    'std' => '',
		 	    'rows' => '',
		 	    'post_type' => '',
		 	    'taxonomy' => '',
		 	    'class' => '',
		 	),
		 	array(
		 	    'label' => 'Button Link',
		 	    'id' => 'button_link',
		 	    'type' => 'text',
		 	    'desc' => 'Button link.',
		 	    'std' => '',
		 	    'rows' => '',
		 	    'post_type' => '',
		 	    'taxonomy' => '',
		 	    'class' => '',
		 	),
		);
	}
	
	
}


 ?>