<?php

if (! defined('ABSPATH')) exit;

if (! class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class HummingbirdLogTable extends WP_List_Table
{
    public function __construct($args = array())
    {
        parent::__construct(
            array(
                'singular'  => 'activity',
                'screen' => isset($args['screen']) ? $args['screen'] : null,
            )
        );

        add_screen_option(
            'per_page',
            array(
                'default' => 20,
                'label'   => __('User Activities', 'hummingbird'),
                'option'  => 'edit_hummingbird_logs_per_page',
            )
        );

        add_filter('set-screen-option', array(&$this, 'setScreenOption'), 10, 3);
        set_screen_options();
    }

    function setScreenOption($status, $option, $value)
    {
        if ($option === 'edit_hummingbird_logs_per_page') {
            return $value;
        }
        return $status;
    }
}
