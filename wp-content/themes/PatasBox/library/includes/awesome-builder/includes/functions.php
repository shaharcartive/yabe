<?php 

function c5_update_ab_templates() {
	$templates = array();
	
	$premade_templates = c5_get_premade_templates();
	
	foreach ($premade_templates as $id => $name) {
		$templates[$id] = ' [template] ' . $name;
	}
	
	$array = c5ab_get_option('post_types');
	if(is_array($array)){
		foreach($array as $type){
			$args = array(
				'post_type'=> $type,
				'posts_per_page'    => -1,
			);
			// The Query
			$the_query = new WP_Query( $args );
			$return = '';
			// The Loop
			if ( $the_query->have_posts() ) {
			   while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$template = get_post_meta(get_the_ID(), 'c5ab_data', true);
				    if( is_array(@unserialize( base64_decode( $template) )) ){
				    	$templates[ get_the_ID() ] = get_the_title();
				    }
				}
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
	}
	
	asort($templates);
	
	update_option('c5ab_templates' , $templates);
	
}

function c5_get_ab_templates() {
	$templates = get_option('c5ab_templates');
	if(!is_array($templates)){
		c5_update_ab_templates();
		$templates = get_option('c5ab_templates');
	}
	return $templates;
	
}

 ?>