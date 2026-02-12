<?php
/**
 * Block: Kostenloses Angebot
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Kostenloses Angebot', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_quote_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'quote_label',
            'type'          => 'text',
            'default_value' => 'Kostenloses Angebot',
        ],
        [
            'key'   => 'field_toja_quote_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'quote_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_quote_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'quote_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_toja_quote_services',
            'label'        => __('Leistungen', 'toni-janis'),
            'name'         => 'quote_services',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => __('Leistung hinzufügen', 'toni-janis'),
            'min'          => 1,
            'sub_fields'   => [
                [
                    'key'          => 'field_toja_quote_service_icon',
                    'label'        => __('Icon (SVG-Code)', 'toni-janis'),
                    'name'         => 'qs_icon',
                    'type'         => 'textarea',
                    'rows'         => 3,
                    'instructions' => __('SVG-Code für das Icon', 'toni-janis'),
                ],
                [
                    'key'   => 'field_toja_quote_service_titel',
                    'label' => __('Titel', 'toni-janis'),
                    'name'  => 'qs_titel',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_quote_service_beschreibung',
                    'label' => __('Beschreibung', 'toni-janis'),
                    'name'  => 'qs_beschreibung',
                    'type'  => 'textarea',
                    'rows'  => 2,
                ],
            ],
        ],
        [
            'key'           => 'field_toja_quote_email',
            'label'         => __('E-Mail-Adresse', 'toni-janis'),
            'name'          => 'quote_email',
            'type'          => 'email',
            'default_value' => '',
            'instructions'  => __('E-Mail-Adresse für Angebotsanfragen', 'toni-janis'),
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
