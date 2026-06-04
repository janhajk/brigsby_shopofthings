<?php
/**
 * Menü-Einstellungen (eigenes Mega-Menü, ohne Plugin)
 *
 * Dedizierte Admin-Seite „Menü" (Settings API). Speichert die komplette
 * Navigationsstruktur in EINER Option `sot_menu` und liefert sie über
 * sot_menu() an das Header-Template.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SOT_MENU_MAX_ITEMS', 7 );   // Top-Level-Punkte
define( 'SOT_MENU_MAX_GROUPS', 4 );  // Gruppen-Kacheln je Mega-Panel

/* ==========================================================================
   Defaults – übernommen aus der Menüstruktur von shopofthings.ch
   ========================================================================== */
function sot_menu_defaults() {
    return array(
        'items' => array(

            // 1) Produkte – Mega-Panel
            array(
                'type'   => 'mega',
                'label'  => 'Produkte',
                'url'    => '',
                'groups' => array(
                    array(
                        'icon'  => 0,
                        'label' => 'Nach Produkttyp',
                        'url'   => '/produkt-kategorie/typ/',
                        'links' => "Aktoren | /produkt-kategorie/typ/aktoren-typ/\nAntennen | /produkt-kategorie/typ/antennen/\nBridges / Converters | /produkt-kategorie/typ/bridges/\nEdge / AI | /produkt-kategorie/typ/edge-ai-machine-learning\nGateways | /produkt-kategorie/typ/gateway/\nNodes / Sensoren | /produkt-kategorie/typ/nodes/\nSchalter | /produkt-kategorie/typ/schalter/\nSoftware + Plattformen | /produkt-kategorie/typ/software-und-plattformen/\nSurveillance | /produkt-kategorie/typ/kameras/\nTracker | /produkt-kategorie/typ/tracker/\nZubehör | /produkt-kategorie/typ/zubehoer/",
                    ),
                    array(
                        'icon'  => 0,
                        'label' => 'Nach Sensorik',
                        'url'   => '/produkt-kategorie/sensorik/',
                        'links' => "Beschleunigung | /produkt-kategorie/sensorik/beschleunigung/\nGase | /produkt-kategorie/sensorik/sensorik-gase/\nLuftfeuchtigkeit | /produkt-kategorie/sensorik/sensorik-luftfeuchtigkeit/\nBewegung | /produkt-kategorie/sensorik/sensorik-bewegung/\nGeräusch | /produkt-kategorie/sensorik/sensorik-geraeusch/\nParksensorik | /produkt-kategorie/sensorik/sensorik-parksensorik/\nBodenfeuchte | /produkt-kategorie/sensorik/sensorik-bodenfeuchte/\nGPS | /produkt-kategorie/sensorik/sensorik-gps/\nRelais | /produkt-kategorie/sensorik/sensorik-relais/\nDistanz | /produkt-kategorie/sensorik/sensorik-distanz/\nStrom | /produkt-kategorie/sensorik/sensorik-strom/\nFeinstaub | /produkt-kategorie/sensorik/sensorik-feinstaub/\nLicht | /produkt-kategorie/sensorik/sensorik-licht/\nTemperatur | /produkt-kategorie/sensorik/sensorik-temperatur/\nLuftdruck | /produkt-kategorie/sensorik/sensorik-luftdruck/\nVOC | /produkt-kategorie/sensorik/sensorik-voc/",
                    ),
                    array(
                        'icon'  => 0,
                        'label' => 'Nach Konnektivität',
                        'url'   => '/produkt-kategorie/connectivity-2/',
                        'links' => "LoRaWAN | /produkt-kategorie/connectivity-2/connectivity-lorawan/\n4/5G, NB-IoT, LTE-M | /produkt-kategorie/connectivity-2/5g-nb-iot-lte-m/\nmioty | /produkt-kategorie/connectivity-2/mioty\nSigfox | /produkt-kategorie/connectivity-2/connectivity-sigfox/\nModbus | /produkt-kategorie/connectivity-2/connectivity-modbus/\nLAN | /produkt-kategorie/connectivity-2/connectivity-lan/\nMeshtastic | /produkt-kategorie/connectivity-2/meshtastic/",
                    ),
                    array(
                        'icon'  => 0,
                        'label' => 'Nach Hersteller',
                        'url'   => '/produkt-kategorie/brands/',
                        'links' => "abeeway | /produkt-kategorie/brands/abeeway/\nadeunis | /produkt-kategorie/brands/adeunis/\nArduino | /produkt-kategorie/brands/arduino/\nBosch | /produkt-kategorie/brands/bosch/\nDecentlab | /produkt-kategorie/brands/decentlab/\nElsys | /produkt-kategorie/brands/elsys/\nMilesight | /produkt-kategorie/brands/milesight/\nRAKwireless | /produkt-kategorie/brands/rakwireless/\nTektelic | /produkt-kategorie/brands/tektelic/\nAlle Hersteller | /produkt-kategorie/brands/",
                    ),
                ),
                'featured' => array(
                    'image'   => 0,
                    'eyebrow' => 'Top Seller',
                    'title'   => 'Milesight WS101 LoRaWAN Smart Red SOS Button',
                    'url'     => '/shop/sensorik/button/milesight-ws101-lorawan-smart-red-button/',
                ),
                'cta'   => array( 'label' => 'Für Prototyping', 'url' => '/produkt-kategorie/prototyping/' ),
                'links' => '',
            ),

            // 2) Anwendungen – Dropdown
            array(
                'type'   => 'dropdown',
                'label'  => 'Anwendungen',
                'url'    => '',
                'groups' => array(),
                'featured' => array(),
                'cta'    => array(),
                'links'  => "Smart Farming | /product-tag/smart-farming/\nSmart Metering | /product-tag/smart-metering/\nAsset Tracking | /product-tag/asset-tracking/",
            ),

            // 3) Lösungen – Dropdown
            array(
                'type'   => 'dropdown',
                'label'  => 'Lösungen',
                'url'    => '',
                'groups' => array(),
                'featured' => array(),
                'cta'    => array(),
                'links'  => "Projekt starten | /projekt-starten/\nIntegration & Steuerung | /integration/\nBeratung & Support | /support/",
            ),

            // 4) Partner – einfacher Link
            array(
                'type'   => 'link',
                'label'  => 'Partner',
                'url'    => '/partner-werden/',
                'groups' => array(),
                'featured' => array(),
                'cta'    => array(),
                'links'  => '',
            ),

            // 5) Unternehmen – Dropdown
            array(
                'type'   => 'dropdown',
                'label'  => 'Unternehmen',
                'url'    => '',
                'groups' => array(),
                'featured' => array(),
                'cta'    => array(),
                'links'  => "Über uns | /ueber-uns/\nBlog | /blog/\nNachhaltigkeit | /nachhaltigkeit/\nImpressum | /impressum/",
            ),

            // 6) Support – Dropdown
            array(
                'type'   => 'dropdown',
                'label'  => 'Support',
                'url'    => '',
                'groups' => array(),
                'featured' => array(),
                'cta'    => array(),
                'links'  => "Kontakt | /kontakt/\nVersand & Rückgabe | /lieferung-und-versandkosten/\nAGB | /agb/\nDatenschutz | /privacy/",
            ),
        ),
    );
}

/* ==========================================================================
   Accessor
   ========================================================================== */
function sot_menu() {
    static $o = null;
    if ( null === $o ) {
        $saved = get_option( 'sot_menu', null );
        $o     = ( is_array( $saved ) && ! empty( $saved['items'] ) ) ? $saved : sot_menu_defaults();
    }
    return $o;
}

/** Standard-Icon (blaues Abzeichen) für Gruppen ohne eigenes Bild */
function sot_menu_default_icon() {
    return '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#1d2e7c" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M8.5 13.5 7 22l5-3 5 3-1.5-8.5"/></svg>';
}

/** "Label | URL"-Zeilen in [ [label,url], … ] umwandeln */
function sot_menu_parse_links( $raw ) {
    $out = array();
    foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw ) as $line ) {
        $line = trim( $line );
        if ( '' === $line ) {
            continue;
        }
        $parts = explode( '|', $line, 2 );
        $label = trim( $parts[0] );
        $url   = isset( $parts[1] ) ? trim( $parts[1] ) : '';
        if ( '' !== $label ) {
            $out[] = array( 'label' => $label, 'url' => $url );
        }
    }
    return $out;
}

/* ==========================================================================
   Registrierung + Admin-Menü
   ========================================================================== */
add_action( 'admin_init', function () {
    register_setting( 'sot_menu_group', 'sot_menu', array(
        'type'              => 'array',
        'sanitize_callback' => 'sot_menu_sanitize',
        'default'           => array(),
    ) );
} );

add_action( 'admin_menu', function () {
    add_menu_page( 'Menü', 'Menü', 'manage_options', 'sot-menu', 'sot_menu_render_page', 'dashicons-menu-alt', 4 );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_sot-menu' !== $hook ) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'sot-menu-admin', get_stylesheet_directory_uri() . '/inc/menu/menu-admin.js', array( 'jquery', 'jquery-ui-sortable' ), '1.0.0', true );
} );

/* ==========================================================================
   Sanitisierung
   ========================================================================== */
function sot_menu_sanitize( $input ) {
    $out = array( 'items' => array() );
    if ( empty( $input['items'] ) || ! is_array( $input['items'] ) ) {
        return $out;
    }

    foreach ( $input['items'] as $item ) {
        if ( ! is_array( $item ) ) {
            continue;
        }
        $label = sanitize_text_field( $item['label'] ?? '' );
        if ( '' === $label ) {
            continue; // leere Slots überspringen
        }
        $type = in_array( ( $item['type'] ?? '' ), array( 'mega', 'dropdown', 'link' ), true ) ? $item['type'] : 'dropdown';

        $groups = array();
        if ( ! empty( $item['groups'] ) && is_array( $item['groups'] ) ) {
            foreach ( $item['groups'] as $g ) {
                if ( ! is_array( $g ) ) {
                    continue;
                }
                $glabel = sanitize_text_field( $g['label'] ?? '' );
                if ( '' === $glabel ) {
                    continue;
                }
                $groups[] = array(
                    'icon'  => absint( $g['icon'] ?? 0 ),
                    'label' => $glabel,
                    'url'   => esc_url_raw( $g['url'] ?? '' ),
                    'links' => sanitize_textarea_field( $g['links'] ?? '' ),
                );
            }
        }

        $featured = array(
            'image'   => absint( $item['featured']['image'] ?? 0 ),
            'eyebrow' => sanitize_text_field( $item['featured']['eyebrow'] ?? '' ),
            'title'   => sanitize_text_field( $item['featured']['title'] ?? '' ),
            'url'     => esc_url_raw( $item['featured']['url'] ?? '' ),
        );

        $cta = array(
            'label' => sanitize_text_field( $item['cta']['label'] ?? '' ),
            'url'   => esc_url_raw( $item['cta']['url'] ?? '' ),
        );

        $out['items'][] = array(
            'type'     => $type,
            'label'    => $label,
            'url'      => esc_url_raw( $item['url'] ?? '' ),
            'groups'   => $groups,
            'featured' => $featured,
            'cta'      => $cta,
            'links'    => sanitize_textarea_field( $item['links'] ?? '' ),
        );
    }

    return $out;
}

/* ==========================================================================
   Render-Helfer
   ========================================================================== */
function sot_menu_field( $path ) {
    return 'sot_menu[' . $path . ']';
}

function sot_menu_text( $key, $label, $value, $ph = '' ) {
    printf(
        '<p style="margin:6px 0"><label><strong>%s</strong><br><input type="text" name="%s" value="%s" placeholder="%s" style="width:100%%;max-width:560px"></label></p>',
        esc_html( $label ), esc_attr( sot_menu_field( $key ) ), esc_attr( $value ), esc_attr( $ph )
    );
}

function sot_menu_links_area( $key, $label, $value ) {
    printf(
        '<p style="margin:6px 0"><label><strong>%s</strong><br><textarea name="%s" rows="5" style="width:100%%;max-width:560px;font-family:monospace;font-size:12px" placeholder="Bezeichnung | /pfad/">%s</textarea></label><br><span class="description">Eine Zeile pro Link: <code>Bezeichnung | /link-pfad/</code></span></p>',
        esc_html( $label ), esc_attr( sot_menu_field( $key ) ), esc_textarea( $value )
    );
}

function sot_menu_media( $key, $label, $value ) {
    $dom = 'sotmenu_' . preg_replace( '/[^a-z0-9]+/i', '_', $key );
    $val = absint( $value );
    $src = $val ? wp_get_attachment_image_url( $val, 'thumbnail' ) : '';
    echo '<p style="margin:6px 0"><strong>' . esc_html( $label ) . '</strong></p>';
    echo '<div class="sot-menu-media" data-target="#' . esc_attr( $dom ) . '">';
    echo '<input type="hidden" id="' . esc_attr( $dom ) . '" name="' . esc_attr( sot_menu_field( $key ) ) . '" value="' . esc_attr( $val ) . '">';
    echo '<div class="sot-menu-preview" style="margin:6px 0">' . ( $src ? '<img src="' . esc_url( $src ) . '" style="max-width:90px;height:auto;border:1px solid #dcdcde;border-radius:6px">' : '' ) . '</div>';
    echo '<button type="button" class="button sot-menu-media-add">Bild wählen</button> <button type="button" class="button sot-menu-media-clear">Entfernen</button>';
    echo '</div>';
}

/* ==========================================================================
   Render – Admin-Seite
   ========================================================================== */
function sot_menu_render_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $o     = sot_menu();
    $items = isset( $o['items'] ) ? array_values( (array) $o['items'] ) : array();
    $fs    = 'border:1px solid #c3c4c7;border-radius:8px;padding:10px 16px;margin:0 0 14px;background:#fff';
    ?>
    <div class="wrap sot-menu-admin">
        <h1>Menü</h1>
        <p class="description">Hauptnavigation aufbauen. Ziehe die Punkte am <span class="dashicons dashicons-move"></span>-Griff, um sie zu sortieren. Pro Punkt einen Typ wählen: <strong>Mega-Panel</strong> (Gruppen + Top-Seller), <strong>Dropdown</strong> (einfache Linkliste) oder <strong>Link</strong> (direkter Link). Leere Punkte (ohne Bezeichnung) werden nicht angezeigt.</p>

        <form method="post" action="options.php">
            <?php settings_fields( 'sot_menu_group' ); ?>

            <ul id="sot-menu-items" style="list-style:none;margin:0;padding:0;max-width:760px">
                <?php
                for ( $i = 0; $i < SOT_MENU_MAX_ITEMS; $i++ ) :
                    $it    = $items[ $i ] ?? array();
                    $type  = $it['type'] ?? 'dropdown';
                    $base  = 'items][' . $i;
                    ?>
                    <li class="sot-menu-item" style="<?php echo esc_attr( $fs ); ?>">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                            <span class="dashicons dashicons-move sot-menu-handle" style="cursor:move;color:#888"></span>
                            <input type="text" name="<?php echo esc_attr( sot_menu_field( $base . '][label' ) ); ?>" value="<?php echo esc_attr( $it['label'] ?? '' ); ?>" placeholder="Bezeichnung (leer = ausgeblendet)" style="font-weight:600;flex:1">
                            <select name="<?php echo esc_attr( sot_menu_field( $base . '][type' ) ); ?>" class="sot-menu-type">
                                <option value="mega" <?php selected( $type, 'mega' ); ?>>Mega-Panel</option>
                                <option value="dropdown" <?php selected( $type, 'dropdown' ); ?>>Dropdown</option>
                                <option value="link" <?php selected( $type, 'link' ); ?>>Link</option>
                            </select>
                        </div>

                        <div class="sot-menu-pane sot-menu-pane-link">
                            <?php sot_menu_text( $base . '][url', 'Link-Ziel (für Typ „Link" oder optional als Haupt-Link)', $it['url'] ?? '' ); ?>
                        </div>

                        <div class="sot-menu-pane sot-menu-pane-dropdown">
                            <?php sot_menu_links_area( $base . '][links', 'Dropdown-Links', $it['links'] ?? '' ); ?>
                        </div>

                        <div class="sot-menu-pane sot-menu-pane-mega">
                            <p style="margin:10px 0 4px"><strong>Gruppen-Kacheln (links im Panel)</strong></p>
                            <?php for ( $g = 0; $g < SOT_MENU_MAX_GROUPS; $g++ ) :
                                $grp  = $it['groups'][ $g ] ?? array();
                                $gbase = $base . '][groups][' . $g; ?>
                                <fieldset style="border:1px dashed #c3c4c7;border-radius:6px;padding:8px 12px;margin:0 0 8px">
                                    <legend>Gruppe <?php echo (int) ( $g + 1 ); ?></legend>
                                    <?php
                                    sot_menu_text( $gbase . '][label', 'Titel', $grp['label'] ?? '' );
                                    sot_menu_text( $gbase . '][url', 'Titel-Link (optional)', $grp['url'] ?? '' );
                                    sot_menu_media( $gbase . '][icon', 'Icon-Bild', $grp['icon'] ?? 0 );
                                    sot_menu_links_area( $gbase . '][links', 'Links dieser Gruppe', $grp['links'] ?? '' );
                                    ?>
                                </fieldset>
                            <?php endfor; ?>

                            <p style="margin:10px 0 4px"><strong>Top-Seller-Karte (rechts im Panel)</strong></p>
                            <?php
                            sot_menu_text( $base . '][featured][eyebrow', 'Kleine Überschrift', $it['featured']['eyebrow'] ?? '' );
                            sot_menu_text( $base . '][featured][title', 'Titel', $it['featured']['title'] ?? '' );
                            sot_menu_text( $base . '][featured][url', 'Link', $it['featured']['url'] ?? '' );
                            sot_menu_media( $base . '][featured][image', 'Bild', $it['featured']['image'] ?? 0 );
                            ?>

                            <p style="margin:10px 0 4px"><strong>CTA-Pill (unten links im Panel)</strong></p>
                            <?php
                            sot_menu_text( $base . '][cta][label', 'Text', $it['cta']['label'] ?? '' );
                            sot_menu_text( $base . '][cta][url', 'Link', $it['cta']['url'] ?? '' );
                            ?>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>

            <?php submit_button( 'Menü speichern' ); ?>
        </form>
    </div>

    <style>
        .sot-menu-admin .sot-menu-pane { display:none; padding-left:28px; }
        .sot-menu-admin .sot-menu-item[data-type="link"] .sot-menu-pane-link,
        .sot-menu-admin .sot-menu-item[data-type="dropdown"] .sot-menu-pane-dropdown,
        .sot-menu-admin .sot-menu-item[data-type="mega"] .sot-menu-pane-mega { display:block; }
    </style>
    <?php
}
