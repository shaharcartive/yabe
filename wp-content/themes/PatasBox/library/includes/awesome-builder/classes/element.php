<?php 

class C5PB_ELEMENT extends C5PB_BASE {
	
	public $animation = '';
	public $desktop = 'TRUE';
	public $tablet = 'TRUE';
	public $mobile = 'TRUE';
	public $widget_class = '';
	public $animation_delay = '0';
	public $animation_duration = '1000';
	public $helper_text;
	
	
	function options() {
		$this->options =  array(
			'type' => 'element',
			'id' => $this->id,
			'order'=> '',
			'parent'=> '',
			'helper_text' =>$this->helper_text,
			'widget_class' => $this->widget_class,
			'content' => $this->content,
			'animation' => $this->animation,
			'animation_delay' => $this->animation_delay,
			'animation_duration' => $this->animation_duration,
			'desktop' => $this->desktop,
			'tablet' => $this->tablet,
			'mobile' => $this->mobile,
		);
	}
	
	function render() {
		$device = new C5AB_Mobile_Detect();
		
		if( ( $this->mobile == 'FALSE') && $device->isMobile() && !$device->isTablet()){
			return;
		}
		
		if( ( $this->tablet == 'FALSE') && $device->isTablet()){
			return;
		}
		
		if( ( $this->desktop == 'FALSE') && !$device->isMobile()){
			return;
		}
		
		
		if ( !class_exists( $this->widget_class ) ) return;
		
		$the_widget = new $this->widget_class;
		
		$classes = array(  'c5ab-widget' );
		if ( !empty( $the_widget->id_base ) ){
			$classes[] = 'widget_' . $the_widget->id_base;
		}
		
		$classes[] = 'c5ab-desktop-' . $this->desktop;
		$classes[] = 'c5ab-tablet-' . $this->tablet;
		$classes[] = 'c5ab-mobile-' . $this->mobile;
		
		$animation_tag = '';
		if($this->animation!='no' && $this->animation!=''){
			//$animation_tag = 'c5ab-animation-data="'.$this->animation.'"';
			$classes[] = 'wow ' . $this->animation;
			$delay = 'data-wow-delay="'.$this->animation_delay.'ms"';
			$duration = 'data-wow-duration="'.$this->animation_duration.'ms"';
			$animation_tag = $delay .' ' . $duration;
		}
		
		$the_widget->widget( array(
			'before_widget' => '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" id="c5ab-widget-'.$this->id.'" '.$animation_tag.'>',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'widget-'
		), $this->content );
		
	}
	
	function html_classes() {
		return '';
	}
	
	function html_controls() {
		echo '';
	}
	
	function element_form() {
		if ( !class_exists( $this->widget_class ) ) return;
		
		$the_widget = new $this->widget_class;
		$the_widget->number = $this->id;
		
		 echo $the_widget->form($this->content);
	}
	
	function html() {
		if ( !class_exists( $this->widget_class ) ) return;
		
		$the_widget = new $this->widget_class;
		?>
		<div class="c5ab-element ui-state-default c5ab-base <?php echo $this->html_classes(); ?>"  draggable="true" data-id="<?php echo $this->id; ?>">
			<div class="c5ab-widget-info">
			<?php 
			
			$this->html_controls();
			
			foreach ($this->options as $key => $value) {
				$this->input_hidden($key);
			}
			 ?>
			<h4><?php $this->control_button('c5abf-duplicate' , __('Duplicate', 'c5ab'));
			 ?><?php echo $the_widget->name; ?><?php $this->control_button('c5abf-trash' , __('Delete', 'c5ab')); ?><span class="c5ab-helper-text"><?php echo $this->helper_text; ?></span></h4>
			
			<?php // echo $the_widget->form($this->content); ?>
			</div>
		</div>
		<?php
	}
	
	function sample_layout() {
		$options =  array(
			'type' => 'element',
			'id' => 'test-id',
			'order'=>'',
			'parent'=> '',
			'helper_text'=>'',
			'widget_class' => '',
			'content' => array(),
			'animation' => 'no',
			'animation_delay' => '0',
			'animation_duration' => '1000',
			'desktop' => 'TRUE',
			'tablet' => 'TRUE',
			'mobile' => 'TRUE',
		);
		$this->set_options($options);
		$this->html();
		
	}
	
	
	function get_animation_elements() {
		$animation_array = array(
			array(
				'class' => 'no',
				'title' => __('No Animation' , 'c5ab'),
			),
			array(
				'class' => 'flipInX',
				'title' => __('Flip In Horizontally' , 'c5ab'),
			),
			array(
				'class' => 'flipInX',
				'title' => __('Flip In Vertically' , 'c5ab'),
			),
			array(
				'class' => 'fadeIn',
				'title' => __('Fade In' , 'c5ab'),
			),
			array(
				'class' => 'fadeInUp',
				'title' => __('Fade In Up' , 'c5ab'),
			),
			array(
				'class' => 'fadeInDown',
				'title' => __('Fade In Down' , 'c5ab'),
			),
			array(
				'class' => 'fadeInLeft',
				'title' => __('Fade In Left' , 'c5ab'),
			),
			array(
				'class' => 'fadeInRight',
				'title' => __('Fade In Right' , 'c5ab'),
			),
			array(
				'class' => 'fadeInUpBig',
				'title' => __('Fade In Up Big' , 'c5ab'),
			),
			array(
				'class' => 'fadeInDownBig',
				'title' => __('Fade In Down Big' , 'c5ab'),
			),
			array(
				'class' => 'fadeInLeftBig',
				'title' => __('Fade In Left Big' , 'c5ab'),
			),
			array(
				'class' => 'fadeInRightBig',
				'title' => __('Fade In Right Big' , 'c5ab'),
			),
			
			array(
				'class' => 'slideInDown',
				'title' => __('Slide In Down' , 'c5ab'),
			),
			array(
				'class' => 'slideInLeft',
				'title' => __('Slide In Left' , 'c5ab'),
			),
			array(
				'class' => 'slideInRight',
				'title' => __('Slide In Right' , 'c5ab'),
			),
			
			array(
				'class' => 'bounceIn',
				'title' => __('Bounce In' , 'c5ab'),
			),
			array(
				'class' => 'bounceInDown',
				'title' => __('Bounce In Down' , 'c5ab'),
			),
			array(
				'class' => 'bounceInUp',
				'title' => __('Bounce In Up' , 'c5ab'),
			),
			array(
				'class' => 'bounceInLeft',
				'title' => __('Bounce In Left' , 'c5ab'),
			),
			array(
				'class' => 'bounceInRight',
				'title' => __('Bounce In Right' , 'c5ab'),
			),
			
			array(
				'class' => 'rotateIn',
				'title' => __('Rotate In' , 'c5ab'),
			),
			array(
				'class' => 'rotateInDownLeft',
				'title' => __('Rotate In Down Left' , 'c5ab'),
			),
			array(
				'class' => 'rotateInDownRight',
				'title' => __('Rotate In Down Right' , 'c5ab'),
			),
			array(
				'class' => 'rotateInUpLeft',
				'title' => __('Rotate In Up Left' , 'c5ab'),
			),
			array(
				'class' => 'rotateInUpRight',
				'title' => __('Rotate In Up Right' , 'c5ab'),
			),
		
		);
		
		return $animation_array;
	}
	
	function edit_widget_layout() {
		if(class_exists( $this->widget_class )){
			$widget_obj = new $this->widget_class;
		}else {
			return '';
		}
		$id_tag = $widget_obj->get_field_id($this->id);
		 ?>
		 
		<form method="post" action="" id="c5ab-widget-form">
		 <div class="c5ab-widget-header clearfix"><h4><?php echo $widget_obj->name ?></h4>
		 	<div class="c5ab-animation-preview-wrap">
		 		<div class="c5ab-animation-preview animated">
		 			<?php _e('Click on animation and see me.', 'c5ab') ?>
		 		</div>
		 	</div>
		 </div>
		 <div class="c5ab-header-screens">
		 	<span class="c5ab-screen-control c5ab-close-screen " title="<?php _e('Close' , 'c5ab') ?>">x</span>
		 	<?php 
		 	
		 	$view_array = array(
		 		array(
		 			'id' => 'desktop',
		 			'icon' => 'laptop',
		 			'title' => __('Show/Hide on Desktop','c5ab')
		 		),
		 		array(
		 			'id' => 'tablet',
		 			'icon' => 'tablet',
		 			'title' => __('Show/Hide on Tablet','c5ab')
		 		),
		 		array(
		 			'id' => 'mobile',
		 			'icon' => 'mobile',
		 			'title' => __('Show/Hide on Mobile','c5ab')
		 		)
		 	);
		 	foreach ($view_array as $info) {
		 	?>
		 		<input type="hidden" name="<?php echo $info['id'] ?>" id="<?php echo $info['id'] ?>" value="<?php echo $_POST[ $info['id'] ] ?>" />
		 		<span class="c5ab-screen-control <?php echo $_POST[ $info['id'] ] ?> c5abf-<?php echo $info['icon'] ?>" title="<?php echo $info['title'] ?>"></span>
		 	<?php
		 	}
		 	 ?>
		 	 
		 	<span class="c5ab-animation-text"><?php _e('Animation','c5ab');  ?></span>
		 		
		 </div>
		
		
		<input type="hidden" name="id_base" value="<?php echo $widget_obj->id_base ?>" />
		<input type="hidden" name="widget-id" value="<?php echo $widget_obj->id_base ?>-<?php echo $this->id ?>" />
		
		<div class="c5ab-animation-container c5ab-animation-container-wrap clearfix">
		<input type="hidden" name="c5ab-animation" id="c5ab-animation" value="<?php echo $this->animation ?>" />
		<div class="c5ab-animation-info">
			<div class="c5ab-animation-container clearfix">
				<div class="c5ab-animation-info">
					<label for="c5ab-animation-duration"><?php _e('Animation Duration (micro Second):', 'c5ab') ?></label>
				</div>
				<div class="c5ab-animation-info">
					<input type="text" name="c5ab-animation-duration" id="c5ab-animation_duration" value="<?php echo $this->animation_duration ?>" />
				</div>
			</div>	
		</div>
		<div class="c5ab-animation-info">
			<div class="c5ab-animation-container clearfix">
				<div class="c5ab-animation-info">
					<label for="c5ab-animation-delay"><?php _e('Animation Delay (micro Second):', 'c5ab') ?></label>
				</div>
				<div class="c5ab-animation-info">
					<input type="text" name="c5ab-animation-delay" id="c5ab-animation_delay" value="<?php echo $this->animation_delay ?>" />
				</div>
			</div>	
		</div>
		<?php 
		$animation_array = $this->get_animation_elements();
		foreach ($animation_array as $key => $info) {
			$class = '';
			if($this->animation == $info['class']){
				$class = 'selected'; 
			}
			?>
			<div class="c5ab-animation-single">
				<div class=" c5ab-animation-wrap <?php echo $class ?>" data-animation="<?php echo $info['class'] ?>"><?php echo $info['title'] ?></div>
			</div>
			<?php
		}
		 ?>
		 </div>
		<?php
		$this->element_form();
		?>
		</form>
		<div class="c5ab-actions">
		<span class="c5ab-btn c5ab-save-widget-data" data-id="<?php echo $this->id ?>"><?php _e('Save Changes', 'c5ab') ?></span>
		</div>
		<?php
		
	}
}
 ?>