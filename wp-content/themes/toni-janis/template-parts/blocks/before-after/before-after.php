<?php
/**
 * Block: Vorher / Nachher
 *
 * Interactive comparison slider with draggable handle.
 * Uses clip-path to reveal before/after images.
 * Supports multiple projects with navigation dots.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('ba_label') ?: 'Vorher / Nachher';
$heading    = get_sub_field('ba_heading');
$text       = get_sub_field('ba_text');
$vergleiche = get_sub_field('ba_vergleiche');
$block_id   = toja_block_id('before-after');

if (empty($vergleiche)) {
    return;
}

// Build projects data for Alpine.js
$projects_data = [];
foreach ($vergleiche as $v) {
    $vorher_url  = $v['ba_vorher']['url'] ?? '';
    $nachher_url = $v['ba_nachher']['url'] ?? '';
    $vorher_alt  = $v['ba_vorher']['alt'] ?? '';
    $nachher_alt = $v['ba_nachher']['alt'] ?? '';
    $titel       = $v['ba_titel'] ?? '';
    $beschreibung = $v['ba_beschreibung'] ?? '';

    $tags = [];
    if (!empty($v['ba_tags'])) {
        foreach ($v['ba_tags'] as $tag_row) {
            if (!empty($tag_row['ba_tag'])) {
                $tags[] = $tag_row['ba_tag'];
            }
        }
    }

    $projects_data[] = [
        'vorher'        => $vorher_url,
        'nachher'       => $nachher_url,
        'vorherAlt'     => $vorher_alt,
        'nachherAlt'    => $nachher_alt,
        'titel'         => $titel,
        'beschreibung'  => $beschreibung,
        'tags'          => $tags,
    ];
}

$total = count($projects_data);
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('before-after', ['py-12 md:py-20'])); ?>"
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

        <!-- Comparison Slider -->
        <div
            x-data="{
                position: 50,
                dragging: false,
                current: 0,
                projects: <?php echo esc_attr(wp_json_encode($projects_data)); ?>,
                get project() {
                    return this.projects[this.current] || this.projects[0];
                },
                startDrag(e) {
                    this.dragging = true;
                    e.preventDefault();
                },
                onDrag(e) {
                    if (!this.dragging) return;
                    const rect = this.$refs.slider.getBoundingClientRect();
                    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                    const x = clientX - rect.left;
                    this.position = Math.max(0, Math.min(100, (x / rect.width) * 100));
                },
                stopDrag() {
                    this.dragging = false;
                },
                goTo(index) {
                    this.current = index;
                    this.position = 50;
                }
            }"
            @mousemove.window="onDrag($event)"
            @mouseup.window="stopDrag()"
            @touchmove.window="onDrag($event)"
            @touchend.window="stopDrag()"
            class="max-w-4xl mx-auto"
        >
            <!-- Slider Container -->
            <div
                x-ref="slider"
                class="relative overflow-hidden rounded-2xl shadow-xl cursor-col-resize select-none aspect-[16/10]"
            >
                <!-- After Image (Background) -->
                <img
                    :src="project.nachher"
                    :alt="project.nachherAlt"
                    class="absolute inset-0 w-full h-full object-cover"
                    loading="lazy"
                >

                <!-- Before Image (Clipped) -->
                <div
                    class="absolute inset-0"
                    :style="'clip-path: inset(0 ' + (100 - position) + '% 0 0)'"
                >
                    <img
                        :src="project.vorher"
                        :alt="project.vorherAlt"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    >
                </div>

                <!-- Labels -->
                <div class="absolute top-4 left-4 z-10">
                    <span class="bg-earth-brown/80 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm">
                        <?php esc_html_e('Vorher', 'toni-janis'); ?>
                    </span>
                </div>
                <div class="absolute top-4 right-4 z-10">
                    <span class="bg-kiwi-green/90 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm">
                        <?php esc_html_e('Nachher', 'toni-janis'); ?>
                    </span>
                </div>

                <!-- Slider Handle -->
                <div
                    class="absolute top-0 bottom-0 z-20 flex items-center"
                    :style="'left: ' + position + '%'"
                    @mousedown="startDrag($event)"
                    @touchstart="startDrag($event)"
                >
                    <!-- Line -->
                    <div class="absolute top-0 bottom-0 w-0.5 bg-white -translate-x-1/2 shadow-lg"></div>

                    <!-- Handle Button -->
                    <div class="relative -translate-x-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center cursor-grab active:cursor-grabbing">
                        <svg class="w-5 h-5 text-kiwi-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Project Info -->
            <div class="mt-6 text-center">
                <template x-if="project.titel">
                    <h3 class="font-heading text-xl md:text-2xl font-bold text-earth-brown mb-2" x-text="project.titel"></h3>
                </template>

                <template x-if="project.beschreibung">
                    <p class="text-earth-brown/70 mb-3 max-w-xl mx-auto" x-text="project.beschreibung"></p>
                </template>

                <template x-if="project.tags && project.tags.length > 0">
                    <div class="flex flex-wrap justify-center gap-2">
                        <template x-for="(tag, idx) in project.tags" :key="idx">
                            <span
                                class="inline-block bg-kiwi-green/10 text-kiwi-dark text-xs font-medium px-3 py-1 rounded-full"
                                x-text="tag"
                            ></span>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Navigation Dots -->
            <?php if ($total > 1) : ?>
                <div class="flex justify-center gap-3 mt-6">
                    <?php for ($i = 0; $i < $total; $i++) : ?>
                        <button
                            @click="goTo(<?php echo $i; ?>)"
                            :class="current === <?php echo $i; ?> ? 'bg-kiwi-green scale-125' : 'bg-earth-brown/30 hover:bg-earth-brown/50'"
                            class="w-3 h-3 rounded-full transition-all duration-300"
                            aria-label="<?php echo esc_attr(sprintf(__('Projekt %d', 'toni-janis'), $i + 1)); ?>"
                        ></button>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
