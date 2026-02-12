<?php
/**
 * Block: Parallax Bild
 *
 * Full-width parallax background image divider between content sections.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

$bild     = get_sub_field('parallax_bild');
$hoehe    = get_sub_field('parallax_hoehe') ?: 'medium';
$overlay  = get_sub_field('parallax_overlay') ?: 'light';
$heading  = get_sub_field('parallax_heading');
$text     = get_sub_field('parallax_text');
$block_id = toja_block_id('parallax-image');

if (empty($bild)) return;

$bg_url = $bild['url'] ?? '';
if (!$bg_url) return;

$height_classes = [
    'small'  => 'min-h-[300px]',
    'medium' => 'min-h-[450px]',
    'large'  => 'min-h-[600px]',
    'full'   => 'min-h-screen',
];

$overlay_classes = [
    'none'   => '',
    'light'  => 'bg-black/30',
    'medium' => 'bg-black/50',
    'dark'   => 'bg-black/70',
];
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('parallax-image', ['relative flex items-center justify-center overflow-hidden'])); ?> <?php echo esc_attr($height_classes[$hoehe] ?? $height_classes['medium']); ?>"
    style="background-image: url('<?php echo esc_url($bg_url); ?>'); background-attachment: fixed; background-position: center; background-size: cover;"
>
    <?php if ($overlay !== 'none') : ?>
        <div class="absolute inset-0 <?php echo esc_attr($overlay_classes[$overlay] ?? ''); ?>"></div>
    <?php endif; ?>

    <?php if ($heading || $text) : ?>
        <div class="relative z-10 text-center px-4">
            <?php if ($heading) : ?>
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
                    <?php echo esc_html($text); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
