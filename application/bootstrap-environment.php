<?php

	if ( ( isset( $_SERVER['SERVER_NAME'] ) && $_SERVER['SERVER_NAME'] == 'localhost' ) || Kohana::$is_cli ) {
		Kohana::$environment = Kohana::DEVELOPMENT;
	}
	else {
		Kohana::$environment = Kohana::PRODUCTION;
	}

?>