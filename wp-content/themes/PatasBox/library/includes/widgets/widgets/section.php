<?php

class C5AB_section extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'section-widget';
        $this->_shortcode_name = 'c5ab_section';
        $name = 'Section';
        $desc = 'Open a Wide Section in your page.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {
		$id = $this->get_unique_id();
		
        
        $bg_mode = 'light';
        $background = '';
        $array = array(
        	'color',
        	'repeat',
        	'attachment',
        	'position',
        	'size'
        );
        foreach ($array as $key => $value) {
        	if($atts[$value]!=''){
        		$background .= 'background-'. $value.': '. $atts[$value] . ';'. "\n";
        	}
        }
        
        if($atts['color'] != ''){
        	$lum = intval( c5_get_lum($atts['color']) );
        	if($lum > 170){
        		$bg_mode = 'light';
        	}else {
        		$bg_mode = 'dark';
        	}	
        }
        if($atts['image'] != ''){
        	$background .= 'background-image: url(\''. $atts['image'] . '\');'. "\n";
        	$lum = intval( c5_get_avg_luminance($atts['image']) ) ;
        	if($lum > 170){
        		$bg_mode = 'light';
        	}else {
        		$bg_mode = 'dark';
        	}
        }
        
        $data ='</div><div id="section-'.$id.'" class="c5-main-width-wide-wrap c5-content-'.$bg_mode.'"><div class="content">';
        $data .= html_entity_decode(do_shortcode($content));
        $data .= '</div></div>'; 
        
        
        $data .= '<style>#section-'.$id.'{'.$background.'}</style>';
        
        $data .= '<div class="c5-main-width-wrap ">';

        return $data;
    }

    function admin_footer_js() {

        $field_id = 'widget_section_widget_daiufi_content';
        ?>
        <script type="section/javascript">


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
                'label' => 'Background-color',
                'id' => 'color',
                'type' => 'colorpicker',
                'desc' => '',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Background Image',
                'id' => 'image',
                'type' => 'upload',
                'desc' => '',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Background Repeat',
                'id' => 'repeat',
                'type' => 'select',
                'desc' => '',
                'choices'=>array(
                	array(
                		'label'=>'repeat',
                		'value'=>''
                	),
                	array(
                		'label'=>'No Repeat',
                		'value'=>'no-repeat'
                	),
                	array(
                		'label'=>'Repeat',
                		'value'=>'repeat'
                	),
                	array(
                		'label'=>'Repeat Vertically',
                		'value'=>'repeat-y'
                	),
                	array(
                		'label'=>'Repeat Horizontally',
                		'value'=>'repeat-x'
                	),array(
                		'label'=>'Inherit',
                		'value'=>'inherit'
                	),
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Background Attachment',
                'id' => 'attachment',
                'type' => 'select',
                'desc' => '',
                'choices'=>array(
                	array(
                		'label'=>'attachment',
                		'value'=>''
                	),
                	array(
                		'label'=>'Fixed',
                		'value'=>'fixed'
                	),
                	array(
                		'label'=>'Scroll',
                		'value'=>'scroll'
                	),
                	array(
                		'label'=>'Inherit',
                		'value'=>'inherit'
                	),
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Background Position',
                'id' => 'position',
                'type' => 'select',
                'desc' => '',
                'choices'=>array(
                	array(
                		'label'=>'position',
                		'value'=>''
                	),
                	array(
                		'label'=>'Left Top',
                		'value'=>'left top'
                	),
                	array(
                		'label'=>'Left Center',
                		'value'=>'left center'
                	),
                	array(
                		'label'=>'Left Bottom',
                		'value'=>'left bottom'
                	),
                	
                	array(
                		'label'=>'Center Top',
                		'value'=>'center top'
                	),
                	array(
                		'label'=>'Center Center',
                		'value'=>'center center'
                	),
                	array(
                		'label'=>'Center Bottom',
                		'value'=>'center bottom'
                	),
                	
                	array(
                		'label'=>'Right Top',
                		'value'=>'right top'
                	),
                	array(
                		'label'=>'Right Center',
                		'value'=>'right center'
                	),
                	array(
                		'label'=>'Right Bottom',
                		'value'=>'right bottom'
                	),
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Background Size',
                'id' => 'size',
                'type' => 'text',
                'desc' => '',
                'std' => 'cover',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Section',
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