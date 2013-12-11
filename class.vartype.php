<?php

/**
 *
 */
class Vartype {


	/**
	 * Placeholder for test data
	 */
	var $test_data = array();

	/**
	 * Placeholder for test data labels
	 */
	var $test_legend = array();

	/**
	 * Placeholder for test data key array
	 */
	var $test_data_keys = array();


	/**
	 * At which point in the tables to repeat headers
	 */
	var $header_repeat = array( 's', 'a', 'o', 'p' );
	
	


	/**
	 * Tests to be run, add in child class
	 */
	var $tests = array();

	var $test_groups = array();
	
	
	/**
	 * Placeholder for test notes
	 */
	var $table_notes = array();


	/**
	 * Constructor
	 */
	function __construct() {

		/**
		 * Replace selected PHP4 specific tests with their PHP5 equivalents to avoid parse errors
		 * when running the tests in PHP4
		 */
		if ( PHP_VERSION_ID >= 50000 ) {
			include_once( APP_DIR . '/class.vartype-php5.php' );
			$this->tests = VartypePHP5::merge_tests( $this->tests );
		}

		// Create the actual test functions
		foreach ( $this->tests as $key => $array ) {
			// pr_var( $key, 'Creating test for:', true );
			$this->tests[$key]['test'] = create_function( $array['arg'], $array['function'] );
		}
	}


	/* PHP4 compatibility */
	function vartype() {
		$this->__construct();
	}


	/**
	 * @param bool $all
	 */
	function do_page( $all = false ) {

		print '<div id="tabs">';

		$this->print_tabs( $all );

		if ( isset( $all ) && $all === true ) {
			$this->print_tables();
		}
		print '</div> <!-- end of tabs -->';
	}


	/**
	 * @param null $test_group
	 *
	 * @return mixed|null
	 */
	function get_test_group( $test_group = null ) {
		$key = key( $this->test_groups ); // set the first test group as the default if no test group given;
		if ( isset( $test_group ) && isset( $this->test_groups[$test_group] ) ) {
			$key = $test_group;
		}
		return $key;
	}


	/**
	 * @param null $test_group
	 */
	function run_test( $test_group = null ) {

		$test_group = $this->get_test_group( $test_group );

		$this->set_test_data( $test_group );
		$this->print_table( $test_group );
		$this->clean_up();
	}


	/**
	 * @param null $test_group
	 */
	function set_test_data( $test_group = null ) {

		$GLOBALS['test'] = $test_group;

		include( APP_DIR . '/include/vars-to-test.php' );
		$this->test_data   = $test_array;
		$this->test_legend = $legend_array;

		// Merge test group specific variables into the test array
		if ( isset( $extra_variables[$test_group] ) && $extra_variables[$test_group] !== array() ) {
			$this->test_data = array_merge( $this->test_data, $extra_variables[$test_group] );
		}

		$keys = array_keys( $this->test_data );
		usort( $keys, array( $this, 'sort_test_data' ) );


		$this->test_data_keys   = array();
		$this->test_data_keys[] = 'notset';
		$this->test_data_keys   = array_merge( $this->test_data_keys, $keys );

		unset( $test_array, $legend_array, $key_array );
	}


	/**
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	function sort_test_data( $a, $b ) {
		$primary_order   = array(
			'n', // null
			'b', // boolean
			'i', // integer
			'f', // float
			's', // string
			'a', // array
			'o', // object
			'r', // resource
			'p', // SPL_Types object
		);
		$secondary_order = array(
			'e', // empty
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
			'a', 'b', 'c', 'd', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
		);
		
		$primary_a = array_search( substr( $a, 0, 1 ), $primary_order, true );
		$primary_b = array_search( substr( $b, 0, 1 ), $primary_order, true );
		
		if ( $primary_a !== $primary_b ) {
			return ( $primary_a < $primary_b ) ? -1 : 1;
		}

		$secondary_a = array_search( substr( $a, 1 ), $secondary_order, true );
		$secondary_b = array_search( substr( $b, 1 ), $secondary_order, true );

		if ( $secondary_a !== $secondary_b ) {
			return ( $secondary_a < $secondary_b ) ? -1 : 1;
		}

		return 0;
	}


	function clean_up() {
		if ( isset( $GLOBALS['test_array'] ) && isset( $GLOBALS['test_array']['r1'] ) && is_resource( $GLOBALS['test_array']['r1'] ) ) {
			fclose( $GLOBALS['test_array']['r1'] );
		}
		if ( isset( $GLOBALS['test_array'] ) && isset( $GLOBALS['test_array']['r2'] ) && is_resource( $GLOBALS['test_array']['r2'] ) ) {
			imagedestroy( $GLOBALS['test_array']['r2'] );
		}
		if ( isset( $this->test_data ) && isset( $this->test_data['r1'] ) && is_resource( $this->test_data['r1'] ) ) {
			fclose( $this->test_data['r1'] );
		}
		if ( isset( $this->test_data ) && isset( $this->test_data['r2'] ) && is_resource( $this->test_data['r2'] ) ) {
			imagedestroy( $this->test_data['r2'] );
		}
	}


	/**
	 * @param bool $all
	 */
	function print_tabs( $all = false ) {
		// Tabs at top of page
		print '
	<ul>';

		foreach ( $this->test_groups as $key => $test_group ) {
			if ( $all === true ) {
				print '
		<li><a href="#' . $key . '"><strong>' . $test_group['title'] . '</strong></a></li>';
			}
			else {
				print '
		<li' . ( $GLOBALS['tab'] === $key ? ' class="ui-tabs-active ui-state-active"' : '' ) . '><a href="index.php?type=' . $GLOBALS['type'] . '&amp;tab=' . $key . '&amp;do=ajax"><strong>' . $test_group['title'] . '</strong></a></li>';
			}
		}
		unset( $key, $test_group );

		print '
	</ul>';
	}


	function print_tables() {
		
		print '
	<div class="tables">';

		foreach ( $this->test_groups as $key => $group_settings ) {
			$this->set_test_data( $key );
			$this->print_table( $key );
		}
		unset( $key, $group_settings );
		
		print '
	</div>';
	}


	/**
	 * @param $test_group
	 */
	function print_table( $test_group ) {
		
		if ( isset( $this->test_groups[$test_group] ) ) {
			$GLOBALS['encountered_errors'] = array();
			
			print '
		<div id="' . $test_group . '">';

			if ( isset( $this->test_groups[$test_group]['urls'] ) && ( is_array( $this->test_groups[$test_group]['urls'] ) && count( $this->test_groups[$test_group]['urls'] ) > 0 ) ) {
				print '<p>References:</p><ul>';
				foreach ( $this->test_groups[$test_group]['urls'] as $url ) {
					print '<li><a href="' . $url . '" target="_blank">' . $url . '</a></li>';
				}
				unset( $url );
				print '</ul>';
			}


			$this->print_tabletop( $test_group );

			$last_key = null;

			foreach ( $this->test_data_keys as $key ) {
				$value  = $this->test_data[$key];
				$legend = ( isset( $this->test_legend[$key] ) ? '<sup class="fright"><a href="#var-legend-' . $key . '">&dagger;' . $key . '</a></sup>' : '' );

				$type = substr( $key, 0, 1 );

				$class = array();
				if ( $type !== $last_key ) {
					$class[]  = 'new-var-type';
					$last_key = $type;
				}
				if ( isset( $this->test_groups[$test_group]['target'] ) && $this->test_groups[$test_group]['target'] === $type ) {
					$class[] = 'target';
				}
				unset( $type, $hr_key );
				
				if ( count( $class ) > 0 ) {
					print '
				<tr class="' . implode( ' ', $class ) . '">';
				}
				else {
					print '
				<tr>';
				}


				print '
					<th>' . $legend . '$x = ';
				pr_var( $value, '', true );
				print '
					</th>';

				$this->print_row_cells( $value, $test_group );
				
				print '
					<th>' . $legend . '$x = ';
				pr_var( $value, '', true );
				print '
					</th>';

				print '
				</tr>';

				unset( $value, $label, $type, $hr_key, $class );
			}
			unset( $key, $last_key );

			print '
			</tbody>
			</table>';

			$this->print_error_footnotes( $test_group );
			$this->print_other_footnotes( $test_group );


			print '
		</div>';
		}
		else {
			trigger_error( 'Unknown test group <b>' . $test_group . '</b>', E_USER_WARNING );
		}
	}


	/**
	 * @param $test_group
	 *
	 * @return string
	 */
	function create_table_header( $test_group ) {
		
		$this->table_notes = array(); // Make sure we start with an empty array

		if ( isset( $this->test_groups[$test_group]['book_url'] ) && $this->test_groups[$test_group]['book_url'] !== '' ) {
			$group_label = '<th class="label-col"><a href="' . $this->test_groups[$test_group]['book_url'] . '" target="_blank">' . $this->test_groups[$test_group]['title'] . '</a></th>';
		}
		else {
			$group_label = '<th class="label-col">' . $this->test_groups[$test_group]['title'] . '</th>';
		}


		$html = '
				<tr>
					' . $group_label;



		foreach ( $this->test_groups[$test_group]['tests'] as $test ) {
			$class = array();
			if ( isset( $this->test_groups[$test_group]['best'] ) && in_array( $test, $this->test_groups[$test_group]['best'] ) ) {
				$class[] = 'best';
			}
			else if ( isset( $this->test_groups[$test_group]['good'] ) && in_array( $test, $this->test_groups[$test_group]['good'] ) ) {
				$class[] = 'good';
			}
			if ( isset( $this->test_groups[$test_group]['break_at'] ) && in_array( $test, $this->test_groups[$test_group]['break_at'] ) ) {
				$class[] = ( $class === '' ) ? 'end' : ' end';
			}
			
			$class = ( ( count( $class ) > 0 ) ? ' class="' . implode( ' ', $class ) . '"' : '' );

			$tooltip = ( isset( $this->tests[$test]['tooltip'] ) ? ' title="' . htmlspecialchars( $this->tests[$test]['tooltip'], ENT_QUOTES, 'UTF-8' ) . '"' : '' );

			$html .= '
					<th' . $class . '>' .
					( ( isset( $this->tests[$test]['url'] ) && $this->tests[$test]['url'] !== '' ) ? '<a href="' . $this->tests[$test]['url'] . '" target="_blank"' . $tooltip . '>' : '' ) .
					$this->tests[$test]['title'] .
					( ( isset( $this->tests[$test]['url'] ) && $this->tests[$test]['url'] !== '' ) ? '</a>' : '' );


			if ( isset( $this->tests[$test]['notes'] ) && ( is_array( $this->tests[$test]['notes'] ) && count( $this->tests[$test]['notes'] ) > 0 ) ) {
				
				$this->table_notes = array_merge( $this->table_notes, $this->tests[$test]['notes'] );
				$this->table_notes = array_unique( $this->table_notes );

				foreach ( $this->tests[$test]['notes'] as $note ) {
					$note_id = array_search( $note, $this->table_notes );
					if ( $note_id !== false ) {
						$html .= ' <sup><a href="#' . $test_group . '-note' . ( $note_id + 1 ) . '">&Dagger;' . ( $note_id + 1 ) . '</a></sup>';
					}
				}
			}

			$html .= '</th>';

			unset( $class, $tooltip );
		}

		$html .= '
					' . $group_label . '
				</tr>';

		return $html;
	}


	/**
	 * @param $test_group
	 */
	function print_tabletop( $test_group ) {

		$header = $this->create_table_header( $test_group );

		print '
		<table id="' . $test_group . '-table" cellpadding="0" cellspacing="0" border="0">';
		print '
		<thead>' . $header . '
		</thead>
		<tfoot>' . $header . '
		</tfoot>
		<tbody>';
	}


	/**
	 * @param $value
	 * @param $test_group
	 */
	function print_row_cells( $value, $test_group ) {

		foreach ( $this->test_groups[$test_group]['tests'] as $key => $test ) {
			$GLOBALS['has_error'] = array();

			$class = array( $test );
			if ( in_array( $test, $this->test_groups[$test_group]['best'] ) ) {
				$class[] = 'best';
			}
			else if ( in_array( $test, $this->test_groups[$test_group]['good'] ) ) {
				$class[] = 'good';
			}
			if ( in_array( $test, $this->test_groups[$test_group]['break_at'] ) ) {
				$class[] = 'end';
			}

			if ( count( $class ) === 0 ) {
				print '					<td>';
			}
			else {
				print '
					<td class="' . implode( ' ', $class ) . '">';
			}


			$val = $this->generate_value( $value );
			$this->tests[$test]['test']( $val );


			if ( is_array( $GLOBALS['has_error'] ) && count( $GLOBALS['has_error'] ) > 0 ) {
				foreach ( $GLOBALS['has_error'] as $error ) {
					if ( isset( $error['msg'] ) && $error['msg'] !== '' ) {
						print '<br />' . $error['msg'];
					}
				}
			}

			print '					</td>';

			unset( $class, $GLOBALS['has_error'] );
		}
		unset( $test );
	}


	/**
	 * Get the value to use for the tests
	 * If in PHP5 and the value is an object, it will clone the object so we'll have a 'clean' object
	 * for each test (not a reference)
	 *
	 * @param	mixed	$value
	 * @return	mixed
	 */
	function generate_value( $value ) {
		if ( method_exists( 'VartypePHP5', 'generate_value' ) ) {
			$value = VartypePHP5::generate_value( $value );
		}
		return $value;
	}


	/**
	 * @param $test_group
	 */
	function print_error_footnotes( $test_group ) {
		// Encountered errors footnote/appendix
		if ( count( $GLOBALS['encountered_errors'] ) > 0 ) {
			print '
			<ol id="' . $test_group . '-errors" class="error-appendix">';
			foreach ( $GLOBALS['encountered_errors'] as $error ) {
				print '
				<li>' . $error . '</li>';
			}
			print '
			</ol>';
		}
		unset( $GLOBALS['encountered_errors'] );
	}


	/**
	 * @param $test_group
	 */
	function print_other_footnotes( $test_group ) {
		if ( is_array( $this->table_notes ) && count( $this->table_notes ) > 0 ) {
			foreach ( $this->table_notes as $key => $note ) {
				print '
			<div id="' . $test_group . '-note' . ( $key + 1 ) . '" class="note-appendix">
				<sup>&Dagger; ' . ( $key + 1 ) . '</sup> ' . $note . '
			</div>
				';
			}
		}
		$this->table_notes = array(); // Reset property
	}


	// PHP4 version
	/**
	 * @param $a
	 * @param $b
	 * @param $function
	 */
	function compare_strings( $a, $b, $function ) {
		$r = $function( $a, $b );
		if ( is_int( $r ) ) {
			pr_int( $r );
		}
		else {
			pr_var( $r, '', true, true );
		}
	}
}

?>