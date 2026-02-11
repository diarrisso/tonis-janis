<?php
/**
 * Component: Heading
 *
 * @param string $text     - Heading text
 * @param string $tag      - HTML tag (h1-h6), default h2
 * @param string $class    - Additional CSS classes
 * @param string $subtext  - Optional subheading text
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

$tag     = $tag ?? 'h2';
$class   = $class ?? '';
$subtext = $subtext ?? '';

if (empty($text)) return;

$base_class = 'font-heading font-bold text-earth-brown';
?>

<div class="heading-group mb-6">
    <<?php echo esc_attr($tag); ?> class="<?php echo esc_attr(toja_classes($base_class, $class)); ?>">
        <?php echo esc_html($text); ?>
    </<?php echo esc_attr($tag); ?>>

    <?php if ($subtext) : ?>
        <p class="mt-2 text-lg text-gray-600"><?php echo esc_html($subtext); ?></p>
    <?php endif; ?>
</div>
