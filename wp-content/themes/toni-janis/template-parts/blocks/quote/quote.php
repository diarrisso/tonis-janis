<?php
/**
 * Block: Kostenloses Angebot
 *
 * 3-step quote request form with Alpine.js.
 * Step 1: Service selection (checkbox cards, multiple selection)
 * Step 2: Project details (size, timeframe, description, file upload placeholder)
 * Step 3: Contact info + privacy checkbox
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('quote_label') ?: 'Kostenloses Angebot';
$heading  = get_sub_field('quote_heading');
$text     = get_sub_field('quote_text');
$services = get_sub_field('quote_services');
$email    = get_sub_field('quote_email') ?: toja_option('footer_email', get_option('admin_email'));
$block_id = toja_block_id('quote');

if (empty($services)) {
    return;
}

// Build services data for Alpine.js
$services_data = [];
foreach ($services as $s) {
    $services_data[] = [
        'icon'         => $s['qs_icon'] ?? '',
        'titel'        => $s['qs_titel'] ?? '',
        'beschreibung' => $s['qs_beschreibung'] ?? '',
    ];
}

$steps = [
    1 => __('Leistung waehlen', 'toni-janis'),
    2 => __('Details angeben', 'toni-janis'),
    3 => __('Kontaktdaten', 'toni-janis'),
];
?>

<section class="quote-section" id="<?php echo esc_attr($block_id); ?>">

    <div class="section-header">
        <?php if ($label) : ?>
            <span class="section-label"><?php echo esc_html($label); ?></span>
        <?php endif; ?>

        <?php if ($heading) : ?>
            <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($text) : ?>
            <p><?php echo esc_html($text); ?></p>
        <?php endif; ?>
    </div>

    <div
        x-data="{
            step: 1,
            totalSteps: 3,
            selectedServices: [],
            stepAnnouncement: '',
            details: {
                size: '',
                timeframe: '',
                description: ''
            },
            contact: {
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
                street: '',
                city: '',
                privacy: false
            },
            submitted: false,
            submitting: false,
            error: '',
            services: <?php echo esc_attr(wp_json_encode($services_data)); ?>,
            toggleService(titel) {
                const idx = this.selectedServices.indexOf(titel);
                if (idx > -1) {
                    this.selectedServices.splice(idx, 1);
                } else {
                    this.selectedServices.push(titel);
                }
            },
            isSelected(titel) {
                return this.selectedServices.includes(titel);
            },
            canProceed() {
                if (this.step === 1) return this.selectedServices.length > 0;
                if (this.step === 2) return true;
                if (this.step === 3) return this.contact.firstName && this.contact.lastName && this.contact.email && this.contact.phone && this.contact.privacy;
                return false;
            },
            nextStep() {
                if (this.canProceed() && this.step < this.totalSteps) {
                    this.step++;
                    this.stepAnnouncement = '<?php echo esc_js(__('Schritt', 'toni-janis')); ?> ' + this.step + ' <?php echo esc_js(__('von', 'toni-janis')); ?> ' + this.totalSteps;
                }
            },
            prevStep() {
                if (this.step > 1) {
                    this.step--;
                    this.stepAnnouncement = '<?php echo esc_js(__('Schritt', 'toni-janis')); ?> ' + this.step + ' <?php echo esc_js(__('von', 'toni-janis')); ?> ' + this.totalSteps;
                }
            },
            async submitForm() {
                if (this.submitting) return;
                this.submitting = true;
                this.error = '';

                try {
                    const data = new FormData();
                    data.append('action', 'toja_quote_request');
                    data.append('nonce', tojaData.nonce);
                    data.append('services', JSON.stringify(this.selectedServices));
                    data.append('size', this.details.size);
                    data.append('timeframe', this.details.timeframe);
                    data.append('description', this.details.description);
                    data.append('firstName', this.contact.firstName);
                    data.append('lastName', this.contact.lastName);
                    data.append('email', this.contact.email);
                    data.append('phone', this.contact.phone);
                    data.append('street', this.contact.street);
                    data.append('city', this.contact.city);

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
        class="quote-container"
    >
        <!-- Live Region for Step Announcements -->
        <div class="sr-only" aria-live="polite" aria-atomic="true" x-text="stepAnnouncement"></div>

        <!-- Success Message -->
        <template x-if="submitted">
            <div class="quote-step" id="quoteSuccess" role="status" aria-live="polite">
                <div class="success-message">
                    <div class="success-icon">&#10003;</div>
                    <h3><?php esc_html_e('Vielen Dank fuer Ihre Anfrage!', 'toni-janis'); ?></h3>
                    <p><?php esc_html_e('Wir haben Ihre Anfrage erhalten und werden uns innerhalb von 24 Stunden bei Ihnen melden.', 'toni-janis'); ?></p>
                </div>
            </div>
        </template>

        <template x-if="!submitted">
            <div>
                <!-- Progress Steps -->
                <div class="quote-progress" role="list" aria-label="<?php esc_attr_e('Fortschritt', 'toni-janis'); ?>">
                    <?php foreach ($steps as $num => $step_label) : ?>
                        <div
                            class="progress-step"
                            :class="step >= <?php echo $num; ?> ? 'active' : ''"
                            data-step="<?php echo $num; ?>"
                            role="listitem"
                            :aria-current="step === <?php echo $num; ?> ? 'step' : false"
                        >
                            <div class="step-number"><?php echo $num; ?></div>
                            <span><?php echo esc_html($step_label); ?></span>
                        </div>
                        <?php if ($num < 3) : ?>
                            <div class="progress-line" :class="step > <?php echo $num; ?> ? 'active' : ''"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Step 1: Service Selection -->
                <div class="quote-step" :class="step === 1 ? 'active' : ''" x-show="step === 1" id="quoteStep1">
                    <h3><?php esc_html_e('Welche Leistung benoetigen Sie?', 'toni-janis'); ?></h3>

                    <div class="service-selection">
                        <?php foreach ($services_data as $index => $service) : ?>
                            <label class="service-option">
                                <input
                                    type="checkbox"
                                    name="service"
                                    value="<?php echo esc_attr($service['titel']); ?>"
                                    @change="toggleService('<?php echo esc_js($service['titel']); ?>')"
                                    :checked="isSelected('<?php echo esc_js($service['titel']); ?>')"
                                >
                                <div class="option-card">
                                    <?php if (!empty($service['icon'])) : ?>
                                        <span class="option-icon"><?php echo $service['icon']; ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($service['titel'])) : ?>
                                        <span class="option-title"><?php echo esc_html($service['titel']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($service['beschreibung'])) : ?>
                                        <span class="option-desc"><?php echo esc_html($service['beschreibung']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <button class="btn btn-primary quote-next" @click="nextStep()" :disabled="!canProceed()">
                        <?php esc_html_e('Weiter', 'toni-janis'); ?> &rarr;
                    </button>
                </div>

                <!-- Step 2: Project Details -->
                <div class="quote-step" :class="step === 2 ? 'active' : ''" x-show="step === 2" id="quoteStep2">
                    <h3><?php esc_html_e('Erzaehlen Sie uns mehr ueber Ihr Projekt', 'toni-janis'); ?></h3>

                    <div class="details-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-size"><?php esc_html_e('Grundstuecksgroesse (ca. m2)', 'toni-janis'); ?></label>
                                <input id="<?php echo esc_attr($block_id); ?>-size" type="number" x-model="details.size" placeholder="<?php esc_attr_e('z.B. 500', 'toni-janis'); ?>" id="propertySize">
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-timeframe"><?php esc_html_e('Gewuenschter Zeitraum', 'toni-janis'); ?></label>
                                <select id="<?php echo esc_attr($block_id); ?>-timeframe" x-model="details.timeframe" id="timeframe">
                                    <option value=""><?php esc_html_e('Bitte waehlen...', 'toni-janis'); ?></option>
                                    <option value="asap"><?php esc_html_e('So schnell wie moeglich', 'toni-janis'); ?></option>
                                    <option value="1month"><?php esc_html_e('Innerhalb 1 Monat', 'toni-janis'); ?></option>
                                    <option value="3months"><?php esc_html_e('Innerhalb 3 Monate', 'toni-janis'); ?></option>
                                    <option value="flexible"><?php esc_html_e('Flexibel', 'toni-janis'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="<?php echo esc_attr($block_id); ?>-description"><?php esc_html_e('Projektbeschreibung', 'toni-janis'); ?></label>
                            <textarea id="<?php echo esc_attr($block_id); ?>-description" x-model="details.description" placeholder="<?php esc_attr_e('Beschreiben Sie Ihr Projekt so detailliert wie moeglich...', 'toni-janis'); ?>" id="projectDescription"></textarea>
                        </div>
                        <div class="form-group">
                            <label><?php esc_html_e('Fotos hochladen (optional)', 'toni-janis'); ?></label>
                            <div class="upload-area" id="uploadArea">
                                <input type="file" id="projectPhotos" class="upload-input" multiple accept="image/*">
                                <span class="upload-icon-large">&#128247;</span>
                                <div class="upload-text"><?php esc_html_e('Bilder hochladen', 'toni-janis'); ?></div>
                                <div class="upload-subtext"><?php esc_html_e('Klicken oder Bilder hierher ziehen', 'toni-janis'); ?></div>
                                <div class="upload-formats"><?php esc_html_e('JPG, PNG, HEIC bis zu 5MB pro Bild (max. 10 Bilder)', 'toni-janis'); ?></div>
                            </div>
                            <div id="imagePreviewGrid" class="image-preview-grid"></div>
                            <div id="uploadCount" style="text-align: center;"></div>
                        </div>
                    </div>

                    <div class="quote-buttons">
                        <button class="btn btn-secondary" @click="prevStep()">&larr; <?php esc_html_e('Zurueck', 'toni-janis'); ?></button>
                        <button class="btn btn-primary" @click="nextStep()"><?php esc_html_e('Weiter', 'toni-janis'); ?> &rarr;</button>
                    </div>
                </div>

                <!-- Step 3: Contact Information -->
                <div class="quote-step" :class="step === 3 ? 'active' : ''" x-show="step === 3" id="quoteStep3">
                    <h3><?php esc_html_e('Ihre Kontaktdaten', 'toni-janis'); ?></h3>

                    <div class="details-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-firstName"><?php esc_html_e('Vorname', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-firstName" type="text" x-model="contact.firstName" placeholder="<?php esc_attr_e('Ihr Vorname', 'toni-janis'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-lastName"><?php esc_html_e('Nachname', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-lastName" type="text" x-model="contact.lastName" placeholder="<?php esc_attr_e('Ihr Nachname', 'toni-janis'); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-email"><?php esc_html_e('E-Mail', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-email" type="email" x-model="contact.email" placeholder="<?php esc_attr_e('ihre@email.de', 'toni-janis'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-phone"><?php esc_html_e('Telefon', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-phone" type="tel" x-model="contact.phone" placeholder="<?php esc_attr_e('0176 123 45678', 'toni-janis'); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-street"><?php esc_html_e('Strasse & Hausnummer', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-street" type="text" x-model="contact.street" placeholder="<?php esc_attr_e('Musterstrasse 123', 'toni-janis'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-city"><?php esc_html_e('PLZ & Ort', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-city" type="text" x-model="contact.city" placeholder="<?php esc_attr_e('27755 Delmenhorst', 'toni-janis'); ?>">
                            </div>
                        </div>
                        <label class="checkbox-label">
                            <input type="checkbox" x-model="contact.privacy" id="quotePrivacy" required>
                            <span><?php printf(
                                esc_html__('Ich stimme der %sDatenschutzerklaerung%s zu *', 'toni-janis'),
                                '<a href="' . esc_url(get_privacy_policy_url()) . '" target="_blank" rel="noopener noreferrer">',
                                '</a>'
                            ); ?></span>
                        </label>
                    </div>

                    <!-- Error Message -->
                    <template x-if="error">
                        <div role="alert" x-text="error" style="color: red; margin-top: 1rem;"></div>
                    </template>

                    <div class="quote-buttons">
                        <button class="btn btn-secondary" @click="prevStep()">&larr; <?php esc_html_e('Zurueck', 'toni-janis'); ?></button>
                        <button class="btn btn-primary" @click="submitForm()" :disabled="!canProceed() || submitting">
                            <span x-show="!submitting"><?php esc_html_e('Angebot anfordern', 'toni-janis'); ?> &#10003;</span>
                            <span x-show="submitting"><?php esc_html_e('Wird gesendet...', 'toni-janis'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</section>
