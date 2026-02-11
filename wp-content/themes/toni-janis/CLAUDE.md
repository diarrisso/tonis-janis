# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Custom WordPress theme for **Toni Janis Garten- und Landschaftsbau** (landscaping and gardening business) in Delmenhorst, Germany. Built with TailwindCSS, SASS, Alpine.js, and ACF Pro flexible content.

## Project Type

WordPress custom theme with ACF flexible content blocks architecture.

## Tech Stack

- **PHP 8.1+** - WordPress theme
- **TailwindCSS 3.4** - Utility-first CSS
- **SASS** - Component/block-specific styles
- **Alpine.js 3** - Interactive UI (loaded via CDN)
- **esbuild** - JS bundling
- **ACF Pro** - Flexible content blocks

## File Structure

```
├── style.css                          # WordPress theme header
├── functions.php                      # Theme bootstrap
├── index.php / page.php / single.php  # WordPress templates
├── header.php / footer.php            # Layout templates
├── front-page.php                     # Homepage template
├── 404.php                            # Error page
├── inc/
│   ├── setup.php                      # Theme setup, enqueue, SVG support
│   ├── acf/
│   │   ├── block-utils.php            # Block rendering utilities
│   │   ├── field-groups.php           # ACF field group registration
│   │   └── blocks-config.php          # Common field definitions
│   └── helpers/
│       ├── html-helpers.php           # toja_image(), toja_button(), toja_svg()
│       ├── class-helpers.php          # toja_classes(), toja_bg_class()
│       └── data-helpers.php           # toja_option(), toja_contact_info()
├── template-parts/
│   ├── blocks/                        # ACF flexible content blocks
│   │   └── _block-template/           # Template for new blocks
│   └── components/                    # Reusable PHP components
│       ├── heading.php
│       ├── button.php
│       ├── image.php
│       └── background.php
├── assets/
│   ├── src/
│   │   ├── css/main.css               # TailwindCSS entry point
│   │   ├── scss/                      # SASS source files
│   │   │   ├── main.scss              # SASS entry point
│   │   │   ├── _variables.scss        # Design tokens
│   │   │   ├── _mixins.scss           # Reusable mixins
│   │   │   ├── _base.scss             # Base styles
│   │   │   ├── _fonts.scss            # Font declarations
│   │   │   ├── blocks/_index.scss     # Block styles
│   │   │   └── components/_index.scss # Component styles
│   │   └── js/
│   │       ├── main.js                # JS entry point
│   │       └── components/            # JS modules
│   └── dist/                          # Compiled assets (production)
│       ├── main.css
│       └── main.js
├── demo/                              # Original HTML mockups (reference)
├── package.json
├── tailwind.config.js
└── postcss.config.js
```

## Commands

```bash
npm run dev          # Watch mode (SASS + Tailwind + JS)
npm run dev:sync     # Watch mode + BrowserSync (proxy localhost:8027)
npm run build        # Production build
npm run lint         # Lint JS + SCSS
npm run format       # Format code with Prettier
```

## Conventions

### PHP Prefix
All functions use the `toja_` prefix (e.g., `toja_setup()`, `toja_image()`).

### Theme Constants
- `TOJA_VERSION` - Theme version
- `TOJA_DIR` - Theme directory path
- `TOJA_URI` - Theme directory URI

### Creating New ACF Blocks
1. Copy `template-parts/blocks/_block-template/` to a new directory
2. Rename files to match the block name
3. Update `config.php` with fields
4. Add SASS file in `assets/src/scss/blocks/` and import in `_index.scss`
5. Or use `/create-acf-block` command

### SASS Architecture
Uses `@use` module system (not deprecated `@import`). Variables are in `_variables.scss`, imported with `@use 'variables' as *`.

## Design System

### Color Palette (Kiwi Green Theme)
```css
--kiwi-green: #8BC34A;      /* Primary brand color */
--kiwi-dark: #689F38;       /* Darker variant */
--kiwi-light: #AED581;      /* Light variant */
--kiwi-accent: #9CCC65;     /* Accent color */
--earth-brown: #5D4037;     /* Text color */
--sand-beige: #E8E0D5;      /* Background variant */
--cream: #FAF8F5;            /* Main background */
--charcoal: #2D2D2D;        /* Dark text */
```

### Typography
- Headers: Playfair Display (400, 600, 700)
- Body/UI: Source Sans 3 (300, 400, 500, 600)
- Fonts loaded via Google Fonts CDN

## Business Information

```
Company: Toni Janis Garten- und Landschaftsbau
Address: Düsternort Str. 104, 27755 Delmenhorst
Phone 1: 0176 343 26549
Phone 2: 0176 878 29995
Email: toni-janis@hotmail.com
WhatsApp: wa.me/4917634326549
```

## Language

All content is in German (Deutsch). Maintain German language in all user-facing content.

## Required Plugins

- **ACF Pro** - Flexible content blocks (required)
- **Classic Editor** - Gutenberg is disabled in theme

## Recommended Plugins

- Yoast SEO / RankMath - SEO
- WP Super Cache - Performance
- Wordfence - Security
- Contact Form 7 - Forms
- EWWW Image Optimizer - Images

## SEO Strategy

Target keywords: Garten- und Landschaftsbau Delmenhorst, Gartengestaltung Delmenhorst, Pflasterarbeiten Delmenhorst, Rollrasen verlegen Bremen.
