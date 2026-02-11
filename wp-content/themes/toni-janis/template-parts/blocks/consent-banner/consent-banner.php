<?php
/**
 * Consent Banner Block
 *
 * Zeigt einen DSGVO Consent/Cookie Banner am unteren oder oberen Rand der Seite an.
 * Der Banner kann vom Benutzer geschlossen werden und wird für X Tage nicht mehr angezeigt.
 *
 * @package ToniJanis
 */

if (!defined('ABSPATH')) exit;

// Prüfe ob der Banner in den Theme-Einstellungen aktiviert ist
$is_enabled = get_field('enable_consent_banner', 'option');

if (!$is_enabled) {
    return;
}

// Hole Daten aus den Theme-Optionen
$message = get_field('consent_banner_message', 'option');
$position = get_field('consent_banner_position', 'option') ?: 'bottom';
$bg_color = get_field('consent_banner_bg_color', 'option') ?: 'white';
$text_color = get_field('consent_banner_text_color', 'option') ?: 'earth-brown';
$storage_days = get_field('consent_banner_storage_days', 'option') ?: 30;

// Wenn keine Nachricht vorhanden ist, nichts anzeigen
if (empty($message)) {
    return;
}

// CSS-Klassen für Hintergrundfarbe
$bg_classes = [
    'white'     => 'bg-white',
    'cream'     => 'bg-cream',
    'kiwi'      => 'bg-kiwi-green',
    'sand'      => 'bg-sand-beige',
];

// CSS-Klassen für Textfarbe
$text_classes = [
    'earth-brown' => 'text-earth-brown',
    'charcoal'    => 'text-charcoal',
    'white'       => 'text-white',
];

// CSS-Klassen für Position
$position_classes = [
    'bottom' => 'bottom-4',
    'top'    => 'top-4',
];

// Erstelle eindeutige ID für localStorage
$banner_id = 'toja-consent-banner';

?>

<div
    x-data="{
        show: false,
        storageKey: '<?php echo esc_js($banner_id); ?>',
        storageDays: <?php echo absint($storage_days); ?>,

        init() {
            // Prüfe ob Banner bereits geschlossen wurde
            const closed = localStorage.getItem(this.storageKey);
            if (!closed) {
                this.show = true;
            }
        },

        close() {
            this.show = false;
            // Speichere Schließ-Datum
            const expiryDate = new Date();
            expiryDate.setDate(expiryDate.getDate() + this.storageDays);
            localStorage.setItem(this.storageKey, expiryDate.toISOString());
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-4"
    class="fixed <?php echo esc_attr($position_classes[$position] ?? 'bottom-4'); ?> left-4 right-4 md:left-auto md:right-8 z-50 w-full max-w-xl"
    style="display: none;"
    x-cloak
>
    <div class="<?php echo esc_attr($bg_classes[$bg_color] ?? 'bg-white'); ?> <?php echo esc_attr($text_classes[$text_color] ?? 'text-earth-brown'); ?>
                rounded-2xl shadow-xl px-5 py-4 md:px-6 md:py-4 flex items-center justify-between gap-4 border border-gray-100">

        <!-- Nachricht -->
        <div class="flex-1 text-sm md:text-base leading-relaxed">
            <?php echo wp_kses_post($message); ?>
        </div>

        <!-- Akzeptieren Button -->
        <button
            @click="close()"
            type="button"
            class="flex-shrink-0 px-4 py-2 bg-kiwi-green text-white text-sm font-semibold rounded-lg hover:bg-kiwi-dark transition-colors duration-200 cursor-pointer"
        >
            <?php esc_html_e('OK', 'toni-janis'); ?>
        </button>

        <!-- Schließen Button -->
        <button
            @click="close()"
            type="button"
            class="flex-shrink-0 w-8 h-8 flex items-center justify-center
                   hover:bg-black/5 rounded-full transition-colors duration-200 cursor-pointer"
            aria-label="<?php esc_attr_e('Banner schließen', 'toni-janis'); ?>"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
