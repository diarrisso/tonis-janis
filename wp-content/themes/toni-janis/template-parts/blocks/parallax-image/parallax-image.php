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

// Height mapping via inline styles (no Tailwind)
$height_map = [
    'small'  => '300px',
    'medium' => '450px',
    'large'  => '600px',
    'full'   => '100vh',
];

$overlay_map = [
    'none'   => '',
    'light'  => 'rgba(0,0,0,0.3)',
    'medium' => 'rgba(0,0,0,0.5)',
    'dark'   => 'rgba(0,0,0,0.7)',
];

$min_height     = $height_map[$hoehe] ?? $height_map['medium'];
$overlay_color  = $overlay_map[$overlay] ?? '';
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="parallax-image"
    style="background-image: url('<?php echo esc_url($bg_url); ?>'); background-attachment: fixed; background-position: center; background-size: cover; min-height: <?php echo esc_attr($min_height); ?>; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden;"
>
    <?php if ($overlay !== 'none' && $overlay_color) : ?>
        <div aria-hidden="true" style="position: absolute; inset: 0; background: <?php echo esc_attr($overlay_color); ?>;"></div>
    <?php endif; ?>

    <?php if ($heading || $text) : ?>
        <div style="position: relative; z-index: 1; text-align: center; padding: 0 1rem;">
            <?php if ($heading) : ?>
                <h2 style="color: #fff; margin-bottom: 1rem;">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p style="color: rgba(255,255,255,0.9);">
                    <?php echo esc_html($text); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
