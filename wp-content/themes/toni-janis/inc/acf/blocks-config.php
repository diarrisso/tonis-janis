<?php
/**
 * ACF Blocks Configuration
 *
 * Central registry for block-specific configuration.
 * Individual blocks are configured via their config.php files.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Common ACF field definitions reusable across blocks
 */
function toja_common_fields() {
    return [
        'heading' => [
            'key'   => 'field_common_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'heading',
            'type'  => 'text',
        ],
        'subheading' => [
            'key'   => 'field_common_subheading',
            'label' => __('Unterüberschrift', 'toni-janis'),
            'name'  => 'subheading',
            'type'  => 'text',
        ],
        'text' => [
            'key'   => 'field_common_text',
            'label' => __('Text', 'toni-janis'),
            'name'  => 'text',
            'type'  => 'wysiwyg',
            'toolbar' => 'basic',
            'media_upload' => 0,
        ],
        'image' => [
            'key'           => 'field_common_image',
            'label'         => __('Bild', 'toni-janis'),
            'name'          => 'image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
        ],
        'button' => [
            'key'           => 'field_common_button',
            'label'         => __('Button', 'toni-janis'),
            'name'          => 'button',
            'type'          => 'link',
            'return_format' => 'array',
        ],
        'background_variant' => [
            'key'     => 'field_common_bg_variant',
            'label'   => __('Hintergrund', 'toni-janis'),
            'name'    => 'background_variant',
            'type'    => 'select',
            'choices' => [
                'white' => __('Weiß', 'toni-janis'),
                'cream' => __('Creme', 'toni-janis'),
                'green' => __('Grün', 'toni-janis'),
                'brown' => __('Braun', 'toni-janis'),
            ],
            'default_value' => 'white',
        ],
        'block_spacing' => [
            'key'     => 'field_common_spacing',
            'label'   => __('Abstand', 'toni-janis'),
            'name'    => 'block_spacing',
            'type'    => 'select',
            'choices' => [
                'none'   => __('Kein', 'toni-janis'),
                'small'  => __('Klein', 'toni-janis'),
                'medium' => __('Mittel', 'toni-janis'),
                'large'  => __('Groß', 'toni-janis'),
            ],
            'default_value' => 'medium',
        ],
        'block_id' => [
            'key'   => 'field_common_block_id',
            'label' => __('Block ID (optional)', 'toni-janis'),
            'name'  => 'block_id',
            'type'  => 'text',
            'instructions' => __('Optionale ID für Ankerlinks', 'toni-janis'),
        ],
    ];
}
