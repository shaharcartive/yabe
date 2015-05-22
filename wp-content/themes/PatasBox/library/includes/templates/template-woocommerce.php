<?php
global $c5_skindata;

	?>
<div id="main" class=" clearfix" role="main">

	<div class="c5-main-width-wrap">
    <?php if ( is_post_type_archive() ) : ?>
<ul id="catlist">
<a href="/categoria-producto/premios/"><li>JUGUETES</li></a>
<li> ACCESORIOS </li>
<a href="../categoria-producto/premios/"><li> Alimentación y Premios </li></a>
<li> Regala PatasBox </li>
<ul>
<div style="clear:both"> &nbsp; </div>
<h2> CONSIGUE LOS FAVORITOS DE LA CAJA </h2>

<?php endif ?>
</div>
    <?php woocommerce_content(); ?>
	</div>
</div>