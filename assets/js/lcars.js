/**
 * N0KMO LCARS — front-end behaviour.
 *
 * - Live UTC clock and stardate readouts.
 * - Mobile toggle for the header buttons.
 * - Optional LCARS chirps on button presses, synthesised with the Web Audio
 *   API so no audio files are needed. Enabled in the Customizer.
 *
 * @package N0KMO_LCARS
 */
( function () {
	'use strict';

	var settings = window.n0kmoLcars || {};

	function forEach( list, callback ) {
		Array.prototype.forEach.call( list, callback );
	}

	function pad( number ) {
		return ( number < 10 ? '0' : '' ) + number;
	}

	/**
	 * TNG-style stardate: 1987 is stardate 41000 and each year adds 1000.
	 * Keep in step with n0kmo_lcars_stardate() in inc/template-tags.php.
	 *
	 * @param {Date} date Moment to convert.
	 * @return {string} Stardate with one decimal place.
	 */
	function stardate( date ) {
		var year = date.getUTCFullYear();
		var start = Date.UTC( year, 0, 1 );
		var end = Date.UTC( year + 1, 0, 1 );
		var value = 41000 + ( year - 1987 ) * 1000 + ( ( date.getTime() - start ) / ( end - start ) ) * 1000;

		return ( Math.floor( value * 10 ) / 10 ).toFixed( 1 );
	}

	function initClock() {
		var clocks = document.querySelectorAll( '[data-lcars-clock]' );
		var stardates = document.querySelectorAll( '[data-lcars-stardate]' );

		if ( ! clocks.length && ! stardates.length ) {
			return;
		}

		function tick() {
			var now = new Date();
			var hoursMinutes = pad( now.getUTCHours() ) + ':' + pad( now.getUTCMinutes() );
			var seconds = ':' + pad( now.getUTCSeconds() );

			forEach( clocks, function ( clock ) {
				var hm = clock.querySelector( '.lcars-clock__hm' );
				var s = clock.querySelector( '.lcars-clock__s' );

				if ( hm ) {
					hm.textContent = hoursMinutes;
				}
				if ( s ) {
					s.textContent = seconds;
				}
				clock.setAttribute( 'datetime', now.toISOString() );
			} );

			forEach( stardates, function ( readout ) {
				readout.textContent = stardate( now );
			} );
		}

		tick();
		window.setInterval( tick, 1000 );
	}

	function initMenuToggle() {
		var toggle = document.querySelector( '.menu-toggle' );
		var nav = document.getElementById( 'site-navigation' );

		if ( ! toggle || ! nav ) {
			return;
		}

		function setOpen( open ) {
			nav.classList.toggle( 'is-open', open );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		}

		toggle.addEventListener( 'click', function () {
			setOpen( ! nav.classList.contains( 'is-open' ) );
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key && nav.classList.contains( 'is-open' ) ) {
				setOpen( false );
				toggle.focus();
			}
		} );
	}

	function initSounds() {
		var AudioContextClass = window.AudioContext || window.webkitAudioContext;
		var context = null;
		var chirps = [
			[ 1046.5, 1318.5 ],
			[ 880, 1174.7 ],
			[ 1318.5, 987.8 ],
			[ 784, 1046.5 ],
		];
		var selector = [
			'.panel-1',
			'#topBtn',
			'.lcars-nav-buttons a',
			'.lcars-side-panels a',
			'.menu-toggle',
			'.lcars-button',
			'.wp-block-button__link',
			'.elementor-button',
			'.page-numbers',
			'.post-navigation a',
			'.footer-menu a',
			'button',
			'input[type="submit"]',
		].join( ',' );

		if ( ! settings.sounds || ! AudioContextClass ) {
			return;
		}

		function chirp() {
			var tones = chirps[ Math.floor( Math.random() * chirps.length ) ];
			var now;

			if ( ! context ) {
				context = new AudioContextClass();
			}
			if ( 'suspended' === context.state ) {
				context.resume();
			}
			now = context.currentTime;

			tones.forEach( function ( frequency, index ) {
				var oscillator = context.createOscillator();
				var gain = context.createGain();
				var start = now + index * 0.06;

				oscillator.type = 'sine';
				oscillator.frequency.value = frequency;
				gain.gain.setValueAtTime( 0.0001, start );
				gain.gain.exponentialRampToValueAtTime( 0.12, start + 0.01 );
				gain.gain.exponentialRampToValueAtTime( 0.0001, start + 0.07 );
				oscillator.connect( gain );
				gain.connect( context.destination );
				oscillator.start( start );
				oscillator.stop( start + 0.08 );
			} );
		}

		function isPlainNavigation( event, link ) {
			var href = link.getAttribute( 'href' ) || '';

			return 'A' === link.tagName &&
				'' !== href &&
				'#' !== href.charAt( 0 ) &&
				0 === event.button &&
				! event.defaultPrevented &&
				! ( event.metaKey || event.ctrlKey || event.shiftKey || event.altKey ) &&
				( ! link.target || '_self' === link.target ) &&
				! link.hasAttribute( 'download' ) &&
				link.origin === window.location.origin;
		}

		document.addEventListener( 'click', function ( event ) {
			var element = event.target.closest ? event.target.closest( selector ) : null;

			if ( ! element ) {
				return;
			}

			chirp();

			// Give the chirp a moment to play before leaving the page.
			if ( isPlainNavigation( event, element ) ) {
				event.preventDefault();
				window.setTimeout( function () {
					window.location.href = element.href;
				}, 140 );
			}
		} );
	}

	function init() {
		initClock();
		initMenuToggle();
		initSounds();
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
