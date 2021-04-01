<?php

/** Create search form
 * @param string
 * @return string
 */
function klyp_widget_search_form($text)
{
    $text = '<form role="search" method="get" class="search-form" action="">
                <label>
                    <span class="screen-reader-text">Search for:</span>
                    <input type="search" name="s" class="search-field" value="" placeholder="Search">
                </label>
                <div class="hb-form-search-icon">
                    <i class="fas fa-search"></i>
                </div>
            </form>';
    return $text;
}
add_filter('get_search_form', 'klyp_widget_search_form');


/** Posts navigation
 * @return void
 */
function klyp_posts_navigation()
{
    if (is_singular()) {
        return;
    }

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1) {
        return;
    }

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max   = intval($wp_query->max_num_pages);

    /** Add current page to the array */
    if ($paged >= 1) {
        $links[] = $paged;
    }

    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="row"><div class="col-12"><div class="hb-blog__pagination
    d-flex flex-wrap flex-column flex-md-row align-items-center
    justify-content-md-between"><ul class="hb-blog__pagination-list list-inline">' . "\n";

    /** Link to first page, plus ellipses if necessary */
    if (! in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf(
            '<li class="list-inline-item"><a %s href="%s">%s</a></li>',
            $class,
            esc_url(get_pagenum_link(1)),
            '1'
        );

        if (! in_array(2, $links)) {
            echo '<li>…</li>';
        }
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array) $links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf(
            '<li class="list-inline-item"><a %s href="%s">%s</a></li>',
            $class,
            esc_url(get_pagenum_link($link)),
            $link
        );
    }

    /** Link to last page, plus ellipses if necessary */
    if (! in_array($max, $links)) {
        if (! in_array($max - 1, $links)) {
            echo '<li>…</li>' . "\n";
        }
        $class = $paged == $max ? ' class="active"' : '';
        printf(
            '<li class="list-inline-item"><a %s href="%s">%s</a></li>',
            $class,
            esc_url(get_pagenum_link($max)),
            $max
        );
    }
    echo '</ul><div class="hb-blog__pagination-number">Page ' . $paged . ' of ' . $max . '</div></div></div></div>';
}

/** Breadcrumb navigation
 * @return void
 */
function klyp_breadcrumb()
{
    global $post;

    if ((is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type()) {
        $pageTitle = get_the_title(get_option('page_for_posts', true));
    } else {
        $pageTitle = $post->post_title;
    }

    echo '<div class="hb-breadcumb hb-gradient-secondary hb-breadcumb--color-gray">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="hb-breadcumb__title">'. $pageTitle .'</h2>
                    </div>
                    <div class="col-12">
                        <nav aria-label="breadcrumb" class="hb-breadcumb__nav">
                            <ol class="d-flex flex-wrap list-inline justify-content-md-end m-0">';

    if (! is_home()) {
        printf(
            '<li class="hb-breadcumb__item breadcrumb-item"><a href="%s">%s</a></li>',
            get_option('home'),
            'Home'
        );
        if (is_category() || is_single()) {
            echo '<li class="hb-breadcumb__item breadcrumb-item">';
            the_category(' </li><li class="hb-breadcumb__item breadcrumb-item"> ');
            if (is_single()) {
                echo '</li><li class="hb-breadcumb__item breadcrumb-item">';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if ($post->post_parent) {
                $anc = get_post_ancestors($post->ID);
                $title = get_the_title();
                foreach ($anc as $ancestor) {
                    $output .= '<li class="hb-breadcumb__item breadcrumb-item">
                    <a href="' . get_permalink($ancestor).'" title="' . get_the_title($ancestor) . '">' .
                    get_the_title($ancestor) . '</a></li>';
                }
                echo $output;
                echo '<strong title="' . $title . '"> ' . $title . '</strong>';
            } else {
                echo '<li class="hb-breadcumb__item breadcrumb-item"><strong>' . get_the_title() . '</strong></li>';
            }
        }
    } elseif ((is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type()) {
        printf(
            '<li class="hb-breadcumb__item breadcrumb-item"><a href="%s">%s</a></li>',
            get_option('home'),
            'Home'
        );
        printf(
            '<li class="hb-breadcumb__item breadcrumb-item active" aria-current="page">%s</li>',
            get_the_title(get_option('page_for_posts', true))
        );
    } elseif (is_tag()) {
        echo '<li class="hb-breadcumb__item breadcrumb-item">';
        single_tag_title();
        echo '</li>';
    } elseif (is_day()) {
        echo '<li class="hb-breadcumb__item breadcrumb-item">Archive for ';
        the_time('F jS, Y');
        echo '</li>';
    } elseif (is_month()) {
        echo '<li class="hb-breadcumb__item breadcrumb-item">Archive for ';
        the_time('F, Y');
        echo '</li>';
    } elseif (is_year()) {
        echo '<li class="hb-breadcumb__item breadcrumb-item">Archive for ';
        the_time('Y');
        echo '</li>';
    } elseif (is_author()) {
        echo '<li class="hb-breadcumb__item breadcrumb-item">Author Archive</li>';
    } elseif (is_search()) {
        echo '<li class="hb-breadcumb__item breadcrumb-item">Search Results</li>';
    }
    echo '                   </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>' . "\n";
}
