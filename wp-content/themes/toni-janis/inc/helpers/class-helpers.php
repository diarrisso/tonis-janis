<?php
/**
 * CSS Class Helper Functions
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Build a class string from an array, filtering empty values
 */
function toja_classes(...$classes) {
    $result = [];
    foreach ($classes as $class) {
        if (is_array($class)) {
            foreach ($class as $key => $value) {
                if (is_string($key) && $value) {
                    $result[] = $key;
                } elseif (is_int($key) && $value) {
                    $result[] = $value;
                }
            }
        } elseif (is_string($class) && $class !== '') {
            $result[] = $class;
        }
    }
    return implode(' ', array_unique(array_filter($result)));
}

/**
 * Get background class based on variant
 */
function toja_bg_class($variant = 'white') {
    $map = [
        'white' => 'bg-white',
        'cream' => 'bg-cream',
        'green' => 'bg-kiwi-green text-white',
        'brown' => 'bg-earth-brown text-white',
    ];
    return $map[$variant] ?? $map['white'];
}

/**
 * Get spacing classes based on size
 */
function toja_spacing_class($size = 'medium') {
    $map = [
        'none'   => 'py-0',
        'small'  => 'py-8 md:py-12',
        'medium' => 'py-12 md:py-20',
        'large'  => 'py-20 md:py-32',
    ];
    return $map[$size] ?? $map['medium'];
}
