<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package ToniJanis
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container mx-auto px-4 py-24 text-center">
        <h1 class="text-6xl md:text-8xl font-heading font-bold text-kiwi-green mb-4">404</h1>
        <h2 class="text-2xl md:text-3xl font-heading text-earth-brown mb-6">
            <?php esc_html_e('Seite nicht gefunden', 'toni-janis'); ?>
        </h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            <?php esc_html_e('Die gesuchte Seite existiert leider nicht. Vielleicht finden Sie hier, was Sie suchen:', 'toni-janis'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 bg-kiwi-green text-white px-6 py-3 rounded-full font-semibold hover:bg-kiwi-dark transition-colors">
            <?php esc_html_e('Zur Startseite', 'toni-janis'); ?>
        </a>
    </div>
</main>

<?php
get_footer();
