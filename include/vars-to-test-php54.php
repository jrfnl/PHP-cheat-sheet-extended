<?php
// Prevent direct calls to this file
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


$test_array['ia']   = 0b0111001; // binary integer 57
$legend_array['ia'] = '$x = 0b0111001; // binary integer (PHP5.4+)';
