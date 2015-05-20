<?php

class C5AB_social_icons extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();
    public $_child_shortcode_bool = true;
    public $_child_shortcode = 'c5ab_social_icon';

    function __construct() {

        $id_base = 'social-icons-widget';
        $this->_shortcode_name = 'c5ab_social_icons';
        $name = 'Social Icons';
        $desc = 'Add Social icons box .';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function child_shortcode($atts, $content) {
        $x = $GLOBALS['social_icons_count'];
        $GLOBALS['social_icons'][$x] = array('title' => sprintf($atts['title'], $GLOBALS['social_icons_count']), 'content' => $content, 'icon' => $atts['icon'], 'link' => $atts['link']);

        $GLOBALS['social_icons_count'] ++;
    }

    function shortcode($atts, $content) {

        $GLOBALS['social_icons_count'] = 0;
        unset($GLOBALS['social_icons']);
        do_shortcode($content);


        if (is_array($GLOBALS['social_icons'])) {
            $tabs = '';
            foreach ($GLOBALS['social_icons'] as $tab) {
                $tabs .= '<div class="single_social_icon"><a class=" ' . $tab['icon'] . '" href="' . $tab['link'] . '" target="_blank" title="' . $tab['title'] . '"></a></div>';
                
            }
            $return = '<div class="c5ab_social_icons clearfix">' . $tabs . '</div>' . "\n";
        }
        return $return;
    }
	
    function options() {
        $icons = new C5AB_ICONS();
        $icons_array = $icons->get_icons_as_images();
        $this->_options = array(
            array(
                'label' => 'Add Social Icon',
                'id' => 'c5ab_social_icon',
                'type' => 'list-item',
                'desc' => 'Add Social Icon to the box.',
                'settings' => array(
                    array(
                        'label' => 'Icon',
                        'id' => 'icon',
                        'type' => 'radio-text',
                        'desc' => '',
                        'choices' => $icons_array,
                        'std' => 'fa fa-facebook',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => 'c5ab_icons'
                    ),
                    array(
                        'label' => 'Link',
                        'id' => 'link',
                        'type' => 'text',
                        'desc' => 'Icon Url.',
                        'std' => '',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    ),
                ),
                'std' => '',
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

            .c5ab_social_icons  .single_social_icon{
                display:block;width:43px;height:43px;float:left;margin:0px 1px;
            }
            .c5ab_social_icons a.fa{display:block;line-height:43px;text-align:center;font-size:13px;border-radius:3px;color: #fff; text-decoration: none;  background-color:#303030;-moz-transition:all .2s ease;-o-transition:all .2s ease;-webkit-transition:all .2s ease;-ms-transition:all .2s ease;transition:all .2s ease}
            .c5ab_social_icons a:hover,
            .c5ab_social_icons a:focus{
                color: white;
                border: none;
            }
            .c5ab_social_icons a:hover.fa-facebook{background:#4c66a4}
            .c5ab_social_icons a:hover.fa-twitter{background:#5dd7fc}
            .c5ab_social_icons a:hover.fa-google-plus{background:#d95232}
            .c5ab_social_icons a:hover.fa-vimeo-square{background:#4bf}
            .c5ab_social_icons a:hover.fa-youtube{background:#e22c28}
            .c5ab_social_icons a:hover.fa-flickr{background:#ff0080}
            .c5ab_social_icons a:hover.fa-dribbble{background:#e24a85}
            .c5ab_social_icons a:hover.fa-linkedin{background:#0274b3}
            .c5ab_social_icons a:hover.fa-tumblr{background:#35506b}
            .c5ab_social_icons a:hover.fa-pinterest{background:#cb2028}
            .c5ab_social_icons a:hover.fa-github{background:#3e3e3e}
            .c5ab_social_icons a:hover.fa-dropbox{background:#1665a7}
            .c5ab_social_icons a:hover.fa-rss{background:#ff6501}


            .single_social_icon .dropdown-menu{
                right: 0px;
                left: auto;
                box-shadow: none;
                border-radius: 0px;
                border: none;
                padding: 10px;
                background-color:#303030;
                color: white;
                margin-top: 0px;
                width: 330px;
            }
        </style>
        <?php
    }

}
?>