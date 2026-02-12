<?php
/**
 * Block: Services (Leistungen)
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Leistungen', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_services_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'services_label',
            'type'          => 'text',
            'default_value' => 'Unsere Leistungen',
        ],
        [
            'key'   => 'field_toja_services_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'services_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_services_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'services_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_toja_services_liste',
            'label'        => __('Services', 'toni-janis'),
            'name'         => 'services_liste',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => __('Service hinzufügen', 'toni-janis'),
            'sub_fields'   => [
                [
                    'key'          => 'field_toja_services_service_icon',
                    'label'        => __('Icon', 'toni-janis'),
                    'name'         => 'service_icon',
                    'type'         => 'textarea',
                    'rows'         => 3,
                    'instructions' => __('SVG Code oder Emoji', 'toni-janis'),
                ],
                [
                    'key'   => 'field_toja_services_service_titel',
                    'label' => __('Titel', 'toni-janis'),
                    'name'  => 'service_titel',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_services_service_beschreibung',
                    'label' => __('Beschreibung', 'toni-janis'),
                    'name'  => 'service_beschreibung',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
                [
                    'key'           => 'field_toja_services_service_link',
                    'label'         => __('Link', 'toni-janis'),
                    'name'          => 'service_link',
                    'type'          => 'link',
                    'return_format' => 'array',
                ],
            ],
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
