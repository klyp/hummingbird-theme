<?php

/**
 * Save post callback
 * @param  int
 * @return void
 */
function klyp_save_post_callback($target = null)
{
    global $post;

    // if no post ID then do nothing
    if (! isset($post->ID)) {
        return;
    }

    // allowed post types
    $allowed_post_types = array('page', 'post');
    // if revision
    if (isset($post_id) && wp_is_post_revision($post_id)) {
        return;
    }
    // if doing auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // if no post type and target is null
    if ((! isset($post->post_type) || ! in_array($post->post_type, $allowed_post_types)) && is_null($target)) {
        return;
    }

    // if we have post id
    if (isset($post->ID)) {
        $target = $post->ID;
    }

    // Generate component ids
    // if we have components on the post
    if (have_rows('components', $post->ID)) {
        // go through all components
        while (have_rows('components', $post->ID)) {
            the_row();
            // update section id
            $section_id     = empty(get_sub_field('id')) ?
            get_row_layout() . '-' . (get_row_index() - 1) . '-' . $post->ID :
            get_sub_field('id');
            $section_key    = 'components_' . (get_row_index() - 1) . '_id';
            update_field($section_key, $section_id, $post->ID);
        }
    }
}

// Only allows admin
if (is_admin()) {
    add_action('save_post', 'klyp_save_post_callback');
}

/**
 * Add site wide header script
 * @return void
 */
function klyp_hook_head()
{
    echo get_field('settings_script_header', 'options');
}
add_action('wp_head', 'klyp_hook_head');

/**
 * Add site wide body script
 * @param  array
 * @return string
 */
function klyp_hook_body($classes)
{
    $classes[] = '">' . get_field('settings_script_body', 'options') . '<noscript></noscript novar="';
    return $classes;
}

/**
 * Add site wide body script for version 5.2.0 and up
 * 
 * @return string
 */
function klyp_hook_body_v5() {
    echo get_field('settings_script_body', 'options');
}

// making sure backward compatible
if (version_compare(get_bloginfo('version'), '5.2', '>=')) {
    add_filter('wp_body_open', 'klyp_hook_body_v5', PHP_INT_MAX);
} else {
    add_filter('body_class', 'klyp_hook_body', PHP_INT_MAX);
}

/**
 * Add site wide footer script
 * @return void
 */
function klyp_hook_footer()
{
    echo get_field('settings_script_footer', 'options');
}
add_action('wp_footer', 'klyp_hook_footer');

// Remove site icon
remove_action('wp_head', 'wp_site_icon', 99);

/**
 * Generate component styles with extras
 * @param  string $id
 * @param  array $styles
 * @return string
 */
function klyp_process_css($styles = null)
{
    if (! $styles || empty($styles)) {
        return;
    }

    // Variables decleration
    $temp           = '';
    $tempM          = '';
    $desktopcss     = '';
    $mobilecss      = '';
    $css            = '';

    foreach ($styles as $section => $breakpoint) {
        if (isset($breakpoint['desktop'])) {
            $css .= '
                #' . $section . ' { ';
                // generate desktop
                $temp = '';
            foreach ($breakpoint['desktop'] as $keys => $values) {
                // If values is array, then we need to generate extra styles
                if (is_array($values)) {
                        $temp .= '
                            #' . $section . ' ' . $keys . ' {';
                    foreach ($values as $key => $value) {
                        $temp .= $key . ': ' . $value . ';';
                    }
                        $temp .= '}';
                } else {
                    $css .= $keys . ': ' . $values . ';';
                }
            }
            $css .= ' }';
        }

        $css .= $temp;

        if (isset($breakpoint['mobile'])) {
            $css .= '
                @media only screen and (max-width: 1200px) {
                    #' . $section . ' {';
                    // generate mobile
                    $tempM = '';
            foreach ($breakpoint['mobile'] as $keys => $values) {
                // If values is array, then we need to generate extra styles
                if (is_array($values)) {
                    $tempM .= '
                                #' . $section . ' ' . $keys . ' {';
                    foreach ($values as $key => $value) {
                            $tempM .= $key . ': ' . $value . ';';
                    }
                            $tempM .= '}';
                } else {
                    $css .= $keys . ': ' . $values . ';';
                }
            }
            $css .= '
                    }
                    ' . $tempM . '
                }
            ';
        }
    }
    return $css;
}

/**
 * Function to minimize css
 * @param string
 * @return string
 */
function klyp_minimize_css($css)
{
    if (! $css || empty($css)) {
        return;
    }

    $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css);
    $css = preg_replace('/\s{2,}/', ' ', $css);
    $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
    $css = preg_replace('/;}/', '}', $css);
    $css = str_replace(site_url(), '', $css);
    return '<style>' . $css . '</style>';
}
