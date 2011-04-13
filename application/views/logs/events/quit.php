<?php

	$message = Arr::get( $line, 'message', '' );
	
	if ( !empty( $message ) ) {
		$message = '(' . $message . ')';
	}

	echo '<span class="serv quit">*** ' . $line['nick'] . ' has quit IRC ' . HTML::chars( $message ) . '</span>';

?>