<?php
/**
 * The front page template
 *
 * @package ToniJanis
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            // Render ACF flexible content if available
            if (function_exists('have_rows') && have_rows('flexible_content')) :
                toja_render_flexible_content();
            else :
                the_content();
            endif;
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();
