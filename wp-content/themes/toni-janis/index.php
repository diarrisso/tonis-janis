<?php
/**
 * The main template file
 *
 * @package ToniJanis
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php if (have_posts()) : ?>
        <div class="container mx-auto px-4 py-12">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>
                    <h2 class="text-2xl font-heading font-bold mb-4">
                        <a href="<?php the_permalink(); ?>" class="text-earth-brown hover:text-kiwi-dark transition-colors">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="entry-content prose">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <div class="pagination mt-12">
                <?php the_posts_pagination([
                    'mid_size' => 2,
                    'prev_text' => __('&laquo; Zurück', 'toni-janis'),
                    'next_text' => __('Weiter &raquo;', 'toni-janis'),
                ]); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="container mx-auto px-4 py-12 text-center">
            <h2 class="text-2xl font-heading"><?php esc_html_e('Keine Beiträge gefunden.', 'toni-janis'); ?></h2>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
