<?php
/**
 * Block: Video
 *
 * YouTube video embed with thumbnail/play button overlay.
 * Uses privacy-enhanced mode (youtube-nocookie.com).
 * Features grid displayed below the video.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label          = get_sub_field('video_label') ?: 'Videos';
$heading        = get_sub_field('video_heading');
$text           = get_sub_field('video_text');
$video_url      = get_sub_field('video_url');
$vorschaubild   = get_sub_field('video_vorschaubild');
$features       = get_sub_field('video_features');
$block_id       = toja_block_id('video');

if (empty($video_url)) {
    return;
}

// Extract YouTube video ID from various URL formats
$video_id = '';
if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video_url, $matches)) {
    $video_id = $matches[1];
}

if (empty($video_id)) {
    return;
}

// Thumbnail: custom or YouTube default
$thumbnail_url = '';
if ($vorschaubild && !empty($vorschaubild['url'])) {
    $thumbnail_url = $vorschaubild['url'];
} else {
    $thumbnail_url = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
}
?>

<section class="youtube-section" id="<?php echo esc_attr($block_id); ?>">

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
        x-data="{ playing: false }"
        class="video-hero-container"
    >
        <div class="video-hero-wrapper">
            <template x-if="!playing">
                <div @click="playing = true" style="cursor: pointer; position: absolute; inset: 0;">
                    <img
                        src="<?php echo esc_url($thumbnail_url); ?>"
                        alt="<?php echo esc_attr($heading ?: __('Video abspielen', 'toni-janis')); ?>"
                        loading="lazy"
                        style="width: 100%; height: 100%; object-fit: cover;"
                    >
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="40" fill="rgba(139,195,74,0.9)"/>
                            <path d="M32 24v32l24-16z" fill="white"/>
                        </svg>
                    </div>
                </div>
            </template>

            <template x-if="playing">
                <iframe
                    src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr($video_id); ?>?autoplay=1&rel=0"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    title="<?php echo esc_attr($heading ?: __('Video', 'toni-janis')); ?>"
                ></iframe>
            </template>
        </div>

        <?php if (!empty($features)) : ?>
            <div class="video-hero-info">
                <h3><?php echo esc_html($heading); ?></h3>
                <?php if ($text) : ?>
                    <p><?php echo esc_html($text); ?></p>
                <?php endif; ?>
                <div class="video-features">
                    <?php foreach ($features as $feature) :
                        $icon  = $feature['feature_icon'] ?? '';
                        $titel = $feature['feature_titel'] ?? '';
                        $ftext = $feature['feature_text'] ?? '';
                    ?>
                        <div class="video-feature">
                            <?php if ($icon) : ?>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 2L12.5 7.5L18 8.5L14 12.5L15 18L10 15.5L5 18L6 12.5L2 8.5L7.5 7.5L10 2Z" fill="currentColor"/>
                                </svg>
                            <?php endif; ?>
                            <?php if ($titel) : ?>
                                <span><?php echo esc_html($titel); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
