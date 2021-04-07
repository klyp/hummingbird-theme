<?php

/**
 * Custom post type for Global Components
 */
function custom_global_components_post_type() {
    // Set UI labels for Global Components Type
    $labels = array(
        'name'                => _x('Global Components', 'Post Type General Name', 'klyp'),
        'singular_name'       => _x('Global Component', 'Post Type Singular Name', 'klyp'),
        'menu_name'           => __('Global Components', 'klyp'),
        'parent_item_colon'   => __('Parent Global Component', 'klyp'),
        'all_items'           => __('All Global Components', 'klyp'),
        'view_item'           => __('View Global Component', 'klyp'),
        'add_new_item'        => __('Add New Global Component', 'klyp'),
        'add_new'             => __('Add New', 'klyp'),
        'edit_item'           => __('Edit Global Component', 'klyp'),
        'update_item'         => __('Update Global Component', 'klyp'),
        'search_items'        => __('Search Global Component', 'klyp'),
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
