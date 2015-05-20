<?php global $c5_skindata; ?>
<div id="main" class=" clearfix" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php setPostViews(get_the_ID()); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(' clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
            <section class="entry-content c5-article-content clearfix" itemprop="articleBody">
            
            	<div class="c5-main-width-wrap">
                <?php 
                $post_obj = new C5_post(); 
                $settings_obj = new C5_theme_options();
                $article_obj = new C5_Article();
                
                if ($settings_obj->get_meta_option('show_author') != 'off'){ ?>
				<?php } ?>
				
                    <div class="c5-top-article clearfix">
                	<?php 
            		$atts = array();
            		$atts['meta_data'] = $settings_obj->get_meta_option('article_meta_data');
            		$atts['c5_date_format'] = $settings_obj->get_meta_option('c5_date_format');
            		
            		echo $post_obj->get_metadata($atts);
            		?>
                    </div>
                    <div class="clearfix"></div>
                    
                    <?php  
                    //before article
                    $article_before = $settings_obj->get_meta_option('article_before');
                    echo html_entity_decode( do_shortcode($article_before));  ?>
                    <div class="clearfix"></div>

                    <?php
                    echo  $article_obj->get_featured_media();
                    echo do_shortcode('[c5ab_review]');
                    //main article content
                     the_content(); ?>
					<div class="clearfix"></div>                    	
                    <!-- Navigation -->                    
                    <?php
                    wp_link_pages(
                            array(
                                'before' => '<nav class="page-links pagination c5-pagination"><ul class="page-numbers"><li><span class="page-links-title">' . __('Pages:', 'code125') . '</span></li>',
                                'after' => '</ul></nav>',
                                'link_before' => '<li><span class="num">',
                                'link_after' => '</span></li>'));
                    ?> 
					<div style="min-height:30px;"></div>
					</div>
                </section>
				</article>
				 
				<div class="c5-main-width-wrap">
                <footer class="article-footer">
                	<?php 
                	//social share buttons
                	$article_obj->social_share_buttons($settings_obj->get_meta_option('article_social_media'));
                	
                	//after article
                	$article_after = $settings_obj->get_meta_option('article_after');
                	echo html_entity_decode( do_shortcode($article_after)); 
                	
                	//read next
                	$article_obj->read_next();
                	
                	//tags 
                    if ($settings_obj->get_meta_option('enable_tags') !='off' && has_tag()) {
                        ?> <div class="c5-tags-wrap c5-margin-bottom clearfix"> <?php
                        $code = '[c5ab_title  title="' . __('Article Tags', 'code125') . '" icon="fa fa-tag" ]';
                        echo do_shortcode($code);
                        ?>
                            <div class="tags-meta tags clearfix"><?php the_tags('', ' ', ''); ?><div class="clearfix"></div></div>
                        </div>
                    <?php } ?>
                </footer>

                <?php
                	$comments_order = $settings_obj->get_meta_option('comments_order');
                	if($comments_order == ''){
                		$comments_order = 'comments_facebook';
                	}
                	$comments_order_array = explode('_', $comments_order);
                	foreach ($comments_order_array as $comment_type) {
                		if($comment_type == 'facebook'){
                			if ( $settings_obj->get_meta_option('enable_facebook') !='off' ) {
                				$article_obj->facebook_comment_form();
                			}
                		}else {
                			if (  $settings_obj->get_meta_option('enable_wp_comments') !='off' ) {
                				$article_obj->comment_form();
                			}
                		}
                	}
                ?>
           </div>
           
           <?php
           /* 
           $next_post = get_next_post();
           $prev_post = get_previous_post();
           $count = 0;
           $p = array();
           if (!empty( $next_post )) {
           	$count++;
           	$p[] = $next_post->ID;
           }
           if (!empty( $prev_post )) {
           	$count++;
           	$p[] = $prev_post->ID;
           }
           if(count($p)!=0){
	           $args =array(
	           	'post__in' => $p,
	           	'ignore_sticky_posts'=> true,
	           	'post_type' => get_post_type( get_the_ID() )
	           );
	           // The Query
	           $the_query = new WP_Query( $args );
	           
	           // The Loop
	           if ( $the_query->have_posts() ) {
	           	echo '<div class="clearfix"></div><div class="c5-related-post clearfix c5-related-post-'.$count.'">';
	           	while ( $the_query->have_posts() ) {
	           		$the_query->the_post();
	           		echo  $post_obj->get_post_blog_3( false);
	           	}
	           	echo '</div>';
	           } 
	          
	           wp_reset_postdata();
           }
           */
            ?>
        <?php endwhile; ?>
    <?php else : ?>

        <article id="post-not-found" class="hentry clearfix">
            <header class="article-header">
                <h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
            </header>
            <section class="entry-content">
                <p><?php _e('Uh Oh. Something is missing. Try double checking things.', 'bonestheme'); ?></p>
            </section>
            <footer class="article-footer">
                <p><?php _e('This is the error message in the single.php template.', 'bonestheme'); ?></p>
            </footer>
        </article>

    <?php endif; ?>

</div>