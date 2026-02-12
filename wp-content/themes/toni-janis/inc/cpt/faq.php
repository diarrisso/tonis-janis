<?php
/**
 * CPT: toja_faq (FAQs)
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Register FAQ CPT.
 *
 * Title = Frage (Question), Editor = Antwort (Answer via the_content()).
 */
function toja_register_cpt_faq(): void {
    $labels = [
        'name'               => __('FAQs', 'toni-janis'),
        'singular_name'      => __('FAQ', 'toni-janis'),
        'menu_name'          => __('FAQs', 'toni-janis'),
        'name_admin_bar'     => __('FAQ', 'toni-janis'),
        'add_new'            => __('Neue FAQ', 'toni-janis'),
        'add_new_item'       => __('Neue FAQ hinzufuegen', 'toni-janis'),
        'new_item'           => __('Neue FAQ', 'toni-janis'),
        'edit_item'          => __('FAQ bearbeiten', 'toni-janis'),
        'view_item'          => __('FAQ ansehen', 'toni-janis'),
        'all_items'          => __('Alle FAQs', 'toni-janis'),
        'search_items'       => __('FAQs durchsuchen', 'toni-janis'),
        'not_found'          => __('Keine FAQs gefunden', 'toni-janis'),
        'not_found_in_trash' => __('Keine FAQs im Papierkorb', 'toni-janis'),
    ];

    $args = [
        'labels'        => $labels,
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'show_in_rest'  => false,
        'supports'      => ['title', 'editor'],
        'menu_icon'     => 'dashicons-editor-help',
        'menu_position' => 22,
    ];

    register_post_type('toja_faq', $args);
}
add_action('init', 'toja_register_cpt_faq');

/**
 * Register ACF fields for FAQ CPT.
 */
function toja_register_acf_fields_faq(): void {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_toja_faq',
        'title'    => __('FAQ-Einstellungen', 'toni-janis'),
        'fields'   => [
            [
                'key'           => 'field_toja_cpt_faq_reihenfolge',
                'label'         => __('Reihenfolge', 'toni-janis'),
                'name'          => 'faq_reihenfolge',
                'type'          => 'number',
                'default_value' => 0,
                'min'           => 0,
                'step'          => 1,
                'instructions'  => __('Sortierreihenfolge (niedrigere Zahl = weiter oben)', 'toni-janis'),
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'toja_faq',
                ],
            ],
        ],
        'position'              => 'side',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);
}
add_action('acf/init', 'toja_register_acf_fields_faq');
