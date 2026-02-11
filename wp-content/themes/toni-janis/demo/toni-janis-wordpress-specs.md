# 🌿 Toni Janis - WordPress Website Spezifikationen

## Übersicht

Dieses Dokument enthält alle technischen Spezifikationen für die Erstellung der WordPress-Website für **Toni Janis Garten- und Landschaftsbau**.

---

## 1. Farbpalette

### Hauptfarben

| Farbe | Hex-Code | RGB | Verwendung |
|-------|----------|-----|------------|
| **Forest Green** | `#2E5A3C` | rgb(46, 90, 60) | Primärfarbe, Header, Buttons, Haupttexte |
| **Leaf Green** | `#4A7C59` | rgb(74, 124, 89) | Sekundärfarbe, Hover-Effekte |
| **Lime Accent** | `#7CB342` | rgb(124, 179, 66) | Akzente, CTAs, Links |
| **Earth Brown** | `#5D4037` | rgb(93, 64, 55) | Fließtext, Footer |
| **Sand Beige** | `#E8E0D5` | rgb(232, 224, 213) | Hintergründe, Cards |
| **Cream** | `#FAF8F5` | rgb(250, 248, 245) | Haupthintergrund |
| **White** | `#FFFFFF` | rgb(255, 255, 255) | Cards, Formulare |
| **Charcoal** | `#2D2D2D` | rgb(45, 45, 45) | Footer, dunkle Bereiche |

### Farbverläufe (Gradients)

```css
/* Nature Gradient - für Buttons und wichtige Elemente */
background: linear-gradient(135deg, #2E5A3C 0%, #4A7C59 100%);

/* Earth Gradient - für Hintergründe */
background: linear-gradient(180deg, #E8E0D5 0%, #FAF8F5 100%);
```

### CSS Variables für WordPress

```css
:root {
    --color-primary: #2E5A3C;
    --color-secondary: #4A7C59;
    --color-accent: #7CB342;
    --color-text: #5D4037;
    --color-text-dark: #2D2D2D;
    --color-bg-light: #FAF8F5;
    --color-bg-medium: #E8E0D5;
    --color-white: #FFFFFF;
}
```

---

## 2. Typografie

### Schriftarten (Google Fonts)

| Schriftart | Verwendung | Gewichte |
|------------|------------|----------|
| **Playfair Display** | Überschriften (H1-H3) | 400, 600, 700 |
| **Source Sans 3** | Fließtext, Navigation, Buttons | 300, 400, 500, 600 |

### Google Fonts Einbindung

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
```

### Schriftgrößen

| Element | Desktop | Mobil | Schriftart |
|---------|---------|-------|------------|
| H1 | 48-64px | 32-40px | Playfair Display, 700 |
| H2 | 36-48px | 28-32px | Playfair Display, 600 |
| H3 | 24-28px | 20-24px | Playfair Display, 600 |
| Body | 16-18px | 16px | Source Sans 3, 400 |
| Navigation | 15px | 14px | Source Sans 3, 500 |
| Buttons | 16px | 16px | Source Sans 3, 600 |

---

## 3. Empfohlene WordPress Themes

### Option 1: Flavor flavor (Empfohlen)
- **Preis**: Kostenlos / Pro ab €59
- **Vorteile**: Sehr flexibel, schnell, SEO-optimiert
- **Link**: flavor flavor

### Option 2: flavor flavor
- **Preis**: Ab €89/Jahr
- **Vorteile**: Professionelle Vorlagen für Handwerker/Dienstleister
- **Link**: flavor flavor

### Option 3: flavor flavor (Starter Templates)
- **Preis**: Kostenlos / Pro ab €47
- **Vorteile**: Leichtgewichtig, schnell, viele Vorlagen
- **Link**: flavor flavor

### Option 4: flavor flavor flavor
- **Preis**: €129 einmalig
- **Vorteile**: Umfangreiche Design-Optionen
- **Link**: flavor flavor flavor

---

## 4. Empfohlene Plugins

### Essentiell

| Plugin | Zweck | Kostenlos |
|--------|-------|-----------|
| **Elementor** | Page Builder | Ja (Pro empfohlen) |
| **Contact Form 7** oder **WPForms** | Kontaktformular | Ja |
| **Yoast SEO** | Suchmaschinenoptimierung | Ja |
| **WP Rocket** oder **LiteSpeed Cache** | Performance | Nein / Ja |
| **UpdraftPlus** | Backups | Ja |
| **Complianz** | DSGVO Cookie-Banner | Ja |

### Empfohlen

| Plugin | Zweck |
|--------|-------|
| **Smush** | Bildoptimierung |
| **Google Site Kit** | Analytics & Search Console |
| **Schema Pro** | Strukturierte Daten (Local Business) |
| **MapPress** oder **Maps Widget** | Google Maps Integration |

---

## 5. Seitenstruktur

### Hauptseiten

```
├── Startseite (Home)
├── Leistungen
│   ├── Gartengestaltung
│   ├── Gartenpflege
│   ├── Pflasterarbeiten
│   ├── Rollrasen verlegen
│   ├── Zaunbau
│   └── Winterdienst
├── Über uns
├── Galerie / Projekte
├── Referenzen
├── Kontakt
├── Impressum
└── Datenschutz
```

### Navigation

**Hauptmenü:**
- Startseite
- Leistungen (Dropdown)
- Über uns
- Galerie
- Referenzen
- Kontakt (Button-Style)

**Footer-Menü:**
- Impressum
- Datenschutz
- AGB (optional)

---

## 6. Wichtige Designelemente

### Buttons

```css
/* Primary Button */
.btn-primary {
    background: linear-gradient(135deg, #2E5A3C 0%, #4A7C59 100%);
    color: #FFFFFF;
    padding: 16px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(46, 90, 60, 0.25);
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(46, 90, 60, 0.35);
}

/* Secondary Button */
.btn-secondary {
    background: #FFFFFF;
    color: #2E5A3C;
    padding: 14px 30px;
    border-radius: 50px;
    font-weight: 600;
    border: 2px solid #2E5A3C;
}

.btn-secondary:hover {
    background: #2E5A3C;
    color: #FFFFFF;
}
```

### Cards / Boxen

```css
.service-card {
    background: #FAF8F5;
    border-radius: 24px;
    padding: 40px;
    border: 1px solid rgba(46, 90, 60, 0.1);
    transition: all 0.4s ease;
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(46, 90, 60, 0.12);
}
```

### Abstände

| Element | Wert |
|---------|------|
| Section Padding | 80-120px (vertikal) |
| Container Max-Width | 1400px |
| Card Gap | 24-32px |
| Element Spacing | 16-24px |

---

## 7. Kontaktinformationen

**Für die Website zu verwenden:**

- **Firmenname**: Toni Janis Garten- und Landschaftsbau
- **Adresse**: Düsternort Str. 104, 27755 Delmenhorst
- **Telefon 1**: 0176 343 26549
- **Telefon 2**: 0176 878 29995
- **E-Mail**: toni-janis@hotmail.com
- **WhatsApp**: wa.me/4917634326549

---

## 8. SEO Empfehlungen

### Meta-Titel (Home)
```
Toni Janis Garten- und Landschaftsbau | Delmenhorst
```

### Meta-Beschreibung (Home)
```
Professioneller Garten- und Landschaftsbau in Delmenhorst ✓ Gartengestaltung ✓ Pflasterarbeiten ✓ Rollrasen ✓ Kostenlose Beratung. Jetzt anfragen!
```

### Wichtige Keywords
- Garten- und Landschaftsbau Delmenhorst
- Gartenpflege Delmenhorst
- Pflasterarbeiten Delmenhorst
- Rollrasen verlegen Bremen
- Gartengestaltung Niedersachsen
- Zaunbau Delmenhorst
- Winterdienst Delmenhorst

### Local SEO
- Google My Business Profil erstellen
- NAP (Name, Address, Phone) konsistent halten
- Lokale Strukturierte Daten (Schema.org LocalBusiness)

---

## 9. DSGVO Checkliste

- [ ] Impressum mit vollständigen Angaben
- [ ] Datenschutzerklärung
- [ ] Cookie-Banner (Complianz Plugin)
- [ ] SSL-Zertifikat (https)
- [ ] Kontaktformular mit Einwilligungserklärung
- [ ] Google Fonts lokal einbinden (optional für DSGVO)
- [ ] AV-Vertrag mit Hosting-Anbieter

---

## 10. Hosting Empfehlungen

| Anbieter | Preis/Monat | Empfehlung |
|----------|-------------|------------|
| **All-Inkl** | ab 4,95€ | Sehr gut für Deutschland |
| **FLAVOR** | ab 3,99€ | Gutes Preis-Leistung |
| **Raidboxes** | ab 9€ | Premium WordPress Hosting |
| **FLAVOR** | ab 4,99€ | Solide Option |

---

## Zusammenfassung

Diese Spezifikationen bieten eine vollständige Grundlage für die Erstellung einer professionellen WordPress-Website für Toni Janis. Die gewählte Farbpalette aus natürlichen Grün- und Erdtönen passt perfekt zum Garten- und Landschaftsbau und vermittelt Professionalität und Naturverbundenheit.

**Nächste Schritte:**
1. Domain und Hosting einrichten
2. WordPress installieren
3. Theme installieren und anpassen
4. Plugins installieren
5. Inhalte erstellen
6. SEO optimieren
7. DSGVO-Anforderungen erfüllen
8. Testen und veröffentlichen
