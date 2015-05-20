<?php

class C5_bread_crumb {

    function __construct() {
        
    }

    function enable_bread() {
        
       
        if (is_page()) {
            global $post;

            $bread_crumb = get_post_meta($post->ID, 'breadcrumb', true);
            if ($bread_crumb != 'off') {
                return true;
            }
        }
        return false;
    }

    function render() {
        global $c5_skindata;
        if ($this->enable_bread()) {
            ?>
            <div id="c5_bread_crumb" class=" c5-single-element c5-breaking-<?php echo $c5_skindata['layout_width'] ?>">
                <div class="border">
                    <div id="title_crumb">
                        <h1 class="heading1"><?php the_title(); ?></h1>
                        <div class="clearfix"></div>
                        <?php echo $this->breadcrumb(); ?>
                        <div class="arrow_down"></div>

                        <div class="clearfix"></div>
                    </div>
                </div>
              </div>
                <?php
            }
        }

        function breadcrumb() {

            $data = '';

            $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show

            if (is_rtl()) {
                $delimiter = ' <span class="fa fa-caret-left"> </span> '; // delimiter between crumbs
            } else {
                $delimiter = ' <span class="fa fa-caret-right"> </span> ';
            }

            $home = ' <span class="fa fa-home"> </span> '; // text for the 'Home' link
            $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
            $before = '<span class="current">'; // tag before the current crumb
            $after = '</span>'; // tag after the current crumb

            global $post;
            $homeLink = home_url();

            if (is_home() || is_front_page()) {

                if ($showOnHome == 1)
                    $data .= '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
            } else {

                $data .= '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

                if (is_category()) {
                    $thisCat = get_category(get_query_var('cat'), false);
                    if ($thisCat->parent != 0)
                        $data .= get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
                    $data .= $before . __('Archive by category "', 'code125') . single_cat_title('', false) . '"' . $after;
                } elseif (is_search()) {
                    $data .= $before . __('Search results for "', 'code125') . get_search_query() . '"' . $after;
                } elseif (is_day()) {
                    $data .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                    $data .= '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
                    $data .= $before . get_the_time('d') . $after;
                } elseif (is_month()) {
                    $data .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                    $data .= $before . get_the_time('F') . $after;
                } elseif (is_year()) {
                    $data .= $before . get_the_time('Y') . $after;
                } elseif (is_single() && !is_attachment()) {
                    if (get_post_type() != 'post') {
                        $post_type = get_post_type_object(get_post_type());
                        $slug = $post_type->rewrite;
                        $data .= '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                        if ($showCurrent == 1)
                            $data .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    } else {
                        $cat = get_the_category();
                        $cat = $cat[0];
                        $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                        if ($showCurrent == 0)
                            $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                        $data .= $cats;
                        if ($showCurrent == 1)
                            $data .= $before . get_the_title() . $after;
                    }
                } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                    $post_type = get_post_type_object(get_post_type());
                    $data .= $before . $post_type->labels->singular_name . $after;
                } elseif (is_attachment()) {
                    
                } elseif (is_page() && !$post->post_parent) {
                    if ($showCurrent == 1)
                        $data .= $before . get_the_title() . $after;
                } elseif (is_page() && $post->post_parent) {
                    $parent_id = $post->post_parent;
                    $breadcrumbs = array();
                    while ($parent_id) {
                        $page = get_page($parent_id);
                        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                        $parent_id = $page->post_parent;
                    }
                    $breadcrumbs = array_reverse($breadcrumbs);
                    for ($i = 0; $i < count($breadcrumbs); $i++) {
                        $data .= $breadcrumbs[$i];
                        if ($i != count($breadcrumbs) - 1)
                            $data .= ' ' . $delimiter . ' ';
                    }
                    if ($showCurrent == 1)
                        $data .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                } elseif (is_tag()) {
                    $data .= $before . __('Tag "', 'code125') . single_tag_title('', false) . '"' . $after;
                } elseif (is_author()) {
                    global $author;
                    $userdata = get_userdata($author);
                    $data .= $before . __('Posted by ', 'code125') . $userdata->display_name . $after;
                } elseif (is_404()) {
                    $data .= $before . __('Error 404', 'code125') . $after;
                }

                if (get_query_var('paged')) {
                    if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                        $data .= ' (';
                    $data .= __('Page', 'code125') . ' ' . get_query_var('paged');
                    if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                        $data .= ')';
                }

                $data .= '</div>';
            }

            return $data;
        }

    }
    ?>