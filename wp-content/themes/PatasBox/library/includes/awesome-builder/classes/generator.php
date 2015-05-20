<?php 

class C5PB_GENERATOR {
	
	function __construct() {
		add_filter('widget_text', 'do_shortcode');
		
		add_action('media_buttons', array($this , 'button'), 100);
	}
	
	function button($page = null, $target = null) {
	
		echo '<span class="c5ab_launch_generator button" title="' . __('Insert shortcode', 'c5ab') . '" data-page="' . $page . '" data-target="' . $target . '">[ ] '.__('Insert shortcode', 'c5ab').'</span>';
	
	}
	
	
}


$obj = new C5PB_GENERATOR();








 ?>