<?php

class C5AB_search extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'search-widget';
        $this->_shortcode_name = 'c5ab_search';
        $name = 'Search';
        $desc = 'Add Search Box.';
        $classes = '';
		
		add_filter('pre_get_posts',array( $this , 'searchfilter') );
        $this->self_construct($name, $id_base, $desc, $classes);
    }
	
	function searchfilter($query) {
		$post_type = get_option('c5_search_post_type');
	    if($post_type==''){
	    	$post_type = 'post';
	    }
	    if ($query->is_search && !is_admin() ) {
	        $query->set('post_type',array($post_type));
	        if(isset($_GET['term'])){
	        	if($_GET['term']!='-1'){
	        	$query->set('tax_query' , array(
	        			array(
	        				'taxonomy' => $_GET['tax'],
	        				'field' => 'id',
	        				'terms' => $_GET['term']
	        			)
	        		) );
	        	}
	        }
	    }
	
	return $query;
	}
	
	
    function shortcode($atts, $content) {
    		update_option('c5_search_post_type' , $atts['search_post']);
    		
    		$args = array(
    			'show_option_none' => __('Select Category','c5ab'),
    			'echo'=>false
    		);
    		
			$form = '<div id="c5ab_widget_search" class=" c5-filer-'.$atts['search_filter'].' clearfix">
			
				<form role="search" method="get" id="c5_searchform" action="'. home_url( '/' ).'" >
				<input type="text" value="'. get_search_query() .'" name="s" id="c5ab_search_field" placeholder="'.$atts['search_text'].'" />';
				
			if($atts['search_filter']=='on'){
				$tax = $this->get_tax_of_post_type( $atts['search_post'] );
				if($tax!=''){
				
				 	$terms = get_terms($tax);
				 	$count = count($terms);
				 	if ( $count > 0 ){
				 		if($tax== 'category'){
				 			$tax_echo = 'cat';
				 		}else {
				 			$tax_echo = 'term';
				 		}
				 		if($tax!= 'category'){
				 			$form .= '<input type="hidden" name="tax" value="'.$tax.'" />';
				 		}
				 		$form .= '<select name="'.$tax_echo.'" id="'.$tax_echo.'" class="postform">
				 			<option value="-1">'.__('Select Category','c5ab').'</option>';
				 		foreach ( $terms as $term ) {
				 			$selected ='';
				 			
				 			if(isset($_GET[$tax_echo])){
				 				if($_GET[$tax_echo] == $term->term_id){
				 					$selected ='selected="selected"';
				 				}
				 			}
				 	       $form .= '<option class="level-0" '.$selected.' value="'. $term->term_id .'">'. $term->name .'</option>';
				 	    }
				 	    $form .= '</select>';
				 	}
				}
			}	
				
			$form .= '</form>
			</div><div class="clearfix"></div>';
			
			return $form;
	}
	
	function get_tax_of_post_type($post_type) {
		$taxonomies = get_taxonomies( '','objects' );
		foreach ($taxonomies as  $tax) {
			if($post_type == $tax->object_type[0]){
				return $tax->name;
			}
		}
	}

    function custom_css() {
        
    }

    function options() {
		
		$args =array('show_ui'=> true);
		$types_array = array();
		$output = 'objects'; // names or objects
		
		$post_types = get_post_types( $args, $output );
		//print_r($post_types);
		$exlude_array = array(
			'attachment',
			'skin',
			'header',
			'footer'
		);
		foreach ( $post_types  as $key => $post_type ) {
			
			if(!in_array($key,  $exlude_array) ){
				$types_array[] = array(
					'label'       => $post_type->label,
					'value'       => $key
				); 
			}
		}
		
        $this->_options = array(
            array(
                'label' => 'Default Search Post Type',
                'id' => 'search_post',
                'type' => 'select',
                'desc' => 'Choose the post type you want to make the search based on.',
                'choices' => $types_array,
                'std' => 'post',
                'section' => 'search'
            ),
            array(
                'label' => 'Show Category Filter',
                'id' => 'search_filter',
                'type' => 'on_off',
                'desc' => 'Show Category Filter.',
                'std' => 'on',
                'section' => 'search'
            ),
            array(
                'label' => 'Placeholder Text',
                'id' => 'search_text',
                'type' => 'text',
                'desc' => 'Add your Placeholder text.',
                'std' => 'Search Your website ...',
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
		#c5ab_search_field{
			width: 48%;
			padding: 10px;
			border: none;
			color: #333;
			margin-right: 4%;
			display: block;
			float: left;
		}
		
		.c5-filer-off #c5ab_search_field{
			width: 100%;
			margin-right: 0px;
		}
		
		#c5_searchform select{
			width: 48%;
			height: 36px;
			border: none;
			background: #eee;
			display: block;
			float: left;
		}
		
        </style>
        <?php

    }


}
?>