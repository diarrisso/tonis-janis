<?php
/**
 * Block: Services (Leistungen)
 *
 * Section header with responsive grid of service cards.
 * Each card has an icon, title, description, and link arrow.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('services_label');
$heading    = get_sub_field('services_heading');
$text       = get_sub_field('services_text');
$services   = get_sub_field('services_liste');
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
$block_id   = toja_block_id('services');

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
    class="<?php echo esc_attr(toja_block_classes('services')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
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

        <!-- Services Grid -->
        <?php if ($services) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                <?php foreach ($services as $service) :
                    $icon         = $service['service_icon'] ?? '';
                    $titel        = $service['service_titel'] ?? '';
                    $beschreibung = $service['service_beschreibung'] ?? '';
                    $link         = $service['service_link'] ?? null;
                    $link_url     = $link['url'] ?? '';
                    $link_target  = $link['target'] ?? '';
                ?>
                    <div class="group bg-cream border border-kiwi-dark/10 rounded-3xl p-8 transition-all duration-400 hover:-translate-y-2 hover:shadow-xl hover:shadow-kiwi-dark/10 relative overflow-hidden">
                        <!-- Top accent line -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-kiwi-dark to-kiwi-green transform scale-x-0 group-hover:scale-x-100 transition-transform duration-400 origin-left"></div>

                        <?php if ($icon) : ?>
                            <div class="w-16 h-16 bg-gradient-to-br from-kiwi-dark to-kiwi-green rounded-2xl flex items-center justify-center text-white text-2xl mb-6">
                                <?php echo wp_kses($icon, $allowed_svg); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($titel) : ?>
                            <h3 class="font-heading text-xl font-semibold text-kiwi-dark mb-3">
                                <?php echo esc_html($titel); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($beschreibung) : ?>
                            <p class="text-earth-brown mb-6">
                                <?php echo esc_html($beschreibung); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($link && $link_url) : ?>
                            <a
                                href="<?php echo esc_url($link_url); ?>"
                                class="inline-flex items-center gap-2 text-kiwi-dark font-semibold transition-all duration-300 group-hover:gap-4"
                                <?php echo $link_target ? 'target="' . esc_attr($link_target) . '" rel="noopener noreferrer"' : ''; ?>
                            >
                                <?php esc_html_e('Mehr erfahren', 'toni-janis'); ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
