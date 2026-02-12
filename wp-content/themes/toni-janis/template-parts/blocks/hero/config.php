<?php
/**
 * Block: Hero
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Hero', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_hero_variante',
            'label'         => __('Variante', 'toni-janis'),
            'name'          => 'hero_variante',
            'type'          => 'select',
            'choices'       => [
                'standard'   => __('Standard (Zweispaltig)', 'toni-janis'),
                'fullscreen' => __('Fullscreen', 'toni-janis'),
            ],
            'default_value' => 'standard',
        ],
        [
            'key'   => 'field_toja_hero_badge',
            'label' => __('Badge-Text', 'toni-janis'),
            'name'  => 'hero_badge',
            'type'  => 'text',
            'instructions' => __('z.B. "Ihr Gartenspezialist in Delmenhorst"', 'toni-janis'),
        ],
        [
            'key'   => 'field_toja_hero_titel',
            'label' => __('Titel', 'toni-janis'),
            'name'  => 'hero_titel',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_toja_hero_highlight',
            'label'        => __('Hervorgehobener Text', 'toni-janis'),
            'name'         => 'hero_highlight',
            'type'         => 'text',
            'instructions' => __('Wird farbig hervorgehoben dargestellt', 'toni-janis'),
        ],
        [
            'key'   => 'field_toja_hero_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'hero_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'           => 'field_toja_hero_hintergrundbild',
            'label'         => __('Hintergrundbild', 'toni-janis'),
            'name'          => 'hero_hintergrundbild',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'instructions'  => __('Wird bei der Fullscreen-Variante als Hintergrund angezeigt', 'toni-janis'),
        ],
        [
            'key'               => 'field_toja_hero_bild',
            'label'             => __('Seitenbild', 'toni-janis'),
            'name'              => 'hero_bild',
            'type'              => 'image',
            'return_format'     => 'array',
            'preview_size'      => 'medium',
            'instructions'      => __('Nur bei der Standard-Variante sichtbar', 'toni-janis'),
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_toja_hero_variante',
                        'operator' => '==',
                        'value'    => 'standard',
                    ],
                ],
            ],
        ],
        [
            'key'           => 'field_toja_hero_button_primary',
            'label'         => __('Primärer Button', 'toni-janis'),
            'name'          => 'hero_button_primary',
            'type'          => 'link',
            'return_format' => 'array',
        ],
        [
            'key'           => 'field_toja_hero_button_secondary',
            'label'         => __('Sekundärer Button', 'toni-janis'),
            'name'          => 'hero_button_secondary',
            'type'          => 'link',
            'return_format' => 'array',
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
