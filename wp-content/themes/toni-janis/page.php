<?php
/**
 * The template for displaying pages
 *
 * @package ToniJanis
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if (!toja_is_flexible_content_page()) : ?>
                <div class="container mx-auto px-4 py-12">
                    <h1 class="text-4xl md:text-5xl font-heading font-bold text-earth-brown mb-8">
                        <?php the_title(); ?>
                    </h1>
                    <div class="entry-content prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php else : ?>
                <?php toja_render_flexible_content(); ?>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
