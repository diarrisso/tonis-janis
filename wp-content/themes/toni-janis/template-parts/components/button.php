<?php
/**
 * Component: Button
 *
 * @param array  $link    - ACF link array (url, title, target)
 * @param string $variant - Button variant (primary, secondary, outline)
 * @param string $class   - Additional CSS classes
 * @param string $size    - Button size (sm, md, lg)
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

$variant = $variant ?? 'primary';
$class   = $class ?? '';
$size    = $size ?? 'md';

if (empty($link)) return;

$url    = $link['url'] ?? '#';
$title  = $link['title'] ?? '';
$target = $link['target'] ?? '';

$variants = [
    'primary'   => 'bg-kiwi-green text-white hover:bg-kiwi-dark',
    'secondary' => 'bg-earth-brown text-white hover:bg-earth-brown/90',
    'outline'   => 'border-2 border-kiwi-green text-kiwi-green hover:bg-kiwi-green hover:text-white',
];

$sizes = [
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
];

$btn_class = toja_classes(
    'inline-flex items-center justify-center font-semibold rounded-full transition-all duration-300',
    $variants[$variant] ?? $variants['primary'],
    $sizes[$size] ?? $sizes['md'],
    $class
);
?>

<a href="<?php echo esc_url($url); ?>" class="<?php echo esc_attr($btn_class); ?>"<?php echo $target ? ' target="' . esc_attr($target) . '" rel="noopener noreferrer"' : ''; ?>>
    <?php echo esc_html($title); ?>
</a>
