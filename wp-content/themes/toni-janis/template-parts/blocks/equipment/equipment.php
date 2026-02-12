<?php
/**
 * Block: Equipment (Professionelle Ausrüstung)
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
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
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

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('equipment')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
>
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <?php if ($label || $heading || $text) : ?>
            <div class="text-center max-w-2xl mx-auto mb-16">
                <?php if ($label) : ?>
                    <span class="inline-block text-sm uppercase tracking-widest text-kiwi-accent font-semibold mb-4">
                        <?php echo esc_html($label); ?>
                    </span>
                <?php endif; ?>

                <?php if ($heading) : ?>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-kiwi-dark mb-4">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <p class="text-earth-brown text-lg">
                        <?php echo esc_html($text); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Equipment Cards Grid -->
        <?php if ($items) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                <?php foreach ($items as $item) :
                    $icon         = $item['equipment_icon'] ?? '';
                    $titel        = $item['equipment_titel'] ?? '';
                    $beschreibung = $item['equipment_beschreibung'] ?? '';
                    $tags         = $item['equipment_tags'] ?? [];
                ?>
                    <div class="group bg-cream border border-kiwi-dark/10 rounded-2xl p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-kiwi-dark/10">
                        <?php if ($icon) : ?>
                            <div class="w-16 h-16 bg-gradient-to-br from-kiwi-dark to-kiwi-green rounded-2xl flex items-center justify-center mb-6 text-white text-2xl transition-transform duration-300 group-hover:scale-110">
                                <?php echo wp_kses($icon, $allowed_svg); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($titel) : ?>
                            <h3 class="font-heading text-xl font-semibold text-kiwi-dark mb-3">
                                <?php echo esc_html($titel); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($beschreibung) : ?>
                            <p class="text-earth-brown text-sm leading-relaxed mb-6">
                                <?php echo esc_html($beschreibung); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Spec Tags -->
                        <?php if ($tags) : ?>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag) :
                                    $tag_name = $tag['tag_name'] ?? '';
                                ?>
                                    <?php if ($tag_name) : ?>
                                        <span class="inline-block bg-kiwi-green/10 text-kiwi-dark text-xs font-medium px-3 py-1.5 rounded-full">
                                            <?php echo esc_html($tag_name); ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
