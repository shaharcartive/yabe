<?php
if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
	$header_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
	
	if (strpos($header_encoding, 'gzip')) {
	    ob_start("ob_gzhandler");
	}	
}
$header_obj = new C5_build_header();
$header_obj->hook();
$header_css = new C5_header_css();
$header_css->hook();
?>
<!doctype html>                                                                                                                             
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->                                                                                                                                <!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->                                                                                                                                <!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

    <head>
        <meta charset="utf-8">
		
		<title><?php wp_title(); ?> </title>
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <?php $favicon = ot_get_option('favicon');?>

        <?php $image_url = c5_generate_image(16, 16, $favicon, true); ?>
        <link rel="icon" href="<?php echo esc_url($image_url[0]) ?>" sizes="16x16">
        <?php $image_url = c5_generate_image(32, 32, $favicon, true); ?>
        <link rel="icon" href="<?php echo esc_url($image_url[0]) ?>" sizes="32x32">
        <?php $image_url = c5_generate_image(48, 48, $favicon, true); ?>
        <link rel="icon" href="<?php echo esc_url($image_url[0]) ?>" sizes="48x48">
        <?php $image_url = c5_generate_image(64, 64, $favicon, true); ?>
        <link rel="icon" href="<?php echo esc_url($image_url[0]) ?>" sizes="64x64">
        <?php $image_url = c5_generate_image(128, 128, $favicon, true); ?>
        <link rel="icon" href="<?php echo esc_url($image_url[0]) ?>" sizes="128x128">

        <!--[if IE]>
                <link rel="shortcut icon" href="<?php echo esc_url($image_url[0]) ?>">
        <![endif]-->
        <?php // or, set /favicon.ico for IE10 win     ?>
        <meta name="msapplication-TileImage" content="<?php echo esc_url($image_url[0]) ?>">

        <link rel="pingback" href="<?php esc_url( bloginfo('pingback_url')); ?>">
        <?php wp_head(); ?>
    </head>
	<?php 
	
	$color_scheme = ot_get_option('color_scheme');
	if ($color_scheme=='') {
		$color_scheme = 'light';
	}
	 ?>
    <body <?php body_class('c5-body-class c5-scheme-'.$color_scheme); ?>>
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-59C5BM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-59C5BM');</script>
		<?php 
		$preload = ot_get_option('preload');
		if ($preload!='off') {
			?>
			<div class="c5-pre-con">
				<div class="center">
					<div class="c5-top-spinner"></div>
				</div>
			</div>
		    <?php
		}
        $preview = ot_get_option('preview');
        if ($preview == 'on') {
            $C5_preview_obj = new C5_preview();
            $C5_preview_obj->render();
        }
        ?>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&appId=<?php echo ot_get_option('facebook_ID'); ?>&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <?php
        global $c5_skindata;
        ?>
        <div class="c5-main-body-wrap  clearfix">
            <div class="c5-container-controller">
                <span class="c5-close-button"></span>

                <?php
                $header_obj->floating_bar();
                $header_obj->main_content();
                ?>
                <?php $header_obj->header_content(); ?>

                <?php
                global $c5_headerdata;

                if ($c5_headerdata['floating_enable'] != 'off') {
                    ?>
                    <div id="floating-trigger"></div>
                <?php } ?>