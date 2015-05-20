<?php

class C5AB_text extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'text-widget';
        $this->_shortcode_name = 'c5ab_text';
        $name = 'Text';
        $desc = 'Text Editor for your website.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {

        $data = html_entity_decode(do_shortcode($content));

        return $data;
    }

    function admin_footer_js() {

        $field_id = 'widget_text_widget_daiufi_content';
        ?>
        <script type="text/javascript">


            ;
            (function($) {


                var new_id = $('#c5_sample_editor_id').val();

				
				delete window.tinyMCEPreInit.mceInit[new_id];
				delete  window.tinyMCEPreInit.qtInit[new_id];
 				
				window.tinyMCEPreInit.mceInit[new_id] = _.extend({}, tinyMCEPreInit.mceInit['content'], {resize: 'vertical', height: 200});
				
				if (_.isUndefined(tinyMCEPreInit.qtInit[new_id])) {
                    window.tinyMCEPreInit.qtInit[new_id] = _.extend({}, tinyMCEPreInit.qtInit['replycontent'], {id: new_id})
                }
				
				
				qt = quicktags(window.tinyMCEPreInit.qtInit[new_id]);
                QTags._buttonsInit();
                window.switchEditors.go(new_id, 'tmce');
                tinymce.execCommand('mceRemoveEditor', true, new_id);
                tinymce.execCommand('mceAddEditor', true, new_id);
                
				
				
//				tinymce.init( window.tinyMCEPreInit.mceInit[new_id] );
				

            })(jQuery);

        </script>
        <?php

    }

    function custom_css() {
        
    }

    function options() {


        $this->_options = array(
            array(
                'label' => 'Text',
                'id' => 'content',
                'type' => 'wp_editor',
                'desc' => '',
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