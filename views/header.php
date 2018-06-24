<?php
/**
 * Template part: Page header.
 *
 * @package PHPCheatsheets
 *
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent -- Fixing these creates trailing whitespace in the HTML output.
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Charset" content="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
if ( isset( $GLOBALS['autogen'] ) && $GLOBALS['autogen'] === true ) :
?>
	<!-- This static cheatsheet was AUTO-GENERATED with PHP <?php echo htmlspecialchars( PHP_VERSION, ENT_QUOTES, 'UTF-8' ), ' - ', date( 'r' ); ?>-->

<?php
endif;
$meta_title = htmlspecialchars( $GLOBALS['page_title'], ENT_QUOTES, 'UTF-8' );
if ( isset( $GLOBALS['tab_title'] ) && $GLOBALS['tab_title'] !== '' ) {
	$meta_title .= ' :: ' . $GLOBALS['tab_title'];
}
if ( isset( $type ) ) {
	$meta_title .= ' Cheatsheet for PHP ' . htmlspecialchars( PHP_VERSION, ENT_QUOTES, 'UTF-8' );
}
?>
	<title><?php echo $meta_title; ?></title>

	<meta name="description" content="Extended PHP Cheat sheets for variable comparisons and variable type testing." />
	<meta name="keywords" content="php, cheat sheet, cheatsheets, blueshoes, variable, type juggling, comparison, arithmetics, testing, defensive coding, defensive programming" />
	<meta name="author" content="Juliette Reinders Folmer, Advies en zo" />
	<meta name="copyright" content="Copyright Advies en zo - all rights reserved" />
	<meta name="language" content="en" />
	<meta name="distribution" content="global" />
	<meta name="robots" content="index,follow" />
	<meta name="revisit-after" content="4 weeks" />

<?php
unset( $meta_title );

if ( isset( $GLOBALS['type'] ) || isset( $GLOBALS['page'] ) ) :
?>
	<link type="text/css" rel="stylesheet" href="<?php echo BASE_URI; ?>page/jquery-css/jquery-ui<?php echo $GLOBALS['min']; ?>.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo BASE_URI; ?>page/jquery-css/jquery-ui.theme<?php echo $GLOBALS['min']; ?>.css" />
<?php
endif;
?>
	<link type="text/css" rel="stylesheet" href="<?php echo BASE_URI; ?>page/style<?php echo $GLOBALS['min']; ?>.css" />

<?php
if ( isset( $GLOBALS['type'] ) || isset( $GLOBALS['page'] ) ) :
?>
	<!-- jQuery via CDN with local fall-back -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type="text/javascript">(window.jQuery) || document.write('\x3Cscript type="text/javascript" src="<?php echo BASE_URI; ?>page/jquery-css/jquery-1.11.2<?php echo $GLOBALS['min']; ?>.js">\x3C/script>')</script>

	<!-- jQueryUI via CDN with local fall-back -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script type="text/javascript">(window.jQuery.ui) || document.write('\x3Cscript type="text/javascript" src="<?php echo BASE_URI; ?>page/jquery-css/jquery-ui-1.11.2<?php echo $GLOBALS['min']; ?>.js">\x3C/script>')</script>

	<!-- floating table headers -->
	<script type="text/javascript" src="<?php echo BASE_URI; ?>page/jquery.thfloat-0.7.2<?php echo $GLOBALS['min']; ?>.js"></script>
	<!-- custom js -->
	<script type="text/javascript" src="<?php echo BASE_URI; ?>page/interaction<?php echo $GLOBALS['min']; ?>.js"></script>
<?php
endif;
?>


	<link rel="start" href="http://phpcheatsheets.com/index.php" />
	<link rel="shortcut icon" href="http://phpcheatsheets.com/favicon.ico" />
	<link rel="bookmark icon" href="http://phpcheatsheets.com/favicon.ico" />
	<link rel="icon" href="http://phpcheatsheets.com/favicon.ico" type="image/ico" />

</head>
<?php
if ( ! isset( $GLOBALS['autogen'] ) || $GLOBALS['autogen'] !== true ) :
?>
<body>
<?php
else :
?>
<body class="static-archive">
<?php
endif;
?>

<div class="head">

<?php
if ( isset( $GLOBALS['type'] ) ) :
?>
	<div id="too-much">
		<a href="http://www.google.com/search?q=fluffy+animals&amp;tbm=isch" target="_blank"><img src="<?php echo BASE_URI; ?>page/images/jakobwesthoff_3231273333_2473ef9cdf_s.jpg" width="75" height="75" alt="Fluffy ElePHPant" /></a>
		<p>Too much ?</p>
		<p><a href="http://www.google.com/search?q=fluffy+animals&amp;tbm=isch" target="_blank">Take a break and rest your eyes</a>.</p>
	</div>
<?php
endif;
?>
	<a href="http://github.com/jrfnl/PHP-cheat-sheet-extended" class="forkme" title="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_left_orange_ff7600.png">&nbsp;</a>

	<h1><a href="<?php echo BASE_URI; ?>"><img src="<?php echo BASE_URI; ?>page/images/php-med-trans.png" width="95" height="51" alt="PHP" /> Cheatsheets</a></h1>

<?php
if ( isset( $GLOBALS['type'] ) || isset( $GLOBALS['page'] ) ) :
?>
	<div id="main-menu">
		<ul>
			<li><a href="<?php echo BASE_URI; ?>compare/" class="top-link<?php echo ( ( isset( $GLOBALS['type'] ) && $GLOBALS['type'] === 'compare' ) ? ' top-active' : '' ); ?>">Variable Comparisons</a></li>
			<li><a href="<?php echo BASE_URI; ?>arithmetic/" class="top-link<?php echo ( ( isset( $GLOBALS['type'] ) && $GLOBALS['type'] === 'arithmetic' ) ? ' top-active' : '' ); ?>">Variable Arithmetics</a></li>
			<li><a href="<?php echo BASE_URI; ?>test/" class="top-link<?php echo ( ( isset( $GLOBALS['type'] ) && $GLOBALS['type'] === 'test' ) ? ' top-active' : '' ); ?>">Variable Testing</a></li>
			<li><a href="<?php echo BASE_URI; ?>other-cheat-sheets/" class="top-link<?php echo ( ( isset( $GLOBALS['page'] ) && $GLOBALS['page'] === 'other-cheat-sheets' ) ? ' top-active' : '' ); ?>">More cheatsheets</a></li>
			<li class="top-link-small"><a href="<?php echo BASE_URI; ?>about/" class="top-link<?php echo ( ( isset( $GLOBALS['page'] ) && $GLOBALS['page'] === 'about' ) ? ' top-active' : '' ); ?>">About</a></li>
		</ul>
	</div>
<?php
endif;
?>
</div>

<div class="content-wrapper">
	<div class="content">

<?php
if ( isset( $GLOBALS['type'] ) || isset( $GLOBALS['page'] ) ) :
?>
	<h2><?php echo htmlspecialchars( $GLOBALS['page_title'], ENT_QUOTES, 'UTF-8' ); ?></h2>

<?php
endif;
