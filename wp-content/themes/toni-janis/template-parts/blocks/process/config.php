<?php
/**
 * Block: Process (Arbeitsprozess)
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Arbeitsprozess', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_process_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'process_label',
            'type'          => 'text',
            'default_value' => 'Unser Arbeitsprozess',
        ],
        [
            'key'   => 'field_toja_process_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'process_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_process_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'process_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_toja_process_schritte',
            'label'        => __('Schritte', 'toni-janis'),
            'name'         => 'process_schritte',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => __('Schritt hinzufügen', 'toni-janis'),
            'sub_fields'   => [
                [
                    'key'          => 'field_toja_process_schritt_icon',
                    'label'        => __('Icon', 'toni-janis'),
                    'name'         => 'schritt_icon',
                    'type'         => 'textarea',
                    'rows'         => 3,
                    'instructions' => __('SVG Code oder Symbol', 'toni-janis'),
                ],
                [
                    'key'   => 'field_toja_process_schritt_titel',
                    'label' => __('Titel', 'toni-janis'),
                    'name'  => 'schritt_titel',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_process_schritt_beschreibung',
                    'label' => __('Beschreibung', 'toni-janis'),
                    'name'  => 'schritt_beschreibung',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
            ],
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
