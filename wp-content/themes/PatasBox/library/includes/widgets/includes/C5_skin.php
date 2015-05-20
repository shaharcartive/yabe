<?php 

class C5_skin_functions {
	function skin_exist($id) {
	        if ($id == '') {
	            return false;
	        }
	        // retrieve one post with an ID of 5
	        query_posts('p=' . $id . '&post_type=skin');
	        $found = false;
	        // the Loop
	        while (have_posts()) : the_post();
	            $found = true;
	        endwhile;
	
	        wp_reset_query();
	        return $found;
	    }
	    
	    
	    function get_color_from_skin($skin_id) {
	    	return get_post_meta($skin_id, 'primary_color', true);
	    }
}

 ?>