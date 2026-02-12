<?php
/**
 * Block: Blog Tips (Gartentipps & Wissen)
 * Configuration and ACF field definitions.
 *
 * Pulls from native WordPress Posts.
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Blog / Gartentipps', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_blog_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'blog_label',
            'type'          => 'text',
            'default_value' => 'Gartentipps & Wissen',
        ],
        [
            'key'   => 'field_toja_blog_heading',
            'label' => __('Ueberschrift', 'toni-janis'),
            'name'  => 'blog_heading',
            'type'  => 'text',
        ],
        [
            'key'  => 'field_toja_blog_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'blog_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'           => 'field_toja_blog_anzahl',
            'label'         => __('Anzahl Beitraege', 'toni-janis'),
            'name'          => 'blog_anzahl',
            'type'          => 'number',
            'default_value' => 3,
            'min'           => 1,
            'max'           => 12,
            'step'          => 1,
            'instructions'  => __('Wie viele Beitraege sollen angezeigt werden?', 'toni-janis'),
        ],
        [
            'key'           => 'field_toja_blog_kategorie',
            'label'         => __('Kategorie filtern', 'toni-janis'),
            'name'          => 'blog_kategorie',
            'type'          => 'taxonomy',
            'taxonomy'      => 'category',
            'field_type'    => 'select',
            'allow_null'    => 1,
            'return_format' => 'id',
            'multiple'      => 0,
            'instructions'  => __('Optional: Nur Beitraege dieser Kategorie anzeigen', 'toni-janis'),
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
