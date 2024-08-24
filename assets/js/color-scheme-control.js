/**
* Add a listener to the Color Scheme control to update other color controls to new values/defaults.
* Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
	"use strict";

	var cssTemplate = wp.template( 'karis-color-scheme' ),
		colorSchemeKeys = [
			'accent_color',
			'accent_hover_color',
		],
		colorSettings = [
			'accent_color',
			'accent_hover_color',
		];

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
					var colors = colorScheme[value].colors;

					// Update Accent Color.
					var color = colors[0];
					api( 'accent_color' ).set( color );
					api.control( 'accent_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Accent Hover Color.
					color = colors[1];
					api( 'accent_hover_color' ).set( color );
					api.control( 'accent_hover_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );
				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'color_scheme' )(),
			css,
			colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			colors[ setting ] = api( setting )();
		} );

		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
