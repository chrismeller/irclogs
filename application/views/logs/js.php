<?php

	$keys = array( 'channel', 'year', 'month', 'day' );
	
	$js = array();
	foreach ( $keys as $key ) {
		if ( isset( $$key ) ) {
			$js[] = "Logs.$key: '{$$key}'";
		}
		else {
			$js[] = "Logs.$key: ''";
		}
	}
	
	$js = implode( ",\n", $js );
	
	echo '<script type="text/javascript">' . $js . '</script>';

?>