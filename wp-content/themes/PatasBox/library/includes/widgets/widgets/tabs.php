<?php

class C5AB_tabs extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();
    public $_child_shortcode_bool = true;
    public $_child_shortcode = 'c5ab_tab';

    function __construct() {

        $id_base = 'tabs-widget';
        $this->_shortcode_name = 'c5ab_tabs';
        $name = 'Tabs';
        $desc = 'Add Tabs box.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function child_shortcode($atts, $content) {
        $x = $GLOBALS['c5ab_tabs_count'];
        $GLOBALS['c5ab_tabs'][$x] = array('title' => sprintf($atts['title'], $GLOBALS['c5ab_tabs_count']), 'content' => $content, 'icon' => $atts['icon'], 'post' => $atts['post'], 'content' => $content);

        $GLOBALS['c5ab_tabs_count'] ++;
    }
	function get_content($tab) {
		$content  = '';
		if( $tab['post'] == ''){
			$content = $tab['content'] ;
		}else{
			$type = get_post_type( $tab['post'] );
			$args = array(
				'p'=>$tab['post'],
				'post_type' => $type
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
			    while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$content .= '<h2 class="c5-tabs-subtitle">'.get_the_title().'</h2>';
					$content .= '<div class="c5-entry">'. get_the_content() . '</div>';
				}
			}
			wp_reset_postdata();
		
		}
		return $content;
	}
    function shortcode($atts, $content) {

        $GLOBALS['c5ab_tabs_count'] = 0;
        unset($GLOBALS['c5ab_tabs']);
        do_shortcode($content);

        $tab_id = $this->get_unique_id();

        $counter = 1;
		
		

        if (is_array($GLOBALS['c5ab_tabs'])) {
            if ($atts['type'] == 'tabs') {


                $tabs = '';
                $panes = '';
                foreach ($GLOBALS['c5ab_tabs'] as $tab) {
                    $class = '';
                    $display = 'style="display:none;"';
                    if ($counter == 1) {
                        $class = "current";
                        $display = 'style="display:block;"';
                        $counter++;
                    }
                    $unique_id = $this->get_unique_id();
                    
                    $tabs .= '<li class="c5ab_tab_handle ' . $class . '" data-id="'.$unique_id.'"><span class="' . $tab['icon'] . '" >' . $tab['title'] . '</span></li>';
                    $panes .= '<div class="custom_tabs_content clearfix pane pane-'.$unique_id.'" '.$display.'>' . $this->get_content($tab) . '</div>';
                    
                }
                $return = '<div class="custom_tabs_wrap_out c5ab_tabs_wrap"><ul class="custom_tabs custom_tabs_' . $tab_id . ' clearfix">' . $tabs . '</ul><div class="custom_tabs_wrap">' . $panes . '</div></div>' . "\n";

            } elseif ($atts['type'] == 'side' || $atts['type'] == 'side-left') {
                $tabs = '';
                $panes = '';
                foreach ($GLOBALS['c5ab_tabs'] as $tab) {
                    if ($tab['icon'] != '' && $tab['icon'] != 'none') {
                        $icon = '<span class="side-menu-icon ' . $tab['icon'] . '"></span>';
                    } else {
                        $icon = '';
                    }

                    $unique_id = $this->get_unique_id();

                    $class = '';
                    $display = 'style="display:none;"';
                    if ($counter == 1) {
                        $class = "current";
                        $display = 'style="display:block;"';
                        $counter++;
                    }
                    $tabs .= '<li class="c5ab_tab_handle ' . $class . '" data-id="'.$unique_id.'">' . $icon . '<span class="tab-caption">' . $tab['title'] . '</span></li>';
                    $panes .= '<div class="pane pane-'.$unique_id.'" '.$display.'>' . $this->get_content($tab) . '</div>';
                }
				if ($atts['type'] == 'side'){
                	$return = '<div class="c5ab_tabs_wrap tabbed_wrapper clearfix"><div class="col-lg-9"><div class="tab-content">' . $panes . '</div></div><div class="col-lg-3"><ul class="nav nav-tabs pos-right">' . $tabs . '</ul></div></div>';
                }else {
                	$return = '<div class="c5ab_tabs_wrap tab-left tabbed_wrapper clearfix"><div class="col-lg-3"><ul class="nav nav-tabs pos-left">' . $tabs . '</ul></div><div class="col-lg-9"><div class="tab-content">' . $panes . '</div></div></div>';
                }

            } elseif ($atts['type'] == 'accordion') {
                $tabs = '';
                foreach ($GLOBALS['c5ab_tabs'] as $tab) {
                    $unique_id = $this->get_unique_id();
                    $class = '';
                    $display = 'style="display:none;"';
                    if ($counter == 1) {
                        $class = "current";
                        $display = 'style="display:block;"';
                        $counter++;
                    }
                    
                    $tabs .= '<h2 class="c5ab_accordion_tab_handle '.$class.'" data-id="'.$unique_id.'"><span class="' . $tab['icon'] . '" data-id="'.$unique_id.'"></span>' . $tab['title'] . '</h2><div class="pane pane-'.$unique_id.'" '.$display.'>' . $this->get_content($tab) . '</div>';
                    $counter++;
                }
                $return = '<div class="accordion c5ab_tabs_wrap accordion_'.$tab_id.'">' . $tabs . '</div>';
                
                
            }
        }
        return do_shortcode($return);
    }

    function get_unique_id() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    


    function options() {
        $icons = new C5AB_ICONS();
        $icons_array = $icons->get_icons_as_images();


        $tabs = array(
            'tabs',
            'side',
            'side-left',
            'accordion',
        );
        $tabs_array = array();
        foreach ($tabs as $value) {
            $tabs_array[] = array(
                'src' => C5BP_extra_uri . 'image/tabs/' . $value . '.png',
                'label' => '',
                'value' => $value
            );
        }


        $this->_options = array(
            array(
                'label' => 'Tabs type',
                'id' => 'type',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $tabs_array,
                'std' => 'tabs',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => ''
            ),
            array(
                'label' => 'Add Tab',
                'id' => 'c5ab_tab',
                'type' => 'list-item',
                'desc' => 'Add tab to the tabs box.',
                'settings' => array(
                    array(
                        'label' => 'Icon',
                        'id' => 'icon',
                        'type' => 'radio-text',
                        'desc' => '',
                        'choices' => $icons_array,
                        'std' => 'fa fa-none',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => 'c5ab_icons'
                    ),
                    array(
                        'label' => 'Post ID',
                        'id' => 'post',
                        'type' => 'text',
                        'desc' => 'Get the content from a post, add the post ID here',
                        'std' => '',
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    ),
                    array(
                        'label' => 'Content',
                        'id' => 'content',
                        'type' => 'textarea-simple',
                        'desc' => '',
                        'std' => '',
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    )
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
        );
    }

   

}
?>