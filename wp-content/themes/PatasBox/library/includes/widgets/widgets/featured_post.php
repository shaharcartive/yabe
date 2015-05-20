<?php 

class C5AB_featured_post extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $_skip_title = true;
	
	function __construct() {
		
		$id_base = 'featured_post-widget';
		$this->_shortcode_name = 'c5ab_featured_post';
		$name = 'Featured Post';
		$desc = 'Featured Post';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
			$post_type = get_post_type($atts['post_id']);
		    $args  =array();
		    
		    $args['post_type'] = $post_type;
		    $args['p'] = $atts['post_id'];
		    // The Query
		    $the_query = new WP_Query( $args );
		    $return = '';
		    
		    // The Loop
		    if ( $the_query->have_posts() ) {
		    	$code = '[c5ab_title title="' . $atts['featured_post'] . '"  icon="' . $atts['icon'] . '"]';
		    	 $return .= do_shortcode($code);
		          
		         while ( $the_query->have_posts() ) {
		    		$the_query->the_post();
		    		
		    		
    		        $class = '';
    				$post_obj = new C5_post();
    		        
    		        $width = $GLOBALS['c5_content_width'];
    		        $GLOBALS['c5_content_width'] = 300;
    		       	$return .= $post_obj->get_post_blog_3(true);
		    		$GLOBALS['c5_content_width'] = $width;
		    	 }
		   	}
		   	/* Restore original Post Data */
		   	wp_reset_postdata();
		    return $return;
		
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$obj = new C5AB_ICONS();
		$icons = $obj->get_icons_as_images();
		
		
		
		
		
		$this->_options =array(
			
			array(
			    'label' => 'Title',
			    'id' => 'featured_post',
			    'type' => 'text',
			    'desc' => 'Title.',
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
			  'choices' => $icons,
			  'std'         => 'fa fa-none',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => 'c5ab_icons'
			),
			array(
			    'label' => 'Post ID',
			    'id' => 'post_id',
			    'type' => 'text',
			    'desc' => 'Add your Post ID.',
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
		
		
		h2.featured_post {
		  font-size: 16px;
		  font-weight: 600;
		  margin: 0px;
		  line-height: 1.4;
		  margin-bottom:20px;
		  font-family: "Helvetica Neue", Helvetica;
		}
		h2.featured_post .icon{
			margin-right:15px;
		}
		h2.featured_post.uppercase{
			text-transform:uppercase;
		}
		
		
		
		
		</style>
		<?php
	}

}


 ?>