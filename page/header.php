<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Charset" content="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title><?php print htmlspecialchars( $page_title, ENT_QUOTES, 'UTF-8' ) . ( isset( $type ) ? ' - tests run using PHP ' . htmlspecialchars( PHP_VERSION, ENT_QUOTES, 'UTF-8' ) . ' on phpcheatsheets.com' : '' ); ?></title>

	<meta name="description" content="Extended PHP Cheat sheets for variable comparisons and variable type testing." />
	<meta name="keywords" content="php, cheat sheet, blueshoes, variable, type juggling, comparison, testing" />
	<meta name="author" content="Juliette Reinders Folmer, Advies en zo" />
	<meta name="copyright" content="Copyright Advies en zo - all rights reserved" />
	<meta name="language" content="en" />
	<meta name="distribution" content="global" />
	<meta name="robots" content="index,follow" />
	<meta name="revisit-after" content="4 weeks" />

<?php
if ( isset( $type ) ): ?>
	<link type="text/css" rel="stylesheet" href="./<?php if ( isset( $dir ) ) print $dir; ?>page/jquery-css/jquery-ui.min.css" />
	<link type="text/css" rel="stylesheet" href="./<?php if ( isset( $dir ) ) print $dir; ?>page/jquery-css/jquery.ui.theme.css" />
<?php
endif; ?>
	<link type="text/css" rel="stylesheet" href="./<?php if ( isset( $dir ) ) print $dir; ?>page/style<?php if ( isset( $min ) ) print $min; ?>.css" />

<?php
if ( isset( $type ) ): ?>
	<!-- jQuery via CDN with local fall-back -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript">(window.jQuery) || document.write('\x3Cscript type="text/javascript" src="./<?php if ( isset( $dir ) ) print $dir; ?>page/jquery-css/jquery-1.11.0<?php if ( isset( $min ) ) print $min; ?>.js">\x3C/script>')</script>

	<!-- jQueryUI via CDN with local fall-back -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript">(window.jQuery.ui) || document.write('\x3Cscript type="text/javascript" src="./<?php if ( isset( $dir ) ) print $dir; ?>page/jquery-css/jquery-ui-1.10.4<?php if ( isset( $min ) ) print $min; ?>.js">\x3C/script>')</script>

	<!-- floating table headers -->
	<script type="text/javascript" src="./<?php if ( isset( $dir ) ) print $dir; ?>page/jquery.thfloat-0.7.2<?php if ( isset( $min ) ) print $min; ?>.js"></script>
<?php
endif; ?>
	<!-- custom js -->
	<script type="text/javascript" src="./<?php if ( isset( $dir ) ) print $dir; ?>page/interaction<?php if ( isset( $min ) ) print $min; ?>.js"></script>


	<link rel="start" href="http://phpcheatsheets.com/index.php" />
	<link rel="shortcut icon" href="http://phpcheatsheets.com/favicon.ico" />
	<link rel="bookmark icon" href="http://phpcheatsheets.com/favicon.ico" />
	<link rel="icon" href="http://phpcheatsheets.com/favicon.ico" type="image/ico" />


</head>


<body>
<div class="head">

	<?php
	if ( isset( $type ) ): ?>
	<div id="too-much">
		<a href="http://www.google.com/search?q=fluffy+animals&amp;tbm=isch" target="_blank"><img src="./<?php if ( isset( $dir ) ) print $dir; ?>page/jakobwesthoff_3231273333_2473ef9cdf_s.jpg" width="75" height="75" alt="Fluffy ElePHPant" /></a>
		<p>Too much ?</p>
		<p><a href="http://www.google.com/search?q=fluffy+animals&amp;tbm=isch" target="_blank">Take a break and rest your eyes</a>.</p>
	</div>
<?php
	endif;
?>

	<h1><a href="http://phpcheatsheets.com/"><img src="./<?php if ( isset( $dir ) ) print $dir; ?>page/php-med-trans.png" width="95" height="51" alt="PHP" /> Cheatsheets</a></h1>

	<?php
	if ( isset( $type ) || isset( $page ) ): ?>
	<div id="main-menu">
		<ul>
			<li><a href="index.php?page=compare" class="top-link<?php if ( isset( $type ) && $type === 'compare' ) print ' top-active'; ?>">Variable Comparisons</a></li>
			<li><a href="index.php?page=arithmetic" class="top-link<?php if ( isset( $type ) && $type === 'arithmetic' ) print ' top-active'; ?>">Variable Arithmetics</a></li>
			<li><a href="index.php?page=test" class="top-link<?php if ( isset( $type ) && $type === 'test' ) print ' top-active'; ?>">Variable Testing</a></li>
			<li><a href="index.php?page=other-cheat-sheets" class="top-link<?php if ( isset( $page ) && $page === 'other-cheat-sheets' ) print ' top-active'; ?>">More cheat sheets</a></li>
		</ul>
	</div>
<?php
	endif;
?>
</div>

<div class="content-wrapper">
	<div class="content">

	<?php
	if ( isset( $type ) || isset( $page ) ): ?>
	<h2><?php print htmlspecialchars( $page_title, ENT_QUOTES, 'UTF-8' ); ?></h2>

	<?php
	endif;?>