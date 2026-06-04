<?php
/**
 * Startseiten-Einstellungen (Theme-Optionen, ohne Plugin)
 *
 * Stellt eine eigene Admin-Seite „Startseite" bereit (WordPress Settings API)
 * und liefert über sot_fp() die Werte für das Startseiten-Template und die Partials.
 * Alle Werte liegen in EINER Option `sot_frontpage` (Array).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================================
   Reihenfolge / Liste der Sektionen
   ========================================================================== */
function sot_fp_sections() {
    return array(
        'hero'        => 'Hero',
        'zielgruppen' => 'Zielgruppen-Karten',
        'prozess'     => 'Der Weg zum IoT (4 Schritte)',
        'kategorien'  => 'Produkt-Kategorien',
        'whyus'       => 'Warum ShopOfThings?',
        'partner'     => 'Technologiepartner-Logos',
        'kunden'      => 'Kunden-Logos',
        'stats'       => 'Zahlen / Statistiken',
        'news'        => 'Aktuelles (Blog)',
    );
}

/* ==========================================================================
   Standardwerte (entsprechen der bisherigen Startseite)
   ========================================================================== */
function sot_fp_defaults() {
    return array(
        'section_order' => array( 'hero', 'zielgruppen', 'prozess', 'kategorien', 'whyus', 'partner', 'kunden', 'stats', 'news' ),
        'sections'      => array(
            'hero'        => 1,
            'zielgruppen' => 1,
            'prozess'     => 1,
            'kategorien'  => 1,
            'whyus'       => 1,
            'partner'     => 1,
            'kunden'      => 1,
            'stats'       => 1,
            'news'        => 1,
        ),

        // Hero
        'hero_subtitle'  => 'IoT einfach gemacht – von Sensor bis Cloud.',
        'hero_title'     => 'Ihr Schweizer <span class="highlight">Shop</span><br>für <span class="highlight">IoT</span>-Hardware<br>und Integration.',
        'hero_btn1_text' => 'Produkte entdecken',
        'hero_btn1_url'  => '/produkt-kategorie/typ/nodes/',
        'hero_btn2_text' => 'Projekt starten',
        'hero_btn2_url'  => '/projekt-starten/',
        'hero_image'     => 0,
        'hero_badges'    => array( 'Schweizer Lager', 'Offizieller Distributor', 'Schnelle Lieferung & Support' ),

        // Zielgruppen
        'zg_heading' => 'Für wen ist ShopOfThings?',
        'zg_intro'   => 'Wir unterstützen Unternehmen, Integratoren und Entwickler bei jedem Schritt Ihres IoT-Projekts.',
        'zg_cards'   => array(
            array( 'title' => 'Unternehmen & Städte', 'text' => 'End-to-End-Lösungen für Smart-City- und Industrie-Projekte.', 'link_text' => 'Mehr erfahren →', 'url' => '/anwendungen/smart-city/' ),
            array( 'title' => 'Systemintegratoren', 'text' => 'End-to-End-Lösungen für Smart-City- und Industrie-Projekte.', 'link_text' => 'Jetzt entdecken →', 'url' => '/partner/systemintegratoren/' ),
            array( 'title' => 'Techniker & Entwickler', 'text' => 'Prototyping, Tools und Sensoren für Ihre individuellen Anforderungen.', 'link_text' => 'Zum Sortiment →', 'url' => '/produkte/sensoren/' ),
        ),

        // Prozess
        'pr_heading' => 'Der Weg zum IoT – in vier Schritten',
        'pr_intro'   => 'Von der Messung bis zur Visualisierung: So bringen wir Ihr IoT-Projekt zum Erfolg.',
        'pr_steps'   => array(
            array( 'title' => 'Sensorik', 'line1' => 'Daten erfassen', 'line2' => 'Hochpräzise Sensoren für alle Anwendungen', 'url' => '/sensorik/' ),
            array( 'title' => 'Connectivity', 'line1' => 'Sichere Datenübertragung', 'line2' => 'LoRaWAN, NB-IoT und weitere Technologien', 'url' => '/konnektivitaet/' ),
            array( 'title' => 'Integration & Steuerung', 'line1' => 'Analyse & Steuerung', 'line2' => 'Dashboards und Schnittstellen', 'url' => '/integration/' ),
            array( 'title' => 'Installation & Support', 'line1' => 'Fachgerechte Umsetzung', 'line2' => 'Beratung und technischer Support', 'url' => '/support/' ),
        ),

        // Kategorien
        'kat_heading'  => 'Unsere beliebtesten Kategorien',
        'kat_category' => '',
        'kat_count'    => 8,

        // Warum ShopOfThings
        'why_heading' => 'Warum ShopOfThings?',
        'why_items'   => array(
            array( 'icon' => '🏢', 'title' => 'Offizieller Distributor', 'text' => 'Autorisierter Partner führender IoT-Hersteller' ),
            array( 'icon' => '🇨🇭', 'title' => 'Schweizer Lager', 'text' => 'Versand innert 48 h aus der Schweiz' ),
            array( 'icon' => '🤝', 'title' => 'Beratung & Support', 'text' => 'Technische Unterstützung von Profis' ),
            array( 'icon' => '🔧', 'title' => 'Integration', 'text' => 'Von der Hardware bis zur Cloud' ),
            array( 'icon' => '📦', 'title' => 'Grosses Sortiment', 'text' => 'Tausende Produkte führender Hersteller' ),
            array( 'icon' => '🌿', 'title' => 'Nachhaltig', 'text' => 'Wir versenden grün' ),
        ),

        // Partner
        'partner_heading' => 'Unsere Technologiepartner',
        'partner_logos'   => array(),

        // Kunden
        'kunden_heading' => 'Unsere Kunden vertrauen auf ShopOfThings',
        'kunden_logos'   => array(),

        // Stats
        'stats_heading' => 'Zahlen, die überzeugen',
        'stats_items'   => array(
            array( 'number' => '>50', 'label' => 'Städte vernetzt' ),
            array( 'number' => '1000+', 'label' => 'Produkte ab Lager' ),
            array( 'number' => '48 h', 'label' => 'Versand aus der Schweiz' ),
            array( 'number' => '15+', 'label' => 'Hersteller-Partnerschaften' ),
        ),

        // News
        'news_heading' => 'Aktuelles aus der IoT-Welt',
        'news_count'   => 3,
    );
}

/* ==========================================================================
   Accessor – im Theme via sot_fp() nutzen
   ========================================================================== */
function sot_fp() {
    static $opts = null;
    if ( null === $opts ) {
        $saved = get_option( 'sot_frontpage', array() );
        if ( ! is_array( $saved ) ) {
            $saved = array();
        }
        // flacher Merge: gespeicherte (vollständig abgesendete) Werte
        // überschreiben die Defaults; fehlende Keys kommen aus den Defaults.
        $opts = array_merge( sot_fp_defaults(), $saved );
    }
    return $opts;
}

/** Einzelwert bequem abrufen */
function sot_fp_get( $key, $fallback = '' ) {
    $opts = sot_fp();
    return isset( $opts[ $key ] ) ? $opts[ $key ] : $fallback;
}

/* ==========================================================================
   Registrierung + Admin-Menü
   ========================================================================== */
add_action( 'admin_init', function () {
    register_setting( 'sot_frontpage_group', 'sot_frontpage', array(
        'type'              => 'array',
        'sanitize_callback' => 'sot_fp_sanitize',
        'default'           => array(),
    ) );
} );

add_action( 'admin_menu', function () {
    add_menu_page(
        'Startseite',
        'Startseite',
        'manage_options',
        'sot-frontpage',
        'sot_fp_render_page',
        'dashicons-admin-home',
        3
    );
} );

/* Medien-Uploader + Admin-Skript nur auf dieser Seite laden */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_sot-frontpage' !== $hook ) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script(
        'sot-frontpage-admin',
        get_stylesheet_directory_uri() . '/inc/frontpage/frontpage-admin.js',
        array( 'jquery', 'jquery-ui-sortable' ),
        '1.0.0',
        true
    );
} );

/* ==========================================================================
   Sanitisierung
   ========================================================================== */
function sot_fp_sanitize( $input ) {
    $d   = sot_fp_defaults();
    $out = array();

    if ( ! is_array( $input ) ) {
        return $d;
    }

    // Sektion-Reihenfolge (Komma-String aus dem Sortable)
    $order = array();
    if ( ! empty( $input['section_order'] ) ) {
        $raw = is_array( $input['section_order'] ) ? $input['section_order'] : explode( ',', $input['section_order'] );
        foreach ( $raw as $slug ) {
            $slug = sanitize_key( $slug );
            if ( array_key_exists( $slug, sot_fp_sections() ) && ! in_array( $slug, $order, true ) ) {
                $order[] = $slug;
            }
        }
    }
    // fehlende Sektionen hinten anhängen
    foreach ( array_keys( sot_fp_sections() ) as $slug ) {
        if ( ! in_array( $slug, $order, true ) ) {
            $order[] = $slug;
        }
    }
    $out['section_order'] = $order;

    // Sichtbarkeit
    $out['sections'] = array();
    foreach ( array_keys( sot_fp_sections() ) as $slug ) {
        $out['sections'][ $slug ] = ( ! empty( $input['sections'][ $slug ] ) ) ? 1 : 0;
    }

    // Hero
    $out['hero_subtitle']  = sanitize_text_field( $input['hero_subtitle'] ?? $d['hero_subtitle'] );
    $out['hero_title']     = wp_kses( $input['hero_title'] ?? $d['hero_title'], array(
        'span'   => array( 'class' => array() ),
        'br'     => array(),
        'strong' => array(),
        'em'     => array(),
    ) );
    $out['hero_btn1_text'] = sanitize_text_field( $input['hero_btn1_text'] ?? '' );
    $out['hero_btn1_url']  = esc_url_raw( $input['hero_btn1_url'] ?? '' );
    $out['hero_btn2_text'] = sanitize_text_field( $input['hero_btn2_text'] ?? '' );
    $out['hero_btn2_url']  = esc_url_raw( $input['hero_btn2_url'] ?? '' );
    $out['hero_image']     = absint( $input['hero_image'] ?? 0 );
    $out['hero_badges']    = array();
    if ( ! empty( $input['hero_badges'] ) && is_array( $input['hero_badges'] ) ) {
        foreach ( $input['hero_badges'] as $b ) {
            $b = sanitize_text_field( $b );
            if ( '' !== $b ) {
                $out['hero_badges'][] = $b;
            }
        }
    }

    // Zielgruppen
    $out['zg_heading'] = sanitize_text_field( $input['zg_heading'] ?? '' );
    $out['zg_intro']   = sanitize_text_field( $input['zg_intro'] ?? '' );
    $out['zg_cards']   = sot_fp_sanitize_rows( $input['zg_cards'] ?? array(), array( 'title', 'text', 'link_text' ), array( 'url' ) );

    // Prozess
    $out['pr_heading'] = sanitize_text_field( $input['pr_heading'] ?? '' );
    $out['pr_intro']   = sanitize_text_field( $input['pr_intro'] ?? '' );
    $out['pr_steps']   = sot_fp_sanitize_rows( $input['pr_steps'] ?? array(), array( 'title', 'line1', 'line2' ), array( 'url' ) );

    // Kategorien
    $out['kat_heading']  = sanitize_text_field( $input['kat_heading'] ?? '' );
    $out['kat_category'] = sanitize_title( $input['kat_category'] ?? '' );
    $out['kat_count']    = max( 1, absint( $input['kat_count'] ?? 8 ) );

    // Warum
    $out['why_heading'] = sanitize_text_field( $input['why_heading'] ?? '' );
    $out['why_items']   = sot_fp_sanitize_rows( $input['why_items'] ?? array(), array( 'icon', 'title', 'text' ), array() );

    // Partner / Kunden
    $out['partner_heading'] = sanitize_text_field( $input['partner_heading'] ?? '' );
    $out['partner_logos']   = sot_fp_sanitize_ids( $input['partner_logos'] ?? '' );
    $out['kunden_heading']  = sanitize_text_field( $input['kunden_heading'] ?? '' );
    $out['kunden_logos']    = sot_fp_sanitize_ids( $input['kunden_logos'] ?? '' );

    // Stats
    $out['stats_heading'] = sanitize_text_field( $input['stats_heading'] ?? '' );
    $out['stats_items']   = sot_fp_sanitize_rows( $input['stats_items'] ?? array(), array( 'number', 'label' ), array() );

    // News
    $out['news_heading'] = sanitize_text_field( $input['news_heading'] ?? '' );
    $out['news_count']   = max( 1, absint( $input['news_count'] ?? 3 ) );

    return $out;
}

/** Hilfsfunktion: Zeilen (Karten/Schritte/…) sanitisieren */
function sot_fp_sanitize_rows( $rows, $text_keys, $url_keys ) {
    $clean = array();
    if ( ! is_array( $rows ) ) {
        return $clean;
    }
    foreach ( $rows as $row ) {
        if ( ! is_array( $row ) ) {
            continue;
        }
        $r = array();
        foreach ( $text_keys as $k ) {
            $r[ $k ] = sanitize_text_field( $row[ $k ] ?? '' );
        }
        foreach ( $url_keys as $k ) {
            $r[ $k ] = esc_url_raw( $row[ $k ] ?? '' );
        }
        // leere Zeilen überspringen
        $has_content = false;
        foreach ( $r as $v ) {
            if ( '' !== $v ) {
                $has_content = true;
                break;
            }
        }
        if ( $has_content ) {
            $clean[] = $r;
        }
    }
    return $clean;
}

/** Hilfsfunktion: Komma-getrennte Attachment-IDs -> sauberes Array */
function sot_fp_sanitize_ids( $value ) {
    if ( is_array( $value ) ) {
        $parts = $value;
    } else {
        $parts = explode( ',', (string) $value );
    }
    $ids = array();
    foreach ( $parts as $p ) {
        $p = absint( $p );
        if ( $p > 0 ) {
            $ids[] = $p;
        }
    }
    return $ids;
}

/* ==========================================================================
   Render – kleine Feld-Helfer
   ========================================================================== */
function sot_fp_field_name( $path ) {
    // $path z.B. "hero_subtitle" oder "zg_cards][0][title"
    return 'sot_frontpage[' . $path . ']';
}

function sot_fp_text( $key, $label, $value, $placeholder = '' ) {
    printf(
        '<p><label><strong>%s</strong><br><input type="text" name="%s" value="%s" placeholder="%s" class="regular-text" style="width:100%%;max-width:640px"></label></p>',
        esc_html( $label ),
        esc_attr( sot_fp_field_name( $key ) ),
        esc_attr( $value ),
        esc_attr( $placeholder )
    );
}

function sot_fp_textarea( $key, $label, $value, $hint = '' ) {
    printf(
        '<p><label><strong>%s</strong><br><textarea name="%s" rows="3" class="large-text" style="max-width:640px">%s</textarea></label>%s</p>',
        esc_html( $label ),
        esc_attr( sot_fp_field_name( $key ) ),
        esc_textarea( $value ),
        $hint ? '<br><span class="description">' . esc_html( $hint ) . '</span>' : ''
    );
}

function sot_fp_number( $key, $label, $value ) {
    printf(
        '<p><label><strong>%s</strong><br><input type="number" min="1" name="%s" value="%s" class="small-text"></label></p>',
        esc_html( $label ),
        esc_attr( sot_fp_field_name( $key ) ),
        esc_attr( $value )
    );
}

/* ==========================================================================
   Render – Admin-Seite
   ========================================================================== */
function sot_fp_render_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $o        = sot_fp();
    $sections = sot_fp_sections();
    ?>
    <div class="wrap sot-fp-admin">
        <h1>Startseite</h1>
        <p class="description"><strong>Hinweis:</strong> Diese Einstellungen wirken auf die Seite mit dem Template „Startseite (ShopOfThings)" – aktuell die Vorschau unter <code>/test-startseite</code>. Die bestehende Startseite wird <em>nicht</em> automatisch ersetzt. Erst wenn du unter <em>Einstellungen → Lesen → „Eine statische Seite"</em> diese Seite auswählst, wird sie zur echten Startseite.</p>

        <form method="post" action="options.php">
            <?php settings_fields( 'sot_frontpage_group' ); ?>

            <h2 class="title">Sektionen ein-/ausblenden &amp; Reihenfolge</h2>
            <p class="description">Per Drag &amp; Drop sortieren, Häkchen zum Ein-/Ausblenden.</p>
            <input type="hidden" id="sot-fp-order" name="<?php echo esc_attr( sot_fp_field_name( 'section_order' ) ); ?>" value="<?php echo esc_attr( implode( ',', (array) $o['section_order'] ) ); ?>">
            <ul id="sot-fp-sortable" style="max-width:520px;margin:0 0 24px">
                <?php foreach ( (array) $o['section_order'] as $slug ) :
                    if ( ! isset( $sections[ $slug ] ) ) { continue; }
                    $enabled = ! empty( $o['sections'][ $slug ] );
                    ?>
                    <li class="sot-fp-sortable-item" data-slug="<?php echo esc_attr( $slug ); ?>" style="background:#fff;border:1px solid #dcdcde;border-radius:6px;padding:10px 12px;margin-bottom:6px;cursor:move;display:flex;align-items:center;gap:10px">
                        <span class="dashicons dashicons-move" style="color:#888"></span>
                        <label style="margin:0">
                            <input type="checkbox" name="<?php echo esc_attr( sot_fp_field_name( 'sections][' . $slug ) ); ?>" value="1" <?php checked( $enabled ); ?>>
                            <strong><?php echo esc_html( $sections[ $slug ] ); ?></strong>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>

            <hr>
            <h2 class="title">Hero</h2>
            <?php
            sot_fp_text( 'hero_subtitle', 'Subtitle (über dem Titel)', $o['hero_subtitle'] );
            sot_fp_textarea( 'hero_title', 'Titel (HTML erlaubt: <span class="highlight">…</span>, <br>)', $o['hero_title'], 'Beispiel: Ihr Schweizer <span class="highlight">Shop</span><br>für IoT.' );
            echo '<div style="display:flex;gap:24px;flex-wrap:wrap">';
            echo '<div>'; sot_fp_text( 'hero_btn1_text', 'Button 1 – Text', $o['hero_btn1_text'] ); sot_fp_text( 'hero_btn1_url', 'Button 1 – Link', $o['hero_btn1_url'] ); echo '</div>';
            echo '<div>'; sot_fp_text( 'hero_btn2_text', 'Button 2 – Text', $o['hero_btn2_text'] ); sot_fp_text( 'hero_btn2_url', 'Button 2 – Link', $o['hero_btn2_url'] ); echo '</div>';
            echo '</div>';
            // Hero-Bild
            $hero_img = absint( $o['hero_image'] );
            $hero_src = $hero_img ? wp_get_attachment_image_url( $hero_img, 'medium' ) : '';
            ?>
            <p><strong>Hero-Bild</strong> <span class="description">(leer = Standardbild des Themes)</span></p>
            <div class="sot-fp-media" data-multiple="0" data-target="#sot-fp-hero-image">
                <input type="hidden" id="sot-fp-hero-image" name="<?php echo esc_attr( sot_fp_field_name( 'hero_image' ) ); ?>" value="<?php echo esc_attr( $hero_img ); ?>">
                <div class="sot-fp-preview" style="margin-bottom:8px"><?php if ( $hero_src ) : ?><img src="<?php echo esc_url( $hero_src ); ?>" style="max-width:220px;height:auto;border:1px solid #dcdcde;border-radius:6px"><?php endif; ?></div>
                <button type="button" class="button sot-fp-media-add">Bild wählen</button>
                <button type="button" class="button sot-fp-media-clear">Entfernen</button>
            </div>
            <?php
            // Badges (3 Stück)
            echo '<p style="margin-top:16px"><strong>Badges (unter den Buttons)</strong></p>';
            $badges = (array) $o['hero_badges'];
            for ( $i = 0; $i < 3; $i++ ) {
                sot_fp_text( 'hero_badges][' . $i, 'Badge ' . ( $i + 1 ), $badges[ $i ] ?? '' );
            }
            ?>

            <hr>
            <h2 class="title">Zielgruppen-Karten</h2>
            <?php
            sot_fp_text( 'zg_heading', 'Überschrift', $o['zg_heading'] );
            sot_fp_textarea( 'zg_intro', 'Einleitungstext', $o['zg_intro'] );
            $cards = (array) $o['zg_cards'];
            for ( $i = 0; $i < 3; $i++ ) {
                $c = $cards[ $i ] ?? array();
                echo '<fieldset style="border:1px solid #dcdcde;border-radius:6px;padding:8px 14px;margin-bottom:10px"><legend><strong>Karte ' . ( $i + 1 ) . '</strong></legend>';
                sot_fp_text( 'zg_cards][' . $i . '][title', 'Titel', $c['title'] ?? '' );
                sot_fp_text( 'zg_cards][' . $i . '][text', 'Text', $c['text'] ?? '' );
                sot_fp_text( 'zg_cards][' . $i . '][link_text', 'Link-Text', $c['link_text'] ?? '' );
                sot_fp_text( 'zg_cards][' . $i . '][url', 'Link-Ziel', $c['url'] ?? '' );
                echo '</fieldset>';
            }
            ?>

            <hr>
            <h2 class="title">Der Weg zum IoT (4 Schritte)</h2>
            <?php
            sot_fp_text( 'pr_heading', 'Überschrift', $o['pr_heading'] );
            sot_fp_textarea( 'pr_intro', 'Einleitungstext', $o['pr_intro'] );
            $steps = (array) $o['pr_steps'];
            for ( $i = 0; $i < 4; $i++ ) {
                $s = $steps[ $i ] ?? array();
                echo '<fieldset style="border:1px solid #dcdcde;border-radius:6px;padding:8px 14px;margin-bottom:10px"><legend><strong>Schritt ' . ( $i + 1 ) . '</strong></legend>';
                sot_fp_text( 'pr_steps][' . $i . '][title', 'Titel', $s['title'] ?? '' );
                sot_fp_text( 'pr_steps][' . $i . '][line1', 'Zeile 1', $s['line1'] ?? '' );
                sot_fp_text( 'pr_steps][' . $i . '][line2', 'Zeile 2', $s['line2'] ?? '' );
                sot_fp_text( 'pr_steps][' . $i . '][url', 'Link-Ziel', $s['url'] ?? '' );
                echo '</fieldset>';
            }
            ?>

            <hr>
            <h2 class="title">Produkt-Kategorien</h2>
            <?php
            sot_fp_text( 'kat_heading', 'Überschrift', $o['kat_heading'] );
            sot_fp_text( 'kat_category', 'Kategorie-Slug (leer = nach Beliebtheit, alle)', $o['kat_category'], 'z. B. nodes' );
            sot_fp_number( 'kat_count', 'Anzahl Produkte', $o['kat_count'] );
            ?>

            <hr>
            <h2 class="title">Warum ShopOfThings?</h2>
            <?php
            sot_fp_text( 'why_heading', 'Überschrift', $o['why_heading'] );
            $why = (array) $o['why_items'];
            for ( $i = 0; $i < 6; $i++ ) {
                $w = $why[ $i ] ?? array();
                echo '<fieldset style="border:1px solid #dcdcde;border-radius:6px;padding:8px 14px;margin-bottom:10px"><legend><strong>Vorteil ' . ( $i + 1 ) . '</strong></legend>';
                sot_fp_text( 'why_items][' . $i . '][icon', 'Icon (Emoji)', $w['icon'] ?? '' );
                sot_fp_text( 'why_items][' . $i . '][title', 'Titel', $w['title'] ?? '' );
                sot_fp_text( 'why_items][' . $i . '][text', 'Text', $w['text'] ?? '' );
                echo '</fieldset>';
            }
            ?>

            <hr>
            <h2 class="title">Technologiepartner-Logos</h2>
            <?php sot_fp_text( 'partner_heading', 'Überschrift', $o['partner_heading'] ); ?>
            <?php sot_fp_render_logos( 'partner_logos', (array) $o['partner_logos'] ); ?>

            <hr>
            <h2 class="title">Kunden-Logos</h2>
            <?php sot_fp_text( 'kunden_heading', 'Überschrift', $o['kunden_heading'] ); ?>
            <?php sot_fp_render_logos( 'kunden_logos', (array) $o['kunden_logos'] ); ?>

            <hr>
            <h2 class="title">Zahlen / Statistiken</h2>
            <?php
            sot_fp_text( 'stats_heading', 'Überschrift', $o['stats_heading'] );
            $stats = (array) $o['stats_items'];
            for ( $i = 0; $i < 4; $i++ ) {
                $st = $stats[ $i ] ?? array();
                echo '<fieldset style="border:1px solid #dcdcde;border-radius:6px;padding:8px 14px;margin-bottom:10px"><legend><strong>Zahl ' . ( $i + 1 ) . '</strong></legend>';
                sot_fp_text( 'stats_items][' . $i . '][number', 'Zahl (z. B. >50)', $st['number'] ?? '' );
                sot_fp_text( 'stats_items][' . $i . '][label', 'Beschriftung', $st['label'] ?? '' );
                echo '</fieldset>';
            }
            ?>

            <hr>
            <h2 class="title">Aktuelles (Blog)</h2>
            <?php
            sot_fp_text( 'news_heading', 'Überschrift', $o['news_heading'] );
            sot_fp_number( 'news_count', 'Anzahl Beiträge', $o['news_count'] );
            ?>

            <?php submit_button( 'Startseite speichern' ); ?>
        </form>
    </div>
    <?php
}

/** Render: Logo-Galerie (mehrere Medien) */
function sot_fp_render_logos( $key, $ids ) {
    $target = 'sot-fp-' . $key;
    ?>
    <div class="sot-fp-media" data-multiple="1" data-target="#<?php echo esc_attr( $target ); ?>">
        <input type="hidden" id="<?php echo esc_attr( $target ); ?>" name="<?php echo esc_attr( sot_fp_field_name( $key ) ); ?>" value="<?php echo esc_attr( implode( ',', array_map( 'absint', $ids ) ) ); ?>">
        <div class="sot-fp-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:8px">
            <?php foreach ( $ids as $id ) :
                $src = wp_get_attachment_image_url( absint( $id ), 'thumbnail' );
                if ( ! $src ) { continue; } ?>
                <span style="position:relative;display:inline-block">
                    <img src="<?php echo esc_url( $src ); ?>" style="width:70px;height:70px;object-fit:contain;border:1px solid #dcdcde;border-radius:6px;background:#fff">
                </span>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button sot-fp-media-add">Logos hinzufügen</button>
        <button type="button" class="button sot-fp-media-clear">Alle entfernen</button>
    </div>
    <?php
}

/* ==========================================================================
   Hero-Badge-Icons (statische SVGs; Reihenfolge passend zu den Badge-Texten)
   ========================================================================== */
function sot_fp_badge_icon( $index ) {
    $icons = array(
        // 0 – Lager / Haus
        '<svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.5 6.62062V22.5706H22.5V6.62062L11.5 0.570618L0.5 6.62062Z" fill="white"/><path d="M4.90015 15.9706V22.5706H11.5001V15.9706H4.90015Z" fill="white"/><path d="M11.5002 15.9706V22.5706H18.1002V15.9706H11.5002Z" fill="white"/><path d="M8.2002 9.37061V15.9706H14.8002V9.37061H8.2002Z" fill="white"/><path d="M0.5 6.62062V22.5706H22.5V6.62062L11.5 0.570618L0.5 6.62062Z" stroke="#1D2E7C"/><path d="M4.90015 15.9706V22.5706H11.5001V15.9706H4.90015Z" stroke="#1D2E7C"/><path d="M11.5002 15.9706V22.5706H18.1002V15.9706H11.5002Z" stroke="#1D2E7C"/><path d="M8.2002 9.37061V15.9706H14.8002V9.37061H8.2002Z" stroke="#1D2E7C"/></svg>',
        // 1 – Distributor / Netzwerk
        '<svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5001 17.7857C22.5001 19.036 22.0034 20.2351 21.1193 21.1192C20.2352 22.0033 19.0361 22.5 17.7858 22.5C16.5355 22.5 15.3364 22.0033 14.4523 21.1192C13.5682 20.2351 13.0715 19.036 13.0715 17.7857C13.0715 16.5354 13.5682 15.3363 14.4523 14.4522C15.3364 13.5681 16.5355 13.0714 17.7858 13.0714C19.0361 13.0714 20.2352 13.5681 21.1193 14.4522C22.0034 15.3363 22.5001 16.5354 22.5001 17.7857Z" fill="white"/><path d="M22.5001 5.21429C22.5001 6.46459 22.0034 7.66369 21.1193 8.54779C20.2352 9.43189 19.0361 9.92857 17.7858 9.92857C16.5355 9.92857 15.3364 9.43189 14.4523 8.54779C13.5682 7.66369 13.0715 6.46459 13.0715 5.21429C13.0715 3.96398 13.5682 2.76488 14.4523 1.88078C15.3364 0.996682 16.5355 0.5 17.7858 0.5C19.0361 0.5 20.2352 0.996682 21.1193 1.88078C22.0034 2.76488 22.5001 3.96398 22.5001 5.21429Z" fill="white"/><path d="M9.92857 11.5001C9.92857 12.7504 9.43189 13.9495 8.54779 14.8336C7.66369 15.7177 6.46459 16.2143 5.21429 16.2143C3.96398 16.2143 2.76488 15.7177 1.88078 14.8336C0.996682 13.9495 0.5 12.7504 0.5 11.5001C0.5 10.2497 0.996682 9.05065 1.88078 8.16655C2.76488 7.28245 3.96398 6.78577 5.21429 6.78577C6.46459 6.78577 7.66369 7.28245 8.54779 8.16655C9.43189 9.05065 9.92857 10.2497 9.92857 11.5001Z" fill="white"/><path d="M9.92857 11.5001C9.92857 12.7504 9.43189 13.9495 8.54779 14.8336C7.66369 15.7177 6.46459 16.2143 5.21429 16.2143C3.96398 16.2143 2.76488 15.7177 1.88078 14.8336C0.996682 13.9495 0.5 12.7504 0.5 11.5001C0.5 10.2497 0.996682 9.05065 1.88078 8.16655C2.76488 7.28245 3.96398 6.78577 5.21429 6.78577C6.46459 6.78577 7.66369 7.28245 8.54779 8.16655C9.43189 9.05065 9.92857 10.2497 9.92857 11.5001Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/><path d="M22.5001 5.21429C22.5001 6.46459 22.0034 7.66369 21.1193 8.54779C20.2352 9.43189 19.0361 9.92857 17.7858 9.92857C16.5355 9.92857 15.3364 9.43189 14.4523 8.54779C13.5682 7.66369 13.0715 6.46459 13.0715 5.21429C13.0715 3.96398 13.5682 2.76488 14.4523 1.88078C15.3364 0.996682 16.5355 0.5 17.7858 0.5C19.0361 0.5 20.2352 0.996682 21.1193 1.88078C22.0034 2.76488 22.5001 3.96398 22.5001 5.21429Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/><path d="M22.5001 17.7857C22.5001 19.036 22.0034 20.2351 21.1193 21.1192C20.2352 22.0033 19.0361 22.5 17.7858 22.5C16.5355 22.5 15.3364 22.0033 14.4523 21.1192C13.5682 20.2351 13.0715 19.036 13.0715 17.7857C13.0715 16.5354 13.5682 15.3363 14.4523 14.4522C15.3364 13.5681 16.5355 13.0714 17.7858 13.0714C19.0361 13.0714 20.2352 13.5681 21.1193 14.4522C22.0034 15.3363 22.5001 16.5354 22.5001 17.7857Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.5681 7.32263L9.43213 9.39116M13.5681 15.6769L9.43213 13.6083" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        // 2 – Lieferung / Pfeile
        '<svg width="23" height="15" viewBox="0 0 23 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.500009 12.8214C0.499189 13.0367 0.557048 13.2481 0.667368 13.433C0.777687 13.6179 0.936296 13.7692 1.12615 13.8706C1.31277 13.9825 1.52626 14.0416 1.74383 14.0416C1.9614 14.0416 2.17489 13.9825 2.36151 13.8706L10.9582 8.28615C11.126 8.17907 11.264 8.03147 11.3596 7.85697C11.4552 7.68247 11.5054 7.48669 11.5054 7.28771C11.5054 7.08873 11.4552 6.89295 11.3596 6.71845C11.264 6.54395 11.126 6.39635 10.9582 6.28927L2.36151 0.670928C2.17489 0.559078 1.9614 0.5 1.74383 0.5C1.52626 0.5 1.31277 0.559078 1.12615 0.670928C0.936296 0.772413 0.777687 0.923716 0.667368 1.10858C0.557048 1.29344 0.499189 1.50486 0.500009 1.72014V12.8214Z" fill="white"/><path d="M11.4946 12.8214C11.4938 13.0367 11.5517 13.2481 11.662 13.433C11.7723 13.6179 11.9309 13.7692 12.1208 13.8706C12.3074 13.9825 12.5209 14.0416 12.7385 14.0416C12.956 14.0416 13.1695 13.9825 13.3561 13.8706L21.9529 8.28615C22.1206 8.17907 22.2586 8.03147 22.3542 7.85697C22.4499 7.68247 22.5 7.48669 22.5 7.28771C22.5 7.08873 22.4499 6.89295 22.3542 6.71845C22.2586 6.54395 22.1206 6.39635 21.9529 6.28927L13.3561 0.670928C13.1695 0.559078 12.956 0.5 12.7385 0.5C12.5209 0.5 12.3074 0.559078 12.1208 0.670928C11.9359 0.769659 11.7806 0.915663 11.6706 1.09404C11.5606 1.27242 11.4999 1.47679 11.4946 1.68629V12.8214Z" fill="white"/><path d="M0.500009 12.8214C0.499189 13.0367 0.557048 13.2481 0.667368 13.433C0.777687 13.6179 0.936296 13.7692 1.12615 13.8706C1.31277 13.9825 1.52626 14.0416 1.74383 14.0416C1.9614 14.0416 2.17489 13.9825 2.36151 13.8706L10.9582 8.28615C11.126 8.17907 11.264 8.03147 11.3596 7.85697C11.4552 7.68247 11.5054 7.48669 11.5054 7.28771C11.5054 7.08873 11.4552 6.89295 11.3596 6.71845C11.264 6.54395 11.126 6.39635 10.9582 6.28927L2.36151 0.670928C2.17489 0.559078 1.9614 0.5 1.74383 0.5C1.52626 0.5 1.31277 0.559078 1.12615 0.670928C0.936296 0.772413 0.777687 0.923716 0.667368 1.10858C0.557048 1.29344 0.499189 1.50486 0.500009 1.72014V12.8214Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4946 12.8214C11.4938 13.0367 11.5517 13.2481 11.662 13.433C11.7723 13.6179 11.9309 13.7692 12.1208 13.8706C12.3074 13.9825 12.5209 14.0416 12.7385 14.0416C12.956 14.0416 13.1695 13.9825 13.3561 13.8706L21.9529 8.28615C22.1206 8.17907 22.2586 8.03147 22.3543 7.85697C22.4499 7.68247 22.5 7.48669 22.5 7.28771C22.5 7.08873 22.4499 6.89295 22.3543 6.71845C22.2586 6.54395 22.1206 6.39635 21.9529 6.28927L13.3561 0.670928C13.1695 0.559078 12.956 0.5 12.7385 0.5C12.5209 0.5 12.3074 0.559078 12.1208 0.670928C11.9359 0.769659 11.7806 0.915663 11.6706 1.09404C11.5606 1.27242 11.4999 1.47679 11.4946 1.68629V12.8214Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    );
    $i = (int) $index;
    if ( isset( $icons[ $i ] ) ) {
        return $icons[ $i ];
    }
    // Default: Häkchen-Kreis
    return '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="11" fill="white" stroke="#1D2E7C"/><path d="M7 12.5l3 3 7-7" stroke="#1D2E7C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}
