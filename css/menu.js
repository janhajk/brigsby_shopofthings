/* Hauptnavigation – Interaktion (Vanilla JS) */
( function () {
    'use strict';

    var isMobile = function () {
        return window.matchMedia( '(max-width: 1024px)' ).matches;
    };

    /* Mega-Panel: Gruppe wechselt die mittlere Liste */
    document.querySelectorAll( '.sot-nav-mega' ).forEach( function ( mega ) {
        var groups = mega.querySelectorAll( '.mega-group' );
        var lists  = mega.querySelectorAll( '.mega-list' );

        function activate( target ) {
            groups.forEach( function ( g ) {
                g.classList.toggle( 'active', g.getAttribute( 'data-target' ) === target );
            } );
            lists.forEach( function ( l ) {
                l.classList.toggle( 'active', l.id === target );
            } );
        }

        groups.forEach( function ( g ) {
            var target = g.getAttribute( 'data-target' );
            g.addEventListener( 'mouseenter', function () {
                if ( ! isMobile() ) { activate( target ); }
            } );
            g.addEventListener( 'click', function ( e ) {
                // Auf Mobile nur umschalten, nicht navigieren
                if ( isMobile() ) { e.preventDefault(); }
                activate( target );
            } );
        } );
    } );

    /* Hamburger + mobiles Akkordeon */
    document.querySelectorAll( '.sot-nav' ).forEach( function ( nav ) {
        var toggle = nav.querySelector( '.sot-nav-toggle' );
        if ( toggle ) {
            toggle.addEventListener( 'click', function () {
                var open = nav.classList.toggle( 'open' );
                toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
                document.body.classList.toggle( 'sot-nav-locked', open );
            } );
        }

        nav.querySelectorAll( '.sot-nav-item.has-panel > .sot-nav-link' ).forEach( function ( link ) {
            link.addEventListener( 'click', function ( e ) {
                if ( isMobile() ) {
                    e.preventDefault();
                    link.parentNode.classList.toggle( 'open' );
                }
            } );
        } );
    } );

    /* Schliessen bei Klick ausserhalb / ESC */
    document.addEventListener( 'click', function ( e ) {
        document.querySelectorAll( '.sot-nav.open' ).forEach( function ( nav ) {
            if ( ! nav.contains( e.target ) ) {
                nav.classList.remove( 'open' );
                var t = nav.querySelector( '.sot-nav-toggle' );
                if ( t ) { t.setAttribute( 'aria-expanded', 'false' ); }
                document.body.classList.remove( 'sot-nav-locked' );
            }
        } );
    } );

    document.addEventListener( 'keyup', function ( e ) {
        if ( 'Escape' === e.key ) {
            document.querySelectorAll( '.sot-nav.open' ).forEach( function ( nav ) {
                nav.classList.remove( 'open' );
                document.body.classList.remove( 'sot-nav-locked' );
            } );
        }
    } );

} )();
