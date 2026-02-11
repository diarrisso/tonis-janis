<?php
/**
 * Component: Image
 *
 * @param array|int $image   - ACF image array or attachment ID
 * @param string    $size    - Image size
 * @param string    $class   - Additional CSS classes
 * @param bool      $lazy    - Lazy loading (default true)
 * @param string    $aspect  - Aspect ratio class (e.g., aspect-video, aspect-square)
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

$size   = $size ?? 'large';
$class  = $class ?? '';
$lazy   = $lazy ?? true;
$aspect = $aspect ?? '';

if (empty($image)) return;

$wrapper_class = toja_classes('overflow-hidden rounded-lg', $aspect);
?>

<div class="<?php echo esc_attr($wrapper_class); ?>">
    <?php toja_image($image, $size, [
        'class'   => toja_classes('w-full h-full object-cover', $class),
        'loading' => $lazy ? 'lazy' : 'eager',
    ]); ?>
</div>
