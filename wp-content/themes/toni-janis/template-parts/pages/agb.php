<?php
/**
 * Template Part: Allgemeine Geschäftsbedingungen (AGB)
 *
 * @package ToniJanis
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('legal-page'); ?>>
    <div class="bg-cream py-16 sm:py-24">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <!-- Seitentitel -->
            <h1 class="text-3xl md:text-4xl font-heading font-bold text-kiwi-dark text-left mb-12">
                <?php the_title(); ?>
            </h1>

            <!-- Inhalt -->
            <div class="prose prose-lg max-w-none prose-headings:font-heading prose-headings:font-semibold prose-headings:text-earth-brown prose-h2:text-2xl prose-h2:mt-10 prose-h2:mb-4 prose-p:text-gray-600 prose-a:text-kiwi-dark hover:prose-a:text-kiwi-green">

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <?php if (get_the_content()): ?>
                        <?php the_content(); ?>
                    <?php endif; ?>

                <?php endwhile; endif; ?>

            </div>

        </div>
    </div>
</article>
