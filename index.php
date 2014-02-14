<?php

if ( ! defined( 'E_STRICT' ) ) {
	define( 'E_STRICT', 2048 );
}
error_reporting( E_ALL & ~E_STRICT );
@ini_set( 'log_errors', false );


define( 'APP_DIR', dirname( __FILE__ ) );

include_once( APP_DIR . '/include/xvardump.php' );
include_once( APP_DIR . '/include/functions.php' );
set_error_handler( 'do_handle_errors' );

if ( ! defined( 'PHP_VERSION_ID' ) ) {
	$version = PHP_VERSION;
	define( 'PHP_VERSION_ID', (int) ( $version{0} * 10000 + $version{2} * 100 + $version{4} ) );
}

// Use C locale for Ctype functions
setlocale( LC_CTYPE, 'C' );

// Set timezone
if ( PHP_VERSION_ID > 50100 ) {
	date_default_timezone_set( 'UTC' );
}


// Minified js & css ?
//$min = '';
$min = '.min';

// js & css directory change ?
$dir = '';



$type = null;
$page = null;
$page_title = 'PHP Cheat Sheets';

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
			$page_title = 'More PHP Cheat Sheets';
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

if ( isset( $type ) && file_exists( APP_DIR . '/' . $file ) ) {
	include_once( APP_DIR . '/' . $file );
	$current_tests = new $class();
	
	$tab = null;
	if ( isset( $_GET['tab'] ) && $_GET['tab'] !== '' ) {
		$tab = $_GET['tab'];
	}

	if ( isset( $_GET['do'] ) && $_GET['do'] === 'ajax' ) {
		$current_tests->run_test( $tab );
	}
	else {
		include_once( APP_DIR . '/page/header.php' );
		include_once( APP_DIR . '/page/notes-legend.php' );
		
		$all = false;
		if ( isset( $_GET['all'] ) && $_GET['all'] === '1' ) {
			// Hidden feature - pre-load all tabs, slow, but useful for source compare & generating of static files
			$all = true;
		}
		$current_tests->do_page( $all );

		include_once( APP_DIR . '/page/footer.php');
	}
}
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
