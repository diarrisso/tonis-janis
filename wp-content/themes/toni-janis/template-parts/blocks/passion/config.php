<?php
/**
 * Block: Passion (Meine Leidenschaft)
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Leidenschaft', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_passion_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'passion_label',
            'type'          => 'text',
            'default_value' => 'Meine Leidenschaft',
        ],
        [
            'key'   => 'field_toja_passion_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'passion_heading',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_toja_passion_zitat',
            'label'        => __('Zitat', 'toni-janis'),
            'name'         => 'passion_zitat',
            'type'         => 'textarea',
            'rows'         => 3,
            'instructions' => __('Ein inspirierendes Zitat', 'toni-janis'),
        ],
        [
            'key'          => 'field_toja_passion_texte',
            'label'        => __('Text', 'toni-janis'),
            'name'         => 'passion_texte',
            'type'         => 'wysiwyg',
            'toolbar'      => 'basic',
            'media_upload' => 0,
        ],
        [
            'key'          => 'field_toja_passion_statistiken',
            'label'        => __('Statistiken', 'toni-janis'),
            'name'         => 'passion_statistiken',
            'type'         => 'repeater',
            'layout'       => 'table',
            'button_label' => __('Statistik hinzufügen', 'toni-janis'),
            'sub_fields'   => [
                [
                    'key'          => 'field_toja_passion_stat_zahl',
                    'label'        => __('Zahl', 'toni-janis'),
                    'name'         => 'stat_zahl',
                    'type'         => 'text',
                    'instructions' => __('z.B. "500+"', 'toni-janis'),
                ],
                [
                    'key'          => 'field_toja_passion_stat_label',
                    'label'        => __('Bezeichnung', 'toni-janis'),
                    'name'         => 'stat_label',
                    'type'         => 'text',
                    'instructions' => __('z.B. "Abgeschlossene Projekte"', 'toni-janis'),
                ],
            ],
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
