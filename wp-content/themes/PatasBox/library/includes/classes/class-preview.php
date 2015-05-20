<?php 
class C5_preview {
	function __construct() {
		
	}
	
	
	function hook() {
		
		
		add_action( 'wp_enqueue_scripts', array($this,'wp_enqueue_scripts' )  );
		add_action('wp_footer' ,  array($this,'footer_js' ));
		
	}
	function wp_enqueue_scripts() {
		$preview = ot_get_option('preview');
		if($preview != 'on'){
			return;
		}
		wp_register_script( 'iris-js', get_stylesheet_directory_uri() . '/library/js/libs/iris.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-widget' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-draggable' );
			
			 
		
		wp_enqueue_script( 'iris-js' );
	}
	
	function render() {
		$color = '';
		if(isset($_POST['c5-preview-color'])){
			$color = $_POST['c5-preview-color'];
		}
		$image_bg = '';
		if(isset($_POST['c5-image-bg'])){
			$image_bg = $_POST['c5-image-bg'];
		}
		$menu = '';
		if(isset($_POST['c5-menu-mode'])){
			$menu = $_POST['c5-menu-mode'];
		}
		
		?>
		<div class="c5-preview-wrap c5-hide clearfix">
			
		<form method="post"  id="c5-preview">
		 <label for="c5-preview-color">Choose Color</label>
		 <input type="text" name="c5-preview-color" id="c5-preview-color" value="<?php echo $color ?>" />
		 
		 <div class="layout-images">
		 <label for="c5-image-bg">See your image as a background</label>
		 	<input type="text" name="c5-image-bg" id="c5-image-bg" placeholder="Add your image link" value="<?php echo $image_bg ?>" />
		 </div>
		 
		 
		 <input type="submit" name="c5-submit-preview" id="c5-submit-preview" value="See Changes" />
		 </form>
		 <span class="fa fa-cog"></span>
		 </div>
		<?php
	}
	
	function footer_js() {
		$preview = ot_get_option('preview');
		if($preview != 'on'){
			return;
		}
		?>
		<script  type="text/javascript">
			jQuery(document).ready(function($) {
			    $('#c5-preview-color').iris({
			    	change: function(event, ui) {
			    	       $("#c5-preview-color").css( 'background', ui.color.toString());
			    	        $("#c5-preview-color").css( 'color', 'white');
			    	}
			    });
			    
			    $('.c5-img-layout').click(function () {
			    	$('.c5-img-layout').removeClass('selected');
			    	$(this).addClass('selected');
			    	$('#c5-image-bg').val($(this).attr('data-value'));
			    	
			    });
			    
			    $('.c5-menu-layout').click(function () {
			    	$('.c5-menu-layout').removeClass('selected');
			    	$(this).addClass('selected');
			    	$('#c5-menu-mode').val($(this).attr('data-value'));
			    });
			    
			    $('.c5-preview-wrap .fa-cog').click(function () {
			    	if( $('.c5-preview-wrap').hasClass('c5-show') ){
			    		$('.c5-preview-wrap').removeClass('c5-show');
			    	}else {
			    		$('.c5-preview-wrap').addClass('c5-show');
			    	}
			    });
			    
			    $('.c5-show-sidenav').click(function () {
			    	if( $('.c5-preview-wrap').hasClass('c5-show') ){
			    		$('.c5-preview-wrap').removeClass('c5-show');
			    	}else {
			    		$('.c5-preview-wrap').addClass('c5-show');
			    	}
			    });
			    
			    
			});
		</script>
		<?php
	}
}


$C5_preview_obj = new C5_preview();
$C5_preview_obj->hook();

 ?>