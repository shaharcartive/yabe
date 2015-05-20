<?php

class C5_user_setttings {

    function __construct() {
        add_action('show_user_profile', array($this, 'user_checboxes'));
        add_action('edit_user_profile', array($this, 'user_checboxes'));
        add_action('personal_options_update', array($this, 'user_save'));
        add_action('edit_user_profile_update', array($this, 'user_save'));
        
    }

    function user_save($user_id) {
        if(!current_user_can('remove_users')){
        	return;
        }
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        
        global $wp_widget_factory;
        
       foreach ($wp_widget_factory->widgets as $class => $info) {
       		update_user_meta($user_id, 'c5_widget_allow_' . $class, $_POST['c5_widget_allow_' . $class] );
       }
        
    }

    function user_checboxes($user) {
    	if(!current_user_can('remove_users')){
    		return;
    	}
    	
        $widgets = array();
        $defaults = array();
        global $wp_widget_factory;

        foreach ($wp_widget_factory->widgets as $class => $info) {
            $widget = new $class();
            
            
            $settings = array(
                'label' => esc_html($widget->name),
                'id' => 'c5_widget_allow_' . $class,
                'type' => 'on_off',
                'desc' => __('Select the Widget to Show/Hide for this user.', 'c5ab'),
                'std' => 'on',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            );
            
            $saved_data =get_the_author_meta('c5_widget_allow_' . $class , $user->ID);
            
            
            $this->display_setting($settings,array('c5_widget_allow_' . $class => $saved_data));
            
         }
            
            
      }
      
      
      function display_setting( $args = array(), $instance= array() ) {
            extract( $args );
            
            /* get current saved data */
            //$options = get_option( $get_option, false );
            
            // Set field value
            
            $current_value =  isset($instance[$id]) ? $instance[$id] : '';
            $id_tag = $id;
            $name = $id;
            
            
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
            
            echo '<div class="format-setting-label">';
              
            	    echo '<h4 class="label">' . $label . '</h4>';     
            
              echo '</div>';
            
            /* get the option HTML */
            echo ot_display_by_type( $_args );
            
       }

}

$obj_user = new C5_user_setttings();
?>