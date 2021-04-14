<?php

if (! defined('ABSPATH')) exit; // Exit if accessed directly

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
                'label'   => __('Number of logs per page:', 'hummingbird'),
                'option'  => 'edit_hummingbird_logs_per_page',
            )
        );

        add_filter('set-screen-option', array(&$this, 'set_screen_option'), 10, 3);
        set_screen_options();
    }

    function set_screen_option($status, $option, $value)
    {
        if ($option === 'edit_hummingbird_logs_per_page') {
            return $value;
        }
        return $status;
    }

    public function get_columns()
    {
        $columns = array(
            'user_id'       => __('User', 'hummingbird'),
            'url'           => __('URL', 'hummingbird'),
            'action'        => __('Action', 'hummingbird'),
            'type'          => __('Type', 'hummingbird'),
            'ip'            => __('IP Address', 'hummingbird'),
            'data'          => __('Data', 'hummingbird'),
            'date'          => __('Date', 'hummingbird'),
        );

        return $columns;
    }

    public function getActionLabel($action)
    {
        return ucwords(str_replace('_', ' ', __($action, 'hummingbird')));
    }

    public function getSortableColumns()
    {
        return array(
            'user_id'   => 'user_id',
            'ip'        => 'ip',
            'type'      => 'type',
            'date'      => array('date', true),
        );
    }

    public function column_default($item, $column_name)
    {
        $return = '';
        switch ($column_name) {
            case 'action':
                $return = $this->getActionLabel($item->action);
                break;
            case 'type':
                $return = $this->getActionLabel($item->type);
                break;
            case 'date':
                $return =  date(get_option('date_format'), strtotime($item->date)) . ' - ' . date(get_option('time_format'), strtotime($item->date));
                break;
            case 'ip':
                $return = $item->ip;
                break;
            case 'data':
                $jsonData = json_decode($item->data, true);
                $return = '';
                if (! empty($jsonData)) {
                    $return .= '<a href="javascript:void(0);" class="hb-log__data">Show</a>
                                <div class="klyp-modal">
                                    <div class="klyp-modal__content--log">' . $item->data . '</div>
                                </div>';
                }
                break;
            default:
                if (isset($item->$column_name)) {
                    $return = $item->$column_name;
                }
                break;
        }
        return $return;
    }

    public function prepareItems()
    {
        global $wpdb;

        $itemsPerPage           = $this->get_items_per_page('edit_hummingbird_logs_per_page', 20);
        $this->_column_headers  = array($this->get_columns(), get_hidden_columns($this->screen), $this->getSortableColumns(), 'user_id');
        $where                  = ' WHERE 1 = 1';

        if (isset($_REQUEST['s'])) {
            // Search only searches 'description' fields.
            $where .= $wpdb->prepare(' AND `object_name` LIKE %s', '%' . $wpdb->esc_like($_REQUEST['s']) . '%');
        }

        if (! isset($_REQUEST['order']) || ! in_array($_REQUEST['order'], array('desc', 'asc'))) {
            $_REQUEST['order'] = 'DESC';
        }
        if (! isset($_REQUEST['orderby']) || ! in_array($_REQUEST['orderby'], array('user_id', 'ip', 'type', 'date'))) {
            $_REQUEST['orderby'] = 'date';
        }

        $offset = ($this->get_pagenum() - 1) * $itemsPerPage;
        $totalItems = $wpdb->get_var(
            'SELECT COUNT(`id`) FROM  `' . $wpdb->hummingbird_log . '`
                ' . $where
        );

        $itemsOrderby = filter_input(INPUT_GET, 'orderby', FILTER_SANITIZE_STRING);
        if (empty($itemsOrderby)) {
            $itemsOrderby = 'date DESC';
        }

        $this->items = $wpdb->get_results(
            $wpdb->prepare(
                'SELECT * FROM `' . $wpdb->hummingbird_log . '`
                    ' . $where . ' ORDER BY ' . $itemsOrderby . ' LIMIT %d, %d;',
                $offset,
                $itemsPerPage
            )
        );

        $this->set_pagination_args(
            array(
                'total_items' => $totalItems,
                'per_page' => $itemsPerPage,
                'total_pages' => ceil($totalItems / $itemsPerPage),
            )
        );
    }

    public function column_user_id($item)
    {
        global $wp_roles;

        if (! empty($item->user_id) && (int) $item->user_id !== 0) {
            $user = get_user_by('id', $item->user_id);
            return sprintf(
                '<a href="%s">%s <br>
                    <span class="aal-author-name">%s</span>
                </a><br>
                <small>%s</small>',
                get_edit_user_link($user->ID),
                get_avatar($user->ID, 40),
                $user->display_name,
                isset($user->roles[0]) && isset($wp_roles->role_names[$user->roles[0]]) ? $wp_roles->role_names[$user->roles[0]] : __('Unknown', 'hummingbird')
            );
        }
        return sprintf(
            '<span class="hb-author-name">%s</span>',
            __('N/A', 'hummingbird')
        );
    }

    public function column_url($item)
    {
        $return = sprintf('<a href="%s">%s</a>', $item->url, $item->url);
        return $return;
    }
    
}
