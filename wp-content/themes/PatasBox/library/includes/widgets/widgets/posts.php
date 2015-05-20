<?php 

class C5AB_posts extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	function __construct() {
		
		$id_base = 'posts-widget';
		$this->_shortcode_name = 'c5ab_posts';
		$name = 'Posts ';
		$desc = 'Add Posts Feed to your page.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		if (!isset($GLOBALS['c5ab_posts_js_bool'])) {
			add_action('wp_footer', array($this, 'custom_js'), 300);
			$GLOBALS['c5ab_posts_js_bool'] = true;
		}
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		if (!isset($GLOBALS['c5ab_posts_js'])) {
		    $GLOBALS['c5ab_posts_js'] = '';
		}
		
		
		$post_obj = new C5_post();
		
		$args = $post_obj->handle_atts($atts);
		
		$skin_obj = new C5_skin_functions();
		
		$slider_id = $this->get_unique_id();
		$atts['ID'] = $slider_id;
		
		
		// The Query
		$the_query = new WP_Query( $args );
		$return = '';
		// The Loop
		if ( $the_query->have_posts() ) {
		       	
		        $return .= '<div class="c5ab_posts_'.$atts['render_type'].'  c5ab_posts_'.$atts['render_type'].'_' . $slider_id . '"  ><div class="c5-load-wrap">';
		        
		        
		        if( $atts['render_type'] == 'slider'  || $atts['render_type'] == 'carousel'){
		        	$return .= '<ul class="c5ab_slides clearfix">';
		        }
		        
		        
		        
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				switch ($atts['render_type']) {
					case 'slider':
						$return .= $post_obj->get_post_slide($atts);
						break;
					case 'blog-thumb';
						$return .= $post_obj->get_post_thumb($atts);	
						break;
					case 'grid-1';
						$current_count = $the_query->current_post;
						if ($GLOBALS['c5_content_width'] < 400) {
							$col_count= 1;
						}elseif ($GLOBALS['c5_content_width'] < 800) {
							$col_count= 2;
						}else {
							$col_count= 3;
						}
						
						$return .= $post_obj->get_grid_1_item($atts, $col_count, $current_count);
						break;
					case 'grid-2';
						if ($GLOBALS['c5_content_width'] < 400) {
							$col_count= 1;
						}elseif ($GLOBALS['c5_content_width'] < 800) {
							$col_count= 2;
						}else {
							$col_count= 3;
						}
						$current_count = $the_query->current_post;
						$return .= $post_obj->get_grid_2_item($atts, $col_count, $current_count);
						break;
					case 'grid-3';
						if ($GLOBALS['c5_content_width'] < 400) {
							$col_count= 1;
						}elseif ($GLOBALS['c5_content_width'] < 800) {
							$col_count= 2;
						}else {
							$col_count= 3;
						}
						$current_count = $the_query->current_post;
						$return .= $post_obj->get_grid_3_item($atts, $col_count, $current_count);
						break;
					case 'blog-1';
						$return .=  $post_obj->get_post_blog_1($atts );
						break;
					case  'blog-2':
						$return .= $post_obj->get_post_blog_2($atts) ;
						break;
					
				}
				
			}
				
				if( $atts['render_type'] == 'slider'  || $atts['render_type'] == 'carousel' ){
					$return .= '</ul>';
				}
				$return .=  '</div>';
				$return .= $post_obj->get_pagination($atts, $the_query, $args);
		        $return .=  '</div>';
		        
		        
		       
		        
		}else {
			$return = '<article id="post-not-found" class="hentry clearfix">
			    <header class="article-header">
			        <h1>'. __('No Articles to show!', 'code125') .'</h1>
			    </header>
			    <section class="entry-content">
			        <p>'. __('No articles found to show on this page.', 'code125').'</p>
			    </section>
			</article>';
		}
		
		/* Restore original Post Data */
		wp_reset_postdata();
		
		
		if( $atts['render_type'] == 'slider' ){
			$GLOBALS['c5ab_posts_js'] .= '$(\'.c5ab_posts_slider_' . $slider_id . '\').flexslider({
		    	          animation: "slide",
		    	          selector: "ul.c5ab_slides > li",
		    	          smoothHeight: true,
		    	          prevText: "",
		    	          nextText: "",
		    	    });'. "\n";
		}
		
		     
		
		
		if( $atts['render_type'] == 'grid-1' || $atts['render_type'] == 'grid-2' || $atts['render_type'] == 'grid-3' ){
		
			if ($GLOBALS['c5_content_width'] < 400) {
				$col_count= 1;
				$single_width =  $GLOBALS['c5_content_width'];
				
			}elseif ($GLOBALS['c5_content_width'] < 800) {
				$col_count= 2;
				$single_width = ( $GLOBALS['c5_content_width']+30) /2;
			}else {
				$col_count= 3;
				$single_width = ( $GLOBALS['c5_content_width']+30)/3;
			}
			$single_width = floor($single_width);
			$height = round( ($single_width-30) * 0.62962962963);
			
			$return .=  '<style>.c5ab_posts_'.$atts['render_type'].'_' . $slider_id . ' .element{width:'.$single_width.'px} .c5ab_posts_'.$atts['render_type'].'_' . $slider_id . ' /*.element .c5-image-wrap {min-height:'.$height.'px}*/</style>';
			
			$GLOBALS['c5ab_posts_js'] .= "
			\$container_".$slider_id." = $('.c5ab_posts_".$atts['render_type']."_" . $slider_id . " .c5-load-wrap').isotope({itemSelector:'.element',masonry: {
			      columnWidth: ".$single_width."
			    }}); \n 
			 $('#filter-".$slider_id."').on( 'click', 'button', function() {
			   var filterValue = $(this).attr('data-filter');
			   $(this).parent().find('button').removeClass('current');
			   $(this).addClass('current');
			   \$container_".$slider_id.".isotope({ filter: filterValue });
			 });   
			    
			    ";
		}
		
		
		
		if( $atts['render_type'] == 'carousel' ){
			if ($GLOBALS['c5_content_width'] < 350) {
			    $single_width = $GLOBALS['c5_content_width'];
			}elseif ($GLOBALS['c5_content_width'] < 700) {
			    $single_width = floor($GLOBALS['c5_content_width'] / 3);
			} elseif ($GLOBALS['c5_content_width'] < 1000) {
			    $single_width = floor($GLOBALS['c5_content_width'] / 4);
			} else {
			    $single_width = floor($GLOBALS['c5_content_width'] / 5);
			}
			$GLOBALS['c5ab_posts_js'] .= '$(\'.c5ab_posts_carousel_' . $slider_id . '\').flexslider({animation:"slide", animationLoop:false, selector:".c5ab_slides > li", itemWidth:'.$single_width.', itemMargin:0, controlNav:false, directionNav:true, move:1, slideshow:false}); ' . "\n";
		}
		
		        
		    return $return;
	}
	
	
	
	function custom_css() {
		
	}
	
	function custom_js() {
	    ?>
	    <script  type="text/javascript">
	        jQuery(document).ready(function($) {
			    <?php
			    if (isset($GLOBALS['c5ab_posts_js'])) {
			        echo $GLOBALS['c5ab_posts_js'];
			    }
			    ?>
	        });
	    </script>
	    <?php
	}
	
	
	
	function options() {
		
		$post_obj = new C5_post();
		$this->_options =array(
			
			$post_obj->get_render_type_array('render_type' , 'blog-1'),
			$post_obj->get_follow_array('follow' , 'off'),
			$post_obj->get_posts_per_page_array('posts_per_page', '5'),
			array(
			    'label' => 'Post Type',
			    'id' => 'post_type',
			    'type' => 'post-select',
			    'desc' => 'Add Different Parameters to show your posts, select by tag, category or author.',
			    'std' => 'post',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			//$post_obj->get_category_array('post_type','post'),
//			$post_obj->get_tags_array('tag',''),
//			$post_obj->get_authors_array('author',''),
			$post_obj->get_orderby_array('orderby','date'),
			$post_obj->get_order_array('order','DESC'),
			array(
			    'label' => 'Add Specific Articles',
			    'id' => 'posts',
			    'type' => 'posts-search',
			    'desc' => 'Add Specific Articles to this query "Any other query will be ignored".',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			$post_obj->get_show_paging_array('paging','off'),
			array(
			    'label' => 'Enable Animation',
			    'id' => 'animation',
			    'type' => 'on_off',
			    'desc' => 'Enable Animation for articles',
			    'std' => 'on',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Reorder and Enable/Disable Meta Data',
			    'id' => 'meta_data',
			    'type' => 'meta-data',
			    'desc' => 'Reorder and Enable/Disable the Meta data for you blog posts',
			    'std' => 'author-image_on,author_on,time_on,category_on,comment_on,like_on',
			    'choices' => array(
			    	array( 
			    		'label'=>'Author',
			    		'icon'=>'fa fa-user',
			    		'value'=>'author',
			    		'default'=>'on'
			    	),
			    	array( 
			    		'label'=>'Date',
			    		'icon'=>'fa fa-calendar-o',
			    		'value'=>'time',
			    		'default'=>'on'
			    	),
			    	array( 
			    		'label'=>'Category',
			    		'icon'=>'fa fa-tags',
			    		'value'=>'category',
			    		'default'=>'on'
			    	),
			    	array( 
			    		'label'=>'Comments',
			    		'icon'=>'fa fa-comment-o',
			    		'value'=>'comment',
			    		'default'=>'on'
			    	),
			    	array( 
			    		'label'=>'Likes',
			    		'icon'=>'fa fa-heart-o',
			    		'value'=>'like',
			    		'default'=>'on'
			    	),
			    	array( 
			    		'label'=>'Views',
			    		'icon'=>'fa fa-eye',
			    		'value'=>'views',
			    		'default'=>'on'
			    	),
//			    	array( 
//			    		'label'=>'Social Share',
//			    		'icon'=>'fa fa-share-alt',
//			    		'value'=>'share',
//			    		'default'=>'on'
//			    	),
			    	array( 
			    		'label'=>'Rating',
			    		'icon'=>'fa fa-star-o',
			    		'value'=>'rating',
			    		'default'=>'on'
			    	),
			    
			    ),
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Date Format',
			    'id' => 'c5_date_format',
			    'type' => 'select',
			    'desc' => 'Set The Date format "Normal date: 12th January, 2013" or "Ago date: 2 days ago"',
			    'choices' => array(
			        array(
			            'label' => 'Date & Time',
			            'value' => 'date_time'
			        ),
			        array(
			            'label' => 'Only Date',
			            'value' => 'date'
			        ),
			        array(
			            'label' => 'Only Time',
			            'value' => 'time'
			        ),
			        array(
			            'label' => 'Ago Format',
			            'value' => 'ago'
			        ),
			        array(
			            'label' => 'Date then Ago Format',
			            'value' => 'date_ago'
			        ),
			    ),
			    'std' => 'date',
			),
			
			 
		);
	}
	
	function admin_footer_js() {
		?>
		<script  type="text/javascript" id="c5_posts_apperance">
			jQuery(document).ready(function($) {
			   C5AB_POSTS_UI = {
			       init: function() {
			           $(document).on('click', '.c5-setting-wrap-render_type .option-tree-ui-radio-image', function(e) {
			               var render_type = $(this).parent().find('.option-tree-ui-radio ').val();
			               var parent_obj = $(this).closest('form');
			   
			               if (render_type == 'blog-1') {
			                   var value = 'author_on,time_on,comment_on,category_on,like_on,views_on,rating_on';
			   
			                    C5AB_POSTS_UI.set_order(value, parent_obj);
			                    C5AB_POSTS_UI.set_article_per_page(10,parent_obj );
			               } else if (render_type == 'blog-2') {
			                   var value = 'author_off,time_on,comment_on,category_off,like_on,views_on,rating_off';
			   
			                    C5AB_POSTS_UI.set_order(value, parent_obj);
			                    C5AB_POSTS_UI.set_article_per_page(10,parent_obj );
			               } else if (render_type == 'grid-1') {
			                   var value = 'author_off,time_off,category_on,comment_on,like_on,views_off,rating_off';
			   
			                    C5AB_POSTS_UI.set_order(value, parent_obj);
			                    C5AB_POSTS_UI.set_article_per_page(9,parent_obj );
			               } else if (render_type == 'grid-2') {
			                   var value = 'author_on,time_off,category_off,comment_on,like_on,views_off,rating_off';
			   
			                    C5AB_POSTS_UI.set_order(value, parent_obj);
			                    C5AB_POSTS_UI.set_article_per_page(9,parent_obj );
			   
			               } else if (render_type == 'grid-3') {
			                   var value = 'author_off,time_on,category_off,comment_on,like_on,views_off,rating_off';
			   
			                    C5AB_POSTS_UI.set_order(value, parent_obj);
			                    C5AB_POSTS_UI.set_article_per_page(9,parent_obj );
			               } else if (render_type == 'slider') {
			                   var value = 'time_on,author_on,category_off,comment_on,like_on,views_on,rating_on';
			   
			                    C5AB_POSTS_UI.set_order(value, parent_obj);
			                    C5AB_POSTS_UI.set_article_per_page(5,parent_obj );
			               } else if (render_type == 'blog-thumb') {
			                   var value = 'time_off,author_off,category_on,comment_off,like_on,views_off,rating_off';
			   
			                    C5AB_POSTS_UI.set_order(value, parent_obj);
			                    C5AB_POSTS_UI.set_article_per_page(4,parent_obj );
			               }
			   
			   
			           });
			   
			   
			       },
			       set_order: function(order, parent_obj) {
			           var order_obj = parent_obj.find('.c5-setting-wrap-meta_data');
			   
			           order_obj.find('.c5-save-meta-data-value').val(order);
			           var html = '';
			           var myArray = order.split(',');
			   
			           // display the result in myDiv
			           for (var i = 0; i < myArray.length; i++) {
			               var data = myArray[i].split('_');
			   
			               var temp = order_obj.find('li.ui-state-default[data-info="' + data[0] + '"]');
			               if (temp.hasClass('c5-current-status-on') && data[1] == 'off') {
			                   temp.removeClass('c5-current-status-on');
			                   temp.find('.c5-change-status').removeClass('fa-eye');
			   
			                   temp.addClass('c5-current-status-off');
			                   temp.find('.c5-change-status').addClass('fa-eye-slash');
			   
			                   temp.attr('data-status', 'off');
			               } else if (temp.hasClass('c5-current-status-off') && data[1] == 'on') {
			                   temp.removeClass('c5-current-status-off');
			                   temp.find('.c5-change-status').removeClass('fa-eye-slash');
			   
			                   temp.addClass('c5-current-status-on');
			                   temp.find('.c5-change-status').addClass('fa-eye');
			   
			                   temp.attr('data-status', 'on');
			               }
			               html += temp.clone().wrap('<div>').parent().html(); ;
			           }
			           order_obj.find('ul.c5-meta-data-values').html(html);
			   
			       },
			       set_article_per_page: function(number ,parent_obj ) {
			   			var number_obj = parent_obj.find('.c5-setting-wrap-posts_per_page');
			   			
			   			number_obj.find('.ot-numeric-slider-hidden-input').val(number);
			   			number_obj.find('.ot-numeric-slider-helper-input').val(number);
			   			
			   			var num = number*100/50;
			   			var percentage = num.toString() + '%';
			   			number_obj.find('.ui-slider-handle').css('left',percentage);
			   			
			   
			       }
			   };
			   			
			    C5AB_POSTS_UI.init();
			    C5AB_POSTS_SELECT_JS.init();

			});

		</script>
		<?php
	}
	
	function css() {
	?>
	<style>
		
		
	</style>
	<?php
	}

}




 ?>