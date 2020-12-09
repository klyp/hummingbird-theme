<?php
    $fields = array(
        'component_timeline' => array(
            'key' => 'component_timeline',
            'name' => 'timeline',
            'label' => 'Timeline',
            'display' => 'block',
            'sub_fields' => array(
                array(
                    'key' => 'component_timeline_tab_general',
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
                    'key' => 'component_timeline_enable',
                    'label' => 'Enable',
                    'name' => 'counter_enable',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
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
                    'key' => 'component_timeline_id',
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
                    'key' => 'component_timeline_class',
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
                    'key' => 'component_timeline_tab_settings',
                    'label' => 'Settings',
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
                    'key' => 'component_timeline_data',
                    'label' => 'Timeline Data',
                    'name' => 'timeline_data',
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
                            'key' => 'component_timeline_link',
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
                        ),
                        array(
                            'key' => 'component_timeline_date',
                            'label' => 'Date',
                            'name' => 'date',
                            'type' => 'date_picker',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'display_format' => 'd/m/Y',
                            'return_format' => 'd/m/Y',
                            'first_day' => 1,
                        )
                    )
                )
            )
        )
    );