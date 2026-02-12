<?php
/**
 * Data Helper Functions
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Get theme option from ACF options page
 */
function toja_option($field, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($field, 'option');
    return $value !== null && $value !== '' ? $value : $default;
}

/**
 * Get phone number formatted for href
 */
function toja_phone_href($number) {
    return 'tel:' . preg_replace('/[^+\d]/', '', $number);
}

/**
 * Get WhatsApp link
 */
function toja_whatsapp_link($number = '', $message = '') {
    $url = 'https://wa.me/' . $number;
    if ($message) {
        $url .= '?text=' . rawurlencode($message);
    }
    return $url;
}

/**
 * Truncate text to a given length
 */
function toja_truncate($text, $length = 150, $suffix = '...') {
    $text = wp_strip_all_tags($text);
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . $suffix;
}

/**
 * Get business contact info
 */
function toja_contact_info() {
    return [
        'company'  => toja_option('footer_company', ''),
        'address'  => toja_option('footer_address', ''),
        'phone1'   => toja_option('footer_phone', ''),
        'phone2'   => toja_option('footer_phone2', ''),
        'email'    => toja_option('footer_email', ''),
        'whatsapp' => toja_whatsapp_link(toja_option('footer_whatsapp', '')),
    ];
}
