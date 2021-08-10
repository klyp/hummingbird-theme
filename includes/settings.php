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
    } else {
        $super_admins = array();
    }

    // If user is KLYP or user in the list and it is not super user yet, set it as Super Admin
    if (wp_get_current_user()->user_login == 'klyp' || in_array(wp_get_current_user()->ID, $super_admins)) {
        wp_get_current_user()->set_role('super-admin');
    } else {
        wp_get_current_user()->remove_role('super-admin');
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
function klyp_remove_super_admin_editable($roles)
{
    if (isset($roles['super-admin'])) {
        unset($roles['super-admin']);
    }
    return $roles;
}

/**
 * Update Super Admin cap on plugin activation.
 * @return void
 */
function klyp_update_super_admin_cap() {
    $adminCap      = get_role('administrator')->capabilities;
    $superAdminCap = get_role('super-admin')->capabilities;
    foreach ($adminCap as $aKey => $aVal) {
        if ( ! array_key_exists($aKey, $superAdminCap)) {
            $superAdminObject = get_role('super-admin');
            $superAdminObject->add_cap($aKey);
        }
    }
}
add_action('activated_plugin', 'klyp_update_super_admin_cap');

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
            'wpseo_dashboard',
            'hummingbird_log_page'
        );

        // add custom post types
        $allowed_post_types = get_field('allowed_post_types', 'option');

        // if we have set allowed post types
        if ($allowed_menus && $allowed_post_types && is_array($allowed_post_types)) {
            foreach ($allowed_post_types as $key => $value) {
                array_push($allowed_menus, $value['value']);
            }
        }

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
        background-image: url(' . get_template_directory_uri() . '/assets/dist/image/Klyp-Logo-RGB-Orange.png);
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
 * Add button after max days to keep log
 * @param object
 * @return void
 */
function klyp_max_log_days_button($field)
{
    echo '<div class="acf-actions">
            <p><a
                id="klyp-purge-logs"
                class="acf-button button button-primary"
                href=""
                data-admin-url="' . admin_url('admin-ajax.php') . '"
                data-nonce="' . wp_create_nonce('klyp-hummingbird') . '"
                data-event="purge-logs">
                    Purge Logs
                </a>
            </p>
          </div>';
}
add_action('acf/render_field/key=settings_advance_max_days_log', 'klyp_max_log_days_button');

/**
 * Function to clean up revision post type
 * @return boolean
 */
function klyp_clean_up_revisions()
{
    if (! wp_verify_nonce($_REQUEST['nonce'], 'klyp-hummingbird')) {
        $return['message'] = esc_html__('Invalid request.');
        wp_send_json_error($return);
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
}
add_action('wp_ajax_klyp_clean_up_revisions', 'klyp_clean_up_revisions');

/**
 * Function to clean up logs
 * @return boolean
 */
function klyp_clean_up_logs()
{
    if (! wp_verify_nonce($_REQUEST['nonce'], 'klyp-hummingbird')) {
        $return['message'] = esc_html__('Invalid request.');
        wp_send_json_error($return);
    }

    global $wpdb;
    $maxDaysLog = (! empty(get_field('max_days_log', 'option')) ? (int) get_field('max_days_log', 'option') : null);

    if (is_null($maxDaysLog) || $maxDaysLog <= 0) {
        $return['message'] = esc_html__('Please set the maximum number of days to keep log to at least one day.');
        wp_send_json_error($return);
    }

    $logs = $wpdb->get_results(
        $wpdb->prepare(
            "DELETE
            FROM " . $wpdb->prefix . HB_LOG_TABLE . "
            WHERE DATE(date) < (CURRENT_DATE - INTERVAL %d DAY)", $maxDaysLog
        )
    );
    $return['message'] = esc_html__('Logs have been cleaned up.');
    wp_send_json_success($return);
}
add_action('wp_ajax_klyp_clean_up_logs', 'klyp_clean_up_logs');

/**
 * Encrypt string using base64
 * @param string
 * @return void
 */
function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * Decrypt string using base64
 *
 * @param string
 * @return void
 */
function base64url_decode($data)
{
    return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
}

/**
 * Checks if site is multisite then add link
 * @return void
 */
function klyp_enable_multisite_login()
{
    global $wp_admin_bar;

    $nodes              = $wp_admin_bar->get_nodes();
    $current_site_id    = get_current_blog_id();
    $current_site       = get_site($current_site_id);
    $current_user       = wp_get_current_user();

    foreach ($nodes as $node) {
        // only update urls on network sites
        if (isset($node->href) && isset($node->id)) {
            $the_node = explode('-', $node->id);

            // if a site
            if ($the_node[0] == 'blog') {
                $node->href = add_query_arg([
                    // current site id, target site id, current user id, expiry
                    'klyp-login' => base64url_encode($current_site_id . '-' . $the_node[1] . '-' . $current_user->ID . '-' . strtotime('+1 hour'))
                ], $node->href);

                $wp_admin_bar->add_node($node);
            }
        }
    }
}

/**
 * Login user from multisite
 * @return void
 */
function klyp_single_login()
{
    if (isset($_GET['klyp-login'])) {
        // if user already logged in then redirect
        if (is_user_logged_in()) {
            wp_redirect(remove_query_arg(['klyp-login']));
            exit();
        }

        // decrypt
        list($referral_site, $target_site, $current_user_id, $expiry_time) = array_pad(explode('-', base64url_decode(sanitize_text_field($_GET['klyp-login']))), 4, '');

        // check expiry time
        if ($expiry_time < time()) {
            wp_die('Login failed, please contact us for more details (Token Expired).');
        }

        // check the site
        if (empty(get_site($referral_site)) || intval($target_site) !== intval(get_blog_details()->blog_id)) {
            wp_die('Login failed, please contact us for more details (Invalid site).');
        }

        // current user
        $current_user = get_user_by('ID', intval($current_user_id));
        // if all good, then authorize current user and checks if user belongs to a site
        if (is_user_member_of_blog($current_user->ID, intval($target_site))) {
            // set cookie
            wp_set_auth_cookie($current_user->ID, true);
            // set current user
            wp_set_current_user($current_user->ID);
            // log user
            add_action('init', function () use ($current_user) {
                do_action('wp_login', $current_user->name, $current_user);
            });
            wp_redirect(remove_query_arg(['klyp-login']));
            exit();
        } else {
            wp_die('Login failed, please contact us for more details (Invalid target user site).');
        }
    }
}

/**
 * Single logout
 * @return void
 */
function klyp_single_logout()
{
    // get all sites
    $sites = get_sites(array('public' => true));
    // get current user id before we log out
    $current_user_id = get_current_user_id();

    // let's go through all the sites in the network
    foreach ($sites as $site) {
        // if site id isn't from the original site
        if (intval(get_blog_details()->blog_id) != intval($site->blog_id)) {
            // let's switch to this site
            switch_to_blog($site->blog_id);
            // if the user is logged in on this site, then log them out
            if (is_user_logged_in()) {
                // get session tokens from this user
                $sessions = WP_Session_Tokens::get_instance($current_user_id);
                // destroy tokens
                $sessions->destroy_all();
            }
            // let's go back to original site so we can be redirected properly
            restore_current_blog();
        }
    }
    wp_redirect(get_home_url());
    exit();
}

// if site is a multi site then enable single login
if (is_multisite()) {
    add_action('init', 'klyp_single_login');
    add_action('wp_before_admin_bar_render', 'klyp_enable_multisite_login');
    add_action('clear_auth_cookie', 'klyp_single_logout');
}
