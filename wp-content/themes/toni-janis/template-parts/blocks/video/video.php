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

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('video', ['py-12 md:py-20'])); ?>"
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

        <!-- Video Container -->
        <div
            x-data="{ playing: false }"
            class="max-w-4xl mx-auto mb-12"
        >
            <div class="relative overflow-hidden rounded-2xl shadow-xl aspect-video bg-charcoal">
                <!-- Thumbnail + Play Button -->
                <template x-if="!playing">
                    <div
                        class="absolute inset-0 cursor-pointer group"
                        @click="playing = true"
                    >
                        <img
                            src="<?php echo esc_url($thumbnail_url); ?>"
                            alt="<?php echo esc_attr($heading ?: __('Video abspielen', 'toni-janis')); ?>"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >

                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors duration-300"></div>

                        <!-- Play Button -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-kiwi-green rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 md:w-10 md:h-10 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- YouTube Iframe (privacy-enhanced mode) -->
                <template x-if="playing">
                    <iframe
                        src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr($video_id); ?>?autoplay=1&rel=0"
                        class="absolute inset-0 w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        title="<?php echo esc_attr($heading ?: __('Video', 'toni-janis')); ?>"
                    ></iframe>
                </template>
            </div>
        </div>

        <!-- Features Grid -->
        <?php if (!empty($features)) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr(min(count($features), 4)); ?> gap-6 max-w-5xl mx-auto">
                <?php foreach ($features as $feature) :
                    $icon  = $feature['feature_icon'] ?? '';
                    $titel = $feature['feature_titel'] ?? '';
                    $ftext = $feature['feature_text'] ?? '';
                ?>
                    <div class="text-center p-6 bg-cream rounded-xl">
                        <?php if ($icon) : ?>
                            <div class="w-12 h-12 mx-auto mb-4 text-kiwi-green flex items-center justify-center">
                                <?php echo $icon; // SVG code, already contains markup ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($titel) : ?>
                            <h3 class="font-heading font-bold text-earth-brown mb-2">
                                <?php echo esc_html($titel); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($ftext) : ?>
                            <p class="text-earth-brown/70 text-sm">
                                <?php echo esc_html($ftext); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
