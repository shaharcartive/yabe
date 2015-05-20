<?php 


class C5_author_settings extends C5_archive_settings {
	
	
	
	
	function hook() {
		
		
		add_action('show_user_profile', array($this, 'user_checboxes'));
		add_action('edit_user_profile', array($this, 'user_checboxes'));
		add_action('personal_options_update', array($this, 'user_save'));
		add_action('edit_user_profile_update', array($this, 'user_save'));
		
		
		
	}
	
	function set_options() {
		
		$this->_options = array();
		
		$this->_options[]= array(
		    'label' => 'Facebook Username',
		    'id' => 'facebook',
		    'type' => 'text',
		    'desc' => 'Facebook Username',
		    'std' => '',
		    'class' => ''
		);
		$this->_options[]= array(
		    'label' => 'Twitter Username',
		    'id' => 'twitter',
		    'type' => 'text',
		    'desc' => 'Twitter Username',
		    'std' => '',
		    'class' => ''
		);
		$this->_options[]= array(
		    'label' => 'Google Plus Link',
		    'id' => 'google_plus',
		    'type' => 'text',
		    'desc' => 'Google Plus Link',
		    'std' => '',
		    'class' => ''
		);
		$this->_options[]= array(
		    'label' => 'LinkedIn Profile Link',
		    'id' => 'linkedin',
		    'type' => 'text',
		    'desc' => 'LinkedIn Profile Link',
		    'std' => '',
		    'class' => ''
		);
		$this->_options[] =  array(
			'label' => 'Cover Photo',
			'id' => 'cover',
			'type' => 'upload',
			'desc' => 'Upload Cover Photo ',
			'std' => '',
			'rows' => '',
			'taxonomy' => '',
			'class' => ''
		);
		
		$this->_options[] =  array(
			'label' => 'Author Content template',
			'id' => 'template',
			'type' => 'select',
			'desc' => 'Choose The custom template for this category ',
			'choices' => $this->get_templates_list(),
			'std' => '',
			'rows' => '',
			'taxonomy' => '',
			'class' => ''
		);
		if (!C5_simple_option) {
		    $this->_options[] = array(
		        'label' => 'Choose Custom Skin',
		        'id' => 'skin_default',
		        'type' => 'custom-post-type-select',
		        'desc' => 'Choose Custom Skin, leave it for default skin.',
		        'std' => '',
		        'rows' => '',
		        'post_type' => 'skin',
		        'taxonomy' => '',
		        'class' => ''
		    );
		} 
		$this->_options[] = array(
		    'label' => 'Use Custom Color Settings',
		    'id' => 'use_custom_colors',
		    'type' => 'on_off',
		    'desc' => 'Use Custom Color Settings.',
		    'std' => 'off',
		    'class' => ''
		);
		$this->_options[]= array(
		    'label' => 'Use Custom Layout Settings',
		    'id' => 'use_custom_layout',
		    'type' => 'on_off',
		    'desc' => 'Use Custom Layout Settings.',
		    'std' => 'off',
		    'class' => ''
		);
		
		
		$this->add_options( $this->get_colors_options() );
		
		$this->add_options( $this->get_layout_options() );
		
		
	}
	
	function user_save($user_id) {
		if(!current_user_can('remove_users')){
			return;
		}
		if (!current_user_can('edit_user', $user_id)) {
		    return false;
		}
		
		$this->set_options();
		
		foreach ($this->_options as $option) {
			$value = $option['id'];
			if(isset($_POST[$value])){
				update_user_meta($user_id, 'c5_term_meta_user_' . $value, $_POST[$value]  );
			}
		
		}
	}
	
	function user_checboxes($user) {
		if(!current_user_can('remove_users')){
			return;
		}
		$this->set_options();
		$theme = wp_get_theme();
		?>
		<h3><?php echo $theme->get( 'Name' ) ?> related User Info</h3>
		<table class="form-table">
		<?php 
		foreach ($this->_options as $option) {
			$value = get_the_author_meta('c5_term_meta_user_' . $option['id'], $user->ID);
			?>
			<tr class="form-field c5-no-label">
			    <th scope="row" valign="top">
			    	<label for="<?php echo $option['id'] ?>"><?php echo $option['label'] ?></label>
			    </th>
			    <td>
		    		<?php 
		    		$option['label'] = '';
		    		$value_array = array($option['id'] =>  $value);
		    		$this->display_setting($option, $value_array ); ?>
			     </td>
			</tr>
			<?php	
		}
		
		 ?>
				
		</table>
		<?php
		
		
	}
	
	
		
	function get_icons($value='') {
		$icons = new C5AB_ICONS();
		echo '<input type="hidden" name="icon" id="c5_icon" value="'.$value.'" />';
		echo '<ul class="c5-span-icons">';
		echo $icons->get_icons_spans($value);
		echo '</ul>';
		
	}
	
	function get_skins($value='') {
	    $skins = '';
		
		$selected = '';
		if($value == ''){
			$selected = 'selected="selected"';
		}
		$skins .= '<option value="" '.$selected.'>Default Skin</option>';
		
	    $query = new WP_Query(array('post_type' => 'skin', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'publish'));
	
	    /* has posts */
	    if ($query->have_posts()) {
	        while ($query->have_posts()) {
	            $query->the_post();
	            $selected = '';
	            $comp_value = get_the_ID();
	            if( $comp_value == $value){
	            	$selected = 'selected="selected"';
	            }
	            
	            $skins .= '<option value="'.$comp_value.'" '.$selected.'>'.get_the_title().'</option>';
	            
	        }
	    }
	    wp_reset_postdata();
	
	    return $skins;
	}
	
	function get_templates($value='') {
		$templates = '';
		$selected = '';
		if($value == ''){
			$selected = 'selected="selected"';
		}
		$skins .= '<option value="" '.$selected.'>Default Template</option>';
		
		foreach (c5_get_ab_templates() as $key => $value2) {
			$selected = '';
			$comp_value = $key;
			if( $comp_value == $value){
				$selected = 'selected="selected"';
			}
			
			$skins .= '<option value="'.$comp_value.'" '.$selected.'>'.$value2.'</option>';
		}
		return $skins;
	}
	
	
	
	
}

$authors_term_obj = new C5_author_settings();

 ?>