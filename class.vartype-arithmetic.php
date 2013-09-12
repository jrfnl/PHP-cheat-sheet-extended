<?php


include_once( 'class.vartype-compare.php' );

class VartypeArithmetic extends VartypeCompare {

	// Set up the tests for the arithmetic operations
	var $tests = array(

		'negate'			=> array(
			'title'			=> 'negate&hellip;',
			'tooltip'		=> '$a == -$b',
			'url'			=> 'http://php.net/language.operators.arithmetic',
			'arg'			=> '$a, $b',
			'function'		=>	'if( !is_array( $a ) && !is_array( $b ) ) { pr_bool( $a == -$b ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'negate_strict'			=> array(
			'title'			=> 'negate strict&hellip;',
			'tooltip'		=> '$a === -$b',
			'url'			=> 'http://php.net/language.operators.arithmetic',
			'arg'			=> '$a, $b',
			'function'		=>	'if( !is_array( $a ) && !is_array( $b ) ) { pr_bool( $a === -$b ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'sum'				=> array(
			'title'			=> '+',
			'tooltip'		=> '$a + $b',
			'url'			=> 'http://php.net/language.operators.arithmetic',
			'arg'			=> '$a, $b',
			'function'		=>	'if( ( !is_array( $a ) && !is_array( $b ) ) || ( is_array( $a ) && is_array( $b ) ) ) { pr_var( $a + $b, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
			'notes'			=> array(
				'<p>Take note of the fact that <code> + </code> is a valid <a href="http://php.net/language.operators.array" target="_blank">array operator</a>.</p>',
			),
		),
		'subtract'			=> array(
			'title'			=> '-',
			'tooltip'		=> '$a - $b',
			'url'			=> 'http://php.net/language.operators.arithmetic',
			'arg'			=> '$a, $b',
			'function'		=>	'if( !is_array( $a ) && !is_array( $b ) ) { pr_var( $a - $b, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'multiply'			=> array(
			'title'			=> '*',
			'tooltip'		=> '$a * $b',
			'url'			=> 'http://php.net/language.operators.arithmetic',
			'arg'			=> '$a, $b',
			'function'		=>	'if( !is_array( $a ) && !is_array( $b ) ) { pr_var( $a * $b, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'divide'			=> array(
			'title'			=> '/',
			'tooltip'		=> '$a / $b',
			'url'			=> 'http://php.net/language.operators.arithmetic',
			'arg'			=> '$a, $b',
			'function'		=>	'if( !is_array( $a ) && !is_array( $b ) ) { $r = $a / $b; if( is_int( $r ) ) { pr_int( $r ); } else if ( is_float( $r ) ) { pr_flt( $r ); } else if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'modulus'			=> array(
			'title'			=> '%',
			'tooltip'		=> '$a % $b',
			'url'			=> 'http://php.net/language.operators.arithmetic',
			'arg'			=> '$a, $b',
			'function'		=> '$r = $a % $b; if( is_int( $r ) ) { pr_int( $r ); } else if ( is_float( $r ) ) { pr_flt( $r ); } else if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		

		'fmod'			=> array(
			'title'			=> 'fmod()',
			'url'			=> 'http://php.net/fmod',
			'arg'			=> '$a, $b',
			'function'		=>	'if ( function_exists( \'fmod\' ) ) { pr_var( fmod( $a, $b ), \'\', true, true ); } else { print \'E: not available (PHP 4.2.0+)\'; }',
		),



	);
	
	
	/**
	 * BCMath tests
	 */
/*
    bcpow � Raise an arbitrary precision number to another
    bcpowmod � Raise an arbitrary precision number to another, reduced by a specified modulus
    bcscale � Set default scale parameter for all bc math functions
    bcsqrt � Get the square root of an arbitrary precision number
*/
	var $bcmath_tests = array(

		'bcadd'			=> array(
			'title'			=> 'bcadd()',
			'url'			=> 'http://php.net/bcadd',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_str( bcadd( $a, $b ) );',
			'notes'			=> array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		'bcsub'			=> array(
			'title'			=> 'bcsub()',
			'url'			=> 'http://php.net/bcsub',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_str( bcsub( $a, $b ) );',
			'notes'			=> array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		'bcmul'			=> array(
			'title'			=> 'bcmul()',
			'url'			=> 'http://php.net/bcmul',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_str( bcmul( $a, $b ) );',
			'notes'			=> array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		'bcdiv'			=> array(
			'title'			=> 'bcdiv()',
			'url'			=> 'http://php.net/bcdiv',
			'arg'			=> '$a, $b',
			'function'		=> '$r = bcdiv( $a, $b ); if( is_string( $r ) ) { pr_str( $r ); } else { pr_var ( $r, \'\', true, true ); }',
			'notes'			=> array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
		'bcmod'			=> array(
			'title'			=> 'bcmod()',
			'url'			=> 'http://php.net/bcmod',
			'arg'			=> '$a, $b',
			'function'		=> '$r = bcmod( $a, $b ); if( is_string( $r ) ) { pr_str( $r ); } else { pr_var ( $r, \'\', true, true ); }',
			'notes'			=> array(
				'<p>For this cheat sheet <code>bcscale()</code> has been set to 3. Remember that the default is 0.</p>',
			),
		),
	);
	
	
	
	function __construct() {
		if ( extension_loaded( 'bcmath' ) ) {
			$this->tests = array_merge( $this->tests, $this->bcmath_tests );
			bcscale( 3 );
		}
		parent::__construct();
	}

	function VartypeArithmetic() {
		$this->__construct();
	}

}

?>