<?php

class C5_Article {
	
	function get_social_li($class = '', $num = 0, $text='', $link='') {
		$data = '<li class="'.$class.'">';
		if($link!=''){
			$data .='<a href="'.$link.'" rel="nofollow" target="_blank">';
		}
		if ($num!='') {
			$data .='<span class="num">'.$this->custom_number_format( $num ) .'</span>';
		}
		$data .='<span class="text">'.$text.'</span>';
		if($link!=''){
			$data .='</a>';
		}
		$data .='</li>';
		return $data;
	}
	function custom_number_format($n) {
	
	        $precision = 1;
	
	        if ($n < 1000) {
	            $n_format = round($n);
	        } else if ($n < 1000000) {
	            $n_format = round($n / 1000, $precision) . 'K';
	        } else {
	            $n_format = round($n / 1000000, $precision) . 'M';
	        }
	
	        return $n_format;
	    }
	function get_featured_media() {
	        $data = '';
	        $width = $GLOBALS['c5_content_width'];
	        $height = round($width * 9 / 16);
	
	        $min_height = $height + 60;
	        $format = get_post_format();
			$meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
	        if ($format == 'video') {
	            $data .= do_shortcode('[c5ab_video url="' . $meta_attachment . '" width="100%" height="' . $height . '" ]');
	        } elseif ($format == 'audio') {
	            $data .= do_shortcode('[c5ab_audio url="' . $meta_attachment . '" ]');
	        }else {
	            if($meta_attachment!=''){
	            	$link = explode('/', $meta_attachment);
	            	if($link[2]=='twitter.com'){
	            		$data .= do_shortcode('[c5ab_tweet link="'.$meta_attachment.'" ]');
	            	}elseif($link[2]=='www.facebook.com'){
	            		if($width == 700){
	            			$width = 500;
	            		}
	            		$width = $GLOBALS['c5_content_width'];
	            		$GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']*0.7);
	            		$data .=   do_shortcode('[c5ab_facebook_post url="'.$meta_attachment.'" width="'.$width.'"]');
	            		
	            		$GLOBALS['c5_content_width'] = $width;
	            	}
	            		
	            }
	        }
	
	        return $data;
	    }
	
	function read_next() {
		echo '<div class="c5-next-prev-wrap c5-margin-bottom clearfix"><div class="row">';
		
		echo '<div class="col-sm-6 prev">';
		$next_post = get_previous_post();
		if (!empty( $next_post )): 
			$icon = 'left';
			if (is_rtl()) {
				$icon = 'right';
			}
		?>
			<p class="fa fa-long-arrow-<?php echo $icon ?>"></p><br/>
		  <a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a>
		<?php endif; 
		echo '</div>';
		
		echo '<div class="col-sm-6 next">';
		$next_post = get_next_post();
		if (!empty( $next_post )): 
			$icon = 'right';
			if (is_rtl()) {
				$icon = 'left';
			}
		?>
			<p class="fa fa-long-arrow-<?php echo $icon ?>"></p><br/>
		  <a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a>
		<?php endif; 
		echo '</div>';
		
		
		echo '</div></div>';
	}
	function social_share_buttons($value = '') {
		$meta_data = '';
		if ($value=='') {
			$value = 'facebook_on,twitter_on,googleplus_on,linkedin_on';
		}
		$raw_data = explode(',', $value );
		
		$valid_meta_data = array();
		if(!empty($raw_data)){
		    foreach ($raw_data as $meta_data) {
		    	$single_value = explode('_', $meta_data);
		    	if (isset($single_value[1])) {
		    		if ($single_value[1]=='on') {
			    		$valid_meta_data[] = $single_value[0];	
			    	}
		    	}
		    }
		}
		
		
		if (!empty($valid_meta_data)) {
			$meta_data = '<div class="c5-social-sidebar c5-margin-bottom clearfix">'.do_shortcode('[c5ab_title title="' . __('Share this article', 'code125') . '" icon="fa fa-share-alt"  ]') . '<div class="row">';
			$current_data = '';
			foreach ($valid_meta_data as $single_data) {
				
				switch ($single_data) {
					case 'facebook':
						$current_data .= '<div class="col-xs-3"><a class="c5-social facebook" href="http://www.facebook.com/sharer.php?u='. urlencode(get_permalink()) .'"><span class="fa fa-facebook"></span></a></div>';
						
						break;
					
					case 'twitter':
						$current_data .= '<div class="col-xs-3"><a class="c5-social twitter" href="http://twitter.com/share?text=' . get_the_title()  .'"><span class="fa fa-twitter"></span></a></div>';
						
						break;
					case 'googleplus':
						$current_data .= '<div class="col-xs-3"><a class="c5-social google" href="http://plus.google.com/share?url='. urlencode(get_permalink())  .'"><span class="fa fa-google-plus"></span></a></div>';
						
						break;
					case 'linkedin':
						//linkedin
						$post_obj = new C5_post();
						$url = 'http://www.linkedin.com/shareArticle?mini=true&url='. urlencode(get_permalink()) .'&title='.get_the_title().'&summary='.$post_obj->get_the_excerpt_max_charlength(300) ;
						
						$current_data .= '<div class="col-xs-3"><a class="c5-social linkedin" href="'.$url.'"><span class="fa fa-linkedin"></span></a></div>';
						break;
					default:
						break;
				}
			}
			if ($current_data=='') {
				return '';
			}
			$meta_data .= $current_data . '</div></div><div class="clearfix"></div>';
			echo $meta_data;
		}
	}
    function related_posts() {
        $post_obj = new C5_post();
        $settings_obj = new C5_theme_options();
        global $post;
        
        echo '<div class="c5-related-wrap c5-margin-bottom clearfix">';
        $code = '[c5ab_title apperance="title-style-1" title="' . __('Related Articles', 'code125') . '" font_size="20" font_weight="300" transform="normal" class="" icon="fa fa-tags" link="" id="" ]';
        echo do_shortcode($code);

        $related_type = $settings_obj->get_meta_option('related_type');
        $post_count = 3;
        $span = 12 / $post_count;
        $args = array(
            'post__not_in' => array($post->ID),
            'posts_per_page' => $post_count, // Number of related posts that will be shown.  
            'ignore_sticky_posts' => 1
        );
        if ($related_type == 'tags') {
            $tags = wp_get_post_tags($post->ID);

            if ($tags) {
                $tag_ids = array();
                foreach ($tags as $individual_tag) {
                    $tag_ids[] = $individual_tag->term_id;
                }
                $args['tag__in'] = $tag_ids;
            } else {
                $args['orderby'] = 'rand';
            }
        } elseif ($related_type == 'category') {
            $tax = c5_get_post_tax(get_the_ID());
            $cat = $post_obj->get_dominaiting_category();
            if ($tax = 'category') {
                $args['cat'] = $cat;
            } else {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => $tax,
                        'field' => 'id',
                        'terms' => $cat
                    )
                );
            }
        } else {
            $args['orderby'] = 'rand';
        }

        // The Query
        $the_query = new WP_Query($args);

        // The Loop
        if ($the_query->have_posts()) {
            $return = '<div class="row">';
            while ($the_query->have_posts()) {
                $the_query->the_post();

                $return .= '<div class="col-sm-' . $span . '">' . $post_obj->get_post_boxes() . '</div>';
            }
            $return .= '</div>';
            echo $return;
        }
        wp_reset_postdata();
        echo '</div>';
    }
    
    function comment_form() {
    	comments_template();
    	
    	
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields = array(
            'author' => '<input id="author" name="author" class="element-block " type="text" value="' .
            esc_attr($commenter['comment_author']) . '" size="30" tabindex="1" ' . $aria_req . ' placeholder="' . __('Name:', 'code125') . '"  />',
            'email' => '<input id="email" name="email" class="element-block" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" tabindex="2" ' . $aria_req . ' placeholder="' . __('Email:', 'code125') . '" />' .
            '</label>',
            'url' => '<input id="url" name="url" type="text" class="element-block " value="' . esc_attr($commenter['comment_author_url']) . '" size="30" tabindex="3"  placeholder="' . __('Website:', 'code125') . '" />' .
            '</label >'
        );



        $defaults = array(
            'fields' => apply_filters('comment_form_default_fields', $fields),
            'id_form' => 'commentform',
            'id_submit' => 'submit',
            'title_reply' => do_shortcode('[c5ab_title title="' . __('Post a comment', 'code125') . '" icon="fa fa-pencil"]') ,
            'comment_notes_after' => '',
            'title_reply_to' => __('Leave a Reply to %s', 'code125'),
            'cancel_reply_link' => __('Cancel reply', 'code125'),
            'label_submit' => __('Post comment.', 'code125'),
            'comment_field' => '<textarea id="comment"  placeholder="' . __('Message..', 'code125') . '" name="comment"  class="element-block  " tabindex="4" aria-required="true"></textarea>',
            'comment_notes_before' => ''
        );
		echo '<div class="c5-margin-bottom">';
        comment_form($defaults);
        echo '</div>';
    }
    
    function facebook_comment_form() {
    	echo '<div class="c5-margin-bottom">';
    	$settings_obj = new C5_theme_options();
    	$code = '[c5ab_title title="' . __('Facebook Comments', 'code125') . '" icon="fa fa-facebook"]';
    	echo do_shortcode($code);
    	$facebook_color = $settings_obj->get_meta_option('facebook_color');
    	?>
    	<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="<?php echo $GLOBALS['c5_content_width'] ?>" data-num-posts="5" data-colorscheme="<?php echo $facebook_color ?>"></div></div>
    	<?php
    }

}
?>