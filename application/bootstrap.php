<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('UTC');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

require( APPPATH . 'bootstrap-environment.php');

if ( file_exists( APPPATH . 'bootstrap-' . Kohana::$environment . '.php' ) ) {
	require( APPPATH . 'bootstrap-' . Kohana::$environment . '.php' );
}
else {
	
	/**
	 * Initialize Kohana, setting the default options.
	 *
	 * The following options are available:
	 *
	 * - string   base_url    path, and optionally domain, of your application   NULL
	 * - string   index_file  name of your index file, usually "index.php"       index.php
	 * - string   charset     internal character set used for input and output   utf-8
	 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
	 * - boolean  errors      enable or disable error handling                   TRUE
	 * - boolean  profile     enable or disable internal profiling               TRUE
	 * - boolean  caching     enable or disable internal caching                 FALSE
	 */
	Kohana::init(array(
		'base_url'   => '/',
		'index_file' => '',
		'caching' => Kohana::$environment == Kohana::PRODUCTION,
		'profiling' => Kohana::$environment != Kohana::PRODUCTION,
	));
	
}

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'cache'			=> MODPATH . 'cache',
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	// 'database'   => MODPATH.'database',   // Database access
	// 'image'      => MODPATH.'image',      // Image manipulation
	// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'oauth'      => MODPATH.'oauth',      // OAuth authentication
	// 'pagination' => MODPATH.'pagination', // Paging of results
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
	
// define routes only if they aren't cached
if ( Route::cache() == false ) {
	
	Route::set( 'logs-channel', '<channel>' )
		->defaults( array(
			'controller' => 'logs',
			'action' => 'channel',
		)
	);
	
	Route::set( 'logs-year', '<channel>/<year>' )
		->defaults( array(
			'controller' => 'logs',
			'action' => 'year',
		)
	);
	
	Route::set( 'logs-month', '<channel>/<year>/<month>' )
		->defaults( array(
			'controller' => 'logs',
			'action' => 'month',
		)
	);
	
	Route::set( 'logs-day', '<channel>/<year>/<month>/<day>' )
		->defaults( array(
			'controller' => 'logs',
			'action' => 'day',
		)
	);
	
	Route::set('default', '(<controller>(/<action>(/<id>)))')
		->defaults(array(
			'controller' => 'logs',
			'action'     => 'index',
		));
		
	// cache the saved routes - but only in production
	if ( Kohana::$environment == Kohana::PRODUCTION ) {
		Route::cache(true);
	}
		
}