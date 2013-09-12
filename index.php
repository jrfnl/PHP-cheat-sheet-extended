<?php

error_reporting( E_ALL );
//@ini_set( 'log_errors', false );


include_once( 'include/xvardump.php' );
include_once( 'include/functions.php' );
set_error_handler( 'do_handle_errors' );


if ( !defined( 'PHP_VERSION_ID' ) ) {
	$version = PHP_VERSION;
	define( 'PHP_VERSION_ID', ( $version{0} * 10000 + $version{2} * 100 + $version{4} ) );
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

if ( isset( $type ) && file_exists( $file ) ) {
	include_once( $file );
	$current_tests = new $class();
	
	$tab = null;
	if ( isset( $_GET['tab'] ) && $_GET['tab'] !== '' ) {
		$tab = $_GET['tab'];
	}

	if ( isset( $_GET['do'] ) && $_GET['do'] === 'ajax' ) {
		$current_tests->run_test( $tab );
	}
	else {
		include_once( 'page/header.php' );
		
		$all = false;
		if ( isset( $_GET['all'] ) && $_GET['all'] === 1 ) {
			$all = true;
		}
		$current_tests->do_page( /*$tab,*/ $all );

		include_once( 'page/footer.php');
	}
}
else {
	include_once( 'page/header.php' );
	include_once( 'page/cheat-sheet-menu.php' );
	include_once( 'page/footer.php');
}



?>