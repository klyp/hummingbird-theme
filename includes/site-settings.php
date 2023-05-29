<?php

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'site_settings_group',
        'title' => 'Site Settings',
        'fields' => array(
            array(
                'key' => 'settings_general_tab',
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
                    'key' => 'settings_blog',
                    'label' => 'Blog Settings',
                    'name' => 'settings_blog',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'settings_blog_style',
                            'label' => 'Blog Style',
                            'name' => 'settings_blog_style',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => array(
                                'card-wo-sidebar' => 'Card Style w/o sidebar',
                                'card-w-sidebar' => 'Card Style w sidebar',
                                'list-wo-sidebar' => 'List Style w/o sidebar',
                                'list-w-sidebar' => 'List Style w sidebar',
                            ),
                            'default_value' => array(
                            ),
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 1,
                            'return_format' => 'value',
                            'ajax' => 0,
                            'placeholder' => '',
                        ),
                        array(
                            'key' => 'settings_enable_global_components',
                            'label' => 'Enable Global Components',
                            'name' => 'global_component_enable',
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
                            'default_value' => 0,
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),
                    ),
                ),

                array(
                    'key' => 'settings_logo',
                    'label' => 'Logos',
                    'name' => 'settings_logo',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'settings_logo_primary',
                            'label' => 'Logo',
                            'name' => 'settings_logo_primary',
                            'type' => 'image',
                            'instructions' => 'Leave it blank for using default logo',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'url',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                        ),
                        array(
                            'key' => 'settings_logo_footer',
                            'label' => 'Footer Logo',
                            'name' => 'settings_logo_footer',
                            'type' => 'image',
                            'instructions' => 'Leave it blank for using default logo',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'url',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                        ),
                    ),
                ),

                array(
                    'key' => 'settings_social_media',
                    'label' => 'Social Media',
                    'name' => 'settings_social_media',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'settings_instagram',
                            'label' => 'Instagram',
                            'name' => 'settings_instagram',
                            'type' => 'link',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ),
                        ),
                        array(
                            'key' => 'settings_facebook',
                            'label' => 'Facebook',
                            'name' => 'settings_facebook',
                            'type' => 'link',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ),
                        ),
                        array(
                            'key' => 'settings_linkedin',
                            'label' => 'LinkedIn',
                            'name' => 'settings_linkedin',
                            'type' => 'link',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ),
                        ),
                        array(
                            'key' => 'settings_twitter',
                            'label' => 'Twitter',
                            'name' => 'settings_twitter',
                            'type' => 'link',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ),
                        ),
                    ),
                ),

                array(
                    'key' => 'settings_form_tab',
                    'label' => 'Form Settings',
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
                    'key' => 'settings_contact',
                    'label' => 'Contact',
                    'name' => 'settings_contact',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'settings_contact_number',
                            'label' => 'Contact Number',
                            'name' => 'settings_contact_number',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                        ),
                    ),
                ),
            array(
                'key' => 'settings_site_wide_scripts_tab',
                'label' => 'Site Wide Scripts',
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
                    'key' => 'settings_script_header',
                    'label' => 'Header',
                    'name' => 'settings_script_header',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => '',
                    'new_lines' => '',
                ),
                array(
                    'key' => 'settings_script_body',
                    'label' => 'Body',
                    'name' => 'settings_script_body',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => '',
                    'new_lines' => '',
                ),
                array(
                    'key' => 'settings_script_footer',
                    'label' => 'Footer',
                    'name' => 'settings_script_footer',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => '',
                    'new_lines' => '',
                ),
            array(
                'key' => 'settings_api_tab',
                'label' => 'APIs',
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
                    'key' => 'settings_api',
                    'label' => 'API',
                    'name' => 'settings_api',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'sub_fields' => array(
                        array(
                            'key' => 'settings_api_google_map',
                            'label' => 'Google Map API',
                            'name' => 'settings_api_google_map',
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
                            'key' => 'settings_tiny_png',
                            'label' => 'Tinypng API',
                            'name' => 'settings_tiny_png',
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

                    )
                ),
            array(
                'key' => 'settings_advance_tab',
                'label' => 'Advance',
                'name' => '',
                'parent' => 'site_settings_group',
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
                    'key' => 'settings_advance',
                    'label' => 'Advance Settings',
                    'name' => 'settings_advance',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'sub_fields' => array(
                        array(
                            'key' => 'settings_advance_lazy_load_enabled',
                            'label' => 'Enable Lazy Load',
                            'name' => 'lazy_load_enabled',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '100',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 0,
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),
                        array(
                            'key' => 'settings_advance_max_revision',
                            'label' => 'Max Revisions to keep',
                            'name' => 'max_revision',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 3,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => '1',
                            'max' => '99',
                            'step' => '',
                        ),
                        array(
                            'key' => 'settings_advance_max_days_log',
                            'label' => 'Max days to keep log',
                            'name' => 'max_days_log',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 3,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => '1',
                            'max' => '99',
                            'step' => '',
                        ),
                        array(
                            'key' => 'settings_advance_super_admins',
                            'label' => 'Super Admins',
                            'name' => 'super_admins',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'collapsed' => '',
                            'min' => 0,
                            'max' => 0,
                            'layout' => 'table',
                            'button_label' => '',
                            'sub_fields' => array(
                                array(
                                    'key' => 'settings_advance_super_admins_username',
                                    'label' => 'Username',
                                    'name' => 'username',
                                    'type' => 'user',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'role' => '',
                                    'allow_null' => 0,
                                    'multiple' => 0,
                                    'return_format' => 'id',
                                ),
                            ),
                        ),
                        array(
                            'key' => 'settings_advance_defer_js',
                            'label' => 'JS Scripts not to defer',
                            'name' => 'js_scripts_to_defer',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'collapsed' => '',
                            'min' => 0,
                            'max' => 0,
                            'layout' => 'table',
                            'button_label' => '',
                            'sub_fields' => array(
                                array(
                                    'key' => 'js_scripts_to_defer_filename',
                                    'label' => 'File Name',
                                    'name' => 'file_name',
                                    'type' => 'text',
                                    'instructions' => 'only .js file can be defered',
                                    'required' => 0,
                                    'conditional_logic' => 0,
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
                                ),
                            ),
                        ),
                        array(
                            'key' => 'settings_advance_allowed_post_types',
                            'label' => 'Allow non Super Admin access to Post Types',
                            'name' => 'allowed_post_types',
                            'type' => 'checkbox',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => array(
                            ),
                            'allow_custom' => 0,
                            'default_value' => array(
                            ),
                            'layout' => 'horizontal',
                            'toggle' => 0,
                            'return_format' => 'array',
                            'save_custom' => 0,
                        ),
                    )
                ),


                
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'site-settings',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
}

/**
 * Generate custom values for non-admin post types
 * @param array
 * @return array
 */
function klyp_generate_custom_values_for_nonadmin_post_types($field)
{
    // add global components
    $field['choices']['edit.php?post_type=global-component'] = 'Global Components';

    // get public custom post types
    $postTypes = get_post_types(array('public' => true, '_builtin' => false), 'objects', 'and');

    // generate choices
    if ($postTypes) {
        foreach ($postTypes as $postType) {
            $field['choices']['edit.php?post_type=' . $postType->name] = $postType->label;
        }
    }
    return $field;
}
add_filter('acf/load_field/name=allowed_post_types', 'klyp_generate_custom_values_for_nonadmin_post_types');

// if user is not klyp or is not super admin, then don't allow them to access advance tap
if (wp_get_current_user()->user_login == 'klyp' || in_array('super-admin', wp_get_current_user()->roles)) {
} else {
    add_action('admin_footer', function () {
        echo '
            <style>
                [data-key="settings_advance_tab"] { display: none !important; }
            </style>
        ';
    });
}
