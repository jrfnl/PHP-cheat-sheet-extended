<?php
/**
 * Define additional PHP 5.4+ test variables.
 *
 * @package PHPCheatsheets
 *
 * @phpcs:disable PHPCompatibility.Miscellaneous.ValidIntegers.BinaryIntegerFound -- This file is targetting PHP 5.4+.
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

$test_array['ia'] = 0b0111001; // Binary integer 57 - legend set in vars-to-test.php.
