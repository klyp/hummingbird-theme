<?php
/**
 * Defer or Asynchronously load scripts
 * @return array
 */
function js_async_attr($tag)
{
    // get the list from settings
    $scripts_to_exclude = get_field('settings_advance', 'option')['js_scripts_to_defer'];

    if (! $scripts_to_exclude) {
        # Do not add defer or async attribute to these scripts
        $scripts_to_exclude = array ('jquery.min.js', 'wp-includes/js');
    } else {
        $scripts_to_exclude = wp_list_pluck($scripts_to_exclude, 'file_name');
        array_push($scripts_to_exclude, 'wp-includes/js');
    }

    foreach ($scripts_to_exclude as $exclude_script) {
        if (! empty($exclude_script) && strpos($tag, $exclude_script) == true) {
            return $tag;
        }
    }

    /*Defer or async all remaining scripts not excluded above*/
    return str_replace(' src', ' defer="defer" src', $tag);
}
add_filter('script_loader_tag', 'js_async_attr', 10);
