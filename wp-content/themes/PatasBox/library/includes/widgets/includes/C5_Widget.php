<?php 



class C5_Widget extends WP_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_child_shortcode_bool = false;
	public  $_skip_title = false;
	public  $_child_shortcode = '';
	public  $_options =array();
	public  $_base_id;
	
	function __construct() {
		
		$id_base = 'menu-widget';
		$this->_shortcode_name = 'menu';
		$name = 'Menu';
		$desc = 'Show Menu in Sidebar.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	function self_construct($name, $id_base , $desc , $classes) {
		
		$this->_base_id = $id_base;
		
		$widget_ops = array( 
			'classname' => 'clearfix c5-widget c5-widget-'.$id_base .' ' . $classes, 
			'description' => $desc  );
		
		$control_ops = array( 'width' => 700, 'height' => 350, 'id_base' => $id_base );
		if(is_admin() ){
			$this->options();
			$this->update_cached_options();
			
		}else {
			$this->get_cached_options();
		}
		
		
		$this->_options = array_merge($this->get_title_array() , $this->_options);
		$this->_options = array_merge($this->get_helper_array() , $this->_options);
		
		
		add_shortcode($this->_shortcode_name, array($this, 'build'));
		if($this->_child_shortcode_bool){
			add_shortcode($this->_child_shortcode, array($this, 'build_child'));
		}
		
		
		add_action( 'wp_enqueue_scripts', array($this, 'inline_css') );
		
		$this->WP_Widget( $id_base, 'AB - '. $name, $widget_ops, $control_ops );
	}
	
	function inline_css() {
			
			if( isset($GLOBALS['c5ab_custom_css_' . $this->_shortcode_name]) ){
				return;
			}
	        ob_start();
	         $this->css();
	         $this->custom_css(); 
	         
	         $custom_css = ob_get_contents();
	         
	         ob_end_clean();
	               
	         
	         $custom_css = str_replace('<style>', '', $custom_css);
	         $custom_css = str_replace('</style>', '', $custom_css);
	         
	        wp_add_inline_style( 'c5ab-widgets', $custom_css );
	}
	
	public function atts(  ) {
		$atts_list = array();
		foreach ($this->_options as $key => $value) {
			$atts_list[ $value['id'] ] = $value['std'];
			
		}
		//print_r($atts_list); 
		return $atts_list;
	}
	
	public function atts_child() {
		$atts_list = array();
		foreach ($this->_options as $key => $value) {
			if($value['id']== $this->_child_shortcode){
				foreach ($value['settings'] as $key2 => $value2) {
					$atts_list[ $value2['id'] ] = $value2['std'];
						
				}
			}
		}
		$atts_list['title']= '';
		return $atts_list;
	}
	
	
	
	public function build_child($atts,$content)
	{
		// extract the attributes into variables
		$atts = shortcode_atts( $this->atts_child() , $atts);
		
		if(isset($atts['content']) && $content == ''){
			$content = $atts['content'];
			unset($atts['content']);
			
		}
		$data = $this->child_shortcode($atts,$content);
		return $data;
	}	
	function child_shortcode($atts, $content) {
		
	}
	
	public function get_helper_array() {
		return array(
			array(
		    	'label' => 'Reference Title',
		    	'id' => 'c5_helper_title',
		    	'type' => 'text',
		    	'desc' => 'This text will be used as the sub-text in your page builder, leave it empty for auto assign<br/><strong>Note: this won\'t get rendered in your widget</strong>',
		    	'std' => '',
			)
		);
	}
	
	public function get_title_array() {
		if($this->_skip_title){
			return array();
		}
		return array(
			array(
		    	'label' => 'Title',
		    	'id' => 'c5_title',
		    	'type' => 'text',
		    	'desc' => '',
		    	'std' => '',
			)
		);
	}
	
	public function return_title_html($atts) {
		if($this->_skip_title){
			return '';
		}
		if( isset($atts['c5_title']) ){
			if($atts['c5_title']!=''){
				$code =  do_shortcode('[c5ab_title title="'.$atts['c5_title'].'"  ]');
				return $code;
			}
		}
		return '';
	}
	
	
	public function build($atts,$content)
	{
		// extract the attributes into variables
		$atts = shortcode_atts( $this->atts(   ) , $atts);
		
		if(isset($atts['content'])  && $content == ''){
			$content = $atts['content'];
			unset($atts['content']);
			
		}
		$data = $this->return_title_html($atts) ;
		
		$data .=  $this->shortcode($atts,$content);
		/*
		if( !isset($GLOBALS['c5ab_custom_css_' . $this->_shortcode_name]) ){
			$this->css();
			$this->custom_css(); 
			$GLOBALS['c5ab_custom_css_' . $this->_shortcode_name] = TRUE;
		}
		*/
		return $data;
	}
	
	function shortcode($atts,$content) {
		//shortcode implementation
	}
	function update_cached_options() {
		$this->options();
		$options_to_be_saved =  array();
		foreach ($this->_options as $option) {
			$new_option = array(
				'id'=>$option['id'],
				'type'=>$option['type'],
				'std'=>$option['std']
			);
			if(isset($option['settings']) && is_array($option['settings'])){
				
				$new_settings =array();
				foreach ($option['settings'] as $setting) {
					$new_settings[] = array(
						'id'=>$setting['id'],
						'type'=>$setting['type'],
						'std'=>$setting['std']
					);
				}
				$new_option['settings'] = $new_settings;	
			}	
			
			$options_to_be_saved[] = $new_option;
		}
		
		update_option('c5_shortcode_option_' . $this->_base_id, $options_to_be_saved);
	}
	function get_cached_options() {
		$options = get_option('c5_shortcode_option_' . $this->_base_id);
		
		if(!is_array($options)){
			$this->update_cached_options();
		}else {
			$this->_options = $options;
		}
	}
	
	function options() {
		
		
		
		
		$this->_options =array(
		 array(
		    'label' => 'Title',
		    'id' => 'title',
		    'type' => 'text',
		    'desc' => 'Menu Widget title.',
		    'std' => '',
		    'rows' => '',
		    'post_type' => '',
		    'taxonomy' => '',
		    'class' => '',
		 ),
		);
	}

	function get_unique_id() {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 5; $i++) {
		    $randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	function get_main_colors() {
		$array = array(
			'primary'=> c5ab_get_option('primary_color'),
			'light'=>c5ab_get_option('light_color'),
			'dark'=>c5ab_get_option('dark_color'),
			'grey'=>c5ab_get_option('grey_color'),
			'text'=>c5ab_get_option('text_color'),
		
		);
		return $array;
	}
	
	function widget( $args, $instance ) {
		echo  do_shortcode( $this->prepare_shortcode( $args, $instance) ) ;
		
	}
	
	function prepare_shortcode( $args, $instance ) {
		
		
		$shortcode = $args['before_widget'] .  $this->build_shortcode($this->_shortcode_name , $this->_options ,$instance) . $args['after_widget'];
		
		
		return   $shortcode ;
	}
	
	function build_shortcode($name, $options, $instance) {
		$shortcode = '['.$name .' ';
		$content_bool = false;
		$content = '';
		
		
		foreach ($options as $key => $value) {
			if($value['type'] == 'list-item'){
				
				$value['settings'][] = array(
				    'label' => 'Title',
				    'id' => 'title',
				    'type' => 'text',
				    'desc' => '',
				    'std' => '',
				    'rows' => '',
				    'post_type' => '',
				    'taxonomy' => '',
				    'class' => ''
				);
				
				$sub_instance = unserialize(base64_decode( $instance[$value['id']] ));
				if(is_array($sub_instance)){
					foreach ($sub_instance as $key2 => $single_instance) {
						$content .= $this->build_shortcode($value['id'] ,$value['settings'] ,$single_instance);
						$content_bool = true;
					}	
				}
			}elseif($value['id'] == 'content'){
				$content .= $instance[$value['id']];
				$content_bool = true;
				
			}else {
				if(isset($instance[$value['id']])){
					$shortcode .= $value['id'] .'="' .$instance[$value['id']] .'" ';
				}
			}
		}
		$shortcode .= ']';
		if($content_bool){
			$shortcode .= $content . '[/'.$name.']';
		}
		
		
		return $shortcode;
	}

	//Update the widget 
	
	function _get_update_callback() {
		
		if(isset($_POST['id_base'])){
			$new_key = 'widget-' . $_POST['id_base'];
			foreach ($_POST as $key => $value) {
				
				if(strpos($key, 'widget-' . $_POST['widget-id'] .'-') !== false){
					$test_string = str_replace('widget-' . $_POST['widget-id'] .'-', "", $key);
					if(strpos($key, '_settings_array') !== false){
						continue;
					}
					
					$_POST[$new_key][$_POST['widget_number']][$test_string] = ot_encode(serialize($value[$key]));
				}
				
			}
			if(isset($_POST[$new_key][ $_POST['widget_number'] ]) && is_array($_POST[$new_key][ $_POST['widget_number'] ])){
				foreach ($_POST[$new_key][ $_POST['widget_number'] ] as $key => $value) {
					if (is_array($value)) {
						$_POST[$new_key][ $_POST['widget_number'] ][$key] = ot_encode(serialize($value));	
					}
				}
			}
		}
		
		return array($this, 'update_callback');
	}
	
	function prepare_atts($data) {
		
		$instance = array();
		foreach ($data as $key => $value) {
			preg_match_all("/\[.*?\]/",$key,$matches);
			if(count( $matches[0] ) !=0){
				$test_array = $matches[0];
				if(count( $test_array ) ==3){
					$instance[$this->_child_shortcode][ c5ab_strip( $test_array[1] ) ][c5ab_strip($test_array[2])] = $value;
				}else {
					$instance[c5ab_strip($test_array[1])] = $value;
				}
			}
		}
		$return = array();
		foreach ($instance as $key => $value) {
			if(is_array($value)){
				$key = str_replace(']' , "", $key);
				$return[$key] = base64_encode(serialize($value));	
			}else {
				$return[$key] = $value;	
			}
		}
		
		$demo = array('before_widget' => '' , 'after_widget' => '' );
		
		return $this->prepare_shortcode($demo, $return);
	}
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		foreach ($new_instance as $key => $value) {
			if(is_array($new_instance[ $key ])){
				$instance[ $key ] =  $new_instance[ $key ];
			}else {
				if($key =='content'){
					$instance[ $key ] =  $new_instance[ $key ] ;
				}else {
					
					$instance[ $key ] = esc_attr( $new_instance[ $key ] );	
				}	
			}
		}
		return $instance;
	}

	
	function form( $instance ) {
		
		foreach ($this->_options as $key => $value) {
			$this->display_setting($value, $instance);
		}
		
		
		echo '<script  type="text/javascript"> OT_UI.init();</script>';
		
		$this->admin_footer_js(); 
		
	}
	
	function admin_footer_js() {
		
	}
	
	function display_setting( $args = array(), $instance= array() ) {
	      extract( $args );
	      
	      /* get current saved data */
	      //$options = get_option( $get_option, false );
	      
	      // Set field value
	      
	      $current_value =  isset($instance[$id]) ? $instance[$id] : '';
	      $id_tag = $this->get_field_id($id);
	      if($type == 'textarea' ){
	      	$id_tag = strtolower($id_tag);
	      	$id_tag = str_replace('-', '_', $id_tag);
	      }
	      $name = $this->get_field_name($id);
	      
	      
	      $field_value = isset( $current_value ) ? $current_value: '';
	      
	      
	      
	      
	      /* set standard value */
	      if ( isset( $current_value ) && $current_value=='' ) {  
	        $field_value = ot_filter_std_value( $field_value, $std );
	      }else {
	      	$field_value = $current_value;
	      }
	      
	      if( ( $type == 'list-item' || $type == 'background') && $field_value!=''){
	      	unset($field_value);
	      	$field_value= array();
	      	$field_value = unserialize(ot_decode($current_value));
	      	
	      }
	      
	      if($id == 'content'){
	      	$field_value= html_entity_decode($field_value);
	      }
	      
	
	      /* build the arguments array */
	      $_args = array(
	        'type'              => $type,
	        'field_id'          => $id_tag,
	        'field_name'        =>  $name ,
	        'field_value'       => $field_value,
	        'field_desc'        => isset( $desc ) ? $desc : '',
	        'field_std'         => isset( $std ) ? $std : '',
	        'field_rows'        => isset( $rows ) && ! empty( $rows ) ? $rows : 15,
	        'field_post_type'   => isset( $post_type ) && ! empty( $post_type ) ? $post_type : 'post',
	        'field_taxonomy'    => isset( $taxonomy ) && ! empty( $taxonomy ) ? $taxonomy : 'category',
	        'field_min_max_step'=> isset( $min_max_step ) && ! empty( $min_max_step ) ? $min_max_step : '0,100,1',
	        'field_class'       => isset( $class ) ? $class : '',
	        'field_choices'     => isset( $choices ) && ! empty( $choices ) ? $choices : array(),
	        'field_settings'    => isset( $settings ) && ! empty( $settings ) ? $settings : array(),
	        'post_id'           => ot_get_media_post_ID(),
	        'get_option'        => $id_tag,
	      );
	      
	      $class = isset( $class ) ? $class : '';
	      echo '<div class="c5-setting-wrap c5-setting-wrap-'.$id.' c5-class-'.$class.'">';
	      echo '<div class="format-setting-label">';
	        
	      	    echo '<h4 class="label">' . $label . '</h4>';     
	      
	        echo '</div>';
	      
	      /* get the option HTML */
	      echo ot_display_by_type( $_args );
	      
	      echo '</div>';
	 }
	 
	 function custom_css() {
	 	
	 }
	 
	 function css() {
	 	
	 }
}

/* add scripts for metaboxes to post-new.php & post.php */
add_action( 'admin_print_scripts-widgets.php', 'ot_admin_scripts', 11 );
      
/* add styles for metaboxes to post-new.php & post.php */
add_action( 'admin_print_styles-widgets.php', 'ot_admin_styles', 11 );


 ?>