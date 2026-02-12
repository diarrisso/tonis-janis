<?php
/**
 * Block: Process (Arbeitsprozess)
 *
 * Section header with a 4-column grid of step cards.
 * Each card has a numbered circle, icon, title, and description.
 * Steps are connected by a horizontal line on larger screens.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('process_label');
$heading    = get_sub_field('process_heading');
$text       = get_sub_field('process_text');
$schritte   = get_sub_field('process_schritte');
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
$block_id   = toja_block_id('process');

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

$total_steps = is_array($schritte) ? count($schritte) : 0;
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('process')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
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

        <!-- Process Steps -->
        <?php if ($schritte) : ?>
            <div class="relative max-w-6xl mx-auto">
                <!-- Connecting Line (visible on lg+) -->
                <div class="hidden lg:block absolute top-16 left-0 right-0 h-0.5 bg-kiwi-green/20" aria-hidden="true"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php
                    $step_number = 0;
                    foreach ($schritte as $schritt) :
                        $step_number++;
                        $icon         = $schritt['schritt_icon'] ?? '';
                        $titel        = $schritt['schritt_titel'] ?? '';
                        $beschreibung = $schritt['schritt_beschreibung'] ?? '';
                    ?>
                        <div class="relative text-center">
                            <!-- Step Number Circle -->
                            <div class="relative z-10 mx-auto mb-6">
                                <div class="w-14 h-14 bg-gradient-to-br from-kiwi-dark to-kiwi-green rounded-full flex items-center justify-center mx-auto shadow-lg shadow-kiwi-dark/20">
                                    <span class="text-white font-bold text-lg"><?php echo esc_html($step_number); ?></span>
                                </div>
                            </div>

                            <!-- Card -->
                            <div class="bg-cream border border-kiwi-dark/10 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-kiwi-dark/5">
                                <?php if ($icon) : ?>
                                    <div class="w-12 h-12 bg-kiwi-green/10 rounded-xl flex items-center justify-center mx-auto mb-4 text-kiwi-dark text-xl">
                                        <?php echo wp_kses($icon, $allowed_svg); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($titel) : ?>
                                    <h3 class="font-heading text-lg font-semibold text-kiwi-dark mb-3">
                                        <?php echo esc_html($titel); ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if ($beschreibung) : ?>
                                    <p class="text-earth-brown text-sm">
                                        <?php echo esc_html($beschreibung); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
