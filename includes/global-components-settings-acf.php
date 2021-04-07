<?php

$fieldNames = array();
$count = 0;
$fields = array();

foreach ($componentFields as $componentField) {
    $count = $count + 1;
    foreach ($componentField as $cfKey => $cfValue) {
        if (! in_array($componentField['label'], $fieldNames)) {
            array_push($fieldNames, $componentField['label']);
            if ($count == 1) {
                $flag = false;
                foreach ($componentField['sub_fields'] as $subKey => $subValue) {
                    if ($flag) {
                        array_push($fields, $subValue);
                    }
                    if ($subValue['label'] == 'Settings') {
                        $flag = true;
                    }
                }
            }
        }
    }
}

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(
        array(
            'key' => 'klyp_global_component',
            'title' => 'Global Components',
            'fields' => array(
                array(
                    'key' => 'select_global_component',
                    'label' => 'Select',
                    'name' => 'select_global_component',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => 'select_global_component',
                    ),
                    'choices' => $fieldNames,
                    'default_value' => false,
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'return_format' => 'value',
                    'ajax' => 0,
                    'placeholder' => '',
                ),
                array(
                    'key' => 'global_component_fields',
                    'label' => '',
                    'name' => 'global_component_fields',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'select_global_component',
                                'operator' => '==contains',
                                'value' => '',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => $fields
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'global-component',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'excerpt',
                2 => 'discussion',
                3 => 'comments',
                4 => 'revisions',
                5 => 'format',
                6 => 'categories',
                7 => 'tags',
                8 => 'send-trackbacks',
            ),
            'active' => true,
            'description' => '',
        )
    );
}

/**
 * To show thankyou popup/page after cf7 form submit.
 */
function display_thankyou_page_popup()
{
    $components = array();

    if (function_exists('klyp_acf_get_child_components')) {
        $components = klyp_acf_get_child_components();
    }

    // If components are empty
    if (empty($components) || count($components) <= 0) {
        $components = klyp_acf_get_components();
    }

    $componentFields = array();
    // Generate components
    foreach ($components as $component) {
        require locate_template('includes/components/' . $component . '.php');
        $componentFields = array_merge($componentFields, $fields);
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready( function($) { 
            $(document).on('change','#acf-select_global_component', function() {
                let name = $('#acf-select_global_component :selected').text();
                $.ajax({
                    url: 'admin-ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'change_the_component_field',
                        name: name,
                        
                    },
                    success: function (response) {
                    }
                });
            });
        });
    </script>
    <?php
}
add_action('acf/input/admin_head', 'display_thankyou_page_popup');

/*
 * Load the post on category page.
*/
add_action('wp_ajax_change_the_component_field', 'change_the_component_field');

/**
 * Function to load more post for post category listing component.
 * @return array $response
 */
function change_the_component_field()
{

    $componentFields = getComponentFields();
    $fieldNames = array();
    $count = 0;
    $fieldss = array();
    foreach ($componentFields as $componentField) {
        if (! in_array($componentField['label'], $fieldNames)) {
            if ($componentField['label'] == $_POST['name']) {
                $flag = false;
                array_push($fieldNames, $componentField['label']);
                foreach ($componentField['sub_fields'] as $subKey => $subValue) {
                    if ($flag) {
                        array_push($fieldss, $subValue);
                    }
                    if ($subKey['label'] == 'Settings') {
                        $flag = true;
                    }
                }
                break;
            }
        }
    }
    print_r($fieldss);die;
    
    // $field = get_field_object('global_component_fields');
    // $field['sub_fields'] = $fields;
    // // tell ACF to update the field settings
    // acf_update_field($field);
    print_r("Sfsdf");die;

    echo 'succuss';
    exit;
}

function getComponentFields()
{
    $components = array();

    if (function_exists('klyp_acf_get_child_components')) {
        $components = klyp_acf_get_child_components();
    }

    // If components are empty
    if (empty($components) || count($components) <= 0) {
        $components = klyp_acf_get_components();
    }

    $componentFields = array();
    // Generate components
    foreach ($components as $component) {
        require locate_template('includes/components/' . $component . '.php');
        $componentFields = array_merge($componentFields, $fields);
    }

    return $componentFields;
}
