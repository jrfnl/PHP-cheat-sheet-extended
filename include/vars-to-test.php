<?php
// Prevent direct calls to this file
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


$test_array = array(
	//'unset'  => 'this variable will be unset',
	'n'   => null,

	'b1'  => false,
	'b2'  => true,

	'i1'  => 1,
	'i2'  => 0,
	'i3'  => -1,
	'i5'  => 42, // char *
	'i8'  => 0xCC00F9, // hexadecimal integer
	'i9'  => 052, // octal integer = 42 = char *

	'f1'  => 1.3,
	'f2'  => 0.005,
	'f3'  => 0.0,
	'f4'  => -1.3,
	'f5'  => acos(8), // is_nan
	'f6'  => NAN, // is_nan
	'f7'  => log( 0 ), // is_infinite
	'f8'  => INF, // is_infinite
	'f9'  => 1.2345E8, // exponent notation float

	'se'  => '',

	's1'  => ' ',
	's2'  => ' 1',
	's3'  => ' 3 ',
	's4'  => '1',
	's5'  => '0',
	's6'  => '-1',
	's7'  => '42',
	's8'  => '1.3',
	's9'  => '0.0',
	'sa'  => '-1.305',
	'sb'  => 'true',
	'sc'  => 'false',
	'sd'  => 'null',
	'sf'  => '123str',
	'sg'  => 'str123',
	'sh'  => '123, "str"',

	'su'  => '0xCC00F9', // is_numeric, filter_var integer allow hex
	'sv'  => '0123', // is_numeric, filter_var integer allow octal, integers


	'ae'  => array(),
	//'a0'  => array( null ),
	//'a1'  => array( 1 ),
	//'a2'  => array( false ),
	'a3'  => array( 1 => 'string' ), // with different key -> array + array
	'a4'  => array( false, 1, 1.3, '123str', 'str123', null ),
	//'a5'  => array( 'a' => 'test1', 'b' => 'test2', 'numerical key', 'null' => null ),


	'oe'  => new stdClass(),
	'o2'  => new TestObjectToString(),

	'r1'  => fopen( APP_DIR . '/include/resource.txt', 'r' ),

);

/**
 * Variable legend
 */
$legend_array = array(
	'i8'  => '$x = 0xCC00F9; // hexadecimal integer',
	'i9'  => '$x = 052; // octal integer',
	'ia'  => '$x = 0b0111001; // binary integer (PHP5.4+)',
	'f5'  => '$x = acos(8); // = NAN',
	'f6'  => '$x = NAN; // = not a number',
	'f7'  => '$x = log(0); // = infinite',
	'f8'  => '$x = INF; // = infinite',
	'f9'  => '$x = 1.2345E8; // exponent notation float',
	'sk'  => '$x = "123, \"str\"\r\n";',
	'sn'  => '$x = "\f\t\r\n";',
	'sp'  => '$x = "\x7f\t\r\n"',
);


if ( PHP_VERSION_ID >= 50400 ) {
	include APP_DIR . '/include/vars-to-test-php54.php';
}


if ( extension_loaded( 'SPL_Types' ) ) {
	if ( class_exists( 'SplBool' ) ) {
		$test_array['p1'] = new SplBool( false, true );
		$test_array['p2'] = new SplBool( true, true );
	}
	if ( class_exists( 'SplInt' ) ) {
		$test_array['p5'] = new SplInt( 94 );
	}
	if ( class_exists( 'SplFloat' ) ) {
		$test_array['p6'] = new SplFloat( 3.154 );
	}
	if ( class_exists( 'SplString' ) ) {
		$test_array['p7'] = new SplString( 'SPLstring' );
	}
}

/**
 * Test group specific extra variables
 */
$extra_variables = array();

$extra_variables['type_testing'] = array(
	'si'  => 'is_array', // is_callable
);


$extra_variables['boolean_tests'] = $extra_variables['filter_extension_bool_int_float'] = array(
	'sq'  => 'on', // filter_var boolean
	'sr'  => 'off', // filter_var boolean
	'ss'  => 'yes', // filter_var boolean
	'st'  => 'no', // filter_var boolean
);

$extra_variables['filter_extension_bool_int_float']['sl'] = 'AF036C';

$extra_variables['string_tests'] = array(
	'sz'  => 'Iñtërnâtiônàlizætiøn', // utf-8 / binary string
);

$extra_variables['object_tests'] = $extra_variables['array_tests'] = array(
	'o1'  => new TestObject(),
);

$extra_variables['object_tests']['a6'] = array(
	's'  => 'simple',
	'm'  => array(
		'test1',
		'test2',
	)
);


if ( extension_loaded( 'gd' ) ) {
	$extra_variables['resource_tests'] = array(
		'r2'  => imagecreatetruecolor( 10, 10 ),
	);
}

$extra_variables['ctype_extension'] = array(
	'i4'  => 10, // char line feed
	'i6'  => 111, // char o
	'i7'  => 12345,

	'sj'  => '123,"str"', // ctype_print, ctype_graph
	'sk'  => "123, \"str\"\r\n", // ctype_print (not in php5.4 ?)
	'sl'  => 'AF036C', // ctype_xdigit
	'sm'  => 'FOO', // ctype_upper
	'sn'  => "\f\t\r\n", //ctype_space
	'so'  => '*&$()', //ctype_punct
	'sp'  => "\x7f\t\r\n", //ctype_ctrl

	'sz'  => 'Iñtërnâtiônàlizætiøn', // utf-8 / binary string
);
