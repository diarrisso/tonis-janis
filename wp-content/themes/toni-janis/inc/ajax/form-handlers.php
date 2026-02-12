<?php
/**
 * AJAX Form Handlers
 *
 * Handles all form submissions: contact, appointment, quote, entsorgen.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

/**
 * Get the default recipient email
 */
function toja_get_form_email($form_email = '') {
    if (!empty($form_email)) {
        return sanitize_email($form_email);
    }
    return toja_option('footer_email', get_option('admin_email'));
}

/**
 * Verify form nonce
 */
function toja_verify_form_nonce() {
    if (!check_ajax_referer('toja_nonce', 'nonce', false)) {
        wp_send_json_error([
            'message' => __('Sicherheitsprüfung fehlgeschlagen. Bitte laden Sie die Seite neu.', 'toni-janis'),
        ]);
    }
}

// ─── Contact Form ────────────────────────────────────────────────
function toja_handle_contact_request() {
    toja_verify_form_nonce();

    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error([
            'message' => __('Bitte füllen Sie alle Pflichtfelder aus.', 'toni-janis'),
        ]);
    }

    $to      = toja_get_form_email();
    $subject = sprintf('[Kontaktanfrage] %s', $name);

    $body  = "Neue Kontaktanfrage über die Website:\n\n";
    $body .= "Name: {$name}\n";
    $body .= "E-Mail: {$email}\n";
    if ($phone) {
        $body .= "Telefon: {$phone}\n";
    }
    if ($service) {
        $body .= "Gewünschte Leistung: {$service}\n";
    }
    $body .= "\nNachricht:\n{$message}\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success([
            'message' => __('Ihre Nachricht wurde erfolgreich gesendet.', 'toni-janis'),
        ]);
    } else {
        wp_send_json_error([
            'message' => __('Die Nachricht konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.', 'toni-janis'),
        ]);
    }
}
add_action('wp_ajax_toja_contact_request', 'toja_handle_contact_request');
add_action('wp_ajax_nopriv_toja_contact_request', 'toja_handle_contact_request');

// ─── Appointment Form ────────────────────────────────────────────
function toja_handle_appointment_request() {
    toja_verify_form_nonce();

    $type    = sanitize_text_field($_POST['type'] ?? '');
    $date    = sanitize_text_field($_POST['date'] ?? '');
    $time    = sanitize_text_field($_POST['time'] ?? '');
    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($type) || empty($date) || empty($time) || empty($name) || empty($email) || empty($phone)) {
        wp_send_json_error([
            'message' => __('Bitte füllen Sie alle Pflichtfelder aus.', 'toni-janis'),
        ]);
    }

    $to      = toja_get_form_email();
    $subject = sprintf('[Terminanfrage] %s - %s', $type, $name);

    $body  = "Neue Terminanfrage über die Website:\n\n";
    $body .= "Beratungsart: {$type}\n";
    $body .= "Datum: {$date}\n";
    $body .= "Uhrzeit: {$time} Uhr\n\n";
    $body .= "Kontaktdaten:\n";
    $body .= "Name: {$name}\n";
    $body .= "E-Mail: {$email}\n";
    $body .= "Telefon: {$phone}\n";
    if ($message) {
        $body .= "\nNachricht:\n{$message}\n";
    }

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success([
            'message' => __('Ihre Terminanfrage wurde erfolgreich gesendet.', 'toni-janis'),
        ]);
    } else {
        wp_send_json_error([
            'message' => __('Die Anfrage konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.', 'toni-janis'),
        ]);
    }
}
add_action('wp_ajax_toja_appointment_request', 'toja_handle_appointment_request');
add_action('wp_ajax_nopriv_toja_appointment_request', 'toja_handle_appointment_request');

// ─── Quote Form ──────────────────────────────────────────────────
function toja_handle_quote_request() {
    toja_verify_form_nonce();

    $services    = sanitize_text_field($_POST['services'] ?? '[]');
    $size        = sanitize_text_field($_POST['size'] ?? '');
    $timeframe   = sanitize_text_field($_POST['timeframe'] ?? '');
    $description = sanitize_textarea_field($_POST['description'] ?? '');
    $firstName   = sanitize_text_field($_POST['firstName'] ?? '');
    $lastName    = sanitize_text_field($_POST['lastName'] ?? '');
    $email       = sanitize_email($_POST['email'] ?? '');
    $phone       = sanitize_text_field($_POST['phone'] ?? '');
    $street      = sanitize_text_field($_POST['street'] ?? '');
    $city        = sanitize_text_field($_POST['city'] ?? '');

    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
        wp_send_json_error([
            'message' => __('Bitte füllen Sie alle Pflichtfelder aus.', 'toni-janis'),
        ]);
    }

    // Decode services JSON
    $services_list = json_decode(stripslashes($services), true);
    $services_text = is_array($services_list) ? implode(', ', $services_list) : $services;

    $to      = toja_get_form_email();
    $subject = sprintf('[Angebotsanfrage] %s %s', $firstName, $lastName);

    $body  = "Neue Angebotsanfrage über die Website:\n\n";
    $body .= "Gewünschte Leistungen: {$services_text}\n\n";
    if ($size) {
        $body .= "Grundstücksgröße: {$size}\n";
    }
    if ($timeframe) {
        $body .= "Zeitrahmen: {$timeframe}\n";
    }
    if ($description) {
        $body .= "\nProjektbeschreibung:\n{$description}\n";
    }
    $body .= "\nKontaktdaten:\n";
    $body .= "Name: {$firstName} {$lastName}\n";
    $body .= "E-Mail: {$email}\n";
    $body .= "Telefon: {$phone}\n";
    if ($street) {
        $body .= "Straße: {$street}\n";
    }
    if ($city) {
        $body .= "PLZ / Ort: {$city}\n";
    }

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$firstName} {$lastName} <{$email}>",
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success([
            'message' => __('Ihre Angebotsanfrage wurde erfolgreich gesendet.', 'toni-janis'),
        ]);
    } else {
        wp_send_json_error([
            'message' => __('Die Anfrage konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.', 'toni-janis'),
        ]);
    }
}
add_action('wp_ajax_toja_quote_request', 'toja_handle_quote_request');
add_action('wp_ajax_nopriv_toja_quote_request', 'toja_handle_quote_request');

// ─── Entsorgen Form ─────────────────────────────────────────────
function toja_handle_entsorgen_request() {
    toja_verify_form_nonce();

    $type  = sanitize_text_field($_POST['type'] ?? '');
    $menge = sanitize_text_field($_POST['menge'] ?? '');
    $name  = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $ort   = sanitize_text_field($_POST['ort'] ?? '');
    $info  = sanitize_textarea_field($_POST['info'] ?? '');

    if (empty($name) || empty($phone) || empty($email) || empty($type)) {
        wp_send_json_error([
            'message' => __('Bitte füllen Sie alle Pflichtfelder aus.', 'toni-janis'),
        ]);
    }

    $to      = toja_get_form_email();
    $subject = sprintf('[Entsorgungsanfrage] %s - %s', $type, $name);

    $body  = "Neue Entsorgungsanfrage über die Website:\n\n";
    $body .= "Art der Entsorgung: {$type}\n";
    if ($menge) {
        $body .= "Geschätzte Menge: {$menge}\n";
    }
    if ($ort) {
        $body .= "Ort / Adresse: {$ort}\n";
    }
    $body .= "\nKontaktdaten:\n";
    $body .= "Name: {$name}\n";
    $body .= "Telefon: {$phone}\n";
    $body .= "E-Mail: {$email}\n";
    if ($info) {
        $body .= "\nZusätzliche Informationen:\n{$info}\n";
    }

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success([
            'message' => __('Ihre Entsorgungsanfrage wurde erfolgreich gesendet.', 'toni-janis'),
        ]);
    } else {
        wp_send_json_error([
            'message' => __('Die Anfrage konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.', 'toni-janis'),
        ]);
    }
}
add_action('wp_ajax_toja_entsorgen_request', 'toja_handle_entsorgen_request');
add_action('wp_ajax_nopriv_toja_entsorgen_request', 'toja_handle_entsorgen_request');
