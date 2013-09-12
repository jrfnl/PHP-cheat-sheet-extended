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
 * @version	1.6
 * @since	2009-09-30 // Last changed: by Juliette Reinders Folmer
 * @copyright	Advies en zo, Meedenken en -doen �2005-2009
 * @license http://www.opensource.org/licenses/lgpl-license.php GNU Lesser General Public License
 * @license	http://opensource.org/licenses/academic Academic Free License Version 1.2
 * @example	example/example.php
 *
 */


define( 'XVARDUMP_SPACE_LONG',		'&nbsp;&nbsp;&nbsp;&nbsp;' );
define( 'XVARDUMP_SPACE_SHORT',		'&nbsp;&nbsp;' );
//define( 'XVARDUMP_COLOR_BCKGR',		'transparent' );
define( 'XVARDUMP_COLOR_STRING',	'#336600' );
//define( 'XVARDUMP_COLOR_INT',		'#FF0000' );
define( 'XVARDUMP_COLOR_INT',		'#0066FF' );
define( 'XVARDUMP_COLOR_INT_0',		'#FF0000' );
define( 'XVARDUMP_COLOR_FLOAT',		'#990033' );
define( 'XVARDUMP_COLOR_BOOL',		'#000099' );
define( 'XVARDUMP_COLOR_B_TRUE',	'#336600' );
define( 'XVARDUMP_COLOR_B_FALSE',	'#FF0000' );
define( 'XVARDUMP_COLOR_RESOURCE',	'#666666' );
define( 'XVARDUMP_COLOR_NULL',		'#666666' );


/**
 * Function to log the debug info and value of a variable to the error log
 * without displaying it to the screen.
 *
 * This function will temporarily overwrite the 'display_errors' ini value.
 *
 * @uses	get_var()
 * @see		pr_var()
 */
function log_var_to_errorlog( $var, $title = '', $escape = true, $short = false, $space = '' ) {
	$display_value = ini_get( 'display_errors' );
	ini_set( 'display_errors', 0 );

	$debug_info = get_var( $var, $title, $escape, $short, $space );
	trigger_error( $debug_info, E_USER_NOTICE );

	ini_set( 'display_errors', $display_value );
}


/**
 * Retrieve the debug info and value of a variable into a string
 *
 * @uses    pr_var()
 * @see     pr_var()
 *
 * @param   mixed   $var
 * @param   string  $title
 * @param   bool    $escape
 * @param   bool    $short
 * @param   string  $space
 *
 * @return  string  debug info on the variable $var
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
 * @uses 	object_info()
 *
 * @param	mixed	$var	the variable to print the debug info for
 * @param	string	$title	(optional) If set, prefaces the debug info with
 * 							a header containing this title
 * 							Useful if you want to print several states of the
 * 							same variable and you want to keep track of which state
 * 							you are at
 * @param	bool	$escape	(optional) whether or not to escape html entities in
 * 							the $var
 * 							Useful if the $var contains html and you want to see
 * 							the source value
 * 							Defaults to true
 * @param	bool	$short	(optional) whether to limit the debug info to color coding
 * 							Defaults to false
 * @param	string	$space	(optional) Internal variable needed to create the proper
 * 							spacing for display of arrays and objects
 * @param   bool    $in_array   (optional) Internal pointer for whether or not to use
 *                          breaks when using short annotation which would give issues
 *                          when displaying arrays
 */
function pr_var( $var, $title = '', $escape = true, $short = false, $space = '', $in_array = false ) {

	if ( is_string( $title ) && $title !== '' ) {
		print '<h4 style="clear: both;">' . ( $escape === true ? htmlentities( $title, ENT_QUOTES ) : $title ) . "</h4>\n";
	}

	if ( is_array( $var ) ) {
		print 'Array: ' . $space . "(<br />\n";
		$spacing = ( ( $short !== true ) ? $space . XVARDUMP_SPACE_LONG : $space . XVARDUMP_SPACE_SHORT );
//		$spacing = $space . XVARDUMP_SPACE_SHORT;
		foreach ( $var as $key => $value ) {
			print $spacing . '[' . ( $escape === true ? htmlentities( $key, ENT_QUOTES ): $key );
			if ( $short !== true ) {
				print  ' ';
				switch ( true ) {
					case ( is_string( $key ) ) :
						print '<span style="color: ' . XVARDUMP_COLOR_STRING . ';"><b><i>(string)</i></b></span>';
						break;
					case ( is_int( $key ) ) :
						print '<span style="color: ' . XVARDUMP_COLOR_INT . ';"><b><i>(int)</i></b></span>';
						break;
					case ( is_float( $key ) ) :
						print '<span style="color: ' . XVARDUMP_COLOR_FLOAT . ';"><b><i>(float)</i></b></span>';
						break;
					default:
						print '(unknown)';
						break;
				}
			}
			print '] => ';
			pr_var( $value, '', $escape, $short, $spacing, true );
		}
		print $space . ")<br />\n\n";
	}
	else if ( is_string( $var ) ) {
		print '<span style="color: ' . XVARDUMP_COLOR_STRING . ';">';
		if ( $short !== true ) {
			print '<b><i>string[' . strlen( $var ) . ']</i></b> : ';
		}
		print '&lsquo;'
			. ( ( $escape === true ) ? str_replace( '  ', ' &nbsp;', htmlentities( $var, ENT_QUOTES, 'UTF-8' ) ) : str_replace( '  ', ' &nbsp;', $var ) )
			. "&rsquo;</span><br />\n";
	}
	else if ( is_bool( $var ) ) {
		print '<span style="color: ' . XVARDUMP_COLOR_BOOL . ';">';
		print ( ( $short !== true ) ? '<b><i>bool</i></b> : ' . $var . ' ( = ' : '<b><i>b</i></b> ');
		print '<i>'
			. ( ( $var === false ) ? '<span style="color: ' . XVARDUMP_COLOR_B_FALSE . ';">false</span>' : ( ( $var === true ) ? '<span style="color: ' . XVARDUMP_COLOR_B_TRUE . ';">true</span>' : 'undetermined' ) );
		print '</i>' . ( ( $short !== true ) ? ' )' : '' );
		print "</span><br />\n";
	}
	else if ( is_int( $var ) ) {
		print '<span style="color: ' . XVARDUMP_COLOR_INT . ';">';
		if ( $short !== true ) {
			print '<b><i>int</i></b> : ';
		}
		print ( ( $var === 0 ) ? '<b style="color: ' . XVARDUMP_COLOR_INT_0 . ';">' . $var . '</b>' : $var ) . "</span><br />\n";
	}
	else if ( is_float( $var ) ) {
		print '<span style="color: ' . XVARDUMP_COLOR_FLOAT . ';">';
		if ( $short !== true ) {
			print '<b><i>float</i></b> : ';
		}
		print $var . "</span><br />\n";
	}
	else if ( is_null( $var ) ) {
		print '<span style="color: ' . XVARDUMP_COLOR_NULL . ';">';
		if ( $short !== true ) {
			print '<b><i>';
		}
		print 'null';
		if ( $short !== true ) {
			print '</i></b> : ' . $var . ' ( = <i>NULL</i> )';
			print "</span><br />\n";
		}
		else if ( $in_array === true ) {
			print "</span><br />\n";
		}
		else {
			print "</span>\n";
		}
	}
	else if ( is_resource( $var ) ) {
		print '<span style="color: ' . XVARDUMP_COLOR_RESOURCE . ';">';
		if ( $short !== true ) {
			print '<b><i>resource</i></b> : ';
		}
		print $var;
		if ( $short !== true ) {
			print ' ( = <i>RESOURCE</i> )';
		}
		print "</span><br />\n";
	}
	else if ( is_object( $var ) ) {
		print "Object: \n" . $space . "(<br />\n";
		$spacing = ( ( $short !== true ) ? $space . XVARDUMP_SPACE_LONG : $space . XVARDUMP_SPACE_SHORT );
		object_info( $var, $escape, $short, $spacing );
		print $space . ")<br />\n\n";
	}
	else {
		print 'I haven&#39;t got a clue what this is: ' . gettype( $var ) . "<br />\n";
	}
}

/**
 * Internal function to print debug info on an object
 *
 * @todo get object properties to show the variable type on one line with the 'property'
 *
 * @internal
 * @uses	pr_var()
 *
 * @param 	object	$obj	object to print debug info on
 * @param 	bool	$short	@see pr_var()
 * @param	bool	$escape	@see pr_var()
 * @param	string	$space	@see pr_var()
 */
function object_info( $obj, $escape, $short, $space ) {
	print $space . '<b><i>Class</i></b>: ' . get_class( $obj ) . " (<br />\n";
	$spacing = ( ( $short !== true ) ? $space . XVARDUMP_SPACE_LONG : $space . XVARDUMP_SPACE_SHORT );
	$ov = get_object_vars( $obj );
	foreach ( $ov as $var => $val ) {
		if ( is_array( $val ) ) {
			print $spacing . '<b><i>property</i></b>: ' . $var . "<b><i> (array)</i></b>\n";
			pr_var( $val, '', $escape, $short, $spacing );
		}
		else {
			print $spacing . '<b><i>property</i></b>: ' . $var . ' = ';
			pr_var( $val, '', $escape, $short, $spacing );
		}
	}
	unset( $ov, $var, $val );

	$om = get_class_methods( $obj );
	foreach ( $om as $method ) {
		print $spacing . '<b><i>method</i></b>: ' . $method . "<br />\n";
	}
	unset( $om );
	print $space . ")<br />\n\n";
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
 * Catch long function names
 */
function pr_string( $var ) {
	pr_str( $var );
}
function pr_boolean( $var ) {
	pr_bool( $var );
}
function pr_integer( $var ) {
	pr_int( $var );
}
function pr_float( $var ) {
	pr_flt( $var );
}


/**
 * Shortcut function to print a string variable
 *
 * @param 	string	$var
 */
function pr_str( $var ) {
	if ( is_string( $var ) ) {
		print '<span style="color: ' . XVARDUMP_COLOR_STRING . ';">&lsquo;' . str_replace( '  ', ' &nbsp;', $var ) . "&rsquo;</span>\n";
	}
	else {
		print 'E: not a string';
	}
}

/**
 * Shortcut function to print a boolean variable
 *
 * @param	bool	$var
 */
function pr_bool( $var ) {
	if ( is_bool( $var ) ) {
		if ( $var === false ) {
			print '<span style="color: ' . XVARDUMP_COLOR_B_FALSE . ';">' . 'false' . "</span>\n";
		}
		else if ( $var === true ) {
			print '<span style="color: ' . XVARDUMP_COLOR_B_TRUE . ';">' . 'true' . "</span>\n";
		}
		else {
			print 'E: boolean value undetermined';
		}
	}
	else {
		print 'E: not boolean';
	}
}

/**
 * Shortcut function to print an integer variable
 * Will print 0 value in red, other values in green
 *
 * @param	int		$var
 */
function pr_int( $var ) {
	if ( is_int( $var ) ) {
		if ( $var === 0 ) {
			print '<span style="color: ' . XVARDUMP_COLOR_INT_0 . ';">' . $var . "</span>\n";
		}
		else {
			print '<span style="color: ' . XVARDUMP_COLOR_INT . ';">' . $var . "</span>\n";
		}
	}
	else {
		print 'E: not an integer';
	}
}


/**
 * Shortcut function to print a float variable
 *
 * @param	float	$var
 */
function pr_flt( $var ) {
	if ( is_float( $var ) ) {
		print '<span style="color: ' . XVARDUMP_COLOR_FLOAT . ';">' . $var . "</span>\n";
	}
	else {
		print 'E: not a float';
	}
}



/**
 * Extended string comparison for debugging purposes
 *
 * @uses pr_var()
 *
 * @param	string	$string1
 * @param 	string	$string2
 */
function extended_string_compare( $string1, $string2 ) {

	pr_var( $string1, 'string1', true, false );
	pr_var( $string2, 'string2', true, false );

	$compared = strcmp( $string1, $string2 );
	print '<h3>strcmp</h3>result from php strcmp is ' . $compared . '<br><br>';

	$count1 = count_chars( $string1, 1 );
	$count2 = count_chars( $string2, 1 );

	print '<h3>count_char compare based on string1</h3><table class="stringcmp">';
	print '<tr><th>key</th><th># in string1</th><th># in string2</th><th>char</th></tr>';
	foreach ( $count1 as $key => $value ) {
		if ( isset( $count2[$key] ) === true && $value != $count2[$key] ) {
			$char = chr( $key );
			print '<tr><td>' . $key . '</td><td>' . $value . '</td><td>' . $count2[$key] . '</td><td>' . $char . '</td></tr>';
		}
		else if ( isset( $count2[$key] ) === false ) {
			$char = chr( $key );
			print '<tr><td>' . $key . '</td><td>' . $value . '</td><td> - </td><td>' . $char . '</td></tr>';
		}
	}
	print '</table>';

	print '<h3>count_char compare based on string2</h3><table class="stringcmp">';
	print '<tr><th>key</th><th># in string1</th><th># in string2</th><th>char</th></tr>';
	foreach ( $count2 as $key => $value ) {
		if ( isset( $count1[$key] ) === true && $value != $count1[$key] ) {
			$char = chr( $key );
			print '<tr><td>' . $key . '</td><td>' . $count1[$key] . '</td><td>' . $value . '</td><td>' . $char . '</td></tr>';
		}
		else if ( isset( $count1[$key] ) === false ) {
			$char = chr( $key );
			print '<tr><td>' . $key . '</td><td> - </td><td>' . $value . '</td><td>' . $char . '</td></tr>';
		}
	}
	print '</table>';


	print '<h3>character for character compare</h3><table class="stringcmp">';
	print '<tr><th>i</th><th>char string1</th><th>ord string1</th><th>chr string1</th><th>char string2</th><th>ord string2</th><th>chr string2</th><th>same ?</th></tr>';
	$max = ( strlen( $string1 ) > strlen( $string2 ) ) ? strlen( $string1 ) : strlen( $string2 );
	for ( $i = 0; $i < $max; $i++ ) {
		$char1 = substr( $string1, $i , 1 );
		$char2 = substr( $string2, $i , 1 );
		$ord1  = ord( $char1 );
		$ord2  = ord( $char2 );
		$chr1  = chr( $ord1 );
		$chr2  = chr( $ord2 );
		$color = ( $ord1 === $ord2 && $chr1 === $chr2 ) ? '008000' : '00FFFF';
		print '<tr><td>' . $i . '</td><td>' . $char1 . '</td><td>' . $ord1 . '</td><td>' . $chr1 . '</td><td>' . $char2 . '</td><td>' . $ord2 . '</td><td>' . $chr2 . '</td><td style="color: #000000; background-color: #' . $color . ';">&nbsp;</td></tr>';
	}
	print '</table>';
}

/** EOF **/
?>