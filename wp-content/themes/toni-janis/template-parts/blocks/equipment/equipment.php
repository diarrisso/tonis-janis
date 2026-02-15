<?php
/**
 * Block: Equipment (Professionelle Ausruestung)
 *
 * Section header with card grid.
 * Each card has an icon, title, description, and specification tag badges.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('equipment_label');
$heading    = get_sub_field('equipment_heading');
$text       = get_sub_field('equipment_text');
$items      = get_sub_field('equipment_items');
$block_id   = toja_block_id('equipment');

$allowed_svg = [
    'svg'  => ['class' => [], 'viewBox' => [], 'fill' => [], 'xmlns' => [], 'width' => [], 'height' => [], 'stroke' => [], 'stroke-width' => [], 'stroke-linecap' => [], 'stroke-linejoin' => []],
    'path' => ['d' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => [], 'stroke-linecap' => [], 'stroke-linejoin' => [], 'opacity' => []],
    'circle' => ['cx' => [], 'cy' => [], 'r' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => []],
    'rect' => ['x' => [], 'y' => [], 'width' => [], 'height' => [], 'rx' => [], 'ry' => [], 'fill' => [], 'stroke' => []],
    'line' => ['x1' => [], 'y1' => [], 'x2' => [], 'y2' => [], 'stroke' => [], 'stroke-width' => []],
    'polyline' => ['points' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => []],
    'polygon' => ['points' => [], 'fill' => [], 'stroke' => []],
    'g' => ['fill' => [], 'stroke' => [], 'transform' => []],
];
?>

<section class="equipment" id="<?php echo esc_attr($block_id); ?>">

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

    <?php if ($items) : ?>
        <div class="equipment-grid">
            <?php foreach ($items as $item) :
                $icon         = $item['equipment_icon'] ?? '';
                $titel        = $item['equipment_titel'] ?? '';
                $beschreibung = $item['equipment_beschreibung'] ?? '';
                $tags         = $item['equipment_tags'] ?? [];
            ?>
                <div class="equipment-card">
                    <?php if ($icon) : ?>
                        <div class="equipment-image">
                            <?php echo wp_kses($icon, $allowed_svg); ?>
                        </div>
                    <?php endif; ?>

                    <div class="equipment-content">
                        <?php if ($titel) : ?>
                            <h3><?php echo esc_html($titel); ?></h3>
                        <?php endif; ?>

                        <?php if ($beschreibung) : ?>
                            <p><?php echo esc_html($beschreibung); ?></p>
                        <?php endif; ?>

                        <?php if ($tags) : ?>
                            <div class="equipment-specs">
                                <?php foreach ($tags as $tag) :
                                    $tag_name = $tag['tag_name'] ?? '';
                                ?>
                                    <?php if ($tag_name) : ?>
                                        <span class="spec-badge"><?php echo esc_html($tag_name); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
