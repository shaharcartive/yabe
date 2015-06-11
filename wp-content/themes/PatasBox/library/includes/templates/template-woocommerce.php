<?php
global $c5_skindata;

	?>
 <div id="overlay"></div>
<div id="main" class=" clearfix" role="main">

	<div class="c5-main-width-wrap">
    <?php woocommerce_breadcrumb(); ?>
    
     <div id="subcat">
    
    <?php  	
   $term = get_queried_object()->term_id;
   $termid = get_term($term, 'product_cat' );
 
 
 if($termid->parent > 0) { 
  /* Show siblings */
} elseif (is_product_category()) {
  echo "<h2 class='text-center title-line wow fadeInDown animated animated'> <span> Categorías </span> </h2>";
}
 
 ?>
    
    <?php   if (is_product_category()) : ?>
    

    
    <?php $category = get_queried_object();
	 ?>
    
 
  

            <?php echo do_shortcode('[product_categories  parent="'.$category->term_id.'" ]');?>
            
       <h2 class='text-center title-line wow fadeInDown animated animated'> <span><?php echo $category->name ?></span> </h2>
    <?php endif ?>
    </div>
    <?php if ( is_post_type_archive() ) : ?>
    <h2 class="text-center title-line wow fadeInDown animated animated"> <span> Categorías </span> </h2>
<ul id="catlist">
<a href="../categoria-producto/alimentacion-y-premios/"><li><img src="<?php echo get_template_directory_uri(); ?>/img/cat_jugutes_hover.png" /><img class="top" src="<?php echo get_template_directory_uri(); ?>/img/cat_jugutes.png" /></li></a>
<a href="../categoria-producto/alimentacion-y-premios/"><li><img src="<?php echo get_template_directory_uri(); ?>/img/cat_complementos_y_higiene_hover.png" /><img class="top" src="<?php echo get_template_directory_uri(); ?>/img/cat_complementos_y_higiene.png" /></li></a>
<a href="../categoria-producto/comida-y-premios/"><li><img src="<?php echo get_template_directory_uri(); ?>/img/cat_comida_y_premios_hover.png" /><img class="top" src="<?php echo get_template_directory_uri(); ?>/img/cat_comida_y_premios.png" /></li></a>
<li><a href="http://htcvr.es/sandbox/tienda/uncategorized/caja-regalo/"><img src="<?php echo get_template_directory_uri(); ?>/img/cat_regala_hover.png" /><img class="top" src="<?php echo get_template_directory_uri(); ?>/img/cat_regala.png" /></a></li>
</ul>
<div style="clear:both"> &nbsp; </div>
<h2 class="text-center title-line wow fadeInDown animated animated"> <span> CONSIGUE LOS FAVORITOS DE LA CAJA </span></h2>

<?php endif ?>
</div>

    <?php woocommerce_content(); ?>
	</div>
    
   
    
    <div id="favoritos">
<?php   if (  is_product() ) : ?>
 <h2 class="text-center title-line wow fadeInDown animated animated"> <span> Nuestros favoritos <span> </h2>
 
   
   <ul class="products">
<?php
     $args = array( 'post_type' => 'product', 'meta_key' => '_featured','posts_per_page' => 15,'columns' => '3', 'meta_value' => 'yes' );
     $loop = new WP_Query( $args );
     while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                        <li class="product type-product status-publish has-post-thumbnail c5-in-cart featured taxable shipping-taxable purchasable product-type-variable instock">
                        <div class="c5-product-content">
                            <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                               
                            <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?></a>
                            
                            <div class="c5-meta-product-content">
                                <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                                <h3><?php echo str_replace(' | ', '<br />', get_the_title()); ?></h3><span class="price"><span class="amount"><?php echo $product->get_price_html(); ?></span></span></a>
                        </div>
	
                        </li>
                <?php
            /**
             * woocommerce_pagination hook
             *
             * @hooked woocommerce_pagination - 10
             * @hooked woocommerce_catalog_ordering - 20
             */
            do_action( 'woocommerce_pagination' );
        ?>
<?php endwhile; ?>
<?php wp_reset_query(); ?>
<?php endif ?>
</ul>
    </div>
</div>