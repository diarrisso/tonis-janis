<?php
/**
 * Block: Entsorgungsservice
 *
 * Two-column layout: services list + benefits cards on left, Alpine.js form on right.
 * Form includes: type select, quantity, photo upload placeholder, contact fields, notes.
 *
 * @package ToniJanis
 */

defined('ABSPATH') || exit;

// Fields
$label    = get_sub_field('entsorgen_label') ?: 'Entsorgungsservice';
$heading  = get_sub_field('entsorgen_heading');
$text     = get_sub_field('entsorgen_text');
$services = get_sub_field('entsorgen_services');
$vorteile = get_sub_field('entsorgen_vorteile');
$email    = get_sub_field('entsorgen_email') ?: toja_option('footer_email', get_option('admin_email'));
$block_id = toja_block_id('entsorgen');

// Build service options for select dropdown
$service_options = [];
if (!empty($services)) {
    foreach ($services as $s) {
        if (!empty($s['es_text'])) {
            $service_options[] = $s['es_text'];
        }
    }
}
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('entsorgen', ['py-12 md:py-20'])); ?>"
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

        <!-- Two-Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            <!-- Left Column: Services + Benefits -->
            <div>
                <!-- Services List -->
                <?php if (!empty($services)) : ?>
                    <div class="mb-8">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-4">
                            <?php esc_html_e('Unsere Entsorgungsleistungen', 'toni-janis'); ?>
                        </h3>
                        <ul class="space-y-3">
                            <?php foreach ($services as $s) :
                                if (empty($s['es_text'])) continue;
                            ?>
                                <li class="flex items-center gap-3">
                                    <div class="w-6 h-6 bg-kiwi-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-earth-brown">
                                        <?php echo esc_html($s['es_text']); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Benefits Cards -->
                <?php if (!empty($vorteile)) : ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach ($vorteile as $v) :
                            $icon  = $v['vorteil_icon'] ?? '';
                            $titel = $v['vorteil_titel'] ?? '';
                            $vtext = $v['vorteil_text'] ?? '';
                        ?>
                            <div class="bg-cream rounded-xl p-5">
                                <?php if ($icon) : ?>
                                    <div class="w-10 h-10 text-kiwi-green mb-3">
                                        <?php echo $icon; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($titel) : ?>
                                    <h4 class="font-bold text-earth-brown mb-1 text-sm">
                                        <?php echo esc_html($titel); ?>
                                    </h4>
                                <?php endif; ?>

                                <?php if ($vtext) : ?>
                                    <p class="text-earth-brown/60 text-sm">
                                        <?php echo esc_html($vtext); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Form -->
            <div
                x-data="{
                    form: {
                        type: '',
                        menge: '',
                        name: '',
                        phone: '',
                        email: '',
                        ort: '',
                        info: ''
                    },
                    submitted: false,
                    submitting: false,
                    error: '',
                    async submitForm() {
                        if (this.submitting) return;
                        if (!this.form.name || !this.form.phone || !this.form.email || !this.form.type) {
                            this.error = '<?php echo esc_js(__('Bitte füllen Sie alle Pflichtfelder aus.', 'toni-janis')); ?>';
                            return;
                        }
                        this.submitting = true;
                        this.error = '';

                        try {
                            const data = new FormData();
                            data.append('action', 'toja_entsorgen_request');
                            data.append('nonce', tojaData.nonce);
                            data.append('type', this.form.type);
                            data.append('menge', this.form.menge);
                            data.append('name', this.form.name);
                            data.append('phone', this.form.phone);
                            data.append('email', this.form.email);
                            data.append('ort', this.form.ort);
                            data.append('info', this.form.info);

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
                    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                        <div class="w-16 h-16 bg-kiwi-green/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-3">
                            <?php esc_html_e('Anfrage gesendet!', 'toni-janis'); ?>
                        </h3>
                        <p class="text-earth-brown/70 text-sm">
                            <?php esc_html_e('Vielen Dank! Wir melden uns schnellstmöglich bei Ihnen zurück.', 'toni-janis'); ?>
                        </p>
                    </div>
                </template>

                <!-- Form -->
                <template x-if="!submitted">
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                            <?php esc_html_e('Entsorgung anfragen', 'toni-janis'); ?>
                        </h3>

                        <div class="space-y-4">
                            <!-- Type Select -->
                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Art der Entsorgung', 'toni-janis'); ?> *
                                </label>
                                <select
                                    x-model="form.type"
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors bg-white"
                                >
                                    <option value=""><?php esc_html_e('Bitte wählen...', 'toni-janis'); ?></option>
                                    <?php foreach ($service_options as $option) : ?>
                                        <option value="<?php echo esc_attr($option); ?>">
                                            <?php echo esc_html($option); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Geschätzte Menge', 'toni-janis'); ?>
                                </label>
                                <input
                                    type="text"
                                    x-model="form.menge"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    placeholder="<?php esc_attr_e('z.B. 2 Kubikmeter, 1 LKW-Ladung', 'toni-janis'); ?>"
                                >
                            </div>

                            <!-- Photo Upload Placeholder -->
                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Fotos (optional)', 'toni-janis'); ?>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-kiwi-green/50 transition-colors cursor-pointer">
                                    <svg class="w-6 h-6 text-earth-brown/40 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-xs text-earth-brown/50">
                                        <?php esc_html_e('Fotos hochladen', 'toni-janis'); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Contact Fields -->
                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Name', 'toni-janis'); ?> *
                                </label>
                                <input
                                    type="text"
                                    x-model="form.name"
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                >
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('Telefon', 'toni-janis'); ?> *
                                    </label>
                                    <input
                                        type="tel"
                                        x-model="form.phone"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('E-Mail', 'toni-janis'); ?> *
                                    </label>
                                    <input
                                        type="email"
                                        x-model="form.email"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Ort / Adresse', 'toni-janis'); ?>
                                </label>
                                <input
                                    type="text"
                                    x-model="form.ort"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                    placeholder="<?php esc_attr_e('Wo soll entsorgt werden?', 'toni-janis'); ?>"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-earth-brown mb-1">
                                    <?php esc_html_e('Zusätzliche Informationen', 'toni-janis'); ?>
                                </label>
                                <textarea
                                    x-model="form.info"
                                    rows="3"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors resize-none"
                                    placeholder="<?php esc_attr_e('Weitere Hinweise, Zugänglichkeit, Terminwünsche...', 'toni-janis'); ?>"
                                ></textarea>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <template x-if="error">
                            <div class="mt-4 p-3 bg-red-50 text-red-700 rounded-xl text-sm" x-text="error"></div>
                        </template>

                        <!-- Submit Button -->
                        <button
                            type="button"
                            @click="submitForm()"
                            :disabled="submitting"
                            :class="submitting ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'bg-kiwi-green hover:bg-kiwi-dark text-white'"
                            class="w-full mt-6 px-8 py-3 font-semibold rounded-xl transition-colors duration-200"
                        >
                            <span x-show="!submitting"><?php esc_html_e('Anfrage senden', 'toni-janis'); ?></span>
                            <span x-show="submitting" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <?php esc_html_e('Wird gesendet...', 'toni-janis'); ?>
                            </span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>
