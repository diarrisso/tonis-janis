<?php
/**
 * Block: Testimonials (Kundenstimmen)
 * Configuration and ACF field definitions.
 *
 * Pulls from CPT: toja_testimonial or manual repeater.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Kundenstimmen', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_testimonials_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'testimonials_label',
            'type'          => 'text',
            'default_value' => 'Kundenstimmen',
        ],
        [
            'key'   => 'field_toja_testimonials_heading',
            'label' => __('Ueberschrift', 'toni-janis'),
            'name'  => 'testimonials_heading',
            'type'  => 'text',
        ],
        [
            'key'  => 'field_toja_testimonials_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'testimonials_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'           => 'field_toja_testimonials_anzahl',
            'label'         => __('Anzahl', 'toni-janis'),
            'name'          => 'testimonials_anzahl',
            'type'          => 'number',
            'default_value' => 6,
            'min'           => 1,
            'max'           => 24,
            'step'          => 1,
            'instructions'  => __('Wie viele Kundenstimmen anzeigen? (nur bei CPT-Quelle)', 'toni-janis'),
        ],
        [
            'key'           => 'field_toja_testimonials_quelle',
            'label'         => __('Datenquelle', 'toni-janis'),
            'name'          => 'testimonials_quelle',
            'type'          => 'select',
            'choices'       => [
                'cpt'     => __('Kundenstimmen (Beitragstyp)', 'toni-janis'),
                'manuell' => __('Manuell eingeben', 'toni-janis'),
            ],
            'default_value' => 'cpt',
            'allow_null'    => false,
            'return_format' => 'value',
        ],
        [
            'key'               => 'field_toja_testimonials_manuell',
            'label'             => __('Manuelle Kundenstimmen', 'toni-janis'),
            'name'              => 'testimonials_manuell',
            'type'              => 'repeater',
            'layout'            => 'block',
            'button_label'      => __('Kundenstimme hinzufuegen', 'toni-janis'),
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_toja_testimonials_quelle',
                        'operator' => '==',
                        'value'    => 'manuell',
                    ],
                ],
            ],
            'sub_fields' => [
                [
                    'key'   => 'field_toja_testimonials_tm_name',
                    'label' => __('Name', 'toni-janis'),
                    'name'  => 'tm_name',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_testimonials_tm_ort',
                    'label' => __('Ort', 'toni-janis'),
                    'name'  => 'tm_ort',
                    'type'  => 'text',
                ],
                [
                    'key'           => 'field_toja_testimonials_tm_bewertung',
                    'label'         => __('Bewertung (Sterne)', 'toni-janis'),
                    'name'          => 'tm_bewertung',
                    'type'          => 'number',
                    'min'           => 1,
                    'max'           => 5,
                    'step'          => 1,
                    'default_value' => 5,
                ],
                [
                    'key'  => 'field_toja_testimonials_tm_text',
                    'label' => __('Bewertungstext', 'toni-janis'),
                    'name'  => 'tm_text',
                    'type'  => 'textarea',
                    'rows'  => 4,
                ],
                [
                    'key'          => 'field_toja_testimonials_tm_initialen',
                    'label'        => __('Initialen', 'toni-janis'),
                    'name'         => 'tm_initialen',
                    'type'         => 'text',
                    'maxlength'    => 2,
                    'instructions' => __('z.B. MK (max. 2 Zeichen)', 'toni-janis'),
                ],
            ],
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
