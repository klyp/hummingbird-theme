<?php

if (! defined('ABSPATH')) exit; // Exit if accessed directly

// define table
define('HB_LOG_TABLE', 'admin_activity_log');

/**
 * Main class for HummingbirdLog
 */
class HummingbirdLog
{
    protected $postData = array();
    protected $postType = '';
    protected $postUrl  = '';

    function __construct()
    {
        add_action('after_setup_theme', array(&$this, 'klyp_add_log_table_db'));

        // user
        add_action('wp_login', array(&$this, 'klyp_log_login'), 10, 2);
        add_action('clear_auth_cookie', array( &$this, 'klyp_log_logout'));
        add_action('delete_user', array( &$this, 'klyp_log_user_delete'), 10, 1);
        add_action('user_register', array(&$this, 'klyp_log_user_register'), 10, 1);
        add_action('profile_update', array( &$this, 'klyp_log_user_updated'), 10, 1);

        // posts
        add_action('transition_post_status', array(&$this, 'klyp_log_transition_post_status'), 10, 3);
        add_action('delete_post', array(&$this, 'klyp_log_delete_post'), 10, 1);
        add_filter('wp_insert_post_data', array(&$this, 'klyp_log_post_data'), 10, 2);

        //options
        add_action('updated_option', array(&$this, 'klyp_log_option_update'), 10, 3);

        // plugin
        add_action('activated_plugin', array(&$this, 'klyp_log_plugin_activated'), 10, 1);
        add_action('deactivated_plugin', array(&$this, 'klyp_log_plugin_deactivated'), 10, 1);
        add_action('upgrader_process_complete', array( &$this, 'klyp_log_plugin_install_update' ), 10, 2);
        add_action('deleted_plugin', array( &$this, 'klyp_log_plugin_delete' ), 10, 2);

        // menu
        add_action('wp_update_nav_menu', array(&$this, 'klyp_log_menu_create_update'), 10, 1);
        add_action('wp_create_nav_menu', array(&$this, 'klyp_log_menu_create_update'), 10, 1);
        add_action('delete_nav_menu', array(&$this, 'klyp_log_menu_delete'), 10, 3);
    }

    /**
     * Create table
     * @return void
     */
    function klyp_add_log_table_db()
    {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $tableName = $wpdb->prefix . HB_LOG_TABLE;
        $wpdb->hummingbird_log = $tableName;

        $sql = "
            CREATE TABLE IF NOT EXISTS {$tableName} (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                user_id bigint(20) NOT NULL,
                url varchar(100) DEFAULT NULL,
                action varchar(20) DEFAULT NULL,
                type varchar(100) DEFAULT NULL,
                data longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                date timestamp NOT NULL DEFAULT current_timestamp(),
                ip varchar(45) NOT NULL,
                PRIMARY KEY (id)
            ) CHARSET=utf8;";

        dbDelta($sql);
    }

    /**
     * Insert log
     * @param int
     * @param string $action
     * @return void
     */
    function klyp_insert_user_log($action = '', $user = null)
    {
        if (! $user) {
            $user = get_user_by('id', get_current_user_id());
        }
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        global $wpdb;

        $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO " . $wpdb->prefix . HB_LOG_TABLE . "
                (user_id, url, action, type, data, ip)
                VALUES (%d, %s, %s, %s, %s, %s)",
                $user->ID, ($this->postUrl) ?: $url, ($action) ?: $_SERVER['REQUEST_METHOD'], $this->postType, json_encode($this->postData, JSON_PRETTY_PRINT), klyp_get_the_user_ip()
            )
        );
    }

    /**
     * Log user login
     * @param string
     * @param object
     * @return void
     */
    function klyp_log_login($user_login, $user)
    {
        $this->postType = 'user';
        $this->klyp_insert_user_log('login', $user);
    }

    /**
     * Log user logout
     * @return void
     */
    function klyp_log_logout()
    {
        $user = wp_get_current_user();

        if (empty($user) || ! $user->exists()) {
            return;
        }

        $this->postType = 'user';
        $this->klyp_insert_user_log('logout', $user);
    }

    /**
     * Log user deleted
     * @param int
     * @return void
     */
    function klyp_log_user_delete($user_id)
    {
        $user = get_user_by('id', $user_id);

        $this->postType = 'user';
        $this->postData = $user;
        $this->klyp_insert_user_log('deleted');
    }

    /**
     * Log user created
     * @param int
     * @return void
     */
    function klyp_log_user_register($user_id)
    {
        $user = get_user_by('id', $user_id);

        $this->postType = 'user';
        $this->postData = $user;
        $this->klyp_insert_user_log('created');
    }

    /**
     * Log user updated
     * @param int
     * @return void
     */
    function klyp_log_user_updated($user_id)
    {
        $user = get_user_by('id', $user_id);

        $this->postType = 'user';
        $this->postData = $user;
        $this->klyp_insert_user_log('updated');
    }

    /**
     * Log post data
     * @param object
     * @param array
     * @return object
     */
    function klyp_log_post_data($data, $postarr)
    {
        if ($postarr['post_status'] !== 'auto-draft') {
            $this->postData = $postarr;
            $this->postUrl  = isset($postarr['referredby']) ? $postarr['referredby'] : $postarr['guid'];
        }
        return $data;
    }

    /**
     * Log post transition status
     * @param string
     * @param string
     * @param object
     * @return void
     */
    function klyp_log_transition_post_status($new_status, $old_status, $post)
    {
        if ($old_status === 'auto-draft' && ($new_status !== 'auto-draft' && $new_status !== 'inherit')) {
            // page created
            $action = 'created';
        } elseif ($new_status === 'auto-draft' || ($old_status === 'new' && $new_status === 'inherit')) {
            // ignore it.
            return;
        } elseif ($new_status === 'trash') {
            // page deleted.
            $action = 'trashed';
        } elseif ($old_status === 'trash') {
            $action = 'restored';
        } else {
            // page updated.
            $action = 'updated';
        }

        if (wp_is_post_revision($post->ID)) {
            return;
        }
        // Skip for menu items.
        if (get_post_type($post->ID) === 'nav_menu_item') {
            return;
        }
        $this->postType = $post->post_type;
        $this->klyp_insert_user_log($action);
    }

    /**
     * Log delete action
     * @param [type] $post_id
     * @return void
     */
    function klyp_log_delete_post($post_id)
    {
        if (wp_is_post_revision($post_id)) {
            return;
        }

        $post = get_post($post_id);

        if (! $post) {
            return;
        }

        if (in_array($post->post_status, array('auto-draft', 'inherit'))) {
            return;
        }

        // Skip for menu items.
        if ('nav_menu_item' === get_post_type($post->ID)) {
            return;
        }

        $this->klyp_insert_user_log('deleted');
    }

    /**
     * Log option update
     * @param string
     * @param string
     * @param string
     * @return void
     */
    function klyp_log_option_update($option_name, $old_value, $value)
    {
        $action = 'updated';

        switch ($option_name) {
            case '_transient_doing_cron':
            case '_transient_timeout_users_online':
            case '_site_transient_update_plugins':
            case '_site_transient_update_core':
            case '_site_transient_update_themes':
            case 'cron':
            case 'active_plugins':
            case 'recently_activated':
                return;
        }
        // $option_name
        $postData[$option_name]['old_value'] = $old_value;
        $postData[$option_name]['new_value'] = $value;
        $this->postType = 'options';
        $this->postData = $postData;
        $this->klyp_insert_user_log($action);
    }

    /**
     * Log plugin activated
     * @param string
     * @return void
     */
    function klyp_log_plugin_activated($plugin_name)
    {
        $this->postType = 'plugin';
        $this->postData = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_name, true, false);;
        $this->klyp_insert_user_log('activated');
    }

    /**
     * Log plugin deactivated
     * @param string
     * @return void
     */
    function klyp_log_plugin_deactivated($plugin_name)
    {
        $this->postType = 'plugin';
        $this->postData = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_name, true, false);
        $this->klyp_insert_user_log('deactivated');
    }

    /**
     * Log plugin install or update
     * @param object
     * @param array
     * @return void
     */
    function klyp_log_plugin_install_update($upgrader, $extra)
    {
        if (! isset($extra['type']) || $extra['type'] !== 'plugin') {
            return;
        }

        if ($extra['action'] === 'install') {
            $path = $upgrader->plugin_info();

            if (! $path) {
                return;
            }

            $data = get_plugin_data( $upgrader->skin->result['local_destination'] . '/' . $path, true, false );

            $this->postType = 'plugin';
            $this->postData = $data;
            $this->klyp_insert_user_log('installed');
        }

        if ($extra['action'] === 'update') {
            if (isset($extra['bulk']) && $extra['bulk'] === true) {
                $slugs = $extra['plugins'];
            } else {
                if (! isset($upgrader->skin->plugin)) {
                    return;
                }
            }

            // go through the log
            foreach ($slugs as $slug) {
                $data = get_plugin_data(WP_PLUGIN_DIR . '/' . $slug, true, false);

                $this->postType = 'plugin';
                $this->postData = $data;
                $this->klyp_insert_user_log('updated');
            }
        }
    }

    /**
     * Log plugin delete
     * @param string
     * @param boolean
     * @return void
     */
    function klyp_log_plugin_delete($plugin_name, $success)
    {
        if ($success === true) {
            $this->postType = 'plugin';
            $this->postData = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_name, true, false);
            $this->klyp_insert_user_log('deleted');
        }
    }

    /**
     * Log menu create or update
     * @param int
     * @return void
     */
    function klyp_log_menu_create_update($nav_id)
    {
        // get menu
        $menu = wp_get_nav_menu_object($nav_id);

        if ($menu) {
            if (current_filter() == 'wp_create_nav_menu') {
                $action = 'created';
            } else {
                $action = 'updated';
            }

            $this->postType = 'menu';
            $this->postData = $menu;
            $this->klyp_insert_user_log($action);
        }
    }

    /**
     * Log menu delete
     * @param string
     * @param int
     * @param object
     * @return void
     */
    function klyp_log_menu_delete($term, $tt_id, $nav)
    {
        $this->postType = 'menu';
        $this->postData = $nav;
        $this->klyp_insert_user_log('deleted');
    }
}
