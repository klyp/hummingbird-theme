<?php

// if admin then we add js and other scripts
if (is_admin()) {
    add_action('admin_enqueue_scripts', function() {
        wp_enqueue_script('klyp-hummingbird-admin-js', get_template_directory_uri() . '/assets/admin/main.js', array('jquery'));
        wp_enqueue_style('klyp-hummingbird-admin-css', get_template_directory_uri() . '/assets/admin/main.css');
    });
}
