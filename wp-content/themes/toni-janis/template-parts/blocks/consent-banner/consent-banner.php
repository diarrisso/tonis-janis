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
$message      = get_field('consent_banner_message', 'option');
$position     = get_field('consent_banner_position', 'option') ?: 'bottom';
$storage_days = get_field('consent_banner_storage_days', 'option') ?: 30;

// Wenn keine Nachricht vorhanden ist, nichts anzeigen
if (empty($message)) {
    return;
}

// Erstelle eindeutige ID für localStorage
$banner_id = 'toja-consent-banner';
?>

<div
    class="consent-banner consent-banner--<?php echo esc_attr($position); ?>"
    x-data="{
        show: false,
        storageKey: '<?php echo esc_js($banner_id); ?>',
        storageDays: <?php echo absint($storage_days); ?>,

        init() {
            const closed = localStorage.getItem(this.storageKey);
            if (!closed) {
                this.show = true;
            }
        },

        close() {
            this.show = false;
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
    style="display: none;"
    x-cloak
    role="dialog"
    aria-label="<?php esc_attr_e('Cookie-Hinweis', 'toni-janis'); ?>"
>
    <div class="consent-banner__inner">
        <!-- Nachricht -->
        <div class="consent-banner__message">
            <?php echo wp_kses_post($message); ?>
        </div>

        <!-- Akzeptieren Button -->
        <button
            @click="close()"
            type="button"
            class="consent-banner__accept btn btn-primary"
        >
            <?php esc_html_e('OK', 'toni-janis'); ?>
        </button>

        <!-- Schließen Button -->
        <button
            @click="close()"
            type="button"
            class="consent-banner__close"
            aria-label="<?php esc_attr_e('Banner schließen', 'toni-janis'); ?>"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
