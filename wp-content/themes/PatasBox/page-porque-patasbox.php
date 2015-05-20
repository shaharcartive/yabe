<?php
/*
Template Name: ¿Por qué PatasBox?
*/
?>

<?php get_header(); 
global $woocommerce;
?>
	<div class="section-0  bk-orange"></div>
	
	<div class="section-4">

		<div class="c5-main-width-wrap top-40">
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-3 c5ab-col-md-6 c5ab-col-sm-12 text-center">
				<img src="<?php the_field('seccion_3.1_imagen');?>">
				<h4><?php the_field('seccion_3.1_titular');?></h4>
				<p><?php the_field('seccion_3.1_contenido');?></p>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-3 c5ab-col-md-6 c5ab-col-sm-12 text-center">
				<img src="<?php the_field('seccion_3.2_imagen');?>">
				<h4><?php the_field('seccion_3.2_titular');?></h4>
				<p><?php the_field('seccion_3.2_contenido');?></p>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-3 c5ab-col-md-6 c5ab-col-sm-12 text-center">
				<img src="<?php the_field('seccion_3.3_imagen');?>">
				<h4><?php the_field('seccion_3.3_titular');?></h4>
				<p><?php the_field('seccion_3.3_contenido');?></p>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-3 c5ab-col-md-6 c5ab-col-sm-12 text-center">
				<img src="<?php the_field('seccion_3.4_imagen');?>">
				<h4><?php the_field('seccion_3.4_titular');?></h4>
				<p><?php the_field('seccion_3.4_contenido');?></p>
			</div>
		</div>
	</div>

	<div class="section-5 bk-green-2">
		<div class="section-5-1 c5ab_center c5ab-col-lg-6 c5ab-col-md-6 c5ab-col-sm-12 text-center dashed-white">
			<h2><?php the_field('seccion_5_titular');?></h2>
			<a href="<?php the_field('seccion_5_link_boton');?>"><button class="red"><?php the_field('seccion_5_texto_boton');?></button></a>
		</div>
	</div>
    
<?php get_footer(); ?>