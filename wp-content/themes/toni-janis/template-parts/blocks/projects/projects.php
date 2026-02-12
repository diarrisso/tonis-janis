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
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
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

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('projects')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
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

        <?php if ($projects->have_posts()) : ?>

            <!-- Filter Buttons -->
            <?php if ($show_filter && !empty($filter_terms)) : ?>
                <div
                    x-data="{ filter: 'alle' }"
                    x-ref="projectFilter"
                    class="mb-10"
                >
                    <div class="flex flex-wrap justify-center gap-3 mb-10">
                        <button
                            @click="filter = 'alle'; $dispatch('filter-change', { filter: 'alle' })"
                            :class="filter === 'alle' ? 'bg-kiwi-dark text-white' : 'bg-white text-earth-brown border border-sand-beige hover:border-kiwi-dark'"
                            class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300"
                        >
                            <?php esc_html_e('Alle Projekte', 'toni-janis'); ?>
                        </button>
                        <?php foreach ($filter_terms as $slug => $name) : ?>
                            <button
                                @click="filter = '<?php echo esc_attr($slug); ?>'; $dispatch('filter-change', { filter: '<?php echo esc_attr($slug); ?>' })"
                                :class="filter === '<?php echo esc_attr($slug); ?>' ? 'bg-kiwi-dark text-white' : 'bg-white text-earth-brown border border-sand-beige hover:border-kiwi-dark'"
                                class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300"
                            >
                                <?php echo esc_html($name); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Projects Grid -->
            <div
                x-data="{ activeFilter: 'alle' }"
                @filter-change.window="activeFilter = $event.detail.filter"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto"
            >
                <?php while ($projects->have_posts()) : $projects->the_post();
                    // Get project data
                    $project_id   = get_the_ID();
                    $standort     = get_field('projekt_standort', $project_id);
                    $flaeche      = get_field('projekt_flaeche', $project_id);
                    $dauer        = get_field('projekt_dauer', $project_id);
                    $badge        = get_field('projekt_badge', $project_id);
                    $tags         = get_field('projekt_tags', $project_id);
                    $excerpt_text = get_the_excerpt();

                    // Get category slugs for data attribute
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
                    <article
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-400 hover:-translate-y-1"
                        data-category="<?php echo esc_attr($cat_slugs_str); ?>"
                        x-show="activeFilter === 'alle' || '<?php echo esc_attr($cat_slugs_str); ?>'.includes(activeFilter)"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                    >
                        <!-- Thumbnail -->
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', [
                                    'class'   => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500',
                                    'loading' => 'lazy',
                                ]); ?>
                            <?php else : ?>
                                <div class="w-full h-full bg-gradient-to-br from-kiwi-light/30 to-kiwi-dark/20 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-kiwi-dark/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <!-- Category Badge -->
                            <?php if ($cat_name) : ?>
                                <span class="absolute top-4 left-4 bg-kiwi-dark/90 text-white text-xs font-semibold px-3 py-1 rounded-full backdrop-blur-sm">
                                    <?php echo esc_html($cat_name); ?>
                                </span>
                            <?php endif; ?>

                            <!-- Optional Badge -->
                            <?php if ($badge) : ?>
                                <span class="absolute top-4 right-4 bg-white/90 text-kiwi-dark text-xs font-semibold px-3 py-1 rounded-full backdrop-blur-sm">
                                    <?php echo esc_html($badge); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="font-heading text-xl font-semibold text-kiwi-dark mb-2 group-hover:text-kiwi-green transition-colors">
                                <a href="<?php the_permalink(); ?>" class="hover:underline">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <?php if ($excerpt_text) : ?>
                                <p class="text-earth-brown text-sm mb-4 line-clamp-2">
                                    <?php echo esc_html(toja_truncate($excerpt_text, 120)); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Meta Info -->
                            <?php if ($standort || $flaeche || $dauer) : ?>
                                <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500 mb-4">
                                    <?php if ($standort) : ?>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <?php echo esc_html($standort); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($flaeche) : ?>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                            </svg>
                                            <?php echo esc_html($flaeche); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($dauer) : ?>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <?php echo esc_html($dauer); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Tags -->
                            <?php if ($tags) : ?>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($tags as $tag) :
                                        $tag_name = $tag['tag_name'] ?? '';
                                        if (!$tag_name) continue;
                                    ?>
                                        <span class="inline-block bg-cream text-earth-brown text-xs px-2.5 py-1 rounded-full border border-sand-beige">
                                            <?php echo esc_html($tag_name); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

        <?php else : ?>
            <p class="text-center text-gray-500">
                <?php esc_html_e('Noch keine Projekte vorhanden.', 'toni-janis'); ?>
            </p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
