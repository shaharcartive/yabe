<?php 

class C5_quick_setup extends C5_archive_settings {
	
	public $_sections =array();
	public $_options =array();
	
	function __construct() {
		
	}
	
	function hook() {
		
		add_action('admin_menu', array($this, 'hook_page'));
		add_action( 'admin_enqueue_scripts', array( $this , 'admin_enqueue_scripts') );
	}
	
	function hook_page() {
		
		if(isset($GLOBALS['c5-demo-account'])){
		    if( $GLOBALS['c5-demo-account']=='true'){
		    	add_dashboard_page('Quick Setup', 'Quick Setup', 'edit_pages', 'c5-quick-setup', array($this, 'quick_setup_page'));
		    }else {
		    	add_dashboard_page('Quick Setup', 'Quick Setup', 'manage_options', 'c5-quick-setup', array($this, 'quick_setup_page'));
		    }
		}else {
			/* add_dashboard_page('Quick Setup', 'Quick Setup', 'manage_options', 'c5-quick-setup', array($this, 'quick_setup_page')); */
		}
	}
	function admin_enqueue_scripts($hook) {
	    if( 'index.php' != $hook )
	        return;
		wp_enqueue_style( 'c5ab-flexslider', C5BP_extra_uri . 'css/flexslider.css');
		wp_enqueue_script( 'c5ab-flexslider', C5BP_extra_uri . 'js/jquery.flexslider-min.js', array(), '2.2', true );
	}
	
	function done_page() {
		$all_options = get_option( 'option_tree' );
		foreach ($this->_options as $option) {
			if( isset( $_POST[ $option['id'] ] )){
				if ($option['type'] == 'list-item' ) {
					$all_options[ $option['id'] ] = $_POST[ $option['id'] ][$option['id'] ];
				}elseif($option['type'] == 'textarea-simple'){
					$all_options[ $option['id'] ] =stripslashes(  $_POST[ $option['id'] ] );
				}else {
					$all_options[ $option['id'] ] = $_POST[ $option['id'] ];
				}
				
			}
		}
		
		
		update_option('c5_options_mode', 'simple');
		update_option( 'option_tree' , $all_options);
		
		?>
		<div class="wrap about-wrap">
			<h2>Quick Setup</h2>
			<div id="welcome-panel" class="c5-main-panel welcome-panel">
				<div class="quick-panel-flexslider c5-successfully">
					<div class="c5-quick-slide-wrap">
					<h2>Successfully Saved...</h2>
					<p class="about-description">Settings have been saved successfully, you might need to check the documentation and video tutorials for more about how to use the website.</p>
					</div>
					
					<div class="feature-section col two-col clearfix">
					
						<div class="col-1">
							<h4>Check Online Documentation</h4>
							<p>Check our online documentation for more updated on how to use your theme and make the best of it.</p>
							<a href="http://crystal.code-125.com/documentation/" class="button button-primary button-large">Check it here</a>
						</div>
						
						<div class="col-2 last-feature">
							<h4>Check Online Video Tutorials</h4>
							<p>Check our online video tutorials to make the best out of this product.</p>
							<a href="https://www.youtube.com/watch?v=MItqDK2RarM&list=PLoZkybG-SsuL9L2GycioDsLPddL7koUIk" class="button button-primary button-large">Check it here</a>
						</div>
						
					
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	
	function quick_setup_page() {
		$this->build_sections();
		$this->build_settings();
		
		if(isset($_POST['c5submit'])){
			$this->done_page();
			return;
		}
		
		?>
		<div class="wrap">
			<h2>Quick Setup</h2>
			<div id="welcome-panel" class="c5-main-panel welcome-panel">
				<form method="post" action="">
				<div class="quick-panel-flexslider">
				<ul class="slides">
				<?php 
				$counter = 1;
				$previous = '';
				foreach ($this->_sections as  $section) {
					echo '<li>';
					
					echo '<div class="c5-quick-slide-wrap">';
					echo '<div class="section-wrap">';
					echo '<h3>'.$section['title'].'</h3>';
					echo $section['desc'];
					echo '</div><div class="options-wrap">';
					foreach ($this->_options as $option) {
						if($option['section']==$section['id']){
							$value = ot_get_option($option['id']);
							if($option['type'] == 'textarea-simple'){
								$value = stripslashes (  $value );
							}
							$value_array = array($option['id'] =>  $value);
							$this->display_setting($option, $value_array ); 
						}
					}
					
					if($section['id'] == 'direction'){
						if(!isset($GLOBALS['c5-demo-account'])){
							echo '<button  type="submit" class="button button-primary button-hero right" name="c5submit"><span class="fa fa-save"></span> Save</button>';
						}
					}elseif ($section['id'] == 'welcome') {
						echo '<p class="button c5-next-page c5-prev-page button-primary button-hero right" data-slide="'.$counter.'">Start <span class="fa fa-chevron-right"></span></p>';
					}else {
						echo '<p class="button c5-next-page c5-prev-page button-primary button-hero right" data-slide="'.$counter.'">Next <span class="fa fa-chevron-right"></span></p>';
					}
					$prev_num = $counter-2;
					if($prev_num >= 0){
						echo '<p class="button c5-next-page button-primary button-hero left" data-slide="'.$prev_num.'"><span class="fa fa-chevron-left"></span> Back</p>';
						
					}
					echo '</div>';
					echo '</div>';
					
					
					
					$counter++;
					echo '</li>';
				}
				 ?>
				</ul>
				</div>
				
				</form>
				</div>
		</div>
		<?php
		
		
	
	}
	function build_page($stage = 0) {
		echo '';
	}
	
	
	function build_sections () {
		$this->_sections = array(
		    array(
		        'title' => 'Welcome',
		        'id' => 'welcome',
		        'desc'=> '<p class="about-description">Thank You for Purcharsing our products, we created this quick setup wizard to help you to set most of the common tasks during your theme installtion, to minimize the time you look in the docs and video tutorials on how to setup your website.</p><p class="about-description">We hope that we will give you a real assistant here.</p>'
		    ),
		    array(
		        'title' => 'Add Your Logo',
		        'id' => 'logo',
		        'desc'=> '<p class="about-description">Upload Your Website logo, make sure that you upload the biggest size of the logo in jpeg/png format and set the height and we will handle it for you.</p>'
		    ),
		    array(
		        'title' => 'Set Your Color',
		        'id' => 'color',
		        'desc'=> '<p class="about-description">Choose the main color for your website, choose the best color that represent your website and brand.</p>'
		    ),
		    array(
		        'title' => 'Set Default Background',
		        'id' => 'background',
		        'desc'=> '<p class="about-description">Upload the default background image, it will be used in case there is no featured in the article.</p>'
		    ),
		    array(
		        'title' => 'Set Your Fonts',
		        'id' => 'fonts',
		        'desc'=> '<p class="about-description">Choose the fonts that will apply to your website, you can choose 2 different fonts to be applied on your headings and your content</p>'
		    ),
		    
		    array(
		        'title' => 'Set Default Layout',
		        'id' => 'layout',
		        'desc'=> '<p class="about-description">Choose the default Layout for your website page, you can assign custom page layouts in each page/article seperatily, but here you will set the default for your website.</p>'
		    ),
		    array(
		        'title' => 'Set Default Blog Layout',
		        'id' => 'blog',
		        'desc'=> '<p class="about-description">Choose the default blog type for your website, this will affect homepage, category, tag, author and search pages.</p>'
		    ),
		    array(
		        'title' => 'Include Search Button',
		        'id' => 'search',
		        'desc'=> '<p class="about-description">Enable/Disable the search button in the top menu</p>'
		    ),
		    array(
		        'title' => 'Set Social Setting',
		        'id' => 'social',
		        'desc'=> '<p class="about-description">Add Your facebook App ID and Twitter authentication settings, this will help you to have your social data shows smoothly.</p>'
		    ),
		    array(
		        'title' => 'Set Website Direction',
		        'id' => 'direction',
		        'desc'=> '<p class="about-description">Do you have your website in Right to Left Language like "Arabic, Persian, Hebrew" you need to make the choice of Yes.</p>'
		    ),
		    
		    
		);
		   
		  
	}
    function build_settings() {
		$fonts_obj = new C5_font();
		$google_fonts = $fonts_obj->get_select_array();
		
		global $wp_registered_sidebars;
		
        $sidebars = array();
        foreach ($wp_registered_sidebars as $sidebar_new) {
            $sidebars[] = array(
                'label' => $sidebar_new['name'],
                'value' => $sidebar_new['id']
            );
        }

        $layout_array = array(
            '1170-B-C',
            '1170-C-B',
            '1170-C',
        );
        $layout_options = array(
        );

        foreach ($layout_array as $value) {
            $layout_options[] = array(
                'src' => C5_skins_URL . 'images/layout/' . $value . '.png',
                'label' => '',
                'value' => $value
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
        
        $obj = new C5AB_ICONS();
        $icons = $obj->get_icons_as_images();
		
	   $this->_options = array(
	   		array(
	   		  'id'          => 'welcome_text',
	   		  'label'       => 'Build your website in few steps!',
	   		  'desc'        => '<p class="about-description">Most of our customers want to build their website in very easy way and don\'t want to read or watch a lot of documentation/video tutorials and thus we created this question based wizard to make it super easy to you.</p>',
	   		  'std'         => '',
	   		  'type'        => 'textblock',
	   		  'section'     => 'welcome',
	   		  'class' => '',
	   		),
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
	   		    'section' => 'logo'
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
	   		    'section' => 'logo'
	   		),
	   		array(
	   		    'label' => 'What is your website color?',
	   		    'id' => 'primary_color',
	   		    'type' => 'colorpicker',
	   		    'desc' => 'Pick a the main color for the theme (default: #c41411 ).',
	   		    'std' => '#c41411',
	   		    'rows' => '',
	   		    'post_type' => '',
	   		    'taxonomy' => '',
	   		    'class' => '',
	   		    'section' => 'color'
	   		),
	   		array(
	   		    'label' => 'Default Cover Photo',
	   		    'id' => 'default_cover',
	   		    'type' => 'upload',
	   		    'desc' => 'Default Cover Photo for your website.',
	   		    'std' => array(),
	   		    'rows' => '',
	   		    'post_type' => '',
	   		    'taxonomy' => '',
	   		    'class' => '',
	   		    'section' =>  'background'
	   		),
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
	   		    'section' => 'fonts'
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
	   		    'section' => 'fonts'
	   		),
	   		array(
	   		    'label' => 'Enable Search bar on top',
	   		    'id' => 'search_on',
	   		    'type' => 'on_off',
	   		    'desc' => 'Choose ON to enable Search on the top menu bar.',
	   		    'std' => 'on',
	   		    'class' => '',
	   		    'section' => 'search'
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
                'section' => 'layout'
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
                'section' => 'layout'
            ),
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
                'class'=>'c5-blog-layout',
                'section' => 'blog'
            ),
	   		array(
	   		    'label' => 'Is Your website in Arabic "Right to Left Direction"',
	   		    'id' => 'rtl',
	   		    'type' => 'select',
	   		    'desc' => '',
	   		    'choices' => array(
	   		    	array(
	   		    		'label'=>'Yes',
	   		    		'value'=>'rtl',
	   		    	),
	   		    	array(
	   		    		'label'=>'No',
	   		    		'value'=>'ltr',
	   		    	),
	   		    ),
	   		    'std' => 'ltr',
	   		    'rows' => '',
	   		    'post_type' => '',
	   		    'taxonomy' => '',
	   		    'class' => 'c5-layout-control',
	   		    'section' =>'direction'
	   		),
	   		
	   		array(
	   		    'label' => 'Facebook App ID',
	   		    'id' => 'facebook_ID',
	   		    'type' => 'text',
	   		    'desc' => 'Add Facebook App ID.',
	   		    'std' => '',
	   		    'class' => '',
	   		    'section' => 'social'
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
	   		    'section' => 'social'
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
	   		    'section' => 'social'
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
	   		    'section' => 'social'
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
	   		    'section' => 'social'
	   		),
	   			   		
	   		
	   );
       
       

    }
    
    function get_content($id , $label , $std,$section = '') {
    	return array(
    	    'label' => $label,
    	    'id' => $id,
    	    'type' => 'textarea-simple',
    	    'desc' => '',
    	    'std' => $std,
    	    'rows' => '',
    	    'post_type' => '',
    	    'taxonomy' => '',
    	    'class' => '',
    	    'section' => $section
    	);
    }
	
	
}
$quick_setup = new C5_quick_setup();
$quick_setup->hook();
?>