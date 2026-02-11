<?php
/**
 * Theme setup and configuration
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Theme setup
 */
function toja_setup() {
    // Translation support
    load_theme_textdomain('toni-janis', TOJA_DIR . '/languages');

    // Theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('editor-styles');
    add_theme_support('responsive-embeds');

    // Image sizes
    add_image_size('hero', 1920, 800, true);
    add_image_size('card', 600, 400, true);
    add_image_size('thumbnail-square', 300, 300, true);

    // Navigation menus
    register_nav_menus([
        'primary' => __('Hauptmenü', 'toni-janis'),
        'footer'  => __('Footer Menü', 'toni-janis'),
        'legal'   => __('Rechtliches Menü', 'toni-janis'),
    ]);
}
add_action('after_setup_theme', 'toja_setup');

/**
 * Enqueue scripts and styles
 */
function toja_enqueue_assets() {
    // Main stylesheet (TailwindCSS compiled)
    wp_enqueue_style(
        'toja-main',
        TOJA_URI . '/assets/dist/main.css',
        [],
        TOJA_VERSION
    );

    // SASS compiled styles
    $sass_file = TOJA_DIR . '/assets/src/scss/compiled/styles.css';
    if (file_exists($sass_file)) {
        wp_enqueue_style(
            'toja-sass',
            TOJA_URI . '/assets/src/scss/compiled/styles.css',
            ['toja-main'],
            TOJA_VERSION
        );
    }

    // Alpine.js
    wp_enqueue_script(
        'alpinejs',
        'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
        [],
        '3.14',
        ['strategy' => 'defer']
    );

    // Main JS bundle
    wp_enqueue_script(
        'toja-main',
        TOJA_URI . '/assets/dist/main.js',
        [],
        TOJA_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script('toja-main', 'tojaData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('toja_nonce'),
        'homeUrl' => home_url('/'),
    ]);
}
add_action('wp_enqueue_scripts', 'toja_enqueue_assets');

/**
 * Google Fonts preconnect
 */
function toja_preconnect_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600&display=swap">' . "\n";
}
add_action('wp_head', 'toja_preconnect_google_fonts', 1);

/**
 * Allow SVG uploads
 */
function toja_allow_svg_upload($mimes) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'toja_allow_svg_upload');

/**
 * Fix SVG MIME type detection
 */
function toja_fix_svg_mime_type($data, $file, $filename, $mimes) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext === 'svg' || $ext === 'svgz') {
        $data['type'] = 'image/svg+xml';
        $data['ext']  = $ext;
    }
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'toja_fix_svg_mime_type', 10, 4);

/**
 * Display SVG thumbnails in Media Library
 */
function toja_svg_media_thumbnails($response, $attachment, $meta) {
    if ($response['mime'] === 'image/svg+xml') {
        $svg_url = wp_get_attachment_url($attachment->ID);
        $response['image'] = ['src' => $svg_url, 'width' => 150, 'height' => 150];
        $response['thumb'] = ['src' => $svg_url];
        $response['sizes']['full'] = ['url' => $svg_url, 'width' => 150, 'height' => 150];
    }
    return $response;
}
add_filter('wp_prepare_attachment_for_js', 'toja_svg_media_thumbnails', 10, 3);

/**
 * Disable Gutenberg (use Classic Editor + ACF)
 */
function toja_disable_gutenberg($use_block_editor, $post_type) {
    return false;
}
add_filter('use_block_editor_for_post_type', 'toja_disable_gutenberg', 10, 2);

/**
 * ACF Options Pages registrieren
 */
function toja_add_options_pages() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    // Hauptseite - Theme Einstellungen
    acf_add_options_page([
        'page_title' => __('Theme Einstellungen', 'toni-janis'),
        'menu_title' => __('Theme Einstellungen', 'toni-janis'),
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-admin-customizer',
        'position'   => 2,
        'redirect'   => true,
    ]);

    // Unterseite - Header
    acf_add_options_sub_page([
        'page_title'  => __('Header Einstellungen', 'toni-janis'),
        'menu_title'  => __('Header', 'toni-janis'),
        'menu_slug'   => 'theme-header-settings',
        'parent_slug' => 'theme-general-settings',
        'capability'  => 'edit_posts',
    ]);

    // Unterseite - Footer
    acf_add_options_sub_page([
        'page_title'  => __('Footer Einstellungen', 'toni-janis'),
        'menu_title'  => __('Footer', 'toni-janis'),
        'menu_slug'   => 'theme-footer-settings',
        'parent_slug' => 'theme-general-settings',
        'capability'  => 'edit_posts',
    ]);
}
add_action('acf/init', 'toja_add_options_pages');
