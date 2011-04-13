<?php

	$message = Arr::get( $line, 'message', '' );
	
	if ( !empty( $message ) ) {
		$message = '(' . $message . ')';
	}

	echo '<span class="serv part">*** ' . $line['nick'] . ' has left ' . $channel . ' ' . HTML::chars( $message ) . '</span>';

?>