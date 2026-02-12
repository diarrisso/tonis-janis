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

// Time slots 08:00 - 16:00
$time_slots = [];
for ($h = 8; $h <= 16; $h++) {
    $time_slots[] = sprintf('%02d:00', $h);
}

$steps = [
    1 => __('Beratungsart', 'toni-janis'),
    2 => __('Datum', 'toni-janis'),
    3 => __('Uhrzeit', 'toni-janis'),
    4 => __('Kontaktdaten', 'toni-janis'),
];
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('appointment', ['py-12 md:py-20 bg-cream'])); ?>"
>
    <div class="container mx-auto px-4">

        <!-- Section Header -->
        <div class="text-center mb-12">
            <?php if ($label) : ?>
                <span class="inline-block text-kiwi-green font-semibold text-sm uppercase tracking-wider mb-2">
                    <?php echo esc_html($label); ?>
                </span>
            <?php endif; ?>

            <?php if ($heading) : ?>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-earth-brown mb-4">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="text-earth-brown/70 max-w-2xl mx-auto">
                    <?php echo esc_html($text); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Multi-Step Form -->
        <div
            x-data="{
                step: 1,
                totalSteps: 4,
                type: '',
                typeLabel: '',
                selectedDate: '',
                selectedTime: '',
                form: {
                    name: '',
                    email: '',
                    phone: '',
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
                    if (this.step === 4) return this.form.name && this.form.email && this.form.phone;
                    return false;
                },
                nextStep() {
                    if (this.canProceed() && this.step < this.totalSteps) {
                        this.step++;
                    }
                },
                prevStep() {
                    if (this.step > 1) {
                        this.step--;
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
                        data.append('name', this.form.name);
                        data.append('email', this.form.email);
                        data.append('phone', this.form.phone);
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
            class="max-w-3xl mx-auto"
        >
            <!-- Success Message -->
            <template x-if="submitted">
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 text-center">
                    <div class="w-16 h-16 bg-kiwi-green/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-2xl font-bold text-earth-brown mb-3">
                        <?php esc_html_e('Vielen Dank!', 'toni-janis'); ?>
                    </h3>
                    <p class="text-earth-brown/70">
                        <?php esc_html_e('Ihre Terminanfrage wurde erfolgreich gesendet. Wir melden uns in Kürze bei Ihnen.', 'toni-janis'); ?>
                    </p>
                </div>
            </template>

            <template x-if="!submitted">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-10">

                    <!-- Progress Bar -->
                    <div class="mb-10">
                        <div class="flex items-center justify-between mb-3">
                            <?php foreach ($steps as $num => $step_label) : ?>
                                <div class="flex flex-col items-center flex-1">
                                    <div
                                        :class="step >= <?php echo $num; ?> ? 'bg-kiwi-green text-white' : 'bg-gray-200 text-earth-brown/50'"
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300"
                                    >
                                        <template x-if="step > <?php echo $num; ?>">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </template>
                                        <template x-if="step <= <?php echo $num; ?>">
                                            <span><?php echo $num; ?></span>
                                        </template>
                                    </div>
                                    <span
                                        :class="step >= <?php echo $num; ?> ? 'text-kiwi-dark' : 'text-earth-brown/40'"
                                        class="text-xs mt-1 hidden sm:block transition-colors duration-300"
                                    >
                                        <?php echo esc_html($step_label); ?>
                                    </span>
                                </div>
                                <?php if ($num < 4) : ?>
                                    <div
                                        :class="step > <?php echo $num; ?> ? 'bg-kiwi-green' : 'bg-gray-200'"
                                        class="flex-1 h-0.5 mx-2 transition-colors duration-300 self-start mt-4"
                                    ></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Step 1: Consultation Type -->
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                            <?php esc_html_e('Wählen Sie eine Beratungsart', 'toni-janis'); ?>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php foreach ($types_data as $index => $typ) : ?>
                                <button
                                    type="button"
                                    @click="selectType('<?php echo esc_js($typ['titel']); ?>')"
                                    :class="type === '<?php echo esc_js($typ['titel']); ?>' ? 'border-kiwi-green bg-kiwi-green/5 ring-2 ring-kiwi-green/20' : 'border-gray-200 hover:border-kiwi-green/50'"
                                    class="p-5 rounded-xl border-2 text-left transition-all duration-200"
                                >
                                    <?php if (!empty($typ['icon'])) : ?>
                                        <div class="w-10 h-10 text-kiwi-green mb-3">
                                            <?php echo $typ['icon']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($typ['titel'])) : ?>
                                        <h4 class="font-bold text-earth-brown mb-1">
                                            <?php echo esc_html($typ['titel']); ?>
                                        </h4>
                                    <?php endif; ?>

                                    <?php if (!empty($typ['beschreibung'])) : ?>
                                        <p class="text-earth-brown/60 text-sm">
                                            <?php echo esc_html($typ['beschreibung']); ?>
                                        </p>
                                    <?php endif; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Step 2: Date Selection -->
                    <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                            <?php esc_html_e('Wählen Sie ein Datum', 'toni-janis'); ?>
                        </h3>

                        <div class="max-w-sm">
                            <input
                                type="date"
                                x-model="selectedDate"
                                :min="new Date().toISOString().split('T')[0]"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors text-earth-brown"
                            >
                        </div>
                    </div>

                    <!-- Step 3: Time Slot Selection -->
                    <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                            <?php esc_html_e('Wählen Sie eine Uhrzeit', 'toni-janis'); ?>
                        </h3>

                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">
                            <?php foreach ($time_slots as $slot) : ?>
                                <button
                                    type="button"
                                    @click="selectedTime = '<?php echo esc_js($slot); ?>'"
                                    :class="selectedTime === '<?php echo esc_js($slot); ?>' ? 'bg-kiwi-green text-white border-kiwi-green' : 'bg-white text-earth-brown border-gray-200 hover:border-kiwi-green/50'"
                                    class="px-4 py-3 rounded-xl border-2 font-medium text-sm transition-all duration-200"
                                >
                                    <?php echo esc_html($slot); ?> <?php esc_html_e('Uhr', 'toni-janis'); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Step 4: Contact Form + Summary -->
                    <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                            <?php esc_html_e('Ihre Kontaktdaten', 'toni-janis'); ?>
                        </h3>

                        <!-- Summary -->
                        <div class="bg-kiwi-green/5 rounded-xl p-4 mb-6">
                            <h4 class="font-bold text-earth-brown text-sm mb-2">
                                <?php esc_html_e('Zusammenfassung', 'toni-janis'); ?>
                            </h4>
                            <div class="text-sm text-earth-brown/70 space-y-1">
                                <p><span class="font-medium"><?php esc_html_e('Art:', 'toni-janis'); ?></span> <span x-text="typeLabel"></span></p>
                                <p><span class="font-medium"><?php esc_html_e('Datum:', 'toni-janis'); ?></span> <span x-text="selectedDate"></span></p>
                                <p><span class="font-medium"><?php esc_html_e('Uhrzeit:', 'toni-janis'); ?></span> <span x-text="selectedTime + ' Uhr'"></span></p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Name', 'toni-janis'); ?> *
                                </label>
                                <input
                                    type="text"
                                    x-model="form.name"
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    placeholder="<?php esc_attr_e('Ihr vollständiger Name', 'toni-janis'); ?>"
                                >
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('E-Mail', 'toni-janis'); ?> *
                                    </label>
                                    <input
                                        type="email"
                                        x-model="form.email"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                        placeholder="<?php esc_attr_e('ihre@email.de', 'toni-janis'); ?>"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('Telefon', 'toni-janis'); ?> *
                                    </label>
                                    <input
                                        type="tel"
                                        x-model="form.phone"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                        placeholder="<?php esc_attr_e('0176 123 45678', 'toni-janis'); ?>"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Nachricht (optional)', 'toni-janis'); ?>
                                </label>
                                <textarea
                                    x-model="form.message"
                                    rows="3"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors resize-none"
                                    placeholder="<?php esc_attr_e('Zusätzliche Informationen oder Wünsche...', 'toni-janis'); ?>"
                                ></textarea>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <template x-if="error">
                            <div class="mt-4 p-3 bg-red-50 text-red-700 rounded-xl text-sm" x-text="error"></div>
                        </template>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                        <button
                            type="button"
                            @click="prevStep()"
                            x-show="step > 1"
                            class="px-6 py-3 text-earth-brown font-medium rounded-xl hover:bg-gray-100 transition-colors"
                        >
                            <?php esc_html_e('Zurück', 'toni-janis'); ?>
                        </button>

                        <div x-show="step === 1"></div>

                        <template x-if="step < totalSteps">
                            <button
                                type="button"
                                @click="nextStep()"
                                :disabled="!canProceed()"
                                :class="canProceed() ? 'bg-kiwi-green hover:bg-kiwi-dark text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                class="px-8 py-3 font-semibold rounded-xl transition-colors duration-200"
                            >
                                <?php esc_html_e('Weiter', 'toni-janis'); ?>
                            </button>
                        </template>

                        <template x-if="step === totalSteps">
                            <button
                                type="button"
                                @click="submitForm()"
                                :disabled="!canProceed() || submitting"
                                :class="canProceed() && !submitting ? 'bg-kiwi-green hover:bg-kiwi-dark text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                class="px-8 py-3 font-semibold rounded-xl transition-colors duration-200"
                            >
                                <span x-show="!submitting"><?php esc_html_e('Termin anfragen', 'toni-janis'); ?></span>
                                <span x-show="submitting" class="flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <?php esc_html_e('Wird gesendet...', 'toni-janis'); ?>
                                </span>
                            </button>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>
