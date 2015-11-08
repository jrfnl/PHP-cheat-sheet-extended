<?php
/**
 * PHP 7+ tests.
 *
 * @package PHPCheatsheets
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * Overload some tests when using PHP7.
 *
 * These tests are added in the relevant child class of the Vartype class.
 */
class VartypePHP7 {

	/**
	 * The PHP7 specific tests.
	 *
	 * @var array $tests  Multi-dimensional array.
	 */
	public static $tests = array(
		/**
		 * Functions where errors have been turned into exceptions.
		 * @see class.vartype-arithmetic.php
		 */
		'modulus'        => array(
			'function'      => 'VartypePHP7::do_modulus( $a, $b );',
		),
		'intdiv'           => array(
			'function'      => 'VartypePHP7::do_intdiv( $a, $b );',
		),
	);


	/**
	 * Helper method to retrieve the static variable.
	 * Needed to prevent parse error in PHP4.. *sigh*.
	 *
	 * @return array
	 */
	public static function get_tests() {
		return self::$tests;
	}


	/**
	 * PHP7 compatible version of % arithmetics.
	 *
	 * @param mixed $var1
	 * @param mixed $var2
	 */
	public static function do_modulus( $var1, $var2 ) {
		try {
			$result = ( $var1 % $var2 );
			if ( is_bool( $result ) ) {
				pr_bool( $result );
			}
			else {
				pr_var( $result, '', true, true );
			}
		}
		catch ( Error $e ) {
			$message = '<span class="error">(Catchable) Fatal error</span>: ' . $e->getMessage();
			self::handle_exception( $message );
		}
	}


	/**
	 * Test intdiv.
	 *
	 * @param mixed $var1
	 * @param mixed $var2
	 */
	public static function do_intdiv( $var1, $var2 ) {
		if ( function_exists( 'intdiv' ) ) {
			try {
				pr_var( intdiv( $var1, $var2 ), '', true, true );
			}
			catch ( Error $e ) {
				$message = '<span class="error">(Catchable) Fatal error</span>: ' . $e->getMessage();
				self::handle_exception( $message );
			}
		}
		else {
			print 'E: not available (PHP 7.0.0+)';
		}
	}


	/**
	 * Helper function to handle exceptions from overloaded functions.
	 *
	 * @internal Exception handling is currently the same as for the PHP5 specific code, but added as separate
	 * method to allow for future adjustment.
	 *
	 * @param string $message The error message.
	 */
	public static function handle_exception( $message ) {
		VartypePHP5::handle_exception( $message );
	}
}
