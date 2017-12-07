! function( t ) {
    "use strict";

    function i() {
        t( ".parallax" )
            .each( function() {
                var i = t( this ),
                    a = t( window )
                        .scrollTop(),
                    o = a * n,
                    o = +o.toFixed( 2 );
                i.hasClass( "fs" ) ? i.css( "transform", "translate3d(-50%,-" + ( 50 - .15 * o ) + "%,0)" ) : i.css( "transform", "translate3d(0," + o + "px,0)" )
            } )
    }

    function a() {
        var i = t( window )
                .height(),
            a = t( window )
                .scrollTop(),
            o = a + i;
        t.each( e, function() {
            var i = t( this ),
                n = i.outerHeight(),
                e = i.offset()
                        .top - 100,
                s = e + n;
            s >= a && e <= o ? i.addClass( "in-view" ) : i.removeClass( "in-view" )
        } )
    }
    t( "body" )
        .append( '<div class="l1"></div><div class="l2"></div><div class="l3"></div>' ), t( "a[href!=#][data-toggle!=tab][data-toggle!=collapse][target!=_blank][class!=anchor]" )
        .addClass( "smooth" ), t( ".smooth-transition" )
        .animsition( {
            linkElement: ".smooth",
            inDuration: 500,
            outDuration: 500
        } ), t( "html" )
        .on( "click", function( i ) {
            t( ".navigation, .nav-trigger" )
                .removeClass( "tapped" )
        } ), t( ".nav-trigger" )
        .on( "click", function( i ) {
            i.stopPropagation(), t( ".navigation" )
                .toggleClass( "tapped" ), t( ".navigation" )
                .hasClass( "tapped" ) ? t( ".nav-trigger" )
                .addClass( "tapped" ) : t( ".nav-trigger" )
                .removeClass( "tapped" )
        } ), t( ".navigation li" )
        .on( "click", function( i ) {
            i.stopPropagation(), t( this )
                .toggleClass( "tapped" )
        } );
    var o = t( ".grid" );
    o.imagesLoaded( function() {
        o.packery( {
            itemSelector: ".item"
        } )
    } ), t( ".filter-trigger" )
        .on( "click", function( i ) {
            i.preventDefault(), t( "body" )
                .addClass( "filters-active" ), t( "html,body" )
                .animate( {
                    scrollTop: t( ".grid" )
                        .offset()
                        .top + "px"
                }, 500 ), t( ".filter-container" )
                .fadeIn()
        } ), t( ".filter-container" )
        .on( "click", function( i ) {
            i.preventDefault(), t( "body" )
                .removeClass( "filters-active" ), t( ".filter-container" )
                .fadeOut()
        } ), t( ".filter" )
        .on( "click", function( i ) {
            i.preventDefault(), i.stopPropagation();
            var a = t( this )
                .attr( "data-filter" );
            t( ".filter.active" )
                .removeClass( "active" ), t( this )
                .addClass( "active" ), t( ".grid" )
                .find( ".item:not(." + a + ")" )
                .css( {
                    "-webkit-transition": "all .25s",
                    transition: "all .25s",
                    "-webkit-transform": "scale(0)",
                    transform: "scale(0)",
                    "-webkit-opacity": "0",
                    opacity: "0"
                } ), setTimeout( function() {
                t( ".grid" )
                    .find( ".item:not(." + a + ")" )
                    .hide( 0 ), t( ".grid" )
                    .find( "." + a )
                    .show( 0 )
                    .css( {
                        "-webkit-transform": "scale(1)",
                        "-webkit-opacity": "1",
                        transform: "scale(1)",
                        opacity: "1"
                    } ), o.packery( "layout" )
            }, 250 )
        } ), t( window )
        .on( "resize", function() {
            setTimeout( function() {
                o.packery( "layout" ), window.requestAnimationFrame( a )
            }, 1500 )
        } ), t( ".anchor" )
        .on( "click", function( i ) {
            i.preventDefault(), i.stopPropagation();
            var a = t( this )
                .attr( "href" );
            t( "html,body" )
                .animate( {
                    scrollTop: t( a )
                        .offset()
                        .top + "px"
                } )
        } );
    var n = .15;
    t( window )
        .on( "scroll", function() {
            window.requestAnimationFrame( i )
        } );
    var e = t( ".item, .fadein" );
    t( window )
        .on( "scroll resize", function() {
            window.requestAnimationFrame( a ), t( ".anchor" )
                .each( function() {
                    var i = "#" + t( ".in-view" )
                            .attr( "id" );
                    i == t( this )
                        .attr( "href" ) && ( t( ".anchor" )
                        .removeClass( "active" ), t( this )
                        .addClass( "active" ) )
                } )
        } ), t( window )
        .on( "load", function() {
            window.requestAnimationFrame( a )
        } ), t( window )
        .on( "pageshow", function( t ) {
            t.originalEvent.persisted && window.location.reload()
        } )
}( jQuery );