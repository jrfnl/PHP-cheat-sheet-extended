<?php

/**
 *
 */
class TestObject {

	var $test1;
	var $test2 = true;


	/**
	 * @param $var
	 */
	function print_it( $var ) {
		print htmlspecialchars( $var );
	}
}

/**
 *
 */
class TestObjectToString extends TestObject {

	var $test3 = 'some string';


	/**
	 * @return string
	 */
	function __toString() {
		return $this->test3;
	}
}




/**
 * Catch errors to display in appendix
 */

function do_handle_errors( $error_no, $error_str, $error_file, $error_line ) {
	if ( ! ( error_reporting() & $error_no ) ) {
		return;
	}

	if ( ! defined( 'E_STRICT' ) )				define( 'E_STRICT', 2048 );
	if ( ! defined( 'E_RECOVERABLE_ERROR' ) )	define( 'E_RECOVERABLE_ERROR', 4096 );
	if ( ! defined( 'E_DEPRECATED' ) )			define( 'E_DEPRECATED', 8192 );
	if ( ! defined( 'E_USER_DEPRECATED' ) )		define( 'E_USER_DEPRECATED', 16384 );

	switch ( $error_no ){
		case E_ERROR: // 1 //
		case E_CORE_ERROR: // 16 //
		case E_COMPILE_ERROR: // 64 //
			$type  = 'Fatal error';
			$class = 'error';
			break;
		case E_USER_ERROR: // 256 //
			$type  = 'Fatal error';
			$class = 'error';
			break;
		case E_WARNING: // 2 //
		case E_CORE_WARNING: // 32 //
		case E_COMPILE_WARNING: // 128 //
			$type  = 'Warning';
			$class = 'warning';
			break;
		case E_USER_WARNING: // 512 //
			$type  = 'Warning';
			$class = 'warning';
			break;
		case E_PARSE: // 4 //
			$type  = 'Parse error';
			$class = 'error';
			break;
		case E_NOTICE: // 8 //
		case E_USER_NOTICE: // 1024 //
			$type  = 'Notice';
			$class = 'notice';
			break;
		case E_STRICT: // 2048 //
			$type  = 'Strict warning';
			$class = 'warning';
			break;
		case E_RECOVERABLE_ERROR: // 4096 //
			$type  = '(Catchable) Fatal error';
			$class = 'error';
			break;
		case E_DEPRECATED: // 8192 //
		case E_USER_DEPRECATED: // 16384 //
			$type  = 'Deprecated';
			$class = 'notice';
			break;
		default:
			$type  = 'Unknown error ( ' . $error_no . ' )';
			$class = 'error';
			break;
	}
	

	// Group some messages
	$search = array(
		'array_key_exists() expects parameter 2 to be array',
		'key() expects parameter 1 to be array',
		'current() expects parameter 1 to be array',
		'array_filter() expects parameter 1 to be array',
		'preg_match() expects parameter 2 to be string',
		'strlen() expects parameter 1 to be string',
		'count_chars() expects parameter 1 to be string',
		'mb_strlen() expects parameter 1 to be string',
		'trim() expects parameter 1 to be string',
		'is_nan() expects parameter 1 to be double',
		'is_finite() expects parameter 1 to be double',
		'is_infinite() expects parameter 1 to be double',
		'get_class() expects parameter 1 to be object',
		'get_resource_type() expects parameter 1 to be resource',
		'fmod() expects parameter 1 to be double',
		'fmod() expects parameter 2 to be double',
		'bcadd() expects parameter 1 to be string',
		'bcadd() expects parameter 2 to be string',
		'bcsub() expects parameter 1 to be string',
		'bcsub() expects parameter 2 to be string',
		'bcmul() expects parameter 1 to be string',
		'bcmul() expects parameter 2 to be string',
		'bcdiv() expects parameter 1 to be string',
		'bcdiv() expects parameter 2 to be string',
		'bcmod() expects parameter 1 to be string',
		'bcmod() expects parameter 2 to be string',
	);

	$replace = array(
		'array_key_exists() expects parameter 2 to be array, <em>null/boolean/integer/double/string/object/resource</em> given',
		'key() expects parameter 1 to be array, <em>null/boolean/integer/double/string/object/resource</em> given',
		'current() expects parameter 1 to be array, <em>null/boolean/integer/double/string/object/resource</em> given',
		'array_filter() expects parameter 1 to be array, <em>null/boolean/integer/double/string/object/resource</em> given',
		'preg_match() expects parameter 2 to be string, <em>array/object/resource</em> given',
		'strlen() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'count_chars() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'mb_strlen() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'trim() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'is_nan() expects parameter 1 to be double, <em>string/array/object/resource</em> given',
		'is_finite() expects parameter 1 to be double, <em>string/array/object/resource</em> given',
		'is_infinite() expects parameter 1 to be double, <em>string/array/object/resource</em> given',
		'get_class() expects parameter 1 to be object, <em>boolean/integer/double/string/array/resource</em> given',
		'get_resource_type() expects parameter 1 to be resource, <em>null/boolean/integer/double/string/array/object</em> given',
		'fmod() expects parameter 1 to be double, <em>string/array/object/resource</em> given',
		'fmod() expects parameter 2 to be double, <em>string/array/object/resource</em> given',
		'bcadd() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'bcadd() expects parameter 2 to be string, <em>array/object/resource</em> given',
		'bcsub() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'bcsub() expects parameter 2 to be string, <em>array/object/resource</em> given',
		'bcmul() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'bcmul() expects parameter 2 to be string, <em>array/object/resource</em> given',
		'bcdiv() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'bcdiv() expects parameter 2 to be string, <em>array/object/resource</em> given',
		'bcmod() expects parameter 1 to be string, <em>array/object/resource</em> given',
		'bcmod() expects parameter 2 to be string, <em>array/object/resource</em> given',
	);

	// Group some more messages and make error message links work
	$preg_search  = array(
		'`^Object of class [A-Za-z]+ could not be converted to (int|double|string)$`',
		'`^Object of class [A-Za-z]+ to string conversion$`',
		'`^Cannot use object of type [A-Za-z]+ as array$`',
		'`<a href=(["\'])function\.`',
	);
	$preg_replace = array(
		'Object of class <em>stdClass/TestObject/TestObjectToString</em> could not be converted to $1',
		'Object of class <em>stdClass/TestObject/TestObjectToString</em> to string conversion',
		'Cannot use object of type <em>stdClass/TestObject/TestObjectToString</em> as array',
		'<a href=$1http://php.net/function.',
	);


	foreach ( $search as $k => $s ) {
		if ( strpos( $error_str, $s ) === 0 ) {
			$error_str = $replace[$k];
			break;
		}
	}
	$error_str = preg_replace( $preg_search, $preg_replace, $error_str );






	$message = '<span class="' . $class . '">' . $type . '</span>: ' . $error_str;

	if ( isset( $GLOBALS['encountered_errors'] ) ) {
		// Ignore strict warnings (can't avoid having them if I want to keep this sheet working with PHP4)
		if ( $error_no !== E_STRICT ) {
			$key = array_search( $message, $GLOBALS['encountered_errors'] );
			if ( $key === false ) {
				$GLOBALS['encountered_errors'][] = $message;
				$key = array_search( $message, $GLOBALS['encountered_errors'] );
			}

			if ( $class === 'notice' ) {
				$GLOBALS['has_error'][]['msg'] = ' (&nbsp;<span class="notice"><a href="#' . $GLOBALS['test']. '-errors">#' . ( $key + 1 ) . '</a></span>&nbsp;)';
				return;
			}
			else if ( $class === 'warning' ) {
				$GLOBALS['has_error'][]['msg'] = ' (&nbsp;<span class="warning"><a href="#' . $GLOBALS['test']. '-errors">#' . ( $key + 1 ) . '</a></span>&nbsp;)';
				return;
			}
			else if ( $class === 'error' ) {
				$GLOBALS['has_error'][]['msg'] = ' <span class="error">' . $type . ' (&nbsp;<a href="#' . $GLOBALS['test']. '-errors">#' . ( $key + 1 ) . '</a>&nbsp;)</span>';
				return;
			}
			else {
				print $message . ' in ' . $error_file . ' on line ' . $error_line . "<br />\n";
			}
		}
		else {
			return;
		}
	}
	else {
		if ( $error_no !== E_STRICT ) {
			print $message . ' in ' . $error_file . ' on line ' . $error_line . "<br />\n";
		}
		else {
			return;
		}
	}

	return false; // Make sure it plays nice with other error handlers (remove if no other error handlers are set)
}
