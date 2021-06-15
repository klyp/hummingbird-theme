<?php

if (isset($componentFields)) {
    $fieldNames = array('' => 'Select');
    $fields     = klyp_change_the_component_field($componentFields);

    // To create array of exising components.
    foreach ($componentFields as $componentField) {
        foreach ($componentField as $cfKey => $cfValue) {
            if (! in_array($componentField['label'], $fieldNames)) {
                $fieldNames[$componentField['name']] = $componentField['label'];
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
