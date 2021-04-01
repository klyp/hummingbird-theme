<?php

/**
 * Get user IP
 * @return string
 */
function klyp_get_the_user_ip()
{
    if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return apply_filters('wpb_get_ip', $ip);
}

/**
 * Generate random string
 * @param int
 * @return string
 */
function klyp_generate_random_string($length = 10)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    return $random_string;
}

/**
 * Get nav menu items by location
 * @param string
 * @param array
 * @return string
 */
function klyp_get_nav_menu_items_by_location($location, $args = [])
{
    // Get all locations
    $locations = get_nav_menu_locations();
 
    // Get object id by location
    if (isset($locations[$location])) {
        $object = wp_get_nav_menu_object($locations[$location]);
 
        // Get menu items by menu name
        $menuItems = wp_get_nav_menu_items($object->name, $args);
 
        // Return menu post objects
        return $menuItems;
    }
}

/**
 * Generate menu by location
 * @param string
 * @return array
 */
function klyp_generate_nav_menu($location)
{
    if (! $location) {
        return;
    }

    $menu = klyp_get_nav_menu_items_by_location($location);
    $newMenu = [];

    if ($menu) {
        foreach ($menu as $item) {
            // add parent menu first
            if ($item->menu_item_parent == '0') {
                $newMenu[$item->ID] = array(
                    'id'    => $item->ID,
                    'title' => $item->title,
                    'url'   => $item->url,
                    'class' => $item->classes
                );
            } else {
                $newMenu[$item->menu_item_parent]['children'][$item->ID] = array(
                    'id'    => $item->ID,
                    'title' => $item->title,
                    'url'   => $item->url,
                    'class' => $item->classes
                );
            }
        }
    }

    return $newMenu;
}
