<?php
/**
 * Block: About (Über uns)
 *
 * 2-column layout with image and experience badge on the left,
 * content with features list on the right.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label          = get_sub_field('about_label');
$heading        = get_sub_field('about_heading');
$texte          = get_sub_field('about_texte');
$bild           = get_sub_field('about_bild');
$erfahrung_zahl = get_sub_field('about_erfahrung_zahl');
$erfahrung_text = get_sub_field('about_erfahrung_text');
$features       = get_sub_field('about_features');
$button         = get_sub_field('about_button');
$bg_variant     = get_sub_field('background_variant') ?: 'cream';
$spacing        = get_sub_field('block_spacing') ?: 'medium';
$block_id       = toja_block_id('about');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('about')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-center max-w-6xl mx-auto">
            <!-- Image Column -->
            <div class="relative">
                <?php if ($bild) : ?>
                    <div class="relative">
                        <div class="overflow-hidden rounded-3xl">
                            <?php toja_image($bild, 'large', [
                                'class' => 'w-full h-auto object-cover',
                            ]); ?>
                        </div>

                        <!-- Experience Badge -->
                        <?php if ($erfahrung_zahl || $erfahrung_text) : ?>
                            <div class="absolute -bottom-6 -right-6 w-36 h-36 bg-white rounded-full shadow-xl flex flex-col items-center justify-center">
                                <?php if ($erfahrung_zahl) : ?>
                                    <strong class="font-heading text-4xl text-kiwi-dark leading-none">
                                        <?php echo esc_html($erfahrung_zahl); ?>
                                    </strong>
                                <?php endif; ?>
                                <?php if ($erfahrung_text) : ?>
                                    <span class="text-sm text-earth-brown text-center mt-1">
                                        <?php echo esc_html($erfahrung_text); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Content Column -->
            <div>
                <?php if ($label) : ?>
                    <span class="inline-block text-sm uppercase tracking-widest text-kiwi-accent font-semibold mb-4">
                        <?php echo esc_html($label); ?>
                    </span>
                <?php endif; ?>

                <?php if ($heading) : ?>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-kiwi-dark mb-6 leading-tight">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($texte) : ?>
                    <div class="prose prose-lg text-earth-brown mb-8 max-w-none">
                        <?php echo wp_kses_post($texte); ?>
                    </div>
                <?php endif; ?>

                <!-- Features List -->
                <?php if ($features) : ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <?php foreach ($features as $feature) :
                            $icon = $feature['feature_icon'] ?? '✓';
                            $feat_text = $feature['feature_text'] ?? '';
                        ?>
                            <?php if ($feat_text) : ?>
                                <div class="flex items-center gap-3">
                                    <span class="flex-shrink-0 w-8 h-8 bg-kiwi-green/10 text-kiwi-dark rounded-full flex items-center justify-center font-bold text-sm">
                                        <?php echo esc_html($icon); ?>
                                    </span>
                                    <span class="text-earth-brown font-medium">
                                        <?php echo esc_html($feat_text); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($button) : ?>
                    <div>
                        <?php toja_component('button', [
                            'link'    => $button,
                            'variant' => 'primary',
                            'size'    => 'lg',
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
