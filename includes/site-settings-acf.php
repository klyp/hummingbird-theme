<?php

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'site_settings_group',
        'title' => 'Site Settings',
        'fields' => array(
            array(
                'key' => 'general_tab',
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
                'key' => 'primary_logo',
                'label' => 'Logo',
                'name' => 'logo',
                'type' => 'image',
                'instructions' => 'Leave it blank for using default logo',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'footer_logo',
                'label' => 'Footer Logo',
                'name' => 'footer_logo',
                'type' => 'image',
                'instructions' => 'Leave it blank for using default logo',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'menu_tab',
                'label' => 'Menu',
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
                'key' => 'menu_contact_tab_text',
                'label' => 'Menu Contact Tab Text',
                'name' => 'menu_contact_text',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'Contact',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
            array(
                'key' => 'menu_contact_tab_link',
                'label' => 'Menu Contact Tab Link',
                'name' => 'menu_contact_link',
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
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
            array(
                'key' => 'menu_quote_tab_text',
                'label' => 'Menu Quote Tab Text',
                'name' => 'menu_quote_text',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'Quote',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
            array(
                'key' => 'menu_quote_tab_link',
                'label' => 'Menu Quote Tab Link',
                'name' => 'menu_quote_link',
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
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
            array(
                'key' => 'menu_phone',
                'label' => 'Contact Number',
                'name' => 'site_phone_no',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value'   => '1800 000 0000',
                'min'           => '',
                'max'           => '',
                'step'          => '',
                'placeholder'   => '',
                'prepend'       => '',
                'append'        => ''
            ),
            array(
                'key' => 'site_wide_scripts_tab',
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
                'key' => 'script_header_field',
                'label' => 'Header',
                'name' => 'script_header',
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
                'key' => 'script_body_field',
                'label' => 'Body',
                'name' => 'script_body',
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
                'key' => 'script_footer_field',
                'label' => 'Footer',
                'name' => 'script_footer',
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
                'key' => 'social_media_tab',
                'label' => 'Social Media',
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
                'key' => 'social_media_instgram_link',
                'label' => 'Instgram Link',
                'name' => 'instgram_link',
                'type' => 'text',
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
                'key' => 'social_media_facebook_link',
                'label' => 'Facebook Link',
                'name' => 'facebook_link',
                'type' => 'text',
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
                'key' => 'social_media_linkedin_link',
                'label' => 'LinkedIn Link',
                'name' => 'linkedin_link',
                'type' => 'text',
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
                'key' => 'social_media_twitter_link',
                'label' => 'Twitter Link',
                'name' => 'twitter_link',
                'type' => 'text',
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
                'key' => 'newsletter_tab',
                'label' => 'Newsletter',
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
                'key' => 'component_newsletter_title',
                'label' => 'Newsletter Title',
                'name' => 'newsletter_title',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'default_value' => 'Join with us, <br> For Our Newsletter.',
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'contact_content_tab',
                'label' => 'Contact Content',
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
                'key' => 'component_contact_content_top_section_title',
                'label' => 'Top Section Title',
                'name' => 'contact_content_top_section_title',
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
                'key' => 'component_contact_content_top_section_contact_icon',
                'label' => 'Top Section Contact Icon',
                'name' => 'contact_content_top_section_contact_icon',
                'type' => 'image',
                'instructions' => '&nbsp;',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'component_contact_content_top_section_contact_title',
                'label' => 'Top Section Contact Title',
                'name' => 'contact_content_top_section_contact_title',
                'type' => 'text',
                'instructions' => '&nbsp;',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'component_contact_content_top_section_contact_body',
                'label' => 'Top Section Contact Body',
                'name' => 'contact_content_top_section_contact_body',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => '',
                'toolbar' => 'basic',
                'media_upload' => 1,
                'delay' => 1,
            ),
            array(
                'key' => 'component_contact_content_top_section_call_icon',
                'label' => 'Top Section Call Icon',
                'name' => 'contact_content_top_section_call_icon',
                'type' => 'image',
                'instructions' => '&nbsp;',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'component_contact_content_top_section_call_title',
                'label' => 'Top Section Call Title',
                'name' => 'contact_content_top_section_call_title',
                'type' => 'text',
                'instructions' => '&nbsp;',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'component_contact_content_top_section_call_body',
                'label' => 'Top Section Call Body',
                'name' => 'contact_content_top_section_call_body',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => '',
                'toolbar' => 'basic',
                'media_upload' => 1,
                'delay' => 1,
            ),
            array(
                'key' => 'component_contact_content_bottom_section_title',
                'label' => 'Bottom Section Title',
                'name' => 'contact_content_bottom_section_title',
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
                'key' => 'component_contact_content_bottom_section_body',
                'label' => 'Bottom Section Body',
                'name' => 'contact_content_bottom_section_body',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => '',
                'toolbar' => 'basic',
                'media_upload' => 1,
                'delay' => 1,
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
