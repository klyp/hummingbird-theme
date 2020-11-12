<?php
/**
 * Defer or Asynchronously load scripts
 * @return array
 */

function js_async_attr($tag)
{
    # Do not add defer or async attribute to these scripts
    $scripts_to_exclude = array('jquery.js', 'datepicker.min.js', 'scripts.js');

    foreach ($scripts_to_exclude as $exclude_script) {
        if (true == strpos($tag, $exclude_script)) {
            return $tag;
        }
    }

    /*Defer or async all remaining scripts not excluded above*/
    return str_replace(' src', ' defer="defer" src', $tag);
}
add_filter('script_loader_tag', 'js_async_attr', 10);
