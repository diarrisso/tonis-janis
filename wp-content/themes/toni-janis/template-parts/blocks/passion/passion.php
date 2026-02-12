<?php
/**
 * Block: Passion (Meine Leidenschaft)
 *
 * 2-column layout with content on the left (heading, quote, text)
 * and statistics cards on the right.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label       = get_sub_field('passion_label');
$heading     = get_sub_field('passion_heading');
$zitat       = get_sub_field('passion_zitat');
$texte       = get_sub_field('passion_texte');
$statistiken = get_sub_field('passion_statistiken');
$bg_variant  = get_sub_field('background_variant') ?: 'white';
$spacing     = get_sub_field('block_spacing') ?: 'medium';
$block_id    = toja_block_id('passion');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('passion')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>"
>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start max-w-6xl mx-auto">
            <!-- Content Column -->
            <div>
                <?php if ($label) : ?>
                    <span class="inline-block text-sm uppercase tracking-widest text-kiwi-accent font-semibold mb-4">
                        <?php echo esc_html($label); ?>
                    </span>
                <?php endif; ?>

                <?php if ($heading) : ?>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-kiwi-dark mb-6 leading-tight">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($zitat) : ?>
                    <blockquote class="border-l-4 border-kiwi-green pl-6 mb-8">
                        <p class="text-xl md:text-2xl font-heading text-kiwi-dark italic leading-relaxed">
                            <?php echo esc_html($zitat); ?>
                        </p>
                    </blockquote>
                <?php endif; ?>

                <?php if ($texte) : ?>
                    <div class="prose prose-lg text-earth-brown max-w-none">
                        <?php echo wp_kses_post($texte); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Statistics Column -->
            <?php if ($statistiken) : ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php foreach ($statistiken as $stat) :
                        $zahl = $stat['stat_zahl'] ?? '';
                        $stat_label = $stat['stat_label'] ?? '';
                    ?>
                        <?php if ($zahl || $stat_label) : ?>
                            <div class="bg-cream border border-kiwi-dark/10 rounded-2xl p-6 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-kiwi-dark/5">
                                <?php if ($zahl) : ?>
                                    <div class="font-heading text-4xl md:text-5xl font-bold text-kiwi-dark mb-2">
                                        <?php echo esc_html($zahl); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($stat_label) : ?>
                                    <div class="text-earth-brown text-sm font-medium uppercase tracking-wider">
                                        <?php echo esc_html($stat_label); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
