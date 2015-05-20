<?php 
class C5PB_BASE {
	
	public $actions =array(
		'add',
		'edit',
		'delete',
		'duplicate',
	);
	
	public $parent_obj;
	
	
	public $id;
	public $type;
	public $order;
	
	public $parent;
	
	public $class;
	
	public $content = array();
	public $options = array();
	
	
	function __construct() {
		$this->initialize();
	}
	
	public function initialize() {
		$this->generate_id();
	}
	
	
	function options() {
		$this->options =  array(
			'type'=>'base',
			'id' => $this->id,
			'content'=> $this->content,
		);
	}
	
	function set_options($array) {
		foreach ($array as $key => $value) {
			$this->$key = $value;
			
		}
		$this->options();
	}
	function duplicate($options) {
		$parent = $this->$parent_obj;
		
	}
	
	function add_content($content_obj) {
		$content_obj->options();
		$this->content[] = $content_obj->options;
		$this->options();
	}
	
	function generate_id() {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 6; $i++) {
		    $randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		$this->id = $randomString;
	}
	
	function generate_name($name) {
		return $this->id . '-' . $name;
	}
	
	function encode($value) {
		if(is_bool($value)){
			if($value){
				return 'TRUE';
			}else {
				return 'FALSE';
			}
		}elseif (is_array($value)) {
			return base64_encode(serialize($value));
		}else {
			return $value;
		}
	}
	
	function decode($value) {
		if($value == 'TRUE' || $value == 'FALSE'){
			if($value == 'TRUE'){
				return true;
			}else {
				return false;
			}
		}elseif( is_array(@unserialize( base64_decode($value) )) ){
			return unserialize( base64_decode($value) );
		}else {
			return $value;
		}
	}
	
	function input_hidden($parameter) {
		echo '<input type="hidden" name="c5ab-'. $this->generate_name($parameter) .'" id="c5ab-'. $this->generate_name($parameter) .'" value="'. $this->encode($this->$parameter) .'" />';
	}
	
	function html_classes() {
		return '';
	}
	
	
	function html_controls() {
		
	}
	
	function after_elements() {
		
	}
	function after_html() {
		
	}
	
	function sub_classes() {
		
	}
	
	
	function control_button($class, $title) {
		echo '<span class="' . $class. ' c5ab-sq-btn" title="'.$title.'"></span>';
	}
	
	function render() {
		
	}
	
	function html() {
		
		?> 
		<div class="c5ab-<?php echo $this->type; ?> c5ab-base ui-state-default clearfix <?php echo $this->html_classes(); ?>" data-id="<?php echo $this->id ?>" draggable="true">
			<div class="c5ab-<?php echo $this->type; ?>-wrap clearfix">
			<?php 
			
			 $this->html_controls();
		?>
		<div class="c5ab-container">
		<div class="c5ab-base-elements c5ab-<?php echo $this->type; ?>-base-elements <?php echo $this->sub_classes(); ?>">
		<?php
		foreach ($this->options as $key => $value) {
			if($key != 'id' && $key != 'content'){
				$this->input_hidden($key);
			}
		}
		if( isset($this->options['content']) &&  is_array($this->options['content'])	){
			foreach ($this->options['content'] as $key => $single) {
				$class_name = $this->get_class_name($single['type']);
				
				$obj = new $class_name();
				$obj->set_options($single);
				$obj->html();
			}
		}
		 ?> 
		 </div>
		 <?php $this->after_elements(); ?>
		 <div class="clearfix"></div>
		 </div>
		 </div> </div> <?php 
		 $this->after_html(); 
		 
	}
	
	function  get_class_name($type){
		switch ($type) {
			case 'row':
				return 'C5PB_ROW';
				break;
			case 'deck':
				return 'C5PB_DECK';
				break;
			case 'element':
				return 'C5PB_ELEMENT';
				break;
			case 'layout':
				return 'C5PB_LAYOUT';
				break;
		}
	}
	
	function  get_type_name(){
		switch ($this->type) {
			case 'row':
				return 'Row';
				break;
			case 'deck':
				return 'Deck';
				break;
			case 'element':
				return 'Element';
				break;
			case 'layout':
				return 'Layout';
				break;
		}
	}
	
	
	
	function display_setting( $args = array(), $instance= array() ) {
	      extract( $args );
	      
	      /* get current saved data */
	      //$options = get_option( $get_option, false );
	      
	      // Set field value
	      
	      $current_value =  isset($instance[$id]) ? $instance[$id] : '';
	      $id_tag =  $id;
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
		
	
} ?>