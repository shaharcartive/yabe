<?php
/*
Template Name: Crea tu caja
*/
?>
<?php get_header(); 
global $woocommerce;
?>

	<div class="section-4">
		<h2 class="text-center title-line wow fadeInDown animated">
			<span><?php the_field('titular_seccion_crea_tu_caja');?></span>
		</h2>
		
		<div class="planes">
			<div class="box-planes plan-1">
				<div class="plan-destacado"><?php the_field('destacado_plan_1');?></div>
                <h3 class="plan-tittle"><?php the_field('titulo_plan_1');?></h3>
				<div class="precio"><?php the_field('precio_plan_1');?><span> <?php the_field('coletilla_precio_€/mes');?></span></div>
				<a href ="http://htcvr.es/sandbox/tienda/carro/?add-to-cart=1679&variation_id=1680&attribute_pa_duracion=mensual">

				<button class="text-center green"><?php the_field('texto_boton_planes');?></button></a>
				<ul>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_1-1');?></li>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_1-2');?></li>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_1-3');?></li>
				</ul>
			</div>
			<div class="box-planes plan-2">
				<div class="plan-destacado"><?php the_field('destacado_plan_2');?></div>
                <h3 class="plan-tittle"><?php the_field('titulo_plan_2');?></h3>
				<div class="precio"><?php the_field('precio_plan_2');?><span> <?php the_field('coletilla_precio_€/mes');?></span></div>

				<a href ="http://htcvr.es/sandbox/tienda/carro/?add-to-cart=1679&variation_id=1681&attribute_pa_duracion=trimestral">
				<button class="text-center green"><?php the_field('texto_boton_planes');?></button></a>
				<ul>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_2-1');?></li>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_2-2');?></li>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_2-3');?></li>
				</ul>
			</div>
			<div class="box-planes plan-3">
				<div class="plan-destacado"><?php the_field('destacado_plan_3');?></div>
                <h3 class="plan-tittle"><?php the_field('titulo_plan_3');?></h3>
				<div class="precio"><?php the_field('precio_plan_3');?><span> <?php the_field('coletilla_precio_€/mes');?></span></div>
				<a href ="http://htcvr.es/sandbox/tienda/carro/?add-to-cart=1679&variation_id=1682&attribute_pa_duracion=semestral">
				<button class="text-center green"><?php the_field('texto_boton_planes');?></button></a>
				<ul>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_3-1');?></li>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_3-2');?></li>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_3-3');?></li>
				</ul>
			</div>
			<div class="box-planes plan-4">
				<div class="plan-destacado"><?php the_field('destacado_plan_4');?></div>
                <h3 class="plan-tittle"><?php the_field('titulo_plan_4');?></h3>
				<div class="precio"><?php the_field('precio_plan_4');?><span> <?php the_field('coletilla_precio_€/mes');?></span></div>
				<a href ="http://htcvr.es/sandbox/tienda/carro/?add-to-cart=1679&variation_id=1683&attribute_pa_duracion=anual">
				<button class="text-center green"><?php the_field('texto_boton_planes');?></button></a>
				<ul>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_4-1');?></li>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_4-2');?></li>
					<li><span class="fa fa-check-square-o"></span> <?php the_field('caracteristicas_plan_4-3');?></li>
				</ul>
			</div>
			<p class="text-center"><?php the_field('coletilla_texto_pie_planes');?></p>
		</div>
	</div>	

<?php get_footer(); ?>