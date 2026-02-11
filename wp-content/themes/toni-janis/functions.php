<?php
/**
 * Theme functions and definitions
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Theme constants
define('TOJA_VERSION', '1.0.0');
define('TOJA_DIR', get_template_directory());
define('TOJA_URI', get_template_directory_uri());

// Theme setup
require_once TOJA_DIR . '/inc/setup.php';

// Helper functions
require_once TOJA_DIR . '/inc/helpers/html-helpers.php';
require_once TOJA_DIR . '/inc/helpers/class-helpers.php';
require_once TOJA_DIR . '/inc/helpers/data-helpers.php';

// ACF configuration
if (class_exists('ACF')) {
    require_once TOJA_DIR . '/inc/acf/block-utils.php';
    require_once TOJA_DIR . '/inc/acf/field-groups.php';
    require_once TOJA_DIR . '/inc/acf/blocks-config.php';
    require_once TOJA_DIR . '/inc/acf-fields/theme-options.php';
}
