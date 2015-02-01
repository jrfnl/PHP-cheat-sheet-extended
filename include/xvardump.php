<?php
/**
 * File: xvardump.php
 * @package xvardump
 */


/**
 * Group of functions for variable visualisation purposes
 *
 * The main function pr_var() can be used as a color-coded alternative for var_dump().
 *
 * A couple of 'shortcut' functions are provided for known variable types
 * Only use those if you know what you are receiving and don't need variable typing info
 *
 * @package xvardump
 * @author	Juliette Reinders Folmer, {@link http://www.adviesenzo.nl/ Advies en zo} -
 *  <xvardump@adviesenzo.nl>
 *
 * @version	1.7
 * @since	2009-09-30 // Last changed: by Juliette Reinders Folmer
 * @copyright	Advies en zo, Meedenken en -doen �2005-2009
 * @license http://www.opensource.org/licenses/lgpl-license.php GNU Lesser General Public License
 * @license	http://opensource.org/licenses/academic Academic Free License Version 1.2
 * @example	example/example.php
 *
 */

// Prevent direct calls to this file
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


define( 'XVARDUMP_SPACE_LONG',     '&nbsp;&nbsp;&nbsp;&nbsp;' );
define( 'XVARDUMP_SPACE_SHORT',    '&nbsp;&nbsp;' );

define( 'XVARDUMP_CLASS_STRING',   'vt-string' );
define( 'XVARDUMP_CLASS_INT',      'vt-int' );
define( 'XVARDUMP_CLASS_INT_0',    'vt-int-0' );
define( 'XVARDUMP_CLASS_FLOAT',    'vt-float' );
define( 'XVARDUMP_CLASS_BOOL',     'vt-bool' );
define( 'XVARDUMP_CLASS_B_TRUE',   'vt-b-true' );
define( 'XVARDUMP_CLASS_B_FALSE',  'vt-b-false' );
define( 'XVARDUMP_CLASS_RESOURCE', 'vt-resource' );
define( 'XVARDUMP_CLASS_NULL',     'vt-null' );


/**
 * Retrieve the debug info and value of a variable into a string
 *
 * @param mixed  $var
 * @param string $title
 * @param bool   $escape
 * @param bool   $short
 * @param string $space
 *
 * @uses pr_var()
 * @see pr_var()
 *
 * @return string  debug info on the variable $var
 */
function get_var( $var, $title = '', $escape = true, $short = false, $space = '' ) {
	ob_start();
	pr_var( $var, $title, $escape, $short, $space );
	$debug_info = ob_get_clean();
	return $debug_info;
}


/**
 * Prints color-coded debug info and value of a variable to the screen
 *
 * If you like, you can customize the color-coding used by changing the
 * values of the associated CONSTANTS at the top of this file
 *
 * @param mixed  $var      The variable to print the debug info for
 * @param string $title	   (optional) If set, prefaces the debug info with
 *                         a header containing this title
 *                         Useful if you want to print several states of the
 *                         same variable and you want to keep track of which state
 *                         you are at
 * @param bool   $escape   (optional) Whether or not to escape html entities in
 *                         the $var
 *                         Useful if the $var contains html and you want to see
 *                         the source value
 *                         Defaults to true
 * @param bool   $short	   (optional) Whether to limit the debug info to color coding
 *                         Defaults to false
 * @param string $space	   (optional) Internal variable needed to create the proper
 *                         spacing for display of arrays and objects
 * @param bool   $in_array (optional) Internal pointer for whether or not to use
 *                         breaks when using short annotation which would give issues
 *                         when displaying arrays
 *
 * @uses object_info()
 */
function pr_var( $var, $title = '', $escape = true, $short = false, $space = '', $in_array = false ) {

	if ( is_string( $title ) && $title !== '' ) {
		echo '<h4 style="clear: both;">', ( ( $escape === true ) ? htmlentities( $title, ENT_QUOTES ) : $title ), "</h4>\n";
	}

	if ( is_array( $var ) ) {
		if ( $var !== array() ) {
			echo 'Array: ', $space, "(<br />\n";
			$spacing = ( ( $short !== true ) ? $space . XVARDUMP_SPACE_LONG : $space . XVARDUMP_SPACE_SHORT );
			//$spacing = $space . XVARDUMP_SPACE_SHORT;
			foreach ( $var as $key => $value ) {
				echo $spacing, '[', ( ( $escape === true ) ? htmlentities( $key, ENT_QUOTES ) : $key );
				if ( $short !== true ) {
					echo ' ';
					switch ( true ) {
						case ( is_string( $key ) ):
							echo '<b class="', XVARDUMP_CLASS_STRING, '"><i>(string)</i></b>';
							break;

						case ( is_int( $key ) ):
							echo '<b class="', XVARDUMP_CLASS_INT, '"><i>(int)</i></b>';
							break;

						case ( is_float( $key ) ):
							echo '<b class="', XVARDUMP_CLASS_FLOAT, '"><i>(float)</i></b>';
							break;

						default:
							echo '(unknown)';
							break;
					}
				}
				echo '] => ';
				pr_var( $value, '', $escape, $short, $spacing, true );
			}
			echo $space, ")<br />\n\n";
		}
		else {
			echo 'array()<br />';
		}
	}
	else if ( is_string( $var ) ) {
		echo '<span class="', XVARDUMP_CLASS_STRING, '">';
		if ( $short !== true ) {
			echo '<b><i>string[', strlen( $var ), ']</i></b> : ';
		}
		echo '&lsquo;',
			( ( $escape === true ) ? str_replace( '  ', ' &nbsp;', htmlentities( $var, ENT_QUOTES, 'UTF-8' ) ) : str_replace( '  ', ' &nbsp;', $var ) ),
			"&rsquo;</span><br />\n";
	}
	else if ( is_bool( $var ) ) {
		if ( $short !== true ) {
			echo '<span class="', XVARDUMP_CLASS_BOOL, '"><b><i>bool</i></b> : ', $var, ' ( = ';
		}
		else {
			echo '<b class="', XVARDUMP_CLASS_BOOL, '"><i>b</i></b> ';
		}
		if ( $var === false ) {
			echo '<i class="', XVARDUMP_CLASS_B_FALSE, '">false</i>';
		}
		else if ( $var === true ) {
			echo '<i class="', XVARDUMP_CLASS_B_TRUE, '">true</i>';
		}
		else {
			echo '<i>undetermined</i>';
		}
		echo ( ( $short !== true ) ? ' )</span>' : '' );
		echo "<br />\n";
	}
	else if ( is_int( $var ) ) {
		echo '<span class="', XVARDUMP_CLASS_INT, '">';
		if ( $short !== true ) {
			echo '<b><i>int</i></b> : ';
		}
		if ( $var === 0 ) {
			echo '<span class="', XVARDUMP_CLASS_INT_0, '">', $var, '</span>';
		}
		else {
			echo $var;
		}
		echo "</span><br />\n";
	}
	else if ( is_float( $var ) ) {
		echo '<span class="', XVARDUMP_CLASS_FLOAT, '">';
		if ( $short !== true ) {
			echo '<b><i>float</i></b> : ';
		}
		echo $var, "</span><br />\n";
	}
	else if ( is_null( $var ) ) {
		echo '<span class="', XVARDUMP_CLASS_NULL, '">';
		if ( $short !== true ) {
			echo '<b><i>';
		}
		echo 'null';
		if ( $short !== true ) {
			echo '</i></b> : ', $var, ' ( = <i>NULL</i> )', "</span><br />\n";
		}
		else if ( $in_array === true ) {
			echo "</span><br />\n";
		}
		else {
			echo "</span>\n";
		}
	}
	else if ( is_resource( $var ) ) {
		echo '<span class="', XVARDUMP_CLASS_RESOURCE, '">';
		if ( $short !== true ) {
			echo '<b><i>resource</i></b> : ';
		}
		echo $var;
		if ( $short !== true ) {
			echo ' ( = <i>RESOURCE</i> )';
		}
		echo "</span><br />\n";
	}
	else if ( is_object( $var ) ) {
		echo "Object: \n", $space, "(<br />\n";
		$spacing = ( ( $short !== true ) ? $space . XVARDUMP_SPACE_LONG : $space . XVARDUMP_SPACE_SHORT );
		object_info( $var, $escape, $short, $spacing );
		echo $space, ")<br />\n\n";
	}
	else {
		echo 'I haven&#39;t got a clue what this is: ', gettype( $var ), "<br />\n";
	}
}


/**
 * Internal function to print debug info on an object
 *
 * @param object $obj    Object to print debug info on
 * @param bool   $escape @see pr_var()
 * @param bool   $short  @see pr_var()
 * @param string $space  @see pr_var()
 *
 * @internal
 * @uses pr_var()
 */
function object_info( $obj, $escape, $short, $space ) {
	echo $space, '<b><i>Class</i></b>: ', get_class( $obj ), " (<br />\n";
	$spacing    = ( ( $short !== true ) ? $space . XVARDUMP_SPACE_LONG : $space . XVARDUMP_SPACE_SHORT );
	$properties = get_object_vars( $obj );
	if ( is_array( $properties ) && $properties !== array() ) {
		foreach ( $properties as $var => $val ) {
			if ( is_array( $val ) ) {
				echo $spacing, '<b><i>property</i></b>: ', $var, "<b><i> (array)</i></b>\n";
				pr_var( $val, '', $escape, $short, $spacing );
			}
			else {
				echo $spacing, '<b><i>property</i></b>: ', $var, ' = ';
				pr_var( $val, '', $escape, $short, $spacing );
			}
		}
	}
	unset( $properties, $var, $val );

	$methods = get_class_methods( $obj );
	if ( is_array( $methods ) && $methods !== array() ) {
		foreach ( $methods as $method ) {
			echo $spacing, '<b><i>method</i></b>: ', $method, "<br />\n";
		}
	}
	unset( $methods, $method );
	echo $space, ")<br />\n\n";
}


/**
 * Function to dump all defined variables
 *
 * @uses	pr_var()
 */
function dump_all() {
	$var = get_defined_vars();
	pr_var( $var, 'Dump of all defined variables' );
}


/**
 * Alias for pr_str()
 *
 * @param string $var
 */
function pr_string( $var ) {
	pr_str( $var );
}


/**
 * Alias for pr_bool()
 *
 * @param bool $var
 */
function pr_boolean( $var ) {
	pr_bool( $var );
}


/**
 * Alias for pr_int()
 *
 * @param int $var
 */
function pr_integer( $var ) {
	pr_int( $var );
}


/**
 * Alias for pr_flt()
 *
 * @param float $var
 */
function pr_float( $var ) {
	pr_flt( $var );
}


/**
 * Shortcut function to print a string variable
 *
 * @param string $var
 */
function pr_str( $var ) {
	if ( is_string( $var ) ) {
		echo '<span class="', XVARDUMP_CLASS_STRING, '">&lsquo;', str_replace( '  ', ' &nbsp;', $var ), "&rsquo;</span>\n";
	}
	else {
		echo 'E: not a string';
	}
}


/**
 * Shortcut function to print a boolean variable
 *
 * @param bool $var
 */
function pr_bool( $var ) {
	if ( is_bool( $var ) ) {
		if ( $var === false ) {
			echo '<span class="', XVARDUMP_CLASS_B_FALSE, '">false', "</span>\n";
		}
		else if ( $var === true ) {
			echo '<span class="', XVARDUMP_CLASS_B_TRUE, '">true', "</span>\n";
		}
		else {
			echo 'E: boolean value undetermined';
		}
	}
	else {
		echo 'E: not boolean';
	}
}


/**
 * Shortcut function to print an integer variable
 *
 * Will print 0 value in red, other values in green
 *
 * @param int $var
 */
function pr_int( $var ) {
	if ( is_int( $var ) ) {
		if ( $var === 0 ) {
			echo '<span class="', XVARDUMP_CLASS_INT_0, '">', $var, "</span>\n";
		}
		else {
			echo '<span class="', XVARDUMP_CLASS_INT, '">', $var, "</span>\n";
		}
	}
	else {
		echo 'E: not an integer';
	}
}


/**
 * Shortcut function to print a float variable
 *
 * @param float $var
 */
function pr_flt( $var ) {
	if ( is_float( $var ) ) {
		echo '<span class="', XVARDUMP_CLASS_FLOAT, '">', $var, "</span>\n";
	}
	else {
		echo 'E: not a float';
	}
}

