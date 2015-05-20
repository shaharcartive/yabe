<?php 

class C5AB_image extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'image-widget';
		$this->_shortcode_name = 'c5ab_image';
		$name = 'Image';
		$desc = 'Image with Caption and Popup.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
			if($atts['width']!='9999' && $atts['height']!='9999'){
				$image_size = c5ab_generate_image_size($atts['width'], $atts['height'], true);
			}elseif($atts['width']=='9999') {
				$image_size = c5ab_generate_image_size('9999', $atts['height'], false);
			}elseif($atts['height']=='9999') {
				$image_size = c5ab_generate_image_size($atts['width'], '9999' , false);
			}else {
				$image_size = 'full';
			}
		    $img_id = c5ab_get_attachment_id_from_src($atts['url']);
		    if($img_id!=''){
		    	$image_url = wp_get_attachment_image_src($img_id, $image_size);
		    }else {
	    		$image_url = array(
	    			$atts['url'],'',''
	    		);
	    	}
		    if($image_url[1]== '' ){
		    	$image_url[1] = 'auto';
		    }
		    if($image_url[2]== ''){
		    	$image_url[2] = 'auto';
		    }
		    
		    $data = '<div class="c5ab-image-wrap ' . $atts['align'] . ' article-'.$atts['article'].'">';
		    
		    if($atts['type']== 'link'){
		    $data .= '<a href="'.$atts['link'].'" target="_blank"><img title="'.$atts['title'].'"  alt="'.$atts['alt'].'" src="' . $image_url[0] . '" width="' . $image_url[1] . '" height="' . $image_url[2] . '" class="'.$atts['class'].'" alt="'.$atts['caption'].'" /></a>';
		    }elseif ($atts['type']== 'popup') {
		    	$data .= '<a class="c5ab_popup" href="'.$atts['url'].'" title="'.$atts['caption'].'">';
		    	
		    	$data .= '<img title="'.$atts['title'].'" alt="'.$atts['alt'].'"  src="' . $image_url[0] . '" width="' . $image_url[1] . '" height="' . $image_url[2] . '" class="c5ab_popup '.$atts['class'].'" alt="'.$atts['caption'].'" />';
		    	
		    	$data .= '</a>';
		    }else {
		    	$data .= '<img title="'.$atts['title'].'"  alt="'.$atts['alt'].'"  src="' . $image_url[0] . '" width="' . $image_url[1] . '" height="' . $image_url[2] . '" alt="'.$atts['caption'].'" class="'.$atts['class'].'" />';
		    }
		    if($atts['caption']!=''){
		    
		    $data .= '<p class="caption">'.$atts['caption'].'</p>';
		    
		    }
		    
		    $data .= '</div>';
		    
		    
		    
		    
		
		    return $data;
		
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
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
		
		$this->_options =array(
			
			array(
			    'label' => 'Image',
			    'id' => 'url',
			    'type' => 'upload',
			    'desc' => 'Upload your Image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Class',
			    'id' => 'class',
			    'type' => 'text',
			    'desc' => 'Add a class to the image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Width',
			    'id' => 'width',
			    'type' => 'numeric-slider',
			    'desc' => 'Slide to set the image width, leave it in 9999 to be auto.',
			    'std' => '9999',
			    'min_max_step' => '10,9999,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Height',
			    'id' => 'height',
			    'type' => 'numeric-slider',
			    'desc' => 'Slide to set the image height, leave it in 9999 to be auto.',
			    'std' => '9999',
			    'min_max_step' => '10,9999,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Link',
			    'id' => 'link',
			    'type' => 'text',
			    'desc' => 'Add a url if you want to the image to be clickable.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Alt "Alternative text"',
			    'id' => 'alt',
			    'type' => 'text',
			    'desc' => 'Add Alternative text to the image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Add Title tag to the image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Caption',
			    'id' => 'caption',
			    'type' => 'text',
			    'desc' => 'Add Caption to the image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Make it Article Formatted',
			    'id' => 'article',
			    'type' => 'on_off',
			    'desc' => 'Make it Article Formatted.',
			    'std' => 'off',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Click Type',
			    'id' => 'type',
			    'type' => 'select',
			    'desc' => 'Choose Click type for that image.',
			    'std' => 'none',
			    'choices'=>array(
			    	array(
			    		'label'=>'None',
			    		'value'=>'none'
			    	),
			    	array(
			    		'label'=>'Popup',
			    		'value'=>'popup'
			    	),
			    	array(
			    		'label'=>'Link',
			    		'value'=>'link'
			    	)
			    ),
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Link',
			    'id' => 'link',
			    'type' => 'text',
			    'desc' => 'Add Link for the image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			  'label'       => 'Image Alignment',
			  'id'          => 'align',
			  'type'        => 'radio-image',
			  'desc'        => 'Choose Image Alignment',
			  'choices' => $row_align_array,
			  'std'         => 'left',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => ''
			),
		    
		);
	}
	
	function css() {
		?>
		<style>
		
		.c5ab-image-wrap{
			margin-bottom:15px;
		}
		.c5ab_popup{
			cursor: pointer;
		}
		.c5ab-image-wrap.article-on{
			padding: 15px;
			background: #f8f8f8;
			border-radius:2px;
		}
		.c5ab-image-wrap.left.article-off{
			text-align:left;
		}
		.c5ab-image-wrap.center{
			text-align:center;
		}
		.c5ab-image-wrap.center img,
		.c5ab-image-wrap.article-on img{
			display: block;
			margin: 10px auto;
		}
		.c5ab-image-wrap.right.article-off{
			text-align:right;
			direction:rtl;
		}
		.c5ab-image-wrap img{
			max-width:100%;
			height: auto;
		}
		
		</style>
		<?php
	}

}


 ?>