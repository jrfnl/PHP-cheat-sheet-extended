<?php

/**
 * Notify user of what we're doing
 */
echo 'Generating static sheets for PHP ' . PHP_VERSION . PHP_EOL;

/**
 * Allow as much memory as possible by default
 */
if ( extension_loaded( 'suhosin' ) && is_numeric( ini_get( 'suhosin.memory_limit' ) ) ) {
    $limit = ini_get( 'memory_limit' );
    if ( preg_match( '(^(\d+)([BKMGT]))', $limit, $match ) ) {
        $shift = array( 'B' => 0, 'K' => 10, 'M' => 20, 'G' => 30, 'T' => 40 );
        $limit = ( $match[1] * ( 1 << $shift[$match[2]] ) );
    }
    if ( ini_get( 'suhosin.memory_limit' ) > $limit && $limit > -1 ) {
        ini_set( 'memory_limit', ini_get( 'suhosin.memory_limit' ) );
    }
}
else {
    ini_set( 'memory_limit', -1 );
}


/**
 * Set the environment
 */
// One-up as we're in /bin
define( 'APP_DIR', dirname( dirname( __FILE__ ) ) );

include_once( APP_DIR . '/include/setup-env.php' );

// Overrule some variables
$min     = '.min';
$dir     = '../../';
$autogen = true;

define( 'SAVE_DIR', APP_DIR . '/static_results' );
define( 'QUIZ_DIR', APP_DIR . '/quiz' );
define( 'QUIZ_SAVE_DIR', QUIZ_DIR . '/static_results' );


/**
 * Helper function(s)
 */
function save_to_file( $filename, $content ) {
	if ( $content !== false && is_string( $content ) && $content !== '' ) {
		if ( file_put_contents( $filename, $content ) !== false ) {
			echo 'SUCCESS - created file : ' . $filename . PHP_EOL;
		}
		else {
			echo 'FAILED to WRITE file : ' . $filename . PHP_EOL;
		}
	}
	else {
		echo 'FAILED to GENERATE file : ' . $filename . PHP_EOL;
	}
}

function fix_content( $content ) {
	$regex_search = array(
		'`^[^<]*<!DOCTYPE html PUBLIC`', // Make sure there is nothing before the doctype
		'`\t+(?:<li[^>]*>)?<a href="[\./]*index\.php\?(?:type|page)=([a-z-]+)" class="top-link(?: top-active)?">([^<]+)(?:<br />Cheat sheet)?</a>(?:</li>)?`', // remove the top-active class
		'`<a href=(["\'])function\.`', // Make sure links to php.net are properly linked
	);


	$regex_replace = array(
		'<!DOCTYPE html PUBLIC',
		'			<li><a href="./../../index.php?page=$1" class="top-link">$2</a></li>',
		'<a href=$1http://php.net/function.',
	);
	

	return preg_replace( $regex_search, $regex_replace, $content );
}



/**
 * Generate the static sheets
 */

ignore_user_abort( true );

$types = array(
	'compare'    => 'PHP Variable Comparison',
	'arithmetic' => 'PHP Arithmetic Operations',
	'test'       => 'PHP Variable Testing',
);


foreach( $types as $type => $page_title ) {

	ob_start();

	/**
	 * Load a cheatsheet page
	 */
	$class = 'Vartype' . ucfirst( $type );
	$file  = 'class.vartype-' . $type . '.php';

	if ( isset( $type ) && file_exists( APP_DIR . '/' . $file ) ) {
		include_once( APP_DIR . '/' . $file );
		$current_tests = new $class();
	
		$tab = null;

		include_once( APP_DIR . '/page/header.php' );
		include_once( APP_DIR . '/page/notes-legend.php' );

		$current_tests->do_page( true );

		include_once( APP_DIR . '/page/footer.php');
	}

	$static_page = ob_get_clean();
	$filename    = SAVE_DIR . '/php' . PHP_VERSION . '.html';

	save_to_file( $filename, $static_page );
}
unset( $type, $page_title, $class, $file, $current_tests, $tab, $static_page, $filename );



if ( is_dir( QUIZ_DIR ) ) {
	ob_start();
	
	$page_title = 'My quiz test';
	
	include_once( APP_DIR . '/page/header.php' );
	include_once( QUIZ_DIR . '/20131005-questions.php' );

	if ( PHP_VERSION_ID >= 50000 ) {
		include_once( QUIZ_DIR . '/20131005-questions-php5.php' );
		spl_question();
	}

	include_once( APP_DIR . '/page/footer.php');

	$static_page = ob_get_clean();
	$filename    = QUIZ_SAVE_DIR . '/php' . PHP_VERSION . '.html';

	save_to_file( $filename, $static_page );
}

ignore_user_abort( false );

