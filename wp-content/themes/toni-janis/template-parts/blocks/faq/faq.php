<?php
/**
 * Block: FAQ (Haeufige Fragen)
 *
 * Accordion list controlled by JavaScript (.active class toggle).
 * Supports both CPT (toja_faq) and manual repeater data source.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('faq_label');
$heading  = get_sub_field('faq_heading');
$text     = get_sub_field('faq_text');
$quelle   = get_sub_field('faq_quelle') ?: 'cpt';
$anzahl   = get_sub_field('faq_anzahl') ?: 6;
$manuell  = get_sub_field('faq_manuell');
$block_id = toja_block_id('faq');

// Build normalized FAQ array
$faqs = [];

if ($quelle === 'cpt') {
    $query = new WP_Query([
        'post_type'      => 'toja_faq',
        'posts_per_page' => (int) $anzahl,
        'post_status'    => 'publish',
        'meta_key'       => 'faq_reihenfolge',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $faqs[] = [
                'frage'   => get_the_title(),
                'antwort' => apply_filters('the_content', get_the_content()),
            ];
        }
    }
    wp_reset_postdata();
} elseif ($quelle === 'manuell' && $manuell) {
    foreach ($manuell as $item) {
        $faqs[] = [
            'frage'   => $item['faq_frage'] ?? '',
            'antwort' => $item['faq_antwort'] ?? '',
        ];
    }
}

$total = count($faqs);

if ($total === 0 && !$label && !$heading) {
    return;
}
?>

<section class="faq-section" id="<?php echo esc_attr($block_id); ?>">
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

    <?php if ($total > 0) : ?>
        <div class="faq-container">
            <?php foreach ($faqs as $index => $faq) :
                $frage   = $faq['frage'];
                $antwort = $faq['antwort'];

                if (empty($frage)) continue;
            ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo esc_html($frage); ?></h3>
                        <div class="faq-icon">+</div>
                    </div>
                    <div class="faq-answer">
                        <?php echo wp_kses_post($antwort); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- FAQ Schema (JSON-LD) -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                <?php
                $schema_items = [];
                foreach ($faqs as $faq) {
                    if (empty($faq['frage'])) continue;
                    $schema_items[] = '{
                        "@type": "Question",
                        "name": ' . wp_json_encode($faq['frage']) . ',
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": ' . wp_json_encode(wp_strip_all_tags($faq['antwort'])) . '
                        }
                    }';
                }
                echo implode(",\n                ", $schema_items);
                ?>
            ]
        }
        </script>
    <?php endif; ?>
</section>
