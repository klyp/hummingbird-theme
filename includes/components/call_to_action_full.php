<?php

$compNames = klyp_get_the_global_components('call_to_action_full');

$fields = array(
    'component_call_to_action_full' => array(
        'key' => 'component_call_to_action_full',
        'name' => 'call_to_action_full',
        'label' => 'Call to Action Full',
        'display' => 'block',
        'sub_fields' => array(
            array(
                'key' => 'component_call_to_action_full_tab_general',
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
                'key' => 'component_cta_full_enable',
                'label' => 'Enable',
                'name' => 'cta_full_enable',
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
                'key' => 'component_call_to_action_full_global_component',
                'label' => 'Global Component',
                'name' => 'call_to_action_full_global_component',
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
                'key' => 'component_call_to_action_full_id',
                'label' => 'ID',
                'name' => 'id',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'component_call_to_action_full_class',
                'label' => 'Classes',
                'name' => 'class',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'component_call_to_action_full_settings',
                'label' => 'Settings',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'component_call_to_action_full_global_component',
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
                'key' => 'component_call_to_action_full_image',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => 'jpg, bmp, gif, png',
            ),
            array(
                'key' => 'component_call_to_action_full_desktop_position',
                'label' => 'Desktop Image Background Position',
                'name' => 'desktop_image_position',
                'type' => 'select',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'multiple'      => 0,
                'allow_null'    => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'choices'       => array(
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => 'left top',
                'ui'            => 0,
                'ajax'          => 0,
                'placeholder'   => '',
                'return_format' => 'value'
            ),
            array(
                'key' => 'component_call_to_action_full_mobile_position',
                'label' => 'Mobile Image Background Position',
                'name' => 'mobile_image_position',
                'type' => 'select',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'multiple'      => 0,
                'allow_null'    => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'choices'       => array(
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => 'left top',
                'ui'            => 0,
                'ajax'          => 0,
                'placeholder'   => '',
                'return_format' => 'value'
            ),
            array(
                'key' => 'component_call_to_action_full_header',
                'label' => 'Header',
                'name' => 'header',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => 155,
            ),
            array(
                'key' => 'component_call_to_action_full_primary_cta',
                'label' => 'Primary CTA',
                'name' => 'primary_cta',
                'type' => 'link',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
            ),
        ),
        'min' => '',
        'max' => '',
    )
);
