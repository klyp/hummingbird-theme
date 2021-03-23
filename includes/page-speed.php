<?php
/**
 * Defer or Asynchronously load scripts
 * @return array
 */
function js_async_attr($tag)
{
    // get the list from settings
    $scripts_to_exclude = get_field('js_scripts_to_defer', 'option');

    if (! $scripts_to_exclude) {
        # Do not add defer or async attribute to these scripts
        $scripts_to_exclude = array ('jquery.min.js', 'wp-includes/js');
    } else {
        $scripts_to_exclude = wp_list_pluck($scripts_to_exclude, 'file_name');
        array_push($scripts_to_exclude, 'wp-includes/js');
    }

    foreach ($scripts_to_exclude as $exclude_script) {
        if (true == strpos($tag, $exclude_script)) {
            return $tag;
        }
    }

    /*Defer or async all remaining scripts not excluded above*/
    return str_replace(' src', ' defer="defer" src', $tag);
}
add_filter('script_loader_tag', 'js_async_attr', 10);
