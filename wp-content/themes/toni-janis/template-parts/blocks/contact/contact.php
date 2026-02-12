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

// Determine grid layout
$has_both    = $show_infos && $show_form;
$grid_class  = $has_both ? 'grid-cols-1 lg:grid-cols-2' : 'grid-cols-1 max-w-2xl mx-auto';
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(toja_block_classes('contact', ['py-12 md:py-20'])); ?>"
>
    <div class="container mx-auto px-4">

        <!-- Section Header -->
        <div class="text-center mb-12">
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

        <!-- Content Grid -->
        <div class="grid <?php echo esc_attr($grid_class); ?> gap-8 lg:gap-12">

            <!-- Left Column: Contact Info -->
            <?php if ($show_infos) : ?>
                <div>
                    <div class="bg-cream rounded-2xl p-6 md:p-8 h-full">
                        <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                            <?php esc_html_e('Kontaktinformationen', 'toni-janis'); ?>
                        </h3>

                        <div class="space-y-6">
                            <!-- Company Name -->
                            <?php if (!empty($contact['company'])) : ?>
                                <div>
                                    <p class="font-bold text-earth-brown">
                                        <?php echo esc_html($contact['company']); ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <!-- Address -->
                            <?php if (!empty($contact['address'])) : ?>
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-kiwi-green/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-earth-brown text-sm"><?php esc_html_e('Adresse', 'toni-janis'); ?></p>
                                        <p class="text-earth-brown/70 text-sm"><?php echo esc_html($contact['address']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Phone -->
                            <?php if (!empty($contact['phone1'])) : ?>
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-kiwi-green/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-earth-brown text-sm"><?php esc_html_e('Telefon', 'toni-janis'); ?></p>
                                        <a href="<?php echo esc_url(toja_phone_href($contact['phone1'])); ?>" class="text-earth-brown/70 text-sm hover:text-kiwi-green transition-colors">
                                            <?php echo esc_html($contact['phone1']); ?>
                                        </a>
                                        <?php if (!empty($contact['phone2'])) : ?>
                                            <br>
                                            <a href="<?php echo esc_url(toja_phone_href($contact['phone2'])); ?>" class="text-earth-brown/70 text-sm hover:text-kiwi-green transition-colors">
                                                <?php echo esc_html($contact['phone2']); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Email -->
                            <?php if (!empty($contact['email'])) : ?>
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-kiwi-green/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-earth-brown text-sm"><?php esc_html_e('E-Mail', 'toni-janis'); ?></p>
                                        <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="text-earth-brown/70 text-sm hover:text-kiwi-green transition-colors">
                                            <?php echo esc_html($contact['email']); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- WhatsApp -->
                            <?php if (!empty($contact['whatsapp'])) : ?>
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-kiwi-green/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-kiwi-green" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-earth-brown text-sm"><?php esc_html_e('WhatsApp', 'toni-janis'); ?></p>
                                        <a href="<?php echo esc_url($contact['whatsapp']); ?>" target="_blank" rel="noopener noreferrer" class="text-earth-brown/70 text-sm hover:text-kiwi-green transition-colors">
                                            <?php esc_html_e('Nachricht senden', 'toni-janis'); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Right Column: Contact Form -->
            <?php if ($show_form) : ?>
                <div
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
                        <div class="bg-white rounded-2xl shadow-lg p-8 text-center h-full flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-kiwi-green/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 text-kiwi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="font-heading text-xl font-bold text-earth-brown mb-3">
                                <?php esc_html_e('Nachricht gesendet!', 'toni-janis'); ?>
                            </h3>
                            <p class="text-earth-brown/70 text-sm">
                                <?php esc_html_e('Vielen Dank für Ihre Nachricht. Wir melden uns schnellstmöglich bei Ihnen.', 'toni-janis'); ?>
                            </p>
                        </div>
                    </template>

                    <!-- Form -->
                    <template x-if="!submitted">
                        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                            <h3 class="font-heading text-xl font-bold text-earth-brown mb-6">
                                <?php esc_html_e('Schreiben Sie uns', 'toni-janis'); ?>
                            </h3>

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
                                            <?php esc_html_e('Telefon', 'toni-janis'); ?>
                                        </label>
                                        <input
                                            type="tel"
                                            x-model="form.phone"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors"
                                            placeholder="<?php esc_attr_e('0176 123 45678', 'toni-janis'); ?>"
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('Leistung', 'toni-janis'); ?>
                                    </label>
                                    <select
                                        x-model="form.service"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors bg-white"
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

                                <div>
                                    <label class="block text-sm font-medium text-earth-brown mb-1">
                                        <?php esc_html_e('Nachricht', 'toni-janis'); ?> *
                                    </label>
                                    <textarea
                                        x-model="form.message"
                                        rows="5"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-kiwi-green focus:ring-2 focus:ring-kiwi-green/20 outline-none transition-colors resize-none"
                                        placeholder="<?php esc_attr_e('Wie können wir Ihnen helfen?', 'toni-janis'); ?>"
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
                                <span x-show="!submitting"><?php esc_html_e('Nachricht senden', 'toni-janis'); ?></span>
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
            <?php endif; ?>
        </div>
    </div>
</section>
