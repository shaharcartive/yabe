<?php 
if ( ! function_exists( 'ot_type_radio_text' ) ) {
  
  function ot_type_radio_text( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-radio-image ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner c5-inner-icons">';
        echo '<input type="text" name="" value="" placeholder="Search for an icon..." class="c5-icon-search" /><div class="clearfix" ></div>';
        /**
         * load the default filterable images if nothing 
         * has been set in the choices array.
         */
        if ( empty( $field_choices ) )
          $field_choices = ot_radio_images( $field_id );
          
        /* build radio image */
        foreach ( (array) $field_choices as $key => $choice ) {
          
          $src = str_replace( 'OT_URL', OT_URL, $choice['src'] );
          $src = str_replace( 'OT_THEME_URL', OT_THEME_URL, $src );
          
          $c5_icon = str_replace('fa fa-', '', $choice['value'] );
          $c5_class_value = 'c5-search-' . $c5_icon;
          
          echo '<div class="option-tree-ui-radio-images '.$c5_class_value.'" data-icon="'.$c5_icon.'">';
            echo '<p style="display:none"><input type="radio" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $field_value, $choice['value'], false ) . ' class="option-tree-ui-radio option-tree-ui-images" /><label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label></p>';
            
            echo '<span class="'.$src.' c5ab_icons  option-tree-ui-radio-image ' . esc_attr( $field_class ) . ( $field_value == $choice['value'] ? ' option-tree-ui-radio-image-selected' : '' ) . '" title="' . esc_attr( $choice['label'] ) .'"></span>';
          echo '</div>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
    echo '<style>
    .c5ab_icons {
    width: 32px;
    height: 32px;
    text-align: center;
    line-height: 32px;
    font-size: 20px;
    cursor: pointer;
    display: block;
    border-radius: 2px;
    
    -moz-transition: all 0.2s ease;
    -o-transition: all 0.2s ease;
    -webkit-transition: all 0.2s ease;
    -ms-transition: all 0.2s ease;
    transition: all 0.2s ease;
    
    }
    input.c5-icon-search{
    	padding: 10px;
    	border: 1px solid #ccc;
    	width: 100%;
    	box-shadow: none;
    	margin: 0px 0px 15px;
    }
    .type-radio-image .option-tree-ui-radio-images .c5ab_icons.option-tree-ui-radio-image-selected,
    .type-radio-image .option-tree-ui-radio-images .c5ab_icons:hover{
    	background:#e14d43;
    	color: white;
    }</style>';
    
  }
  
}


if ( ! function_exists( 'ot_type_wp_editor' ) ) {
  
  function ot_type_wp_editor( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textarea ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . ' fill-area">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      echo '<input type="hidden" name="c5_sample_editor_id" id="c5_sample_editor_id" value="'.$field_id.'" />';
      
      //echo '<span class="">'.$field_id.'</span>';
      
        /* build textarea */
        wp_editor( 
          $field_value, 
          esc_attr( $field_id )        );
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

 ?>