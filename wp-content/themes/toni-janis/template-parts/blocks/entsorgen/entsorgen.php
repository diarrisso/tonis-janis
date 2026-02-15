<?php
/**
 * Block: Entsorgungsservice
 *
 * Two-column layout: services list + benefits cards on left, form on right.
 * Form includes: type select, quantity, photo upload, contact fields, notes.
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

<section class="entsorgen-section" id="<?php echo esc_attr($block_id); ?>">

    <!-- Section Header -->
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

    <!-- Two-Column Layout -->
    <div class="entsorgen-container">

        <!-- Left Column: Services + Benefits -->
        <div class="entsorgen-info">
            <!-- Services List -->
            <?php if (!empty($services)) : ?>
                <h3><?php esc_html_e('Was wir entsorgen:', 'toni-janis'); ?></h3>
                <ul class="entsorgen-list">
                    <?php foreach ($services as $s) :
                        if (empty($s['es_text'])) continue;
                    ?>
                        <li><?php echo esc_html($s['es_text']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- Benefits Cards -->
            <?php if (!empty($vorteile)) : ?>
                <div class="entsorgen-benefits">
                    <?php foreach ($vorteile as $v) :
                        $icon  = $v['vorteil_icon'] ?? '';
                        $titel = $v['vorteil_titel'] ?? '';
                        $vtext = $v['vorteil_text'] ?? '';
                    ?>
                        <div class="benefit-box">
                            <?php if ($icon) : ?>
                                <div class="benefit-icon"><?php echo $icon; ?></div>
                            <?php endif; ?>

                            <?php if ($titel) : ?>
                                <h4><?php echo esc_html($titel); ?></h4>
                            <?php endif; ?>

                            <?php if ($vtext) : ?>
                                <p><?php echo esc_html($vtext); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Form -->
        <div class="entsorgen-form-wrapper"
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
                <div class="success-message" role="status" aria-live="polite">
                    <div class="success-icon">&#10003;</div>
                    <h3><?php esc_html_e('Anfrage gesendet!', 'toni-janis'); ?></h3>
                    <p><?php esc_html_e('Vielen Dank! Wir melden uns schnellstmöglich bei Ihnen zurück.', 'toni-janis'); ?></p>
                </div>
            </template>

            <!-- Form -->
            <template x-if="!submitted">
                <form class="entsorgen-form" id="entsorgenForm" @submit.prevent="submitForm()">
                    <h3><?php esc_html_e('Kostenlos Angebot anfordern', 'toni-janis'); ?></h3>

                    <!-- Type Select -->
                    <div class="form-group">
                        <label for="<?php echo esc_attr($block_id); ?>-type">
                            <?php esc_html_e('Was soll entsorgt werden?', 'toni-janis'); ?> *
                        </label>
                        <select
                            id="<?php echo esc_attr($block_id); ?>-type"
                            x-model="form.type"
                            required
                            aria-required="true"
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
                    <div class="form-group">
                        <label for="<?php echo esc_attr($block_id); ?>-menge">
                            <?php esc_html_e('Geschätzte Menge', 'toni-janis'); ?>
                        </label>
                        <input
                            id="<?php echo esc_attr($block_id); ?>-menge"
                            type="text"
                            x-model="form.menge"
                            placeholder="<?php esc_attr_e('z.B. 5 Kubikmeter, 10 Säcke, etc.', 'toni-janis'); ?>"
                        >
                    </div>

                    <!-- Photo Upload -->
                    <div class="form-group">
                        <label><?php esc_html_e('Fotos hochladen (optional)', 'toni-janis'); ?></label>
                        <div class="upload-area" id="entsorgenUploadArea">
                            <input type="file" id="entsorgenPhotos" class="upload-input" multiple accept="image/*">
                            <span class="upload-icon-large">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </span>
                            <div class="upload-text"><?php esc_html_e('Bilder der zu entsorgenden Objekte hochladen', 'toni-janis'); ?></div>
                            <div class="upload-subtext"><?php esc_html_e('Klicken oder Bilder hierher ziehen', 'toni-janis'); ?></div>
                            <div class="upload-formats"><?php esc_html_e('JPG, PNG, HEIC bis zu 5MB pro Bild', 'toni-janis'); ?></div>
                        </div>
                    </div>

                    <!-- Contact Fields -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="<?php echo esc_attr($block_id); ?>-name">
                                <?php esc_html_e('Ihr Name', 'toni-janis'); ?> *
                            </label>
                            <input
                                id="<?php echo esc_attr($block_id); ?>-name"
                                type="text"
                                x-model="form.name"
                                required
                                aria-required="true"
                            >
                        </div>
                        <div class="form-group">
                            <label for="<?php echo esc_attr($block_id); ?>-phone">
                                <?php esc_html_e('Telefon', 'toni-janis'); ?> *
                            </label>
                            <input
                                id="<?php echo esc_attr($block_id); ?>-phone"
                                type="tel"
                                x-model="form.phone"
                                required
                                aria-required="true"
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
                            >
                        </div>
                        <div class="form-group">
                            <label for="<?php echo esc_attr($block_id); ?>-ort">
                                <?php esc_html_e('PLZ & Ort', 'toni-janis'); ?> *
                            </label>
                            <input
                                id="<?php echo esc_attr($block_id); ?>-ort"
                                type="text"
                                x-model="form.ort"
                                placeholder="<?php esc_attr_e('27755 Delmenhorst', 'toni-janis'); ?>"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="<?php echo esc_attr($block_id); ?>-info">
                            <?php esc_html_e('Zusätzliche Informationen', 'toni-janis'); ?>
                        </label>
                        <textarea
                            id="<?php echo esc_attr($block_id); ?>-info"
                            x-model="form.info"
                            placeholder="<?php esc_attr_e('Besondere Hinweise, Zugangsweg, etc...', 'toni-janis'); ?>"
                        ></textarea>
                    </div>

                    <!-- Error Message -->
                    <template x-if="error">
                        <div class="error-message" role="alert" x-text="error"></div>
                    </template>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary" :disabled="submitting" style="width: 100%;">
                        <span x-show="!submitting">
                            <?php esc_html_e('Kostenloses Angebot anfordern', 'toni-janis'); ?>
                            <span>&rarr;</span>
                        </span>
                        <span x-show="submitting">
                            <?php esc_html_e('Wird gesendet...', 'toni-janis'); ?>
                        </span>
                    </button>
                </form>
            </template>
        </div>
    </div>
</section>
