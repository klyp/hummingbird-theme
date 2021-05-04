<?php

// if admin then we add js and other scripts
add_action('admin_enqueue_scripts', function($hook_suffix) {
    wp_enqueue_script('klyp-hummingbird-admin-js', get_template_directory_uri() . '/assets/admin/main.js', array('jquery'));
    wp_enqueue_style('klyp-hummingbird-admin-css', get_template_directory_uri() . '/assets/admin/main.css');
});

/**
 * Add admin notice
 * @param string
 * @param string
 * @return void
 */
function klyp_add_admin_notice($notice = '', $type = 'warning')
{
    $notices = get_option('klyp_admin_notices', array());

    // push notices
    array_push($notices, array(
        'notice'    => $notice,
        'type'      => $type
    ));

    // update
    update_option('klyp_admin_notices', $notices);
}

/**
 * Display admin notices
 * @return void
 */
function klyp_display_admin_notices()
{
    $notices = get_option('klyp_admin_notices', array());

    if (! empty($notices)) {
        foreach ($notices as $notice) {
            printf('<div class="notice notice-%1$s is-dismissible"><p>%2$s</p></div>',
                $notice['type'],
                $notice['notice']
            );
        }

        delete_option('klyp_admin_notices', array());
    }
}
add_action('admin_notices', 'klyp_display_admin_notices', 12);
