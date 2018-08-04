<?php
/**
 * PHP 5+ tests.
 *
 * @package PHPCheatsheets
 *
 * Select PHPCS exclusions: this file is only included when on PHP 5+.
 * @phpcs:disable PHPCompatibility.PHP.NewClasses.exceptionFound
 *
 * Select PHPCS exclusions: the calls to these functions are wrapped in a function_exists() check.
 * @phpcs:disable PHPCompatibility.PHP.NewFunctions.filter_varFound
 * @phpcs:disable PHPCompatibility.PHP.NewFunctions.filter_var_arrayFound
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * Overload some tests when using PHP5.
 *
 * These tests are added in the relevant child class of the Vartype class.
 */
class VartypePHP5 {

	/**
	 * The PHP5 specific tests which will overrule the PHP4 compatible tests.
	 *
	 * @var array $tests  Multi-dimensional array.
	 */
	public static $tests = array(

		/*
		 * String comparison functions.
		 *
		 * @see class.vartype-compare.php
		 */
		'strcmp'        => array(
			'function'      => 'VartypePHP5::compare_strings( $a, $b, "strcmp" );',
		),
		'strcasecmp'    => array(
			'function'      => 'VartypePHP5::compare_strings( $a, $b, "strcasecmp" );',
		),
		'strnatcmp'     => array(
			'function'      => 'VartypePHP5::compare_strings( $a, $b, "strnatcmp" );',
		),
		'strnatcasecmp' => array(
			'function'      => 'VartypePHP5::compare_strings( $a, $b, "strnatcasecmp" );',
		),
		'strcoll'       => array(
			'function'      => 'VartypePHP5::compare_strings( $a, $b, "strcoll" );',
		),
		'similar_text'  => array(
			'function'      => 'VartypePHP5::compare_strings( $a, $b, "similar_text" );',
		),
		'levenshtein'   => array(
			'function'      => 'VartypePHP5::compare_strings( $a, $b, "levenshtein" );',
		),



		/*
		 * Loose type juggling.
		 *
		 * @see class.vartype-test.php
		 */
		'juggle_int'    => array(
			'function'      => '
				try {
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
				}
				catch ( Exception $e ) {
					$message = $e->getMessage();
					$key = array_search( $message, $GLOBALS[\'encountered_errors\'] );
					if ( $key === false ) {
						$GLOBALS[\'encountered_errors\'][] = $message;
						$key = array_search( $message, $GLOBALS[\'encountered_errors\'] );
					}
					echo \'<span class="error">Fatal error <a href="#\', $GLOBALS[\'test\'], \'-errors">#\', ( $key + 1 ), \'</a></span>\';
				}
			',
		),
		'juggle_flt'    => array(
			'function'      => '
				try {
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
				}
				catch ( Exception $e ) {
					$message = $e->getMessage();
					$key = array_search( $message, $GLOBALS[\'encountered_errors\'] );
					if ( $key === false ) {
						$GLOBALS[\'encountered_errors\'][] = $message;
						$key = array_search( $message, $GLOBALS[\'encountered_errors\'] );
					}
					echo \'<span class="error">Fatal error <a href="#\', $GLOBALS[\'test\'], \'-errors">#\', ( $key + 1 ), \'</a></span>\';
				}
			',
		),


		/*
		 * Some object related functions.
		 *
		 * @see class.vartype-test.php
		 */
		'instanceof'    => array(
			'function'      => '$c = \'TestObject\'; $r = ( $x instanceof $c ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
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
	 * Ensure we clone an object before using it to avoid contamination by results of previous actions.
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public static function generate_value( $value ) {

		if ( is_object( $value ) ) {
			$value = clone $value;
		}

		if ( is_array( $value ) || is_object( $value ) ) {
			reset( $value );
		}

		return $value;
	}


	/**
	 * Smarter way to compare strings in PHP5.
	 *
	 * @param mixed  $var1
	 * @param mixed  $var2
	 * @param string $function
	 */
	public static function compare_strings( $var1, $var2, $function ) {

		if ( ( PHP_VERSION_ID >= 50000 && $function === 'levenshtein' ) && ( ( gettype( $var1 ) === 'array' || gettype( $var1 ) === 'resource' ) || ( gettype( $var2 ) === 'array' || gettype( $var2 ) === 'resource' ) ) ) {
			try {
				pc_compare_strings( $var1, $var2, $function );
			}
			catch ( Exception $e ) {
				self::handle_exception( $e->getMessage() );
			}
		}
		else if ( PHP_VERSION_ID >= 50200 && ( gettype( $var1 ) === 'object' || gettype( $var2 ) === 'object' ) ) {
			try {
				pc_compare_strings( $var1, $var2, $function );
			}
			catch ( Exception $e ) {
				self::handle_exception( $e->getMessage() );
			}
		}
		else {
			pc_compare_strings( $var1, $var2, $function );
		}
	}


	/**
	 * Helper function to handle exceptions from the string compare function.
	 *
	 * @param string $message The error message.
	 */
	public static function handle_exception( $message ) {
		$key = get_error_key( $message );
		echo '<span class="error">(Catchable) Fatal error <a href="#', $GLOBALS['test'], '-errors">#', ( $key + 1 ), '</a></span>';
	}


	/**
	 * Run tests using the filter extension.
	 *
	 * @param mixed       $value    Value to test.
	 * @param string|null $expected Expected variable type of the output of the test.
	 * @param int         $filter   The Filter to apply.
	 * @param mixed|null  $flags    Which filter flags to apply.
	 * @param mixed|null  $options  Which options to apply.
	 */
	public static function filter_combined( $value, $expected = null, $filter = FILTER_DEFAULT, $flags = null, $options = null ) {

		if ( function_exists( 'filter_var' ) && function_exists( 'filter_var_array' ) ) {
			if ( ! is_array( $value ) ) {
				self::do_filter_var( $value, $expected, $filter, $flags, $options );
			}
			else {
				self::do_filter_var_array( $value, $filter, $flags, $options );
			}
		}
		else {
			echo 'E: not available (PHP 5.2.0+)';
		}
	}


	/**
	 * Helper function: Run tests using the `filter_var()` function.
	 *
	 * @param mixed       $value    Value to test.
	 * @param string|null $expected Expected variable type of the output of the test.
	 * @param int         $filter   The Filter to apply.
	 * @param mixed|null  $flags    Which filter flags to apply.
	 * @param mixed|null  $options  Which options to apply.
	 */
	public static function do_filter_var( $value, $expected = null, $filter = FILTER_DEFAULT, $flags = null, $options = null ) {
		$opt = array();
		if ( isset( $flags ) ) {
			$opt['flags'] = $flags;
		}
		if ( isset( $options ) && ( is_array( $options ) && $options !== array() ) ) {
			$opt['options'] = $options;
		}

		if ( $opt !== array() ) {
			$result = filter_var( $value, $filter, $opt );
		}
		else {
			$result = filter_var( $value, $filter );
		}

		self::print_typed_result( $result, $expected );
	}


	/**
	 * Helper function: Run tests using the `filter_var_array()` function.
	 *
	 * @param mixed      $value   Value to test.
	 * @param int        $filter  The Filter to apply.
	 * @param mixed|null $flags   Which filter flags to apply.
	 * @param mixed|null $options Which options to apply.
	 */
	public static function do_filter_var_array( $value, $filter = FILTER_DEFAULT, $flags = null, $options = null ) {
		if ( ! isset( $flags ) && ! isset( $options ) ) {
			pr_var( filter_var_array( $value, $filter ), '', true, true );
		}
		else {
			$input      = array(
				'x' => $value,
			);
			$filter_def = array(
				'x' => array(
					'filter' => $filter,
				),
			);
			if ( isset( $flags ) ) {
				$filter_def['x']['flags'] = ( FILTER_REQUIRE_ARRAY | $flags );
			}
			if ( isset( $options ) && ( is_array( $options ) && $options !== array() ) ) {
				$filter_def['x']['options'] = $options;
			}
			$output = filter_var_array( $input, $filter_def );
			pr_var( $output['x'], '', true, true );
		}
	}


	/**
	 * Helper function to print the filter result.
	 *
	 * @param mixed       $result
	 * @param string|null $expected Expected variable type of the output of the test.
	 */
	public static function print_typed_result( $result, $expected = null ) {
		switch ( true ) {
			case ( $expected === 'bool' && is_bool( $result ) === true ):
				pr_bool( $result );
				break;

			case ( $expected === 'int' && is_int( $result ) === true ):
				pr_int( $result );
				break;

			case ( $expected === 'float' && is_float( $result ) === true ):
				pr_flt( $result );
				break;

			case ( $expected === 'string' && is_string( $result ) === true ):
				pr_str( $result );
				break;

			default:
				pr_var( $result, '', true, true );
				break;
		}
	}
}
