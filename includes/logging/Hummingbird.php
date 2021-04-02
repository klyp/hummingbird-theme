<?php

namespace Hummingbird;

defined('ABSPATH') or die();

/**
 * Main class for Hummingbird
 */
class Hummingbird
{
    protected $postData = array();
    protected $postType = '';
    protected $postUrl  = '';

    public function __construct()
    {
        add_action('after_setup_theme', array(&$this, 'klyp_add_log_table_db'));
        add_action('wp_login', array(&$this, 'klyp_log_login'), 10, 2);
        add_action('transition_post_status', array(&$this, 'klyp_log_transition_post_status'), 10, 3);
        add_action('delete_post', array(&$this, 'klyp_log_delete_post'));
        add_filter('wp_insert_post_data', array(&$this, 'klyp_log_post_data'), 10, 2 );
    }
    
    function klyp_add_log_table_db()
    {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $tableName = $wpdb->prefix . 'hummingbird_logs';

        $sql = "
            CREATE TABLE IF NOT EXISTS {$tableName} (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                user_id bigint(20) NOT NULL,
                url varchar(100) DEFAULT NULL,
                action varchar(20) DEFAULT NULL,
                type varchar(100) DEFAULT NULL,
                data longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(data)),
                date timestamp NOT NULL DEFAULT current_timestamp(),
                ip varchar(45) NOT NULL,
                PRIMARY KEY (id)
            ) CHARSET=utf8;";

        dbDelta($sql);
    }

    function klyp_insert_user_log($user, $action = '')
    {
        global $wpdb;
        $tablename = $wpdb->prefix . 'hummingbird_logs';
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $data = array(
            'user_id'   => $user->ID,
            'url'       => ($this->postUrl) ?: $url,
            'action'    => ($action) ?: $_SERVER['REQUEST_METHOD'],
            'type'      => $this->postType,
            'data'      => json_encode($this->postData),
            'ip'        => klyp_get_the_user_ip()
        );
        $wpdb->insert($tablename, $data);
    }

    function klyp_log_login($user_login, $user)
    {
        klyp_insert_user_log($user);
    }

    function klyp_log_post_data($data, $postarr)
    {
        $this->postData = $postarr;
        $this->postUrl  = $postarr['referredby'];
        return $data;
    }


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
        $user = get_user_by('id', get_current_user_id());
        $this->klyp_insert_user_log($user, $action);
    }


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

        $user = get_user_by('id', get_current_user_id());
        $this->klyp_insert_user_log($user, 'deleted');
    }

}
