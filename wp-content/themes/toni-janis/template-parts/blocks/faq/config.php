<?php
/**
 * Block: FAQ (Haeufige Fragen)
 * Configuration and ACF field definitions.
 *
 * Pulls from CPT: toja_faq or manual repeater.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('FAQ', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_faq_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'faq_label',
            'type'          => 'text',
            'default_value' => 'Haeufige Fragen',
        ],
        [
            'key'   => 'field_toja_faq_heading',
            'label' => __('Ueberschrift', 'toni-janis'),
            'name'  => 'faq_heading',
            'type'  => 'text',
        ],
        [
            'key'  => 'field_toja_faq_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'faq_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'           => 'field_toja_faq_quelle',
            'label'         => __('Datenquelle', 'toni-janis'),
            'name'          => 'faq_quelle',
            'type'          => 'select',
            'choices'       => [
                'cpt'     => __('FAQ-Beitraege (Beitragstyp)', 'toni-janis'),
                'manuell' => __('Manuell eingeben', 'toni-janis'),
            ],
            'default_value' => 'cpt',
            'allow_null'    => false,
            'return_format' => 'value',
        ],
        [
            'key'           => 'field_toja_faq_anzahl',
            'label'         => __('Anzahl', 'toni-janis'),
            'name'          => 'faq_anzahl',
            'type'          => 'number',
            'default_value' => 6,
            'min'           => 1,
            'max'           => 30,
            'step'          => 1,
            'instructions'  => __('Wie viele FAQs anzeigen? (nur bei CPT-Quelle)', 'toni-janis'),
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_toja_faq_quelle',
                        'operator' => '==',
                        'value'    => 'cpt',
                    ],
                ],
            ],
        ],
        [
            'key'               => 'field_toja_faq_manuell',
            'label'             => __('Manuelle FAQs', 'toni-janis'),
            'name'              => 'faq_manuell',
            'type'              => 'repeater',
            'layout'            => 'block',
            'button_label'      => __('Frage hinzufuegen', 'toni-janis'),
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_toja_faq_quelle',
                        'operator' => '==',
                        'value'    => 'manuell',
                    ],
                ],
            ],
            'sub_fields' => [
                [
                    'key'   => 'field_toja_faq_frage',
                    'label' => __('Frage', 'toni-janis'),
                    'name'  => 'faq_frage',
                    'type'  => 'text',
                ],
                [
                    'key'          => 'field_toja_faq_antwort',
                    'label'        => __('Antwort', 'toni-janis'),
                    'name'         => 'faq_antwort',
                    'type'         => 'wysiwyg',
                    'toolbar'      => 'basic',
                    'media_upload' => 0,
                    'tabs'         => 'visual',
                ],
            ],
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
