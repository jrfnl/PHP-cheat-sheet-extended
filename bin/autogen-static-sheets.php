<?php

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


$success = 0;
$failure = 0;

/**
 * Interpret expected command line argument(s)
 */
$verbose = 0;
if ( isset( $argv[1] ) && strpos( $argv[1], 'verbose=' ) === 0 ) {
	$v = explode( '=', $argv[1] );
	$v[1] = (int) $v[1];
	if ( $v[1] === 1 || $v[1] === 2 ) {
		$verbose = $v[1];
	}
	unset( $v );
}


/**
 * Helper function(s)
 */
function save_to_file( $filename, $content ) {
	$msg = '';

	if ( $content !== false && is_string( $content ) && $content !== '' ) {
		
		if ( strpos( $content, '</body>' ) !== false ) {
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
		echo $msg . PHP_EOL;
	}
}

function fix_content( $content ) {
	$search = array(
		0  => '<span>Browse <a href="./static_results">other versions</a>.</span>',
		/*1  => '	<meta http-equiv="Charset" content="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />',*/
		//2  => '<head>',
	
		3  => '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>',
		4  => '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>',
	
		5  => '<body>',
		6  => '<div class="head">
		<p><a href="http://adviesenzo.nl/"><img src="http://adviesenzo.nl/images/logo_dpi120.gif" width="411" height="80" alt="Logo Advies en zo, Meedenken en -doen" /></a></p>',
	
		7  => '<link rel="start" href="http://www.adviesenzo.nl/index.html" />',
		8  => '<img src="./page/',
		9  => '<code>E_ALL ^ E_STRICT</code>',
		10 => '<span class="int"><b class="int-0">0</b></span>',
		11 => '<span class="int"><b><i>int</i></b> : <b class="int-0">0</b></span>',

		12 => '</div><!-- end of class content -->
	
	<div class="footer">',
		'<p id="copyright">&copy;2006-2013 <a href="http://adviesenzo.nl/">Advies en zo, Meedenken en -doen</a></p>
	</div>',
	);
	
	
	$replace = array(
		0  => '<span>Browse <a href="./../static_results">other versions</a>.</span>', // replace slightly below
		//1  => '', // remove old charset tags
		/*2  => '<head>
	<meta http-equiv="Charset" content="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
',*/

		3  => '<!-- jQuery via CDN with local fall-back -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript">(window.jQuery) || document.write(\'\x3Cscript type="text/javascript" src="./../../page/jquery-css/jquery-1.11.0.min.js">\x3C/script>\')</script>
',
		4  => '<!-- jQueryUI via CDN with local fall-back -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript">(window.jQuery.ui) || document.write(\'\x3Cscript type="text/javascript" src="./../../page/jquery-css/jquery-ui-1.10.4.min.js">\x3C/script>\')</script>
',

		5  => '<body class="static-archive">',
		6  => '<div class="head">

	<div id="too-much">
		<a href="http://www.google.com/search?q=fluffy+animals&amp;tbm=isch" target="_blank"><img src="./page/jakobwesthoff_3231273333_2473ef9cdf_s.jpg" width="75" height="75" alt="Fluffy ElePHPant" /></a>
		<p>Too much ?</p>
		<p><a href="http://www.google.com/search?q=fluffy+animals&amp;tbm=isch" target="_blank">Take a break and rest your eyes</a>.</p>
	</div>

	<h1><a href="http://phpcheatsheets.com/"><img src="./page/php-med-trans.png" width="95" height="51" alt="PHP" /> Cheatsheets</a></h1>',
	
		7  => '<link rel="start" href="http://phpcheatsheets.com/index.php" />',
		8  => '<img src="./../../page/',
		9  => '<code>E_ALL &amp; ~E_STRICT</code>',
		10 => '<span class="int"><span class="int-0">0</span></span>',
		11 => '<span class="int"><b><i>int</i></b> : <span class="int-0">0</span></span>',

		12 => '	</div><!-- end of class content -->
</div><!-- end of class content-wrapper -->

<div class="footer"><div>',
	'<p id="copyright">&copy; 2006-2014 <a href="http://adviesenzo.nl/">Advies en zo, Meedenken en -doen</a></p>
</div></div>',
	);
	
	$regex_search = array(
		0  => '`^[^<]+<!DOCTYPE html PUBLIC`',
		1  => '`<link type="text/css" rel="stylesheet" href="\./page/([^"]+?)(\.min)*\.css`',
		2  => '`(<|\x3C)script type="text/javascript" src="\./page/([^"]+?)(\.min)*\.js`',
		3  => '`class="top-link">Variable (Comparison|Arithmetic)([^s])`',
		4  => '`\t+(?:<li([^>]*)>)?<a href="[\./]*index\.php\?(?:type|page)=([a-z-]+)" class="top-link(?: top-active)?">([^<]+)(?:<br />Cheat sheet)?</a>(?:</li>)?`',
		5  => '`<a href=(["\'])function\.`',
		6  => '`<link rel="([^"]+)" href="http://(?:www\.)?adviesenzo\.nl/([^"]+)"`',
		7  => '`<th><span title="Array: \(\s+\)\s+">Array\(&hellip;\)</span>\s+</th>`',
		8  => '`Array: \(<br />\s+\)<br />\s+`',
		9  => '`<t([dh])([^>]*)?>array\(\)<br />\s+</t\1>`',

		//10 => '`(?: on phpcheatsheets\.com)?</title>`', // prevent double replace
		//11 => '`\t+<div id="main-menu">(?:\s+<ul>)?`', // prevent double replace
		12 => '`\t*</div>\s+</div>\s+<div class="content">\s+<h1>([^<]+) Cheat Sheet</h1>\s+<h2 id="php-version">\s+This page has been generated with <strong>PHP ([0-9\.]+)</strong>\s+<span>Browse <a href="[\./]*static_results">other versions</a>\.</span>\s+</h2>`',
	);


	$regex_replace = array(
		0  => '<!DOCTYPE html PUBLIC',
		1  => '<link type="text/css" rel="stylesheet" href="./../../page/$1.min.css',
		2  => '$1script type="text/javascript" src="./../../page/$2.min.js',
		3  => 'class="top-link">Variable $1s$2',
		4  => '			<li$1><a href="./../../index.php?page=$2" class="top-link">$3</a></li>',
		5  => '<a href=$1http://php.net/function.',
		6  => '<link rel="$1" href="http://phpcheatsheets.com/$2"',
		7  => '<th>array()<br />					</th>',
		8  => 'array()<br />',
		9  => '<t$1$2>array()<br /></t$1>',

		//10 => ' on phpcheatsheets.com</title>',
		/*11 => '	<div id="main-menu">
		<ul>',*/
		12 => '			<li><a href="./../../index.php?page=other-cheat-sheets" class="top-link">More cheat sheets</a></li>
			<li class="top-link-small"><a href="./../../index.php?page=about" class="top-link">About</a></li>
		</ul>
	</div>
</div>

<div class="content-wrapper">
	<div class="content">

	<h2>$1</h2>

	<div id="sidebar">
		<h3 id="php-version">
			This page has been generated with <strong>PHP $2</strong>
			<span>Browse <a href="./../../static_results">other versions</a>.</span>
		</h3>
	</div>
',
	);
	
	/*
	$regex_search = array(
		1 => '`^[^<]*<!DOCTYPE html PUBLIC`', // #1: Make sure there is nothing before the doctype
		2 => '`\t+(?:<li[^>]*>)?<a href="[\./]*index\.php\?(?:type|page)=([a-z-]+)" class="top-link(?: top-active)?">([^<]+)(?:<br />Cheat sheet)?</a>(?:</li>)?`', // #2: remove the top-active class
		3 => '`<a href=(["\'])function\.`', // #3: Make sure links to php.net are properly linked
		// Tidy up whitespace
		//4 => '`<th><span title="Array: \(\s+\)\s+">Array\(&hellip;\)</span>\s+</th>`', // #4
		//5 => '`Array: \(<br />\s+\)<br />\s+`', // #5
		6 => '`<t([dh])([^>]*)?>array\(\)<br />\s+</t\1>`', // #6
	);


	$regex_replace = array(
		1 => '<!DOCTYPE html PUBLIC',
		2 => '			<li><a href="./../../index.php?page=$1" class="top-link">$2</a></li>',
		3 => '<a href=$1http://php.net/function.',
		//4 => '<th>array()<br />					</th>',
		//5 => 'array()<br />',
		6 => '<t$1$2>array()<br /></t$1>',
	);
	*/

	if( $GLOBALS['verbose'] !== 2 ) {
		$content = str_replace( $search, $replace, $content );
		$content = preg_replace( $regex_search, $regex_replace, $content );
	}
	else {
		/**
		 * Verbose output showing how many replacements were done of which type to see if anything should
		 * be optimized within the html code generation.
		 */
		echo PHP_EOL . 'Preparing file content... ' . PHP_EOL;

		foreach ( $search as $key => $string ) {
			$content = str_replace( $string, $replace[ $key ], $content, $count );
	
			if( $count > 0 ) {
				echo 'String #' . $key . ' : ' . $count . ' replacements made.'  . PHP_EOL;
			}
		}
		unset( $key, $string, $count );
	
		if ( PHP_VERSION_ID >= 50100 ) {
			foreach ( $regex_search as $key => $regex ) {
				$content = preg_replace( $regex, $regex_replace[ $key ], $content, -1, $count );
	
				if( $count > 0 ) {
					echo 'Regex #' . $key . ' : ' . $count . ' replacements made.'  . PHP_EOL;
				}
			}
			unset( $key, $string, $count );
		}
		else {
			// $count parameter does not exist pre-PHP 5.1.0
			$content = preg_replace( $regex_search, $regex_replace, $content );
		}
	}

	return $content;
}



/**
 * Generate the static sheets
 */

ignore_user_abort( true );

/**
 * Notify user of what we're doing
 */
if ( $verbose > 0 ) {
	echo PHP_EOL . 'Generating static sheets for PHP ' . PHP_VERSION . PHP_EOL;
	echo '----------------------------------------' . PHP_EOL;
}


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

		include( APP_DIR . '/page/header.php' );
		include( APP_DIR . '/page/notes-legend.php' );

		$current_tests->do_page( true );

		include( APP_DIR . '/page/footer.php');
	}

	$static_page = ob_get_clean();
	$filename    = SAVE_DIR . '/' . $type .'/php' . PHP_VERSION . '.html';

	save_to_file( $filename, $static_page );
}
unset( $type, $page_title, $class, $file, $current_tests, $tab, $static_page, $filename );



if ( is_dir( QUIZ_DIR ) && is_file( QUIZ_DIR . 'quiz.php' ) ) {
	ob_start();
	
	$page_title = 'My quiz test';
	
	include( APP_DIR . '/page/header.php' );
	include( QUIZ_DIR . '/20131005-questions.php' );

	if ( PHP_VERSION_ID >= 50000 ) {
		include( QUIZ_DIR . '/20131005-questions-php5.php' );
		spl_question();
	}

	include( APP_DIR . '/page/footer.php');

	$static_page = ob_get_clean();
	$filename    = QUIZ_SAVE_DIR . '/php' . PHP_VERSION . '.html';

	save_to_file( $filename, $static_page );
}

ignore_user_abort( false );

exit( ( $success * 10 ) + $failure );