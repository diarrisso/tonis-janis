<?php
/**
 * Block: Termin buchen
 *
 * Multi-step appointment booking form with Alpine.js.
 * Step 1: Consultation type selection (radio cards)
 * Step 2: Date input
 * Step 3: Time slot selection (08:00 - 16:00 hourly)
 * Step 4: Contact form with summary
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('appointment_label') ?: 'Termin buchen';
$heading  = get_sub_field('appointment_heading');
$text     = get_sub_field('appointment_text');
$typen    = get_sub_field('appointment_typen');
$email    = get_sub_field('appointment_email') ?: toja_option('footer_email', get_option('admin_email'));
$block_id = toja_block_id('appointment');

if (empty($typen)) {
    return;
}

// Build types data for Alpine.js
$types_data = [];
foreach ($typen as $t) {
    $types_data[] = [
        'icon'         => $t['typ_icon'] ?? '',
        'titel'        => $t['typ_titel'] ?? '',
        'beschreibung' => $t['typ_beschreibung'] ?? '',
    ];
}

// Time slots 08:00 - 17:00
$time_slots = [];
for ($h = 8; $h <= 17; $h++) {
    $time_slots[] = sprintf('%02d:00', $h);
}

$steps = [
    1 => __('Beratungsart', 'toni-janis'),
    2 => __('Datum waehlen', 'toni-janis'),
    3 => __('Uhrzeit', 'toni-janis'),
    4 => __('Ihre Daten', 'toni-janis'),
];
?>

<section class="appointment" id="<?php echo esc_attr($block_id); ?>">

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
            totalSteps: 4,
            stepAnnouncement: '',
            type: '',
            typeLabel: '',
            selectedDate: '',
            selectedTime: '',
            form: {
                vorname: '',
                nachname: '',
                email: '',
                phone: '',
                adresse: '',
                plz: '',
                ort: '',
                message: ''
            },
            submitted: false,
            submitting: false,
            error: '',
            types: <?php echo esc_attr(wp_json_encode($types_data)); ?>,
            selectType(titel) {
                this.type = titel;
                this.typeLabel = titel;
            },
            canProceed() {
                if (this.step === 1) return this.type !== '';
                if (this.step === 2) return this.selectedDate !== '';
                if (this.step === 3) return this.selectedTime !== '';
                if (this.step === 4) return this.form.vorname && this.form.nachname && this.form.email && this.form.phone;
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
                    data.append('action', 'toja_appointment_request');
                    data.append('nonce', tojaData.nonce);
                    data.append('type', this.type);
                    data.append('date', this.selectedDate);
                    data.append('time', this.selectedTime);
                    data.append('vorname', this.form.vorname);
                    data.append('nachname', this.form.nachname);
                    data.append('email', this.form.email);
                    data.append('phone', this.form.phone);
                    data.append('adresse', this.form.adresse);
                    data.append('plz', this.form.plz);
                    data.append('ort', this.form.ort);
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
        class="appointment-container"
    >
        <!-- Live Region for Step Announcements -->
        <div class="sr-only" aria-live="polite" aria-atomic="true" x-text="stepAnnouncement"></div>

        <!-- Success Message -->
        <template x-if="submitted">
            <div class="success-message" role="status" aria-live="polite">
                <div class="success-icon">&#10003;</div>
                <h3><?php esc_html_e('Vielen Dank!', 'toni-janis'); ?></h3>
                <p><?php esc_html_e('Ihre Terminanfrage wurde erfolgreich gesendet. Wir melden uns in Kuerze bei Ihnen.', 'toni-janis'); ?></p>
            </div>
        </template>

        <template x-if="!submitted">
            <div>
                <!-- Progress Stepper -->
                <div class="appointment-progress" role="list" aria-label="<?php esc_attr_e('Fortschritt', 'toni-janis'); ?>">
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
                        <?php if ($num < 4) : ?>
                            <div class="progress-line" :class="step > <?php echo $num; ?> ? 'active' : ''"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Step 1: Consultation Type -->
                <div class="appointment-step" :class="step === 1 ? 'active' : ''" x-show="step === 1" id="appointmentStep1">
                    <h3><?php esc_html_e('Welche Art von Beratung benoetigen Sie?', 'toni-janis'); ?></h3>

                    <div class="consultation-types">
                        <?php foreach ($types_data as $index => $typ) : ?>
                            <label class="consultation-option">
                                <input type="radio" name="consultation-type" value="<?php echo esc_attr($typ['titel']); ?>" @change="selectType('<?php echo esc_js($typ['titel']); ?>')">
                                <div class="option-card">
                                    <?php if (!empty($typ['icon'])) : ?>
                                        <?php echo $typ['icon']; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($typ['titel'])) : ?>
                                        <span class="option-title"><?php echo esc_html($typ['titel']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($typ['beschreibung'])) : ?>
                                        <span class="option-desc"><?php echo esc_html($typ['beschreibung']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <button class="btn btn-primary" @click="nextStep()" :disabled="!canProceed()" style="margin-top: 2rem;">
                        <?php esc_html_e('Weiter', 'toni-janis'); ?>
                        <span>&rarr;</span>
                    </button>
                </div>

                <!-- Step 2: Date Selection -->
                <div class="appointment-step" :class="step === 2 ? 'active' : ''" x-show="step === 2" id="appointmentStep2">
                    <h3><?php esc_html_e('Waehlen Sie ein Datum', 'toni-janis'); ?></h3>

                    <div class="calendar-wrapper">
                        <label for="<?php echo esc_attr($block_id); ?>-date" class="sr-only">
                            <?php esc_html_e('Datum waehlen', 'toni-janis'); ?>
                        </label>
                        <input
                            id="<?php echo esc_attr($block_id); ?>-date"
                            type="date"
                            x-model="selectedDate"
                            :min="new Date().toISOString().split('T')[0]"
                            aria-required="true"
                        >
                    </div>

                    <div class="step-nav">
                        <button class="btn btn-secondary" @click="prevStep()">
                            &larr; <?php esc_html_e('Zurueck', 'toni-janis'); ?>
                        </button>
                        <button class="btn btn-primary" @click="nextStep()" :disabled="!canProceed()">
                            <?php esc_html_e('Weiter', 'toni-janis'); ?>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Time Slot Selection -->
                <div class="appointment-step" :class="step === 3 ? 'active' : ''" x-show="step === 3" id="appointmentStep3">
                    <h3><?php esc_html_e('Waehlen Sie eine Uhrzeit', 'toni-janis'); ?></h3>
                    <p style="text-align: center; margin-bottom: 2rem;">
                        <?php esc_html_e('Verfuegbare Zeiten fuer', 'toni-janis'); ?> <strong x-text="selectedDate" id="selectedDateDisplay">--</strong>
                    </p>

                    <div class="time-slots-grid">
                        <?php foreach ($time_slots as $slot) : ?>
                            <button
                                type="button"
                                class="time-slot"
                                :class="selectedTime === '<?php echo esc_js($slot); ?>' ? 'active' : ''"
                                @click="selectedTime = '<?php echo esc_js($slot); ?>'"
                                data-time="<?php echo esc_attr($slot); ?>"
                            >
                                <?php echo esc_html($slot); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <div class="step-nav">
                        <button class="btn btn-secondary" @click="prevStep()">
                            &larr; <?php esc_html_e('Zurueck', 'toni-janis'); ?>
                        </button>
                        <button class="btn btn-primary" @click="nextStep()" :disabled="!canProceed()">
                            <?php esc_html_e('Weiter', 'toni-janis'); ?>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Step 4: Contact Details -->
                <div class="appointment-step" :class="step === 4 ? 'active' : ''" x-show="step === 4" id="appointmentStep4">
                    <h3><?php esc_html_e('Ihre Kontaktdaten', 'toni-janis'); ?></h3>

                    <form class="appointment-form" id="finalAppointmentForm" @submit.prevent="submitForm()">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-vorname"><?php esc_html_e('Vorname', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-vorname" type="text" x-model="form.vorname" required placeholder="<?php esc_attr_e('Ihr Vorname', 'toni-janis'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-nachname"><?php esc_html_e('Nachname', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-nachname" type="text" x-model="form.nachname" required placeholder="<?php esc_attr_e('Ihr Nachname', 'toni-janis'); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-email"><?php esc_html_e('E-Mail', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-email" type="email" x-model="form.email" required placeholder="<?php esc_attr_e('ihre@email.de', 'toni-janis'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-phone"><?php esc_html_e('Telefon', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-phone" type="tel" x-model="form.phone" required placeholder="<?php esc_attr_e('0176 123 4567', 'toni-janis'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="<?php echo esc_attr($block_id); ?>-adresse"><?php esc_html_e('Adresse', 'toni-janis'); ?> *</label>
                            <input id="<?php echo esc_attr($block_id); ?>-adresse" type="text" x-model="form.adresse" required placeholder="<?php esc_attr_e('Strasse und Hausnummer', 'toni-janis'); ?>">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-plz"><?php esc_html_e('PLZ', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-plz" type="text" x-model="form.plz" required placeholder="27755">
                            </div>
                            <div class="form-group">
                                <label for="<?php echo esc_attr($block_id); ?>-ort"><?php esc_html_e('Ort', 'toni-janis'); ?> *</label>
                                <input id="<?php echo esc_attr($block_id); ?>-ort" type="text" x-model="form.ort" required placeholder="Delmenhorst">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="<?php echo esc_attr($block_id); ?>-message"><?php esc_html_e('Projektbeschreibung (optional)', 'toni-janis'); ?></label>
                            <textarea id="<?php echo esc_attr($block_id); ?>-message" x-model="form.message" rows="3" placeholder="<?php esc_attr_e('Beschreiben Sie kurz Ihr Anliegen...', 'toni-janis'); ?>"></textarea>
                        </div>

                        <div class="appointment-summary">
                            <h4><?php esc_html_e('Ihre Buchung:', 'toni-janis'); ?></h4>
                            <div class="summary-item">
                                <strong><?php esc_html_e('Beratungsart:', 'toni-janis'); ?></strong>
                                <span id="summaryConsultationType" x-text="typeLabel">--</span>
                            </div>
                            <div class="summary-item">
                                <strong><?php esc_html_e('Datum:', 'toni-janis'); ?></strong>
                                <span id="summaryDate" x-text="selectedDate">--</span>
                            </div>
                            <div class="summary-item">
                                <strong><?php esc_html_e('Uhrzeit:', 'toni-janis'); ?></strong>
                                <span id="summaryTime" x-text="selectedTime">--</span>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <template x-if="error">
                            <div role="alert" x-text="error" style="color: red; margin-top: 1rem;"></div>
                        </template>

                        <div class="step-nav">
                            <button type="button" class="btn btn-secondary" @click="prevStep()">
                                &larr; <?php esc_html_e('Zurueck', 'toni-janis'); ?>
                            </button>
                            <button type="submit" class="btn btn-primary" :disabled="!canProceed() || submitting">
                                <span x-show="!submitting"><?php esc_html_e('Termin verbindlich buchen', 'toni-janis'); ?> <span>&#10003;</span></span>
                                <span x-show="submitting"><?php esc_html_e('Wird gesendet...', 'toni-janis'); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</section>
