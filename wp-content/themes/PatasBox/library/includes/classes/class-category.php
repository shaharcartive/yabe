<?php 


class C5_category_settings extends C5_archive_settings {
	
	function hook() {
		
	
		
		add_action ( 'edit_category_form_fields', array($this , 'edit_form'));
		add_action('edit_tag_form_fields' , array($this , 'edit_form'));
		
		
		//add_action ( 'edited_category', array($this , 'save_form'));
		add_action ( 'edited_terms', array($this , 'save_form'));
		
		
	}
		
	
	
	function save_form($term_id) {
		
		$this->set_options();
		
		if(isset($_POST['taxonomy'])){
			$tax = $_POST['taxonomy'];
			foreach ($this->_options as $option) {
				$value = $option['id'];
				if(isset($_POST[$value])){
					update_option('c5_term_meta_' . $tax .'_'. $term_id .'_' . $value , $_POST[$value]);	
				}
			
			}
		}
		$css_obj = new C5_header_css();
		$css_obj->create_terms_array();
	}
	
	function set_options() {
		
		$this->_options = array();
		
		
		$this->_options[] =  array(
			'label' => 'Category Content template',
			'id' => 'template',
			'type' => 'select',
			'desc' => 'Choose The custom template for this category ',
			'choices' => $this->get_templates_list(),
			'std' => '',
			'rows' => '',
			'taxonomy' => '',
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
		if (!C5_simple_option) {
		    $this->_options[] = array(
		        'label' => 'Choose Custom Skin',
		        'id' => 'skin',
		        'type' => 'custom-post-type-select',
		        'desc' => 'Choose Custom Skin, leave it for default skin.',
		        'std' => '',
		        'rows' => '',
		        'post_type' => 'skin',
		        'taxonomy' => '',
		        'class' => ''
		    );
		    if(isset($_GET['taxonomy'])){
			    $tax = $_GET['taxonomy'];
		    }elseif( isset($_POST['taxonomy']) ) {
		    	$tax = $_POST['taxonomy'];
		    }
		    if($tax != 'post_tag'){
		       $this->_options[] = array(
		            'label' => 'Choose Custom Article Skin',
		            'id' => 'article_skin',
		            'type' => 'custom-post-type-select',
		            'desc' => 'Choose Custom Article Skin, leave it for default skin.',
		            'std' => '',
		            'rows' => '',
		            'post_type' => 'skin',
		            'taxonomy' => '',
		            'class' => ''
		        );
		    } 
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
		
		
		
		$this->_options[] =  $this->get_icons_options() ;
		
		
		$this->add_options( $this->get_colors_options() );
		$this->add_options( $this->get_layout_options() );
		
		
	}
	
	
	function edit_form($term) {
	
		
		$this->set_options();
		$tax = $_GET['taxonomy'];
		$term_id = $_GET['tag_ID'];
		if(isset($_GET['post_type'])){
			$post_type = $_GET['post_type'];
		}else {
			$post_type = 'post';
		}
		
		foreach ($this->_options as $option) {
			$value = get_option('c5_term_meta_' . $tax .'_'. $term_id . '_' .  $option['id']);
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
	}
	
	
	
	
}

$categories_term_obj = new C5_category_settings();

 ?>