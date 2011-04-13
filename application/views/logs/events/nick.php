<?php

	$message = Arr::get( $line, 'message', '' );

	echo '<span class="serv nick">*** ' . $line['nick'] . ' is now know as ' . HTML::chars( $message ) . '</span>';

?>