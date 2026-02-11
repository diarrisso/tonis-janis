<?php
/**
 * Component: Background Section Wrapper
 *
 * @param string $variant  - Background variant (white, cream, green, brown)
 * @param string $spacing  - Spacing size (none, small, medium, large)
 * @param string $class    - Additional CSS classes
 * @param string $id       - Section ID for anchor links
 *
 * Usage: Include this at the start and end of a block section.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

$variant = $variant ?? 'white';
$spacing = $spacing ?? 'medium';
$class   = $class ?? '';
$id      = $id ?? '';

$section_class = toja_classes(
    toja_bg_class($variant),
    toja_spacing_class($spacing),
    $class
);
?>

<section<?php echo $id ? ' id="' . esc_attr($id) . '"' : ''; ?> class="<?php echo esc_attr($section_class); ?>">
    <div class="container mx-auto px-4">
