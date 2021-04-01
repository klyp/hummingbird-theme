<?php
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(
        array(
            'key' => 'klyp_group_components',
            'title' => 'Components',
            'fields' => array(
                array(
                    'key' => 'field_klyp_components',
                    'label' => 'Components',
                    'name' => 'components',
                    'type' => 'flexible_content',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layouts' => $componentFields,
                    'button_label' => 'Add Component',
                    'min' => '',
                    'max' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
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
