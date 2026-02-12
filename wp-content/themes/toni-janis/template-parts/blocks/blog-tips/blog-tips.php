<?php
/**
 * Block: Blog Tips (Gartentipps & Wissen)
 *
 * Responsive grid of blog post cards pulled from native WordPress Posts.
 * Optional category filter.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('blog_label');
$heading    = get_sub_field('blog_heading');
$text       = get_sub_field('blog_text');
$anzahl     = get_sub_field('blog_anzahl') ?: 3;
$kategorie  = get_sub_field('blog_kategorie');
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
$block_id   = toja_block_id('blog-tips');

// Build WP_Query args
$query_args = [
    'post_type'      => 'post',
    'posts_per_page' => (int) $anzahl,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'ignore_sticky_posts' => true,
];

// Filter by selected category
if (!empty($kategorie)) {
    $query_args['cat'] = (int) $kategorie;
}

$posts_query = new WP_Query($query_args);
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('blog-tips')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
>
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <?php if ($label || $heading || $text) : ?>
            <div class="text-center max-w-2xl mx-auto mb-12">
                <?php if ($label) : ?>
                    <span class="inline-block text-sm uppercase tracking-widest text-kiwi-accent font-semibold mb-4">
                        <?php echo esc_html($label); ?>
                    </span>
                <?php endif; ?>

                <?php if ($heading) : ?>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-kiwi-dark mb-4">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <p class="text-earth-brown text-lg">
                        <?php echo esc_html($text); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($posts_query->have_posts()) : ?>
            <!-- Blog Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <?php while ($posts_query->have_posts()) : $posts_query->the_post();
                    $post_id      = get_the_ID();
                    $post_date    = get_the_date('d. F Y');
                    $categories   = get_the_category();
                    $cat_label    = !empty($categories) ? $categories[0]->name : '';
                    $excerpt_text = get_the_excerpt();

                    // Estimate reading time
                    $word_count   = str_word_count(wp_strip_all_tags(get_the_content()));
                    $reading_time = max(1, ceil($word_count / 200));
                ?>
                    <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-400 hover:-translate-y-1">
                        <!-- Image -->
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', [
                                    'class'   => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500',
                                    'loading' => 'lazy',
                                ]); ?>
                            <?php else : ?>
                                <div class="w-full h-full bg-gradient-to-br from-kiwi-light/30 to-kiwi-dark/20 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-kiwi-dark/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <!-- Category Badge -->
                            <?php if ($cat_label) : ?>
                                <span class="absolute top-4 left-4 bg-kiwi-dark/90 text-white text-xs font-semibold px-3 py-1 rounded-full backdrop-blur-sm">
                                    <?php echo esc_html($cat_label); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Meta: Date + Reading Time -->
                            <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo esc_html($post_date); ?>
                                </time>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <?php printf(
                                        esc_html(_n('%d Min. Lesezeit', '%d Min. Lesezeit', $reading_time, 'toni-janis')),
                                        $reading_time
                                    ); ?>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="font-heading text-lg font-semibold text-kiwi-dark mb-2 group-hover:text-kiwi-green transition-colors line-clamp-2">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <?php if ($excerpt_text) : ?>
                                <p class="text-earth-brown/80 text-sm mb-4 line-clamp-3">
                                    <?php echo esc_html(toja_truncate($excerpt_text, 140)); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Read More -->
                            <a
                                href="<?php the_permalink(); ?>"
                                class="inline-flex items-center gap-2 text-kiwi-dark font-semibold text-sm group-hover:gap-3 transition-all duration-300"
                            >
                                <?php esc_html_e('Weiterlesen', 'toni-janis'); ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-center text-gray-500">
                <?php esc_html_e('Noch keine Beitraege vorhanden.', 'toni-janis'); ?>
            </p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
