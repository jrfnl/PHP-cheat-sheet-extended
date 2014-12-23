<?php

define( 'APP_DIR', dirname( __FILE__ ) );
include_once( APP_DIR . '/include/setup-env.php' );

/**
 * Determine what has been requested
 */
$type = null;
$page = null;
$page_title = 'PHP Cheatsheets';

if( isset( $_GET['page'] ) ) {
	switch ( $_GET['page'] ) {
		case 'compare':
			$type       = 'compare';
			$page_title = 'PHP Variable Comparison';
			break;
			
		case 'arithmetic':
			$type       = 'arithmetic';
			$page_title = 'PHP Arithmetic Operations';
			break;

		case 'test':
			$type       = 'test';
			$page_title = 'PHP Variable Testing';
			break;
			
		case 'other-cheat-sheets':
			$page = 'other-cheat-sheets';
			$page_title = 'More PHP Cheatsheets';
			break;

		case 'about':
			$page = 'about';
			$page_title = 'About phpcheatsheets.com';
			break;
	}
}


/* ***** Send headers ***** */
header( 'Content-type: text/html; charset=utf-8' );


$class = 'Vartype' . ucfirst( $type );
$file  = 'class.vartype-' . $type . '.php';

/**
 * Load a cheatsheet page
 */
if ( isset( $type ) && file_exists( APP_DIR . '/' . $file ) ) {
	include_once( APP_DIR . '/' . $file );
	$current_tests = new $class();

	$tab = null;
	if ( isset( $_GET['tab'] ) && $_GET['tab'] !== '' ) {
		$tab = $_GET['tab'];
	}

	/**
	 * Only return the table if it's an ajax call
	 */
	if ( isset( $_GET['do'] ) && $_GET['do'] === 'ajax' ) {
		$current_tests->run_test( $tab );
	}
	/**
	 * Return a full page if not
	 */
	else {
		include_once( APP_DIR . '/page/header.php' );
		include_once( APP_DIR . '/page/notes-legend.php' );

		/* Hidden feature - pre-load all tabs, slow, but useful for source compare & generating of static files */
		$all = false;
		if ( isset( $_GET['all'] ) && $_GET['all'] === '1' ) {
			$all = true;
			@ini_set( 'max_execution_time', '180' ); // lengthen allowed execution time
		}

		$current_tests->do_page( $all );

		include_once( APP_DIR . '/page/footer.php');
	}
}
/**
 * Load an extraneous page (about, links etc)
 */
else {
	include_once( APP_DIR . '/page/header.php' );

	if ( isset( $page ) && $page !== '' ) {
		if ( file_exists( APP_DIR . '/page/' . $page . '.html' ) ) {
			include_once( APP_DIR . '/page/' . $page . '.html' );
		}
		else if ( file_exists( APP_DIR . '/page/' . $page . '.php' ) ) {
			include_once( APP_DIR . '/page/' . $page . '.php' );
		}
		else {
			include_once( APP_DIR . '/page/cheat-sheet-menu.php' );
		}
	}
	else {
		include_once( APP_DIR . '/page/cheat-sheet-menu.php' );
	}

	include_once( APP_DIR . '/page/footer.php');
}
