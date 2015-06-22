<?php
/**
 * Script to autogenerate static HTML files representing the test results on a specific PHP version.
 *
 * @package PHPCheatsheets
 */

/**
 * Allow as much memory as possible by default.
 */
if ( extension_loaded( 'suhosin' ) && is_numeric( ini_get( 'suhosin.memory_limit' ) ) ) {
	$limit = ini_get( 'memory_limit' );
	if ( preg_match( '(^(\d+)([BKMGT]))', $limit, $match ) ) {
		$shift = array( 'B' => 0, 'K' => 10, 'M' => 20, 'G' => 30, 'T' => 40 );
		$limit = ( $match[1] * ( 1 << $shift[ $match[2] ] ) );
	}
	if ( ini_get( 'suhosin.memory_limit' ) > $limit && $limit > -1 ) {
		ini_set( 'memory_limit', ini_get( 'suhosin.memory_limit' ) );
	}
}
else {
	ini_set( 'memory_limit', -1 );
}


/**
 * Set the environment.
 */
// One-up as we're in /bin
define( 'APP_DIR', dirname( dirname( __FILE__ ) ) );

include_once APP_DIR . '/include/setup-env.php';

// Overrule some variables
$min     = '.min';
$autogen = true;

define( 'SAVE_DIR', APP_DIR . '/static_results' );
define( 'QUIZ_DIR', APP_DIR . '/quiz' );
define( 'QUIZ_SAVE_DIR', QUIZ_DIR . '/static_results' );


$success = 0;
$failure = 0;

/**
 * Interpret expected command line argument(s).
 */
$verbose = 0;
if ( isset( $argv[1] ) && strpos( $argv[1], 'verbose=' ) === 0 ) {
	$v    = explode( '=', $argv[1] );
	$v[1] = (int) $v[1];
	if ( $v[1] === 1 || $v[1] === 2 ) {
		$verbose = $v[1];
	}
	unset( $v );
}


/**
 * Save the html page to disk.
 *
 * @param string $filename
 * @param string $content
 */
function save_to_file( $filename, $content ) {
	$msg = '';

	if ( $content !== false && is_string( $content ) && $content !== '' ) {

		if ( strpos( $content, '</body>' ) !== false && strpos( $content, '\Blueshoes extended\PHP-cheat-sheet-extended' ) === false ) {
			$content = fix_content( $content );

			if ( file_put_contents( $filename, $content ) !== false ) {
				$msg = 'SUCCESS - created file : ' . str_replace( APP_DIR, '', $filename );
				$GLOBALS['success']++;
			}
			else {
				$msg = 'FAILED to WRITE file : ' . str_replace( APP_DIR, '', $filename );
				$GLOBALS['failure']++;
			}
		}
		else {
			$msg = 'FAILED : FATAL ERROR encountered while generating file : ' . str_replace( APP_DIR, '', $filename );
			$GLOBALS['failure']++;
		}
	}
	else {
		$msg = 'FAILED to GENERATE file : ' . str_replace( APP_DIR, '', $filename );
		$GLOBALS['failure']++;
	}

	if ( $GLOBALS['verbose'] > 0 ) {
		echo $msg, PHP_EOL;
	}
}


/**
 * Make sure the html is up to scratch.
 *
 * @param string $content
 *
 * @return string
 */
function fix_content( $content ) {

	$search = array(
		// Make sure there are no references to the local version left
		0  => '://phpcheatsheets.localdev/',
		1  => '<body>',
	);

	$replace = array(
		0  => '://phpcheatsheets.com/',
		1  => '<body class="static-archive">',
	);

	// @todo Verify which rules are still needed in the renewed version.
	$regex_search = array(
		// Make sure there is nothing before the doctype.
		0  => '`^[^<]+<!DOCTYPE html PUBLIC`',
		// Make sure any potential links to php.net are properly linked.
		5  => '`<a href=(["\'])function\.`',
		// Tidy up html whitespace around array prints.
		7  => '`<th><span title="Array: \(\s+\)\s+">Array\(&hellip;\)</span>\s+</th>`',
		8  => '`Array: \(<br />\s+\)<br />\s+`',
		9  => '`<t([dh])([^>]*)?>array\(\)<br />\s+</t\1>`',
		// Make sure the correct PHP version nr for the live sheets is shown in the version dropdown.
		10 => '`<option value="live"(?: selected="selected")?\s*>PHP [0-9\.-]+(?:(?:alpha|beta|rc)(?:[0-9])?)?</option>`',
		// Make chosen PHP version persistent.
		12 => '`<a href="http://([a-z\.-]+)/(arithmetic|compare|test)/" class="top-link(?: top-active)?">`',
		// Make sure any potential links to php.net are properly linked.
		13  => '`\[(http://php\.net/manual/([^\]]+))\]`',
		// HTML attributes should be using double quotes.
		14  => '`<a href=\'([^\']+)\'`',
	);

	$regex_replace = array(
		0  => '<!DOCTYPE html PUBLIC',
		5  => '<a href=$1http://php.net/function.',
		7  => '<th>array()<br />					</th>',
		8  => 'array()<br />',
		9  => '<t$1$2>array()<br /></t$1>',
		10 => '<option value="live">PHP 5.4.13</option>', // IMPORTANT! Change this if the PHP version on the server changes!!
		12 => '<a href="http://$1/index.php?page=$2&amp;phpversion=php' . PHP_VERSION . '" class="top-link$3">',
		13 => '[<a href="$1">$2</a>]',
		14 => '<a href="$1"',
	);


	if ( $GLOBALS['verbose'] !== 2 ) {
		$content = str_replace( $search, $replace, $content );
		$content = preg_replace( $regex_search, $regex_replace, $content );
	}
	else {
		/**
		 * Verbose output showing how many replacements were done of which type to see if anything should
		 * be optimized within the html code generation.
		 */
		echo PHP_EOL, 'Preparing file content... ', PHP_EOL;


		foreach ( $search as $key => $string ) {
			$content = str_replace( $string, $replace[ $key ], $content, $count );

			if ( $count > 0 ) {
				echo 'String #', $key, ' : ', $count, ' replacements made.', PHP_EOL;
			}
		}
		unset( $key, $string, $count );


		if ( PHP_VERSION_ID >= 50100 ) {
			foreach ( $regex_search as $key => $regex ) {
				$content = preg_replace( $regex, $regex_replace[ $key ], $content, -1, $count );

				if ( $count > 0 ) {
					echo 'Regex #', $key, ' : ', $count, ' replacements made.', PHP_EOL;
				}
			}
			unset( $key, $regex, $count );
		}
		else {
			// The $count parameter does not exist pre-PHP 5.1.0
			$content = preg_replace( $regex_search, $regex_replace, $content );
		}
	}

	return $content;
}


/**
 * Generate the static sheets.
 */
ignore_user_abort( true );

// Notify user of what we're doing.
if ( $verbose > 0 ) {
	echo PHP_EOL, 'Generating static sheets for PHP ', PHP_VERSION, PHP_EOL;
	echo '----------------------------------------', PHP_EOL;
}


$types = array(
	'compare'    => 'PHP Variable Comparison',
	'arithmetic' => 'PHP Arithmetic Operations',
	'test'       => 'PHP Variable Testing',
);

if ( is_dir( QUIZ_DIR ) && is_file( QUIZ_DIR . '/quiz.php' ) ) {
	ob_start();

	include QUIZ_DIR . '/quiz.php';

	$static_page = ob_get_clean();
	$filename    = QUIZ_SAVE_DIR . '/php' . PHP_VERSION . '.html';

	save_to_file( $filename, $static_page );
}

foreach ( $types as $type => $page_title ) {

	ob_start();

	/**
	 * Load a cheatsheet page.
	 */
	$class = 'Vartype' . ucfirst( $type );
	$file  = 'class.vartype-' . $type . '.php';

	if ( isset( $type ) && file_exists( APP_DIR . '/' . $file ) ) {
		include_once APP_DIR . '/' . $file;
		$current_tests = new $class();

		$tab = null;

		include APP_DIR . '/views/header.php';
		include APP_DIR . '/views/notes-legend.php';

		$current_tests->do_page( true );

		include APP_DIR . '/views/footer.php';
	}

	$static_page = ob_get_clean();
	$filename    = SAVE_DIR . '/' . $type .'/php' . PHP_VERSION . '.html';

	save_to_file( $filename, $static_page );
}
unset( $type, $page_title, $class, $file, $current_tests, $tab, $static_page, $filename );


ignore_user_abort( false );

if ( $GLOBALS['verbose'] > 0 ) {
	echo "\nexit code";
	var_dump( ( ( $success * 10 ) + $failure ) );
}

exit( ( $success * 10 ) + $failure );
