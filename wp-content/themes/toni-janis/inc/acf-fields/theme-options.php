<?php
/**
 * ACF Theme Options Fields
 *
 * Registriert ACF-Felder für Header, Footer und Consent Banner
 *
 * @package ToniJanis
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ACF Felder für Header Optionen registrieren
 */
function toja_register_header_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_toja_header_options',
        'title' => 'Header Konfiguration',
        'fields' => [

            // Logo Tab
            [
                'key' => 'field_toja_header_logo_tab',
                'label' => 'Logo',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_header_logo',
                'label' => 'Logo',
                'name' => 'header_logo',
                'type' => 'image',
                'instructions' => 'Firmenlogo hochladen (empfohlen: SVG oder PNG mit transparentem Hintergrund)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_toja_header_logo_height',
                'label' => 'Logo Höhe (px)',
                'name' => 'header_logo_height',
                'type' => 'number',
                'instructions' => 'Höhe des Logos in Pixeln',
                'default_value' => 50,
                'min' => 20,
                'max' => 120,
                'step' => 5,
            ],

            // Navigation Tab
            [
                'key' => 'field_toja_header_nav_tab',
                'label' => 'Navigation',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_header_sticky',
                'label' => 'Sticky Header',
                'name' => 'header_sticky',
                'type' => 'true_false',
                'instructions' => 'Header bleibt beim Scrollen oben fixiert',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Ja',
                'ui_off_text' => 'Nein',
            ],

            // CTA Button Tab
            [
                'key' => 'field_toja_header_cta_tab',
                'label' => 'CTA Button',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_header_cta_text',
                'label' => 'Button Text',
                'name' => 'header_cta_text',
                'type' => 'text',
                'default_value' => 'Kontakt',
            ],
            [
                'key' => 'field_toja_header_cta_url',
                'label' => 'Button URL',
                'name' => 'header_cta_url',
                'type' => 'page_link',
                'instructions' => 'Zielseite für den Kontakt-Button',
                'post_type' => ['page'],
                'allow_null' => 1,
            ],

            // Styling Tab
            [
                'key' => 'field_toja_header_styling_tab',
                'label' => 'Styling',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_header_bg_color',
                'label' => 'Hintergrundfarbe',
                'name' => 'header_background_color',
                'type' => 'select',
                'choices' => [
                    'white'       => 'Weiß',
                    'cream'       => 'Creme',
                    'transparent' => 'Transparent',
                ],
                'default_value' => 'white',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-header-settings',
                ],
            ],
        ],
    ]);
}
add_action('acf/init', 'toja_register_header_fields');

/**
 * ACF Felder für Footer Optionen registrieren
 */
function toja_register_footer_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_toja_footer_options',
        'title' => 'Footer Konfiguration',
        'fields' => [

            // Logo Tab
            [
                'key' => 'field_toja_footer_logo_tab',
                'label' => 'Logo',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_footer_logo',
                'label' => 'Footer Logo',
                'name' => 'footer_logo',
                'type' => 'image',
                'instructions' => 'Logo für den Footer (empfohlen: helle Version für dunklen Hintergrund)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],

            // Kontakt Tab
            [
                'key' => 'field_toja_footer_contact_tab',
                'label' => 'Kontakt',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_footer_address',
                'label' => 'Adresse',
                'name' => 'footer_address',
                'type' => 'textarea',
                'instructions' => 'Vollständige Adresse (mehrzeilig möglich)',
                'rows' => 3,
                'default_value' => "Düsternort Str. 104\n27755 Delmenhorst",
            ],
            [
                'key' => 'field_toja_footer_phone',
                'label' => 'Telefon',
                'name' => 'footer_phone',
                'type' => 'text',
                'default_value' => '0176 343 26549',
            ],
            [
                'key' => 'field_toja_footer_phone2',
                'label' => 'Telefon 2',
                'name' => 'footer_phone2',
                'type' => 'text',
                'default_value' => '0176 878 29995',
            ],
            [
                'key' => 'field_toja_footer_email',
                'label' => 'E-Mail',
                'name' => 'footer_email',
                'type' => 'email',
                'default_value' => 'toni-janis@hotmail.com',
            ],
            [
                'key' => 'field_toja_footer_whatsapp',
                'label' => 'WhatsApp Nummer',
                'name' => 'footer_whatsapp',
                'type' => 'text',
                'instructions' => 'Nummer im internationalen Format ohne + (z.B. 4917634326549)',
                'default_value' => '4917634326549',
            ],

            // Social Media Tab
            [
                'key' => 'field_toja_footer_social_tab',
                'label' => 'Social Media',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_footer_social_facebook',
                'label' => 'Facebook URL',
                'name' => 'footer_social_facebook',
                'type' => 'url',
            ],
            [
                'key' => 'field_toja_footer_social_instagram',
                'label' => 'Instagram URL',
                'name' => 'footer_social_instagram',
                'type' => 'url',
            ],
            [
                'key' => 'field_toja_footer_social_google',
                'label' => 'Google Business URL',
                'name' => 'footer_social_google',
                'type' => 'url',
                'instructions' => 'Google My Business Profil-URL',
            ],

            // Copyright Tab
            [
                'key' => 'field_toja_footer_copyright_tab',
                'label' => 'Copyright',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_footer_copyright_text',
                'label' => 'Copyright Text',
                'name' => 'footer_copyright_text',
                'type' => 'text',
                'instructions' => 'Verwenden Sie {year} für das aktuelle Jahr',
                'default_value' => '© {year} Toni Janis Garten- und Landschaftsbau. Alle Rechte vorbehalten.',
            ],
            [
                'key' => 'field_toja_footer_show_whatsapp_button',
                'label' => 'WhatsApp Button anzeigen',
                'name' => 'footer_show_whatsapp_button',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Ja',
                'ui_off_text' => 'Nein',
            ],

            // Consent Banner Tab
            [
                'key' => 'field_toja_footer_consent_tab',
                'label' => 'Consent Banner',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_toja_enable_consent_banner',
                'label' => 'Consent Banner aktivieren',
                'name' => 'enable_consent_banner',
                'type' => 'true_false',
                'instructions' => 'DSGVO Consent Banner auf der gesamten Website aktivieren.',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Ja',
                'ui_off_text' => 'Nein',
            ],
            [
                'key' => 'field_toja_consent_banner_message',
                'label' => 'Nachricht',
                'name' => 'consent_banner_message',
                'type' => 'wysiwyg',
                'instructions' => 'Der Text im Banner. Sie können Links zur Datenschutzerklärung hinzufügen.',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'default_value' => 'Wir verwenden Cookies, um Ihnen die bestmögliche Erfahrung zu bieten. <a href="/datenschutz">Mehr erfahren</a>',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_toja_enable_consent_banner',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_toja_consent_banner_position',
                'label' => 'Position',
                'name' => 'consent_banner_position',
                'type' => 'select',
                'choices' => [
                    'bottom' => 'Unten (Standard)',
                    'top' => 'Oben',
                ],
                'default_value' => 'bottom',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_toja_enable_consent_banner',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_toja_consent_banner_bg_color',
                'label' => 'Hintergrundfarbe',
                'name' => 'consent_banner_bg_color',
                'type' => 'select',
                'choices' => [
                    'white' => 'Weiß (Standard)',
                    'cream' => 'Creme',
                    'kiwi'  => 'Kiwi Grün',
                    'sand'  => 'Sand Beige',
                ],
                'default_value' => 'white',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_toja_enable_consent_banner',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_toja_consent_banner_text_color',
                'label' => 'Textfarbe',
                'name' => 'consent_banner_text_color',
                'type' => 'select',
                'choices' => [
                    'earth-brown' => 'Erdbraun',
                    'charcoal'    => 'Dunkelgrau',
                    'white'       => 'Weiß',
                ],
                'default_value' => 'earth-brown',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_toja_enable_consent_banner',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_toja_consent_banner_storage_days',
                'label' => 'Speicherdauer (Tage)',
                'name' => 'consent_banner_storage_days',
                'type' => 'number',
                'instructions' => 'Wie viele Tage soll der Banner nach dem Schließen ausgeblendet bleiben?',
                'default_value' => 30,
                'min' => 1,
                'max' => 365,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_toja_enable_consent_banner',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-footer-settings',
                ],
            ],
        ],
    ]);
}
add_action('acf/init', 'toja_register_footer_fields');
