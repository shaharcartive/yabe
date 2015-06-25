		</div>
        
       
        
         <?php   if (is_woocommerce()) : ?>
        <div class="section-6 bk-red">
		<div class="section-6-1 c5ab_center c5ab-col-base c5ab-col-lg-4 c5ab-col-md-6 c5ab-col-sm-12 text-center dashed-white">
        <img src="<?php echo get_template_directory_uri(); ?>/img/delivery.png" align="middle">
			<h2 class="text-center">Envíos gratuitos*</h2>
            <span class="text-center patascoins"><p>*A partir de 39.95 €<br /><br /></p>
</span>
		</div>
        <div class="section-6-1 c5ab_center c5ab-col-base c5ab-col-lg-4 c5ab-col-md-6 c5ab-col-sm-12 text-center dashed-white">
        <img src="<?php echo get_template_directory_uri(); ?>/img/patasbox-patascoins.png" align="middle">
			<h2 class="text-center">Patascoins</h2>
            <span class="text-center patascoins"><p>Te devolvemos el 5% de tu compra en PatasCoins. </p>
</span>
		</div>
        <div class="section-6-1 c5ab_center c5ab-col-base c5ab-col-lg-4 c5ab-col-md-6 c5ab-col-sm-12 text-center dashed-white">
        <img src="<?php echo get_template_directory_uri(); ?>/img/tested.png" align="middle">
			<h2 class="text-center">Testado </h2>
            <span class="text-center patascoins"><p>y aprobado por los Patasbox and friends</p>
</span>
		</div>
	</div>
     <?php endif ?>
			<footer class="footer" role="contentinfo">
				<?php
				 global $c5_footerdata;
				 global $c5_skindata;
				 global $c5_skip_page_width;
				 $c5_skip_page_width = true;
				 if(C5_simple_option){
				 	$c5_skindata['footer_default'] = ot_get_option('footer_template');
				 }
				 
				 $footer_enable = $c5_footerdata['footer_enable'];
				 if ($footer_enable != 'off') {
				 $color_mode = 'c5-content-dark';
				 $footer_background = $c5_footerdata['footer_background'];
				 if ($footer_background != '') {
				 	$lum = c5_get_lum_hex($footer_background);
				 	
				 	if ($lum<170) {
				 		$color_mode = 'c5-content-dark';
				 	}else {
				 		$color_mode = 'c5-content-light';
				 	}
				 }
				 ?>
				<div class="pre-footer-main">
					<div class="<?php echo $color_mode; ?> c5-main-width-wrap">
						<?php dynamic_sidebar("Ventajas");?>
					</div>
				</div>
				<div class="footer-main">
					<div class="<?php echo $color_mode; ?> c5-main-width-wrap">
					<?php dynamic_sidebar("Footer");?>
					</div>
					<div class="img-icons-seguridad-pagos"><img src="//htcvr.es/sandbox/wp-content/themes/PatasBox/img/icon-pagos-ssl.png"></div>
				</div>
				<?php 
				}
				$footer_copyrights_enable = $c5_footerdata['footer_copyrights_enable'];
				if ($footer_copyrights_enable != 'off') {
					$color_mode = 'c5-content-dark';
					$footer_copyrights_background = $c5_footerdata['footer_copyrights_background'];
					if ($footer_copyrights_background != '') {
						$lum = c5_get_lum_hex($footer_copyrights_background);
						
						if ($lum<170) {
							$color_mode = 'c5-content-dark';
						}else {
							$color_mode = 'c5-content-light';
						}
					}
					echo '<div class="footer-bar clearfix"><div class="'.$color_mode.' c5-main-width-wrap">';
					
					$footer_copyrights = $c5_footerdata['footer_copyrights'];
					if($footer_copyrights!=''){
						echo '<div class="text-center">';
						echo '<div class="c5-copyrights">';
						
						echo wp_kses($footer_copyrights,array(
							'a' => array(
								'href' => array(),
						        'title' => array(),
						        'class' => array()
						     ),
						     'span'=>array(
						     	'class' => array()
						     )
						     ));
						
						echo '</div>';
						echo '</div>';
					}
					
					
					$code = '';
					$social_icons = $c5_footerdata['social_icons'];
					if ($social_icons) {
					    $code .= '[c5ab_social_icons]';
					    foreach ($social_icons as $social_icon) {
					        $code .= '[c5ab_social_icon icon="' . esc_attr($social_icon['icon']) . '" link="' . esc_url($social_icon['link']) . '" title="' . esc_attr($social_icon['title']) . '" ]';
					    }
					    $code .= '[/c5ab_social_icons]';
					}
					echo '<div class="c5-right"><div class="c5-social-footers"></div>' . do_shortcode($code) .'</div>';					
					echo '<div class="clearfix"></div></div></div>';
				}
					 ?>
				<style>
				
				.footer .footer-main{
					background: <?php echo $c5_footerdata['footer_background'] ?>;
				}
				.footer .footer-bar{
					background: <?php echo $c5_footerdata['footer_copyrights_background'] ?>;
				}
				</style>
			</footer>
	</div>
	</div>
	<p id="gotop"><span class="fa fa-sort-asc"></span></p>
	
	<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/jquery.contact.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/plugins.js"></script>
	
	
	<?php if ( is_page( 'registro' ) ) { ?>
		<script>
			jQuery('#foto').before('<div id="contorno-avatar">');
			jQuery('#contorno-avatar').append('<div id="avatar"><img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/contorno-imagen-mascota.png">');
			
			jQuery("#foto").change(function(){
    			if (this.files && this.files[0]) {
        			var reader = new FileReader();
        			reader.onload = function (e) {
						/*jQuery('#preview').attr('src', e.target.result); */
						jQuery('#avatar').css({backgroundImage: "url("+e.target.result+")"});
        			}
        		reader.readAsDataURL(this.files[0]);
    			}			
			});
			jQuery("label[for='Si por favor_26']").text("Si, por favor");	
			jQuery("label[for='No gracias_26']").text("No, gracias");
		</script>
	<?php } ?>

	<?php if ( is_page( 'mi-cuenta' ) ) { ?>
		<script>
			jQuery("label[for='Si por favor_26']").text("Si, por favor");	
			jQuery("label[for='No gracias_26']").text("No, gracias");
			
			jQuery('#foto').before('<div id="contorno-avatar">');
			jQuery('#contorno-avatar').append('<div id="avatar"><img src="//htcvr.es/sandbox/wp-content/themes/PatasBox/img/contorno-imagen-mascota.png">');
			
			jQuery('.wppb-avatar-file').find('img').each(function(n, image){
				var image = jQuery(image);
				var thisurl = jQuery(this).attr('src');
				jQuery('#avatar').css('background-image', 'url(' + thisurl + ')');
			});

			jQuery("#foto").change(function(){
    			if (this.files && this.files[0]) {
        			var reader = new FileReader();
        			reader.onload = function (e) {
						jQuery('#avatar').css({backgroundImage: "url("+e.target.result+")"});
        			}
        		reader.readAsDataURL(this.files[0]);
    			}			
			});
		</script>
	<?php } ?>

		<script>
			jQuery(document).ready(function() {
			jQuery("#wppb-form-element-21").nextUntil("#wppb-form-element-26").andSelf().add("#wppb-form-element-26").wrapAll("<ul class='datos-mascota bk-red'></ul>");
			jQuery("#wppb-form-element-3").nextUntil("#wppb-form-element-13").andSelf().add("#wppb-form-element-13").wrapAll("<ul class='datos-cuenta bk-orange'></ul>");
			});
			jQuery("#nombre_mascota").attr("placeholder", "Nombre de tu mascota");
			jQuery("#fecha").attr("placeholder", "Cumpleaños");
			jQuery("#texto_mascota").attr("placeholder", "Cuéntanos un poco más sobre tu mascota");
			jQuery("#first_name").attr("placeholder", "Nombre");
			jQuery("#last_name").attr("placeholder", "Apellidos");
			jQuery("#email").attr("placeholder", "E-mail");
			jQuery("#passw1").attr("placeholder", "Contraseña");
			jQuery("#passw2").attr("placeholder", "Confirmar Contraseña");
		</script>
	<?php wp_footer(); ?>	
	</body>
</html>