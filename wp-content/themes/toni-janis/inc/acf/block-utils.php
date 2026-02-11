<?php
/**
 * ACF Block Utilities
 *
 * Shared functions for rendering ACF flexible content blocks.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Check if current page uses ACF flexible content
 */
function toja_is_flexible_content_page() {
    return function_exists('have_rows') && have_rows('flexible_content');
}

/**
 * Render all flexible content blocks
 */
function toja_render_flexible_content($field_name = 'flexible_content') {
    if (!function_exists('have_rows') || !have_rows($field_name)) {
        return;
    }

    while (have_rows($field_name)) : the_row();
        $layout = get_row_layout();
        $template = TOJA_DIR . '/template-parts/blocks/' . $layout . '/' . $layout . '.php';

        if (file_exists($template)) {
            include $template;
        }
    endwhile;
}

/**
 * Get block classes with optional additional classes
 */
function toja_block_classes($block_name, $additional = []) {
    $classes = ['toja-block', 'toja-block--' . $block_name];

    // Background variant
    $bg = get_sub_field('background_variant');
    if ($bg) {
        $classes[] = 'toja-block--bg-' . $bg;
    }

    // Spacing
    $spacing = get_sub_field('block_spacing');
    if ($spacing) {
        $classes[] = 'toja-block--spacing-' . $spacing;
    }

    $classes = array_merge($classes, (array) $additional);

    return implode(' ', array_filter($classes));
}

/**
 * Get block ID from ACF field or generate one
 */
function toja_block_id($block_name) {
    $custom_id = get_sub_field('block_id');
    return $custom_id ?: $block_name . '-' . uniqid();
}

/**
 * Render a component from template-parts/components/
 */
function toja_component($name, $args = []) {
    $template = TOJA_DIR . '/template-parts/components/' . $name . '.php';

    if (file_exists($template)) {
        extract($args, EXTR_SKIP);
        include $template;
    }
}

/**
 * Auto-discover and register blocks from blocks directory
 */
function toja_auto_discover_blocks() {
    $blocks_dir = TOJA_DIR . '/template-parts/blocks/';

    if (!is_dir($blocks_dir)) {
        return [];
    }

    $blocks = [];
    $dirs = glob($blocks_dir . '*', GLOB_ONLYDIR);

    foreach ($dirs as $dir) {
        $block_name = basename($dir);

        // Skip template directory
        if ($block_name === '_block-template') {
            continue;
        }

        $config_file = $dir . '/config.php';
        if (file_exists($config_file)) {
            $config = include $config_file;
            if (is_array($config)) {
                $blocks[$block_name] = $config;
            }
        }
    }

    return $blocks;
}
