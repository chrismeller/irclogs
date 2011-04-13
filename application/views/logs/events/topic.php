<?php

	$message = Arr::get( $line, 'message', '' );

	echo '<span class="serv topic">*** ' . $line['nick'] . ' has changed the topic to: <strong>' . HTML::chars( $message ) . '</strong></span>';

?>