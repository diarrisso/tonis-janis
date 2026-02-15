<?php
/**
 * Block: Passion (Meine Leidenschaft)
 *
 * 2-column layout with content on the left (heading, quote, text)
 * and statistics cards on the right.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label       = get_sub_field('passion_label');
$heading     = get_sub_field('passion_heading');
$zitat       = get_sub_field('passion_zitat');
$texte       = get_sub_field('passion_texte');
$statistiken = get_sub_field('passion_statistiken');
$block_id    = toja_block_id('passion');
?>

<section class="passion" id="<?php echo esc_attr($block_id); ?>">
    <div class="passion-container">
        <!-- Content Column -->
        <div class="passion-content">
            <?php if ($label) : ?>
                <span class="section-label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($zitat) : ?>
                <p class="passion-quote"><?php echo esc_html($zitat); ?></p>
            <?php endif; ?>

            <?php if ($texte) : ?>
                <p class="passion-text"><?php echo wp_kses_post($texte); ?></p>
            <?php endif; ?>
        </div>

        <!-- Statistics Column -->
        <?php if ($statistiken) : ?>
            <div class="passion-stats">
                <?php foreach ($statistiken as $stat) :
                    $zahl      = $stat['stat_zahl'] ?? '';
                    $stat_label = $stat['stat_label'] ?? '';
                ?>
                    <?php if ($zahl || $stat_label) : ?>
                        <div class="stat-item">
                            <?php if ($zahl) : ?>
                                <div class="stat-number"><?php echo esc_html($zahl); ?></div>
                            <?php endif; ?>
                            <?php if ($stat_label) : ?>
                                <div class="stat-label"><?php echo esc_html($stat_label); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
