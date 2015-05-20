<?php global $c5_skindata; ?>
<div id="main" class="clearfix" role="main">
	<div class="c5-main-width-wrap clearfix">
    <?php
    
    
    if ($c5_skindata['template_id'] != '') {
        echo do_shortcode('[c5ab_template id="' . $c5_skindata['template_id'] . '"]');
    } else {
    	$blog_type = ot_get_option('default_blog_layout');
    	if ($blog_type == '') {
    		$blog_type = 'blog-1';
    	}
    	
    	switch ($blog_type) {
    		case 'blog-1':
    			$meta_value = 'author_on,time_on,comment_on,category_on,like_on,views_on,rating_on';
    			break;
    		case 'blog-2':
    			$meta_value = 'author_off,time_on,comment_on,category_off,like_on,views_on,rating_off';
    			break;
    		case 'grid-1':
    			$meta_value = 'author_off,time_off,category_on,comment_on,like_on,views_off,rating_off';
    			break;
    		case 'grid-2':
    			$meta_value = 'author_on,time_off,category_off,comment_on,like_on,views_off,rating_off';
    			break;
    		case 'grid-3':
    			$meta_value = 'author_off,time_on,category_off,comment_on,like_on,views_off,rating_off';
    			break;
    		default:
    			$meta_value = 'author_on,time_on,comment_on,category_on,like_on,views_on,rating_on';
    			break;
    	}
    	
        echo do_shortcode('[c5ab_posts render_type="'.$blog_type.'"  follow="on" posts_per_page="'.get_option( 'posts_per_page').'" post_type="post"  orderby="date" order="DESC" posts="" paging="on"  meta_data="'.$meta_value.'"]');
    }
    ?>
    </div>


</div>