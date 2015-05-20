<?php 

class C5AB_ads extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'ads-widget';
		$this->_shortcode_name = 'c5ab_ads';
		$name = 'Advertisement Box';
		$desc = 'Advertisement Box with various sizes.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		$device = new C5AB_Mobile_Detect();
		
		
		
		if( ( $atts['mobile'] == 'off') && $device->isMobile() && !$device->isTablet()){
			return;
		}
		
		if( (  $atts['tablet'] == 'off') && $device->isTablet()){
			return;
		}
		
		if( (  $atts['desktop'] == 'off') && !$device->isMobile()){
			return;
		}
		
		
		$data = '<div class="c5ab_ads c5ab-desktop-'.$atts['desktop'].'  c5ab-tablet-'.$atts['tablet'].'  c5ab-mobile-'.$atts['mobile'].' '.$atts['size'].'">'.html_entity_decode( do_shortcode($content)).'</div>';
		
		$size_temp = explode('_', $atts['size']);
		$size =  explode('x', $size_temp[1]);
		$data .='<style>.'.$atts['size'].'{
			display:block;
			margin:0px auto 30px;
			width:'.$size[0].'px;
			height:'.$size[1].'px;
			}</style>';
		
		return $data;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			
			array(
			    'label' =>'Advertisement Size',
			    'id' => 'size',
			    'type' => 'select',
			    'desc' => 'Choose Advertisement Size.',
			    'choices' => array(
			       array(
			            'label' => '320 x 50 mobile',
			            'value' => 'ads_320x50'
			        ),
			       array(
			            'label' => '468 x 60 Full Banner',
			            'value' => 'ads_468x60'
			        ),
			        array(
			            'label' => '728 x 90 Leaderboard',
			            'value' => 'ads_728x90'
			        ),
			        array(
			            'label' => '336 x 280 Square',
			            'value' => 'ads_336x280'
			        ),
			        array(
			            'label' => '300 x 250 Square',
			            'value' => 'ads_300x250'
			        ),
			        array(
			            'label' => '250 x 250 Square',
			            'value' => 'ads_250x250'
			        ),
			        array(
			            'label' => '160 x 600 Skyscraper',
			            'value' => 'ads_160x600'
			        ),
			        array(
			            'label' => '120 x 600 Skyscraper',
			            'value' => 'ads_120x600'
			        ),
			        array(
			            'label' => '120 x 240 Small Skyscraper',
			            'value' => 'ads_120x240'
			        ),
			        array(
			            'label' => '240 x 400 Fat Skyscraper',
			            'value' => 'ads_240x400'
			        ),
			        array(
			            'label' => '234 x 60 Half Banner',
			            'value' => 'ads_234x60'
			        ),
			        array(
			            'label' => '180 x 150 Rectangle',
			            'value' => 'ads_180x150'
			        ),
			        array(
			            'label' => '125 x 125 Square Button',
			            'value' => 'ads_125x125'
			        ),
			        array(
			            'label' => '120 x 90 Button',
			            'value' => 'ads_120x90'
			        ),
			        array(
			            'label' => '120 x 60 Button',
			            'value' => 'ads_120x60'
			        ),
			        array(
			            'label' => '88 x 31	Button',
			            'value' => 'ads_88x31'
			        )
			    ),
			    'std' => 'ads_300x250',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Show on Mobile',
			    'id' => 'mobile',
			    'type' => 'on_off',
			    'desc' => 'Show Advertisement on Mobile',
			    'std' => 'on',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Show on Tablet',
			    'id' => 'tablet',
			    'type' => 'on_off',
			    'desc' => 'Show Advertisement on Tablet',
			    'std' => 'on',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Show on Desktop',
			    'id' => 'desktop',
			    'type' => 'on_off',
			    'desc' => 'Show Advertisement on Desktop',
			    'std' => 'on',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Content',
			    'id' => 'content',
			    'type' => 'textarea-simple',
			    'desc' => 'Advertisement content "HTML ALLOWED"',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		 
		);
	}
	
	

}


 ?>