<?php 

class C5AB_audio extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'audio-widget';
		$this->_shortcode_name = 'c5ab_audio';
		$name = 'Audio';
		$desc = 'Embed a Audio file "Sound Cloud or HTML5 Audio".';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		add_shortcode('c5ab_soundcloud', array($this , 'soundcloud'));
		wp_oembed_add_provider('#https?://(?:api\.)?soundcloud\.com/.*#i', 'http://soundcloud.com/oembed', true);
		
	}
	
	function get_id($url) {
		if (strpos($url, 'soundcloud.com') !== false) {
		    $url = "https://soundcloud.com/oembed?url=" . $url . "&format=json";
		   	$xml = file_get_contents($url);
		    $array = json_decode($xml, true); // decode json
		    $id_sound = '';
		    foreach ($array as $attribute => $ttt) {
		        if ($attribute == 'html') {
		            $split_1 = explode("url=https", $ttt);
		            $split_2 = explode("%", $split_1[1]);
		            $rrrr = explode("&show_artwork=true", $split_2[5]);
		            $id_sound = substr($rrrr[0], 2);
		        }
		    }
		    return array('soundcloud' ,  $id_sound);
		  }else {
		  	return array( 'html5' , $url);
		  }
	}
	
	
	function shortcode($atts,$content) {
		$return_data = $this->get_id( $atts['url'] );
		    $id = $return_data[1];
		    $type = $return_data[0];
		
			if($type == 'soundcloud'){
				return do_shortcode('[c5ab_soundcloud url="https://api.soundcloud.com/tracks/'.$id.'" params="color=ff6600&auto_play=false&show_artwork=true" width="100%" height="166" iframe="true" /]');
			}elseif ($type == 'html5') {
				return '<audio class="c5ab-audio" src="' . $id . '" preload="true" loop="false" controls="true" autobuffer ></audio>';
			}
			return '';        
	}
	
	function add_oembed_soundcloud(){
		wp_oembed_add_provider( 'http://soundcloud.com/*', 'http://soundcloud.com/oembed' );
	}
	
	
	
	function custom_css() {
		
	}
	
	function options() {
		
		$this->_options =array(
			array(
			    'label' => 'Audio URL',
			    'id' => 'url',
			    'type' => 'text',
			    'desc' => 'Add Audio URL ... you can add a Soundcloud URL and it will be automaticlly detected, or you can add external audio url and it will be added to a player.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		);
	}
	
	
	/**
	 * SoundCloud shortcode handler
	 * @param  {string|array}  $atts     The attributes passed to the shortcode like [soundcloud attr1="value" /].
	 *                                   Is an empty string when no arguments are given.
	 * @param  {string}        $content  The content between non-self closing [soundcloud]…[/soundcloud] tags.
	 * @return {string}                  Widget embed code HTML
	 */
	function soundcloud($atts, $content = null) {
	
	    // Custom shortcode options
	    $shortcode_options = array_merge(array('url' => trim($content)), is_array($atts) ? $atts : array());
	
	    // Turn shortcode option "param" (param=value&param2=value) into array
	    $shortcode_params = array();
	    if (isset($shortcode_options['params'])) {
	        parse_str(html_entity_decode($shortcode_options['params']), $shortcode_params);
	    }
	    $shortcode_options['params'] = $shortcode_params;
	
	    // User preference options
	    $plugin_options = array_filter(array(
	        'iframe' => $this->soundcloud_get_option('player_iframe', true),
	        'width' => $this->soundcloud_get_option('player_width'),
	        'height' => $this->soundcloud_url_has_tracklist($shortcode_options['url']) ? $this->soundcloud_get_option('player_height_multi') : $this->soundcloud_get_option('player_height'),
	        'params' => array_filter(array(
	            'auto_play' => $this->soundcloud_get_option('auto_play'),
	            'show_comments' => $this->soundcloud_get_option('show_comments'),
	            'color' => $this->soundcloud_get_option('color'),
	            'theme_color' => $this->soundcloud_get_option('theme_color'),
	        )),
	    ));
	    // Needs to be an array
	    if (!isset($plugin_options['params'])) {
	        $plugin_options['params'] = array();
	    }
	
	    // plugin options < shortcode options
	    $options = array_merge(
	            $plugin_options, $shortcode_options
	    );
	
	    // plugin params < shortcode params
	    $options['params'] = array_merge(
	            $plugin_options['params'], $shortcode_options['params']
	    );
	
	    if (isset($options['id'])) {
	        $options['url'] = trim('http://api.soundcloud.com/tracks/' . $options['id']);
	    } else {
	        // The "url" option is required
	        if (!isset($options['url'])) {
	            return '';
	        } else {
	            $options['url'] = trim($options['url']);
	        }
	    }
	
	    // Both "width" and "height" need to be integers
	    if (isset($options['width']) && !preg_match('/^\d+$/', $options['width'])) {
	        // set to 0 so oEmbed will use the default 100% and WordPress themes will leave it alone
	        $options['width'] = 0;
	    }
	    if (isset($options['height']) && !preg_match('/^\d+$/', $options['height'])) {
	        unset($options['height']);
	    }
	
	    // The "iframe" option must be true to load the iframe widget
	    $iframe = $this->soundcloud_booleanize(true)
	            // Default to flash widget for permalink urls (e.g. http://soundcloud.com/{username})
	            // because HTML5 widget doesn’t support those yet
	            ? preg_match('/api.soundcloud.com/i', $options['url']) : false;
	
	    // Return html embed code
	    if ($iframe) {
	        return $this->soundcloud_iframe_widget($options);
	    } else {
	        return $this->soundcloud_flash_widget($options);
	    }
	}
	
	
	
	
	/* Register SoundCloud shortcode
	  -------------------------------------------------------------------------- */
	
	/**
	 * Plugin options getter
	 * @param  {string|array}  $option   Option name
	 * @param  {mixed}         $default  Default value
	 * @return {mixed}                   Option value
	 */
	function soundcloud_get_option($option, $default = false) {
	    $value = get_option('c5ab_soundcloud_' . $option);
	    return $value === '' ? $default : $value;
	}
	
	/**
	 * Booleanize a value
	 * @param  {boolean|string}  $value
	 * @return {boolean}
	 */
	function soundcloud_booleanize($value) {
	    return is_bool($value) ? $value : $value === 'true' ? true : false;
	}
	
	/**
	 * Decide if a url has a tracklist
	 * @param  {string}   $url
	 * @return {boolean}
	 */
	function soundcloud_url_has_tracklist($url) {
	    return preg_match('/^(.+?)\/(sets|groups|playlists)\/(.+?)$/', $url);
	}
	
	/**
	 * Parameterize url
	 * @param  {array}  $match  Matched regex
	 * @return {string}          Parameterized url
	 */
	function soundcloud_oembed_params_callback($match) {
	    global $c5ab_soundcloud_oembed_params;
	
	    // Convert URL to array
	    $url = parse_url(urldecode($match[1]));
	    // Convert URL query to array
	    parse_str($url['query'], $query_array);
	    // Build new query string
	    $query = http_build_query(array_merge($query_array, $c5ab_soundcloud_oembed_params));
	
	    return 'src="' . $url['scheme'] . '://' . $url['host'] . $url['path'] . '?' . $query;
	}
	
	/**
	 * Iframe widget embed code
	 * @param  {array}   $options  Parameters
	 * @return {string}            Iframe embed code
	 */
	function soundcloud_iframe_widget($options) {
	
	    // Merge in "url" value
	    $options['params'] = array_merge(array(
	        'url' => $options['url']
	            ), $options['params']);
	
	    // Build URL
	    $url = 'http://w.soundcloud.com/player?' . http_build_query($options['params']);
	    // Set default width if not defined
	    $width = isset($options['width']) && $options['width'] !== 0 ? $options['width'] : '100%';
	    // Set default height if not defined
	    $height = isset($options['height']) && $options['height'] !== 0 ? $options['height'] : ($this->soundcloud_url_has_tracklist($options['url']) ? '450' : '166');
	
	    return sprintf('<iframe width="%s" height="%s" scrolling="no" frameborder="no" src="%s"></iframe>', $width, $height, $url);
	}
	
	/**
	 * Legacy Flash widget embed code
	 * @param  {array}   $options  Parameters
	 * @return {string}            Flash embed code
	 */
	function soundcloud_flash_widget($options) {
	
	    // Merge in "url" value
	    $options['params'] = array_merge(array(
	        'url' => $options['url']
	            ), $options['params']);
	
	    // Build URL
	    $url = 'http://player.soundcloud.com/player.swf?' . http_build_query($options['params']);
	    // Set default width if not defined
	    $width = isset($options['width']) && $options['width'] !== 0 ? $options['width'] : '100%';
	    // Set default height if not defined
	    $height = isset($options['height']) && $options['height'] !== 0 ? $options['height'] : ($this->soundcloud_url_has_tracklist($options['url']) ? '255' : '81');
	
	    return preg_replace('/\s\s+/', "", sprintf('<object width="%s" height="%s">
	                                <param name="movie" value="%s"></param>
	                                <param name="allowscriptaccess" value="always"></param>
	                                <embed width="%s" height="%s" src="%s" allowscriptaccess="always" type="application/x-shockwave-flash"></embed>
	                              </object>', $width, $height, $url, $width, $height, $url));
	}
	
	
	function css() {
	?>
	<style>
		.c5ab-audio{
			width: 100%;
			display: block;
		}
	</style>
	<?php
	}

}


 ?>