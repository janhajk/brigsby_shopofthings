<?php
/**
 * Startseiten-Einstellungen (Theme-Optionen, ohne Plugin)
 *
 * Stellt eine eigene Admin-Seite „Startseite" bereit (WordPress Settings API)
 * und liefert über sot_fp() die Werte für das Startseiten-Template und die
 * Partials. Alle Werte liegen in EINER Option `sot_frontpage` (Array).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================================
   Liste / Beschriftung der Sektionen (Reihenfolge = Default-Reihenfolge)
   ========================================================================== */
function sot_fp_sections() {
    return array(
        'hero'        => 'Hero',
        'zielgruppen' => 'Zielgruppen-Karten',
        'prozess'     => 'Der Weg zum IoT (4 Schritte)',
        'kacheln'     => 'Produkte/Anwendungen-Kacheln (Tabs)',
        'cta'         => 'CTA-Banner',
        'whyus'       => 'Warum ShopOfThings?',
        'partner'     => 'Technologiepartner-Logos',
        'kunden'      => 'Kunden-Logos',
        'stats'       => 'Zahlen / Statistiken',
        'news'        => 'Aktuelles (Blog)',
        'berater'     => 'Berater-CTA',
    );
}

/* ==========================================================================
   Standardwerte (gemäss Figma-Design)
   ========================================================================== */
function sot_fp_defaults() {
    return array(
        'section_order' => array_keys( sot_fp_sections() ),
        'sections'      => array_fill_keys( array_keys( sot_fp_sections() ), 1 ),

        // Hero
        'hero_subtitle'  => 'IoT einfach gemacht – von Sensor bis Cloud.',
        'hero_title'     => 'Ihr Schweizer <span class="highlight">Shop</span><br>für <span class="highlight">IoT</span>-Hardware<br>und Integration.',
        'hero_btn1_text' => 'Produkte entdecken',
        'hero_btn1_url'  => '/produkt-kategorie/typ/nodes/',
        'hero_btn2_text' => 'Projekt starten',
        'hero_btn2_url'  => '#sektion-zielgruppen',
        'hero_image'     => 0,
        'hero_badges'    => array( 'Schweizer Lager', 'Offizieller Distributor', 'Schnelle Lieferung & Support' ),

        // Zielgruppen
        'zg_eyebrow' => 'Für wen ist ShopOfThings?',
        'zg_heading' => 'Wir unterstützen Unternehmen, Integratoren und Entwickler bei jedem Schritt Ihres IoT-Projekts.',
        'zg_cards'   => array(
            array( 'title' => 'Unternehmen & Städte', 'text' => 'End-to-End-Lösungen für Smart-City- und Industrie-Projekte.', 'link_text' => 'Mehr erfahren →', 'url' => '/anwendungen/smart-city/' ),
            array( 'title' => 'Systemintegratoren', 'text' => 'End-to-End-Lösungen für Smart-City- und Industrie-Projekte.', 'link_text' => 'Jetzt entdecken →', 'url' => '/partner/systemintegratoren/' ),
            array( 'title' => 'Techniker & Entwickler', 'text' => 'Prototyping, Tools und Sensoren für Ihre individuellen Anforderungen.', 'link_text' => 'Zum Sortiment →', 'url' => '/produkte/sensoren/' ),
        ),

        // Prozess
        'pr_eyebrow' => 'Der Weg zum IoT – in vier Schritten',
        'pr_heading' => 'Von der Messung bis zur Visualisierung: So bringen wir Ihr IoT-Projekt zum Erfolg.',
        'pr_steps'   => array(
            array( 'title' => 'Sensorik', 'line1' => 'Daten erfassen', 'line2' => 'Hochpräzise Sensoren für alle Anwendungen', 'url' => '/sensorik/' ),
            array( 'title' => 'Connectivity', 'line1' => 'Sichere Datenübertragung', 'line2' => 'LoRaWAN, NB-IoT und weitere Technologien', 'url' => '/konnektivitaet/' ),
            array( 'title' => 'Integration & Visualisierung', 'line1' => 'Analyse & Steuerung', 'line2' => 'Dashboards und Schnittstellen', 'url' => '/integration/' ),
            array( 'title' => 'Installation & Support', 'line1' => 'Fachgerechte Umsetzung', 'line2' => 'Beratung und technischer Support', 'url' => '/support/' ),
        ),

        // Kacheln (Tabs)
        'kacheln_tab1_label' => 'Produkte',
        'kacheln_tab2_label' => 'Anwendungen',
        'kacheln_tab1_cards' => array(
            array( 'title' => 'Sensoren', 'text' => 'Temperatur, Feuchtigkeit, CO2 und mehr', 'btn_text' => 'Sensoren entdecken', 'url' => '/produkt-kategorie/sensorik/', 'image' => 0 ),
            array( 'title' => 'Connectivity', 'text' => 'LoRaWAN, NB-IoT, LTE Gateways', 'btn_text' => 'Konnektivität sichern', 'url' => '/produkt-kategorie/connectivity-2/', 'image' => 0 ),
            array( 'title' => 'Gateways', 'text' => 'Indoor & Outdoor LoRaWAN Gateways', 'btn_text' => 'Gateways entdecken', 'url' => '/produkt-kategorie/typ/gateway/', 'image' => 0 ),
            array( 'title' => 'Zubehör', 'text' => 'Antennen, Kabel, Gehäuse', 'btn_text' => 'Zubehör entdecken', 'url' => '/produkt-kategorie/typ/zubehoer/', 'image' => 0 ),
            array( 'title' => 'Tools', 'text' => 'Entwicklungstools und Software', 'btn_text' => 'Tools entdecken', 'url' => '/produkt-kategorie/prototyping/tools/', 'image' => 0 ),
            array( 'title' => 'Lösungspakete', 'text' => 'Komplette IoT-Lösungen', 'btn_text' => 'Lösungspakete entdecken', 'url' => '/produkt-kategorie/sets/', 'image' => 0 ),
        ),
        'kacheln_tab2_cards' => array(
            array( 'title' => 'Smart Farming', 'text' => 'Sensorik für die Landwirtschaft', 'btn_text' => 'Mehr erfahren', 'url' => '/product-tag/smart-farming/', 'image' => 0 ),
            array( 'title' => 'Smart Metering', 'text' => 'Verbrauch intelligent erfassen', 'btn_text' => 'Mehr erfahren', 'url' => '/product-tag/smart-metering/', 'image' => 0 ),
            array( 'title' => 'Asset Tracking', 'text' => 'Standort & Zustand im Blick', 'btn_text' => 'Mehr erfahren', 'url' => '/product-tag/asset-tracking/', 'image' => 0 ),
        ),

        // CTA-Banner
        'cta_image'     => 0,
        'cta_badge'     => 'Sofort lieferbar',
        'cta_heading'   => 'Bereit, Ihr IoT-Projekt auf das nächste Level zu bringen?',
        'cta_text'      => 'Entdecken Sie unsere beliebtesten Produkte oder sprechen Sie direkt mit einem Experten – wir helfen Ihnen, die passende Lösung zu finden.',
        'cta_btn1_text' => 'Topseller ansehen',
        'cta_btn1_url'  => '/shop/',
        'cta_btn2_text' => 'Beraten lassen',
        'cta_btn2_url'  => '/kontakt/',
        'cta_footnote'  => 'Über 1000+ erfolgreiche IoT-Projekte realisiert',

        // Warum ShopOfThings
        'why_heading' => 'Warum ShopOfThings?',
        'why_items'   => array(
            array( 'icon' => '🏢', 'title' => 'Offizieller Distributor', 'text' => 'Autorisierter Partner führender IoT-Hersteller' ),
            array( 'icon' => '🇨🇭', 'title' => 'Schweizer Lager', 'text' => 'Lieferung innert 48 Stunden in die ganze Schweiz' ),
            array( 'icon' => '📅', 'title' => '7 Jahre Erfahrung im IoT-Markt', 'text' => 'Expertise in LoRaWAN und IoT-Lösungen' ),
            array( 'icon' => '🤝', 'title' => 'Persönlicher Support & Beratung', 'text' => 'Technische Beratung von Experten' ),
            array( 'icon' => '🔧', 'title' => 'End-to-End-Lösungen', 'text' => 'Umfassende Lösungen von Hardware bis Cloud-Integration' ),
            array( 'icon' => '🌿', 'title' => 'Nachhaltiger Versand mit Biobiene®', 'text' => 'Klimaneutraler Versand für eine grüne Zukunft' ),
        ),

        // Partner
        'partner_eyebrow' => 'Unsere Technologiepartner',
        'partner_heading' => 'Wir arbeiten mit führenden Herstellern weltweit zusammen.',
        'partner_logos'   => array(),

        // Kunden
        'kunden_heading' => 'Unsere Kunden vertrauen auf ShopOfThings',
        'kunden_logos'   => array(),

        // Stats
        'stats_heading' => 'Zahlen, die überzeugen',
        'stats_items'   => array(
            array( 'number' => '>50', 'label' => 'Städte vernetzt' ),
            array( 'number' => '>1000', 'label' => 'Produkte ab Lager' ),
            array( 'number' => '7 Jahre', 'label' => 'Erfahrung' ),
            array( 'number' => '96.7%', 'label' => 'LoRaWAN-Abdeckung CH' ),
        ),

        // News
        'news_heading' => 'Aktuelles aus der IoT-Welt',
        'news_count'   => 3,

        // Berater-CTA
        'ber_eyebrow'  => 'Haben Sie ein IoT-Projekt?',
        'ber_heading'  => 'Wir beraten Sie persönlich und finden die passende Lösung – von der Auswahl bis zur Installation.',
        'ber_btn_text' => 'Jetzt Beratung anfordern',
        'ber_btn_url'  => '/kontakt/?angebot=1',
        'ber_photo'    => 0,
        'ber_name'     => 'Jan Schär',
        'ber_role'     => 'IoT Consultant',
        'ber_phone'    => '+41 62 530 48 00',
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
        $opts = array_merge( sot_fp_defaults(), $saved );

        // Sektionen normalisieren: alle bekannten Sektionen müssen in
        // section_order + sections vorhanden sein (auch nach späteren Updates).
        $known = array_keys( sot_fp_sections() );
        $order = array();
        foreach ( (array) $opts['section_order'] as $slug ) {
            if ( in_array( $slug, $known, true ) && ! in_array( $slug, $order, true ) ) {
                $order[] = $slug;
            }
        }
        foreach ( $known as $slug ) {
            if ( ! in_array( $slug, $order, true ) ) {
                $order[] = $slug;
            }
        }
        $opts['section_order'] = $order;
        foreach ( $known as $slug ) {
            if ( ! isset( $opts['sections'][ $slug ] ) ) {
                $opts['sections'][ $slug ] = 1;
            }
        }
    }
    return $opts;
}

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
    add_menu_page( 'Startseite', 'Startseite', 'manage_options', 'sot-frontpage', 'sot_fp_render_page', 'dashicons-admin-home', 3 );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_sot-frontpage' !== $hook ) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'sot-frontpage-admin', get_stylesheet_directory_uri() . '/inc/frontpage/frontpage-admin.js', array( 'jquery', 'jquery-ui-sortable' ), '1.2.0', true );
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

    // Reihenfolge
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
    $out['hero_subtitle']  = sanitize_text_field( $input['hero_subtitle'] ?? '' );
    $out['hero_title']     = wp_kses( $input['hero_title'] ?? '', array( 'span' => array( 'class' => array() ), 'br' => array(), 'strong' => array(), 'em' => array() ) );
    $out['hero_btn1_text'] = sanitize_text_field( $input['hero_btn1_text'] ?? '' );
    $out['hero_btn1_url']  = esc_url_raw( $input['hero_btn1_url'] ?? '' );
    $out['hero_btn2_text'] = sanitize_text_field( $input['hero_btn2_text'] ?? '' );
    $out['hero_btn2_url']  = esc_url_raw( $input['hero_btn2_url'] ?? '' );
    $out['hero_image']     = absint( $input['hero_image'] ?? 0 );
    $out['hero_badges']    = array();
    foreach ( (array) ( $input['hero_badges'] ?? array() ) as $b ) {
        $b = sanitize_text_field( $b );
        if ( '' !== $b ) {
            $out['hero_badges'][] = $b;
        }
    }

    // Zielgruppen
    $out['zg_eyebrow'] = sanitize_text_field( $input['zg_eyebrow'] ?? '' );
    $out['zg_heading'] = sanitize_text_field( $input['zg_heading'] ?? '' );
    $out['zg_cards']   = sot_fp_sanitize_rows( $input['zg_cards'] ?? array(), array( 'title', 'text', 'link_text' ), array( 'url' ) );

    // Prozess
    $out['pr_eyebrow'] = sanitize_text_field( $input['pr_eyebrow'] ?? '' );
    $out['pr_heading'] = sanitize_text_field( $input['pr_heading'] ?? '' );
    $out['pr_steps']   = sot_fp_sanitize_rows( $input['pr_steps'] ?? array(), array( 'title', 'line1', 'line2' ), array( 'url' ) );

    // Kacheln
    $out['kacheln_tab1_label'] = sanitize_text_field( $input['kacheln_tab1_label'] ?? '' );
    $out['kacheln_tab2_label'] = sanitize_text_field( $input['kacheln_tab2_label'] ?? '' );
    $out['kacheln_tab1_cards'] = sot_fp_sanitize_rows( $input['kacheln_tab1_cards'] ?? array(), array( 'title', 'text', 'btn_text' ), array( 'url' ), array( 'image' ) );
    $out['kacheln_tab2_cards'] = sot_fp_sanitize_rows( $input['kacheln_tab2_cards'] ?? array(), array( 'title', 'text', 'btn_text' ), array( 'url' ), array( 'image' ) );

    // CTA
    $out['cta_image']     = absint( $input['cta_image'] ?? 0 );
    $out['cta_badge']     = sanitize_text_field( $input['cta_badge'] ?? '' );
    $out['cta_heading']   = sanitize_text_field( $input['cta_heading'] ?? '' );
    $out['cta_text']      = sanitize_textarea_field( $input['cta_text'] ?? '' );
    $out['cta_btn1_text'] = sanitize_text_field( $input['cta_btn1_text'] ?? '' );
    $out['cta_btn1_url']  = esc_url_raw( $input['cta_btn1_url'] ?? '' );
    $out['cta_btn2_text'] = sanitize_text_field( $input['cta_btn2_text'] ?? '' );
    $out['cta_btn2_url']  = esc_url_raw( $input['cta_btn2_url'] ?? '' );
    $out['cta_footnote']  = sanitize_text_field( $input['cta_footnote'] ?? '' );

    // Warum
    $out['why_heading'] = sanitize_text_field( $input['why_heading'] ?? '' );
    $out['why_items']   = sot_fp_sanitize_rows( $input['why_items'] ?? array(), array( 'icon', 'title', 'text' ), array() );

    // Partner / Kunden
    $out['partner_eyebrow'] = sanitize_text_field( $input['partner_eyebrow'] ?? '' );
    $out['partner_heading'] = sanitize_text_field( $input['partner_heading'] ?? '' );
    $out['partner_logos']   = sot_fp_sanitize_gallery( $input['partner_logos'] ?? array() );
    $out['kunden_heading']  = sanitize_text_field( $input['kunden_heading'] ?? '' );
    $out['kunden_logos']    = sot_fp_sanitize_gallery( $input['kunden_logos'] ?? array() );

    // Stats
    $out['stats_heading'] = sanitize_text_field( $input['stats_heading'] ?? '' );
    $out['stats_items']   = sot_fp_sanitize_rows( $input['stats_items'] ?? array(), array( 'number', 'label' ), array() );

    // News
    $out['news_heading'] = sanitize_text_field( $input['news_heading'] ?? '' );
    $out['news_count']   = max( 1, absint( $input['news_count'] ?? 3 ) );

    // Berater
    $out['ber_eyebrow']  = sanitize_text_field( $input['ber_eyebrow'] ?? '' );
    $out['ber_heading']  = sanitize_text_field( $input['ber_heading'] ?? '' );
    $out['ber_btn_text'] = sanitize_text_field( $input['ber_btn_text'] ?? '' );
    $out['ber_btn_url']  = esc_url_raw( $input['ber_btn_url'] ?? '' );
    $out['ber_photo']    = absint( $input['ber_photo'] ?? 0 );
    $out['ber_name']     = sanitize_text_field( $input['ber_name'] ?? '' );
    $out['ber_role']     = sanitize_text_field( $input['ber_role'] ?? '' );
    $out['ber_phone']    = sanitize_text_field( $input['ber_phone'] ?? '' );

    return $out;
}

function sot_fp_sanitize_rows( $rows, $text_keys, $url_keys, $int_keys = array() ) {
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
        foreach ( $int_keys as $k ) {
            $r[ $k ] = absint( $row[ $k ] ?? 0 );
        }
        $has_content = false;
        foreach ( $text_keys as $k ) {
            if ( '' !== $r[ $k ] ) {
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

/** Galerie sanitisieren: Array von { id, url } (tolerant ggü. altem [int]-Format) */
function sot_fp_sanitize_gallery( $rows ) {
    $clean = array();
    if ( ! is_array( $rows ) ) {
        return $clean;
    }
    foreach ( $rows as $row ) {
        $id = absint( is_array( $row ) ? ( $row['id'] ?? 0 ) : $row );
        if ( ! $id ) {
            continue;
        }
        $clean[] = array(
            'id'  => $id,
            'url' => esc_url_raw( is_array( $row ) ? ( $row['url'] ?? '' ) : '' ),
        );
    }
    return $clean;
}

/* ==========================================================================
   Render-Helfer
   ========================================================================== */
function sot_fp_field_name( $path ) {
    return 'sot_frontpage[' . $path . ']';
}

function sot_fp_text( $key, $label, $value, $placeholder = '' ) {
    printf(
        '<p><label><strong>%s</strong><br><input type="text" name="%s" value="%s" placeholder="%s" class="regular-text" style="width:100%%;max-width:640px"></label></p>',
        esc_html( $label ), esc_attr( sot_fp_field_name( $key ) ), esc_attr( $value ), esc_attr( $placeholder )
    );
}

function sot_fp_textarea( $key, $label, $value, $hint = '' ) {
    printf(
        '<p><label><strong>%s</strong><br><textarea name="%s" rows="3" class="large-text" style="max-width:640px">%s</textarea></label>%s</p>',
        esc_html( $label ), esc_attr( sot_fp_field_name( $key ) ), esc_textarea( $value ),
        $hint ? '<br><span class="description">' . esc_html( $hint ) . '</span>' : ''
    );
}

function sot_fp_number( $key, $label, $value ) {
    printf(
        '<p><label><strong>%s</strong><br><input type="number" min="1" name="%s" value="%s" class="small-text"></label></p>',
        esc_html( $label ), esc_attr( sot_fp_field_name( $key ) ), esc_attr( $value )
    );
}

/** Einzel-Bild-Auswahl (wp.media, einzeln) */
function sot_fp_media_single( $key, $label, $value ) {
    $dom_id = 'sotfp_' . preg_replace( '/[^a-z0-9]+/i', '_', $key );
    $value  = absint( $value );
    $src    = $value ? wp_get_attachment_image_url( $value, 'thumbnail' ) : '';
    echo '<p><strong>' . esc_html( $label ) . '</strong></p>';
    echo '<div class="sot-fp-media" data-multiple="0" data-target="#' . esc_attr( $dom_id ) . '">';
    echo '<input type="hidden" id="' . esc_attr( $dom_id ) . '" name="' . esc_attr( sot_fp_field_name( $key ) ) . '" value="' . esc_attr( $value ) . '">';
    echo '<div class="sot-fp-preview" style="margin:6px 0">' . ( $src ? '<img src="' . esc_url( $src ) . '" style="max-width:140px;height:auto;border:1px solid #dcdcde;border-radius:6px">' : '' ) . '</div>';
    echo '<button type="button" class="button sot-fp-media-add">Bild wählen</button> <button type="button" class="button sot-fp-media-clear">Entfernen</button>';
    echo '</div>';
}

/**
 * Logo-/Bilder-Galerie mit Sortierung (Drag&Drop), Einzel-Entfernen und
 * optionalem Link pro Bild. Speichert je Eintrag { id, url }.
 */
function sot_fp_render_gallery( $key, $items ) {
    ?>
    <div class="sot-fp-gallery" data-key="<?php echo esc_attr( $key ); ?>">
        <ul class="sot-fp-gallery-list" style="list-style:none;margin:0 0 10px;padding:0;display:flex;flex-wrap:wrap;gap:10px">
            <?php foreach ( (array) $items as $i => $it ) :
                $id  = absint( is_array( $it ) ? ( $it['id'] ?? 0 ) : $it );
                $url = is_array( $it ) ? ( $it['url'] ?? '' ) : '';
                if ( ! $id ) { continue; }
                sot_fp_gallery_item( $key, $i, $id, $url );
            endforeach; ?>
        </ul>
        <button type="button" class="button sot-fp-gallery-add">Bilder hinzufügen</button>
        <p class="description">Drag &amp; Drop zum Sortieren · Link pro Bild optional.</p>
    </div>
    <?php
}

function sot_fp_gallery_item( $key, $idx, $id, $url ) {
    $src  = wp_get_attachment_image_url( absint( $id ), 'thumbnail' );
    $base = 'sot_frontpage[' . $key . '][' . $idx . ']';
    ?>
    <li class="sot-fp-gallery-item" style="border:1px solid #dcdcde;border-radius:8px;padding:8px;width:150px;background:#fff">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
            <span class="dashicons dashicons-move sot-fp-gallery-handle" style="cursor:move;color:#888"></span>
            <button type="button" class="button-link sot-fp-gallery-remove" style="color:#b32d2e">Entfernen</button>
        </div>
        <img src="<?php echo esc_url( $src ); ?>" alt="" style="width:100%;height:80px;object-fit:contain;background:#f6f7f7;border-radius:4px">
        <input type="hidden" class="g-id" name="<?php echo esc_attr( $base . '[id]' ); ?>" value="<?php echo esc_attr( absint( $id ) ); ?>">
        <input type="url" class="g-url" name="<?php echo esc_attr( $base . '[url]' ); ?>" value="<?php echo esc_attr( $url ); ?>" placeholder="Link (optional)" style="width:100%;margin-top:6px;font-size:11px">
    </li>
    <?php
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
    $fs       = 'border:1px solid #dcdcde;border-radius:6px;padding:8px 14px;margin-bottom:10px';
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
                    $enabled = ! empty( $o['sections'][ $slug ] ); ?>
                    <li class="sot-fp-sortable-item" data-slug="<?php echo esc_attr( $slug ); ?>" style="background:#fff;border:1px solid #dcdcde;border-radius:6px;padding:10px 12px;margin-bottom:6px;cursor:move;display:flex;align-items:center;gap:10px">
                        <span class="dashicons dashicons-move" style="color:#888"></span>
                        <label style="margin:0"><input type="checkbox" name="<?php echo esc_attr( sot_fp_field_name( 'sections][' . $slug ) ); ?>" value="1" <?php checked( $enabled ); ?>> <strong><?php echo esc_html( $sections[ $slug ] ); ?></strong></label>
                    </li>
                <?php endforeach; ?>
            </ul>

            <hr><h2 class="title">Hero</h2>
            <?php
            sot_fp_text( 'hero_subtitle', 'Subtitle (über dem Titel)', $o['hero_subtitle'] );
            sot_fp_textarea( 'hero_title', 'Titel (HTML erlaubt: <span class="highlight">…</span>, <br>)', $o['hero_title'], 'z. B. Ihr Schweizer <span class="highlight">Shop</span><br>für IoT.' );
            echo '<div style="display:flex;gap:24px;flex-wrap:wrap"><div>';
            sot_fp_text( 'hero_btn1_text', 'Button 1 – Text', $o['hero_btn1_text'] );
            sot_fp_text( 'hero_btn1_url', 'Button 1 – Link', $o['hero_btn1_url'] );
            echo '</div><div>';
            sot_fp_text( 'hero_btn2_text', 'Button 2 – Text', $o['hero_btn2_text'] );
            sot_fp_text( 'hero_btn2_url', 'Button 2 – Link', $o['hero_btn2_url'] );
            echo '</div></div>';
            echo '<p class="description">Tipp: Als Link kannst du auch zu einer Sektion auf der Startseite springen (sanftes Scrollen). Verfügbare Anker: ';
            $anchors = array();
            foreach ( array_keys( sot_fp_sections() ) as $slug ) {
                $anchors[] = '<code>#sektion-' . esc_html( $slug ) . '</code>';
            }
            echo implode( ' ', $anchors ) . '</p>';
            sot_fp_media_single( 'hero_image', 'Hero-Bild (leer = Standardbild des Themes)', $o['hero_image'] );
            echo '<p style="margin-top:16px"><strong>Badges (unter den Buttons)</strong></p>';
            for ( $i = 0; $i < 3; $i++ ) {
                sot_fp_text( 'hero_badges][' . $i, 'Badge ' . ( $i + 1 ), $o['hero_badges'][ $i ] ?? '' );
            }
            ?>

            <hr><h2 class="title">Zielgruppen-Karten</h2>
            <?php
            sot_fp_text( 'zg_eyebrow', 'Kleine Überschrift (Eyebrow)', $o['zg_eyebrow'] );
            sot_fp_textarea( 'zg_heading', 'Grosse Überschrift', $o['zg_heading'] );
            for ( $i = 0; $i < 3; $i++ ) {
                $c = $o['zg_cards'][ $i ] ?? array();
                echo '<fieldset style="' . $fs . '"><legend><strong>Karte ' . ( $i + 1 ) . '</strong></legend>';
                sot_fp_text( 'zg_cards][' . $i . '][title', 'Titel', $c['title'] ?? '' );
                sot_fp_text( 'zg_cards][' . $i . '][text', 'Text', $c['text'] ?? '' );
                sot_fp_text( 'zg_cards][' . $i . '][link_text', 'Link-Text', $c['link_text'] ?? '' );
                sot_fp_text( 'zg_cards][' . $i . '][url', 'Link-Ziel', $c['url'] ?? '' );
                echo '</fieldset>';
            }
            ?>

            <hr><h2 class="title">Der Weg zum IoT (4 Schritte)</h2>
            <?php
            sot_fp_text( 'pr_eyebrow', 'Kleine Überschrift (Eyebrow)', $o['pr_eyebrow'] );
            sot_fp_textarea( 'pr_heading', 'Grosse Überschrift', $o['pr_heading'] );
            for ( $i = 0; $i < 4; $i++ ) {
                $s = $o['pr_steps'][ $i ] ?? array();
                echo '<fieldset style="' . $fs . '"><legend><strong>Schritt ' . ( $i + 1 ) . '</strong></legend>';
                sot_fp_text( 'pr_steps][' . $i . '][title', 'Titel', $s['title'] ?? '' );
                sot_fp_text( 'pr_steps][' . $i . '][line1', 'Untertitel (fett)', $s['line1'] ?? '' );
                sot_fp_text( 'pr_steps][' . $i . '][line2', 'Text', $s['line2'] ?? '' );
                sot_fp_text( 'pr_steps][' . $i . '][url', 'Link-Ziel', $s['url'] ?? '' );
                echo '</fieldset>';
            }
            ?>

            <hr><h2 class="title">Produkte/Anwendungen-Kacheln</h2>
            <?php
            echo '<div style="display:flex;gap:24px;flex-wrap:wrap"><div>';
            sot_fp_text( 'kacheln_tab1_label', 'Tab 1 – Beschriftung', $o['kacheln_tab1_label'] );
            echo '</div><div>';
            sot_fp_text( 'kacheln_tab2_label', 'Tab 2 – Beschriftung', $o['kacheln_tab2_label'] );
            echo '</div></div>';

            foreach ( array( 'kacheln_tab1_cards' => 'Tab 1', 'kacheln_tab2_cards' => 'Tab 2' ) as $field => $tablabel ) {
                echo '<h3>' . esc_html( $tablabel ) . ' – Kacheln</h3>';
                for ( $i = 0; $i < 6; $i++ ) {
                    $c = $o[ $field ][ $i ] ?? array();
                    echo '<fieldset style="' . $fs . '"><legend><strong>Kachel ' . ( $i + 1 ) . '</strong></legend>';
                    sot_fp_text( $field . '][' . $i . '][title', 'Titel', $c['title'] ?? '' );
                    sot_fp_text( $field . '][' . $i . '][text', 'Text', $c['text'] ?? '' );
                    sot_fp_text( $field . '][' . $i . '][btn_text', 'Button-Text', $c['btn_text'] ?? '' );
                    sot_fp_text( $field . '][' . $i . '][url', 'Link-Ziel', $c['url'] ?? '' );
                    sot_fp_media_single( $field . '][' . $i . '][image', 'Bild', $c['image'] ?? 0 );
                    echo '</fieldset>';
                }
            }
            ?>

            <hr><h2 class="title">CTA-Banner</h2>
            <?php
            sot_fp_media_single( 'cta_image', 'Bild (links)', $o['cta_image'] );
            sot_fp_text( 'cta_badge', 'Badge auf dem Bild', $o['cta_badge'] );
            sot_fp_text( 'cta_heading', 'Überschrift', $o['cta_heading'] );
            sot_fp_textarea( 'cta_text', 'Text', $o['cta_text'] );
            echo '<div style="display:flex;gap:24px;flex-wrap:wrap"><div>';
            sot_fp_text( 'cta_btn1_text', 'Button 1 – Text', $o['cta_btn1_text'] );
            sot_fp_text( 'cta_btn1_url', 'Button 1 – Link', $o['cta_btn1_url'] );
            echo '</div><div>';
            sot_fp_text( 'cta_btn2_text', 'Button 2 – Text', $o['cta_btn2_text'] );
            sot_fp_text( 'cta_btn2_url', 'Button 2 – Link', $o['cta_btn2_url'] );
            echo '</div></div>';
            sot_fp_text( 'cta_footnote', 'Fusszeile (mit Häkchen)', $o['cta_footnote'] );
            ?>

            <hr><h2 class="title">Warum ShopOfThings?</h2>
            <?php
            sot_fp_text( 'why_heading', 'Überschrift', $o['why_heading'] );
            for ( $i = 0; $i < 6; $i++ ) {
                $w = $o['why_items'][ $i ] ?? array();
                echo '<fieldset style="' . $fs . '"><legend><strong>Vorteil ' . ( $i + 1 ) . '</strong></legend>';
                sot_fp_text( 'why_items][' . $i . '][icon', 'Icon (Emoji)', $w['icon'] ?? '' );
                sot_fp_text( 'why_items][' . $i . '][title', 'Titel', $w['title'] ?? '' );
                sot_fp_text( 'why_items][' . $i . '][text', 'Text', $w['text'] ?? '' );
                echo '</fieldset>';
            }
            ?>

            <hr><h2 class="title">Technologiepartner-Logos</h2>
            <?php
            sot_fp_text( 'partner_eyebrow', 'Kleine Überschrift (Eyebrow)', $o['partner_eyebrow'] );
            sot_fp_textarea( 'partner_heading', 'Grosse Überschrift', $o['partner_heading'] );
            sot_fp_render_gallery( 'partner_logos', (array) $o['partner_logos'] );
            ?>

            <hr><h2 class="title">Kunden-Logos</h2>
            <?php
            sot_fp_text( 'kunden_heading', 'Überschrift', $o['kunden_heading'] );
            sot_fp_render_gallery( 'kunden_logos', (array) $o['kunden_logos'] );
            ?>

            <hr><h2 class="title">Zahlen / Statistiken</h2>
            <?php
            sot_fp_text( 'stats_heading', 'Überschrift', $o['stats_heading'] );
            for ( $i = 0; $i < 4; $i++ ) {
                $st = $o['stats_items'][ $i ] ?? array();
                echo '<fieldset style="' . $fs . '"><legend><strong>Zahl ' . ( $i + 1 ) . '</strong></legend>';
                sot_fp_text( 'stats_items][' . $i . '][number', 'Zahl (z. B. >50)', $st['number'] ?? '' );
                sot_fp_text( 'stats_items][' . $i . '][label', 'Beschriftung', $st['label'] ?? '' );
                echo '</fieldset>';
            }
            ?>

            <hr><h2 class="title">Aktuelles (Blog)</h2>
            <?php
            sot_fp_text( 'news_heading', 'Überschrift', $o['news_heading'] );
            sot_fp_number( 'news_count', 'Anzahl Beiträge', $o['news_count'] );
            ?>

            <hr><h2 class="title">Berater-CTA</h2>
            <?php
            sot_fp_text( 'ber_eyebrow', 'Kleine Überschrift (Eyebrow)', $o['ber_eyebrow'] );
            sot_fp_textarea( 'ber_heading', 'Überschrift', $o['ber_heading'] );
            echo '<div style="display:flex;gap:24px;flex-wrap:wrap"><div>';
            sot_fp_text( 'ber_btn_text', 'Button – Text', $o['ber_btn_text'] );
            sot_fp_text( 'ber_btn_url', 'Button – Link', $o['ber_btn_url'] );
            echo '</div></div>';
            sot_fp_media_single( 'ber_photo', 'Foto (Berater)', $o['ber_photo'] );
            sot_fp_text( 'ber_name', 'Name', $o['ber_name'] );
            sot_fp_text( 'ber_role', 'Rolle', $o['ber_role'] );
            sot_fp_text( 'ber_phone', 'Telefon', $o['ber_phone'] );
            ?>

            <?php submit_button( 'Startseite speichern' ); ?>
        </form>
    </div>
    <?php
}

/* ==========================================================================
   Hero-Badge-Icons (statische SVGs)
   ========================================================================== */
function sot_fp_badge_icon( $index ) {
    $icons = array(
        '<svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.5 6.62062V22.5706H22.5V6.62062L11.5 0.570618L0.5 6.62062Z" fill="white"/><path d="M4.90015 15.9706V22.5706H11.5001V15.9706H4.90015Z" fill="white"/><path d="M11.5002 15.9706V22.5706H18.1002V15.9706H11.5002Z" fill="white"/><path d="M8.2002 9.37061V15.9706H14.8002V9.37061H8.2002Z" fill="white"/><path d="M0.5 6.62062V22.5706H22.5V6.62062L11.5 0.570618L0.5 6.62062Z" stroke="#1D2E7C"/><path d="M4.90015 15.9706V22.5706H11.5001V15.9706H4.90015Z" stroke="#1D2E7C"/><path d="M11.5002 15.9706V22.5706H18.1002V15.9706H11.5002Z" stroke="#1D2E7C"/><path d="M8.2002 9.37061V15.9706H14.8002V9.37061H8.2002Z" stroke="#1D2E7C"/></svg>',
        '<svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5001 17.7857C22.5001 19.036 22.0034 20.2351 21.1193 21.1192C20.2352 22.0033 19.0361 22.5 17.7858 22.5C16.5355 22.5 15.3364 22.0033 14.4523 21.1192C13.5682 20.2351 13.0715 19.036 13.0715 17.7857C13.0715 16.5354 13.5682 15.3363 14.4523 14.4522C15.3364 13.5681 16.5355 13.0714 17.7858 13.0714C19.0361 13.0714 20.2352 13.5681 21.1193 14.4522C22.0034 15.3363 22.5001 16.5354 22.5001 17.7857Z" fill="white"/><path d="M22.5001 5.21429C22.5001 6.46459 22.0034 7.66369 21.1193 8.54779C20.2352 9.43189 19.0361 9.92857 17.7858 9.92857C16.5355 9.92857 15.3364 9.43189 14.4523 8.54779C13.5682 7.66369 13.0715 6.46459 13.0715 5.21429C13.0715 3.96398 13.5682 2.76488 14.4523 1.88078C15.3364 0.996682 16.5355 0.5 17.7858 0.5C19.0361 0.5 20.2352 0.996682 21.1193 1.88078C22.0034 2.76488 22.5001 3.96398 22.5001 5.21429Z" fill="white"/><path d="M9.92857 11.5001C9.92857 12.7504 9.43189 13.9495 8.54779 14.8336C7.66369 15.7177 6.46459 16.2143 5.21429 16.2143C3.96398 16.2143 2.76488 15.7177 1.88078 14.8336C0.996682 13.9495 0.5 12.7504 0.5 11.5001C0.5 10.2497 0.996682 9.05065 1.88078 8.16655C2.76488 7.28245 3.96398 6.78577 5.21429 6.78577C6.46459 6.78577 7.66369 7.28245 8.54779 8.16655C9.43189 9.05065 9.92857 10.2497 9.92857 11.5001Z" fill="white"/><path d="M9.92857 11.5001C9.92857 12.7504 9.43189 13.9495 8.54779 14.8336C7.66369 15.7177 6.46459 16.2143 5.21429 16.2143C3.96398 16.2143 2.76488 15.7177 1.88078 14.8336C0.996682 13.9495 0.5 12.7504 0.5 11.5001C0.5 10.2497 0.996682 9.05065 1.88078 8.16655C2.76488 7.28245 3.96398 6.78577 5.21429 6.78577C6.46459 6.78577 7.66369 7.28245 8.54779 8.16655C9.43189 9.05065 9.92857 10.2497 9.92857 11.5001Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/><path d="M22.5001 5.21429C22.5001 6.46459 22.0034 7.66369 21.1193 8.54779C20.2352 9.43189 19.0361 9.92857 17.7858 9.92857C16.5355 9.92857 15.3364 9.43189 14.4523 8.54779C13.5682 7.66369 13.0715 6.46459 13.0715 5.21429C13.0715 3.96398 13.5682 2.76488 14.4523 1.88078C15.3364 0.996682 16.5355 0.5 17.7858 0.5C19.0361 0.5 20.2352 0.996682 21.1193 1.88078C22.0034 2.76488 22.5001 3.96398 22.5001 5.21429Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/><path d="M22.5001 17.7857C22.5001 19.036 22.0034 20.2351 21.1193 21.1192C20.2352 22.0033 19.0361 22.5 17.7858 22.5C16.5355 22.5 15.3364 22.0033 14.4523 21.1192C13.5682 20.2351 13.0715 19.036 13.0715 17.7857C13.0715 16.5354 13.5682 15.3363 14.4523 14.4522C15.3364 13.5681 16.5355 13.0714 17.7858 13.0714C19.0361 13.0714 20.2352 13.5681 21.1193 14.4522C22.0034 15.3363 22.5001 16.5354 22.5001 17.7857Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.5681 7.32263L9.43213 9.39116M13.5681 15.6769L9.43213 13.6083" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg width="23" height="15" viewBox="0 0 23 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.500009 12.8214C0.499189 13.0367 0.557048 13.2481 0.667368 13.433C0.777687 13.6179 0.936296 13.7692 1.12615 13.8706C1.31277 13.9825 1.52626 14.0416 1.74383 14.0416C1.9614 14.0416 2.17489 13.9825 2.36151 13.8706L10.9582 8.28615C11.126 8.17907 11.264 8.03147 11.3596 7.85697C11.4552 7.68247 11.5054 7.48669 11.5054 7.28771C11.5054 7.08873 11.4552 6.89295 11.3596 6.71845C11.264 6.54395 11.126 6.39635 10.9582 6.28927L2.36151 0.670928C2.17489 0.559078 1.9614 0.5 1.74383 0.5C1.52626 0.5 1.31277 0.559078 1.12615 0.670928C0.936296 0.772413 0.777687 0.923716 0.667368 1.10858C0.557048 1.29344 0.499189 1.50486 0.500009 1.72014V12.8214Z" fill="white"/><path d="M11.4946 12.8214C11.4938 13.0367 11.5517 13.2481 11.662 13.433C11.7723 13.6179 11.9309 13.7692 12.1208 13.8706C12.3074 13.9825 12.5209 14.0416 12.7385 14.0416C12.956 14.0416 13.1695 13.9825 13.3561 13.8706L21.9529 8.28615C22.1206 8.17907 22.2586 8.03147 22.3542 7.85697C22.4499 7.68247 22.5 7.48669 22.5 7.28771C22.5 7.08873 22.4499 6.89295 22.3542 6.71845C22.2586 6.54395 22.1206 6.39635 21.9529 6.28927L13.3561 0.670928C13.1695 0.559078 12.956 0.5 12.7385 0.5C12.5209 0.5 12.3074 0.559078 12.1208 0.670928C11.9359 0.769659 11.7806 0.915663 11.6706 1.09404C11.5606 1.27242 11.4999 1.47679 11.4946 1.68629V12.8214Z" fill="white"/><path d="M0.500009 12.8214C0.499189 13.0367 0.557048 13.2481 0.667368 13.433C0.777687 13.6179 0.936296 13.7692 1.12615 13.8706C1.31277 13.9825 1.52626 14.0416 1.74383 14.0416C1.9614 14.0416 2.17489 13.9825 2.36151 13.8706L10.9582 8.28615C11.126 8.17907 11.264 8.03147 11.3596 7.85697C11.4552 7.68247 11.5054 7.48669 11.5054 7.28771C11.5054 7.08873 11.4552 6.89295 11.3596 6.71845C11.264 6.54395 11.126 6.39635 10.9582 6.28927L2.36151 0.670928C2.17489 0.559078 1.9614 0.5 1.74383 0.5C1.52626 0.5 1.31277 0.559078 1.12615 0.670928C0.936296 0.772413 0.777687 0.923716 0.667368 1.10858C0.557048 1.29344 0.499189 1.50486 0.500009 1.72014V12.8214Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4946 12.8214C11.4938 13.0367 11.5517 13.2481 11.662 13.433C11.7723 13.6179 11.9309 13.7692 12.1208 13.8706C12.3074 13.9825 12.5209 14.0416 12.7385 14.0416C12.956 14.0416 13.1695 13.9825 13.3561 13.8706L21.9529 8.28615C22.1206 8.17907 22.2586 8.03147 22.3543 7.85697C22.4499 7.68247 22.5 7.48669 22.5 7.28771C22.5 7.08873 22.4499 6.89295 22.3543 6.71845C22.2586 6.54395 22.1206 6.39635 21.9529 6.28927L13.3561 0.670928C13.1695 0.559078 12.956 0.5 12.7385 0.5C12.5209 0.5 12.3074 0.559078 12.1208 0.670928C11.9359 0.769659 11.7806 0.915663 11.6706 1.09404C11.5606 1.27242 11.4999 1.47679 11.4946 1.68629V12.8214Z" stroke="#1D2E7C" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    );
    $i = (int) $index;
    if ( isset( $icons[ $i ] ) ) {
        return $icons[ $i ];
    }
    return '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="11" fill="white" stroke="#1D2E7C"/><path d="M7 12.5l3 3 7-7" stroke="#1D2E7C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}
