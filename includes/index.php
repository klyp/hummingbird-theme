<?php

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
 * If admin, then add all these.
 */
if (is_admin()) {
    require get_theme_file_path('includes/admin.php');
}

/**
 * Logging.
 */
require get_theme_file_path('includes/log/index.php');
