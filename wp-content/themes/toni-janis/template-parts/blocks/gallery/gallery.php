<?php
/**
 * Block: Galerie
 *
 * Responsive image gallery with Alpine.js slider.
 * Shows 1 image on mobile, 2 on tablet, 3 on desktop.
 * Images have overlay gradient with label text, rounded corners, hover scale.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('gallery_label') ?: 'Galerie';
$heading  = get_sub_field('gallery_heading');
$text     = get_sub_field('gallery_text');
$bilder   = get_sub_field('gallery_bilder');
$block_id = toja_block_id('gallery');

if (empty($bilder)) {
    return;
}

$total = count($bilder);
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('gallery', ['py-12 md:py-20'])); ?>"
>
    <div class="container mx-auto px-4">

        <!-- Section Header -->
        <div class="text-center mb-12">
            <?php if ($label) : ?>
                <span class="inline-block text-kiwi-green font-semibold text-sm uppercase tracking-wider mb-2">
                    <?php echo esc_html($label); ?>
                </span>
            <?php endif; ?>

            <?php if ($heading) : ?>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-earth-brown mb-4">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="text-earth-brown/70 max-w-2xl mx-auto">
                    <?php echo esc_html($text); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Gallery Slider -->
        <div
            x-data="{
                current: 0,
                total: <?php echo esc_attr($total); ?>,
                perPage: 3,
                get maxIndex() {
                    return Math.max(0, this.total - this.perPage);
                },
                init() {
                    this.updatePerPage();
                    window.addEventListener('resize', () => this.updatePerPage());
                },
                updatePerPage() {
                    if (window.innerWidth < 640) {
                        this.perPage = 1;
                    } else if (window.innerWidth < 1024) {
                        this.perPage = 2;
                    } else {
                        this.perPage = 3;
                    }
                    if (this.current > this.maxIndex) {
                        this.current = this.maxIndex;
                    }
                },
                prev() {
                    this.current = Math.max(0, this.current - 1);
                },
                next() {
                    this.current = Math.min(this.maxIndex, this.current + 1);
                },
                goTo(index) {
                    this.current = Math.min(index, this.maxIndex);
                }
            }"
        >
            <!-- Slider Container -->
            <div class="relative overflow-hidden">
                <div
                    class="flex transition-transform duration-500 ease-in-out"
                    :style="'transform: translateX(-' + (current * (100 / perPage)) + '%)'"
                >
                    <?php foreach ($bilder as $index => $bild) :
                        $img_label = $bild['caption'] ?: ($bild['alt'] ?: '');
                    ?>
                        <div
                            class="flex-shrink-0 px-2"
                            :class="perPage === 1 ? 'w-full' : perPage === 2 ? 'w-1/2' : 'w-1/3'"
                        >
                            <div class="group relative overflow-hidden rounded-2xl cursor-pointer aspect-[4/3]">
                                <?php toja_image($bild, 'large', [
                                    'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110',
                                ]); ?>

                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>

                                <?php if ($img_label) : ?>
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <p class="text-white font-medium text-sm md:text-base">
                                            <?php echo esc_html($img_label); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Navigation -->
            <?php if ($total > 1) : ?>
                <div class="flex items-center justify-center gap-4 mt-8">
                    <!-- Prev Button -->
                    <button
                        @click="prev()"
                        :disabled="current === 0"
                        class="w-10 h-10 rounded-full border-2 border-kiwi-green text-kiwi-green flex items-center justify-center transition-all hover:bg-kiwi-green hover:text-white disabled:opacity-30 disabled:cursor-not-allowed"
                        aria-label="<?php esc_attr_e('Vorheriges Bild', 'toni-janis'); ?>"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Dot Indicators -->
                    <div class="flex gap-2">
                        <?php for ($i = 0; $i < $total; $i++) : ?>
                            <button
                                @click="goTo(<?php echo $i; ?>)"
                                :class="current === <?php echo $i; ?> ? 'bg-kiwi-green w-8' : 'bg-earth-brown/30 w-2'"
                                class="h-2 rounded-full transition-all duration-300"
                                aria-label="<?php echo esc_attr(sprintf(__('Bild %d', 'toni-janis'), $i + 1)); ?>"
                            ></button>
                        <?php endfor; ?>
                    </div>

                    <!-- Next Button -->
                    <button
                        @click="next()"
                        :disabled="current >= maxIndex"
                        class="w-10 h-10 rounded-full border-2 border-kiwi-green text-kiwi-green flex items-center justify-center transition-all hover:bg-kiwi-green hover:text-white disabled:opacity-30 disabled:cursor-not-allowed"
                        aria-label="<?php esc_attr_e('Nächstes Bild', 'toni-janis'); ?>"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
