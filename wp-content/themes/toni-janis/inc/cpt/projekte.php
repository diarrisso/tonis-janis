<?php
/**
 * CPT: toja_projekt (Projekte)
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Register Projekt CPT.
 */
function toja_register_cpt_projekt(): void {
    $labels = [
        'name'                  => __('Projekte', 'toni-janis'),
        'singular_name'         => __('Projekt', 'toni-janis'),
        'menu_name'             => __('Projekte', 'toni-janis'),
        'name_admin_bar'        => __('Projekt', 'toni-janis'),
        'add_new'               => __('Neues Projekt', 'toni-janis'),
        'add_new_item'          => __('Neues Projekt hinzufuegen', 'toni-janis'),
        'new_item'              => __('Neues Projekt', 'toni-janis'),
        'edit_item'             => __('Projekt bearbeiten', 'toni-janis'),
        'view_item'             => __('Projekt ansehen', 'toni-janis'),
        'all_items'             => __('Alle Projekte', 'toni-janis'),
        'search_items'          => __('Projekte durchsuchen', 'toni-janis'),
        'not_found'             => __('Keine Projekte gefunden', 'toni-janis'),
        'not_found_in_trash'    => __('Keine Projekte im Papierkorb', 'toni-janis'),
        'featured_image'        => __('Projektbild', 'toni-janis'),
        'set_featured_image'    => __('Projektbild festlegen', 'toni-janis'),
        'remove_featured_image' => __('Projektbild entfernen', 'toni-janis'),
        'use_featured_image'    => __('Als Projektbild verwenden', 'toni-janis'),
        'archives'              => __('Projekt-Archiv', 'toni-janis'),
    ];

    $args = [
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => false,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'menu_icon'    => 'dashicons-portfolio',
        'rewrite'      => ['slug' => 'projekte'],
        'menu_position' => 20,
    ];

    register_post_type('toja_projekt', $args);
}
add_action('init', 'toja_register_cpt_projekt');

/**
 * Register Projekt Kategorie taxonomy.
 */
function toja_register_tax_projekt_kategorie(): void {
    $labels = [
        'name'              => __('Projekt-Kategorien', 'toni-janis'),
        'singular_name'     => __('Projekt-Kategorie', 'toni-janis'),
        'menu_name'         => __('Kategorien', 'toni-janis'),
        'all_items'         => __('Alle Kategorien', 'toni-janis'),
        'edit_item'         => __('Kategorie bearbeiten', 'toni-janis'),
        'view_item'         => __('Kategorie ansehen', 'toni-janis'),
        'update_item'       => __('Kategorie aktualisieren', 'toni-janis'),
        'add_new_item'      => __('Neue Kategorie hinzufuegen', 'toni-janis'),
        'new_item_name'     => __('Neuer Kategoriename', 'toni-janis'),
        'search_items'      => __('Kategorien durchsuchen', 'toni-janis'),
        'not_found'         => __('Keine Kategorien gefunden', 'toni-janis'),
        'parent_item'       => __('Uebergeordnete Kategorie', 'toni-janis'),
        'parent_item_colon' => __('Uebergeordnete Kategorie:', 'toni-janis'),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => false,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'projekt-kategorie'],
    ];

    register_taxonomy('toja_projekt_kategorie', 'toja_projekt', $args);
}
add_action('init', 'toja_register_tax_projekt_kategorie');

/**
 * Insert default terms for Projekt Kategorie taxonomy.
 */
function toja_insert_default_projekt_kategorien(): void {
    $default_terms = [
        'Gartengestaltung',
        'Pflasterarbeiten',
        'Rollrasen',
        'Zaunbau',
        'Terrassen',
    ];

    foreach ($default_terms as $term) {
        if (!term_exists($term, 'toja_projekt_kategorie')) {
            wp_insert_term($term, 'toja_projekt_kategorie');
        }
    }
}
add_action('init', 'toja_insert_default_projekt_kategorien');

/**
 * Register ACF fields for Projekt CPT.
 */
function toja_register_acf_fields_projekt(): void {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_toja_projekt',
        'title'    => __('Projekt-Details', 'toni-janis'),
        'fields'   => [
            [
                'key'         => 'field_toja_cpt_projekt_standort',
                'label'       => __('Standort', 'toni-janis'),
                'name'        => 'projekt_standort',
                'type'        => 'text',
                'placeholder' => __('z.B. Delmenhorst', 'toni-janis'),
            ],
            [
                'key'         => 'field_toja_cpt_projekt_flaeche',
                'label'       => __('Flaeche', 'toni-janis'),
                'name'        => 'projekt_flaeche',
                'type'        => 'text',
                'placeholder' => __('z.B. 450 m2', 'toni-janis'),
            ],
            [
                'key'         => 'field_toja_cpt_projekt_dauer',
                'label'       => __('Dauer', 'toni-janis'),
                'name'        => 'projekt_dauer',
                'type'        => 'text',
                'placeholder' => __('z.B. 3 Wochen', 'toni-janis'),
            ],
            [
                'key'         => 'field_toja_cpt_projekt_badge',
                'label'       => __('Badge', 'toni-janis'),
                'name'        => 'projekt_badge',
                'type'        => 'text',
                'placeholder' => __('z.B. Abgeschlossen 2024', 'toni-janis'),
            ],
            [
                'key'           => 'field_toja_cpt_projekt_galerie',
                'label'         => __('Projekt-Galerie', 'toni-janis'),
                'name'          => 'projekt_galerie',
                'type'          => 'gallery',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'min'           => 0,
                'max'           => 20,
            ],
            [
                'key'          => 'field_toja_cpt_projekt_tags',
                'label'        => __('Tags', 'toni-janis'),
                'name'         => 'projekt_tags',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => __('Tag hinzufuegen', 'toni-janis'),
                'sub_fields'   => [
                    [
                        'key'   => 'field_toja_cpt_projekt_tag_name',
                        'label' => __('Tag', 'toni-janis'),
                        'name'  => 'tag_name',
                        'type'  => 'text',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'toja_projekt',
                ],
            ],
        ],
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);
}
add_action('acf/init', 'toja_register_acf_fields_projekt');
