<?php 

class C5_theme_activation  {
	
	public $_sections =array();
	public $_options =array();
	
	function __construct() {
		
	}
	
	function hook() {
		
		add_action('admin_menu', array($this, 'hook_page'));
	}
	
	function hook_page() {
		
		add_submenu_page('tools.php','Crystal Import', 'Crystal Import', 'edit_pages', 'c5-demo-import', array($this, 'import_page'));
	}
	
	
	
	
	function all_demos() {
		
		$options = array(
			'main-demo' => array(
				'label'=>'Blog Style 1',
				'xml' => 'http://d.pr/f/1cUL1+',
				'theme-options' => 'http://d.pr/f/1kv5h+',
				'widgets' => 'http://d.pr/f/1cgiw+',
				'img' => 'http://d.pr/i/o4Wo+',
				'homepage' => 'Homepage Blog 1',
			),
			'dark' => array(
				'label'=>'Dark Demo',
				'xml' => 'http://d.pr/f/1cUL1+',
				'theme-options' => 'http://d.pr/f/13wmw+',
				'widgets' => 'http://d.pr/f/1cgiw+',
				'img' => 'http://d.pr/i/17p2o+',
				'homepage' => 'Homepage Blog 1',
			),
			'blog-2' => array(
				'label'=>'Blog Style 2',
				'xml' => 'http://d.pr/f/1cUL1+',
				'theme-options' => 'http://d.pr/f/18PqE+',
				'widgets' => 'http://d.pr/f/1cgiw+',
				'img' => 'http://d.pr/i/1kWfl+',
				'homepage' => 'Homepage Blog 2',
			),
			'grid-1' => array(
				'label'=>'Grid Style 1',
				'xml' => 'http://d.pr/f/1cUL1+',
				'theme-options' => 'http://d.pr/f/1bfZ1+',
				'widgets' => 'http://d.pr/f/1cgiw+',
				'img' => 'http://d.pr/i/HhK2+',
				'homepage' => 'Homepage Grid 1',
			),
			'grid-2' => array(
				'label'=>'Grid Style 2',
				'xml' => 'http://d.pr/f/1cUL1+',
				'theme-options' => 'http://d.pr/f/1hu2o+',
				'widgets' => 'http://d.pr/f/1cgiw+',
				'img' => 'http://d.pr/i/8ulX+',
				'homepage' => 'Homepage Grid 2',
			),
			'grid-3' => array(
				'label'=>'Grid Style 3',
				'xml' => 'http://d.pr/f/1cUL1+',
				'theme-options' => 'http://d.pr/f/15csi+',
				'widgets' => 'http://d.pr/f/1cgiw+',
				'img' => 'http://d.pr/i/1biYG+',
				'homepage' => 'Homepage Grid 3',
			),
			'shop' => array(
				'label'=>'Shop',
				'xml' => 'http://d.pr/f/1hE7o+',
				'theme-options' => 'http://d.pr/f/1kv5h+',
				'widgets' => 'http://d.pr/f/vVp9+',
				'img' => 'http://d.pr/i/16tpJ+',
				'homepage' => 'Homepage 1',
			),
			'ar' => array(
				'label'=>'Arabic Demo',
				'xml' => 'http://d.pr/f/1a8nX+',
				'theme-options' => 'http://d.pr/f/1aMGd+',
				'widgets' => 'http://d.pr/f/nExZ+',
				'img' => 'http://d.pr/i/12Lmh+',
				'homepage' => 'Homepage Blog 1',
			),
		
		);
		
		return $options;
		
	}
	
	
	function import_page() {
		?>
		<div class="wrap about-wrap">
			<h2>Crystal Import tool</h2>
			<div id="welcome-panel" class="c5-main-panel welcome-panel">
				<div class="quick-panel-flexslider c5-successfully">
					<div class="c5-quick-slide-wrap">
					<?php if (isset($_GET['activated'])) { ?>
						<h2 ><span class="fa fa-check-square-o"></span> Successfully Activated...</h2>
						<p class="about-description">Crystal Theme has been activated, Thank you for choosing Crystal, we recommend you to see the following resources for help.</p>
					<?php }else{ ?>
						<p>Thank you for choosing Crystal, we recommend you to see the following resources for help.</p>
					<?php } ?>
					</div>
					
					
					<div class="feature-section col three-col clearfix">
					
						<div class="col-1">
							<h4>Quick Setup</h4>
							<p>We grouped the most settings you might need to set in your initial setup, we recommend to install a demo first then start the quick setup process.</p>
							<a href="<?php echo admin_url('index.php?page=c5-quick-setup'); ?>" target="_blank" class="button button-primary button-large">Start Here</a>
						</div>
						
						<div class="col-2 ">
							<h4>Check Online Documentation</h4>
							<p>Check our online documentation for more updated on how to use your theme and make the best of it.</p>
							<a href="http://crystal.code-125.com/documentation/" target="_blank" class="button button-primary button-large">Check it here</a>
						</div>
						<div class="col-3 last-feature">
							<h4>Check Online Video Tutorials</h4>
							<p>Check our online video tutorials to make the best out of this product.</p>
							<a href="https://www.youtube.com/watch?v=MItqDK2RarM&list=PLoZkybG-SsuL9L2GycioDsLPddL7koUIk" target="_blank" class="button button-primary button-large">Check it here</a>
						</div>
						
					
					</div>
					
					
					<h2 class="c5-demo-heading">Choose one of the following demos to install</h2>
					
					<div class="feature-section col three-col clearfix">
						<?php 
						$counter = 1;
						foreach ($this->all_demos() as $id => $info) {
							$class = '';
							if ($counter == 3) {
								$class = ' last-feature ';
							}
							?>
								<div class="col-<?php echo $counter ?> <?php echo $class ?>">
									<div class="c5-import-signle">
										<h4><?php echo $info['label'] ?></h4>
										<div class="item-wrap">
											<div class="img-wrap">
												<img src="<?php echo $info['img'] ?>" alt="" />
											</div>
											<div class="buttons-wrap">
												<button class="button-primary button-large button c5-install-button " data-type="demo" data-demo="<?php echo $id ?>" >Install Complete Demo</button>
												<button class="button-primary button-large button c5-install-button" data-type="widget" data-demo="<?php echo $id ?>" >Install Only Widgets</button>
												<button class="button-primary button-large button c5-install-button" data-type="options" data-demo="<?php echo $id ?>" >Install Only Theme Options</button>
											</div>
										</div>
									</div>
								</div>
							<?php
							
							$counter++;
							if ($counter == 4) {
								$counter =1;
							}
						}
						
						 ?>
						
					
					</div>
					
				</div>
			</div>
		</div>
		<?php
		
		
	
	}
	
	
	/**
	 * The main controller for the import theme options.
	 *
	 * @param string $file Path to the text file for importing
	 */
	function import_theme_options($data_file) {
		$get_data = wp_remote_get( $data_file );
		
		if ( is_wp_error( $get_data ) )
		  return false;
		  
		$rawdata = isset( $get_data['body'] ) ? $get_data['body'] : '';
		$options = unserialize( ot_decode( $rawdata ) );
		
		/* get settings array */
		$settings = get_option( 'option_tree_settings' );
		
		/* has options */
		if ( is_array( $options ) ) {
		  
		  /* validate options */
		  if ( is_array( $settings ) ) {
		  
		    foreach( $settings['settings'] as $setting ) {
		    
		      if ( isset( $options[$setting['id']] ) ) {
		        
		        $content = ot_stripslashes( $options[$setting['id']] );
		        
		        $options[$setting['id']] = ot_validate_setting( $content, $setting['type'], $setting['id'] );
		        
		      }
		    
		    }
		  
		  }
		  
		  /* update the option tree array */
		  update_option( 'option_tree', $options );
		  
		}
	}
	
	
	function import_wp_options($data_file) {
		$get_data = wp_remote_get( $data_file );
		
		if ( is_wp_error( $get_data ) )
		  return false;
		  
		$rawdata = isset( $get_data['body'] ) ? $get_data['body'] : '';
		$options = unserialize( base64_decode( $rawdata ) );
		
		
		/* has options */
		if ( is_array( $options ) ) {
		  
		  
		    foreach( $options as $category => $info ) {
		    	$category_obj = get_category_by_slug( $category );
		    	$temp = explode('-', $category);
		    	$id =$temp[1]; 
		    	
		    	
		    	foreach ($info as $key => $value) {
		    		if($key == 'color'){
		    			$key = 'primary_color';
		    		}
		    		update_option('c5_term_meta_category_' . $id .'_' . $key , $value);
		    		if($key == 'primary_color'){
		    			update_option('c5_term_meta_category_' . $id .'_use_custom_colors' , 'on');
		    		}
		    	}
		  	}
		  
		  
		  
		}
	}
	
	function get_attachment_id_from_filename ($name) {
		global $wpdb;
		
		$query = "SELECT guid FROM {$wpdb->posts} WHERE guid LIKE '%{$name}%'";
		$id = $wpdb->get_var($query);
			
		return $id;
	}
    
	
}
$c5_import_demo = new C5_theme_activation();
$c5_import_demo->hook();
?>