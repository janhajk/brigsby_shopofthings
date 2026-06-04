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

    /* ---- Bilder-Galerien (Logos: sortieren, entfernen, Link je Bild) ---- */
    var galCounter = 1000000;

    function galItem( key, idx, id, src, url ) {
        var base = 'sot_frontpage[' + key + '][' + idx + ']';
        return '<li class="sot-fp-gallery-item" style="border:1px solid #dcdcde;border-radius:8px;padding:8px;width:150px;background:#fff">' +
            '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">' +
            '<span class="dashicons dashicons-move sot-fp-gallery-handle" style="cursor:move;color:#888"></span>' +
            '<button type="button" class="button-link sot-fp-gallery-remove" style="color:#b32d2e">Entfernen</button></div>' +
            '<img src="' + src + '" alt="" style="width:100%;height:80px;object-fit:contain;background:#f6f7f7;border-radius:4px">' +
            '<input type="hidden" class="g-id" name="' + base + '[id]" value="' + id + '">' +
            '<input type="url" class="g-url" name="' + base + '[url]" value="' + ( url || '' ) + '" placeholder="Link (optional)" style="width:100%;margin-top:6px;font-size:11px">' +
            '</li>';
    }

    $( '.sot-fp-gallery' ).each( function () {
        var $g    = $( this );
        var key   = $g.data( 'key' );
        var $list = $g.find( '.sot-fp-gallery-list' );

        if ( $.fn.sortable ) {
            $list.sortable( { items: '> li', handle: '.sot-fp-gallery-handle' } );
        }

        $g.on( 'click', '.sot-fp-gallery-add', function ( e ) {
            e.preventDefault();
            var frame = wp.media( { title: 'Bilder auswählen', button: { text: 'Übernehmen' }, multiple: 'add' } );
            frame.on( 'select', function () {
                frame.state().get( 'selection' ).each( function ( att ) {
                    var a   = att.toJSON();
                    var src = ( a.sizes && a.sizes.thumbnail ) ? a.sizes.thumbnail.url : a.url;
                    $list.append( galItem( key, galCounter++, a.id, src, '' ) );
                } );
            } );
            frame.open();
        } );

        $g.on( 'click', '.sot-fp-gallery-remove', function ( e ) {
            e.preventDefault();
            $( this ).closest( 'li' ).remove();
        } );
    } );

} )( jQuery );
