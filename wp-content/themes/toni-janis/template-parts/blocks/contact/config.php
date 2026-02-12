<?php
/**
 * Block: Kontakt
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Kontakt', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_contact_heading',
            'label'         => __('Überschrift', 'toni-janis'),
            'name'          => 'contact_heading',
            'type'          => 'text',
            'default_value' => 'Kontaktieren Sie uns',
        ],
        [
            'key'   => 'field_toja_contact_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'contact_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'           => 'field_toja_contact_infos_anzeigen',
            'label'         => __('Kontaktinfos anzeigen', 'toni-janis'),
            'name'          => 'contact_infos_anzeigen',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => __('Kontaktinformationen in der Seitenleiste anzeigen', 'toni-janis'),
        ],
        [
            'key'           => 'field_toja_contact_formular_anzeigen',
            'label'         => __('Kontaktformular anzeigen', 'toni-janis'),
            'name'          => 'contact_formular_anzeigen',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => __('Kontaktformular anzeigen', 'toni-janis'),
        ],
        [
            'key'           => 'field_toja_contact_email',
            'label'         => __('E-Mail-Adresse', 'toni-janis'),
            'name'          => 'contact_email',
            'type'          => 'email',
            'default_value' => '',
            'instructions'  => __('E-Mail-Adresse für Kontaktanfragen', 'toni-janis'),
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_toja_contact_formular_anzeigen',
                        'operator' => '==',
                        'value'    => '1',
                    ],
                ],
            ],
        ],
        [
            'key'          => 'field_toja_contact_services',
            'label'        => __('Leistungen für Dropdown', 'toni-janis'),
            'name'         => 'contact_services',
            'type'         => 'repeater',
            'layout'       => 'table',
            'button_label' => __('Leistung hinzufügen', 'toni-janis'),
            'instructions' => __('Leistungen die im Kontaktformular-Dropdown angezeigt werden', 'toni-janis'),
            'sub_fields'   => [
                [
                    'key'   => 'field_toja_contact_service_value',
                    'label' => __('Wert', 'toni-janis'),
                    'name'  => 'service_value',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_contact_service_label',
                    'label' => __('Bezeichnung', 'toni-janis'),
                    'name'  => 'service_label',
                    'type'  => 'text',
                ],
            ],
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_toja_contact_formular_anzeigen',
                        'operator' => '==',
                        'value'    => '1',
                    ],
                ],
            ],
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
