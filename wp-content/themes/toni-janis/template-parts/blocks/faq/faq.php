<?php
/**
 * Block: FAQ (Haeufige Fragen)
 *
 * Accordion list powered by Alpine.js.
 * Supports both CPT (toja_faq) and manual repeater data source.
 * CPT: Title = Question, Content = Answer, ordered by faq_reihenfolge meta.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('faq_label');
$heading    = get_sub_field('faq_heading');
$text       = get_sub_field('faq_text');
$quelle     = get_sub_field('faq_quelle') ?: 'cpt';
$anzahl     = get_sub_field('faq_anzahl') ?: 6;
$manuell    = get_sub_field('faq_manuell');
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
$block_id   = toja_block_id('faq');

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

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('faq')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
>
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <?php if ($label || $heading || $text) : ?>
            <div class="text-center max-w-2xl mx-auto mb-12">
                <?php if ($label) : ?>
                    <span class="inline-block text-sm uppercase tracking-widest text-kiwi-accent font-semibold mb-4">
                        <?php echo esc_html($label); ?>
                    </span>
                <?php endif; ?>

                <?php if ($heading) : ?>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-kiwi-dark mb-4">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <p class="text-earth-brown text-lg">
                        <?php echo esc_html($text); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($total > 0) : ?>
            <!-- Accordion -->
            <div
                x-data="{ open: null }"
                class="max-w-3xl mx-auto divide-y divide-sand-beige"
            >
                <?php foreach ($faqs as $index => $faq) :
                    $frage   = $faq['frage'];
                    $antwort = $faq['antwort'];

                    if (empty($frage)) continue;
                ?>
                    <div class="group">
                        <!-- Question Button -->
                        <button
                            @click="open === <?php echo $index; ?> ? open = null : open = <?php echo $index; ?>"
                            class="w-full flex items-center justify-between py-5 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-kiwi-dark focus-visible:ring-offset-2 rounded-lg"
                            :aria-expanded="open === <?php echo $index; ?>"
                            aria-controls="faq-answer-<?php echo esc_attr($block_id . '-' . $index); ?>"
                        >
                            <span class="font-heading text-lg font-semibold text-earth-brown pr-4 group-hover:text-kiwi-dark transition-colors">
                                <?php echo esc_html($frage); ?>
                            </span>
                            <span class="flex-shrink-0 w-8 h-8 rounded-full border-2 border-kiwi-dark/20 flex items-center justify-center transition-all duration-300"
                                :class="open === <?php echo $index; ?> ? 'bg-kiwi-dark border-kiwi-dark rotate-45' : 'bg-transparent'"
                            >
                                <svg
                                    class="w-4 h-4 transition-colors duration-300"
                                    :class="open === <?php echo $index; ?> ? 'text-white' : 'text-kiwi-dark'"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"></path>
                                </svg>
                            </span>
                        </button>

                        <!-- Answer -->
                        <div
                            id="faq-answer-<?php echo esc_attr($block_id . '-' . $index); ?>"
                            x-show="open === <?php echo $index; ?>"
                            x-collapse
                            x-cloak
                        >
                            <div class="pb-6 pr-12 text-earth-brown/80 leading-relaxed prose prose-sm max-w-none">
                                <?php echo wp_kses_post($antwort); ?>
                            </div>
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
                    echo implode(",\n                    ", $schema_items);
                    ?>
                ]
            }
            </script>
        <?php else : ?>
            <p class="text-center text-gray-500">
                <?php esc_html_e('Noch keine FAQs vorhanden.', 'toni-janis'); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
