<?php

	$keys = array( 'channel', 'year', 'month', 'day', 'next_token' );
	
	// urlencode the next token so it doesn't break the javascript
	$next_token = urlencode( $next_token );
	
	// strip the leading character from the channel
	$channel = SDBLogs::trim_chan( $channel );
	
	$js = array();
	foreach ( $keys as $key ) {
		if ( isset( $$key ) ) {
			$js[] = "Logs.$key = '{$$key}';";
		}
		else {
			$js[] = "Logs.$key = '';";
		}
	}
	
	$js[] = 'Logs.next_token = unescape( Logs.next_token );';
	
	$js = implode( "\n", $js );
	
	echo '<script type="text/javascript">' . $js . '</script>';

?>