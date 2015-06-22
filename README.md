PHP-cheat-sheet-extended
========================
[![GitHub license](https://img.shields.io/badge/license-GPLv3-blue.svg)](https://raw.githubusercontent.com/jrfnl/PHP-cheat-sheet-extended/master/LICENSE.md)
[![Build Status](https://travis-ci.org/jrfnl/PHP-cheat-sheet-extended.svg?branch=master)](https://travis-ci.org/jrfnl/PHP-cheat-sheet-extended)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jrfnl/PHP-cheat-sheet-extended/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jrfnl/PHP-cheat-sheet-extended/?branch=master)


### View these cheat sheets live at [PHPCheatsheets.com](http://phpcheatsheets.com/)


#### Much extended version of the [Blueshoes PHP cheat sheet](http://www.blueshoes.org/en/developer/php_cheat_sheet/) for variable type juggling.


##### Features:
* Lots of extra variables being tested.
* Lots of extra comparisons and tests.
* Variable arithmetic.
* Results available for a wide variety of PHP versions.


##### Contributing:
Suggestions for additional test variables, additional comparisons, tests or other improvements are very welcome. Just [open an issue](https://github.com/jrfnl/PHP-cheat-sheet-extended/issues) or send in a [pull request](https://github.com/jrfnl/PHP-cheat-sheet-extended/pulls) for it.


##### About the static versions of the sheets:

Static versions of the cheatsheets are generated using a variety of PHP versions.

These PHP versions will include:
* [Always] Latest release for each minor PHP version at the time of (re-)generation of the static sheets.
* [Always] The PHP versions included in [Ubuntu LTS releases](http://distrowatch.com/table.php?distribution=Ubuntu).
* [Selectively] Popular minor releases based on [worldwide usage statistics](http://w3techs.com/technologies/details/pl-php/all/all) at the time of (re-)generation of the static sheets.
* [Selectively] Previously included versions if no other close minor release will be included.

In general, a balance is sought between significance and variety.


#### Credits:
[Elephpant photo](http://www.flickr.com/photos/jakobwesthoff/3231273333/) by Jacob Westhoff.
[Sad Elephpant photo](http://www.flickr.com/photos/gluek/100179589/) by Gluek.


#### Changelog:

##### 1.3 (Jun 2015): Get ready for PHP 7!
* New tests:
	- `<=>` in variable comparisons (PHP7+ only).
	- `$x ?? ...` in variable tests (PHP7+ only).
	- `intdiv()` in variable arithmetics (PHP7+ only).
	- `preg_match()` with unicode property codes in variable string tests (PHP5.1+).
* Added two new variables specifically for the unicode property tests.
* Renewed static sheets based on currently available and most used versions:
	- Added static sheets for **PHP 7.0.0-alpha1**, 5.6.10, 5.6.8, 5.6.0, 5.5.26, 5.5.24, 5.5.22, 5.4.42, 5.4.39, 5.4.36.
	- Removed static sheet generation for PHP 5.6.4, 5.5.21, 5.5.20, 5.5.18, 5.4.37, 5.4.35 and 4.3.9.
* Updated CastToType submodule to v2.0 which brings object casting via that class for all PHP versions in line with PHP7 and fixes a bug in object casting for PHP <= 5.1.

Also:
* Fixed a hiccup where the "Filter" tab would be shown in PHP 5.1, while the filter extension is only available in PHP 5.2+.
* Fixed a bug on the "test" cheatsheet where the row variable header would not display properly in the right hand column on low PHP versions.
* Improved grouping of PHP error messages.
* Added some more user facing information about the tests run and version quirks.
* Fixed js error in sitemap stylesheet.
* Fixed a faulty redirect in .htaccess.
* Minor UI improvements.
* Tidying up.


##### 1.2.0.1 (Feb 2015)
* Added sitemaps.


##### 1.2 (Feb 2015)
* New tests:
	- `pow()` in variable arithmetic.
	- `**` (PHP 5.6+) in variable arithmetic.
	- `.` (concatenation) in variable arithmetic - for want of better place.
* Added two new float variables.
* Lots of usability improvements:
	- Select PHP version via dropdown.
	- PHP version persists across sheets.
	- Variable legend now auto-expand when user clicks on variable 'footnote' link.
	- 'Pretty' (semantic) urls.
	- Better window titles.
	- Better error handling (404).
* Static sheets now available in lots more versions (30!), including PHP 5.5, 5.6 which weren't available until now. Retired some older versions which have close versions available anyhow.
* Fixed:
	- Variable legend for binary integer was missing.

Also:
* Added donate to charity button.
* Change over to absolute rather than relative urls.
* Minor html and css fixes.
* Script to autogen (nearly) all static sheets.
* Updated cast-to-type submodule.
* Upgraded jQuery and jQuery UI to 1.11.2.
* General tidying up.


##### 1.1 (Feb 2014) - move to own domain.
* New tests:
	- `abs()` in variable testing.
* New pages:
	- 'other cheatsheets'.
	- 'about'.
* New site styling for own domain.

Also:
* Added twitter & LinkedIn share buttons.
* Upgraded jQuery to 1.11.0 and jQuery UI to v 1.10.4.
* Cleaned up HTML.


##### 1.0 (Sep 2013) - first public version.