<?php
/**
 * Block: Kontakt
 *
 * Two-column layout: contact info on left, form on right.
 * Uses toja_contact_info() for business data.
 * Conditional rendering for info sidebar and form.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$heading           = get_sub_field('contact_heading') ?: 'Kontaktieren Sie uns';
$text              = get_sub_field('contact_text');
$show_infos        = get_sub_field('contact_infos_anzeigen');
$show_form         = get_sub_field('contact_formular_anzeigen');
$email             = get_sub_field('contact_email') ?: toja_option('footer_email', get_option('admin_email'));
$contact_services  = get_sub_field('contact_services');
$block_id          = toja_block_id('contact');

// Get contact info
$contact = toja_contact_info();
?>

<section class="contact" id="<?php echo esc_attr($block_id); ?>">
    <div class="contact-container">

        <!-- Left Column: Contact Info -->
        <?php if ($show_infos) : ?>
            <div class="contact-info">
                <?php if ($heading) : ?>
                    <h2><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <p><?php echo esc_html($text); ?></p>
                <?php endif; ?>

                <div class="contact-details">
                    <!-- Address -->
                    <?php if (!empty($contact['address'])) : ?>
                        <div class="contact-item">
                            <div class="contact-item-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="contact-item-text">
                                <strong><?php esc_html_e('Adresse', 'toni-janis'); ?></strong>
                                <span><?php echo esc_html($contact['address']); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Phone -->
                    <?php if (!empty($contact['phone1'])) : ?>
                        <div class="contact-item">
                            <div class="contact-item-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                                </svg>
                            </div>
                            <div class="contact-item-text">
                                <strong><?php esc_html_e('Telefon', 'toni-janis'); ?></strong>
                                <a href="<?php echo esc_url(toja_phone_href($contact['phone1'])); ?>">
                                    <?php echo esc_html($contact['phone1']); ?>
                                </a>
                                <?php if (!empty($contact['phone2'])) : ?>
                                    <br>
                                    <a href="<?php echo esc_url(toja_phone_href($contact['phone2'])); ?>">
                                        <?php echo esc_html($contact['phone2']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Email -->
                    <?php if (!empty($contact['email'])) : ?>
                        <div class="contact-item">
                            <div class="contact-item-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div class="contact-item-text">
                                <strong><?php esc_html_e('E-Mail', 'toni-janis'); ?></strong>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>">
                                    <?php echo esc_html($contact['email']); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- WhatsApp -->
                    <?php if (!empty($contact['whatsapp'])) : ?>
                        <div class="contact-item">
                            <div class="contact-item-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path>
                                </svg>
                            </div>
                            <div class="contact-item-text">
                                <strong><?php esc_html_e('WhatsApp', 'toni-janis'); ?></strong>
                                <a href="<?php echo esc_url($contact['whatsapp']); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php esc_html_e('Nachricht senden', 'toni-janis'); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Right Column: Contact Form -->
        <?php if ($show_form) : ?>
            <div class="contact-form-wrapper"
                x-data="{
                    form: {
                        name: '',
                        email: '',
                        phone: '',
                        service: '',
                        message: ''
                    },
                    submitted: false,
                    submitting: false,
                    error: '',
                    async submitForm() {
                        if (this.submitting) return;
                        if (!this.form.name || !this.form.email || !this.form.message) {
                            this.error = '<?php echo esc_js(__('Bitte füllen Sie alle Pflichtfelder aus.', 'toni-janis')); ?>';
                            return;
                        }
                        this.submitting = true;
                        this.error = '';

                        try {
                            const data = new FormData();
                            data.append('action', 'toja_contact_request');
                            data.append('nonce', tojaData.nonce);
                            data.append('name', this.form.name);
                            data.append('email', this.form.email);
                            data.append('phone', this.form.phone);
                            data.append('service', this.form.service);
                            data.append('message', this.form.message);

                            const response = await fetch(tojaData.ajaxUrl, {
                                method: 'POST',
                                body: data
                            });

                            const result = await response.json();

                            if (result.success) {
                                this.submitted = true;
                            } else {
                                this.error = result.data?.message || '<?php echo esc_js(__('Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.', 'toni-janis')); ?>';
                            }
                        } catch (e) {
                            this.error = '<?php echo esc_js(__('Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.', 'toni-janis')); ?>';
                        } finally {
                            this.submitting = false;
                        }
                    }
                }"
            >
                <!-- Success Message -->
                <template x-if="submitted">
                    <div class="success-message" role="status" aria-live="polite">
                        <div class="success-icon">&#10003;</div>
                        <h3><?php esc_html_e('Nachricht gesendet!', 'toni-janis'); ?></h3>
                        <p><?php esc_html_e('Vielen Dank für Ihre Nachricht. Wir melden uns schnellstmöglich bei Ihnen.', 'toni-janis'); ?></p>
                    </div>
                </template>

                <!-- Form -->
                <template x-if="!submitted">
                    <form class="contact-form" @submit.prevent="submitForm()">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-vorname">
                                    <?php esc_html_e('Vorname', 'toni-janis'); ?> *
                                </label>
                                <input
                                    id="<?php echo esc_attr($block_id); ?>-vorname"
                                    type="text"
                                    x-model="form.name"
                                    required
                                    aria-required="true"
                                    placeholder="<?php esc_attr_e('Ihr Vorname', 'toni-janis'); ?>"
                                >
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-nachname">
                                    <?php esc_html_e('Nachname', 'toni-janis'); ?> *
                                </label>
                                <input
                                    id="<?php echo esc_attr($block_id); ?>-nachname"
                                    type="text"
                                    placeholder="<?php esc_attr_e('Ihr Nachname', 'toni-janis'); ?>"
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-email">
                                    <?php esc_html_e('E-Mail', 'toni-janis'); ?> *
                                </label>
                                <input
                                    id="<?php echo esc_attr($block_id); ?>-email"
                                    type="email"
                                    x-model="form.email"
                                    required
                                    aria-required="true"
                                    placeholder="<?php esc_attr_e('ihre@email.de', 'toni-janis'); ?>"
                                >
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-phone">
                                    <?php esc_html_e('Telefon', 'toni-janis'); ?>
                                </label>
                                <input
                                    id="<?php echo esc_attr($block_id); ?>-phone"
                                    type="tel"
                                    x-model="form.phone"
                                    placeholder="<?php esc_attr_e('Ihre Telefonnummer', 'toni-janis'); ?>"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="<?php echo esc_attr($block_id); ?>-service">
                                <?php esc_html_e('Gewünschte Leistung', 'toni-janis'); ?>
                            </label>
                            <select
                                id="<?php echo esc_attr($block_id); ?>-service"
                                x-model="form.service"
                            >
                                <option value=""><?php esc_html_e('Bitte wählen...', 'toni-janis'); ?></option>
                                <?php if (!empty($contact_services)) : ?>
                                    <?php foreach ($contact_services as $service) : ?>
                                        <option value="<?php echo esc_attr($service['service_value']); ?>">
                                            <?php echo esc_html($service['service_label']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="<?php echo esc_attr($block_id); ?>-message">
                                <?php esc_html_e('Ihre Nachricht', 'toni-janis'); ?> *
                            </label>
                            <textarea
                                id="<?php echo esc_attr($block_id); ?>-message"
                                x-model="form.message"
                                required
                                aria-required="true"
                                placeholder="<?php esc_attr_e('Beschreiben Sie Ihr Projekt...', 'toni-janis'); ?>"
                            ></textarea>
                        </div>

                        <!-- Error Message -->
                        <template x-if="error">
                            <div class="error-message" role="alert" x-text="error"></div>
                        </template>

                        <div class="form-submit">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="submitting"
                                style="width: 100%;"
                            >
                                <span x-show="!submitting">
                                    <?php esc_html_e('Anfrage senden', 'toni-janis'); ?>
                                    <span>&rarr;</span>
                                </span>
                                <span x-show="submitting">
                                    <?php esc_html_e('Wird gesendet...', 'toni-janis'); ?>
                                </span>
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        <?php endif; ?>
    </div>
</section>
