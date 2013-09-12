jQuery(document).ready(function() {
//jQuery(function() {

	// Collapsible notes at top of page
	var icons = {
		header: 'ui-icon-circle-arrow-e',
		activeHeader: 'ui-icon-circle-arrow-s'
	};
	jQuery('#accordion').accordion({
		active: false,
		collapsible: true,
		icons: icons,
		heightStyle: 'content'
	});
/*
ui-icon-alert
ui-icon-info
ui-icon-notice
ui-icon-help 

ui-icon-plus
ui-icon-minus

ui-icon-plusthick
ui-icon-minusthick

ui-icon-circle-plus
ui-icon-circle-minus
*/


	// Tabbed interface
	var myTabs = jQuery('#tabs');
	var tabsTotal  = myTabs.find('li a').length;
	var tabsLoaded = 1;


	myTabs.tabs({
		beforeLoad: function( event, ui ) {
			// Show spinner if tab hasn't been loaded yet
			if( ui.panel.html() == '' ) {
				ui.panel.html('<div class="spinner"><img src="page/ajax-loader.gif" /></div>');
			}
			else {
				// Ok, html has already loaded, no need to request it again.
				return false;
			}
			// Show error message if ajax loading of content failed
            ui.jqXHR.error(function() {
                ui.panel.html('An error occured while loading the table. Please try again. If it keeps failing, please inform the site owner.');
            });
		},
	    cache : true
	});



	myTabs.on('mouseover.preload', '.ui-tabs-nav li a', function(event){
		var tabId = jQuery(this).attr('id');
		var tabIndex = tabId.replace( 'ui-id-', '' );
		tabIndex = parseInt( tabIndex ) - 1;
		if( jQuery('#ui-tabs-'+(tabIndex+1)).html() === '' ) {
			try {
				myTabs.tabs('load',tabIndex);
				tabsLoaded++;
			}
			catch(e) {
				console.log( 'Failed to pre-load tab '+tabIndex );
			}
		}
		if( tabsLoaded == tabsTotal ) {
			myTabs.off('.preload');
			console.log( 'Removed pre-load event handler' );
		}
		/*else {
			console.log( 'Loaded '+tabsLoaded+' tabs out of '+ tabsTotal );
		}*/
	});



	// Change the location bar url to the selected tab to enable reloading to the tab where you where
	// and avoid the location bar change causing the page to reload
	myTabs.on('click', 'ul.ui-tabs-nav a', function() { // when tab is shown update the URL
		var tabHref = jQuery(this).attr('href');
		tabHref = tabHref.substring( 0, tabHref.indexOf('&do=') );
		var tabTitle = jQuery(this).text();
		tabTitle = jQuery('title').text()+' - '+tabTitle;
		history.pushState('notrelevant', tabTitle, tabHref );
		//return false;
	});


	// Tooltips for long table column headers
	jQuery('.ui-tabs-panel th').tooltip({
		tooltipClass: 'thtooltip',
		content: create_tooltip( jQuery( this ) )
	});

	function create_tooltip( element ) {
//		var element = jQuery( this );
		if ( element.is( '[title]' ) ) {
			var ttip = element.attr( 'title' );
			ttip = ttip.replace(/\n/g, '<br />');
			ttip = ttip.replace(/\t/g, '&nbsp;&nbsp;&nbsp;&nbsp;');
			return ttip;
		}
	}



	// Highlight table row and column
	var tabPanels = jQuery('.ui-tabs-panel');
	tabPanels.on('mouseenter', 'td, th', function() {
		var idx = jQuery(this).parent().children('td,th').index( jQuery(this))+1;
		var ridx = jQuery(this).parent().parent().children('tr').index( jQuery(this).parent())+1;
		if (ridx > 1) { jQuery(this).parent().addClass('hover'); }
		if (idx > 1) {
			jQuery('.ui-tabs-panel td:nth-child('+idx+')').addClass('hover');
			jQuery('.ui-tabs-panel th:nth-child('+idx+')').addClass('hover');
		}
	});
	tabPanels.on('mouseleave', 'td, th', function() {
		var idx = jQuery(this).parent().children('td,th').index( jQuery(this))+1;
		var ridx = jQuery(this).parent().parent().children('tr').index( jQuery(this).parent())+1;
		if (ridx > 1) { jQuery(this).parent().removeClass('hover'); }
		if ( idx > 1 ) {
			jQuery('.ui-tabs-panel td:nth-child('+idx+')').removeClass('hover');
			jQuery('.ui-tabs-panel th:nth-child('+idx+')').removeClass('hover');
		}
	});
	
	


	// Sticky highlighting
	tabPanels.on('click', 'td, th', function() {
		var idx = jQuery(this).parent().children('td,th').index( jQuery(this))+1;
		var ridx = jQuery(this).parent().parent().children('tr').index( jQuery(this).parent())+1;
		var tCells = jQuery('.ui-tabs-panel td:nth-child('+idx+')');
		var tHeaders = jQuery('.ui-tabs-panel th:nth-child('+idx+')');

		if( jQuery(this).parent().hasClass('sticky') || jQuery('td:nth-child('+idx+')').hasClass('sticky') || jQuery('th:nth-child('+idx+')').hasClass('sticky') ) {
			if ( ridx > 1 ) { jQuery(this).parent().removeClass('sticky'); }
			if ( idx > 1 ) {
				tCells.removeClass('sticky');
				tHeaders.removeClass('sticky');
			}
		}
		else {
			if (ridx > 1) { jQuery(this).parent().addClass('sticky'); }
			if (idx > 1) {
				tCells.addClass('sticky');
				tHeaders.addClass('sticky');
			}
		}
	});
	
});

function show_props(obj, objName) {
	var result = '';
	for (var i in obj) {
		result += objName + '.' + i + ' = ' + obj[i] + "\n";
	}
	return result;
}