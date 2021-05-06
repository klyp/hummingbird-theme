<?php

/**
 * Add Google Map API to ACF
 * @param  array
 * @return array
 */
function klyp_acf_google_map_api($api)
{
    if ($api_google_map = get_field('settings_api_google_map', 'option')) {
        $api['key'] = $api_google_map;
    }
    return $api;
}
add_filter('acf/fields/google_map/api', 'klyp_acf_google_map_api');

function klyp_block_custom_category($categories, $post)
{
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'acf',
                'title' => 'ACF',
            ),
        )
    );
}

add_filter('block_categories', 'klyp_block_custom_category', 10, 2);

/**
 * Initialize ACF Settings
 * @return void
 */
function klyp_acf_init()
{
    if ($api_google_map = get_field('settings_api_google_map', 'option')) {
        acf_update_setting('google_api_key', $api_google_map);
    }
}
add_action('acf/init', 'klyp_acf_init');

/**
 * Component Block Callback Function.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
function klyp_acf_block_render_callback($block, $content = '', $is_preview = false, $post_id = 0)
{
    $layoutName = str_replace($block['category'] . '/', '', $block['name']);
    get_template_part('/templates/components/' . $layoutName);
}

/**
 * Save ACF into JSON
 * @param  string
 * @return string
 */
function klyp_acf_json_save_folder($path)
{
    $path = get_template_directory() . '/includes/acf-json';
    return $path;
}

/**
 * Load ACF from JSON
 * @param  string
 * @return string
 */
function klyp_acf_json_load_folder($paths)
{
    unset($paths[0]);
    $paths[] = get_template_directory() . '/includes/acf-json';
    return $paths;
}

// If acf is installed
if (class_exists('acf')) {
    // Save ACF to jsons
    add_filter('acf/settings/save_json', 'klyp_acf_json_save_folder');

    // Load ACF from jsons
    add_filter('acf/settings/load_json', 'klyp_acf_json_load_folder');

    // Enable shortcode on wysiwyg
    add_filter('acf/format_value/type=wysiwyg', 'do_shortcode');

    // Add theme settings
    acf_add_options_page(
        array(
            'page_title'  => 'Site Settings',
            'menu_title'  => 'Site Settings',
            'menu_slug'   => 'site-settings',
            'capability'  => 'edit_posts',
            'redirect'    => false,
            'position'    => 2
        )
    );

    // Get available components fromt child themes
    $components = array();

    if (function_exists('klyp_acf_get_child_components')) {
        $components = klyp_acf_get_child_components();
    }

    // If components are empty
    if (empty($components) || count($components) <= 0) {
        $components = klyp_acf_get_components();
    }

    $componentFields = array();
    // Generate components
    if (function_exists('acf_register_block')) {
        foreach ($components as $component) {
            require locate_template('includes/components/' . $component . '.php');
            $componentFields = array_merge($componentFields, $fields);
        }
        if (! empty($componentFields)) {
            foreach ($componentFields as $key => $data) {
                acf_register_block(
                    array(
                        'name'              => $data['name'],
                        'title'             => __($data['label']),
                        'description'       => __($data['label']),
                        'render_callback'   => 'klyp_acf_block_render_callback',
                        'category'          => 'acf',
                        'mode'              => 'edit',
                        'post_types'        => array('post', 'page'),
                        'icon'              => 'list-view',
                        'keywords'          => array('components', $data['name']),
                        'supports'          => array(
                            'mode' => false
                        ),
                    )
                );
                $data['location'] = array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/' . $data['name'],
                        )
                    ),
                );
                $data['menu_order'] = 0;
                $data['position'] = 'normal';
                $data['style'] = 'default';
                $data['fields'] = $data['sub_fields'];
                $data['label_placement'] = 'top';
                $data['instruction_placement'] = 'label';
                $data['hide_on_screen'] = array(
                    0 => 'the_content',
                    1 => 'excerpt',
                    2 => 'discussion',
                    3 => 'comments',
                    4 => 'revisions',
                    5 => 'format',
                    6 => 'categories',
                    7 => 'tags',
                    8 => 'send-trackbacks',
                );
                acf_add_local_field_group($data);
            }
        }
    }
}

/**
 * Get available default components
 * @return array
 */
function klyp_acf_get_components()
{
    // Available default components
    $components = array(
        'accordion',
        'advance-counter',
        'blockquote',
        'breadcrumb',
        'call_to_action',
        'call_to_action_full',
        'cards',
        'content',
        'counter',
        'form',
        'gallery',
        'heading',
        'hero',
        'icon',
        'image-column',
        'image-content',
        'images',
        'location',
        'slider',
        'team',
        'tile',
        'timeline'
    );

    return $components;
}

/**
 * Add custom acf location rules types
 * @param  array
 * @return array
 */
function klyp_acf_location_rules_types($choices)
{
    $choices['Page']['visibility'] = 'Page Visibility';
    return $choices;
}
add_filter('acf/location/rule_types', 'klyp_acf_location_rules_types');

/**
 * Add custom acf location rules visibility
 * @param  array
 * @return array
 */
function klyp_acf_location_rules_values_visibility($choices)
{
    $choices['password'] = 'Password Protected';
    return $choices;
}
add_filter('acf/location/rule_values/visibility', 'klyp_acf_location_rules_values_visibility');

/**
 * Add custom acf location rules match visibility
 * @param  boolean
 * @param  array
 * @param  array
 * @return boolean
 */
function klyp_acf_location_rules_match_visibility($match, $rule, $options)
{
    global $post;
    $pw = $post->post_password;
    if (isset($pw)) {
        if (! empty($pw)) {
            $match = true;
        }
    } else {
        $match = false;
    }
    return $match;
}
add_filter('acf/location/rule_match/visibility', 'klyp_acf_location_rules_match_visibility', 10, 3);
