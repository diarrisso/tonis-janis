<?php
/**
 * Block Template
 *
 * Copy and rename this file along with the directory.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

$heading    = get_sub_field('heading');
$text       = get_sub_field('text');
$image      = get_sub_field('image');
$button     = get_sub_field('button');
$bg_variant = get_sub_field('background_variant') ?: 'white';
$spacing    = get_sub_field('block_spacing') ?: 'medium';
$block_id   = toja_block_id('block-template');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr(toja_block_classes('block-template')); ?> <?php echo esc_attr(toja_bg_class($bg_variant)); ?> <?php echo esc_attr(toja_spacing_class($spacing)); ?>">
    <div class="container mx-auto px-4">
        <?php if ($heading) : ?>
            <?php toja_component('heading', ['text' => $heading, 'tag' => 'h2']); ?>
        <?php endif; ?>

        <?php if ($text) : ?>
            <div class="prose prose-lg max-w-none">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>

        <?php if ($image) : ?>
            <?php toja_component('image', ['image' => $image]); ?>
        <?php endif; ?>

        <?php if ($button) : ?>
            <div class="mt-8">
                <?php toja_component('button', ['link' => $button]); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
