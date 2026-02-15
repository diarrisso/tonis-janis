<?php
/**
 * Block: Process (Arbeitsprozess)
 *
 * Section header with a grid of step cards.
 * Each card has a numbered circle, title, and description.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('process_label');
$heading  = get_sub_field('process_heading');
$text     = get_sub_field('process_text');
$schritte = get_sub_field('process_schritte');
$block_id = toja_block_id('process');
?>

<section class="process" id="<?php echo esc_attr($block_id); ?>">
    <!-- Section Header -->
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

    <!-- Process Steps -->
    <?php if ($schritte) : ?>
        <div class="process-steps">
            <?php
            $step_number = 0;
            foreach ($schritte as $schritt) :
                $step_number++;
                $titel        = $schritt['schritt_titel'] ?? '';
                $beschreibung = $schritt['schritt_beschreibung'] ?? '';
            ?>
                <div class="step">
                    <div class="step-number-circle"><?php echo esc_html($step_number); ?></div>

                    <?php if ($titel) : ?>
                        <h3><?php echo esc_html($titel); ?></h3>
                    <?php endif; ?>

                    <?php if ($beschreibung) : ?>
                        <p><?php echo esc_html($beschreibung); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
