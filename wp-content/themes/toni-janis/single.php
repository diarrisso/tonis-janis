<?php
/**
 * The template for displaying single posts
 *
 * @package ToniJanis
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <!-- Hero -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="relative h-64 md:h-96 overflow-hidden">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-earth-brown/60 to-transparent"></div>
                </div>
            <?php endif; ?>

            <div class="container mx-auto px-4 py-12">
                <header class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-heading font-bold text-earth-brown mb-4">
                        <?php the_title(); ?>
                    </h1>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                        <?php if (has_category()) : ?>
                            <span class="text-gray-300">|</span>
                            <?php the_category(', '); ?>
                        <?php endif; ?>
                    </div>
                </header>

                <div class="entry-content prose prose-lg max-w-none">
                    <?php the_content(); ?>
                </div>

                <!-- Post Navigation -->
                <nav class="mt-12 pt-8 border-t border-gray-200 flex justify-between" aria-label="<?php esc_attr_e('Beitragsnavigation', 'toni-janis'); ?>">
                    <div>
                        <?php previous_post_link('%link', '&laquo; %title'); ?>
                    </div>
                    <div>
                        <?php next_post_link('%link', '%title &raquo;'); ?>
                    </div>
                </nav>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
