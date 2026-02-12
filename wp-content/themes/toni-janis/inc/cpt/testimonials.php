<?php
/**
 * CPT: toja_testimonial (Kundenstimmen)
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Register Testimonial CPT.
 */
function toja_register_cpt_testimonial(): void {
    $labels = [
        'name'               => __('Kundenstimmen', 'toni-janis'),
        'singular_name'      => __('Kundenstimme', 'toni-janis'),
        'menu_name'          => __('Kundenstimmen', 'toni-janis'),
        'name_admin_bar'     => __('Kundenstimme', 'toni-janis'),
        'add_new'            => __('Neue Kundenstimme', 'toni-janis'),
        'add_new_item'       => __('Neue Kundenstimme hinzufuegen', 'toni-janis'),
        'new_item'           => __('Neue Kundenstimme', 'toni-janis'),
        'edit_item'          => __('Kundenstimme bearbeiten', 'toni-janis'),
        'view_item'          => __('Kundenstimme ansehen', 'toni-janis'),
        'all_items'          => __('Alle Kundenstimmen', 'toni-janis'),
        'search_items'       => __('Kundenstimmen durchsuchen', 'toni-janis'),
        'not_found'          => __('Keine Kundenstimmen gefunden', 'toni-janis'),
        'not_found_in_trash' => __('Keine Kundenstimmen im Papierkorb', 'toni-janis'),
    ];

    $args = [
        'labels'        => $labels,
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'show_in_rest'  => false,
        'supports'      => ['title'],
        'menu_icon'     => 'dashicons-format-quote',
        'menu_position' => 21,
    ];

    register_post_type('toja_testimonial', $args);
}
add_action('init', 'toja_register_cpt_testimonial');

/**
 * Register ACF fields for Testimonial CPT.
 */
function toja_register_acf_fields_testimonial(): void {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_toja_testimonial',
        'title'    => __('Kundenstimme-Details', 'toni-janis'),
        'fields'   => [
            [
                'key'           => 'field_toja_cpt_testimonial_bewertung',
                'label'         => __('Bewertung (Sterne)', 'toni-janis'),
                'name'          => 'testimonial_bewertung',
                'type'          => 'number',
                'min'           => 1,
                'max'           => 5,
                'step'          => 1,
                'default_value' => 5,
                'placeholder'   => '1-5',
            ],
            [
                'key'         => 'field_toja_cpt_testimonial_text',
                'label'       => __('Bewertungstext', 'toni-janis'),
                'name'        => 'testimonial_text',
                'type'        => 'textarea',
                'rows'        => 4,
                'placeholder' => __('Was sagt der Kunde?', 'toni-janis'),
            ],
            [
                'key'         => 'field_toja_cpt_testimonial_name',
                'label'       => __('Vollstaendiger Name', 'toni-janis'),
                'name'        => 'testimonial_name',
                'type'        => 'text',
                'placeholder' => __('z.B. Maria Klein', 'toni-janis'),
            ],
            [
                'key'         => 'field_toja_cpt_testimonial_ort',
                'label'       => __('Ort', 'toni-janis'),
                'name'        => 'testimonial_ort',
                'type'        => 'text',
                'placeholder' => __('z.B. Delmenhorst', 'toni-janis'),
            ],
            [
                'key'           => 'field_toja_cpt_testimonial_initialen',
                'label'         => __('Initialen', 'toni-janis'),
                'name'          => 'testimonial_initialen',
                'type'          => 'text',
                'placeholder'   => __('z.B. MK', 'toni-janis'),
                'instructions'  => __('Initialen fuer den Avatar (max. 2 Zeichen)', 'toni-janis'),
                'maxlength'     => 2,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'toja_testimonial',
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
add_action('acf/init', 'toja_register_acf_fields_testimonial');
