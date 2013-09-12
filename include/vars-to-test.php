<?php


$test_array = array(
//	'unset'	=>	'this variable will be unset',
	'n'		=>	null,

	'b1'	=>	false,
	'b2'	=>	true,

	'i1'	=>	1,
	'i2'	=>	0,
	'i3'	=>	-1,
	'i4'	=>	10, // char line feed
	'i5'	=>	42, // char *
	'i6'	=>	111, // char o
	'i7'	=>	12345,
	'i8'	=>	0xCC00F9, // hexadecimal integer
	'i9'	=>	0123, // octal integer

	'f1'	=>	1.3,
	'f2'	=>	0.005,
	'f3'	=>	0.0,
	'f4'	=>	-1.3,
	'f5'	=>	acos( 1.01 ), // is_nan
	'f6'	=>	log( 0 ), // is_infinite

	'se'	=>	'',

	's1'	=>	' ',
	's2'	=>	' 1',
	's3'	=>	' 3 ',
	's4'	=>	'15',
	's5'	=>	'1',
	's6'	=>	'0',
	's7'	=>	'-1',
	's8'	=>	'1.30',
	's9'	=>	'0.0',
	'sa'	=>	'-1.3',
	'sb'	=>	'true',
	'sc'	=>	'false',
	'sd'	=>	'null',
	'sf'	=>	'123str',
	'sg'	=>	'str123',
	'sh'	=>	'123, "str"',

	'si'	=>	'123,"str"', // ctype_print, ctype_graph
	'sj'	=>	"123, \"str\"\r\n", // ctype_print
	'sk'	=>	'AF036C', // ctype_xdigit
	'sl'	=>	'FOO', // ctype_upper
	'sm'	=>	"\f\t\r\n", //ctype_space
	'sn'	=>	'*&$()', //ctype_punct
	'so'	=>	"\x7f\t\r\n", //ctype_ctrl

	'sp'	=>	'on', // filter_var
	'sq'	=>	'off', // filter_var
	'sr'	=>	'yes', // filter_var
	'ss'	=>	'no', // filter_var

	'st'	=>	'is_array', // is_callable
	
	'su'	=>	'i', // increment/decrement effect

	'sz'	=>	'Iñtërnâtiônàlizætiøn', // utf-8 / binary string


	'ae'	=>	array(),
	'a0'	=>	array( null ),
	'a1'	=>	array( 1 ),
	'a2'	=>	array( false ),
	'a3'	=>	array( 1 => 'string' ), // with different key -> array + array
	'a4'	=>	array( false, 1, 1.3, '123str', 'str123', null ),
	'a5'	=>	array( 'a'	=> 'test1', 'b'	=>	'test2', 'numerical key', 'null' => null ),
	'a6'	=>	array( 's'	=> 'simple', 'm' => array( 'test1', 'test2' ) ),

	'oe'	=>	new stdClass(),
	'o1'	=>	new TestObject(),
	'o2'	=>	new TestObjectToString(),

	'r1'	=>	imagecreatetruecolor( 10, 10 ),


);

if ( extension_loaded( 'SPL_Types' ) ) {
	if ( class_exists( 'SplBool' ) ) {
		$test_array['p1'] =	new SplBool( false, true );
		$test_array['p2'] =	new SplBool( true, true );
//		$test_array['p3'] = SplBool::false;
//		$test_array['p4'] = SplBool::true;
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


$label_array = array(
	'i8'	=>	'hex int: 0xCC00F9',
	'i9'	=>	'octal: 0123',
//	'f5'	=>	'acos(1.01)',
//	'f6'	=>	'log(0)',
	'sm'	=> '"\f\t\r\n"',
	'so'	=> '"\x7f\t\r\n"',
);


$key_array   = array();
$key_array[] = 'notset';
$key_array   = array_merge( $key_array, array_keys( $test_array ) );



?>