<?php 

class C5AB_authors_info extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'authors_info-widget';
		$this->_shortcode_name = 'c5ab_authors_info';
		$name = 'Authors Info';
		$desc = 'Authors Info Box.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		if($atts['author_id'] == ''){
			$user_ID = get_the_author_meta('ID');
		}else {
			$user_ID = $atts['author_id'] ;
		}
		
		$user_info = get_userdata($user_ID);
		
		$title = $user_info->display_name;
		$subtitle = '';
		$image_src = '';
		$color_mode = 'dark';
		$small_text = '';
		$icon ='';
		$lum=0;
		$data='';
		
		$subtitle =  $user_info->description;
		$image_src =  get_the_author_meta('c5_term_meta_user_cover', $user_ID);
		
		if($image_src==''){
			$image_src = ot_get_option('default_cover');
		} 
		
		
		
		$social_icons =array();
		
		$facebook = get_the_author_meta('c5_term_meta_user_facebook', $user_ID);
			if($facebook!=''){
				$facebook = 'http://www.facebook.com/'.$facebook;
			}
		$social_icons['fa-facebook'] = $facebook;
		
		$twitter = get_the_author_meta('c5_term_meta_user_twitter', $user_ID);
		if($twitter!=''){
			$twitter = 'http://www.twitter.com/'.$twitter;
		}
		$social_icons['fa-twitter'] = $twitter;
		
		$google = get_the_author_meta('c5_term_meta_user_google_plus', $user_ID);
		if($google!=''){
			$google = 'http://www.google.com/+'.$google;
		}
		$social_icons['fa-google-plus'] = $google;
		
		$social_icons['fa-linkedin']= get_the_author_meta('c5_term_meta_user_linkedin', $user_ID);
		
		$social_icons['fa-envelope'] = $user_info->user_email;
		$social_icons['fa-link'] = $user_info->user_url;
		
		$data .= '<div class="c5-author-info-wrap">
		    <div class="c5-upper clearfix">
		    	<img src="'.$image_src.'" class="c5-cover-author" alt="" />
		    </div>
		    <div class="c5-image"><a href="'.get_author_posts_url($user_ID).'">'.get_avatar( $user_ID, 200 ).'</a></div>
		    <div class="c5-lower">
		    	<h3><a href="'.get_author_posts_url($user_ID).'">'. $title  .'</a></h3>
		    	<ul class="author-social">';
		    	 
		    		foreach ($social_icons as $icon => $value) {
		    			if($value!=''){
		    				if($icon =='fa-envelope'){
		    					$data .=  '<li><a href="mailto:'.$value.'" target="_blank"><span class="fa '.$icon.'"></span></a></li>';
		    				}else {
		    					$data .=  '<li><a href="'.$value.'" target="_blank"><span class="fa '.$icon.'"></span></a></li>';
		    				}
		    				
		    			}
		    		}
		    	 $data .= '</ul>';
		    	 if ($subtitle!='') { 
		    		$data .= '<p class="description">'. $subtitle .'</p>';
		    	 } 
		    $data .= '</div>
		</div>';
				
		return $data;
		
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$array = array();
		        $array[] = array(
		            'label' => 'Current Article Authors',
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
		
		$this->_options =array(
			
			array(
			    'label' => 'Author',
			    'id' => 'author_id',
			    'type' => 'select',
			    'desc' => 'Choose the Author',
			    'std' => '',
			    'choices' => $array,
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			)
		 
		);
	}
	
	function css() {
		?>
		<style>
		.c5-user-description{
			padding: 15px;
			font-size: 13px;
			background: #eee;
			position: relative;
			display: block;
			margin-bottom:30px;
		}
		.c5-user-description:after{
			width: 0;
			height: 0;
			content: '';
			border-left: 14px solid transparent;
			border-right: 14px solid transparent;
			border-top: 14px solid transparent;
			border-bottom: 14px solid #eee;
			position: absolute;
			display: block;
			top: -28px;
			left: 20px;
			-webkit-transition: all .2s ease;
			-moz-transition: all .2s ease;
			-ms-transition: all .2s ease;
			-o-transition: all .2s ease;
			transition: all .2s ease;
		}
		.c5-author-meta-wrap {
		  position: relative;
		  min-height: 100px;
		  display: block;
		  margin-bottom: 30px;
		}
		.c5-author-meta-wrap .c5-author-img {
		  width: 100px;
		  height: 100px;
		  display: block;
		  position: absolute;
		  top: 0px;
		  left: 0px;
		}
		.c5-author-meta-wrap .list-icon {
		  width: 100px;
		  height: 100px;
		  background: #eee;
		  line-height: 100px;
		  text-align: center;
		  font-size: 40px;
		  display: block;
		  position: absolute;
		  top: 0px;
		  left: 0px;
		}
		.c5-author-meta-wrap .c5-author-data {
		  padding-left: 130px;
		  display: block;
		  position: relative;
		}
		.c5-author-meta-wrap .c5-author-data .fa {
		  margin-right: 5px;
		}
		.c5-author-meta-wrap .url.fn {
		  color: #333;
		  font-size: 16px;
		  margin-bottom: 10px;
		  font-weight: bold;
		}
		
		</style>
		<?php
	}

}


 ?>