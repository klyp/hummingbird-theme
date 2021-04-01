<?php
/**
 * Klyp functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hummingbird
 */

if (! function_exists('klyp_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function klyp_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Klyp, use a find and replace
         * to change 'klyp' to the name of your theme in all the template files.
         */
        load_theme_textdomain('klyp', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'menu-primary'  => esc_html__('Primary Menu', 'klyp'),
                'menu-footer'   => esc_html__('Footer Menu', 'klyp')
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');
    }
}
add_action('after_setup_theme', 'klyp_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function klyp_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'klyp'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here to appear on blog archive page.', 'klyp'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'klyp_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function klyp_scripts()
{
    // remove gutenberg styles.
    wp_dequeue_style('wp-block-library');
    // deregister wp embed.
    wp_deregister_script('wp-embed');
    // remove emoji styles.
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('wp_enqueue_scripts', 'klyp_scripts');

/**
 * Enqueue scripts and styles on footer.
 *
 * @return void
 */
function klyp_footer_scripts()
{
    // enqueue googlemaps script
    if ($api_google_map = get_field('settings_api_google_map', 'option')) {
        wp_register_script(
            'googlemaps',
            '//maps.googleapis.com/maps/api/js?key=' . $api_google_map . '&libraries=places',
            array(),
            '',
            true
        );
        wp_enqueue_script('googlemaps');
    }
    // scripts that aren't essentials can be loaded on the footer
    wp_enqueue_script(
        'klyp-script',
        get_stylesheet_directory_uri() . '/assets/dist/js/main.min.js',
        array('jquery'),
        '1.0.0',
        true
    );
    // to localise the script in child theme
    do_action('klyp_localize_script');
}
add_action('get_footer', 'klyp_footer_scripts');

/**
 * Disable Gutenberg
 */
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);

/**
 * Modify mimes.
 *
 * @param array $mimes types of files.
 * @return void
 */
function klyp_cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg';

    // we don't want executables
    unset($mimes['exe']);
    return $mimes;
}
add_filter('upload_mimes', 'klyp_cc_mime_types');

/**
 * Remove comment support
 */
function klyp_remove_comment_support()
{
    remove_post_type_support('page', 'comments');
    remove_post_type_support('post', 'comments');
}
add_action('init', 'klyp_remove_comment_support', 100);

/**
 * Change default wordpress email address
 *
 * @param  mixed $email sender email address
 * @return void
 */
function klyp_wpb_sender_email($email)
{
    return get_bloginfo('admin_email');
}
add_filter('wp_mail_from', 'klyp_wpb_sender_email');

/**
 * Change default wordpress sender name
 *
 * @param  mixed $emailFrom from email name.
 * @return void
 */
function klyp_wpb_sender_name($emailFrom)
{
    return get_bloginfo('name');
}
add_filter('wp_mail_from_name', 'klyp_wpb_sender_name');

/**
 * Change default wordpress excerpt length.
 *
 * @param  mixed $length excerpt length.
 * @return void
 */
function klyp_excerpt_length($length = 50)
{
    return $length;
}
add_filter('excerpt_length', 'klyp_excerpt_length', 999);

/**
 * Custom Functions
 */
require get_template_directory() . '/includes/index.php';

/**
 * Custom Logging Functions
 */
require get_template_directory() . '/includes/logging.php';
