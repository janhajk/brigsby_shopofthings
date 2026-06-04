<?php
/**
 * Startseite – Produkte/Anwendungen-Kacheln (Tabs)
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$tabs  = array(
    'tab1' => array( 'label' => $fp['kacheln_tab1_label'], 'cards' => (array) $fp['kacheln_tab1_cards'] ),
    'tab2' => array( 'label' => $fp['kacheln_tab2_label'], 'cards' => (array) $fp['kacheln_tab2_cards'] ),
);
// nur Tabs mit Inhalt
$tabs = array_filter( $tabs, function ( $t ) { return ! empty( $t['cards'] ); } );
if ( empty( $tabs ) ) { return; }
$uid    = 'kacheln-' . wp_rand( 1000, 9999 );
$first  = true;
?>
<section class="sot-tiles" id="<?php echo esc_attr( $uid ); ?>">
    <div class="hgrid">

        <?php if ( count( $tabs ) > 1 ) : ?>
            <div class="tiles-tabs" role="tablist">
                <?php $i = 0; foreach ( $tabs as $key => $tab ) : ?>
                    <button type="button" class="tiles-tab<?php echo $i === 0 ? ' active' : ''; ?>" data-target="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $tab['label'] ); ?></button>
                <?php $i++; endforeach; ?>
            </div>
        <?php endif; ?>

        <?php foreach ( $tabs as $key => $tab ) : ?>
            <div class="tiles-panel<?php echo $first ? ' active' : ''; ?>" data-panel="<?php echo esc_attr( $key ); ?>">
                <div class="tiles-grid">
                    <?php foreach ( $tab['cards'] as $c ) :
                        $img = ! empty( $c['image'] ) ? wp_get_attachment_image_url( absint( $c['image'] ), 'medium' ) : ''; ?>
                        <div class="tile">
                            <div class="tile-body">
                                <?php if ( ! empty( $c['title'] ) ) : ?><h3><?php echo esc_html( $c['title'] ); ?></h3><?php endif; ?>
                                <?php if ( ! empty( $c['text'] ) ) : ?><p><?php echo esc_html( $c['text'] ); ?></p><?php endif; ?>
                            </div>
                            <div class="tile-media">
                                <?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $c['title'] ?? '' ); ?>" loading="lazy"><?php endif; ?>
                            </div>
                            <?php if ( ! empty( $c['btn_text'] ) ) : ?>
                                <a class="tile-btn" href="<?php echo esc_url( $c['url'] ); ?>"><?php echo esc_html( $c['btn_text'] ); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $first = false; ?>
        <?php endforeach; ?>

    </div>
</section>
<?php if ( count( $tabs ) > 1 ) : ?>
<script>
( function () {
    var root = document.getElementById( '<?php echo esc_js( $uid ); ?>' );
    if ( ! root ) { return; }
    root.querySelectorAll( '.tiles-tab' ).forEach( function ( btn ) {
        btn.addEventListener( 'click', function () {
            var target = btn.getAttribute( 'data-target' );
            root.querySelectorAll( '.tiles-tab' ).forEach( function ( b ) { b.classList.toggle( 'active', b === btn ); } );
            root.querySelectorAll( '.tiles-panel' ).forEach( function ( p ) {
                p.classList.toggle( 'active', p.getAttribute( 'data-panel' ) === target );
            } );
        } );
    } );
} )();
</script>
<?php endif; ?>
