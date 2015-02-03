PHP-cheat-sheet-extended
========================
[![Build Status](https://travis-ci.org/jrfnl/PHP-cheat-sheet-extended.svg?branch=master)](https://travis-ci.org/jrfnl/PHP-cheat-sheet-extended)

### View these cheat sheets live at [PHPCheatsheets.com](http://phpcheatsheets.com/)

Much extended version of the [Blueshoes PHP cheat sheet](http://www.blueshoes.org/en/developer/php_cheat_sheet/) for variable type juggling.


##### Features:
* Lots of extra variables being tested
* Lots of extra comparisons and tests
* Variable arithmetic
* Results available based on various PHP versions


##### Contributing:
Suggestions for additional test variables, additional comparisons, tests or other improvements are very welcome. Just open an issue or send in a pull request for it.


##### About the static versions of the sheets

Static versions of the cheatsheets are generated using a variety of PHP versions.

These PHP versions will include:
* [Always] Latest release for each minor PHP version at the time of (re-)generation of the static sheets
* [Always] The PHP versions included in [Ubuntu LTS releases](http://distrowatch.com/table.php?distribution=Ubuntu)
* [Selectively] Popular minor releases based on [worldwide usage statistics](http://w3techs.com/technologies/details/pl-php/all/all) at the time of (re-)generation of the static sheets
* [Selectively] Previously included versions if no other close minor release will be included

In general, a balance is sought between significance and variety.


#### Credits:
[Elephpant photo](http://www.flickr.com/photos/jakobwesthoff/3231273333/) by Jacob Westhoff
[Sad Elephpant photo](http://www.flickr.com/photos/gluek/100179589/) by Gluek


#### Changelog:

##### 1.2 (Feb 2015)
* New tests:
	- `pow()` in variable arithmetic
	- `**` (PHP 5.6+) in variable arithmetic
	- `.` (concatenation) in variable arithmetic - for want of better place
* Added two new float variables
* Lots of usability improvements:
	- Select PHP version via dropdown
	- PHP version persists across sheets
	- Variable legend now auto-expand when user clicks on variable 'footnote' link
	- 'Pretty' (semantic) urls
	- Better window titles
	- Better error handling (404)
* Static sheets now available in lots more versions (30!), including PHP 5.5, 5.6 which weren't available until now. Retired some older versions which have close versions available anyhow.
* Fixed:
	- Variable legend for binary integer was missing

Also:
* Added donate to charity button
* Change over to absolute rather than relative urls
* Minor html and css fixes
* Script to autogen (nearly) all static sheets
* Updated cast-to-type submodule
* Upgraded jQuery and jQuery UI to 1.11.2
* General tidying up


##### 1.1 (Feb 2014) - move to own domain
* New tests:
	- `abs()` in variable testing
* New pages:
	- 'other cheatsheets'
	- 'about'
* New site styling for own domain

Also:
* Added twitter & LinkedIn share buttons
* Upgraded jQuery to 1.11.0 and jQuery UI to v 1.10.4
* Cleaned up HTML


##### 1.0 (Sep 2013) - first public version