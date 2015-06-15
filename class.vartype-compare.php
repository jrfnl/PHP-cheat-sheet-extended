<?php
/**
 * Variable comparison tests.
 *
 * @package PHPCheatsheets
 */

// Prevent direct calls to this file.
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


include_once APP_DIR . '/class.vartype.php';

/**
 * Variable comparison tests.
 */
class VartypeCompare extends Vartype {

	/**
	 * The tests to run.
	 *
	 * @var array $tests  Multi-dimensional array.
	 *                    Possible lower level array keys:
	 *                    - title     Used as tab title
	 *                    - tooltip   Additional code sample for tooltip on tab
	 *                    - url       Relevant PHP Manual page
	 *                    - arg       Function arguments
	 *                    - function  Function to run
	 *                    - Notes     Array of notes on this test
	 */
	var $tests = array(

		/**
		 * Operator based comparisons.
		 */
		'equal'         => array(
			'title'         => '==',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a == $b );',
		),
		'equal_strict'  => array(
			'title'         => '===',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a === $b );',
		),
		'not_equal'     => array(
			'title'         => '!=',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a != $b );',
		),
		'not_equal2'    => array(
			'title'         => '&lt;&gt;',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a <> $b );',
		),
		'not_equal_strict'  => array(
			'title'         => '!==',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a !== $b );',
		),
		'less_than'            => array(
			'title'         => '&lt;',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a < $b );',
		),
		'greater_than'            => array(
			'title'         => '&gt;',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a > $b );',
		),
		'less_than_or_equal'           => array(
			'title'         => '&lt;=',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a <= $b );',
		),
		'greater_than_or_equal'           => array(
			'title'         => '&gt;=',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_bool( $a >= $b );',
		),

		// Will be removed from $tests property from constructor if not on PHP 7+ to prevent parse errors.
		'spaceship'           => array(
			'title'         => '&lt;=&gt;',
			'url'           => 'http://php.net/language.operators.comparison',
			'arg'           => '$a, $b',
			'function'      => 'pr_int( $a <=> $b );',
			'notes'         => array(
				'<p>The Spaceship operator is only available in PHP 7.0.0+.</p>',
			),
		),


		/**
		 * String comparison functions.
		 *
		 * Note: all of these functions have a PHP5 equivalent in class.vartype-php5.php.
		 */
		'strcmp'        => array(
			'title'         => 'strcmp()',
			'url'           => 'http://php.net/strcmp',
			'arg'           => '$a, $b',
			'function'      => 'Vartype::compare_strings( $a, $b, "strcmp" );',
		),
		'strcasecmp'    => array(
			'title'         => 'strcasecmp()',
			'url'           => 'http://php.net/strcasecmp',
			'arg'           => '$a, $b',
			'function'      => 'Vartype::compare_strings( $a, $b, "strcasecmp" );',
		),
		'strnatcmp'     => array(
			'title'         => 'strnatcmp()',
			'url'           => 'http://php.net/strnatcmp',
			'arg'           => '$a, $b',
			'function'      => 'Vartype::compare_strings( $a, $b, "strnatcmp" );',
		),
		'strnatcasecmp' => array(
			'title'         => 'strnatcasecmp()',
			'url'           => 'http://php.net/strnatcasecmp',
			'arg'           => '$a, $b',
			'function'      => 'Vartype::compare_strings( $a, $b, "strnatcasecmp" );',
		),
		'strcoll'       => array(
			'title'         => 'strcoll()',
			'url'           => 'http://php.net/strcoll',
			'arg'           => '$a, $b',
			'function'      => 'Vartype::compare_strings( $a, $b, "strcoll" );',
		),
		'similar_text'  => array(
			'title'         => 'similar_text()',
			'url'           => 'http://php.net/similar_text',
			'arg'           => '$a, $b',
			'function'      => 'Vartype::compare_strings( $a, $b, "similar_text" );',
		),
		'levenshtein'   => array(
			'title'         => 'levenshtein()',
			'url'           => 'http://php.net/levenshtein',
			'arg'           => '$a, $b',
			'function'      => 'Vartype::compare_strings( $a, $b, "levenshtein" );',
		),


		/**
		 * Number comparison functions
		 */
		'bccomp'        => array(
			'title'         => 'bccomp()',
			'url'           => 'http://php.net/bccomp',
			'arg'           => '$a, $b',
			'function'      => 'if ( extension_loaded( \'bcmath\' ) ) { $r = bccomp( $a, $b ); if ( is_int( $r ) ) { pr_int( $r ); } else { pr_var( $r, \'\', true, true ); } } else { print \'E: bcmath extension not installed\'; }',
			'notes'         => array(
				'<p>Remember that the default <code>bcscale()</code> is 0 !</p>',
				'<p>For a reliable implementation of all the BCMath functions which avoids a number of the common pitfalls, see <a href="https://gist.github.com/jrfnl/8449978" target="_blank">this example function</a> (gist).</p>',
			),
		),
		'min'           => array(
			'title'         => 'min()',
			'url'           => 'http://php.net/min',
			'arg'           => '$a, $b',
			'function'      => 'pr_var( min( $a, $b ), \'\', true, true );',
			'notes'         => array(
				'<p><strong>Please note:</strong> <code>min() / max()</code> will evaluate a non-numeric string as 0 if compared to integer, but still return the string if it\'s seen as the numerically lowest/highest value.</p>',
				'<p><code>min()</code> If multiple arguments evaluate to 0, will return the lowest alphanumerical string value if any strings are given, else a numeric 0 is returned.</p>',
			),
		),

		'max'           => array(
			'title'         => 'max()',
			'url'           => 'http://php.net/max',
			'arg'           => '$a, $b',
			'function'      => 'pr_var( max( $a, $b ), \'\', true, true );',
			'notes'         => array(
				'<p><strong>Please note:</strong> <code>min() / max()</code> will evaluate a non-numeric string as 0 if compared to integer, but still return the string if it\'s seen as the numerically lowest/highest value.</p>',
				'<p><code>max()</code> returns the numerically highest of the parameter values. If multiple values can be considered of the same size, the one that is listed first will be returned.<br />
				 If <code>max()</code> is given multiple arrays, the longest array is returned. If all the arrays have the same length, <code>max()</code> will use lexicographic ordering to find the return value.</p>',
			),
		),
	);


	/**
	 * Constructor.
	 */
	function __construct() {
		// Remove spaceship comparison for PHP < 7
		if ( PHP_VERSION_ID < 70000 ) {
			unset( $this->tests['spaceship'] );
		}
		parent::__construct();
	}


	/**
	 * PHP4 Constructor.
	 */
	function VartypeCompare() {
		$this->__construct();
	}


	/**
	 * Get the tab title for the initial tab for use in the page header.
	 *
	 * @param string $tab
	 * @return string
	 */
	function get_tab_title( $tab ) {
		if ( isset( $this->tests[ $tab ]['title'] ) && is_string( $this->tests[ $tab ]['title'] ) && $this->tests[ $tab ]['title'] !== '' ) {
			return $this->tests[ $tab ]['title'];
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
		return array_keys( $this->tests );
	}


	/**
	 * Determine which tests to run.
	 *
	 * @param string|null $test_group
	 *
	 * @return string
	 */
	function get_test_group( $test_group = null ) {
		$key = key( $this->tests ); // Get first item in array.
		if ( isset( $test_group, $this->tests[ $test_group ] ) ) {
			$key = $test_group;
		}
		return $key;
	}


	/**
	 * Generate the subsection tabs (at the top of the page) for the cheatsheet.
	 *
	 * @param bool $all
	 */
	function print_tabs( $all = false ) {
		echo '
	<ul>';

		foreach ( $this->tests as $key => $test ) {
			$tooltip = '';
			if ( isset( $test['tooltip'] ) ) {
				$tooltip = ' title="' . $test['tooltip'] . '"';
			}

			$active_class = '';
			if ( $GLOBALS['tab'] === $key ) {
				$active_class = ' class="ui-tabs-active ui-state-active"';
			}

			if ( $all === true ) {
				echo '
		<li', $tooltip, '><a href="#', $key, '" data-tab="', $key, '" data-tab-title="', $test['title'], '"><strong>', $test['title'], '</strong></a></li>';
			}
			else {
				echo '
		<li', $active_class, $tooltip, '><a href="', BASE_URI, $GLOBALS['type'], '/', $key, '/ajax" data-tab="', $key, '" data-tab-title="', $test['title'], '"><strong>', $test['title'], '</strong></a></li>';
			}
		}
		unset( $key, $test, $tooltip );

		echo '
	</ul>';
	}


	/**
	 * Print all tables for the cheatsheet.
	 */
	function print_tables() {

		echo '
	<div class="tables">';


		$this->set_test_data();


		foreach ( $this->tests as $key => $test_settings ) {
			$GLOBALS['test'] = $key;
			$this->print_table( $key );
		}
		unset( $key, $test_settings );
		$this->clean_up();

		echo '
	</div>';
	}


	/**
	 * Generate the table for one specific subsection of a comparison cheatsheet.
	 *
	 * @param string $test The current subsection
	 */
	function print_table( $test ) {

		if ( isset( $this->tests[ $test ] ) ) {
			$GLOBALS['encountered_errors'] = array();

			echo '
		<div id="', $test, '">';


			$this->print_tabletop( $test );


			$last_key = null;

			foreach ( $this->test_data_keys as $key1 ) {
				$value1 = $this->test_data[ $key1 ];
				$legend = '';
				if ( isset( $this->test_legend[ $key1 ] ) ) {
					$legend = '<sup class="fright"><a href="#var-legend-' . $key1 . '">&dagger;' . $key1 . '</a></sup>';
				}

				$type = substr( $key1, 0, 1 );

				$class = array();
				if ( $type !== $last_key ) {
					$class[]  = 'new-var-type';
					$last_key = $type;
				}

				if ( count( $class ) > 0 ) {
					echo '
				<tr class="', implode( ' ', $class ), '">';
				}
				else {
					echo '
				<tr>';
				}

				echo '
					<th>', $legend;
				pr_var( $value1, '', true );
				echo '
					</th>';

				$this->print_compare_row_cells( $value1, $key1, $test );

				echo '
					<th>', $legend;
				pr_var( $value1, '', true );
				echo '
					</th>
				</tr>';

				unset( $value1, $label, $type, $hr_key, $class );
			}
			unset( $key1, $last_key );

			echo '
			</tbody>
			</table>';


			$this->print_error_footnotes( $test );
			$this->print_other_footnotes( $test );

			echo '
		</div>';
		}
		else {
			trigger_error( 'Unknown test <b>' . $test . '</b>', E_USER_WARNING );
		}

	}


	/**
	 * Generate the first row of the cheatsheet table.
	 *
	 * @param string $test The current subsection
	 *
	 * @return string
	 */
	function create_table_header( $test ) {
		$tooltip = '';
		if ( isset( $this->tests[ $test ]['tooltip'] ) && $this->tests[ $test ]['tooltip'] !== '' ) {
			$tooltip = ' title="' . $this->tests[ $test ]['tooltip'] . '"';
		}

		if ( isset( $this->tests[ $test ]['url'] ) && $this->tests[ $test ]['url'] !== '' ) {
			$group_label = '<a href="' . $this->tests[ $test ]['url'] . '" target="_blank"' . $tooltip . '><strong>' . $this->tests[ $test ]['title'] . '</strong></a>';
		}
		else {
			$group_label = '<a href="' . $this->tests[ $test ]['url'] . '" target="_blank"' . $tooltip . '><strong>' . $this->tests[ $test ]['title'] . '</strong></a>';
		}

		$notes = '';
		if ( isset( $this->tests[ $test ]['notes'] ) && ( is_array( $this->tests[ $test ]['notes'] ) && count( $this->tests[ $test ]['notes'] ) > 0 ) ) {
			foreach ( $this->tests[ $test ]['notes'] as $key => $note ) {
				$notes .= ' <sup><a href="#' . $test . '-note' . ( $key + 1 ) . '">&Dagger;' . ( $key + 1 ) . '</a></sup>';
			}
		}


		$html = '
				<tr>
					<th>' . $group_label . $notes . '</th>';


		// Top labels
		foreach ( $this->test_data_keys as $i => $key ) {
			$value = $this->test_data[ $key ];

			$class = '';
			if ( ! isset( $this->test_data_keys[ ( $i + 1 ) ] ) || substr( $key, 0, 1 ) !== substr( $this->test_data_keys[ ( $i + 1 ) ], 0, 1 ) ) {
				$class = ' class="end"';
			}

			$html .= '
					<th' . $class . '>';

			ob_start();
			pr_var( $value, '', false, true, '' );
			$label = ob_get_clean();

			// @todo: improve upon - preferably in a way that the tooltip is fully HTML capable
			// at the very least move to separate method (duplicate code).
			if ( strpos( $label, 'Object: ' ) !== false ) {
				$label = str_replace( '&nbsp;', ' ', $label );
				$label = str_replace( "\n", '', $label );
				$label = str_replace( 'null', "null\n", $label );
				$label = str_replace( '<br />', "\n", $label );
				$label = str_replace( '&lsquo;', "'", $label );
				$label = str_replace( '&rsquo;', "'", $label );
				$label = strip_tags( $label );
				$label = htmlspecialchars( $label, ENT_QUOTES, 'UTF-8' );

				$html .= '<span title="' . $label . '">Object(&hellip;)</span>';
			}
			else if ( strpos( $label, 'Array: ' ) !== false ) {
				$label = str_replace( '&nbsp;', ' ', $label );
				$label = str_replace( "\n", '', $label );
				$label = str_replace( '<br />', "\n", $label );
				$label = str_replace( '&lsquo;', "'", $label );
				$label = str_replace( '&rsquo;', "'", $label );

				$label = strip_tags( $label );
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


	/**
	 * Generate a cheatsheet result row.
	 *
	 * @param mixed  $value1 The value this row applies to
	 * @param string $key1   The array key reference to that value in the testdata array
	 * @param string $test   The current subsection
	 */
	function print_compare_row_cells( $value1, $key1, $test ) {

		foreach ( $this->test_data_keys as $i => $key2 ) {
			$GLOBALS['has_error'] = array();

			$value2 = $this->test_data[ $key2 ];

			$class = array( 'value1-' . $key1, 'value2-' . $key2 );
			if ( ! isset( $this->test_data_keys[ ( $i + 1 ) ] ) || substr( $key2, 0, 1 ) !== substr( $this->test_data_keys[ ( $i + 1 ) ], 0, 1 ) ) {
				$class[] = 'end';
			}

			if ( count( $class ) === 0 ) {
				echo '
					<td>';
			}
			else {
				echo '
					<td class="', implode( ' ', $class ), '">';
			}


			$this->tests[ $test ]['test']( $value1, $value2 );
			$this->print_row_cell_error_refs();

			echo '					</td>';

			unset( $GLOBALS['has_error'], $value2, $type, $class );
		}
		unset( $i, $key2 );
	}


	/**
	 * Generate footnotes for a test subsection if applicable.
	 *
	 * @param string $test The current subsection
	 */
	function print_other_footnotes( $test ) {
		if ( isset( $this->tests[ $test ]['notes'] ) && ( is_array( $this->tests[ $test ]['notes'] ) && count( $this->tests[ $test ]['notes'] ) > 0 ) ) {
			foreach ( $this->tests[ $test ]['notes'] as $key => $note ) {
				printf( '
			<div id="%1$s-note%2$s" class="note-appendix">
				<sup>&Dagger; %2$s</sup> %3$s
			</div>',
					$test,
					( $key + 1 ),
					$note
				);
			}
		}
	}
}
