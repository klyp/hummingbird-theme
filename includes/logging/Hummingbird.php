<?php

namespace Hummingbird;

defined('ABSPATH') or die();

/**
 * Main class for Hummingbird
 */
class Hummingbird
{
    const DBTABLE = 'simple_history';
    public function log($data = array())
    {
        global $wpdb;
        $tablename = $wpdb->prefix . 'logs';
        $wpdb->insert($tablename, $data);
    }
}
