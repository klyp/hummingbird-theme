<?php

$compNames = klyp_get_the_global_components('tile');

$fields = array(
    'component_tile' => array(
        'key' => 'component_tile',
        'name' => 'tile',
        'label' => 'Tile',
        'display' => 'block',
        'sub_fields' => array(
            array(
                'key' => 'component_tile_tab_general',
                'label' => 'General',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'component_tile_enable',
                'label' => 'Enable',
                'name' => 'counter_enable',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'component_tile_global_component',
                'label' => 'Global Component',
                'name' => 'tile_global_component',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => $compNames,
                'default_value' => false,
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
            array(
                'key' => 'component_tile_id',
                'label' => 'ID',
                'name' => 'id',
                'type' => 'text',
                'instructions' => 'identifier',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'component_tile_class',
                'label' => 'Classes',
                'name' => 'class',
                'type' => 'text',
                'instructions' => 'additional classes',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'component_tile_tab_settings',
                'label' => 'Settings',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'component_tile_global_component',
                            'operator' => '==',
                            'value' => '',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'component_tile_data',
                'label' => 'Tile Data',
                'name' => 'tile_data',
                'type' => 'repeater',
                'instructions' => '&nbsp;',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'min' => 3,
                'max' => 0,
                'layout' => 'table',
                'sub_fields' => array(
                    array(
                        'key' => 'component_tile_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'instructions' => 'File size must be less or equal to 2MB',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'url',
                        'library' => 'all',
                        'min_size' => '',
                        'max_size' => '2MB',
                        'mime_types' => 'jpg,bmp,gif,png',
                    ),
                    array(
                        'key' => 'component_tile_link',
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'link',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                    )
                )
            )
        )
    )
);
