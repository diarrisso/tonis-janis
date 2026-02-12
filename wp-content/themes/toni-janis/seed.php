<?php
/**
 * Seed Script - Populate WordPress with demo content
 * Run: wp eval-file wp-content/themes/toni-janis/seed.php
 *
 * @package ToniJanis
 */

if (!defined('ABSPATH')) {
    echo "Run this script via WP-CLI: wp eval-file wp-content/themes/toni-janis/seed.php\n";
    exit;
}

// Prevent duplicate runs
if (get_option('toja_seed_completed')) {
    echo "Seed already completed. Delete option 'toja_seed_completed' to re-run.\n";
    echo "Or run: wp option delete toja_seed_completed\n";
    exit;
}

echo "=== Toni Janis Seed Script ===\n\n";

// ─────────────────────────────────────────────────────────────
// Section 1: Helper functions
// ─────────────────────────────────────────────────────────────

function seed_page($title, $slug, $content = '') {
    $existing = get_page_by_path($slug);
    if ($existing) {
        echo "  Page '$title' already exists (ID: {$existing->ID})\n";
        return $existing->ID;
    }
    $id = wp_insert_post([
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ]);
    echo "  Created page '$title' (ID: $id)\n";
    return $id;
}

function seed_cpt($post_type, $title, $content = '', $args = []) {
    $existing = get_posts([
        'post_type'   => $post_type,
        'title'       => $title,
        'post_status' => 'any',
        'numberposts' => 1,
    ]);
    if (!empty($existing)) {
        echo "  $post_type '$title' already exists (ID: {$existing[0]->ID})\n";
        return $existing[0]->ID;
    }
    $post_data = array_merge([
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => $post_type,
    ], $args);
    $id = wp_insert_post($post_data);
    echo "  Created $post_type '$title' (ID: $id)\n";
    return $id;
}

function seed_term($term_name, $taxonomy) {
    $existing = term_exists($term_name, $taxonomy);
    if ($existing) {
        echo "  Term '$term_name' already exists (ID: {$existing['term_id']})\n";
        return (int) $existing['term_id'];
    }
    $result = wp_insert_term($term_name, $taxonomy);
    if (is_wp_error($result)) {
        echo "  ERROR creating term '$term_name': " . $result->get_error_message() . "\n";
        return 0;
    }
    echo "  Created term '$term_name' (ID: {$result['term_id']})\n";
    return (int) $result['term_id'];
}

// ─────────────────────────────────────────────────────────────
// Section 2: Create all pages
// ─────────────────────────────────────────────────────────────

echo "--- Creating Pages ---\n";

$page_startseite   = seed_page('Startseite', 'startseite');
$page_leistungen   = seed_page('Leistungen', 'leistungen');
$page_ueber_uns    = seed_page('Über uns', 'ueber-uns');
$page_projekte     = seed_page('Projekte', 'projekte');
$page_galerie      = seed_page('Galerie', 'galerie');
$page_karriere     = seed_page('Karriere', 'karriere');
$page_kontakt      = seed_page('Kontakt', 'kontakt');
$page_angebote     = seed_page('Angebote', 'angebote');
$page_termin       = seed_page('Termin buchen', 'termin-buchen');
$page_blog         = seed_page('Blog', 'blog');
$page_impressum    = seed_page('Impressum', 'impressum');
$page_datenschutz  = seed_page('Datenschutz', 'datenschutz');

// Set static front page
update_option('show_on_front', 'page');
update_option('page_on_front', $page_startseite);
update_option('page_for_posts', $page_blog);
echo "  Set static front page to Startseite (ID: $page_startseite)\n";
echo "  Set blog page to Blog (ID: $page_blog)\n\n";

// ─────────────────────────────────────────────────────────────
// Section 3: Create menus
// ─────────────────────────────────────────────────────────────

echo "--- Creating Menus ---\n";

// Primary menu
$primary_menu_name = 'Hauptmenu';
$primary_menu_exists = wp_get_nav_menu_object($primary_menu_name);
if ($primary_menu_exists) {
    $primary_menu_id = $primary_menu_exists->term_id;
    echo "  Menu '$primary_menu_name' already exists (ID: $primary_menu_id)\n";
} else {
    $primary_menu_id = wp_create_nav_menu($primary_menu_name);
    echo "  Created menu '$primary_menu_name' (ID: $primary_menu_id)\n";
}

$primary_items = [
    'Leistungen' => $page_leistungen,
    'Über uns'   => $page_ueber_uns,
    'Projekte'   => $page_projekte,
    'Galerie'    => $page_galerie,
    'Karriere'   => $page_karriere,
];

$position = 1;
foreach ($primary_items as $label => $page_id) {
    wp_update_nav_menu_item($primary_menu_id, 0, [
        'menu-item-title'     => $label,
        'menu-item-object'    => 'page',
        'menu-item-object-id' => $page_id,
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish',
        'menu-item-position'  => $position++,
    ]);
}

// Footer menu
$footer_menu_name = 'Footer Menu';
$footer_menu_exists = wp_get_nav_menu_object($footer_menu_name);
if ($footer_menu_exists) {
    $footer_menu_id = $footer_menu_exists->term_id;
    echo "  Menu '$footer_menu_name' already exists (ID: $footer_menu_id)\n";
} else {
    $footer_menu_id = wp_create_nav_menu($footer_menu_name);
    echo "  Created menu '$footer_menu_name' (ID: $footer_menu_id)\n";
}

$footer_items = [
    'Leistungen' => $page_leistungen,
    'Über uns'   => $page_ueber_uns,
    'Projekte'   => $page_projekte,
    'Karriere'   => $page_karriere,
    'Kontakt'    => $page_kontakt,
];

$position = 1;
foreach ($footer_items as $label => $page_id) {
    wp_update_nav_menu_item($footer_menu_id, 0, [
        'menu-item-title'     => $label,
        'menu-item-object'    => 'page',
        'menu-item-object-id' => $page_id,
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish',
        'menu-item-position'  => $position++,
    ]);
}

// Legal menu
$legal_menu_name = 'Rechtliches Menu';
$legal_menu_exists = wp_get_nav_menu_object($legal_menu_name);
if ($legal_menu_exists) {
    $legal_menu_id = $legal_menu_exists->term_id;
    echo "  Menu '$legal_menu_name' already exists (ID: $legal_menu_id)\n";
} else {
    $legal_menu_id = wp_create_nav_menu($legal_menu_name);
    echo "  Created menu '$legal_menu_name' (ID: $legal_menu_id)\n";
}

$legal_items = [
    'Impressum'   => $page_impressum,
    'Datenschutz' => $page_datenschutz,
];

$position = 1;
foreach ($legal_items as $label => $page_id) {
    wp_update_nav_menu_item($legal_menu_id, 0, [
        'menu-item-title'     => $label,
        'menu-item-object'    => 'page',
        'menu-item-object-id' => $page_id,
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish',
        'menu-item-position'  => $position++,
    ]);
}

// Assign menus to theme locations
$locations = get_theme_mod('nav_menu_locations', []);
$locations['primary'] = $primary_menu_id;
$locations['footer']  = $footer_menu_id;
$locations['legal']   = $legal_menu_id;
set_theme_mod('nav_menu_locations', $locations);
echo "  Assigned menus to theme locations (primary, footer, legal)\n\n";

// ─────────────────────────────────────────────────────────────
// Section 4: ACF Theme Options
// ─────────────────────────────────────────────────────────────

echo "--- Setting ACF Theme Options ---\n";

// Header options
update_field('header_sticky', 1, 'option');
update_field('header_cta_primary_text', 'Angebote', 'option');
update_field('header_cta_primary_url', $page_angebote, 'option');
update_field('header_cta_secondary_text', 'Termin buchen', 'option');
update_field('header_cta_secondary_url', $page_termin, 'option');
update_field('header_background_color', 'white', 'option');
echo "  Set header options (sticky, CTAs, background)\n";

// Footer options
update_field('footer_company', 'Toni Janis Garten- und Landschaftsbau', 'option');
update_field('footer_address', "Düsternort Str. 104\n27755 Delmenhorst", 'option');
update_field('footer_phone', '0176 343 26549', 'option');
update_field('footer_phone2', '0176 878 29995', 'option');
update_field('footer_email', 'toni-janis@hotmail.com', 'option');
update_field('footer_whatsapp', '4917634326549', 'option');
update_field('footer_copyright_text', '© {year} Toni Janis Garten- und Landschaftsbau. Alle Rechte vorbehalten.', 'option');
update_field('footer_show_whatsapp_button', 1, 'option');
echo "  Set footer options (company, address, phone, email, whatsapp, copyright)\n\n";

// ─────────────────────────────────────────────────────────────
// Section 5: Taxonomy terms
// ─────────────────────────────────────────────────────────────

echo "--- Creating Taxonomy Terms ---\n";

$term_gartengestaltung = seed_term('Gartengestaltung', 'toja_projekt_kategorie');
$term_pflasterarbeiten = seed_term('Pflasterarbeiten', 'toja_projekt_kategorie');
$term_rollrasen        = seed_term('Rollrasen', 'toja_projekt_kategorie');
$term_zaunbau          = seed_term('Zaunbau', 'toja_projekt_kategorie');
$term_terrassen        = seed_term('Terrassen', 'toja_projekt_kategorie');
echo "\n";

// ─────────────────────────────────────────────────────────────
// Section 6: CPT entries
// ─────────────────────────────────────────────────────────────

// --- 6a: Projekte ---
echo "--- Creating Projekte ---\n";

$projekt_1 = seed_cpt('toja_projekt', 'Moderne Gartenverwandlung Delmenhorst',
    'Komplette Neugestaltung eines 450qm Gartens mit Terrasse, Hochbeeten und automatischer Bewässerung.');
wp_set_object_terms($projekt_1, [$term_gartengestaltung], 'toja_projekt_kategorie');
update_field('projekt_standort', 'Delmenhorst', $projekt_1);
update_field('projekt_flaeche', '450 m²', $projekt_1);
update_field('projekt_dauer', '3 Wochen', $projekt_1);
update_field('projekt_badge', 'Abgeschlossen 2024', $projekt_1);
update_field('projekt_tags', [
    ['tag_name' => 'Neu'],
    ['tag_name' => 'Premium'],
    ['tag_name' => 'Bewässerung'],
], $projekt_1);

$projekt_2 = seed_cpt('toja_projekt', 'Einfahrt & Terrasse Bremen',
    'Neuverlegung der Einfahrt und Terrasse mit hochwertigem Naturstein und LED-Beleuchtung.');
wp_set_object_terms($projekt_2, [$term_pflasterarbeiten], 'toja_projekt_kategorie');
update_field('projekt_standort', 'Bremen', $projekt_2);
update_field('projekt_flaeche', '180 m²', $projekt_2);
update_field('projekt_dauer', '2 Wochen', $projekt_2);
update_field('projekt_badge', 'Abgeschlossen 2024', $projekt_2);
update_field('projekt_tags', [
    ['tag_name' => 'Naturstein'],
    ['tag_name' => 'Beleuchtung'],
], $projekt_2);

$projekt_3 = seed_cpt('toja_projekt', 'Perfekter Rasen Ganderkesee',
    'Verlegung von Premium-Rollrasen mit automatischer Sprinkleranlage für ganzjährig grünen Rasen.');
wp_set_object_terms($projekt_3, [$term_rollrasen], 'toja_projekt_kategorie');
update_field('projekt_standort', 'Ganderkesee', $projekt_3);
update_field('projekt_flaeche', '320 m²', $projekt_3);
update_field('projekt_dauer', '1 Woche', $projekt_3);
update_field('projekt_badge', 'Abgeschlossen 2024', $projekt_3);
update_field('projekt_tags', [
    ['tag_name' => 'Premium'],
    ['tag_name' => 'Sprinkler'],
], $projekt_3);

$projekt_4 = seed_cpt('toja_projekt', 'Moderner Sichtschutz Oldenburg',
    'Installation eines modernen Holz-Metall-Zauns mit integrierter Beleuchtung und Pflanzkästen.');
wp_set_object_terms($projekt_4, [$term_zaunbau], 'toja_projekt_kategorie');
update_field('projekt_standort', 'Oldenburg', $projekt_4);
update_field('projekt_flaeche', '45 Meter', $projekt_4);
update_field('projekt_dauer', '1 Woche', $projekt_4);
update_field('projekt_badge', 'Abgeschlossen 2023', $projekt_4);
update_field('projekt_tags', [
    ['tag_name' => 'Modern'],
    ['tag_name' => 'Holz-Metall'],
], $projekt_4);

$projekt_5 = seed_cpt('toja_projekt', 'Luxus-Holzterrasse Bremen',
    'Premium-Holzterrasse aus Bangkirai mit Unterkonstruktion, Drainage und Outdoor-Küche.');
wp_set_object_terms($projekt_5, [$term_terrassen], 'toja_projekt_kategorie');
update_field('projekt_standort', 'Bremen', $projekt_5);
update_field('projekt_flaeche', '85 m²', $projekt_5);
update_field('projekt_dauer', '2 Wochen', $projekt_5);
update_field('projekt_badge', 'Abgeschlossen 2023', $projekt_5);
update_field('projekt_tags', [
    ['tag_name' => 'Bangkirai'],
    ['tag_name' => 'Outdoor-Küche'],
], $projekt_5);

$projekt_6 = seed_cpt('toja_projekt', 'Vorgarten-Modernisierung Delmenhorst',
    'Pflegeleichter Vorgarten mit Zierkies, Hochbeeten und moderner Bepflanzung.');
wp_set_object_terms($projekt_6, [$term_gartengestaltung], 'toja_projekt_kategorie');
update_field('projekt_standort', 'Delmenhorst', $projekt_6);
update_field('projekt_flaeche', '60 m²', $projekt_6);
update_field('projekt_dauer', '1 Woche', $projekt_6);
update_field('projekt_badge', 'Abgeschlossen 2023', $projekt_6);
update_field('projekt_tags', [
    ['tag_name' => 'Pflegeleicht'],
    ['tag_name' => 'Modern'],
], $projekt_6);

echo "\n";

// --- 6b: Testimonials ---
echo "--- Creating Testimonials ---\n";

$testimonial_1 = seed_cpt('toja_testimonial', 'Bewertung - Maria K.');
update_field('testimonial_bewertung', 5, $testimonial_1);
update_field('testimonial_text', 'Herr Janis hat unseren Garten komplett neu gestaltet. Das Ergebnis übertrifft alle Erwartungen. Sehr professionell und zuverlässig!', $testimonial_1);
update_field('testimonial_name', 'Maria K.', $testimonial_1);
update_field('testimonial_ort', 'Delmenhorst', $testimonial_1);
update_field('testimonial_initialen', 'MK', $testimonial_1);

$testimonial_2 = seed_cpt('toja_testimonial', 'Bewertung - Thomas S.');
update_field('testimonial_bewertung', 5, $testimonial_2);
update_field('testimonial_text', 'Pünktlich, sauber und super Qualität. Der neue Rollrasen ist einfach perfekt. Kann ich nur weiterempfehlen!', $testimonial_2);
update_field('testimonial_name', 'Thomas S.', $testimonial_2);
update_field('testimonial_ort', 'Bremen', $testimonial_2);
update_field('testimonial_initialen', 'TS', $testimonial_2);

$testimonial_3 = seed_cpt('toja_testimonial', 'Bewertung - Andrea H.');
update_field('testimonial_bewertung', 5, $testimonial_3);
update_field('testimonial_text', 'Seit Jahren betreut Toni Janis unseren Garten im Abo. Immer zuverlässig und die Pflege ist erstklassig. Vielen Dank!', $testimonial_3);
update_field('testimonial_name', 'Andrea H.', $testimonial_3);
update_field('testimonial_ort', 'Ganderkesee', $testimonial_3);
update_field('testimonial_initialen', 'AH', $testimonial_3);

$testimonial_4 = seed_cpt('toja_testimonial', 'Bewertung - Jürgen M.');
update_field('testimonial_bewertung', 5, $testimonial_4);
update_field('testimonial_text', 'Die Pflasterarbeiten wurden perfekt ausgeführt. Tolle Beratung und faire Preise. Absolut empfehlenswert!', $testimonial_4);
update_field('testimonial_name', 'Jürgen M.', $testimonial_4);
update_field('testimonial_ort', 'Oldenburg', $testimonial_4);
update_field('testimonial_initialen', 'JM', $testimonial_4);

$testimonial_5 = seed_cpt('toja_testimonial', 'Bewertung - Sandra K.');
update_field('testimonial_bewertung', 5, $testimonial_5);
update_field('testimonial_text', 'Schnelle Entsorgung unserer alten Gartenmöbel. Unkompliziert und zum fairen Preis. Gerne wieder!', $testimonial_5);
update_field('testimonial_name', 'Sandra K.', $testimonial_5);
update_field('testimonial_ort', 'Delmenhorst', $testimonial_5);
update_field('testimonial_initialen', 'SK', $testimonial_5);

$testimonial_6 = seed_cpt('toja_testimonial', 'Bewertung - Peter W.');
update_field('testimonial_bewertung', 5, $testimonial_6);
update_field('testimonial_text', 'Professionelle Arbeit von A bis Z. Der neue Zaun ist wunderschön und absolut stabil. Danke!', $testimonial_6);
update_field('testimonial_name', 'Peter W.', $testimonial_6);
update_field('testimonial_ort', 'Bremen', $testimonial_6);
update_field('testimonial_initialen', 'PW', $testimonial_6);

echo "\n";

// --- 6c: FAQs ---
echo "--- Creating FAQs ---\n";

$faq_1 = seed_cpt('toja_faq', 'Was kostet ein kompletter Garten?',
    "Die Kosten für eine komplette Gartengestaltung hängen von vielen Faktoren ab. Grundsätzlich können Sie mit folgenden Richtwerten rechnen:\n\n- Einfache Gartengestaltung: 50-80 Euro pro m²\n- Mittlere Ausstattung: 80-150 Euro pro m²\n- Premium-Gestaltung: 150-300 Euro pro m²\n\nWir erstellen Ihnen gerne ein individuelles, kostenloses Angebot nach einer Besichtigung vor Ort.");
update_field('faq_reihenfolge', 1, $faq_1);

$faq_2 = seed_cpt('toja_faq', 'Wie lange dauert die Umsetzung eines Gartenprojekts?',
    "Die Dauer hängt vom Umfang des Projekts ab:\n\n- Rollrasenverlegung: 1-2 Tage\n- Terrassenbau: 3-7 Tage\n- Komplette Gartengestaltung: 1-4 Wochen\n- Pflasterarbeiten: 3-10 Tage\n\nBei der Planung berücksichtigen wir Ihre Wünsche und erstellen einen realistischen Zeitplan.");
update_field('faq_reihenfolge', 2, $faq_2);

$faq_3 = seed_cpt('toja_faq', 'Bieten Sie eine Garantie auf Ihre Arbeiten?',
    "Ja! Wir bieten auf alle unsere Arbeiten eine umfassende Garantie:\n\n- 2 Jahre Garantie auf Pflasterarbeiten\n- 1 Jahr Garantie auf Rollrasen\n- 2 Jahre auf Zaunbau und Holzkonstruktionen\n- Gesetzliche Gewährleistung auf alle Leistungen\n\nZusätzlich sind alle unsere Arbeiten vollständig versichert.");
update_field('faq_reihenfolge', 3, $faq_3);

$faq_4 = seed_cpt('toja_faq', 'Welche Zahlungsmöglichkeiten gibt es?',
    "Wir bieten flexible Zahlungsmöglichkeiten:\n\n- Überweisung (mit Zahlungsziel)\n- EC-Kartenzahlung\n- Ratenzahlung bei größeren Projekten möglich\n- Anzahlung nur bei größeren Materialbeschaffungen\n\nBei jedem Projekt erstellen wir eine transparente Abrechnung.");
update_field('faq_reihenfolge', 4, $faq_4);

$faq_5 = seed_cpt('toja_faq', 'Wie schnell bekomme ich einen Termin?',
    "Wir bemühen uns um schnelle Termine:\n\n- Erstberatung: meist innerhalb von 2-5 Werktagen\n- Kleine Projekte: oft Start binnen 1-2 Wochen möglich\n- Größere Projekte: Abstimmung nach Verfügbarkeit\n- Notfälle: schnellstmögliche Reaktion\n\nKontaktieren Sie uns einfach für eine unverbindliche Terminabsprache.");
update_field('faq_reihenfolge', 5, $faq_5);

$faq_6 = seed_cpt('toja_faq', 'Übernehmen Sie auch die Entsorgung von Altmaterialien?',
    "Ja, selbstverständlich! Wir bieten einen kompletten Entsorgungsservice:\n\n- Abtransport von alten Pflanzen und Erde\n- Entsorgung von alten Pflastersteinen und Beton\n- Abholung alter Gartenmöbel und -geräte\n- Fachgerechte Entsorgung aller Materialien\n\nDie Kosten werden transparent im Angebot aufgeführt.");
update_field('faq_reihenfolge', 6, $faq_6);

echo "\n";

// --- 6d: Stellenangebote ---
echo "--- Creating Stellenangebote ---\n";

$stelle_1 = seed_cpt('toja_stellenangebot', 'Gärtner / Landschaftsgärtner (m/w/d)',
    'Wir suchen motivierte Mitarbeiter, die mit Leidenschaft Gärten gestalten und pflegen möchten.');
update_field('job_typ', 'Vollzeit', $stelle_1);
update_field('job_verfuegbarkeit', 'Ab sofort', $stelle_1);
update_field('job_aufgaben', [
    ['aufgabe' => 'Gartengestaltung und Neuanlagen'],
    ['aufgabe' => 'Pflasterarbeiten und Wegebau'],
    ['aufgabe' => 'Rollrasen verlegen'],
    ['aufgabe' => 'Gartenpflege und Instandhaltung'],
    ['aufgabe' => 'Kundenberatung vor Ort'],
], $stelle_1);
update_field('job_anforderungen', [
    ['anforderung' => 'Abgeschlossene Ausbildung als Gärtner oder Landschaftsgärtner'],
    ['anforderung' => 'Berufserfahrung wünschenswert'],
    ['anforderung' => 'Führerschein Klasse B'],
    ['anforderung' => 'Teamfähigkeit und Zuverlässigkeit'],
    ['anforderung' => 'Freude am Arbeiten im Freien'],
], $stelle_1);
update_field('job_angebot', [
    ['angebot_item' => 'Unbefristete Festanstellung'],
    ['angebot_item' => 'Leistungsgerechte Bezahlung'],
    ['angebot_item' => 'Modernes Arbeitsgerät'],
    ['angebot_item' => 'Freundliches Arbeitsklima'],
    ['angebot_item' => 'Vielseitige Projekte'],
], $stelle_1);
update_field('job_email', '', $stelle_1);

echo "\n";

// --- 6e: Blog posts ---
echo "--- Creating Blog Posts ---\n";

// Create category Gartentipps
$cat_gartentipps = term_exists('Gartentipps', 'category');
if (!$cat_gartentipps) {
    $cat_gartentipps = wp_insert_term('Gartentipps', 'category');
    echo "  Created category 'Gartentipps' (ID: {$cat_gartentipps['term_id']})\n";
} else {
    echo "  Category 'Gartentipps' already exists (ID: {$cat_gartentipps['term_id']})\n";
}
$cat_gartentipps_id = (int) $cat_gartentipps['term_id'];

$blog_1_content = "Bereiten Sie Ihren Garten optimal auf den Winter vor. Mit diesen Profi-Tipps überstehen Ihre Pflanzen die kalte Jahreszeit.\n\nDer Winter steht vor der Tür und es ist Zeit, Ihren Garten auf die kalte Jahreszeit vorzubereiten. Mit unserer Checkliste vergessen Sie nichts:\n\n1. Empfindliche Pflanzen schützen\n2. Rasen ein letztes Mal mähen\n3. Laub entfernen\n4. Wasserleitungen entleeren\n5. Gartenmöbel einlagern";

$blog_1 = seed_cpt('post', 'Garten winterfest machen - Die ultimative Checkliste', $blog_1_content, [
    'post_date' => '2024-11-15 10:00:00',
]);
wp_set_object_terms($blog_1, [$cat_gartentipps_id], 'category');

$blog_2_content = "Vor- und Nachteile beider Methoden im direkten Vergleich. So treffen Sie die richtige Entscheidung für Ihren Garten.\n\nBeim Thema Rasen stehen Gartenbesitzer oft vor der Frage: Rollrasen oder Aussaat? Beide Methoden haben ihre Berechtigung.\n\nRollrasen:\n- Sofort nutzbar\n- Gleichmäßiges Ergebnis\n- Höhere Anfangsinvestition\n\nAussaat:\n- Günstiger\n- Mehr Sortenwahl\n- Längere Wartezeit";

$blog_2 = seed_cpt('post', 'Rollrasen vs. Aussaat - Was ist die bessere Wahl?', $blog_2_content, [
    'post_date' => '2024-10-28 10:00:00',
]);
wp_set_object_terms($blog_2, [$cat_gartentipps_id], 'category');

$blog_3_content = "Transparente Übersicht über typische Kosten und wie Sie Ihr Budget optimal einsetzen.\n\nEine Gartenumgestaltung ist eine Investition in Ihr Zuhause. Hier eine Übersicht typischer Kosten:\n\n- Rasen (Rollrasen): 8-15 €/m²\n- Pflasterarbeiten: 40-120 €/m²\n- Zaunbau: 80-200 €/lfm\n- Bepflanzung: 20-50 €/m²\n\nWir beraten Sie gerne kostenlos zu Ihrem Budget.";

$blog_3 = seed_cpt('post', 'Was kostet eine Gartenumgestaltung? Budgetplanung leicht gemacht', $blog_3_content, [
    'post_date' => '2024-10-10 10:00:00',
]);
wp_set_object_terms($blog_3, [$cat_gartentipps_id], 'category');

echo "\n";

// ─────────────────────────────────────────────────────────────
// Section 7: Front Page Flexible Content (19 blocks)
// ─────────────────────────────────────────────────────────────

echo "--- Setting Front Page Flexible Content (19 blocks) ---\n";

$layouts = [

    // Block 0: hero
    [
        'acf_fc_layout'      => 'hero',
        'hero_variante'      => 'standard',
        'hero_badge'         => 'Ihr Gartenspezialist in Delmenhorst',
        'hero_titel'         => 'Professioneller Garten- und Landschaftsbau',
        'hero_highlight'     => 'Ihr Traumgarten wird Wirklichkeit',
        'hero_text'          => 'Mit über 10 Jahren Erfahrung verwandeln wir Ihren Außenbereich in eine grüne Oase. Von der Planung bis zur Pflege - wir sind Ihr zuverlässiger Partner in Delmenhorst und Umgebung.',
        'hero_button_primary' => [
            'title'  => 'Kostenlose Beratung',
            'url'    => '#contact',
            'target' => '',
        ],
        'hero_button_secondary' => [
            'title'  => 'Unsere Leistungen',
            'url'    => '#services',
            'target' => '',
        ],
        'background_variant' => 'white',
        'block_spacing'      => 'none',
        'block_id'           => 'hero',
    ],

    // Block 1: services
    [
        'acf_fc_layout'    => 'services',
        'services_label'   => 'Unsere Leistungen',
        'services_heading' => 'Kompletter Service für Ihren Garten',
        'services_text'    => 'Von der ersten Idee bis zur dauerhaften Pflege – wir bieten alle Leistungen aus einer Hand.',
        'services_liste'   => [
            [
                'service_icon'         => '🌳',
                'service_titel'        => 'Gartengestaltung',
                'service_beschreibung' => 'Kreative Planung und professionelle Umsetzung Ihrer Gartenträume. Wir gestalten individuelle Grünanlagen.',
                'service_link'         => '',
            ],
            [
                'service_icon'         => '🌿',
                'service_titel'        => 'Gartenpflege',
                'service_beschreibung' => 'Regelmäßige Pflege und Instandhaltung Ihres Gartens. Auch als praktisches Abo verfügbar.',
                'service_link'         => '',
            ],
            [
                'service_icon'         => '🧱',
                'service_titel'        => 'Pflasterarbeiten',
                'service_beschreibung' => 'Terrassen, Wege und Einfahrten – professionell gepflastert mit hochwertigen Materialien.',
                'service_link'         => '',
            ],
            [
                'service_icon'         => '🌱',
                'service_titel'        => 'Rollrasen verlegen',
                'service_beschreibung' => 'Schnell zum perfekten Rasen. Wir verlegen Rollrasen fachgerecht für ein sofort grünes Ergebnis.',
                'service_link'         => '',
            ],
            [
                'service_icon'         => '🪵',
                'service_titel'        => 'Zaunbau & Sichtschutz',
                'service_beschreibung' => 'Hochwertige Zäune und Sichtschutzelemente für mehr Privatsphäre in Ihrem Garten.',
                'service_link'         => '',
            ],
            [
                'service_icon'         => '❄️',
                'service_titel'        => 'Winterdienst',
                'service_beschreibung' => 'Zuverlässiger Winterdienst für sichere Wege und Einfahrten in der kalten Jahreszeit.',
                'service_link'         => '',
            ],
            [
                'service_icon'         => '♻️',
                'service_titel'        => 'Entsorgungsservice',
                'service_beschreibung' => 'Professionelle Entsorgung aller Art: Sperrmüll, Möbel, Elektrogeräte, Bau- und Gartenabfälle. Fachgerecht und umweltfreundlich.',
                'service_link'         => '',
            ],
        ],
        'background_variant' => 'cream',
        'block_spacing'      => 'medium',
        'block_id'           => 'services',
    ],

    // Block 2: about
    [
        'acf_fc_layout'        => 'about',
        'about_label'          => 'Über uns',
        'about_heading'        => 'Ihr Partner für professionelle Gartengestaltung in Delmenhorst',
        'about_texte'          => '<p>Toni Janis Garten- und Landschaftsbau steht für Qualität, Zuverlässigkeit und Leidenschaft. Mit über 10 Jahren Erfahrung verwandeln wir Ihre Gartenträume in Wirklichkeit.</p><p>Wir bieten alles rund ums Haus – von der kompletten Neugestaltung bis zur regelmäßigen Pflege. Dabei legen wir besonderen Wert auf individuelle Beratung und hochwertige Ausführung.</p>',
        'about_erfahrung_zahl' => '10+',
        'about_erfahrung_text' => 'Jahre Erfahrung',
        'about_features'       => [
            ['feature_icon' => '✓', 'feature_text' => 'Kostenlose Beratung'],
            ['feature_icon' => '✓', 'feature_text' => 'Faire Preise'],
            ['feature_icon' => '✓', 'feature_text' => 'Termingerecht'],
            ['feature_icon' => '✓', 'feature_text' => 'Qualitätsarbeit'],
        ],
        'about_button' => [
            'title'  => 'Mehr erfahren',
            'url'    => '#contact',
            'target' => '',
        ],
        'background_variant' => 'white',
        'block_spacing'      => 'medium',
        'block_id'           => 'about',
    ],

    // Block 3: passion
    [
        'acf_fc_layout'       => 'passion',
        'passion_label'       => 'Meine Leidenschaft',
        'passion_heading'     => 'Gartenbau ist nicht nur mein Beruf, sondern meine Berufung',
        'passion_zitat'       => 'Jeden Tag schaffe ich grüne Oasen, die Menschen glücklich machen. Das ist meine größte Motivation.',
        'passion_texte'       => '<p>Seit über einem Jahrzehnt verwandle ich mit Herzblut verwilderte Flächen in gepflegte Traumgärten. Jedes Projekt ist für mich eine neue Herausforderung, bei der ich mein gesamtes Fachwissen und meine Kreativität einbringe.</p><p>Die Digitalisierung meines Handwerks ermöglicht es mir, noch professioneller zu arbeiten: Von der Online-Terminbuchung über digitale Angebotserstellung bis hin zur transparenten Projektkommunikation – ich nutze moderne Technologie, um Ihnen den bestmöglichen Service zu bieten.</p>',
        'passion_statistiken' => [
            ['stat_zahl' => '500+', 'stat_label' => 'Abgeschlossene Projekte'],
            ['stat_zahl' => '100%', 'stat_label' => 'Kundenzufriedenheit'],
            ['stat_zahl' => '10+',  'stat_label' => 'Jahre Erfahrung'],
        ],
        'background_variant' => 'green',
        'block_spacing'      => 'medium',
        'block_id'           => 'passion',
    ],

    // Block 4: process
    [
        'acf_fc_layout'    => 'process',
        'process_label'    => 'Unser Arbeitsprozess',
        'process_heading'  => 'So arbeiten wir – Schritt für Schritt',
        'process_text'     => 'Transparenz und Professionalität in jedem Projekt. Von der ersten Idee bis zur Fertigstellung.',
        'process_schritte' => [
            [
                'schritt_icon'         => '📞',
                'schritt_titel'        => 'Erstberatung',
                'schritt_beschreibung' => 'Kostenlose Beratung vor Ort. Wir besprechen Ihre Wünsche und Vorstellungen für Ihren Garten.',
            ],
            [
                'schritt_icon'         => '📋',
                'schritt_titel'        => 'Planung & Angebot',
                'schritt_beschreibung' => 'Detaillierte Planung und transparentes Angebot. Sie erhalten einen klaren Kostenvoranschlag.',
            ],
            [
                'schritt_icon'         => '🚜',
                'schritt_titel'        => 'Umsetzung',
                'schritt_beschreibung' => 'Professionelle Durchführung mit modernster Ausstattung. Wir halten Sie stets auf dem Laufenden.',
            ],
            [
                'schritt_icon'         => '✅',
                'schritt_titel'        => 'Übergabe & Service',
                'schritt_beschreibung' => 'Finale Abnahme und Pflegehinweise. Auf Wunsch übernehmen wir auch die regelmäßige Pflege.',
            ],
        ],
        'background_variant' => 'cream',
        'block_spacing'      => 'medium',
        'block_id'           => 'process',
    ],

    // Block 5: quality
    [
        'acf_fc_layout'  => 'quality',
        'quality_label'  => 'Qualität & Expertise',
        'quality_heading' => 'Zertifizierte Qualität, auf die Sie sich verlassen können',
        'quality_text'   => 'Ständige Weiterbildung und höchste Standards in allen Bereichen.',
        'quality_items'  => [
            [
                'quality_icon'         => '🎓',
                'quality_titel'        => 'Meisterqualifikation',
                'quality_beschreibung' => 'Zertifizierter Fachbetrieb für Garten- und Landschaftsbau mit Meisterbrief.',
            ],
            [
                'quality_icon'         => '🌿',
                'quality_titel'        => 'Umweltbewusstsein',
                'quality_beschreibung' => 'Nachhaltige Arbeitsweise mit umweltfreundlichen Materialien und Methoden.',
            ],
            [
                'quality_icon'         => '🛡️',
                'quality_titel'        => 'Versicherungsschutz',
                'quality_beschreibung' => 'Vollständig versichert für Ihre Sicherheit und unsere professionelle Arbeit.',
            ],
            [
                'quality_icon'         => '⚡',
                'quality_titel'        => 'Moderne Technik',
                'quality_beschreibung' => 'Digitale Projektplanung und -verwaltung für maximale Effizienz.',
            ],
        ],
        'background_variant' => 'white',
        'block_spacing'      => 'medium',
        'block_id'           => 'quality',
    ],

    // Block 6: equipment
    [
        'acf_fc_layout'     => 'equipment',
        'equipment_label'   => 'Professionelle Ausrüstung',
        'equipment_heading' => 'Hochwertige Geräte für perfekte Ergebnisse',
        'equipment_text'    => 'Mit modernster Technik und professionellem Equipment arbeiten wir effizient und präzise.',
        'equipment_items'   => [
            [
                'equipment_icon'         => '🚜',
                'equipment_titel'        => 'Kompaktlader & Bagger',
                'equipment_beschreibung' => 'Für Erdarbeiten, Fundamentaushub und große Umgestaltungen setzen wir moderne Kompaktlader ein.',
                'equipment_tags'         => [
                    ['tag_name' => 'Leistungsstark'],
                    ['tag_name' => 'Präzise'],
                    ['tag_name' => 'Effizient'],
                ],
            ],
            [
                'equipment_icon'         => '🔨',
                'equipment_titel'        => 'Rüttelplatten & Verdichter',
                'equipment_beschreibung' => 'Professionelle Bodenverdichtung für stabile Fundamente bei Pflasterarbeiten.',
                'equipment_tags'         => [
                    ['tag_name' => 'Verdichtung'],
                    ['tag_name' => 'Stabilität'],
                ],
            ],
            [
                'equipment_icon'         => '✂️',
                'equipment_titel'        => 'Profi-Gartengeräte',
                'equipment_beschreibung' => 'Hochwertige Heckenscheren, Rasenmäher und Freischneider für perfekte Schnittergebnisse.',
                'equipment_tags'         => [
                    ['tag_name' => 'Präzision'],
                    ['tag_name' => 'Sauber'],
                    ['tag_name' => 'Schnell'],
                ],
            ],
        ],
        'background_variant' => 'cream',
        'block_spacing'      => 'medium',
        'block_id'           => 'equipment',
    ],

    // Block 7: blog-tips
    [
        'acf_fc_layout'      => 'blog-tips',
        'blog_label'         => 'Gartentipps & Wissen',
        'blog_heading'       => 'Profitipps vom Experten',
        'blog_text'          => 'Wertvolles Fachwissen für Ihren perfekten Garten – direkt vom Profi.',
        'blog_anzahl'        => 3,
        'background_variant' => 'white',
        'block_spacing'      => 'medium',
        'block_id'           => 'blog-tips',
    ],

    // Block 8: projects
    [
        'acf_fc_layout'      => 'projects',
        'projects_label'     => 'Unsere Projekte',
        'projects_heading'   => 'Erfolgreiche Projekte im Detail',
        'projects_text'      => 'Entdecken Sie unsere abgeschlossenen Projekte mit allen Details und Ergebnissen.',
        'projects_anzahl'    => 6,
        'projects_filter'    => 1,
        'background_variant' => 'cream',
        'block_spacing'      => 'medium',
        'block_id'           => 'projekte',
    ],

    // Block 9: faq
    [
        'acf_fc_layout'      => 'faq',
        'faq_label'          => 'Häufige Fragen',
        'faq_heading'        => 'Antworten auf Ihre Fragen',
        'faq_text'           => 'Hier finden Sie Antworten auf die am häufigsten gestellten Fragen.',
        'faq_quelle'         => 'cpt',
        'faq_anzahl'         => 6,
        'background_variant' => 'white',
        'block_spacing'      => 'medium',
        'block_id'           => 'faq',
    ],

    // Block 10: entsorgen
    [
        'acf_fc_layout'      => 'entsorgen',
        'entsorgen_label'    => 'Entsorgungsservice',
        'entsorgen_heading'  => 'Professionelle Entsorgung aller Art',
        'entsorgen_text'     => 'Von Haushaltsauflösungen bis Baustellenabfälle - wir entsorgen fachgerecht und zuverlässig. Senden Sie uns Fotos für ein kostenloses Angebot.',
        'entsorgen_services' => [
            ['es_text' => 'Sperrmüll & Haushaltsauflösungen'],
            ['es_text' => 'Möbel & Einrichtungsgegenstände'],
            ['es_text' => 'Elektrogeräte & Elektronik'],
            ['es_text' => 'Bau- & Renovierungsabfälle'],
            ['es_text' => 'Gartenabfälle & Grünschnitt'],
            ['es_text' => 'Büroausstattung & Gewerbeabfall'],
            ['es_text' => 'Altholz & Baumaterialien'],
            ['es_text' => 'Schrott & Metallabfälle'],
        ],
        'entsorgen_vorteile' => [
            [
                'vorteil_icon'  => '📸',
                'vorteil_titel' => 'Fotos hochladen',
                'vorteil_text'  => '3-5 qualitativ hochwertige Bilder',
            ],
            [
                'vorteil_icon'  => '💶',
                'vorteil_titel' => 'Angebot erhalten',
                'vorteil_text'  => 'Innerhalb von 24 Stunden',
            ],
            [
                'vorteil_icon'  => '🚚',
                'vorteil_titel' => 'Abholen & Entsorgen',
                'vorteil_text'  => 'Fachgerecht & umweltfreundlich',
            ],
        ],
        'background_variant' => 'cream',
        'block_spacing'      => 'medium',
        'block_id'           => 'entsorgen',
    ],

    // Block 11: gallery
    [
        'acf_fc_layout'      => 'gallery',
        'gallery_label'      => 'Unsere Arbeit',
        'gallery_heading'    => 'Projekte die begeistern',
        'gallery_text'       => 'Einblicke in unsere erfolgreich umgesetzten Gartenprojekte.',
        'gallery_bilder'     => [],
        'background_variant' => 'white',
        'block_spacing'      => 'medium',
        'block_id'           => 'gallery',
    ],

    // Block 12: before-after
    [
        'acf_fc_layout'      => 'before-after',
        'ba_label'           => 'Vorher / Nachher',
        'ba_heading'         => 'Beeindruckende Verwandlungen',
        'ba_text'            => 'Sehen Sie selbst, wie wir Gärten in echte Wohlfühloasen verwandeln.',
        'ba_vergleiche'      => [
            [
                'ba_titel'        => 'Komplette Gartenumgestaltung',
                'ba_beschreibung' => 'Verwandlung eines verwilderten Gartens in eine moderne Wohlfühloase mit Terrasse, Rasenfläche und mediterraner Bepflanzung.',
                'ba_tags'         => [
                    ['ba_tag' => 'Gartengestaltung'],
                    ['ba_tag' => 'Rollrasen'],
                    ['ba_tag' => 'Pflasterung'],
                ],
            ],
            [
                'ba_titel'        => 'Terrassen-Neuanlage',
                'ba_beschreibung' => 'Aus einem alten Betonplatz wurde eine elegante Naturstein-Terrasse mit integrierter Beleuchtung und Hochbeeten.',
                'ba_tags'         => [
                    ['ba_tag' => 'Pflasterarbeiten'],
                    ['ba_tag' => 'Beleuchtung'],
                ],
            ],
            [
                'ba_titel'        => 'Vorgarten-Modernisierung',
                'ba_beschreibung' => 'Neugestaltung eines Vorgartens mit pflegeleichter Bepflanzung, Zierkies und modernem Wegesystem.',
                'ba_tags'         => [
                    ['ba_tag' => 'Vorgarten'],
                    ['ba_tag' => 'Pflegeleicht'],
                    ['ba_tag' => 'Modern'],
                ],
            ],
        ],
        'background_variant' => 'cream',
        'block_spacing'      => 'medium',
        'block_id'           => 'before-after',
    ],

    // Block 13: video
    [
        'acf_fc_layout'      => 'video',
        'video_label'        => 'Video',
        'video_heading'      => 'Sehen Sie unsere Arbeit in Aktion',
        'video_text'         => 'Erleben Sie, wie wir Gärten in Delmenhorst transformieren - von der ersten Planung bis zum fertigen Traumgarten.',
        'video_url'          => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'video_features'     => [
            [
                'feature_icon'  => '⭐',
                'feature_titel' => 'Professionelle Planung',
                'feature_text'  => 'Durchdachte Konzepte für jeden Garten',
            ],
            [
                'feature_icon'  => '⭐',
                'feature_titel' => 'Hochwertige Materialien',
                'feature_text'  => 'Nur die besten Materialien für Ihr Projekt',
            ],
            [
                'feature_icon'  => '⭐',
                'feature_titel' => 'Termingerechte Ausführung',
                'feature_text'  => 'Zuverlässig und pünktlich',
            ],
        ],
        'background_variant' => 'white',
        'block_spacing'      => 'medium',
        'block_id'           => 'video',
    ],

    // Block 14: testimonials
    [
        'acf_fc_layout'        => 'testimonials',
        'testimonials_label'   => 'Kundenstimmen',
        'testimonials_heading' => 'Was unsere Kunden sagen',
        'testimonials_text'    => 'Zufriedene Kunden sind unsere beste Referenz.',
        'testimonials_quelle'  => 'cpt',
        'testimonials_anzahl'  => 6,
        'background_variant'   => 'cream',
        'block_spacing'        => 'medium',
        'block_id'             => 'testimonials',
    ],

    // Block 15: appointment
    [
        'acf_fc_layout'       => 'appointment',
        'appointment_label'   => 'Terminbuchung',
        'appointment_heading' => 'Buchen Sie Ihren Beratungstermin in 4 Schritten',
        'appointment_text'    => 'Kostenlose Vor-Ort-Beratung - einfach und schnell online buchen',
        'appointment_typen'   => [
            [
                'typ_icon'         => '🕐',
                'typ_titel'        => 'Erstberatung',
                'typ_beschreibung' => 'Kostenlose Beratung vor Ort (60 Min.)',
            ],
            [
                'typ_icon'         => '📋',
                'typ_titel'        => 'Projektbesprechung',
                'typ_beschreibung' => 'Detaillierte Planung mit Kostenvoranschlag',
            ],
            [
                'typ_icon'         => '⚠️',
                'typ_titel'        => 'Notfall/Dringend',
                'typ_beschreibung' => 'Schnellstmögliche Terminvergabe',
            ],
        ],
        'background_variant' => 'white',
        'block_spacing'      => 'medium',
        'block_id'           => 'termin',
    ],

    // Block 16: quote
    [
        'acf_fc_layout'      => 'quote',
        'quote_label'        => 'Kostenloser Kostenvoranschlag',
        'quote_heading'      => 'Angebot in 3 einfachen Schritten',
        'quote_text'         => 'Erhalten Sie schnell und unkompliziert ein maßgeschneidertes Angebot für Ihr Gartenprojekt.',
        'quote_services'     => [
            [
                'qs_icon'         => '🌳',
                'qs_titel'        => 'Gartengestaltung',
                'qs_beschreibung' => 'Neuanlage & Umgestaltung',
            ],
            [
                'qs_icon'         => '✂️',
                'qs_titel'        => 'Gartenpflege',
                'qs_beschreibung' => 'Regelmäßige Pflege & Abo',
            ],
            [
                'qs_icon'         => '🧱',
                'qs_titel'        => 'Pflasterarbeiten',
                'qs_beschreibung' => 'Terrassen, Wege, Einfahrten',
            ],
            [
                'qs_icon'         => '🌱',
                'qs_titel'        => 'Rollrasen',
                'qs_beschreibung' => 'Verlegen & Vorbereitung',
            ],
            [
                'qs_icon'         => '🪵',
                'qs_titel'        => 'Zaunbau',
                'qs_beschreibung' => 'Zäune & Sichtschutz',
            ],
            [
                'qs_icon'         => '❄️',
                'qs_titel'        => 'Winterdienst',
                'qs_beschreibung' => 'Schneeräumung & Streuen',
            ],
        ],
        'background_variant' => 'cream',
        'block_spacing'      => 'medium',
        'block_id'           => 'angebot',
    ],

    // Block 17: karriere
    [
        'acf_fc_layout'      => 'karriere',
        'karriere_label'     => 'Karriere',
        'karriere_heading'   => 'Werde Teil unseres Teams',
        'karriere_text'      => 'Wir suchen motivierte Mitarbeiter, die mit Leidenschaft Gärten gestalten und pflegen möchten.',
        'background_variant' => 'white',
        'block_spacing'      => 'medium',
        'block_id'           => 'karriere',
    ],

    // Block 18: contact
    [
        'acf_fc_layout'           => 'contact',
        'contact_heading'         => 'Lassen Sie uns Ihren Traumgarten planen',
        'contact_text'            => 'Kontaktieren Sie uns für eine kostenlose Beratung. Wir freuen uns auf Ihr Projekt!',
        'contact_infos_anzeigen'  => 1,
        'contact_formular_anzeigen' => 1,
        'contact_services'        => [
            ['service_value' => 'gartengestaltung', 'service_label' => 'Gartengestaltung'],
            ['service_value' => 'gartenpflege',     'service_label' => 'Gartenpflege'],
            ['service_value' => 'pflasterarbeiten', 'service_label' => 'Pflasterarbeiten'],
            ['service_value' => 'rollrasen',        'service_label' => 'Rollrasen'],
            ['service_value' => 'zaunbau',          'service_label' => 'Zaunbau'],
            ['service_value' => 'winterdienst',     'service_label' => 'Winterdienst'],
            ['service_value' => 'sonstiges',        'service_label' => 'Sonstiges'],
        ],
        'background_variant' => 'cream',
        'block_spacing'      => 'medium',
        'block_id'           => 'contact',
    ],

];

// Save flexible content to front page
update_field('flexible_content', $layouts, $page_startseite);
echo "  Saved " . count($layouts) . " flexible content blocks to Startseite (ID: $page_startseite)\n\n";

// ─────────────────────────────────────────────────────────────
// Section 8: Mark seed as completed
// ─────────────────────────────────────────────────────────────

update_option('toja_seed_completed', true);
echo "=== Seed completed successfully! ===\n";
echo "Visit your site to see the demo content.\n";
echo "To re-run: wp option delete toja_seed_completed\n";
