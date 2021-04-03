<?php

defined('ABSPATH') or die();

/**
 * Main class for HummingbirdLogUI
 */
class HummingbirdLogUI
{
    /**
     * @var HummingbirdLogTable
     */
    protected $listTable = null;
    protected $screens = array();

    function __construct()
    {
        add_action('admin_menu', array(&$this, 'klypLogCreateAdminMenu'), 20);
    }


    function klypLogCreateAdminMenu()
    {
        $this->screens['main'] = add_menu_page(
            _x('Hummingbird Log', 'Page Title', 'hummingbird'),
            _x('Hummingbird Log', 'Menu Title', 'hummingbird'),
            'edit_themes',
            'hummingbird_log_page',
            array(&$this, 'activity_log_page_func'),
            '',
            '4.1'
        );
        // Just make sure we are create instance.
        add_action('load-' . $this->screens['main'], array(&$this, 'getListTable'));
    }

    /**
     * @return HummingbirdLogTable
     */
    public function getListTable()
    {
        if (is_null($this->listTable)) {
            $this->listTable = new HummingbirdLogTable(array('screen' => $this->screens['main']));
            // do_action('aal_admin_page_load', $this->listTable);
        }
        
        return $this->listTable;
    }
}
