<?php
/**
 * Variable testing tests.
 *
 * @package PHPCheatsheets
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


require_once APP_DIR . '/class.vartype.php';

/**
 * Variable testing tests.
 */
class VartypeTest extends Vartype {

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
		'gettype' => array(
			'title'         => 'gettype()',
			'url'           => 'https://php.net/gettype',
			'arg'           => '$x',
			'function'      => 'pr_str( gettype( $x ) );',
		),

		'isset' => array(
			'title'         => 'isset()',
			'url'           => 'https://php.net/isset',
			'arg'           => '$x',
			'function'      => 'pr_bool( isset( $x ) );',
		),


		// Will be removed from $tests property from constructor if not on PHP 7+ to prevent parse errors.
		'null_coalesce' => array(
			'title'         => '$x ?? \'not-set\'',
			'url'           => 'https://php.net/language.operators.comparison',
			'arg'           => '$x',
			'function'      => 'pr_var( $x ?? \'not-set\' );',
			'notes'         => array(
				'<p>The Null Coalesce operator is only available in PHP 7.0.0+.</p>',
			),
		),



		'var' => array(
			'title'         => '$x',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x );',
		),
		'not_var' => array(
			'title'         => '!$x',
			'arg'           => '$x',
			'function'      => 'pr_bool( ! $x );',
		),
		'if_var' => array(
			'title'         => 'if(&nbsp;$x&nbsp;) {..}',
			'arg'           => '$x',
			'function'      => 'if ( $x ) { pr_bool( true ); } else { pr_bool( false ); }',
		),
		'if_not_var' => array(
			'title'         => 'if(&nbsp;!&nbsp;$x&nbsp;) {..}',
			'arg'           => '$x',
			'function'      => 'if ( ! $x ) { pr_bool( true ); } else { pr_bool( false ); }',
		),


		/*
		 * Test is_...() functions
		 */
		'is_array' => array(
			'title'         => 'is_array()',
			'url'           => 'https://php.net/is_array',
			'arg'           => '$x',
			'function'      => 'pr_bool( is_array( $x ) );',
		),
		'is_binary' => array(
			'title'         => 'is_binary()',
			'url'           => 'https://php.net/is_binary',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_binary\' ) ) { pr_bool( is_binary( $x ) ); } else { print "E: not available (PHP 6.0.0+)\n"; }',
		),
		'is_bool' => array(
			'title'         => 'is_bool()',
			'url'           => 'https://php.net/is_bool',
			'arg'           => '$x',
			'function'      => 'pr_bool( is_bool( $x ) );',
		),
		'is_callable' => array(
			'title'         => 'is_callable()',
			'url'           => 'https://php.net/is_callable',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_callable\' ) ) { pr_bool( is_callable( $x ) ); } else { print "E: not available (PHP 4.0.6+)\n"; }',
		),
		'is_float' => array(
			'title'         => 'is_float()',
			'url'           => 'https://php.net/is_float',
			'arg'           => '$x',
			'function'      => 'pr_bool( is_float( $x ) );',
		),
		'is_int' => array(
			'title'         => 'is_int()',
			'url'           => 'https://php.net/is_int',
			'arg'           => '$x',
			'function'      => 'pr_bool( is_int( $x ) );',
		),
		'is_null' => array(
			'title'         => 'is_null()',
			'url'           => 'https://php.net/is_null',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_null\' ) ) { pr_bool( is_null( $x ) ); } else { print "E: not available (PHP 4.0.4+)\n"; }',
		),
		'is_numeric' => array(
			'title'         => 'is_numeric()',
			'url'           => 'https://php.net/is_numeric',
			'arg'           => '$x',
			'function'      => 'pr_bool( is_numeric( $x ) );',
		),
		'is_object' => array(
			'title'         => 'is_object()',
			'url'           => 'https://php.net/is_object',
			'arg'           => '$x',
			'function'      => 'pr_bool( is_object( $x ) );',
		),
		'is_resource' => array(
			'title'         => 'is_resource()',
			'url'           => 'https://php.net/is_resource',
			'arg'           => '$x',
			'function'      => 'pr_bool( is_resource( $x ) );',
		),
		'is_scalar' => array(
			'title'         => 'is_scalar()',
			'url'           => 'https://php.net/is_scalar',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_scalar\' ) ) { pr_bool( is_scalar( $x ) ); } else { print "E: not available (PHP 4.0.5+)\n"; }',
		),
		'is_string' => array(
			'title'         => 'is_string()',
			'url'           => 'https://php.net/is_string',
			'arg'           => '$x',
			'function'      => 'pr_bool( is_string( $x ) );',
		),


		// Float specific.
		'is_nan' => array(
			'title'         => 'is_nan()',
			'url'           => 'https://php.net/is_nan',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_nan\' ) ) { $r = is_nan( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print "E: not available (PHP 4.2.0+)\n"; }',
		),
		'is_finite' => array(
			'title'         => 'is_finite()',
			'url'           => 'https://php.net/is_finite',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_finite\' ) ) { $r = is_finite( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print "E: not available (PHP 4.2.0+)\n"; }',
		),
		'is_infinite' => array(
			'title'         => 'is_infinite()',
			'url'           => 'https://php.net/is_infinite',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_infinite\' ) ) { $r = is_infinite( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print "E: not available (PHP 4.2.0+)\n"; }',
		),


		// Array related.
		'is_iterable' => array(
			'title'         => 'is_iterable()',
			'url'           => 'https://php.net/is_iterable',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_iterable\' ) ) { pr_bool( is_iterable( $x ) ); } else { print "E: not available (PHP 7.1.0+)\n"; }',
		),
		'is_countable' => array(
			'title'         => 'is_countable()',
			'url'           => 'https://php.net/is_countable',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'is_countable\' ) ) { pr_bool( is_countable( $x ) ); } else { print "E: not available (PHP 7.3.0+)\n"; }',
		),


		/*
		 * Type casting.
		 */
		'array' => array(
			'title'         => '(array)',
			'url'           => 'https://php.net/language.types.array#language.types.array.casting',
			'arg'           => '$x',
			'function'      => 'pr_var( (array) $x, \'\', true, true );',
		),
		'bool' => array(
			'title'         => '(bool)',
			'url'           => 'https://php.net/language.types.boolean#language.types.boolean.casting',
			'arg'           => '$x',
			'function'      => 'pr_bool( (bool) $x );',
		),
		'float' => array(
			'title'         => '(float)',
			'url'           => 'https://php.net/language.types.float#language.types.float.casting',
			'arg'           => '$x',
			'function'      => 'pr_flt( (float) $x );',
		),
		'int' => array(
			'title'         => '(int)',
			'url'           => 'https://php.net/language.types.integer#language.types.integer.casting',
			'arg'           => '$x',
			'function'      => '$r = (int) $x; if ( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		'object' => array(
			'title'         => '(object)',
			'url'           => 'https://php.net/language.types.object#language.types.object.casting',
			'arg'           => '$x',
			'function'      => 'pr_var( (object) $x, \'\', true, true );',
		),
		'string' => array(
			'title'         => '(string)',
			'url'           => 'https://php.net/language.types.string#language.types.string.casting',
			'arg'           => '$x',
			'function'      => 'pr_str( (string) $x );',
		),
		'unset' => array(
			'title'         => '(unset)',
			'url'           => 'https://php.net/language.types.null#language.types.null.casting',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 50000 ) { pr_var( (unset) $x, \'\', true, true ); } else { print "E: not available (PHP 5+)\n"; }',
		),
		'f_unset' => array(
			'title'         => 'unset()',
			'url'           => 'https://php.net/unset',
			'arg'           => '$x',
			'function'      => 'unset( $x ); pr_var( $x, \'\', true, true );',
		),


		/*
		 * ...val()
		 */
		'floatval' => array(
			'title'         => 'floatval()',
			'url'           => 'https://php.net/floatval',
			'arg'           => '$x',
			'function'      => '$r = floatval( $x ); if ( is_float( $r ) ) { pr_flt( $r ); } else if ( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		'intval' => array(
			'title'         => 'intval()',
			'url'           => 'https://php.net/intval',
			'arg'           => '$x',
			'function'      => '$r = intval( $x ); if ( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		'strval' => array(
			'title'         => 'strval()',
			'url'           => 'https://php.net/strval',
			'arg'           => '$x',
			'function'      => '$r = strval( $x ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),


		/*
		 * Loose type juggling.
		 */
		'juggle_int' => array(
			'title'         => '$x&nbsp;+&nbsp;0',
			'url'           => 'https://php.net/language.types.type-juggling',
			'arg'           => '$x',
			'function'      => '
				if ( ! is_array( $x ) && ( PHP_VERSION_ID > 50005 || ! is_object( $x ) ) ) {
					$x = $x + 0;
					if ( is_int( $x ) ) {
						pr_int( $x );
					}
					else if ( is_float( $x ) ) {
						pr_flt( $x );
					}
					else {
						pr_var( $x, \'\', true, true );
					}
				}
				else {
					trigger_error( \'Unsupported operand types\', E_USER_ERROR );
				}
			', // Note: has PHP5 equivalent in class.vartype-php5.php.
		),
		'juggle_flt' => array(
			'title'         => '$x&nbsp;+&nbsp;0.0',
			'url'           => 'https://php.net/language.types.type-juggling',
			'arg'           => '$x',
			'function'      => '
				if ( ! is_array( $x ) && ( PHP_VERSION_ID > 50005 || ! is_object( $x ) ) ) {
					$r = $x + 0.0;
					if ( is_float( $r ) ) {
						pr_flt( $r );
					}
					else if ( is_int( $r ) ) {
						pr_int( $r );
					}
					else {
						pr_var( $r, \'\', true, true );
					}
				}
				else {
					trigger_error( \'Unsupported operand types\', E_USER_ERROR );
				}
			', // Note: has PHP5 equivalent in class.vartype-php5.php.
		),
		'juggle_str' => array(
			'title'         => '$x&nbsp;.&nbsp;\'\'',
			'url'           => 'https://php.net/language.types.type-juggling',
			'arg'           => '$x',
			'function'      => 'pr_str( $x . \' \' );',
		),


		/*
		 * Test settype()
		 */
		'settype_array' => array(
			'title'         => 'settype (&nbsp;$copy, \'array\'&nbsp;)',
			'url'           => 'https://php.net/settype',
			'arg'           => '$x',
			'function'      => '$pass = settype( $x, \'array\' ); if ( $pass === true ) { pr_var( $x, \'\', true, true ); } else { print \'FAILED\'; }',
		),
		'settype_bool' => array(
			'title'         => 'settype (&nbsp;$copy, \'bool\'&nbsp;)',
			'url'           => 'https://php.net/settype',
			'arg'           => '$x',
			'function'      => '$pass = settype( $x, \'boolean\' ); if ( $pass === true ) { pr_bool( $x ); } else { print \'FAILED\'; }',
		),
		'settype_float' => array(
			'title'         => 'settype (&nbsp;$copy, \'float\'&nbsp;)',
			'url'           => 'https://php.net/settype',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 40200 ) { $pass = settype( $x, \'float\' ); } else { $pass = settype( $x, \'double\' ); } if ( $pass === true ) { pr_flt( $x ); } else { print \'FAILED\'; }',
		),
		'settype_int' => array(
			'title'         => 'settype (&nbsp;$copy, \'int\'&nbsp;)',
			'url'           => 'https://php.net/settype',
			'arg'           => '$x',
			'function'      => '$pass = settype( $x, \'integer\' ); if ( $pass === true ) { if ( is_int( $x ) ) { pr_int( $x ); } else { pr_var( $x, \'\', true, true ); } } else { print \'FAILED\'; }',
		),
		'settype_null' => array(
			'title'         => 'settype (&nbsp;$copy, \'null\'&nbsp;)',
			'url'           => 'https://php.net/settype',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 40200 ) { $pass = settype( $x, \'null\' ); if ( $pass === true ) { pr_var( $x, \'\', true, true ); } else { print \'FAILED\'; } } else { print "E: not available (PHP 4.2.0+)\n"; }',
		),
		'settype_object' => array(
			'title'         => 'settype (&nbsp;$copy, \'object\'&nbsp;)',
			'url'           => 'https://php.net/settype',
			'arg'           => '$x',
			'function'      => '$pass = settype( $x, \'object\' ); if ( $pass === true ) { pr_var( $x, \'\', true, true ); } else { print \'FAILED\'; }',
		),
		'settype_string' => array(
			'title'         => 'settype (&nbsp;$copy, \'string\'&nbsp;)',
			'url'           => 'https://php.net/settype',
			'arg'           => '$x',
			'function'      => '$pass = settype( $x, \'string\' ); if ( $pass === true ) { pr_str( $x ); } else { print \'FAILED\'; }',
			'notes'         => array(
				'<p>Depending on your error handling settings/exception catching and your PHP version, using <code>settype( $copy, \'string\' )</code> on an object which does not have a <code>__toString()</code> method will result either in the string <code>Object</code> or will return a (catchable) fatal error.</p>',
				'<p>Before PHP &lt; 5.2.0, the <code>__toString()</code> method was only available to echo/print statements, so casting to string would still result in <code>Object</code>, even when the object contained a <code>__toString()</code> method.</p>',
			),
		),


		/*
		 * Tests using CastToType class.
		 *
		 * @see https://github.com/jrfnl/PHP-cast-to-type.git
		 */
		'cast_to_type_array' => array(
			'title'         => 'CastToType::_array (&nbsp;$x&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ); pr_var( CastToType::_array( $x ), \'\', true, true ); } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an external library</p>',
			),
		),
		'cast_to_type_bool' => array(
			'title'         => 'CastToType::_bool (&nbsp;$x&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; $r = CastToType::_bool( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_float' => array(
			'title'         => 'CastToType::_float (&nbsp;$x&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; $r = CastToType::_float( $x ); if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_int' => array(
			'title'         => 'CastToType::_int (&nbsp;$x&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; $r = CastToType::_int( $x ); if ( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_null' => array(
			'title'         => 'CastToType::_null (&nbsp;$x&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; pr_var( CastToType::_null( $x ), \'\', true, true ); } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_object' => array(
			'title'         => 'CastToType::_object (&nbsp;$x&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; pr_var( CastToType::_object( $x ), \'\', true, true ); } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_string' => array(
			'title'         => 'CastToType::_string (&nbsp;$x&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; $r = CastToType::_string( $x ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),


		'cast_to_type_array_not_empty' => array(
			'title'         => 'CastToType::_array (&nbsp;$x, false&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; pr_var( CastToType::_array( $x, false ), \'\', true, true ); } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an external library</p>',
			),
		),
		'cast_to_type_bool_not_empty_recurse_arrays' => array(
			'title'         => 'CastToType::_bool (&nbsp;$x, false, false&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; $r = CastToType::_bool( $x, false, false ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_float_not_empty_recurse_arrays' => array(
			'title'         => 'CastToType::_float (&nbsp;$x, false, false&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; $r = CastToType::_float( $x, false, false ); if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_int_not_empty_recurse_arrays' => array(
			'title'         => 'CastToType::_int (&nbsp;$x, false, false&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; $r = CastToType::_int( $x, false, false ); if ( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_object_not_empty' => array(
			'title'         => 'CastToType::_object (&nbsp;$x, false&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; pr_var( CastToType::_object( $x, false ), \'\', true, true ); } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),
		'cast_to_type_string_not_empty_recurse_arrays' => array(
			'title'         => 'CastToType::_string (&nbsp;$x, false, false&nbsp;)',
			'url'           => 'https://github.com/jrfnl/PHP-cast-to-type.git',
			'arg'           => '$x',
			'function'      => 'if ( file_exists( APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\' ) ) { include_once APP_DIR . \'/include/PHP-cast-to-type/cast-to-type.php\'; $r = CastToType::_string( $x, false, false ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'&nbsp;\'; }',
			'notes'         => array(
				'<p>Uses an <a href="https://github.com/jrfnl/PHP-cast-to-type.git" target="_blank">external library</a></p>',
			),
		),



		/*
		 * Absolute numbers
		 */
		'abs' => array(
			'title'         => 'abs()',
			'url'           => 'https://php.net/abs',
			'arg'           => '$x',
			'function'      => '$r = abs( $x ); if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),


		/*
		 * Some rounding functions
		 */
		'floor' => array(
			'title'         => 'floor()',
			'url'           => 'https://php.net/floor',
			'arg'           => '$x',
			'function'      => '$r = floor( $x ); if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		'ceil' => array(
			'title'         => 'ceil()',
			'url'           => 'https://php.net/ceil',
			'arg'           => '$x',
			'function'      => '$r = ceil( $x ); if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		'round' => array(
			'title'         => 'round()',
			'url'           => 'https://php.net/round',
			'arg'           => '$x',
			'function'      => '$r = round( $x ); if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),




		/*
		 * Some string related functions
		 */
		'empty' => array(
			'title'         => 'empty()',
			'url'           => 'https://php.net/empty',
			'arg'           => '$x',
			'function'      => 'pr_bool( empty( $x ) );',
		),
		'strlen' => array(
			'title'         => 'strlen()',
			'url'           => 'https://php.net/strlen',
			'arg'           => '$x',
			'function'      => '$r = strlen( $x ); if ( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		'count_chars' => array(
			'title'         => 'count_chars (&hellip;)',
			'tooltip'       => 'array_sum( count_chars( $x, 1 ) )',
			'url'           => 'https://php.net/count_chars',
			'arg'           => '$x',
			'function'      => 'pr_var( array_sum( count_chars( $x, 1 ) ), \'\', true, true );',
		),
		'str_shuffle' => array(
			'title'         => 'str_shuffle (&nbsp;$x&nbsp;)',
			'url'           => 'https://php.net/str_shuffle',
			'arg'           => '$x',
			'function'      => 'pr_var( str_shuffle( $x ), \'\', true, true );',
		),

		'mb_strlen' => array(
			'title'         => 'mb_strlen()',
			'url'           => 'https://php.net/mb-strlen',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'mb_strlen\' ) ) { $r = mb_strlen( $x, \'UTF-8\' ); if ( is_int( $r ) ) { pr_int( $r ); } else if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'E: mbstring extension not installed\'; }',
		),
		'trim' => array(
			'title'         => 'trim()',
			'url'           => 'https://php.net/trim',
			'arg'           => '$x',
			'function'      => 'pr_var( trim( $x ), \'\', true, true );',
		),
		'char_access' => array(
			'title'         => '$x{2}',
			'tooltip'       => 'String character access by index.',
			'url'           => 'https://php.net/manual/en/language.types.string.php#language.types.string.substr',
			'arg'           => '$x',
			'function'      => 'if ( ! is_object( $x ) ) { pr_var( $x{2}, \'\', true, true ); } else { $class = get_class( $x ); trigger_error( \'Cannot use object of type \' . $class . \' as array\', E_USER_ERROR ); unset( $class ); }',
		),



		/*
		 * Some array related functions
		 */
		'count' => array(
			'title'         => 'count()',
			'url'           => 'https://php.net/count',
			'arg'           => '$x',
			'function'      => 'pr_int( count( $x ) );',
		),
		'count_mt_0' => array(
			'title'         => 'count()&nbsp;>&nbsp;0',
			'url'           => 'https://php.net/count',
			'arg'           => '$x',
			'function'      => 'pr_bool( ( count( $x ) > 0 ) );',
		),
		'isset_0' => array(
			'title'         => 'isset (&nbsp;$x[0]&nbsp;)',
			'url'           => 'https://php.net/isset',
			'arg'           => '$x',
			'function'      => 'if ( ! is_object( $x ) ) { pr_bool( isset( $x[0] ) ); } else { $class = get_class( $x ); trigger_error( \'Cannot use object of type \' . $class . \' as array\', E_USER_ERROR ); unset( $class ); }',
			'notes'         => array(
				'<p>
					Whether to use <code>isset()</code> or <code>array_key_exists()</code> depends on what you want to know:
				</p>
				<ul>
					<li><code>isset( $array[$key] )</code> will tell you whether the array key exists <strong>and</strong> has been assigned a value.<br />
						Used on its own it will give undesired results when used on strings as characters within a string can be approached using the <code>$x[]</code> syntax as well.<br />
						Also, it will cause fatal errors when used on objects.</li>
					<li><code>array_key_exists( $key, $array )</code> will tell you only whether the array key exists, but will not check whether it has a value assigned to it.<br />
						Used on its own, it will show a warning if $array is not an array</li>
				</ul>
				<p>
					This said, we can conclude that to avoid warnings and undesired results you will always have to use an <code>is_array()</code> first.<br />
					Also note that <code>isset()</code> is faster than <code>array_key_exists()</code>, but as said above, will return false if no value has been assigned.
				</p>',
			),
		),

		'isset_foo' => array(
			'title'         => 'isset (&nbsp;$x[\'foo\']&nbsp;)',
			'url'           => 'https://php.net/isset',
			'arg'           => '$x',
			'function'      => 'if ( ! is_object( $x ) ) { pr_bool( isset( $x[\'foo\'] ) ); } else { $class = get_class( $x ); trigger_error( \'Cannot use object of type \' . $class . \' as array\', E_USER_ERROR ); unset( $class ); }',
			'notes'         => array(
				'<p>
					Whether to use <code>isset()</code> or <code>array_key_exists()</code> depends on what you want to know:
				</p>
				<ul>
					<li><code>isset( $array[$key] )</code> will tell you whether the array key exists <strong>and</strong> has been assigned a value.<br />
						Used on its own it will give undesired results when used on strings as characters within a string can be approached using the <code>$x[]</code> syntax as well.<br />
						Also, it will cause fatal errors when used on objects.</li>
					<li><code>array_key_exists( $key, $array )</code> will tell you only whether the array key exists, but will not check whether it has a value assigned to it.<br />
						Used on its own, it will show a warning if $array is not an array</li>
				</ul>
				<p>
					This said, we can conclude that to avoid warnings and undesired results you will always have to use an <code>is_array()</code> first.<br />
					Also note that <code>isset()</code> is faster than <code>array_key_exists()</code>, but as said above, will return false if no value has been assigned.
				</p>',
			),
		),

		'array_key_exists' => array(
			'title'         => 'array_key_exists (&nbsp;0,&nbsp;$x&nbsp;)',
			'url'           => 'https://php.net/array_key_exists',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'array_key_exists\' ) ) { $r = array_key_exists( 0, $x ); if ( is_bool( $r ) ) { pr_bool( array_key_exists( 0, $x ) ); } else { pr_var( $r, \'\', true, true ); } } else { print "E: not available (PHP 4.0.7+)\n"; }',
			'notes'         => array(
				'<p>
					Whether to use <code>isset()</code> or <code>array_key_exists()</code> depends on what you want to know:
				</p>
				<ul>
					<li><code>isset( $array[$key] )</code> will tell you whether the array key exists <strong>and</strong> has been assigned a value.<br />
						Used on its own it will give undesired results when used on strings as characters within a string can be approached using the <code>$x[]</code> syntax as well.<br />
						Also, it will cause fatal errors when used on objects.</li>
					<li><code>array_key_exists( $key, $array )</code> will tell you only whether the array key exists, but will not check whether it has a value assigned to it.<br />
						Used on its own, it will show a warning if $array is not an array</li>
				</ul>
				<p>
					This said, we can conclude that to avoid warnings and undesired results you will always have to use an <code>is_array()</code> first.<br />
					Also note that <code>isset()</code> is faster than <code>array_key_exists()</code>, but as said above, will return false if no value has been assigned.
				</p>',
			),

		),
		'in_array' => array(
			'title'         => 'in_array (&nbsp;\'s\', $x&nbsp;)',
			'url'           => 'https://php.net/in_array',
			'arg'           => '$x',
			'function'      => 'pr_bool( in_array( \'s\', $x ) );',
		),
		'array_count_values' => array(
			'title'         => 'array_count_values()',
			'url'           => 'https://php.net/array_count_values',
			'arg'           => '$x',
			'function'      => 'pr_var( array_count_values( $x ), \'\', true, true );',
		),
		'array_access_simple_string' => array(
			'title'         => '$x[\'foo\']',
			'url'           => 'https://php.net/manual/en/language.types.array.php',
			'arg'           => '$x',
			'function'      => 'if ( ! is_object( $x ) ) { pr_var( $x[\'foo\'], \'\', true, true ); } else { $class = get_class( $x ); trigger_error( \'Cannot use object of type \' . $class . \' as array\', E_USER_ERROR ); unset( $class ); }',
		),
		'array_access_multi_string' => array(
			'title'         => '$x[\'foo\'][\'bar\']',
			'url'           => 'https://php.net/manual/en/language.types.array.php',
			'arg'           => '$x',
			'function'      => 'if ( ! is_object( $x ) ) { if ( ! is_string( $x ) || ( is_string( $x ) && ( PHP_VERSION_ID > 50350 || PHP_VERSION_ID < 50000 ) ) ) { pr_var( $x[\'foo\'][\'bar\'], \'\', true, true ); } else { trigger_error( \'Cannot use string offset as an array\', E_USER_ERROR ); } } else { $class = get_class( $x ); trigger_error( \'Cannot use object of type \' . $class . \' as array\', E_USER_ERROR ); unset( $class ); }',
		),


		'array_filter' => array(
			'title'         => 'array_filter()',
			'url'           => 'https://php.net/array_filter',
			'arg'           => '$x',
			'function'      => 'pr_var( array_filter( $x ), \'\', true, true );',
		),
		'array_flip' => array(
			'title'         => 'array_flip()',
			'url'           => 'https://php.net/array_flip',
			'arg'           => '$x',
			'function'      => 'pr_var( array_flip( $x ), \'\', true, true );',
		),
		'array_reverse' => array(
			'title'         => 'array_reverse()',
			'url'           => 'https://php.net/array_reverse',
			'arg'           => '$x',
			'function'      => 'pr_var( array_reverse( $x ), \'\', true, true );',
		),
		'current' => array(
			'title'         => 'current()',
			'url'           => 'https://php.net/current',
			'arg'           => '$x',
			'function'      => 'pr_var( current( $x ), \'\', true, true );',
		),
		'key' => array(
			'title'         => 'key()',
			'url'           => 'https://php.net/key',
			'arg'           => '$x',
			'function'      => 'pr_var( key( $x ), \'\', true, true );',
		),
		'shuffle' => array(
			'title'         => 'shuffle (&nbsp;$copy&nbsp;)',
			'url'           => 'https://php.net/shuffle',
			'arg'           => '$x',
			'function'      => '$pass = shuffle( $x ); if ( $pass === true) { pr_var( $x, \'\', true, true ); } else { print \'FAILED\'; }',
		),
		'sort' => array(
			'title'         => 'sort (&nbsp;$copy&nbsp;)',
			'url'           => 'https://php.net/sort',
			'arg'           => '$x',
			'function'      => '$pass = sort( $x ); if ( $pass === true) { pr_var( $x, \'\', true, true ); } else { print \'FAILED\'; }',
		),


		/*
		 * Some object related functions.
		 */
		'is_a' => array(
			'title'         => 'is_a (&nbsp;$x, \'TestObject\'&nbsp;)',
			'url'           => 'https://php.net/is_a',
			'arg'           => '$x',
			'function'      => '$c = \'TestObject\'; $r = is_a( $x, $c ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
		'instanceof' => array(
			'title'         => 'instanceof TestObject',
			'url'           => 'https://php.net/language.operators.type',
			'arg'           => '$x',
			'function'      => 'print "E: not available (PHP 5.0+)\n";', // Note: has PHP5 equivalent in class.vartype-php5.php.
		),
		'get_class' => array(
			'title'         => 'get_class()',
			'url'           => 'https://php.net/get_class',
			'arg'           => '$x',
			'function'      => '$r = get_class( $x ); if ( ! is_bool( $r ) ) { pr_var( $r, \'\', true, true ); } else { pr_bool( $r ); }',
		),
		'get_parent_class' => array(
			'title'         => 'get_parent_class()',
			'url'           => 'https://php.net/get_parent_class',
			'arg'           => '$x',
			'function'      => '$r = get_parent_class( $x ); if ( ! is_bool( $r ) ) { pr_var( $r, \'\', true, true ); } else { pr_bool( $r ); }',
		),
		'is_subclass_of' => array(
			'title'         => 'is_subclass_of (&nbsp;$x, \'TestObject\'&nbsp;)',
			'url'           => 'https://php.net/is_subclass_of',
			'arg'           => '$x',
			'function'      => '$c = \'TestObject\'; $r = is_subclass_of( $x, $c  ); if ( is_bool( $r ) ) { pr_bool( $r, \'\', true, true ); } else { pr_var( $r, \'\', true, true ); }',
		),



		/*
		 * Resource specific functions.
		 */
		'get_resource_type' => array(
			'title'         => 'get_resource_type()',
			'url'           => 'https://php.net/get_resource_type',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'get_resource_type\' ) ) { $r = get_resource_type( $x ); if ( is_string( $r ) ) { pr_str( $r ); } else if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); } } else {print "E: not available (PHP 4.0.2+)\n"; }',
		),






		/*
		 * Test null comparisons.
		 */
		'null_cmp_loose' => array(
			'title'         => '== null',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == null );',
		),
		'null_cmp_strict' => array(
			'title'         => '=== null',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === null );',
		),
		'null_cmp_loose_str' => array(
			'title'         => '== \'null\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == \'null\' );',
		),
		'null_cmp_strict_str' => array(
			'title'         => '=== \'null\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === \'null\' );',
		),

		'null_cmp_rv_loose' => array(
			'title'         => 'null ==',
			'arg'           => '$x',
			'function'      => 'pr_bool( null == $x );',
		),
		'null_cmp_rv_strict' => array(
			'title'         => 'null ===',
			'arg'           => '$x',
			'function'      => 'pr_bool( null === $x );',
		),
		'null_cmp_rv_loose_str' => array(
			'title'         => '\'null\' ==',
			'arg'           => '$x',
			'function'      => 'pr_bool( \'null\' == $x );',
		),
		'null_cmp_rv_strict_str' => array(
			'title'         => '\'null\' ===',
			'arg'           => '$x',
			'function'      => 'pr_bool( \'null\' === $x );',
		),


		/*
		 * Boolean comparisons.
		 */
		'bool_cmp_true_loose' => array(
			'title'         => '== true',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == true );',
		),
		'bool_cmp_false_loose' => array(
			'title'         => '== false',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == false );',
		),
		'bool_cmp_true_strict' => array(
			'title'         => '=== true',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === true );',
		),
		'bool_cmp_false_strict' => array(
			'title'         => '=== false',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === false );',
		),
		'bool_cmp_true_loose_int' => array(
			'title'         => '==&nbsp;1',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == 1 );',
		),
		'bool_cmp_false_loose_int' => array(
			'title'         => '==&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == 0 );',
		),
		'bool_cmp_true_strict_int' => array(
			'title'         => '===&nbsp;1',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === 1 );',
		),
		'bool_cmp_false_strict_int' => array(
			'title'         => '===&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === 0 );',
		),
		'bool_cmp_true_loose_str' => array(
			'title'         => '== \'true\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == \'true\' );',
		),
		'bool_cmp_false_loose_str' => array(
			'title'         => '== \'false\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == \'false\' );',
		),
		'bool_cmp_true_strict_str' => array(
			'title'         => '=== \'true\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === \'true\' );',
		),
		'bool_cmp_false_strict_str' => array(
			'title'         => '=== \'false\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === \'false\' );',
		),



		'bool_cmp_rv_true_loose' => array(
			'title'         => 'true ==',
			'arg'           => '$x',
			'function'      => 'pr_bool( true == $x );',
		),
		'bool_cmp_rv_false_loose' => array(
			'title'         => 'false ==',
			'arg'           => '$x',
			'function'      => 'pr_bool( false == $x );',
		),
		'bool_cmp_rv_true_strict' => array(
			'title'         => 'true ===',
			'arg'           => '$x',
			'function'      => 'pr_bool( true === $x );',
		),
		'bool_cmp_rv_false_strict' => array(
			'title'         => 'false ===',
			'arg'           => '$x',
			'function'      => 'pr_bool( false === $x );',
		),
		'bool_cmp_rv_true_loose_int' => array(
			'title'         => '1 ==',
			'arg'           => '$x',
			'function'      => 'pr_bool( 1 == $x );',
		),
		'bool_cmp_rv_false_loose_int' => array(
			'title'         => '0 ==',
			'arg'           => '$x',
			'function'      => 'pr_bool( 0 == $x );',
		),
		'bool_cmp_rv_true_strict_int' => array(
			'title'         => '1 ===',
			'arg'           => '$x',
			'function'      => 'pr_bool( 1 === $x );',
		),
		'bool_cmp_rv_false_strict_int' => array(
			'title'         => '0 ===',
			'arg'           => '$x',
			'function'      => 'pr_bool( 0 === $x );',
		),
		'bool_cmp_rv_true_loose_str' => array(
			'title'         => '\'true\' ==',
			'arg'           => '$x',
			'function'      => 'pr_bool( \'true\' == $x );',
		),
		'bool_cmp_rv_false_loose_str' => array(
			'title'         => '\'false\' ==',
			'arg'           => '$x',
			'function'      => 'pr_bool( \'false\' == $x );',
		),
		'bool_cmp_rv_true_strict_str' => array(
			'title'         => '\'true\' ===',
			'arg'           => '$x',
			'function'      => 'pr_bool( \'true\' === $x );',
		),
		'bool_cmp_rv_false_strict_str' => array(
			'title'         => '\'false\' ===',
			'arg'           => '$x',
			'function'      => 'pr_bool( \'false\' === $x );',
		),


		/*
		 * Comparisons with int 0.
		 */
		'int_cmp_gt0' => array(
			'title'         => '&gt;&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x > 0 );',
		),
		'int_cmp_gte0' => array(
			'title'         => '&gt;=&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x >= 0 );',
		),
		'int_cmp_is0_loose' => array(
			'title'         => '==&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == 0 );',
		),
		'int_cmp_is0_strict' => array(
			'title'         => '===&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === 0 );',
		),
		'int_cmp_not0_loose' => array(
			'title'         => '!=&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x != 0 );',
		),
		'int_cmp_not0_strict' => array(
			'title'         => '!==&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x !== 0 );',
		),
		'int_cmp_lt0' => array(
			'title'         => '&lt;&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x < 0 );',
		),
		'int_cmp_lte0' => array(
			'title'         => '&lt;=&nbsp;0',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x <= 0 );',
		),


		/*
		 * Comparisons with empty string.
		 */
		'str_cmp_empty_loose' => array(
			'title'         => '==&nbsp;\'\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x == \'\' );',
		),
		'str_cmp_empty_strict' => array(
			'title'         => '===&nbsp;\'\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x === \'\' );',
		),
		'str_cmp_not_empty_loose' => array(
			'title'         => '!=&nbsp;\'\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x != \'\' );',
		),
		'str_cmp_not_empty_strict' => array(
			'title'         => '!==&nbsp;\'\'',
			'arg'           => '$x',
			'function'      => 'pr_bool( $x !== \'\' );',
		),


		/*
		 * Arithmetic operations.
		 */
		'pre_increment' => array(
			'title'         => '$x = ++$x',
			'url'           => 'https://php.net/language.operators.increment',
			'arg'           => '$x',
			'function'      => '$r = ++$x; if ( is_int( $r ) ) { pr_int( $r ); } else if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>Please take note: using the in-/decrementors on SplInt and SplFloat objects may give unexpected (inconsistent) results....</p>',
			),
		),
		'post_increment' => array(
			'title'         => '$x = $x++',
			'url'           => 'https://php.net/language.operators.increment',
			'arg'           => '$x',
			'function'      => '$r = $x++; if ( is_int( $r ) ) { pr_int( $r ); } else if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>Please take note: using the in-/decrementors on SplInt and SplFloat objects may give unexpected (inconsistent) results....</p>',
			),
		),
		'pre_decrement' => array(
			'title'         => '$x = --$x',
			'url'           => 'https://php.net/language.operators.increment',
			'arg'           => '$x',
			'function'      => '$r = --$x; if ( is_int( $r ) ) { pr_int( $r ); } else if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>Please take note: using the in-/decrementors on SplInt and SplFloat objects may give unexpected (inconsistent) results....</p>',
			),
		),
		'post_decrement' => array(
			'title'         => '$x = $x--',
			'url'           => 'https://php.net/language.operators.increment',
			'arg'           => '$x',
			'function'      => '$r = $x--; if ( is_int( $r ) ) { pr_int( $r ); } else if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p>Please take note: using the in-/decrementors on SplInt and SplFloat objects may give unexpected (inconsistent) results....</p>',
			),
		),


		'arithmetic_negate' => array(
			'title'         => '-$x',
			'url'           => 'https://php.net/language.operators.arithmetic',
			'arg'           => '$x',
			'function'      => 'if ( ! is_array( $x ) && ( PHP_VERSION_ID > 50005 || ! is_object( $x ) ) ) { pr_var( -$x, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'arithmetic_subtract' => array(
			'title'         => '$x&nbsp;-&nbsp;0',
			'url'           => 'https://php.net/language.operators.arithmetic',
			'arg'           => '$x',
			'function'      => 'if ( ! is_array( $x ) && ( PHP_VERSION_ID > 50005 || ! is_object( $x ) ) ) { pr_var( $x - 0, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'arithmetic_multiply' => array(
			'title'         => '$x&nbsp;*&nbsp;1',
			'url'           => 'https://php.net/language.operators.arithmetic',
			'arg'           => '$x',
			'function'      => 'if ( ! is_array( $x ) && ( PHP_VERSION_ID > 50005 || ! is_object( $x ) ) ) { pr_var( $x * 1, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'arithmetic_divide' => array(
			'title'         => '$x&nbsp;/&nbsp;1',
			'url'           => 'https://php.net/language.operators.arithmetic',
			'arg'           => '$x',
			'function'      => 'if ( ! is_array( $x ) && ( PHP_VERSION_ID > 50005 || ! is_object( $x ) ) ) { pr_var( $x / 1, \'\', true, true ); } else { trigger_error( \'Unsupported operand types\', E_USER_ERROR ); }',
		),
		'arithmetic_modulus' => array(
			'title'         => '$x&nbsp;%&nbsp;1',
			'url'           => 'https://php.net/language.operators.arithmetic',
			'arg'           => '$x',
			'function'      => 'pr_var( $x % 1, \'\', true, true );',
		),


		/*
		 * Tests using preg_match().
		 */
		'preg_int_pos' => array(
			'title'         => 'preg_match (`^[0-9]+$`)',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[0-9]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		'preg_int' => array(
			'title'         => 'preg_match (`^[0-9<span style="color: red;">-</span>]+$`)',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[0-9-]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		// Results depend on locale.
		'preg_digit_pos' => array(
			'title'         => 'preg_match (`^\d+$`)',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^\d+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		// Results depend on locale.
		'preg_digit' => array(
			'title'         => 'preg_match (`^[\d<span style="color: red;">-</span>]+$`)',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[\d-]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),


		// ##PREG_DECIMAL_POINT## is replaced by the locale specific decimal point character in the class constructor.
		'preg_float_pos' => array(
			'title'         => 'preg_match (`^[0-9##PREG_DECIMAL_POINT##]+$`)',
			'tooltip'       => 'Decimal point character adjusted based on locale',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[0-9##PREG_DECIMAL_POINT##]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		// ##PREG_DECIMAL_POINT## is replaced by the locale specific decimal point character in the class constructor.
		'preg_float' => array(
			'title'         => 'preg_match (`^[0-9##PREG_DECIMAL_POINT##<span style="color: red;">-</span>]+$`)',
			'tooltip'       => 'Decimal point character adjusted based on locale',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[0-9##PREG_DECIMAL_POINT##-]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		// ##PREG_DECIMAL_POINT## is replaced by the locale specific decimal point character in the class constructor.
		// Results depend on locale.
		'preg_digit_float_pos' => array(
			'title'         => 'preg_match (`^[\d##PREG_DECIMAL_POINT##]+$`)',
			'tooltip'       => 'Decimal point character adjusted based on locale',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[\d##PREG_DECIMAL_POINT##]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		// ##PREG_DECIMAL_POINT## is replaced by the locale specific decimal point character in the class constructor.
		// Results depend on locale.
		'preg_digit_float' => array(
			'title'         => 'preg_match (`^[\d##PREG_DECIMAL_POINT##<span style="color: red;">-</span>]]+$`)',
			'tooltip'       => 'Decimal point character adjusted based on locale',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[\d##PREG_DECIMAL_POINT##-]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		'preg_alpha' => array(
			'title'         => 'preg_match (`^[A-Za-z]+$`)',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[A-Za-z]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		'preg_alnum' => array(
			'title'         => 'preg_match (`^[A-Za-z0-9]+$`)',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^[A-Za-z0-9]+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		'preg_word' => array(
			'title'         => 'preg_match (`^\w+$`)',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^\w+$`\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
		),
		// Result depends on locale.
		'preg_word_utf8' => array(
			'title'         => 'preg_match (`^\w+$`u)',
			'url'           => 'https://php.net/preg-match',
			'arg'           => '$x',
			'function'      => '$valid = preg_match( \'`^\w+$`u\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); }',
			'notes'         => array(
				'<p>What <code>\w</code> matches is locale dependent. The locale for these cheatsheets are set to <code>C</code>. Results with other locales will vary.</p>',
			),
		),



		'preg_int_unicode_pos' => array(
			'title'         => 'preg_match (`^\p{N}+$`u)',
			'url'           => 'https://php.net/regexp.reference.unicode.php',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 50100 ) { $valid = preg_match( \'`^\p{N}+$`u\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); } } else { print "E: not available (PHP 5.1+)\n"; }',
		),
		'preg_int_unicode' => array(
			'title'         => 'preg_match (`^[\p{N}-]+$`u)',
			'url'           => 'https://php.net/regexp.reference.unicode.php',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 50100 ) { $valid = preg_match( \'`^[\p{N}-]+$`u\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); } } else { print "E: not available (PHP 5.1+)\n"; }',
		),
		// ##PREG_DECIMAL_POINT## is replaced by the locale specific decimal point character in the class constructor.
		'preg_number_unicode_pos' => array(
			'title'         => 'preg_match (`^[\p{N}##PREG_DECIMAL_POINT##]+$`u)',
			'url'           => 'https://php.net/regexp.reference.unicode.php',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 50100 ) { $valid = preg_match( \'`^[\p{N}##PREG_DECIMAL_POINT##]+$`u\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); } } else { print "E: not available (PHP 5.1+)\n"; }',
		),
		// ##PREG_DECIMAL_POINT## is replaced by the locale specific decimal point character in the class constructor.
		'preg_number_unicode' => array(
			'title'         => 'preg_match (`^[\p{N}##PREG_DECIMAL_POINT##-]+$`u)',
			'url'           => 'https://php.net/regexp.reference.unicode.php',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 50100 ) { $valid = preg_match( \'`^[\p{N}##PREG_DECIMAL_POINT##-]+$`u\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); } } else { print "E: not available (PHP 5.1+)\n"; }',
		),

		'preg_alpha_unicode' => array(
			'title'         => 'preg_match (`^\p{L}+$`u)',
			'url'           => 'https://php.net/regexp.reference.unicode.php',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 50100 ) { $valid = preg_match( \'`^\p{L}+$`u\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); } } else { print "E: not available (PHP 5.1+)\n"; }',
		),
		'preg_alnum_unicode' => array(
			'title'         => 'preg_match (`^[\p{L}\p{N}]+$`u)',
			'url'           => 'https://php.net/regexp.reference.unicode.php',
			'arg'           => '$x',
			'function'      => 'if ( PHP_VERSION_ID >= 50100 ) { $valid = preg_match( \'`^[\p{L}\p{N}]+$`u\', $x ); if ( $valid === 1 ) { pr_bool( true ); } else if ( $valid === 0 ) { pr_bool( false ); } else if ( $valid === false ) { print \'Error\'; } else { pr_var( $valid, \'\', true, true ); } } else { print "E: not available (PHP 5.1+)\n"; }',
		),


		/*
		 * CTYPE extension.
		 */
		'ctype_alnum' => array(
			'title'         => 'ctype_alnum()',
			'url'           => 'https://php.net/ctype_alnum',
			'arg'           => '$x',
			'function'      => '$r = ctype_alnum( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),
		),
		'ctype_alpha' => array(
			'title'         => 'ctype_alpha()',
			'url'           => 'https://php.net/ctype_alpha',
			'arg'           => '$x',
			'function'      => '$r = ctype_alpha( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_cntrl' => array(
			'title'         => 'ctype_cntrl()',
			'url'           => 'https://php.net/ctype_cntrl',
			'arg'           => '$x',
			'function'      => '$r = ctype_cntrl( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_digit' => array(
			'title'         => 'ctype_digit()',
			'url'           => 'https://php.net/ctype_digit',
			'arg'           => '$x',
			'function'      => '$r = ctype_digit( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_graph' => array(
			'title'         => 'ctype_graph()',
			'url'           => 'https://php.net/ctype_graph',
			'arg'           => '$x',
			'function'      => '$r = ctype_graph( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_lower' => array(
			'title'         => 'ctype_lower()',
			'url'           => 'https://php.net/ctype_lower',
			'arg'           => '$x',
			'function'      => '$r = ctype_lower( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_print' => array(
			'title'         => 'ctype_print()',
			'url'           => 'https://php.net/ctype_print',
			'arg'           => '$x',
			'function'      => '$r = ctype_print( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_punct' => array(
			'title'         => 'ctype_punct()',
			'url'           => 'https://php.net/ctype_punct',
			'arg'           => '$x',
			'function'      => '$r = ctype_punct( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_space' => array(
			'title'         => 'ctype_space()',
			'url'           => 'https://php.net/ctype_space',
			'arg'           => '$x',
			'function'      => '$r = ctype_space( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_upper' => array(
			'title'         => 'ctype_upper()',
			'url'           => 'https://php.net/ctype_upper',
			'arg'           => '$x',
			'function'      => '$r = ctype_upper( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),
		'ctype_xdigit' => array(
			'title'         => 'ctype_xdigit()',
			'url'           => 'https://php.net/ctype_xdigit',
			'arg'           => '$x',
			'function'      => '$r = ctype_xdigit( $x ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
			'notes'         => array(
				'<p><strong>Important</strong>: Integers between -128 and 255 are interpreted as the ASCII value pointing to a character (negative values have 256 added in order to allow characters in the Extended ASCII range).<br />
				In any other case, integers are interpreted as a string containing the decimal digits of the integer.</p>',
			),

		),






		/*
		 * FILTER extension.
		 */

		// Boolean filters.
		'filter_var_bool' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => 'filter_var( $x, FILTER_VALIDATE_BOOLEAN )',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'filter_var\' ) ) { pr_bool( filter_var( $x, FILTER_VALIDATE_BOOLEAN ), \'\', true, true ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_var_array_bool' => array(
			'title'         => 'filter_var_array (&hellip;)',
			'tooltip'       => 'filter_var_array( $x, FILTER_VALIDATE_BOOLEAN )',
			'url'           => 'https://php.net/filter_var_array',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'filter_var_array\' ) ) { pr_var( filter_var_array( $x, FILTER_VALIDATE_BOOLEAN ), \'\', true, true ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_combined_bool' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_VALIDATE_BOOLEAN );
}
else {
	filter_var_array( $x, FILTER_VALIDATE_BOOLEAN );
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'bool\', FILTER_VALIDATE_BOOLEAN ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_combined_bool_null' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'bool\', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>Please note: On some PHP versions <code>filter_var( $x, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE )</code> where <code>$x = false</code> will incorrectly return <code>null</code>.<br />
				Also: with the same parameters filter_var() will return <code>false</code> instead of <code>null</code> for most objects.</p>',
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),

		// Float filters.
		'filter_var_float' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => 'filter_var( $x, FILTER_VALIDATE_FLOAT )',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'filter_var\' ) ) { $r = filter_var( $x, FILTER_VALIDATE_FLOAT ); if ( is_float( $r ) ) { pr_flt( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_var_array_float' => array(
			'title'         => 'filter_var_array (&hellip;)',
			'tooltip'       => 'filter_var_array( $x, FILTER_VALIDATE_FLOAT )',
			'url'           => 'https://php.net/filter_var_array',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'filter_var_array\' ) ) { pr_var( filter_var_array( $x, FILTER_VALIDATE_FLOAT ), \'\', true, true ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_combined_float' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_VALIDATE_FLOAT );
}
else {
	filter_var_array( $x, FILTER_VALIDATE_FLOAT );
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'float\', FILTER_VALIDATE_FLOAT ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_combined_float_null' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'float\', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),
		'filter_combined_flt_null_sanitize' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'float\', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),


		'filter_combined_flt_null_sanitize_allow_x3' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_NULL_ON_FAILURE|FILTER_FLAG_ALLOW_FRACTION| FILTER_FLAG_ALLOW_THOUSAND|FILTER_FLAG_ALLOW_SCIENTIFIC );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_NULL_ON_FAILURE|FILTER_FLAG_ALLOW_FRACTION| FILTER_FLAG_ALLOW_THOUSAND|FILTER_FLAG_ALLOW_SCIENTIFIC ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'float\', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_NULL_ON_FAILURE|FILTER_FLAG_ALLOW_FRACTION|FILTER_FLAG_ALLOW_THOUSAND|FILTER_FLAG_ALLOW_SCIENTIFIC ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),


		// Integer filters.
		'filter_var_int' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => 'filter_var( $x, FILTER_VALIDATE_INT )',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'filter_var\' ) ) { $r = filter_var( $x, FILTER_VALIDATE_INT ); if ( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_var_array_int' => array(
			'title'         => 'filter_var_array (&hellip;)',
			'tooltip'       => 'filter_var_array( $x, FILTER_VALIDATE_INT )',
			'url'           => 'https://php.net/filter_var_array',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'filter_var_array\' ) ) { pr_var( filter_var_array( $x, FILTER_VALIDATE_INT ), \'\', true, true ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_combined_int' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_VALIDATE_INT );
}
else {
	filter_var_array( $x, FILTER_VALIDATE_INT );
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'int\', FILTER_VALIDATE_INT ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_combined_int_null' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'int\', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),
		'filter_combined_int_null_min_max' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
$options = array( \'min_range\' => 1, \'max_range\' => 50 );
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE, $options );
}
else {
	filter_var_array( $x, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE, $options ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { $options = array( \'min_range\' => 1, \'max_range\' => 50 ); VartypePHP5::filter_combined( $x, \'int\', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE, $options ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),

		'filter_combined_int_null_hex_octal' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE| FILTER_FLAG_ALLOW_HEX|FILTER_FLAG_ALLOW_OCTAL );
}
else {
	filter_var_array( $x, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE| FILTER_FLAG_ALLOW_HEX|FILTER_FLAG_ALLOW_OCTAL ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'int\', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE|FILTER_FLAG_ALLOW_HEX|FILTER_FLAG_ALLOW_OCTAL ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),

		'filter_combined_int_null_sanitize' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'int\', FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),

		'filter_combined_int_null_sanitize_x3' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE| FILTER_FLAG_ALLOW_HEX|FILTER_FLAG_ALLOW_OCTAL );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE| FILTER_FLAG_ALLOW_HEX|FILTER_FLAG_ALLOW_OCTAL ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'int\', FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE|FILTER_FLAG_ALLOW_HEX|FILTER_FLAG_ALLOW_OCTAL ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),




		// String filters.
		'filter_var_string' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => 'filter_var( $x, FILTER_UNSAFE_RAW )',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'filter_var\' ) ) { $r = filter_var( $x, FILTER_UNSAFE_RAW ); if ( is_string( $r ) ) { pr_str( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_var_array_string' => array(
			'title'         => 'filter_var_array (&hellip;)',
			'tooltip'       => 'filter_var_array( $x, FILTER_UNSAFE_RAW )',
			'url'           => 'https://php.net/filter_var_array',
			'arg'           => '$x',
			'function'      => 'if ( function_exists( \'filter_var_array\' ) ) { pr_var( filter_var_array( $x, FILTER_UNSAFE_RAW ), \'\', true, true ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_combined_string' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_UNSAFE_RAW );
}
else {
	filter_var_array( $x, FILTER_UNSAFE_RAW );
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'string\', FILTER_UNSAFE_RAW ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
		),
		'filter_combined_string_null' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_UNSAFE_RAW, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_UNSAFE_RAW, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'string\', FILTER_UNSAFE_RAW, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),


		'filter_combined_str_null_sanitize' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'string\', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),


		'filter_combined_str_null_sanitize_encode' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE| FILTER_FLAG_ENCODE_LOW|FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_AMP );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE| FILTER_FLAG_ENCODE_LOW|FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_AMP ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'string\', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE|FILTER_FLAG_ENCODE_LOW|FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_AMP ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),

		'filter_combined_str_null_sanitize_strip' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE| FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE| FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'string\', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE|FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),

		'filter_combined_str_null_sanitize_special_chars' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) ) { VartypePHP5::filter_combined( $x, \'string\', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.2.0+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),

		'filter_combined_str_null_sanitize_full_special_chars' => array(
			'title'         => 'filter_var (&hellip;)',
			'tooltip'       => '
if( ! is_array( $x ) ) {
	filter_var( $x, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE );
}
else {
	filter_var_array( $x, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE ); // = Simplified... see note
}
			',
			'url'           => 'https://php.net/filter_var',
			'arg'           => '$x',
			'function'      => 'if ( extension_loaded( \'filter\' ) && defined( \'FILTER_SANITIZE_FULL_SPECIAL_CHARS\' ) ) { VartypePHP5::filter_combined( $x, \'string\', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE ); } else { print "E: not available (PHP 5.3.3+)\n"; }',
			'notes'         => array(
				'<p>The code snippet is simplified for brevity. Please refer to the source of this file on <a href="https://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a> for full details on how to use filter_var_array().</p>',
			),
		),

	);


	/**
	 * Setup the various tests across subsections to be show in individual tabs.
	 *
	 * @var array $test_groups
	 */
	var $test_groups = array(

		'general'        => array(
			'title'     => 'General typing',
			'tests'     => array(
				'gettype',
				'empty',
				'is_null',
				'isset',
				'bool',
				'if_var',
				'null_coalesce',
			),
			'break_at'  => array( 'gettype', 'if_var' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/types.comparisons',
			'target'    => null,
		),

		'type_testing'   => array(
			'title'     => 'is_&hellip;()',
			'tests'     => array(
				'gettype',

				'is_null',

				'is_scalar',
				'is_bool',
				'is_int',
				'is_float',
				'is_string',

				'is_array',
				'is_object',
				'is_resource',

				// 'is_binary', // PHP6 ?
				'is_callable',

				'is_numeric',

				'is_iterable',
				'is_countable',
			),
			'break_at'  => array( 'gettype', 'is_null', 'is_string', 'is_resource', 'is_callable', 'is_numeric', 'is_countable' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/ref.var',
			'target'    => null,
		),


		'null_tests'     => array(
			'title'     => 'Null',
			'tests'     => array(
				'settype_null',
				'unset',
				'f_unset',
				'cast_to_type_null',

				'isset',
				'null_coalesce',
				'empty',

				'is_null',
				'null_cmp_loose',
				'null_cmp_strict',
				'null_cmp_loose_str',
				'null_cmp_strict_str',
			),
			'break_at'  => array( 'cast_to_type_null', 'empty', 'null_cmp_strict_str', 'null_cmp_rv_strict_str' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/types.comparisons',
			'target'    => 'n',
		),


		'boolean_tests'  => array(
			'title'     => 'Boolean',
			'tests'     => array(
				'settype_bool',
				'bool',
				'filter_combined_bool',
				'filter_combined_bool_null',
				'cast_to_type_bool_not_empty_recurse_arrays',

				'is_bool',

				'bool_cmp_true_loose',
				'bool_cmp_true_strict',
				'bool_cmp_true_loose_int',
				'bool_cmp_true_loose_str',

				'bool_cmp_false_loose',
				'bool_cmp_false_strict',
				'bool_cmp_false_loose_int',
				'bool_cmp_false_loose_str',

				'if_var',
				'if_not_var',

			),
			'break_at'  => array( 'cast_to_type_bool_not_empty_recurse_arrays', 'is_bool', 'bool_cmp_true_loose_str', 'bool_cmp_rv_true_strict_str', 'bool_cmp_false_loose_str', 'bool_cmp_rv_false_strict_str', 'if_not_var' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/types.comparisons',
			'target'    => 'b',
		),


		'integer_tests'  => array(
			'title'     => 'Integers',
			'tests'     => array(
				'settype_int',
				'int',
				'intval',
				'juggle_int',
				'filter_combined_int',
				'filter_combined_int_null',
				'cast_to_type_int_not_empty_recurse_arrays',

				'abs',

				'empty',
				'is_int',
				'is_numeric',
				'ctype_digit',
				'preg_int_pos',
				'preg_int',
				'preg_int_unicode',
			),
			'break_at'  => array( 'cast_to_type_int_not_empty_recurse_arrays', 'abs', 'preg_int_unicode' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.var',
			'target'    => 'i',
		),


		'float_tests'    => array(
			'title'     => 'Floats',
			'tests'     => array(
				'settype_float',
				'float',
				'floatval',
				'juggle_flt',
				'filter_combined_float',
				'filter_combined_float_null',
				'cast_to_type_float_not_empty_recurse_arrays',

				'empty',
				'is_float',
				'is_numeric',
				'ctype_digit',
				'preg_float_pos',
				'preg_float',
				'preg_number_unicode',
			),
			'break_at'  => array( 'cast_to_type_float_not_empty_recurse_arrays', 'preg_number_unicode' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.var',
			'target'    => 'f',
		),


		'numeric_tests'  => array(
			'title'     => 'Numeric tests',
			'tests'     => array(
				'is_numeric',

				'ctype_digit',
				'preg_int_unicode',
				'preg_number_unicode',

				'int_cmp_gt0',
				'int_cmp_gte0',
				'int_cmp_is0_loose',
				'int_cmp_is0_strict',
				'int_cmp_not0_loose',
				'int_cmp_not0_strict',
				'int_cmp_lt0',
				'int_cmp_lte0',

				'is_nan',
				'is_finite',
				'is_infinite',

				'floor',
				'ceil',
				'round',
			),
			'break_at'  => array( 'is_numeric', 'preg_number_unicode', 'int_cmp_lte0', 'is_infinite', 'round' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.var',
			'target'    => '',
		),


		'string_casting' => array(
			'title'     => 'String casting',
			'tests'     => array(
				'settype_string',
				'string',
				'strval',
				'juggle_str',
				'filter_combined_string',
				'filter_combined_string_null',
				'cast_to_type_string_not_empty_recurse_arrays',
			),
			'break_at'  => array( 'cast_to_type_string_not_empty_recurse_arrays' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.strings',
			'target'    => 's',
		),


		'string_tests'   => array(
			'title'     => 'String tests',
			'tests'     => array(
				'is_string',

				'empty',
				'str_cmp_empty_loose',
				'str_cmp_empty_strict',

				'ctype_alpha',
				'preg_alpha',
				'preg_alpha_unicode',

				'ctype_alnum',
				'preg_alnum',
				'preg_word',
				'preg_word_utf8',
				'preg_alnum_unicode',

				'strlen',
				'count_chars',
				'mb_strlen',

				'char_access',

				'trim',
			),
			'break_at'  => array( 'is_string', 'str_cmp_empty_strict', 'preg_alpha_unicode', 'preg_alnum_unicode', 'mb_strlen', 'char_access', 'trim' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.strings',
			'target'    => 's',
		),


		'array_casting'  => array(
			'title'     => 'Array casting',
			'tests'     => array(
				'settype_array',
				'array',
				'cast_to_type_array_not_empty',
			),
			'break_at'  => array( 'cast_to_type_array_not_empty' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.array',
			'target'    => 'a',
		),


		'array_tests'    => array(
			'title'     => 'Array testing',
			'tests'     => array(
				'is_array',
				'count',

				'empty',
				'count_mt_0',
				'is_iterable',
				'is_countable',

				'isset_0',
				'array_key_exists',
				'isset_foo',

				'key',
				'current',
				'array_access_simple_string',
				'array_access_multi_string',

				'array_filter',
			),
			'break_at'  => array( 'count', 'is_countable', 'isset_foo', 'array_access_multi_string', 'array_filter' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.array',
			'target'    => 'a',
		),


		'object_tests'   => array(
			'title'     => 'Objects',
			'tests'     => array(
				'settype_object',
				'object',
				'cast_to_type_object_not_empty',

				'is_object',
				'is_a',
				'instanceof',

				'get_class',
				'get_parent_class',
				'is_subclass_of',
			),
			'break_at'  => array( 'cast_to_type_object', 'cast_to_type_object_not_empty', 'instanceof', 'is_subclass_of' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.classobj',
			'target'    => 'o',
		),


		'resource_tests' => array(
			'title'     => 'Resources',
			'tests'     => array(
				'is_resource',
				'get_resource_type',
			),
			'break_at'  => array( 'is_resource', 'get_resource_type' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => '',
			'target'    => 'r',
		),


		'arithmetic'     => array(
			'title'     => 'Basic Arithmetic',
			'tests'     => array(
				'pre_increment',
				'post_increment',
				'pre_decrement',
				'post_decrement',

				'arithmetic_negate',
				'juggle_int',
				'arithmetic_subtract',
				'arithmetic_multiply',
				'arithmetic_divide',
				'arithmetic_modulus',

			),
			'break_at'  => array( 'post_decrement', 'arithmetic_modulus' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/language.operators.arithmetic',
			'target'    => '',
		),
	);


	/**
	 * Additional testgroup only to be added if the ctype extension is available.
	 *
	 * @var array $ctype_test_group
	 */
	var $ctype_test_group = array(
		'ctype_extension' => array(
			'title'     => 'CType Extension',
			'tests'     => array(
				'ctype_digit',
				'ctype_xdigit',

				'ctype_alpha',
				'ctype_alnum',
				'ctype_graph',
				'ctype_print',

				'ctype_lower', // Has issues on PHP 5.0.5.
				'ctype_upper',

				'ctype_cntrl', // Has issues on PHP 5.0.5.
				'ctype_punct', // Has issues on PHP 5.0.5.
				'ctype_space',
			),
			'break_at'  => array( 'ctype_xdigit', 'ctype_print', 'ctype_upper', 'ctype_space' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.ctype',
			'target'    => 's',
		),
	);


	/**
	 * Additional testgroup only to be added if the filter extension is available.
	 *
	 * @var array $ctype_test_group
	 */
	var $filter_test_group = array(
		'filter_extension_bool_int_float' => array(
			'title'     => 'Filter Extension - bool/int/float',
			'tests'     => array(
				'filter_combined_bool_null',

				'filter_combined_int_null',
				'filter_combined_int_null_min_max',
				'filter_combined_int_null_hex_octal',
				'filter_combined_int_null_sanitize',
				/* 'filter_combined_int_null_sanitize_x3', */

				'filter_combined_float_null',
				'filter_combined_flt_null_sanitize',
				'filter_combined_flt_null_sanitize_allow_x3',

			),
			'break_at'  => array( 'filter_combined_bool_null', 'filter_combined_int_null_sanitize', 'filter_combined_flt_null_sanitize_allow_x3' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.filter',
			'target'    => '',
		),

		'filter_extension_strings' => array(
			'title'     => 'Filter Extension - string',
			'tests'     => array(
				'filter_combined_string_null',
				'filter_combined_str_null_sanitize',
				'filter_combined_str_null_sanitize_encode',
				'filter_combined_str_null_sanitize_strip',
				'filter_combined_str_null_sanitize_special_chars',
				'filter_combined_str_null_sanitize_full_special_chars',
			),
			'break_at'  => array( 'filter_combined_str_null_sanitize_full_special_chars' ),
			'good'      => array(),
			'best'      => array(),
			'urls'      => array(),
			'book_url'  => 'https://php.net/book.filter',
			'target'    => '',
		),
	);


	/**
	 * Constructor.
	 */
	function __construct() {

		// Make sure the tests presented will be compatible with the install the cheatsheet is running on.
		$this->phpcompat_filter_tests();

		/**
		 * Adjust float regex tests to use the correct decimal point character.
		 */
		// Try & get decimal point for use in float operations.
		if ( ! defined( 'DECIMAL_POINT' ) ) {
			$locale_info = localeconv();
			define( 'DECIMAL_POINT', $locale_info['decimal_point'] );
			unset( $locale_info );
		}
		// Prep decimal point for use in regex.
		if ( defined( 'DECIMAL_POINT' ) ) {
			$preg_point = preg_quote( DECIMAL_POINT, '`' );
		}
		else {
			$preg_point = preg_quote( '.,', '`' );
		}

		$targets = array(
			'preg_float_pos',
			'preg_float',
			'preg_digit_float_pos',
			'preg_digit_float',
			'preg_number_unicode_pos',
			'preg_number_unicode',
		);
		foreach ( $targets as $target ) {
			foreach ( $this->tests[ $target ] as $key => $value ) {
				$this->tests[ $target ][ $key ] = str_replace( '##PREG_DECIMAL_POINT##', $preg_point, $value );
			}
		}
		unset( $preg_point );

		parent::__construct();
	}


	/**
	 * PHP4 compatibility constructor.
	 */
	function VartypeTest() {
		$this->__construct();
	}


	/**
	 * Filter out some tests which would break the cheatsheets and merge some which won't.
	 */
	function phpcompat_filter_tests() {

		// Work around some bugs in PHP versions having issues with ctype.
		if ( extension_loaded( 'ctype' ) ) {
			// Remove some tests which give issues in PHP5.0.x.
			if ( PHP_VERSION_ID === 50005 || PHP_VERSION_ID === 50004 ) {
				unset(
					$this->ctype_test_group['ctype_extension']['tests'][6], // Function ctype_lower().
					$this->ctype_test_group['ctype_extension']['tests'][8], // Function ctype_cntrl().
					$this->ctype_test_group['ctype_extension']['tests'][9]  // Function ctype_punct().
				);
			}
			// Merge the ctype testgroup.
			$this->test_groups = array_merge( $this->test_groups, $this->ctype_test_group );
		}

		if ( extension_loaded( 'filter' ) && function_exists( 'filter_var' ) && defined( 'FILTER_NULL_ON_FAILURE' ) ) {
			$this->test_groups = array_merge( $this->test_groups, $this->filter_test_group );
		}

		// Remove null coalesce test for PHP < 7.
		if ( PHP_VERSION_ID < 70000 ) {
			unset(
				$this->tests['null_coalesce'],
				$this->test_groups['general']['tests'][6],
				$this->test_groups['null_tests']['tests'][5]
			);
		}
	}


	/**
	 * Work around some really weird bug which I haven't been able to track down yet.
	 *
	 * Bug details: some semi-random text string is shown for the INF constant on the
	 * object_test sheet in PHP 5.0.x.
	 * Similarly a "Fatal error:  Unknown function:  f8()" is shown just before the array_testing group in 4.3.11.
	 *
	 * @param string|null $test_group The current subsection.
	 */
	function set_test_data( $test_group = null ) {
		parent::set_test_data( $test_group );

		if ( ( PHP_VERSION_ID >= 50004 && PHP_VERSION_ID <= 50005 ) || phpversion() === '4.3.11' ) {
			$key = array_search( 'f8', $this->test_data_keys, true );
			unset( $this->test_data_keys[ $key ], $this->test_data['f8'] );
		}
	}
}
