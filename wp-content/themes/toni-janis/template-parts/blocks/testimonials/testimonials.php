<?php
/**
 * Block: Testimonials (Kundenstimmen)
 *
 * Dark green section with testimonial cards in an Alpine.js slider.
 * Supports both CPT (toja_testimonial) and manual repeater data source.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('testimonials_label');
$heading    = get_sub_field('testimonials_heading');
$text       = get_sub_field('testimonials_text');
$anzahl     = get_sub_field('testimonials_anzahl') ?: 6;
$quelle     = get_sub_field('testimonials_quelle') ?: 'cpt';
$manuell    = get_sub_field('testimonials_manuell');
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
$block_id   = toja_block_id('testimonials');

// Build normalized testimonials array
$testimonials = [];

if ($quelle === 'cpt') {
    $query = new WP_Query([
        'post_type'      => 'toja_testimonial',
        'posts_per_page' => (int) $anzahl,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $pid = get_the_ID();
            $testimonials[] = [
                'name'      => get_field('testimonial_name', $pid) ?: get_the_title(),
                'ort'       => get_field('testimonial_ort', $pid),
                'bewertung' => (int) (get_field('testimonial_bewertung', $pid) ?: 5),
                'text'      => get_field('testimonial_text', $pid),
                'initialen' => get_field('testimonial_initialen', $pid),
            ];
        }
    }
    wp_reset_postdata();
} elseif ($quelle === 'manuell' && $manuell) {
    foreach ($manuell as $item) {
        $testimonials[] = [
            'name'      => $item['tm_name'] ?? '',
            'ort'       => $item['tm_ort'] ?? '',
            'bewertung' => (int) ($item['tm_bewertung'] ?? 5),
            'text'      => $item['tm_text'] ?? '',
            'initialen' => $item['tm_initialen'] ?? '',
        ];
    }
}

$total = count($testimonials);

if ($total === 0 && !$label && !$heading) {
    return;
}
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('testimonials', ['bg-kiwi-dark'])); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
>
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <?php if ($label || $heading || $text) : ?>
            <div class="text-center max-w-2xl mx-auto mb-12">
                <?php if ($label) : ?>
                    <span class="inline-block text-sm uppercase tracking-widest text-kiwi-light font-semibold mb-4">
                        <?php echo esc_html($label); ?>
                    </span>
                <?php endif; ?>

                <?php if ($heading) : ?>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-white mb-4">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <p class="text-kiwi-light/80 text-lg">
                        <?php echo esc_html($text); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($total > 0) : ?>
            <!-- Testimonials Slider -->
            <div
                x-data="{
                    current: 0,
                    total: <?php echo esc_attr($total); ?>,
                    perPage: 3,
                    init() {
                        this.updatePerPage();
                        window.addEventListener('resize', () => this.updatePerPage());
                    },
                    updatePerPage() {
                        if (window.innerWidth < 768) {
                            this.perPage = 1;
                        } else if (window.innerWidth < 1024) {
                            this.perPage = 2;
                        } else {
                            this.perPage = 3;
                        }
                        if (this.current > this.maxIndex()) this.current = this.maxIndex();
                    },
                    maxIndex() {
                        return Math.max(0, this.total - this.perPage);
                    },
                    next() {
                        this.current = this.current < this.maxIndex() ? this.current + 1 : 0;
                    },
                    prev() {
                        this.current = this.current > 0 ? this.current - 1 : this.maxIndex();
                    }
                }"
                class="relative"
            >
                <!-- Slider Track -->
                <div class="overflow-hidden">
                    <div
                        class="flex transition-transform duration-500 ease-in-out gap-6"
                        :style="'transform: translateX(-' + (current * (100 / perPage + (6 * 4 / (perPage * 16)))) + '%);'"
                    >
                        <?php foreach ($testimonials as $index => $t) :
                            $name      = $t['name'];
                            $ort       = $t['ort'];
                            $bewertung = $t['bewertung'];
                            $quote     = $t['text'];
                            $initialen = $t['initialen'];

                            // Auto-generate initials if empty
                            if (empty($initialen) && !empty($name)) {
                                $parts = explode(' ', trim($name));
                                $initialen = mb_strtoupper(mb_substr($parts[0], 0, 1));
                                if (isset($parts[1])) {
                                    $initialen .= mb_strtoupper(mb_substr($parts[1], 0, 1));
                                }
                            }
                        ?>
                            <div class="flex-shrink-0 w-full md:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)]">
                                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 h-full flex flex-col border border-white/10">
                                    <!-- Stars -->
                                    <div class="flex gap-1 mb-4">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <svg class="w-5 h-5 <?php echo $i <= $bewertung ? 'text-yellow-400' : 'text-white/20'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        <?php endfor; ?>
                                    </div>

                                    <!-- Quote -->
                                    <?php if ($quote) : ?>
                                        <blockquote class="text-white/90 leading-relaxed mb-6 flex-grow">
                                            &laquo;<?php echo esc_html($quote); ?>&raquo;
                                        </blockquote>
                                    <?php endif; ?>

                                    <!-- Author -->
                                    <div class="flex items-center gap-3 mt-auto pt-4 border-t border-white/10">
                                        <!-- Avatar with Initials -->
                                        <div class="w-10 h-10 rounded-full bg-kiwi-green/30 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                            <?php echo esc_html($initialen); ?>
                                        </div>
                                        <div>
                                            <?php if ($name) : ?>
                                                <p class="text-white font-semibold text-sm">
                                                    <?php echo esc_html($name); ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if ($ort) : ?>
                                                <p class="text-kiwi-light/60 text-xs">
                                                    <?php echo esc_html($ort); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <?php if ($total > 3) : ?>
                    <div class="flex justify-center gap-4 mt-8">
                        <button
                            @click="prev()"
                            class="w-12 h-12 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition-colors"
                            aria-label="<?php esc_attr_e('Vorherige', 'toni-janis'); ?>"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            @click="next()"
                            class="w-12 h-12 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition-colors"
                            aria-label="<?php esc_attr_e('Naechste', 'toni-janis'); ?>"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Dot Indicators -->
                <?php if ($total > 1) : ?>
                    <div class="flex justify-center gap-2 mt-4">
                        <?php for ($i = 0; $i < $total; $i++) : ?>
                            <button
                                @click="current = <?php echo $i; ?>"
                                :class="current === <?php echo $i; ?> ? 'bg-white w-8' : 'bg-white/30 w-2'"
                                class="h-2 rounded-full transition-all duration-300"
                                aria-label="<?php printf(esc_attr__('Folie %d', 'toni-janis'), $i + 1); ?>"
                            ></button>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <p class="text-center text-white/60">
                <?php esc_html_e('Noch keine Kundenstimmen vorhanden.', 'toni-janis'); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
