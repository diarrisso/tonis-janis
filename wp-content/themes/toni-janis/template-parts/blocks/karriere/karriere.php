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
$block_id   = toja_block_id('karriere');

// Query all published jobs
$jobs = new WP_Query([
    'post_type'      => 'toja_stellenangebot',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>

<section class="karriere" id="<?php echo esc_attr($block_id); ?>">
    <div class="karriere-container">

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

        <?php if ($jobs->have_posts()) : ?>
            <?php while ($jobs->have_posts()) : $jobs->the_post();
                $job_id            = get_the_ID();
                $job_titel         = get_the_title();
                $job_typ           = get_field('job_typ', $job_id) ?: '';
                $job_verfuegbar    = get_field('job_verfuegbarkeit', $job_id) ?: '';
                $job_aufgaben      = get_field('job_aufgaben', $job_id) ?: [];
                $job_anforderungen = get_field('job_anforderungen', $job_id) ?: [];
                $job_angebot       = get_field('job_angebot', $job_id) ?: [];
                $job_email         = get_field('job_email', $job_id) ?: toja_option('footer_email', get_option('admin_email'));
                $job_content       = get_the_content();
            ?>
                <div class="job-card" x-data="{ open: false }">
                    <!-- Job Header -->
                    <div class="job-header" @click="open = !open" role="button" tabindex="0" :aria-expanded="open" @keydown.enter.prevent="open = !open" @keydown.space.prevent="open = !open">
                        <div class="job-title-section">
                            <h3><?php echo esc_html($job_titel); ?></h3>
                            <div class="job-meta">
                                <?php if ($job_typ) : ?>
                                    <span class="job-badge featured"><?php echo esc_html($job_typ); ?></span>
                                <?php endif; ?>
                                <?php if ($job_verfuegbar) : ?>
                                    <span class="job-badge"><?php echo esc_html($job_verfuegbar); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <button class="job-toggle-btn" aria-label="<?php esc_attr_e('Details anzeigen', 'toni-janis'); ?>" type="button" @click.stop="open = !open">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Expandable Content -->
                    <div class="job-content" x-show="open" x-collapse x-cloak>
                        <!-- Job Description (from editor) -->
                        <?php if ($job_content) : ?>
                            <div class="job-section">
                                <?php echo wp_kses_post(apply_filters('the_content', $job_content)); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Aufgaben -->
                        <?php if (!empty($job_aufgaben)) : ?>
                            <div class="job-section">
                                <h4><?php esc_html_e('Deine Aufgaben:', 'toni-janis'); ?></h4>
                                <ul>
                                    <?php foreach ($job_aufgaben as $aufgabe) :
                                        $aufgabe_text = $aufgabe['aufgabe'] ?? '';
                                        if (empty($aufgabe_text)) continue;
                                    ?>
                                        <li><?php echo esc_html($aufgabe_text); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Anforderungen -->
                        <?php if (!empty($job_anforderungen)) : ?>
                            <div class="job-section">
                                <h4><?php esc_html_e('Das bringst du mit:', 'toni-janis'); ?></h4>
                                <ul>
                                    <?php foreach ($job_anforderungen as $anforderung) :
                                        $anf_text = $anforderung['anforderung'] ?? '';
                                        if (empty($anf_text)) continue;
                                    ?>
                                        <li><?php echo esc_html($anf_text); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Wir bieten -->
                        <?php if (!empty($job_angebot)) : ?>
                            <div class="job-section">
                                <h4><?php esc_html_e('Wir bieten:', 'toni-janis'); ?></h4>
                                <ul>
                                    <?php foreach ($job_angebot as $angebot) :
                                        $angebot_text = $angebot['angebot_item'] ?? '';
                                        if (empty($angebot_text)) continue;
                                    ?>
                                        <li><?php echo esc_html($angebot_text); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Apply Button -->
                        <div class="job-apply">
                            <a
                                href="mailto:<?php echo esc_attr($job_email); ?>?subject=<?php echo esc_attr(sprintf(__('Bewerbung als %s', 'toni-janis'), $job_titel)); ?>"
                                class="btn btn-primary"
                            >
                                <?php esc_html_e('Jetzt bewerben', 'toni-janis'); ?>
                                <span>&rarr;</span>
                            </a>
                            <p class="job-apply-info">
                                <?php esc_html_e('Oder per E-Mail an:', 'toni-janis'); ?>
                                <a href="mailto:<?php echo esc_attr($job_email); ?>"><?php echo esc_html($job_email); ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

        <?php else : ?>
            <div class="section-header">
                <h3><?php esc_html_e('Aktuell keine offenen Stellen', 'toni-janis'); ?></h3>
                <p><?php esc_html_e('Wir freuen uns trotzdem ueber Ihre Initiativbewerbung!', 'toni-janis'); ?></p>
                <?php $contact = toja_contact_info(); ?>
                <a
                    href="mailto:<?php echo esc_attr($contact['email']); ?>?subject=<?php echo esc_attr(__('Initiativbewerbung', 'toni-janis')); ?>"
                    class="btn btn-primary"
                >
                    <?php esc_html_e('Initiativbewerbung senden', 'toni-janis'); ?>
                    <span>&rarr;</span>
                </a>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
