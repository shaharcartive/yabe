<?php 

class C5_theme_options  {
	function get_meta_option($option) {
		$post_type = get_post_type();
		if($post_type == 'post'){
				return ot_get_option($option);
		}else {
			$post_type_ID = $this->get_cpt( get_post_type(get_the_ID()));
			$value =  get_post_meta($post_type_ID, $option, true);
			if($value!=''){
				return $value;
			}
		}
		return ot_get_option($option);
	}
	
	function get_cpt($slug) {
		$args = array(
			'post_type' => 'cpt',
			'meta_value' => $slug
		);
		$id = false;
		$the_query = new WP_Query( $args );
		// The Loop
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$id = get_the_ID();
			}
		}
		wp_reset_postdata();
		return $id;
	}
	
}

 ?>