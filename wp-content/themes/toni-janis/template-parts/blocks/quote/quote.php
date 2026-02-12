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
    1 => __('Leistungen', 'toni-janis'),
    2 => __('Projektdetails', 'toni-janis'),
    3 => __('Kontaktdaten', 'toni-janis'),
];
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('quote', ['py-12 md:py-20'])); ?>"
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

        <!-- 3-Step Form -->
        <div
            x-data="{
                step: 1,
                totalSteps: 3,
                selectedServices: [],
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
                        <?php esc_html_e('Vielen Dank für Ihre Anfrage!', 'toni-janis'); ?>
                    </h3>
                    <p class="text-earth-brown/70">
                        <?php esc_html_e('Wir erstellen Ihr kostenloses Angebot und melden uns schnellstmöglich bei Ihnen.', 'toni-janis'); ?>
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
                                <?php if ($num < 3) : ?>
                                    <div
                                        :class="step > <?php echo $num; ?> ? 'bg-kiwi-green' : 'bg-gray-200'"
                                        class="flex-1 h-0.5 mx-2 transition-colors duration-300 self-start mt-4"
                                    ></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Step 1: Service Selection -->
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-2">
                            <?php esc_html_e('Welche Leistungen benötigen Sie?', 'toni-janis'); ?>
                        </h3>
                        <p class="text-earth-brown/60 text-sm mb-6">
                            <?php esc_html_e('Mehrfachauswahl möglich', 'toni-janis'); ?>
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php foreach ($services_data as $index => $service) : ?>
                                <button
                                    type="button"
                                    @click="toggleService('<?php echo esc_js($service['titel']); ?>')"
                                    :class="isSelected('<?php echo esc_js($service['titel']); ?>') ? 'border-kiwi-green bg-kiwi-green/5 ring-2 ring-kiwi-green/20' : 'border-gray-200 hover:border-kiwi-green/50'"
                                    class="p-5 rounded-xl border-2 text-left transition-all duration-200 relative"
                                >
                                    <!-- Checkbox indicator -->
                                    <div
                                        :class="isSelected('<?php echo esc_js($service['titel']); ?>') ? 'bg-kiwi-green border-kiwi-green' : 'border-gray-300'"
                                        class="absolute top-3 right-3 w-5 h-5 rounded border-2 flex items-center justify-center transition-colors"
                                    >
                                        <svg
                                            x-show="isSelected('<?php echo esc_js($service['titel']); ?>')"
                                            class="w-3 h-3 text-white"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>

                                    <?php if (!empty($service['icon'])) : ?>
                                        <div class="w-10 h-10 text-kiwi-green mb-3">
                                            <?php echo $service['icon']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($service['titel'])) : ?>
                                        <h4 class="font-bold text-earth-brown mb-1 pr-6">
                                            <?php echo esc_html($service['titel']); ?>
                                        </h4>
                                    <?php endif; ?>

                                    <?php if (!empty($service['beschreibung'])) : ?>
                                        <p class="text-earth-brown/60 text-sm">
                                            <?php echo esc_html($service['beschreibung']); ?>
                                        </p>
                                    <?php endif; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Step 2: Project Details -->
                    <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                            <?php esc_html_e('Projektdetails', 'toni-janis'); ?>
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Grundstücksgröße (ca. m²)', 'toni-janis'); ?>
                                </label>
                                <input
                                    type="text"
                                    x-model="details.size"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    placeholder="<?php esc_attr_e('z.B. 500 m²', 'toni-janis'); ?>"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Gewünschter Zeitrahmen', 'toni-janis'); ?>
                                </label>
                                <select
                                    x-model="details.timeframe"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors bg-white"
                                >
                                    <option value=""><?php esc_html_e('Bitte wählen...', 'toni-janis'); ?></option>
                                    <option value="sofort"><?php esc_html_e('So schnell wie möglich', 'toni-janis'); ?></option>
                                    <option value="1-monat"><?php esc_html_e('Innerhalb 1 Monat', 'toni-janis'); ?></option>
                                    <option value="3-monate"><?php esc_html_e('Innerhalb 3 Monaten', 'toni-janis'); ?></option>
                                    <option value="6-monate"><?php esc_html_e('Innerhalb 6 Monaten', 'toni-janis'); ?></option>
                                    <option value="flexibel"><?php esc_html_e('Flexibel', 'toni-janis'); ?></option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Projektbeschreibung', 'toni-janis'); ?>
                                </label>
                                <textarea
                                    x-model="details.description"
                                    rows="4"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors resize-none"
                                    placeholder="<?php esc_attr_e('Beschreiben Sie Ihr Projekt...', 'toni-janis'); ?>"
                                ></textarea>
                            </div>

                            <!-- File Upload Placeholder -->
                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Fotos hochladen (optional)', 'toni-janis'); ?>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-kiwi-green/50 transition-colors cursor-pointer">
                                    <svg class="w-8 h-8 text-earth-brown/40 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm text-earth-brown/50">
                                        <?php esc_html_e('Klicken Sie hier oder ziehen Sie Dateien hierher', 'toni-janis'); ?>
                                    </p>
                                    <p class="text-xs text-earth-brown/30 mt-1">
                                        <?php esc_html_e('JPG, PNG bis 10 MB', 'toni-janis'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Contact Info -->
                    <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                            <?php esc_html_e('Ihre Kontaktdaten', 'toni-janis'); ?>
                        </h3>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('Vorname', 'toni-janis'); ?> *
                                    </label>
                                    <input
                                        type="text"
                                        x-model="contact.firstName"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('Nachname', 'toni-janis'); ?> *
                                    </label>
                                    <input
                                        type="text"
                                        x-model="contact.lastName"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    >
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('E-Mail', 'toni-janis'); ?> *
                                    </label>
                                    <input
                                        type="email"
                                        x-model="contact.email"
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
                                        x-model="contact.phone"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                        placeholder="<?php esc_attr_e('0176 123 45678', 'toni-janis'); ?>"
                                    >
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('Straße + Nr.', 'toni-janis'); ?>
                                    </label>
                                    <input
                                        type="text"
                                        x-model="contact.street"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('PLZ + Ort', 'toni-janis'); ?>
                                    </label>
                                    <input
                                        type="text"
                                        x-model="contact.city"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    >
                                </div>
                            </div>

                            <!-- Privacy Checkbox -->
                            <div class="pt-2">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        x-model="contact.privacy"
                                        class="mt-1 w-4 h-4 rounded border-gray-300 text-kiwi-green focus:ring-kiwi-green"
                                    >
                                    <span class="text-sm text-earth-brown/70">
                                        <?php printf(
                                            esc_html__('Ich habe die %sDatenschutzerklärung%s gelesen und stimme der Verarbeitung meiner Daten zu. *', 'toni-janis'),
                                            '<a href="' . esc_url(get_privacy_policy_url()) . '" target="_blank" class="text-kiwi-green underline hover:text-kiwi-dark">',
                                            '</a>'
                                        ); ?>
                                    </span>
                                </label>
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
                                <span x-show="!submitting"><?php esc_html_e('Angebot anfordern', 'toni-janis'); ?></span>
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
