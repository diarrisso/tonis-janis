<?php
/**
 * Block: Services (Leistungen)
 *
 * Section header with responsive grid of service cards.
 * Each card has an icon, title, description, and link.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

$label    = get_sub_field('services_label');
$heading  = get_sub_field('services_heading');
$text     = get_sub_field('services_text');
$services = get_sub_field('services_liste');
$block_id = toja_block_id('services');

$allowed_svg = [
    'svg'  => ['class' => [], 'viewBox' => [], 'fill' => [], 'xmlns' => [], 'width' => [], 'height' => [], 'stroke' => [], 'stroke-width' => [], 'stroke-linecap' => [], 'stroke-linejoin' => []],
    'path' => ['d' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => [], 'stroke-linecap' => [], 'stroke-linejoin' => [], 'opacity' => []],
    'circle' => ['cx' => [], 'cy' => [], 'r' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => []],
    'rect' => ['x' => [], 'y' => [], 'width' => [], 'height' => [], 'rx' => [], 'ry' => [], 'fill' => [], 'stroke' => []],
    'line' => ['x1' => [], 'y1' => [], 'x2' => [], 'y2' => [], 'stroke' => [], 'stroke-width' => []],
    'polyline' => ['points' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => []],
    'polygon' => ['points' => [], 'fill' => [], 'stroke' => []],
    'g' => ['fill' => [], 'stroke' => [], 'transform' => []],
];
?>

<section id="<?php echo esc_attr($block_id); ?>" class="services">
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

    <?php if ($services) : ?>
        <div class="services-grid">
            <?php foreach ($services as $service) :
                $icon         = $service['service_icon'] ?? '';
                $titel        = $service['service_titel'] ?? '';
                $beschreibung = $service['service_beschreibung'] ?? '';
                $link         = $service['service_link'] ?? null;
                $link_url     = $link['url'] ?? '';
                $link_target  = $link['target'] ?? '';
                $data_service = sanitize_title($titel);
            ?>
                <div class="service-card">
                    <?php if ($icon) : ?>
                        <div class="service-icon">
                            <?php echo wp_kses($icon, $allowed_svg); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($titel) : ?>
                        <h3><?php echo esc_html($titel); ?></h3>
                    <?php endif; ?>

                    <?php if ($beschreibung) : ?>
                        <p><?php echo esc_html($beschreibung); ?></p>
                    <?php endif; ?>

                    <?php if ($link && $link_url) : ?>
                        <a
                            href="<?php echo esc_url($link_url); ?>"
                            class="service-link"
                            data-service="<?php echo esc_attr($data_service); ?>"
                            <?php echo $link_target ? 'target="' . esc_attr($link_target) . '" rel="noopener noreferrer"' : ''; ?>
                        >
                            <?php esc_html_e('Mehr erfahren', 'toni-janis'); ?>
                            <span>&rarr;</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
