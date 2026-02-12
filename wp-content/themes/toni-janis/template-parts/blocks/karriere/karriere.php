<?php
/**
 * Block: Karriere (Stellenangebote)
 *
 * Expandable job listing cards pulled from toja_stellenangebot CPT.
 * Each card uses Alpine.js for expand/collapse.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('karriere_label');
$heading    = get_sub_field('karriere_heading');
$text       = get_sub_field('karriere_text');
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
$block_id   = toja_block_id('karriere');

// Query all published jobs
$jobs = new WP_Query([
    'post_type'      => 'toja_stellenangebot',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$job_count = $jobs->found_posts;
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('karriere')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
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

        <?php if ($jobs->have_posts()) : ?>
            <div class="max-w-4xl mx-auto space-y-6">
                <?php while ($jobs->have_posts()) : $jobs->the_post();
                    $job_id           = get_the_ID();
                    $job_titel        = get_the_title();
                    $job_typ          = get_field('job_typ', $job_id) ?: '';
                    $job_verfuegbar   = get_field('job_verfuegbarkeit', $job_id) ?: '';
                    $job_aufgaben     = get_field('job_aufgaben', $job_id) ?: [];
                    $job_anforderungen = get_field('job_anforderungen', $job_id) ?: [];
                    $job_angebot      = get_field('job_angebot', $job_id) ?: [];
                    $job_email        = get_field('job_email', $job_id) ?: toja_option('footer_email', get_option('admin_email'));
                    $job_content      = get_the_content();
                ?>
                    <div
                        x-data="{ open: false }"
                        class="border border-sand-beige rounded-2xl overflow-hidden bg-white transition-shadow duration-300 hover:shadow-lg"
                    >
                        <!-- Job Header -->
                        <button
                            @click="open = !open"
                            class="w-full flex flex-col sm:flex-row sm:items-center justify-between p-6 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-kiwi-dark focus-visible:ring-offset-2 gap-4"
                            :aria-expanded="open"
                        >
                            <div class="flex-1">
                                <h3 class="font-heading text-xl font-semibold text-kiwi-dark mb-2">
                                    <?php echo esc_html($job_titel); ?>
                                </h3>

                                <!-- Badges -->
                                <div class="flex flex-wrap gap-2">
                                    <?php if ($job_typ) : ?>
                                        <span class="inline-flex items-center gap-1 bg-kiwi-dark/10 text-kiwi-dark text-xs font-semibold px-3 py-1 rounded-full">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <?php echo esc_html($job_typ); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($job_verfuegbar) : ?>
                                        <span class="inline-flex items-center gap-1 bg-kiwi-green/10 text-kiwi-dark text-xs font-semibold px-3 py-1 rounded-full">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <?php echo esc_html($job_verfuegbar); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Toggle Icon -->
                            <div
                                class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all duration-300 flex-shrink-0"
                                :class="open ? 'bg-kiwi-dark border-kiwi-dark' : 'border-kiwi-dark/20 bg-transparent'"
                            >
                                <svg
                                    class="w-5 h-5 transition-transform duration-300"
                                    :class="open ? 'rotate-180 text-white' : 'text-kiwi-dark'"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Green Accent Line -->
                        <div
                            class="h-0.5 bg-gradient-to-r from-kiwi-dark to-kiwi-green transition-opacity duration-300"
                            :class="open ? 'opacity-100' : 'opacity-0'"
                        ></div>

                        <!-- Expandable Content -->
                        <div
                            x-show="open"
                            x-collapse
                            x-cloak
                        >
                            <div class="p-6 pt-4 space-y-6">
                                <!-- Job Description (from editor) -->
                                <?php if ($job_content) : ?>
                                    <div class="prose prose-sm max-w-none text-earth-brown/80">
                                        <?php echo wp_kses_post(apply_filters('the_content', $job_content)); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Aufgaben -->
                                <?php if (!empty($job_aufgaben)) : ?>
                                    <div>
                                        <h4 class="font-heading text-base font-semibold text-kiwi-dark mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                            </svg>
                                            <?php esc_html_e('Ihre Aufgaben', 'toni-janis'); ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <?php foreach ($job_aufgaben as $aufgabe) :
                                                $aufgabe_text = $aufgabe['aufgabe'] ?? '';
                                                if (empty($aufgabe_text)) continue;
                                            ?>
                                                <li class="flex items-start gap-2 text-earth-brown/80 text-sm">
                                                    <svg class="w-4 h-4 text-kiwi-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <?php echo esc_html($aufgabe_text); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Anforderungen -->
                                <?php if (!empty($job_anforderungen)) : ?>
                                    <div>
                                        <h4 class="font-heading text-base font-semibold text-kiwi-dark mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <?php esc_html_e('Was Sie mitbringen', 'toni-janis'); ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <?php foreach ($job_anforderungen as $anforderung) :
                                                $anf_text = $anforderung['anforderung'] ?? '';
                                                if (empty($anf_text)) continue;
                                            ?>
                                                <li class="flex items-start gap-2 text-earth-brown/80 text-sm">
                                                    <svg class="w-4 h-4 text-kiwi-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <?php echo esc_html($anf_text); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Wir bieten -->
                                <?php if (!empty($job_angebot)) : ?>
                                    <div>
                                        <h4 class="font-heading text-base font-semibold text-kiwi-dark mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                            </svg>
                                            <?php esc_html_e('Was wir bieten', 'toni-janis'); ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <?php foreach ($job_angebot as $angebot) :
                                                $angebot_text = $angebot['angebot_item'] ?? '';
                                                if (empty($angebot_text)) continue;
                                            ?>
                                                <li class="flex items-start gap-2 text-earth-brown/80 text-sm">
                                                    <svg class="w-4 h-4 text-kiwi-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <?php echo esc_html($angebot_text); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Apply Button -->
                                <div class="pt-4 border-t border-sand-beige">
                                    <a
                                        href="mailto:<?php echo esc_attr($job_email); ?>?subject=<?php echo esc_attr(sprintf(__('Bewerbung: %s', 'toni-janis'), $job_titel)); ?>"
                                        class="inline-flex items-center gap-2 bg-kiwi-dark text-white px-6 py-3 rounded-full font-semibold text-sm hover:bg-kiwi-green transition-colors duration-300"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <?php esc_html_e('Jetzt bewerben', 'toni-janis'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- No jobs hint -->
        <?php else : ?>
            <div class="max-w-2xl mx-auto text-center bg-cream rounded-2xl p-10 border border-sand-beige">
                <svg class="w-16 h-16 text-kiwi-dark/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="font-heading text-xl font-semibold text-kiwi-dark mb-2">
                    <?php esc_html_e('Aktuell keine offenen Stellen', 'toni-janis'); ?>
                </h3>
                <p class="text-earth-brown/70 mb-6">
                    <?php esc_html_e('Wir freuen uns trotzdem ueber Ihre Initiativbewerbung!', 'toni-janis'); ?>
                </p>
                <?php $contact = toja_contact_info(); ?>
                <a
                    href="mailto:<?php echo esc_attr($contact['email']); ?>?subject=<?php echo esc_attr(__('Initiativbewerbung', 'toni-janis')); ?>"
                    class="inline-flex items-center gap-2 bg-kiwi-dark text-white px-6 py-3 rounded-full font-semibold text-sm hover:bg-kiwi-green transition-colors duration-300"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <?php esc_html_e('Initiativbewerbung senden', 'toni-janis'); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
