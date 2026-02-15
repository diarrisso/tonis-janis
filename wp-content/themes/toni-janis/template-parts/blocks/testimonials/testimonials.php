<?php
/**
 * Block: Testimonials (Kundenstimmen)
 *
 * Testimonial cards in a custom JS slider.
 * Items are grouped into slides of 3.
 * Supports both CPT (toja_testimonial) and manual repeater data source.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('testimonials_label');
$heading  = get_sub_field('testimonials_heading');
$text     = get_sub_field('testimonials_text');
$anzahl   = get_sub_field('testimonials_anzahl') ?: 6;
$quelle   = get_sub_field('testimonials_quelle') ?: 'cpt';
$manuell  = get_sub_field('testimonials_manuell');
$block_id = toja_block_id('testimonials');

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
        ];
    }
}

$total = count($testimonials);

if ($total === 0 && !$label && !$heading) {
    return;
}

// Chunk testimonials into slides of 3
$slides = array_chunk($testimonials, 3);
?>

<section class="testimonials" id="<?php echo esc_attr($block_id); ?>">
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

    <?php if ($total > 0) : ?>
        <div class="testimonials-slider slider-container">
            <div class="slider-wrapper" id="testimonialsSliderWrapper">
                <?php foreach ($slides as $slide_index => $slide_items) : ?>
                    <div class="testimonials-slide">
                        <?php foreach ($slide_items as $t) :
                            $name      = $t['name'];
                            $ort       = $t['ort'];
                            $bewertung = $t['bewertung'];
                            $quote     = $t['text'];

                            // Generate initials from name
                            $initialen = '';
                            if (!empty($name)) {
                                $parts = explode(' ', trim($name));
                                $initialen = mb_strtoupper(mb_substr($parts[0], 0, 1));
                                if (isset($parts[1])) {
                                    $initialen .= mb_strtoupper(mb_substr($parts[1], 0, 1));
                                }
                            }

                            // Build stars string based on bewertung
                            $stars = str_repeat("\xE2\x98\x85", $bewertung);
                        ?>
                            <div class="testimonial-card">
                                <div class="testimonial-stars"><?php echo $stars; ?></div>

                                <?php if ($quote) : ?>
                                    <p>&laquo;<?php echo esc_html($quote); ?>&raquo;</p>
                                <?php endif; ?>

                                <div class="testimonial-author">
                                    <div class="testimonial-avatar"><?php echo esc_html($initialen); ?></div>
                                    <div>
                                        <?php if ($name) : ?>
                                            <strong><?php echo esc_html($name); ?></strong>
                                        <?php endif; ?>
                                        <?php if ($ort) : ?>
                                            <span><?php echo esc_html($ort); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($slides) > 1) : ?>
                <div class="slider-controls">
                    <button class="slider-btn" id="testimonialsPrev" aria-label="Vorherige Bewertung">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="slider-dots" id="testimonialsDots"></div>
                    <button class="slider-btn" id="testimonialsNext" aria-label="Naechste Bewertung">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
