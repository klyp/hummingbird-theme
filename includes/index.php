<?php

/**
 * Add global component functions.
 */
require get_theme_file_path('includes/global-components.php');

/**
 * Adds ACF.
 */

require get_template_directory() . '/includes/acf.php';

/**
 * Adds general functions
 */
require get_template_directory() . '/includes/functions.php';

/**
 * Adds page functions.
 */
require get_template_directory() . '/includes/page.php';

/**
 * Adds import export page functions.
 */
require get_template_directory() . '/includes/import-export.php';

/**
 * Adds settings functions
 */
require get_template_directory() . '/includes/settings.php';

/**
 * Adds site settings
 */
require get_template_directory() . '/includes/site-settings.php';

/**
 * Adds template functions
 */
require get_template_directory() . '/includes/template.php';

/**
 * Adds image optimize functions
 */
require get_template_directory() . '/includes/image-optimize.php';

/**
 * Page Speed Optimization.
 */
if (! is_user_logged_in()) {
    require get_theme_file_path('includes/page-speed.php');
}

/**
 * Adds Custom post type: Global Components.
 */
require get_theme_file_path('includes/post-types/global-components.php');

/**
 * Adds extra global components post type acf field for site.
 */
require get_theme_file_path('includes/global-components-settings-acf.php');

/**
 * If admin, then add all these.
 */
if (is_admin()) {
    require get_theme_file_path('includes/admin.php');
}

/**
 * Logging.
 */
require get_theme_file_path('includes/log/index.php');
