<?php

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
		'base_url'   => '/irclogs/',
		'index_file' => '',
		'caching' => true,
		'profile' => false,
	));
	
?>
