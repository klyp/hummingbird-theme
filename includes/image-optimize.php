<?php

/**
 * Add a cron schedule.
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
 * @since    1.0.0
 */
function klyp_configure_tinypng_api()
{
    $api_tiny_png = get_field('settings_tiny_png', 'option');

    if(! empty( $api_tiny_png ) ) {
        \Tinify\setKey($api_tiny_png);
    }
}
add_action('plugins_loaded', 'klyp_configure_tinypng_api');

/**
 * Add custom cron recurrence time interval.
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
add_action('cron_schedules', 'klyp_set_cron_schedule_time');

/**
 * Add callback to cron scheduled for image compression and rename.
 * @since    1.0.0
 */
function klyp_existing_image_processing_cron_fire_event()
{
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
        process_single_image_batch($images[0]);
    }
}
add_action('klyp_cc_cron_schedule', 'klyp_existing_image_processing_cron_fire_event');

/**
 * Creates webp version of image.
 * @since    1.0.0
 * @param    array      $batch      current batch for processing webp
 */
function process_single_image_batch($batch)
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

    process_single_image_batch($images);
}
add_action('add_attachment', 'klyp_after_upload_image_processing_event');
add_action('edit_attachment', 'klyp_after_upload_image_processing_event');

/**
 * Include tinypng library
 * @return void
 */
function klyp_include_tinypng_lib()
{
    /**
     * The includes library responsible for defining all actions that occur in the tinypng api
     */
    if (! function_exists('get_field')) {
        include_once(ABSPATH . 'wp-content/plugins/advanced-custom-fields-pro/acf.php');
    }
    $api_tiny_png = get_field('settings_tiny_png', 'option');

    if (! empty($api_tiny_png)) {
        \Tinify\setKey($api_tiny_png);
    }
}
add_action('init', 'klyp_include_tinypng_lib');

/**
 * Prepare a resized image.
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
