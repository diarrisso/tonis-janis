<?php
/**
 * Block: Hero
 *
 * Standard variant: 2-column layout (text left, image right).
 * Fullscreen variant: Centered text on fullscreen background image.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

$variante        = get_sub_field('hero_variante') ?: 'standard';
$badge           = get_sub_field('hero_badge');
$titel           = get_sub_field('hero_titel');
$highlight       = get_sub_field('hero_highlight');
$text            = get_sub_field('hero_text');
$hintergrundbild = get_sub_field('hero_hintergrundbild');
$bild            = get_sub_field('hero_bild');
$button_primary  = get_sub_field('hero_button_primary');
$button_secondary = get_sub_field('hero_button_secondary');
$block_id        = toja_block_id('hero');

$is_fullscreen = ($variante === 'fullscreen');

$bg_image_url = '';
if ($is_fullscreen && $hintergrundbild) {
    $bg_image_url = $hintergrundbild['url'] ?? '';
}
?>

<?php if ($is_fullscreen) : ?>
    <section
        id="<?php echo esc_attr($block_id); ?>"
        class="hero-alt"
        <?php if ($bg_image_url) : ?>
            style="background-image: url('<?php echo esc_url($bg_image_url); ?>');"
        <?php endif; ?>
    >
        <div class="hero-container">
            <div class="hero-content">
                <?php if ($badge) : ?>
                    <div class="hero-badge"><?php echo esc_html($badge); ?></div>
                <?php endif; ?>

                <?php if ($titel || $highlight) : ?>
                    <h1>
                        <?php if ($titel) : ?>
                            <?php echo esc_html($titel); ?>
                        <?php endif; ?>
                        <?php if ($highlight) : ?>
                            <span><?php echo esc_html($highlight); ?></span>
                        <?php endif; ?>
                    </h1>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <p><?php echo esc_html($text); ?></p>
                <?php endif; ?>

                <?php if ($button_primary || $button_secondary) : ?>
                    <div class="hero-buttons">
                        <?php if ($button_primary) : ?>
                            <a href="<?php echo esc_url($button_primary['url']); ?>" class="btn btn-primary"<?php echo !empty($button_primary['target']) ? ' target="' . esc_attr($button_primary['target']) . '" rel="noopener noreferrer"' : ''; ?>>
                                <?php echo esc_html($button_primary['title']); ?>
                                <span>&rarr;</span>
                            </a>
                        <?php endif; ?>

                        <?php if ($button_secondary) : ?>
                            <a href="<?php echo esc_url($button_secondary['url']); ?>" class="btn btn-secondary"<?php echo !empty($button_secondary['target']) ? ' target="' . esc_attr($button_secondary['target']) . '" rel="noopener noreferrer"' : ''; ?>>
                                <?php echo esc_html($button_secondary['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="hero-scroll-indicator">
            <span><?php esc_html_e('Scrollen', 'toni-janis'); ?></span>
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 5V19M12 19L19 12M12 19L5 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </section>

<?php else : ?>
    <section
        id="<?php echo esc_attr($block_id); ?>"
        class="hero"
    >
        <div class="hero-container">
            <div class="hero-content">
                <?php if ($badge) : ?>
                    <div class="hero-badge"><?php echo esc_html($badge); ?></div>
                <?php endif; ?>

                <?php if ($titel || $highlight) : ?>
                    <h1>
                        <?php if ($titel) : ?>
                            <?php echo esc_html($titel); ?>
                        <?php endif; ?>
                        <?php if ($highlight) : ?>
                            <span><?php echo esc_html($highlight); ?></span>
                        <?php endif; ?>
                    </h1>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <p><?php echo esc_html($text); ?></p>
                <?php endif; ?>

                <?php if ($button_primary || $button_secondary) : ?>
                    <div class="hero-buttons">
                        <?php if ($button_primary) : ?>
                            <a href="<?php echo esc_url($button_primary['url']); ?>" class="btn btn-primary"<?php echo !empty($button_primary['target']) ? ' target="' . esc_attr($button_primary['target']) . '" rel="noopener noreferrer"' : ''; ?>>
                                <?php echo esc_html($button_primary['title']); ?>
                                <span>&rarr;</span>
                            </a>
                        <?php endif; ?>

                        <?php if ($button_secondary) : ?>
                            <a href="<?php echo esc_url($button_secondary['url']); ?>" class="btn btn-secondary"<?php echo !empty($button_secondary['target']) ? ' target="' . esc_attr($button_secondary['target']) . '" rel="noopener noreferrer"' : ''; ?>>
                                <?php echo esc_html($button_secondary['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($bild) : ?>
                <div class="hero-image">
                    <div class="hero-image-main">
                        <?php toja_image($bild, 'large', ['loading' => 'eager']); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php endif; ?>
