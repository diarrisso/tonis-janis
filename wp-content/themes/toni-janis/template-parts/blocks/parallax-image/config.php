<?php
/**
 * Block: Parallax Bild
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Parallax Bild', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_parallax_bild',
            'label'         => __('Hintergrundbild', 'toni-janis'),
            'name'          => 'parallax_bild',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'required'      => 1,
        ],
        [
            'key'           => 'field_toja_parallax_hoehe',
            'label'         => __('Mindesthöhe', 'toni-janis'),
            'name'          => 'parallax_hoehe',
            'type'          => 'select',
            'choices'       => [
                'small'  => __('Klein (300px)', 'toni-janis'),
                'medium' => __('Mittel (450px)', 'toni-janis'),
                'large'  => __('Groß (600px)', 'toni-janis'),
                'full'   => __('Vollbild (100vh)', 'toni-janis'),
            ],
            'default_value' => 'medium',
        ],
        [
            'key'           => 'field_toja_parallax_overlay',
            'label'         => __('Overlay Stärke', 'toni-janis'),
            'name'          => 'parallax_overlay',
            'type'          => 'select',
            'choices'       => [
                'none'   => __('Kein Overlay', 'toni-janis'),
                'light'  => __('Leicht (30%)', 'toni-janis'),
                'medium' => __('Mittel (50%)', 'toni-janis'),
                'dark'   => __('Dunkel (70%)', 'toni-janis'),
            ],
            'default_value' => 'light',
        ],
        [
            'key'   => 'field_toja_parallax_heading',
            'label' => __('Überschrift (optional)', 'toni-janis'),
            'name'  => 'parallax_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_parallax_text',
            'label' => __('Untertitel (optional)', 'toni-janis'),
            'name'  => 'parallax_text',
            'type'  => 'text',
        ],
        toja_common_fields()['block_id'],
    ],
];
