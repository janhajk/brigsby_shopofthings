<?php
/**
 * ShopOfThings – allgemeine Einstellungen (eigene Admin-Seite) + Widgets.
 * Aktuell: B2B-/Export-Box (ersetzt den alten „Non-EU B2B"-Block),
 * pflegbar hier und als Widget einfügbar.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================================
   Option + Defaults
   ========================================================================== */
function sot_settings_defaults() {
    return array(
        'b2b_enabled'  => 1,
        'b2b_title'    => 'Geschäftskunden & Export',
        'b2b_text'     => 'B2B-Bestellungen und Versand in ganz Europa – unkompliziert auf Anfrage.',
        'b2b_btn_text' => 'Mehr erfahren',
        'b2b_btn_url'  => '/kontakt/',
    );
}

function sot_settings_get( $key, $fallback = '' ) {
    static $o = null;
    if ( null === $o ) {
        $saved = get_option( 'sot_settings', array() );
        $o     = array_merge( sot_settings_defaults(), is_array( $saved ) ? $saved : array() );
    }
    return isset( $o[ $key ] ) ? $o[ $key ] : $fallback;
}

/* ==========================================================================
   Registrierung + Admin-Seite
   ========================================================================== */
add_action( 'admin_init', function () {
    register_setting( 'sot_settings_group', 'sot_settings', array(
        'type'              => 'array',
        'sanitize_callback' => 'sot_settings_sanitize',
        'default'           => array(),
    ) );
} );

add_action( 'admin_menu', function () {
    add_menu_page( 'ShopOfThings', 'ShopOfThings', 'manage_options', 'sot-settings', 'sot_settings_render_page', 'dashicons-store', 5 );
} );

function sot_settings_sanitize( $input ) {
    if ( ! is_array( $input ) ) {
        $input = array();
    }
    return array(
        'b2b_enabled'  => ! empty( $input['b2b_enabled'] ) ? 1 : 0,
        'b2b_title'    => sanitize_text_field( $input['b2b_title'] ?? '' ),
        'b2b_text'     => sanitize_textarea_field( $input['b2b_text'] ?? '' ),
        'b2b_btn_text' => sanitize_text_field( $input['b2b_btn_text'] ?? '' ),
        'b2b_btn_url'  => esc_url_raw( $input['b2b_btn_url'] ?? '' ),
    );
}

function sot_settings_render_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $name = function ( $k ) { return 'sot_settings[' . $k . ']'; };
    ?>
    <div class="wrap">
        <h1>ShopOfThings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'sot_settings_group' ); ?>

            <h2 class="title">B2B-/Export-Box</h2>
            <p class="description">Diese Box kannst du über das Widget <strong>„ShopOfThings: B2B-Box"</strong> in eine beliebige Widget-/Sidebar-Position einfügen (Design → Widgets).</p>

            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">Anzeigen</th>
                    <td><label><input type="checkbox" name="<?php echo esc_attr( $name( 'b2b_enabled' ) ); ?>" value="1" <?php checked( sot_settings_get( 'b2b_enabled' ) ); ?>> Box aktiv</label></td>
                </tr>
                <tr>
                    <th scope="row"><label>Überschrift</label></th>
                    <td><input type="text" class="regular-text" name="<?php echo esc_attr( $name( 'b2b_title' ) ); ?>" value="<?php echo esc_attr( sot_settings_get( 'b2b_title' ) ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Text</label></th>
                    <td><textarea class="large-text" rows="3" name="<?php echo esc_attr( $name( 'b2b_text' ) ); ?>"><?php echo esc_textarea( sot_settings_get( 'b2b_text' ) ); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label>Button-Text</label></th>
                    <td><input type="text" class="regular-text" name="<?php echo esc_attr( $name( 'b2b_btn_text' ) ); ?>" value="<?php echo esc_attr( sot_settings_get( 'b2b_btn_text' ) ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Button-Link</label></th>
                    <td><input type="text" class="regular-text" name="<?php echo esc_attr( $name( 'b2b_btn_url' ) ); ?>" value="<?php echo esc_attr( sot_settings_get( 'b2b_btn_url' ) ); ?>" placeholder="/b2b/"></td>
                </tr>
            </table>

            <?php submit_button( 'Einstellungen speichern' ); ?>
        </form>
    </div>
    <?php
}

/* ==========================================================================
   Widget: B2B-Box
   ========================================================================== */
class SOT_B2B_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'sot_b2b_widget',
            'ShopOfThings: B2B-Box',
            array( 'description' => 'B2B-/Export-Box. Inhalt wird unter „ShopOfThings" gepflegt.' )
        );
    }

    public function widget( $args, $instance ) {
        if ( ! sot_settings_get( 'b2b_enabled' ) ) {
            return;
        }
        $title = sot_settings_get( 'b2b_title' );
        $text  = sot_settings_get( 'b2b_text' );
        $bt    = sot_settings_get( 'b2b_btn_text' );
        $bu    = sot_settings_get( 'b2b_btn_url' );

        echo $args['before_widget']; // phpcs:ignore
        echo '<div class="sot-b2b-box">';
        if ( $title ) {
            echo '<h4>' . esc_html( $title ) . '</h4>';
        }
        if ( $text ) {
            echo '<p>' . esc_html( $text ) . '</p>';
        }
        if ( $bt && $bu ) {
            echo '<a class="sot-b2b-btn" href="' . esc_url( $bu ) . '">' . esc_html( $bt ) . ' →</a>';
        }
        echo '</div>';
        echo $args['after_widget']; // phpcs:ignore
    }

    public function form( $instance ) {
        echo '<p>Der Inhalt dieser Box wird zentral unter <strong>ShopOfThings</strong> (linkes Admin-Menü) gepflegt.</p>';
    }

    public function update( $new_instance, $old_instance ) {
        return array();
    }
}

add_action( 'widgets_init', function () {
    register_widget( 'SOT_B2B_Widget' );
} );
