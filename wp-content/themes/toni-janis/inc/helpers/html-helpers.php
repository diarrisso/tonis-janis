<?php
/**
 * HTML Helper Functions
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Render a responsive image with lazy loading
 */
function toja_image($image, $size = 'large', $attrs = []) {
    if (empty($image)) return;

    $defaults = [
        'class'   => '',
        'loading' => 'lazy',
        'alt'     => '',
    ];
    $attrs = wp_parse_args($attrs, $defaults);

    if (is_array($image)) {
        $id = $image['ID'] ?? 0;
        $alt = $attrs['alt'] ?: ($image['alt'] ?? '');
    } else {
        $id = (int) $image;
        $alt = $attrs['alt'] ?: get_post_meta($id, '_wp_attachment_image_alt', true);
    }

    if (!$id) return;

    echo wp_get_attachment_image($id, $size, false, [
        'class'   => $attrs['class'],
        'loading' => $attrs['loading'],
        'alt'     => $alt,
    ]);
}

/**
 * Render a link/button
 */
function toja_button($link, $class = 'btn-primary', $attrs = []) {
    if (empty($link)) return;

    $url    = $link['url'] ?? '#';
    $title  = $link['title'] ?? '';
    $target = $link['target'] ?? '';

    $extra = '';
    foreach ($attrs as $key => $val) {
        $extra .= ' ' . esc_attr($key) . '="' . esc_attr($val) . '"';
    }

    printf(
        '<a href="%s" class="%s"%s%s>%s</a>',
        esc_url($url),
        esc_attr($class),
        $target ? ' target="' . esc_attr($target) . '" rel="noopener noreferrer"' : '',
        $extra,
        esc_html($title)
    );
}

/**
 * Output inline SVG from file
 */
function toja_svg($filename, $class = '') {
    $path = TOJA_DIR . '/assets/svg/' . $filename . '.svg';

    if (!file_exists($path)) return;

    $svg = file_get_contents($path);

    if ($class) {
        $svg = str_replace('<svg', '<svg class="' . esc_attr($class) . '"', $svg);
    }

    echo $svg;
}
