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
	static public $tests = array(
		/**
		 * Functions where errors have been turned into exceptions
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
	 * PHP7 compatible version of % arithmetics
	 *
	 * @param mixed $a
	 * @param mixed $b
	 */
	static function do_modulus( $a, $b ) {
		try {
			$r = ( $a % $b );
			if ( is_bool( $r ) ) {
				pr_bool( $r );
			}
			else {
				pr_var( $r, '', true, true );
			}
		}
		catch ( Exception $e ) {
			$message = '<span class="error">(Catchable) Fatal error</span>: ' . $e->getMessage();
			self::handle_exception( $message );
		}
	}


	/**
	 * PHP7 compatible version of intdiv
	 *
	 * @param mixed $a
	 * @param mixed $b
	 */
	static function do_intdiv( $a, $b ) {
		if ( function_exists( 'intdiv' ) ) {
			try {
				pr_var( intdiv( $a, $b ), '', true, true );
			}
			catch ( Exception $e ) {
				$message = '<span class="error">(Catchable) Fatal error</span>: ' . $e->getMessage();
				self::handle_exception( $message );
			}
		}
		else {
			print 'E: not available (PHP 7.0.0+)';
		}
	}


	/**
	 * Helper function to handle exceptions from the overloaded functions.
	 *
	 * @internal Exception handling is currently the same as for the PHP5 specific code, but added as separate
	 * method to allow for future adjustment.
	 *
	 * @param string $message The error message.
	 */
	static public function handle_exception( $message ) {
		VartypePHP5::handle_exception( $message );
	}
}
