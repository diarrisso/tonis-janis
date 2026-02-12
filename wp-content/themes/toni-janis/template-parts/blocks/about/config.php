<?php
/**
 * Block: About (Über uns)
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Über uns', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_about_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'about_label',
            'type'          => 'text',
            'default_value' => 'Über uns',
        ],
        [
            'key'   => 'field_toja_about_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'about_heading',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_toja_about_texte',
            'label'        => __('Text', 'toni-janis'),
            'name'         => 'about_texte',
            'type'         => 'wysiwyg',
            'toolbar'      => 'basic',
            'media_upload' => 0,
        ],
        [
            'key'           => 'field_toja_about_bild',
            'label'         => __('Bild', 'toni-janis'),
            'name'          => 'about_bild',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
        ],
        [
            'key'           => 'field_toja_about_erfahrung_zahl',
            'label'         => __('Erfahrung Zahl', 'toni-janis'),
            'name'          => 'about_erfahrung_zahl',
            'type'          => 'text',
            'default_value' => '10+',
            'instructions'  => __('z.B. "10+"', 'toni-janis'),
        ],
        [
            'key'           => 'field_toja_about_erfahrung_text',
            'label'         => __('Erfahrung Text', 'toni-janis'),
            'name'          => 'about_erfahrung_text',
            'type'          => 'text',
            'default_value' => 'Jahre Erfahrung',
        ],
        [
            'key'          => 'field_toja_about_features',
            'label'        => __('Features', 'toni-janis'),
            'name'         => 'about_features',
            'type'         => 'repeater',
            'layout'       => 'table',
            'button_label' => __('Feature hinzufügen', 'toni-janis'),
            'sub_fields'   => [
                [
                    'key'           => 'field_toja_about_feature_icon',
                    'label'         => __('Icon', 'toni-janis'),
                    'name'          => 'feature_icon',
                    'type'          => 'text',
                    'default_value' => '✓',
                ],
                [
                    'key'   => 'field_toja_about_feature_text',
                    'label' => __('Text', 'toni-janis'),
                    'name'  => 'feature_text',
                    'type'  => 'text',
                ],
            ],
        ],
        [
            'key'           => 'field_toja_about_button',
            'label'         => __('Button', 'toni-janis'),
            'name'          => 'about_button',
            'type'          => 'link',
            'return_format' => 'array',
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
