<?php 




$timebeforerevote = 120;

add_action('wp_ajax_nopriv_c5_post_like', 'c5_post_like');
add_action('wp_ajax_c5_post_like', 'c5_post_like');


function c5_post_like()
{
	$nonce = $_POST['nonce'];
 
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
		
	if(isset($_POST['post_like']))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$post_id = $_POST['post_id'];
		
		$meta_IP = get_post_meta($post_id, "voted_IP");

		if(isset($meta_IP[0])){
			$voted_IP = $meta_IP[0];
			if(!is_array($voted_IP))
				$voted_IP = array();
		}else {
			$voted_IP = array();
			
		}
		$meta_count = get_post_meta($post_id, "votes_count", true);

		if(!hasAlreadyVoted($post_id))
		{
			$voted_IP[$ip] = time();

			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);
			
			echo $meta_count;
		}
		else
			echo "already";
	}
	exit;
}

function hasAlreadyVoted($post_id)
{
	global $timebeforerevote;

	$meta_IP = get_post_meta($post_id, "voted_IP");
	if(isset($meta_IP[0])){
		$voted_IP = $meta_IP[0];
		if(!is_array($voted_IP))
			$voted_IP = array();
	}else {
		$voted_IP = array();
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if(in_array($ip, array_keys($voted_IP)))
	{
		$time = $voted_IP[$ip];
		$now = time();
		
		if(round(($now - $time) / 60) > $timebeforerevote)
			return false;
			
		return true;
	}
	
	return false;
}

function getPostLikeLink($post_id)
{
	$like_enable = ot_get_option('like_enable');
	if($like_enable !='no'){
	$vote_count = get_post_meta($post_id, "votes_count", true);
	if($vote_count == ''){
		$vote_count = 0;
	}

	$output = '<p class="post-like clearfix">';
	if(hasAlreadyVoted($post_id))
		$output .= ' <span title="'.__('like', 'code125').'" class="qtip like alreadyvoted fa fa-heart"></span><span class="count">'.$vote_count.'</span>';
	else
		$output .= '<a href="#" data-post_id="'.$post_id.'">
					<span  title="'.__('like', 'code125').'" class="qtip like  fa fa-heart"></span><span class="count">'.$vote_count.'</span></a>';
	$output .= '</p>';
	}else {
		$output ='';
	}
	return $output;
}

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count ;
}

// function to count views.
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = 'Views';
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
	if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}

 ?>