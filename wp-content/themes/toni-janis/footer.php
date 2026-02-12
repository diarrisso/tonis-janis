<?php
/**
 * The footer template
 *
 * Dark gradient footer with logo, contact info, social links, navigation,
 * copyright line, and back-to-top button.
 *
 * @package ToniJanis
 */

$contact = toja_contact_info();
$footer_address   = toja_option('footer_address', $contact['address']);
$footer_email     = toja_option('footer_email', $contact['email']);
$footer_phone1    = toja_option('footer_phone', $contact['phone1']);
$footer_phone2    = toja_option('footer_phone2', $contact['phone2']);
$footer_copyright = toja_option('footer_copyright_text', '&copy; {year} ' . get_bloginfo('name') . '. ' . __('Alle Rechte vorbehalten.', 'toni-janis'));

$social_facebook  = toja_option('footer_social_facebook', '');
$social_instagram = toja_option('footer_social_instagram', '');
$social_whatsapp  = toja_option('footer_social_whatsapp', $contact['whatsapp']);

$footer_logo      = toja_option('footer_logo', '');
?>

    <footer id="site-footer" class="site-footer relative bg-gradient-to-b from-[#1a2e1a] to-[#0f1f0f] text-white mt-auto">

        <!-- Decorative green gradient line -->
        <div class="h-1 bg-gradient-to-r from-kiwi-dark via-kiwi-green to-kiwi-light" aria-hidden="true"></div>

        <!-- Logo Section -->
        <div class="container mx-auto px-4 pt-12 pb-8">
            <div class="flex justify-center mb-10">
                <?php if ($footer_logo) : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block" aria-label="<?php esc_attr_e('Zur Startseite', 'toni-janis'); ?>">
                        <?php if (is_array($footer_logo) && isset($footer_logo['url'])) : ?>
                            <img
                                src="<?php echo esc_url($footer_logo['url']); ?>"
                                alt="<?php echo esc_attr($footer_logo['alt'] ?? get_bloginfo('name')); ?>"
                                class="h-16 w-auto brightness-0 invert"
                                width="<?php echo esc_attr($footer_logo['width'] ?? ''); ?>"
                                height="<?php echo esc_attr($footer_logo['height'] ?? ''); ?>"
                                loading="lazy"
                            >
                        <?php else : ?>
                            <img
                                src="<?php echo esc_url($footer_logo); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                                class="h-16 w-auto brightness-0 invert"
                                loading="lazy"
                            >
                        <?php endif; ?>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block" aria-label="<?php esc_attr_e('Zur Startseite', 'toni-janis'); ?>">
                        <svg class="h-16 w-auto" viewBox="0 0 200 60" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <text x="10" y="35" font-family="Playfair Display, serif" font-size="24" font-weight="700" fill="#AED581">Toni Janis</text>
                            <text x="10" y="52" font-family="Source Sans 3, sans-serif" font-size="10" fill="#8BC34A" letter-spacing="2">GARTEN- UND LANDSCHAFTSBAU</text>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Content Section: Two Columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 max-w-4xl mx-auto">

                <!-- Left Column: Contact Info + Social -->
                <div>
                    <h3 class="text-lg font-heading font-semibold text-kiwi-light mb-5">
                        <?php esc_html_e('Kontakt', 'toni-janis'); ?>
                    </h3>

                    <address class="not-italic text-sm text-gray-300 space-y-3 mb-6">
                        <?php if ($footer_address) : ?>
                            <p class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-kiwi-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span><?php echo esc_html($footer_address); ?></span>
                            </p>
                        <?php endif; ?>

                        <?php if ($footer_email) : ?>
                            <p class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-kiwi-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:<?php echo esc_attr($footer_email); ?>" class="hover:text-kiwi-light transition-colors duration-200">
                                    <?php echo esc_html($footer_email); ?>
                                </a>
                            </p>
                        <?php endif; ?>

                        <?php if ($footer_phone1) : ?>
                            <p class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-kiwi-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="<?php echo esc_attr(toja_phone_href($footer_phone1)); ?>" class="hover:text-kiwi-light transition-colors duration-200">
                                    <?php echo esc_html($footer_phone1); ?>
                                </a>
                            </p>
                        <?php endif; ?>

                        <?php if ($footer_phone2) : ?>
                            <p class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-kiwi-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="<?php echo esc_attr(toja_phone_href($footer_phone2)); ?>" class="hover:text-kiwi-light transition-colors duration-200">
                                    <?php echo esc_html($footer_phone2); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </address>

                    <!-- Social Media Links -->
                    <?php if ($social_facebook || $social_instagram || $social_whatsapp) : ?>
                        <div class="flex items-center gap-4">
                            <?php if ($social_facebook) : ?>
                                <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-gray-300 hover:bg-kiwi-green hover:text-white transition-all duration-200" aria-label="Facebook">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if ($social_instagram) : ?>
                                <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-gray-300 hover:bg-kiwi-green hover:text-white transition-all duration-200" aria-label="Instagram">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if ($social_whatsapp) : ?>
                                <a href="<?php echo esc_url($social_whatsapp); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-gray-300 hover:bg-kiwi-green hover:text-white transition-all duration-200" aria-label="WhatsApp">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.612.638l4.716-1.244A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.244 0-4.322-.724-6.016-1.952l-.42-.312-3.07.81.825-3.012-.342-.544A9.935 9.935 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column: Footer Navigation -->
                <div>
                    <h3 class="text-lg font-heading font-semibold text-kiwi-light mb-5">
                        <?php esc_html_e('Schnelllinks', 'toni-janis'); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'menu_class'     => 'space-y-3 list-none m-0 p-0 text-sm text-gray-300',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1,
                        'link_before'    => '<span class="hover-link">',
                        'link_after'     => '</span>',
                    ]);
                    ?>
                </div>

            </div>
        </div>

        <!-- Copyright Bar -->
        <div class="border-t border-white/10">
            <div class="container mx-auto px-4 py-5">
                <p class="text-center text-sm text-gray-400">
                    <?php
                    $copyright_text = str_replace('{year}', date('Y'), $footer_copyright);
                    echo wp_kses_post($copyright_text);
                    ?>
                </p>
            </div>
        </div>

        <!-- Back to Top Button -->
        <button
            x-data="{ visible: false }"
            x-init="window.addEventListener('scroll', () => { visible = window.scrollY > 400 })"
            x-show="visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-full bg-kiwi-green text-white shadow-lg hover:bg-kiwi-dark focus:outline-none focus:ring-2 focus:ring-kiwi-light focus:ring-offset-2 focus:ring-offset-[#0f1f0f] transition-colors duration-200 flex items-center justify-center"
            aria-label="<?php esc_attr_e('Nach oben scrollen', 'toni-janis'); ?>"
            x-cloak
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
            </svg>
        </button>

    </footer>

    <!-- Floating Contact Button -->
    <?php
    $show_floating_btn = toja_option('footer_show_whatsapp_button', true);
    $whatsapp_number   = toja_option('footer_whatsapp', '');
    $contact_page_url  = get_permalink(get_page_by_path('kontakt'));
    ?>
    <?php if ($show_floating_btn) : ?>
    <a
        href="<?php echo $whatsapp_number ? esc_url('https://wa.me/' . $whatsapp_number) : esc_url($contact_page_url ?: '#kontakt'); ?>"
        <?php echo $whatsapp_number ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
        x-data="{ visible: false }"
        x-init="setTimeout(() => visible = true, 1000)"
        x-show="visible"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        class="fixed bottom-6 left-6 z-40 w-14 h-14 rounded-full bg-kiwi-green text-white shadow-lg hover:bg-kiwi-dark hover:scale-110 focus:outline-none focus:ring-2 focus:ring-kiwi-light focus:ring-offset-2 transition-all duration-300 flex items-center justify-center"
        aria-label="<?php echo $whatsapp_number ? esc_attr__('WhatsApp Nachricht senden', 'toni-janis') : esc_attr__('Kontakt aufnehmen', 'toni-janis'); ?>"
        x-cloak
    >
        <?php if ($whatsapp_number) : ?>
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.612.638l4.716-1.244A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.244 0-4.322-.724-6.016-1.952l-.42-.312-3.07.81.825-3.012-.342-.544A9.935 9.935 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
            </svg>
        <?php else : ?>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="2" y="4" width="20" height="16" rx="2" stroke-width="2"/>
                <path d="M2 7l10 6 10-6" stroke-width="2" stroke-linecap="round"/>
            </svg>
        <?php endif; ?>
    </a>
    <?php endif; ?>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
