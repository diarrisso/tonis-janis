<?php
/**
 * CPT: toja_stellenangebot (Stellenangebote)
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Register Stellenangebot CPT.
 */
function toja_register_cpt_stellenangebot(): void {
    $labels = [
        'name'                  => __('Stellenangebote', 'toni-janis'),
        'singular_name'         => __('Stellenangebot', 'toni-janis'),
        'menu_name'             => __('Stellenangebote', 'toni-janis'),
        'name_admin_bar'        => __('Stellenangebot', 'toni-janis'),
        'add_new'               => __('Neues Stellenangebot', 'toni-janis'),
        'add_new_item'          => __('Neues Stellenangebot hinzufuegen', 'toni-janis'),
        'new_item'              => __('Neues Stellenangebot', 'toni-janis'),
        'edit_item'             => __('Stellenangebot bearbeiten', 'toni-janis'),
        'view_item'             => __('Stellenangebot ansehen', 'toni-janis'),
        'all_items'             => __('Alle Stellenangebote', 'toni-janis'),
        'search_items'          => __('Stellenangebote durchsuchen', 'toni-janis'),
        'not_found'             => __('Keine Stellenangebote gefunden', 'toni-janis'),
        'not_found_in_trash'    => __('Keine Stellenangebote im Papierkorb', 'toni-janis'),
        'featured_image'        => __('Stellenbild', 'toni-janis'),
        'set_featured_image'    => __('Stellenbild festlegen', 'toni-janis'),
        'remove_featured_image' => __('Stellenbild entfernen', 'toni-janis'),
        'use_featured_image'    => __('Als Stellenbild verwenden', 'toni-janis'),
        'archives'              => __('Stellen-Archiv', 'toni-janis'),
    ];

    $args = [
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'show_in_rest'  => false,
        'supports'      => ['title', 'editor', 'thumbnail'],
        'menu_icon'     => 'dashicons-businessperson',
        'rewrite'       => ['slug' => 'karriere'],
        'menu_position' => 23,
    ];

    register_post_type('toja_stellenangebot', $args);
}
add_action('init', 'toja_register_cpt_stellenangebot');

/**
 * Register ACF fields for Stellenangebot CPT.
 */
function toja_register_acf_fields_stellenangebot(): void {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_toja_stellenangebot',
        'title'    => __('Stellenangebot-Details', 'toni-janis'),
        'fields'   => [
            [
                'key'           => 'field_toja_cpt_job_typ',
                'label'         => __('Beschaeftigungsart', 'toni-janis'),
                'name'          => 'job_typ',
                'type'          => 'select',
                'choices'       => [
                    'Vollzeit'   => __('Vollzeit', 'toni-janis'),
                    'Teilzeit'   => __('Teilzeit', 'toni-janis'),
                    'Minijob'    => __('Minijob', 'toni-janis'),
                    'Ausbildung' => __('Ausbildung', 'toni-janis'),
                ],
                'default_value' => 'Vollzeit',
                'allow_null'    => false,
                'return_format' => 'value',
            ],
            [
                'key'           => 'field_toja_cpt_job_verfuegbarkeit',
                'label'         => __('Verfuegbarkeit', 'toni-janis'),
                'name'          => 'job_verfuegbarkeit',
                'type'          => 'text',
                'default_value' => __('Ab sofort', 'toni-janis'),
                'placeholder'   => __('z.B. Ab sofort, Ab 01.03.2025', 'toni-janis'),
            ],
            [
                'key'          => 'field_toja_cpt_job_aufgaben',
                'label'        => __('Aufgaben', 'toni-janis'),
                'name'         => 'job_aufgaben',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => __('Aufgabe hinzufuegen', 'toni-janis'),
                'sub_fields'   => [
                    [
                        'key'   => 'field_toja_cpt_job_aufgabe',
                        'label' => __('Aufgabe', 'toni-janis'),
                        'name'  => 'aufgabe',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'          => 'field_toja_cpt_job_anforderungen',
                'label'        => __('Anforderungen', 'toni-janis'),
                'name'         => 'job_anforderungen',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => __('Anforderung hinzufuegen', 'toni-janis'),
                'sub_fields'   => [
                    [
                        'key'   => 'field_toja_cpt_job_anforderung',
                        'label' => __('Anforderung', 'toni-janis'),
                        'name'  => 'anforderung',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'          => 'field_toja_cpt_job_angebot',
                'label'        => __('Wir bieten', 'toni-janis'),
                'name'         => 'job_angebot',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => __('Angebot hinzufuegen', 'toni-janis'),
                'sub_fields'   => [
                    [
                        'key'   => 'field_toja_cpt_job_angebot_item',
                        'label' => __('Angebot', 'toni-janis'),
                        'name'  => 'angebot_item',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'           => 'field_toja_cpt_job_email',
                'label'         => __('Bewerbungs-E-Mail', 'toni-janis'),
                'name'          => 'job_email',
                'type'          => 'email',
                'default_value' => '',
                'placeholder'   => 'bewerbung@beispiel.de',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'toja_stellenangebot',
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
add_action('acf/init', 'toja_register_acf_fields_stellenangebot');
