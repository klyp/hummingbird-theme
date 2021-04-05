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
            array(&$this, 'klypActivityLogPageFunc'),
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
    
    public function klypActivityLogPageFunc()
    {
        $this->getListTable()->prepareItems();
        ?>
        <div class="wrap">
            <h1 class="hb-title"><?php _ex('Humingbird Activity Log', 'Page and Menu Title', 'hummingbird'); ?></h1>

            <form id="activity-filter" method="get">
                <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
                <?php $this->getListTable()->display(); ?>
            </form>
        </div>
        <?php
    }
}
