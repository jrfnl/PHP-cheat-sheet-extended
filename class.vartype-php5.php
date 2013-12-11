<?php

/**
 *
 */
class VartypePHP5 {
	
	/**
	 * Tests to be run, add in child class
	 */
	static public $tests = array(
		/**
		 * String comparison functions
		 * @see class.vartype-compare.php
		 */
		'strcmp'		=> array(
			'function'		=> 'VartypePHP5::compare_strings( $a, $b, "strcmp" );',
		),
		'strcasecmp'	=> array(
			'function'		=> 'VartypePHP5::compare_strings( $a, $b, "strcasecmp" );',
		),
		'strnatcmp'		=> array(
			'function'		=> 'VartypePHP5::compare_strings( $a, $b, "strnatcmp" );',
		),
		'strnatcasecmp'	=> array(
			'function'		=> 'VartypePHP5::compare_strings( $a, $b, "strnatcasecmp" );',
		),
		'strcoll'		=> array(
			'function'		=> 'VartypePHP5::compare_strings( $a, $b, "strcoll" );',
		),
		'similar_text'	=> array(
			'function'		=> 'VartypePHP5::compare_strings( $a, $b, "similar_text" );',
		),
		'levenshtein'	=> array(
			'function'		=> 'VartypePHP5::compare_strings( $a, $b, "levenshtein" );',
		),
		
		
		
		/**
		 * Loose type juggling
		 * @see class.vartype-test.php
		 */
		'juggle_int' =>	array(
			'function'	=>	'
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
				catch( Exception $e ) {
					$message = $e->getMessage();
					$key = array_search( $message, $GLOBALS[\'encountered_errors\'] );
					if ( $key === false ) {
						$GLOBALS[\'encountered_errors\'][] = $message;
						$key = array_search( $message, $GLOBALS[\'encountered_errors\'] );
					}
					print \'<span class="error">Fatal error <a href="#\' . $GLOBALS[\'test\']. \'-errors">#\' . ( $key + 1 ) . \'</a></span>\';
				}
			',
		),
		'juggle_flt' =>	array(
			'function'	=> '
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
				catch( Exception $e ) {
					$message = $e->getMessage();
					$key = array_search( $message, $GLOBALS[\'encountered_errors\'] );
					if ( $key === false ) {
						$GLOBALS[\'encountered_errors\'][] = $message;
						$key = array_search( $message, $GLOBALS[\'encountered_errors\'] );
					}
					print \'<span class="error">Fatal error <a href="#\' . $GLOBALS[\'test\']. \'-errors">#\' . ( $key + 1 ) . \'</a></span>\';
				}
			',
		),
		
		
		/**
		 * Some object related functions
		 * @see class.vartype-test.php
		 */
		'instanceof' => array(
			'function'	=>	'$c = \'TestObject\'; $r = ( $x instanceof $c ); if ( is_bool( $r ) ) { pr_bool( $r ); } else { pr_var( $r, \'\', true, true ); }',
		),
	);


	/**
	 * Overwrite selected entries in the original test array with the above PHP5 specific function code
	 *
	 * @param	array	$test_array
	 * @return	array
	 */
	static public function merge_tests( $test_array ) {

		foreach ( self::$tests as $key => $array ) {
			if ( isset( $test_array[$key] ) && ( isset( $test_array[$key]['function'] ) && isset( $array['function'] ) ) ) {
				$test_array[$key]['function'] = $array['function'];
			}
		}
		return $test_array;
	}


	/**
	 * @param $value
	 *
	 * @return object
	 */
	static public function generate_value( $value ) {

		if ( is_object( $value ) ) {
			$value = clone( $value );
		}
		return $value;
	}


	/**
	 * @param $a
	 * @param $b
	 * @param $function
	 */
	static public function compare_strings( $a, $b, $function ) {

		if ( ( PHP_VERSION_ID >= 50000 && $function === 'levenshtein' ) && ( ( gettype( $a ) === 'array' || gettype( $a ) === 'resource' ) || ( gettype( $b ) === 'array' || gettype( $b ) === 'resource' ) ) ) {
			try {
				$r = $function( $a, $b );
				if ( is_int( $r ) ) {
					pr_int( $r );
				}
				else {
					pr_var( $r, '', true, true );
				}
			}
			catch( Exception $e ) {
				$message = $e->getMessage();
				$key     = array_search( $message, $GLOBALS['encountered_errors'] );
				if ( $key === false ) {
					$GLOBALS['encountered_errors'][] = $message;
					$key = array_search( $message, $GLOBALS['encountered_errors'] );
				}
				print '<span class="error">Fatal error <a href="#' . $GLOBALS['test']. '-errors">#' . ( $key + 1 ) . '</a></span>';
			}
		}
		else if ( PHP_VERSION_ID >= 50200 && ( gettype( $a ) === 'object' || gettype( $b ) === 'object' ) ) {
			try {
				$r = $function( $a, $b );
				if ( is_int( $r ) ) {
					pr_int( $r );
				}
				else {
					pr_var( $r, '', true, true );
				}
			}
			catch( Exception $e ) {
				$message = $e->getMessage();
				$key     = array_search( $message, $GLOBALS['encountered_errors'] );
				if ( $key === false ) {
					$GLOBALS['encountered_errors'][] = $message;
					$key = array_search( $message, $GLOBALS['encountered_errors'] );
				}
				print '<span class="error">Fatal error <a href="#' . $GLOBALS['test']. '-errors">#' . ( $key + 1 ) . '</a></span>';
			}
		}
		else {
			$r = $function( $a, $b );
			if ( is_int( $r ) ) {
				pr_int( $r );
			}
			else {
				pr_var( $r, '', true, true );
			}
		}
	}
}

?>