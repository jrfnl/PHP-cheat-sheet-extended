/* Javascript interaction for PHP cheat sheets. */
jQuery( document ).ready( function() {

	/**
	 * Declare variables.
	 */
	var myAccordion, phpvForm, myTabs, formTabField, windowTitle, tabPanels;


	/**
	 * Collapsible notes/legend at top of page.
	 */
	myAccordion = jQuery( '#accordion' );
	myAccordion.accordion({
		active: false,
		collapsible: true,
		icons: {
			header: 'ui-icon-circle-arrow-e',
			activeHeader: 'ui-icon-circle-arrow-s'
		},
		heightStyle: 'content'
	});


	/**
	 * Add auto-submit to php version dropdown.
	 */
	phpvForm = jQuery( '#choose-version' );
	phpvForm.on( 'change', 'select', function() {
		phpvForm.submit();
	});


	/**
	 * Tabbed interface.
	 */
	myTabs       = jQuery( '#tabs' );
	formTabField = jQuery( '#phpv-tab' );
	windowTitle  = jQuery( 'title' );

	myTabs.tabs({
		beforeActivate: function( event, ui ) {
			/* Remove floating table headers from old panel. */
			var oldId = ui.oldPanel.find( 'table' ).attr( 'id' );
			if ( oldId ) {
				jQuery( '#' + oldId ).thfloat( 'destroy' );
			}
		},
		activate: function( event, ui ) {
			var tableId, tabHref, tabTab, tabTitle, oldTab, oldTitle, titleText;
			var oldTabNoUnderscore, oldTitlePre, oldUri;

			/* (Re-)attach floating table headers for activated panel. */
			tableId = ui.newPanel.find( 'table' ).attr( 'id' );
			if ( tableId ) {
				jQuery( '#' + tableId ).thfloat({
					side: 'head',
					onShow: function( table, block ) {

						// Remove hover and sticky classes as they will otherwise not stay consistent.
						block.find( 'th' ).css( 'background', '' );
					}
				}).thfloat({
					side: 'foot',
					onShow: function( table, block ) {

						// Remove hover and sticky classes as they will otherwise not stay consistent.
						block.find( 'th' ).css( 'background', '' );
					}
				});
			}

			/* Remove hover and sticky classes as they will otherwise not stay consistent. */
			jQuery( '.hover, .sticky' ).removeClass( 'hover sticky' );


			/* Change the location bar url to the selected tab to enable reloading to the currently
			   selected tab and avoid the location bar change causing the page to reload. */
			tabHref  = ui.newTab.find( 'a' ).attr( 'href' );
			tabTab   = ui.newTab.find( 'a' ).attr( 'data-tab' );
			tabTitle = ui.newTab.find( 'a' ).attr( 'data-tab-title' );
			if ( tabHref && tabTab && tabTitle ) {
				oldTab   = ui.oldTab.find( 'a' ).attr( 'data-tab' );
				oldTitle = ui.oldTab.find( 'a' ).attr( 'data-tab-title' );

				titleText   = windowTitle.text();

				if ( titleText.indexOf( ':: ' + oldTitle ) !== -1 ) {
					titleText = titleText.replace( ':: ' + oldTitle, ':: ' + tabTitle );
				}
				else {
					oldTabNoUnderscore = oldTab.replace( '_', ' ' );
					if ( titleText.indexOf( ':: ' + oldTabNoUnderscore ) !== -1 ) {
						titleText = titleText.replace( ':: ' + oldTabNoUnderscore, ':: ' + tabTitle );
					}
					// This was a generic call, no previous tab selected.
					else {
						oldTitlePre = titleText.substring( 0, titleText.indexOf( ' Cheatsheet for ' ) );
						titleText = oldTitlePre + titleText.replace( oldTitlePre, ( ' :: ' + tabTitle ) );
					}
				}

				// Static sheets.
				if ( '#' === tabHref.substring( 0, 1 ) ) {
					oldUri = window.location.href;
					if ( oldUri.indexOf( '#' ) !== -1 && window.location.hash === ( '#' + oldTab ) ) {
						tabHref = oldUri.replace( window.location.hash, tabHref );
					}
					else {
						tabHref = oldUri + tabHref;
					}
				}
				// Dynamic sheet.
				else {
					tabHref  = tabHref.substring( 0, ( tabHref.indexOf( '/ajax' ) + 1 ) );
				}

				// Add to history.
				history.pushState( null, titleText, tabHref );
				// Change the title bar title.
				windowTitle.text( titleText );
				// Change the tab value for the php version dropdown.
				formTabField.val( tabTab );
			}
		},
		beforeLoad: function( event, ui ) {
			if ( '' === ui.panel.html() ) {
				// Show spinner if tab hasn't been loaded yet.
				ui.panel.html( '<div class="spinner">&nbsp;</div>' );
				// Show error message if ajax loading of content failed.
				ui.jqXHR.error(function() {
					ui.panel.html( 'An error occurred while loading the table. Please try again. If it keeps failing, please inform the site owner.' );
				});
				return true;
			}
			// Ok, html has already loaded, no need to request it again.
			return false;
		},
	    cache: true,
	    create: function( event, ui ) {
			var tabTitle, titleText, oldTitlePre;

			/* Set the initial tab value for the dropdown and title bar
			   Static sheets only (they are the only ones with location hashes). */
			var tabHash = window.location.hash;
			if ( tabHash && '' !== tabHash ) {
				// Change the initial tab value for the php version dropdown.
				if ( '' === formTabField.val() ) {
					formTabField.val( tabHash.replace( '#', '' ) );
				}
				// Add the tab title to the initial window titlebar title.
				tabTitle    = ui.tab.find( 'a' ).attr( 'data-tab-title' );
				titleText   = windowTitle.text();
				oldTitlePre = titleText.substring( 0, titleText.indexOf( ' Cheatsheet for ' ) );
				titleText   = oldTitlePre + titleText.replace( oldTitlePre, ( ' :: ' + tabTitle ) );
				windowTitle.text( titleText );
			}
		},
	    load: function( event, ui ) {
			/* Attach floating table headers for panel loaded via Ajax. */
			var tableId = ui.panel.find( 'table' ).attr( 'id' );
				jQuery( '#' + tableId ).thfloat({
					side: 'head',
					onShow: function( table, block ) {
						// Remove hover and sticky classes as they will otherwise not stay consistent.
						block.find( 'th' ).css( 'background', '' );
					}
				}).thfloat({
					side: 'foot',
					onShow: function( table, block ) {
						// Remove hover and sticky classes as they will otherwise not stay consistent.
						block.find( 'th' ).css( 'background', '' );
					}
				});
			// Remove hover and sticky classes as they will otherwise not stay consistent.
			// jQuery( '.thfloat th' ).removeClass( 'hover sticky' ).css( 'background', '' );
		}
	});


	/**
	 * Auto-expand relevant accordion legend section when a link refering to text within the section is clicked.
	 */
	myTabs.on( 'click', '.fright a', function() {
		myAccordion.accordion( 'option', 'active', 1 );
	});


	/**
	 * Tooltips for long table column headers.
	 *
	 * @todo improve....
	 */
	jQuery( '.ui-tabs-panel th [title]' ).tooltip({
		tooltipClass: 'th-tooltip',
		content: function() {
			var element = jQuery( this );
			var toolTip;
			toolTip = element.attr( 'title' );
			toolTip = toolTip.replace( /\n/g, '<br />' );
			toolTip = toolTip.replace( /\t/g, '&nbsp;&nbsp;&nbsp;&nbsp;' );
			return toolTip;
		}
	});


	/**
	 * Highlight table row and column.
	 */
	tabPanels = jQuery( '.ui-tabs-panel' );
	tabPanels.on( 'mouseenter', 'td, th', function() {
		var idx    = jQuery( this ).parent().children( 'td,th' ).index( jQuery( this ) ) + 1;
		var rowIdx = jQuery( this ).parent().parent().children( 'tr' ).index( jQuery( this ).parent() ) + 1;
		if ( rowIdx > 1 ) {
			jQuery( this ).parent().addClass( 'hover' );
		}
		if ( idx > 1 ) {
			jQuery( '.ui-tabs-panel td:nth-child( ' + idx + ' )' ).addClass( 'hover' );
			jQuery( '.ui-tabs-panel th:nth-child( ' + idx + ' )' ).addClass( 'hover' );
			jQuery( '.thfloat th:nth-child( ' + idx + ' )' ).addClass( 'hover' );
		}
	});
	tabPanels.on( 'mouseleave', 'td, th', function() {
		var idx    = jQuery( this ).parent().children( 'td,th' ).index( jQuery( this ) ) + 1;
		var rowIdx = jQuery( this ).parent().parent().children( 'tr' ).index( jQuery( this ).parent() ) + 1;
		if ( rowIdx > 1 ) {
			jQuery( this ).parent().removeClass( 'hover' );
		}
		if ( idx > 1 ) {
			jQuery( '.ui-tabs-panel td:nth-child( ' + idx + ' )' ).removeClass( 'hover' );
			jQuery( '.ui-tabs-panel th:nth-child( ' + idx + ' )' ).removeClass( 'hover' );
			jQuery( '.thfloat th:nth-child( ' + idx + ' )' ).removeClass( 'hover' );
		}
	});


	/**
	 * Sticky table row and column highlighting.
	 */
	tabPanels.on( 'click', 'td, th', function() {
		var idx    = jQuery( this ).parent().children( 'td,th' ).index( jQuery( this ) ) + 1;
		var rowIdx = jQuery( this ).parent().parent().children( 'tr' ).index( jQuery( this ).parent() ) + 1;

		var tCells   = jQuery( '.ui-tabs-panel td:nth-child( ' + idx + ' )' );
		var tHeaders = jQuery( '.ui-tabs-panel th:nth-child( ' + idx + ' )' );
		var fHeaders = jQuery( '.thfloat th:nth-child( ' + idx + ' )' );

		if ( jQuery( this ).parent().hasClass( 'sticky' ) || jQuery( 'td:nth-child( ' + idx + ' )' ).hasClass( 'sticky' ) || jQuery( 'th:nth-child( ' + idx + ' )' ).hasClass( 'sticky' ) ) {
			if ( rowIdx > 1 ) {
				jQuery( this ).parent().removeClass( 'sticky' );
			}
			if ( idx > 1 ) {
				tCells.removeClass( 'sticky' );
				tHeaders.removeClass( 'sticky' );
				fHeaders.removeClass( 'sticky' );
			}
		}
		else {
			if ( rowIdx > 1 ) {
				jQuery( this ).parent().addClass( 'sticky' );
			}
			if ( idx > 1 ) {
				tCells.addClass( 'sticky' );
				tHeaders.addClass( 'sticky' );
				fHeaders.addClass( 'sticky' );
			}
		}
	});
});
