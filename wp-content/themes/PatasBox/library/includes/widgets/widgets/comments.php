<?php 

class C5AB_comment extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $_skip_title = true;
	
	function __construct() {
		
		$id_base = 'comment-widget';
		$this->_shortcode_name = 'c5ab_comment';
		$name = 'Comments';
		$desc = 'Comments list.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		
		$args = array(
				'status' => 'approve',
				'number' => $atts['number'],
				'post_type' => 'post'
			);
			$comments = get_comments($args);
			
			$data ='';
			foreach($comments as $comment) :
				
				$data .=   '<li class="clearfix">';
				
				$data .= get_avatar($comment->user_id,$size='100',$default= ot_get_option('avatar') );
				$data .=  '<a href="'.get_permalink($comment->comment_post_ID).'">' . substr($comment->comment_content, 0, 80). '</a>';
				$data .=   '</li>';
			endforeach;
			
			$title = do_shortcode('[c5ab_title apperance="title-style-1" title="' . $atts['title'] . '" font_size="20" font_weight="300" transform="normal" class="" icon="fa fa-comment" link="" id="" ]');
		
		return $title . '<ul class="comments_list">' . $data . '</ul>';
		
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
	
		$this->_options =array(
			
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Title .',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Number of Comments',
			    'id' => 'number',
			    'type' => 'numeric-slider',
			    'desc' => 'Number of Comments to show.',
			    'std' => '5',
			    'min_max_step' => '1,20,1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
		 
		);
	}
	
	function css() {
		?>
		<style>
		ul.comments_list li{
			padding-left:0px;
			padding-right:0px;
		}
		ul.comments_list li img{
			float: left;
			margin-right:15px;
			width: 50px;
			border-radius:2px;
		}
		ul.comments_list li a{
			font-size:12px;
			line-height:1.3;
		}
		</style>
		<?php
	}

}


 ?>