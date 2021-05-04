<?php

/**
 * Add import window on pages
 * @return void
 */
function klyp_add_import_window()
{
    global $wp;

    // show window only for pages
    if ($wp->query_vars['post_type'] == 'page') {
        echo '
        <div id="klyp-import-page-modal" class="klyp-modal">
            <label class="klyp-modal__bg" for="hb-log-7"></label>
            <div class="klyp-modal__inner import">
                <form id="klyp-import-page-form" method="post"  enctype="multipart/form-data" action="' . admin_url('admin-post.php') . '">
                    <label class="klyp-modal__close" for="hb-log-7"></label>
                    <h2>Import</h2>
                    <input name="action" type="hidden" value="custom_form_submit">
                    <input id="klyp-import-page-nonce" name="importNonce" type="hidden" value="' . wp_create_nonce('klyp-hummingbird') . '">
                    <input id="klyp-import-page-action" name="klypAction" type="hidden" value="klyp-import-page">
                    <input id="klyp-import-page-id" name="postID" type="hidden" value="">
                    <input id="klyp-import-page-file" name="importFile" type="file" accept="application/JSON" required>
                    <input id="klyp-import-page-submit" type="submit" name="submit" class="button button-primary alignright" value="Import">
                </form>
            </div>
        </div>';
    }
}
add_action('admin_head', 'klyp_add_import_window');

/**
 * Function to export components
 * @param object
 * @return void
 */
function klyp_page_export_components($wp)
{
    // check nonce
    if (! isset($wp->query_vars['exportNonce'])) {
        return;
    }

    // verify nonce
    if (! wp_verify_nonce($wp->query_vars['exportNonce'], 'klyp-hummingbird')) {
        return;
    }

    // check exported page id
    if (! isset($wp->query_vars['exportID'])) {
        return;
    }

    global $wpdb;
    $postID = intval($wp->query_vars['exportID']);
    // query to get post meta with meta key components
    $postMetas = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT meta_key, meta_value
            FROM $wpdb->postmeta
            WHERE post_id = %d
            AND (meta_key like 'components%' OR meta_key like '_components%')
            ORDER BY meta_key ASC", $postID
        )
    );

    // if we find results
    if ($postMetas) {
        // encode to json
        $theJson = json_encode($postMetas);
        // force download
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . get_post_field('post_name', $postID) . '.json"');
        header('Content-Length: ' . strlen($theJson));
        echo $theJson;
        die();
    } else {
        // if nothing found
        $notice = __('No component found in page titled: <strong>"' . get_the_title($wp->query_vars['exportID']) . '"</strong>.');
        klyp_add_admin_notice($notice, 'warning');
    }
    return;
}

/**
 * Function to export components
 * @return void
 */
function klyp_page_import_components()
{
    // check action
    if (isset($_POST['klypAction']) && sanitize_text_field($_POST['klypAction']) != 'klyp-import-page') {
        return;
    }

    // verify nonce
    if (! isset($_POST['importNonce']) || ! wp_verify_nonce($_POST['importNonce'], 'klyp-hummingbird')) {
        $notice = __('Invalid request.', 'hummingbird');
        klyp_add_admin_notice($notice, 'error');
    }

    // check import file
    if (! isset($_FILES['importFile']) || ! isset($_POST['postID'])) {
        $notice = __('No import file found.', 'hummingbird');
        klyp_add_admin_notice($notice, 'error');
    }

    // grab uploaded file
    if (isset($_FILES['importFile']) && isset($_FILES['importFile']['tmp_name'])) {
        $importFileContent = json_decode(file_get_contents($_FILES['importFile']['tmp_name']));

        // if json is valid
        if ((json_last_error() == JSON_ERROR_NONE) === true) {
            // delete post meta
            global $wpdb;
            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM $wpdb->postmeta
                    WHERE post_id = %d AND
                    (meta_key LIKE 'components%' OR meta_key LIKE '_components%')",
                    intval($_POST['postID'])
                )
            );

            // insert data
            foreach ($importFileContent as $key => $value) {
                add_post_meta(intval($_POST['postID']), $value->meta_key, (is_serialized($value->meta_value) ? unserialize($value->meta_value) : $value->meta_value), true);
            }

            // create notice before we redirect
            $notice = __('Components imported.', 'hummingbird');
            klyp_add_admin_notice($notice, 'success');
        } else {
            // if error
            $notice = __('Import file is either corrupted or invalid.', 'hummingbird');
            klyp_add_admin_notice($notice, 'error');
        }
    }
    wp_safe_redirect(wp_get_referer());
    return;
}

/**
 * Add import export actions on pages
 * @param array
 * @param object
 * @return void
 */
function klyp_add_page_custom_actions($actions, $post)
{
    global $wp;
    $args['exportNonce']    = wp_create_nonce('klyp-hummingbird');
    $args['exportID']       = $post->ID;

    // add import export
    $actions['export_components'] = '<a href="'. site_url(add_query_arg($args)) . '">' . __('Export Components', 'hummingbird') . '</a>';
    $actions['import_components'] = '<a href="#" class="klyp-import-components klyp-modal__open" data-target="' . $post->ID . '">' . __('Import Components', 'hummingbird') . '</a>';
    return $actions;
}
// only trigger if admin
if (is_admin()) {
    add_filter('page_row_actions', 'klyp_add_page_custom_actions', 10, 2);
    add_action('wp', 'klyp_page_export_components');
    add_action('admin_post_custom_form_submit', 'klyp_page_import_components');
}
