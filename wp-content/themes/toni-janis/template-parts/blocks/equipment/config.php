<?php
/**
 * Block: Equipment (Professionelle Ausrüstung)
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Ausrüstung', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_equipment_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'equipment_label',
            'type'          => 'text',
            'default_value' => 'Professionelle Ausrüstung',
        ],
        [
            'key'   => 'field_toja_equipment_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'equipment_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_equipment_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'equipment_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_toja_equipment_items',
            'label'        => __('Geräte', 'toni-janis'),
            'name'         => 'equipment_items',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => __('Gerät hinzufügen', 'toni-janis'),
            'sub_fields'   => [
                [
                    'key'          => 'field_toja_equipment_item_icon',
                    'label'        => __('Icon', 'toni-janis'),
                    'name'         => 'equipment_icon',
                    'type'         => 'textarea',
                    'rows'         => 3,
                    'instructions' => __('SVG Code', 'toni-janis'),
                ],
                [
                    'key'   => 'field_toja_equipment_item_titel',
                    'label' => __('Titel', 'toni-janis'),
                    'name'  => 'equipment_titel',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_equipment_item_beschreibung',
                    'label' => __('Beschreibung', 'toni-janis'),
                    'name'  => 'equipment_beschreibung',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
                [
                    'key'          => 'field_toja_equipment_item_tags',
                    'label'        => __('Tags / Spezifikationen', 'toni-janis'),
                    'name'         => 'equipment_tags',
                    'type'         => 'repeater',
                    'layout'       => 'table',
                    'button_label' => __('Tag hinzufügen', 'toni-janis'),
                    'sub_fields'   => [
                        [
                            'key'   => 'field_toja_equipment_tag_name',
                            'label' => __('Tag', 'toni-janis'),
                            'name'  => 'tag_name',
                            'type'  => 'text',
                        ],
                    ],
                ],
            ],
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
