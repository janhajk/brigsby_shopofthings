<?php
/**
 * Zusatzreiter je Produkt: Dokumente und Lieferumfang
 * ===================================================
 *
 * DOKUMENTE
 * Haengt an jedes Produkt eine beliebige Liste von Dokumenten (Datenblatt, Decoder,
 * Anleitung, Konformitaetserklaerung ...) und zeigt sie als eigenen Reiter "Dokumente"
 * auf der Produktseite - neben Beschreibung und den technischen Details.
 * Speicherung: Post-Meta `_sot_dokumente` als Array von
 *   [ 'titel' => string, 'url' => string, 'typ' => string, 'hinweis' => string ]
 *
 * LIEFERUMFANG
 * Reiter direkt nach "Dokumente": was tatsaechlich in der Packung liegt.
 * Speicherung: Post-Meta `_sot_lieferumfang` als Array von Zeilen (Strings).
 * WICHTIG: nur befuellen, wenn der Hersteller den Lieferumfang klar und eindeutig
 * angibt. Lieber leer lassen als raten - ein falscher Lieferumfang erzeugt
 * Reklamationen und Retouren.
 *
 * Befuellen laesst sich beides auch per WP-CLI oder Woo-API, z. B.:
 *   wp post meta update <ID> _sot_dokumente '<json>' --format=json
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const SOT_DOKUMENTE_META = '_sot_dokumente';
const SOT_LIEFERUMFANG_META = '_sot_lieferumfang';

/**
 * Gespeicherten Lieferumfang eines Produkts holen (Array von Zeilen).
 *
 * @param int $post_id
 * @return array
 */
function sot_get_lieferumfang( $post_id ) {
    $zeilen = get_post_meta( $post_id, SOT_LIEFERUMFANG_META, true );
    if ( ! is_array( $zeilen ) ) {
        return array();
    }
    return array_values( array_filter( array_map( 'trim', $zeilen ), 'strlen' ) );
}

/**
 * Gespeicherte Dokumente eines Produkts holen (immer ein sauberes Array).
 *
 * @param int $post_id
 * @return array
 */
function sot_get_dokumente( $post_id ) {
    $docs = get_post_meta( $post_id, SOT_DOKUMENTE_META, true );
    if ( ! is_array( $docs ) ) {
        return array();
    }
    // Nur Eintraege mit URL sind sinnvoll; alles andere waere ein toter Listenpunkt.
    return array_values( array_filter( $docs, function ( $d ) {
        return is_array( $d ) && ! empty( $d['url'] );
    } ) );
}

/* ---------------------------------------------------------------------------
 * Backend: Metabox
 * ------------------------------------------------------------------------- */

function sot_dokumente_metabox() {
    add_meta_box(
        'sot_dokumente',
        'Dokumente (Datenblatt, Decoder, Anleitungen)',
        'sot_dokumente_metabox_callback',
        'product',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes_product', 'sot_dokumente_metabox' );

function sot_dokumente_metabox_callback( $post ) {
    $docs = sot_get_dokumente( $post->ID );
    $docs[] = array( 'titel' => '', 'url' => '', 'typ' => '', 'hinweis' => '' ); // eine Leerzeile zum Anhaengen
    wp_nonce_field( 'sot_dokumente_speichern', 'sot_dokumente_nonce' );
    ?>
    <p style="margin-top:0;color:#666">
        Eine Zeile je Dokument. Dateien vorher in die Mediathek laden und die Datei-URL einsetzen -
        oder direkt auf eine Herstellerseite verlinken. Leere Zeilen werden verworfen.
    </p>
    <table class="widefat" id="sot-dokumente-tabelle">
        <thead>
            <tr>
                <th style="width:26%">Titel</th>
                <th style="width:40%">URL</th>
                <th style="width:12%">Typ</th>
                <th style="width:22%">Hinweis (optional)</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ( $docs as $i => $d ) : ?>
            <tr>
                <td><input type="text" style="width:100%" name="sot_dok[<?php echo (int) $i; ?>][titel]"
                           value="<?php echo esc_attr( isset( $d['titel'] ) ? $d['titel'] : '' ); ?>"
                           placeholder="Datenblatt DL-PYR"></td>
                <td><input type="url" style="width:100%" name="sot_dok[<?php echo (int) $i; ?>][url]"
                           value="<?php echo esc_attr( isset( $d['url'] ) ? $d['url'] : '' ); ?>"
                           placeholder="https://..."></td>
                <td><input type="text" style="width:100%" name="sot_dok[<?php echo (int) $i; ?>][typ]"
                           value="<?php echo esc_attr( isset( $d['typ'] ) ? $d['typ'] : '' ); ?>"
                           placeholder="PDF"></td>
                <td><input type="text" style="width:100%" name="sot_dok[<?php echo (int) $i; ?>][hinweis]"
                           value="<?php echo esc_attr( isset( $d['hinweis'] ) ? $d['hinweis'] : '' ); ?>"
                           placeholder="englisch, 12 Seiten"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p>
        <button type="button" class="button" onclick="sotDokZeile()">Zeile hinzufuegen</button>
    </p>
    <script>
    function sotDokZeile() {
        var tbody = document.querySelector('#sot-dokumente-tabelle tbody');
        var zeile = tbody.rows[tbody.rows.length - 1].cloneNode(true);
        var index = tbody.rows.length;
        zeile.querySelectorAll('input').forEach(function (input) {
            input.value = '';
            input.name = input.name.replace(/\[\d+\]/, '[' + index + ']');
        });
        tbody.appendChild(zeile);
    }
    </script>
    <?php
}

function sot_lieferumfang_metabox() {
    add_meta_box(
        'sot_lieferumfang',
        'Lieferumfang (nur bei klarer Herstellerangabe)',
        'sot_lieferumfang_metabox_callback',
        'product',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes_product', 'sot_lieferumfang_metabox' );

function sot_lieferumfang_metabox_callback( $post ) {
    $zeilen = sot_get_lieferumfang( $post->ID );
    wp_nonce_field( 'sot_lieferumfang_speichern', 'sot_lieferumfang_nonce' );
    ?>
    <p style="margin-top:0;color:#666">
        Eine Position je Zeile, so wie sie der Hersteller angibt (z. B. "Sensoreinheit",
        "Nivellierteller mit Libelle", "2 Batterien Typ C"). <strong>Nur ausfuellen, wenn der
        Lieferumfang eindeutig dokumentiert ist</strong> - im Zweifel leer lassen. Ist das Feld
        leer, erscheint der Reiter gar nicht.
    </p>
    <textarea name="sot_lieferumfang" rows="6" style="width:100%;font-family:monospace"
        placeholder="Sensoreinheit&#10;Nivellierteller mit Libelle&#10;5 m Anschlusskabel"><?php
        echo esc_textarea( implode( "\n", $zeilen ) );
    ?></textarea>
    <?php
}

function sot_lieferumfang_speichern( $post_id ) {
    if ( ! isset( $_POST['sot_lieferumfang_nonce'] ) || ! wp_verify_nonce( $_POST['sot_lieferumfang_nonce'], 'sot_lieferumfang_speichern' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $roh    = isset( $_POST['sot_lieferumfang'] ) ? wp_unslash( $_POST['sot_lieferumfang'] ) : '';
    $zeilen = array_values( array_filter( array_map( function ( $z ) {
        return sanitize_text_field( trim( $z ) );
    }, preg_split( '/\r\n|\r|\n/', (string) $roh ) ), 'strlen' ) );

    if ( empty( $zeilen ) ) {
        delete_post_meta( $post_id, SOT_LIEFERUMFANG_META );
    } else {
        update_post_meta( $post_id, SOT_LIEFERUMFANG_META, $zeilen );
    }
}
add_action( 'save_post_product', 'sot_lieferumfang_speichern' );

function sot_dokumente_speichern( $post_id ) {
    if ( ! isset( $_POST['sot_dokumente_nonce'] ) || ! wp_verify_nonce( $_POST['sot_dokumente_nonce'], 'sot_dokumente_speichern' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $sauber = array();
    if ( isset( $_POST['sot_dok'] ) && is_array( $_POST['sot_dok'] ) ) {
        foreach ( wp_unslash( $_POST['sot_dok'] ) as $eintrag ) {
            $url = isset( $eintrag['url'] ) ? esc_url_raw( trim( $eintrag['url'] ) ) : '';
            if ( '' === $url ) {
                continue;
            }
            $titel = isset( $eintrag['titel'] ) ? sanitize_text_field( $eintrag['titel'] ) : '';
            $sauber[] = array(
                'titel'   => '' !== $titel ? $titel : basename( wp_parse_url( $url, PHP_URL_PATH ) ),
                'url'     => $url,
                'typ'     => isset( $eintrag['typ'] ) ? sanitize_text_field( $eintrag['typ'] ) : '',
                'hinweis' => isset( $eintrag['hinweis'] ) ? sanitize_text_field( $eintrag['hinweis'] ) : '',
            );
        }
    }

    if ( empty( $sauber ) ) {
        delete_post_meta( $post_id, SOT_DOKUMENTE_META );
    } else {
        update_post_meta( $post_id, SOT_DOKUMENTE_META, $sauber );
    }
}
add_action( 'save_post_product', 'sot_dokumente_speichern' );

/* ---------------------------------------------------------------------------
 * Frontend: eigener Reiter auf der Produktseite
 * ------------------------------------------------------------------------- */

function sot_dokumente_tab( $tabs ) {
    global $post;
    if ( ! $post ) {
        return $tabs;
    }
    if ( sot_get_dokumente( $post->ID ) ) {
        $tabs['sot_dokumente'] = array(
            'title'    => __( 'Dokumente', 'brigsby' ),
            'priority' => 25,   // nach "Beschreibung" (10), vor "Zusaetzliche Informationen" (30)
            'callback' => 'sot_dokumente_tab_inhalt',
        );
    }
    if ( sot_get_lieferumfang( $post->ID ) ) {
        $tabs['sot_lieferumfang'] = array(
            'title'    => __( 'Lieferumfang', 'brigsby' ),
            'priority' => 26,   // direkt nach "Dokumente"
            'callback' => 'sot_lieferumfang_tab_inhalt',
        );
    }
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'sot_dokumente_tab' );

function sot_lieferumfang_tab_inhalt() {
    global $post;
    $zeilen = sot_get_lieferumfang( $post->ID );
    if ( ! $zeilen ) {
        return;
    }
    echo '<h2>Lieferumfang</h2>';
    echo '<ul class="sot-lieferumfang">';
    foreach ( $zeilen as $z ) {
        echo '<li>' . esc_html( $z ) . '</li>';
    }
    echo '</ul>';
    echo '<p class="sot-lieferumfang-hinweis">Angaben gemaess Hersteller. Batterien, SIM-Karten und '
        . 'Montagematerial sind nur enthalten, wenn sie oben ausdruecklich aufgefuehrt sind.</p>';
}

/**
 * Dateigroesse eines Anhangs aus der Mediathek ermitteln - nur fuer eigene Dateien,
 * externe Links bekommen keine Groessenangabe (kein Remote-Call auf jedem Seitenaufruf).
 */
function sot_dokument_groesse( $url ) {
    $id = attachment_url_to_postid( $url );
    if ( ! $id ) {
        return '';
    }
    $pfad = get_attached_file( $id );
    if ( ! $pfad || ! file_exists( $pfad ) ) {
        return '';
    }
    return size_format( filesize( $pfad ) );
}

function sot_dokumente_tab_inhalt() {
    global $post;
    $docs = sot_get_dokumente( $post->ID );
    if ( ! $docs ) {
        return;
    }

    echo '<h2>Dokumente</h2>';
    echo '<ul class="sot-dokumente">';
    foreach ( $docs as $d ) {
        $typ     = ! empty( $d['typ'] ) ? strtoupper( $d['typ'] ) : strtoupper( pathinfo( wp_parse_url( $d['url'], PHP_URL_PATH ), PATHINFO_EXTENSION ) );
        $groesse = sot_dokument_groesse( $d['url'] );
        $extern  = false === strpos( $d['url'], home_url() );

        $meta = array_filter( array( $typ, $groesse, ! empty( $d['hinweis'] ) ? $d['hinweis'] : '' ) );

        echo '<li>';
        printf(
            '<a href="%s"%s>%s</a>',
            esc_url( $d['url'] ),
            $extern ? ' target="_blank" rel="noopener noreferrer"' : ' download',
            esc_html( $d['titel'] )
        );
        if ( $meta ) {
            echo ' <span class="sot-dokument-meta">' . esc_html( implode( ' · ', $meta ) ) . '</span>';
        }
        echo '</li>';
    }
    echo '</ul>';
}
