<?php

class C5_Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu {
    /**
     * @see Walker_Nav_Menu::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */

    /**
     * @see Walker_Nav_Menu::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function start_lvl(&$output, $depth = 0, $args = array()) {
        
    }

    /**
     * @see Walker_Nav_Menu::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function end_lvl(&$output, $depth = 0, $args = array()) {
        
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $_wp_nav_menu_max_depth;
		
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        ob_start();
        $item_id = esc_attr($item->ID);
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );

        $original_title = '';
        if ('taxonomy' == $item->type) {
            $original_title = get_term_field('name', $item->object_id, $item->object, 'raw');
            if (is_wp_error($original_title))
                $original_title = false;
        } elseif ('post_type' == $item->type) {
            $original_object = get_post($item->object_id);
            $original_title = $original_object->post_title;
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr($item->object),
            'menu-item-edit-' . ( ( isset($_GET['edit-menu-item']) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if (!empty($item->_invalid)) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf('%s (Invalid)', $item->title);
        } elseif (isset($item->post_status) && 'draft' == $item->post_status) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf('%s (Pending)', $item->title);
        }

        $title = empty($item->label) ? $title : $item->label;
        ?>
        <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                <span class="item-title"><?php echo esc_html($title); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html($item->type_label); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
                        echo wp_nonce_url(
                                add_query_arg(
                                        array(
                            'action' => 'move-up-menu-item',
                            'menu-item' => $item_id,
                                        ), remove_query_arg($removed_args, admin_url('nav-menus.php'))
                                ), 'move-menu_item'
                        );
                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
                        echo wp_nonce_url(
                                add_query_arg(
                                        array(
                            'action' => 'move-down-menu-item',
                            'menu-item' => $item_id,
                                        ), remove_query_arg($removed_args, admin_url('nav-menus.php'))
                                ), 'move-menu_item'
                        );
                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                    echo ( isset($_GET['edit-menu-item']) && $item_id == $_GET['edit-menu-item'] ) ? admin_url('nav-menus.php') : add_query_arg('edit-menu-item', $item_id, remove_query_arg($removed_args, admin_url('nav-menus.php#menu-item-settings-' . $item_id)));
                    ?>"><?php echo 'Edit Menu Item'; ?></a>
                </span>
                </dt>
            </dl>

            <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                <?php if ('custom' == $item->type) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                            <?php echo 'URL'; ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->url); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                        <?php echo 'Navigation Label'; ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->title); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                        <?php echo 'Title Attribute'; ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->post_excerpt); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked($item->target, '_blank'); ?> />
                        <?php echo 'Open link in a new window/tab'; ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                        <?php echo 'CSS Classes (optional)'; ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr(implode(' ', $item->classes)); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                        <?php echo 'Link Relationship (XFN)'; ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->xfn); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                        <?php echo 'Description'; ?><br />
                        <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html($item->description); // textarea_escaped    ?></textarea>
                        <span class="description"><?php echo 'The description will be displayed in the menu if the current theme supports it.'; ?></span>
                    </label>
                </p>        
                <?php
                /* New fields insertion starts here */
                ?>      
                <p class="field-custom description description-wide">
                    <label for="edit-menu-item-subtitle-<?php echo $item_id; ?>">
                        <?php echo 'Icon Class'; ?><br />
                        <input type="text" id="edit-menu-item-subtitle-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-subtitle[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->subtitle); ?>" />
                    </label>
                </p>
                <?php
                
                $thisCat = get_term_by('id', $item->object_id, $item->object);
                if (is_object($thisCat)) {
                    ?>      
                    <p class="field-custom description description-wide">
                        <label for="edit-menu-item-template-<?php echo $item_id; ?>">
                            <?php echo 'Mega Menu Options'; ?><br />
                            <?php
                            
                        	$options = array(
                        	    'no' => 'Disabled',
                        	    'date' => 'Enable/ Order by Date',
                        	    'comment_count' => 'Enable/ Order by Comments Count',
                        	);
                            
                            ?>
                            <select id="edit-menu-item-template-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-template[<?php echo $item_id; ?>]">
                                <?php
                                foreach ($options as $key => $value) {
                                    $selected = '';
                                    if (esc_attr($item->template) == $key) {
                                        $selected = 'selected="selected"';
                                    }
                                    ?>
                                    <option value="<?php echo $key ?>" <?php echo $selected; ?>><?php echo $value ?></option>
                                    <?php
                                }
                                ?>

                            </select>

                        </label>
                    </p>
                <?php } 
                
                /* else {
                    ?>
                    <p class="field-custom description description-wide">
                        <label for="edit-menu-item-mega-<?php echo $item_id; ?>">
                            <?php echo 'Enable Mega Menu'; ?><br />
                            <?php
                            $options = array(
                                'no' => 'no',
                                'yes' => 'Yes',
                            );
                            ?>
                            <select id="edit-menu-item-mega-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-mega[<?php echo $item_id; ?>]">
                                <?php
                                foreach ($options as $key => $value) {
                                    $selected = '';
                                    if (esc_attr($item->mega) == $key) {
                                        $selected = 'selected="selected"';
                                    }
                                    ?>
                                    <option value="<?php echo $key ?>" <?php echo $selected; ?>><?php echo $value ?></option>
                                    <?php
                                }
                                ?>

                            </select>

                        </label>
                    </p>


                    <?php
                }
                */
                /* New fields insertion ends here */
                ?>
                <div class="menu-item-actions description-wide submitbox">
                    <?php if ('custom' != $item->type && $original_title !== false) : ?>
                        <p class="link-to-original">
                            <?php printf('Original: %s', '<a href="' . esc_attr($item->url) . '">' . esc_html($original_title) . '</a>'); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                    echo wp_nonce_url(
                            add_query_arg(
                                    array(
                        'action' => 'delete-menu-item',
                        'menu-item' => $item_id,
                                    ), remove_query_arg($removed_args, admin_url('nav-menus.php'))
                            ), 'delete-menu_item_' . $item_id
                    );
                    ?>"><?php echo'Remove'; ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url(add_query_arg(array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg($removed_args, admin_url('nav-menus.php'))));
                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php echo 'Cancel'; ?></a>
                </div>

                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->object_id); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->object); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->menu_item_parent); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->menu_order); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr($item->type); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
            <?php
            $output .= ob_get_contents();

            ob_end_clean();
        }

    }

    class c5_custom_menu {
        /* --------------------------------------------*
         * Constructor
         * -------------------------------------------- */

        /**
         * Initializes the plugin by setting localization, filters, and administration functions.
         */
        function __construct() {


            // add custom menu fields to menu
            add_filter('wp_setup_nav_menu_item', array($this, 'add_custom_nav_fields'));

            // save menu custom fields
            add_action('wp_update_nav_menu_item', array($this, 'update_custom_nav_fields'), 10, 3);

            // edit menu walker
            add_filter('wp_edit_nav_menu_walker', array($this, 'edit_walker'), 10, 2);
        }

// end constructor

        /**
         * Add custom fields to $item nav object
         * in order to be used in custom Walker
         *
         * @access      public
         * @since       1.0 
         * @return      void
         */
        function add_custom_nav_fields($menu_item) {

            $menu_item->subtitle = get_post_meta($menu_item->ID, '_menu_item_subtitle', true);
            $menu_item->template = get_post_meta($menu_item->ID, '_menu_item_template', true);
//            $menu_item->mega = get_post_meta($menu_item->ID, '_menu_item_mega', true);

            return $menu_item;
        }

        /**
         * Save menu custom fields
         *
         * @access      public
         * @since       1.0 
         * @return      void
         */
        function update_custom_nav_fields($menu_id, $menu_item_db_id, $args) {

            // Check if element is properly sent
            if (isset($_REQUEST['menu-item-subtitle'])) {
                if (is_array($_REQUEST['menu-item-subtitle'])) {
                    if (isset($_REQUEST['menu-item-subtitle'][$menu_item_db_id])) {
                        $subtitle_value = $_REQUEST['menu-item-subtitle'][$menu_item_db_id];
                        update_post_meta($menu_item_db_id, '_menu_item_subtitle', $subtitle_value);
                    }
                }
            }
           
            // Check if element is properly sent
            if (isset($_REQUEST['menu-item-template'])) {
                if (is_array($_REQUEST['menu-item-template'])) {
                    if (isset($_REQUEST['menu-item-template'][$menu_item_db_id])) {
                        $template_value = $_REQUEST['menu-item-template'][$menu_item_db_id];
                        update_post_meta($menu_item_db_id, '_menu_item_template', $template_value);
                    }
                }
            }
			 /*
            // Check if element is properly sent
            if (isset($_REQUEST['menu-item-mega'])) {
                if (is_array($_REQUEST['menu-item-mega'])) {
                    if (isset($_REQUEST['menu-item-mega'][$menu_item_db_id])) {
                        $template_value = $_REQUEST['menu-item-mega'][$menu_item_db_id];
                        update_post_meta($menu_item_db_id, '_menu_item_mega', $template_value);
                    }
                }
            }
            */
        }

        /**
         * Define new Walker edit
         *
         * @access      public
         * @since       1.0 
         * @return      void
         */
        function edit_walker($walker, $menu_id) {

            return 'C5_Walker_Nav_Menu_Edit_Custom';
        }

    }

// instantiate plugin's class
    $GLOBALS['c5_custom_menu'] = new c5_custom_menu();

    class C5_description_walker extends Walker_Nav_Menu {

        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            global $wp_query;
            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
			
            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));

            $li_class = '';
            $a_class = '';
            $a_data = '';

            $thisCat = get_term_by('id', $item->object_id, $item->object);
            if (is_object($thisCat)) {
            
                global $c5_terms_array;
               $category_icon= '';
                if(isset($c5_terms_array[ $item->object . '-' . strval( $item->object_id) ] )){
                	$category_icon = $c5_terms_array[ $item->object . '-' .strval( $item->object_id )]['icon'];
                }
                
                if ($item->template != '' && $item->template != 'no') {
                    $li_class = ' c5-mega-menu-li ' . $item->object_id . '-' . $item->object;
                    $a_class = ' c5-mega-menu-a';
                    $a_data = 'c5-mega-data="' . $item->object_id . '#' . $item->object . '#' . $item->template .'"';
                }
                
            } else {
                $category_icon = '';
            }

//            if ($item->mega != '' && $item->mega != 'no') {
//                $li_class .= ' c5-mega-sub-menu';
//            }

            $class_names = ' class="' . esc_attr($class_names) . $li_class . '"';

            $output .= $indent . '<li  ' . $value . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

            $prepend = '<span>';
            $append = '</span>';
            $description = '';

            $item_output = $args->before;




            $item_output .= '<a' . $attributes . ' ' . $a_data . ' class="' . $a_class . ' " ><span class="'.$category_icon.' ' . esc_attr($item->subtitle) . '"></span>' ;
            $item_output .= $args->link_before . $prepend . apply_filters('the_title', $item->title, $item->ID) . $append;
            $item_output .= $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
			
            if ($item->template != '' && $item->template != 'no') {
                $item_output .= '<div class="c5-mega-menu-wrap" ><div class="mid-page"><span class=" icon-arrows-ccw c5-loading rotate-360"></span></div></div>';
            }
			
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

    function c5_special_nav_class($classes, $item) {

        $thisCat = get_term_by('id', $item->object_id, $item->object);
        if (is_object($thisCat)) {
            
            $classes[] = $item->object . '-' . $item->object_id;
        }
        return $classes;
    }

    add_filter('nav_menu_css_class', 'c5_special_nav_class', 10, 2);
    
    
    
    
    function c5ab_menu_mega_menu() {
    	$info = explode('#', $_POST['passing_string']);
    	
    	  $cat_id = $info[0];
    	  $tax = $info[1];
    	  $order = $info[2];
    	  $tax_object = get_taxonomy($tax);
    	  $post_type = $tax_object->object_type[0];
    	  $GLOBALS['c5_content_width'] = 1070;
    	  
    	  $count =  4;
    	  $GLOBALS['c5_content_width'] = floor( 1070/$count) ;
    	  $args = array(
    	  'posts_per_page' => $count, /* you can change this to show more */
    	  'post_type' => array( $post_type ),
    	  );
    	  
    	  if ($tax == 'category') {
    	      $args['cat'] = $cat_id;
    	  } else {
    	      $args['tax_query'] = array(
    	          'taxonomy' => $tax,
    	          'field' => 'id',
    	          'terms' => $cat_id
    	      );
    	  }
    	  
    	  switch ($order) {
    	  	case 'date':
    	  		$args['orderby'] = 'date';
    	  		break;
    	  	case 'comment_count':
    	  		$args['orderby'] = 'comment_count';
    	  		break;
    	  	case 'views':
    	  		$args['orderby'] = 'meta_value_num';
    	  		$args['meta_key'] = 'post_views_count';
    	  		break;
    	  	case 'likes':
    	  		$args['orderby'] = 'meta_value_num';
    	  		$args['meta_key'] = 'votes_count';
    	  		break;
    	  	case 'social':
    	  		$args['orderby'] = 'meta_value_num';
    	  		$args['meta_key'] = 'total_share';
    	  		break;
    	  	case  'rating':
    	  		$args['orderby'] = 'meta_value_num';
    	  		$args['meta_key'] = 'rating_average';
    	  		break;
    	  	default:
    	  		$args['orderby'] = 'date';
    	  		break;
    	  }
    	  $post_obj = new C5_post();
    	  // The Query
    	  $the_query = new WP_Query( $args );
    	  
    	  if ( $the_query->have_posts() ) {
    	         $return = '<div class="mid-page"><div class="c5-mega-menu-block" "><div class="row">';
    	  		while ( $the_query->have_posts() ) {
    	  			$the_query->the_post();
	    	  		$return .=  '<div class="col-sm-3">' .$post_obj->get_menu_post( ) .'</div>';
	    	  	}
    	  		$return .='</div></div></div>';
    	  	}
    	  		
    	  		
    	  
    	  wp_reset_postdata();
    	  echo $return;
    	  
    	die();
    	
    }
    
    
    add_action( 'wp_ajax_c5ab_menu_mega_menu', 'c5ab_menu_mega_menu' );
    add_action( 'wp_ajax_nopriv_c5ab_menu_mega_menu', 'c5ab_menu_mega_menu' );
    
    ?>