<?php

/**
 * c5ab_social_counter_Counter class.
 */
class c5ab_social_counter_Counter {

	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	  $connection = new C5_TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	  return $connection;
	}

	/**
	 * Update transients and cache.
	 */
	public function update_transients($atts) {
		// Get transient.
		$count = get_transient( 'c5ab_social_counter_counter' );

		// Test transient if exist.
		if ( false != $count )
			return $count;

		// Get options.
		$settings = get_option( 'c5ab_social_counter_settings' );
		$cache = get_option( 'c5ab_social_counter_cache' );
		
		// Default count array.
		$count = array(
			'twitter'    => 0,
			'facebook'   => 0,
			'youtube'    => 0,
			'googleplus' => 0,
			'posts'      => 0,
			'comments'   => 0,
		);
		
		$consumerkey = ot_get_option('consumerkey');
		$consumersecret = ot_get_option('consumersecret');
		$accesstoken = ot_get_option('accesstoken');
		$accesstokensecret = ot_get_option('accesstokensecret');
		
		// Twitter.
		if (   $atts['twitter'] != ''
			&& $consumerkey != ''
			&& $consumersecret != ''
			&& $accesstoken != ''
			&& $accesstokensecret != ''
		) {
			
			
			
			$connection = $this->getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
			$twitter_data = $connection->get("https://api.twitter.com/1.1/users/show.json?screen_name=" . $atts['twitter'] ) or die('Couldn\'t retrieve profile! Wrong username?');
			
			if ( is_wp_error( $twitter_data ) ) {
				$count['twitter'] = ( isset( $cache['twitter'] ) ) ? $cache['twitter'] : 0;
			} else {
				if ( isset( $twitter_data->followers_count ) ) {
					$twitter_count = $twitter_data->followers_count;

					$count['twitter'] = $twitter_count;
					$cache['twitter'] = $twitter_count;
				} else {
					$count['twitter'] = ( isset( $cache['twitter'] ) ) ? $cache['twitter'] : 0;
				}
			}
		}

		// Facebook.
		if (  $atts['facebook'] !='' ) {
			
			
			$facebook_data = wp_remote_get('http://api.facebook.com/restserver.php?method=facebook.fql.query&query=SELECT%20fan_count%20FROM%20page%20WHERE%20username="' . $atts['facebook'] . '"');
			    	
			    	if (is_wp_error($facebook_data)) {
			    	    $count['facebook'] = ( isset( $cache['facebook'] ) ) ? $cache['facebook'] : 0;
			    	} else {
			    	    $facebook_count = strip_tags($facebook_data['body']);
			    	    
			    	    $count['facebook'] = $facebook_count;
			    	    $cache['facebook'] = $facebook_count;
			    	}
			
			
		}

		// YouTube.
		if ( $atts['youtube'] != '') {

			// Get youtube data.
			$youtube_data = wp_remote_get( 'http://gdata.youtube.com/feeds/api/users/' . $atts['youtube'] );

			if ( is_wp_error( $youtube_data ) || '400' <= $youtube_data['response']['code'] ) {
				$count['youtube'] = ( isset( $cache['youtube'] ) ) ? $cache['youtube'] : 0;
			} else {
				try {
					$youtube_body = str_replace( 'yt:', '', $youtube_data['body'] );
					$youtube_xml = @new SimpleXmlElement( $youtube_body, LIBXML_NOCDATA );
					$youtube_count = (int) $youtube_xml->statistics['subscriberCount'];

					$count['youtube'] = $youtube_count;
					$cache['youtube'] = $youtube_count;
				} catch ( Exception $e ) {
					$count['youtube'] = ( isset( $cache['youtube'] ) ) ? $cache['youtube'] : 0;
				}
			}
		}

		// Google Plus.
		if ( $atts['google_plus'] != '' ) {
			$googleplus_id = 'https://plus.google.com/+' . $atts['google_plus'];

			$googleplus_data_params = array(
				'method'    => 'POST',
				'sslverify' => false,
				'timeout'   => 30,
				'headers'   => array( 'Content-Type' => 'application/json' ),
				'body'      => '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $googleplus_id . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]'
			);

			// Get googleplus data.
			$googleplus_data = wp_remote_get( 'https://clients6.google.com/rpc', $googleplus_data_params );

			if ( is_wp_error( $googleplus_data ) || '400' <= $googleplus_data['response']['code'] ) {
				$count['googleplus'] = ( isset( $cache['googleplus'] ) ) ? $cache['googleplus'] : 0;
			} else {
				$googleplus_response = json_decode( $googleplus_data['body'], true );

				if ( isset( $googleplus_response[0]['result']['metadata']['globalCounts']['count'] ) ) {
					$googleplus_count = $googleplus_response[0]['result']['metadata']['globalCounts']['count'];

					$count['googleplus'] = $googleplus_count;
					$cache['googleplus'] = $googleplus_count;
				} else {
					$count['googleplus'] = ( isset( $cache['googleplus'] ) ) ? $cache['googleplus'] : 0;
				}
			}
		}



		// Update plugin extra cache.
		update_option( 'c5ab_social_counter_cache', $cache );

		// Update counter transient.
		set_transient( 'c5ab_social_counter_counter', $count,  60*60  ); // 1 hours.

		return $count;
	}

	

} 
