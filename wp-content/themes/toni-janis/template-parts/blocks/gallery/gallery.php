<?php
/**
 * Block: Galerie
 *
 * Image gallery with custom JS slider.
 * Items are grouped into slides of 3.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('gallery_label');
$heading  = get_sub_field('gallery_heading');
$text     = get_sub_field('gallery_text');
$bilder   = get_sub_field('gallery_bilder');
$block_id = toja_block_id('gallery');

if (empty($bilder)) {
    return;
}

// Chunk gallery items into slides of 3
$slides = array_chunk($bilder, 3);
?>

<section class="gallery" id="<?php echo esc_attr($block_id); ?>">
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

    <div class="gallery-slider slider-container">
        <div class="slider-wrapper" id="gallerySliderWrapper">
            <?php foreach ($slides as $slide_index => $slide_items) : ?>
                <div class="gallery-slide">
                    <?php foreach ($slide_items as $bild) :
                        $img_url     = $bild['url'] ?? '';
                        $img_title   = $bild['title'] ?? '';
                        $img_desc    = $bild['description'] ?? ($bild['caption'] ?? '');
                        $img_alt     = $bild['alt'] ?? '';
                    ?>
                        <div class="gallery-slide-item" style="background-image: url('<?php echo esc_url($img_url); ?>');">
                            <div class="gallery-item-overlay">
                                <?php if ($img_title) : ?>
                                    <h4><?php echo esc_html($img_title); ?></h4>
                                <?php endif; ?>
                                <?php if ($img_desc) : ?>
                                    <p><?php echo esc_html($img_desc); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($slides) > 1) : ?>
            <div class="slider-controls">
                <button class="slider-btn" id="galleryPrev" aria-label="Vorheriges Bild">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="slider-dots" id="galleryDots"></div>
                <button class="slider-btn" id="galleryNext" aria-label="Naechstes Bild">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>
