<?php
/**
 * Sitemap Generator.
 *
 * @package PHPCheatsheets
 */

define( 'APP_DIR', dirname( dirname( __FILE__ ) ) );

/**
 * Generate static sitemap file for the phpcheatsheets.com website.
 */
class CheatsheetSitemap {

	/**
	 * Base url for the website.
	 */
	const BASE_URI = 'http://phpcheatsheets.com/';

	/**
	 * Directory where the static files can be found.
	 */
	const STATIC_DIR = 'static_results';

	/**
	 * Default change frequency.
	 */
	const CHANGE_FREQ = 'monthly';

	/**
	 * Entries to be added to the sitemap.
	 *
	 * @var array
	 */
	protected $entries = array();

	/**
	 * Formatted entries to be added to sitemap.xml.
	 *
	 * @var array
	 */
	protected $sitemap_entries = array();

	/**
	 * Formatted entries to be added to ror.xml.
	 *
	 * @var array
	 */
	protected $ror_sitemap_entries = array();

	/**
	 * Structure of the site to determine the pages to add to the sitemaps.
	 *
	 * @todo DRY out (duplicate info in index.php)
	 *
	 * @var array
	 */
	protected $page_locations = array(
		'compare'            => array(
			'title'  => 'PHP Variable Comparison Cheatsheet',
			'prio'   => 0.85,
			'class'  => 0.6,
			'static' => 0.4,
		),
		'arithmetic'         => array(
			'title'  => 'PHP Arithmetic Operations Cheatsheet',
			'prio'   => 0.85,
			'class'  => 0.6,
			'static' => 0.4,
		),
		'test'               => array(
			'title'  => 'PHP Variable Testing Cheatsheet',
			'prio'   => 0.85,
			'class'  => 0.6,
			'static' => 0.4,
		),
		'other-cheat-sheets' => array(
			'title'  => 'More PHP Cheatsheets',
			'prio'   => 0.5,
			'class'  => false,
			'static' => false,
		),
		'about'              => array(
			'title'  => 'About phpcheatsheets.com',
			'prio'   => 0.5,
			'class'  => false,
			'static' => false,
		),
	);


	/**
	 * Create the sitemaps.
	 */
	public function __construct() {
		$this->get_entries();
		if ( is_array( $this->entries ) && $this->entries !== array() ) {
			echo 'we have ' . count( $this->entries ) . ' entries' . PHP_EOL;
			$this->prepare_entries_for_sitemaps();
			$this->create_sitemap();
			$this->create_ror_sitemap();
		}
	}


	/**
	 * Retrieve the entries which should be added to the sitemaps.
	 */
	protected function get_entries() {
		$this->entries[] = array(
			'url'         => self::BASE_URI,
			'prio'        => 1,
			'sort_order'  => 1,
			'title'       => 'PHP Cheatsheets',
			'description' => 'Extended PHP Cheat sheets for variable comparisons and variable type testing.',
			'last_mod'    => null,
		);

		foreach ( $this->page_locations as $key => $info ) {
			$this->entries[] = array(
				'url'        => self::BASE_URI . $key . '/',
				'prio'       => $info['prio'],
				'sort_order' => 2,
				'title'      => $info['title'],
				'last_mod'   => null,
			);

			if ( $info['class'] !== false ) {
				$class = 'Vartype' . ucfirst( $key );
				$file  = 'class.vartype-' . $key . '.php';

				if ( file_exists( APP_DIR . '/' . $file ) ) {
					include_once APP_DIR . '/' . $file;
					$current_tests = new $class();
					$tabs          = $current_tests->get_tab_list();

					foreach ( $tabs as $tab ) {
						$title           = $current_tests->get_tab_title( $tab );
						$this->entries[] = array(
							'url'        => self::BASE_URI . $key . '/' . $tab . '/',
							'prio'       => $info['class'],
							'sort_order' => 3,
							'title'      => $info['title'] . ' :: ' . $title,
							'last_mod'   => null,
						);
					}
				}
			}

			if ( $info['static'] !== false ) {
				$available = glob( APP_DIR . '/' . self::STATIC_DIR . '/' . $key . '/php*.html' );
				usort( $available, 'version_compare' );

				$regex = sprintf( '`^%1$s/(%2$s/%3$s/php([457]\.[0-9]+\.[0-9-]+(?:(?:alpha|beta|rc)(?:[0-9])?)?)\.html)$`',
					preg_quote( APP_DIR, '`' ),
					preg_quote( self::STATIC_DIR, '`' ),
					preg_quote( $key, '`' )
				);

				foreach ( $available as $static_file ) {
					if ( preg_match( $regex, $static_file, $match ) ) {
						$title           = $current_tests->get_tab_title( $tab );
						$this->entries[] = array(
							'url'        => self::BASE_URI . $match[1],
							'prio'       => $info['static'],
							'sort_order' => 4,
							'title'      => $info['title'] . ' for PHP ' . $match[2],
							'last_mod'   => filemtime( $static_file ),
						);
					}
				}
			}
		}
	}


	/**
	 * Transform the entry information to xml formatted entry information.
	 */
	protected function prepare_entries_for_sitemaps() {
		$this->order_entries();

		foreach ( $this->entries as $entry ) {
			$this->add_sitemap_entry( $entry );
			$this->add_ror_sitemap_entry( $entry );
		}
	}


	/**
	 * Sort the sitemap entries.
	 */
	protected function order_entries() {
		// Obtain a list of columns.
		foreach ( $this->entries as $key => $info ) {
		    $sort_order[ $key ] = $info['sort_order'];
		    $prio[ $key ]       = $info['prio'];
		    $url[ $key ]        = $info['url'];
		}

		// Sort the data with volume descending, edition ascending.
		// Add $data as the last parameter, to sort by the common key.
		array_multisort(
			$sort_order, SORT_ASC,
			$prio, SORT_DESC,
			$url, SORT_ASC, SORT_NATURAL,
			$this->entries
		);
	}


	/**
	 * Save a sitemap file to disk.
	 *
	 * @param string $content
	 * @param string $filename
	 */
	protected function save_file( $content, $filename ) {
		$msg = '';

		if ( $content !== false && is_string( $content ) && $content !== '' ) {

			if ( file_put_contents( APP_DIR . '/' . $filename, $content ) !== false ) {
				$msg = 'SUCCESS - created file : ' . $filename;
			}
			else {
				$msg = 'FAILED to WRITE file : ' . $filename;
			}
		}
		else {
			$msg = 'FAILED to GENERATE file : ' . $filename;
		}

		if ( ! isset( $GLOBALS['verbose'] ) || $GLOBALS['verbose'] > 0 ) {
			echo $msg, PHP_EOL;
		}
	}


	/**
	 * Save a gz compressed sitemap file to disk.
	 *
	 * @param string $content
	 * @param string $filename
	 */
	protected function save_compressed_file( $content, $filename ) {
		$msg = '';

		$gz = gzopen( APP_DIR . '/' . $filename, 'w9' );
		if ( gzwrite( $gz, $content ) > 0 ) {
			$msg = 'SUCCESS - created file : ' . $filename;
		}
		else {
			$msg = 'FAILED to GENERATE file : ' . $filename;
		}
		gzclose( $gz );

		if ( ! isset( $GLOBALS['verbose'] ) || $GLOBALS['verbose'] > 0 ) {
			echo $msg, PHP_EOL;
		}
	}


	/**
	 * Create the sitemap.xml file.
	 */
	protected function create_sitemap() {
		$sitemap = sprintf( '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="%1$spage/xml-sitemap.xsl"?>
<urlset
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
%2$s
</urlset>',
			self::BASE_URI,
			implode( '', $this->sitemap_entries )
		);
		$this->save_file( $sitemap, 'sitemap.xml' );
		$this->save_compressed_file( $sitemap, 'sitemap.xml.gz' );
	}


	/**
	 * Create the ror.xml file.
	 */
	protected function create_ror_sitemap() {
		$sitemap = sprintf( '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:ror="http://rorweb.com/0.1/">
	<channel>
		<title>ROR Sitemap for %1$s</title>
		<link>%1$s</link>
%2$s
	</channel>
</rss>',
			self::BASE_URI,
			implode( '', $this->ror_sitemap_entries )
		);
		$this->save_file( $sitemap, 'ror.xml' );
	}


	/**
	 * Format a sitemap entry for use in a sitemap.xml file.
	 *
	 * @param array $entry
	 */
	protected function add_sitemap_entry( $entry ) {
		$last_mod = ( isset( $entry['last_mod'] ) ? $entry['last_mod'] : time() );

		$this->sitemap_entries[] = sprintf( '
	<url>
		<loc>%1$s</loc>
		<lastmod>%2$s</lastmod>
		<changefreq>%3$s</changefreq>
		<priority>%4$s</priority>
	</url>',
			$entry['url'],
			date( 'c', $last_mod ),
			self::CHANGE_FREQ,
			$entry['prio']
		);
	}


	/**
	 * Format a sitemap entry for use in a ror.xml file.
	 *
	 * @param array $entry
	 */
	protected function add_ror_sitemap_entry( $entry ) {
		$description = '';
		if ( isset( $entry['description'] ) && is_string( $entry['description'] ) && $entry['description'] !== '' ) {
			$description = '
			<description>' . $entry['description'] . '</description>';
		}

		$this->ror_sitemap_entries[] = sprintf( '
		<item>
			<link>%1$s</link>
			<title>%2$s</title>%3$s
			<ror:updatePeriod>%4$s</ror:updatePeriod>
			<ror:sortOrder>%5$s</ror:sortOrder>
			<ror:resourceOf>sitemap</ror:resourceOf>
		</item>',
			$entry['url'],
			$entry['title'],
			$description,
			self::CHANGE_FREQ,
			$entry['sort_order']
		);
	}
}

new CheatsheetSitemap;
