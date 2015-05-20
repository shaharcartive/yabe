<?php

class C5AB_menu extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'menu-widget';
        $this->_shortcode_name = 'c5ab_menu';
        $name = 'Menu';
        $desc = 'Add your Menu.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {


        if (has_nav_menu($atts['location'])) {
            $menu = wp_nav_menu(array(
                'container' => false, // remove nav container
                'container_class' => 'menu clearfix', // class of container (should you choose to use it)
                'menu' => 'The Main Menu', // nav name
                'menu_class' => ' top-nav menu-sc-nav clearfix', // adding custom nav class
                'theme_location' => $atts['location'], // where it's located in the theme
                'before' => '', // before the menu
                'after' => '', // after the menu
                'link_before' => '', // before each link
                'link_after' => '', // after each link
                'depth' => 3,
                'echo' => 0,
                'walker' => new C5_description_walker()));



            if ($atts['style'] == 'sidebar') {
                $atts['responsive'] = 'no_responsive';
            }
            return '<nav role="navigation" class="navigation-shortcode responsive-' . $atts['responsive'] . ' ' . $atts['bg_mode'] . ' ' . $atts['style'] . ' top-menu-nav clearfix"><div class="responsive-controller clearfix"><span class="menu-enable fa fa-align-justify"></span></div>' . $menu . '</nav>';
        } else {

            if ($atts['location'] == 'main-nav') {
                $args = array(
                    'depth' => 0,
                    'sort_column' => 'menu_order, post_title',
                    'menu_class' => 'top-nav menu-sc-nav c5-pages-menu clearfix',
                    'include' => '',
                    'exclude' => '',
                    'echo' => false,
                    'show_home' => true,
                    'link_before' => '',
                    'link_after' => '');
                return '<nav role="navigation" class="c5-pages-menu-wrap navigation-shortcode ' . $atts['responsive'] . ' ' . $atts['bg_mode'] . ' ' . $atts['style'] . ' top-menu-nav clearfix" style="display:none;"><div class="responsive-controller clearfix"><span class="menu-enable icon-menu"></span></div>' . wp_page_menu($args) . '</nav>';
            }
            return '';
        }
    }

    function custom_css() {
        
    }

    function options() {

        $this->_options = array(
            array(
                'label' => 'Choose Menu',
                'id' => 'location',
                'type' => 'select',
                'desc' => 'Choose The Menu.',
                'choices' => $this->get_current_menus(),
                'std' => 'main-nav',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Responsive',
                'id' => 'responsive',
                'type' => 'on_off',
                'desc' => 'Make the Menu Responsive.',
                'std' => 'on',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Menu Shape',
                'id' => 'style',
                'type' => 'select',
                'desc' => 'Choose Menu Shape.',
                'choices' => array(
                    array(
                        'label' => 'Default Menu',
                        'value' => 'default'
                    ),
                    array(
                        'label' => 'Side Menu',
                        'value' => 'side'
                    ),
                    array(
                        'label' => 'Center Menu "Default Size"',
                        'value' => 'center'
                    ),
                    array(
                        'label' => 'Full Width Menu "Default Size"',
                        'value' => 'full'
                    ),
                    array(
                        'label' => 'Center Menu "Default Size"',
                        'value' => 'center'
                    ),
                    array(
                        'label' => 'Mini Menu',
                        'value' => 'mini'
                    ),
                ),
                'std' => 'default',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Background Mode',
                'id' => 'bg_mode',
                'type' => 'select',
                'desc' => 'Choose background mode.',
                'choices' => array(
                    array(
                        'label' => 'Light Background',
                        'value' => 'light-mode'
                    ),
                    array(
                        'label' => 'Dark Background',
                        'value' => 'dark-mode'
                    )
                ),
                'std' => 'light-mode',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
        );
    }

    function css() {
        ?>
        <style>
		
        </style>
        <?php

    }

    function get_current_menus() {
        /** Menu Locations* */
        $themes = get_registered_nav_menus();
        $menu_new = array();

        foreach ($themes as $key => $value) {
            $menu_new[] = array(
                'label' => $value,
                'value' => $key
            );
        }

        return $menu_new;
    }

}

?>