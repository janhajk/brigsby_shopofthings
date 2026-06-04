/* Menü-Admin: Medien-Picker, Sortierung der Top-Punkte, Typ-Umschaltung */
( function ( $ ) {
    'use strict';

    /* Typ-abhängige Felder ein-/ausblenden (über data-type am <li>) */
    function applyType( $item ) {
        $item.attr( 'data-type', $item.find( '.sot-menu-type' ).val() );
    }
    $( '.sot-menu-item' ).each( function () { applyType( $( this ) ); } );
    $( document ).on( 'change', '.sot-menu-type', function () {
        applyType( $( this ).closest( '.sot-menu-item' ) );
    } );

    /* Top-Punkte sortieren */
    if ( $.fn.sortable ) {
        $( '#sot-menu-items' ).sortable( { items: '> li', handle: '.sot-menu-handle', axis: 'y' } );
    }

    /* Einzel-Bild-Picker */
    $( document ).on( 'click', '.sot-menu-media-add', function ( e ) {
        e.preventDefault();
        var $wrap   = $( this ).closest( '.sot-menu-media' );
        var $input  = $( $wrap.data( 'target' ) );
        var $prev   = $wrap.find( '.sot-menu-preview' );
        var frame   = wp.media( { title: 'Bild auswählen', button: { text: 'Übernehmen' }, multiple: false } );
        frame.on( 'select', function () {
            var a   = frame.state().get( 'selection' ).first().toJSON();
            var src = ( a.sizes && a.sizes.thumbnail ) ? a.sizes.thumbnail.url : a.url;
            $input.val( a.id );
            $prev.html( '<img src="' + src + '" style="max-width:90px;height:auto;border:1px solid #dcdcde;border-radius:6px">' );
        } );
        frame.open();
    } );

    $( document ).on( 'click', '.sot-menu-media-clear', function ( e ) {
        e.preventDefault();
        var $wrap = $( this ).closest( '.sot-menu-media' );
        $( $wrap.data( 'target' ) ).val( '' );
        $wrap.find( '.sot-menu-preview' ).empty();
    } );

} )( jQuery );
