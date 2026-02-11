<?php
/**
 * The footer template
 *
 * @package ToniJanis
 */
?>

    <footer id="site-footer" class="site-footer bg-earth-brown text-white mt-auto">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-lg font-heading font-bold mb-4 text-kiwi-light">
                        <?php bloginfo('name'); ?>
                    </h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        <?php bloginfo('description'); ?>
                    </p>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-heading font-bold mb-4 text-kiwi-light">
                        <?php esc_html_e('Kontakt', 'toni-janis'); ?>
                    </h3>
                    <address class="not-italic text-sm text-gray-300 space-y-2">
                        <p>Düsternort Str. 104</p>
                        <p>27755 Delmenhorst</p>
                        <p><a href="tel:+4917634326549" class="hover:text-kiwi-light transition-colors">0176 343 26549</a></p>
                        <p><a href="mailto:toni-janis@hotmail.com" class="hover:text-kiwi-light transition-colors">toni-janis@hotmail.com</a></p>
                    </address>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-heading font-bold mb-4 text-kiwi-light">
                        <?php esc_html_e('Schnelllinks', 'toni-janis'); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'menu_class'     => 'space-y-2 list-none m-0 p-0 text-sm text-gray-300',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="text-lg font-heading font-bold mb-4 text-kiwi-light">
                        <?php esc_html_e('Rechtliches', 'toni-janis'); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'legal',
                        'menu_class'     => 'space-y-2 list-none m-0 p-0 text-sm text-gray-300',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-white/20 mt-8 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-400">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('Alle Rechte vorbehalten.', 'toni-janis'); ?></p>
                <a href="https://wa.me/4917634326549" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition-colors text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.612.638l4.716-1.244A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.244 0-4.322-.724-6.016-1.952l-.42-.312-3.07.81.825-3.012-.342-.544A9.935 9.935 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </footer>

    <?php
    // DSGVO Consent Banner
    if (function_exists('get_field')) {
        $consent_enabled = get_field('enable_consent_banner', 'option');
        if ($consent_enabled) {
            get_template_part('template-parts/blocks/consent-banner/consent-banner');
        }
    }
    ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
