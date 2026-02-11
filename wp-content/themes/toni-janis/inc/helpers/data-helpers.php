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
function toja_whatsapp_link($number = '4917634326549', $message = '') {
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
        'company' => 'Toni Janis Garten- und Landschaftsbau',
        'address' => 'Düsternort Str. 104, 27755 Delmenhorst',
        'phone1'  => '0176 343 26549',
        'phone2'  => '0176 878 29995',
        'email'   => 'toni-janis@hotmail.com',
        'whatsapp' => 'https://wa.me/4917634326549',
    ];
}
