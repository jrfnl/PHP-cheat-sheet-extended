<?php

error_reporting( E_ALL ^ E_STRICT );
//@ini_set( 'log_errors', false );

define( 'APP_DIR', dirname( __FILE__ ) );


include_once( APP_DIR . '/include/xvardump.php' );
include_once( APP_DIR . '/include/functions.php' );
set_error_handler( 'do_handle_errors' );


if ( !defined( 'PHP_VERSION_ID' ) ) {
	$version = PHP_VERSION;
	define( 'PHP_VERSION_ID', (int) ( $version{0} * 10000 + $version{2} * 100 + $version{4} ) );
}

// Use C locale for Ctype functions
setlocale( LC_CTYPE, 'C' );


// Minified js & css ?
$min = '';
//$min = '.min';

// js & css directory change ?
$dir = '';



$type = null;
$page_title = 'PHP Variable comparison and type testing cheat sheets';

if ( isset( $_GET['type'] ) && $_GET['type'] === 'compare' ) {
	$type       = 'compare';
	$page_title = 'PHP Variable Comparison Cheat Sheet';
}
else if ( isset( $_GET['type'] ) && $_GET['type'] === 'arithmetic' ) {
	$type       = 'arithmetic';
	$page_title = 'PHP Arithmetic Operations Cheat Sheet';
}
else if ( isset( $_GET['type'] ) && $_GET['type'] === 'test' ) {
	$type       = 'test';
	$page_title = 'PHP Variable Testing Cheat Sheet';
}




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
		
		$all = false;
		if ( isset( $_GET['all'] ) && $_GET['all'] === '1' ) {
			// Hidden feature - pre-load all tabs, slow, but useful for source compare
			$all = true;
		}
		$current_tests->do_page( $all );

		include_once( APP_DIR . '/page/footer.php');
	}
}
else {
	include_once( APP_DIR . '/page/header.php' );
	include_once( APP_DIR . '/page/cheat-sheet-menu.php' );
	include_once( APP_DIR . '/page/footer.php');
}



?>