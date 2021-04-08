<?php

$fieldNames = array('Select');

// To create array of exising components.
foreach ($componentFields as $componentField) {
    foreach ($componentField as $cfKey => $cfValue) {
        if (! in_array($componentField['label'], $fieldNames)) {
           array_push($fieldNames, $componentField['label']);
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
                    'label' => 'Select Component',
                    'name' => 'select_global_component',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 1,
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
                                'operator' => '!=',
                                'value' => '0',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array()
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
 * Change load component fields after select.
 *
 * @param  array $field field data.
 * @return array
 */
function load_global_component_fields($field)
{
    $fields              = change_the_component_field();
    $field['sub_fields'] = $fields;

	return $field;
}
add_filter('acf/load_field/name=global_component_fields', 'load_global_component_fields');

/**
 * Generate fields for the component field group.
 *
 * @return array
 */
function change_the_component_field()
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

    $fieldNames = array();
    $count = 1;
    $fields = array();
    $groups = array();

    foreach ($componentFields as $componentField) {    
        foreach ($componentField as $cfKey => $cfValue) {
            if (! in_array($componentField['label'], $fieldNames)) {
                array_push($fieldNames, $componentField['label']);
                $flag = false;
                $fields = array();

                foreach ($componentField['sub_fields'] as $subKey => $subValue) {
                    if ($flag) {
                        array_push($fields, $subValue);
                    }
                    if ($subValue['label'] == 'Settings') {
                        $flag = true;
                    }
                }

                $group = array(
                    'key' => 'global_component_fields_' . $componentField['name'],
                    'label' => $componentField['label'],
                    'name' => 'global_component_fields_' . $componentField['name'],
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'select_global_component',
                                'operator' => '==',
                                'value' => $count,
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
                );

                array_push($groups, $group);
                $count = $count + 1;
            }
        }
    }

    return $groups;
}

/**
 * Apply validation to component select field.
 *
 * @param  mixed $valid field valid value.
 * @param  mixed $value field field value.
 * @param  array $field field field array.
 * @param  string $input_name field name.
 * @return array
 */
function klyp_acf_validate_value($valid, $value, $field, $input_name) {

    // Bail early if value is already invalid.
    if($valid !== true) {
        return $valid;
    }

    if ($input_name == 'acf[select_global_component]') {
        // Prevent value from saving if it contains default value.
        if(is_string($value) && strpos($value, '0') !== false) {
            return esc_html__('Select value is required.', 'klyp');
        }
    }

    return $valid;
}
// Apply to all fields.
add_filter('acf/validate_value', 'klyp_acf_validate_value', 10, 4);
