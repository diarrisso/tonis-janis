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

<section class="before-after" id="<?php echo esc_attr($block_id); ?>">

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
        class="ba-hero-container"
    >
        <div x-ref="slider" class="ba-hero-wrapper">
            <div class="ba-comparison" id="baMainComparison">
                <div
                    class="ba-before"
                    id="baBeforeImage"
                    :style="'clip-path: inset(0 ' + (100 - position) + '% 0 0); background-image: url(' + project.vorher + ')'"
                ></div>
                <div
                    class="ba-after"
                    id="baAfterImage"
                    :style="'background-image: url(' + project.nachher + ')'"
                ></div>
                <div
                    class="ba-slider"
                    id="baSlider"
                    :style="'left: ' + position + '%'"
                    @mousedown="startDrag($event)"
                    @touchstart="startDrag($event)"
                    @keydown.left.prevent="position = Math.max(0, position - 2)"
                    @keydown.right.prevent="position = Math.min(100, position + 2)"
                    role="slider"
                    tabindex="0"
                    aria-label="<?php esc_attr_e('Vergleichsregler: nach links oder rechts ziehen, um Vorher- und Nachher-Bilder zu vergleichen', 'toni-janis'); ?>"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    :aria-valuenow="Math.round(position)"
                ></div>
                <div class="ba-labels">
                    <span class="ba-label"><?php esc_html_e('Vorher', 'toni-janis'); ?></span>
                    <span class="ba-label"><?php esc_html_e('Nachher', 'toni-janis'); ?></span>
                </div>
            </div>
        </div>

        <div class="ba-hero-info" id="baHeroInfo">
            <template x-if="project.titel">
                <h3 id="baProjectTitle" x-text="project.titel"></h3>
            </template>

            <template x-if="project.beschreibung">
                <p id="baProjectDescription" x-text="project.beschreibung"></p>
            </template>

            <template x-if="project.tags && project.tags.length > 0">
                <div class="ba-tags" id="baProjectTags">
                    <template x-for="(tag, idx) in project.tags" :key="idx">
                        <span class="ba-tag" x-text="tag"></span>
                    </template>
                </div>
            </template>

            <?php if ($total > 1) : ?>
                <div class="ba-navigation">
                    <button class="ba-nav-btn" id="baPrev" @click="goTo((current - 1 + projects.length) % projects.length)" aria-label="<?php esc_attr_e('Vorheriges Projekt', 'toni-janis'); ?>">&larr;</button>
                    <div class="ba-nav-dots" id="baDots">
                        <?php for ($i = 0; $i < $total; $i++) : ?>
                            <button
                                @click="goTo(<?php echo $i; ?>)"
                                :class="current === <?php echo $i; ?> ? 'active' : ''"
                                aria-label="<?php echo esc_attr(sprintf(__('Projekt %d', 'toni-janis'), $i + 1)); ?>"
                            ></button>
                        <?php endfor; ?>
                    </div>
                    <button class="ba-nav-btn" id="baNext" @click="goTo((current + 1) % projects.length)" aria-label="<?php esc_attr_e('Naechstes Projekt', 'toni-janis'); ?>">&rarr;</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
