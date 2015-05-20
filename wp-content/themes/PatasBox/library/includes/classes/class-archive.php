<?php 


class C5_archive_settings extends C5_theme_option_elements {
	
	public $_options =array();
	function __construct() {
	
		$this->hook();
	}
	
	
	function add_options($options) {
		$this->_options = array_merge($this->_options, $options);
	}
	
	
	
	function display_setting( $args = array(), $instance= array() ) {
	      extract( $args );
	      
	      /* get current saved data */
	      //$options = get_option( $get_option, false );
	      
	      // Set field value
	      
	      $current_value =  isset($instance[$id]) ? $instance[$id] : '';
	      $id_tag =  $id;
	      if($type == 'textarea' ){
	      	$id_tag = strtolower($id_tag);
	      	$id_tag = str_replace('-', '_', $id_tag);
	      }
	      $name =  $id;
	      
	      
	      $field_value = isset( $current_value ) ? $current_value: '';
	      
	      
	      
	      
	      /* set standard value */
	      if ( isset( $current_value ) && $current_value=='' ) {  
	        $field_value = ot_filter_std_value( $field_value, $std );
	      }else {
	      	$field_value = $current_value;
	      }
	      
	      if( (  $type == 'background') && $field_value!=''){
	      	unset($field_value);
	      	if(is_array($current_value)){
	      		$field_value = $current_value;
	      	}else {
	      		$field_value= array();
	      		$field_value = unserialize(ot_decode($current_value));	
	      	}
	      	
	      }
	      
	      if($id == 'content'){
	      	//$field_value= html_entity_decode($field_value);
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
	      echo '<div class="c5-setting-wrap c5-setting-wrap-'.$id.' c5-class-'.$class.'">';
	      echo '<div class="format-setting-label">';
	        
	      	    echo '<h4 class="label">' . $label . '</h4>';     
	      
	        echo '</div>';
	      
	      /* get the option HTML */
	      echo ot_display_by_type( $_args );
	      
	      echo '</div>';
	 }
	
	
	
	
}


 ?>