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

<section class="blog-tips" id="<?php echo esc_attr($block_id); ?>">

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

    <?php if ($posts_query->have_posts()) : ?>
        <div class="blog-grid">
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
                <article class="blog-card">
                    <div class="blog-image">
                        <?php if ($cat_label) : ?>
                            <span class="blog-category"><?php echo esc_html($cat_label); ?></span>
                        <?php endif; ?>

                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium_large', [
                                'loading' => 'lazy',
                            ]); ?>
                        <?php endif; ?>
                    </div>

                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><?php echo esc_html($post_date); ?></span>
                            <span><?php printf(
                                esc_html(_n('%d Min. Lesezeit', '%d Min. Lesezeit', $reading_time, 'toni-janis')),
                                $reading_time
                            ); ?></span>
                        </div>

                        <h3>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <?php if ($excerpt_text) : ?>
                            <p><?php echo esc_html(toja_truncate($excerpt_text, 140)); ?></p>
                        <?php endif; ?>

                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php esc_html_e('Weiterlesen', 'toni-janis'); ?> <span>&rarr;</span>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e('Noch keine Beitraege vorhanden.', 'toni-janis'); ?></p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</section>
