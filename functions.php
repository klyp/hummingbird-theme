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
 * Custom Functions
 */
require get_template_directory() . '/includes/index.php';

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
 * Page Speed Optimization.
 */
if (! is_user_logged_in()) {
    require get_theme_file_path('includes/page-speed.php');
}


/*=====================================================================
                        Image Optimiser and Resizing
======================================================================*/

/**
 * Add a cron schedule.
 *
 * @since    1.0.0
 */
function klyp_cron_schedule()
{
    if (! wp_next_scheduled('klyp_cc_cron_schedule')) {
        wp_schedule_event(time(), 'klyp_cc_ten_minutes', 'klyp_cc_cron_schedule');
    }
}
add_action('init', 'klyp_cron_schedule');

/**
 * Register the API key.
 *
 * @since    1.0.0
 */

function klyp_configure_tinypng_api() {
    $api_tiny_png = get_field('settings_tiny_png', 'option');
    if(! empty( $api_tiny_png ) ) {
        \Tinify\setKey($api_tiny_png);
    }
}

add_action('plugins_loaded', 'klyp_configure_tinypng_api');

/**
 * Add custom cron recurrence time interval.
 *
 * @since    1.0.0
 * @param       array $schedules       Array of cron Schedule times for recurrence.
 */
function klyp_set_cron_schedule_time($schedules)
{

    if (! isset($schedules['klyp_cc_ten_minutes'])) {

        $schedules['klyp_cc_ten_minutes'] = array(
            'interval' => 10 * 60,
            'display' => __('Once every 10 minutes', 'woocommerce-one-click-upsell-funnel-pro'),
        );
    }

    return $schedules;
}
// Set cron recurrence time for 'klyp_cc_ten_minutes' schedule.
add_action('cron_schedules', 'klyp_set_cron_schedule_time');


// Define Cron schedule fire Event for Image processing in background.
add_action('klyp_cc_cron_schedule', 'klyp_existing_image_processing_cron_fire_event');
add_action('add_attachment', 'klyp_after_upload_image_processing_event');
add_action('edit_attachment', 'klyp_after_upload_image_processing_event');

/**
 * Add callback to cron scheduled for image compression and rename.
 *
 * @since    1.0.0
 */
function klyp_existing_image_processing_cron_fire_event(){
    $ids = get_posts(
        array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        )
    );

    $images = array();
    foreach ($ids as $id) {

        $webp_exists = get_post_meta($id, '_is_webp_generated', true);
        if (!empty($webp_exists)) {
            continue;
        }

        $image = get_post($id);
        $image_type = str_replace('image/', '', $image->post_mime_type);
        $image_title = $image->post_title;
        $image_url = $image->guid;

        $images[] = array(
            'id' => $id,
            'image_type' => $image_type,
            'image_title' => $image_title,
            'image_url' => $image_url,
        );
    }

    // Process 10 images at once.
    $images = array_chunk($images, 10);
    if (! empty($images) && is_array($images)) {

        process_single_image_bactch($images[0]);
    }
}

/**
 * Creates webp version of image.
 *
 * @since    1.0.0
 * @param    array      $batch      current batch for processing webp
 */
function process_single_image_bactch($batch)
{

    if (! empty($batch)) {

        foreach ($batch  as $key => $image_data) {

            if( empty($image_data) ) {
                continue;
            }

            $file_path = wp_get_original_image_path($image_data['id']);
            $file_url = $image_data['image_url'];
            $image_type = $image_data['image_type'];

            $formats = array('jpg', 'jpeg', 'png');
            $webp_file = str_replace($formats, 'webp', $file_path);
            $webp_url = str_replace($formats, 'webp', $file_url);

            $result = array(
                'file_path' => $file_path,
                'file_url' => $file_url,
                'webp_file' => $webp_file,
                'webp_url' => $webp_url,
                'before_optimisation' => ! empty($file_path) ? getimagesize($file_path) : '',
                'before_optimisation_filesize' => ! empty($file_path) ? filesize($file_path) : '',
            );

            // Creating a compressed image file.
            try {
                $source = \Tinify\fromUrl($file_url);
                $source->toFile($file_path);

                $result['after_optimisation'] = getimagesize($file_path);
                $result['after_optimisation_filesize'] = filesize($file_path);

                klyp_cc_create_activity_log($image_data['id'], 'Attempt Compressing image', $image_data['image_title'], $result);
            } catch (Exception $e) {
                wp_die('Error Creating Compressed Image image : ' . $e->getMessage());
            }

            // Creating a webp file.
            try {
                klyp_cc_create_activity_log($image_data['id'], 'Attempt Creating Webp image', $image_data['image_title'], $result);

                switch ($image_type) {
                    case 'jpeg':
                    case 'jpg':
                        $image = imagecreatefromjpeg($file_path);
                        ob_start();
                        imagejpeg($image, NULL, 100);
                        $cont = ob_get_contents();
                        ob_end_clean();
                        break;

                    case 'png':
                        $image = imagecreatefrompng($file_path);
                        ob_start();
                        imagepng($image, NULL, 100);
                        $cont = ob_get_contents();
                        ob_end_clean();
                        break;

                    default:
                        return;
                        break;
                }

                imagedestroy($image);
                $content = imagecreatefromstring($cont);
                imagewebp($content, $webp_file);
                imagedestroy($content);

                // Add a flag
                update_post_meta($image_data['id'], '_is_webp_generated', 'true');
                update_post_meta($image_data['id'], '_webp_generated_url', $webp_url);
            } catch (Exception $e) {
                wp_die('Error Creating Webp image : ' . $e->getMessage());
            }
        }
    }
}

/**
 * Logs to image compression job log file.
 *
 * @since    1.0.0
 * @param    string $image_id       Image id assigned by WP
 * @param    string $step           
 * @param    string $message        
 * @param    string $final_response Response if successfully       
 */
function klyp_cc_create_activity_log($image_id = 00, $step = '', $message = '', $final_response = '')
{

    if (! defined('WC_LOG_DIR')) {
        return;
    }

    $log_dir        = WC_LOG_DIR;

    // As sometimes when dir is not present, and fopen cannot create directories.
    if (! is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }

    if (! is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }

    $log_dir_file = $log_dir . 'image-optimiser-activity-logger' . date('j-F-Y') . '.log';

    if (! file_exists($log_dir_file) || !is_writable($log_dir_file)) {

        @fopen($log_dir_file, 'a');
    }

    if (file_exists($log_dir_file) && is_writable($log_dir_file)) {

        $log  = 'Website: ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL .
            'Time: ' . current_time('F j, Y  g:i a') . PHP_EOL .
            'Image ID : ' . $image_id . PHP_EOL .
            'Step: ' . $step . PHP_EOL .
            'Image title: ' . $message . PHP_EOL .
            'Response: ' . print_r($final_response, true) . PHP_EOL .
            '----------------------------------------------------------------------------' . PHP_EOL;

        file_put_contents($log_dir_file, $log, FILE_APPEND);
    }
}


/**
 * Logs to image compression job log file.
 *
 * @since    1.0.0
 * @param    string $image_id       Image id assigned by WP
 * @param    string $step           
 * @param    string $message        
 * @param    string $final_response Response if successfully       
 */
function klyp_after_upload_image_processing_event($attachment_ID)
{
    $image = get_post($attachment_ID);
    $image_type = str_replace('image/', '', $image->post_mime_type);
    $image_title = $image->post_title;
    $image_url = $image->guid;

    $images[] = array(
        'id' => $attachment_ID,
        'image_type' => $image_type,
        'image_title' => $image_title,
        'image_url' => $image_url,
    );

    process_single_image_bactch($images);
}

function klyp_include_tinypng_lib() {

    /**
     * The includes library responsible for defining all actions that occur in the tinypng api
     */
    $lib_path = get_theme_file_path('vendor/autoload.php');
    $api_tiny_png = get_field('settings_tiny_png', 'option');

    if(! empty( $api_tiny_png ) && file_exists( $lib_path ) ) {
        require_once $lib_path;
        \Tinify\setKey($api_tiny_png);
    }
}
add_action('init', 'klyp_include_tinypng_lib');

/**
 * Prepare a resized image.
 *
 * @since    1.0.0
 * @param    string $image_url       Image url assigned by WP
 * @param    string $width           Width
 * @param    string $height          Height     
 */
function prepare_resized_image($image_url, $width = 100, $height = 100)
{

    $attachment_ID = get_attachment_id($image_url);
    $image = get_post($attachment_ID);

    $image_type = str_replace('image/', '', $image->post_mime_type);

    $image_string = explode(".", $image->post_title);

    $image_title = $image_string[0];
    $image_ext = !empty($image_string[1]) ? $image_string[1] : $image_type;

    $original_name = $image_title . '.' . $image_ext;

    $file_path = wp_get_original_image_path($attachment_ID);

    $new_file_name = $image_title . '-' . $width . 'x' . $height . '.' . $image_ext;
    $new_file_path = str_replace($original_name, $new_file_name, $file_path);

    $source = \Tinify\fromUrl($image_url);
    $resized = $source->resize(array(
        "method" => "fit",
        "width" => $width,
        "height" => $height
    ));

    return $resized->toFile($new_file_path);
}


/**
 * Get image id via link.
 *
 * @since    1.0.0   
 */
function get_attachment_id($url)
{

    $attachment_id = 0;

    $dir = wp_upload_dir();

    if (false !== strpos($url, $dir['baseurl'] . '/')) {
        $file = basename($url);

        $query_args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'fields'      => 'ids',
            'meta_query'  => array(
                array(
                    'value'   => $file,
                    'compare' => 'LIKE',
                    'key'     => '_wp_attachment_metadata',
                ),
            )
        );

        $query = new WP_Query($query_args);

        if ($query->have_posts()) {

            foreach ($query->posts as $post_id) {

                $meta = wp_get_attachment_metadata($post_id);

                $original_file       = basename($meta['file']);
                $cropped_image_files = wp_list_pluck($meta['sizes'], 'file');

                if ($original_file === $file || in_array($file, $cropped_image_files)) {
                    $attachment_id = $post_id;
                    break;
                }
            }
        }
    }

    return $attachment_id;
}
