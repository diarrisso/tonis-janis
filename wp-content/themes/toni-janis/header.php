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
            <?php
            $cta_primary_text = toja_option('header_cta_primary_text', 'Angebote');
            $cta_primary_url  = toja_option('header_cta_primary_url', home_url('/angebote'));
            $cta_secondary_text = toja_option('header_cta_secondary_text', 'Termin buchen');
            $cta_secondary_url  = toja_option('header_cta_secondary_url', home_url('/termin'));
            ?>
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
                    <!-- Dark Mode Toggle -->
                    <button
                        @click="$store.darkMode.toggle()"
                        class="p-2 rounded-lg text-earth-brown/60 hover:text-earth-brown hover:bg-gray-100 transition-colors"
                        aria-label="<?php esc_attr_e('Dark Mode umschalten', 'toni-janis'); ?>"
                    >
                        <template x-if="!$store.darkMode.on">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="4" fill="currentColor"/>
                                <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.07 7.07l-1.41-1.41M6.34 6.34L4.93 4.93m12.73 0l-1.41 1.41M6.34 17.66l-1.41 1.41" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </template>
                        <template x-if="$store.darkMode.on">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                            </svg>
                        </template>
                    </button>

                    <?php if ($cta_primary_text) : ?>
                        <a href="<?php echo esc_url($cta_primary_url); ?>" class="inline-flex items-center px-5 py-2.5 border-2 border-kiwi-green text-kiwi-green font-semibold rounded-lg hover:bg-kiwi-green hover:text-white transition-colors">
                            <?php echo esc_html($cta_primary_text); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($cta_secondary_text) : ?>
                        <a href="<?php echo esc_url($cta_secondary_url); ?>" class="inline-flex items-center px-5 py-2.5 bg-kiwi-green text-white font-semibold rounded-lg hover:bg-kiwi-dark transition-colors">
                            <?php echo esc_html($cta_secondary_text); ?>
                        </a>
                    <?php endif; ?>
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
                <!-- Dark Mode Toggle (Mobile) -->
                <div class="flex items-center gap-3 mt-4 pb-3 border-b border-gray-100">
                    <button
                        @click="$store.darkMode.toggle()"
                        class="p-2 rounded-lg text-earth-brown/60 hover:text-earth-brown hover:bg-gray-100 transition-colors"
                        aria-label="<?php esc_attr_e('Dark Mode umschalten', 'toni-janis'); ?>"
                    >
                        <template x-if="!$store.darkMode.on">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="4" fill="currentColor"/>
                                <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.07 7.07l-1.41-1.41M6.34 6.34L4.93 4.93m12.73 0l-1.41 1.41M6.34 17.66l-1.41 1.41" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </template>
                        <template x-if="$store.darkMode.on">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                            </svg>
                        </template>
                    </button>
                    <span class="text-sm text-earth-brown/60"><?php esc_html_e('Dark Mode', 'toni-janis'); ?></span>
                </div>

                <div class="flex flex-col gap-3 mt-4">
                    <?php if ($cta_primary_text) : ?>
                        <a href="<?php echo esc_url($cta_primary_url); ?>" class="text-center block px-5 py-3 border-2 border-kiwi-green text-kiwi-green font-semibold rounded-lg hover:bg-kiwi-green hover:text-white transition-colors">
                            <?php echo esc_html($cta_primary_text); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($cta_secondary_text) : ?>
                        <a href="<?php echo esc_url($cta_secondary_url); ?>" class="text-center block px-5 py-3 bg-kiwi-green text-white font-semibold rounded-lg hover:bg-kiwi-dark transition-colors">
                            <?php echo esc_html($cta_secondary_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
