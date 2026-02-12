<?php
/**
 * Block: Entsorgungsservice
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Entsorgungsservice', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_entsorgen_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'entsorgen_label',
            'type'          => 'text',
            'default_value' => 'Entsorgungsservice',
        ],
        [
            'key'   => 'field_toja_entsorgen_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'entsorgen_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_entsorgen_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'entsorgen_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_toja_entsorgen_services',
            'label'        => __('Entsorgungsarten', 'toni-janis'),
            'name'         => 'entsorgen_services',
            'type'         => 'repeater',
            'layout'       => 'table',
            'button_label' => __('Entsorgungsart hinzufügen', 'toni-janis'),
            'min'          => 1,
            'sub_fields'   => [
                [
                    'key'   => 'field_toja_entsorgen_service_text',
                    'label' => __('Bezeichnung', 'toni-janis'),
                    'name'  => 'es_text',
                    'type'  => 'text',
                    'instructions' => __('z.B. "Sperrmüll & Haushaltsauflösungen"', 'toni-janis'),
                ],
            ],
        ],
        [
            'key'          => 'field_toja_entsorgen_vorteile',
            'label'        => __('Vorteile', 'toni-janis'),
            'name'         => 'entsorgen_vorteile',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => __('Vorteil hinzufügen', 'toni-janis'),
            'sub_fields'   => [
                [
                    'key'          => 'field_toja_entsorgen_vorteil_icon',
                    'label'        => __('Icon (SVG-Code)', 'toni-janis'),
                    'name'         => 'vorteil_icon',
                    'type'         => 'textarea',
                    'rows'         => 3,
                    'instructions' => __('SVG-Code für das Icon', 'toni-janis'),
                ],
                [
                    'key'   => 'field_toja_entsorgen_vorteil_titel',
                    'label' => __('Titel', 'toni-janis'),
                    'name'  => 'vorteil_titel',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_entsorgen_vorteil_text',
                    'label' => __('Text', 'toni-janis'),
                    'name'  => 'vorteil_text',
                    'type'  => 'textarea',
                    'rows'  => 2,
                ],
            ],
        ],
        [
            'key'           => 'field_toja_entsorgen_email',
            'label'         => __('E-Mail-Adresse', 'toni-janis'),
            'name'          => 'entsorgen_email',
            'type'          => 'email',
            'default_value' => '',
            'instructions'  => __('E-Mail-Adresse für Entsorgungsanfragen', 'toni-janis'),
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
