<?php

/*
 * Get the component template data.
*/
add_action('wp_ajax_klyp_get_comp_data', 'klyp_get_comp_data_callback');
add_action('wp_ajax_nopriv_klyp_get_comp_data', 'klyp_get_comp_data_callback');

/**
 * Ajax function to get the component data and return in response.
 */
function klyp_get_comp_data_callback()
{
    // To verify nonce
    // if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'klyp-secret')) {
    //     exit;
    // }
    // To see if we have comp data
    if (! isset($_POST['attr'])) {
        return;
    }
    
    $comp = $_POST['attr'];
    $pagePostId = $comp['page_id'];
    $pageComponents = get_field('components', $pagePostId);

    ob_start();
    if (! empty($pageComponents)) {
        foreach ($pageComponents as $key => $pageComponent) {
            if ($pageComponent['acf_fc_layout'] == $comp['layout']) {
               // print_r($comp['layout']);die;
               
                // require(get_template_directory() . '/templates/components/advance_counter.php');
                // get_template_part('templates/components', $comp['layout']);
                // $html = file_get_contents(locate_template('templates/components/' . $comp['layout'] . '.php'));
                include_once get_stylesheet_directory() . '/templates/components/' . $comp['layout'] . '.php';
                // print_r($pageComponent['acf_fc_layout']);
                // print_r($comp['layout']);
            }
        }
    }
    
    $data = ob_get_clean();
    echo json_encode($data);
    wp_die();
}
