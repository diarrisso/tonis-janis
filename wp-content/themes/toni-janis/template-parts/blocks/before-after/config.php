<?php
/**
 * Block: Vorher / Nachher
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Vorher / Nachher', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_ba_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'ba_label',
            'type'          => 'text',
            'default_value' => 'Vorher / Nachher',
        ],
        [
            'key'   => 'field_toja_ba_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'ba_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_ba_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'ba_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_toja_ba_vergleiche',
            'label'        => __('Vergleiche', 'toni-janis'),
            'name'         => 'ba_vergleiche',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => __('Vergleich hinzufügen', 'toni-janis'),
            'min'          => 1,
            'sub_fields'   => [
                [
                    'key'           => 'field_toja_ba_vorher',
                    'label'         => __('Vorher-Bild', 'toni-janis'),
                    'name'          => 'ba_vorher',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'medium',
                    'instructions'  => __('Bild vor der Bearbeitung', 'toni-janis'),
                ],
                [
                    'key'           => 'field_toja_ba_nachher',
                    'label'         => __('Nachher-Bild', 'toni-janis'),
                    'name'          => 'ba_nachher',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'medium',
                    'instructions'  => __('Bild nach der Bearbeitung', 'toni-janis'),
                ],
                [
                    'key'   => 'field_toja_ba_titel',
                    'label' => __('Projekttitel', 'toni-janis'),
                    'name'  => 'ba_titel',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_ba_beschreibung',
                    'label' => __('Projektbeschreibung', 'toni-janis'),
                    'name'  => 'ba_beschreibung',
                    'type'  => 'textarea',
                    'rows'  => 2,
                ],
                [
                    'key'          => 'field_toja_ba_tags',
                    'label'        => __('Tags', 'toni-janis'),
                    'name'         => 'ba_tags',
                    'type'         => 'repeater',
                    'layout'       => 'table',
                    'button_label' => __('Tag hinzufügen', 'toni-janis'),
                    'sub_fields'   => [
                        [
                            'key'   => 'field_toja_ba_tag',
                            'label' => __('Tag', 'toni-janis'),
                            'name'  => 'ba_tag',
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
