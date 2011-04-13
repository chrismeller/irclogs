<?php

	// $message is the nick that was kicked - we don't have the actual kick message
	$message = Arr::get( $line, 'message', '' );

	echo '<span class="serv kick">*** ' . $message . ' has been kicked from ' . $channel . ' by ' . $line['nick'] . '</span>';

?>