<?php
global $c5_skindata;

	?>
<div id="main" class=" clearfix" role="main">

	<div class="c5-main-width-wrap">
    <?php if ( is_post_type_archive() ) : ?>
<ul id="catlist">
<a href="/categoria-producto/premios/"><li>Juguetes</li></a>
<li> Complementos e Higiene </li>
<a href="../categoria-producto/premios/"><li> Comida y Premios </li></a>
<li> Regala PatasBox </li>
<ul>
<div style="clear:both"> &nbsp; </div>
<h2> CONSIGUE LOS FAVORITOS DE LA CAJA </h2>

<?php endif ?>
</div>

    <?php woocommerce_content(); ?>
	</div>
    
    <div>
    
    <?php   if (is_product_category()) : ?>
    
    <?php $category = get_queried_object(); ?>

            <?php echo do_shortcode('[product_categories parent="'.$category->term_id.'" ]');?>
       
    <?php endif ?>
    </div>
    
    <div id="favoritos">
   
    <ul>
<?php   if (  is_product() ) : ?>
 <h2> Nuestros favoritos </h2>
<?php
     $args = array( 'post_type' => 'product', 'meta_key' => '_featured','posts_per_page' => 15,'columns' => '3', 'meta_value' => 'yes' );
     $loop = new WP_Query( $args );
     while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                        <li class="product">    
                            
                               
                                <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?></a>
                                <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                                <h3><?php the_title(); ?></h3><br /><span class="price"><?php echo $product->get_price_html(); ?></span>
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