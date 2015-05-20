<?php 
class C5PB_ROW extends C5PB_BASE {
	
	public $actions =array(
		'add',
		'edit',
		'delete',
		'duplicate',
	);
	public $row_settings = array();
	
	public $margin = 30;
	public $full_width = false;
	public $background = array();
	public $bg_mode = 'light';
	public $settings = array(
			'margin'=>30,
			'full_width' => 'off',
			'align' => 'left',
			'video_background_mp4'=>'',
			'video_background_ogg'=>'',
			'video_background_webm'=>'',
			'desktop'=>'TRUE',
			'tablet'=>'TRUE',
			'mobile'=>'TRUE',
		);
	
	function __construct() {
		
	}
	
	function options() {
		$this->options =  array(
			'type'=>'row',
			'id' => $this->id,
			'order'=>'',
			'parent'=> '',
			'content' =>$this->content,
			'settings' => $this->settings,
		);
	}
	
	function sample_layout() {
		$options =  array(
			'type'=>'row',
			'id' => 'test-id',
			'order'=>'',
			'parent'=> '',
			'content'=> array(),
			'settings' => array(
				'margin'=>30,
				'full_width' => 'off',
				'align' => 'left',
				'desktop'=>'TRUE',
				'tablet'=>'TRUE',
				'mobile'=>'TRUE',
			),
		);
		$this->set_options($options);
		$this->html();
		
	}
	
	function settings_parametars() {
		$row_align = array(
			'left',
			'center',
			'right',
		);
		$row_align_array = array();
		foreach ($row_align as $value) {
			$row_align_array[] = array(
			    'src' => C5BP_uri.'image/'.$value.'.png',
			    'label' => '',
			    'value' => $value
			);
		}
		
		$this->row_settings = array(
			array(
			    'label' => __('Custom Class', 'c5ab'),
			    'id' => 'custom_class',
			    'type' => 'text',
			    'desc' => __('Add Custom Class to this row .', 'c5ab') ,
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => __('Full Width', 'c5ab'),
			    'id' => 'full_width',
			    'type' => 'on_off',
			    'desc' => __('Choose whether to Open Full Width or No .', 'c5ab') ,
			    'std' => 'off',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => __('Row Width', 'c5ab'),
			    'id' => 'row_width',
			    'type' => 'select',
			    'desc' => __('Choose whether to follow the width you added in settings or add a custom width.', 'c5ab') ,
			    'choices' => array( 
			    		array(
			    		  'value'   => 'default',
			    		  'label'   => __( 'Default Width', 'c5ab' ),
			    		),
			    		array(
			    		  'value'   => 'custom',
			    		  'label'   => __( 'Custom Width "Below"', 'c5ab' ),
			    		)
			    ),
			    'std' => 'default',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => __('Custom Row width', 'c5ab'),
			    'id' => 'custom_width',
			    'type' => 'numeric-slider',
			    'desc' => __('Add the custom width you want for that row.', 'c5ab'),
			    'std' => '1170',
			    'min_max_step' => '500,2000,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			
			array(
			  'label'       => __('Text and Blocks Alignment', 'c5ab'),
			  'id'          => 'align',
			  'type'        => 'radio-image',
			  'desc'        => 'Choose Text and Blocks Alignment',
			  'choices' => $row_align_array,
			  'std'         => 'left',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => ''
			),
			array(
			    'label' => __('Columns margin', 'c5ab'),
			    'id' => 'margin',
			    'type' => 'numeric-slider',
			    'desc' => __('Add columns margin in pixels, Default is 30.', 'c5ab'),
			    'std' => '30',
			    'min_max_step' => '0,200,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			  'label'       => __('Video Background mp4', 'c5ab'),
			  'id'          => 'video_background_mp4',
			  'type'        => 'upload',
			  'desc'        => __('Add Video background (mp4 format) for this row.', 'c5ab'),
			  'std'         => '',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => ''
			),
			array(
			  'label'       => __('Video Background ogg', 'c5ab'),
			  'id'          => 'video_background_ogg',
			  'type'        => 'upload',
			  'desc'        => __('Add Video background for (ogg format) this row.', 'c5ab'),
			  'std'         => '',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => ''
			),
			array(
			  'label'       => __('Video Background webm', 'c5ab'),
			  'id'          => 'video_background_webm',
			  'type'        => 'upload',
			  'desc'        => __('Add Video background for (webm format) this row.', 'c5ab'),
			  'std'         => '',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => ''
			),
			array(
			  'label'       => __('Background', 'c5ab'),
			  'id'          => 'background',
			  'type'        => 'background',
			  'desc'        => __('Add background for this row.', 'c5ab'),
			  'std'         => '',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => ''
			),
			array(
			    'label' => __('Background Mode', 'c5ab'),
			    'id' => 'bg_mode',
			    'type' => 'select',
			    'desc' => __('Choose Background Mode, Light or Dark .', 'c5ab') ,
			    'choices' => array(
			        array(
			            'label' => 'Light',
			            'value' => 'light-mode'
			        ),
			        array(
			            'label' => 'Dark',
			            'value' => 'dark-mode'
			        )
			    ),
			    'std' => 'light-mode',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => __('Row margin top', 'c5ab'),
			    'id' => 'row_margin_top',
			    'type' => 'numeric-slider',
			    'desc' => __('Add Row margin-top in pixels, Default is 0px.', 'c5ab'),
			    'std' => '0',
			    'min_max_step' => '0,300,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => __('Row margin bottom', 'c5ab'),
			    'id' => 'row_margin_bottom',
			    'type' => 'numeric-slider',
			    'desc' => __('Add Row margin-bottom in pixels, Default is 0px.', 'c5ab'),
			    'std' => '0',
			    'min_max_step' => '0,300,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => __('Row Padding top', 'c5ab'),
			    'id' => 'row_padding_top',
			    'type' => 'numeric-slider',
			    'desc' => __('Add Row Padding-top in pixels, Default is 0px.', 'c5ab'),
			    'std' => '0',
			    'min_max_step' => '0,300,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => __('Row Padding bottom', 'c5ab'),
			    'id' => 'row_padding_bottom',
			    'type' => 'numeric-slider',
			    'desc' => __('Add Row Padding-bottom in pixels, Default is 0px.', 'c5ab'),
			    'std' => '0',
			    'min_max_step' => '0,300,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),		
		);
	
	}
	
	
	function edit_options_panel() {
		?>
		<form method="post" action="" id="c5ab-row-form">
		 <div class="c5ab-widget-header clearfix">
		 	<h4><?php _e('Row Settings','c5ab') ?></h4>
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
		 		if(!isset($this->settings[  $info['id'] ] )){
		 			$value  = 'TRUE';
		 		}else {
	 				$value = $this->settings[  $info['id'] ] ;
	 			}
		 	
		 	?>
		 		<input type="hidden" name="<?php echo $info['id'] ?>" id="<?php echo $info['id'] ?>" value="<?php echo $value ?>" />
		 		<span class="c5ab-screen-control <?php echo $value ?> c5abf-<?php echo $info['icon'] ?>" title="<?php echo $info['title'] ?>"></span>
		 	<?php
		 	}
		 	 ?>
		 	 
		 		
		 </div>
		
		<?php
		$this->settings_parametars();
		foreach ($this->row_settings as $key => $value) {
			$this->display_setting($value, $this->settings);
		}
		
		echo '<script  type="text/javascript"> OT_UI.init();</script>';
		?>
		</form>
		<div class="c5ab-actions">
		<span class="c5ab-btn c5ab-save-row-data" data-id="<?php echo $this->id ?>"><?php _e('Save Changes', 'c5ab') ?></span>
		</div>
		<?php
	}
	
	function html_classes() {
		$class= ' row ';
		
		return $class;
	}
	
	function format_background($array) {
		$data = '';
		if($array['background-color']!=''){
			$data .= 'background-color:'. $array['background-color'] .';';
		}
		if($array['background-position']!=''){
			$data .= 'background-position:'. $array['background-position'] .';';
		}
		if($array['background-repeat']!=''){
			$data .= 'background-repeat:'. $array['background-repeat'] .';';
		}
		if($array['background-attachment']!=''){
			$data .= 'background-attachment:'. $array['background-attachment'] .';';
		}
		if($array['background-image']!=''){
			$data .= 'background-image:url(\''. $array['background-image'] .'\');';
		}
		return $data;
	
	}
	
	function validate_settings() {
		
		$this->settings_parametars();
		
		foreach ($this->row_settings as  $value) {
			if(!isset($this->settings[ $value['id'] ])){
				$this->settings[ $value['id'] ] =  $value['std'];
			}
		}
		
		$new_array = array('mobile' , 'tablet', 'desktop');
		foreach ($new_array as  $value) {
			if(!isset($this->settings[ $value ])){
				$this->settings[ $value ] =  'TRUE';
			}
		}
	
	}
	
	function render_bg_video() {
		
		if($this->settings['video_background_mp4'] !='' || $this->settings['video_background_ogg'] !='' || $this->settings['video_background_webm'] !='' ){
		?>
		<div class="c5ab_video_background clearfix">
			<video id="video_background" preload="auto" autoplay="autoplay" loop="loop" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; z-index: 0; width: 100%;">
				<?php 
				if($this->settings['video_background_mp4'] !='' ){
					echo '<source src="'.$this->settings['video_background_mp4'].'" type="video/mp4">';
				}
				if($this->settings['video_background_ogg'] !='' ){
				 	echo '<source src="'.$this->settings['video_background_ogg'].'" type="video/ogg">';
				}
				if($this->settings['video_background_webm'] !='' ){
				  	echo '<source src="'.$this->settings['video_background_webm'].'" type="video/webm">';
				}
				?>
			</video>
		
		</div>
		<?php
		}
		
	}
	
	function render() {
		
		
		$this->validate_settings();
		$device = new C5AB_Mobile_Detect();
		
		if( ( $this->settings['mobile'] == 'FALSE') && $device->isMobile() && !$device->isTablet()){
			return;
		}
		
		if( ( $this->settings['tablet'] == 'FALSE') && $device->isTablet()){
			return;
		}
		
		if( ( $this->settings['desktop'] == 'FALSE') && !$device->isMobile()){
			return;
		}
		
		if($this->parent == '0'){
		?>
		<style scoped>
			#c5ab-row-<?php echo $this->id ?>,
			#c5ab-row-<?php echo $this->id ?> .c5ab-row{
				margin-left:-<?php echo $this->settings['margin']/2; ?>px;
				margin-right:-<?php echo $this->settings['margin']/2; ?>px;
			}
			
			#c5ab-row-<?php echo $this->id ?> .c5ab-col-base{
				padding-left: <?php echo $this->settings['margin']/2; ?>px;
				padding-right: <?php echo $this->settings['margin']/2; ?>px;
			}
			#c5ab-section-<?php echo $this->id ?>{
				<?php echo $this->format_background(unserialize(base64_decode($this->settings['background']))); ?>
			
				margin-top: <?php echo $this->settings['row_margin_top']  ?>px;
				margin-bottom: <?php echo $this->settings['row_margin_bottom']  ?>px;
				padding-top: <?php echo $this->settings['row_padding_top']  ?>px;
				padding-bottom: <?php echo $this->settings['row_padding_bottom']  ?>px;
			}
			
		</style>
		<?php } 
		$GLOBALS['c5_content_margin']  = $this->settings['margin'];
		
		
		 
		 $classes = array();
		 $classes[] = 'c5ab-desktop-' . $this->settings['desktop'];
		 $classes[] = 'c5ab-tablet-' . $this->settings['tablet'];
		 $classes[] = 'c5ab-mobile-' . $this->settings['mobile'];
		 
		 if($this->settings['video_background_mp4'] !='' || $this->settings['video_background_ogg'] !='' || $this->settings['video_background_webm'] !='' ){
		 	$classes[] = 'c5ab-have-videobackground';
		 }
		 
		 $classes[] = $this->settings['custom_class'];
		  ?>
		 
		 
			<div id="c5ab-section-<?php echo $this->id ?>" class="c5ab-<?php echo $this->settings['bg_mode'] ?> c5ab-section-common c5ab-align-<?php echo $this->settings['align'] ?> <?php echo implode( ' ', $classes); ?>  clearfix">
			<?php 
			
			$this->render_bg_video();
			 ?>
		
			<?php if($this->settings['full_width'] != 'on'){
				if($this->settings['row_width'] == 'custom'){
					$max_width = $this->settings['custom_width'];
				}else {
//					$max_width = c5ab_get_option('content_width');
					$max_width = c5_get_page_width();
					global $c5_skip_page_width;
					if(is_bool($c5_skip_page_width)){
						if($c5_skip_page_width){
							$max_width = 2000;
						}
					}
					
				}
				if(!isset($GLOBALS['c5_content_width'])){
					$GLOBALS['c5_content_width'] = $max_width;
				}
			 ?>
				<div class="c5ab-center-content" style="max-width:<?php echo $max_width; ?>px">
			<?php } ?>
		
		<div class="c5ab-row clearfix" id="c5ab-row-<?php echo $this->id ?>">
		<?php 
		if(!isset($GLOBALS['c5_content_width'])){
			$GLOBALS['c5_content_width'] = c5ab_get_option('content_width');
		}
		
		$device_responsive = new C5AB_Mobile_Detect();
		if( $device_responsive->isTablet() ){
			$GLOBALS['c5_content_width'] = 645;
		}
		
		if( $device_responsive->isMobile() && !$device_responsive->isTablet() ) {
			$GLOBALS['c5_content_width'] = 300;
		}
		
		if( isset($this->options['content']) &&  is_array($this->options['content'])	){
			foreach ($this->options['content'] as $key => $single) {
				$class_name = $this->get_class_name($single['type']);
				
				$obj = new $class_name();
				$obj->set_options($single);
				$obj->render();
			}
		}
		 ?>
		</div>
		
		<?php if($this->settings['full_width'] != 'on'){ ?>
				</div>
			<?php }  ?>
			
			</div>
		<?php  
		
	}
	function html_controls() {
		?>
		
		
		
		<div class="c5ab-sub-row-controls">
			<?php 
			$this->control_button('c5abf-duplicate' , __('Duplicate', 'c5ab'));
			$this->control_button('c5abf-trash' , __('Delete', 'c5ab'));
			$this->control_button('c5abf-drag' , __('Move', 'c5ab'));
			 ?>
		</div>
		<div class="c5ab-row-controls">
			<div class="controls-left">
				<?php 
				$this->control_button('c5abf-up-open' , __('Move Up', 'c5ab'));
				$this->control_button('c5abf-drag' , __('Move', 'c5ab'));
				$this->control_button('c5abf-down-open' , __('Move Down', 'c5ab'));
				?><!--
				<span class="c5ab-move-up c5ab-sq-btn c5abf-up-open "></span>
				<span class="c5ab-move c5ab-sq-btn c5abf-drag "></span>
				<span class="c5ab-move-down c5ab-sq-btn c5abf-down-open "></span>-->
			</div>
			<div class="controls-right">
				<?php 
				$this->control_button('c5abf-cog' , __('Edit Settings', 'c5ab'));
				$this->control_button('c5abf-duplicate' , __('Duplicate', 'c5ab'));
				$this->control_button('c5abf-trash' , __('Delete', 'c5ab'));
				?>
				<!--<span class="c5ab-settings c5ab-sq-btn c5abf-cog "></span>
				<span class="c5ab-duplicate c5ab-sq-btn c5abf-duplicate "></span>
				<span class="c5ab-delete c5ab-sq-btn c5abf-trash "></span>-->
			</div>
		</div>
		
		<div class="clearfix"></div>
		<?php
	}
	
	
	
	
}
 ?>