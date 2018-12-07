<?php
/**
 * Some generic functions and mock objects for test variables.
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
 * Simple object to use for tests with the object variable type.
 */
class TestObject {

	/**
	 * A property.
	 *
	 * @var null
	 */
	var $test1;

	/**
	 * Another property.
	 *
	 * @var bool
	 */
	var $test2 = true;


	/**
	 * Example method.
	 *
	 * @param string $var
	 */
	function print_it( $var ) {
		echo htmlspecialchars( $var );
	}
}

/**
 * Another simple object to use for tests with the object variable type.
 */
class TestObjectToString extends TestObject {

	/**
	 * A third property.
	 *
	 * @var string
	 */
	var $test3 = 'some string';


	/**
	 * Example __toString method.
	 *
	 * @return string
	 *
	 * @phpcs:disable PHPCompatibility.FunctionNameRestrictions.NewMagicMethods.__tostringFound -- Used for demo purposes.
	 */
	function __toString() {
		return $this->test3;
	}
	// phpcs:enable
}


/**
 * Helper function to compare strings, compatible with PHP4.
 *
 * @param mixed  $var1
 * @param mixed  $var2
 * @param string $function
 */
function pc_compare_strings( $var1, $var2, $function ) {
	$result = $function( $var1, $var2 );
	if ( is_int( $result ) ) {
		pr_int( $result );
	}
	else {
		pr_var( $result, '', true, true );
	}
}


/**
 * Catch errors to display in appendix.
 *
 * @param int    $error_no
 * @param string $error_str
 * @param string $error_file
 * @param int    $error_line
 *
 * @return null|false
 */
function do_handle_errors( $error_no, $error_str, $error_file, $error_line ) {
	if ( ! ( error_reporting() & $error_no ) ) {
		return;
	}

	if ( ! defined( 'E_STRICT' ) ) {
		define( 'E_STRICT', 2048 );
	}
	if ( ! defined( 'E_RECOVERABLE_ERROR' ) ) {
		define( 'E_RECOVERABLE_ERROR', 4096 );
	}
	if ( ! defined( 'E_DEPRECATED' ) ) {
		define( 'E_DEPRECATED', 8192 );
	}
	if ( ! defined( 'E_USER_DEPRECATED' ) ) {
		define( 'E_USER_DEPRECATED', 16384 );
	}

	switch ( $error_no ) {
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


	// Group some messages.
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
		'get_class() expects parameter 1 to be object',
		'get_resource_type() expects parameter 1 to be resource',
		'intdiv() expects parameter 1 to be integer',
		'intdiv() expects parameter 2 to be integer',
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
		'get_class() expects parameter 1 to be object, <em>boolean/integer/double/string/array/resource</em> given',
		'get_resource_type() expects parameter 1 to be resource, <em>null/boolean/integer/double/string/array/object</em> given',
		'intdiv() expects parameter 1 to be integer, <em>float/string/array/object/resource</em> given',
		'intdiv() expects parameter 2 to be integer, <em>float/string/array/object/resource</em> given',
	);

	// Group some more messages and make error message links work.
	$preg_search  = array(
		'`^(bc(?:add|sub|mul|div|mod|comp)|str(?:case|natcase|nat)?cmp|strcoll|similar_text|levenshtein)\(\) expects parameter ([12]) to be string, (?:array|object|resource) given$`',
		'`^fmod\(\) expects parameter ([12]) to be (double|float), (?:string|array|object|resource) given$`',
		'`^(is_(?:nan|(?:in)?finite))\(\) expects parameter ([12]) to be (double|float), (?:string|array|object|resource) given$`',
		'`^Object of class [A-Za-z]+ could not be converted to (int|double|float|string)$`',
		'`^Object of class [A-Za-z]+ to string conversion$`',
		'`^Cannot use object of type [A-Za-z]+ as array$`',
		'`<a href=(["\'])function\.`',
	);
	$preg_replace = array(
		'$1() expects parameter $2 to be string, <em>array/object/resource</em> given',
		'fmod() expects parameter $1 to be $2, <em>string/array/object/resource</em> given',
		'$1() expects parameter $2 to be $3, <em>string/array/object/resource</em> given',
		'Object of class <em>stdClass/TestObject/TestObjectToString</em> could not be converted to $1',
		'Object of class <em>stdClass/TestObject/TestObjectToString</em> to string conversion',
		'Cannot use object of type <em>stdClass/TestObject/TestObjectToString</em> as array',
		'<a href=$1https://php.net/function.',
	);

	foreach ( $search as $k => $s ) {
		if ( strpos( $error_str, $s ) === 0 ) {
			$error_str = $replace[ $k ];
			break;
		}
	}
	$error_str = preg_replace( $preg_search, $preg_replace, $error_str );


	$message = '<span class="' . $class . '">' . $type . '</span>: ' . $error_str;

	if ( isset( $GLOBALS['encountered_errors'] ) ) {
		// Ignore strict warnings (can't avoid having them if I want to keep this sheet working with PHP4).
		if ( $error_no !== E_STRICT ) {
			$key = get_error_key( $message );

			if ( $class === 'notice' || $class === 'warning' ) {
				$GLOBALS['has_error'][]['msg'] = ' (&nbsp;<span class="' . $class . '"><a href="#' . $GLOBALS['test'] . '-errors">#' . ( $key + 1 ) . '</a></span>&nbsp;)';
				return;
			}
			else if ( $class === 'error' ) {
				$GLOBALS['has_error'][]['msg'] = ' <span class="error">' . $type . ' (&nbsp;<a href="#' . $GLOBALS['test'] . '-errors">#' . ( $key + 1 ) . '</a>&nbsp;)</span>';
				return;
			}
			else {
				echo $message, ' in ', $error_file, ' on line ', $error_line, "<br />\n";
			}
		}
		else {
			return;
		}
	}
	else {
		if ( $error_no !== E_STRICT ) {
			echo $message, ' in ', $error_file, ' on line ', $error_line, "<br />\n";
		}
		else {
			return;
		}
	}

	return false; // Make sure it plays nice with other error handlers (remove if no other error handlers are set).
}


/**
 * Get the index key for an error message and add the error message to the global array if it doesn't exist yet.
 *
 * @param string $message
 *
 * @return int
 */
function get_error_key( $message ) {
	$key = array_search( $message, $GLOBALS['encountered_errors'], true );
	if ( $key === false ) {
		$GLOBALS['encountered_errors'][] = $message;
		$key                             = array_search( $message, $GLOBALS['encountered_errors'], true );
	}
	return $key;
}


/**
 * Determine the base url to use.
 *
 * @return string
 */
function determine_base_uri() {
	$valid_hosts = array(
		'phpcheatsheets.com',
		'phpcheatsheet.com',
		'phpcheatsheets.localdev',
		'localhost',
	);

	$base_uri = 'https://phpcheatsheets.com/';

	if ( isset( $_SERVER['HTTP_HOST'] ) && in_array( $_SERVER['HTTP_HOST'], $valid_hosts, true ) ) {
		$base_uri = 'https://' . $_SERVER['HTTP_HOST'] . determine_script_path();
	}
	else if ( isset( $_SERVER['SERVER_NAME'] ) && in_array( $_SERVER['SERVER_NAME'], $valid_hosts, true ) ) {
		$base_uri = 'https://' . $_SERVER['SERVER_NAME'] . determine_script_path();
	}

	return $base_uri;
}


/**
 * Determine the script path part of the base url.
 *
 * @return string
 */
function determine_script_path() {
	if ( ! empty( $_SERVER['SCRIPT_NAME'] ) && stripos( $_SERVER['SCRIPT_NAME'], 'index.php' ) !== false ) {
		return substr( $_SERVER['SCRIPT_NAME'], 0, stripos( $_SERVER['SCRIPT_NAME'], 'index.php' ) );
	}
	else if ( ! empty( $_SERVER['REQUEST_URI'] ) && stripos( $_SERVER['REQUEST_URI'], 'index.php' ) !== false ) {
		return substr( $_SERVER['REQUEST_URI'], 0, stripos( $_SERVER['REQUEST_URI'], 'index.php' ) );
	}
	else {
		return '/';
	}
}


/**
 * PHP4 compat.
 */
if ( ! function_exists( 'stripos' ) ) {
	/**
	 * Make an equivalent to the PHP5 stripos() function available in PHP4.
	 *
	 * @param string $haystack
	 * @param string $needle
	 *
	 * @return int|false
	 */
	function stripos( $haystack, $needle ) {
		$haystack = strtolower( $haystack );
		$needle   = strtolower( $needle );
		return strpos( $haystack, $needle );
	}
}


/**
 * Generate dropdown list of available static versions.
 *
 * @return string
 */
function generate_version_dropdown() {

	$available = glob( APP_DIR . '/static_results/' . $GLOBALS['type'] . '/php*.html' );
	usort( $available, 'version_compare' );
	$available = array_reverse( $available );

	$optgroup = 100;
	$options  = array();

	$options_html          = '';
	$optgroup_html_pattern = '
					<optgroup label="PHP %1$s">%2$s' . "\n\t\t\t\t\t</optgroup>";

	$regex = sprintf( '`^%1$s/static_results/%2$s/php(([457]\.[0-9]+)\.[0-9-]+(?:(?:alpha|beta|RC)(?:[0-9])?)?)\.html$`',
		preg_quote( APP_DIR, '`' ),
		preg_quote( $GLOBALS['type'], '`' )
	);

	foreach ( $available as $file ) {
		if ( preg_match( $regex, $file, $match ) ) {
			if ( $options !== array() && ( version_compare( $optgroup, $match[2], '>' ) && $optgroup !== 100 ) ) {
				$options_html .= sprintf( $optgroup_html_pattern, $optgroup, implode( "\n", $options ) );
				$options       = array();
			}
			$optgroup = $match[2];


			$selected = '';
			if ( ( isset( $GLOBALS['autogen'] ) && $GLOBALS['autogen'] === true ) && $match[1] === PHP_VERSION ) {
				$selected = ' selected="selected"';
			}
			$options[] = sprintf( '
						<option value="php%1$s"%2$s>PHP %1$s</option>',
				htmlspecialchars( $match[1], ENT_QUOTES, 'UTF-8' ),
				$selected
			);
		}
	}
	// Add last group.
	if ( $options !== array() ) {
		$options_html .= sprintf( $optgroup_html_pattern, $optgroup, implode( "\n", $options ) );
	}

	$dropdown = sprintf( '
			<form action="%6$sindex.php" method="get" id="choose-version">
				<input type="hidden" name="page" value="%1$s" />
				<input type="hidden" id="phpv-tab" name="tab" value="%2$s" />
				<select id="phpversion-dropdown" name="phpversion">
					<optgroup label="Live">
						<option value="live" %3$s >PHP %4$s</option>
					</optgroup>
					%5$s
				</select>
			</form>',
		htmlspecialchars( $GLOBALS['type'], ENT_QUOTES, 'UTF-8' ),
		htmlspecialchars( $GLOBALS['tab'], ENT_QUOTES, 'UTF-8' ),
		( ( ! isset( $GLOBALS['autogen'] ) || $GLOBALS['autogen'] !== true ) ? ' selected="selected"' : '' ),
		htmlspecialchars( PHP_VERSION, ENT_QUOTES, 'UTF-8' ),
		$options_html,
		htmlspecialchars( BASE_URI, ENT_QUOTES, 'UTF-8' )
	);

	return $dropdown;
}
