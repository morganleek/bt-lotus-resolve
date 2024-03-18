import './style.scss';

// GSAP
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin( ScrollTrigger );

document.addEventListener( 'DOMContentLoaded', () => {
	// Popup
	// if( document.querySelector( '.announcement-popup.wp-block-template-part' ) ) {
	// 	if( sessionStorage.getItem( "lotus-annoucement" ) === null ) {
	// 		document.body.classList.add( 'announcement-is-visible' );
			
	// 		sessionStorage.setItem( "lotus-annoucement", true );
	// 	}

	// 	document.querySelector( '.announcement-popup.wp-block-template-part a[href="#close-me"]' ).addEventListener( 'click', ( e ) => {
	// 		e.preventDefault();
	// 		document.body.classList.remove( 'announcement-is-visible' );
	// 	} );
	// }

	document.querySelectorAll( 'a[rel="external"]' ).forEach( ( a ) => { a.target = "_blank"; } );

	// Fixed header
	let mm = gsap.matchMedia();

	mm.add("(max-width: 799px)", () => {
		if( document.querySelector( 'header.wp-block-template-part' ) ) {
			const start = document.querySelector( 'header.wp-block-template-part .floating-menu' ) ? document.querySelector( 'header.wp-block-template-part .floating-menu' ).offsetTop - 10 : 44;
			gsap.timeline( {
				scrollTrigger: {
					trigger: document.querySelector( 'header.wp-block-template-part' ),
					endTrigger: document.querySelector( 'footer' ),
					start: "10px top",
					end: "bottom top",
					scrub: true,
					toggleClass: { targets: document.body, className: 'is-fixed' },
					// markers: true
				}
			} );
		}
	} );

	mm.add("(min-width: 800px)", () => {
		if( document.querySelector( 'header.wp-block-template-part' ) ) {
			const start = document.querySelector( 'header.wp-block-template-part .floating-menu' ) ? document.querySelector( 'header.wp-block-template-part .floating-menu' ).offsetTop - 10 : 44;
			gsap.timeline( {
				scrollTrigger: {
					trigger: document.querySelector( 'header.wp-block-template-part' ),
					endTrigger: document.querySelector( 'footer' ),
					start: start + "px top",
					end: "bottom top",
					scrub: true,
					toggleClass: { targets: document.body, className: 'is-fixed' },
					// markers: true
				}
			} );
		}
	} );

	// document.querySelectorAll( '.employee-profile-stack' ).forEach( ( stack ) => {
	// 	console.log( stack );
	// 	stack.addEventListener( 'animationend', ( e ) => {
	// 		console.log( 'before now' ); 
	// 	} );
	// } );

	document.querySelectorAll( '.wp-block-group.employee-profile-stack > .wp-block-group > p, .wp-block-group.employee-profile-stack > .wp-block-image' ).forEach( ( link ) => {
		link.addEventListener( 'click', ( e ) => {
			const stack = e.target.closest( '.employee-profile-stack' );
			stack.classList.toggle( 'is-active' );
			// stack.addEventListener( 'animationend', ( e ) => {
			// 	console.log( e ); 
			// } );
		} );
	} );

	// iOS window height work around  
  window.addEventListener( 'resize', () => {
		bones_theme_window_height();
	} );
  bones_theme_window_height();

	// Lazy loading images
	document.querySelectorAll( 'img[loading="lazy"]' ).forEach( ( img ) => {
		if( img.complete == true ) {
			img.classList.add( 'has-loaded' );
		}
		img.addEventListener( "load", ( e ) => {
			e.target.classList.add( 'has-loaded' );
		} );
	} );

} );

// iOS window height
const bones_theme_window_height = () => {
  document.documentElement.style.setProperty('--app--height', `${window.innerHeight}px`);

	if( document.querySelector( 'header' ) ) {
		document.documentElement.style.setProperty('--app--header--height', `${document.querySelector( 'header' ).offsetHeight}px`);
	}
}