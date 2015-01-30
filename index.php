<?php

/**
 * Catch requests for static files (which have not been caught by htaccess)
 */
if ( ( isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'arithmetic', 'compare', 'test' ), true ) ) && ( isset( $_GET['phpversion'] ) && preg_match( '`^php[457](?:\.[0-9]+){2}(?:-[0-9])?$`', $_GET['phpversion'] ) ) ) {
	$file = './static_results/' . $_GET['page'] . '/' . $_GET['phpversion'] . '.html';
	if ( is_file( $file ) ) {

		$tab = '';
		if ( isset( $_GET['tab'] ) && preg_match( '`[a-z0-9_-]+`', $_GET['tab'] ) ) {
			$tab = '#' . $_GET['tab'];
		}

		$host = $_SERVER['HTTP_HOST'];
		$url  = 'http://' . $host . '/static_results/' . $_GET['page'] . '/' . $_GET['phpversion'] . '.html' . $tab;
		header( "Location: $url", true, 301 );
		exit;
	}
	else {
		// 404 not found
		$_GET['page'] = 'error';
		$_GET['e']    = '404';
	}
}


define( 'APP_DIR', dirname( __FILE__ ) );

include_once APP_DIR . '/include/setup-env.php';

/**
 * Determine what has been requested
 */
$type       = null;
$page       = null;
$tab        = null;
$page_title = 'PHP Cheatsheets';

if ( isset( $_GET['page'] ) ) {
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
			$page       = 'other-cheat-sheets';
			$page_title = 'More PHP Cheatsheets';
			break;

		case 'about':
			$page       = 'about';
			$page_title = 'About phpcheatsheets.com';
			break;

		case 'error':
		default:
			$page       = 'error';
			$page_title = 'Page not found';
			$protocol   = ( ( isset( $_SERVER['SERVER_PROTOCOL'] ) && $_SERVER['SERVER_PROTOCOL'] !== '' && preg_match( '`HTTP/1\.[0-9]`', $_SERVER['SERVER_PROTOCOL'] ) ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1' );
			header( "$protocol 404 Not Found" );
			break;
	}
}


// Send headers
header( 'Content-type: text/html; charset=utf-8' );


$class = 'Vartype' . ucfirst( $type );
$file  = 'class.vartype-' . $type . '.php';

/**
 * Load a cheatsheet page
 */
if ( isset( $type ) && file_exists( APP_DIR . '/' . $file ) ) {
	include_once APP_DIR . '/' . $file;
	$current_tests = new $class();

	if ( isset( $_GET['tab'] ) && $_GET['tab'] !== '' ) {
		$tab = $_GET['tab']; // wpcs: ok - validation is done before use in VarType::get_test_group() method
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
		include_once APP_DIR . '/views/header.php';
		include_once APP_DIR . '/views/notes-legend.php';

		// Hidden feature - pre-load all tabs, slow, but useful for source compare & generating of static files
		$all = false;
		if ( isset( $_GET['all'] ) && $_GET['all'] === '1' ) {
			$all = true;
			ini_set( 'max_execution_time', '180' ); // lengthen allowed execution time
		}

		$current_tests->do_page( $all );

		include_once APP_DIR . '/views/footer.php';
	}
}

/**
 * Load an extraneous page (about, links etc)
 */
else {
	include_once APP_DIR . '/views/header.php';

	if ( isset( $page ) && $page !== '' ) {
		if ( file_exists( APP_DIR . '/views/' . $page . '.html' ) ) {
			include_once APP_DIR . '/views/' . $page . '.html';
		}
		else if ( file_exists( APP_DIR . '/views/' . $page . '.php' ) ) {
			include_once APP_DIR . '/views/' . $page . '.php';
		}
		else {
			include_once APP_DIR . '/views/cheat-sheet-menu.php';
		}
	}
	else {
		include_once APP_DIR . '/views/cheat-sheet-menu.php';
	}

	include_once APP_DIR . '/views/footer.php';
}
