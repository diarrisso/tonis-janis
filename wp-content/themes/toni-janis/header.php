<?php
/**
 * The header template
 *
 * @package ToniJanis
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-cream text-charcoal font-body antialiased'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-kiwi-green focus:text-white focus:px-4 focus:py-2 focus:rounded" href="#main-content">
        <?php esc_html_e('Zum Inhalt springen', 'toni-janis'); ?>
    </a>

    <header id="site-header" class="site-header sticky top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm transition-all duration-300" x-data="{ mobileOpen: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 50)">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between" :class="scrolled ? 'h-16' : 'h-20'" style="transition: height 0.3s ease;">
                <!-- Logo -->
                <div class="site-branding flex-shrink-0">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-heading font-bold text-earth-brown hover:text-kiwi-dark transition-colors">
                            <?php bloginfo('name'); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Desktop Navigation -->
                <nav id="site-navigation" class="main-navigation hidden lg:flex items-center gap-8" aria-label="<?php esc_attr_e('Hauptmenü', 'toni-janis'); ?>">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class'     => 'flex items-center gap-6 list-none m-0 p-0',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 2,
                    ]);
                    ?>
                    <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn-primary inline-flex items-center px-5 py-2.5 bg-kiwi-green text-white font-semibold rounded-lg hover:bg-kiwi-dark transition-colors">
                        <?php esc_html_e('Kontakt', 'toni-janis'); ?>
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden p-2 text-earth-brown hover:text-kiwi-green transition-colors" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-controls="mobile-menu" aria-label="<?php esc_attr_e('Menü öffnen', 'toni-janis'); ?>">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden overflow-hidden transition-all duration-300" x-show="mobileOpen" x-collapse x-cloak @click.away="mobileOpen = false">
            <div class="container mx-auto px-4 py-4 border-t border-gray-100">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'flex flex-col gap-3 list-none m-0 p-0',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'depth'          => 2,
                ]);
                ?>
                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="mt-4 btn-primary text-center block px-5 py-3 bg-kiwi-green text-white font-semibold rounded-lg hover:bg-kiwi-dark transition-colors">
                    <?php esc_html_e('Kontakt', 'toni-janis'); ?>
                </a>
            </div>
        </div>
    </header>
