<?php

/**
 * Admin activiy log
 * @return void
 */
function klyp_register_admin_activity_log()
{
    global $wpdb;
    $wpdb->admin_activity_log = "{$wpdb->prefix}admin_activity_log";
}
add_action('init', 'klyp_register_admin_activity_log', 1);
add_action('switch_blog', 'klyp_register_admin_activity_log');

/**
 * Create the table
 * @return void
*/
function klyp_create_admin_activity_log()
{

    global $wpdb;
    global $charset_collate;

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    klyp_register_admin_activity_log();

    $createTable = "CREATE TABLE {$wpdb->admin_activity_log} (
        log_id bigint(20) unsigned NOT NULL auto_increment,
        user_id bigint(20) unsigned NOT NULL default '0',
        activity varchar(30) NOT NULL default 'updated',
        object_id bigint(20) unsigned NOT NULL default '0',
        object_type varchar(20) NOT NULL default 'post',
        activity_date datetime NOT NULL default '0000-00-00 00:00:00',
        PRIMARY KEY  (log_id),
        KEY abc (user_id)
        ) $charset_collate; ";

    dbDelta($createTable);
}
add_action('admin_init', 'klyp_create_admin_activity_log');

/**
 * Returns log table columns
 * @return array
 */
function klyp_get_log_table_columns()
{
    return array(
        'log_id'        => '%d',
        'user_id'       => '%d',
        'activity'      => '%s',
        'object_id'     => '%d',
        'object_type'   => '%s',
        'activity_date' => '%s',
    );
}

/**
 * Insert log
 * @param array
 * @return int
*/
function klyp_insert_log($data = array())
{
    global $wpdb;

    // set data
    $data = wp_parse_args($data, array('user_id'=> get_current_user_id(), 'date'=> current_time('timestamp')));

    // check date
    // if (! is_float($data['date']) || $data['date'] <= 0) {
    //     return 0;
    // }

    // convert date
    $data['activity_date'] = date_i18n('Y-m-d H:i:s', $data['date'], true);

    // get columns
    $columnFormats = klyp_get_log_table_columns();

    // change to lower case
    $data = array_change_key_case($data);

    // remove unwanted columns
    $data = array_intersect_key($data, $columnFormats);

    // reorder
    $dataKeys = array_keys($data);
    $columnFormats = array_merge(array_flip($dataKeys), $columnFormats);
    $wpdb->insert($wpdb->admin_activity_log, $data, $columnFormats);

    return $wpdb->insert_id;
}

/**
 * Update log
 * @param int
 * @param array
 * @return bool
*/
function wptuts_update_log($log_id, $data = array())
{
    global $wpdb;

    $log_id = absint($log_id);

    if (empty($log_id)) {
        return false;
    }

    // convert date
    if (isset($data['activity_date'])) {
        $data['activity_date'] = date_i18n('Y-m-d H:i:s', $data['date'], true);
    }

    // get columns
    $column_formats = klyp_get_log_table_columns();

    // change to lower case
    $data = array_change_key_case($data);

    // remove unwanted columns
    $data = array_intersect_key($data, $column_formats);

    // reorder
    $data_keys = array_keys($data);
    $column_formats = array_merge(array_flip($data_keys), $column_formats);

    if ($wpdb->update($wpdb->admin_activity_log, $data, array('log_id' => $log_id), $column_formats) === false) {
        return false;
    }

    return true;
}

/**
 * Get log
 * @param array
 * @return array
 */
function klyp_get_logs($query = array())
{
    global $wpdb;

    // parse default
    $defaults = array(
        'fields'    => array(),
        'orderby'   => 'datetime',
        'order'     => 'desc',
        'user_id'   => false,
        'since'     => false,
        'until'     => false,
        'number'    => 10,
        'offset'    => 0
    );

    $query = wp_parse_args($query, $defaults);

    $cache_key = 'Log:' . md5(serialize($query));
    $cache = wp_cache_get($cache_key);

    if ($cache !== false) {
        $cache = apply_filters('klyp_get_logs', $cache, $query);
        return $cache;
    }

    extract($query);

    // get columns
    $allowed_fields = klyp_get_log_table_columns();

    if (is_array($fields)) {

        // to lower case
        $fields = array_map('strtolower', $fields);
        $fields = array_intersect($fields, $allowed_fields);
    } else {
        $fields = strtolower($fields);
    }

    if (empty($fields)) {
        $select_sql = "SELECT* FROM {$wpdb->admin_activity_log}";
    } elseif ('count' == $fields) {
        $select_sql = "SELECT COUNT(*) FROM {$wpdb->admin_activity_log}";
    } else {
        $select_sql = "SELECT " . implode(',', $fields) . " FROM {$wpdb->admin_activity_log}";
    }

    // we might need this
    $join_sql = '';

    // where
    $where_sql = 'WHERE 1=1';

    if (! empty($log_id))
        $where_sql .=  $wpdb->prepare(' AND log_id = %d', $log_id);

    if (! empty($user_id)) {
        if (! is_array($user_id)) {
            $user_id = array($user_id);
        }

        $user_id = array_map('absint', $user_id);
        $user_id__in = implode(',', $user_id);
        $where_sql .=  " AND user_id IN ($user_id__in)";
    }

    $since = absint($since);
    $until = absint($until);

    if (! empty($since)) {
        $where_sql .=  $wpdb->prepare(' AND activity_date >= %s', date_i18n('Y-m-d H:i:s', $since, true));
    }

    if (! empty($until)) {
        $where_sql .=  $wpdb->prepare(' AND activity_date <= %s', date_i18n('Y-m-d H:i:s', $until, true));
    }

    $order = strtoupper($order);
    $order = ('ASC' == $order ? 'ASC' : 'DESC');
    switch ($orderby) {
        case 'log_id':
            $order_sql = "ORDER BY log_id $order";
            break;
        case 'user_id':
            $order_sql = "ORDER BY user_id $order";
            break;
        case 'datetime':
            $order_sql = "ORDER BY activity_date $order";
        default:
            break;
    }

    $offset = absint($offset); //Positive integer
    if ($number == -1) {
        $limit_sql = "";
    } else {
        $number = absint($number); //Positive integer
        $limit_sql = "LIMIT $offset, $number";
    }

    $pieces = array('select_sql', 'join_sql', 'where_sql', 'order_sql', 'limit_sql');
    $clauses = apply_filters('wptuts_logs_clauses', compact($pieces), $query);

    foreach ($pieces as $piece) {
        $$piece = isset($clauses[$piece]) ? $clauses[$piece] : '';
    }

    $sql = "$select_sql $where_sql $order_sql $limit_sql";

    if ('count' == $fields) {
        return $wpdb->get_var($sql);
    }

    $logs = $wpdb->get_results($sql);

    wp_cache_add($cache_key, $logs, 24 * 60 * 60);
    $logs = apply_filters('klyp_get_logs', $logs, $query);

    return $logs;


}