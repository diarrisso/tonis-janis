<?php
/**
 * The footer template
 *
 * Structure matches demo/index.html 1:1 for proper demo CSS styling.
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

    <footer class="footer-new">
        <div class="footer-container">
            <!-- Logo Section -->
            <div class="footer-logo-section">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="display: flex; align-items: center; gap: 1rem; text-decoration: none;">
                    <?php if ($footer_logo && is_array($footer_logo) && isset($footer_logo['url'])) : ?>
                        <img src="<?php echo esc_url($footer_logo['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" height="60" style="height: 60px; width: auto;">
                    <?php else : ?>
                        <svg width="60" height="60" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 5L25 15H30L35 25L30 35H10L5 25L10 15H15L20 5Z" fill="white"/>
                            <circle cx="20" cy="20" r="8" fill="var(--kiwi-green)"/>
                            <path d="M20 12V28M15 20H25" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Footer Content -->
            <div class="footer-content">
                <!-- Left: Contact Info -->
                <div class="footer-contact">
                    <?php if ($footer_address) : ?>
                        <div class="footer-contact-item">
                            <p><?php echo nl2br(esc_html($footer_address)); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="footer-contact-item">
                        <?php if ($footer_email) : ?>
                            <p><a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a></p>
                        <?php endif; ?>
                        <?php if ($footer_phone1 || $footer_phone2) : ?>
                            <p>
                                <?php if ($footer_phone1) : ?>
                                    <a href="<?php echo esc_attr(toja_phone_href($footer_phone1)); ?>"><?php echo esc_html($footer_phone1); ?></a>
                                <?php endif; ?>
                                <?php if ($footer_phone1 && $footer_phone2) : ?><br><?php endif; ?>
                                <?php if ($footer_phone2) : ?>
                                    <a href="<?php echo esc_attr(toja_phone_href($footer_phone2)); ?>"><?php echo esc_html($footer_phone2); ?></a>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Social Media -->
                    <?php if ($social_facebook || $social_instagram || $social_whatsapp) : ?>
                        <div class="footer-social">
                            <?php if ($social_facebook) : ?>
                                <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($social_instagram) : ?>
                                <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($social_whatsapp) : ?>
                                <a href="<?php echo esc_url($social_whatsapp); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Legal Links -->
                <nav class="footer-nav">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1,
                        'items_wrap'     => '%3$s',
                        'walker'         => new class extends Walker_Nav_Menu {
                            public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                                $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
                            }
                            public function end_el(&$output, $item, $depth = 0, $args = null) {}
                            public function start_lvl(&$output, $depth = 0, $args = null) {}
                            public function end_lvl(&$output, $depth = 0, $args = null) {}
                        },
                    ]);
                    ?>
                </nav>
            </div>

            <!-- Copyright -->
            <div class="footer-copyright">
                <p>
                    <?php
                    $copyright_text = str_replace('{year}', date('Y'), $footer_copyright);
                    echo wp_kses_post($copyright_text);
                    ?>
                </p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTopBtn" aria-label="<?php esc_attr_e('Zuruck nach oben', 'toni-janis'); ?>">
        <svg viewBox="0 0 17.08543 23.9511" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.39644,23.951v-15.67l-2.5,2.5c-.77679.77706-2.03644.77729-2.8135.0005-.77706-.77679-.77729-2.03644-.0005-2.8135L8.55044.5l7.472,7.471c.76601.78812.74808,2.04799-.04004,2.814-.77231.75064-2.00165.75064-2.77396,0l-2.5-2.5.003,15.666"
                  fill="none"
                  stroke="currentColor"
                  stroke-linejoin="round"
                  stroke-width="1.5"/>
        </svg>
    </button>

    <!-- Floating Contact Button -->
    <?php
    $show_floating_btn = toja_option('footer_show_whatsapp_button', true);
    ?>
    <?php if ($show_floating_btn && $social_whatsapp) : ?>
    <a href="<?php echo esc_url($social_whatsapp); ?>" target="_blank" rel="noopener noreferrer" class="floating-contact-btn" aria-label="<?php esc_attr_e('WhatsApp Nachricht senden', 'toni-janis'); ?>">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.612.638l4.716-1.244A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.244 0-4.322-.724-6.016-1.952l-.42-.312-3.07.81.825-3.012-.342-.544A9.935 9.935 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
        </svg>
    </a>
    <?php endif; ?>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
