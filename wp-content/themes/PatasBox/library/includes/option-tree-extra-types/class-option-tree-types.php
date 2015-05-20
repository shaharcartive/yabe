<?php 

class C5_option_tree_type {
	
	function __construct() {
	
		define('C5_OT_Extra_Type_ROOT', get_template_directory_uri() . '/library/includes/option-tree-extra-types/');
		add_action('admin_enqueue_scripts',array($this, 'hook_script_and_style'),999);
	}
	
	function hook_script_and_style() {
		wp_enqueue_script( 'c5-admin-selectize-js', C5_OT_Extra_Type_ROOT.'selectize.min.js',false );
		wp_enqueue_script( 'c5-ot-type-script-js', C5_OT_Extra_Type_ROOT.'c5-ot-type-script.js',false );
		
		
		wp_enqueue_style( 'c5-ot-selectize', C5_OT_Extra_Type_ROOT.'selectize.css' );
		wp_enqueue_style( 'c5-ot-selectize-bs', C5_OT_Extra_Type_ROOT.'selectize.bootstrap3.css' );	
		wp_enqueue_style( 'c5-ot-type-css', C5_OT_Extra_Type_ROOT.'c5-ot-type-css.css' );	
	}	
}

$obj_C5_option_tree_type = new C5_option_tree_type();


if ( ! function_exists( 'ot_type_post_select' ) ) {
  
  function ot_type_post_select( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-post-search clearfix ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
     /* description */
     echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
     
     
     
     /* format setting inner wrapper */
     echo '<div class="format-setting-inner '.$field_class.'">';
     
     echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="'.$field_value.'" class="c5-save-post-type-value" />';
     
     echo '<ul class="c5-current-values clearfix">';
     if($field_value == ''){
     	$values = array();
     }else {
     	$values = explode(',', $field_value );	
     }
     
     $values_array = array();
     if(!empty($values)){
	     foreach ($values as $value) {
	     	$li = '<li class="ui-state-default" data-info="'.$value.'">';
	     	$li .= c5_get_post_type_name_from_value($value);
	     	$li .= '<span class="fa fa-times"></span></li>';
	     	echo $li;
	     }
     }
     
     echo '</ul>';
     echo '<div class="clearfix"></div>';
     
     $args = array('show_ui' => true);
     $output = 'objects'; // names or objects
	 echo '<div class="clearfix c5-post-type-wrap">';
	 $screen_base = '';
	 $current_screen = get_current_screen();
	 if (is_object($current_screen)) {
	 	$screen_base = 	$current_screen->base;
	 }
	 echo '<p>Choose Post Type:</p><select class="c5-post-type c5-screen-'.$screen_base.'" name="c5-post-type" id="c5-post-type">';
	 
	 $post_types_all = get_post_types($args, $output);
	 $exlude_array_no_page = array(
         'attachment',
         'skin',
         'header',
         'footer',
         'page',
         'cpt'
     );
	 echo '<option value="">Choose Post Type</option>';
     foreach ($post_types_all as $key => $post_type) {
		if (!in_array($key, $exlude_array_no_page)) {
            echo '<option value="'.$key .'">'.$post_type->label .'</option>';
         }
     }
     echo '</select>';
     echo '</div>';
     echo '<div class="clearfix"></div>';
     echo '<div class="c5-categories-wrap"></div>';
     echo '<div class="c5-terms-wrap"></div>';
     
     echo '</div>';
    
    echo '</div>';
  }
}




if ( ! function_exists( 'ot_type_posts_search' ) ) {
  
  function ot_type_posts_search( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-post-search clearfix ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
     /* description */
     echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
     
     
     
     /* format setting inner wrapper */
     echo '<div class="format-setting-inner '.$field_class.'">';
     
     echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="'.$field_value.'" class="c5-save-posts-search-value" />';
     
     echo '<ul class="c5-posts-current-values clearfix">';
     if($field_value==''){
     	$values = array();
     }else {
     	$values = explode(',', $field_value );
     }
     
     
     $values_array = array();
     if(!empty($values)){
         foreach ($values as $value) {
         	$li = '<li class="ui-state-default"  data-info="'.$value.'">';
         	$li .= c5_get_post_name_via_ID($value);
         	$li .= '<span class="fa fa-times"></span></li>';
         	echo $li;
         }
     }
     
     echo '</ul>';
     echo '<div class="clearfix"></div>';
     
     $screen_base = '';
     $current_screen = get_current_screen();
     if (is_object($current_screen)) {
     	$screen_base = 	$current_screen->base;
     }
     $args = array('show_ui' => true);
     $output = 'objects'; // names or objects
     echo '<div class="clearfix c5-post-type-wrap">';
     echo '<p>Choose Post Type:</p><select class="c5-posts-search-post-type c5-screen-'.$screen_base.'" name="c5-post-type" id="c5-post-type">';
     $post_types_all = get_post_types($args, $output);
     $exlude_array_no_page = array(
         'attachment',
         'skin',
         'header',
         'footer',
         'page',
         'cpt'
     );
     echo '<option value="">Choose Post Type</option>';
     foreach ($post_types_all as $key => $post_type) {
    	if (!in_array($key, $exlude_array_no_page)) {
            echo '<option value="'.$key .'">'.$post_type->label .'</option>';
         }
     }
     echo '</select>';
     echo '</div>';
     echo '<div class="clearfix"></div>';
     echo '<div class="c5-articles-wrap"></div>';
     
     echo '</div>';
    
    echo '</div>';
  }
}

if ( ! function_exists( 'ot_type_tax_search' ) ) {
  
  function ot_type_tax_search( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tax-search ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
     /* description */
     echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
     
     c5_ajax_search_form($args, 'tax', $field_taxonomy);
    
    echo '</div>';
  }
}


if ( ! function_exists( 'ot_type_author_select' ) ) {
  
  function ot_type_author_select( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting c5-author-search type-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      	
      	 
      	 $screen_base = '';
      	 $current_screen = get_current_screen();
      	 if (is_object($current_screen)) {
      	 	$screen_base = 	$current_screen->base;
      	 }
      	 
        /* build select */
        echo '<select id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_name ) . '" class=" c5-author-search-ajax c5-screen-'.$screen_base.'">';
        echo '<option value="">Choose/Search For Author</option>';
        echo '<option value="-1">Current Article Author</option>';
        if ($field_value!='' && $field_value!='-1') {
        	$user = get_userdata($field_value);
        	echo '<option value="'.$field_value.'" selected="selected">'.$user->display_name.'</option>';
        }
        echo '</select>';
        
      echo '</div>';
      echo '<div class="clearfix"></div>';
    
    echo '</div>';
    
  }
  
}


if ( ! function_exists( 'ot_type_meta_data' ) ) {
  
  function ot_type_meta_data( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-post-search clearfix ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
     /* description */
     echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
     
     
     
     /* format setting inner wrapper */
     echo '<div class="format-setting-inner '.$field_class.'">';
     
     echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="'.$field_value.'" class="c5-save-meta-data-value" />';
     
     echo '<ul class="c5-meta-data-values clearfix">';
     
     
     if (empty($field_choices)) {
     	
	     $pre_loaded_array = array(
	     	'category' => array(
	     		'icon' => 'fa fa-tags',
	     		'title' => 'Category',
	     		'default'=>'on'
	     	),
	     	'author' => array(
	     		'icon' => 'fa fa-user',
	     		'title' => 'Author',
	     		'default'=>'on'
	     	),
	     	'comment' => array(
	     		'icon' => 'fa fa-comment',
	     		'title' => 'Comment Count',
	     		'default'=>'on'
	     	),
	     	'time' => array(
	     		'icon' => 'fa fa-clock-o',
	     		'title' => 'Time & Date',
	     		'default'=>'on'
	     	),
	     	'like' => array(
	     		'icon' => 'fa fa-heart',
	     		'title' => 'Like Count',
	     		'default'=>'on'
	     	),
	     	'views' => array(
	     		'icon' => 'fa fa-eye',
	     		'title' => 'Views',
	     		'default'=>'on'
	     	),
	     	'rating' => array(
	     		'icon' => 'fa fa-star',
	     		'title' => 'Rating',
	     		'default'=>'on'
	     	),
	     	'share' => array(
	     		'icon' => 'fa fa-share',
	     		'title' => 'Social Share Count',
	     		'default'=>'on'
	     	),
	     );
     
     }else {
     	$pre_loaded_array = array();
     	foreach ( (array) $field_choices as $choice ) {
     	
     		$pre_loaded_array[ $choice['value']  ] = array(
     			'icon' => $choice['icon'],
     			'title' => $choice['label'],
     			'default' => $choice['default']
     		);
     	  
     	}
     }
     
     $values_array =array();
     $transient_array = array();
    if ($field_value!='') {
    	$saved_data = explode(',', $field_value ); 
    	foreach ($saved_data as  $value) {
    		$value_info = explode('_', $value );
    		$transient_array[$value_info[0]] = $value_info[1];
    	}
    }
	
	foreach ($pre_loaded_array as $key => $data_value) {
		
		$test_array = $data_value;
		//default
		$test_array['status'] = $data_value['default'];
		//off
		if (strpos($field_value,  $key . '_off') !== false) {
			$test_array['status'] = 'off';
		}
		//on
		if (strpos($field_value, $key . '_on') !== false) {
			$test_array['status'] = 'on';
		}
		$values_array[$key] = $test_array;
	}
	
	$final_values = array();
	if (empty($transient_array)) {
		$final_values = $values_array;
	}else {
		foreach ($transient_array as $key => $value) {
			if (isset($values_array[$key])) {
				$final_values[$key] = $values_array[$key];	
				unset($values_array[$key]);
			}
		}
		if (!empty($values_array)) {
			foreach ($values_array as $key => $value) {
				$final_values[$key] = $values_array[$key];
			}
		}
		
	}
    
     
 	
        
     
     
     if(!empty($final_values)){
         foreach ($final_values as $key => $value) {
         	$li = '<li class="ui-state-default c5-current-status-'.$value['status'].'"  data-info="'.$key.'" data-status="'.$value['status'].'">';
         	
         	
         	$li .= '<span class="c5-icon-item '.$value['icon'].'"></span>' . $value['title'];
         	
         	if($value['status'] == 'off'){
         		$li .= '<span class="fa c5-change-status fa-eye-slash"></span>';
         	}else {
         		$li .= '<span class="fa c5-change-status fa-eye"></span>';
         	}
         	
         	$li .= '</li>';
         	echo $li;
         }
     }
     
     echo '</ul>';
     echo '<div class="clearfix"></div>';
     
     echo '<div class="clearfix"></div>';
     
     echo '</div>';
    
    echo '</div>';
  }
}

function c5_ajax_search_form($args, $type, $search_value) {
	
	/* turns arguments array into variables */
	extract( $args );
	
	/* format setting inner wrapper */
	echo '<div class="format-setting-inner '.$field_class.'">';
	
	$values = explode(',', $field_value );
	$values_array = array();
	foreach ($values as $key => $value) {
		if($type == 'tax'){
			
		}elseif ($type == 'author') {
			
		}else {
			
		}
	}
	
	echo '<ul class="c5-current-values"></ul>';
	echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="'.$field_value.'" />';
	echo '<input type="text" name="' . esc_attr( $field_name ) . '-search-field" id="' . esc_attr( $field_id ) . '-search-field" class="c5-helper-search" placeholder="Start Searching"  data-search-type="'.$type.'" data-search-value="'.$search_value.'" />';
	 
	echo '<ul class="c5-search-helper-container"></ul>';
	
	echo '</div>';
}





/**Ajax Functions*/
function c5_get_post_type_terms() {
	$post_type = $_POST['post_type'];
	$obj = get_post_type_object($post_type );
	
	$taxonomies=get_taxonomies(array() ,'objects'); 
	if  ($taxonomies) {
	  echo '<p>Selection Based On:</p><select name="c5-category-select" id="c5-category-select"  class="c5-category-select">';
	  echo '<option value="">Selection based on:</option>';
	  echo '<option value="'.$post_type.'#author">Author</option>';
	  foreach ($taxonomies  as $taxonomy ) {
	  	if(in_array($post_type, $taxonomy->object_type)){
	    	echo '<option value="'.$post_type.'#'.$taxonomy->name.'">'.$taxonomy->label.'</option>';
	    }
	  }
	  echo '</select>';
	}  
	
	die();
}
 add_action( 'wp_ajax_c5_get_post_type_terms', 'c5_get_post_type_terms' );


function c5_get_tax_ajax_name() {
	$value = $_POST['value'];
	echo c5_get_post_type_name_from_value($value);
	die();
}

function c5_get_post_type_name_from_value($value) {
	$return = '';
	$value_a = explode('#', $value);
	$obj = get_post_type_object($value_a[0]);
	$return .= '['.$obj->labels->name .'] ';
	
	if(!isset($value_a[1])){
		$return .= 'All Categories';
		return $return;
	}
	
	if($value_a[1] == 'author'){
		$return .= 'Author - ';
		if(isset($value_a[2])){
			$user_info = get_userdata($value_a[2]);
			$return .= $user_info->display_name;
		}else {
			$return .= 'All Authors';
		}
	}else {
		$tax_obj = get_taxonomy($value_a[1]);
		$return .= $tax_obj->labels->singular_name .' - ';
		if(isset($value_a[2])){
			$term = get_term($value_a[2],$value_a[1]);
			$return .= $term->name;
		}else {
			$return .= 'All '.$tax_obj->labels->name;
		}
	}
	return $return;
}
 add_action( 'wp_ajax_c5_get_tax_ajax_name', 'c5_get_tax_ajax_name' ); 
 
 
 function c5_search_authors_via_ajax() {
 	global $wpdb;
 	
 	$options =array();
 	$name = $_POST['name'];
 	
 	$query = "SELECT ID FROM {$wpdb->users} WHERE display_name LIKE '%{$name}%'";
 	$results = $wpdb->get_results($query);
 	if ( ! empty( $results ) ) {
 		foreach ($results as $user) {
 			$user_ID = $user->ID;
 			$user_info = get_userdata($user_ID);
 			$options[] =array(
 				'title'=> $user_info->display_name,
 				'value'=> $user_ID
 			);
 		}
 	}
 	echo json_encode( $options );
 	die();
 }
 add_action( 'wp_ajax_c5_search_authors_via_ajax', 'c5_search_authors_via_ajax' ); 
 
 function c5_search_terms_ajax() {
 	$value_a = explode('#', $_POST['value']);
 	$post_type = $value_a[0];
 	$options =array();
 	$tax = $value_a[1];
 	
 	if($tax == 'author'){
 		
 		$name = $_POST['q'];
 		global $wpdb;
 		$query = "SELECT ID FROM {$wpdb->users} WHERE display_name LIKE '%{$name}%'";
 		$results = $wpdb->get_results($query);
 		if ( ! empty( $results ) ) {
 			foreach ($results as $user) {
 				$user_ID = $user->ID;
 				$user_info = get_userdata($user_ID);
 				$options[] =array(
 					'title'=> $user_info->display_name,
 					'value'=>$_POST['value'] . '#' .$user_ID
 				);
 			}
 		}
 	}else{
	 	
	 	
	 	$args = array(
	 	    'search' => $_POST['q']
	 	); 
	 	$terms = get_terms($tax ,$args);
	 	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
	 	    
	 	    foreach ($terms as $term) {
	 	        $options[] =array(
	 	    		'title'=> $term->name,
	 	    		'value'=>$_POST['value'] . '#' .$term->term_id
	 	    	);
	 	    }
	 	}
	 }
 	
 	echo json_encode( $options );
 	die();
 }
  add_action( 'wp_ajax_c5_search_terms_ajax', 'c5_search_terms_ajax' ); 
 function c5_get_tax_ajax_terms() {
 	$value = $_POST['value'];
 	$value_a = explode('#', $value);
 	$post_type = $value_a[0];
 	$tax = $value_a[1];
 	$search = false;
 	$options = array();
 	$text = '';
 	if($tax =='author'){
 	
 		$users = count_users();
 		if(isset($users['avail_roles']['subscriber'])){
 			$users_total = $users['total_users']-$users['avail_roles']['subscriber'];
 		}else {
 			$users_total = $users['total_users'];
 		}
 		
 		$options[''] = 'Choose Author';
 		$options[$post_type.'#'.$tax] = 'All Authors';
 		
 		if($users_total<20){
 			$blogusers = get_users();
 			foreach ($blogusers as $user) {
 			    if (count_user_posts($user->ID) > 0) {
 			        $options[$post_type.'#'.$tax.'#'.$user->ID] = $user->display_name;
 			    }
 			}
 			$text ='Choose Author:';
 		}else {
 			$search = true;
 			$text ='Search Author:';
 		}
 		
 	}else {
 		$count = wp_count_terms( $tax);
 		$tax_obj = get_taxonomy($tax);
 		$tax_group = $tax_obj->labels->name;
 		$tax_single = $tax_obj->labels->singular_name;
 		
 		$options[''] = 'Choose '.$tax_single;
 		$options[$post_type.'#'.$tax] = 'All ' .$tax_group;
 		
 		if($count < 20){
 			$text ='Choose '.$tax_single.':';
 			$categories = get_terms( $tax, array(
 			 	'orderby'    => 'count',
 			 	'hide_empty' => 0
 			 ) );
 			 if ( !empty( $categories ) && !is_wp_error( $categories ) ){
 			      
 			      foreach ( $categories as $term ) {
 			        $options[$post_type.'#'.$tax.'#'.$term->term_id] = $term->name;
 			      }
 			 }
 		}else {
 			$text ='Search '.$tax_group.':';
 			$search = true;
 		}	
 	}
 	$class= '';
 	if($search){
 		$class= ' c5-searchable ';
 	}
 	 	
 	
 	if (!empty($options)) {
 		echo '<p>'.$text.'</p><select name="c5-terms-select" id="c5-terms-select"  class="c5-terms-select '.$class.'">';
 		foreach ( $options as $key => $option ) {
 		  echo '<option value="'.$key.'">'.$option.'</option>';
 		}
 		echo '</select>';
 	}
 	die();
 }
  add_action( 'wp_ajax_c5_get_tax_ajax_terms', 'c5_get_tax_ajax_terms' );
  
  
  /**Article Search*/
  function c5_get_posts_by_search() {
  	$post_type = $_POST['post_type'];
  	$obj = get_post_type_object($post_type );
  	$text = 'Search '. $obj->labels->name;
  	echo '<p>'.$text.'</p><select name="c5-articles-select" id="c5-articles-select"  class="c5-articles-select">';
  	
  	die();
  }
  add_action( 'wp_ajax_c5_get_posts_by_search', 'c5_get_posts_by_search' );
  
  
  function c5_search_for_articles() {
  	$post_type = $_POST['post_type'];
  	$query = $_POST['q'];
  	$options = array();
  	$args = array(
  		'post_type'=>$post_type,
  		's'=>$query
  	);
  	
  	// The Query
  	$the_query = new WP_Query( $args );
  	
  	// The Loop
  	if ( $the_query->have_posts() ) {
  		while ( $the_query->have_posts() ) {
  			$the_query->the_post();
  			$options[] =array(
  				'title'=> get_the_title(),
  				'value'=>get_the_ID()
  			);
  		}
  	} else {
  		// no posts found
  	}
  	/* Restore original Post Data */
  	wp_reset_postdata();
  	
  	echo json_encode($options);
  	
  	die();
  }
  add_action( 'wp_ajax_c5_search_for_articles', 'c5_search_for_articles' );
  
  function c5_get_article_name_ajax() {
  	$id = $_POST['value'];
  	  	
  	echo c5_get_post_name_via_ID($id);
  	
  	die();
  }
  function c5_get_post_name_via_ID($id) {
  	$post_type = get_post_type($id);
  	
  	$args = array(
  		'post_type'=>$post_type,
  		'p'=>$id
  	);
  	$title = '';
  	// The Query
  	$the_query = new WP_Query( $args );
  	
  	// The Loop
  	if ( $the_query->have_posts() ) {
  		while ( $the_query->have_posts() ) {
  			$the_query->the_post();
  			$title =  get_the_title();
  		}
  	} else {
  		// no posts found
  	}
  	/* Restore original Post Data */
  	wp_reset_postdata();
  	return $title;
  }
  add_action( 'wp_ajax_c5_get_article_name_ajax', 'c5_get_article_name_ajax' );
  
  function c5_get_ajax_post_types() {
  	$args = array('show_ui' => true);
  	$output = 'objects'; // names or objects
  	$post_types_all = get_post_types($args, $output);
  	$exlude_array_no_page = array(
  	    'attachment',
  	    'skin',
  	    'header',
  	    'footer',
  	    'page',
  	    'cpt'
  	);
  	$options = array();
  	foreach ($post_types_all as $key => $post_type) {
  		if (!in_array($key, $exlude_array_no_page)) {
  	       $options[] =array(
  	       	'title'=> $post_type->label,
  	       	'value'=>$key
  	       );
  	    }
  	}
  	 echo json_encode($options);
  	
  	die();
  }
    add_action( 'wp_ajax_c5_get_ajax_post_types', 'c5_get_ajax_post_types' );
  
  
  
  
 ?>