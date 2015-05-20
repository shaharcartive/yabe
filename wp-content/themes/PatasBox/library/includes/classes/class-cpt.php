<?php 

class C5_cpt extends C5_skin_base {
	
	function __construct() {
		$this->slug = 'cpt';
		$this->name = 'Add Post Type';
		$this->image = 'cpt';
		$this->supports = array( 'title' );
		$this->hook();
	}
	
	function register_custom_posttype() {
		register_post_type( $this->slug,
		
		 	// let's now add all the options for this post type
			array('labels' => array(
				'name' =>  'Add Post Type', 
				'singular_name' => 'Add Post Type', 
				'all_items' => 'Post Types', 
				'add_new' => 'Add Post Type' ,
				'add_new_item' => 'Add Post Type' , 
				'edit' => 'Edit', /* Edit Dialog */
				'edit_item' => 'Edit Post Type' , 
				'new_item' => 'Add Post Type', 
				'view_item' => 'View Post Type' , 
				'search_items' => 'Search Post Types', 
				'not_found' =>  'Nothing found in the Database.',
				'not_found_in_trash' => 'Nothing found in Trash', 
				'parent_item_colon' => ''
				), 
				
				'description' => '', 
				'public' => false,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => 30, 
				'menu_icon' => C5_skins_URL. 'images/'.$this->image.'.png', 
				'rewrite'	=> array( 'slug' => $this->slug,  'with_front' => false ),
				'has_archive' => $this->slug, 
				'capability_type' => 'page',
				'hierarchical' => false,
				'supports' => $this->supports
		 	) 
		); 
	}
	
	
	function meta_box() {
		
		$cpt_meta_basics = array(
		    array(
		        'label' => 'Slug',
		        'id' => 'slug',
		        'type' => 'text',
		        'desc' => 'Add Custom Post Type Slug.',
		        'std' => 'book',
		        'rows' => '',
		        'post_type' => '',
		        'taxonomy' => '',
		        'class' => ''
		    ),
		    array(
		        'label' => 'Name',
		        'id' => 'name',
		        'type' => 'text',
		        'desc' => 'Add Custom Post Type Name & Menu label.',
		        'std' => 'Books',
		        'rows' => '',
		        'post_type' => '',
		        'taxonomy' => '',
		        'class' => ''
		    ),
		    array(
		        'label' => 'Singular Name',
		        'id' => 'singular_name',
		        'type' => 'text',
		        'desc' => 'Add Custom Post Type Singular Name.',
		        'std' => 'Book',
		        'rows' => '',
		        'post_type' => '',
		        'taxonomy' => '',
		        'class' => ''
		    ),
		    
		);
		if(!C5_simple_option){
			$cpt_meta_basics[] = array(
			    'label' => 'Posts Skin',
			    'id' => 'skin_default',
			    'type' => 'custom-post-type-select',
			    'desc' => 'Choose Default Posts Skin.',
			    'post_type' => 'skin',
			    'std' => '',
			);
		}
		
		
	    $meta_skins_layout = array(
	        'id' => 'meta_skins',
	        'title' => 'Custom Post Type Info',
	        'desc' => '',
	        'pages' => array('cpt'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $cpt_meta_basics ,
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	    
	    
	   $page_templates = $this->get_templates_list();
	    
	    $cpt_taxonomy_array = array(
	        array(
	            'label' => 'Enable Taxonomy',
	            'id' => 'enable_category',
	            'type' => 'on_off',
	            'desc' => 'Enable Category/Taxonomy',
	            'std' => 'off',
	        ),
	        array(
	            'label' => 'Category Name',
	            'id' => 'category_name',
	            'type' => 'text',
	            'desc' => 'Add Category name"',
	            'std' => 'Categories',
	        ),
	        array(
	            'label' => 'Category Name (Singular)',
	            'id' => 'category_name_singular',
	            'type' => 'text',
	            'desc' => 'Add Category name"',
	            'std' => 'Category',
	        ),
	        array(
	            'label' => 'Category slug',
	            'id' => 'category',
	            'type' => 'text',
	            'desc' => 'Add Category to this custom post, add its slug here "this will be used in the url of the category page"',
	            'std' => 'book_cat',
	        ),
	        
	        	        
	        
	    );
	    if(!C5_simple_option){
	    	$cpt_taxonomy_array[] = array(
	    	    'label' => 'Category Skin',
	    	    'id' => 'category_skin',
	    	    'type' => 'custom-post-type-select',
	    	    'desc' => 'Choose Default Category Skin.',
	    	    'post_type' => 'skin',
	    	    'std' => '',
	    	    
	    	);
	    }
	    
	    $cpt_taxonomy_array[] = array(
	        'label' => 'Category Page template.',
	        'id' => 'category_template',
	        'type' => 'select',
	        'desc' => 'Choose your Default Category Page template.',
	        'choices'=> $page_templates,
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => '',
	        'section' => 'default_templates'
	    );
	    $cpt_taxonomy_array[] = array(
	        'label' => 'Enable Tags',
	        'id' => 'enable_tags',
	        'type' => 'on_off',
	        'desc' => 'Add Tags to this post type',
	        'std' => 'on',
	    );
	    
	    
	    $meta_cpt_tax = array(
	        'id' => 'meta_cpt_tax',
	        'title' => 'Custom Post Type Taxonomy Info',
	        'desc' => '',
	        'pages' => array('cpt'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $cpt_taxonomy_array  ,
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	    
	    
	   $theme_options_element = new C5_theme_option_elements();
	    
	    $meta_cpt_article = array(
	        'id' => 'meta_cpt_article',
	        'title' => 'Custom Post Type Article Info',
	        'desc' => '',
	        'pages' => array('cpt'),
	        'context' => 'normal',
	        'priority' => 'low',
	        'fields' => $theme_options_element->get_articles_options(),
	        'std' => '',
	        'rows' => '',
	        'post_type' => '',
	        'taxonomy' => '',
	        'class' => ''
	    );
	
		
		
		
	    ot_register_meta_box($meta_skins_layout);
	    ot_register_meta_box($meta_cpt_tax);
	    ot_register_meta_box($meta_cpt_article);
	}
	
	
}

 ?>