<?php

class Vartype {


	/**
	 * Placeholder for test data
	 */
	var $test_data = array();

	/**
	 * Placeholder for test data labels
	 */
	var $test_labels = array();

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

		foreach ( $this->tests as $key => $array ) {
//pr_var( $key, 'Creating test for:', true );
			$this->tests[$key]['test'] = create_function( $array['arg'], $array['function'] );
		}
	}


	/* PHP4 compatibility */
	function vartype() {
		$this->__construct();
	}


	function do_page( /*$test_group = null,*/ $all = false ) {

//		$test_group = $this->get_test_group( $test_group );

		print '<div id="tabs">';

		$this->print_tabs( $all );

		if ( isset( $all ) && $all === true ) {
			$this->print_tables();
		}
/*		else {
			$this->run_test( $test_group );
		}
*/
		print '</div> <!-- end of tabs -->';
	}
	
	
	function get_test_group( $test_group = null ) {
		$key = key( $this->test_groups ); // get first item in array;
		if ( isset( $test_group ) && isset( $this->test_groups[$test_group] ) ) {
			$key = $test_group;
		}
		return $key;
	}


	function run_test( $test_group = null ) {

		$test_group = $this->get_test_group( $test_group );

		$this->set_test_data( $test_group );
		$this->print_table( $test_group );
	}


	function set_test_data( $test_group = null ) {

		$GLOBALS['test'] = $test_group;

		include( 'include/vars-to-test.php' );
		$this->test_data      = $test_array;
		$this->test_labels    = $label_array;
		$this->test_data_keys = $key_array;

		/*
		array_splice( $key_array, 28, 12 );
		array_splice( $key_array, 34, 2 );
		*/

		unset( $test_array, $label_array, $key_array );
	}


	function print_tabs( $all = false ) {
		// Tabs at top of page
		print '
	<ul>';

		foreach ( $this->test_groups as $key => $test_group ) {
//			print '
//		<li><a href="#' . $key . '"><strong>' . $test_group['title'] . '</strong></a></li>';
//			if( $GLOBALS['tab'] === $key || $all === true ) {
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


			$header = $this->create_table_header( $test_group );

			$this->print_tabletop( $header );

			$last_key = null;

			foreach ( $this->test_data_keys as $key ) {
				$value = $this->test_data[$key];
				$label = ( isset( $this->test_labels[$key] ) ? $this->test_labels[$key] : $value );

				$type = substr( $key, 0, 1 );

				$hr_key = array_search( $type, $this->header_repeat );
				if ( $hr_key !== false && $type !== $last_key ) {
					print $header;
				}

				$class = array();
				if ( $type !== $last_key ) {
					$class[]  = 'newvartype';
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
					<th>$x = ';
				pr_var( $label, '', true );
				print '					</th>';

				$this->print_rowcells( $value, $test_group );
				
				print '
					<th>$x = ';
				pr_var( $label, '', true );
				print '					</th>';

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

			$tooltip = ( isset( $this->tests[$test]['tooltip'] ) ? ' title="' . $this->tests[$test]['tooltip'] . '"' : '' );

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
	
	
	function print_tabletop( $header ) {
		print '
		<table cellpadding="0" cellspacing="0" border="0">';
		print '
		<thead>' . $header . '
		</thead>
		<tfoot>' . $header . '
		</tfoot>
		<tbody>';
	}
	


	function print_rowcells( $value, $test_group ) {

		foreach ( $this->test_groups[$test_group]['tests'] as $test ) {
			$GLOBALS['has_error'] = array();

			$class = array();
			if ( in_array( $test, $this->test_groups[$test_group]['best'] ) ) {
				$class[] = 'best';
			}
			else if ( in_array( $test, $this->test_groups[$test_group]['good'] ) ) {
				$class[] = 'good';
			}
			if ( in_array( $test, $this->test_groups[$test_group]['break_at'] ) ) {
				$class[] = 'end';
			}

			print ( ( count( $class ) === 0 ) ? '
					<td>' : '
					<td class="' . implode( ' ', $class ) . '">' );


			$this->tests[$test]['test']( $value );


			if ( is_array( $GLOBALS['has_error'] ) && count( $GLOBALS['has_error'] ) > 0 ) {
				foreach ( $GLOBALS['has_error'] as $error ) {
					if ( isset( $error['msg'] ) && $error['msg'] !== '' ) {
						print '<br />' . $error['msg'];
					}
				}
			}

			print '
					</td>';

			unset( $class, $GLOBALS['has_error'] );
		}
		unset( $test );
	}


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


	
	static function compare_strings( $a, $b, $function ) {
		
		if ( ( PHP_VERSION_ID >= 50000 && $function === 'levenshtein' ) && ( ( gettype( $a ) === 'array' || gettype( $a ) === 'resource' ) || ( gettype( $b ) === 'array' || gettype( $b ) === 'resource' ) ) ) {

			try {
				$r = $function( $a, $b );
				if ( is_int( $r ) ) {
					pr_int( $r );
				}
				else {
					pr_var( $r, '', true, true );
				}
			}
			catch( Exception $e ) {
				$message = $e->getMessage();
				$key     = array_search( $message, $GLOBALS['encountered_errors'] );
				if ( $key === false ) {
					$GLOBALS['encountered_errors'][] = $message;
					$key = array_search( $message, $GLOBALS['encountered_errors'] );
				}
				print '<span class="error">Fatal error <a href="#' . $GLOBALS['test']. '-errors">#' . ( $key + 1 ) . '</a></span>';
			}
		}
		else if ( PHP_VERSION_ID >= 50200 && ( gettype( $a ) === 'object' || gettype( $b ) === 'object' ) ) {
			try {
				$r = $function( $a, $b );
				if ( is_int( $r ) ) {
					pr_int( $r );
				}
				else {
					pr_var( $r, '', true, true );
				}
			}
			catch( Exception $e ) {
				$message = $e->getMessage();
				$key     = array_search( $message, $GLOBALS['encountered_errors'] );
				if ( $key === false ) {
					$GLOBALS['encountered_errors'][] = $message;
					$key = array_search( $message, $GLOBALS['encountered_errors'] );
				}
				print '<span class="error">Fatal error <a href="#' . $GLOBALS['test']. '-errors">#' . ( $key + 1 ) . '</a></span>';
			}
		}
		else {
			$r = $function( $a, $b );
			if ( is_int( $r ) ) {
				pr_int( $r );
			}
			else {
				pr_var( $r, '', true, true );
			}
		}
	}

}

?>