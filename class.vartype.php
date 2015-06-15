<?php
/**
 * Generic variable testing parent class.
 *
 * @package PHPCheatsheets
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Generic variable testing parent class.
 */
class Vartype {

	/**
	 * Placeholder for test data.
	 *
	 * @var array
	 */
	var $test_data = array();

	/**
	 * Placeholder for test data labels.
	 *
	 * @var array
	 */
	var $test_legend = array();

	/**
	 * Placeholder for test data key array.
	 *
	 * @var array
	 */
	var $test_data_keys = array();


	/**
	 * At which point in the tables to repeat headers.
	 *
	 * @var array
	 */
	var $header_repeat = array( 's', 'a', 'o', 'p' );


	/**
	 * Tests to be run, added in child class.
	 *
	 * @var array
	 */
	var $tests = array();

	/**
	 * Placeholder for grouping of the tests.
	 *
	 * @var array
	 */
	var $test_groups = array();


	/**
	 * Placeholder for test notes.
	 *
	 * @var array
	 */
	var $table_notes = array();


	/**
	 * Constructor.
	 */
	function __construct() {

		/**
		 * Replace selected PHP4 specific tests with their PHP5 equivalents to avoid parse errors
		 * when running the tests in PHP4.
		 */
		if ( PHP_VERSION_ID >= 50000 ) {
			include_once APP_DIR . '/class.vartype-php5.php';
			$this->merge_tests( VartypePHP5::$tests );
		}

		/**
		 * Add some PHP7 specific tests.
		 */
		if ( PHP_VERSION_ID >= 70000 ) {
			include_once APP_DIR . '/class.vartype-php7.php';
			$this->merge_tests( VartypePHP7::$tests );
		}

		// Create the actual test functions.
		foreach ( $this->tests as $key => $array ) {
			// pr_var( $key, 'Creating test for:', true );
			$this->tests[ $key ]['test'] = create_function( $array['arg'], $array['function'] );
		}
	}


	/**
	 * PHP4 compatibility constructor.
	 */
	function vartype() {
		$this->__construct();
	}


	/**
	 * Overwrite selected entries in the original test array with PHP-version specific function code.
	 *
	 * @param array $overload_tests Array of test entries to use in the overloading.
	 */
	function merge_tests( $overload_tests ) {

		foreach ( $overload_tests as $key => $array ) {
			if ( isset( $this->tests[ $key ], $this->tests[ $key ]['function'], $array['function'] ) ) {
				$this->tests[ $key ]['function'] = $array['function'];
			}
		}
	}


	/**
	 * Get the tab title for the initial tab for use in the page header.
	 *
	 * @param string $tab
	 *
	 * @return string
	 */
	function get_tab_title( $tab ) {
		if ( isset( $this->test_groups[ $tab ]['title'] ) && is_string( $this->test_groups[ $tab ]['title'] ) && $this->test_groups[ $tab ]['title'] !== '' ) {
			return $this->test_groups[ $tab ]['title'];
		}
		else {
			return '';
		}
	}


	/**
	 * Get a list of all tabs which this class will create.
	 *
	 * Helper function for the sitemap.
	 *
	 * @return array
	 */
	function get_tab_list() {
		return array_keys( $this->test_groups );
	}


	/**
	 * Generate a cheatsheet page.
	 *
	 * @param bool $all
	 */
	function do_page( $all = false ) {

		echo '<div id="tabs">';

		$this->print_tabs( $all );

		if ( isset( $all ) && $all === true ) {
			$this->print_tables();
		}
		echo "\n", '</div><!-- end of div#tabs -->';
	}


	/**
	 * Determine which tests to run.
	 *
	 * @param string|null $test_group The current subsection
	 *
	 * @return string
	 */
	function get_test_group( $test_group = null ) {
		$key = key( $this->test_groups ); // Set the first test group as the default if no test group given.
		if ( isset( $test_group, $this->test_groups[ $test_group ] ) ) {
			$key = $test_group;
		}
		return $key;
	}


	/**
	 * Run all the tests for one specific testgroup.
	 *
	 * @param string|null $test_group The current subsection
	 */
	function run_test( $test_group = null ) {

		$test_group = $this->get_test_group( $test_group );

		$this->set_test_data( $test_group );
		$this->print_table( $test_group );
		$this->clean_up();
	}


	/**
	 * Prepare the test data (the variables) for use in the tests.
	 *
	 * @param string|null $test_group The current subsection
	 */
	function set_test_data( $test_group = null ) {

		$GLOBALS['test'] = $test_group;

		include APP_DIR . '/include/vars-to-test.php';
		$this->test_data   = $test_array;
		$this->test_legend = $legend_array;

		// Merge test group specific variables into the test array.
		if ( isset( $extra_variables[ $test_group ] ) && $extra_variables[ $test_group ] !== array() ) {
			$this->test_data = array_merge( $this->test_data, $extra_variables[ $test_group ] );
		}

		$keys = array_keys( $this->test_data );
		usort( $keys, array( $this, 'sort_test_data' ) );


		$this->test_data_keys   = array();
		$this->test_data_keys[] = 'notset';
		$this->test_data_keys   = array_merge( $this->test_data_keys, $keys );

		unset( $test_array, $legend_array, $key_array );
	}


	/**
	 * Sort the test data via a set order - callback method.
	 *
	 * @param mixed $var_a
	 * @param mixed $var_b
	 *
	 * @return int
	 */
	function sort_test_data( $var_a, $var_b ) {
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
			'a', 'b', 'c', 'd', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
			'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
		);

		$primary_a = array_search( substr( $var_a, 0, 1 ), $primary_order, true );
		$primary_b = array_search( substr( $var_b, 0, 1 ), $primary_order, true );

		if ( $primary_a !== $primary_b ) {
			return ( ( $primary_a < $primary_b ) ? -1 : 1 );
		}

		$secondary_a = array_search( substr( $var_a, 1 ), $secondary_order, true );
		$secondary_b = array_search( substr( $var_b, 1 ), $secondary_order, true );

		if ( $secondary_a !== $secondary_b ) {
			return ( ( $secondary_a < $secondary_b ) ? -1 : 1 );
		}

		return 0;
	}


	/**
	 * Housekeeping so the variables can be re-initiated properly.
	 */
	function clean_up() {
		$clean_this = array(
			'r1' => 'fclose',
			'r2' => 'imagedestroy',
		);

		foreach ( $clean_this as $key => $function ) {
			if ( isset( $GLOBALS['test_array'], $GLOBALS['test_array'][ $key ] ) && is_resource( $GLOBALS['test_array'][ $key ] ) ) {
				$function( $GLOBALS['test_array'][ $key ] );
			}
			if ( isset( $this->test_data, $this->test_data[ $key ] ) && is_resource( $this->test_data[ $key ] ) ) {
				$function( $this->test_data[ $key ] );
			}
		}
	}


	/**
	 * Generate the subsection tabs (at the top of the page) for the cheatsheet.
	 *
	 * @param bool $all
	 */
	function print_tabs( $all = false ) {
		echo '
	<ul>';

		foreach ( $this->test_groups as $key => $test_group ) {
			$active_class = '';
			if ( $GLOBALS['tab'] === $key ) {
				$active_class = ' class="ui-tabs-active ui-state-active"';
			}

			if ( $all === true ) {
				echo '
		<li><a href="#', $key, '" data-tab="', $key, '" data-tab-title="', $test_group['title'], '"><strong>', $test_group['title'], '</strong></a></li>';
			}
			else {
				echo '
		<li', $active_class, '><a href="', BASE_URI, $GLOBALS['type'], '/', $key, '/ajax" data-tab="', $key, '" data-tab-title="', $test_group['title'], '"><strong>', $test_group['title'], '</strong></a></li>';
			}
		}
		unset( $key, $test_group );

		echo '
	</ul>';
	}


	/**
	 * Print all tables for the cheatsheet.
	 */
	function print_tables() {

		echo '
	<div class="tables">';

		foreach ( $this->test_groups as $key => $group_settings ) {
			$this->set_test_data( $key );
			$this->print_table( $key );
		}
		unset( $key, $group_settings );

		echo '
	</div><!-- end of div.tables -->';
	}


	/**
	 * Generate the table for one specific subsection of a cheatsheet.
	 *
	 * @param string $test_group The current subsection
	 */
	function print_table( $test_group ) {

		if ( isset( $this->test_groups[ $test_group ] ) ) {
			$GLOBALS['encountered_errors'] = array();

			echo '
		<div id="', $test_group, '">';

			if ( isset( $this->test_groups[ $test_group ]['urls'] ) && ( is_array( $this->test_groups[ $test_group ]['urls'] ) && count( $this->test_groups[ $test_group ]['urls'] ) > 0 ) ) {
				echo '<p>References:</p><ul>';
				foreach ( $this->test_groups[ $test_group ]['urls'] as $url ) {
					printf( '<li><a href="%1$s" target="_blank">%1$s</a></li>', $url );
				}
				unset( $url );
				echo '</ul>';
			}


			$this->print_tabletop( $test_group );

			$last_key = null;

			foreach ( $this->test_data_keys as $key ) {
				$value  = $this->test_data[ $key ];
				$legend = '';
				if ( isset( $this->test_legend[ $key ] ) ) {
					$legend = '<sup class="fright"><a href="#var-legend-' . $key . '">&dagger;' . $key . '</a></sup>';
				}

				$type = substr( $key, 0, 1 );

				$class = array();
				if ( $type !== $last_key ) {
					$class[]  = 'new-var-type';
					$last_key = $type;
				}
				if ( isset( $this->test_groups[ $test_group ]['target'] ) && $this->test_groups[ $test_group ]['target'] === $type ) {
					$class[] = 'target';
				}
				unset( $type, $hr_key );

				if ( count( $class ) > 0 ) {
					echo '
				<tr class="', implode( ' ', $class ), '">';
				}
				else {
					echo '
				<tr>';
				}


				echo '
					<th>', $legend, '$x = ';
				pr_var( $value, '', true );
				echo '
					</th>';

				$this->print_row_cells( $value, $test_group );

				echo '
					<th>', $legend, '$x = ';
				pr_var( $value, '', true );
				echo '
					</th>
				</tr>';

				unset( $value, $label, $type, $hr_key, $class );
			}
			unset( $key, $last_key );

			echo '
			</tbody>
			</table>';

			$this->print_error_footnotes( $test_group );
			$this->print_other_footnotes( $test_group );


			echo '
		</div><!-- end of div#', $test_group, ' -->';
		}
		else {
			trigger_error( 'Unknown test group <b>' . $test_group . '</b>', E_USER_WARNING );
		}
	}


	/**
	 * Generate the first row of the cheatsheet table.
	 *
	 * @param string $test_group The current subsection
	 *
	 * @return string
	 */
	function create_table_header( $test_group ) {

		$this->table_notes = array(); // Make sure we start with an empty array.
		$group_label       = $this->get_table_header_group_label( $test_group );

		$html = '
				<tr>
					' . $group_label;

		foreach ( $this->test_groups[ $test_group ]['tests'] as $test ) {
			$class   = $this->get_table_header_cell_class( $test_group, $test );
			$tooltip = ( isset( $this->tests[ $test ]['tooltip'] ) ? ' title="' . htmlspecialchars( $this->tests[ $test ]['tooltip'], ENT_QUOTES, 'UTF-8' ) . '"' : '' );

			$html .= '
					<th' . $class . '>' .
					( ( isset( $this->tests[ $test ]['url'] ) && $this->tests[ $test ]['url'] !== '' ) ? '<a href="' . $this->tests[ $test ]['url'] . '" target="_blank"' . $tooltip . '>' : '' ) .
					$this->tests[ $test ]['title'] .
					( ( isset( $this->tests[ $test ]['url'] ) && $this->tests[ $test ]['url'] !== '' ) ? '</a>' : '' );


			if ( isset( $this->tests[ $test ]['notes'] ) && ( is_array( $this->tests[ $test ]['notes'] ) && count( $this->tests[ $test ]['notes'] ) > 0 ) ) {

				$this->table_notes = array_merge( $this->table_notes, $this->tests[ $test ]['notes'] );
				$this->table_notes = array_unique( $this->table_notes );

				foreach ( $this->tests[ $test ]['notes'] as $note ) {
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
	 * Get the - potentially linked - group label (= first cell in the table header).
	 *
	 * @param string $test_group
	 *
	 * @return string
	 */
	function get_table_header_group_label( $test_group ) {
		if ( isset( $this->test_groups[ $test_group ]['book_url'] ) && $this->test_groups[ $test_group ]['book_url'] !== '' ) {
			$group_label = '<th class="label-col"><a href="' . $this->test_groups[ $test_group ]['book_url'] . '" target="_blank">' . $this->test_groups[ $test_group ]['title'] . '</a></th>';
		}
		else {
			$group_label = '<th class="label-col">' . $this->test_groups[ $test_group ]['title'] . '</th>';
		}

		return $group_label;
	}


	/**
	 * Get the CSS class string to attach to a table header cell.
	 *
	 * @param string $test_group
	 * @param string $test
	 *
	 * @return string
	 */
	function get_table_header_cell_class( $test_group, $test ) {
		$class = array();
		if ( isset( $this->test_groups[ $test_group ]['best'] ) && in_array( $test, $this->test_groups[ $test_group ]['best'] ) ) {
			$class[] = 'best';
		}
		else if ( isset( $this->test_groups[ $test_group ]['good'] ) && in_array( $test, $this->test_groups[ $test_group ]['good'] ) ) {
			$class[] = 'good';
		}
		if ( isset( $this->test_groups[ $test_group ]['break_at'] ) && in_array( $test, $this->test_groups[ $test_group ]['break_at'] ) ) {
			$class[] = 'end';
		}

		$class = ( ( count( $class ) > 0 ) ? ' class="' . implode( ' ', $class ) . '"' : '' );

		return $class;
	}


	/**
	 * Generate the html for the table top.
	 *
	 * @param string $test_group The current subsection
	 */
	function print_tabletop( $test_group ) {

		$header = $this->create_table_header( $test_group );

		echo '
		<table id="', $test_group, '-table" cellpadding="0" cellspacing="0" border="0">
		<thead>', $header, '
		</thead>
		<tfoot>', $header, '
		</tfoot>
		<tbody>';
	}


	/**
	 * Generate a cheatsheet result row.
	 *
	 * @param mixed  $value      The value this row applies to
	 * @param string $test_group The current subsection
	 */
	function print_row_cells( $value, $test_group ) {

		foreach ( $this->test_groups[ $test_group ]['tests'] as $key => $test ) {
			$GLOBALS['has_error'] = array();

			$class = $this->get_table_row_cell_class( $test_group, $test );

			echo '
					<td' . $class . '>';

			$val = $this->generate_value( $value );
			$this->tests[ $test ]['test']( $val );
			$this->print_row_cell_error_refs();

			echo '					</td>';

			unset( $class, $GLOBALS['has_error'] );
		}
		unset( $test );
	}


	/**
	 * Get the CSS class string to attach to a table cell.
	 *
	 * @param string $test_group
	 * @param string $test
	 *
	 * @return string
	 */
	function get_table_row_cell_class( $test_group, $test ) {
		$class = array( $test );
		if ( in_array( $test, $this->test_groups[ $test_group ]['best'] ) ) {
			$class[] = 'best';
		}
		else if ( in_array( $test, $this->test_groups[ $test_group ]['good'] ) ) {
			$class[] = 'good';
		}
		if ( in_array( $test, $this->test_groups[ $test_group ]['break_at'] ) ) {
			$class[] = 'end';
		}

		$class = ( ( count( $class ) > 0 ) ? ' class="' . implode( ' ', $class ) . '"' : '' );

		return $class;
	}


	/**
	 * Print the error reference numbers.
	 *
	 * Used in table cells to link to errors which will be displayed as footnotes.
	 */
	function print_row_cell_error_refs() {
		if ( is_array( $GLOBALS['has_error'] ) && count( $GLOBALS['has_error'] ) > 0 ) {
			foreach ( $GLOBALS['has_error'] as $error ) {
				if ( isset( $error['msg'] ) && $error['msg'] !== '' ) {
					echo '<br />', $error['msg'];
				}
			}
		}
	}


	/**
	 * Get the value to use for the tests.
	 *
	 * If in PHP5 and the value is an object, it will clone the object so we'll have a 'clean' object
	 * for each test (not a reference).
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	function generate_value( $value ) {
		if ( method_exists( 'VartypePHP5', 'generate_value' ) ) {
			$value = VartypePHP5::generate_value( $value );
		}
		return $value;
	}


	/**
	 * Generate footnotes for any errors encountered.
	 *
	 * @param string $test_group The current subsection
	 */
	function print_error_footnotes( $test_group ) {
		// Encountered errors footnote/appendix.
		if ( count( $GLOBALS['encountered_errors'] ) > 0 ) {
			echo '
			<ol id="', $test_group, '-errors" class="error-appendix">';
			foreach ( $GLOBALS['encountered_errors'] as $error ) {
				echo '
				<li>', $error, '</li>';
			}
			echo '
			</ol>';
		}
		unset( $GLOBALS['encountered_errors'] );
	}


	/**
	 * Generate footnotes for a test subsection if applicable.
	 *
	 * @param string $test_group The current subsection
	 */
	function print_other_footnotes( $test_group ) {
		if ( is_array( $this->table_notes ) && count( $this->table_notes ) > 0 ) {
			foreach ( $this->table_notes as $key => $note ) {
				printf( '
			<div id="%1$s-note%2$s" class="note-appendix">
				<sup>&Dagger; %2$s</sup> %3$s
			</div>',
					$test_group,
					( $key + 1 ),
					$note
				);
			}
		}
		$this->table_notes = array(); // Reset property
	}

}
