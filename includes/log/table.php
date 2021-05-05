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
            'user_id'   => array('display_name', true),
            'ip'        => array('ip', true),
            'type'      => array('type', true),
            'date'      => array('date', true),
        );
    }

    public function column_default($item, $column_name)
    {
        $time_stamp = date(get_option('date_format'), strtotime($item->date)) . ' - ' . date(get_option('time_format'), strtotime($item->date));
        $return = '';
        switch ($column_name) {
            case 'action':
                $return = $this->getActionLabel($item->action);
                break;
            case 'type':
                $return = $this->getActionLabel($item->type);
                break;
            case 'date':
                $return =  $time_stamp;
                break;
            case 'ip':
                $return = $item->ip;
                break;
            case 'data':
                $jsonData = json_decode($item->data, true);
                $return = '';
                if (! empty($jsonData)) {
                    $return .= '
                        <label class="button button-primary" for="hb-log-' . $item->id . '">' . __('Show', 'hummingbird') . '</label>
                        <input class="klyp-modal__state" id="hb-log-' . $item->id . '" type="checkbox">
                        <div class="klyp-modal">
                            <label class="klyp-modal__bg" for="hb-log-' . $item->id . '"></label>
                            <div class="klyp-modal__inner">
                                <label class="klyp-modal__close" for="hb-log-' . $item->id . '"></label>
                                <h2>
                                    ' . get_user_by('id', $item->user_id)->display_name . ' 
                                    ' . $item->action . ' a 
                                    ' . $item->type . ' @ 
                                    ' . $time_stamp . '                                    
                                </h2>
                                <textarea class="klyp-modal__content" disabled="disabled" readonly="readonly">' . $item->data . '</textarea>
                            </div>
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

    public function searchBox($text, $search_input_id)
    {
        $searchData = isset($_REQUEST['search_ip']) ? sanitize_text_field($_REQUEST['search_ip']) : '';

        $search_input_id = $search_input_id . '-search-input'; ?>
        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo $search_input_id ?>"><?php echo $text; ?>:</label>
            <input type="search" id="<?php echo $search_input_id ?>" name="search_ip" value="<?php echo esc_attr($searchData); ?>" />
            <?php submit_button($text, 'button', false, false, array('id' => 'search-submit')); ?>
        </p>
        <?php
    }

    public function extraTablenav($which)
    {
        global $wpdb;

        if ($which !== 'top') {
            return;
        }
        echo '<div class="alignleft actions">';

        $users = $wpdb->get_results(
            'SELECT DISTINCT `user_id` FROM `' . $wpdb->hummingbird_log . '`
                WHERE 1 = 1
                GROUP BY `user_id`
                ORDER BY `user_id`
            ;'
        );

        if ($users) {
            if (! isset($_REQUEST['userfilter'])) {
                $_REQUEST['userfilter'] = '';
            }

            $output = array();
            foreach ($users as $user) {
                if (0 === (int) $user->user_id) {
                    $output[0] = __('N/A', 'hummingbird');
                    continue;
                }

                $userData = get_user_by('id', $user->user_id);
                if ($userData) {
                    $output[ $userData->ID ] = $userData->display_name;
                }
            }

            if (! empty($output)) {
                echo '<select name="userfilter" id="hs-filter-userfilter">';
                printf('<option value="">%s</option>', __('All Users', 'hummingbird'));
                foreach ($output as $key => $value) {
                    printf('<option value="%s"%s>%s</option>', $key, selected($_REQUEST['userfilter'], $key, false), $value);
                }
                echo '</select>';
            }
        }

        $types = $wpdb->get_results(
            'SELECT DISTINCT `type` FROM `' . $wpdb->hummingbird_log . '`
                WHERE 1 = 1
                GROUP BY `type`
                ORDER BY `type`
            ;'
        );

        if ($types) {
            if (! isset($_REQUEST['typefilter'])) {
                $_REQUEST['typefilter'] = '';
            }
            $output = array();
            foreach ($types as $type) {
                $output[] = sprintf('<option value="%s"%s>%s</option>', $type->type, selected($_REQUEST['typefilter'], $type->type, false), $this->getActionLabel(__($type->type, 'hummingbird')));
            }
            echo '<select name="typefilter" id="hs-filter-typefilter">';
            printf('<option value="">%s</option>', __('All Types', 'hummingbird'));
            echo implode('', $output);
            echo '</select>';
        }

        $actions = $wpdb->get_results(
            'SELECT DISTINCT `action` FROM `' . $wpdb->hummingbird_log . '`
                WHERE 1 = 1
                GROUP BY `action`
                ORDER BY `action`
            ;'
        );

        if ($actions) {
            if (! isset($_REQUEST['actionfilter'])) {
                $_REQUEST['actionfilter'] = '';
            }
            $output = array();
            foreach ($actions as $action) {
                $output[] = sprintf('<option value="%s"%s>%s</option>', $action->action, selected($_REQUEST['actionfilter'], $action->action, false), $this->getActionLabel(__($action->action, 'hummingbird')));
            }
            echo '<select name="actionfilter" id="hs-filter-actionfilter">';
            printf('<option value="">%s</option>', __('All Actions', 'hummingbird'));
            echo implode('', $output);
            echo '</select>';
            submit_button(__('Filter', 'hummingbird'), 'button', 'hb-filter', false, array('id' => 'activity-query-submit'));
        }

        echo '</div>';
    }

    public function display_tablenav($which)
    {
        if ('top' == $which) {
            $this->searchBox(__('Search IP', 'hummingbird'), 'hb-log');
        }
        ?>
        <div class="tablenav <?php echo esc_attr($which); ?>">
            <?php
            $this->extraTablenav($which);
            $this->pagination($which);
            ?>
            <br class="clear" />
        </div>
        <?php
    }

    public function prepareItems()
    {
        global $wpdb;

        $itemsPerPage           = $this->get_items_per_page('edit_hummingbird_logs_per_page', 20);
        $this->_column_headers  = array($this->get_columns(), get_hidden_columns($this->screen), $this->getSortableColumns(), 'user_id');
        $where                  = ' WHERE 1 = 1';

        if (isset($_REQUEST['search_ip'])) {
            // Search only searches 'ip' fields.
            $where .= $wpdb->prepare(' AND `ip` LIKE %s', '%' . $wpdb->esc_like($_REQUEST['search_ip']) . '%');
        }

        if (! empty($_REQUEST['typefilter'])) {
            $where .= $wpdb->prepare(' AND `type` = %s', $_REQUEST['typefilter']);
        }

        if (! empty($_REQUEST['actionfilter'])) {
            $where .= $wpdb->prepare(' AND `action` = %s', $_REQUEST['actionfilter']);
        }

        if (! empty($_REQUEST['userfilter'])) {
            $where .= $wpdb->prepare(' AND `user_id` = %s', $_REQUEST['userfilter']);
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
            $itemsOrderby = 'date';
        }

        $itemsOrder = strtoupper($_REQUEST['order']);
        if (empty($itemsOrder) || ! in_array($itemsOrder, array('DESC', 'ASC'))) {
            $itemsOrder = 'DESC';
        }

        $this->items = $wpdb->get_results(
            $wpdb->prepare(
                'SELECT hb_log.* FROM `' . $wpdb->hummingbird_log . '` as hb_log
                    JOIN `' . $wpdb->prefix . 'users' . '` as users ON users.ID = hb_log.user_id ' .
                    $where . ' ORDER BY ' . $itemsOrderby . ' ' . $itemsOrder . ' LIMIT %d, %d;',
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
