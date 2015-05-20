<?php 

class C5_custom_post_type {
	function __construct() {
		add_action( 'init',  array($this, 'register_custom_posttype'));
	}
	function register_custom_posttype() {
		
		
		
	    $query = new WP_Query(array('post_type' => 'cpt', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'publish'));
	
	    /* has posts */
	    if ($query->have_posts()) {
	        while ($query->have_posts()) {
	            $query->the_post();
	            
	            $custom_post_array = get_post_custom(get_the_ID());
	            $custom_post = array();
	            foreach ($custom_post_array as $key => $value) {
	            	$custom_post[$key] = $value[0];
	            }
	            //print_r($custom_post);
	            $taxonomies = array();
	            if($custom_post['enable_category'] == 'on' && $custom_post['category']!='') {
	            	$taxonomies[] = $custom_post['category'];
	            }
	            if($custom_post['enable_tags'] == 'on') {
	            	$taxonomies[] = 'post_tag';
	            }
	            
	            register_post_type( $custom_post['slug'], 
	            	array('labels' => array(
	                		'name' => $custom_post['name'],
	                		'singular_name' =>  $custom_post['singular_name'],
	                		'all_items' => 'All '. $custom_post['name'],
	                		'add_new' => 'Add New ' . $custom_post['singular_name'], 
	                		'add_new_item' => 'Add New '.$custom_post['singular_name'] ,
	                		'edit' => 'Edit',
	                		'edit_item' => 'Edit '.$custom_post['singular_name'], 
	                		'new_item' => 'New '.$custom_post['singular_name'] , 
	                		'view_item' => 'View '.$custom_post['singular_name'] , 
	                		'search_items' => 'Search '.$custom_post['name'] ,
	                		'not_found' =>  'Nothing found in the Database.', 
	                		'not_found_in_trash' => 'Nothing found in Trash',
	            			'parent_item_colon' => ''
	            		), 
	            		
	            		'description' => 'This is the example '.$custom_post['name'] ,
	            		'public' => true,
	            		'publicly_queryable' => true,
	            		'exclude_from_search' => false,
	            		'show_ui' => true,
	            		'query_var' => true,
	            		'menu_position' => 8, 
	            		'rewrite'	=> array( 'slug' => $custom_post['slug'], 'with_front' => false ), 
	            		'has_archive' => true,
	            		'capability_type' => 'post',
	            		'hierarchical' => false,
	            		'supports' => array( 'title',  'comments' ,'editor', 'thumbnail', 'excerpt'  , 'sticky' , 'post-formats'),
	            		'taxonomies' => $taxonomies
	             	) 
	            ); 
	            
	            if($custom_post['enable_category'] == 'on' && $custom_post['category']!='') {
	                register_taxonomy( $custom_post['category'], 
	                	array($custom_post['slug']), 
	                	array('hierarchical' => true,    
	                		'labels' => array(
	                			'name' => $custom_post['category_name'], 
	                			'singular_name' =>$custom_post['category_name_singular'], 		            
	                			'search_items' =>   'Search '.$custom_post['category_name'],
	                			'all_items' => 'All '.$custom_post['category_name'], 
	                			'parent_item' =>  'Parent '.$custom_post['category_name_singular'], 
	                			'parent_item_colon' => 'Parent '.$custom_post['category_name_singular'].':',
	                			'edit_item' =>  'Edit '.$custom_post['category_name_singular'],
	                			'update_item' =>  'Update '.$custom_post['category_name_singular'], 
	                			'add_new_item' =>  'Add New '.$custom_post['category_name_singular'],
	                			'new_item_name' =>  'New '.$custom_post['category_name_singular'],	
	                		),
	                		'show_ui' => true,
	                		'query_var' => true,
	                	)
	                ); 
	            }
	            
	            
	        }
	    }
	    wp_reset_postdata();
		
	}
}

$obj_custom_types = new C5_custom_post_type();


function c5_get_post_tax($id) {
	$post_type = get_post_type($id);
	$taxonomies=get_taxonomies();
	$skip = array(
		'post_tag',
		'nav_menu',
		'link_category',
		'post_format'
	);
	foreach ($taxonomies as $tax) {
		if(!in_array($tax , $skip) ){
			$tax_obj = get_taxonomy( $tax );
			if($tax_obj->object_type[0] == $post_type){
				return $tax;
			}
		}
	}
	
}

 ?>