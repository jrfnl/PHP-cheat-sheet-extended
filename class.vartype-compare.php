<?php


include_once( 'class.vartype.php' );

class VartypeCompare extends Vartype {

	// Set up the tests for the comparisons
	var $tests = array(
		'equal'			=> array(
			'title'			=> '==',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a==$b );',
		),
		'equal_strict'	=> array(
			'title'			=> '===',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a===$b );',
		),
		'not_equal'		=> array(
			'title'			=> '!=',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a!=$b );',
		),
		'not_equal2'	=> array(
			'title'			=> '&lt;&gt;',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a<>$b );',
		),
		'not_equal_strict'	=> array(
			'title'			=> '!==',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a!==$b );',
		),
		'lt'			=> array(
			'title'			=> '&lt;',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a<$b );',
		),
		'gt'			=> array(
			'title'			=> '&gt;',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a>$b );',
		),
		'lte'			=> array(
			'title'			=> '&lt;=',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a<=$b );',
		),
		'gte'			=> array(
			'title'			=> '&gt;=',
			'url'			=> 'http://php.net/language.operators.comparison',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_bool( $a>=$b );',
		),


		/**
		 * String comparison functions
		 */
		'strcmp'		=> array(
			'title'			=> 'strcmp()',
			'url'			=> 'http://php.net/strcmp',
			'arg'			=> '$a, $b',
			'function'		=> 'Vartype::compare_strings( $a, $b, "strcmp" );',
		),
		'strcasecmp'	=> array(
			'title'			=> 'strcasecmp()',
			'url'			=> 'http://php.net/strcasecmp',
			'arg'			=> '$a, $b',
			'function'		=> 'Vartype::compare_strings( $a, $b, "strcasecmp" );',
		),
		'strnatcmp'		=> array(
			'title'			=> 'strnatcmp()',
			'url'			=> 'http://php.net/strnatcmp',
			'arg'			=> '$a, $b',
			'function'		=> 'Vartype::compare_strings( $a, $b, "strnatcmp" );',
		),
		'strnatcasecmp'	=> array(
			'title'			=> 'strnatcasecmp()',
			'url'			=> 'http://php.net/strnatcasecmp',
			'arg'			=> '$a, $b',
			'function'		=> 'Vartype::compare_strings( $a, $b, "strnatcasecmp" );',
		),
		'strcoll'		=> array(
			'title'			=> 'strcoll()',
			'url'			=> 'http://php.net/strcoll',
			'arg'			=> '$a, $b',
			'function'		=> 'Vartype::compare_strings( $a, $b, "strcoll" );',
		),
		'similar_text'	=> array(
			'title'			=> 'similar_text()',
			'url'			=> 'http://php.net/similar_text',
			'arg'			=> '$a, $b',
			'function'		=> 'Vartype::compare_strings( $a, $b, "similar_text" );',
		),
		'levenshtein'	=> array(
			'title'			=> 'levenshtein()',
			'url'			=> 'http://php.net/levenshtein',
			'arg'			=> '$a, $b',
			'function'		=> 'Vartype::compare_strings( $a, $b, "levenshtein" );',
		),


		/**
		 * Number comparison functions
		 */

		'bccomp'	=> array(
			'title'			=> 'bccomp()',
			'url'			=> 'http://php.net/bccomp',
			'arg'			=> '$a, $b',
			'function'		=> 'if( extension_loaded( \'bcmath\' ) ) { $r = bccomp( $a, $b ); if( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'E: bcmath extension not installed\'; }',
		),
		// @todo rewrite note! (copy to the other ones!)
		'min'			=> array(
			'title'			=> 'min()',
			'url'			=> 'http://php.net/min',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_var( min( $a, $b ), \'\', true, true );',
			'notes'			=> array(
				'<p>Please note: (REWRITE!!)

PHP will evaluate a non-numeric string as 0 if compared to integer, but still return the string if it\'s seen as the numerically lowest value. If multiple arguments evaluate to 0, min() will return the lowest alphanumerical string value if any strings are given, else a numeric 0 is returned. 

 max() returns the numerically highest of the parameter values. If multiple values can be considered of the same size, the one that is listed first will be returned.

When max() is given multiple arrays, the longest array is returned. If all the arrays have the same length, max() will use lexicographic ordering to find the return value.

When given a string it will be cast as an integer when comparing. </p>',
			),
		),

		'max'			=> array(
			'title'			=> 'max()',
			'url'			=> 'http://php.net/max',
			'arg'			=> '$a, $b',
			'function'		=> 'pr_var( max( $a, $b ), \'\', true, true );',
			'notes'			=> array(
				'<p>Please note: (REWRITE!!)

PHP will evaluate a non-numeric string as 0 if compared to integer, but still return the string if it\'s seen as the numerically highest value. If multiple arguments evaluate to 0, max() will return a numeric 0 if given, else the alphabetical highest string value will be returned.

 max() returns the numerically highest of the parameter values. If multiple values can be considered of the same size, the one that is listed first will be returned.

When max() is given multiple arrays, the longest array is returned. If all the arrays have the same length, max() will use lexicographic ordering to find the return value.

When given a string it will be cast as an integer when comparing. </p>',
			),
		),


	);
	
	

	function __construct() {
		parent::__construct();
	}

	function VartypeCompare() {
		$this->__construct();
	}
	
	
	function get_test_group( $test_group = null ) {
		$key = key( $this->tests ); // get first item in array;
		if ( isset( $test_group ) && isset( $this->tests[$test_group] ) ) {
			$key = $test_group;
		}
		return $key;
	}




	function print_tabs( $all = false ) {
		// Tabs at top of page
		print '
	<ul>';
	
		foreach ( $this->tests as $key => $test ) {
//			print '
//		<li' . ( isset( $test['tooltip'] ) ? ' title="' . $test['tooltip'] . '"' : '' ) . '><a href="#' . $key . '"><strong>' . $test['title'] . '</strong></a></li>';

			if ( $all === true ) {
				print '
		<li' . ( isset( $test['tooltip'] ) ? ' title="' . $test['tooltip'] . '"' : '' ) . '><a href="#' . $key . '"><strong>' . $test['title'] . '</strong></a></li>';
			}
			else {
				print '
		<li' . ( $GLOBALS['tab'] === $key ? ' class="ui-tabs-active ui-state-active"' : '' ) . ( isset( $test['tooltip'] ) ? ' title="' . $test['tooltip'] . '"' : '' ) . '><a href="index.php?type=' . $GLOBALS['type'] . '&amp;tab=' . $key . '&amp;do=ajax"><strong>' . $test['title'] . '</strong></a></li>';
			}
		}
		unset( $key, $test );

		print '
	</ul>';
	}
	
	
	function print_tables() {
		
		print '
	<div class="tables">';

		// Get & Slim down test array
/*		include( 'include/vars-to-test.php' );
//		array_splice( $key_array, 28, 13 );
//		array_splice( $key_array, 34, 2 );

		// Assign test_data to the properties
		$this->test_data      = $test_array;
		$this->test_labels    = $label_array;
		$this->test_data_keys = $key_array;*/
		
		$this->set_test_data();


		foreach ( $this->tests as $key => $test_settings ) {
			$GLOBALS['test'] = $key;
			$this->print_table( $key );
		}
		unset( $key, $test_settings, $test_array, $label_array, $key_array );

		print '
	</div>';
	}


	// Comparison tables
	function print_table( $test ) {

		if ( isset( $this->tests[$test] ) ) {
			$GLOBALS['encountered_errors'] = array();

			print '
		<div id="' . $test . '">';

//			print '<h4>Comparisons with '' . $this->tests[$test]['title'] . '</h4>';

			$header = $this->create_table_header( $test );

			$this->print_tabletop( $header );
			
			
			$last_key = null;

			foreach ( $this->test_data_keys as $key1 ) {
				$value1 = $this->test_data[$key1];
				$label  = ( isset( $this->test_labels[$key1] ) ? $this->test_labels[$key1] : $value1 );

				$type = substr( $key1, 0, 1 );

				$hr_key = array_search( $type, $this->header_repeat );
				if ( $hr_key !== false && $type !== $last_key ) {
					print $header;
				}

				$class = array();
				if ( $type !== $last_key ) {
					$class[]  = 'newvartype';
					$last_key = $type;
				}

				if ( count( $class ) > 0 ) {
					print '
				<tr class="' . implode( ' ', $class ) . '">';
				}
				else {
					print '
				<tr>';
				}

				print '
					<th>';
				pr_var( $label, '', true );
				print '					</th>';

				$this->print_rowcells( $value1, $test );

				print '
					<th>';
				pr_var( $label, '', true );
				print '					</th>';

				print '
				</tr>';

				unset( $value1, $label, $type, $hr_key, $class );
			}
			unset( $key1, $last_key );

			print '
			</tbody>
			</table>';


			$this->print_error_footnotes( $test );
			$this->print_other_footnotes( $test );

			print '
		</div>';
		}
		else {
			trigger_error( 'Unknown test <b>' . $test . '</b>', E_USER_WARNING );
		}

	}
	


	function create_table_header( $test ) {
		
		
		if ( isset( $this->tests[$test]['url'] ) && $this->tests[$test]['url'] !== '' ) {
			$group_label = '<a href="' . $this->tests[$test]['url'] . '" target="_blank"' . ( ( isset( $this->tests[$test]['tooltip'] ) && $this->tests[$test]['tooltip'] !== '' ) ? ' title="' . $this->tests[$test]['tooltip'] . '"' : '' ) . '><strong>' . $this->tests[$test]['title'] . '</strong></a>';
		}
		else {
			$group_label = '<a href="' . $this->tests[$test]['url'] . '" target="_blank"' . ( ( isset( $this->tests[$test]['tooltip'] ) && $this->tests[$test]['tooltip'] !== '' ) ? ' title="' . $this->tests[$test]['tooltip'] . '"' : '' ) . '><strong>' . $this->tests[$test]['title'] . '</strong></a>';
		}
		
		$notes = '';
		if ( isset( $this->tests[$test]['notes'] ) && ( is_array( $this->tests[$test]['notes'] ) && count( $this->tests[$test]['notes'] ) > 0 ) ) {
			foreach ( $this->tests[$test]['notes'] as $key => $note ) {
				$notes .= ' <sup><a href="#' . $test . '-note' . ( $key + 1 ) . '">&Dagger;' . ( $key + 1 ) . '</a></sup>';
			}
		}


		$html = '
				<tr>
					<th>' . $group_label . $notes . '</th>';


		// Top labels
		foreach ( $this->test_data_keys as $i => $key ) {
			$value = $this->test_data[$key];
			
			$class = '';
			if ( !isset( $this->test_data_keys[$i + 1] ) || substr( $key, 0, 1 ) !== substr( $this->test_data_keys[$i + 1], 0, 1 ) ) {
				$class = ' class="end"';
			}
			
			$html .= '
					<th' . $class . '>';
						
			ob_start();
			pr_var( $value, '', false, true, '' );
			$label = ob_get_clean();

			if ( strpos( $label, 'Object: ' ) !== false ) {
				$label = str_replace( "\n", '', $label );
				$label = str_replace( '<br />', "\n", $label );
				$label = htmlspecialchars( $label, ENT_QUOTES, 'UTF-8' );
	
				$html .= '<span title="' . $label . '">Object(&hellip;)</span>';
			}
			else if ( strpos( $label, 'Array: ' ) !== false ) {
				$label = str_replace( "\n", '', $label );
				$label = str_replace( '<br />', "\n", $label );
				$label = htmlspecialchars( $label, ENT_QUOTES, 'UTF-8' );
	
				$html .= '<span title="' . $label . '">Array(&hellip;)</span>';
			}
			else {
				$html .= $label;
			}
			$html .= '					</th>';

			unset( $value, $class, $label );
		}
		unset( $i, $key );
	
	
		$html .= '
					<th>' . $group_label . $notes . '</th>
				</tr>';
	
		return $html;
	}
	
	

	function print_rowcells( $value1, $test ) {
		
		foreach ( $this->test_data_keys as $i => $key2 ) {
			$GLOBALS['has_error'] = array();

			$value2 = $this->test_data[$key2];

			$class = '';
			if ( !isset( $this->test_data_keys[$i + 1] ) || substr( $key2, 0, 1 ) !== substr( $this->test_data_keys[$i + 1], 0, 1 ) ) {
				$class = ' class="end"';
			}


			print '
				<td' . $class . '>';

			$this->tests[$test]['test']( $value1, $value2 );

			if ( is_array( $GLOBALS['has_error'] ) && count( $GLOBALS['has_error'] ) > 0 ) {
				foreach ( $GLOBALS['has_error'] as $error ) {
					if ( isset( $error['msg'] ) && $error['msg'] !== '' ) {
						print '<br />' . $error['msg'];
					}
				}
			}

			print '
					</td>';

			unset( $GLOBALS['has_error'], $value2, $type, $class );
		}
		unset( $i, $key2 );
	}
	
	
	function print_other_footnotes( $test ) {
		if ( isset( $this->tests[$test]['notes'] ) && ( is_array( $this->tests[$test]['notes'] ) && count( $this->tests[$test]['notes'] ) > 0 ) ) {
			foreach ( $this->tests[$test]['notes'] as $key => $note ) {
				print '
			<div id="' . $test . '-note' . ( $key + 1 ) . '" class="note-appendix">
				<sup>&Dagger; ' . ( $key + 1 ) . '</sup> ' . $note . '
			</div>
				';
			}
		}
	}


}

?>