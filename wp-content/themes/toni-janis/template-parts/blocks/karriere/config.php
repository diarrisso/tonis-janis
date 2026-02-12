<?php
/**
 * Block: Karriere (Stellenangebote)
 * Configuration and ACF field definitions.
 *
 * Pulls from CPT: toja_stellenangebot
 *
 * @package ToniJanis
 */

return [
    'label'   => __('Karriere', 'toni-janis'),
    'display' => 'block',
    'fields'  => [
        [
            'key'           => 'field_toja_karriere_label',
            'label'         => __('Label', 'toni-janis'),
            'name'          => 'karriere_label',
            'type'          => 'text',
            'default_value' => 'Karriere',
        ],
        [
            'key'   => 'field_toja_karriere_heading',
            'label' => __('Ueberschrift', 'toni-janis'),
            'name'  => 'karriere_heading',
            'type'  => 'text',
        ],
        [
            'key'  => 'field_toja_karriere_text',
            'label' => __('Beschreibung', 'toni-janis'),
            'name'  => 'karriere_text',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        toja_common_fields()['background_variant'],
        toja_common_fields()['block_spacing'],
        toja_common_fields()['block_id'],
    ],
];
