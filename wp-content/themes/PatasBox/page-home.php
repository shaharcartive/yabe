<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>

	<div class="section-0  bk-green"></div>
	
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
		<div class="section-2-1 c5ab_center c5ab-col-lg-4 c5ab-col-md-12 c5ab-col-sm-12 text-center dashed-white">
			<h2><?php the_field('titular_seccion_2');?></h2>
			<a href="<?php the_field('link_boton_seccion_2');?>"><button class="green"><?php the_field('texto_boton_seccion_2');?></button></a>
		</div>
	</div>
	
	<div class="section-4">
		<h2 class="text-center title-line wow fadeInDown animated">
			<span><?php the_field('titular_seccion_3');?></span>
		</h2>
		
		<div class="c5-main-width-wrap top-40 bottom-60">
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center">
				<a href="<?php the_field('link_imagen_punto_1');?>"><img src="<?php the_field('imagen_punto_1');?>"></a>
				<a href="<?php the_field('link_imagen_punto_1');?>"><h4 class="titmasq"><?php the_field('titular_punto_1');?></h4></a>
				<?php the_field('descripcion_punto_1');?>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center">
				<img src="<?php the_field('imagen_punto_2');?>">
				<h4><?php the_field('titular_punto_2');?></h4>
				<?php the_field('descripcion_punto_2');?>
			</div>
			<div class="c5ab-col-base c5ab_center c5ab-col-lg-4 c5ab-col-md-4 c5ab-col-sm-12 text-center">
				<a href="<?php the_field('link_imagen_punto_3');?>"><img src="<?php the_field('imagen_punto_3');?>"></a>
				<a href="<?php the_field('link_imagen_punto_3');?>"><h4 class="titmasq"><?php the_field('titular_punto_3');?></h4></a>
				<?php the_field('descripcion_punto_3');?>
			</div>
		</div>
	</div>
	
	<div class="section-8">
		<h2 class="text-center title-line">
			<span><?php the_field('titular_friends');?></span>
		</h2>
		<div class="social-feed">
			<ul class="image-grid">
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_1');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_2');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_3');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_4');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_5');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_6');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_7');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_8');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_9');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_10');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_11');?>"></li>
				<li class="c5ab-col-lg-2"><img src="<?php the_field('friend_12');?>"></li>
			</ul>
		</div>
	</div>
	
	<div class="section-6 bk-red">
		<div class="section-6-1 c5ab_center c5ab-col-lg-6 c5ab-col-md-12 c5ab-col-sm-12 text-center dashed-white">
			<h2 class="text-center"><?php the_field('titular_bloque');?></h2>
			<a href="<?php the_field('link_boton');?>"><button class="green"><?php the_field('texto_boton');?></button></a>
		</div>
	</div>
<?php get_footer(); ?>