<?php
/**
 * Block: Projects (Projekte)
 * Configuration and ACF field definitions.
 *
 * Pulls from CPT: toja_projekt
 * Taxonomy: toja_projekt_kategorie
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Projekte', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_projects_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'projects_label',
            'type'          => 'text',
            'default_value' => 'Unsere Projekte',
        ],
        [
            'key'   => 'field_toja_projects_heading',
            'label' => __('Ueberschrift', 'toni-janis'),
            'name'  => 'projects_heading',
            'type'  => 'text',
        ],
        [
            'key'  => 'field_toja_projects_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'projects_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'           => 'field_toja_projects_anzahl',
            'label'         => __('Anzahl Projekte', 'toni-janis'),
            'name'          => 'projects_anzahl',
            'type'          => 'number',
            'default_value' => 6,
            'min'           => 1,
            'max'           => 24,
            'step'          => 1,
            'instructions'  => __('Wie viele Projekte sollen angezeigt werden?', 'toni-janis'),
        ],
        [
            'key'           => 'field_toja_projects_filter',
            'label'         => __('Kategoriefilter anzeigen', 'toni-janis'),
            'name'          => 'projects_filter',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => __('Filter-Buttons fuer Kategorien anzeigen?', 'toni-janis'),
        ],
        [
            'key'           => 'field_toja_projects_kategorien',
            'label'         => __('Kategorien filtern', 'toni-janis'),
            'name'          => 'projects_kategorien',
            'type'          => 'taxonomy',
            'taxonomy'      => 'toja_projekt_kategorie',
            'field_type'    => 'multi_select',
            'allow_null'    => 1,
            'return_format' => 'id',
            'multiple'      => 1,
            'instructions'  => __('Optional: Nur Projekte dieser Kategorien anzeigen (leer = alle)', 'toni-janis'),
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
