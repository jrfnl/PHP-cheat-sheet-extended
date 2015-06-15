<?php
/**
 * Variable Arithmetic tests.
 *
 * @package PHPCheatsheets
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


include_once APP_DIR . '/class.vartype-compare.php';

/**
 * Variable Arithmetic tests.
 */
class VartypeArithmetic extends VartypeCompare {

	/**
	 * The tests to run.
	 *
	 * @var array $tests  Multi-dimensional array.
	 *                    Possible lower level array keys:
	 *                    - title     Used as tab title
	 *                    - tooltip   Additional code sample for tooltip on tab
	 *                    - url       Relevant PHP Manual page
	 *                    - arg       Function arguments
	 *                    - function  Function to run
	 *                    - Notes     Array of notes on this test
	 */
	var $tests = array(

		/**
		 * Operator based calculations.
		 */
		'negate'         => array(
			'title'         => 'negate&hellip;',
			'tooltip'       => '$a == -$b',
			'url'           => 'http://php.net/language.operators.arithmetic',
			'arg'           => '$a, $b',
			'function'      => 'if ( ( ! is_array( $a ) && ! is_array( $b ) ) && ( ! is_object( $a ) && ! is_object( $b ) ) ) { pr_bool( $a == -$b ); } else if ( PHP_VERSION_ID >= 50006 && ( ! is_array( $a ) && ! is_array( $b ) ) && ( is_object( $a ) || is_object( $b ) ) ) { pr_bool( $a == -$b ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'negate_strict'  => array(
			'title'         => 'negate strict&hellip;',
			'tooltip'       => '$a === -$b',
			'url'           => 'http://php.net/language.operators.arithmetic',
			'arg'           => '$a, $b',
			'function'      => 'if ( ( ! is_array( $a ) && ! is_array( $b ) ) && ( ! is_object( $a ) && ! is_object( $b ) ) ) { pr_bool( $a === -$b ); } else if ( PHP_VERSION_ID >= 50006 && ( ! is_array( $a ) && ! is_array( $b ) ) && ( is_object( $a ) || is_object( $b ) ) ) { pr_bool( $a === -$b ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'sum'            => array(
			'title'         => '+',
			'tooltip'       => '$a + $b',
			'url'           => 'http://php.net/language.operators.arithmetic',
			'arg'           => '$a, $b',
			'function'      => 'if ( ( ( ! is_array( $a ) && ! is_array( $b ) || ( is_array( $a ) && is_array( $b ) ) ) ) && ( ! is_object( $a ) && ! is_object( $b ) ) ) { pr_var( $a + $b, \'\', true, true ); } else if ( PHP_VERSION_ID >= 50006 && ( ! is_array( $a ) && ! is_array( $b ) ) && ( is_object( $a ) || is_object( $b ) ) ) { pr_var( $a + $b, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
			'notes'         => array(
				'<p>Take note of the fact that <code> + </code> is a valid <a href="http://php.net/language.operators.array" target="_blank">array operator</a>.</p>',
			),
		),
		'subtract'       => array(
			'title'         => '-',
			'tooltip'       => '$a - $b',
			'url'           => 'http://php.net/language.operators.arithmetic',
			'arg'           => '$a, $b',
			'function'      => 'if ( ( ! is_array( $a ) && ! is_array( $b ) ) && ( ! is_object( $a ) && ! is_object( $b ) ) ) { pr_var( $a - $b, \'\', true, true ); } else if ( PHP_VERSION_ID >= 50006 && ( ! is_array( $a ) && ! is_array( $b ) ) && ( is_object( $a ) || is_object( $b ) ) ) { pr_var( $a - $b, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'multiply'       => array(
			'title'         => '*',
			'tooltip'       => '$a * $b',
			'url'           => 'http://php.net/language.operators.arithmetic',
			'arg'           => '$a, $b',
			'function'      => 'if ( ( ! is_array( $a ) && ! is_array( $b ) ) && ( ! is_object( $a ) && ! is_object( $b ) ) ) { pr_var( $a * $b, \'\', true, true ); } else if ( PHP_VERSION_ID >= 50006 && ( ! is_array( $a ) && ! is_array( $b ) ) && ( is_object( $a ) || is_object( $b ) ) ) { pr_var( $a * $b, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'divide'         => array(
			'title'         => '/',
			'tooltip'       => '$a / $b',
			'url'           => 'http://php.net/language.operators.arithmetic',
			'arg'           => '$a, $b',
			'function'      => 'if ( ( ! is_array( $a ) && ! is_array( $b ) ) && ( ! is_object( $a ) && ! is_object( $b ) ) ) { $r = $a / $b; if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else if ( PHP_VERSION_ID >= 50006 && ( ! is_array( $a ) && ! is_array( $b ) ) && ( is_object( $a ) || is_object( $b ) ) ) { $r = $a / $b; if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'modulus'        => array(
			'title'         => '%',
			'tooltip'       => '$a % $b',
			'url'           => 'http://php.net/language.operators.arithmetic',
			'arg'           => '$a, $b',
			'function'      => '$r = $a % $b; if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		'pow_operator'         => array(
			'title'         => '**',
			'url'           => 'http://php.net/language.operators.arithmetic',
			'arg'           => '$a, $b',
			'function'      => 'if ( PHP_VERSION_ID >= 50600 ) { pr_var( $a ** $b, \'\', true, true ); } else { print \'E: \'**\' operator not available (PHP 5.6+)\'; }',
		),


		// Doesn't really belong in arithmetic, but for now it's the most logical place anyhow.
		'concatenate'        => array(
			'title'         => '.',
			'tooltip'       => '$a . $b',
			'url'           => 'http://php.net/language.operators.string.php',
			'arg'           => '$a, $b',
			'function'      => 'pr_var( $a . $b, \'\', true, true );',
		),

		'fmod'           => array(
			'title'         => 'fmod()',
			'url'           => 'http://php.net/fmod',
			'arg'           => '$a, $b',
			'function'      => 'if ( function_exists( \'fmod\' ) ) { pr_var( fmod( $a, $b ), \'\', true, true ); } else { print \'E: not available (PHP 4.2.0+)\'; }',
		),

		'pow'            => array(
			'title'         => 'pow()',
			'url'           => 'http://php.net/pow',
			'arg'           => '$a, $b',
			'function'      => 'pr_var( pow( $a, $b ), \'\', true, true );',
		),

	);


	/**
	 * Calculations with BCMath.
	 *
	 * Will be added to $tests property from constructor if BCMath is available.
	 *
	 * @var array $bcmath_tests  Multi-dimensional array of BC Math related tests.
	 */
	var $bcmath_tests = array(

		'bcadd'          => array(
			'title'         => 'bcadd()',
			'url'           => 'http://php.net/bcadd',
			'arg'           => '$a, $b',
			'function'      => '$r = bcadd( $a, $b ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var ( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		'bcsub'          => array(
			'title'         => 'bcsub()',
			'url'           => 'http://php.net/bcsub',
			'arg'           => '$a, $b',
			'function'      => '$r = bcsub( $a, $b ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var ( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		'bcmul'          => array(
			'title'         => 'bcmul()',
			'url'           => 'http://php.net/bcmul',
			'arg'           => '$a, $b',
			'function'      => '$r = bcmul( $a, $b ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var ( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		'bcdiv'          => array(
			'title'         => 'bcdiv()',
			'url'           => 'http://php.net/bcdiv',
			'arg'           => '$a, $b',
			'function'      => '$r = bcdiv( $a, $b ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var ( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		'bcmod'          => array(
			'title'         => 'bcmod()',
			'url'           => 'http://php.net/bcmod',
			'arg'           => '$a, $b',
			'function'      => '$r = bcmod( $a, $b ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var ( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),

		/*
		'bcpow'          => array(
			'title'         => 'bcpow()',
			'url'           => 'http://php.net/bcpow',
			'arg'           => '$a, $b',
			'function'      => 'if ( $a != 0 && is_infinite( pow( $a, $b ) ) === false ) { $r = bcpow( $a, $b ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var ( $r, \'\', true, true ); } } else { trigger_error( \'would result in INF and will normally exhaust memory\', E_USER_ERROR ); }',
			'notes'         => array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		*/
	);


	/**
	 * Constructor.
	 */
	function __construct() {
		if ( PHP_VERSION_ID < 50600 ) {
			unset( $this->tests['pow_operator'] );
		}
		if ( extension_loaded( 'bcmath' ) ) {
			$this->tests = array_merge( $this->tests, $this->bcmath_tests );
			bcscale( 3 );
		}
		parent::__construct();
	}


	/**
	 * PHP4 Constructor.
	 */
	function VartypeArithmetic() {
		$this->__construct();
	}
}
