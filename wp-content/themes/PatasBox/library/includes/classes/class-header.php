<?php

class C5_build_header {

    function __construct() {
        
    }

    function hook() {

        add_action('wp_footer', array($this, 'footer'), 300);
    }

    function footer() {
        global $c5_skindata;
        ?>
        <script  type="text/javascript">
            /***General Custom CSS**/
        <?php echo esc_js( ot_get_option('custom_js')); ?>
            /***Skin Custom CSS**/
        <?php echo esc_js( $c5_skindata['custom_js']); ?>

        </script>
        <?php
    }

    function floating_bar() {
        global $c5_headerdata;
        global $c5_skindata;
        if ($c5_headerdata['floating_enable'] == 'off') {
            return;
        }
        $search_on = ot_get_option('search_on');
        ?>

        <header class="header header_floating" role="banner">
        
        <div class="mi-cuenta-cart">
          <ul class="c5-main-width-wrap clearfix">
			  <li class="texto-cabecera"><?php the_field('texto_fecha_de_suscripcion_cabecera');?></li>
              <li class="mi-cuenta">
                <a href="http://htcvr.es/sandbox/wishlist/view/"><span class="c5ab-single-icon-SRoiJ c5ab-single-icon-TFvfS fa fa-heart"></span> Wishlist</a>
              </li>
              <li class="mi-cuenta">
                <a href="http://htcvr.es/sandbox/mi-cuenta/"><span class="c5ab-single-icon-SRoiJ c5ab-single-icon-TFvfS fa fa-user"></span> Mi cuenta</a>
              </li>

			<?php global $woocommerce; ?>               
			  <li class="cart">
            	<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'Ver Carrito' );?>"><span class="c5ab-single-icon-SRoiJ fa fa-shopping-cart"></span> 
            	<span class="products-cart"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?></span>
            	</a>	            	
			  </li>
		  </ul>
		</div>

            <div  class="inner-header c5-main-width-wrap clearfix">
                <div class="c5-logo-wrap clearfix">
                    <div class="c5-left" ><?php $this->get_current_logo(); ?></div> 

                    <div class="c5-left c5-floating-article-header" >
                        <?php
                        if (is_single()) {
                            echo '<h3>' . get_the_title() . '<span class="c5-hide-rest"></span></h3>';

                          //  echo '<div class="c5-header-like-button"><div class="fb-like" data-href="' . get_permalink() . '" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></div>';
                        }
                        ?>
                    </div>
                    <div class="c5-middle">
                        <?php
                        echo(do_shortcode('[c5ab_menu location="' . $c5_headerdata['header_menu'] . '" responsive="on" style="default" bg_mode="light" ]'));
                        if ($c5_skindata['page_width'] != 'full') {
                         //   echo '<span class="fa fa-align-justify c5-sidebar-handle" ></span>';
                        }
                        ?>
                    </div>
                    <div class="c5-right">
                    	<nav class="navigation-shortcode responsive-on light default top-menu-nav clearfix" role"navigation">
							<?php 
								$args = array(
								    'menu_class' => 'top-nav menu-sc-nav clearfix',        
								    'menu' => 'Crea tu caja'
								);
								wp_nav_menu( $args ); 
							
	                        	if ($search_on != 'off') {
	                            //	echo '<span class="fa fa-search c5-search-handle"></span>';
	                        	}
	                        ?>
						</nav>
                    </div>
                </div>
            </div>
            <span class="c5-reading-progress"></span>
        </header>
        <?php
    }

    function main_content() {
        global $c5_headerdata;
        global $c5_skindata;

        $search_on = ot_get_option('search_on');

        if ($search_on != 'off') {
            ?>
            <div id="c5-search-area">
                <form method="get" action="<?php echo home_url() ?>">
                    <?php
                    $value = '';
                    if (isset($_GET['s'])) {
                        $value =  $_GET['s'];
                    }
                    ?>
                    <input type="text" name="s" value="<?php echo esc_attr($value) ?>" placeholder="<?php _e('Type then hit return', 'code125'); ?>" />

                    <span class="fa fa-search search-icon"></span>

                    <span class="fa fa-times close-icon"></span>
                </form>
            </div>
        <?php } ?>


        <header class="header" role="banner">
			
			<div class="mi-cuenta-cart">
              <ul class="c5-main-width-wrap clearfix">
				  <li class="texto-cabecera"><?php the_field('texto_fecha_de_suscripcion_cabecera');?></li>
                  <li class="mi-cuenta">
                <a href="http://htcvr.es/sandbox/wishlist/view/"><span class="c5ab-single-icon-SRoiJ c5ab-single-icon-TFvfS fa fa-heart"></span> Wishlist</a>
              </li>
	              <li class="mi-cuenta">
	                <a href="http://htcvr.es/sandbox/mi-cuenta/"><span class="c5ab-single-icon-SRoiJ c5ab-single-icon-TFvfS fa fa-user"></span> Mi cuenta</a>
	              </li>

				<?php global $woocommerce; ?>               
				  <li class="cart">
	            	<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'Ver Carrito' );?>"><span class="c5ab-single-icon-SRoiJ fa fa-shopping-cart"></span> 
	            	
	            	<span class="products-cart"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?></span>
	            	</a>	            	
				  </li>
			  </ul>
			</div>
			
            <div  class="inner-header c5-main-width-wrap clearfix">
                <div class="c5-logo-wrap clearfix">
                    <div class="c5-left" ><?php $this->get_current_logo(); ?></div>
                    <div class="c5-middle">
                        <?php
                        echo(do_shortcode('[c5ab_menu location="' . $c5_headerdata['header_menu'] . '" responsive="on" style="default" bg_mode="light" ]'));
                        if ($c5_skindata['page_width'] != 'full') {
                          //  echo '<span class="fa fa-align-justify c5-sidebar-handle" ></span>';
                        }
                        ?>
                    </div>
                    <div class="c5-right">
                    	<nav class="navigation-shortcode responsive-on light default top-menu-nav clearfix" role"navigation">
							<?php 
								$args = array(
								    'menu_class' => 'top-nav menu-sc-nav clearfix',        
								    'menu' => 'Crea tu caja'
								);
								wp_nav_menu( $args ); 
							
	                        	if ($search_on != 'off') {
	                            //	echo '<span class="fa fa-search c5-search-handle"></span>';
	                        	}
	                        ?>
						</nav>
                    </div>
                </div>
            </div>
            <span class="c5-reading-progress"></span>
        </header>
        <?php
    }

    function get_current_logo() {
        global $c5_headerdata;
        if ($c5_headerdata['logo'] != '') {
            $logo_url = $c5_headerdata['logo'];
        } else {
            $logo_url = ot_get_option('logo');
            if ($logo_url == '') {
                $top_margin = ot_get_option('logo_margin');
                if ($top_margin == '') {
                    $top_margin = '12';
                }
                $data = '<a class="clearfix c5-orignial-logo c5-logo" id="logo" style="margin-top:' . $top_margin . 'px" href="' . esc_url(home_url() ) . '" rel="nofollow"><img  src="'  . esc_attr(  C5_URL . 'library/images/logo.png') .'"  /></a>';
                echo $data;
                return;
            }
        }

        $image_url = c5_generate_image(9999, $c5_headerdata['logo_height'], $logo_url, false);

        if ($image_url[1] == 0) {
            $image_url[1] = '';
        }
        if ($image_url[2] == 0) {
            $image_url[2] = '';
        }

        $width = '';
        if ($image_url[1] != '') {
            $width = ' width="' . $image_url[1] . '" ';
        }
        $height = '';
        if ($image_url[2] != '') {
            $height = ' height="' . $image_url[2] . '" ';
        }

        $data = '<a class="clearfix c5-orignial-logo c5-logo"  style="margin-top:' . $c5_headerdata['logo_margin'] . 'px" href="' . esc_url( home_url() ) . '" rel="nofollow"><img alt="Logo" src="' . esc_url( $image_url[0] ). '" ' . $width . ' ' . $height . ' /></a>';



        echo $data;
    }

    function header_author_content() {
        global $c5_skindata;

        $obj = get_queried_object();
        $user_ID = $obj->ID;
        $user_info = get_userdata($obj->ID);

        $title = $user_info->display_name;
        $subtitle = '';
        $image_src = '';
        $color_mode = 'dark';
        $small_text = '';
        $icon = '';
        $lum = 0;

        $subtitle = $user_info->description;
        $image_src = get_the_author_meta('c5_term_meta_user_cover', $user_ID);

        if ($image_src == '') {
            $image_src = ot_get_option('default_cover');
        }

        if ($image_src == '') {
			/* $image_src = C5_URL . 'library/images/default.jpg'; */
        }

        if ($image_src != '') {
            $lum = intval(c5_get_avg_luminance($image_src));
            if ($lum > 170) {
                $color_mode = 'light';
            } else {
                $color_mode = 'dark';
            }
        }

        $center_class = 'c5-main-width-wrap';
        $social_icons = array();

        $facebook = get_the_author_meta('c5_term_meta_user_facebook', $user_ID);
        if ($facebook != '') {
            $facebook = 'http://www.facebook.com/' . $facebook;
        }
        $social_icons['fa-facebook'] = $facebook;

        $twitter = get_the_author_meta('c5_term_meta_user_twitter', $user_ID);
        if ($twitter != '') {
            $twitter = 'http://www.twitter.com/' . $twitter;
        }
        $social_icons['fa-twitter'] = $twitter;

        $google = get_the_author_meta('c5_term_meta_user_google_plus', $user_ID);
        if ($google != '') {
            $google = 'http://www.google.com/+' . $google;
        }
        $social_icons['fa-google-plus'] = $google;

        $social_icons['fa-linkedin'] = get_the_author_meta('c5_term_meta_user_linkedin', $user_ID);

        $social_icons['fa-envelope'] = $user_info->user_email;
        $social_icons['fa-link'] = $user_info->user_url;
        ?>
        <div class="c5-main-header-wrap c5-content-<?php echo $color_mode; ?>">
            <div class="c5-inner-header-wrap">
                <style >
                    .c5-main-header-wrap{
                        background-image: url('<?php echo esc_url( $image_src ) ?>');
                    }
                </style>
                <?php
                $width_class = 'c5-sidebar-hidden';
                switch ($c5_skindata['page_width']) {
                    case 'left':
                        $width_class = 'c5-sidebar-active';
                        break;
                    case 'right':
                        $width_class = 'c5-sidebar-active';
                        break;
                    default:
                        break;
                }
                echo '<div class="c5-main-width-wrap c5-main-page-wrap-sidebar ' . $width_class . ' c5-page-' . $c5_skindata['page_width'] . ' clearfix"><div class="c5-main-header-ad clearfix">' . $this->get_main_header_ad('728x90', true) . '</div><div class="row"><div class="c5-middle-control clearfix"><div class="c5-main-content-area c5-single-content clearfix">';
                ?>
                <div class="c5-dark-shadow c5-content-<?php echo $color_mode; ?>" >
                    <div class="c5-header-data wow c5-author-content fadeInDown">
                        <div class="row">
                            <div class="col-sm-2">
                                <?php echo get_avatar($obj->ID, 200); ?>
                            </div>
                            <div class="col-sm-10">
                                <h1  ><?php echo $icon; ?><?php echo $title; ?></h1>
                                <ul class="author-social">
                                    <?php
                                    foreach ($social_icons as $icon => $value) {
                                        if ($value != '') {
                                            if ($icon == 'fa-envelope') {
                                                echo '<li><a href="mailto:' . sanitize_email($value) . '" target="_blank"><span class="fa ' . $icon . '"></span></a></li>';
                                            } else {
                                                echo '<li><a href="' . esc_url($value) . '" target="_blank"><span class="fa ' . $icon . '"></span></a></li>';
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                                <?php if ($subtitle != '') { ?>
                                    <p class="description"><?php echo esc_attr($subtitle) ?></p>	
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div><div class="c5-single-content c5-sidebar-wrap clearfix"><?php echo $this->get_main_header_ad('300x250', false) ?></div></div></div></div>

        </div>
        </div>


        <?php
    }

    function header_page_custom() {
        $color_mode = 'dark';

        $page_ID = get_the_ID();

        if (class_exists('WooCommerce')) {
            if (is_woocommerce() || is_checkout() || is_cart()) {
                $page_ID = c5_wc_get_current_page();
            }
        }

        $c5_force = get_post_meta($page_ID, 'c5_force', true);
        $c5_content = get_post_meta($page_ID, 'c5_content', true);
        $c5_top_slider = get_post_meta($page_ID, 'c5_top_slider', true);
        $content = '';
        
        if ($c5_top_slider == 'on') {
        	$slider_post_type = get_post_meta($page_ID, 'slider_post_type', true);
        	$slider_orderby = get_post_meta($page_ID, 'slider_orderby', true);
        	$slider_posts_per_page = get_post_meta($page_ID, 'slider_posts_per_page', true);
        	$slider_posts = get_post_meta($page_ID, 'slider_posts', true);
        	
        	$content = '[c5ab_posts render_type="slider" follow="off" posts_per_page="'.$slider_posts_per_page.'" post_type="'.$slider_post_type.'" orderby="'.$slider_orderby.'" posts="'.$slider_posts.'" order="DESC" paging="off" ]';
        	
        }
        
        if ($c5_content != '') {
        	$content = $c5_content;
        }
        
        $skip_bg = 'no-skip-bg';

        switch ($c5_force) {
            case 'light':
                $color_mode = 'light';
                break;
            case 'dark':
                $color_mode = 'dark';
                break;
            case 'dark_bg':
                $color_mode = 'dark';
                $skip_bg = 'skip-bg';
                break;
            case 'light_bg':
                $color_mode = 'light';
                $skip_bg = 'skip-bg';
                break;
            default:
                $color_mode = 'dark';
                break;
        }
        ?>
        <div class="c5-main-header-wrap c5-custom-page c5-content-<?php echo $color_mode; ?> <?php echo $skip_bg ?>">

            <?php echo do_shortcode($content) ?>

        </div>
        <?php
    }

    function homepage_slider() {
        $color_mode = 'dark';
        ?>
        <div class="c5-main-header-wrap c5-custom-page c5-content-<?php echo $color_mode; ?>">

            <?php echo do_shortcode('[c5ab_posts render_type="slider" follow="off" posts_per_page="5" post_type="post" orderby="comment_count" order="DESC" paging="off" ]'); ?>

        </div>
        <?php
    }

    function get_header_image() {
        $image_src = '';
        $color_mode = 'dark';
        $small_text = '';
        $icon = '';
        $lum = 0;
    }

    function header_content() {
        global $c5_skindata;
        $title = '';
        $subtitle = '';
        $image_src = '';
        $color_mode = 'dark';
        $small_text = '';
        $icon = '';
        $lum = 0;
        if (is_category() || is_tag() || is_tax()) {
            $obj = get_queried_object();

            $title = $obj->name;
            $image_src = get_option('c5_term_meta_' . $obj->taxonomy . '_' . $obj->term_id . '_cover');
            $icon = get_option('c5_term_meta_' . $obj->taxonomy . '_' . $obj->term_id . '_icon');
            $subtitle = $obj->description;
        } elseif (is_author()) {

            $this->header_author_content();
            return;
        } elseif (is_search()) {

            $image_src = ot_get_option('search_cover');
            $title = __('Search results for', 'code125') . ': ' . $_GET['s'];
        } elseif (is_home()) {
            $this->homepage_slider();
            return;
        } elseif (is_page() || is_single()) {
            $c5_content = get_post_meta(get_the_ID(), 'c5_content', true);
            $c5_top_slider = get_post_meta(get_the_ID(), 'c5_top_slider', true);
            if ($c5_content != '' || $c5_top_slider == 'on') {
                $this->header_page_custom();
                return;
            }
            $title = get_the_title();
            $alt_title = $subtitle = get_post_meta(get_the_ID(), 'c5_title', true);
            if ($alt_title != '') {
                $title = $alt_title;
            }
            $subtitle = get_post_meta(get_the_ID(), 'c5_subtitle', true);

            $image_size = c5ab_generate_image_size(1000, 600, true);
            $attachment_id = get_post_thumbnail_id(get_the_ID());
            $image_attributes = wp_get_attachment_image_src($attachment_id, $image_size);
            if ($image_attributes) {
                $image_src = $image_attributes[0];
            }
        } elseif (is_404()) {
            $title = __('404 Error, Page not Found', 'code125');
            $subtitle = '';
        } elseif (is_archive()) {
            $title = single_month_title('', false);
        }
        if (is_single()) {
            $post_obj = new C5_post();
            $type = get_post_type(get_the_ID());
            if ($type == 'product') {
                global $post, $product;
                $product = new WC_Product(get_the_ID()); 
                $in_stock = $product->is_in_stock() ? 'InStock' : 'OutOfStock';
             //   $small_text = '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            	//	 	<p class="price">' . $product->get_price_html() . '</p>
            	//	 	<meta itemprop="price" content="' . $product->get_price() . '" />
            	//	 	<meta itemprop="priceCurrency" content="' . get_woocommerce_currency() . '" />
            	//	 	<link itemprop="availability" href="http://schema.org/' . $in_stock . '" />
            	//	 </div>';
            } else {
                $small_text = $post_obj->get_meta_categories() . '<div class="clearfix"></div>';
            }
        }



        if ($image_src == '') {
            $image_src = ot_get_option('default_cover');
        }
        if ($image_src == '') {
			/*$image_src = C5_URL . 'library/images/default.jpg';*/
        }



        if (class_exists('WooCommerce')) {
            if (is_woocommerce() || is_checkout() || is_cart()) {
                $page_id = c5_wc_get_current_page();
                if ($page_id) {
                    $title = get_the_title($page_id);
                    $subtitle = get_post_meta($page_id, 'c5_subtitle', true);

                    $return = $this->check_color_for_page($page_id);
                    if ($return != '') {
                        $color_mode = $return;
                    }

                    $image_size = c5ab_generate_image_size(1000, 600, true);
                    $attachment_id = get_post_thumbnail_id($page_id);
                    $image_attributes = wp_get_attachment_image_src($attachment_id, $image_size);
                    if ($image_attributes) {
                        $image_src = $image_attributes[0];
                    }
                }
            }
        }

        if (isset($_POST['c5-image-bg']) && $_POST['c5-image-bg'] != '') {
            $image_src = esc_url($_POST['c5-image-bg']);
        }

        if ($image_src != '') {
            $lum = intval(c5_get_avg_luminance($image_src));
            if ($lum > 170) {
                $color_mode = 'light';
            } else {
                $color_mode = 'dark';
            }
        }

        if (is_page()) {
            $return = $this->check_color_for_page(get_the_ID());
            if ($return != '') {
                $color_mode = $return;
            }
        }

        $center_class = 'c5-main-width-wrap';
        if (is_page()) {
            $center_class = c5_get_header_width_class();
        }
        if ($icon != '') {
            $icon = '<span class="' . $icon . '"></span>';
        }
        ?>
        <div class="c5-main-header-wrap c5-content-<?php echo $color_mode; ?>">
            <div class="c5-inner-header-wrap">

                <!--<style  >
                    .c5-main-header-wrap{
                        background-image: url('<?php // echo esc_url($image_src) ?>');
                    }
                </style>-->
                <?php
                $width_class = 'c5-sidebar-hidden';
                switch ($c5_skindata['page_width']) {
                    case 'left':
                        $width_class = 'c5-sidebar-active';
                        break;
                    case 'right':
                        $width_class = 'c5-sidebar-active';
                        break;
                    default:
                        break;
                }
                echo '<div class="c5-main-width-wrap c5-main-page-wrap-sidebar ' . $width_class . ' c5-page-' . $c5_skindata['page_width'] . ' clearfix"><div class="c5-main-header-ad clearfix">' . $this->get_main_header_ad('728x90', true) . '</div><div class="row"><div class="c5-middle-control clearfix"><div class="c5-main-content-area c5-single-content clearfix">';
                ?>
                <div class="c5-dark-shadow c5-content-<?php echo $color_mode; ?>" >

                    <div class="c5-header-data wow fadeInDown">
                        <!--<h1><?php // echo $icon; ?><?php // echo $title; ?></h1>-->
                        <?php if ($subtitle != '') { ?>
                        	<div class="logo-marca">
                        		<?php echo get_brand_thumbnail_url( $brand_id );?>
                        		
                        		<?php echo do_shortcode("[product_brand]");?>
                        	</div>
                            <p class="description"><?php echo esc_attr($subtitle) ?></p>	
                        <?php } ?>
                        
                        <?php
							if ( is_front_page() ) { ?>
								<a href="<?php echo get_permalink( 1591 ); ?>"><button class="text-center red marg">Descubre más</button></a>
								<a href="<?php echo get_permalink( 1668 ); ?>"><button class="text-center green">Crea tu caja</button></a>
							<?php } elseif (is_page('por-que-patasbox')) { ?>
								<a href="<?php echo get_permalink( 1668 ); ?>"><button class="text-center green">Crea tu caja</button></a>
							<?php } elseif (is_page('como-funciona')) { ?>
								<a href="<?php echo get_permalink( 1668 ); ?>"><button class="text-center red">Crea tu caja</button></a>
							<?php } else { ?>
							
							<?php } ?>
                        <?php echo $small_text; ?>                                     
                    </div>
                    </div>
                </div>
            </div>
            <div class="c5-single-content c5-sidebar-wrap clearfix"><?php echo $this->get_main_header_ad('300x250', false) ?></div></div></div></div>
        </div>
        </div>
        <?php
    }

    function get_main_header_ad($size = '728x90', $main_ad = false) {
        global $c5_headerdata;
        $return = '';
        if (isset($c5_headerdata['main_ad']) && ( $c5_headerdata['main_ad'] == $size || $c5_headerdata['main_ad'] == 'both' )) {
            if ($main_ad) {
                $size = '728x90';
            } else {
                $size = '300x250';
            }
            $return =  $c5_headerdata['main_ad_content_' . $size] ;
        }
        return do_shortcode($return);
    }

    function check_color_for_page($id) {
        $c5_force = esc_attr(get_post_meta($id, 'c5_force', true));
        if ($c5_force == 'light') {
            return 'light';
        }
        if ($c5_force == 'dark') {
            return 'dark';
        }
    }

}
?>