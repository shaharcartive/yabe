<?php
	global $c5_skindata;
?>
<div id="main" class=" clearfix" role="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
				<?php 
				$login_required = get_post_meta(get_the_ID(), 'login_required', true);
				$login_required_bool = true;
				if($login_required == 'on'){
					$login_required_bool = false;
					if(is_user_logged_in()){
						$login_required_bool = true;	
					}
				}
				if($login_required_bool ){ ?>
	                <section class="entry-content clearfix">
	                	<div class="<?php echo c5_get_width_class(); ?>">
	                    	<?php 
	                    		c5_check_mobile_width();
	                    		the_content(); 
	                    	?>
	                    </div>
	                </section>
	                <?php
	                c5_page_navi();
	                $comments = get_post_meta(get_the_ID(), 'enable_comments', true);
	                if ($comments == 'on') {
	                	echo '<div class="'.c5_get_width_class().'">';
	                    $C5_Article = new C5_Article();
	                    $C5_Article->comment_form();
	                    echo '</div>';
	                }
                }else {
                	echo '<div class="'.c5_get_width_class().'"><div class="c5-login-required">' . do_shortcode('[c5ab_account username_text="'.__( 'Username' ,'code125') .'" password_text="******" login_text="'.__( 'Login in' ,'code125') .'" register_text="'.__( 'Register' ,'code125') .'" forget_text="'.__( 'Forget Password ?' ,'code125') .'" remember_text="'.__( 'Remember me ?' ,'code125') .'" checkbox="on" forget="on" register="on" ]') . '</div></div>';
                }
                ?>
            </article>

        <?php endwhile; ?>
    <?php endif; ?>

</div>