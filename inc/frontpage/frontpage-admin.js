/* Startseiten-Einstellungen – Admin-JS
   - Medien-Uploader (einzeln + mehrfach)
   - Drag & Drop Reihenfolge der Sektionen
*/
( function ( $ ) {
    'use strict';

    /* ---- Sektionen sortieren ---- */
    function refreshOrder() {
        var order = [];
        $( '#sot-fp-sortable .sot-fp-sortable-item' ).each( function () {
            order.push( $( this ).data( 'slug' ) );
        } );
        $( '#sot-fp-order' ).val( order.join( ',' ) );
    }

    if ( $.fn.sortable ) {
        $( '#sot-fp-sortable' ).sortable( {
            handle: '.dashicons-move',
            axis: 'y',
            update: refreshOrder
        } );
    }

    /* ---- Medien-Uploader ---- */
    $( '.sot-fp-media' ).each( function () {
        var $wrap     = $( this );
        var multiple  = $wrap.data( 'multiple' ) === 1 || $wrap.data( 'multiple' ) === '1';
        var $input    = $( $wrap.data( 'target' ) );
        var $preview  = $wrap.find( '.sot-fp-preview' );
        var frame;

        $wrap.on( 'click', '.sot-fp-media-add', function ( e ) {
            e.preventDefault();

            frame = wp.media( {
                title: multiple ? 'Logos auswählen' : 'Bild auswählen',
                button: { text: 'Übernehmen' },
                multiple: multiple ? 'add' : false
            } );

            frame.on( 'select', function () {
                var sel = frame.state().get( 'selection' );

                if ( multiple ) {
                    var ids = ( $input.val() ? $input.val().split( ',' ) : [] ).filter( Boolean );
                    sel.each( function ( att ) {
                        var a    = att.toJSON();
                        var idStr = String( a.id );
                        if ( ids.indexOf( idStr ) === -1 ) {
                            ids.push( idStr );
                            var src = ( a.sizes && a.sizes.thumbnail ) ? a.sizes.thumbnail.url : a.url;
                            $preview.append(
                                '<span style="position:relative;display:inline-block">' +
                                '<img src="' + src + '" style="width:70px;height:70px;object-fit:contain;border:1px solid #dcdcde;border-radius:6px;background:#fff">' +
                                '</span>'
                            );
                        }
                    } );
                    $input.val( ids.join( ',' ) );
                } else {
                    var a   = sel.first().toJSON();
                    var src = ( a.sizes && a.sizes.medium ) ? a.sizes.medium.url : a.url;
                    $input.val( a.id );
                    $preview.html( '<img src="' + src + '" style="max-width:220px;height:auto;border:1px solid #dcdcde;border-radius:6px">' );
                }
            } );

            frame.open();
        } );

        $wrap.on( 'click', '.sot-fp-media-clear', function ( e ) {
            e.preventDefault();
            $input.val( '' );
            $preview.empty();
        } );
    } );

} )( jQuery );
