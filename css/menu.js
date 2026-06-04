/* Hauptnavigation – Interaktion (Vanilla JS) */
( function () {
    'use strict';

    var isMobile = function () {
        return window.matchMedia( '(max-width: 1024px)' ).matches;
    };

    /* Suchfeld zwischen Top-Bar (Desktop) und Bereich unter dem Header (Mobile)
       verschieben – nur EIN Widget, daher keine doppelten IDs. */
    function placeSearch() {
        var search = document.querySelector( '.sot-search-dropdown' );
        var mobile = document.getElementById( 'sot-mobile-search' );
        if ( ! search || ! mobile ) { return; }

        if ( isMobile() ) {
            if ( search.parentNode !== mobile ) { mobile.appendChild( search ); }
            search.classList.add( 'active' ); // immer sichtbar
        } else {
            var right = document.querySelector( '.sot-topbar-right' );
            if ( right && search.parentNode === mobile ) {
                var toggle = right.querySelector( '.sot-search-toggle' );
                if ( toggle && toggle.nextSibling ) {
                    right.insertBefore( search, toggle.nextSibling );
                } else {
                    right.appendChild( search );
                }
                search.classList.remove( 'active' );
            }
        }
    }
    placeSearch();
    var resizeTimer;
    window.addEventListener( 'resize', function () {
        clearTimeout( resizeTimer );
        resizeTimer = setTimeout( placeSearch, 150 );
    } );

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
        function collapseAll() {
            groups.forEach( function ( g ) { g.classList.remove( 'active' ); } );
            lists.forEach( function ( l ) { l.classList.remove( 'active' ); } );
        }

        // Auf Mobile starten alle Untermenüs geschlossen
        if ( isMobile() ) { collapseAll(); }

        groups.forEach( function ( g ) {
            var target = g.getAttribute( 'data-target' );
            g.addEventListener( 'mouseenter', function () {
                if ( ! isMobile() ) { activate( target ); }
            } );
            g.addEventListener( 'click', function ( e ) {
                if ( isMobile() ) {
                    e.preventDefault();
                    // Akkordeon: nur eines offen, erneutes Tippen schliesst
                    var wasActive = g.classList.contains( 'active' );
                    collapseAll();
                    if ( ! wasActive ) { activate( target ); }
                } else {
                    activate( target );
                }
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
                if ( ! isMobile() ) { return; }
                e.preventDefault();
                e.stopPropagation();
                var li     = link.closest( '.sot-nav-item' );
                var isOpen = li.classList.contains( 'open' );
                // Akkordeon: erst alle schliessen …
                nav.querySelectorAll( '.sot-nav-item.open' ).forEach( function ( o ) {
                    o.classList.remove( 'open' );
                } );
                // … und nur öffnen, wenn der Punkt vorher zu war
                if ( ! isOpen ) {
                    li.classList.add( 'open' );
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
