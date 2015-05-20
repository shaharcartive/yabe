<?php 

class C5PB_LAYOUT extends C5PB_BASE {
	
	
	public $width = array(
		'lg'=> 12,
		'md'=> 12,
		'sm'=> 12,
		'xs'=> 12,
	);
	
	public $desktop;
	public $tablet;
	public $phone;
	
	function __construct() {
		
	}
	
	
	function set_width($width) {
		if(is_array($width)){
			$this->width = $width;
		}else {
			$this->width = array(
				'lg'=> $width,
				'md'=> $width,
				'sm'=> $width,
				'xs'=> $width,
			);
		}
	}
	
	function options() {
		$this->options =  array(
			'type'=>'layout',
			'id' => $this->id,
			'order'=>'',
			'parent'=> '',
			'content'=> $this->content,
			'desktop' => $this->desktop,
			'tablet' => $this->tablet,
			'phone' => $this->phone
		);
	}
	
	function get_css_class() {
		
	}
	
	function html_classes() {
		$class= '';
		$class .= ' c5ab_col_' . $this->desktop .'  c5ab_base_col ';
		
		return $class;
	}
	
	function sub_classes() {
		return ' c5ab-panel-rows-wrap ';
	}
	
	function html_controls() {
		
	}
	
	function after_html() {
		
	}
	
	function after_elements() {
		?>
		<div class="c5ab-add-element c5ab-base " >
			<div class="c5ab-widget-info">
					<span class="c5ab-add">+</span>
			</div>
		</div>
		<?php
	}
	
	function render() {
		?>
		<div class="c5ab-col-base c5ab-col-lg-<?php echo $this->desktop ?> c5ab-col-md-<?php echo $this->tablet ?> c5ab-col-sm-<?php echo $this->phone ?> ">
		<?php 
		$temp_width = $GLOBALS['c5_content_width'];
		$device = new C5AB_Mobile_Detect();
		
		$test_width = $GLOBALS['c5_content_margin'] + $GLOBALS['c5_content_width'];
		
		if(  $device->isMobile() && !$device->isTablet() ){
			$GLOBALS['c5_content_width'] = floor( $test_width *$this->phone/C5BP_col_count)- $GLOBALS['c5_content_margin'];
		}
		
		if(   $device->isTablet() ){
			$GLOBALS['c5_content_width'] = floor( $test_width*$this->tablet/C5BP_col_count )- $GLOBALS['c5_content_margin'];
		}
		
		if(  !$device->isMobile() ){
			$GLOBALS['c5_content_width'] = floor( $test_width*$this->desktop/C5BP_col_count )- $GLOBALS['c5_content_margin'];
		}
		
		if( isset($this->options['content']) &&  is_array($this->options['content'])	){
			foreach ($this->options['content'] as $key => $single) {
				$class_name = $this->get_class_name($single['type']);
				
				$obj = new $class_name();
				if(!is_array($single['content'])){
					if( is_array(@unserialize( base64_decode( $single['content']) )) ){
						$single['content'] = unserialize( base64_decode( $single['content']) );
					}
				}
				$obj->set_options($single);
				
				
				$obj->render();
			}
		}
		$GLOBALS['c5_content_width'] = $temp_width ;
		 ?>
		</div>
		<?php
	}
	
	function sample_layout() {
		$options =  array(
			'type'=>'layout',
			'id' => 'test-id',
			'order'=>'',
			'parent'=> '',
			'content'=> array(),
			'desktop' => 0,
			'tablet' => 2,
			'phone' => 12
		);
		$this->set_options($options);
		$this->html();
		
	}
}









 ?>