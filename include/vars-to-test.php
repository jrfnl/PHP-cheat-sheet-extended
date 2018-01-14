<?php
/**
 * Define test variables.
 *
 * @package PHPCheatsheets
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


$test_array = array(
	// 'unset'  => 'this variable will be unset',
	'n'   => null,

	'b1'  => false,
	'b2'  => true,

	'i1'  => 1,
	'i2'  => 0,
	'i3'  => -1,
	'i5'  => 42, // Testing char * .
	'i8'  => 0xCC00F9, // Testing hexadecimal integer.
	'i9'  => 052, // Testing octal integer = 42 = char * .

	'f1'  => 1.3,
	'f2'  => 0.005,
	'f3'  => 0.0,
	'f4'  => -1.3,
	'f5'  => acos( 8 ), // Testing is_nan().
	'f6'  => NAN, // Testing is_nan().
	'f7'  => log( 0 ), // Testing is_infinite().
	'f8'  => INF, // Testing is_infinite() => gets removed for 5.0 & 4.3 tests in `set_test_data()` as problematic.
	'f9'  => 1.2345E8, // Testing exponent notation float.

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

	'su'  => '0xCC00F9', // Testing is_numeric, filter_var integer allow hex.
	'sv'  => '0123', // Testing is_numeric, filter_var integer allow octal, integers.

	'ae'  => array(),
	'a3'  => array( // With different key -> array + array.
		1 => 'string',
	),
	'a4'  => array(
		false,
		1,
		1.3,
		'123str',
		'str123',
		null,
	),

	'oe'  => new stdClass(),
	'o2'  => new TestObjectToString(),

	'r1'  => fopen( APP_DIR . '/include/resource.txt', 'r' ),

);

/**
 * Variable legend.
 */
$legend_array = array(
	'i8'  => '$x = 0xCC00F9; // Hexadecimal integer.',
	'i9'  => '$x = 052; // Octal integer.',
	'ia'  => '$x = 0b0111001; // Binary integer (PHP5.4+).',
	'ib'  => '$x = ‏௫‏; // Tamil digit five - entered as string as PHP itself cannot deal with it as an integer.',
	'ic'  => '$x = ⁸₈; // Unicode superscript and subscript digit 8 - entered as a string as PHP itself cannot deal with these as integers.',
	'f5'  => '$x = acos(8); // = NAN',
	'f6'  => '$x = NAN; // = Not a number.',
	'f7'  => '$x = log(0); // = Infinite.',
	'f8'  => '$x = INF; // = Infinite.',
	'f9'  => '$x = 1.2345E8; // Exponent notation float.',
	'fa'  => '$x = ⅕; // Unicode character representing 1/5 - entered as string as PHP itself cannot deal with it as a float.',
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
 * Test group specific extra variables.
 */
$extra_variables = array();

$extra_variables['type_testing'] = array(
	'si'  => 'is_array', // Testing is_callable.
);

$extra_variables['boolean_tests']                         = array(
	'sq'  => 'on', // Testing filter_var() boolean.
	'sr'  => 'off', // Testing filter_var() boolean.
	'ss'  => 'yes', // Testing filter_var() boolean.
	'st'  => 'no', // Testing filter_var() boolean.
);
$extra_variables['filter_extension_bool_int_float']       = $extra_variables['boolean_tests'];
$extra_variables['filter_extension_bool_int_float']['sl'] = 'AF036C';


$extra_variables['integer_tests'] = array(
	'ib'  => '௫', // Tamil digit five.
	'ic'  => '⁸₈', // Superscript and subscript digit 8.
);

$extra_variables['float_tests'] = array(
	'fa'  => '⅕', // Unicode 1/5.
);


$extra_variables['numeric_tests'] = $extra_variables['integer_tests'];
$extra_variables['numeric_tests'] = array_merge( $extra_variables['numeric_tests'], $extra_variables['float_tests'] );

$extra_variables['string_tests'] = array(
	'sz'  => 'Iñtërnâtiônàlizætiøn', // Utf-8 / binary string.
);

/*
	DO NOT change this to a neater version with two assignments!!!
	If you do, for some obscure reason it breaks the PHP 5.0.x tests cheatsheet.
 */
// phpcs:ignore Squiz.PHP.DisallowMultipleAssignments -- see comment above.
$extra_variables['object_tests'] = $extra_variables['array_tests'] = array(
	'o1'  => new TestObject(),
);

$extra_variables['object_tests']['a6'] = array(
	's'  => 'simple',
	'm'  => array(
		'test1',
		'test2',
	),
);


if ( extension_loaded( 'gd' ) ) {
	$extra_variables['resource_tests'] = array(
		'r2'  => imagecreatetruecolor( 10, 10 ),
	);
}

$extra_variables['ctype_extension'] = array(
	'i4'  => 10, // Char line feed.
	'i6'  => 111, // Char o .
	'i7'  => 12345,

	'sj'  => '123,"str"', // Testing ctype_print(), ctype_graph().
	'sk'  => "123, \"str\"\r\n", // Testing ctype_print() (not in php5.4 ?).
	'sl'  => 'AF036C', // Testing ctype_xdigit().
	'sm'  => 'FOO', // Testing ctype_upper().
	'sn'  => "\f\t\r\n", // Testing ctype_space().
	'so'  => '*&$()', // Testing ctype_punct().
	'sp'  => "\x7f\t\r\n", // Testing ctype_ctrl().

	'sz'  => 'Iñtërnâtiônàlizætiøn', // Utf-8 / binary string.
);
