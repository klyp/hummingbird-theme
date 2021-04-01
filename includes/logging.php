<?php
    
function klyp_add_log_table_db()
{
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $tableName = $wpdb->prefix . 'logs';

    $sql = "
        CREATE TABLE IF NOT EXISTS {$tableName} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            url varchar(100) DEFAULT NULL,
            action varchar(20) DEFAULT NULL,
            data longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(data)),
            date timestamp NOT NULL DEFAULT current_timestamp(),
            ip varchar(45) NOT NULL,
            PRIMARY KEY (id)
        ) CHARSET=utf8;";

    dbDelta($sql);
}

add_action('after_setup_theme', 'klyp_add_log_table_db');

function klyp_insert_user_log($user)
{
    global $wpdb;
    $tablename = $wpdb->prefix . 'logs';
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $data = array(
        'user_id'   => $user->ID,
        'url'       => $url,
        'action'    => $_SERVER['REQUEST_METHOD'],
        'data'      => json_encode(array()),
        'ip'        => klyp_get_the_user_ip()
    );
    $wpdb->insert($tablename, $data);
}

function klyp_log_login($user_login, $user)
{
    klyp_insert_user_log($user);
}
add_action('wp_login', 'klyp_log_login', 10, 2);
