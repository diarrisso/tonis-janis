<?php
/**
 * ACF Field Groups Registration
 *
 * Register field groups programmatically.
 * Blocks are auto-discovered from template-parts/blocks/
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Register flexible content field group for pages
 */
function toja_register_flexible_content() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Auto-discover block layouts
    $blocks = toja_auto_discover_blocks();
    $layouts = [];

    foreach ($blocks as $name => $config) {
        if (isset($config['fields'])) {
            $layouts[$name] = [
                'key'        => 'layout_' . $name,
                'name'       => $name,
                'label'      => $config['label'] ?? ucfirst(str_replace('-', ' ', $name)),
                'display'    => $config['display'] ?? 'block',
                'sub_fields' => $config['fields'],
            ];
        }
    }

    if (empty($layouts)) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_flexible_content',
        'title'    => __('Seiteninhalt', 'toni-janis'),
        'fields'   => [
            [
                'key'        => 'field_flexible_content',
                'label'      => __('Inhaltsblöcke', 'toni-janis'),
                'name'       => 'flexible_content',
                'type'       => 'flexible_content',
                'layouts'    => $layouts,
                'button_label' => __('Block hinzufügen', 'toni-janis'),
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'page'],
            ],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'seamless',
    ]);
}
add_action('acf/init', 'toja_register_flexible_content');
