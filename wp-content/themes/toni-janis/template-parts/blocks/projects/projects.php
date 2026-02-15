<?php
/**
 * Block: Projects (Projekte)
 *
 * Responsive grid of project cards pulled from toja_projekt CPT.
 * Features Alpine.js-powered category filter buttons.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label      = get_sub_field('projects_label');
$heading    = get_sub_field('projects_heading');
$text       = get_sub_field('projects_text');
$anzahl     = get_sub_field('projects_anzahl') ?: 6;
$show_filter = get_sub_field('projects_filter');
$kategorien = get_sub_field('projects_kategorien');
$block_id   = toja_block_id('projects');

// Build WP_Query args
$query_args = [
    'post_type'      => 'toja_projekt',
    'posts_per_page' => (int) $anzahl,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

// Filter by selected categories
if (!empty($kategorien) && is_array($kategorien)) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'toja_projekt_kategorie',
            'field'    => 'term_id',
            'terms'    => $kategorien,
        ],
    ];
}

$projects = new WP_Query($query_args);

// Collect unique category terms for filter buttons
$filter_terms = [];
if ($show_filter && $projects->have_posts()) {
    $temp_posts = $projects->posts;
    foreach ($temp_posts as $p) {
        $terms = get_the_terms($p->ID, 'toja_projekt_kategorie');
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $filter_terms[$term->slug] = $term->name;
            }
        }
    }
    asort($filter_terms);
}
?>

<section class="projects-section" id="<?php echo esc_attr($block_id); ?>">

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

    <?php if ($projects->have_posts()) : ?>

        <?php if ($show_filter && !empty($filter_terms)) : ?>
            <div
                x-data="{ filter: 'alle' }"
                x-ref="projectFilter"
                class="projects-filters"
            >
                <button
                    @click="filter = 'alle'; $dispatch('filter-change', { filter: 'alle' })"
                    :class="filter === 'alle' ? 'active' : ''"
                    class="filter-btn"
                    data-filter="alle"
                >
                    <?php esc_html_e('Alle Projekte', 'toni-janis'); ?>
                </button>
                <?php foreach ($filter_terms as $slug => $name) : ?>
                    <button
                        @click="filter = '<?php echo esc_attr($slug); ?>'; $dispatch('filter-change', { filter: '<?php echo esc_attr($slug); ?>' })"
                        :class="filter === '<?php echo esc_attr($slug); ?>' ? 'active' : ''"
                        class="filter-btn"
                        data-filter="<?php echo esc_attr($slug); ?>"
                    >
                        <?php echo esc_html($name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div
            x-data="{ activeFilter: 'alle' }"
            @filter-change.window="activeFilter = $event.detail.filter"
            class="projects-grid"
        >
            <?php while ($projects->have_posts()) : $projects->the_post();
                $project_id   = get_the_ID();
                $standort     = get_field('projekt_standort', $project_id);
                $flaeche      = get_field('projekt_flaeche', $project_id);
                $dauer        = get_field('projekt_dauer', $project_id);
                $badge        = get_field('projekt_badge', $project_id);
                $tags         = get_field('projekt_tags', $project_id);
                $excerpt_text = get_the_excerpt();

                $cat_terms = get_the_terms($project_id, 'toja_projekt_kategorie');
                $cat_slugs = [];
                $cat_name  = '';
                if ($cat_terms && !is_wp_error($cat_terms)) {
                    foreach ($cat_terms as $ct) {
                        $cat_slugs[] = $ct->slug;
                    }
                    $cat_name = $cat_terms[0]->name;
                }
                $cat_slugs_str = implode(' ', $cat_slugs);
            ?>
                <div
                    class="project-card"
                    data-category="<?php echo esc_attr($cat_slugs_str); ?>"
                    x-show="activeFilter === 'alle' || '<?php echo esc_attr($cat_slugs_str); ?>'.includes(activeFilter)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                >
                    <div class="project-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', [
                                'loading' => 'lazy',
                            ]); ?>
                        <?php endif; ?>

                        <?php if ($badge) : ?>
                            <span class="project-badge"><?php echo esc_html($badge); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="project-content">
                        <?php if ($cat_name) : ?>
                            <div class="project-category"><?php echo esc_html($cat_name); ?></div>
                        <?php endif; ?>

                        <h3>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <?php if ($excerpt_text) : ?>
                            <p><?php echo esc_html(toja_truncate($excerpt_text, 120)); ?></p>
                        <?php endif; ?>

                        <?php if ($standort || $flaeche || $dauer) : ?>
                            <div class="project-meta">
                                <?php if ($standort) : ?>
                                    <div class="project-meta-item">
                                        <span>&#128205;</span>
                                        <span><?php echo esc_html($standort); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($flaeche) : ?>
                                    <div class="project-meta-item">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 3l18 18M3 21V3h18"/>
                                            <path d="M7 7v2M11 7v4M15 7v6M19 7v8"/>
                                        </svg>
                                        <span><?php echo esc_html($flaeche); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($dauer) : ?>
                                    <div class="project-meta-item">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="13" r="8"/>
                                            <path d="M12 9v4l2 2"/>
                                            <path d="M16.5 3.5l-1 1M7.5 3.5l1 1"/>
                                        </svg>
                                        <span><?php echo esc_html($dauer); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($tags) : ?>
                            <div class="project-tags">
                                <?php foreach ($tags as $tag) :
                                    $tag_name = $tag['tag_name'] ?? '';
                                    if (!$tag_name) continue;
                                ?>
                                    <span class="project-tag"><?php echo esc_html($tag_name); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    <?php else : ?>
        <p><?php esc_html_e('Noch keine Projekte vorhanden.', 'toni-janis'); ?></p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</section>
