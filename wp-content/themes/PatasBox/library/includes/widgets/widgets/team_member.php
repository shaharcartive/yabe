<?php 

class C5AB_team_member extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $_child_shortcode_bool = true;
	public  $_child_shortcode = 'c5ab_team_member_icon';
	
	function __construct() {
		
		$id_base = 'team-member-widget';
		$this->_shortcode_name = 'c5ab_team_member';
		$name = 'Team Member';
		$desc = 'Add Team Member.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function child_shortcode($atts, $content) {
		    $x = $GLOBALS['team_member_count'];
		    $GLOBALS['team_member'][$x] = array('title' => sprintf($atts['title'], $GLOBALS['tab_count']), 'content' => $content, 'icon' => $atts['icon'] , 'link' => $atts['link']);
		
		    $GLOBALS['team_member_count']++;
	}
	
	function shortcode($atts,$content) {
		
		$GLOBALS['team_member_count'] = 0;
		    unset($GLOBALS['team_member']);
		    do_shortcode($content);
		    
		    
		    if (is_array($GLOBALS['team_member'])) {
		        $tabs = '';
		        foreach ($GLOBALS['team_member'] as $tab) {
		            
		            $tabs .= '<li><a class="' . $tab['icon'] . '" href="' . $tab['link'] . '" target="_blank" title="' . $tab['title'] . '"></a><li>';
		            
		        }
		        $return = '<div class="c5ab_team_member clearfix"><img src="'.$atts['image'].'" alt="'.$atts['name'].'"><h3>'.$atts['name'].'</h3><p>'.$atts['position'].'</p><ul class="team_social">' . $tabs . '</ul></div>' . "\n";
		
		    }
		    return $return;
	}
	
	
	function custom_css() {
		
	}
	
	function options() {
		$icons = new C5AB_ICONS();
		$icons_array = $icons->get_icons_as_images(); 
		$this->_options =array(
			array(
			    'label' => 'Name',
			    'id' => 'name',
			    'type' => 'text',
			    'desc' => 'Team member name.',
			    'std' => 'John Deo',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Position',
			    'id' => 'position',
			    'type' => 'text',
			    'desc' => 'Team member position.',
			    'std' => 'CEO - Founder',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Photo',
			    'id' => 'image',
			    'type' => 'upload',
			    'desc' => 'Team member Photo.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Add Social Icon',
			    'id' => 'c5ab_team_member_icon',
			    'type' => 'list-item',
			    'desc' => 'Add Social Icon to the box.',
			    'settings' => array(
			        array(
			           'label'       => 'Icon',
			           'id'          => 'icon',
			           'type'        => 'radio-text',
			           'desc'        => '',
			           'choices' => $icons_array,
			           'std'         => 'fa fa-facebook',
			           'rows'        => '',
			           'post_type'   => '',
			           'taxonomy'    => '',
			           'class'       => 'c5ab_icons'
			         ),
			        array(
			            'label' => 'Link',
			            'id' => 'link',
			            'type' => 'text',
			            'desc' => 'Icon Url.',
			            'std' => '',
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        )
			    ),
			    'std' => '',
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
		.c5ab_team_member a{display:block;width:43px;height:43px;float:left;margin:1px;line-height:43px;text-align:center;font-size:13px;border-radius:3px;color: #fff; text-decoration: none;  background-color:#303030;-moz-transition:all .2s ease;-o-transition:all .2s ease;-webkit-transition:all .2s ease;-ms-transition:all .2s ease;transition:all .2s ease}
		.c5ab_team_member a:hover{
			color: white;
		}
		.c5ab_team_member{
			text-align:center;
			background:#eee;
			padding-bottom:25px;
		}
		.c5ab_team_member h3{
			margin-bottom:0px;
		}
		.c5ab_team_member a:hover.fa-facebook{background:#4c66a4}
		.c5ab_team_member a:hover.fa-twitter{background:#5dd7fc}
		.c5ab_team_member a:hover.fa-google-plus{background:#d95232}
		.c5ab_team_member a:hover.fa-vimeo-square{background:#4bf}
		.c5ab_team_member a:hover.fa-youtube{background:#e22c28}
		.c5ab_team_member a:hover.fa-flickr{background:#ff0080}
		.c5ab_team_member a:hover.fa-dribbble{background:#e24a85}
		.c5ab_team_member a:hover.fa-linkedin{background:#0274b3}
		.c5ab_team_member a:hover.fa-tumblr{background:#35506b}
		.c5ab_team_member a:hover.fa-pinterest{background:#cb2028}
		.c5ab_team_member a:hover.fa-github{background:#3e3e3e}
		.c5ab_team_member a:hover.fa-dropbox{background:#1665a7}
		.c5ab_team_member a:hover.fa-rss{background:#ff6501}
		
		ul.team_social{
			margin: 0px;
			padding: 0px;
			list-style: none;
			text-align:center;
		}
		ul.team_social li{
			display: inline-block;
		}
	</style>
	<?php
	}

}


 ?>