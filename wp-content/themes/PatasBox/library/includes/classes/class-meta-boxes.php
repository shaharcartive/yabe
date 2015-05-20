<?php

class C5_meta_boxes extends C5_theme_option_elements {

    function __construct() {

        add_action('admin_init', array($this, 'meta_boxes'));
    }

    function meta_boxes() {



        $args = array('show_ui' => true);
		$post_obj = new C5_post();

        $post_types_no_page = array();
        $post_types = array();
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

        foreach ($post_types_all as $key => $post_type) {

            if (!in_array($key, $exlude_array_no_page)) {
                $post_types_no_page[] = $key;
                $post_types[] = $key;
            }
        }
        $post_types[] = 'page';



        

        $stylings = array(
            'id' => 'page_styling',
            'title' => 'Page Settings',
            'desc' => '',
            'pages' => array('page'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'label' => 'Alternative Title',
                    'id' => 'c5_title',
                    'type' => 'text',
                    'desc' => 'Add an alternative title to your page title',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => 'Page Subtitle',
                    'id' => 'c5_subtitle',
                    'type' => 'text',
                    'desc' => 'Article, Page Subtitle',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => 'Force Dark/Light Mode for this page',
                    'id' => 'c5_force',
                    'type' => 'select',
                    'desc' => 'Force Dark/Light Mode for this page',
                    'choices' => array(
                        array(
                            'label' => 'Automatic Checked',
                            'value' => ''
                        ),
                        array(
                            'label' => 'Dark',
                            'value' => 'dark'
                        ),
                        array(
                            'label' => 'Light',
                            'value' => 'light'
                        ),
                    ),
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => 'Enable Comments',
                    'id' => 'enable_comments',
                    'type' => 'on_off',
                    'desc' => 'Enable/Disable Comments for this Page',
                    'std' => 'off',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => 'Login Required',
                    'id' => 'login_required',
                    'type' => 'on_off',
                    'desc' => 'Make this page Login Required',
                    'std' => 'off',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
            )
        );
        
        $top_content = array(
            'id' => 'page_top_content',
            'title' => 'Page Top Content Settings',
            'desc' => '',
            'pages' => array('page'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'label' => 'Enable top Slider',
                    'id' => 'c5_top_slider',
                    'type' => 'on_off',
                    'desc' => 'Enable Top Slider',
                    'std' => 'off',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
    			    'label' => 'Choose Post Type/Category/Tag/Author',
    			    'id' => 'slider_post_type',
    			    'type' => 'post-select',
    			    'desc' => 'Add Different Parameters to show your posts, select by tag, category or author.',
    			    'std' => 'post',
    			    'rows' => '',
    			    'post_type' => '',
    			    'taxonomy' => '',
    			    'class' => ''
    			),
    			$post_obj->get_orderby_array('slider_orderby','date'),
    			$post_obj->get_posts_per_page_array('slider_posts_per_page', '5'),
    			array(
    			    'label' => 'Or Add Specific Articles',
    			    'id' => 'slider_posts',
    			    'type' => 'posts-search',
    			    'desc' => 'Add Specific Articles to this query "Any other query will be ignored".',
    			    'std' => '',
    			    'rows' => '',
    			    'post_type' => '',
    			    'taxonomy' => '',
    			    'class' => ''
    			),
                array(
                    'label' => 'Alternative Top Content',
                    'id' => 'c5_content',
                    'type' => 'textarea-simple',
                    'desc' => 'Add an alternative content to your top area, ex: slider shortcode or page builder template shortcode',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
            )
        );
        
        
        

		
        $stylings2 = array(
            'id' => 'meta_styling',
            'title' => 'Styling Settings',
            'desc' => '',
            'pages' => $post_types,
            'context' => 'normal',
            'priority' => 'high',
            'fields' =>  $this->get_styling_options()
        );
        
        $stylings_colors = array(
            'id' => 'meta_styling_color',
            'title' => 'Color Settings',
            'desc' => '',
            'pages' => $post_types,
            'context' => 'normal',
            'priority' => 'high',
            'fields' => $this->get_colors_options()
        );
        $stylings_layout = array(
            'id' => 'meta_styling_layout',
            'title' => 'Layout Settings',
            'desc' => '',
            'pages' => $post_types,
            'context' => 'normal',
            'priority' => 'high',
            'fields' => $this->get_layout_options()
        );


        if (isset($_GET['post_type'])) {
            $post_type = $_GET['post_type'];
        } else {
            if (isset($_GET['post'])) {
                $id = $_GET['post'];
                $post_type = get_post_type($id);
            } else {
                $post_type = 'post';
            }
        }
        if ($post_type != 'page') {
            $tax = c5_get_tax_from_post_type($post_type);
			
			
			
            $cats = array(
                'id' => 'category_styling',
                'title' => 'Category Settings',
                'desc' => '',
                'pages' => $post_types_no_page,
                'context' => 'normal',
                'priority' => 'high',
                'fields' => array(
                    array(
                        'label' => 'Choose Dominating Category',
                        'id' => 'category_follow',
                        'type' => 'taxonomy-select',
                        'desc' => 'Choose Dominating Category for this post, the Article will follow this category in its styling settings.',
                        'std' => '',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => $tax,
                        'class' => ''
                    )
                )
            );
            ot_register_meta_box($cats);
        }






		$subtitle = array(
		    'id' => 'meta_subtitle',
		    'title' => 'Article Subtitle',
		    'desc' => '',
		    'pages' => $post_types_no_page,
		    'context' => 'normal',
		    'priority' => 'high',
		    'fields' =>  array(
		    	array(
		    	    'label' => 'Subtitle',
		    	    'id' => 'c5_subtitle',
		    	    'type' => 'text',
		    	    'desc' => 'Article, Page Subtitle',
		    	    'std' => '',
		    	    'rows' => '',
		    	    'post_type' => '',
		    	    'taxonomy' => '',
		    	    'class' => ''
		    	),
		    	array(
		    	    'label' => 'Video / Audio / Facebook Status / Twitter Status url',
		    	    'id' => 'meta_attachment',
		    	    'type' => 'text',
		    	    'desc' => 'Video url, we support "Youtube, Vimeo and Dailymotion" or Audio url we support "Audio and Soundcloud"',
		    	    'std' => '',
		    	    'rows' => '',
		    	    'post_type' => '',
		    	    'taxonomy' => '',
		    	    'class' => ''
		    	)
		    	
		    )
		);
		


        $review = array(
            'id' => 'meta_review',
            'title' => 'Review Options',
            'desc' => '',
            'pages' => $post_types_no_page,
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
                            'std' => '100',
                            'min_max_step' => '0,100,1',
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
            )
            ,
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => ''
        );



        /**
         * Register our meta boxes using the 
         * ot_register_meta_box() function.
         */
         
        ot_register_meta_box($subtitle);
        ot_register_meta_box($stylings);
        ot_register_meta_box($top_content);
        ot_register_meta_box($stylings2);
        ot_register_meta_box($stylings_colors);
        ot_register_meta_box($stylings_layout);
    }

}
?>