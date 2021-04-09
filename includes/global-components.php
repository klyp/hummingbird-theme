<?php

/**
 * Generate fields for the component field group.
 *
 * @return array
 */
function klyp_change_the_component_field($componentFields)
{
    $fieldNames = array();
    $count = 1;
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
                                'value' => $componentField['name'],
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
 * Return global components related to particluar component.
 *
 * @param  array $component field valid value.
 * 
 * @return array
 */
function klyp_get_the_global_components($component)
{
    $compNames = array('' => 'Select');

    $args = [
        'post_type'      => 'global-component',
        'posts_per_page' => - 1,
        'fields'         => 'ids',
        'meta_query'     => []
    ];

    if (! empty($component)) {
        $args['meta_query'][] = [
            'key'     => 'select_global_component',
            'value'   => $component,
            'compare' => '==',
            'type'    => 'CHAR'
        ];
    }

    $query = new WP_Query($args);

    if (! empty($query->posts)) {
        foreach ($query->posts as $pId) {
            $compNames[$pId] = get_the_title($pId);
        }
    }

    return $compNames;
}

/**
 * Return global components field values if selected else component field values.
 *
 * @param  string $globalComponent globalComponent post id if selected.
 * @param  string $compName component name.
 * @param  string $fieldName field name.
 * 
 * @return mixed
 */
function klyp_get_the_field_values($globalComponent, $compName, $fieldName)
{
    if (! empty($globalComponent)) {
        $data = get_field('global_component_fields', $globalComponent);
        $fieldValue = $data['global_component_fields_'. $compName][$fieldName];
    } else {
        $fieldValue      = get_sub_field($fieldName);
    }

    return $fieldValue;
}
