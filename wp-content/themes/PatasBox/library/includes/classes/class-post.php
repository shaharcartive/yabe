<?php

class C5_post {

    function __construct() {
        
    }

    function hook() {

    }

    function get_post_thumb_wide($atts) {

        $return = '';

        $class = '';

       

        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], round(0.5 * $GLOBALS['c5_content_width']), true);
        $img_html = get_the_post_thumbnail(get_the_ID(), $image_size);


        $return .= '<article  class="c5ab_post_thumb c5ab_posts_thumb_tall_single ' . $class . ' clearfix"><div class="row">';



        if ($img_html != '') {
            $return .= '<div class="col-sm-6"><div class="c5-thumb-hover  clearfix">'. $img_html . '</div></div>';
        }

        $return .= '<div class="col-sm-6" ><div class="content ">';

        $return .= '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';


        $return .= $this->get_metadata($atts);

        $return .= '<div class="clearfix" ></div>';

        $return .= '<p class="c5-excerpt">' . $this->get_the_excerpt_max_charlength(200) . '</p>';

        $return .= '</div></div></div></article>';

        return $return;
    }
    
    function get_menu_post() {
    	
		
		$image_src = '';
        $class = '';
        $permalink = get_permalink();
        $size_class= 'normal';
	    $min_height = round( $GLOBALS['c5_content_width']* 1.618) ;
        
        $title = get_the_title();
        
        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'] , $min_height , true);
        $attachment_id = get_post_thumbnail_id( get_the_ID() );
        $image_attributes = wp_get_attachment_image_src( $attachment_id , $image_size); 			
        if( $image_attributes ){
        	$image_src = $image_attributes[0];
        }
        
        if($image_src==''){
        	$image_src = ot_get_option('default_cover');
        }
        
        if($image_src==''){
        	$image_src = C5_URL . 'library/images/default.png';
        } 
        
        if($image_src!=''){
        	$lum = intval( c5_get_avg_luminance($image_src) ) ;
            if($lum > 170){
            	$color_mode = 'light';
			}else {
				$color_mode = 'dark';
            }
        }

        $data = '<div  class="c5-menu-post  ' . $class . ' clearfix" ><div id="post-bg-'.get_the_ID().'" class="c5-single-bg-post c5-content-'.  $color_mode .' '.$size_class.'">
            <div class="c5-inner-header-wrap">
            <div class="c5-dark-shadow c5-content-'.  $color_mode .'" >
            	<div class="c5-main-width-wrap c5-header-data">';
    			$data .=  '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            	$data .= '</div></div>';
           $data .= ' </div>
        </div>
        </div>';
        $data .= '<style >#post-bg-'.get_the_ID().'{background-image:url("'.$image_src.'")}</style>';
				
		
		return $data;	
    }
	function get_post_mega_menu_post() {
	
	        $return = '';
	
	        $class = '';
	        $permalink = get_permalink();

	        $return .= '<article  class="c5ab_post_thumb c5-thumb-hover-trigger c5ab_posts_thumb_menu_single ' . $class . ' clearfix " >';
	        
			$return .= $this->get_featured_media();
			
	        $return .= '<div class="content ">';
			$return .=  '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
			$return .= '<div class="clearfix" ></div>';
			$return .= '</div></article>';
	
	        return $return;
	    }
	
    function get_post_blog_1($atts) {

        $return = '';

        $class = '';
        $permalink = get_permalink();
       	
       	$animation = '';
		if ( !isset($atts['animation'])){
	$atts['animation'] = 'on';
}

if( $atts['animation']!='off') {
			$animation = ' wow fadeInUp ';
		}

        $return .= '<article  class="c5ab_post_thumb c5-thumb-hover-trigger c5ab_posts_thumb_blog_1_single ' . $class . ' clearfix '.$animation.'" >';
        
		$return .= $this->get_featured_media();
		
        $return .= '<div class="content ">';
		$return .= $this->get_meta_categories();
		$return .= '<div class="clearfix" ></div>';
		$return .=  '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
		$return .= '<div class="clearfix" ></div>';
		
		

        $return .= '<p class="c5-excerpt">' . $this->get_the_excerpt_max_charlength(600) . '</p>';
        $return .= '<div class="clearfix" ></div>';
		
		$atts['meta_data'] = str_replace('category_on', 'category_off', $atts['meta_data']); 
		
		$return .= '<div class="c5ab_hr" ></div>';
		
		$return .= $this->get_metadata($atts);
		$return .= '<div class="clearfix" ></div>';
		
//        $return .= $this->get_read_more_button($permalink);
		$return .= '<div class="clearfix" ></div>';
        $return .= '</div></article>';

        return $return;
    }

    function get_post_blog_3( $atts) {

        $return = '';
		$image_src = '';
        $class = '';
        $permalink = get_permalink();
        $size_class= 'normal';
	    $min_height = round( $GLOBALS['c5_content_width']* 1.618) ;
        
        $title = get_the_title();
        
        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'] , $min_height , true);
        $attachment_id = get_post_thumbnail_id( get_the_ID() );
        $image_attributes = wp_get_attachment_image_src( $attachment_id , $image_size); 			
        if( $image_attributes ){
        	$image_src = $image_attributes[0];
        }
        
        if($image_src==''){
        	$image_src = ot_get_option('default_cover');
        }
        
        if($image_src==''){
        	$image_src = C5_URL . 'library/images/default.png';
        } 
        
        if($image_src!=''){
        	$lum = intval( c5_get_avg_luminance($image_src) ) ;
            if($lum > 170){
            	$color_mode = 'light';
			}else {
				$color_mode = 'dark';
            }
        }

        $data = '<div  class="c5ab_posts_thumb_blog_3_single  ' . $class . ' clearfix" ><div id="post-bg-'.get_the_ID().'" class="c5-single-bg-post c5-content-'.  $color_mode .' '.$size_class.'">
            <div class="c5-inner-header-wrap">
            <div class="c5-dark-shadow c5-content-'.  $color_mode .'" >
            	<div class="c5-main-width-wrap c5-header-data">';
            	
            	$data .= $this->get_meta_categories();
    			$data .= '<div class="clearfix" ></div>';
    			$data .=  '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
    			$data .= '<div class="clearfix" ></div>';
    			
    			
    	
    	        $data .= '<p class="c5-excerpt">' . $this->get_the_excerpt_max_charlength(600) . '</p>';
    	        $data .= '<div class="clearfix" ></div>';
    			
    			$atts['meta_data'] = str_replace('category_on', 'category_off', $atts['meta_data']); 
    			
    			$data .= '<div class="c5ab_hr" ></div>';
    			
    			$data .= $this->get_metadata($atts);
            		
            	$data .= '<div class="clearfix"></div></div></div>';
            //$data .= '<a href="'.get_permalink().'"  class="fa c5-read-more fa-angle-right"></a>
           $data .= ' </div>
        </div>
        </div>';
        $data .= '<style >#post-bg-'.get_the_ID().'{background-image:url("'.$image_src.'")}</style>';
        
        
        
        return $data;
    }

    function get_post_blog_2($atts) {

        $return = '';
        
        $has_thumbnail = $this->has_thumbnail();
        
        $animation = '';
        if ( !isset($atts['animation'])){
	$atts['animation'] = 'on';
}

if( $atts['animation']!='off') {
        	$animation = ' wow fadeInUp ';
        }
        
        $return .= '<article  class="c5ab_post_thumb c5-thumb-hover-trigger c5ab_posts_thumb_blog_2_single clearfix  '.$has_thumbnail.'  '.$animation.'">';
//		$return .=  '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
        $return .= '<div class="row">';

        $width = round(($GLOBALS['c5_content_width'] + 30)*5 / 12 - 30);
        
        $device = new C5AB_Mobile_Detect();
        
        if( $device->isMobile() && !$device->isTablet() ){
        	$width = 300;
        }

        $image_size = c5ab_generate_image_size($width, round($width*1.35), true);
        $read_more = '<span class="half"><span class="fa fa-link"></span></span>';
        $img_html = $this->get_featured_image($image_size,$read_more);
        if ($img_html != '') {
            $return .= '<div class="col-sm-5">'.$img_html.'</div><div class="col-sm-7">';
        } else {
            $return .= '<div class="col-sm-12">';
        }

        
        
//      $return .= $this->get_metadata($atts);
//        
//		$return .= '<div class="clearfix"></div>';
//		
//		$return .= $this->get_excerpt( 200);
//		
//		$return .= '<div class="clearfix"></div>';
//		
//		$return .= $this->get_read_more_button( get_permalink() );
		
		
		//
		$return .= '<div class="content" >';
		$return .= $this->get_meta_categories();
		$return .= '<div class="clearfix" ></div>';
		$return .=  '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
		$return .= '<div class="clearfix" ></div>';
		
		

        $return .= '<p class="c5-excerpt">' . $this->get_the_excerpt_max_charlength(600) . '</p>';
        $return .= '<div class="clearfix" ></div>';
		
		$atts['meta_data'] = str_replace('category_on', 'category_off', $atts['meta_data']); 
		
		$return .= '<div class="c5ab_hr" ></div>';
		
		$return .= $this->get_metadata($atts);
		$return .= '<div class="clearfix" ></div>';
		
		//
		
        $return .= '</div></div>';

        $return .= '</div></article>';

        return $return;
    }
	
	function get_grid_1_item($atts, $columns_count = 4, $order = 1) {
		$current_order =  $order%$columns_count;
		
		$delay = '0s';
		if ($current_order == 1) {
			$delay = '0.2s';
		}elseif ($current_order == 2) {
			if ($columns_count!='2') {
				$delay = '0.4s';
			}
		
		}elseif ($current_order == 3) {
			if ($columns_count=='4' ) {
				$delay = '0.6s';
			}
		}
		switch ($columns_count) {
			case 4:
				$width = ( $GLOBALS['c5_content_width']-3*30) /4;
				$height = round( $width * 0.62962962963);
				break;
			case 3:
				$width = ( $GLOBALS['c5_content_width']-2*30)/3;
				$height = round( $width * 0.62962962963);
				break;
			case 2:
				$width = ( $GLOBALS['c5_content_width']-30)/2;
				$height = round( $width * 0.62962962963);
				break;
			default:
				$width = ( $GLOBALS['c5_content_width']-3*30) /4;
				$height = round( $width * 0.62962962963);
				break;
		}
		$device = new C5AB_Mobile_Detect();
		
		if( $device->isMobile() && !$device->isTablet() ){
			$width =  $GLOBALS['c5_content_width'];
			$height = round( $width * 0.62962962963);
		}
			
		$image_size = c5ab_generate_image_size($width, $height, true);
		$read_more = '<span class="half"><span class="fa fa-link"></span></span>';
		$img_html = $this->get_featured_image($image_size, $read_more);
		
		$animation = '';
		if ( !isset($atts['animation'])){
	$atts['animation'] = 'on';
}

if( $atts['animation']!='off') {
			$animation = ' wow fadeInUp ';
		}
		
		$return = '<article  class="c5-portfolio-single c5-thumb-hover-trigger element count-'.$columns_count.' clearfix  '.$this->get_meta_slug_categories().'" data-filter="'.$this->get_meta_slug_categories().'" ><div class="c5-main-border '.$animation.' clearfix" data-wow-delay="'.$delay.'" >';
		
		$return .=  $img_html;
		
		
		
		$return .= '<div class="content clearfix"><div class="row"><div class="col-sm-3 date-border"><div class="date"><span class="day">'.get_the_date('d').'</span><span class="month">'.get_the_date('M').'</span><span class="year">'.get_the_date('Y').'</span></div></div><div class="col-sm-9"><h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3><div class="clearfix"></div>';
		
		$atts['meta_data'] = str_replace('time_on', 'time_off', $atts['meta_data']); 
		
		
		$return .= $this->get_metadata($atts);
		$return .= '</div></div></div>';
		
		$return .= '</div></article>';
		
		return $return;	
	}
	
	
	function get_grid_2_item($atts, $columns_count = 4, $order = 1) {
		$current_order =  $order%$columns_count;
		$width_test = $GLOBALS['c5_content_width'];
		$delay = '0s';
		if ($current_order == 1) {
			$delay = '0.2s';
		}elseif ($current_order == 2) {
			if ($columns_count!='2') {
				$delay = '0.4s';
			}
		
		}elseif ($current_order == 3) {
			if ($columns_count=='4' ) {
				$delay = '0.6s';
			}
		}
		switch ($columns_count) {
			case 4:
				$width = ( $GLOBALS['c5_content_width']-3*30) /4;
				$height = round( $width * 0.62962962963);
				break;
			case 3:
				$width = ( $GLOBALS['c5_content_width']-2*30)/3;
				$height = round( $width * 0.62962962963);
				break;
			case 2:
				$width = ( $GLOBALS['c5_content_width']-30)/2;
				$height = round( $width * 0.62962962963);
				break;
			default:
				$width = ( $GLOBALS['c5_content_width']-3*30) /4;
				$height = round( $width * 0.62962962963);
				break;
		}
		$device = new C5AB_Mobile_Detect();
		
		if( $device->isMobile() && !$device->isTablet() ){
			$width =  $GLOBALS['c5_content_width'];
			$height = round( $width * 0.62962962963);
		}	
		$GLOBALS['c5_content_width'] = $width;
		$image_size = c5ab_generate_image_size($width, $height, true);
//		$read_more = '<span class="half"><span class="fa fa-link"></span></span>';
//		$img_html = $this->get_featured_image($image_size, $read_more);
		
		$animation = '';
		if ( !isset($atts['animation'])){
	$atts['animation'] = 'on';
}

if( $atts['animation']!='off') {
			$animation = ' wow fadeInUp ';
		}
		
		$return = '<article  class="c5-portfolio-single c5-grid-blog c5-thumb-hover-trigger element count-'.$columns_count.' clearfix  '.$this->get_meta_slug_categories().'" data-filter="'.$this->get_meta_slug_categories().'" ><div class="c5-main-border '.$animation.' clearfix" data-wow-delay="'.$delay.'" >';
		
//		$return .=  $img_html;
		$return .= $this->get_featured_media();
				
        $return .= '<div class="content ">';
		$return .= $this->get_meta_categories();
		$return .= '<div class="clearfix" ></div>';
		$return .=  '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
		$return .= '<div class="clearfix" ></div>';
		
		

        $return .= '<p class="c5-excerpt">' . $this->get_the_excerpt_max_charlength(200) . '</p>';
        $return .= '<div class="clearfix" ></div>';
		
		$atts['meta_data'] = str_replace('category_on', 'category_off', $atts['meta_data']); 
		
		$return .= '<div class="c5ab_hr" ></div>';
		
		$return .= $this->get_metadata($atts);
		$return .= '<div class="clearfix" ></div>';
		
		$return .= '</div></div></article>';
		
		$GLOBALS['c5_content_width'] = $width_test ;
		return $return;	
	}
	
	function get_grid_3_item($atts, $columns_count = 4, $order = 1) {
			$current_order =  $order%$columns_count;
			$delay = '0s';
			if ($current_order == 1) {
				$delay = '0.2s';
			}elseif ($current_order == 2) {
				if ($columns_count!='2') {
					$delay = '0.4s';
				}
			
			}elseif ($current_order == 3) {
				if ($columns_count=='4' ) {
					$delay = '0.6s';
				}
			}
			switch ($columns_count) {
				case 4:
					$width = ( $GLOBALS['c5_content_width']-3*30) /4;
					$height = round( $width * 0.62962962963);
					break;
				case 3:
					$width = ( $GLOBALS['c5_content_width']-2*30)/3;
					$height = round( $width * 0.62962962963);
					break;
				case 2:
					$width = ( $GLOBALS['c5_content_width']-30)/2;
					$height = round( $width * 0.62962962963);
					break;
				default:
					$width = ( $GLOBALS['c5_content_width']-3*30) /4;
					$height = round( $width * 0.62962962963);
					break;
			}
			$device = new C5AB_Mobile_Detect();
			
			if( $device->isMobile() && !$device->isTablet() ){
				$width =  $GLOBALS['c5_content_width'];
				$height = round( $width * 0.62962962963);
			}	
			$image_size = c5ab_generate_image_size($width, $height, true);
	//		$read_more = '<span class="half"><span class="fa fa-link"></span></span>';
	//		$img_html = $this->get_featured_image($image_size, $read_more);
			
			$animation = '';
			if ( !isset($atts['animation'])){
	$atts['animation'] = 'on';
}

if( $atts['animation']!='off') {
				$animation = ' wow fadeInUp ';
			}
			
			$return = '<article  class="c5-portfolio-single c5-grid-blog c5-thumb-hover-trigger element count-'.$columns_count.' clearfix  '.$this->get_meta_slug_categories().'" data-filter="'.$this->get_meta_slug_categories().'" ><div class="c5-main-border '.$animation.' clearfix" data-wow-delay="'.$delay.'" >';
			
	//		$return .=  $img_html;
			$return .= $this->get_post_blog_3($atts);
					
	        $return .= '</div></article>';
			
			return $return;	
		}
	
	function get_meta_slug_categories() {
	        $tax = c5_get_post_tax(get_the_ID());
	        $terms = wp_get_post_terms(get_the_ID(), $tax);
	        $data = '';
	        $counter = 1;
	        if (count($terms) != 0) {
	            foreach ($terms as $term) {
	            	$data .= '' .  $term->slug ;
	            	if ($counter != count($terms)) {
	            		$data .= ' ';
	            	}
	            	$counter++;
	            }
	        }
	        return $data;
	    }
	
	function get_featured_image($image_size , $html = '') {
		$return = '';
		$img_html = get_the_post_thumbnail(get_the_ID(), $image_size);
        if ($img_html != '') {
        	$attachment_id = get_post_thumbnail_id( get_the_ID() );
        	$image_attributes = wp_get_attachment_image_src( $attachment_id , $image_size); 		
        	
        	$min_height = 100;	
        	if( $image_attributes ){
        		$min_height = $image_attributes[2];
        	}
            $return .= '<div class="c5-thumb-hover  clearfix" style="min-height:'.$min_height.'px;">' . $img_html;
			$return .= '<div class="img-wrap"><a class="link" href="' . get_permalink() . '"><span class="line top-line"></span><span class="line bottom-line"></span><span class="line left-line"></span><span class="line right-line"></span>'.$html.'</a></div>';

            $return .= '</div>';
        }
        
        return $return; 
	}
	
    function get_post_titles($atts) {

        $return = '';




        $return .= '<article  class="c5ab_post_thumb element c5ab_posts_thumb_titles_single  clearfix">';
        if (is_rtl()) {
            $icon = 'fa fa-arrow-circle-o-left';
        } else {
            $icon = 'fa fa-arrow-circle-o-right';
        }

        $return .= '<span class="' . $icon . '"></span><a href="' . get_permalink() . '">' . get_the_title() . '</a>';

        $return .= '</article>';


        return $return;
    }

    function get_featured_media() {
        $data = '';
        $width = $GLOBALS['c5_content_width'];
        $height = round($width * 0.4);
        if ($height< 240) {
        	$height = 240;
        }
        
		
		$image_size = c5ab_generate_image_size($width, $height, true);
		$attachment_id = get_post_thumbnail_id();
		$src= '';
		$image_attributes = wp_get_attachment_image_src($attachment_id , $image_size , false );
		if ($image_attributes) {
			$src = $image_attributes[0];
		}
		$unique_id = $this->get_unique_id();
		$data .= '<style >#media-'.$unique_id.'{background-image:url("'.$src.'")}</style>';
        $min_height = $height;
        $format = get_post_format();

        if ($format == 'gallery') {
            if (!is_single()) {
                $data.= '<div class="clearfix" style="min-height:' . $min_height . 'px;">' . get_post_gallery() . '</div>';
            }
        } elseif ($format == 'video') {
        	$height = round( ($width-120) * 9 / 16);
            $meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
            
            $data .=  do_shortcode('[c5ab_video url="' . $meta_attachment . '" width="100%" height="' . $height . '" ]');
            
        } elseif ($format == 'audio') {
            $meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
            $data .= '<div id="media-'.$unique_id.'" class="c5-media-audio c5-media-common  clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_audio url="' . $meta_attachment . '" ]') . '</div></div>';
        } elseif ($format == 'quote') {
        	$quote = '';
        	preg_match_all('/\<blockquote\>(.*?)\<\/blockquote\>/', get_the_content(),$matches);
        	if(isset($matches[0][0])){
        		$quote = $matches[0][0];
        	}
        	$data .= '<div id="media-'.$unique_id.'" class="c5-media-blockquote c5-media-common  clearfix"><div class="c5-media-common-inner"><div class="c5-quote"><span class="fa fa-quote-left"></span>' . $quote .'</div></div></div>';
        }else {
        	$meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
        	if($meta_attachment!=''){
        		$link = explode('/', $meta_attachment);
        		if($link[2]=='twitter.com'){
        			$data .= '<div id="media-'.$unique_id.'" class="c5-media-twitter c5-media-common  clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_tweet link="'.$meta_attachment.'" ]') . '</div></div>';
        		}elseif($link[2]=='www.facebook.com'){
        			if($width == 700){
        				$width = 500;
        			}
        			$width = $GLOBALS['c5_content_width'];
        			$GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']*0.7);
        			$data .=   '<div id="media-'.$unique_id.'" class="c5-media-facebook c5-media-common clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_facebook_post url="'.$meta_attachment.'" width="'.$width.'"]') . '</div></div>';
        			
        			$GLOBALS['c5_content_width'] = $width;
        		}
        			
        	}else {
        		$image_size = c5ab_generate_image_size($width, $height, true);
        		
        		$read_more = '<span class="half"><span class="fa fa-link"></span></span>';
        		$data .=  $this->get_featured_image($image_size, $read_more);
        	}
        	
            
        }
        if($data !=''){
        	$data ='<div class="clearfix">' . $data . '</div>';
        }

        return $data;
    }

    

    

    

    

    

    function get_post_carousel() {

        $return = '';

        $class = '';
        $element_id = $this->get_unique_id();
        


        $layout = get_post_meta(get_the_ID(), 'meta_metro', true);
        if ($layout == '') {
            $layout = 'photo';
        }
        $size = 'medium';

        if ($GLOBALS['c5_content_width'] < 350) {
            $single_width = $GLOBALS['c5_content_width'];
        } elseif ($GLOBALS['c5_content_width'] < 700) {
            $single_width = floor($GLOBALS['c5_content_width'] / 3);
        } elseif ($GLOBALS['c5_content_width'] < 1000) {
            $single_width = floor($GLOBALS['c5_content_width'] / 4);
        } else {
            $single_width = floor($GLOBALS['c5_content_width'] / 5);
        }



        $width = $single_width;
        $height = $single_width;


        $image_size = c5ab_generate_image_size($width, $height, true);
        $img_html = get_the_post_thumbnail(get_the_ID(), $image_size);


        $return .= '<article  class="flip-post element ' . $size . ' ' . $class . '  flip-post-' . $element_id . ' c5ab_posts_thumb_metro_single clearfix">';
        $return .= '<style >.flip-post-' . $element_id . '{width:' . $width . 'px;height:' . $height . 'px;}</style>';
        $return .= '<div class="flip-wrap">';

        if ($layout == 'photo') {
            $return .= '<div class="post-front">' . $img_html . '</div>';
            $return .= '<div class="post-back post-data-bg"><div class="post-back-wrap">';

            $return .= '<a class="cat-link" href="' . get_term_link(intval($cat_id), $tax) . '"><span class="' . c5_get_category_icon( $tax . '-' . $cat_id) . '"></span></a>';

            $return .= '<a class="title-link" href="' . get_permalink() . '">' . get_the_title() . '</a>';


            $return .= '</div></div>';
        } else {
            $return .= '<div class="post-front post-data-bg"><div class="post-back-wrap">';

            $return .= '<a class="cat-link" href="' . get_term_link(intval($cat_id), $tax) . '"><span class="' . c5_get_category_icon( $tax . '-' . $cat_id) . '"></span></a>';



            $return .= '<a class="title-link" href="' . get_permalink() . '">' . get_the_title() . '</a>';
            $return .= '</div></div><div class="post-back">';
            $return .= '<a  href="' . get_permalink() . '">' . $img_html . '</a></div>';
        }



        $return .= '</div></article>';

        return $return;
    }

    function get_post_slide($atts) {
        $return = '';
        $color_mode = 'dark';
		$image_src = '';
		$title = get_the_title();
		$subtitle = get_post_meta(get_the_ID() , 'c5_subtitle',true);
		$small_text = $this->get_meta_categories() . '<div class="clearfix"></div>';

		$image_size = c5ab_generate_image_size(1000, 600, true);
		$attachment_id = get_post_thumbnail_id( get_the_ID() );
		$image_attributes = wp_get_attachment_image_src( $attachment_id , $image_size); 			
		if( $image_attributes ){
			$image_src = $image_attributes[0];
		}
		if($image_src==''){
			$image_src = ot_get_option('default_cover'); 
		}
		
		if($image_src==''){
			/* $image_src = C5_URL . 'library/images/default.jpg'; */
		}
		
		if($image_src!=''){
			$lum = intval( c5_get_avg_luminance($image_src) ) ;
		    if($lum > 170){
		    	$color_mode = 'light';
		    	$color = '#222';
		    	$color_hover = '#000';
			}else {
				$color_mode = 'dark';
				$color = '#fff';
				$color_hover = '#eee';
		    }
		}
		$c5_force = get_post_meta(get_the_ID() , 'c5_force',true);
		if($c5_force == 'light'){
			$color_mode = 'light';
		}
		if($c5_force == 'dark'){
			$color_mode = 'dark';
		}
		
		$center_class = 'c5-main-width-wrap';
		$ID = $this->get_unique_id();
        $return .= '<li class="slide-'.$ID.' "><div class="c5-li c5-content-'.$color_mode.'">';
        
        $return .= '<style >
        	li.slide-'.$ID.'{
        		background-image: url(\''. $image_src .'\');
        	}
        </style>
        <div class="c5-dark-shadow c5-content-'.  $color_mode .'" >
        	<div class="c5-main-width-wrap c5-header-data">';
        	
        $return .= '<div class="content ">';
		$return .= $this->get_meta_categories();
		$return .= '<div class="clearfix" ></div>';
		$return .=  '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
		$return .= '<div class="clearfix" ></div>';
		
		
		if ($subtitle!='') {
			$return .= '<p class="c5-excerpt">'. esc_attr( $subtitle ) .'</p>';	
		} 
//      $return .= '<p class="c5-excerpt">' . $this->get_the_excerpt_max_charlength(600) . '</p>';
        $return .= '<div class="clearfix" ></div>';
		
		$atts['meta_data'] = str_replace('category_on', 'category_off', $atts['meta_data']); 
		
		$return .= '<div class="c5ab_hr" ></div>';
		
		$return .= $this->get_metadata($atts);
		$return .= '<div class="clearfix" ></div>';	
		$return .= '</div>';
        		
//      $small_text .'<h1><a href="'.get_permalink().'">'. $title .'</a></h1>';
//        	
//       
//        
//      //button
//      $icon = 'fa fa-angle-right';
//      $align = 'right';
//      if (is_rtl()) {
//         $icon = 'fa fa-angle-left';
//         $align = 'left';
//      }
//      $return .= do_shortcode('[c5ab_button text="' . __('Read More', 'code125') . '" link="' . get_permalink() . '" icon="' . $icon . '" font_size="14" font_weight="300" button_class="" float="center" button_color="'.$color.'" button_hover_color="'.$color_hover.'" ]');
        
        $return .= '</div></div></div>';
        $return .= '</li>';
        return $return;
    }

    function get_post_thumb($atts) {
        $return = '';
        $class = '';

        $image_size = c5ab_generate_image_size(100, 100, true);
        $read_more = '<span class="half"><span class="fa fa-link"></span></span>';
        $img_html = $this->get_featured_image($image_size,$read_more);

        if ($img_html != '') {
            $class .= ' has-thumb';
        }

        $return .= '<article  class="c5ab_post_thumb c5-thumb-hover-trigger c5ab_posts_thumb_single ' . $class . ' clearfix">';

		$return .= $img_html;

        $return .= '<div class="content ">';

        $return .= '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3><div class="clearfix"></div>';
        
        $return .= $this->get_metadata($atts);
        $return .= '<div class="clearfix" ></div>';
		$return .= '</div></article>';

        return $return;
    }

   function has_thumbnail() {
   		$attachment_id = get_post_thumbnail_id( get_the_ID() );
   		if ($attachment_id == '') {
   			return 'no_thumbnail';
   		}else {
   			return 'has_thumbnail';
   		}
   }

    function show_meta($atts, $element) {
        if (isset($atts[$element]) && $atts[$element] != 'off') {
            return true;
        }
        return false;
    }

//    function get_metadata(){
//
//        $meta_data = '<ul class="c5_meta_data  clearfix">';
//
//       
//			$categories = $this->get_meta_categories();
//			$meta_data .= '<li class="c5-meta-li-categories">' . $categories . '</li>';
//            //Author
//            $author = $this->get_meta_author();
//            $meta_data .= '<li class="c5-meta-li-author">' . $author . '</li>';
//        
//            //Date
//            $date = $this->get_meta_date('date_ago');
//            $meta_data .= '<li class="c5-meta-li-date">' . $date . '</li>';
//        
//            //Rating
//            $rating = $this->get_meta_rating();
//            $meta_data .= '<li class="c5-meta-li-rating">' . $rating . '</li>';
//        
//
//
//
//
//        $meta_data .= '</ul>';
//
//
//        return $meta_data;
//    }
    
    
    function get_metadata($atts){
		$meta_data = '';
		
		$raw_data = explode(',', $atts['meta_data'] );
		
		$valid_meta_data = array();
		if(!empty($raw_data)){
		    foreach ($raw_data as $meta_data) {
		    	$single_value = explode('_', $meta_data);
		    	if (isset($single_value[1])) {
		    		if ($single_value[1]=='on') {
			    		$valid_meta_data[] = $single_value[0];	
			    	}
		    	}
		    }
		}
		
		
		if (!empty($valid_meta_data)) {
			$meta_data = '<ul class="c5_meta_data  clearfix">';
			foreach ($valid_meta_data as $single_data) {
				$current_data = '';
				switch ($single_data) {
					case 'category':
					
						$current_data = $this->get_meta_categories();
						
						break;
					
					case 'author':
						$current_data =  $this->get_meta_author();
						break;
					case 'comment':
						$current_data =  '<a href="'.get_permalink().'#comments"><span class="fa fa-comment-o"></span>' . $this->get_meta_comment_count() . '</a>';
						
						break;
					case 'time':
						$format = $atts['c5_date_format'];
						if ($format == '') {
							$format = 'date';
						}
						$current_data =  $this->get_meta_date($format);
						break;
					case 'tags':
						if (has_tag()) {
							ob_start();
							the_tags('',', ' ,'');
							$tags = ob_get_clean();
							$current_data =  '<span class="fa fa-tags"></span>' . $tags;
						}
						break;	
						
					case 'like':
						
						$str = __('Likes','code125');
						
						$current_data =  $this->get_meta_likes_count($str);
						break;
					case 'views':
						$current_data =  $this->get_meta_views_count();
						break;
					case 'rating':
						$current_data =  $this->get_meta_rating();
						break;
					case 'share':
//						$current_data =  $this->get_meta_social_count();
						break;
					default:
						break;
				}
				if ($current_data!='') {
					$meta_data .= '<li class="c5-meta-li-'.$single_data.' clearfix">'.$current_data.'</li>';
				}
			}
			$meta_data .= '</ul>';
		}
		
        


        return $meta_data;
    }
    

    

    function custom_number_format($n) {

        $precision = 1;

        if ($n < 1000) {
            $n_format = round($n);
        } else if ($n < 1000000) {
            $n_format = round($n / 1000, $precision) . 'K';
        } else {
            $n_format = round($n / 1000000, $precision) . 'M';
        }

        return $n_format;
    }

    function get_read_more_button($permalink) {
		global $c5_skindata;
        $color = $c5_skindata['primary_color'];
        
        $icon = 'fa fa-angle-right';
        $align = 'right';
        if (is_rtl()) {
            $icon = 'fa fa-angle-left';
            $align = 'left';
        }
        $button = do_shortcode('[c5ab_button text="' . __('Read More', 'code125') . '" link="' . $permalink . '" icon="' . $icon . '" font_size="12" font_weight="300" button_class="" float="'.$align.'" button_color="'.$color.'" button_hover_color="#333" ]');

        return $button;
    }

    function get_excerpt($atts, $charlength = 600) {
        return '<p class="c5-excerpt">' . $this->get_the_excerpt_max_charlength($charlength) . '</p>';
        
        return '';
    }

    function get_the_excerpt_max_charlength($charlength) {
        $excerpt = get_the_excerpt();
        $excerpt = strip_tags($excerpt);
        $data = '';
        $charlength++;

        if (mb_strlen($excerpt) > $charlength) {
            $subex = mb_substr($excerpt, 0, $charlength - 5);
            $exwords = explode(' ', $subex);
            $excut = - ( mb_strlen($exwords[count($exwords) - 1]) );
            if ($excut < 0) {
                $data .= mb_substr($subex, 0, $excut);
            } else {
                $data .= $subex;
            }
        } else {
            $data .= $excerpt;
        }

        return $data;
    }

    function get_pagination($atts, $the_query, $args) {
        if ($atts['paging'] == 'off') {
            return;
        }

        $bignum = 999999999;
        if ($the_query->max_num_pages <= 1)
            return;

        $data = '<nav class="c5-pagination">';

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        if ($atts['paging'] == 'ajax') {
        	$paged++;
        	$args['offset'] = 0;
        	$args['paged'] = $paged;
        	$single_width = '';
        	if( $atts['render_type'] == 'grid-1' || $atts['render_type'] == 'grid-2' || $atts['render_type'] == 'grid-3' ){
        	
        		if ($GLOBALS['c5_content_width'] < 400) {
        			$single_width =  $GLOBALS['c5_content_width'];
        			break;
        		}elseif ($GLOBALS['c5_content_width'] < 800) {
        			$single_width = ( $GLOBALS['c5_content_width']+30) /2;
        		}else {
        			$single_width = ( $GLOBALS['c5_content_width']+30)/3;
        		}
        		$single_width = floor($single_width);
        		
        	}
        	
        	global $c5_skindata;
        	$data = '<div class="c5-load-more-posts" data-args="'.base64_encode(serialize($args)).'" data-atts="'.base64_encode(serialize($atts)).'" render_type="'.$atts['render_type'].'" data-page="2" data-color="'.$c5_skindata['primary_color'].'" data-content-width="'.$GLOBALS['c5_content_width'].'" slider_id="'.$atts['ID'].'" single_width="'.$single_width.'">
        		<span class="fa fa-spin fa-spinner"></span>
        	</div>';
        	
        	return $data;
        }


        $prev_text = '<span class="num fa fa-angle-left"></span>';
        $next_text = '<span class="num fa fa-angle-right"></span>';
        if (is_rtl()) {
            $prev_text = '<span class="num fa fa-angle-right"></span>';
            $next_text = '<span class="num fa fa-angle-left"></span>';
        }

        $output = paginate_links(array(
            'base' => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
            'format' => '',
            'current' => $paged,
            'total' => $the_query->max_num_pages,
            'prev_text' => $prev_text,
            'next_text' => $next_text,
            'type' => 'list',
            'end_size' => 3,
            'mid_size' => 3,
            'before_page_number' => '<span class="num">',
            'after_page_number' => '</span>'
        ));
//        print_r($output);
		$data .= $output;
        $data .= '</nav>';
        
//        print_r($data);
        return $data;
    }

    function get_meta_social_count() {

        $count = get_post_meta(get_the_ID(), 'c5_total_share', true);
        if ($count == '') {
            $count = 0;
        }

        $output = '<span class="fa fa-share-alt"></span><span class="c5-social-count">' . $this->custom_number_format($count) . '</span>';
        return $output;
    }

    function get_meta_rating() {

        $meta_reviews = get_post_meta(get_the_ID(), 'meta_reviews', true);
        $total_count = 0;
        $rating = 0;
        if (is_array($meta_reviews)) {
            foreach ($meta_reviews as $review) {
                $rating = $rating + $review['rating'];
                $total_count++;
            }
        }
        if ($total_count > 0) {
            $count = round($rating / $total_count);
            $output = '<div class="c5-rating-view-wrap">' . c5_review_stars($count);



            $output .= '</div>';
            return $output;
        } else {
            return '';
        }
    }

    function get_meta_views_count() {

        $count = get_post_meta(get_the_ID(), 'post_views_count', true);
        if ($count == '') {
            $count = 0;
        }

        $output = '<span class="fa fa-eye"></span><span class="c5-views">' . $this->custom_number_format($count) . '</span>';
        return $output;
    }

    function get_meta_likes_count() {
        $vote_count = get_post_meta(get_the_ID(), "votes_count", true);
        if ($vote_count == '') {
            $vote_count = 0;
        }

        $output = '<span class="c5-post-like" data-post_id="' . get_the_ID() . '" title="' . __('like', 'code125') . '"><span class="fa fa-heart-o"></span><span class="count">' . $this->custom_number_format($vote_count) . '</span></span>';

        return $output;
    }

    function get_meta_comment_count() {
        $count = get_comments_number(get_the_ID());

        $fb_count = get_post_meta(get_the_ID(), 'c5_fb_comments_count', true);

        if ($fb_count == '') {
            $fb_count = 0;
        }
        $comment = $count + $fb_count;
        
//        if ($comment == 0) {
//        	$comment = __('No comments','code125');
//        }elseif ($comment == 1) {
//        	$comment = __('One comment','code125');
//        }else {
//        	$comment = $comment .' '. __('comments','code125');
//        }

        return $comment ;
    }

    function get_meta_date($choice) {
        $data = '';
        if ($choice == 'date_time') {
            $date = get_the_time(get_option('date_format') . ' ' . get_option('time_format'));
        } elseif ($choice == 'date') {
            $date = get_the_time(get_option('date_format'));
        } elseif ($choice == 'time') {
            $date = get_the_time(get_option('time_format'));
        } elseif ($choice == 'ago') {
            $date = sprintf(__('%s ago', 'code125'), human_time_diff(get_the_time('U'), current_time('timestamp')));
        }elseif ($choice == 'date_ago') {
            $date = get_the_time(get_option('date_format')) . ', ' .sprintf(__('%s ago', 'code125'), human_time_diff(get_the_time('U'), current_time('timestamp')));
        } else {
            return '';
        }

        $return = '<time class="value updated" datetime="' . get_the_time('Y-m-d') . '"><span class="fa fa-calendar-o"></span>' . $date . '</time>';
        return $return;
    }

    function get_meta_author() {
        return '<a class="url fn" href="' . get_author_posts_url(get_the_author_meta('ID')) . '"><span class="fa fa-user"></span>' . get_the_author_meta('display_name') . '</a>';
    }

    function get_meta_categories() {
        $tax = c5_get_post_tax(get_the_ID());
        $terms = wp_get_post_terms(get_the_ID(), $tax);
        $data = '';
        if (count($terms) != 0) {
            foreach ($terms as $term) {
                $icon = c5_get_category_icon( $tax . '-' . $term->term_id);
                if (!$icon) {
                    $icon = '<span class="fa fa-tag"></span>';
                } else {
                    $icon = '<span class="' . $icon . '"></span>';
                }
                $data .= '<a href="' . get_term_link(intval($term->term_id), $tax) . '" class="c5-meta-cat ' . $tax . '-' . $term->term_id . '">' . $icon . $term->name . '</a>';
            }
        }
        return $data;
    }

    function handle_atts($atts) {
    
        $default_atts = array(
            'post_type' => 'post',
            'posts' => '',
            'posts_per_page' => '10',
            'follow' => 'off',
            'paging' => 'off',
            'orderby' => 'date',
            'order' => 'DESC',
        );
        foreach ($default_atts as $key => $value) {
            if (!isset($atts[$key])) {
                $atts[$key] = $default_atts[$key];
            }
        }
        $args = array();
    
    
        $tax_queries = array();
        if ($atts['posts'] != '') {
            $args['post__in'] = explode(',', $atts['posts']);
            $args['ignore_sticky_posts'] = true;
            $args['orderby'] = 'post__in';
    		$args['post_type'] = 'any';
            return $args;
        } else {
            $post_types = array();
    
            $author_id = array();
            $post_type_args = explode(',', $atts['post_type']);
            if (!empty($post_type_args)) {
                foreach ($post_type_args as $post_type_value) {
                    $info = explode('#', $post_type_value);
                    $post_types[] = $info[0];
                    if (isset($info[2])) {
                        if ($info[1] == 'author') {
                            $author_id[] = $info[2];
                        } else {
                            $tax_queries[] = array(
                                'taxonomy' => $info[1],
                                'field' => 'id',
                                'terms' => $info[2]
                            );
                        }
                    }
                }
                $args['post_type'] = $post_types;
    
                if (!empty($author__in)) {
                    $args['author__in'] = $author__in;
                }
            }
        }
    
        if (is_front_page()) {
            $frontpage_id = get_option('page_on_front');
            $main_news = get_post_meta($frontpage_id, 'main_news', true);
            if ($main_news != '') {
                $args['post__not_in'] = array($main_news);
            }
        } elseif (is_single()) {
            global $post;
            $args['post__not_in'] = array($post->ID);
        }
    
        if ($atts['follow'] == 'on') {
    
            if (is_archive() || is_search()) {
                unset($args['tax_query']);
                $tax_queries = array();
                unset($args['author__in']);
                unset($args['tag']);
                unset($args['author']);
            }
            if (is_category()) {
                $obj = get_queried_object();
                $tax = get_taxonomy($obj->taxonomy);
                $args['cat'] = $obj->term_id;
            } elseif (is_tax()) {
                $obj = get_queried_object();
    
                $tax = get_taxonomy($obj->taxonomy);
                $args['post_type'] = $tax->object_type[0];
    
                $tax_queries[] = array(
                    'taxonomy' => $obj->taxonomy,
                    'field' => 'id',
                    'terms' => $obj->term_id
                );
            } elseif (is_tag()) {
                $obj = get_queried_object();
    
                $args['tag_id'] = $obj->term_id;
            } elseif (is_author()) {
                $obj = get_queried_object();
                $args['author'] = $obj->ID;
            } elseif (is_search()) {
                if (isset($_GET['s'])) {
                    $args['s'] = $_GET['s'];
                }
    
                if (isset($_GET['post_type'])) {
                    $args['post_type'] = $_GET['post_type'];
                }
                if (isset($_GET['cat'])) {
                    if ($_GET['cat'] != '-1') {
                        $tax_queries[] = array(
                            'taxonomy' => 'category',
                            'field' => 'id',
                            'terms' => $_GET['cat']
                        );
                    }
                }
    
                if (isset($_GET['tax'])) {
                    $tax = get_taxonomy($_GET['tax']);
                    if ($_GET['term'] != '-1') {
                        $tax_queries[] = array(
                            'taxonomy' => $_GET['tax'],
                            'field' => 'id',
                            'terms' => $_GET['term']
                        );
                    }
                }
            } elseif (is_day()) {
                $args['date_query'] = array(
                    'year' => get_the_time('Y'),
                    'month' => get_the_time('n'),
                    'day' => get_the_time('j'),
                );
            } elseif (is_month()) {
                $args['date_query'] = array(
                    'year' => get_the_time('Y'),
                    'month' => get_the_time('n'),
                );
            } elseif (is_year()) {
                $args['date_query'] = array(
                    'year' => get_the_time('Y'),
                );
            }
        }
    
        if (!empty($tax_queries)) {
            $args['tax_query'] = $tax_queries;
        }
        $args['posts_per_page'] = $atts['posts_per_page'];
    
        if ($atts['paging'] == 'on') {
            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } elseif (get_query_var('page')) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
        } else {
            $paged = 1;
        }
        $args['offset'] = 0;
        $args['paged'] = $paged;
    
    //orderby
        $order_custom = array(
            'votes_count',
            'rating_average',
            'votes_count',
            'rating_average',
            'post_views_count',
            'c5_hourly_views',
            'c5_daily_views',
            'c5_weekly_views',
            'c5_total_share',
            'c5_hourly_shares',
            'c5_daily_shares',
            'c5_weekly_shares',
        );
    
        if (!in_array($atts['orderby'], $order_custom)) {
            $args['orderby'] = $atts['orderby'];
        } else {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = $atts['orderby'];
        }
    
    
        $args['order'] = $atts['order'];
    
    //    		print_r($args);
        return $args;
    }

    function get_authors_array($tag_id) {
        $array = array();
        $array[] = array(
            'label' => 'All Authors',
            'value' => ''
        );
        $blogusers = get_users();
        foreach ($blogusers as $user) {
            if (count_user_posts($user->ID) > 0) {
                $array[] = array(
                    'label' => $user->display_name,
                    'value' => $user->ID
                );
            }
        }

        $ret_array = array(
            'label' => 'Author',
            'id' => $tag_id,
            'type' => 'select',
            'desc' => 'Choose the Certain Authors',
            'std' => '',
            'choices' => $array,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        );
        return $ret_array;
    }

    function get_tags_array($tag_id) {

        $ret_array = array(
            'label' => 'Tag Select',
            'id' => $tag_id,
            'type' => 'tag-select',
            'desc' => 'Choose the tag to follow or leave blank',
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        );
        return $ret_array;
    }

    function get_posts_input_array($tag_id) {

        $ret_array = array(
            'label' => 'Select Certain Posts',
            'id' => $tag_id,
            'type' => 'text',
            'desc' => 'Add Posts IDs seperated with comma ",", Example: 4,5,10',
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        );
        return $ret_array;
    }

    function get_posts_per_page_array($tag_id, $std) {
        $ret_array = array(
            'label' => 'Number of Articles to show',
            'id' => $tag_id,
            'type' => 'numeric-slider',
            'desc' => 'Slide to select the Number of Articles to show',
            'std' => $std,
            'min_max_step' => '1,50,1',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        );
        return $ret_array;
    }

    function get_time_frame_array($tag_id, $default = '') {

        $time_frame = array(
            'all' => 'All the time',
            '_hour' => 'This hour',
            '_5min' => 'Now "5 minutes range"',
        );

        $array = array();
        foreach ($time_frame as $key => $value) {
            $array[] = array(
                'label' => $value,
                'value' => $key
            );
        }

        $ret_array = array(
            'label' => 'Select Timeframe',
            'id' => $tag_id,
            'type' => 'Select',
            'desc' => 'Select Timeframe to Show Articles in',
            'std' => $default,
            'choices' => $array,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        );
        return $ret_array;
    }

    function get_orderby_array($tag_id, $default = 'date') {

        $orderby = array(
            'none' => 'None',
            'id' => 'Post ID',
            'author' => 'Author',
            'title' => 'Title',
            'date' => 'Date Created',
            'modified' => 'Date Modified',
            'parent' => 'Post/Page Parent ID',
            'rand' => 'Random',
            'comment_count' => 'Number of Comments',
            'menu_order' => 'Page Order',
            
            'votes_count' => 'Likes Count',
            'rating_average' => 'Rating Average',
            'post_views_count' => 'Views Count',
//            'c5_hourly_views'=>'Views Count in the past Hour',
//            'c5_daily_views'=>'Views Count in the past Day',
//            'c5_weekly_views'=>'Views Count in the past 7 Days',
//            'c5_total_share' => 'Social Total Share',
//            'c5_hourly_shares'=>'Social Share Count in the past Hour',
//            'c5_daily_shares'=>'Social Share Count in the past Day',
//            'c5_weekly_shares'=>'Social Share Count in the past 7 Days',
        );

        $array = array();
        foreach ($orderby as $key => $value) {
            $array[] = array(
                'label' => $value,
                'value' => $key
            );
        }

        $ret_array = array(
            'label' => 'Order By',
            'id' => $tag_id,
            'type' => 'Select',
            'desc' => 'Order by a certain parameter',
            'std' => $default,
            'choices' => $array,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        );
        return $ret_array;
    }

    function get_order_array($tag_id, $default = 'DESC') {

        $order = array(
            'ASC' => 'Ascending',
            'DESC' => 'Descending'
        );

        $array = array();
        foreach ($order as $key => $value) {
            $array[] = array(
                'label' => $value,
                'value' => $key
            );
        }

        $ret_array = array(
            'label' => 'Order',
            'id' => $tag_id,
            'type' => 'Select',
            'desc' => 'Order Direction',
            'std' => $default,
            'choices' => $array,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        );
        return $ret_array;
    }

    function get_follow_array($tag_id, $default = 'off') {


        $ret_array = array(
            'label' => 'Follow Current Page query',
            'id' => $tag_id,
            'type' => 'on_off',
            'desc' => 'Follow Current Page query, if you are in category page then the query will be about this category etc.',
            'std' => $default,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => ''
        );
        return $ret_array;
    }

    function get_category_array($tag_id) {

        $all_category = array();


        $args = array(
            'public' => true
        );
        $taxonomies = get_taxonomies($args);
        $all_categories = array();
        foreach ($taxonomies as $key) {
            if (!( $key == 'post_tag' || $key == 'post_format' )) {
                $categories = get_terms($key);
                foreach ($categories as $category) {
                    $taxonomy_data = get_taxonomy($category->taxonomy);
                    foreach ($taxonomy_data->object_type as $post_type) {
                        $obj = get_post_type_object($post_type);
                        if ($category->parent != 0) {
                            $parent_term = get_term($category->parent, $category->taxonomy);
                            $parent = $parent_term->term_taxonomy_id;
                        } else {
                            $parent = 0;
                        }

                        $all_categories[$category->term_taxonomy_id . '_' . $post_type] = array(
                            'id' => $category->term_id,
                            'label' => $category->name,
                            'parent' => $parent,
                            'post_name' => $obj->label,
                            'post_type' => $post_type,
                            'taxonomy' => $category->taxonomy
                        );
                    }
                }
            }
        }


        // this array contains all the childs
        $new_terms = array();

        foreach ($all_categories as $key => $term) {
            if ($term['parent'] != 0) {
                $new_terms[$key] = $term;
            }
        }
        $posts_local = array();
        foreach ($all_categories as $term) {
            if (!isset($posts_local[$term['post_name']])) {
                $posts_local[$term['post_name']] = $term['post_name'];
                $all_category[$term['post_type']] = $term['post_name'] . ' -> All Categories';
            }
            if ($term['parent'] == 0) {
                $all_category[$term['post_type'] . '#' . $term['taxonomy'] . '#' . $term['id']] = $term['post_name'] . ' -> ' . $term['label'];
                foreach ($new_terms as $new_term) {
                    if ($new_term['parent'] == $term['id']) {


                        $all_category[$term['post_type'] . '#' . $term['taxonomy'] . '#' . $new_term['id']] = $term['post_name'] . ' -> ' . $term['label'] . ' -> ' . $new_term['label'];
                    }
                }
            }
        }
        $return = array();
        foreach ($all_category as $key => $value) {
            $return[] = array(
                'label' => $value,
                'value' => $key
            );
        }


        $ret_array = array(
            'label' => 'Post Type & Category',
            'id' => $tag_id,
            'type' => 'Select',
            'desc' => 'Choose the Post type and Category',
            'std' => '',
            'choices' => $return,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        );
        return $ret_array;
    }

    function get_show_paging_array($tag_id, $default = 'on') {


        $ret_array = array(
            'label' => 'Enable Paging',
            'id' => $tag_id,
            'type' => 'select',
            'desc' => 'Enable Paging.',
            'choices' => array(
            	array(
            		'label'=>'Pagination',
            		'value'=>'on'
            	),
            	array(
            		'label'=>'Ajax Loading',
            		'value'=>'ajax'
            	),
            	array(
            		'label'=>'No Pagination',
            		'value'=>'off'
            	),
            ),
            'std' => $default,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => 'c5_show_paging'
        );
        return $ret_array;
    }

    function get_render_type_array($id, $default) {

        $tabs = array(
            'slider',
            'blog-1',
            'blog-2',
            'grid-1',
            'grid-2',
            'grid-3',
            'blog-thumb',
        );
        $tabs_array = array();
        foreach ($tabs as $value) {
            $tabs_array[] = array(
                'src' => C5_URL . 'library/includes/images/blog/' . $value . '.jpg',
                'label' => '',
                'value' => $value,
                'class' => 'c5_posts_img'
            );
        }

        $return = array(
            'label' => 'Posts Apperance',
            'id' => $id,
            'type' => 'radio-image',
            'desc' => '',
            'choices' => $tabs_array,
            'std' => $default,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => ''
        );

        return $return;
    }

    function get_unique_id() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}

$ajax_call = new C5_post();

$ajax_call->hook();
?>