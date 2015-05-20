<?php
/*
Template Name: Landing PatasBox
*/
?>

<?php get_header(); ?>
		
	<div class="flexslider">
		<div id="claim" class="claim-landing wow fadeInDown animated">
			<div class="c5-main-width-wrap">
				<h1>Recibe la caja que tu </br>perro quiere cada mes</h1>
			</div>
		</div>
		
		<ul class="slides">
			<li><img alt="PatasBox" src="<?php bloginfo('template_url');?>/img/patasbox-landing-1.jpg"/></li>
			<li><img alt="PatasBox" src="<?php bloginfo('template_url');?>/img/patasbox-landing-2.jpg"/></li>
			<li><img alt="PatasBox" src="<?php bloginfo('template_url');?>/img/patasbox-landing-3.jpg"/></li>
			<li><img alt="PatasBox" src="<?php bloginfo('template_url');?>/img/patasbox-landing-4.jpg"/></li>
		</ul>
		
		<ul class="slides-mobile">
			<li><img src="<?php bloginfo('template_url');?>/img/patasbox-landing-1-mobile.jpg"/></li>		
		</ul>
	</div>

	<div class="section-0  bk-green">
		<div class="c5-main-width-wrap">
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center box">
				7 productos valorados en más de 40 €
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center box">
				Apoyamos a jóvenes creadores
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center box">
				Colaboramos con protectoras
			</div>
		</div>
	</div>
	
	<div class="section-1">
		<div class="c5-main-width-wrap">
			<div class="c5ab-col-base c5ab-col-lg-6 c5ab-col-md-6 c5ab-col-sm-12">
				<div class="rounded-dashed primero">
					<div class="title-list color-red"><?php the_field('home_titular_la_caja');?></div>
					<?php the_field('home_contenido_la_caja');?>
				</div>
			</div>
			
			<div class="c5ab-col-base c5ab-col-lg-6 c5ab-col-md-6 c5ab-col-sm-12">
				<div class="rounded-dashed segundo">
					<div class="title-list color-red"><?php the_field('titular_seccion_1.2');?></div>
					<?php the_field('contenido_seccion_1.2');?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="section-2 bk-brown">
		<h2 class="text-center title-line wow fadeInDown animated">
			<span><?php the_field('titular_seccion_2');?></span>
		</h2>
		
		<div class="c5-main-width-wrap top-40 bottom-60">
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center">
				<img src="<?php bloginfo('template_url');?>/img/patasbox-icon-01.png">
				<h4><?php the_field('titular_punto_1');?></h4>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center">
				<img src="<?php bloginfo('template_url');?>/img/patasbox-icon-02.png">
				<h4><?php the_field('titular_punto_2');?></h4>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center">
				<img src="<?php bloginfo('template_url');?>/img/patasbox-icon-03.png">
				<h4><?php the_field('titular_punto_3');?></h4>
			</div>
		</div>
	</div>
	
	<div class="section-3 bk-brown">
		<div class="c5-main-width-wrap">
			<div class="section-3-1">
				<h2 class="text-center wow fadeInDown"><?php the_field('titular_envio_correo');?></h2>
				<p class="text-center wow fadeInUp"><?php the_field('texto_envio_correo');?></p>
				<form role="form" id="newsletter-form" method="post" action="javascript:nestocontact();" class="wow fadeInLeft" data-wow-duration="1.5s">
		            <div class="form-group">
		                <input type="email" class="form-control" placeholder="Introduce tu dirección de email" name="email" id="contact-email" value="">
					        <div class="text-center check">
					        	<input type="checkbox" id="checkbox" checked="checked"/><span class="check"><a href="http://htcvr.es/sandbox/terminos-y-condiciones/" target="_blank">Acepto términos y condiciones</a></span>
					        </div>
		                <button type="submit" class="btn btn-lg btn-nesto">Enviar</button>
		            </div>
		        </form>
	        </div>
        </div>
	</div>
	
	<div class="section-4">
		<h2 class="text-center title-line wow fadeInDown">
			<span>¿Por qué Patas Box?</span>
		</h2>
		
		<div class="c5-main-width-wrap top-40">
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-3 c5ab-col-md-6 c5ab-col-sm-12 text-center">
				<img src="<?php bloginfo('template_url');?>/img/patasbox-icon-04.png">
				<h4><?php the_field('seccion_3.1_titular');?></h4>
				<p><?php the_field('seccion_3.1_contenido');?></p>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-3 c5ab-col-md-6 c5ab-col-sm-12 text-center">
				<img src="<?php bloginfo('template_url');?>/img/patasbox-icon-05.png">
				<h4><?php the_field('seccion_3.2_titular');?></h4>
				<p><?php the_field('seccion_3.2_contenido');?></p>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-3 c5ab-col-md-6 c5ab-col-sm-12 text-center">
				<img src="<?php bloginfo('template_url');?>/img/patasbox-icon-06.png">
				<h4><?php the_field('seccion_3.3_titular');?></h4>
				<p><?php the_field('seccion_3.3_contenido');?></p>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-3 c5ab-col-md-6 c5ab-col-sm-12 text-center">
				<img src="<?php bloginfo('template_url');?>/img/patasbox-icon-07.png">
				<h4><?php the_field('seccion_3.4_titular');?></h4>
				<p><?php the_field('seccion_3.4_contenido');?></p>
			</div>
		</div>
	</div>
	
	<div class="section-5">
		<h2 class="text-center title-line">
			<span>PatasBox & Friends</span>
		</h2>
		<div class="social-feed">
			<ul class="image-grid">
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-1.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends"src="<?php bloginfo('template_url');?>/img/patasbox-friends-2.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-3.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-4.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-5.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-6.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-7.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-8.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-9.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-10.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-11.jpg"></li>
				<li class="c5ab-col-lg-2"><img alt="PatasBox & Friends" src="<?php bloginfo('template_url');?>/img/patasbox-friends-12.jpg"></li>
			</ul>
		</div>
	</div>
	
	<div class="section-6 bk-red">
		<h2 class="text-center">Saltarán al verlo</h2>
		<form role="form" id="newsletter-form-2" method="post" action="javascript:nestocontact2();" class="wow fadeInLeft" data-wow-duration="1.5s">
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Introduce tu dirección de email" name="email" id="contact-email-2" value="">
			        <div class="text-center check">
			        	<input type="checkbox" id="checkbox2" checked="checked"/><span class="check"><a href="http://htcvr.es/sandbox/terminos-y-condiciones/" target="_blank">Acepto términos y condiciones</a></span>
			        </div>
                <button type="submit" class="btn btn-lg btn-nesto">Enviar</button>
            </div>
        </form>
	</div>

	<div class="modal fade" id="ResponseModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="ResponseModal-title">title</h4>
                </div>

                 <div class="modal-body">
                    <span id="ResponseModalLabel"></span>
                    <h5 class="nesto-response">-</h5>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" charset="utf-8">
		jQuery(window).load(function() {
			jQuery('.flexslider').flexslider({
				controlNav: false
			});
		});
	</script>
<?php get_footer(); ?>