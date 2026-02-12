<?php
/**
 * Block: Video
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Video', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_video_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'video_label',
            'type'          => 'text',
            'default_value' => 'Videos',
        ],
        [
            'key'   => 'field_toja_video_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'video_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_video_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'video_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_toja_video_url',
            'label'        => __('YouTube URL', 'toni-janis'),
            'name'         => 'video_url',
            'type'         => 'url',
            'instructions' => __('Vollständige YouTube-URL (z.B. https://www.youtube.com/watch?v=XXXXX)', 'toni-janis'),
        ],
        [
            'key'           => 'field_toja_video_vorschaubild',
            'label'         => __('Vorschaubild (optional)', 'toni-janis'),
            'name'          => 'video_vorschaubild',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'instructions'  => __('Eigenes Vorschaubild. Wenn leer, wird das YouTube-Thumbnail verwendet.', 'toni-janis'),
        ],
        [
            'key'          => 'field_toja_video_features',
            'label'        => __('Features', 'toni-janis'),
            'name'         => 'video_features',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => __('Feature hinzufügen', 'toni-janis'),
            'sub_fields'   => [
                [
                    'key'          => 'field_toja_video_feature_icon',
                    'label'        => __('Icon (SVG-Code)', 'toni-janis'),
                    'name'         => 'feature_icon',
                    'type'         => 'textarea',
                    'rows'         => 3,
                    'instructions' => __('SVG-Code für das Icon', 'toni-janis'),
                ],
                [
                    'key'   => 'field_toja_video_feature_titel',
                    'label' => __('Titel', 'toni-janis'),
                    'name'  => 'feature_titel',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_toja_video_feature_text',
                    'label' => __('Text', 'toni-janis'),
                    'name'  => 'feature_text',
                    'type'  => 'textarea',
                    'rows'  => 2,
                ],
            ],
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
