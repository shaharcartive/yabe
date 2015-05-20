<?php


/**
 * 
 * @param type $post_id
 * update the value of rating in the database after action update post
 */
function c5_update_my_post_rating($post_id) {
    $newRating = c5_review_calculate_average_rating($post_id);
    update_post_meta($post_id, 'c5_rating', $newRating);
}

add_action('save_post', 'c5_update_my_post_rating');

/**
 * 
 * @param type $rating
 * @return type rating number in percentage formate
 */
function c5_review_percentage($rating) {
    
    return '<div class="progress progress-striped">
      <div class="progress-bar progress-bar-success" style="width: '.$rating.'%">
        <span class="text">'.$rating.'%</span>
      </div>
    </div>';
}

/**
 * 
 * @param type $rating
 * @return type rating number in points formate
 */
function c5_review_points($rating) {
    $text = $rating / 10;
    
    return '<div class="progress progress-striped">
      <div class="progress-bar progress-bar-success" style="width: '.$rating.'%">
        <span class="text">'.$text.'</span>
      </div>
    </div>';
}

/**
 * 
 * @param type $rating
 * @return string of rating as star for complete srat,
 *  hstar for half star and estar for empty star
 */
function c5_review_stars($rating) {
	$rating_of_stars = ($rating / 20);
    $rating_double = $rating_of_stars * 2;
    $rating_round = round($rating_double);
    $rating = $rating_round / 2;
    $result = '<span class="c5-rating-wrap">';
    $count = $rating;
    while ($rating >= 1) {
       
        $result .=  '<span class="fa fa-star "></span>';
        
        $rating--;
    }
    if ($rating != 0) {
        $result .=  '<span class="fa fa-star-half-o "></span>';
    }
    // add to complete 5 stars
    while ($count <= 4) {
       	$result .=  '<span class="fa fa-star-o "></span>';
        $count++;
    }
    
    $result .= '</span>';
    return $result;
}

/**
 * 
 * @param type $post_id
 * @return type value of review type of rating
 */
function c5_review_type_of_review($post_id) {
    return get_post_meta($post_id, 'meta_review_type', true);
}

/**
 * 
 * @param type $post_id
 * @return boolean true if review rating is enable and false otherwise
 */
function has_review($post_id) {

    $meta_reviews = get_post_meta($post_id , 'meta_reviews', true);
	
	if(is_array($meta_reviews)){
		return true;
	}else {
		return false;
	}    
}

/**
 * 
 * @return type the average rating of post
 */
function c5_review_calculate_average_rating($post_id) {
    $rating = 0;
    
    if (has_review($post_id)) {
        $rating_numbers = 0;
        $count = 0;
        $meta_reviews = get_post_meta($post_id , 'meta_reviews', true);
        foreach ($meta_reviews as $review) {
            $rating_numbers = $rating_numbers + $review['rating'];
            $count++;
            
        }
        $rating = round($rating_numbers / $count, 2);
    }
    return $rating;
}

function get_rating_average($rating) {
	return round( $rating/20, 2);
	
}




function c5_format_rating($rating, $type_of_review) {
	$result_shape_of_rating = '';
	if ($type_of_review == 'stars') {
	    $result_shape_of_rating = c5_review_stars($rating);
	    $rating = round($rating / 20, 2);
	} else if ($type_of_review == 'points') {
	    $result_shape_of_rating = c5_review_points($rating);
	    $rating = round($rating / 10, 2);
	} else {
	    $result_shape_of_rating = c5_review_percentage($rating);
	}
	return $result_shape_of_rating;
}

/**
 * 
 * @param type $result_shape_of_rating
 * @param type $rating
 * return display table of rating information
 */
function c5_review_display_table( $rating) {
    $meta_reviews = get_post_meta(get_the_ID() , 'meta_reviews', true);
    $type_of_review = c5_review_type_of_review(get_the_ID());
    $result_shape_of_rating = c5_format_rating($rating , $type_of_review);
    if (is_array($meta_reviews)) {
        $table_review = '<div class="c5-rating-box">';
        foreach ($meta_reviews as $review) {
            $table_review .= '<div class="rating-row"><div class="row"><div class="col-xs-6"><h5>' . $review['title'] . '</h5></div>';
            $table_review .= '<div class="col-xs-6">' .  c5_format_rating( $review['rating'] , $type_of_review) . '</div></div></div>';
            
        }
        // add comment to table
        $comment = get_post_meta(get_the_ID() , 'meta_review_comment', true);
        if($comment!=''){
        	$table_review .=  '<div class="row"><div class="col-md-12"><div class="review_comment">' . $comment . '</div></div></div>';
        }
        $total_count = 0;
         $rating = 0;
         foreach ($meta_reviews as $review) {
             $rating = $rating + $review['rating'];
             $total_count++;
         }
        
         $count = round( $rating/$total_count);
         $seo_count = round($count/20 ,2);
         
         $table_review .= '<div class="c5-rating-view" style="opacity: 0; visibility: hidden;" itemscope itemtype="http://data-vocabulary.org/Review">
             <span itemprop="itemreviewed">'. get_the_title() .'</span>
             Reviewed by <span itemprop="reviewer"><a class="url fn" href="' . get_author_posts_url(get_the_author_meta('ID')) . '"><span class="fa fa-user"></span>' . get_the_author_meta('display_name') . '</a></span> on
             <time itemprop="dtreviewed" datetime="'. get_the_time('Y-m-d') .'">'. get_the_time('M N') .'</time>.
             Rating: <span itemprop="rating">'. $seo_count .'</span>
           </div>';
        
        $table_review .= '</div>';
        return $table_review;
    }
    return '';
}

/**
 * meta box of review 
 */
function c5_custom_meta_boxes_review() {
	if(function_exists('c5_get_all_posts_types_in_array')){
		  $post_types = c5_get_all_posts_in_array();
	}else {
		  $post_types =  array( 'post');
	}
    $review = array(
        'id' => 'meta_review',
        'title' => 'Review Options',
        'desc' => '',
        'pages' => $post_types,
        'context' => 'normal',
        'priority' => 'low',
        'fields' => array(
            array(
                'label' => 'Reviews',
                'id' => 'meta_reviews',
                'type' => 'list-item',
                'desc' => 'Add Reviews to your post.',
                'settings' => array(
                    array(
                        'label' => 'Rating Value',
                        'id' => 'rating',
                        'type' => 'numeric-slider',
                        'desc' => 'Add the rating Value From 0 to 100.',
                        'min_max_step' => '1,100,1',
                        'std' => '100',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => ''
                    )
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Rating Comment',
                'id' => 'meta_review_comment',
                'type' => 'textarea-simple',
                'desc' => 'Comment about the Product you are reviewing.',
                'std' => '',
                'rows' => '5',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Review Type',
                'id' => 'meta_review_type',
                'type' => 'select',
                'desc' => 'Select to Type of the review in this article?, Default: Stars.',
                'choices' => array(
                    array(
                        'label' => 'Stars',
                        'value' => 'stars'
                    ),
                    array(
                        'label' => 'Percentage',
                        'value' => 'percentage'
                    ),
                    array(
                        'label' => 'Points',
                        'value' => 'points'
                    )
                ),
                'std' => 'stars',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            )
       	),
        'std' => '',
        'rows' => '',
        'post_type' => '',
        'taxonomy' => '',
        'class' => ''
    );
    ot_register_meta_box($review);
}

add_action('admin_init', 'c5_custom_meta_boxes_review');

if(!class_exists('C5_Widget')){
	return;
}

class C5AB_review extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'review-widget';
		$this->_shortcode_name = 'c5ab_review';
		$name = 'Article Review';
		$desc = 'Article Review Box.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		if(!is_single()){
			return '';
		}
		$rating = get_post_meta( get_the_ID() , 'c5_rating', true);
		$data= '';
		if ($rating != '') {
		    
		    // table of reviews
		    $data = c5_review_display_table( $rating);
		}
		return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$icons = new C5AB_ICONS();
		$icons_array = $icons->get_icons();
		$this->_options =array(
			
			
		 
		);
	}
	
	function css() {
		?>
		<style>
		
		</style>
		<?php
	}

}


?>
