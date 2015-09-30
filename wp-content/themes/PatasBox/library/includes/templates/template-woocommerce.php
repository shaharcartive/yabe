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
   global $wp_query;
$term = $wp_query->get_queried_object();

   $children = get_terms( $term->taxonomy, array(
'parent'    => $term->term_id,
'hide_empty' => false
) );
 // print_r($children); // uncomment to examine for debugging

 
 
 if($termid->parent > 0) { 

} 
elseif (($children) && is_product_category()) { echo "<h2 class='text-center title-line wow fadeInDown animated animated'> <span><button>+</button> Lo más guau </span> </h2>";
}
elseif (is_product_category()) {
  echo "";
 
}

elseif ( is_post_type_archive() ) { echo "<h2 class='text-center title-line wow fadeInDown animated animated'> <span> Lo más guau </span> </h2>"; }


 
 ?>
    
    <?php   if (is_product_category()) : ?>
    

    
    <?php $category = get_queried_object();
	 ?>
    
 
  

            <?php echo do_shortcode('[product_categories  parent="'.$category->term_id.'" ]');?>
            
       <h2 class='text-center title-line wow fadeInDown animated animated'> <span><?php echo $category->name ?></span> </h2>
    <?php endif ?>
    </div>
    <?php if ( is_post_type_archive() ) : ?>
     <div id="subcat">
   <?php echo do_shortcode('[product_categories number="4" parent="0"]');?>

</div>
<div style="clear:both"> &nbsp; </div>
<h2 class="text-center title-line wow fadeInDown animated animated"> <span> Compra lo mejor de Patasbox </span></h2>

<?php endif ?>
</div>

    <?php woocommerce_content(); ?>
	</div>
    
   
    
    <div id="favoritos">
<?php   if (  is_product() ) : ?>
 <h2 class="text-center title-line wow fadeInDown animated animated"> <span> Nuestros favoritos <span> </h2>
 
     <section class="slider">
        <div class="flexslider carousel">
   <ul class="products slides">
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
      </section>
    </div>
</div>
