<?php
/**
 * Block: Hero
 *
 * Standard variant: 2-column grid (text left, image right) with gradient background.
 * Fullscreen variant: Centered text on fullscreen background image.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$variante        = get_sub_field('hero_variante') ?: 'standard';
$badge           = get_sub_field('hero_badge');
$titel           = get_sub_field('hero_titel');
$highlight       = get_sub_field('hero_highlight');
$text            = get_sub_field('hero_text');
$hintergrundbild = get_sub_field('hero_hintergrundbild');
$bild            = get_sub_field('hero_bild');
$button_primary  = get_sub_field('hero_button_primary');
$button_secondary = get_sub_field('hero_button_secondary');
$bg_variant      = get_sub_field('background_variant') ?: 'white';
$spacing         = get_sub_field('block_spacing') ?: 'medium';
$block_id        = toja_block_id('hero');

$is_fullscreen = ($variante === 'fullscreen');

// Background image URL for fullscreen variant
$bg_image_url = '';
if ($is_fullscreen && $hintergrundbild) {
    $bg_image_url = $hintergrundbild['url'] ?? '';
}
?>

<?php if ($is_fullscreen) : ?>
    <?php // --- Fullscreen Variant --- ?>
    <section
        id="<?php echo esc_attr($block_id); ?>"
        class="<?php echo esc_attr(toja_block_classes('hero', ['relative min-h-screen flex items-center justify-center overflow-hidden'])); ?>"
        <?php if ($bg_image_url) : ?>
            style="background-image: url('<?php echo esc_url($bg_image_url); ?>'); background-size: cover; background-position: center;"
        <?php endif; ?>
        x-data="{ scrollVisible: true }"
        @scroll.window="scrollVisible = (window.scrollY < 100)"
    >
        <!-- Overlay -->
        <div class="absolute inset-0 bg-kiwi-dark/70"></div>

        <div class="container mx-auto px-4 relative z-10 text-center py-20">
            <?php if ($badge) : ?>
                <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium mb-6">
                    <?php echo esc_html($badge); ?>
                </span>
            <?php endif; ?>

            <?php if ($titel || $highlight) : ?>
                <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    <?php if ($titel) : ?>
                        <?php echo esc_html($titel); ?>
                    <?php endif; ?>
                    <?php if ($highlight) : ?>
                        <span class="text-kiwi-accent block mt-2"><?php echo esc_html($highlight); ?></span>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-10">
                    <?php echo esc_html($text); ?>
                </p>
            <?php endif; ?>

            <?php if ($button_primary || $button_secondary) : ?>
                <div class="flex flex-wrap gap-4 justify-center">
                    <?php if ($button_primary) : ?>
                        <?php toja_component('button', [
                            'link'    => $button_primary,
                            'variant' => 'primary',
                            'size'    => 'lg',
                        ]); ?>
                    <?php endif; ?>

                    <?php if ($button_secondary) : ?>
                        <?php toja_component('button', [
                            'link'    => $button_secondary,
                            'variant' => 'outline',
                            'size'    => 'lg',
                            'class'   => 'border-white text-white hover:bg-white hover:text-kiwi-dark',
                        ]); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Scroll Indicator -->
        <div
            class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 transition-opacity duration-300"
            x-show="scrollVisible"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <a href="#content" class="flex flex-col items-center text-white/80 hover:text-white transition-colors">
                <span class="text-sm mb-2"><?php esc_html_e('Mehr entdecken', 'toni-janis'); ?></span>
                <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </section>

<?php else : ?>
    <?php // --- Standard Variant --- ?>
    <section
        id="<?php echo esc_attr($block_id); ?>"
        class="<?php echo esc_attr(toja_block_classes('hero', ['relative overflow-hidden'])); ?> bg-gradient-to-br from-sand-beige to-cream <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
    >
        <?php if ($hintergrundbild) : ?>
            <div class="absolute inset-0 opacity-10">
                <?php toja_image($hintergrundbild, 'full', [
                    'class'   => 'w-full h-full object-cover',
                    'loading' => 'eager',
                ]); ?>
            </div>
        <?php endif; ?>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center min-h-[80vh] py-20 lg:py-0">
                <!-- Content -->
                <div class="order-2 lg:order-1">
                    <?php if ($badge) : ?>
                        <span class="inline-flex items-center gap-2 bg-kiwi-dark/10 text-kiwi-dark px-4 py-2 rounded-full text-sm font-medium mb-6">
                            <?php echo esc_html($badge); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($titel || $highlight) : ?>
                        <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold text-kiwi-dark mb-6 leading-tight">
                            <?php if ($titel) : ?>
                                <?php echo esc_html($titel); ?>
                            <?php endif; ?>
                            <?php if ($highlight) : ?>
                                <span class="text-kiwi-accent"><?php echo esc_html($highlight); ?></span>
                            <?php endif; ?>
                        </h1>
                    <?php endif; ?>

                    <?php if ($text) : ?>
                        <p class="text-lg text-earth-brown mb-8 max-w-lg">
                            <?php echo esc_html($text); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($button_primary || $button_secondary) : ?>
                        <div class="flex flex-wrap gap-4">
                            <?php if ($button_primary) : ?>
                                <?php toja_component('button', [
                                    'link'    => $button_primary,
                                    'variant' => 'primary',
                                    'size'    => 'lg',
                                ]); ?>
                            <?php endif; ?>

                            <?php if ($button_secondary) : ?>
                                <?php toja_component('button', [
                                    'link'    => $button_secondary,
                                    'variant' => 'outline',
                                    'size'    => 'lg',
                                ]); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Image -->
                <div class="order-1 lg:order-2 relative">
                    <?php if ($bild) : ?>
                        <div class="relative">
                            <div class="overflow-hidden rounded-3xl shadow-2xl">
                                <?php toja_image($bild, 'large', [
                                    'class'   => 'w-full h-auto object-cover',
                                    'loading' => 'eager',
                                ]); ?>
                            </div>
                            <!-- Decorative element -->
                            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-kiwi-green/20 rounded-2xl -z-10"></div>
                            <div class="absolute -top-4 -left-4 w-16 h-16 bg-kiwi-accent/20 rounded-xl -z-10"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>
