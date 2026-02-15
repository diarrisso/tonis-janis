<?php
/**
 * The header template
 *
 * Structure matches demo/index.html 1:1 for proper demo CSS styling.
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
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link sr-only" href="#main-content">
        <?php esc_html_e('Zum Inhalt springen', 'toni-janis'); ?>
    </a>

    <?php
    $cta_primary_text   = toja_option('header_cta_primary_text', 'Angebote');
    $cta_primary_url    = toja_option('header_cta_primary_url', '#contact');
    $cta_secondary_text = toja_option('header_cta_secondary_text', 'Termin buchen');
    $cta_secondary_url  = toja_option('header_cta_secondary_url', '#termin');
    ?>

    <!-- Header -->
    <header id="site-header">
        <nav>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <div class="logo-icon">
                    <?php if (has_custom_logo()) : ?>
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
                        ?>
                        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="40" height="40">
                    <?php else : ?>
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 5L25 15H30L35 25L30 35H10L5 25L10 15H15L20 5Z" fill="#689F38"/>
                            <circle cx="20" cy="20" r="8" fill="#8BC34A"/>
                            <path d="M20 12V28M15 20H25" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="logo-text">
                    <strong><?php bloginfo('name'); ?></strong>
                </div>
            </a>

            <div class="nav-container">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-links',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ]);
                ?>
            </div>

            <div class="nav-actions">
                <?php if ($cta_primary_text) : ?>
                    <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn-cta-small">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M14 2H2C1.44772 2 1 2.44772 1 3V13C1 13.5523 1.44772 14 2 14H14C14.5523 14 15 13.5523 15 13V3C15 2.44772 14.5523 2 14 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 5L8 9L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span><?php echo esc_html($cta_primary_text); ?></span>
                    </a>
                <?php endif; ?>
                <?php if ($cta_secondary_text) : ?>
                    <a href="<?php echo esc_url($cta_secondary_url); ?>" class="btn-cta">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="2" y="3" width="14" height="13" rx="2" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M6 1V4M12 1V4M2 7H16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        <span><?php echo esc_html($cta_secondary_text); ?></span>
                    </a>
                <?php endif; ?>
                <button class="dark-mode-toggle" onclick="toggleDarkMode()" aria-label="<?php esc_attr_e('Dark Mode umschalten', 'toni-janis'); ?>">
                    <svg class="sun-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <circle cx="10" cy="10" r="4" fill="currentColor"/>
                        <path d="M10 1V3M10 17V19M19 10H17M3 10H1M16.364 16.364L14.95 14.95M5.05 5.05L3.636 3.636M16.364 3.636L14.95 5.05M5.05 14.95L3.636 16.364" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <svg class="moon-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M17 10.5C17 14.6421 13.6421 18 9.5 18C5.35786 18 2 14.6421 2 10.5C2 6.35786 5.35786 3 9.5 3C9.67286 3 9.84457 3.00647 10.015 3.01924C8.21785 4.17598 7 6.21201 7 8.5C7 11.8137 9.68629 14.5 13 14.5C15.288 14.5 17.324 13.2821 18.4808 11.485C18.4935 11.6554 18.5 11.8271 18.5 12C18.5 12.1667 18.4942 12.3321 18.4827 12.496C18.1565 11.3508 17.6658 10.7866 17 10.5Z" fill="currentColor"/>
                    </svg>
                </button>
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="<?php esc_attr_e('Menu', 'toni-janis'); ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobile-menu">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => false,
                'depth'          => 1,
                'items_wrap'     => '<ul>%3$s</ul>',
            ]);
            ?>
            <?php if ($cta_primary_text) : ?>
                <ul>
                    <li><a href="<?php echo esc_url($cta_primary_url); ?>" onclick="toggleMobileMenu()" class="mobile-cta"><?php echo esc_html($cta_primary_text); ?></a></li>
                    <?php if ($cta_secondary_text) : ?>
                        <li><a href="<?php echo esc_url($cta_secondary_url); ?>" onclick="toggleMobileMenu()" class="mobile-cta"><?php echo esc_html($cta_secondary_text); ?></a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </header>

