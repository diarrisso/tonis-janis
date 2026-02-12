<?php
/**
 * Block: Galerie
 * Configuration and ACF field definitions.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Galerie', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_gallery_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'gallery_label',
            'type'          => 'text',
            'default_value' => 'Galerie',
        ],
        [
            'key'   => 'field_toja_gallery_heading',
            'label' => __('Überschrift', 'toni-janis'),
            'name'  => 'gallery_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_toja_gallery_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'gallery_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'           => 'field_toja_gallery_bilder',
            'label'         => __('Bilder', 'toni-janis'),
            'name'          => 'gallery_bilder',
            'type'          => 'gallery',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'insert'        => 'append',
            'library'       => 'all',
            'min'           => 1,
            'instructions'  => __('Bilder für die Galerie hochladen. Alt-Text oder Bildunterschrift wird als Label angezeigt.', 'toni-janis'),
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
