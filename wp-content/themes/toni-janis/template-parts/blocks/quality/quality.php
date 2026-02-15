<?php
/**
 * Block: Quality (Qualität & Expertise)
 *
 * Section header with a grid of quality cards.
 * Each card has an icon, title, and description.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('quality_label');
$heading  = get_sub_field('quality_heading');
$text     = get_sub_field('quality_text');
$items    = get_sub_field('quality_items');
$block_id = toja_block_id('quality');

$allowed_svg = [
    'svg'      => ['class' => [], 'viewBox' => [], 'fill' => [], 'xmlns' => [], 'width' => [], 'height' => [], 'stroke' => [], 'stroke-width' => [], 'stroke-linecap' => [], 'stroke-linejoin' => []],
    'path'     => ['d' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => [], 'stroke-linecap' => [], 'stroke-linejoin' => [], 'opacity' => []],
    'circle'   => ['cx' => [], 'cy' => [], 'r' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => []],
    'rect'     => ['x' => [], 'y' => [], 'width' => [], 'height' => [], 'rx' => [], 'ry' => [], 'fill' => [], 'stroke' => []],
    'line'     => ['x1' => [], 'y1' => [], 'x2' => [], 'y2' => [], 'stroke' => [], 'stroke-width' => []],
    'polyline' => ['points' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => []],
    'polygon'  => ['points' => [], 'fill' => [], 'stroke' => []],
    'g'        => ['fill' => [], 'stroke' => [], 'transform' => []],
];
?>

<section class="quality" id="<?php echo esc_attr($block_id); ?>">
    <!-- Section Header -->
    <?php if ($label || $heading || $text) : ?>
        <div class="section-header">
            <?php if ($label) : ?>
                <span class="section-label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Quality Cards Grid -->
    <?php if ($items) : ?>
        <div class="quality-grid">
            <?php foreach ($items as $item) :
                $icon         = $item['quality_icon'] ?? '';
                $titel        = $item['quality_titel'] ?? '';
                $beschreibung = $item['quality_beschreibung'] ?? '';
            ?>
                <div class="quality-card">
                    <?php if ($icon) : ?>
                        <div class="quality-icon">
                            <?php echo wp_kses($icon, $allowed_svg); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($titel) : ?>
                        <h3><?php echo esc_html($titel); ?></h3>
                    <?php endif; ?>

                    <?php if ($beschreibung) : ?>
                        <p><?php echo esc_html($beschreibung); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
