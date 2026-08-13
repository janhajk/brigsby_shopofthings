<?php
/**
 * Referenz / Anmerkung an der Bestellung bearbeitbar machen
 * =========================================================
 *
 * Das Feld "Referenz / Anmerkung" stammt aus dem Plugin "Custom Payment Gateways for
 * WooCommerce" (Praefix alg_wc_cpg). Beim Checkout mit der Zahlungsart
 * "Rechnung / Invoice" (alg_custom_gateway_1) tippt der Kunde dort z. B. seine
 * Bestellnummer oder eine Kostenstelle ein.
 *
 * Gespeichert wird es als Order-Meta `_alg_wc_cpg_input_fields`, und zwar als Array,
 * dessen SCHLUESSEL der Feldname ist:
 *   array( 'Referenz / Anmerkung' => 'Alex' )
 *
 * Das Plugin zeigt dieses Meta im Bestell-Editor nur LESEND an - und auch nur dann,
 * wenn schon ein Wert existiert. Bei manuell im Backend angelegten Bestellungen gibt
 * es also gar kein Feld. Diese Datei ersetzt die Plugin-Box durch eine eigene,
 * beschreibbare Metabox in der Seitenleiste des Bestell-Editors.
 *
 * Bewusst NICHT im Plugin gepatcht - ein Plugin-Update wuerde das ueberschreiben.
 *
 * Funktioniert mit klassischer Speicherung (Post-Meta) und mit HPOS, weil
 * durchgehend ueber die WC_Order-API ($order->get_meta()/update_meta_data()) gelesen
 * und geschrieben wird.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const SOT_CPG_FELDER_META = '_alg_wc_cpg_input_fields';

/** Fallback-Feldname, falls in den Gateway-Einstellungen (noch) nichts konfiguriert ist. */
const SOT_CPG_STANDARDFELD = 'Referenz / Anmerkung';

/* ---------------------------------------------------------------------------
 * Hilfsfunktionen
 * ------------------------------------------------------------------------- */

/**
 * Bestell-Objekt aus dem holen, was WordPress der Metabox-Callback uebergibt:
 * klassisch ein WP_Post, unter HPOS direkt ein WC_Order.
 *
 * @param WP_Post|WC_Order $post_oder_order
 * @return WC_Order|false
 */
function sot_cpg_order_holen( $post_oder_order ) {
    if ( $post_oder_order instanceof WC_Order ) {
        return $post_oder_order;
    }
    if ( $post_oder_order instanceof WP_Post ) {
        return wc_get_order( $post_oder_order->ID );
    }
    return false;
}

/**
 * Gespeicherte Eingabefelder einer Bestellung (immer ein sauberes Array).
 *
 * @param WC_Order $order
 * @return array<string,string>
 */
function sot_cpg_werte( $order ) {
    $werte = $order->get_meta( SOT_CPG_FELDER_META, true );
    return is_array( $werte ) ? $werte : array();
}

/**
 * Alle in den Gateway-Einstellungen konfigurierten Feldnamen einsammeln.
 *
 * Das Plugin legt seine Felder je Zahlungsart in den WooCommerce-Gateway-Optionen ab
 * (`input_fields_total` + `input_fields_title_1..n`). Wir lesen sie aus, damit die
 * Metabox bei einer frisch angelegten Bestellung schon das richtige Feld anbietet -
 * und nicht ein hart verdrahteter Name verwendet wird, der spaeter mal abweicht.
 *
 * Die Zahlungsart der Bestellung kommt zuerst, danach die uebrigen Custom-Gateways.
 *
 * @param WC_Order|false $order
 * @return string[]
 */
function sot_cpg_konfigurierte_feldnamen( $order = false ) {
    $gateway_ids = array();

    if ( $order && 0 === strpos( (string) $order->get_payment_method(), 'alg_custom_gateway_' ) ) {
        $gateway_ids[] = $order->get_payment_method();
    }
    // Die Custom-Gateways heissen durchgaengig alg_custom_gateway_1..n.
    for ( $i = 1; $i <= 20; $i++ ) {
        $gateway_ids[] = 'alg_custom_gateway_' . $i;
    }

    $namen = array();
    foreach ( array_unique( $gateway_ids ) as $id ) {
        $settings = get_option( 'woocommerce_' . $id . '_settings' );
        if ( ! is_array( $settings ) || empty( $settings['input_fields_total'] ) ) {
            continue;
        }
        $total = (int) $settings['input_fields_total'];
        for ( $n = 1; $n <= $total; $n++ ) {
            $titel = isset( $settings[ 'input_fields_title_' . $n ] ) ? trim( (string) $settings[ 'input_fields_title_' . $n ] ) : '';
            if ( '' !== $titel ) {
                $namen[] = $titel;
            }
        }
    }

    if ( ! $namen ) {
        $namen[] = SOT_CPG_STANDARDFELD;
    }
    return array_values( array_unique( $namen ) );
}

/**
 * Welche Feldnamen darf die Metabox anzeigen bzw. speichern?
 *
 * Bereits gespeicherte Schluessel bleiben immer erhalten (auch wenn sie in den
 * Gateway-Einstellungen zwischenzeitlich umbenannt wurden), dazu kommen die aktuell
 * konfigurierten Feldnamen. Diese Liste dient beim Speichern zugleich als Whitelist,
 * damit ueber das Formular keine beliebigen Meta-Schluessel angelegt werden koennen.
 *
 * @param WC_Order $order
 * @return string[]
 */
function sot_cpg_erlaubte_feldnamen( $order ) {
    $namen = array_keys( sot_cpg_werte( $order ) );
    foreach ( sot_cpg_konfigurierte_feldnamen( $order ) as $name ) {
        if ( ! in_array( $name, $namen, true ) ) {
            $namen[] = $name;
        }
    }
    return $namen;
}

/* ---------------------------------------------------------------------------
 * Backend: Metabox im Bestell-Editor
 * ------------------------------------------------------------------------- */

/**
 * Screen-ID des Bestell-Editors - unter HPOS eine andere als beim klassischen CPT.
 *
 * @return string
 */
function sot_cpg_order_screen() {
    if ( class_exists( '\Automattic\WooCommerce\Utilities\OrderUtil' )
        && \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled() ) {
        return wc_get_page_screen_id( 'shop-order' );
    }
    return 'shop_order';
}

/**
 * Eigene Metabox registrieren - und die rein lesende des Plugins entfernen,
 * damit im Editor nicht zweimal dasselbe steht.
 */
function sot_cpg_metabox( $post_type = '', $post = null ) {
    if ( ! function_exists( 'wc_get_order' ) ) {
        return;
    }
    $screen = sot_cpg_order_screen();
    if ( $post_type !== $screen && 'shop_order' !== $post_type ) {
        return;
    }

    // Lesende Plugin-Box "Payment gateway input fields" ausblenden (Plugin bleibt unangetastet).
    remove_meta_box( 'alg-wc-cpg-input-fields', $screen, 'side' );

    add_meta_box(
        'sot_bestellung_referenz',
        'Referenz / Anmerkung',
        'sot_cpg_metabox_callback',
        $screen,
        'side',
        'high'
    );
}
// Prioritaet 100: erst laufen lassen, wenn das Plugin seine Box registriert hat.
add_action( 'add_meta_boxes', 'sot_cpg_metabox', 100, 2 );

function sot_cpg_metabox_callback( $post_oder_order ) {
    $order = sot_cpg_order_holen( $post_oder_order );
    if ( ! $order ) {
        return;
    }

    $werte  = sot_cpg_werte( $order );
    $felder = sot_cpg_erlaubte_feldnamen( $order );

    wp_nonce_field( 'sot_cpg_speichern', 'sot_cpg_nonce' );
    ?>
    <p style="margin-top:0;color:#666">
        Angabe des Kunden aus dem Checkout (Zahlungsart „Rechnung / Invoice").
        Hier auch bei manuell erfassten Bestellungen nachtragbar - erscheint auf
        Bestellbestaetigung und in der Kundenansicht.
    </p>
    <?php foreach ( $felder as $i => $name ) :
        $wert = isset( $werte[ $name ] ) ? (string) $werte[ $name ] : '';
        ?>
        <p style="margin-bottom:12px">
            <label for="sot-cpg-<?php echo (int) $i; ?>" style="display:block;font-weight:600;margin-bottom:3px">
                <?php echo esc_html( $name ); ?>
            </label>
            <input type="hidden" name="sot_cpg[<?php echo (int) $i; ?>][feld]" value="<?php echo esc_attr( $name ); ?>">
            <input type="text" class="widefat" id="sot-cpg-<?php echo (int) $i; ?>"
                   name="sot_cpg[<?php echo (int) $i; ?>][wert]"
                   value="<?php echo esc_attr( $wert ); ?>"
                   placeholder="z. B. Bestellnummer oder Kostenstelle des Kunden">
        </p>
    <?php endforeach; ?>
    <?php
}

/* ---------------------------------------------------------------------------
 * Speichern
 * ------------------------------------------------------------------------- */

/**
 * Wird beim Speichern einer Bestellung im Backend aufgerufen (klassisch wie HPOS).
 *
 * Bestehende Werte im Array bleiben erhalten; nur die im Formular uebermittelten
 * Schluessel werden ueberschrieben.
 *
 * @param int $order_id
 */
function sot_cpg_speichern( $order_id ) {
    if ( ! isset( $_POST['sot_cpg_nonce'] ) || ! wp_verify_nonce( $_POST['sot_cpg_nonce'], 'sot_cpg_speichern' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_shop_orders' ) ) {
        return;
    }
    if ( ! isset( $_POST['sot_cpg'] ) || ! is_array( $_POST['sot_cpg'] ) ) {
        return;
    }

    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }

    $vorher   = sot_cpg_werte( $order );
    $werte    = $vorher;
    $erlaubte = sot_cpg_erlaubte_feldnamen( $order );

    foreach ( wp_unslash( $_POST['sot_cpg'] ) as $eintrag ) {
        if ( ! is_array( $eintrag ) || ! isset( $eintrag['feld'] ) ) {
            continue;
        }
        $feld = sanitize_text_field( $eintrag['feld'] );
        // Nur bekannte Feldnamen - kein Anlegen beliebiger Schluessel ueber das Formular.
        if ( ! in_array( $feld, $erlaubte, true ) ) {
            continue;
        }
        $werte[ $feld ] = isset( $eintrag['wert'] ) ? sanitize_text_field( $eintrag['wert'] ) : '';
    }

    // Nichts eingetragen und vorher gab es auch nichts: kein leeres Meta anlegen.
    if ( ! $vorher && '' === implode( '', array_map( 'strval', $werte ) ) ) {
        return;
    }
    if ( $werte === $vorher ) {
        return;
    }

    $order->update_meta_data( SOT_CPG_FELDER_META, $werte );
    $order->save();
}
add_action( 'woocommerce_process_shop_order_meta', 'sot_cpg_speichern', 20 );
