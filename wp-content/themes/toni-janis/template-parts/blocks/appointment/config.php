<?php
/**
 * Block: Termin buchen
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Termin buchen', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_appointment_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'appointment_label',
            'type'          => 'text',
            'default_value' => 'Termin buchen',
        ],
        [
            'key'   => 'field_toja_appointment_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'appointment_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_appointment_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'appointment_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_toja_appointment_typen',
            'label'        => __('Beratungsarten', 'toni-janis'),
            'name'         => 'appointment_typen',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => __('Typ hinzufügen', 'toni-janis'),
            'min'          => 1,
            'sub_fields'   => [
                [
                    'key'          => 'field_toja_appointment_typ_icon',
                    'label'        => __('Icon (SVG-Code)', 'toni-janis'),
                    'name'         => 'typ_icon',
                    'type'         => 'textarea',
                    'rows'         => 3,
                    'instructions' => __('SVG-Code für das Icon', 'toni-janis'),
                ],
                [
                    'key'   => 'field_toja_appointment_typ_titel',
                    'label' => __('Titel', 'toni-janis'),
                    'name'  => 'typ_titel',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_appointment_typ_beschreibung',
                    'label' => __('Beschreibung', 'toni-janis'),
                    'name'  => 'typ_beschreibung',
                    'type'  => 'textarea',
                    'rows'  => 2,
                ],
            ],
        ],
        [
            'key'           => 'field_toja_appointment_email',
            'label'         => __('E-Mail-Adresse', 'toni-janis'),
            'name'          => 'appointment_email',
            'type'          => 'email',
            'default_value' => '',
            'instructions'  => __('E-Mail-Adresse für Terminanfragen', 'toni-janis'),
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
