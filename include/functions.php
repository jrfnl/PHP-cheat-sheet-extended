<?php

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

class TestObjectToString extends TestObject {

	var $test3 = 'some string';


	/**
	 * @return string
	 */
	function __toString() {
		return $this->test3;
	}
}



function median() {
	$args = func_get_args();

	switch ( func_num_args() ) {
		case 0:
			trigger_error( 'median() requires at least one parameter', E_USER_WARNING );
			return false;
			break;

		case 1:
			$args = array_pop( $args );
			// fall through

		default:
			if ( is_array( $args ) === false ) {
				trigger_error( 'median() requires a list of numbers to operate on or an array of numbers', E_USER_NOTICE );
				return false;
			}

			sort( $args );

			$n = count( $args );
			$h = intval( $n / 2 );

			if ( $n % 2 == 0 ) {
				$median = ( $args[$h] + $args[$h - 1] ) / 2;
			}
			else {
				$median = $args[$h];
			}
			break;
	}
	return $median;
}



/**
 * Catch errors to display in table appendix
 */

function do_handle_errors( $errno, $errstr, $errfile, $errline ) {
	if ( !( error_reporting() & $errno ) )
		return;

	if ( !defined( 'E_STRICT' ) )			define( 'E_STRICT', 2048 );
	if ( !defined( 'E_RECOVERABLE_ERROR' ) ) define( 'E_RECOVERABLE_ERROR', 4096 );
	if ( !defined( 'E_DEPRECATED' ) )		define( 'E_DEPRECATED', 8192 );
	if ( !defined( 'E_USER_DEPRECATED' ) )	define( 'E_USER_DEPRECATED', 16384 );

	switch ( $errno ){
		case E_ERROR: // 1 //
		case E_CORE_ERROR: // 16 //
		case E_COMPILE_ERROR: // 64 //
			$type  = 'Fatal error';
			$class = 'error';
			$show  = false;
			break;
		case E_USER_ERROR: // 256 //
			$type  = 'Fatal error';
			$class = 'error';
			$show  = true;
			break;
		case E_WARNING: // 2 //
		case E_CORE_WARNING: // 32 //
		case E_COMPILE_WARNING: // 128 //
			$type  = 'Warning';
			$class = 'warning';
			$show  = false;
			break;
		case E_USER_WARNING: // 512 //
			$type  = 'Warning';
			$class = 'warning';
			$show  = true;
			break;
		case E_PARSE: // 4 //
			$type  = 'Parse error';
			$class = 'error';
			$show  = false;
			break;
		case E_NOTICE: // 8 //
		case E_USER_NOTICE: // 1024 //
			$type  = 'Notice';
			$class = 'notice';
			$show  = true;
			break;
		case E_STRICT: // 2048 //
			$type  = 'Strict warning';
			$class = 'warning';
			$show  = true;
			break;
		case E_RECOVERABLE_ERROR: // 4096 //
			$type  = '(Catchable) Fatal error';
			$class = 'error';
			$show  = true;
			break;
		case E_DEPRECATED: // 8192 //
		case E_USER_DEPRECATED: // 16384 //
			$type  = 'Deprecated';
			$class = 'notice';
			$show  = true;
			break;
		default:
			$type  = 'Unknown error ($errno)';
			$class = 'error';
			$show  = true;
			break;
	}
	

	$message = '<span class="' . $class . '">' . $type . '</span>: ' . $errstr;

	if ( isset( $GLOBALS['encountered_errors'] ) ) {
		$key = array_search( $message, $GLOBALS['encountered_errors'] );
		if ( $key === false ) {
			$GLOBALS['encountered_errors'][] = $message;
			$key = array_search( $message, $GLOBALS['encountered_errors'] );
		}
		
/*		try {
		    if( $type === '(Catchable) Fatal error' ) {
		        throw new Exception('<span class="error">(Catchable) Fatal error <a href="#' . $GLOBALS['test']. '-errors">#' . ( $key + 1 ) . '</a></span>');
			}
		}
		catch( Exception $e ) {
			print $e->getMessage();
		}
		unset( $e );
*/
//		if ( $show === true ) {
/*			$GLOBALS['has_error'] = array(
				'type' => $class,
			);
*/
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
/*		}
//		else if( $type !== '(Catchable) Fatal error' ) {
*/		else {
			print $message . ' in ' . $errfile . ' on line ' . $errline . "<br />\n";
		}
	}
	else {
		print $message . ' in ' . $errfile . ' on line ' . $errline . "<br />\n";
	}


/*
	switch($errno) {
		case E_WARNING		:
		case E_USER_WARNING :
		case E_STRICT		:
		case E_NOTICE		:
		case ( defined( 'E_DEPRECATED' ) ? E_DEPRECATED : 8192 )   :
		case E_USER_NOTICE	:
			$type = 'warning';
			$fatal = false;
			break;
		default			 :
			$type = 'fatal error';
			$fatal = true;
			break;
	}
	$trace = debug_backtrace();
	array_shift($trace);
	if (php_sapi_name() == 'cli' && ini_get('display_errors') ) {
		echo 'Backtrace from ' . $type . ' \'' . $errstr . '\' at ' . $errfile . ' ' . $errline . ':' . "\n";
		foreach($trace as $item)
			echo '	' . (isset($item['file']) ? $item['file'] : '<unknown file>') . ' ' . (isset($item['line']) ? $item['line'] : '<unknown line>') . ' calling ' . $item['function'] . '()' . "\n";
	} else if( ini_get('display_errors') ) {
		echo '<p class="error_backtrace">' . "\n";
		echo '	Backtrace from ' . $type . ' \'' . $errstr . '\' at ' . $errfile . ' ' . $errline . ':' . "\n";
		echo '	<ol>' . "\n";
		foreach($trace as $item)
			echo '	<li>' . (isset($item['file']) ? $item['file'] : '<unknown file>') . ' ' . (isset($item['line']) ? $item['line'] : '<unknown line>') . ' calling ' . $item['function'] . '()</li>' . "\n";
		echo '	</ol>' . "\n";
		echo '</p>' . "\n";
	}
	if (ini_get('log_errors')) {
		$items = array();
		foreach($trace as $item)
			$items[] = (isset($item['file']) ? $item['file'] : '<unknown file>') . ' ' . (isset($item['line']) ? $item['line'] : '<unknown line>') . ' calling ' . $item['function'] . '()';
		$message = 'Backtrace from ' . $type . ' \'' . $errstr . '\' at ' . $errfile . ' ' . $errline . ': ' . join(' | ', $items);
		error_log($message);
	}

	flush();
//		return $errstr;

	if ($fatal)
		exit(1);
*/
	return false; // Make sure it plays nice with other error handlers (remove if no other error handlers are set)
}



?>