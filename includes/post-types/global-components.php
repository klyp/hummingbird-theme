<?php

/**
 * Custom post type for Global Components
 */
function custom_global_components_post_type() {
    // Set UI labels for Global Components Type
    $labels = array(
        'name'                => _x('Components', 'Post Type General Name', 'klyp'),
        'singular_name'       => _x('Component', 'Post Type Singular Name', 'klyp'),
        'menu_name'           => __('Components', 'klyp'),
        'parent_item_colon'   => __('Parent Component', 'klyp'),
        'all_items'           => __('All Components', 'klyp'),
        'view_item'           => __('View Component', 'klyp'),
        'add_new_item'        => __('Add New Component', 'klyp'),
        'add_new'             => __('Add New', 'klyp'),
        'edit_item'           => __('Edit Component', 'klyp'),
        'update_item'         => __('Update Component', 'klyp'),
        'search_items'        => __('Search Component', 'klyp'),
        'not_found'           => __('Not Found', 'klyp'),
        'not_found_in_trash'  => __('Not found in Trash', 'klyp'),
    );

    // Set other options for Global Component type
    $args = array(
        'label'               => __('global-component', 'klyp'),
        'description'         => __('Global Component', 'klyp'),
        'labels'              => $labels,
        'supports'            => array('title'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );

    register_post_type('global-component', $args);
}
add_action('init', 'custom_global_components_post_type', 0);

/**
 * Add new column for global component
 * @param array
 * @return array
 */
function klyp_set_custom_column_global_component($columns)
{
    // set date column to last
    $date = $columns['date'];
    unset($columns['date']);

    // create new column
    $columns['component'] = __('Component', 'hummingbird');

    // set date back
    $columns['date'] = $date;
    return $columns;
}
add_filter('manage_global-component_posts_columns', 'klyp_set_custom_column_global_component');

/**
 * Set value for column
 * @param string
 * @param int
 * @return void
 */
function klyp_set_custom_column_global_component_value($column, $post_id)
{
    switch ($column) {
        case 'component' :
            echo get_field('select_global_component', $post_id);
            break;
    }
}
add_action('manage_global-component_posts_custom_column' , 'klyp_set_custom_column_global_component_value', 10, 2);

/**
 * Set sortable
 * @param array
 * @return array
 */
function klyp_set_custom_column_global_component_sortable($columns)
{
    $columns['component'] = 'component';
    return $columns;
}
add_filter('manage_edit-global-component_sortable_columns', 'klyp_set_custom_column_global_component_sortable');

/**
 * Sort column
 * @param object
 * @return void
 */
function klyp_sort_custom_global_component_query($query)
{
    $postType   = $query->get('post_type');
    $orderby    = $query->get('orderby');

    if ($postType == 'global-component' && $orderby == 'component') {
        $meta_query = array(
            'relation' => 'OR',
            array(
                'key' => 'select_global_component',
                'compare' => 'NOT EXISTS', // see note above
            ),
            array(
                'key' => 'select_global_component',
            ),
        );
        $query->set('meta_query', $meta_query);
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'klyp_sort_custom_global_component_query');
