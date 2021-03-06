<?php

$compNames = klyp_get_the_global_components('advance_counter');

$fields = array(
    'component_advance_counter' => array(
        'key' => 'component_advance_counter',
        'name' => 'advance_counter',
        'label' => 'Advance Counter',
        'display' => 'block',
        'sub_fields' => array(
            array(
                'key' => 'component_advance_counter_tab_general',
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
                'key' => 'component_advance_counter_enable',
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
                'key' => 'component_advance_counter_global_component',
                'label' => 'Global Component',
                'name' => 'advance_counter_global_component',
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
                'key' => 'component_advance_counter_id',
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
                'key' => 'component_advance_counter_class',
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
                'key' => 'component_advance_counter_tab_settings',
                'label' => 'Settings',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'component_advance_counter_global_component',
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
                'key' => 'component_advance_counter_title',
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
                'instructions' => '&nbsp;',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'component_advance_counter_subtitle',
                'label' => 'Subtitle',
                'name' => 'subtitle',
                'type' => 'text',
                'instructions' => '&nbsp;',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'component_advance_counter_percentage',
                'label' => 'Percentage',
                'name' => 'percentage',
                'type' => 'repeater',
                'instructions' => '&nbsp;',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'min' => 1,
                'max' => 0,
                'layout' => 'table',
                'sub_fields' => array(
                    array(
                        'key' => 'component_advance_counter_countertitle',
                        'label' => 'Counter Title',
                        'name' => 'countertitle',
                        'type' => 'text',
                        'instructions' => '&nbsp;',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                    ),
                    array(
                        'key' => 'component_advance_counter_selectdata',
                        'label' => 'Select option',
                        'name' => 'radio',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'percent' => 'Percent',
                            'number' => 'Number',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => 'percent',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'component_advance_counter_percent',
                        'label' => 'Percent',
                        'name' => 'percent',
                        'type' => 'range',
                        'required' => 0,
                        'default' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'component_advance_counter_selectdata',
                                    'operator' => '==',
                                    'value' => 'percent',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'minimum' => 0,
                        'maximum' => 100,
                        'step_size' => 1,
                        'append' => '%',
                        'prepend' => '',
                    ),
                    array(
                        'key' => 'component_advance_counter_number',
                        'label' => 'Number',
                        'name' => 'number',
                        'type' => 'number',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'component_advance_counter_selectdata',
                                    'operator' => '==',
                                    'value' => 'number',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    )
                )
            )
        )
    )
);
