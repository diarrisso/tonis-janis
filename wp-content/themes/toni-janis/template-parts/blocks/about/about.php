<?php
/**
 * Block: About (Über uns)
 *
 * 2-column layout with image and experience badge on the left,
 * content with features list on the right.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label          = get_sub_field('about_label');
$heading        = get_sub_field('about_heading');
$texte          = get_sub_field('about_texte');
$bild           = get_sub_field('about_bild');
$erfahrung_zahl = get_sub_field('about_erfahrung_zahl');
$erfahrung_text = get_sub_field('about_erfahrung_text');
$features       = get_sub_field('about_features');
$button         = get_sub_field('about_button');
$block_id       = toja_block_id('about');
?>

<section class="about" id="<?php echo esc_attr($block_id); ?>">
    <div class="about-container">
        <!-- Image Column -->
        <div class="about-image">
            <?php if ($bild) : ?>
                <div class="about-image-main">
                    <?php toja_image($bild, 'large', [
                        'alt' => $heading ? $heading : 'Über uns',
                    ]); ?>
                </div>

                <?php if ($erfahrung_zahl || $erfahrung_text) : ?>
                    <div class="experience-badge">
                        <?php if ($erfahrung_zahl) : ?>
                            <strong><?php echo esc_html($erfahrung_zahl); ?></strong>
                        <?php endif; ?>
                        <?php if ($erfahrung_text) : ?>
                            <span><?php echo wp_kses_post($erfahrung_text); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Content Column -->
        <div class="about-content">
            <?php if ($label) : ?>
                <span class="section-label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($texte) : ?>
                <?php echo wp_kses_post($texte); ?>
            <?php endif; ?>

            <?php if ($features) : ?>
                <div class="about-features">
                    <?php foreach ($features as $feature) :
                        $icon       = $feature['feature_icon'] ?? '✓';
                        $feat_titel = $feature['feature_titel'] ?? '';
                        $feat_text  = $feature['feature_text'] ?? '';
                    ?>
                        <?php if ($feat_titel || $feat_text) : ?>
                            <div class="about-feature">
                                <div class="about-feature-icon"><?php echo esc_html($icon); ?></div>
                                <div class="about-feature-text">
                                    <?php if ($feat_titel) : ?>
                                        <strong><?php echo esc_html($feat_titel); ?></strong>
                                    <?php endif; ?>
                                    <?php if ($feat_text) : ?>
                                        <span><?php echo esc_html($feat_text); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($button) :
                $btn_url   = $button['url'] ?? '#';
                $btn_title = $button['title'] ?? 'Jetzt Beratung anfragen';
                $btn_target = $button['target'] ?? '';
            ?>
                <a href="<?php echo esc_url($btn_url); ?>" class="btn btn-primary"<?php echo $btn_target ? ' target="' . esc_attr($btn_target) . '" rel="noopener noreferrer"' : ''; ?>>
                    <?php echo esc_html($btn_title); ?> <span>&rarr;</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
