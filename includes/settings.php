<?php

// Create a new role called Super Admin which should have FULL control
if (! $GLOBALS['wp_roles']->is_role('super-admin')) {
    add_role('super-admin', 'Super Admin', get_role('administrator')->capabilities);
}

/**
 * Get all super admins from settings *
 * @return void
 */
function klyp_get_super_admins()
{
    // if already super-admin
    if (array_shift(wp_get_current_user()->roles) == 'super-admin') {
        return;
    }

    // get super admins from settings
    $super_admins = get_field('super_admins', 'option');
    
    // if we have a list
    if ($super_admins) {
        $super_admins = wp_list_pluck($super_admins, 'username');
    }

    // If user is KLYP or user in the list and it is not super user yet, set it as Super Admin
    if (wp_get_current_user()->user_login == 'klyp' || in_array(wp_get_current_user()->ID, $super_admins)) {
        wp_get_current_user()->set_role('super-admin');
    }
}
add_action('admin_init', 'klyp_get_super_admins');

// If a user is not a super admin, disable access to certain things
if (! in_array('super-admin', wp_get_current_user()->roles)) {
    add_action('admin_init', 'klyp_remove_access_to_updates');
    add_action('admin_init', 'klyp_remove_menus');
    add_action('editable_roles', 'klyp_remove_super_admin_editable');
}

/**
 * Remove Super Admin role from roles list
 * @return void
 */
function klyp_remove_super_admin_editable($roles) {
    if (isset($roles['super-admin'])) {
        unset($roles['super-admin'] );
    }
    return $roles;
}

/**
 * Remove menus
 * @return void
 */
function klyp_remove_menus()
{
    // if global menu is set
    if (isset($GLOBALS['menu'])) {
        // Allowed parent menus
        $allowed_menus = array(
            'upload.php',
            'edit.php?post_type=page',
            'edit.php',
            'users.php',
            'widgets.php',
            'nav-menus.php',
            'themes.php',
            'wpcf7',
            'flamingo',
            'site-settings',
            'wpseo_dashboard'
        );
        foreach ($GLOBALS['menu'] as $key => $menu) {
            if (! in_array($menu[2], $allowed_menus)) {
                remove_menu_page($menu[2]);
            }
        }
    }
    // if global submenu isset
    if (isset($GLOBALS['submenu'])) {
        // Remove sub menus - parent - sub menu
        $allowed_submenus = array(
            'themes.php'            => [
                'widgets.php',
                'nav-menus.php'
            ],
        );
        foreach ($allowed_submenus as $parent_menu => $parent_submenu) {
            if (isset($GLOBALS['submenu'][$parent_menu])) {
                foreach ($GLOBALS['submenu'][$parent_menu] as $key => $submenus) {
                    if (! in_array($submenus[2], $parent_submenu)) {
                        remove_submenu_page($parent_menu, $submenus[2]);
                    }
                }
            }
        }
    }
}

/**
 * Remove access to updates
 * @return void
 */
function klyp_remove_access_to_updates()
{
    // Disallow installing plugins and updates
    define('DISALLOW_FILE_MODS', true);
    define('WP_AUTO_UPDATE_CORE', false);
}

/**
 * Remove admin bar links
 * @return void
 */
function klyp_remove_admin_bar_links()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the Wordpress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about Wordpress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the Wordpress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the Wordpress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('archive');          // Remove the archive link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
}
add_action('wp_before_admin_bar_render', 'klyp_remove_admin_bar_links');

/**
 * Remove dashboard widgets
 * @return void
 */
function klyp_remove_dashboard_widgets()
{
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', 'klyp_remove_dashboard_widgets');

/**
 * Update admin login logo
 * @return void
 */
function klyp_admin_login_logo()
{
    echo '
    <style type="text/css">
        #login h1 a, .login h1 a {
        background-image: url(' . get_stylesheet_directory_uri() . '/assets/dist/image/Klyp-Logo-RGB-Orange.png);
        background-repeat: no-repeat;
        background-size: 100% auto;
        height:160px;
        margin-bottom: 0;
        width:320px;
        }
    </style>';
}
add_action('login_enqueue_scripts', 'klyp_admin_login_logo');

/**
 * Update admin login logo url
 * @return void
 */
function klyp_admin_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'klyp_admin_login_logo_url');

/**
 * Update admin login url title
 * @return void
 */
function klyp_admin_login_logo_url_title()
{
    return 'Site by Klyp';
}
add_filter('login_headertext', 'klyp_admin_login_logo_url_title');

/**
 * Remove footer admin
 * @return void
 */
function klyp_remove_footer_admin()
{
    return '<span id="footer-thankyou">In collaboration with <a href="https://klyp.co"
    target="_blank">Klyp.co</a></span>';
}
add_filter('admin_footer_text', 'klyp_remove_footer_admin');

/**
 * Set max post/page revisions
 * @return int
 */
function klyp_set_max_revisions()
{
    // get max post revisions
    $maxRevision = (! empty(get_field('max_revision', 'option')) ? get_field('max_revision', 'option') : -1);

    return (int) $maxRevision;
}
add_filter('wp_revisions_to_keep', 'klyp_set_max_revisions', 1);

/**
 * Add button after max revision
 * @param object
 * @return void
 */
function klyp_max_revision_purge_button($field)
{
    echo '<div class="acf-actions">
            <p><a
                id="klyp-purge-revisions"
                class="acf-button button button-primary"
                href=""
                data-admin-url="' . admin_url('admin-ajax.php') . '"
                data-nonce="' . wp_create_nonce('klyp-hummingbird') . '"
                data-event="purge-revisions">
                    Purge Revisions
                </a></p>
          </div>';
}
add_action('acf/render_field/key=settings_advance_max_revision', 'klyp_max_revision_purge_button');

/**
 * Function to clean up revision post type
 * @return boolean
 */
function klyp_clean_up_revisions()
{
    if (! wp_verify_nonce($_REQUEST['nonce'], 'klyp-hummingbird')) {
        $return['message'] = esc_html__('Invalid request.');
        wp_send_json_error($return);
        die();
    }

    global $wpdb;
    $postType = 'revision';
    $maxRevision = (! empty(get_field('max_revision', 'option')) ? get_field('max_revision', 'option') : -1);
    $totalRevisions = 0;

    $allRevisions = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT DISTINCT post_parent
            FROM $wpdb->posts
            WHERE post_type = %s", $postType
        )
    );

    if ($allRevisions) {
        foreach ($allRevisions as $key => $revision) {
            $revisions = wp_get_post_revisions($revision->post_parent);

            if (count($revisions) <= $maxRevision) {
                continue;
            }

            $totalRevisions += count($revision);
            $revisionsToRemove = array_slice($revisions, $maxRevision, null, true);

            foreach ($revisionsToRemove as $revisionRemoved) {
                wp_delete_post_revision($revisionRemoved->ID);
            }
        }

        if ($totalRevisions > 0) {
            $return['message'] = esc_html__(sprintf('A total of %d revision(s) in %d post(s) have been purged.', $totalRevisions, count($allRevisions)));
        } else {
            $return['message'] = esc_html__('Nothing to purge.');
        }
    } else {
        $return['message'] = esc_html__('Nothing to purge.');
    }

    wp_send_json_success($return);
    die();
}
add_action('wp_ajax_klyp_clean_up_revisions', 'klyp_clean_up_revisions');
