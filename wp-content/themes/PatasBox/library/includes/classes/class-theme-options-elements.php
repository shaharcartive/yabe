<?php

class C5_theme_option_elements extends C5_theme_option_base{

    
    function __construct() {
        
    }
	
    
    function add_options($options) {
    	$this->_options = array_merge($this->_options, $options);
    }

    
	
    function get_logo_options($section = '') {
        $options = array(
            array(
                'label' => 'Website Logo',
                'id' => 'logo',
                'type' => 'upload',
                'desc' => 'Upload the main logo for your website, Upload as the logo as big as you can, you choose its size below',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Logo Height',
                'id' => 'logo_height',
                'type' => 'numeric-slider',
                'desc' => 'Slide to select your Logo Height in <strong>pixels</strong>. "We will calculate the width automaticly based on the height"',
                'std' => '30',
                'min_max_step' => '10,300,1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Main Logo Top Margin',
                'id' => 'logo_margin',
                'type' => 'numeric-slider',
                'desc' => 'Top Margin for the logo for your website, Default:7px.',
                'std' => '12',
                'min_max_step' => '0,300,1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'favicon',
                'id' => 'favicon',
                'type' => 'upload',
                'desc' => 'Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.',
                'std' => '',
                'section' => $section
            ),
        );

        return $options;
    }
	function get_shop_skin($section = '') {
		if(!class_exists( 'WooCommerce' )){
			return array();
		}
		
		
		$return = array(
		    'label' => 'Choose The default Skin for Woocommerce Products',
		    'id' => 'skin_default_shop',
		    'type' => 'custom-post-type-select',
		    'desc' => 'Choose The default Skin for Woocommerce Products.',
		    'std' => '',
		    'rows' => '',
		    'post_type' => 'skin',
		    'taxonomy' => '',
		    'class' => '',
		    'section' => $section
		);
		return $return;
	}
    function get_skins_options($section = '') {
        $options = array(
            $this->get_skin_array('Website', 'skin_default', $section),
            $this->get_skin_array('Pages', 'skin_default_page', $section),
            $this->get_shop_skin($section),
            $this->get_skin_array('Category', 'skin_default_category', $section),
            $this->get_skin_array('Tags', 'skin_default_tag', $section),
            $this->get_skin_array('Search Page', 'skin_default_search', $section),
            $this->get_skin_array('Archive Page "Year, Month"', 'skin_default_archive', $section),
            $this->get_skin_array('404 Page', 'skin_default_404', $section),
        );

        return $options;
    }

    function get_templates_options($section = '') {
        $options = array(
            $this->get_template_array('Website', 'default_template', $section),
            $this->get_template_array('Category Page', 'cat_template', $section),
            $this->get_template_array('Tag Page', 'tag_template', $section),
            $this->get_template_array('Author Page', 'author_template', $section),
            $this->get_template_array('Search Page', 'search_template', $section),
            $this->get_template_array('Archive Page "Year, Month"', 'archive_template', $section),
            $this->get_template_array('404 Page', '404_template', $section),
        );

        return $options;
    }

    function get_default_options($section = '') {
        $options = array(
			array(
			    'label' => 'Default Cover Photo',
			    'id' => 'default_cover',
			    'type' => 'upload',
			    'desc' => 'Default Cover Photo.',
			    'std' => '',
			    'section' => $section
			),
			array(
			    'label' => 'Preloading Animation',
			    'id' => 'preload',
			    'type' => 'on_off',
			    'desc' => 'Choose ON to enable the preloading circle in your website.',
			    'std' => 'on',
			    'section' => $section
			),
			array(
			    'label' => 'Preview Mode',
			    'id' => 'preview',
			    'type' => 'on_off',
			    'desc' => 'Choose ON to enable Preview Mode to test some colors changes in your website.',
			    'std' => 'on',
			    'section' => $section
			),
			array(
			    'label' => 'Enable Category Styling',
			    'id' => 'category_styling',
			    'type' => 'on_off',
			    'desc' => 'Choose ON to enable Category Styling, you can disable it if you have very large number of posts.',
			    'std' => 'on',
			    'section' => $section
			),
            array(
                'label' => 'Google Analytics Code',
                'id' => 'google_analytics',
                'type' => 'textarea-simple',
                'desc' => 'Paste your Google Analytics (or other) tracking code here. This will be added into your theme.',
                'std' => '',
                'rows' => '10',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Custom CSS Code',
                'id' => 'custom_css',
                'type' => 'css',
                'desc' => 'Paste your custom css code.',
                'std' => '',
                'rows' => '10',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Custom Javascript Code',
                'id' => 'custom_js',
                'type' => 'textarea-simple',
                'desc' => 'Paste your custom Javascript code.',
                'std' => '',
                'rows' => '10',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_header_options($section = '') {
        $options = array( );
            
         $options [] =array(
                'label' => 'Choose Main Menu',
                'id' => 'header_menu',
                'type' => 'select',
                'desc' => 'Choose The Main Menu.',
                'choices' => $this->get_current_menus(),
                'std' => 'main-nav',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            );
         
         $options [] = array(
             'label' => 'Header Ad Size',
             'id' => 'main_ad',
             'type' => 'select',
             'desc' => 'Choose Header Ad Options.',
             'std' => '728x90',
             'choices' => array(
             	array(
             		'label'=>'728x90',
             		'value'=> '728x90'
             	),
             	array(
         			'label'=>'300x250',
         			'value'=> '300x250'
             	),
             	array(
         			'label'=>'Both Ads on Header',
         			'value'=> 'both'
         		),
         		array(
     				'label'=>'No Ads on Header',
     				'value'=> 'none'
     			),
             ),
             'rows' => '',
             'post_type' => '',
             'taxonomy' => '',
             'class' => '',
             'section' => $section
         );
         
         $options [] = array(
             'label' => 'Header Ad 728x90 Size',
             'id' => 'main_ad_content_728x90',
             'type' => 'textarea-simple',
             'desc' => 'Ad 728x90 content.',
             'std' => '',
             'rows' => '',
             'post_type' => '',
             'taxonomy' => '',
             'class' => '',
             'section' => $section
         );
         $options [] = array(
             'label' => 'Header Ad 300x250 Size',
             'id' => 'main_ad_content_300x250',
             'type' => 'textarea-simple',
             'desc' => 'Ad 300x250 content.',
             'std' => '',
             'rows' => '',
             'post_type' => '',
             'taxonomy' => '',
             'class' => '',
             'section' => $section
         );
         
         
         $options [] = array(
             'label' => 'Enable Floating Bar',
             'id' => 'floating_enable',
             'type' => 'on_off',
             'desc' => 'Choose to Show Top Bar or not.',
             'std' => 'on',
             'rows' => '',
             'post_type' => '',
             'taxonomy' => '',
             'class' => '',
             'section' => $section
         );
            
                     

        return $options;
    }
    
    
    
    
    function get_footer_options($section = '') {
            $options = array(
                
                array(
                	'label' => 'Enable Footer',
                	'id' => 'footer_enable',
                	'type' => 'on_off',
                	'desc' => '',
                	'std' => 'on',
                	'rows' => '',
                	'taxonomy' => '',
                	'class' => '',
                	'section' => $section
                ),
                array(
                	'label' => 'Footer Background',
                	'id' => 'footer_background',
                	'type' => 'colorpicker',
                	'desc' => 'Default #272727',
                	'std' => '#272727',
                	'rows' => '',
                	'taxonomy' => '',
                	'class' => '',
                	'section' => $section
                ),
                array(
                	'label' => 'Enable Copyrights Footer',
                	'id' => 'footer_copyrights_enable',
                	'type' => 'on_off',
                	'desc' => '',
                	'std' => 'on',
                	'rows' => '',
                	'taxonomy' => '',
                	'class' => '',
                	'section' => $section
                ),
                array(
                	'label' => 'Footer Copyrights Background',
                	'id' => 'footer_copyrights_background',
                	'type' => 'colorpicker',
                	'desc' => 'Default #1f1f1f',
                	'std' => '#1f1f1f',
                	'rows' => '',
                	'taxonomy' => '',
                	'class' => '',
                	'section' => $section
                ),
                //// social icons
                array(
                    'label' => 'Social Top Icons',
                    'id' => 'social_icons',
                    'type' => 'list-item',
                    'desc' => '',
                    'settings' => array(
                        array(
                            'label' => 'Link',
                            'id' => 'link',
                            'type' => 'text',
                            'desc' => 'Your Social Link',
                            'choices' => '',
                            'std' => '',
                            'rows' => '',
                            'post_type' => '',
                            'taxonomy' => '',
                            'class' => ''
                        ),
                        $this->get_icons_options('fa fa-facebook')
                    ),
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => '',
                    'section' => $section
                ),
                array(
                	'label' => 'Footer Copyright',
                	'id' => 'footer_copyrights',
                	'type' => 'textarea',
                	'desc' => '',
                	'std' => 'Copyright ©2014. Designed by <a href="http://c125.co/1f6m4Se" target="_blank">Code125</a>',
                	'rows' => '',
                	'taxonomy' => '',
                	'class' => '',
                	'section' => $section
                )
                
            );
            
            if(C5_simple_option){
            	$page_templates = $this->get_templates_list();
            	
            	$options[] = array(
                	'label' => 'Footer template',
                	'id' => 'footer_template',
                	'type' => 'select',
                	'desc' => 'Choose The Footer template from the current page templates',
                	'choices' => $page_templates,
                	'std' => 'footer-1',
                	'rows' => '',
                	'taxonomy' => '',
                	'class' => '',
                	'section' => $section
            	);
            }
    
            return $options;
        }


	function get_color_scheme_options($section = '') {
	        $options = array(
	            array(
	                'label' => 'Select Theme Color Scheme ',
	                'id' => 'color_scheme',
	                'type' => 'select',
	                'desc' => 'Choose Theme Color Scheme,  Light/Dark.',
	                'std' => 'light',
	                'choices'=>array(
	                	array(
	                		'label'=>'Light',
	                		'value'=>'light'
	                	),
	                	array(
	                		'label'=>'Dark',
	                		'value'=>'dark'
	                	),
	                ),
	                'rows' => '',
	                'post_type' => '',
	                'taxonomy' => '',
	                'class' => '',
	                'section' => $section
	            ),
	        );
	
	        return $options;
	    }

    function get_colors_options($section = '') {
        $options = array(
            array(
                'label' => 'Primary Color',
                'id' => 'primary_color',
                'type' => 'colorpicker',
                'desc' => 'Pick a the main color for the theme (default: #c41411 ).',
                'std' => '#c41411',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_fonts_options($section = '') {
        $fonts_obj = new C5_font();
        $google_fonts = $fonts_obj->get_select_array();


        $options = array(
	        array(
		        'label' => 'Primary Heading Font',
		        'id' => 'heading_font',
		        'type' => 'select',
		        'desc' => 'Select your Header font from the available fonts, Fonts are provided via Google Fonts API',
		        'choices' => $google_fonts,
		        'std' => 'Droid Serif#latin#googlefont',
		        'rows' => '',
		        'post_type' => '',
		        'taxonomy' => '',
		        'class' => '',
		        'section' => $section
	        ),
	        array(
		        'label' => 'Body Font',
		        'id' => 'body_font',
		        'type' => 'select',
		        'desc' => 'Select your body "Default" font from the available fonts, Fonts are provided via Google Fonts API',
		        'choices' => $google_fonts,
		        'std' => 'Droid Serif#latin#googlefont',
		        'rows' => '',
		        'post_type' => '',
		        'taxonomy' => '',
		        'class' => '',
		        'section' => $section
	        ),
	        $this->get_font_size_array('Body', 'body_fs', '15', $section ),
	        $this->get_font_size_array('Menu', 'menu_fs', '12', $section ),
	        $this->get_font_size_array('Title', 'title_fs', '16', $section ),
	        
	        $this->get_font_size_array('Article Title', 'article_title_fs', '50', $section ),
	        $this->get_font_size_array('Article Subtitle', 'article_subtitle_fs', '24', $section ),
	        $this->get_font_size_array('Article Meta Data', 'article_meta_fs', '13', $section ),
	        $this->get_font_size_array('Article Text size', 'article_text_fs', '16', $section ),
	    );

        return $options;
    }

    function get_layout_options($section = '') {


        global $wp_registered_sidebars;

        $sidebars = array();
        foreach ($wp_registered_sidebars as $sidebar_new) {
            $sidebars[] = array(
                'label' => $sidebar_new['name'],
                'value' => $sidebar_new['id']
            );
        }

        $rtl_array = array(
            'ltr',
            'rtl'
        );
        $rtl_options = array(
        );

        foreach ($rtl_array as $value) {
            $rtl_options[] = array(
                'src' => C5_skins_URL . 'images/rtl/' . $value . '.png',
                'label' => '',
                'value' => $value
            );
        }
		
		
        
		
        $options = array(
            array(
                'label' => 'RTL',
                'id' => 'rtl',
                'type' => 'radio-image',
                'desc' => 'Choose Website direction.',
                'choices' => $rtl_options,
                'std' => 'ltr',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-layout-control',
                'section' => $section
            ),
            
            array(
                'label' => 'Page Layout',
                'id' => 'page_width',
                'type' => 'select',
                'desc' => 'Choose Page Layout',
                'choices' => array(
                	array(
                		'label'=>'Full Width',
                		'value'=>'full',
                	),
                	array(
                		'label'=>'Hidden Left Sidebar',
                		'value'=>'left_hidden',
                	),
                	array(
                		'label'=>'Hidden Right Sidebar',
                		'value'=>'right_hidden',
                	),
                	array(
                		'label'=>'Left Sidebar',
                		'value'=>'left',
                	),
                	array(
                		'label'=>'Right Sidebar',
                		'value'=>'right',
                	),
                ),
                'std' => 'right',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-layout-control',
                'section' => $section
            ),
            array(
                'label' => 'Sidebar',
                'id' => 'big_sidebar',
                'type' => 'select',
                'desc' => 'Select the Big Page sidebar.',
                'choices' => $sidebars,
                'std' => 'sidebar',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-layout-control',
                'section' => $section
            ),

        );

        return $options;
    }
    
    function get_default_blog($section = '') {
    	$tabs = array(
    	    'blog-1',
    	    'blog-2',
    	    'grid-1',
    	    'grid-2',
    	    'grid-3',
    	);
    	$tabs_array = array();
    	foreach ($tabs as $value) {
    	    $tabs_array[] = array(
    	        'src' => C5_URL . 'library/includes/images/blog/' . $value . '.jpg',
    	        'label' => '',
    	        'value' => $value,
    	        'class' => 'c5_posts_img'
    	    );
    	}
    	$options = array(
    		array(
    		    'label' => 'Default Blog Layout',
    		    'id' => 'default_blog_layout',
    		    'type' => 'radio-image',
    		    'desc' => '',
    		    'choices' => $tabs_array,
    		    'std' => 'blog-1',
    		    'rows' => '',
    		    'post_type' => '',
    		    'taxonomy' => '',
    		    'section' => $section
    		)
    	);
    	return $options;
    }

    function get_sidebars_options($section = '') {


        $options = array(
            array(
                'label' => 'Sidebars',
                'id' => 'sidebars',
                'type' => 'list-item',
                'desc' => 'Add Unlimited Sidebars to your website.',
                'settings' => array(
                    array(
                        'label' => 'Slug',
                        'id' => 'slug',
                        'type' => 'text',
                        'desc' => 'Sidebar Slug "All lowercase and must be unique".',
                        'std' => '',
                    ),
                    array(
                        'label' => 'Description',
                        'id' => 'description',
                        'type' => 'textarea-simple',
                        'desc' => 'Sidebar Description.',
                        'std' => '',
                        'rows' => '5',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => ''
                    )
                ),
                'std' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_menu_locations_options($section = '') {


        $options = array(
            array(
                'label' => 'Menu Locations',
                'id' => 'menus',
                'type' => 'list-item',
                'desc' => 'Add Unlimited Menu Locations to your website.',
                'settings' => array(
                    array(
                        'label' => 'Location',
                        'id' => 'location',
                        'type' => 'text',
                        'desc' => 'Menu Location You will get the menu by that name. "No spaces"',
                        'std' => '',
                    )
                ),
                'std' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_custom_fonts_options($section = '') {

        $options = array(
            array(
                'label' => 'Custom Fonts',
                'id' => 'custom_fonts',
                'type' => 'list-item',
                'desc' => 'Add New Custom font.',
                'settings' => array(
                    array(
                        'label' => 'folder name',
                        'id' => 'folder',
                        'type' => 'text',
                        'desc' => 'type the folder name you added to /library/fonts/',
                        'std' => '',
                    ),
                    array(
                        'label' => '.css file name',
                        'id' => 'css',
                        'type' => 'text',
                        'desc' => 'add .css file name for the font face"type it without the extension"',
                        'std' => '',
                    )
                ),
                'std' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_search_options($section = '') {
        $args = array('show_ui' => true);
        $types_array = array();
        $output = 'objects'; // names or objects

        $post_types = get_post_types($args, $output);
        //print_r($post_types);
        $exlude_array = array(
            'attachment',
            'skin',
            'header',
            'footer'
        );
        foreach ($post_types as $key => $post_type) {

            if (!in_array($key, $exlude_array)) {
                $types_array[] = array(
                    'label' => $post_type->label,
                    'value' => $key
                );
            }
        }
        $options = array(
            array(
                'label' => 'Enable Search bar on top',
                'id' => 'search_on',
                'type' => 'on_off',
                'desc' => 'Choose ON to enable Search on the top menu bar.',
                'std' => 'on',
                'section' => $section
            ),
            array(
                'label' => 'Default Search Post Type',
                'id' => 'search_post',
                'type' => 'select',
                'desc' => 'Choose the post type you want to make the search based on.',
                'choices' => $types_array,
                'std' => 'post',
                'section' => $section
            ),
            array(
                'label' => 'Cover Photo',
                'id' => 'search_cover',
                'type' => 'upload',
                'desc' => 'Upload Cover Photo.',
                'std' => '',
                'section' => $section
            ),
        );

        return $options;
    }
    
    function get_icons_options($default='fa fa-none') {
    	$obj = new C5AB_ICONS();
    	$icons = $obj->get_icons_as_images();
    	
    	$options = array(
    		    'label' => 'Icon',
    		    'id' => 'icon',
    		    'type' => 'radio-text',
    		    'desc' => '',
    		    'std' => $default,
    		    'choices' => $icons,
    		    'rows' => '',
    		    'post_type' => '',
    		    'taxonomy' => '',
    		    'class' => ''
    		);
    	return $options;
    }

    function get_social_options($section = '') {

        

        $options = array(
            array(
                'label' => 'Facebook App ID',
                'id' => 'facebook_ID',
                'type' => 'text',
                'desc' => 'Add Facebook App ID.',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => 'Twitter Consumer Key',
                'id' => 'consumerkey',
                'type' => 'text',
                'desc' => 'Add your twitter Consumer Key <a href="http://themepacific.com/how-to-generate-api-key-consumer-token-access-key-for-twitter-oauth/994/" >Click Here to learn about these keys</a>.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Twitter Consumer Secret',
                'id' => 'consumersecret',
                'type' => 'text',
                'desc' => 'Add your twitter Consumer Secret.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
             array(
                'label' => 'Twitter Access Token',
                'id' => 'accesstoken',
                'type' => 'text',
                'desc' => 'Add your twitter Access Token.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
             array(
                'label' => 'Twitter Access Token Secret',
                'id' => 'accesstokensecret',
                'type' => 'text',
                'desc' => 'Add your twitter Access Token Secret.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            
        );

        return $options;
    }

    function get_articles_options($section = '') {
        
		global $wp_registered_sidebars;
		
        $sidebars = array();
        foreach ($wp_registered_sidebars as $sidebar_new) {
            $sidebars[] = array(
                'label' => $sidebar_new['name'],
                'value' => $sidebar_new['id']
            );
        }
        
        $options = array(
            array(
                'label' => 'Article Layout',
                'id' => 'article_width',
                'type' => 'select',
                'desc' => 'Choose Article Layout',
                'choices' => array(
                	array(
                		'label'=>'Full Width',
                		'value'=>'full',
                	),
                	array(
                		'label'=>'Hidden Left Sidebar',
                		'value'=>'left_hidden',
                	),
                	array(
                		'label'=>'Hidden Right Sidebar',
                		'value'=>'right_hidden',
                	),
                	array(
                		'label'=>'Left Sidebar',
                		'value'=>'left',
                	),
                	array(
                		'label'=>'Right Sidebar',
                		'value'=>'right',
                	),
                ),
                'std' => 'right',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-layout-control',
                'section' => $section
            ),
            array(
                'label' => 'Articles Sidebar',
                'id' => 'article_sidebar',
                'type' => 'select',
                'desc' => 'Select the Articles sidebar.',
                'choices' => $sidebars,
                'std' => 'article',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-layout-control',
                'section' => $section
            ),
            array(
                'label' => 'Reorder and Enable/Disable Meta Data',
                'id' => 'article_meta_data',
                'type' => 'meta-data',
                'desc' => 'Reorder and Enable/Disable the Meta data for you blog posts',
                'std' => 'author_on,time_on,comment_on,like_on,views_on,share_on',
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
                
                ),
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
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
                'std' => 'date_ago',
                'section' => $section
            ),
            array(
                'label' => 'Reorder and Enable/Disable Social Share Buttons',
                'id' => 'article_social_media',
                'type' => 'meta-data',
                'desc' => 'Reorder and Enable/Disable Social Share Buttons for your blog posts, if you widh to remove them all, just turn all the eyes off',
                'std' => 'facebook_on,twitter_on,googleplus_on,linkedin_on',
                'choices' => array(
                	array( 
                		'label'=>'Facebook',
                		'icon'=>'fa fa-facebook',
                		'value'=>'facebook',
                		'default'=>'on'
                	),
                	array( 
                		'label'=>'Twitter',
                		'icon'=>'fa fa-twitter',
                		'value'=>'twitter',
                		'default'=>'on'
                	),
                	array( 
                		'label'=>'Google Plus',
                		'icon'=>'fa fa-google-plus',
                		'value'=>'googleplus',
                		'default'=>'on'
                	),
                	array( 
                		'label'=>'Linkedin',
                		'icon'=>'fa fa-linkedin',
                		'value'=>'linkedin',
                		'default'=>'on'
                	),
                
                ),
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Before Article Section Content',
                'id' => 'article_before',
                'type' => 'textarea-simple',
                'desc' => 'Add a content to show before each article',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => 'After Article Section Content',
                'id' => 'article_after',
                'type' => 'textarea-simple',
                'desc' => 'Add a content to show after each article',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => 'Enable Facebook Comments',
                'id' => 'enable_facebook',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'section' => $section
            ),
            array(
                'label' => 'Enable WordPress Comments',
                'id' => 'enable_wp_comments',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'section' => $section
            ),
            array(
                'label' => 'Comments Section Order',
                'id' => 'comments_order',
                'type' => 'select',
                'desc' => 'Select the Comments Order in your article, Default: Facebook - WP Comments',
                'choices' => array(
                    array(
                        'label' => 'Facebook - WP Comments',
                        'value' => 'facebook_comments'
                    ),
                    array(
                        'label' => 'WP Comments - Facebook',
                        'value' => 'comments_facebook'
                    )
                ),
                'std' => 'facebook_comments',
                'section' => $section
            ),
            array(
                'label' => 'Facebook Color',
                'id' => 'facebook_color',
                'type' => 'select',
                'desc' => 'Select Facebook Color Mode. Default Light.',
                'choices' => array(
                    array(
                        'label' => 'Light',
                        'value' => 'light'
                    ),
                    array(
                        'label' => 'Dark',
                        'value' => 'dark'
                    )
                ),
                'std' => 'light',
                'section' => $section
            ),
        );
        
        
        if(!C5_simple_option){
        	$temp = array(
        		array(
        		    'label' => 'Article Skin',
        		    'id' => 'article_skin',
        		    'type' => 'custom-post-type-select',
        		    'desc' => 'Choose Default Posts Skin.',
        		    'post_type' => 'skin',
        		    'std' => '',
        		    'section' => $section
        		),
        	);
        	$options = array_merge($temp, $options );
        }
        return $options;
    }
    
	function get_styling_options() {
        $stylings_fields = array();
        
        if (!C5_simple_option) {
            $stylings_fields[] = array(
                'label' => 'Choose Custom Skin',
                'id' => 'skin_default',
                'type' => 'custom-post-type-select',
                'desc' => 'Choose Custom Skin, leave it for default skin.',
                'std' => '',
                'rows' => '',
                'post_type' => 'skin',
                'taxonomy' => '',
                'class' => ''
            );
        } 
    	$stylings_fields[] = array(
    	    'label' => 'Use Custom Color Settings',
    	    'id' => 'use_custom_colors',
    	    'type' => 'on_off',
    	    'desc' => 'Use Custom Color Settings.',
    	    'std' => 'off',
    	    'class' => ''
    	);
    	$stylings_fields[] = array(
    	    'label' => 'Use Custom Layout Settings',
    	    'id' => 'use_custom_layout',
    	    'type' => 'on_off',
    	    'desc' => 'Use Custom Layout Settings.',
    	    'std' => 'off',
    	    'class' => ''
    	);
        
        return $stylings_fields;
    }

    function get_skins_main_meta() {


        $options = array(
            array(
                'label' => 'Choose The default Header',
                'id' => 'header_default',
                'type' => 'custom-post-type-select',
                'desc' => 'Choose The  Header.',
                'std' => '',
                'rows' => '',
                'post_type' => 'header',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Choose The default Footer',
                'id' => 'footer_default',
                'type' => 'custom-post-type-select',
                'desc' => 'Choose The Footer.',
                'std' => '',
                'rows' => '',
                'post_type' => 'footer',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Custom CSS for this skin',
                'id' => 'custom_css',
                'type' => 'css',
                'desc' => 'Add Custom CSS for this skin.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
            array(
                'label' => 'Custom js for this skin',
                'id' => 'custom_js',
                'type' => 'textarea-simple',
                'desc' => 'Add Custom js for this skin.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            )
        );

        return $options;
    }

}

?>