<?php

	Route::set( 'sdblogs-channel', 'sdblogs/<channel>', array( 'channel' => '.*' ) )
		->defaults( array(
			'controller' => 'sdblogs',
			'action' => 'channel',
		)
	);
	
	Route::set( 'sdblogs-year', 'sdblogs/<channel>/<year>' )
		->defaults( array(
			'controller' => 'sdblogs',
			'action' => 'year',
		)
	);
	
	Route::set( 'sdblogs-month', 'sdblogs/<channel>/<year>/<month>' )
		->defaults( array(
			'controller' => 'sdblogs',
			'action' => 'month',
		)
	);
	
	Route::set( 'sdblogs-day', 'sdblogs/<channel>/<year>/<month>/<day>' )
		->defaults( array(
			'controller' => 'sdblogs',
			'action' => 'day',
		)
	);

?>